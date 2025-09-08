<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Friends_request;
use App\Models\User;
use App\Models\Chat;
use App\Models\DefaultImage;
use App\Models\user_notification;
use App\Models\Notification;
use RtcTokenBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ChatController extends BaseController
{
    public function chat_api(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'to_user' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // if (request('message') == "" || request('url') == "") {
        //     return $this->sendError(['error' => "message, url is required."]);
        // }
        $user_id = Auth::user()->token()->user_id;
        $input['from_user'] = $user_id;
        // $input['from_user'] = $request->user()->token()->user_id;
        // $input['seen'] = 0;
        $input['message'] = (request('message')) ? request('message') : "";
        $input['type'] = (request('type')) ? request('type') : "";
        $input['url'] = (request('url')) ? request('url') : "";

        $input['date'] = round(microtime(true) * 1000);
        // $input['thumbnail'] = (request('thumbnail')) ? request('thumbnail') : "";
        $input['time'] = (request('time')) ? request('time') : "";
        if ($request->file('url')) {
            if ($request->file('url')) {
                $file = $request->file('url');
                $filename = "chat_" . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/chat/'), $filename);
                $input['url'] = $filename;
            }
            // if ($request->file('thumbnail')) {
            //     $file = $request->file('thumbnail');
            //     $filename = "thumbnail" . uniqid() . '.' . $file->getClientOriginalExtension();
            //     $file->move(public_path('/files/chats_img'), $filename);
            //     $input['thumbnail'] = $filename;
            // }
        } else {
            $input['message'] = request('message');
        }
        $chat = Chat::create($input);
        if (!empty($chat)) {

            $user_id = Auth::user()->token()->user_id;
            $to_user = $request->to_user;
            $message = $request->message;
            $type = $request->type;
            // $user = Auth::guard('sanctum')->user();

            // $fUser = User::select('firstname')->where('id', $user_id)->first()->fullname;
            // $FcmToken = User::select('device_token')->where('id', $request->to_user)->first()->device_token;
            // $data = [
            //     "registration_ids" => array($FcmToken),
            //     "notification" => [
            //         "title" => "Message",
            //         "body" => "$fUser send you message.",
            //     ]
            // ];
            // $this->sendNotification($data);

            // $fImage = User::select('profile_pic')->where('id', $user_id)->first()->profile_pic;

            $FcmToken = User::where('id', $to_user)->value('device_token');


            $username =  User::where('id', $user_id)->first();

            $firstname = $username->firstname;
            $profile_image = url('public/images/user/' . $username->profile_pic);

            $data = [
                'title' => $firstname,
                'message' => "$firstname is message now.",
                'type' => "Message",
                'booking_id' => $user_id,
                'order_id' => $to_user,
                'profile_image' => $profile_image,
                'username' => $firstname,
            ];

            //  dd($data);

            $this->sendNotification_chat(new Request($data), $FcmToken);



            // $data = [
            //     "registration_ids" => array($FcmToken),
            //     "notification" => [
            //         "title" => "Message",
            //         "body" => "$fUser send message",
            //         "is_type" => "message",
            //         "from_user" => $user_id,
            //         "to_user" => $to_user,
            //     ],
            //     "data" => [
            //         "title" => "Message",
            //         "body" => "$fUser is message now.",
            //         'toUser' => $to_user,
            //         'message' => $message,
            //         'my_id' => $user_id,
            //         'my_secondid' => $to_user,
            //         'profile_image' => url('public/images/user/' . $fImage),

            //         'isType' => "message",
            //         "Message" => 'Message'
            //     ]
            // ];
            // $this->sendNotification($data);

            // print_r($data);
            // die;

            return response()->json(['success' => "true", 'message' => "Message Send successfully..!"]);
        } else {
            return response()->json(['error' => "message not send"]);
        }
    }

    public function message_list_new(request $request)
    {
        $validator = Validator::make($request->all(), ['to_user' => 'required',]);

        if ($validator->fails()) {
            //pass validator errors as errors object for ajax response
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // $from_user = Auth::guard('sanctum')->user()->id;
        $from_user = Auth::user()->token()->user_id;

        $to_user = request('to_user');
        // $data = chat::where('from_user', $from_user)->where('to_user', $to_user)->orwhere('from_user', $to_user)->where('to_user', $from_user)->get();

        $user = User::select('id', 'firstname', 'profile_pic')->where('id', '=', $from_user)->get()->transform(function ($ts) {
            $ts['profile_pic'] = $ts['profile_pic'] ? url('/images/user/' . $ts['profile_pic']) : "";
            return $ts;
        })->toArray();

        //   $message_read = $request->input('message_read');

        $data = array(
            "read_message" =>  "1",
        );

        // Updating rows in the Chat table based on the conditions
        Chat::where('to_user', $from_user)
            ->where('from_user', $to_user)
            // ->where('message_read', "1")
            ->update($data);

        $data = Chat::where(function ($query) use ($from_user, $to_user) {
            $query->where('from_user', $from_user)->where('to_user', $to_user)
                ->orWhere('from_user', $to_user)->where('to_user', $from_user);
        })
            // ->whereIn('type', ['image', 'text']) // type image & text lava mate
            ->orderBy('created_at', 'desc') // Order by created_at column in descending order
            ->get()
            ->transform(function ($ts) use ($from_user) {

                $ts['id'] = (string)$ts['id'];
                // $ts['my_id'] = (string)$ts['from_user'];
                $ts['to_user'] = (string)$ts['to_user'];

                //  $from_user = Auth::guard('sanctum')->user()->id;
                $from_user = Auth::user()->token()->user_id;

                //   if ($otherUser = ($ts->from_user == $from_user)) {
                //         $ts['my_id'] = (string)$from_user;
                //         $ts['second_id'] = (string)$ts->to_user;
                //     }else{
                //          $ts['my_id'] = (string)$from_user;
                //         $ts['second_id'] = (string)$ts->from_user;
                //     }

                if ($ts->from_user == $from_user) {
                    // if(chat::where('from_user', '==', $user_id )){
                    // if($row->id == $user_id ){


                    $ts['type'] = $ts['type'];
                } else {

                    $ts['type'] = $ts['type'];
                }

                // $ts['firstname'] = $ts['firstname'] ?? "";
                unset($ts['read_message']);
                unset($ts['updated_at']);
                unset($ts['timestamp']);


                $all_done = User::select('id', 'firstname', 'profile_pic')->where('id', '=', $from_user)->first();
                $ts['firstname'] = $all_done->firstname ?? "";
                $ts['profile_pic'] = $all_done->profile_pic ? url('public/images/user/' . $all_done->profile_pic) : "";

                // $ts['profile_pic'] = $ts['profile_pic'] ? url('/images/user/' . $ts['profile_pic']) : "";
                $ts['url'] = $ts['url'] ? url('public/images/chat/' . $ts['url']) : "";
                $ts['message'] = ($ts['message']) ? $ts['message'] : "";


                $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $ts['created_at']);
                $ts['chat_time'] = $carbon->format('h:i A');
                return $ts;
            })->toArray();

        $response = [
            'success' => "true",
            'message' => "Message list.",
            'chat' => $data

        ];
        return response()->json($response, 200);
    }


    public function message_list(request $request)
    {
        $validator = Validator::make($request->all(), ['to_user' => 'required',]);

        if ($validator->fails()) {
            //pass validator errors as errors object for ajax response
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // $from_user = Auth::guard('sanctum')->user()->id;
        $from_user = Auth::user()->token()->user_id;

        $to_user = request('to_user');
        // $data = chat::where('from_user', $from_user)->where('to_user', $to_user)->orwhere('from_user', $to_user)->where('to_user', $from_user)->get();

        $user = User::select('id', 'firstname', 'profile_pic')->where('id', '=', $from_user)->get()->transform(function ($ts) {
            $ts['profile_pic'] = $ts['profile_pic'] ? url('/images/user/' . $ts['profile_pic']) : "";
            return $ts;
        })->toArray();

        //   $message_read = $request->input('message_read');

        $data = array(
            "read_message" =>  "1",
        );

        // Updating rows in the Chat table based on the conditions
        Chat::where('to_user', $from_user)
            ->where('from_user', $to_user)
            // ->where('message_read', "1")
            ->update($data);

        $data = Chat::where(function ($query) use ($from_user, $to_user) {
            $query->where('from_user', $from_user)->where('to_user', $to_user)
                ->orWhere('from_user', $to_user)->where('to_user', $from_user);
        })
            // ->whereIn('type', ['image', 'text']) // type image & text lava mate
            ->orderBy('created_at', 'desc') // Order by created_at column in descending order
            ->get()
            ->groupBy(function ($message) {
                return $message->created_at->format('Y-m-d'); // Group messages by date
            })
            // ->map(function ($groupedMessages, $date) {
            ->map(function ($groupedMessages, $date) use ($request) {

                // Add $request here
                $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d\TH:i:s.u\Z');
                return [
                    'date' => $formattedDate, // Include the date in the result
                    // 'messages' => $groupedMessages->map(function ($message) {
                    'messages' => $groupedMessages->map(function ($message) use ($request) { // Add $request here as well

                        // $to_user_profile = User::select('firstname', 'lastname', 'profile_pic')->where('id', $message->from_user)->first();
                        // $profile = "";
                        // // $url = "";
                        // if (!empty($to_user_profile->profile_pic)) {
                        //     $url = explode(':', $to_user_profile->profile_pic);
                        //     if ($url[0] == 'https' || $url[0] == 'http') {
                        //         $profile  = $to_user_profile->profile_pic;
                        //     } else {
                        //         $profile = url('public/images/user/' . $to_user_profile->profile_pic);
                        //     }
                        // }

                        $to_user_profile = User::select('id', 'firstname', 'lastname', 'profile_pic')->where('id', $message->from_user)->first();
                        $provider_details = User::where('id', $to_user_profile->id)->first();
                        $pro_seen = $provider_details->people_id;

                        // Default profile pic
                        $profile_pic = "";

                        if (!empty($to_user_profile->profile_pic)) {
                            // Agar user ke paas profile pic hai toh wahi use karo
                            $profile = url('/images/user/' . $to_user_profile->profile_pic);
                        } else {
                            // Default image lene ke liye people_id check karo
                            $default_image = DefaultImage::where('people_id', $pro_seen)->first();

                            // Agar default image mil jaaye toh use karo
                            if ($default_image) {
                                $profile = url('/images/user/' . $default_image->image);
                            }
                        }

                        $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at);
                        // Transform each message as needed
                        return [
                            'id' => (string)$message->id,
                            'from_user' => $message->from_user,
                            'to_user' => $message->to_user,
                            'message' => $message->message ?? "",
                            'url' => $message->url ? url('public/images/chat/' . $message->url) : "",
                            'type' => $message->type ? $message->type : "",
                            'read_message' => (string)$message->read_message ?? "",
                            'date' => $message->date ? $message->date : "",
                            'time' => $message->time ? $message->time : "",
                            'created_at' => $message->created_at ? $message->created_at : "",
                            'firstname' => $to_user_profile ? ($to_user_profile->firstname) : "",
                            'profile_image' => $profile,
                            'message_seen' => $message->read_message ? $message->read_message : "",
                            'chat_time' => $carbon->format('h:i A'),


                            // Add other fields you want to include here
                        ];
                    }),
                ];
            });
        // ->transform(function ($ts) use ($from_user) {

        //     $ts['id'] = (string)$ts['id'];
        //     // $ts['my_id'] = (string)$ts['from_user'];
        //     $ts['to_user'] = (string)$ts['to_user'];

        //     //  $from_user = Auth::guard('sanctum')->user()->id;
        //     $from_user = Auth::user()->token()->user_id;

        //     //   if ($otherUser = ($ts->from_user == $from_user)) {
        //     //         $ts['my_id'] = (string)$from_user;
        //     //         $ts['second_id'] = (string)$ts->to_user;
        //     //     }else{
        //     //          $ts['my_id'] = (string)$from_user;
        //     //         $ts['second_id'] = (string)$ts->from_user;
        //     //     }

        //     if ($ts->from_user == $from_user) {
        //         // if(chat::where('from_user', '==', $user_id )){
        //         // if($row->id == $user_id ){


        //         $ts['type'] = $ts['type'];
        //     } else {

        //         $ts['type'] = $ts['type'];
        //     }

        //     // $ts['firstname'] = $ts['firstname'] ?? "";
        //     unset($ts['read_message']);
        //     unset($ts['updated_at']);
        //     unset($ts['timestamp']);


        //     $all_done = User::select('id', 'firstname', 'profile_pic')->where('id', '=', $from_user)->first();
        //     $ts['firstname'] = $all_done->firstname ?? "";
        //     $ts['profile_pic'] = $all_done->profile_pic ? url('images/user/' . $all_done->profile_pic) : "";

        //     // $ts['profile_pic'] = $ts['profile_pic'] ? url('/images/user/' . $ts['profile_pic']) : "";
        //     $ts['url'] = $ts['url'] ? url('/images/chat/' . $ts['url']) : "";
        //     $ts['message'] = ($ts['message']) ? $ts['message'] : "";


        //     $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $ts['created_at']);
        //     $ts['chat_time'] = $carbon->format('h:i A');
        //     return $ts;
        // })->toArray();

        $response = [
            'success' => "true",
            'message' => "Message list.",
            'chat' => $data->values()->all(),

        ];
        return response()->json($response, 200);
    }

    public function user_chat_list(Request $request)
    {
        // $user_id = $request->user()->token()->user_id;

        // $user_id = Auth::guard('sanctum')->user()->id;
        $user_id = Auth::user()->token()->user_id;

        $data = User::select('id')->whereIn('id', function ($q) use ($user_id) {
            $q->select('to_user')->from('chats')->where('from_user', $user_id);
        })->orwhereIn('id', function ($q) use ($user_id) {
            $q->select('from_user')->from('chats')->where('to_user', $user_id);
        })->get();

        $data_Ar = array();
        foreach ($data as $row) {
            $last_message_query = Chat::where(function ($q) use ($user_id, $row) {
                $q->where('from_user', $user_id)
                    ->where('to_user', $row->id);
            })->orwhere(function ($q) use ($user_id, $row) {
                $q->where('from_user', $row->id)
                    ->where('to_user', $user_id);
            })->orderBy('created_at', 'DESC')->first();

            $chat_list['id'] = (string)$last_message_query->id;
            // if($user_id){
            $chat_list['my_id'] = (string)$user_id;
            // }else{
            $chat_list['second_id'] = (string)$row->id;
            // }
            // $chat_list['second_id'] = (string)$last_message_query->to_user;
            if ($last_message_query->url) {
                $chat_list['last_message'] = "files";
            } elseif ($last_message_query->message) {
                $chat_list['last_message'] = "messages";
            } elseif ($last_message_query->story_id) {
                $chat_list['last_message'] = "story";
            } elseif ($last_message_query->post_id) {
                $chat_list['last_message'] = "posts";
            }
            $chat_list['message'] = $last_message_query->message ?? "";
            $chat_list['url'] = $last_message_query->url ? url('public/images/chat/' . $last_message_query->url) : "";
            $chat_list['type'] = $last_message_query->type ? $last_message_query->type : "";
            $user = $last_message_query->to_user == $user_id ?  User::where('id', $last_message_query->from_user)->first() : user::where('id', $last_message_query->to_user)->first();
            $chat_list['user_id'] = (string)$user->id;
            // $chat_list['firstname'] = $user->firstname ? $user->firstname : "";
            $chat_list['firstname'] = trim(($user->firstname ? $user->firstname : "") . " " . ($user->lastname ? $user->lastname : ""));
            $chat_list['user_role'] = $user->user_role ? $user->user_role : "";
            // $chat_list['fullname'] = $user->fullname ? $user->fullname : "";
            // $chat_list['profile_pic'] = ($user->profile_pic) ? url('public/images/user/' . $user->profile_pic) :  "";

            if (!empty($user->profile_pic)) {
                $profile_pic = url('/images/user/' . $user->profile_pic);
            } else {
                $provider_details = $user; // Already fetched user details
                $pro_seen = $provider_details->people_id;
                $default_image = DefaultImage::where('people_id', $pro_seen)->first();
                $profile_pic = $default_image ? url('/images/user/' . $default_image->image) : "";
            }
            $chat_list['profile_pic'] = $profile_pic;
            $chat_list['is_online'] = (string)$user->is_online;
            $chat_list['last_seen'] = (string)$user->updated_at;
            // $chat_list['is_verify'] = (string)$user->is_verify;
            $chat_list['date'] = $last_message_query->date ? $last_message_query->date : "";
            $chat_list['time'] = $last_message_query->created_at->diffForHumans();

            // $block = lock_user::where('user_id', $user_id)->where('locked_user_id', $user->id)->first();
            $chat_list['unread_message'] = (string)Chat::where('to_user', $user_id)->where('from_user', $row->id)->where('read_message', 0)->count();

            // if($last_message_query->to_user == $user_id){
            // $chat_list['unread_message'] = (string)chat::where('to_user', $last_message_query->to_user)->where('read_message', 0)->count();
            // }else{
            //       $chat_list['unread_message'] = "0";
            // }
            // $chat_list['chat_time'] = $this->created_at->diffForHumans();
            // $chat_list['is_blocked'] = block_user::where('user_id', $user_id)->where('blocked_user_id', $user->id)->orwhere('user_id', $user->id)->where('blocked_user_id', $user_id)->exists() ? "1" : "0";
            // $chat_list['is_meblocked'] = block_user::where('user_id', $user->id)->where('blocked_user_id', $user_id)->orwhere('user_id', $user->id)->where('blocked_user_id', $user_id)->exists() ? "1" : "0";
            // if ($block) {
            //     $chat_list['password'] = $block->password ? $block->password : "";
            // } else {
            //     $chat_list['password'] = "";
            // }
            // $chat_list['is_lock'] = lock_user::where('user_id', $user_id)->where('locked_user_id', $user->id)->exists() ? "1" : "0";

            // $chat_list['chat_accept'] = chat_accept::where('from_user', $user_id)->where('to_user', $row->id)->where('is_status', '1')->exists()  ? true : false;

            array_push($data_Ar, $chat_list);
        }

        $chat = array();
        foreach ($data_Ar as $key => $row) {
            $chat[$key] = $row['id'];
        }
        array_multisort($chat, SORT_DESC, $data_Ar);


        // if (chat_accept::where('from_user', $user_id)->where('to_user', $to_user)->exists()) {
        //         $result['is_block'] = "1";
        //     } else {
        //         $result['is_block'] = "0";
        //     }

        $response = [
            'success' => "true",
            'message' => "Message list.",
            'chat_list' => $data_Ar
        ];
        return response()->json($response, 200);
        // if ($data_Ar) {
        //     return response()->json(array('message' => 'true', 'data' => $data_Ar));
        // } else {
        //     return response()->json(array('message' => 'false'));
        // }
    }

    public function total_unread_messages(Request $request)
    {
        $user_id = Auth::user()->token()->user_id;

        $total_unread_messages = Chat::where('to_user', $user_id)->where('read_message', 0)->count();

        $response = [
            'success' => true,
            'total_unread_messages' => (string)$total_unread_messages
        ];

        return response()->json($response, 200);
    }
}
