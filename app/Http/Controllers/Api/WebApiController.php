<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HandymanEmailAssignforOrder;
use App\Models\HandymanEmailBookingAccepted;
use App\Models\HandymanEmailBookingCompleted;
use App\Models\HandymanEmailBookingRejected;
use App\Models\HandymanEmailForgotPassword;
use App\Models\HandymanEmailOtpVerify;
use App\Models\HandymanEmailReviewReceived;
use App\Models\ProviderEmailAssignHandyman;
use App\Models\ProviderEmailBookingAccepted;
use App\Models\ProviderEmailBookingCompleted;
use App\Models\ProviderEmailBookingHold;
use App\Models\ProviderEmailBookingRejected;
use App\Models\ProviderEmailForgotPassword;
use App\Models\UserCancelledbyProvider;
use App\Models\ProviderEmailOrderDelivered;
use App\Models\ProviderEmailOrderInProgress;
use App\Models\ProviderEmailOrderReceived;
use App\Models\ProviderEmailOtpVerify;
use App\Models\ProviderEmailPaymentRequestReceived;
use App\Models\ProviderEmailPaymentRequestSent;
use App\Models\ProviderEmailRejectHandyman;
use App\Models\ProviderEmailReviewReceived;
use App\Models\UserEmailBookingAccepted;
use App\Models\UserEmailBookingCancelled;
use App\Models\UserEmailBookingHold;
use App\Models\UserEmailBookingInProgress;
use App\Models\UserEmailBookingRejected;
use App\Models\UserEmailForgotPassword;
use App\Models\UserEmailOrderPlacedService;
use App\Models\UserEmailOtpVerify;
use App\Models\UserEmailProductDelivered;
use App\Models\UserRefundbyProvider;
use App\Models\UserEmailProductInProgress;
use Illuminate\Http\Request;

class WebApiController extends Controller
{
    // User
    // showUserEmailUserOtpVerify
    public function showUserEmailUserOtpVerify()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailOtpVerify::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserForgotPassword
    public function showUserEmailUserForgotPassword()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailForgotPassword::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserOrderPlacedService
    public function showUserEmailUserOrderPlacedService()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailOrderPlacedService::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserBookingAccepted
    public function showUserEmailUserBookingAccepted()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailBookingAccepted::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserBookingInProgress
    public function showUserEmailUserBookingInProgress()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailBookingInProgress::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserBookingHold
    public function showUserEmailUserBookingHold()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailBookingHold::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserBookingCancelled
    public function showUserEmailUserBookingCancelled()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailBookingCancelled::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserBookingRejected
    public function showUserEmailUserBookingRejected()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailBookingRejected::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserProductinProgress
    public function showUserEmailUserProductinProgress()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailProductInProgress::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserProductDelivered
    public function showUserEmailUserProductDelivered()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserEmailProductDelivered::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }

    // showUserEmailUserCancelledbyProvider
    public function showUserEmailUserCancelledbyProvider()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserCancelledbyProvider::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }




    // Provider
    // showProviderEmailProviderOtpVerify
    public function showProviderEmailProviderOtpVerify()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailOtpVerify::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderForgotPassword
    public function showProviderEmailProviderForgotPassword()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailForgotPassword::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderOrderReceived
    public function showProviderEmailProviderOrderReceived()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailOrderReceived::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderBookingAccepted
    public function showProviderEmailProviderBookingAccepted()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailBookingAccepted::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderBookingRejected
    public function showProviderEmailProviderBookingRejected()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailBookingRejected::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderAssignHandyman
    public function showProviderEmailProviderAssignHandyman()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailAssignHandyman::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderRejectHandyman
    public function showProviderEmailProviderRejectHandyman()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailRejectHandyman::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderOrderInProgress
    public function showProviderEmailProviderOrderInProgress()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailOrderInProgress::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderOrderDelivered
    public function showProviderEmailProviderOrderDelivered()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailOrderDelivered::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderBookingHold
    public function showProviderEmailProviderBookingHold()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailBookingHold::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderBookingCompleted
    public function showProviderEmailProviderBookingCompleted()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailBookingCompleted::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderPaymentReceived
    public function showProviderEmailProviderPaymentReceived()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailPaymentRequestReceived::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderPaymentSent
    public function showProviderEmailProviderPaymentSent()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailPaymentRequestSent::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showProviderEmailProviderReviewReceived
    public function showProviderEmailProviderReviewReceived()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = ProviderEmailReviewReceived::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showUserEmailUserRefundbyProvider
    public function showUserEmailUserRefundbyProvider()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = UserRefundbyProvider::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }








    // Handyman
    // showHandymanEmailHandymanOtpVerify
    public function showHandymanEmailHandymanOtpVerify()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = HandymanEmailOtpVerify::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showHandymanEmailHandymanForgotPassword
    public function showHandymanEmailHandymanForgotPassword()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = HandymanEmailForgotPassword::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showHandymanEmailHandymanAssignforOrder
    public function showHandymanEmailHandymanAssignforOrder()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = HandymanEmailAssignforOrder::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showHandymanEmailHandymanBookingAccepted
    public function showHandymanEmailHandymanBookingAccepted()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = HandymanEmailBookingAccepted::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showHandymanEmailHandymanBookingRejected
    public function showHandymanEmailHandymanBookingRejected()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = HandymanEmailBookingRejected::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showHandymanEmailHandymanBookingCompleted
    public function showHandymanEmailHandymanBookingCompleted()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = HandymanEmailBookingCompleted::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }


    // showHandymanEmailHandymanReviewReceived
    public function showHandymanEmailHandymanReviewReceived()
    {
        $baseUrl = rtrim(asset('images/socialmedialogo/'), '/') . '/'; // Ensure proper trailing slash
        $emails = HandymanEmailReviewReceived::get()->map(function ($email) use ($baseUrl) {
            $email->logo = $baseUrl . $email->logo; // Prepend the base URL to the logo
            return $email;
        });

        return response([
            'success' => true,
            'message' => 'Success...!',
            'data' => $emails,
        ]);
    }
}
