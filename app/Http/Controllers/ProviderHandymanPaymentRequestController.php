<?php

namespace App\Http\Controllers;

use App\Models\BookingHandymanHistory;
use App\Models\SiteSetup;
use Illuminate\Http\Request;
use App\Models\HandymanReview;

use Illuminate\Support\Facades\Auth;

class ProviderHandymanPaymentRequestController extends Controller
{
    // index
    public function index(Request $request)
    {
        // Retrieve the search input and the currently logged-in admin user
        $search = $request->input('search');
        $user = Auth::guard('admin')->user();

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Fetch handyman users with their associated provider details and optional search
        $users = BookingHandymanHistory::where('provider_id', $user->id) // Ensure the handyman is related to the logged-in provider
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->where('handman_status', 0) // Sort by creation date in descending order
            ->orderBy('created_at', 'desc') // Sort by creation date in descending order
            ->with([
                'service',
                'handyman' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
            ])
            ->paginate(10);

        // Fetch average review ratings for each handyman
        $handymanIds = $users->pluck('handyman.id')->filter(); // Get all handyman IDs in pagination
        $avgHandymanReviews = HandymanReview::whereIn('handyman_id', $handymanIds)
            ->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('handyman_id')
            ->pluck('avg_star', 'handyman_id');

        // Format the created_at date and assign average rating
        $users->getCollection()->transform(function ($record) use ($avgHandymanReviews) {
            $record->formatted_created_at = $record->created_at
            ? $record->created_at->format('d M, Y / g:i A')
            : '';

            // Ensure handyman exists before assigning avg review
            if ($record->handyman) {
                $record->handyman->avg_handyman_review = number_format($avgHandymanReviews[$record->handyman->id] ?? 0.0, 1);
            }
            return $record;
        });

        // Return the view with the data
        return view('providerhandyman-paymentrequest', compact('users', 'search', 'defaultCurrency'));
    }


    // ProviderhandymanPaymentRequestApproval
    public function ProviderhandymanPaymentRequestApproval(Request $request, $id)
    {
        // Find the service by id
        $service = BookingHandymanHistory::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        try {
            // Update the request approval status
            $service->handman_status = $request->status;
            $service->save();

            return response()->json(['message' => 'Request accepted successfully', 'id' => $service->id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating request', 'error' => $e->getMessage()], 500);
        }
    }


    // rejectPaymentProviderHandyman
    public function rejectPaymentProviderHandyman(Request $request, $id)
    {
        // Find the service by id
        $service = BookingHandymanHistory::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        try {
            // Update the request approval status
            $service->handman_status = $request->status; // Assuming 3 means "rejected"
            $service->save();

            return response()->json(['message' => 'Handyman payment request rejected successfully', 'id' => $service->id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating request', 'error' => $e->getMessage()], 500);
        }
    }


    // ProviderHandymanApprovedList
    public function ProviderHandymanApprovedList(Request $request)
    {
        // Retrieve the search input and the currently logged-in admin user
        $search = $request->input('search');
        $user = Auth::guard('admin')->user();


        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Fetch handyman users with their associated provider details and optional search
        $users = BookingHandymanHistory::where('provider_id', $user->id) // Ensure the handyman is related to the logged-in provider
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->where('handman_status', 1) // Sort by creation date in descending order
            ->orderBy('created_at', 'desc') // Sort by creation date in descending order
            ->with([
                'service',
                'handyman' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
            ])
            ->paginate(10);

        // Fetch average review ratings for each handyman
        $handymanIds = $users->pluck('handyman.id')->filter(); // Get all handyman IDs in pagination
        $avgHandymanReviews = HandymanReview::whereIn('handyman_id', $handymanIds)
            ->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('handyman_id')
            ->pluck('avg_star', 'handyman_id');

        // Format the created_at date and assign average rating
        $users->getCollection()->transform(function ($record) use ($avgHandymanReviews) {
            $record->formatted_created_at = $record->created_at
            ? $record->created_at->format('d M, Y / g:i A')
            : '';

            // Ensure handyman exists before assigning avg review
            if ($record->handyman) {
                $record->handyman->avg_handyman_review = number_format($avgHandymanReviews[$record->handyman->id] ?? 0.0, 1);
            }
            return $record;
        });

        // Return the view with the data
        return view('providerhandyman-approvedlist', compact('users', 'search', 'defaultCurrency'));
    }


    // ProviderHandymanRejectedList
    public function ProviderHandymanRejectedList(Request $request)
    {
        // Retrieve the search input and the currently logged-in admin user
        $search = $request->input('search');
        $user = Auth::guard('admin')->user();

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Fetch handyman users with their associated provider details and optional search
        $users = BookingHandymanHistory::where('provider_id', $user->id) // Ensure the handyman is related to the logged-in provider
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->where('handman_status', 2) // Sort by creation date in descending order
            ->orderBy('created_at', 'desc') // Sort by creation date in descending order
            ->with([
                'service',
                'handyman' => function ($query) {
                    $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
                },
            ])
            ->paginate(10);

        // Fetch average review ratings for each handyman
        $handymanIds = $users->pluck('handyman.id')->filter(); // Get all handyman IDs in pagination
        $avgHandymanReviews = HandymanReview::whereIn('handyman_id', $handymanIds)
            ->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('handyman_id')
            ->pluck('avg_star', 'handyman_id');

        // Format the created_at date and assign average rating
        $users->getCollection()->transform(function ($record) use ($avgHandymanReviews) {
            $record->formatted_created_at = $record->created_at
            ? $record->created_at->format('d M, Y / g:i A')
            : '';

            // Ensure handyman exists before assigning avg review
            if ($record->handyman) {
                $record->handyman->avg_handyman_review = number_format($avgHandymanReviews[$record->handyman->id] ?? 0.0, 1);
            }
            return $record;
        });

        // Return the view with the data
        return view('providerhandyman-rejectlist', compact('users', 'search', 'defaultCurrency'));
    }
}
