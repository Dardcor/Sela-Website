<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LecturerAccessRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $approveUrl;

    public function __construct(User $user, string $approveUrl)
    {
        $this->user = $user;
        $this->approveUrl = $approveUrl;
    }

    public function build()
    {
        return $this->subject('New Lecturer Access Request')
                    ->view('emails.lecturer_access_request');
    }
}
