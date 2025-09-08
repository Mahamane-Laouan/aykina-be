<?php

namespace App\Http\Controllers;

use App\Models\ProviderEmailAssignHandyman;
use App\Models\ProviderEmailBookingAccepted;
use App\Models\ProviderEmailBookingCompleted;
use App\Models\ProviderEmailBookingHold;
use App\Models\ProviderEmailBookingRejected;
use App\Models\ProviderEmailForgotPassword;
use App\Models\ProviderEmailOrderDelivered;
use App\Models\ProviderEmailOrderInProgress;
use App\Models\GeneralSettings;
use App\Models\ProviderEmailOrderReceived;
use App\Models\ProviderEmailOtpVerify;
use App\Models\ProviderEmailPaymentRequestReceived;
use App\Models\ProviderEmailPaymentRequestSent;
use App\Models\ProviderEmailRejectHandyman;
use App\Models\ProviderEmailReviewReceived;
use Illuminate\Http\Request;

class ProviderEmailController extends Controller
{
    // index
    public function index()
    {
        $generalSettings = GeneralSettings::first()->name;
        $emailproviderotpverify = ProviderEmailOtpVerify::first();
        $emailproviderforgotpassword = ProviderEmailForgotPassword::first();
        $emailproviderorderreceived = ProviderEmailOrderReceived::first();
        $emailproviderbookingaccepted = ProviderEmailBookingAccepted::first();
        $emailproviderbookingrejected = ProviderEmailBookingRejected::first();
        $emailproviderassignhandyman = ProviderEmailAssignHandyman::first();
        $emailproviderrejecthandyman = ProviderEmailRejectHandyman::first();
        $emailproviderorderinprogress = ProviderEmailOrderInProgress::first();
        $emailproviderorderdelivered = ProviderEmailOrderDelivered::first();
        $emailproviderbookinghold = ProviderEmailBookingHold::first();
        $emailproviderbookingcompleted = ProviderEmailBookingCompleted::first();
        $emailproviderpaymentreceived = ProviderEmailPaymentRequestReceived::first();
        $emailproviderpaymentsent = ProviderEmailPaymentRequestSent::first();
        $emailproviderreviewreceived = ProviderEmailReviewReceived::first();


        return view(
            'provideremail-detail',
            compact('emailproviderotpverify', 'emailproviderforgotpassword', 'emailproviderorderreceived', 'emailproviderbookingaccepted', 'emailproviderbookingrejected', 'emailproviderassignhandyman', 'emailproviderrejecthandyman', 'emailproviderorderinprogress', 'emailproviderorderdelivered', 'emailproviderbookinghold', 'emailproviderbookingcompleted', 'emailproviderpaymentreceived', 'emailproviderpaymentsent', 'emailproviderreviewreceived', 'generalSettings')
        );
    }


    // emailProviderOtpVerify
    public function emailProviderOtpVerify(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailOtpVerify::first() ?? new ProviderEmailOtpVerify();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderOtpVerify
    public function changeEmailProviderOtpVerify(Request $request, $id)
    {
        $status = ProviderEmailOtpVerify::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderForgotPassword
    public function emailProviderForgotPassword(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailForgotPassword::first() ?? new ProviderEmailForgotPassword();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderForgotPassword
    public function changeEmailProviderForgotPassword(Request $request, $id)
    {
        $status = ProviderEmailForgotPassword::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderOrderReceived
    public function emailProviderOrderReceived(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailOrderReceived::first() ?? new ProviderEmailOrderReceived();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderOrderReceived
    public function changeEmailProviderOrderReceived(Request $request, $id)
    {
        $status = ProviderEmailOrderReceived::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderBookingAccepted
    public function emailProviderBookingAccepted(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailBookingAccepted::first() ?? new ProviderEmailBookingAccepted();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderBookingAccepted
    public function changeEmailProviderBookingAccepted(Request $request, $id)
    {
        $status = ProviderEmailBookingAccepted::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderBookingRejected
    public function emailProviderBookingRejected(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailBookingRejected::first() ?? new ProviderEmailBookingRejected();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderBookingRejected
    public function changeEmailProviderBookingRejected(Request $request, $id)
    {
        $status = ProviderEmailBookingRejected::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderAssignHandyman
    public function emailProviderAssignHandyman(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailAssignHandyman::first() ?? new ProviderEmailAssignHandyman();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderAssignHandyman
    public function changeEmailProviderAssignHandyman(Request $request, $id)
    {
        $status = ProviderEmailAssignHandyman::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderRejectHandyman
    public function emailProviderRejectHandyman(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailRejectHandyman::first() ?? new ProviderEmailRejectHandyman();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderRejectHandyman
    public function changeEmailProviderRejectHandyman(Request $request, $id)
    {
        $status = ProviderEmailRejectHandyman::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderOrderInProgress
    public function emailProviderOrderInProgress(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailOrderInProgress::first() ?? new ProviderEmailOrderInProgress();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderOrderInProgress
    public function changeEmailProviderOrderInProgress(Request $request, $id)
    {
        $status = ProviderEmailOrderInProgress::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderOrderDelivered
    public function emailProviderOrderDelivered(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailOrderDelivered::first() ?? new ProviderEmailOrderDelivered();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderOrderDelivered
    public function changeEmailProviderOrderDelivered(Request $request, $id)
    {
        $status = ProviderEmailOrderDelivered::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderBookingHold
    public function emailProviderBookingHold(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailBookingHold::first() ?? new ProviderEmailBookingHold();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderBookingHold
    public function changeEmailProviderBookingHold(Request $request, $id)
    {
        $status = ProviderEmailBookingHold::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderBookingCompleted
    public function emailProviderBookingCompleted(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailBookingCompleted::first() ?? new ProviderEmailBookingCompleted();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderBookingCompleted
    public function changeEmailProviderBookingCompleted(Request $request, $id)
    {
        $status = ProviderEmailBookingCompleted::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderPaymentReceived
    public function emailProviderPaymentReceived(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailPaymentRequestReceived::first() ?? new ProviderEmailPaymentRequestReceived();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderPaymentReceived
    public function changeEmailProviderPaymentReceived(Request $request, $id)
    {
        $status = ProviderEmailPaymentRequestReceived::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderPaymentSent
    public function emailProviderPaymentSent(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailPaymentRequestSent::first() ?? new ProviderEmailPaymentRequestSent();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderPaymentSent
    public function changeEmailProviderPaymentSent(Request $request, $id)
    {
        $status = ProviderEmailPaymentRequestSent::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailProviderReviewReceived
    public function emailProviderReviewReceived(Request $request)
    {
        // dd($request->all());
        $rules = [
            'logo' => 'nullable|image',
            'title' => 'required',
            'body' => 'required',
            'section_text' => 'required',
            'copyright_content' => 'required',
        ];

        $customMessages = [
            'logo.image' => 'Please upload a valid image for the logo.',
            'title.required' => 'Please enter title.',
            'body.required' => 'Please enter mail body.',
            'section_text.required' => 'Please enter section text.',
            'copyright_content.required' => 'Please enter copyright content.',
        ];

        $this->validate($request, $rules, $customMessages);

        $email = ProviderEmailReviewReceived::first() ?? new ProviderEmailReviewReceived();

        $email->title = $request->input('title');
        $email->body = $request->input('body');
        $email->section_text = $request->input('section_text');
        $email->privacy_policy = $request->has('privacy_policy') ? 1 : 0;
        $email->refund_policy = $request->has('refund_policy') ? 1 : 0;
        $email->cancellation_policy = $request->has('cancellation_policy') ? 1 : 0;
        $email->contact_us = $request->has('contact_us') ? 1 : 0;
        $email->twitter = $request->has('twitter') ? 1 : 0;
        $email->linkedIn = $request->has('linkedIn') ? 1 : 0;
        $email->instagram = $request->has('instagram') ? 1 : 0;
        $email->facebook = $request->has('facebook') ? 1 : 0;
        $email->copyright_content = $request->input('copyright_content');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/socialmedialogo'), $imageName);
            $email->logo = $imageName;
        }

        $email->save();

        return redirect()->route('provideremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailProviderReviewReceived
    public function changeEmailProviderReviewReceived(Request $request, $id)
    {
        $status = ProviderEmailReviewReceived::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }
}
