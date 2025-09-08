<?php

namespace App\Http\Controllers;

use App\Models\HandymanEmailAssignforOrder;
use App\Models\HandymanEmailBookingAccepted;
use App\Models\HandymanEmailBookingCompleted;
use App\Models\HandymanEmailBookingRejected;
use App\Models\HandymanEmailForgotPassword;
use App\Models\GeneralSettings;
use App\Models\HandymanEmailOtpVerify;
use App\Models\HandymanEmailReviewReceived;
use Illuminate\Http\Request;

class HandymanEmailController extends Controller
{
    // index
    public function index()
    {
        $generalSettings = GeneralSettings::first()->name;
        $emailhandymanotpverify = HandymanEmailOtpVerify::first();
        $emailhandymanforgotpassword = HandymanEmailForgotPassword::first();
        $emailhandymanassignfororder = HandymanEmailAssignforOrder::first();
        $emailhandymanacceptbooking = HandymanEmailBookingAccepted::first();
        $emailhandymanrejectbooking = HandymanEmailBookingRejected::first();
        $emailhandymancompledtedbooking = HandymanEmailBookingCompleted::first();
        $emailhandymanreviewreceived = HandymanEmailReviewReceived::first();

        return view(
            'handymanemail-detail',
            compact('emailhandymanotpverify', 'emailhandymanforgotpassword', 'emailhandymanassignfororder', 'emailhandymanacceptbooking', 'emailhandymanrejectbooking', 'emailhandymancompledtedbooking', 'emailhandymanreviewreceived', 'generalSettings')
        );
    }


    // emailHandymanOtpVerify
    public function emailHandymanOtpVerify(Request $request)
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

        $email = HandymanEmailOtpVerify::first() ?? new HandymanEmailOtpVerify();

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

        return redirect()->route('handymanemail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailHandymanOtpVerify
    public function changeEmailHandymanOtpVerify(Request $request, $id)
    {
        $status = HandymanEmailOtpVerify::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailHandymanForgotPassword
    public function emailHandymanForgotPassword(Request $request)
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

        $email = HandymanEmailForgotPassword::first() ?? new HandymanEmailForgotPassword();

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

        return redirect()->route('handymanemail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailHandymanForgotPassword
    public function changeEmailHandymanForgotPassword(Request $request, $id)
    {
        $status = HandymanEmailForgotPassword::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailHandymanAssignForOrder
    public function emailHandymanAssignForOrder(Request $request)
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

        $email = HandymanEmailAssignforOrder::first() ?? new HandymanEmailAssignforOrder();

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

        return redirect()->route('handymanemail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailHandymanAssignForOrder
    public function changeEmailHandymanAssignForOrder(Request $request, $id)
    {
        $status = HandymanEmailAssignforOrder::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailHandymanAcceptBooking
    public function emailHandymanAcceptBooking(Request $request)
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

        $email = HandymanEmailBookingAccepted::first() ?? new HandymanEmailBookingAccepted();

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

        return redirect()->route('handymanemail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailHandymanAcceptBooking
    public function changeEmailHandymanAcceptBooking(Request $request, $id)
    {
        $status = HandymanEmailBookingAccepted::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailHandymanRejectBooking
    public function emailHandymanRejectBooking(Request $request)
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

        $email = HandymanEmailBookingRejected::first() ?? new HandymanEmailBookingRejected();

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

        return redirect()->route('handymanemail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailHandymanRejectBooking
    public function changeEmailHandymanRejectBooking(Request $request, $id)
    {
        $status = HandymanEmailBookingRejected::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailHandymanCompletedBooking
    public function emailHandymanCompletedBooking(Request $request)
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

        $email = HandymanEmailBookingCompleted::first() ?? new HandymanEmailBookingCompleted();

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

        return redirect()->route('handymanemail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailHandymanCompletedBooking
    public function changeEmailHandymanCompletedBooking(Request $request, $id)
    {
        $status = HandymanEmailBookingCompleted::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailHandymanReviewReceived
    public function emailHandymanReviewReceived(Request $request)
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

        $email = HandymanEmailReviewReceived::first() ?? new HandymanEmailReviewReceived();

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

        return redirect()->route('handymanemail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailHandymanReviewReceived
    public function changeEmailHandymanReviewReceived(Request $request, $id)
    {
        $status = HandymanEmailReviewReceived::find($id);

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
