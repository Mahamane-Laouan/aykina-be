<?php

namespace App\Http\Resources;

use App\Http\Controllers\API\BaseController;
use App\Models\Service;
use App\Models\BookingOrders;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class CartSerRes extends JsonResource
{



    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */


    public function toArray(Request $request): array
    {

        $all_status = BookingOrders::where('cart_id', $this->cart_id)->first();
        $formatted_booking_date = Carbon::parse($this->booking_date)->format('d/m/Y');

        return [
            'cart_id' => (string)$this->cart_id,
            'user_id' => (string)$this->user_id,
            'service_id' => (string)$this->service_id,
            'quantity' => (string)$this->quantity,
            'price' => (string)$this->price,
            'checked' => (string)$this->checked,
            'address_id' => (string)$this->address_id,
            'booking_date' => (string)$formatted_booking_date,
            'booking_time' => (string)$this->booking_time,
            'notes' => (string)$this->notes ?? "",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'booking_status' => $all_status ? (string)$all_status->handyman_status : "",
            'booking_id' => $all_status ? (string)$all_status->id : "",
            'service_Details' => new ServiceRes(Service::where('id', $this->service_id)->first())
        ];
    }
}
