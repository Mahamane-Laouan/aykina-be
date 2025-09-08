<?php

namespace App\Http\Controllers;

use App\Models\ProviderReqModel;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceReview;
use App\Models\SiteSetup;
use Illuminate\Http\Request;

class PayOutListProviderController extends Controller
{

    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Fetch data with provider and bank details
        $records = ProviderReqModel::with(['provider', 'bankDetails'])
            ->when($search, function ($query, $search) {
                $query->whereHas('provider', function ($q) use ($search) {
                    $q->where('firstname', 'LIKE', "%{$search}%")
                        ->orWhere('lastname', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $providerIds = $records->pluck('provider.id')->filter(); // Get all provider IDs in pagination
        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider

        // Transform the created_at field for the main page view
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';

            // Ensure provider exists before assigning avg review
            if ($record->provider) {
                $record->provider->avg_provider_review = number_format($avgProviderReviews[$record->provider->id] ?? 0.0, 1);
            }


            return $record;
        });

        return view('payout-listprovider', compact('records', 'search', 'defaultCurrency'));
    }


    // ChangeProviderPayoutListStatus
    public function ChangeProviderPayoutListStatus($id)
    {
        // Fetch the current status
        $provider = ProviderReqModel::find($id);

        if (!$provider) {
            return response()->json(['message' => 'Provider request not found'], 404);
        }

        // Toggle the status
        $provider->status = $provider->status == 1 ? 0 : 1;

        // Save the updated status
        if ($provider->save()) {
            return response()->json(['message' => 'Request Approved successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }
}
