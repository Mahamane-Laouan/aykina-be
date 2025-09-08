<?php

namespace App\Http\Controllers;

use App\Models\Commissions;
use App\Models\SiteSetup;
use App\Models\User;
use App\Models\ServiceReview;
use DateTimeZone;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    // index
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch commission value for provider role
        $commission = Commissions::where('people_id', 1)->value('value');

        // Fetch the default currency and timezone from SiteSetup
        $siteSetup = SiteSetup::first();
        $defaultCurrency = $siteSetup->default_currency;
        $istTimezone = new DateTimeZone($siteSetup->time_zone); // Set dynamic timezone

        // Fetch users with people_id = 1
        $users = User::where('people_id', 1)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$search}%"])
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $users->pluck('id'); // Get all user IDs in pagination
        $avgReviews = ServiceReview::whereIn('provider_id', $userIds)
            ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('provider_id')
            ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $users->map(function ($record) use ($commission, $defaultCurrency, $avgReviews, $istTimezone) {
                return [
                    'id' => $record->id,
                    'firstname' => $record->firstname ?? '',
                    'lastname' => $record->lastname ?? '',
                    'email' => $record->email ?? '',
                    'profile_pic' => $record->profile_pic ? asset('images/user/' . $record->profile_pic) : '',
                    'country_code' => $record->country_code ?? '',
                    'mobile' => $record->mobile ?? '',
                    'login_type' => $record->login_type ?? '',
                    'created_at' => $record->created_at
                        ? $record->created_at->setTimezone($istTimezone)->format('d M, Y / g:i A')
                        : '',
                    'is_blocked' => $record->is_blocked,
                    'wallet_balance' => $record->wallet_balance ?? '',
                    'commission' => $commission ?? '',
                    'edit_url' => route('provider-view', $record->id),
                    'view_url' => route('provider-view', $record->id),
                    'currency' => $defaultCurrency,
                    'avg_review' => number_format($avgReviews[$record->id] ?? 0.0, 1) // Add review rating
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Attach avg review ratings and formatted created_at to users collection
        $users->getCollection()->transform(function ($record) use ($avgReviews, $istTimezone) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->setTimezone($istTimezone)->format('d M, Y / g:i A')
                : '';

            $record->avg_review = number_format($avgReviews[$record->id] ?? 0.0, 1); // Assign rating

            return $record;
        });

        return view('providers-list', compact('users', 'search', 'commission', 'defaultCurrency'));
    }




    // addProvider
    public function addProvider()
    {
        return view('provider-add');
    }


    // Save Provider
    public function saveProvider(Request $request)
    {
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'mobile' => ['required', 'regex:/^[0-9]{10}$/'],
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
            ],
            'profile_pic' => 'required|image',
            'is_blocked' => 'required',
        ];

        $customMessages = [
            'firstname.required' => 'Please enter first name.',
            'lastname.required' => 'Please enter last name.',
            'mobile.required' => 'Please enter contact number.',
            'mobile.regex' => 'Contact number must be exactly 10 digits.',
            'email.required' => 'Please enter email.',
            'password.required' => 'Please enter password.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least one letter, one number, and one special character, and be at least 8 characters long.',
            'profile_pic.required' => 'Please upload a profile image.',
            'is_blocked.required' => 'Please select the status.',
        ];

        $this->validate($request, $rules, $customMessages);

        $user = new User();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->country_code = '+' . $request->input('country_code');
        $user->password = bcrypt($request->input('password'));
        $user->people_id = 1;
        $user->user_role = 'provider';
        $user->login_type = 'email';
        $user->is_blocked = $request->input('is_blocked');



        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/user/'), $imageName);
            $user->profile_pic = $imageName;
        }

        $user->save();

        return redirect()
            ->route('providers-list')
            ->with('message', 'Provider added successfully');
    }


    // Edit Provider
    public function editProvider($id)
    {
        $user = User::find($id);
        $existingImage = $user->profile_pic;
        return view('provider-edit', compact('user', 'existingImage'));
    }


    // Update Provider
    public function updateProvider($id, Request $request)
    {
        $user = User::find($id);
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->country_code = '+' . $request->input('country_code');
        $user->is_blocked = $request->input('is_blocked');

        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/user/'), $imageName);
            $user->profile_pic = $imageName;
        }

        $user->save();

        return redirect()->route('providers-list')->with('message', 'Provider updated successfully');;
    }


    // Delete Provider
    public function deleteProvider($id)
    {
        User::find($id)->delete();
        return response()->json(['message' => 'Provider deleted successfully', 'id' => $id]);
    }


    // ChangeProviderListBlocked
    public function ChangeProviderListBlocked($id)
    {
        // Check the current status
        $currentType = User::where('id', $id)->value('is_blocked');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = User::where('id', $id)->update(['is_blocked' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }
}
