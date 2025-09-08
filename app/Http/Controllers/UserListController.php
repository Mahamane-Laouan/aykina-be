<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\OrdersModel;
use App\Models\ServiceLike;
use App\Models\ServiceReview;
use App\Models\HandymanReview;
use Carbon\Carbon;
use App\Models\ServiceProof;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $users = User::where(function ($query) {
            $query->where('people_id', 3);
        })
            ->when($search, function ($query, $search) {
                return $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$search}%"])
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $users->pluck('id'); // Get all user IDs in pagination
        $avgReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $users->map(function ($record) use ($defaultCurrency, $avgReviews) {
                return [
                    'id' => $record->id,
                    'firstname' => $record->firstname ?? '',
                    'lastname' => $record->lastname ?? '',
                    'email' => $record->email ?? '',
                    'profile_pic' => $record->profile_pic ? asset('images/user/' . $record->profile_pic) : '',
                    'country_code' => $record->country_code ?? '',
                    'mobile' => $record->mobile ?? '',
                    'login_type' => $record->login_type,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'), // Format created_at
                    'is_blocked' => $record->is_blocked,
                    'wallet_balance' => $record->wallet_balance ?? '',
                    'edit_url' => route('user-edit', $record->id),
                    'view_url' => route('user-view', $record->id),
                    'currency' => $defaultCurrency,
                    'avg_review' => number_format($avgReviews[$record->id] ?? 0.0, 1) // Add review rating

                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Format created_at date within the records for convenience
        $users->getCollection()->transform(function ($record) use ($avgReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';
            $record->avg_review = number_format($avgReviews[$record->id] ?? 0.0, 1); // Assign rating
            return $record;
        });


        return view('user-list', compact('users', 'search', 'defaultCurrency'));
    }


    // viewUser
    public function viewUser($id)
    {
        // Fetch the user details
        $user = User::findOrFail($id);

        $defaultCurrency = SiteSetup::first()->default_currency;

        $totalBooking = OrdersModel::where('user_id', $id)->count() ?? 0;

        $WalletBalance = User::where('id', $id)->sum('wallet_balance') ?? 0;

        $totalreviews = ServiceReview::where('user_id', $id)->count() ?? 0;

        $totallikes = ServiceLike::where('user_id', $id)->count() ?? 0;

        // Fetch the user's orders in descending order
        $orders = OrdersModel::with(['user', 'provider', 'service'])
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc') // Assuming 'id' is the primary key and used for ordering
            ->get();


        $avgReview = ServiceProof::where('user_id', $id)->avg('rev_star') ?? 0.0;


        // Fetch average review ratings for each provider
        $userIds = ServiceProof::where('user_id', $id)->pluck('handyman_id')->filter(); // Get all provider IDs

        $avgUsersReviews = HandymanReview::whereIn('handyman_id', $userIds)->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')->groupBy('handyman_id')->pluck('avg_star', 'handyman_id'); // Fetch avg star rating per provider

        // Fetch the latest customers dynamically through provider_id
        $latestCustomersofUser = ServiceProof::where('user_id', $id)
            ->with('user') // Eager load the user relationship
            ->get()
            ->filter(fn($review) => $review->user !== null) // Ensure user exists
            ->map(function ($review) use ($avgUsersReviews) {
                return [
                    'id' => $review->user->id,
                    'firstname' => $review->user->firstname ?? '',
                    'lastname' => $review->user->lastname ?? '',
                    'email' => $review->user->email ?? '',
                    'profile_pic' => $review->user->profile_pic ?? 'default_handyman.jpg', // Fallback for profile picture
                    'rev_star' => $review->rev_star,
                    'rev_text' => $review->rev_text ?? '', // Fallback for review text
                    'created_at' => Carbon::parse($review->created_at)->format('d F, Y'),
                    'avg_handyman_review' => number_format($avgUsersReviews[$review->user->id] ?? 0.0, 1), // Fetch avg review rating
                ];
            });



        // Pass the values to the view
        return view('user-view', compact('user', 'totalBooking', 'WalletBalance', 'totalreviews', 'totallikes', 'orders', 'defaultCurrency', 'avgReview', 'latestCustomersofUser'));
    }


    // editUser
    public function editUser($id)
    {
        $user = User::find($id);
        return view('user-edit', compact('user'));
    }


    // updateUser
    public function updateUser($id, Request $request)
    {
        $user = User::find($id);
        $user->confirmation = $request->input('confirmation');
        $user->save();

        return redirect()->route('user-list')->with('message', 'User updated successfully');;
    }

    // ChangeUserListBlocked
    public function ChangeUserListBlocked($id)
    {
        // Check the current status
        $currentType = User::where('id', $id)->value('is_blocked');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = User::where('id', $id)->update(['is_blocked' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }


    // deleteUser
    public function deleteUser($id)
    {
        $data = User::where('id', $id)->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
