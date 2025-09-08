<?php

namespace App\Http\Controllers;

use App\Models\OrdersModel;
use App\Models\SiteSetup;
use App\Models\ServiceProof;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');


        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = OrdersModel::with([
            'service' => function ($query) {
                $query->select('id', 'service_name');
            },
            'user' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
            }
        ])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($serviceQuery) use ($search) {
                    $serviceQuery->where('firstname', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc') // Order by created_at, latest first
            ->paginate(10); // Paginate results

        // Fetch average review ratings for each provider
        $userIds = $records->pluck('user.id')->filter(); // Get all provider IDs in pagination
        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')
            ->groupBy('user_id')
            ->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgUsersReviews) {
                return [
                    'id' => $record->id,
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'payment_mode' => $record->payment_mode,
                    'service_name' => $record->service->service_name ?? '',
                    'p_status' => $record->p_status,
                    'service_url' => $record->service && $record->service->id
                        ? route('service-edit', $record->service->id) // Ensure service ID is passed
                        : null,
                    'total' => $record->total,
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
                    'view_url' => route('booking-view', $record->id),
                    'currency' => $defaultCurrency,
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

        return view('payment-list', compact('records', 'search', 'defaultCurrency'));
    }
}
