<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $actionUrl;
    public $actionText;

    public function __construct($subject, $content, $actionUrl = null, $actionText = null)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.custom')
                    ->with([
                        'content' => $this->content,
                        'actionUrl' => $this->actionUrl,
                        'actionText' => $this->actionText,
                    ]);
    }
}
