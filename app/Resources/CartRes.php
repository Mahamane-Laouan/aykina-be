<?php

namespace App\Http\Resources;

use App\Http\Controllers\API\BaseController;
use App\Models\Product;
use App\Models\BookingOrders;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartRes extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $all_status = BookingOrders::where('cart_id', $this->cart_id)->first();
        return [
            'cart_id' => (string)$this->cart_id,
            'user_id' => (string)$this->user_id,
            'product_id' => (string)$this->product_id,
            'quantity' => (string)$this->quantity,
            'price' => (string)$this->price,
            'checked' => (string)$this->checked,
            'address_id' => (string)$this->address_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'booking_status' => $all_status ? $all_status->handyman_status : "",
            'booking_id' => $all_status ? (string)$all_status->id : "",
            'product_Details' => new ProductRes(Product::where('product_id', $this->product_id)->first())
        ];
    }
}
