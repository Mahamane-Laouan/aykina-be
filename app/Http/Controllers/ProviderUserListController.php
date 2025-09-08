<?php

namespace App\Http\Controllers;

use App\Models\BookingOrders;
use App\Models\OrdersModel;
use App\Models\ServiceLike;
use App\Models\ServiceReview;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderUserListController extends Controller
{
    // viewProviderUser
    public function viewProviderUser($id)
    {
        // Fetch the user details
        $user = User::findOrFail($id);

        $defaultCurrency = SiteSetup::first()->default_currency;

        $totalBooking = OrdersModel::where('user_id', $id)->count() ?? 0;

        $WalletBalance = User::where('id', $id)->sum('wallet_balance') ?? 0;

        $totalreviews = ServiceReview::where('user_id', $id)->count() ?? 0;

        $totallikes = ServiceLike::where('user_id', $id)->count() ?? 0;

        // Fetch the user's orders
        $orders = OrdersModel::with(['user', 'provider', 'service'])
            ->where('user_id', $id)
            ->get();



        // Pass the values to the view
        return view('provideruser-view', compact('user', 'totalBooking', 'WalletBalance', 'totalreviews', 'totallikes', 'orders', 'defaultCurrency'));
    }
}
