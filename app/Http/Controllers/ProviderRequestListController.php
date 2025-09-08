<?php

namespace App\Http\Controllers;

use App\Models\Commissions;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ProviderRequestListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch commission value for provider or Provider role
        $commission = Commissions::where(function ($query) {
            $query->where('people_id', 1);
        })->value('value');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $users = User::where(function ($query) {
            $query->where('people_id', 1)
                ->where('confirmation', 0);
        })
            ->where('confirmation', 0)  // Ensure only providers with confirmation = 0 are fetched
            ->when($search, function ($query, $search) {
                return $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$search}%"])
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
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
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'confirmation' => $record->confirmation,
                    'wallet_balance' => $record->wallet_balance ?? '',
                    'commission' => $commission ?? '',
                    'edit_url' => route('provider-view', $record->id),
                    'view_url' => route('provider-view', $record->id),
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Format created_at date for convenience
        $users->getCollection()->transform(function ($record) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';
            return $record;
        });

        return view('provider-requestlist', compact('users', 'search', 'commission',
        'defaultCurrency'));
    }



    // providerRequestApproval
    public function providerRequestApproval($id)
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


    // ignoreProvider
    public function ignoreProvider($id)
    {
        User::find($id)->delete();
        return response()->json(['message' => 'Provider deleted successfully', 'id' => $id]);
    }


    public function getUnverifiedProvider()
    {
        $count = DB::table('users')
        ->where('people_id', 1)
        ->where('confirmation', 0)
        ->count(); // Count all unverified providers

        return response()->json(['unverified_provider' => $count]);
    }
}
