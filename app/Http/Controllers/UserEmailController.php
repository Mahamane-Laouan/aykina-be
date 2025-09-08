<?php

namespace App\Http\Controllers;

use App\Models\UserEmailBookingAccepted;
use App\Models\UserEmailBookingCancelled;
use App\Models\UserEmailBookingHold;
use App\Models\UserEmailBookingInProgress;
use App\Models\UserEmailBookingRejected;
use App\Models\UserEmailForgotPassword;
use App\Models\UserEmailOrderPlacedService;
use App\Models\UserEmailOtpVerify;
use App\Models\GeneralSettings;
use App\Models\UserEmailProductDelivered;
use App\Models\UserRefundbyProvider;
use App\Models\UserEmailProductInProgress;
use App\Models\UserCancelledbyProvider;
use Illuminate\Http\Request;

class UserEmailController extends Controller
{
    // index
    public function index()
    {
        // Fetch the default currency from SiteSetup
        $generalSettings = GeneralSettings::first()->name;
        $emailuserotpverify = UserEmailOtpVerify::first();
        $emailuserforgotpassword = UserEmailForgotPassword::first();
        $emailuserorderplacedservice = UserEmailOrderPlacedService::first();
        $emailuserbookingaccepted = UserEmailBookingAccepted::first();
        $emailuserbookinginprogress = UserEmailBookingInProgress::first();
        $emailuserbookinghold = UserEmailBookingHold::first();
        $emailuserbookingcancelled = UserEmailBookingCancelled::first();
        $emailuserbookingrejected = UserEmailBookingRejected::first();
        $emailuserproductinprogress = UserEmailProductInProgress::first();
        $emailuserproductdelivered = UserEmailProductDelivered::first();
        $usercancelledbyprovider = UserCancelledbyProvider::first();
        $userrefundbyprovider = UserRefundbyProvider::first();


        return view(
            'useremail-detail',
            compact('emailuserotpverify', 'emailuserforgotpassword', 'emailuserorderplacedservice', 'emailuserbookingaccepted', 'emailuserbookinginprogress', 'emailuserbookinghold', 'emailuserbookingcancelled', 'emailuserbookingrejected', 'emailuserproductinprogress', 'emailuserproductdelivered', 'generalSettings', 'usercancelledbyprovider', 'userrefundbyprovider')
        );
    }


    // emailUserOtpVerify
    public function emailUserOtpVerify(Request $request)
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

        $email = UserEmailOtpVerify::first() ?? new UserEmailOtpVerify();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserOtpVerify
    public function changeEmailUserOtpVerify(Request $request, $id)
    {
        $status = UserEmailOtpVerify::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserForgotPassword
    public function emailUserForgotPassword(Request $request)
    {
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

        $email = UserEmailForgotPassword::first() ?? new UserEmailForgotPassword();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserForgotPassword
    public function changeEmailUserForgotPassword(Request $request, $id)
    {
        $status = UserEmailForgotPassword::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserOrderPlacedService
    public function emailUserOrderPlacedService(Request $request)
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

        $email = UserEmailOrderPlacedService::first() ?? new UserEmailOrderPlacedService();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserOrderPlaced
    public function changeEmailUserOrderPlaced(Request $request, $id)
    {
        $status = UserEmailOrderPlacedService::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserBookingAccepted
    public function emailUserBookingAccepted(Request $request)
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

        $email = UserEmailBookingAccepted::first() ?? new UserEmailBookingAccepted();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserBookingAccepted
    public function changeEmailUserBookingAccepted(Request $request, $id)
    {
        $status = UserEmailBookingAccepted::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserBookingInProgress
    public function emailUserBookingInProgress(Request $request)
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

        $email = UserEmailBookingInProgress::first() ?? new UserEmailBookingInProgress();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserBookingInProgress
    public function changeEmailUserBookingInProgress(Request $request, $id)
    {
        $status = UserEmailBookingInProgress::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserBookingHold
    public function emailUserBookingHold(Request $request)
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

        $email = UserEmailBookingHold::first() ?? new UserEmailBookingHold();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserBookingHold
    public function changeEmailUserBookingHold(Request $request, $id)
    {
        $status = UserEmailBookingHold::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserBookingCancelled
    public function emailUserBookingCancelled(Request $request)
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

        $email = UserEmailBookingCancelled::first() ?? new UserEmailBookingCancelled();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserBookingCancelled
    public function changeEmailUserBookingCancelled(Request $request, $id)
    {
        $status = UserEmailBookingCancelled::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserBookingRejected
    public function emailUserBookingRejected(Request $request)
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

        $email = UserEmailBookingRejected::first() ?? new UserEmailBookingRejected();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserBookingRejected
    public function changeEmailUserBookingRejected(Request $request, $id)
    {
        $status = UserEmailBookingRejected::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserProductInProgress
    public function emailUserProductInProgress(Request $request)
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

        $email = UserEmailProductInProgress::first() ?? new UserEmailProductInProgress();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserProductInProgress
    public function changeEmailUserProductInProgress(Request $request, $id)
    {
        $status = UserEmailProductInProgress::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserProductDelivered
    public function emailUserProductDelivered(Request $request)
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

        $email = UserEmailProductDelivered::first() ?? new UserEmailProductDelivered();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserProductDelivered
    public function changeEmailUserProductDelivered(Request $request, $id)
    {
        $status = UserEmailProductDelivered::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserCancelledbyProvider
    public function emailUserCancelledbyProvider(Request $request)
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

        $email = UserCancelledbyProvider::first() ?? new UserCancelledbyProvider();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }



    // changeEmailUserCancelledbyProviderStatus
    public function changeEmailUserCancelledbyProviderStatus(Request $request, $id)
    {
        $status = UserCancelledbyProvider::find($id);

        if ($status) {
            // Update get_email field based on the request data (1 for checked, 0 for unchecked)
            $status->get_email = $request->get_email;
            $status->save();

            return response()->json(['success' => true, 'message' => 'Status changed successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }


    // emailUserRefundbyProvider
    public function emailUserRefundbyProvider(Request $request)
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

        $email = UserRefundbyProvider::first() ?? new UserRefundbyProvider();

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

        return redirect()->route('useremail-detail')->with('message', 'Email Data saved successfully');
    }


    // changeEmailUserRefundbyProviderStatus
    public function changeEmailUserRefundbyProviderStatus(Request $request, $id)
    {
        $status = UserRefundbyProvider::find($id);

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
