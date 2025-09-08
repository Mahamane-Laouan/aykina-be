<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserProductDelivered extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $firstname;
    public $booking_id;
    public $product_name;
    public $date;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $firstname, $booking_id, $product_name, $date)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->booking_id = $booking_id;
        $this->product_name = $product_name;
        $this->date = $date;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('UserProductDelivered')
            ->with([
                'email' => $this->email,
                'firstname' => $this->firstname,
                'booking_id' => $this->booking_id,
                'product_name' => $this->product_name,
                'date' => $this->date,
            ]);
    }
}
