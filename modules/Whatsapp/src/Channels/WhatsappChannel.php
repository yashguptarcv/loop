<?php

namespace Modules\Whatsapp\Channels;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Modules\EmailNotification\Jobs\TestJob;
use Modules\Whatsapp\Models\WhatsAppTemplate;
use Modules\Notifications\Models\NotificationLog;
use Modules\EmailNotification\Mail\NotificationEmail;
use Modules\Notifications\Contracts\NotificationChannel;

class WhatsappChannel implements NotificationChannel
{
    public function __construct(protected array $config) {}

    public function send(array $notifiables, $notification): void
    {
        
        $template = WhatsAppTemplate::where('id', $notification->getTemplateIdentifier()[$this->getName()])
            ->first();

        if (!$template) {
            throw new \Exception("Template not found: {$notification->getTemplateIdentifier()[$this->getName()]}");
        }

        foreach ($notifiables as $notifiable) {
            try {
                $compiled = $template->compile($notification->getVariables());
                $recipient = $notifiable->routeNotificationFor('mail', $notification);

                if (empty($recipient)) {
                    continue;
                }

                $log = NotificationLog::create([
                    'event_code' => $notification->getEventCode(),
                    'channel_name' => $this->getName(),
                    'notifiable_type' => get_class($notifiable),
                    'notifiable_id' => $notifiable->id,
                    'content' => $compiled['content'],
                    'status' => 'queued',
                    'sent_at' => null
                ]);

                // Dispatch the email to queue
                $this->dispatchToQueue($recipient, $compiled['subject'], $compiled['content'], $log->id);
            } catch (\Exception $e) {
                
                NotificationLog::create([
                    'event_code' => $notification->getEventCode(),
                    'channel_name' => $this->getName(),
                    'notifiable_type' => get_class($notifiable),
                    'notifiable_id' => $notifiable->id,
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'config' => json_encode($this->config)
                ]);
            }
        }
    }

    protected function dispatchToQueue($recipient, $subject, $content, $logId): void
    {
        try {
            $mailable = new NotificationEmail($subject, $content, $this->config, $logId);

            Mail::to($recipient)->queue($mailable);
        } catch (\Exception $e) {

            NotificationLog::where('id', $logId)
                ->update([
                    'status' => 'failed',
                    'error_message' => 'Queue dispatch failed: ' . $e->getMessage()
                ]);

            throw $e;
        }
    }

    /**
     * Method getTemplates
     *
     * @return array
     */
    public function getTemplates() {
        return WhatsAppTemplate::select('id', 'name')->where('status', 'rejected')->get()->toArray();
    }

    public function getName(): string
    {
        return 'whatsapp';
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
