<?php

namespace App\Http\Controllers;

use App\Models\BookHistory;
use App\Models\BookingOrders;
use App\Models\BookingProviderHistory;
use App\Models\Commissions;
use App\Models\ServiceReview;
use Illuminate\Support\Facades\DB;
use App\Models\ProviderHistory;
use App\Models\ProviderReqModel;
use App\Models\SiteSetup;
use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch commission value for providers
        $commission = Commissions::where(function ($query) {
            $query->where('people_id', 1);
        })->value('value');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;


        // Fetch unique provider data along with total bookings and their earnings
        $records = BookingOrders::with([
            'provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            }
        ])
            ->when($search, function ($query, $search) {
                $query->whereHas('provider', function ($providerQuery) use ($search) {
                    $providerQuery->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->select('provider_id', DB::raw('COUNT(DISTINCT id) as total_bookings'))
            ->groupBy('provider_id') // Group by provider_id to ensure unique counting
            ->orderBy('total_bookings', 'desc') // Order by total bookings in descending order
            ->paginate(10); // Paginate results

        // Attach total earnings, net earnings, admin earnings, and total balance for each provider
        foreach ($records as $record) {
            // Calculate provider earnings
            $record->provider_earning = BookingProviderHistory::where('provider_id', $record->provider_id)->sum('amount');

            // Calculate provider commission and net earnings
            $record->commission_value = $commission;
            // $record->net_earning = $record->provider_earning - ($record->provider_earning * $commission / 100);

            // $totalBals = ProviderHistory::where('provider_id', $record->provider_id)->value('available_bal');
            // $record->net_earning = $totalBals ?? 0;  // Set to 0 if no balance is found

            $totalBals = ProviderReqModel::where('provider_id', $record->provider_id)->sum('amount');
            $record->net_earning = $totalBals ?? 0;  // Set to 0 if no balance is found

            // Calculate total amount paid by provider
            $totalAmountPaid = BookHistory::where('provider_id', $record->provider_id)->sum('payment');

            // Calculate admin earnings (80% of total amount paid)
            $record->admin_earning = $totalAmountPaid * 0.80;

            // Fetch total balance from ProviderHistory
            $totalBal = ProviderHistory::where('provider_id', $record->provider_id)->value('total_bal');
            $availableBal = ProviderHistory::where('provider_id', $record->provider_id)->value('available_bal');
            $record->total_balance = $totalBal - $totalBals ?? 0;  // Set to 0 if no balance is found
        }

        // Fetch average review ratings for each provider
        $providerIds = $records->pluck('provider.id')->filter(); // Get all provider IDs in pagination
        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgProviderReviews) {
                return [
                    'id' => $record->id,
                    'total_bookings' => $record->total_bookings,
                    'provider' => [
                        'firstname' => $record->provider->firstname ?? '',
                        'lastname' => $record->provider->lastname ?? '',
                        'email' => $record->provider->email ?? '',
                        'avg_provider_review' => number_format($avgProviderReviews[$record->provider->id] ?? 0.0, 1), // Provider rating
                        'profile_pic' => $record->provider && $record->provider->profile_pic
                            ? asset('images/user/' . $record->provider->profile_pic)
                            : '',
                        'profile_url' => $record->provider && $record->provider->id
                            ? route('provider-view', $record->provider->id)
                            : null,
                    ],
                    'provider_earning' => $record->provider_earning,
                    'commission_value' => $record->commission_value,
                    'net_earning' => $record->net_earning,
                    'admin_earning' => $record->admin_earning,
                    'total_balance' => $record->total_balance,
                    'currency' => $defaultCurrency,
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
            if ($record->provider) {
                $record->provider->avg_provider_review = number_format($avgProviderReviews[$record->provider->id] ?? 0.0, 1);
            }


            return $record;
        });

        return view('earnings', compact('records', 'search', 'defaultCurrency'));
    }
}
