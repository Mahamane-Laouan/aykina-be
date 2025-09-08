<?php

namespace App\Http\Controllers;

use App\Models\Commissions;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HandymanRequestListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch commission value for provider or Provider role
        $commission = Commissions::where(function ($query) {
            $query->where('people_id', 2);
        })->value('value');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Fetch handyman users with their associated provider details
        $users = User::where(function ($query) {
            $query->where('people_id', 2)
                ->where('confirmation', 0);
        })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$search}%"])
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('provider', function ($providerQuery) use ($search) {
                            $providerQuery->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$search}%"])
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->where('confirmation', 0)
            ->orderBy('created_at', 'desc')
            ->with(['provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic'); // Select specific fields
            }])
            ->paginate(10);

        if ($request->ajax()) {
            $recordsArray = $users->map(function ($record) use ($commission, $defaultCurrency) {
                return [
                    'id' => $record->id,
                    'firstname' => $record->firstname ?? '',
                    'lastname' => $record->lastname ?? '',
                    'email' => $record->email ?? '',
                    'profile_pic' => $record->profile_pic ? asset('images/user/' . $record->profile_pic) : '',
                    'country_code' => $record->country_code ?? '',
                    'mobile' => $record->mobile ?? '',
                    'created_at' => $record->created_at->format('d M, Y / g:i A'), // Format created_at
                    'confirmation' => $record->confirmation,
                    'wallet_balance' => $record->wallet_balance ?? '',
                    'commission' => $commission ?? '',

                    'provider' => [
                        'firstname' => $record->provider->firstname ?? '',
                        'lastname' => $record->provider->lastname ?? '',
                        'email' => $record->provider->email ?? '',
                        'profile_pic' => $record->provider->profile_pic ? asset('images/user/' . $record->provider->profile_pic) : '',
                        'profile_url' => $record->provider && $record->provider->id
                            ? route('provider-view', $record->provider->id)
                            : null,
                    ],

                    'edit_url' => route('handyman-edit', $record->id),
                    'view_url' => route('handyman-view', $record->id),
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Format created_at date within the records for convenience
        $users->getCollection()->transform(function ($record) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';
            return $record;
        });

        return view('handyman-requestlist', compact('users', 'search', 'commission', 'defaultCurrency'));
    }


    // handymanRequestApproval
    public function handymanRequestApproval($id)
    {
        // Find the service by id
        $service = User::find($id);

        // Check if the service exists
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        try {
            // Update the request approval status
            $service->confirmation = 1;
            $service->save();

            return response()->json(['message' => 'Request accepted successfully', 'id' => $service->id]);
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json(['message' => 'Error updating request', 'error' => $e->getMessage()], 500);
        }
    }


    // ignoreHandyman
    public function ignoreHandyman($id)
    {
        User::find($id)->delete();
        return response()->json(['message' => 'Handyman deleted successfully', 'id' => $id]);
    }

    
    // getUnverifiedHandyman
    public function getUnverifiedHandyman()
    {
        $count = DB::table('users')
        ->where('people_id', 2)
        ->where('confirmation', 0)
        ->count(); // Count all unverified providers

        return response()->json(['unverified_handyman' => $count]);
    }
}
