<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageText; // Make it public so it's available in the view

    public function __construct($messageText)
    {
        $this->messageText = $messageText;
    }

    public function build()
    {
        return $this->subject('Message Regarding Your Order')
                    ->view('emails.customer-message') // your view file
                    ->with([
                        'messageText' => $this->messageText,
                    ]);
    }
}
