<?php

namespace App\Http\Controllers;

use App\Models\PaymentGatewayKey;
use Illuminate\Http\Request;

class PaymentConfigurationController extends Controller
{
    // index
    public function index(Request $request)
    {
        $razorpay = PaymentGatewayKey::find(1);
        $flutterwave = PaymentGatewayKey::find(2);
        $stripe = PaymentGatewayKey::find(3);
        $paypal = PaymentGatewayKey::find(4);
        $googlepay = PaymentGatewayKey::find(5);
        $wallet = PaymentGatewayKey::find(6);
        $applepay = PaymentGatewayKey::find(7);


        return view('payment-configuration', compact('razorpay', 'flutterwave', 'stripe', 'paypal', 'googlepay', 'wallet', 'applepay'));
    }


    // saveRazorPay
    public function saveRazorPay(Request $request)
    {
        $data = PaymentGatewayKey::find(1) ?? new PaymentGatewayKey();

        $data->public_key = $request->razorpay_public_key;
        $data->secret_key = $request->razorpay_secret_key;
        $data->mode = $request->razorpay_mode; // Update the mode dynamically
        $data->status = $request->razorpay_enabled ? 1 : 0; // Update status based on checkbox

        $data->save();

        return redirect()->route('payment-configuration')->with('message', 'RazorPay configuration updated successfully.');
    }


    // saveFlutterWave
    public function saveFlutterWave(Request $request)
    {
        $data = PaymentGatewayKey::find(2) ?? new PaymentGatewayKey();

        $data->public_key = $request->flutterwave_public_key;
        $data->secret_key = $request->flutterwave_secret_key;
        $data->mode = $request->flutterwave_mode; // Update the mode dynamically
        $data->status = $request->flutterwave_enabled ? 1 : 0; // Update status based on checkbox

        $data->save();

        return redirect()->route('payment-configuration')->with('message', 'FlutterWave configuration updated successfully.');
    }


    // saveStripe
    public function saveStripe(Request $request)
    {
        $data = PaymentGatewayKey::find(3) ?? new PaymentGatewayKey();

        $data->public_key = $request->stripe_public_key;
        $data->secret_key = $request->stripe_secret_key;
        $data->mode = $request->stripe_mode; // Update the mode dynamically
        $data->status = $request->stripe_enabled ? 1 : 0; // Update status based on checkbox

        $data->save();

        return redirect()->route('payment-configuration')->with('message', 'Stripe configuration updated successfully.');
    }


    // savePayPal
    public function savePayPal(Request $request)
    {
        $data = PaymentGatewayKey::find(4) ?? new PaymentGatewayKey();

        $data->public_key = $request->paypal_public_key;
        $data->secret_key = $request->paypal_secret_key;
        $data->mode = $request->paypal_mode; // Update the mode dynamically
        $data->status = $request->paypal_enabled ? 1 : 0; // Update status based on checkbox

        $data->save();

        return redirect()->route('payment-configuration')->with('message', 'PayPal configuration updated successfully.');
    }


    // saveGooglePay
    public function saveGooglePay(Request $request)
    {
        $data = PaymentGatewayKey::find(5) ?? new PaymentGatewayKey();

        $data->public_key = $request->googlepay_public_key;
        $data->secret_key = $request->googlepay_secret_key;
        $data->mode = $request->googlepay_mode; // Update the mode dynamically
        $data->status = $request->googlepay_enabled ? 1 : 0; // Update status based on checkbox
        $data->country_code = $request->country_code;
        $data->currency_code = $request->currency_code;

        $data->save();

        return redirect()->route('payment-configuration')->with('message', 'Google Pay configuration updated successfully.');
    }


    // saveWallet
    public function saveWallet(Request $request)
    {
        $data = PaymentGatewayKey::find(6) ?? new PaymentGatewayKey();

        $data->mode = $request->wallet_mode; // Update the mode dynamically
        $data->status = $request->wallet_enabled ? 1 : 0; // Update status based on checkbox

        $data->save();

        return redirect()->route('payment-configuration')->with('message', 'Wallet updated successfully.');
    }



    // saveApplePay
    public function saveApplePay(Request $request)
    {
        $data = PaymentGatewayKey::find(7) ?? new PaymentGatewayKey();

        $data->public_key = $request->applepay_public_key;
        $data->secret_key = $request->applepay_secret_key;
        $data->mode = $request->applepay_mode; // Update the mode dynamically
        $data->status = $request->applepay_enabled ? 1 : 0; // Update status based on checkbox
        $data->country_code = $request->country_code;
        $data->currency_code = $request->currency_code;

        $data->save();

        return redirect()->route('payment-configuration')->with('message', 'Apple Pay configuration updated successfully.');
    }
}
