<?php

namespace App\Http\Controllers;

use App\Models\ProviderReqModel;
use App\Models\SiteSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderWithdrawRequestController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the search input from the request
        $search = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Check if the user is a provider and get their ID
        $providerId = $user->id;

        // Fetch records related to the provider with optional search functionality
        $records = ProviderReqModel::when($providerId, function ($query) use ($providerId) {
            $query->where('provider_id', $providerId);
        })
            ->when($search, function ($query) use ($search) {
                // Assuming you want to filter records based on a search term
                $query->where('amount', 'like', "%{$search}%"); // Replace 'some_field' with the actual field to search
            })
            ->orderBy('created_at', 'desc') // Order records by creation date in descending order
            ->paginate(10);

        // Format created_at date within the records for convenience
        $records->getCollection()->transform(function ($record) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';
            return $record;
        });

        // Return the view with the fetched data
        return view('providerwithdraw-request', [
            'records' => $records,
            'search' => $search,
            'defaultCurrency' => $defaultCurrency,
        ]);
    }
}
