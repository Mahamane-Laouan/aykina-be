<?php

namespace App\Http\Controllers;

use App\Models\Commissions;
use App\Models\Currencies;
use App\Models\GeneralSettings;
use App\Models\MailSetup;
use App\Models\MobileUrl;
use App\Models\SiteSetup;
use App\Models\SMSConfig;
use App\Models\SocialMedia;
use App\Models\NearbyDistance;
use App\Models\ThemeSetup;
use App\Models\UserLoginStatus;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    // index
    public function index(Request $request)
    {
        $sitesetup = SiteSetup::first();
        $mobileurl = MobileUrl::first();
        $socialmedia = SocialMedia::first();
        $serverconfig = UserLoginStatus::all();
        $mailsetup = MailSetup::first();
        $smsConfig = SMSConfig::first();
        $currencies = Currencies::all();

        // Mask sensitive data
        $smsConfig->twilio_sid = str_repeat('*', strlen($smsConfig->twilio_sid));
        $smsConfig->twilio_auth_token = str_repeat('*', strlen($smsConfig->twilio_auth_token));
        $smsConfig->twilio_phone_number = str_repeat('*', strlen($smsConfig->twilio_phone_number));

        $smsConfig->msg91_auth_key = str_repeat('*', strlen($smsConfig->msg91_auth_key));
        $smsConfig->msg91_private_key = str_repeat('*', strlen($smsConfig->msg91_private_key));

        // Fetch specific commission data
        $handymanCommission = Commissions::where('people_id', 2)->first();
        $providerServiceCommission = Commissions::where('people_id', 1)
            ->where('type', 'Service')
            ->first();
        $providerProductCommission = Commissions::where('people_id', 1)
            ->where('type', 'Product')
            ->first();

        $nearbydistance = NearbyDistance::first();

        $purchasecode = SiteSetup::first();



        return view('settings', compact(
            'sitesetup',
            'mobileurl',
            'socialmedia',
            'serverconfig',
            'handymanCommission',
            'providerServiceCommission',
            'providerProductCommission',
            'mailsetup',
            'smsConfig',
            'currencies',
            'nearbydistance',
            'purchasecode'
        ));
    }


    // saveSiteSetup
    public function saveSiteSetup(Request $request)
    {

        $data = SiteSetup::first() ?? new SiteSetup();

        $data->name = $request->name;
        $data->min_amountbook = $request->min_amountbook;
        $data->distance = $request->distance;
        $data->distance_type = $request->distance_type;
        $data->platform_fees = $request->platform_fees;
        $data->time_zone = $request->time_zone;
        $data->default_currency = $request->default_currency;
        $data->default_currency_name = $request->default_currency_name;
        $data->copyright_text = $request->copyright_text;
        $data->google_map_key = $request->google_map_key;
        $data->color_code = $request->color_code;


        if ($request->hasFile('light_logo')) {
            $image = $request->file('light_logo');
            $imageName = time() . '_light_logo_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/logo'), $imageName);
            $data->light_logo = $imageName;
        }

        if ($request->hasFile('dark_logo')) {
            $image = $request->file('dark_logo');
            $imageName = time() . '_dark_logo_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/logo'), $imageName);
            $data->dark_logo = $imageName;
        }

        if ($request->hasFile('fav_icon')) {
            $image = $request->file('fav_icon');
            $imageName = time() . '_favicon_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/logo'), $imageName);
            $data->fav_icon = $imageName;
        }

        $data->save();

        return redirect()->route('settings')->with('message', 'General Settings updated successfully');
    }


    // saveMobileUrl
    public function saveMobileUrl(Request $request)
    {

        $data = MobileUrl::first() ?? new MobileUrl();

        $data->android_url = $request->android_url;
        $data->android_provider_url = $request->android_provider_url;
        $data->ios_url = $request->ios_url;
        $data->ios_provider_url = $request->ios_provider_url;
        $data->save();

        return redirect()->route('settings')->with('message', 'Mobile Url updated successfully');
    }


    // saveSocialMedia
    public function saveSocialMedia(Request $request)
    {

        $data = SocialMedia::first() ?? new SocialMedia();

        $data->facebook_link = $request->facebook_link;
        $data->whatsapp_link = $request->whatsapp_link;
        $data->instagram_link = $request->instagram_link;
        $data->twitter_link = $request->twitter_link;
        $data->youtube_link = $request->youtube_link;
        $data->linkdln_link = $request->linkdln_link;
        $data->save();

        return redirect()->route('settings')->with('message', 'Social Media updated successfully');
    }


    // saveServerConfig
    public function saveServerConfig(Request $request, $type)
    {
        if ($type === 'user') {
            // Update User Status
            $services = UserLoginStatus::all();
            foreach ($services as $service) {
                $status = $request->input($service->text, 0); // Default to 0 if not submitted
                $service->update(['status' => $status]);
            }
        } elseif ($type === 'handyman') {
            // Update Handyman Status
            $services = UserLoginStatus::all();
            foreach ($services as $service) {
                $status = $request->input($service->text . '_handyman', 0); // Default to 0 if not submitted
                $service->update(['handyman_status' => $status]);
            }
        }

        return redirect()->route('settings')->with('message', ucfirst($type) . ' Login Configurations updated successfully');
    }



    // saveComissions
    public function saveComissions(Request $request)
    {
        // Update Handyman commission
        $handymanCommission = Commissions::where('people_id', 2)->first();
        if (!$handymanCommission) {
            $handymanCommission = new Commissions();
            $handymanCommission->people_id = 2;
        }
        $handymanCommission->value = $request->handyman_commission;
        $handymanCommission->save();

        // Update Provider Service commission
        $providerServiceCommission = Commissions::where('people_id', 1)
            ->where('type', 'Service')
            ->first();
        if (!$providerServiceCommission) {
            $providerServiceCommission = new Commissions();
            $providerServiceCommission->people_id = 1;
            $providerServiceCommission->type = 'Service';
        }
        $providerServiceCommission->value = $request->provider_service_commission;
        $providerServiceCommission->save();

        // Update Provider Product commission
        $providerProductCommission = Commissions::where('people_id', 1)
            ->where('type', 'Product')
            ->first();
        if (!$providerProductCommission) {
            $providerProductCommission = new Commissions();
            $providerProductCommission->people_id = 1;
            $providerProductCommission->type = 'Product';
        }
        $providerProductCommission->value = $request->provider_product_commission;
        $providerProductCommission->save();

        return redirect()->route('settings')->with('message', 'Commissions updated successfully');
    }


    // saveMailSetup
    public function saveMailSetup(Request $request)
    {

        $data = MailSetup::first() ?? new MailSetup();

        $data->mail_mailer = $request->mail_mailer;
        $data->mail_host = $request->mail_host;
        $data->mail_port = $request->mail_port;
        $data->mail_encryption = $request->mail_encryption;
        $data->mail_username = $request->mail_username;
        $data->mail_password = $request->mail_password;
        $data->mail_from = $request->mail_from;
        $data->save();

        return redirect()->route('settings')->with('message', 'Mail Setup updated successfully');
    }


    // saveSMSConfig
    public function saveSMSConfig(Request $request)
    {
        $data = SMSConfig::first() ?? new SMSConfig();

        // Preserve existing values if the input is masked
        if ($request->twilio_sid !== '******') {
            $data->twilio_sid = $request->twilio_sid;
        }
        if ($request->twilio_auth_token !== '******') {
            $data->twilio_auth_token = $request->twilio_auth_token;
        }
        if ($request->twilio_phone_number !== '******') {
            $data->twilio_phone_number = $request->twilio_phone_number;
        }
        if ($request->msg91_auth_key !== '******') {
            $data->msg91_auth_key = $request->msg91_auth_key;
        }
        if ($request->msg91_private_key !== '******') {
            $data->msg91_private_key = $request->msg91_private_key;
        }

        $data->save();

        return redirect()->route('settings')->with('message', 'SMS Config updated successfully');
    }




    // saveNearbyDistance
    public function saveNearbyDistance(Request $request)
    {

        $data = NearbyDistance::first() ?? new NearbyDistance();

        $data->distance = $request->distance;
        $data->distance_type = $request->distance_type;
        $data->save();

        return redirect()->route('settings')->with('message', 'Nearby Distance updated successfully');
    }
}
