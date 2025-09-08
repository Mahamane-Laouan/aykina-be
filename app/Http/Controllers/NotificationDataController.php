<?php

namespace App\Http\Controllers;

use App\Models\ProviderReqModel;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class NotificationDataController extends Controller
{
    // index
    public function index(Request $request)
    {
        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;


        // Fetch provider pending withdrawal requests (status = 0)
        $withdrawRequests = ProviderReqModel::where('status', 0)
            ->with('vendor:id,firstname,lastname,profile_pic,is_color')  // Include is_color in the query
            ->orderBy('created_at', 'desc')
            ->take(20) // Limit to latest 20 entries
            ->get();


        $withdrawalFormattedNotifications = $withdrawRequests->map(function ($request) use ($defaultCurrency) {
            if ($request->vendor) {
                return [
                    'title' => $request->vendor->firstname . ' ' . $request->vendor->lastname,
                    'message' => "A withdrawal request for {$defaultCurrency}{$request->amount} has been received from {$request->vendor->firstname} {$request->vendor->lastname}.",
                    'time' => $request->created_at->diffForHumans(),
                    'id' => $request->id,
                    'profile_pic' => $request->vendor->profile_pic ? url("images/user/{$request->vendor->profile_pic}") : '',
                    'is_color' => $request->is_color,
                ];
            }
            return null;
        })->filter(); // Remove null values in case vendor doesn't exist


        return view('notificationdata-list', compact('withdrawalFormattedNotifications'));
    }


    public function markNotificationsAsRead()
    {

        ProviderReqModel::where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['message' => 'Notifications marked as read successfully.']);
    }


    public function updateColor($id)
    {
        // Check if the notification exists in ProviderReqModel's notifications
        $providerNotification = ProviderReqModel::find($id);
        if ($providerNotification && $providerNotification->is_color !== 1) {
            $providerNotification->is_color = 1;
            $providerNotification->save();
        }

        return response()->json(['success' => true]);
    }
}
