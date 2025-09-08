<?php

namespace App\Http\Controllers;

use App\Models\ServiceReview;
use Illuminate\Http\Request;

class ProviderReviewListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $records = ServiceReview::with([
            'service' => function ($query) {
                $query->select('id', 'service_name');
            },
            'provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            }
        ])
            ->where('text', 'LIKE', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $providerIds = $records->pluck('provider.id')->filter(); // Get all provider IDs in pagination
        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
        ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
        ->groupBy('provider_id')
        ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($avgProviderReviews) {
                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'service_name' => $record->service->service_name ?? '',
                    'service_url' => $record->service && $record->service->id
                        ? route('service-edit', $record->service->id) // Ensure service ID is passed
                        : null,
                    'star_count' => $record->star_count ?? '',
                    'text' => $record->text ?? '',
                    'provider' => [
                        'firstname' => $record->provider->firstname ?? '',
                        'lastname' => $record->provider->lastname ?? '',
                        'email' => $record->provider->email ?? '',
                        'profile_pic' => $record->provider->profile_pic ? asset('images/user/' . $record->provider->profile_pic) : '',
                        'avg_provider_review' => number_format($avgProviderReviews[$record->provider->id] ?? 0.0, 1), // Provider rating
                        'profile_url' => $record->provider && $record->provider->id
                            ? route('provider-view', $record->provider->id)
                            : null,
                    ],
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }


        // Transform the created_at field for the main page view
        $records->getCollection()->transform(function ($record)use ( $avgProviderReviews)  {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->provider) {
                $record->provider->avg_provider_review = number_format($avgProviderReviews[$record->provider->id] ?? 0.0, 1);
            }


            return $record;
        });

        return view('provider-reviewlist', compact('records', 'search'));
    }


    // deleteProviderReview
    public function deleteProviderReview($id)
    {
        $data = ServiceReview::where('id', $id)->delete();
        return response()->json(['message' => 'Review deleted successfully']);
    }
}
