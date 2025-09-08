<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HandymanForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $otp;
    public $firstname;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $otp, $firstname)
    {
        $this->email = $email;
        $this->otp = $otp;
        $this->firstname = $firstname;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('HandymanForgotPassword')
            ->with([
                'email' => $this->email,
                'otp' => $this->otp,
                'firstname' => $this->firstname,
            ]);
    }
}
