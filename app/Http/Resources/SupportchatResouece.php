<?php

namespace App\Http\Resources;

use App\Models\SupportChat;
use App\Models\ProfileBlock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportchatResouece extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $to_user_profile = User::select('firstname', 'profile_pic')->where('id', $this->to_user)->first();
        $profile = "";
        // $url = "";
        if (!empty($to_user_profile->profile_pic)) {
            $url = explode(':', $to_user_profile->profile_pic);
            if ($url[0] == 'https' || $url[0] == 'http') {
                $profile  = $to_user_profile->profile_pic;
            } else {
                $profile = url('/images/user/' . $to_user_profile->profile_pic);
            }
        } else {
            $profile = url('/profile_pics/eventuser.jpg');
        }

        // if (!empty($this->url)) {
        //     $url = explode(':', $this->url);
        //     if ($url[0] == 'https' || $url[0] == 'http') {
        //         $url  = $this->url;
        //     } else {
        //         $url = url('/chat_images/' . $this->url);
        //     }
        // }
        // $is_block = "";
        //  if($this->from_user){

        // if(SupportChat::where('from_user', $this->user_id)->where('to_user', $this->peer_id)->exists()) {
        //     $is_message_me = "1";
        // } else {
        //     $is_message_me = "0";
        // }


        // $is_incomeing = "";
        // if(!empty($this->call_type)){

        //     if(Chat::where('from_user', $this->from_user)->where('to_user', $this->to_user)->exists()) {
        //         $is_incomeing = "1";
        //     } else {
        //         $is_incomeing = "0";
        //     }
        // }



        return array(
            'id' => (string)$this->id,
            'from_user' => $this->from_user ? $this->from_user : "",
            'to_user' => $this->to_user ? $this->to_user : "",
            'message' => $this->message ? $this->message : "",
            'subject' => $this->subject ? $this->subject : "",
            'url' => $this->url ? url('/images/support_chat_images/' . $this->url) : "",
            'type' => $this->type ? $this->type : "",
            'order_number' => $this->order_number ? $this->order_number : "",
            'status' => $this->status,
            'username' => $to_user_profile ? $to_user_profile->firstname : "",
            'profile_pic' => $profile,
            'created_at' =>  date('H:i', strtotime($this->created_at)),
            'is_attachment' => $this->url ? "1" : "0",
            'is_message_me' => $this->is_message_me,
            'date' => $this->created_at ? $this->created_at->format('Y-m-d') : "",

        );
    }
}
