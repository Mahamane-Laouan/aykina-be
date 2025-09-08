<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\AvailablePayment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

  // StripePayment
  public function index()
  {
    $payments = AvailablePayment::all();
    return view('content.apps.payments', compact('payments'));
  }

  public function paymentSave(Request $request)
  {
    $rules = [
      'publish_key' => 'required',
      'secret_key' => 'required',
      'payment_mode' => 'required',
    ];

    $customMessages = [
      'publish_key.required' => 'Please enter stripe key.',
      'secret_key.required' => 'Please enter stripe secret key.',
      'payment_mode.required' => 'Please select a payment mode.',
    ];

    $this->validate($request, $rules, $customMessages);

    // Check if payment_mode already exists
    $existingPayment = AvailablePayment::where('payment_mode', $request->input('payment_mode'))->first();

    if ($existingPayment) {
      $existingPayment->publish_key = $request->input('publish_key');
      $existingPayment->secret_key = $request->input('secret_key');
      $existingPayment->status = $request->has('status') ? 1 : 0;
      $existingPayment->save();
      $message = 'Stripe Payment details updated successfully';
    } else {

      $payment = new AvailablePayment;
      $payment->publish_key = $request->input('publish_key');
      $payment->secret_key = $request->input('secret_key');
      $payment->payment_mode = $request->input('payment_mode');
      $payment->status = $request->has('status') ? 1 : 0;
      $payment->save();
      $message = 'Stripe Payment done successfully';
    }

    return redirect()->route('payments')->with('message', $message);
  }


  // RazorPayment
  public function razorPayment()
  {
    $payments = AvailablePayment::all();
    return view('content.apps.razor-payment', compact('payments'));
  }

  public function razorPaymentSave(Request $request)
  {
    $rules = [
      'publish_key' => 'required',
      'secret_key' => 'required',
      'payment_mode' => 'required',
    ];

    $customMessages = [
      'publish_key.required' => 'Please enter razor key.',
      'secret_key.required' => 'Please enter razor secret key.',
      'payment_mode.required' => 'Please select a payment mode.',
    ];

    $this->validate($request, $rules, $customMessages);

    // Check if payment_mode already exists
    $existingPayment = AvailablePayment::where('payment_mode', $request->input('payment_mode'))->first();

    if ($existingPayment) {
      $existingPayment->publish_key = $request->input('publish_key');
      $existingPayment->secret_key = $request->input('secret_key');
      $existingPayment->status = $request->has('status') ? 1 : 0;
      $existingPayment->save();
      $message = 'Razor Payment details updated successfully';
    } else {

      $payment = new AvailablePayment;
      $payment->publish_key = $request->input('publish_key');
      $payment->secret_key = $request->input('secret_key');
      $payment->payment_mode = $request->input('payment_mode');
      $payment->status = $request->has('status') ? 1 : 0;
      $payment->save();
      $message = 'Razor Payment done successfully';
    }

    return redirect()->route('razor-payment')->with('message', $message);
  }


  // FlutterwavePayment
  public function flutterwavePayment()
  {
    $payments = AvailablePayment::all();
    return view('content.apps.flutterwave-payment', compact('payments'));
  }

  public function flutterwavePaymentSave(Request $request)
  {
    $rules = [
      'publish_key' => 'required',
      'secret_key' => 'required',
      'payment_mode' => 'required',
    ];

    $customMessages = [
      'publish_key.required' => 'Please enter flutterwave key.',
      'secret_key.required' => 'Please enter flutterwave secret key.',
      'payment_mode.required' => 'Please select a payment mode.',
    ];

    $this->validate($request, $rules, $customMessages);

    // Check if payment_mode already exists
    $existingPayment = AvailablePayment::where('payment_mode', $request->input('payment_mode'))->first();

    if ($existingPayment) {
      $existingPayment->publish_key = $request->input('publish_key');
      $existingPayment->secret_key = $request->input('secret_key');
      $existingPayment->status = $request->has('status') ? 1 : 0;
      $existingPayment->save();
      $message = 'Flutterwave Payment details updated successfully';
    } else {

      $payment = new AvailablePayment;
      $payment->publish_key = $request->input('publish_key');
      $payment->secret_key = $request->input('secret_key');
      $payment->payment_mode = $request->input('payment_mode');
      $payment->status = $request->has('status') ? 1 : 0;
      $payment->save();
      $message = 'Flutterwave Payment done successfully';
    }

    return redirect()->route('flutterwave-payment')->with('message', $message);
  }


  // PayPal
  public function paypal()
  {
    $payments = AvailablePayment::all();
    return view('content.apps.paypal', compact('payments'));
  }

  public function paypalPaymentSave(Request $request)
  {
    $rules = [
      'publish_key' => 'required',
      'secret_key' => 'required',
      'payment_mode' => 'required',
    ];

    $customMessages = [
      'publish_key.required' => 'Please enter paypal client id.',
      'secret_key.required' => 'Please enter paypal secret key.',
      'payment_mode.required' => 'Please select a payment mode.',
    ];

    $this->validate($request, $rules, $customMessages);

    // Check if payment_mode already exists
    $existingPayment = AvailablePayment::where('payment_mode', $request->input('payment_mode'))->first();

    if ($existingPayment) {
      $existingPayment->publish_key = $request->input('publish_key');
      $existingPayment->secret_key = $request->input('secret_key');
      $existingPayment->status = $request->has('status') ? 1 : 0;
      $existingPayment->save();
      $message = 'PayPal Payment details updated successfully';
    } else {

      $payment = new AvailablePayment;
      $payment->publish_key = $request->input('publish_key');
      $payment->secret_key = $request->input('secret_key');
      $payment->payment_mode = $request->input('payment_mode');
      $payment->status = $request->has('status') ? 1 : 0;
      $payment->save();
      $message = 'PayPal Payment done successfully';
    }

    return redirect()->route('paypal')->with('message', $message);
  }


  // Cheque Payment
  public function chequePayment()
  {
    $payments = AvailablePayment::all();
    return view('content.apps.cheque-payment', compact('payments'));
  }


  public function ChequePaymentSave(Request $request)
  {
    // Check if payment_mode already exists
    $existingPayment = AvailablePayment::where('payment_mode', $request->input('payment_mode'))->first();

    if ($existingPayment) {
      $existingPayment->status = $request->has('status') ? 1 : 0;
      $existingPayment->save();
      $message = 'Cheque Payment details updated successfully';
    } else {

      $payment = new AvailablePayment;
      $payment->payment_mode = $request->input('payment_mode');
      $payment->status = $request->has('status') ? 1 : 0;
      $payment->save();
      $message = 'Cheque Payment done successfully';
    }

    return redirect()->route('cheque-payment')->with('message', $message);
  }

  // CODPayment
  public function codPayment()
  {
    $payments = AvailablePayment::all();
    return view('content.apps.cod-payment', compact('payments'));
  }

  public function codPaymentSave(Request $request)
  {
    // Check if payment_mode already exists
    $existingPayment = AvailablePayment::where('payment_mode', $request->input('payment_mode'))->first();

    if ($existingPayment) {
      $existingPayment->status = $request->has('status') ? 1 : 0;
      $existingPayment->save();
      $message = 'COD Payment details updated successfully';
    } else {

      $payment = new AvailablePayment;
      $payment->payment_mode = $request->input('payment_mode');
      $payment->status = $request->has('status') ? 1 : 0;
      $payment->save();
      $message = 'COD Payment done successfully';
    }

    return redirect()->route('cod-payment')->with('message', $message);
  }
}
