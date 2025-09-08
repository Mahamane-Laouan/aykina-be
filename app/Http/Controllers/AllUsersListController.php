<?php

namespace App\Http\Controllers;

use App\Models\SiteSetup;
use App\Models\HandymanReview;
use App\Models\ServiceReview;
use App\Models\ServiceProof;
use App\Models\User;
use Illuminate\Http\Request;

class AllUsersListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $users = User::where('id', '!=', 1) // Exclude user with ID 1
        ->when($search, function ($query, $search) {
            return $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$search}%"])
            ->orWhere('email', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // Fetch the user IDs in pagination
        $userIds = $users->pluck('id');

        // Fetch average reviews for handymen (people_id = 2)
        $avgHandymanReviews = HandymanReview::whereIn('handyman_id', $userIds)
        ->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')
        ->groupBy('handyman_id')
        ->pluck('avg_star', 'handyman_id');

        // Fetch average reviews for providers (people_id = 1)
        $avgProviderReviews = ServiceReview::whereIn('provider_id', $userIds)
        ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
        ->groupBy('provider_id')
        ->pluck('avg_star', 'provider_id');


        // Fetch average reviews for providers (people_id = 1)
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
        ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
        ->groupBy('user_id')
        ->pluck('avg_star', 'user_id');
        

        if ($request->ajax()) {
            $recordsArray = $users->map(function ($record) use ($defaultCurrency, $avgHandymanReviews, $avgProviderReviews, $avgUsersReviews) {
                // Determine the view URL based on people_id
                $viewUrl = match ($record->people_id) {
                    1 => route('provider-view', $record->id),
                    2 => route('handyman-view', $record->id),
                    3 => route('user-view', $record->id),
                    default => route('user-view', $record->id),
                };

                // Determine default profile image based on people_id
                $defaultImages = [
                    1 => 'default_provider.jpg',
                    2 => 'default_handyman.jpg',
                    3 => 'default_user.jpg',
                ];
                $defaultImage = $defaultImages[$record->people_id] ?? 'default_user.jpg';

                // Set correct review value based on people_id
                $avgReview = $record->people_id == 1
                ? number_format($avgProviderReviews[$record->id] ?? 0.0, 1)
                : ($record->people_id == 2
                ? number_format($avgHandymanReviews[$record->id] ?? 0.0, 1)
                : ($record->people_id == 3
                    ? number_format($avgUsersReviews[$record->id] ?? 0.0, 1)
                        : '0.0'));


                return [
                    'id' => $record->id,
                    'firstname' => $record->firstname ?? '',
                    'lastname' => $record->lastname ?? '',
                    'email' => $record->email ?? '',
                    'profile_pic' => $record->profile_pic
                        ? asset('images/user/' . $record->profile_pic)
                        : asset('images/user/' . $defaultImage),
                    'country_code' => $record->country_code ?? '',
                    'mobile' => $record->mobile ?? '',
                    'people_id' => $record->people_id,
                    'login_type' => $record->login_type,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'is_blocked' => $record->is_blocked,
                    'wallet_balance' => $record->wallet_balance ?? '',
                    'edit_url' => route('user-edit', $record->id),
                    'avg_review' => $avgReview,
                    'view_url' => $viewUrl,
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Format created_at and attach correct review to users
        $users->getCollection()->transform(function ($record) use ($avgHandymanReviews, $avgProviderReviews, $avgUsersReviews) {
            $record->formatted_created_at = $record->created_at
            ? $record->created_at->format('d M, Y / g:i A')
            : '';

            // Set correct review value based on people_id
            $record->avg_review = $record->people_id == 1
            ? number_format($avgProviderReviews[$record->id] ?? 0.0, 1)
            : ($record->people_id == 2
            ? number_format($avgHandymanReviews[$record->id] ?? 0.0, 1)
            : ($record->people_id == 3
            ? number_format($avgUsersReviews[$record->id] ?? 0.0, 1)
            : '0.0'));


            return $record;
        });

        return view('all-users', compact('users', 'search', 'defaultCurrency'));
    }




    // ChangeUserBlocked
    public function ChangeUserBlocked($id)
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
}
