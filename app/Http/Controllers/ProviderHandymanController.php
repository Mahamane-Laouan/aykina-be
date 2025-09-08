<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BookingHandymanHistory;
use App\Models\BookingOrders;
use App\Models\Commissions;
use App\Models\HandymanHistory;
use App\Models\ServiceProof;
use Carbon\Carbon;
use App\Models\HandymanReview;
use App\Models\SiteSetup;
use App\Models\User;

class ProviderHandymanController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = Auth::guard('admin')->user();  // Get the logged-in user

        // Fetch commission value for the provider role
        $commission = Commissions::where(function ($query) {
            $query->where('people_id', 2);  // assuming '2' is the provider role
        })->value('value');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Fetch users (handymen) related to the logged-in provider's ID
        $users = User::where(function ($query) use ($user) {
            $query->where('people_id', 2)
                ->where('provider_id', $user->id);  // Ensure the handyman is related to the logged-in provider
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
            ->orderBy('created_at', 'desc')
            ->with(['provider' => function ($query) {
                $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic'); // Select specific fields
            }])
            ->paginate(10);

        // Fetch average review ratings for each provider
        $userIds = $users->pluck('id'); // Get all user IDs in pagination
        $avgReviews = HandymanReview::whereIn('handyman_id', $userIds)
            ->selectRaw('handyman_id, COALESCE(AVG(star_count), 0) as avg_star')
            ->groupBy('handyman_id')
            ->pluck('avg_star', 'handyman_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $users->map(function ($record) use ($commission, $defaultCurrency, $avgReviews,) {
                return [
                    'id' => $record->id,
                    'firstname' => $record->firstname ?? '',
                    'lastname' => $record->lastname ?? '',
                    'email' => $record->email ?? '',
                    'profile_pic' => $record->profile_pic ? asset('images/user/' . $record->profile_pic) : '',
                    'country_code' => $record->country_code ?? '',
                    'mobile' => $record->mobile ?? '',
                    'is_blocked' => $record->is_blocked,
                    'login_type' => $record->login_type ?? '',
                    'created_at' => $record->created_at->format('d M, Y / g:i A'),
                    'confirmation' => $record->confirmation,
                    'wallet_balance' => $record->wallet_balance ?? '',
                    'commission' => $commission ?? '',
                    'avg_review' => number_format($avgReviews[$record->id] ?? 0.0, 1),
                    'edit_url' => route('providerhandyman-edit', $record->id),
                    'view_url' => route('providerhandyman-view', $record->id),
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Format created_at date within the records
        $users->getCollection()->transform(function ($record) use ($avgReviews) {
            $record->formatted_created_at = $record->created_at
                ? $record->created_at->format('d M, Y / g:i A')
                : '';
            $record->avg_review = number_format($avgReviews[$record->id] ?? 0.0, 1); // Handyman rating
            return $record;
        });

        return view('providerhandyman-list', compact('users', 'search', 'commission', 'defaultCurrency'));
    }



    // addProviderHandyman
    public function addProviderHandyman()
    {

        // Pass the providers to the view
        return view('providerhandyman-add');
    }




    // saveProviderHandyman
    public function saveProviderHandyman(Request $request)
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

        $user = Auth::guard('admin')->user(); // Get the logged-in user

        $newHandyman = new User();
        $newHandyman->firstname = $request->input('firstname');
        $newHandyman->lastname = $request->input('lastname');
        $newHandyman->email = $request->input('email');
        $newHandyman->mobile = $request->input('mobile');
        $newHandyman->provider_id = $user->id; // Assign the logged-in provider's ID
        $newHandyman->country_code = '+' . $request->input('country_code');
        $newHandyman->password = bcrypt($request->input('password'));
        $newHandyman->people_id = 2; // Assign the handyman role
        $newHandyman->login_type = 'email';
        $newHandyman->is_blocked = $request->input('is_blocked');

        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/user/'), $imageName);
            $newHandyman->profile_pic = $imageName;
        }

        $newHandyman->save();

        return redirect()
            ->route('providerhandyman-list')
            ->with('message', 'Handyman added successfully');
    }


    // editProviderHandyman
    public function editProviderHandyman($id)
    {
        $user = User::find($id);
        $existingImage = $user->profile_pic;

        return view('providerhandyman-edit', compact('user', 'existingImage'));
    }


    // updateProviderHandyman
    public function updateProviderHandyman($id, Request $request)
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

        return redirect()->route('providerhandyman-list')->with('message', 'Handyman updated successfully');;
    }


    // viewProviderHandyman
    public function
    viewProviderHandyman($id, $year = null)
    {
        // Fetch the user details
        $user = User::findOrFail($id);

        $defaultCurrency = SiteSetup::first()->default_currency;

        $totalBooking = BookingOrders::where('work_assign_id', $id)->count() ?? 0;

        $WalletBalance = User::where('id', $id)->sum('wallet_balance') ?? 0;


        $WithdrawnBalance = BookingHandymanHistory::where('handyman_id', $id)
        ->where('handman_status', 1)
        ->sum('amount') ?? 0;

        $totalProviderBalance = HandymanHistory::where('handyman_id', $id)->sum('total_bal') ?? 0;

        $payouts = BookingHandymanHistory::where('handyman_id', $id)
            ->select('booking_id', 'amount', 'commision_persontage', 'handman_status', 'payment_method', 'created_at')
            ->get();

        // Get the average review star count for the provider (if no review, return 0.0)
        $avgReview = HandymanReview::where('handyman_id', $id)->avg('star_count') ?? 0.0;



        // // Fetch the counts for each booking status for the provider
        $statusCounts = [
            'Pending' => BookingOrders::where('work_assign_id', $id)->where('handyman_status', 0)->count(),
            'Accepted' => BookingOrders::where('work_assign_id', $id)->where('handyman_status', 2)->count(),
            'Rejected' => BookingOrders::where('work_assign_id', $id)->where('handyman_status', 3)->count(),
            'Completed' => BookingOrders::where('work_assign_id', $id)->where('handyman_status', 6)->count(),
        ];


        // Month names
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // If a year is provided, use it; otherwise, use the current year
        $year = $year ?: date('Y');

        // Fetch monthly earnings for the provider based on the selected year
        $monthlyEarnings = [];
        foreach ($monthNames as $index => $month) {
            $earnings = BookingHandymanHistory::where('handyman_id', $id)
            ->whereYear('created_at', $year)  // Filter by selected year
            ->whereMonth(
                'created_at',
                $index + 1
            )
                ->sum('amount'); // Sum the earnings for the provider in that month

            // Add the earnings for the month to the data array
            $monthlyEarnings[] = [
                'x' => $month,
                'Earnings' => $earnings ?? 0, // Default to 0 if no earnings for that month
            ];
        }

        // Get the available years based on the created_at column in BookingHandymanHistory for this provider
        $availableYears = BookingHandymanHistory::where('handyman_id', $id)
        ->selectRaw('YEAR(created_at) as year')  // Get the year part of created_at
        ->distinct()  // Make sure we only get distinct years
        ->orderByDesc('year')  // Order from most recent to oldest
        ->pluck('year');


        // Fetch average review ratings for each provider
        $userIds = HandymanReview::where('handyman_id', $id)->pluck('user_id')->filter(); // Get all provider IDs

        $avgUsersReviews = ServiceProof::whereIn('user_id', $userIds)->selectRaw('user_id, COALESCE(AVG(rev_star), 0) as avg_star')->groupBy('user_id')->pluck('avg_star', 'user_id'); // Fetch avg star rating per provider

        // Fetch the latest customers dynamically through handyman_id
        $latestReviews = HandymanReview::where('handyman_id', $id)
        ->with('user') // Eager load the user relationship
        ->get()
            ->filter(fn($review) => $review->user !== null) // Ensure user exists
            ->map(function ($review) use ($avgUsersReviews) {
                return [
                    'id' => $review->user->id,
                    'firstname' => $review->user->firstname ?? '',
                    'lastname' => $review->user->lastname ?? '',
                    'email' => $review->user->email ?? '',
                    'profile_pic' => $review->user->profile_pic ?? 'default_user.jpg', // Fallback for profile picture
                    'star_count' => $review->star_count,
                    'text' => $review->text ?? '', // Fallback for review text
                    'created_at' => Carbon::parse($review->created_at)->format('d F, Y'),
                    'avg_users_review' => number_format($avgUsersReviews[$review->user->id] ?? 0.0, 1), // Fetch avg review rating
                ];
            });


        // Pass the values to the view
        return view('providerhandyman-view', compact('user', 'totalBooking', 'WalletBalance', 'statusCounts', 'WithdrawnBalance', 'totalProviderBalance', 'payouts', 'monthlyEarnings', 'availableYears', 'defaultCurrency', 'avgReview', 'latestReviews'));
    }



    // getProviderHandymanMonthlyEarnings
    public function getProviderHandymanMonthlyEarnings($id, $year)
    {
        // Month names
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Fetch monthly earnings for the provider based on the selected year
        $monthlyEarnings = [];
        foreach ($monthNames as $index => $month) {
            $earnings = BookingHandymanHistory::where('handyman_id', $id)
                ->whereYear('created_at', $year)  // Filter by selected year
                ->whereMonth('created_at', $index + 1)
                ->sum('amount'); // Sum the earnings for the provider in that month

            // Add the earnings for the month to the data array
            $monthlyEarnings[] = [
                'x' => $month,
                'Earnings' => $earnings ?? 0, // Default to 0 if no earnings for that month
            ];
        }

        // Return the earnings data as JSON
        return response()->json(['monthlyEarnings' => $monthlyEarnings]);
    }


    // deleteProviderHandyman
    public function deleteProviderHandyman($id)
    {
        User::find($id)->delete();
        return response()->json(['message' => 'Handyman deleted successfully', 'id' => $id]);
    }


    // ChangeProviderHandymanListBlocked
    public function ChangeProviderHandymanListBlocked($id)
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
