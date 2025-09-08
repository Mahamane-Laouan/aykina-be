<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\CartItemsModel;
use App\Models\ServiceLike;
use App\Models\ProductLike;
use App\Models\ProviderHistory;
use App\Models\user_notification;
use App\Models\User;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        $all_cart = CartItemsModel::where('user_id', $this->id)->where('checked', "0")->count();
        
        $all_service_like = ServiceLike::where('user_id', $this->id)->count();
        
        $all_product_like = ProductLike::where('user_id', $this->id)->count();
        
        $balance = ProviderHistory::where('provider_id', $this->id)->first();
        
        $unread_count = 0;
        $user_type = User::where('id', $this->id)->first();
        
        $user_role = $user_type->user_role;
        
        if($user_role == "Provider"){
            
         $unread_count = user_notification::where('provider_id', $this->id)->where('read_provider', "0")->count();
        }
        
        if($user_role == "Handyman"){
            
         $unread_count = user_notification::where('handyman_id', $this->id)->where('read_handyman', "0")->count();
        }
        
         if($user_role == "User" || $user_role == "user"){
            
         $unread_count = user_notification::where('user_id', $this->id)->where('read_user', "0")->count();
        }
        
        
        return [
            'id' => (string)$this->id,
            // 'fullname' => (string)$this->fullname,
            'firstname' => $this->firstname ?? "",
            'lastname' => $this->lastname ?? "",
            'email' => $this->email ?? "",
            'mobile' => (string)$this->mobile ?? "",
            'country_code' => (string)$this->country_code ?? "",
            'user_role' => $this->user_role ?? "",
            'login_type' => $this->login_type ?? "",
            'google_id' => (string)$this->google_id ?? "",
            'device_token' => $this->device_token ?? "",
            'city' => $this->city ?? "",
            'state' => $this->state ?? "",
            'location' => $this->location ?? "",
            'profile_pic' => $this->profile_pic ? url('public/images/user/' . $this->profile_pic) : "",
            'commision' => "20%",
            'country_flag' => $this->country_flag ?? "",
            
            'total_cart_item_count' => $all_cart,
            'total_product_like' => $all_product_like,
            'total_service_like' => $all_service_like,
            'wallet_balance' => $this->wallet_balance ? (string)$this->wallet_balance : "",
            'provider_wallet_balance' => $balance ? $balance->available_bal : "",
            'unread_notification_count' => $unread_count,
            'refer_code' => $this->refer_code ?? "",
            'latitude' => $this->latitude ?? "",
            'longitude' => $this->longitude ?? "",
            'mobile_verified_otp' => $this->mobile_verified_otp ?? "",
            // 'phone' => (string)$this->phone,
            // 'salt' => (string)$this->salt,
            // 'email_verified_at' => (string)$this->email_verified_at,
            // 'login_type' => (string)$this->login_type,
            // 'google_id' => (string)$this->google_id,
            // 'profile_pic' => asset('assets/images/user/'.$this->profile_pic),
            // 'dob' => (string)$this->dob,
            // 'age' => (string)$this->age,
            // 'gender' => (string)$this->gender,
            // 'country' => (string)$this->country,
            // 'state' => (string)$this->state,
            // 'city' => (string)$this->city,
            // 'country_id' => (int)$this->country_id,
            // 'state_id' => (int)$this->state_id,
            // 'city_id' => (int)$this->city_id,
            // 'bio' => (string)$this->bio,
            // 'interests_id' => (string)$this->interests_id,
            // 'device_token' => (string)$this->device_token,
            // 'is_Private' => (string)$this->is_Private,
            // 'create_date' => (string)$this->create_date,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
