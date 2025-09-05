<?php

namespace Modules\Whatsapp\Services;

use App\Events\GenericWhatsAppEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationDispatcher
{
    /**
     * Dispatch a WhatsApp template message based on an event key.
     *
     * @param string $eventKey The unique key representing the application event (e.g., 'user_created').
     * @param string $mobileNo The recipient's mobile number.
     * @param array $templateParameters An array of values for the template's body parameters.
     * @param string|null $recipientName The name of the recipient (optional).
     * @return bool True if the event was dispatched, false otherwise.
     */
    public function dispatchFromEvent(string $eventKey, string $mobileNo, array $templateParameters = [], ?string $recipientName = null): bool
    {
        $templateName = DB::table('whatsapp_event_templates')
            ->where('event_key', $eventKey)
            ->value('template_name');

        if (!$templateName) {
            Log::warning("WhatsApp template mapping not found for event key: {$eventKey}");
            return false;
        }

        event(new GenericWhatsAppEvent($mobileNo, $templateName, $templateParameters, $recipientName));
        
        Log::info("Dispatched GenericWhatsAppEvent for event key: {$eventKey} with template: {$templateName}");
        return true;
    }
}