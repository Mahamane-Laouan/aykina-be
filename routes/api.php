<?php


use App\Http\Controllers\Api\WebApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\RazorPayController;
use App\Http\Controllers\Api\PayPalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LanguageController;


// User Routes
Route::get('/showuseremail-userotpverify', [WebApiController::class, 'showUserEmailUserOtpVerify']);
Route::get('/showuseremail-userforgotpassword', [WebApiController::class, 'showUserEmailUserForgotPassword']);
Route::get('/showuseremail-userorderplacedservice', [WebApiController::class, 'showUserEmailUserOrderPlacedService']);
Route::get('/showuseremail-userbookingaccepted', [WebApiController::class, 'showUserEmailUserBookingAccepted']);
Route::get('/showuseremail-userbookinginprogress', [WebApiController::class, 'showUserEmailUserBookingInProgress']);
Route::get('/showuseremail-userbookinghold', [WebApiController::class, 'showUserEmailUserBookingHold']);
Route::get('/showuseremail-userbookingcancelled', [WebApiController::class, 'showUserEmailUserBookingCancelled']);
Route::get('/showuseremail-userbookingrejected', [WebApiController::class, 'showUserEmailUserBookingRejected']);
Route::get('/showuseremail-userproductinprogress', [WebApiController::class, 'showUserEmailUserProductinProgress']);
Route::get('/showuseremail-userproductdelivered', [WebApiController::class, 'showUserEmailUserProductDelivered']);
Route::get('/showuseremail-usercancelledbyprovider', [WebApiController::class, 'showUserEmailUserCancelledbyProvider']);
Route::get('/showuseremail-userrefundbyprovider', [WebApiController::class, 'showUserEmailUserRefundbyProvider']);



// Provider Routes
Route::get('/showprovideremail-providerotpverify', [WebApiController::class, 'showProviderEmailProviderOtpVerify']);
Route::get('/showprovideremail-providerforgotpassword', [WebApiController::class, 'showProviderEmailProviderForgotPassword']);
Route::get('/showprovideremail-providerorderreceived', [WebApiController::class, 'showProviderEmailProviderOrderReceived']);
Route::get('/showprovideremail-providerbookingaccepted', [WebApiController::class, 'showProviderEmailProviderBookingAccepted']);
Route::get('/showprovideremail-providerbookingrejected', [WebApiController::class, 'showProviderEmailProviderBookingRejected']);
Route::get('/showprovideremail-providerassignhandyman', [WebApiController::class, 'showProviderEmailProviderAssignHandyman']);
Route::get('/showprovideremail-providerrejecthandyman', [WebApiController::class, 'showProviderEmailProviderRejectHandyman']);
Route::get('/showprovideremail-providerorderinprogress', [WebApiController::class, 'showProviderEmailProviderOrderInProgress']);
Route::get('/showprovideremail-providerorderdelivered', [WebApiController::class, 'showProviderEmailProviderOrderDelivered']);
Route::get('/showprovideremail-providerbookinghold', [WebApiController::class, 'showProviderEmailProviderBookingHold']);
Route::get('/showprovideremail-providerbookingcompleted', [WebApiController::class, 'showProviderEmailProviderBookingCompleted']);
Route::get('/showprovideremail-providerpaymentreceived', [WebApiController::class, 'showProviderEmailProviderPaymentReceived']);
Route::get('/showprovideremail-providerpaymentsent', [WebApiController::class, 'showProviderEmailProviderPaymentSent']);
Route::get('/showprovideremail-providerreviewreceived', [WebApiController::class, 'showProviderEmailProviderReviewReceived']);



// Handyman Routes
Route::get('/showhandymanemail-handymanotpverify', [WebApiController::class, 'showHandymanEmailHandymanOtpVerify']);
Route::get('/showhandymanemail-handymanforgotpassword', [WebApiController::class, 'showHandymanEmailHandymanForgotPassword']);
Route::get('/showhandymanemail-handymanassignfororder', [WebApiController::class, 'showHandymanEmailHandymanAssignforOrder']);
Route::get('/showhandymanemail-handymanbookingaccepted', [WebApiController::class, 'showHandymanEmailHandymanBookingAccepted']);
Route::get('/showhandymanemail-handymanbookingrejected', [WebApiController::class, 'showHandymanEmailHandymanBookingRejected']);
Route::get('/showhandymanemail-handymanbookingcompleted', [WebApiController::class, 'showHandymanEmailHandymanBookingCompleted']);
Route::get('/showhandymanemail-handymanreviewreceived', [WebApiController::class, 'showHandymanEmailHandymanReviewReceived']);







/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::post('validatePurchase', [AuthController::class, 'validatePurchase']);
// Route::post('verifyToken', [AuthController::class, 'verifyToken']);
// Route::post('expireToken', [AuthController::class, 'expireToken']);


Route::post(base64_decode('dmFsaWRhdGVQdXJjaGFzZQ=='), [AuthController::class, 'validatePurchase']);
Route::post(base64_decode('dmVyaWZ5VG9rZW4='), [AuthController::class, 'verifyToken']);
Route::post(base64_decode('ZXhwaXJlVG9rZW4='), [AuthController::class, 'expireToken']);

Route::post('social_login', [AuthController::class, 'social_login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('send-otp', [AuthController::class, 'sendOtp']);
Route::post('register_new', [AuthController::class, 'register_new']);
Route::post('login', [AuthController::class, 'login']);
Route::post('send_otp', [AuthController::class, 'send_otp']);
Route::post('check_otp', [AuthController::class, 'check_otp']);
Route::post('username_email_check', [AuthController::class, 'username_email_check']);
Route::post('forgotPassword', [UserController::class, 'forgotPassword']);
Route::post('reset_pass', [UserController::class, 'reset_pass']);
Route::post('check_verified_code', [UserController::class, 'check_verified_code']);
Route::post('email_check_otp', [AuthController::class, 'email_check_otp']);

Route::get('get_all_category', [ProviderController::class, 'get_all_category']);
Route::post('get_all_service_sub_category', [ProviderController::class, 'get_all_service_sub_category']);
Route::get('get_all_product_category', [ProviderController::class, 'get_all_product_category']);

Route::post('support_chat_api', [UserController::class, 'support_chat_api']);
Route::post('support_message_list', [UserController::class, 'support_message_list']);
Route::post('support_chat_status', [UserController::class, 'support_chat_status']);
Route::post('referal_code_check', [UserController::class, 'referal_code_check']);
Route::post('sendCustomNotification', [UserController::class, 'sendCustomNotification']);


Route::post('all_subcategory_by_category', [ProviderController::class, 'all_subcategory_by_category']);
Route::get('all_payment_gateway_key', [UserController::class, 'all_payment_gateway_key']);
Route::get('all_login_status', [UserController::class, 'all_login_status']);
Route::get('provider_handyman_login_status', [UserController::class, 'provider_handyman_login_status']);
Route::get('get_currency_and_colour', [UserController::class, 'get_currency_and_colour']);

Route::post('user_home', [UserController::class, 'user_home']);
Route::post('all_role', [UserController::class, 'all_role']);

Route::post('admin_booking_status_history', [ProviderController::class, 'admin_booking_status_history']);

Route::post('addLanguageColumn', [LanguageController::class, 'addLanguageColumn']);
Route::post('translateAllKeywords', [LanguageController::class, 'translateAllKeywords']);
Route::post('updateStatus', [LanguageController::class, 'updateStatus']);
Route::post('listAllLanguages', [LanguageController::class, 'listAllLanguages']);
Route::post('getLanguageDataFromStatusId', [LanguageController::class, 'getLanguageDataFromStatusId']);
Route::post('editLanguage', [LanguageController::class, 'editLanguage']);
Route::post('fetchLanguages', [LanguageController::class, 'fetchLanguages']);
Route::post('translateoneKeywords', [LanguageController::class, 'translateoneKeywords']);

Route::post('addKey', [LanguageController::class, 'addKey']);
Route::post('fetchDefaultLanguage', [LanguageController::class, 'fetchDefaultLanguage']);
Route::post('fetchLanguageKeywordsWithTranslation', [LanguageController::class, 'fetchLanguageKeywordsWithTranslation']);
Route::post('editKeyword', [LanguageController::class, 'editKeyword']);
Route::post('get_privacy_policy', [UserController::class, 'get_privacy_policy']);






Route::middleware('auth:api')->group(function () {

    Route::post('user_update_status', [AuthController::class, 'user_update_status']);
    Route::post('notification_list', [UserController::class, 'notification_list']);
    Route::post('handyman_notification_list', [UserController::class, 'handyman_notification_list']);
    Route::post('notification_verified', [UserController::class, 'notification_verified']);
    Route::post('handyman_notification_verified', [UserController::class, 'handyman_notification_verified']);
    Route::post('provider_notification_verified', [ProviderController::class, 'provider_notification_verified']);
    Route::post('handyman_review_given', [UserController::class, 'handyman_review_given']);
    Route::post('provider_review_given', [ProviderController::class, 'provider_review_given']);
    Route::post('get_all_service_by_category_provider', [ProviderController::class, 'get_all_service_by_category_provider']);


    Route::get('banner', [UserController::class, 'banner']);
    Route::post('booking_list', [UserController::class, 'booking_list']);
    Route::post('home', [UserController::class, 'home']);
    Route::post('booking_filter', [UserController::class, 'booking_filter']);
    Route::post('booking_details', [UserController::class, 'booking_details']);
    Route::post('user_profile', [UserController::class, 'user_profile']);
    Route::post('search_users', [UserController::class, 'search_users']);
    Route::post('account_delete', [UserController::class, 'account_delete']);
    Route::post('change_password', [UserController::class, 'change_password']);
    Route::post('handyman_update_status', [UserController::class, 'handyman_update_status']);
    Route::post('handyman_check_otp', [UserController::class, 'handyman_check_otp']);
    Route::post('add_service_proof', [UserController::class, 'add_service_proof']);
    Route::post('provider_info_by_handyman', [UserController::class, 'provider_info_by_handyman']);
    Route::post('notification_list', [UserController::class, 'notification_list']);

    Route::post('service_details', [UserController::class, 'service_details']);
    Route::post('get_all_service_by_category', [UserController::class, 'get_all_service_by_category']);
    Route::post('get_all_service', [UserController::class, 'get_all_service']);
    Route::post('get_all_service_with_pagination', [UserController::class, 'get_all_service_with_pagination']);
    Route::post('get_all_product_with_pagination', [UserController::class, 'get_all_product_with_pagination']);
    Route::post('get_all_product', [UserController::class, 'get_all_product']);
    Route::post('like_service', [UserController::class, 'like_service']);
    Route::post('like_service_list', [UserController::class, 'like_service_list']);
    Route::post('like_product', [UserController::class, 'like_product']);
    Route::post('like_product_list', [UserController::class, 'like_product_list']);
    Route::post('all_provider_list', [UserController::class, 'all_provider_list']);
    Route::post('like_provider', [UserController::class, 'like_provider']);
    Route::post('like_provider_list', [UserController::class, 'like_provider_list']);
    Route::post('product_details', [UserController::class, 'product_details']);
    Route::post('user_info', [UserController::class, 'user_info']);
    Route::post('add_address', [UserController::class, 'add_address']);
    Route::post('get_all_addresses', [UserController::class, 'get_all_addresses']);
    Route::post('get_all_coupan', [UserController::class, 'get_all_coupan']);
    Route::post('add_to_cart', [UserController::class, 'add_to_cart']);
    Route::post('get_cart_items', [UserController::class, 'get_cart_items']);
    Route::post('cart_time_slot_booking', [UserController::class, 'cart_time_slot_booking']);
    Route::post('del_fromCart', [UserController::class, 'del_fromCart']);
    Route::post('delete_all_cart', [UserController::class, 'delete_all_cart']);
    Route::post('orderPlaced', [UserController::class, 'orderPlaced']);
    Route::post('allcart_address_update', [UserController::class, 'allcart_address_update']);
    Route::post('all_booking_service_by_user', [UserController::class, 'all_booking_service_by_user']);
    Route::post('all_booking_product_by_user', [UserController::class, 'all_booking_product_by_user']);
    Route::post('service_booking_details_by_booking_id', [UserController::class, 'service_booking_details_by_booking_id']);
    Route::post('product_booking_details_by_booking_id', [UserController::class, 'product_booking_details_by_booking_id']);
    Route::post('all_booking_details_by_orderid', [UserController::class, 'all_booking_details_by_orderid']);
    Route::post('create_ticket', [UserController::class, 'create_ticket']);
    Route::post('all_ticket_by_user', [UserController::class, 'all_ticket_by_user']);
    Route::post('search_services', [UserController::class, 'search_services']);
    Route::post('search_products', [UserController::class, 'search_products']);
    Route::post('filter_services', [UserController::class, 'filter_services']);
    Route::post('filter_products', [UserController::class, 'filter_products']);
    Route::post('nearby_services', [UserController::class, 'nearby_services']);
    Route::post('add_service_review', [UserController::class, 'add_service_review']);
    Route::post('add_product_review', [UserController::class, 'add_product_review']);
    Route::post('review_given', [UserController::class, 'review_given']);
    Route::post('edit_all_review', [UserController::class, 'edit_all_review']);
    Route::post('review_all_delete', [UserController::class, 'review_all_delete']);
    Route::post('service_all_review', [UserController::class, 'service_all_review']);
    Route::post('product_all_review', [UserController::class, 'product_all_review']);
    Route::post('transition_details', [UserController::class, 'transition_details']);
    Route::post('all_booking_status_history', [UserController::class, 'all_booking_status_history']);
    Route::post('handyman_booking_status_history', [UserController::class, 'handyman_booking_status_history']);


    Route::post('chat_api', [ChatController::class, 'chat_api']);
    Route::post('message_list', [ChatController::class, 'message_list']);
    Route::post('user_chat_list', [ChatController::class, 'user_chat_list']);

    Route::post('message_list_new', [ChatController::class, 'message_list_new']);

    Route::post('user_online', [UserController::class, 'user_online']);
    Route::post('paymentsend', [UserController::class, 'paymentsend']);
    Route::post('total_unread_messages', [ChatController::class, 'total_unread_messages']);
    Route::post('user_update_wallet', [UserController::class, 'user_update_wallet']);
    Route::post('transition_list', [UserController::class, 'transition_list']);
    Route::post('user_cancel_order', [UserController::class, 'user_cancel_order']);

    Route::post('handyman_wallet_list', [UserController::class, 'handyman_wallet_list']);
    Route::post('withdrawMoney_handyman', [UserController::class, 'withdrawMoney_handyman']);
    Route::post('handyman_wallet_transaction_history', [UserController::class, 'handyman_wallet_transaction_history']);
    Route::post('handyman_add_bank_details', [UserController::class, 'handyman_add_bank_details']);

    Route::post('home_provider_by_services', [ProviderController::class, 'home_provider_by_services']);
    Route::post('home_provider_by_products', [ProviderController::class, 'home_provider_by_products']);
    Route::post('add_service_by_provider', [ProviderController::class, 'add_service_by_provider']);
    Route::post('edit_service_by_provider', [ProviderController::class, 'edit_service_by_provider']);
    Route::post('get_service_by_provider', [ProviderController::class, 'get_service_by_provider']);
    Route::post('add_product_by_provider', [ProviderController::class, 'add_product_by_provider']);
    Route::post('edit_product_by_provider', [ProviderController::class, 'edit_product_by_provider']);
    Route::post('edit_addon_product', [ProviderController::class, 'edit_addon_product']);
    Route::post('get_product_by_provider', [ProviderController::class, 'get_product_by_provider']);
    Route::post('handyman_list_by_provider', [ProviderController::class, 'handyman_list_by_provider']);
    Route::post('provider_add_handyman', [ProviderController::class, 'provider_add_handyman']);
    Route::post('new_handyman_add_by_provider', [AuthController::class, 'new_handyman_add_by_provider']);
    Route::post('edit_profile_handyman_by_provider', [ProviderController::class, 'edit_profile_handyman_by_provider']);
    Route::post('handyman_account_delete_by_provider', [ProviderController::class, 'handyman_account_delete_by_provider']);
    Route::post('home_provider_info', [ProviderController::class, 'home_provider_info']);
    Route::post('edit_service_image', [ProviderController::class, 'edit_service_image']);
    Route::post('edit_product_image', [ProviderController::class, 'edit_product_image']);
    Route::post('product_image_delete', [ProviderController::class, 'product_image_delete']);
    Route::post('service_image_delete', [ProviderController::class, 'service_image_delete']);

    Route::post('all_products_booking_by_provider', [ProviderController::class, 'all_products_booking_by_provider']);
    Route::post('all_services_booking_by_provider', [ProviderController::class, 'all_services_booking_by_provider']);
    Route::post('get_all_service_by_provider', [ProviderController::class, 'get_all_service_by_provider']);
    Route::post('service_booking_details_by_provider', [ProviderController::class, 'service_booking_details_by_provider']);
    Route::post('product_booking_details_by_provider', [ProviderController::class, 'product_booking_details_by_provider']);
    Route::post('edit_faq_by_provider', [ProviderController::class, 'edit_faq_by_provider']);
    Route::post('delete_faq_by_provider', [ProviderController::class, 'delete_faq_by_provider']);

    Route::post('provider_update_status', [ProviderController::class, 'provider_update_status']);
    Route::post('provider_assign_work_handyman', [ProviderController::class, 'provider_assign_work_handyman']);
    Route::post('add_faq_by_provider', [ProviderController::class, 'add_faq_by_provider']);
    Route::post('faq_list', [ProviderController::class, 'faq_list']);
    Route::post('withdrawMoney_provider', [ProviderController::class, 'withdrawMoney_provider']);
    Route::post('payReqList_provider', [ProviderController::class, 'payReqList_provider']);
    Route::post('provider_add_bank_details', [ProviderController::class, 'provider_add_bank_details']);
    Route::post('provider_notification_list', [ProviderController::class, 'provider_notification_list']);
    Route::post('provider_booking_status_history', [ProviderController::class, 'provider_booking_status_history']);
    Route::post('handyman_profile_with_review', [ProviderController::class, 'handyman_profile_with_review']);
    Route::post('delete_service', [ProviderController::class, 'delete_service']);
    Route::post('delete_product', [ProviderController::class, 'delete_product']);
    Route::post('provider_handyman_payreq_list', [ProviderController::class, 'provider_handyman_payreq_list']);
    Route::post('provider_update_handyman_payreq', [ProviderController::class, 'provider_update_handyman_payreq']);
    Route::post('provider_wallet_list', [ProviderController::class, 'provider_wallet_list']);
    //Razorpay Controller

    Route::post('AddWalletRazorPay', [RazorPayController::class, 'AddWalletRazorPay']);
    Route::post('RazorPaycheckout', [RazorPayController::class, 'RazorPaycheckout']);

    Route::post('social_send_otp', [AuthController::class, 'social_send_otp']);
    //PayPal Controller

    Route::post('PayPalCheckout', [PayPalController::class, 'PayPalCheckout']);
    Route::post('capturePayment', [PayPalController::class, 'capturePayment']);

    Route::post('my_referalcode_list', [AuthController::class, 'my_referalcode_list']);

    Route::post('remove_coupon', [UserController::class, 'remove_coupon']);
});
