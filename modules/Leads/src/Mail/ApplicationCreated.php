<?php

namespace Modules\Leads\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $isNewUser;

    public function __construct(User $user, $password, $isNewUser)
    {
        $this->user = $user;
        $this->password = $password;
        $this->isNewUser = $isNewUser;
    }

    public function build()
    {
        $subject = $this->isNewUser
            ? 'Your Account Has Been Created'
            : 'Your Account Has Been Updated';

        return $this->subject($subject)
            ->view('emails.application-created')
            ->with([
                'user' => $this->user,
                'password' => $this->password,
                'isNewUser' => $this->isNewUser,
            ]);
    }
}
