<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HandymanBookingAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $booking_id;
    public $provider_name;
    public $booking_date;
    public $firstname;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $booking_id, $provider_name, $booking_date, $firstname)
    {
        $this->email = $email;
        $this->booking_id = $booking_id;
        $this->provider_name = $provider_name;
        $this->booking_date = $booking_date;
        $this->firstname = $firstname;
        
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('HandymanBookingAccepted')
            ->with([
                'email' => $this->email,
                'booking_id' => $this->booking_id,
                'provider_name' => $this->provider_name,
                'booking_date' => $this->booking_date,
                'firstname' => $this->firstname,
                
            ]);
    }
}
