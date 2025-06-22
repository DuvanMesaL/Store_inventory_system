<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $emailSubject;
    public $emailContent;
    public $actionUrl;
    public $actionText;

    public function __construct($subject, $content, $actionUrl = null, $actionText = null)
    {
        $this->emailSubject = $subject;
        $this->emailContent = $content;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
    }

    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->view('emails.custom')
                    ->with([
                        'content' => $this->emailContent,
                        'actionUrl' => $this->actionUrl,
                        'actionText' => $this->actionText,
                    ]);
    }
}
