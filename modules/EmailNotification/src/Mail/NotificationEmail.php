<?php

namespace Modules\EmailNotification\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Modules\Notifications\Models\NotificationLog;

class NotificationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Queue-related configurations
     */
    public int $tries = 3;
    public int $maxExceptions = 2;
    public int $timeout = 30;
    public bool $deleteWhenMissingModels = true;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $mail_subject,
        public string $content,
        public array $config = [],
        public ?int $logId = null
    ) {}

    /**
     * Build the message.
     */
    public function build()
    {
        $log = $this->logId
            ? NotificationLog::find($this->logId)
            : null;

        try {
            if ($log) {
                $log->update(['status' => 'processing']);
            }

            // Apply custom SMTP configuration if provided
            if (!empty($this->config)) {
                $this->validateSmtpConfig();
                $this->configureCustomMailer();
            }

            $email = $this->subject($this->mail_subject)
                          ->html($this->content);

            // Add CC if specified
            if (!empty($this->config['cc'])) {
                $this->addCcRecipients($email);
                if ($log) {
                    $log->update(['cc' => json_encode($this->config['cc'])]);
                }
            }

            if ($log) {
                $log->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            }

            return $email;
        } catch (Exception $e) {
            if ($log) {
                $log->update([
                    'status' => 'failed',
                    'error_message' => 'Email processing failed: ' . $e->getMessage(),
                ]);
            }
            throw $e;
        }
    }

    /**
     * Handle failed queue job.
     */
    public function failed(\Throwable $exception): void
    {
        if ($this->logId) {
            NotificationLog::where('id', $this->logId)->update([
                'status' => 'failed',
                'error_message' => 'Job failed: ' . $exception->getMessage(),
            ]);
        }
    }

    /**
     * Validate dynamic SMTP configuration.
     */
    protected function validateSmtpConfig(): void
    {
        $required = ['host', 'port', 'username', 'password', 'from_address'];

        foreach ($required as $key) {
            if (empty($this->config[$key])) {
                throw new \InvalidArgumentException("Missing required SMTP configuration: {$key}");
            }
        }
    }

    /**
     * Apply custom mailer configuration dynamically.
     */
    protected function configureCustomMailer(): void
    {
        Config::set('mail.mailers.smtp', [
            'MAIL_MAILER'     => $this->config['driver'] ?? 'smtp',
            'MAIL_HOST'       => $this->config['host'],
            'MAIL_PORT'       => $this->config['port'],
            'MAIL_ENCRYPTION' => $this->config['encryption'] ?? null,
            'MAIL_USERNAME'   => $this->config['username'],
            'MAIL_PASSWORD'   => $this->config['password'],
            'timeout'    => $this->config['timeout'] ?? null,
        ]);

        Config::set('mail.from', [
            'MAIL_FROM_ADDRESS' => $this->config['from_address'],
            'MAIL_FROM_NAME'    => $this->config['from_name'] ?? config('app.name'),
        ]);
    }

    /**
     * Add CC recipients to email.
     */
    protected function addCcRecipients(Mailable $email): void
    {
        $cc = is_array($this->config['cc'])
            ? $this->config['cc']
            : [$this->config['cc']];

        foreach ($cc as $address) {
            $email->cc($address);
        }
    }
}
