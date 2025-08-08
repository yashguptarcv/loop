<?php

namespace Modules\Whatsapp\Listeners;

use App\Events\GenericWhatsAppEvent;
use Modules\Whatsapp\Models\WhatsAppTemplate;
use Modules\Whatsapp\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendGenericWhatsAppTemplate implements ShouldQueue
{
    use InteractsWithQueue;

    protected $whatsAppService;

    /**
     * Create the event listener.
     *
     * @param WhatsAppService $whatsAppService
     */
    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Handle the event.
     *
     * @param GenericWhatsAppEvent $event
     * @return void
     */
    public function handle(GenericWhatsAppEvent $event)
    {
        Log::info('GenericWhatsAppEvent received, attempting to send WhatsApp admin.whatsapp.', [
            'mobile_no' => $event->mobileNo,
            'template_name' => $event->templateName,
            'parameters' => $event->templateParameters,
        ]);

        // Fetch the template to get its language and ensure it exists
        $template = WhatsAppTemplate::where('name', $event->templateName)->first();

        if (!$template) {
            Log::warning('WhatsApp template not found for generic event.', [
                'template_name' => $event->templateName,
                'mobile_no' => $event->mobileNo,
            ]);
            return; // Do not proceed if template is not found
        }

        // Format parameters for the WhatsApp API 'body' component
        $components = [];
        if (!empty($event->templateParameters)) {
            $parameters = [];
            foreach ($event->templateParameters as $param) {
                $parameters[] = ['type' => 'text', 'text' => (string) $param];
            }
            $components[] = [
                'type' => 'body',
                'parameters' => $parameters
            ];
        }

        // Call the WhatsAppService to send the template message
        $result = $this->whatsAppService->sendTemplateMessage(
            $event->mobileNo,
            $template->name,
            $template->language,
            $components,
            $event->recipientName
        );

        if ($result['success']) {
            Log::info('WhatsApp template message sent successfully via generic event.', [
                'mobile_no' => $event->mobileNo,
                'template_name' => $event->templateName,
                'whatsapp_message_id' => $result['data']['messages'][0]['id'] ?? 'N/A',
            ]);
        } else {
            Log::error('Failed to send WhatsApp template message via generic event.', [
                'mobile_no' => $event->mobileNo,
                'template_name' => $event->templateName,
                'error' => $result['error'],
            ]);
        }
    }
}