<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HandymanPaymentRequestAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $booking_id;
    public $handyman_name;
    public $booking_date;
    public $firstname;
    public $amount;
    public $service_name;
    public $currency;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $booking_id, $handyman_name, $booking_date, $firstname, $amount, $service_name, $currency)
    {
        $this->email = $email;
        $this->booking_id = $booking_id;
        $this->handyman_name = $handyman_name;
        $this->booking_date = $booking_date;
        $this->firstname = $firstname;
        $this->amount = $amount;
        $this->service_name = $service_name;
        $this->currency = $currency;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('HandymanPaymentRequestAccepted')
            ->with([
                'email' => $this->email,
                'booking_id' => $this->booking_id,
                'handyman_name' => $this->handyman_name,
                'booking_date' => $this->booking_date,
                'firstname' => $this->firstname,
                'amount' => $this->amount,
                'service_name' => $this->service_name,
                'currency' => $this->currency,

            ]);
    }
}
