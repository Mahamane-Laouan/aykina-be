<?php

namespace App\Http\Controllers;

use App\Models\HandymanReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProviderHandymanReviewListController extends Controller
{
    // index
    public function index(Request $request)
    {
        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Check if the user is a provider and get the provider ID
        $providerId = $user->id;

        $search = $request->input('search');

        $records = HandymanReview::with([
            'handyman' => function ($query) use ($providerId) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic')
                    ->where('provider_id', $providerId);
            }
        ])
            ->whereHas('handyman', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
            ->where('text', 'LIKE', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // Fetch average review ratings for each provider
        $providerIds = $records->pluck('handyman.id')->filter(); // Get all provider IDs in pagination
        $avgProviderReviews = HandymanReview::whereIn('handyman_id', $providerIds)
        ->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')
        ->groupBy('handyman_id')
        ->pluck('avg_star', 'handyman_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($avgProviderReviews) {
                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'star_count' => $record->star_count ?? '',
                    'text' => $record->text ?? '',
                    'handyman' => [
                        'firstname' => $record->handyman->firstname ?? '',
                        'lastname' => $record->handyman->lastname ?? '',
                        'email' => $record->handyman->email ?? '',
                        'profile_pic' => $record->handyman->profile_pic ? asset('images/user/' . $record->handyman->profile_pic) : '',
                        'avg_handyman_review' => number_format($avgProviderReviews[$record->handyman->id] ?? 0.0, 1), // Provider rating
                        'profile_url' => $record->handyman && $record->handyman->id
                            ? route('providerhandyman-view', $record->handyman->id)
                            : null,
                    ],
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Transform the created_at field for the main page view
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews) {
            $record->formatted_created_at = $record->created_at
            ? $record->created_at->format('d M, Y / g:i A')
            : '';

            // Ensure provider exists before assigning avg review
            if ($record->handyman) {
                $record->handyman->avg_handyman_review = number_format($avgProviderReviews[$record->handyman->id] ?? 0.0, 1);
            }
            return $record;
        });

        return view('providerhandyman-reviewlist', compact('records', 'search'));
    }



    // deleteProviderHandymanReview
    public function deleteProviderHandymanReview($id)
    {
        $data = HandymanReview::where('id', $id)->delete();
        return response()->json(['message' => 'Review deleted successfully']);
    }
}
