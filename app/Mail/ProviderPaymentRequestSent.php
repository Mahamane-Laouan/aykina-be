<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProviderPaymentRequestSent extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $provider_name;
    public $booking_date;
    public $firstname;
    public $amount;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $provider_name, $booking_date, $firstname, $amount)
    {
        $this->email = $email;
        $this->provider_name = $provider_name;
        $this->booking_date = $booking_date;
        $this->firstname = $firstname;
        $this->amount = $amount;
        
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('ProviderPaymentRequestSent')
            ->with([
                'email' => $this->email,
                'provider_name' => $this->provider_name,
                'booking_date' => $this->booking_date,
                'firstname' => $this->firstname,
                'amount' => $this->amount,
                
            ]);
    }
}
