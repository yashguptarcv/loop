<?php

namespace Modules\Orders\Notifications;

use Exception;
use Modules\Orders\Models\Order;
use Modules\Notifications\Contracts\Notification;
use Modules\Notifications\Models\NotificationEvent;
use Modules\Notifications\Models\NotificationChannel;
use Modules\Notifications\Models\NotificationMapping;

class OrderCreatedNotification implements Notification
{
    public function __construct(protected Order $order) {}
    
    public function getEventCode(): string
    {
        return 'order_created';
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
            'user_name' => $this->order->user->name,
            'order_number' => $this->order->order_number,
            'order_date' => $this->order->created_at->format('Y-m-d'),
            'order_total' => number_format($this->order->total, 2),
            'order_link' => route('admin.orders.show', $this->order),
            'user_email' => $this->order->user->email
        ];
    }
    
    public function getAvailableVariables(): array
    {
        return [
            'user_name' => 'Full name of the user',
            'order_number' => 'The unique order number',
            'order_date' => 'Date when order was placed (YYYY-MM-DD)',
            'order_total' => 'Formatted order total amount',
            'order_link' => 'URL to view the order details',
            'user_email' => 'Customer email address'
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