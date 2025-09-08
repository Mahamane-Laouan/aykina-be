<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProviderReviewReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $provider_name;
    public $booking_date;
    public $firstname;
    public $rating;
    public $text;
    public $service_name;
    public $booking_id;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $provider_name, $booking_date, $firstname, $rating, $text, $service_name, $booking_id)
    {
        $this->email = $email;
        $this->provider_name = $provider_name;
        $this->booking_date = $booking_date;
        $this->firstname = $firstname;
        $this->rating = $rating;
        $this->text = $text;
        $this->service_name = $service_name;
        $this->booking_id = $booking_id;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('ProviderReviewReceived')
            ->with([
                'email' => $this->email,
                'provider_name' => $this->provider_name,
                'booking_date' => $this->booking_date,
                'firstname' => $this->firstname,
                'rating' => $this->rating,
                'text' => $this->text,
                'service_name' => $this->service_name,
                'booking_id' => $this->booking_id,

            ]);
    }
}
