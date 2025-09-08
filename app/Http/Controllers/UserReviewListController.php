<?php

namespace App\Http\Controllers;

use App\Models\ServiceReview;
use App\Models\ServiceProof;
use Illuminate\Http\Request;

class UserReviewListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $records = ServiceProof::with([
            // 'service' => function ($query) {
            //     $query->select('id', 'service_name');
            // },
            'user' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            }
        ])
            // ->where('rev_text', 'LIKE', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($avgUsersReviews) {
                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'service_name' => $record->service_name ?? '',
                    'service_url' => $record->service && $record->service->id
                        ? route('service-edit', $record->service->id) // Ensure service ID is passed
                        : null,
                    'star_count' => $record->rev_star ?? '',
                    'text' => $record->rev_text ?? '',
                    'user' => [
                        'firstname' => $record->user->firstname ?? '',
                        'lastname' => $record->user->lastname ?? '',
                        'email' => $record->user->email ?? '',
                        'avg_users_review' => number_format($avgUsersReviews[$record->user->id] ?? 0.0, 1),
                        'profile_pic' => $record->user && $record->user->profile_pic ? asset('images/user/' . $record->user->profile_pic) : '',
                        'profile_url' => $record->user && $record->user->id
                            ? route('user-view', $record->user->id)
                            : null,
                    ],
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }


        // Transform the created_at field for the main page view
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

        return view('user-reviewlist', compact('records', 'search'));
    }


    // deleteReview
    public function deleteReview($id)
    {
        $data = ServiceReview::where('id', $id)->delete();
        return response()->json(['message' => 'Review deleted successfully']);
    }
}
