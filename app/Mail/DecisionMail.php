<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DecisionMail extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $requestitem ;
    protected $user;
    protected $request;

    public function __construct($requestitem , $user, $request)
    {
        //
        
        $this->items=$requestitem ;
        $this->user=$user;
        $this->request=$request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.decision')->with([
            'Name' => $this->items->name,
            'itemColor' => $this->items->color,
            'itemCategory' => $this->items->category,
            'requestSubmitted' => $this->request->reason,
            'approved' => $this->request->approved

        ]);
    }
}
