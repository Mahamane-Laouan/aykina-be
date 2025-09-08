<?php

namespace App\Http\Controllers;

use App\Models\BookHistory;
use App\Models\BookingHandymanHistory;
use App\Models\BookingOrders;
use Illuminate\Support\Facades\Auth;
use App\Models\BookingProviderHistory;
use App\Models\HandymanReview;
use App\Models\Commissions;
use Illuminate\Support\Facades\DB;
use App\Models\ProviderHistory;
use App\Models\SiteSetup;
use Illuminate\Http\Request;

class ProviderHandymanEarningsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Check if the user is a provider
        $providerId = $user->id;

        // Fetch handyman data for the specific provider
        $records = BookingHandymanHistory::with([
            'handyman' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            },
            'provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname');
            }
        ])
            ->when($providerId, function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('handyman', function ($handymanQuery) use ($search) {
                    $handymanQuery->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->select(
                'handyman_id',
                'provider_id',
                DB::raw('COUNT(DISTINCT booking_id) as total_bookings'),
                DB::raw('SUM(amount) as total_earning'),
                DB::raw('SUM(CASE WHEN handman_status = 1 THEN amount ELSE 0 END) as provider_paid_amount'),
                DB::raw('SUM(CASE WHEN handman_status = 0 THEN amount ELSE 0 END) as pending_amount'),
                DB::raw('MAX(commision_persontage) as commision_persontage') // Fetch max commission percentage
            )
            ->groupBy('handyman_id', 'provider_id') // Group by handyman and provider
            ->orderBy('total_bookings', 'desc') // Order by total bookings in descending order
            ->paginate(10);

        // Fetch average review ratings for each provider
        $handymanIds = $records->pluck('handyman_id')->filter();
        $avgHandymanReviews = HandymanReview::whereIn('handyman_id', $handymanIds)
        ->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')
        ->groupBy('handyman_id')
        ->pluck('avg_star', 'handyman_id'); // Fetch avg star rating per handyman


        // Transform the created_at field for the main page view
        $records->getCollection()->transform(function ($record) use ($avgHandymanReviews) {
            $record->formatted_created_at = $record->created_at
            ? $record->created_at->format('d M, Y / g:i A')
            : '';

            // Assign average review rating to the handyman
            if ($record->handyman) {
                $record->handyman->avg_handyman_review = number_format($avgHandymanReviews[$record->handyman_id] ?? 0.0, 1);
            }
            return $record;
        });


        return view('provider-handymanearnings', compact('records', 'search', 'defaultCurrency'));
    }

}
