<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserOrderPlacedService extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $product_subtotal;
    public $service_subtotal;
    public $sub_total;
    public $total;
    public $coupon;
    public $tax;
    public $service_charge;
    public $firstname;
    public $order_id;
    public $order_date;
    public $addressString;
    public $my_name;
    public $allItms_done;
    public $booking_services_name;
    public $final_price;
    public $productItms_done;


    /**
     * Create a new message instance.
     */
    public function __construct($email, $product_subtotal, $service_subtotal, $sub_total, $total, $coupon, $tax, $service_charge, $firstname, $order_id, $order_date, $addressString, $my_name, $allItms_done, $booking_services_name, $final_price, $productItms_done)
    {
        $this->email = $email;
        $this->product_subtotal = $product_subtotal;
        $this->service_subtotal = $service_subtotal;
        $this->sub_total = $sub_total;
        $this->total = $total;
        $this->coupon = $coupon;
        $this->tax = $tax;
        $this->service_charge = $service_charge;
        $this->firstname = $firstname;
        $this->order_id = $order_id;
        $this->order_date = $order_date;
        $this->addressString = $addressString;
        $this->my_name = $my_name;
        $this->allItms_done = $allItms_done;
        $this->booking_services_name = $booking_services_name;
        $this->final_price = $final_price;
        $this->productItms_done = $productItms_done;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('UserOrderPlacedService')
            ->with([
                'email' => $this->email,
                'product_subtotal' => $this->product_subtotal,
                'service_subtotal' => $this->service_subtotal,
                'sub_total' => $this->sub_total,
                'total' => $this->total,
                'coupon' => $this->coupon,
                'tax' => $this->tax,
                'service_charge' => $this->service_charge,
                'firstname' => $this->firstname,
                'order_id' => $this->order_id,
                'order_date' => $this->order_date,
                'addressString' => $this->addressString,
                'my_name' => $this->my_name,
                'allItms_done' => $this->allItms_done,
                'booking_services_name' => $this->booking_services_name,
                'final_price' => $this->final_price,
                'productItms_done' => $this->productItms_done,
            ]);
    }
}
