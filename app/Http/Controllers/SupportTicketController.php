<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\SupportChat;
use App\Models\ServiceProof;
use App\Models\SupportChatstatus;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{

    // index
    public function index(Request $request)
    {
        $records = Ticket::with([
            'user' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            },
            'supportChatStatus'  // Eager load the supportChatStatus relationship
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        // Format created_at date within the records for convenience
        $records->getCollection()->transform(function ($record) use ($avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->user) {
                $record->user->avg_users_review = number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1);
            }
            return $record;
        });

        return view('support-ticket', compact('records'));
    }


    public function viewTicket($id)
    {
        $ticket = Ticket::with('user')->findOrFail($id); // Ensure 'user' relationship is loaded
        $admin = Admin::first(); // Ensure 'user' relationship is loaded
        $orderNumber = SupportChat::where('order_number', $ticket->order_id)->pluck('order_number')->first();
        $chatMessages = SupportChat::where('order_number', $orderNumber)
            ->orderBy('created_at', 'asc')
            ->get();

        // Fetch the average review rating for the user associated with the ticket
        $avgUsersReview = ServiceProof::where('user_id', $ticket->user_id)
        ->avg('rev_star') ?? 0;

        // Attach the avg review to the user object for easy access in the view
        $ticket->user->avg_users_review = number_format($avgUsersReview, 1);

        return view('ticket-view', compact('ticket', 'chatMessages', 'orderNumber', 'admin'));
    }

    public function sendMessage(Request $request)
    {

        // Store the message
        $message = new SupportChat();
        $message->order_number = $request->order_number;
        $message->message = $request->message; // Allow null for image-only message
        $message->from_user = $request->from_user;
        $message->to_user = $request->to_user;
        $message->admin_message = $request->admin_message;

        // Store image if provided
        if ($request->hasFile('url')) {
            $image = $request->file('url');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/support_chat_images'), $imageName);
            $message->url = $imageName; // Store the image filename in the URL column
        }

        $message->save();

        // Return response with success
        return response()->json([
            'success' => true,
            'message' => $message->message,
            'imageUrl' => $message->url, // Include image URL if applicable
            'time' => $message->created_at->format('H:i')
        ]);
    }

    public function closeTicket(Request $request, $id)
    {
        // Find the ticket by ID
        $ticket = Ticket::findOrFail($id);

        // Ensure the logic for closing tickets works only on the relevant table (support_chat_status in this case)
        // Compare order_id from tickets table and order_number from support_chat_status table
        $supportChatStatus = SupportChatStatus::where('order_number', $ticket->order_id)->first();

        // If a matching SupportChatStatus entry is found, update its status
        if ($supportChatStatus) {
            $supportChatStatus->status = 1; // Assuming '1' means closed
            $supportChatStatus->save();
        }

        return response()->json(['success' => true, 'message' => 'Support Chat status updated successfully.']);
    }
}
