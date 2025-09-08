<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRefundbyallProvider extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $firstname;
    public $booking_id;
    public $service_name;
    public $currency;
    public $amount;
    public $date;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $firstname, $booking_id, $service_name, $currency, $amount, $date)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->booking_id = $booking_id;
        $this->service_name = $service_name;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->date = $date;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('UserRefundbyallProvider')
            ->with([
                'email' => $this->email,
                'firstname' => $this->firstname,
                'booking_id' => $this->booking_id,
                'service_name' => $this->service_name,
                'currency' => $this->currency,
                'amount' => $this->amount,
                'date' => $this->date,
            ]);
    }
}
