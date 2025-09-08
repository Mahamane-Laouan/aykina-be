<?php

namespace App\Http\Resources;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressRes extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // if ($this->profile_pic) {
        //     $profile = new BaseController;
        //     $profile_pic = $profile->s3FetchFile($this->profile_pic);
        //     if (!$profile_pic) {
        //         $profile_pic = url('/profile_pic/' . $this->profile_pic);
        //     }
        // }

        return [
            'address_id' => (string)$this->address_id,
            'user_id' => (string)$this->user_id,
            'full_name' => $this->full_name ? $this->full_name : "",
            'phone' => $this->phone,
            'address' => $this->address,
            'address_type' => $this->address_type,
            'landmark' => $this->landmark,
            'city' => $this->city ?  $this->city : "",
            'area_name' => $this->area_name ? $this->area_name : "",
            'state' => $this->state ? $this->state : "",
            'country' => $this->country ? $this->country : "",
            'zip_code' => $this->zip_code ? (string) $this->zip_code : "",
            'as_default' => (string) $this->as_default,
            'lat' => $this->lat ? (string) $this->lat : "",
            'lon' => $this->lon ? (string) $this->lon : "",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
