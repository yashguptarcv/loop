<?php

namespace Modules\Meetings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Modules\Meetings\Models\Meeting;
use Illuminate\Support\Facades\Validator;
use Modules\Meetings\DataView\MeetingsList;
use Modules\Meetings\Http\Requests\MeetingRequest;
use Modules\Meetings\Services\GoogleCalendarService;
use Modules\Meetings\Services\MeetingService;

class MeetingsController extends Controller
{
    protected MeetingService $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

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

    public function store(MeetingRequest $request)
    {

        $validated = $request->validated();
        try {
            $this->meetingService->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Meeting created successfully!',
                'redirect_url' => route('admin.meetings.index')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Unable to create meeting on Google Calendar: ' . $e->getMessage(),
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

    public function update(MeetingRequest $request, Meeting $meeting)
    {
        $validated = $request->validated();

        try {

            $this->meetingService->update($meeting, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Meeting updated successfully!',
                'redirect_url' => route('admin.meetings.index')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Unable to update meeting on Google Calendar: ' . $e->getMessage(),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Unable to update meeting on Google Calendar: ' . $e->getMessage(),
            ]);
        }
    }

    public function destroy(Meeting $meeting)
    {
        try {

            $this->meetingService->delete($meeting);

            return response()->json([
                'success' => true,
                'message' => 'Meeting deleted successfully!',
                'redirect_url' => route('admin.meetings.index')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Unable to delete meeting on Google Calendar: ' . $e->getMessage(),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Unable to delete meeting on Google Calendar: ' . $e->getMessage(),
            ]);
        }
    }

    public function syncWithGoogle()
    {
        try {

            $this->meetingService->syncFromGoogle();

            return redirect()->back()
                ->with('success', 'Meetings synced with Google Calendar');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', 'Failed to sync with Google Calendar: ' . $e->getMessage());
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Failed to sync with Google Calendar: ' . $e->getMessage());
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()
                ->with('error', 'Failed to sync with Google Calendar: ' . $e->getMessage());
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
