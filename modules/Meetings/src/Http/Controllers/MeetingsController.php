<?php

namespace Modules\Meetings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Modules\Meetings\Models\Meeting;
use Illuminate\Support\Facades\Validator;
use Modules\Meetings\DataView\MeetingsList;
use Modules\Meetings\Services\GoogleCalendarService;

class MeetingsController extends Controller
{
    public function index()
    {
        return view('meetings::index', [
            'hasGoogleAuth' => true
        ]);
    }

    public function getCalendarData(Request $request)
    {
        try {
            // Validate input parameters
            $validated = Validator::make($request->all(), [
                'month' => 'sometimes|integer',
                'year' => 'sometimes|integer|min:2024'
            ]);

            $month = $request['month'] ?? now()->month;
            $year = $request['year'] ?? now()->year;

            // Create date objects for the requested month
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            if ($validated->fails()) {
                return response()->json([
                    'success' => true,
                    'meetings_calendar' => '<p class="py-3 px-2 text-center">Oops! unable to fetch events</p>',
                    'monthDisplay' => $startDate->format('M, Y')
                ]);
            }

            // Fetch meetings for the current admin within the date range
            if (fn_get_setting('general.lead.user_group') == auth('admin')->id()) {
                $meetings = Meeting::query()
                    ->whereBetween('start_time', [$startDate, $endDate])
                    ->orderBy('start_time')
                    ->get()
                    ->groupBy(function ($meeting) {
                        return Carbon::parse($meeting->start_time)->format('j'); // Group by day of month
                    });
            } else {
                $meetings = Meeting::query()
                    ->where('admin_id', auth('admin')->id())
                    ->whereBetween('start_time', [$startDate, $endDate])
                    ->orderBy('start_time')
                    ->get()
                    ->groupBy(function ($meeting) {
                        return Carbon::parse($meeting->start_time)->format('j'); // Group by day of month
                    });
            }

            // Generate calendar HTML
            $html = view('meetings::components.meetings', [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'meetings' => $meetings
            ])->render();

            return response()->json([
                'success' => true,
                'meetings_calendar' => $html,
                'monthDisplay' => $startDate->format('M, Y')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load calendar data',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function list(Request $request)
    {
        $lists = fn_datagrid(MeetingsList::class)->process();
        return view('meetings::list', compact('lists'));
    }

    public function show(Meeting $meeting)
    {
        return view('meetings::show', compact('meeting'));
    }

    public function store(Request $request, GoogleCalendarService $calendarService)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'location' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        try {
            $startTime = Carbon::parse($request->start_time);
            $endTime = $startTime->copy()->addMinute($request->end_time ?? fn_get_setting('general.google.meeting_gap'));

            $meeting = Meeting::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location' => $request->location,
                'color' => $request->color ?? fn_get_setting('general.google.meeting_color'),
                'admin_id' => auth('admin')->id(),
            ]);

            // Only sync if user has Google auth        
            $event = $calendarService->createEvent($meeting);
            $meeting->update([
                'google_event_id' => $event->id,
                'google_calendar_id' => 'primary',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Meeting created successfully!',
                'redirect_url' => route('admin.meetings.index')
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Unable to create meeting on Google Calendar: ' . $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, Meeting $meeting, GoogleCalendarService $calendarService)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'location' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        try {
            $startTime = Carbon::parse($request->start_time);
            $endTime = $startTime->copy()->addMinute($request->end_time ?? fn_get_setting('general.google.meeting_gap'));

            $meeting->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location' => $request->location,
                'color' => $request->color ?? fn_get_setting('general.google.meeting_color'),
            ]);

            // Update Google Calendar event if exists
            if ($meeting->google_event_id) {
                $calendarService->updateEvent($meeting);
            }

            return response()->json([
                'success' => true,
                'message' => 'Meeting updated successfully!',
                'redirect_url' => route('admin.meetings.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Unable to update meeting: ' . $e->getMessage(),
            ]);
        }
    }

    public function destroy(Meeting $meeting, GoogleCalendarService $calendarService)
    {
        try {
            // Delete from Google Calendar if exists
            if ($meeting->google_event_id) {
                $calendarService->deleteEvent($meeting);
            }

            $meeting->delete();

            return response()->json([
                'success' => true,
                'message' => 'Meeting deleted successfully!',
                'redirect_url' => route('admin.meetings.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Unable to delete meeting: ' . $e->getMessage(),
            ]);
        }
    }

    public function syncWithGoogle(GoogleCalendarService $calendarService)
    {
        try {
            $events = $calendarService->getEvents('primary', [
                'timeMin' => now()->startOfMonth()->toRfc3339String(),
                'timeMax' => now()->endOfMonth()->toRfc3339String(),
            ]);

            if (!empty($events)) {
                foreach ($events as $event) {
                    Meeting::updateOrCreate(
                        ['google_event_id' => $event['getId']],
                        [
                            'title' => $event['getSummary'],
                            'description' => $event['getDescription'],
                            'start_time' => $event['getStart']['getDateTime'],
                            'end_time' => $event['getEnd']['getDateTime'],
                            'location' => $event['getLocation'],
                            'google_calendar_id' => 'primary',
                            'admin_id' => auth('admin')->id(),
                        ]
                    );
                }

                return redirect()->back()
                    ->with('success', 'Meetings synced with Google Calendar');
            }

            return redirect()->back()
                ->with('info', 'No Meetings synced with Google Calendar');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to sync with Google Calendar: ' . $e->getMessage());
        }
    }

    public function share_calendar()
    {
        return view('meetings::components.share_calendar');
    }

    public function new_meeting()
    {
        return view('meetings::components.new_meeting');
    }

    public function edit(Meeting $meeting)
    {
        return view('meetings::edit', compact('meeting'));
    }
}
