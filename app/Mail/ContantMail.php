<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContantMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailConfig = settings('mail');
        if(empty((array) $mailConfig)) {
            throw new Exception("There are no settings for sending email", 1);
            
        }
        return $this->from($mailConfig->from)
                view($mailConfig->view);
    }
}
