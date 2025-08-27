<?php

namespace Modules\EmailNotification\Channels;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Modules\EmailNotification\Jobs\TestJob;
use Modules\Notifications\Models\NotificationLog;
use Modules\EmailNotification\Mail\NotificationEmail;
use Modules\Notifications\Contracts\NotificationChannel;
use Modules\EmailNotification\Models\NotificationTemplate;

class EmailChannel implements NotificationChannel
{
    public function __construct(protected array $config) {}

    public function send(array $notifiables, $notification): void
    {
        
        $template = NotificationTemplate::where('id', $notification->getTemplateIdentifier()[$this->getName()] ?? 0)
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


            Mail::mailer($this->config['driver'])->to($recipient)->queue($mailable);
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
    public function getTemplates()
    {
        return NotificationTemplate::select('id', 'name')
            ->where('status', true)
            ->get()
            ->toArray();
    }

    public function getName(): string
    {
        return 'email';
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
