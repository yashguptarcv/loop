<?php

namespace Modules\Notifications\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Notifications\Models\NotificationEvent;
use Modules\Notifications\Models\NotificationChannel;
use Modules\Notifications\Models\NotificationMapping;
use Nette\Iterators\Mapper;

class NotificationController extends Controller
{
    public function index()
    {
        // Get all active events with their mappings and related channel info
        $events = NotificationEvent::with(['mappings' => function ($query) {
            $query->with('channel');
        }])->get();

        // Get all active channels
        $channels = NotificationChannel::where('status', true)->get();

        // Prepare the mapping data structure
        $mappings = [];
        foreach ($events as $event) {
            foreach ($event->mappings as $mapping) {

                // Channel mappings
                if ($mapping->channel_id) {
                    $mappings[$event->id]['channels'][$mapping->channel_id] = $mapping;
                }

                // Recipient mappings                
                $mappings[$event->id]['recipients']['admin'] = $mapping->notify_admin;


                // Recipient mappings

                $mappings[$event->id]['recipients']['user'] = $mapping->notify_customer;


                // Recipient mappings
                if ($mapping->template_id) {
                    $mappings[$event->id]['templates']['template'] = $mapping->template_id;
                }
            }
        }

        return view('notifications::index', [
            'events' => $events,
            'channels' => $channels,
            'mappings' => $mappings
        ]);
    }

    public function show($id)
    {
        try {
            // Get the specific event
            $mapping = NotificationMapping::where('event_id', $id)->get();

            $channelMappings = [];
            foreach ($mapping as $key => $mapping) {
                $event = NotificationEvent::where('id', $mapping->event_id)->first();
                $channel_id = $mapping->channel_id;
                $templates[$channel_id] = [];
                // Get all channels with their mappings for this event
                $channels = NotificationChannel::where('id', $mapping->channel_id)->get();

                foreach ($channels as $channel) {
                    // Instantiate the channel class with config
                    $channelInstance = app($channel->channel_class, ['config' => []]);

                    if (method_exists($channelInstance, 'getTemplates')) {
                        $channelTemplates = $channelInstance->getTemplates();
                        $templates[$channel_id] = array_merge($templates[$channel_id], $channelTemplates);
                    }
                }
                // Organize mappings by channel                
                foreach ($channels as $channel) {                    
                    $channelMappings[$channel->id] = [
                        'name'          => $channel->name,
                        'notify_admin' => $mapping->notify_admin ?? false,
                        'notify_customer' => $mapping->notify_customer ?? false,
                        'template_id' => $mapping->template_id ?? null,
                        'channel_id' => $mapping->channel_id ?? null,
                        'channel_class' => $channel->channel_class // Include channel class if needed
                    ];
                }
            }

            return view('notifications::form', [                
                'channels' => $channels,
                'templates' => $templates,
                'channelMappings' => $channelMappings,
                'currentEventId' => $id
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Failed to load notification settings: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            // Manually validate request
            $validator = Validator::make($request->all(), [
                'event_id' => 'required|exists:notification_events,id',
                'channels' => 'required|array',
                'channels.*.notify_admin' => 'sometimes|boolean',
                'channels.*.notify_customer' => 'sometimes|boolean',
                'channels.*.template_id' => 'sometimes|nullable'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }

            $event = NotificationEvent::findOrFail($request['event_id']);
            $channels = $request->input('channels');

            foreach ($channels as $channelId => $mappingData) {

                $updateData = [
                    'notify_admin' => (bool)($mappingData['notify_admin'] ?? false),
                    'notify_customer' => (bool)($mappingData['notify_customer'] ?? false),
                    'template_id' => $mappingData['template_id'] ?? null
                ];


                NotificationMapping::updateOrCreate(
                    [
                        'event_id' => $event->id,
                        'channel_id' => $channelId
                    ],
                    $updateData
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Notification settings updated successfully',
                'redirect_url' => route('admin.notification.index')
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => 'Failed to update settings: ' . $e->getMessage()
            ]);
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'notifications' => 'required|array',
            'notifications.*' => 'array',
        ]);

        try {
            DB::beginTransaction();

            foreach ($validated['notifications'] as $eventId => $settings) {
                // Get all existing channel IDs for this event
                $existingChannelIds = NotificationMapping::where('event_id', $eventId)
                    ->pluck('channel_id')
                    ->toArray();

                $submittedChannelIds = [];

                if (isset($settings['channels'])) {
                    foreach ($settings['channels'] as $channelId => $channelData) {
                        // Only process if the channel is enabled
                        if (isset($channelData['enabled']) && $channelData['enabled']) {
                            // Get recipient settings (now from the recipients array)
                            $notifyAdmin = $settings['recipients']['admin'] ?? false;
                            $notifyUser = $settings['recipients']['user'] ?? false;

                            // Update or create the mapping
                            NotificationMapping::updateOrCreate(
                                [
                                    'event_id' => $eventId,
                                    'channel_id' => $channelId,
                                ],
                                [
                                    'notify_admin' => (bool)$notifyAdmin,
                                    'notify_customer' => (bool)$notifyUser
                                ]
                            );
                            $submittedChannelIds[] = $channelId;
                        }
                    }
                }

                // Delete mappings for channels that weren't submitted or were unchecked
                $channelsToDelete = array_diff($existingChannelIds, $submittedChannelIds);
                if (!empty($channelsToDelete)) {
                    NotificationMapping::where('event_id', $eventId)
                        ->whereIn('channel_id', $channelsToDelete)
                        ->delete();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Notification settings updated successfully',
                'redirect_url' => route('admin.notification.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => 'Failed to update notification settings: ' . $e->getMessage(),
            ]);
        }
    }
}
