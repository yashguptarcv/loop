<?php

namespace Modules\Leads\Notifications;

use Exception;
use Modules\Notifications\Contracts\Notification;
use Modules\Notifications\Models\NotificationEvent;
use Modules\Notifications\Models\NotificationChannel;
use Modules\Notifications\Models\NotificationMapping;

class ApplicationNotification implements Notification
{
    public function __construct(protected $data) {}

    public function getEventCode(): string
    {
        return 'application_send';
    }

    public function getTemplateIdentifier(): array
    {
        $channels = [];
        try {
            // Get the event first

            $event = NotificationEvent::where('event_code', $this->getEventCode())->first();

            if (!$event) {
                return $channels;
            }
            
            // Get the mapping using the event ID
            $mappings = NotificationMapping::where('event_id', $event->id)
                ->get();


            foreach ($mappings as $key => $mapping) {
                $channel_name = NotificationChannel::where('id', $mapping->channel_id)->first();
                $channels[$channel_name->name] = $mapping->template_id;
            }
        } catch (Exception $e) {
            
        }

        return $channels;
    }

    public function getVariables(): array
    {
        $password = $this->data['password'];
        return [
            'name'              => $this->data['application']->full_name,
            'email'             => $this->data['application']->email,
            'password'          => $password,
            'application_id'    => $this->data['application']->id,
            'application_url'   => ''

        ];
    }

    public function getAvailableVariables(): array
    {
        return [
            'name'      => "User name",
            'email'     => "User email",
            'password'      => "User Random password",
            'application_id'        => "User Application ID",
            'application_url'       => "Application URL",
        ];
    }

    public function toArray(): array
    {
        return [
            'event_code' => $this->getEventCode(),
            'template' => $this->getTemplateIdentifier(),
            'variables' => $this->getVariables(),
            'available_variables' => $this->getAvailableVariables()
        ];
    }
}
