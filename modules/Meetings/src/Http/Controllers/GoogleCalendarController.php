<?php

namespace Modules\Meetings\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Meetings\Models\Meeting;
use Modules\Meetings\Services\GoogleCalendarService;

class GoogleCalendarController extends Controller
{
    public function oauth(GoogleCalendarService $calendarService)
    {
        return redirect($calendarService->getAuthUrl());
    }

    public function callback(Request $request, GoogleCalendarService $calendarService)
    {
        try {
            $calendarService->handleCallback($request->code);
            return redirect()->route('admin.meetings.index')
                ->with('success', 'Successfully connected to Google Calendar');
        } catch (\Exception $e) {
            return redirect()->route('admin.meetings.index')
                ->with('error', 'Failed to connect to Google Calendar: ' . $e->getMessage());
        }
    }
}
