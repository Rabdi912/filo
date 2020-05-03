<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptMail extends Mailable
{
    use Queueable, SerializesModels;
    public $item_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->item_id=$item_id;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.accept')->with($this->item_id);
    }
}
