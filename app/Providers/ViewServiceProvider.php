<?php

namespace App\Providers;

use App\Models\CartItem;
use App\Models\ProviderReqModel;
use App\Models\Service;
use App\Models\SiteSetup;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorStore;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;



class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            try {
                // Fetch the default currency from SiteSetup
                $defaultCurrency = SiteSetup::first()?->default_currency ?? '₹'; // Fallback to a default currency if null

                // Fetch provider pending withdrawal requests (status = 0)
                $withdrawRequests = ProviderReqModel::where('status', 0)
                    ->with('vendor:id,firstname,lastname,profile_pic')
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Fetch unread provider pending withdrawal requests (status = 0, is_read = 0)
                $withdrawRequestsCount = ProviderReqModel::where('status', 0)
                    ->where('is_read', 0)
                    ->with('vendor:id,firstname,lastname,profile_pic')
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Format withdrawal notifications
                $withdrawalFormattedNotifications = $withdrawRequests->map(function ($request) use ($defaultCurrency) {
                    if ($request->vendor) {
                        return [
                            'title' => $request->vendor->firstname . ' ' . $request->vendor->lastname,
                            'message' => "A withdrawal request for {$defaultCurrency}{$request->amount} has been received from {$request->vendor->firstname} {$request->vendor->lastname}.",
                            'time' => $request->created_at->diffForHumans(),
                            'id' => $request->id,
                            'profile_pic' => $request->vendor->profile_pic ? url("images/user/{$request->vendor->profile_pic}") : '',
                        ];
                    }
                    return null;
                })->filter();

                // Share with the view
                $view->with([
                    'withdrawalNotifications' => $withdrawalFormattedNotifications,
                    'notificationCount' => count($withdrawRequestsCount),
                ]);
            } catch (\Exception $e) {
                // Redirect to home page if database connection fails
                if (request()->isMethod('post')) {
                    redirect('/')->send();
                }

                // Share empty defaults in case of failure
                $view->with([
                    'withdrawalNotifications' => [],
                    'notificationCount' => 0,
                ]);
            }
        });
    }
}
