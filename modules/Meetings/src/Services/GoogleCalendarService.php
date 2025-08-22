<?php

namespace Modules\Meetings\Services;

use Google_Client;
use Google\Service;
use GuzzleHttp\Client;
use Google_Service_Calendar;
use Illuminate\Support\Carbon;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Auth;
use App\Models\GoogleOAuthCredential;
use Google_Service_Calendar_EventDateTime;

class GoogleCalendarService
{
    protected $client;
    protected $calendarService;
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user ?: auth('admin')->user();
        $this->client = $this->getClient();
        $this->calendarService = new Google_Service_Calendar($this->client);
    }

    protected function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName(config('general.google.app_name'));
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig([
            'client_id' => fn_get_setting('general.google.client_id'),
            'client_secret' => fn_get_setting('general.google.client_secret'),
            'redirect_uris' => [fn_get_setting('general.settings.google.redirect')],
        ]);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Get and validate token values        
        
        if (!empty(auth('admin')->user()->google_access_token) && !empty(auth('admin')->user()->google_refresh_token)) {
            $accessToken    = auth('admin')->user()->google_access_token;
            $refreshToken   = auth('admin')->user()->google_refresh_token;
            $expiresIn      = (int)auth('admin')->user()->google_expires_in;
            $tokenType      = auth('admin')->user()->google_token_type;
            $timestamp      = $this->parseTokenTimestamp(auth('admin')->user()->google_token_created_at);
            $client->setAccessToken([
                'access_token'  => $accessToken,
                'refresh_token' => $refreshToken,
                'expires_in'    => $expiresIn,
                'token_type'    => $tokenType,
                'created'       => $timestamp,
            ]);
        }

        if ($client->isAccessTokenExpired()) {
            if (!empty(auth('admin')->user()->google_refresh_token)) {
                $newToken = $client->fetchAccessTokenWithRefreshToken(auth('admin')->user()->google_refresh_token);
                $this->storeCredentials($newToken);
                $client->setAccessToken($newToken);
            }
        }


        return $client;
    }

    protected function storeCredentials($token)
    {
        $admin = Auth::guard('admin')->user();
        $admin->setGoogleToken([
            'access_token'  => $token['access_token'],
            'refresh_token' => $token['refresh_token'],
            'expires_in'    => $token['expires_in'],
            'token_type'    => $token['token_type'],
            'timestamp'     => now()->addSeconds($token['expires_in'])
        ]);
    }

    protected function parseTokenTimestamp($timestamp)
    {
        if (is_numeric($timestamp)) {
            return (int)$timestamp;
        }

        if ($timestamp instanceof \DateTimeInterface) {
            return $timestamp->getTimestamp();
        }

        if (is_string($timestamp) && strtotime($timestamp) !== false) {
            return strtotime($timestamp);
        }

        return time(); // Fallback to current time
    }


    public function createEvent($meeting)
    {
        $event = new Google_Service_Calendar_Event([
            'summary' => $meeting->title,
            'description' => $meeting->description,
            'location' => $meeting->location,
            'start' => new Google_Service_Calendar_EventDateTime([
                'dateTime' => Carbon::parse($meeting->start_time)->toRfc3339String(),
                'timeZone' => fn_get_setting('general.timezone'),
            ]),
            'end' => new Google_Service_Calendar_EventDateTime([
                'dateTime' => Carbon::parse($meeting->end_time)->toRfc3339String(),
                'timeZone' => fn_get_setting('general.timezone'),
            ]),
        ]);

        $calendarId = 'primary';
        $event = $this->calendarService->events->insert($calendarId, $event);

        return $event;
    }

    public function getEvents($calendarId = 'primary', array $params = [])
    {
        try {
            $defaultParams = [
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => now()->startOfMonth()->toRfc3339String(),
                'timeMax' => now()->endOfMonth()->toRfc3339String(),
            ];

            $params = array_merge($defaultParams, $params);
            $events = $this->calendarService->events->listEvents($calendarId, $params);

            $formattedEvents = [];
            if (!empty($events)) {
                foreach ($events->getItems() as $event) {
                    $formattedEvents[] = $this->formatEvent($event);
                }
            }

            return $formattedEvents;
        } catch (\Exception $e) {
            \Log::error('Google Calendar error: ' . $e->getMessage());
            return [];
        }
    }

    protected function formatEvent($event)
    {
        $start = $event->getStart()->getDateTime() ?: $event->getStart()->getDate();
        $end = $event->getEnd()->getDateTime() ?: $event->getEnd()->getDate();

        return [
            'id' => $event->getId(),
            'title' => $event->getSummary(),
            'description' => $event->getDescription(),
            'location' => $event->getLocation(),
            'start' => $start,
            'end' => $end,
            'timezone' => $event->getStart()->getTimeZone(),
            'status' => $event->getStatus(),
            'htmlLink' => $event->getHtmlLink(),
            'organizer' => $event->getOrganizer(),
            'attendees' => $event->getAttendees(),
            'google_event_id' => $event->getId(),
            'google_calendar_id' => 'primary',
        ];
    }


    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function handleCallback($code)
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);
        $this->storeCredentials($token);
        return $token;
    }
}
