<?php

namespace Modules\Leads\Notifications;

use Exception;
use Modules\Notifications\Contracts\Notification;
use Modules\Notifications\Models\NotificationEvent;
use Modules\Notifications\Models\NotificationChannel;
use Modules\Notifications\Models\NotificationMapping;

class CustomerNominationNotification implements Notification
{
    public function __construct(protected $data) {}

    public function getEventCode(): string
    {
        return 'customer_nomination_query';
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
            'name'  => $this->data->full_name,
            'email' => $this->data->email,
            'phone' => $this->data->mobile,
            'company'   => $this->data->organization,
            'application_id'    => $this->data->id,
        ];
    }

    public function getAvailableVariables(): array
    {
        return [
            'name'      => "User name",
            'email'     => "User email",
            'phone'      => "User Phone",
            'company'        => "Company",
            'application_id'       => "Application ID",
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
