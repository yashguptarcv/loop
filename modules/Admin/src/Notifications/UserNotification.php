<?php

namespace Modules\Admin\Notifications;

use Exception;
use Modules\Notifications\Contracts\Notification;
use Modules\Notifications\Models\NotificationEvent;
use Modules\Notifications\Models\NotificationChannel;
use Modules\Notifications\Models\NotificationMapping;

class UserNotification implements Notification
{
    public function __construct(protected $data) {}

    public function getEventCode(): string
    {
        return 'create_user_account';
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
        return [
            'name'              => $this->data['name'],
            'email'             => $this->data['email'],
            'password'          => $this->data['password'],
            'login_url'         => route('admin.login')

        ];
    }

    public function getAvailableVariables(): array
    {
        return [
            'name'      => "User name",
            'email'     => "User email",
            'password'  => "User Random password",
            'login_url' => "Login URL",
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
