<?php

namespace Modules\Meetings\Services;

use Exception;
use Carbon\Carbon;
use Modules\Meetings\Models\Meeting;

class MeetingService
{
    protected GoogleCalendarService $calendarService;

    public function __construct(GoogleCalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * Create new meeting and sync with Google Calendar
     */
    public function create(array $data): Meeting
    {
        $startTime = Carbon::parse($data['start_time']);
        
        $endTime = $startTime->copy()->addMinutes(
            $data['end_time'] ?? (int)fn_get_setting('general.google.meeting_gap')
        );

        $meeting = Meeting::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'start_time'  => $startTime,
            'end_time'    => $endTime,
            'location'    => $data['location'] ?? null,
            'color'       => $data['color'] ?? fn_get_setting('general.google.meeting_color'),
            'admin_id'    => auth('admin')->id(),
        ]);

        // Sync with Google if available
        if ($this->hasGoogleAuth()) {
            $event = $this->calendarService->createEvent($meeting);
            $meeting->update([
                'google_event_id'    => $event->id,
                'google_calendar_id' => 'primary',
            ]);
        }

        return $meeting;
    }

    /**
     * Update existing meeting
     */
    public function update(Meeting $meeting, array $data): Meeting
    {
        $startTime = Carbon::parse($data['start_time']);
        $endTime = $startTime->copy()->addMinutes(
            $data['end_time'] ?? (int)fn_get_setting('general.google.meeting_gap')
        );

        $meeting->update([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'start_time'  => $startTime,
            'end_time'    => $endTime,
            'location'    => $data['location'] ?? null,
            'color'       => $data['color'] ?? fn_get_setting('general.google.meeting_color'),
        ]);

        if ($meeting->google_event_id) {
            $this->calendarService->updateEvent($meeting);
        }

        return $meeting;
    }

    /**
     * Delete meeting
     */
    public function delete(Meeting $meeting): bool
    {
        if ($meeting->google_event_id) {
            $this->calendarService->deleteEvent($meeting);
        }

        return $meeting->delete();
    }

    /**
     * Sync Google Calendar events into DB
     */
    public function syncFromGoogle(): int
    {
        $events = $this->calendarService->getEvents('primary', [
            'timeMin' => now()->startOfMonth()->toRfc3339String(),
            'timeMax' => now()->endOfMonth()->toRfc3339String(),
        ]);

        $count = 0;
        foreach ($events as $event) {
            Meeting::updateOrCreate(
                ['google_event_id' => $event->getId()],
                [
                    'title'             => $event->getSummary(),
                    'description'       => $event->getDescription(),
                    'start_time'        => $event->getStart()->getDateTime(),
                    'end_time'          => $event->getEnd()->getDateTime(),
                    'location'          => $event->getLocation(),
                    'google_calendar_id' => 'primary',
                    'admin_id'          => auth('admin')->id(),
                ]
            );
            $count++;
        }

        return $count;
    }

    /**
     * Just a placeholder — check if Google auth exists
     */
    protected function hasGoogleAuth(): bool
    {
        if (!empty(auth('admin')->user()->google_access_token) && !empty(auth('admin')->user()->google_refresh_token)) {
            return true;
        }

        return false;
    }
}
