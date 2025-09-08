<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProviderOrderCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $booking_id;
    public $user_name;
    public $booking_date;
    public $firstname;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $booking_id, $user_name, $booking_date, $firstname)
    {
        $this->email = $email;
        $this->booking_id = $booking_id;
        $this->user_name = $user_name;
        $this->booking_date = $booking_date;
        $this->firstname = $firstname;
        
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('ProviderOrderCancelled')
            ->with([
                'email' => $this->email,
                'booking_id' => $this->booking_id,
                'user_name' => $this->user_name,
                'booking_date' => $this->booking_date,
                'firstname' => $this->firstname,
                
            ]);
    }
}
