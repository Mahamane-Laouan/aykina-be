<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AllUsersListController;
use App\Http\Controllers\BookingListController;
use App\Http\Controllers\CancelPolicyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CouponListController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoneController;
use App\Http\Controllers\PayOutListProviderController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\TaxController;
use App\Models\OrdersModel;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HandymanCommissionController;
use App\Http\Controllers\HandymanController;
use App\Http\Controllers\HandymanEmailController;
use App\Http\Controllers\LanguageListController;
use App\Http\Controllers\HandymanRequestListController;
use App\Http\Controllers\HandymanReviewListController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProviderProductBookingListController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProviderServiceBookingListController;
use App\Http\Controllers\NotificationTemplateController;
use App\Http\Controllers\PaymentConfigurationController;
use App\Http\Controllers\NotificationDataController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\ProductBookingListController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SliderListController;
use App\Http\Controllers\ProviderBookingListController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ServiceBookingListController;
use App\Http\Controllers\ProviderDashboardController;
use App\Http\Controllers\ProviderEmailController;
use App\Http\Controllers\ProviderHandymanController;
use App\Http\Controllers\ProviderHandymanEarningsController;
use App\Http\Controllers\ProviderHandymanPaymentRequestController;
use App\Http\Controllers\ProviderHandymanRequestListController;
use App\Http\Controllers\ProviderHandymanReviewListController;
use App\Http\Controllers\ProviderProductController;
use App\Http\Controllers\ProviderRequestListController;
use App\Http\Controllers\ProviderReviewListController;
use App\Http\Controllers\ProviderServiceController;
use App\Http\Controllers\ProviderUserListController;
use App\Http\Controllers\ProviderViewController;
use App\Http\Controllers\ProviderWithdrawRequestController;
use App\Http\Controllers\RefundPolicyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubCategoryListController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\SystemCheckController;
use App\Http\Controllers\TermsConditionController;
use App\Http\Controllers\UserEmailController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\UserReviewListController;
use Illuminate\Support\Facades\Route;


Route::get('/validate', function () {
    return response()->file(public_path('images/validate.html'));
})->name('validate-page');

// Login Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/', [HomeController::class, 'checkExtensions'])->name('check-extensions');
Route::get(base64_decode('Y2hlY2stZGlyZWN0b3JpZXM='), [SystemCheckController::class, 'checkDirectories'])->name('check-directories');
Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration');
Route::post('/save-configuration', [ConfigurationController::class, 'save'])->name('save-configuration');
Route::get('/done', [DoneController::class, 'index'])->name('done');
Route::post('/auth/login', [LoginController::class, 'login'])->name('auth-login');


// Pages
Route::get('privacy-policy-page', [PrivacyPolicyController::class, 'showPrivacyPolicy'])->name('privacy-policy-page');
Route::get('contact-us-page', [ContactUsController::class, 'showContactus'])->name('contact-policy-page');
Route::get('refund-policy-page', [RefundPolicyController::class, 'showRefundPolicy'])->name('refund-policy-page');
Route::get('cancel-policy-page', [CancelPolicyController::class, 'showCancelPolicy'])->name('cancel-policy-page');


Route::group(['middleware' => ['admin']], function () {



    // LoginController
    Route::post('logout', [LoginController::class, 'Logout'])->name('logout');


    // DashboardController
    Route::get('admin-dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');


    // ProviderDashboardController
    Route::get('provider-dashboard', [ProviderDashboardController::class, 'index'])->name('provider-dashboard');




    // ProfileController
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile-save', [ProfileController::class, 'saveProfile'])->name('profile-save');
    Route::post('password-save', [ProfileController::class, 'savePassword'])->name('password-save');


    // BookingListController
    Route::get('booking-list', [BookingListController::class, 'index'])->name('booking-list');
    Route::post('booking-delete/{id}', [BookingListController::class, 'deleteBooking'])->name('booking-delete');
    Route::get('booking-view/{id}', [BookingListController::class, 'viewBooking'])->name('booking-view');
    Route::get('subbooking-view/{id}', [BookingListController::class, 'innerbookingView'])->name('subbooking-view');
    Route::post('/assign-handyman/{id}', [BookingListController::class, 'assignHandyman'])->name('assign.handyman');
    Route::get('/invoice/print/{id}', [BookingListController::class, 'printInvoice'])->name('invoice.print');


    // People
    // ProviderController
    Route::get('providers-list', [ProviderController::class, 'index'])->name('providers-list');
    Route::get('provider-add', [ProviderController::class, 'addProvider'])->name('provider-add');
    Route::post('provider-save', [ProviderController::class, 'saveProvider'])->name('provider-save');
    Route::get('provider-edit/{id}', [ProviderController::class, 'editProvider'])->name('provider-edit');
    Route::post('provider-update/{id}', [ProviderController::class, 'updateProvider'])->name('provider-update');
    Route::post('provider-delete/{id}', [ProviderController::class, 'deleteProvider'])->name('provider-delete');
    Route::get('change-providerlistblocked/{id}',  [ProviderController::class, 'ChangeProviderListBlocked'])->name('change-providerlistblocked');



    // ProviderViewController
    Route::get('provider-view/{id}', [ProviderViewController::class, 'viewProvider'])->name('provider-view');
    Route::get('/provider/{id}/earnings/{year}', [ProviderViewController::class, 'getMonthlyEarnings'])->name('provider.earnings');



    // ProviderRequestListController
    Route::get('provider-requestlist', [ProviderRequestListController::class, 'index'])->name('provider-requestlist');
    Route::get('provider-requestapproval/{id}', [ProviderRequestListController::class, 'providerRequestApproval'])->name('provider-requestapproval');
    Route::post('provider-ignore/{id}', [ProviderRequestListController::class, 'ignoreProvider'])->name('provider-ignore');
    Route::get('get-provider-counts', [ProviderRequestListController::class, 'getUnverifiedProvider'])->name('get-provider-counts');



    // HandymanController
    Route::get('handyman-list', [HandymanController::class, 'index'])->name('handyman-list');
    Route::get('handyman-add', [HandymanController::class, 'addHandyman'])->name('handyman-add');
    Route::post('handyman-save', [HandymanController::class, 'saveHandyman'])->name('handyman-save');
    Route::get('handyman-edit/{id}', [HandymanController::class, 'editHandyman'])->name('handyman-edit');
    Route::post('handyman-update/{id}', [HandymanController::class, 'updateHandyman'])->name('handyman-update');
    Route::post('handyman-delete/{id}', [HandymanController::class, 'deleteHandyman'])->name('handyman-delete');
    Route::get('handyman-view/{id}', [HandymanController::class, 'viewHandyman'])->name('handyman-view');
    Route::get('/handyman/{id}/earnings/{year}', [HandymanController::class, 'getHandymanMonthlyEarnings'])->name('handyman.earnings');
    Route::get('change-handymanlistblocked/{id}',  [HandymanController::class, 'ChangeHandymanListBlocked'])->name('change-handymanlistblocked');



    // HandymanRequestListController
    Route::get('handyman-requestlist', [HandymanRequestListController::class, 'index'])->name('handyman-requestlist');
    Route::get('handyman-requestapproval/{id}', [HandymanRequestListController::class, 'handymanRequestApproval'])->name('handyman-requestapproval');
    Route::post('handyman-ignore/{id}', [HandymanRequestListController::class, 'ignoreHandyman'])->name('handyman-ignore');
    Route::get('get-handyman-counts', [HandymanRequestListController::class, 'getUnverifiedHandyman'])->name('get-handyman-counts');



    // UserListController
    Route::get('user-list', [UserListController::class, 'index'])->name('user-list');
    Route::get('user-edit/{id}', [UserListController::class, 'editUser'])->name('user-edit');
    Route::post('user-update/{id}', [UserListController::class, 'updateUser'])->name('user-update');
    Route::get('user-view/{id}', [UserListController::class, 'viewUser'])->name('user-view');
    Route::get('change-userlistblocked/{id}',  [UserListController::class, 'ChangeUserListBlocked'])->name('change-userlistblocked');
    Route::post('user-delete/{id}', [UserListController::class, 'deleteUser'])->name('user-delete');



    // Services
    // CategoryController
    Route::get('category-list', [CategoryController::class, 'index'])->name('category-list');
    Route::get('category-add', [CategoryController::class, 'addCategory'])->name('category-add');
    Route::post('category-save', [CategoryController::class, 'saveCategory'])->name('category-save');
    Route::get('category-edit/{id}', [CategoryController::class, 'editCategory'])->name('category-edit');
    Route::post('category-update/{id}', [CategoryController::class, 'updateCategory'])->name('category-update');
    Route::post('category-delete/{id}', [CategoryController::class, 'deleteCategory'])->name('category-delete');
    Route::get('change-categorystatus/{id}',  [CategoryController::class, 'changeCategoryStatus'])->name('change-categorystatus');



    // SubCategoryListController
    Route::get('subcategory-list', [SubCategoryListController::class, 'index'])->name('subcategory-list');
    Route::get('subcategory-add', [SubCategoryListController::class, 'addSubcategory'])->name('subcategory-add');
    Route::post('subcategory-save', [SubCategoryListController::class, 'saveSubcategory'])->name('subcategory-save');
    Route::get('subcategory-edit/{id}', [SubCategoryListController::class, 'editSubcategory'])->name('subcategory-edit');
    Route::post('subcategory-update/{id}', [SubCategoryListController::class, 'updateSubcategory'])->name('subcategory-update');
    Route::post('subcategory-delete/{id}', [SubCategoryListController::class, 'deleteSubcategory'])->name('subcategory-delete');
    Route::get('change-subcategorystatus/{id}',  [SubCategoryListController::class, 'changeSubCategoryStatus'])->name('change-subcategorystatus');



    // ServiceController
    Route::get('service-list', [ServiceController::class, 'index'])->name('service-list');
    Route::get('service-add', [ServiceController::class, 'addService'])->name('service-add');
    Route::post('service-save', [ServiceController::class, 'saveService'])->name('service-save');
    Route::get('service-edit/{id}', [ServiceController::class, 'editService'])->name('service-edit');
    Route::post('service-update/{id}', [ServiceController::class, 'updateService'])->name('service-update');
    Route::post('service-delete/{id}', [ServiceController::class, 'deleteService'])->name('service-delete');
    Route::get('service-view/{id}', [ServiceController::class, 'viewService'])->name('service-view');
    Route::get('change-servicestatus/{id}',  [ServiceController::class, 'ChangeServiceStatus'])->name('change-servicestatus');
    Route::get('/get-subcategories/{categoryId}', [ServiceController::class, 'getSubcategories']);
    Route::post('service-imagedelete/{id}', [ServiceController::class, 'imageDeleteService'])->name('service-imagedelete');
    Route::get('/get-products/{v_id}', [ServiceController::class, 'getProductsByVendor']);
    Route::get('change-servicelinkstatus/{id}',  [ServiceController::class, 'changeServiceLinkStatus'])->name('change-servicelinkstatus');



    // ProductController
    Route::get('product-list', [ProductController::class, 'index'])->name('product-list');
    Route::get('product-add', [ProductController::class, 'addProduct'])->name('product-add');
    Route::post('product-save', [ProductController::class, 'saveProduct'])->name('product-save');
    Route::get('product-edit/{id}', [ProductController::class, 'editProduct'])->name('product-edit');
    Route::post('product-update/{id}', [ProductController::class, 'updateProduct'])->name('product-update');
    Route::post('product-delete/{id}', [ProductController::class, 'deleteProduct'])->name('product-delete');
    Route::get('change-productstatus/{id}',  [ProductController::class, 'ChangeProductStatus'])->name('change-productstatus');
    Route::get('/get-services/{providerId}', [ProductController::class, 'getServices']);
    Route::post('product-imagedelete/{id}', [ProductController::class, 'imageDeleteProduct'])->name('product-imagedelete');
    Route::get('change-productliststatus/{product_id}',  [ProductController::class, 'changeProductListStatus'])->name('change-productliststatus');



    // PaymentController
    Route::get('payment-list', [PaymentController::class, 'index'])->name('payment-list');


    // EarningsController
    Route::get('earnings', [EarningsController::class, 'index'])->name('earnings');


    // CouponListController
    Route::get('coupon-list', [CouponListController::class, 'index'])->name('coupon-list');
    Route::get('coupon-add', [CouponListController::class, 'addCoupon'])->name('coupon-add');
    Route::post('coupon-save', [CouponListController::class, 'saveCoupon'])->name('coupon-save');
    Route::post('coupon-delete/{id}', [CouponListController::class, 'deleteCoupon'])->name('coupon-delete');
    Route::get('coupon-edit/{id}', [CouponListController::class, 'editCoupon'])->name('coupon-edit');
    Route::post('coupon-update/{id}', [CouponListController::class, 'updateCoupon'])->name('coupon-update');
    Route::get('change-couponstatus/{id}',  [CouponListController::class, 'changeCouponStatus'])->name('change-couponstatus');




    // UserReviewListController
    Route::get('user-reviewlist', [UserReviewListController::class, 'index'])->name('user-reviewlist');
    Route::post('review-delete/{id}', [UserReviewListController::class, 'deleteReview'])->name('review-delete');



    // ProviderReviewListController
    Route::get('provider-reviewlist', [ProviderReviewListController::class, 'index'])->name('provider-reviewlist');
    Route::post('providerreview-delete/{id}', [ProviderReviewListController::class, 'deleteProviderReview'])->name('providerreview-delete');



    // HandymanReviewListController
    Route::get('handyman-reviewlist', [HandymanReviewListController::class, 'index'])->name('handyman-reviewlist');
    Route::post('handymanreview-delete/{id}', [HandymanReviewListController::class, 'deleteHandymanReview'])->name('handymanreview-delete');



    // PrivacyPolicyController
    Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy');
    Route::post('privacy-policysave', [PrivacyPolicyController::class, 'savePrivacyPolicy'])->name('privacy-policysave');




    // TermsConditionController
    Route::get('terms-conditions', [TermsConditionController::class, 'index'])->name('terms-conditions');
    Route::post('terms-conditionssave', [TermsConditionController::class, 'saveTermsCondition'])->name('terms-conditionssave');


    // AboutController
    Route::get('about', [AboutController::class, 'index'])->name('about');
    Route::post('aboutsave', [AboutController::class, 'saveAbout'])->name('aboutsave');


    // RefundPolicyController
    Route::get('refund-policy', [RefundPolicyController::class, 'index'])->name('refund-policy');
    Route::post('refund-policysave', [RefundPolicyController::class, 'saveRefundPolicy'])->name('refund-policysave');



    // CancelPolicyController
    Route::get('cancel-policy', [CancelPolicyController::class, 'index'])->name('cancel-policy');
    Route::post('cancel-policysave', [CancelPolicyController::class, 'saveCancelPolicy'])->name('cancel-policysave');



    // ContactUsController
    Route::get('contactus', [ContactUsController::class, 'index'])->name('contactus');
    Route::post('contactussave', [ContactUsController::class, 'saveContactUs'])->name('contactussave');




    // SettingsController
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('mobileurl-save', [SettingsController::class, 'saveMobileUrl'])->name('mobileurl-save');
    Route::post('sitesetup-save', [SettingsController::class, 'saveSiteSetup'])->name('sitesetup-save');
    Route::post('socialmedia-save', [SettingsController::class, 'saveSocialMedia'])->name('socialmedia-save');
    // Route::post('serverconfig-save', [SettingsController::class, 'saveServerConfig'])->name('serverconfig-save');
    Route::post('commissions', [SettingsController::class, 'saveComissions'])->name('commissions-save');
    Route::post('mailsetup-save', [SettingsController::class, 'saveMailSetup'])->name('mailsetup-save');
    Route::post('smsconfig-save', [SettingsController::class, 'saveSMSConfig'])->name('smsconfig-save');
    Route::post('nearbydistance-save', [SettingsController::class, 'saveNearbyDistance'])->name('nearbydistance-save');
    Route::post('serverconfig-save/{type}', [SettingsController::class, 'saveServerConfig'])->name('serverconfig.save');



    // SupportTicketController
    Route::get('support-ticket', [SupportTicketController::class, 'index'])->name('support-ticket');
    Route::get('ticket-view/{id}', [SupportTicketController::class, 'viewTicket'])->name('ticket-view');
    Route::post('send-message', [SupportTicketController::class, 'sendMessage'])->name('sendMessage');
    Route::post('close-ticket/{id}', [SupportTicketController::class, 'closeTicket'])->name('closeTicket');






    // PaymentConfigurationController
    Route::get('payment-configuration', [PaymentConfigurationController::class, 'index'])->name('payment-configuration');
    Route::post('razorpay-save', [PaymentConfigurationController::class, 'saveRazorPay'])->name('razorpay-save');
    Route::post('flutterwave-save', [PaymentConfigurationController::class, 'saveFlutterWave'])->name('flutterwave-save');
    Route::post('stripe-save', [PaymentConfigurationController::class, 'saveStripe'])->name('stripe-save');
    Route::post('paypal-save', [PaymentConfigurationController::class, 'savePayPal'])->name('paypal-save');
    Route::post('googlepay-save', [PaymentConfigurationController::class, 'saveGooglePay'])->name('googlepay-save');
    Route::post('wallet-save', [PaymentConfigurationController::class, 'saveWallet'])->name('wallet-save');
    Route::post('applepay-save', [PaymentConfigurationController::class, 'saveApplePay'])->name('applepay-save');



    // UserEmailController
    Route::get('/useremail-detail', [UserEmailController::class, 'index'])->name('useremail-detail');
    Route::post('/email-userotpverify', [UserEmailController::class, 'emailUserOtpVerify'])->name('email-userotpverify');
    Route::get('/changeemail-userotpverifystatus/{id}', [UserEmailController::class, 'changeEmailUserOtpVerify'])->name('changeemail-userotpverifystatus');
    Route::post('/email-userforgotpassword', [UserEmailController::class, 'emailUserForgotPassword'])->name('email-userforgotpassword');
    Route::get('/changeemail-userforgotpasswordstatus/{id}', [UserEmailController::class, 'changeEmailUserForgotPassword'])->name('changeemail-userforgotpasswordstatus');
    Route::post('/email-userorderplacedservice', [UserEmailController::class, 'emailUserOrderPlacedService'])->name('email-userorderplacedservice');
    Route::get('/changeemail-userorderplacedservicestatus/{id}', [UserEmailController::class, 'changeEmailUserOrderPlaced'])->name('changeemail-userorderplacedservicestatus');
    Route::post('/email-userbookingaccepted', [UserEmailController::class, 'emailUserBookingAccepted'])->name('email-userbookingaccepted');
    Route::get('/changeemail-userbookingacceptedstatus/{id}', [UserEmailController::class, 'changeEmailUserBookingAccepted'])->name('changeemail-userbookingacceptedstatus');
    Route::post('/email-userbookinginprogress', [UserEmailController::class, 'emailUserBookingInProgress'])->name('email-userbookinginprogress');
    Route::get('/changeemail-userbookinginprogressstatus/{id}', [UserEmailController::class, 'changeEmailUserBookingInProgress'])->name('changeemail-userbookinginprogressstatus');
    Route::post('/email-userbookinghold', [UserEmailController::class, 'emailUserBookingHold'])->name('email-userbookinghold');
    Route::get('/changeemail-userbookingholdstatus/{id}', [UserEmailController::class, 'changeEmailUserBookingHold'])->name('changeemail-userbookingholdstatus');
    Route::post('/email-userbookinghold', [UserEmailController::class, 'emailUserBookingHold'])->name('email-userbookinghold');
    Route::get('/changeemail-userbookingholdstatus/{id}', [UserEmailController::class, 'changeEmailUserBookingHold'])->name('changeemail-userbookingholdstatus');
    Route::post('/email-userbookingcancelled', [UserEmailController::class, 'emailUserBookingCancelled'])->name('email-userbookingcancelled');
    Route::get('/changeemail-userbookingcancelledstatus/{id}', [UserEmailController::class, 'changeEmailUserBookingCancelled'])->name('changeemail-userbookingcancelledstatus');
    Route::post('/email-userbookingrejected', [UserEmailController::class, 'emailUserBookingRejected'])->name('email-userbookingrejected');
    Route::get('/changeemail-userbookingrejectedstatus/{id}', [UserEmailController::class, 'changeEmailUserBookingRejected'])->name('changeemail-userbookingrejectedstatus');
    Route::post('/email-userproductinprogress', [UserEmailController::class, 'emailUserProductInProgress'])->name('email-userproductinprogress');
    Route::get('/changeemail-userproductinprogressstatus/{id}', [UserEmailController::class, 'changeEmailUserProductInProgress'])->name('changeemail-userproductinprogressstatus');
    Route::post('/email-userproductdelivered', [UserEmailController::class, 'emailUserProductDelivered'])->name('email-userproductdelivered');
    Route::get('/changeemail-userproductdeliveredstatus/{id}', [UserEmailController::class, 'changeEmailUserProductDelivered'])->name('changeemail-userproductdeliveredstatus');
    Route::post('/email-usercancelledbyprovider', [UserEmailController::class, 'emailUserCancelledbyProvider'])->name('email-usercancelledbyprovider');
    Route::get('/changeemail-usercancelledbyproviderstatus/{id}', [UserEmailController::class, 'changeEmailUserCancelledbyProviderStatus'])->name('changeemail-usercancelledbyproviderstatus');
    Route::post('/email-userrefundbyprovider', [UserEmailController::class, 'emailUserRefundbyProvider'])->name('email-userrefundbyprovider');
    Route::get('/changeemail-userrefundbyproviderstatus/{id}', [UserEmailController::class, 'changeEmailUserRefundbyProviderStatus'])->name('changeemail-userrefundbyproviderstatus');



    // ProviderEmailController
    Route::get('/provideremail-detail', [ProviderEmailController::class, 'index'])->name('provideremail-detail');
    Route::post('/email-providerotpverify', [ProviderEmailController::class, 'emailProviderOtpVerify'])->name('email-providerotpverify');
    Route::get('/changeemail-providerotpverifystatus/{id}', [ProviderEmailController::class, 'changeEmailProviderOtpVerify'])->name('changeemail-providerotpverifystatus');
    Route::post('/email-providerforgotpassword', [ProviderEmailController::class, 'emailProviderForgotPassword'])->name('email-providerforgotpassword');
    Route::get('/changeemail-providerforgotpasswordstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderForgotPassword'])->name('changeemail-providerforgotpasswordstatus');
    Route::post('/email-providerordereceived', [ProviderEmailController::class, 'emailProviderOrderReceived'])->name('email-providerordereceived');
    Route::get('/changeemail-providerordereceivedstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderOrderReceived'])->name('changeemail-providerordereceivedstatus');
    Route::post('/email-providerbookingaccepted', [ProviderEmailController::class, 'emailProviderBookingAccepted'])->name('email-providerbookingaccepted');
    Route::get('/changeemail-providerbookingacceptedstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderBookingAccepted'])->name('changeemail-providerbookingacceptedstatus');
    Route::post('/email-providerbookingrejected', [ProviderEmailController::class, 'emailProviderBookingRejected'])->name('email-providerbookingrejected');
    Route::get('/changeemail-providerbookingrejectedstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderBookingRejected'])->name('changeemail-providerbookingrejectedstatus');
    Route::post('/email-providerassignhandyman', [ProviderEmailController::class, 'emailProviderAssignHandyman'])->name('email-providerassignhandyman');
    Route::get('/changeemail-providerassignhandymanstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderAssignHandyman'])->name('changeemail-providerassignhandymanstatus');
    Route::post('/email-providerrejecthandyman', [ProviderEmailController::class, 'emailProviderRejectHandyman'])->name('email-providerrejecthandyman');
    Route::get('/changeemail-providerrejecthandymanstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderRejectHandyman'])->name('changeemail-providerrejecthandymanstatus');
    Route::post('/email-providerorderinprogress', [ProviderEmailController::class, 'emailProviderOrderInProgress'])->name('email-providerorderinprogress');
    Route::get('/changeemail-providerorderinprogressstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderOrderInProgress'])->name('changeemail-providerorderinprogressstatus');
    Route::post('/email-providerorderdelivered', [ProviderEmailController::class, 'emailProviderOrderDelivered'])->name('email-providerorderdelivered');
    Route::get('/changeemail-providerorderdeliveredstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderOrderDelivered'])->name('changeemail-providerorderdeliveredstatus');
    Route::post('/email-providerbookinghold', [ProviderEmailController::class, 'emailProviderBookingHold'])->name('email-providerbookinghold');
    Route::get('/changeemail-providerbookingholdstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderBookingHold'])->name('changeemail-providerbookingholdstatus');
    Route::post('/email-providerbookingcompleted', [ProviderEmailController::class, 'emailProviderBookingCompleted'])->name('email-providerbookingcompleted');
    Route::get('/changeemail-providerbookingcompletedstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderBookingCompleted'])->name('changeemail-providerbookingcompletedstatus');
    Route::post('/email-providerpaymentreceived', [ProviderEmailController::class, 'emailProviderPaymentReceived'])->name('email-providerpaymentreceived');
    Route::get('/changeemail-providerpaymentreceivedstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderPaymentReceived'])->name('changeemail-providerpaymentreceivedstatus');
    Route::post('/email-providerpaymentsent', [ProviderEmailController::class, 'emailProviderPaymentSent'])->name('email-providerpaymentsent');
    Route::get('/changeemail-providerpaymentsentstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderPaymentSent'])->name('changeemail-providerpaymentsentstatus');
    Route::post('/email-providerreviewreceived', [ProviderEmailController::class, 'emailProviderReviewReceived'])->name('email-providerreviewreceived');
    Route::get('/changeemail-providerreviewreceivedstatus/{id}', [ProviderEmailController::class, 'changeEmailProviderReviewReceived'])->name('changeemail-providerreviewreceivedstatus');




    // HandymanEmailController
    Route::get('/handymanemail-detail', [HandymanEmailController::class, 'index'])->name('handymanemail-detail');
    Route::post('/email-handymanotpverify', [HandymanEmailController::class, 'emailHandymanOtpVerify'])->name('email-handymanotpverify');
    Route::get('/changeemail-handymanotpverifystatus/{id}', [HandymanEmailController::class, 'changeEmailHandymanOtpVerify'])->name('changeemail-handymanotpverifystatus');
    Route::post('/email-handymanforgotpassword', [HandymanEmailController::class, 'emailHandymanForgotPassword'])->name('email-handymanforgotpassword');
    Route::get('/changeemail-handymanforgotpasswordstatus/{id}', [HandymanEmailController::class, 'changeEmailHandymanForgotPassword'])->name('changeemail-handymanforgotpasswordstatus');
    Route::post('/email-handymanassignfororder', [HandymanEmailController::class, 'emailHandymanAssignForOrder'])->name('email-handymanassignfororder');
    Route::get('/changeemail-handymanassignfororderstatus/{id}', [HandymanEmailController::class, 'changeEmailHandymanAssignForOrder'])->name('changeemail-handymanassignfororderstatus');
    Route::post('/email-handymanacceptbooking', [HandymanEmailController::class, 'emailHandymanAcceptBooking'])->name('email-handymanacceptbooking');
    Route::get('/changeemail-handymanacceptbookingstatus/{id}', [HandymanEmailController::class, 'changeEmailHandymanAcceptBooking'])->name('changeemail-handymanacceptbookingstatus');
    Route::post('/email-handymanrejectbooking', [HandymanEmailController::class, 'emailHandymanRejectBooking'])->name('email-handymanrejectbooking');
    Route::get('/changeemail-handymanrejectbookingstatus/{id}', [HandymanEmailController::class, 'changeEmailHandymanRejectBooking'])->name('changeemail-handymanrejectbookingstatus');
    Route::post('/email-handymancompletedbooking', [HandymanEmailController::class, 'emailHandymanCompletedBooking'])->name('email-handymancompletedbooking');
    Route::get('/changeemail-handymancompletedbookingstatus/{id}', [HandymanEmailController::class, 'changeEmailHandymanCompletedBooking'])->name('changeemail-handymancompletedbookingstatus');
    Route::post('/email-handymanreviewreceived', [HandymanEmailController::class, 'emailHandymanReviewReceived'])->name('email-handymanreviewreceived');
    Route::get('/changeemail-handymanreviewreceivedstatus/{id}', [HandymanEmailController::class, 'changeEmailHandymanReviewReceived'])->name('changeemail-handymanreviewreceivedstatus');




    // NotificationTemplateController
    Route::get('notification-template', [NotificationTemplateController::class, 'index'])->name('notification-template');
    Route::get('notification-templateedit/{id}', [NotificationTemplateController::class, 'editNotificationTemplate'])->name('notification-templateedit');
    Route::post('notification-templateupdate/{id}', [NotificationTemplateController::class, 'updateNotificationTemplate'])->name('notification-templateupdate');
    Route::get('change-notificationtemplatestatus/{id}',  [NotificationTemplateController::class, 'changeNotificationTemplateStatus'])->name('change-notificationtemplatestatus');






    // Provider Routes
    // ProviderHandymanController
    Route::get('providerhandyman-list', [ProviderHandymanController::class, 'index'])->name('providerhandyman-list');
    Route::get('providerhandyman-add', [ProviderHandymanController::class, 'addProviderHandyman'])->name('providerhandyman-add');
    Route::post('providerhandyman-save', [ProviderHandymanController::class, 'saveProviderHandyman'])->name('providerhandyman-save');
    Route::get('providerhandyman-edit/{id}', [ProviderHandymanController::class, 'editProviderHandyman'])->name('providerhandyman-edit');
    Route::post('providerhandyman-update/{id}', [ProviderHandymanController::class, 'updateProviderHandyman'])->name('providerhandyman-update');
    Route::post('providerhandyman-delete/{id}', [ProviderHandymanController::class, 'deleteProviderHandyman'])->name('providerhandyman-delete');
    Route::get('providerhandyman-view/{id}', [ProviderHandymanController::class, 'viewProviderHandyman'])->name('providerhandyman-view');
    Route::get('/providerhandyman/{id}/earnings/{year}', [ProviderHandymanController::class, 'getProviderHandymanMonthlyEarnings'])->name('handyman.providerearnings');
    Route::get('change-providerhandymanlistblocked/{id}',  [ProviderHandymanController::class, 'ChangeProviderHandymanListBlocked'])->name('change-providerhandymanlistblocked');



    // ProviderHandymanRequestListController
    Route::get('providerhandyman-requestlist', [ProviderHandymanRequestListController::class, 'index'])->name('providerhandyman-requestlist');
    Route::get('providerhandyman-requestapproval/{id}', [ProviderHandymanRequestListController::class, 'ProviderhandymanRequestApproval'])->name('providerhandyman-requestapproval');
    Route::post('providerhandyman-ignore/{id}', [ProviderHandymanRequestListController::class, 'ignoreProviderHandyman'])->name('providerhandyman-ignore');



    // ProviderHandymanEarningsController
    Route::get('providerhandyman-earnings', [ProviderHandymanEarningsController::class, 'index'])->name('providerhandyman-earnings');



    // ProviderHandymanReviewListController
    Route::get('providerhandyman-reviewlist', [ProviderHandymanReviewListController::class, 'index'])->name('providerhandyman-reviewlist');
    Route::post('providerhandymanreview-delete/{id}', [ProviderHandymanReviewListController::class, 'deleteProviderHandymanReview'])->name('providerhandymanreview-delete');



    // FaqController
    Route::get('faq-list', [FaqController::class, 'index'])->name('faq-list');
    Route::get('faq-add', [FaqController::class, 'addFaq'])->name('faq-add');
    Route::post('faq-save', [FaqController::class, 'saveFaq'])->name('faq-save');
    Route::get('faq-edit/{id}', [FaqController::class, 'editFaq'])->name('faq-edit');
    Route::post('faq-update/{id}', [FaqController::class, 'updateFaq'])->name('faq-update');
    Route::post('faq-delete/{id}', [FaqController::class, 'deleteFaq'])->name('faq-delete');



    // ProviderServiceController
    Route::get('providerservice-list', [ProviderServiceController::class, 'index'])->name('providerservice-list');
    Route::get('providerservice-add', [ProviderServiceController::class, 'addProviderService'])->name('providerservice-add');
    Route::post('providerservice-save', [ProviderServiceController::class, 'saveProviderService'])->name('providerservice-save');
    Route::get('providerservice-edit/{id}', [ProviderServiceController::class, 'editProviderService'])->name('providerservice-edit');
    Route::post('providerservice-update/{id}', [ProviderServiceController::class, 'updateProviderService'])->name('providerservice-update');
    Route::post('providerservice-delete/{id}', [ProviderServiceController::class, 'deleteProviderService'])->name('providerservice-delete');
    Route::get('change-providerservicestatus/{id}',  [ProviderServiceController::class, 'ChangeProviderServiceStatus'])->name('change-providerservicestatus');
    Route::get('/get-providersubcategories/{categoryId}', [ProviderServiceController::class, 'getProviderSubcategories']);
    Route::post('providerservice-imagedelete/{id}', [ProviderServiceController::class, 'providerimageDeleteService'])->name('providerservice-imagedelete');
    Route::get('change-providerservicelinkstatus/{id}',  [ProviderServiceController::class, 'changeProviderServiceLinkStatus'])->name('change-providerservicelinkstatus');



    // ProviderProductController
    Route::get('providerproduct-list', [ProviderProductController::class, 'index'])->name('providerproduct-list');
    Route::get('providerproduct-add', [ProviderProductController::class, 'addProviderProduct'])->name('providerproduct-add');
    Route::post('providerproduct-save', [ProviderProductController::class, 'saveProviderProduct'])->name('providerproduct-save');
    Route::get('providerproduct-edit/{id}', [ProviderProductController::class, 'editProviderProduct'])->name('providerproduct-edit');
    Route::post('providerproduct-update/{id}', [ProviderProductController::class, 'updateProviderProduct'])->name('providerproduct-update');
    Route::post('providerproduct-delete/{id}', [ProviderProductController::class, 'deleteProviderProduct'])->name('providerproduct-delete');
    Route::get('change-providerproductstatus/{id}',  [ProviderProductController::class, 'ChangeProviderProductStatus'])->name('change-providerproductstatus');
    Route::post('providerproduct-imagedelete/{id}', [ProviderProductController::class, 'imageDeleteProviderProduct'])->name('providerproduct-imagedelete');
    Route::get('change-providerproductliststatus/{product_id}',  [ProviderProductController::class, 'changeProviderProductListStatus'])->name('change-providerproductliststatus');



    // HandymanCommissionController
    Route::get('handyman-commission', [HandymanCommissionController::class, 'index'])->name('handyman-commission');
    Route::post('handyman-commissionsave', [HandymanCommissionController::class, 'saveHandymanCommission'])->name('handyman-commissionsave');


    // ProviderWithdrawRequestController
    Route::get('providerwithdraw-request', [ProviderWithdrawRequestController::class, 'index'])->name('providerwithdraw-request');



    // ProviderHandymanPaymentRequestController
    Route::get('providerhandyman-paymentrequest', [ProviderHandymanPaymentRequestController::class, 'index'])->name('providerhandyman-paymentrequest');
    Route::get('providerhandyman-paymentrequestapproval/{id}', [ProviderHandymanPaymentRequestController::class, 'ProviderhandymanPaymentRequestApproval'])->name('providerhandyman-paymentrequestapproval');
    Route::post('providerhandyman-paymentreject/{id}', [ProviderHandymanPaymentRequestController::class, 'rejectPaymentProviderHandyman'])->name('providerhandyman-paymentreject');
    Route::get('providerhandyman-approvedlist', [ProviderHandymanPaymentRequestController::class, 'ProviderHandymanApprovedList'])->name('providerhandyman-approvedlist');
    Route::get('providerhandyman-rejectlist', [ProviderHandymanPaymentRequestController::class, 'ProviderHandymanRejectedList'])->name('providerhandyman-rejectlist');





    // ProviderBookingListController
    Route::get('providerbooking-list', [ProviderBookingListController::class, 'index'])->name('providerbooking-list');
    Route::post('providerbooking-delete/{id}', [ProviderBookingListController::class, 'deleteProviderBooking'])->name('providerbooking-delete');
    Route::get('providerbooking-view/{id}', [ProviderBookingListController::class, 'viewProviderBooking'])->name('providerbooking-view');
    Route::post('/providerassign-handyman/{id}', [ProviderBookingListController::class, 'assignProviderHandyman'])->name('assign.providerhandyman');




    // UserListController
    Route::get('provideruser-view/{id}', [ProviderUserListController::class, 'viewProviderUser'])->name('provideruser-view');



    // ServiceBookingListController
    Route::get('pending-bookinglist', [ServiceBookingListController::class, 'index'])->name('pending-bookinglist');
    Route::post('servicebooking-delete/{id}', [ServiceBookingListController::class, 'deleteServiceBooking'])->name('servicebooking-delete');
    Route::get('accepted-bookinglist', [ServiceBookingListController::class, 'acceptedBookingList'])->name('accepted-bookinglist');
    Route::get('rejected-bookinglist', [ServiceBookingListController::class, 'rejectedBookingList'])->name('rejected-bookinglist');
    Route::get('inprogress-bookinglist', [ServiceBookingListController::class, 'inprogressBookingList'])->name('inprogress-bookinglist');
    Route::get('completed-bookinglist', [ServiceBookingListController::class, 'completedBookingList'])->name('completed-bookinglist');
    Route::get('cancelled-bookinglist', [ServiceBookingListController::class, 'cancelledBookingList'])->name('cancelled-bookinglist');
    Route::get('hold-bookinglist', [ServiceBookingListController::class, 'holdBookingList'])->name('hold-bookinglist');
    Route::get('get-booking-counts', [ServiceBookingListController::class, 'getBookingCounts'])->name('get-booking-counts');



    // AllUsersListController
    Route::get('all-users', [AllUsersListController::class, 'index'])->name('all-users');
    Route::get('change-userblocked/{id}',  [AllUsersListController::class, 'ChangeUserBlocked'])->name('change-userblocked');



    // ProductBookingListController
    Route::get('all-productbookinglist', [ProductBookingListController::class, 'allProductBookingList'])->name('all-productbookinglist');
    Route::get('inprogress-productbookinglist', [ProductBookingListController::class, 'index'])->name('inprogress-productbookinglist');
    Route::post('productbooking-delete/{id}', [ProductBookingListController::class, 'deleteProductBooking'])->name('productbooking-delete');
    Route::get('delivered-productbookinglist', [ProductBookingListController::class, 'deliveredProductBooking'])->name('delivered-productbookinglist');
    Route::get('cancelled-productbookinglist', [ProductBookingListController::class, 'cancelledProductBooking'])->name('cancelled-productbookinglist');
    Route::get('pending-productbookinglist', [ProductBookingListController::class, 'pendingProductBooking'])->name('pending-productbookinglist');
    Route::get('cancelledbyuser-productbookinglist', [ProductBookingListController::class, 'cancelledbyUserProductBooking'])->name('cancelledbyuser-productbookinglist');
    Route::get('get-productbooking-counts', [ProductBookingListController::class, 'getProductBookingCounts'])->name('get-productbooking-counts');



    // CurrenciesController
    Route::get('currencies-list', [CurrenciesController::class, 'index'])->name('currencies-list');
    Route::get('currencies-add', [CurrenciesController::class, 'addCurrencies'])->name('currencies-add');
    Route::post('currencies-save', [CurrenciesController::class, 'saveCurrencies'])->name('currencies-save');
    Route::post('currencies-delete/{id}', [CurrenciesController::class, 'deleteCurrencies'])->name('currencies-delete');


    // NotificationDataController
    Route::get('notificationdata-list', [NotificationDataController::class, 'index'])->name('notificationdata-list');
    Route::post('/mark-notifications-as-read', [NotificationDataController::class, 'markNotificationsAsRead']);
    Route::post('/update-notification-color/{id}', [NotificationDataController::class, 'updateColor']);





    // SliderListController
    Route::get('slider-list', [SliderListController::class, 'index'])->name('slider-list');
    Route::get('slider-add', [SliderListController::class, 'addSlider'])->name('slider-add');
    Route::post('slider-save', [SliderListController::class, 'saveSlider'])->name('slider-save');
    Route::post('slider-delete/{id}', [SliderListController::class, 'deleteSlider'])->name('slider-delete');
    Route::get('slider-edit/{id}', [SliderListController::class, 'editSlider'])->name('slider-edit');
    Route::post('slider-update/{id}', [SliderListController::class, 'updateSlider'])->name('slider-update');



    // ProviderServiceBookingListController
    Route::get('providerpending-bookinglist', [ProviderServiceBookingListController::class, 'index'])->name('providerpending-bookinglist');
    Route::get('provideraccepted-bookinglist', [ProviderServiceBookingListController::class, 'provideracceptedBookingList'])->name('provideraccepted-bookinglist');
    Route::get('providerrejected-bookinglist', [ProviderServiceBookingListController::class, 'providerrejectedBookingList'])->name('providerrejected-bookinglist');
    Route::get('providerinprogress-bookinglist', [ProviderServiceBookingListController::class, 'providerinprogressBookingList'])->name('providerinprogress-bookinglist');
    Route::get('providercompleted-bookinglist', [ProviderServiceBookingListController::class, 'providercompletedBookingList'])->name('providercompleted-bookinglist');
    Route::get('providercancelled-bookinglist', [ProviderServiceBookingListController::class, 'providercancelledBookingList'])->name('providercancelled-bookinglist');
    Route::get('providerhold-bookinglist', [ProviderServiceBookingListController::class, 'providerholdBookingList'])->name('providerhold-bookinglist');
    Route::get('get-providerbooking-counts', [ProviderServiceBookingListController::class, 'getproviderBookingCounts'])->name('get-providerbooking-counts');



    // ProviderProductBookingListController
    Route::get('providerinprogress-productbookinglist', [ProviderProductBookingListController::class, 'index'])->name('providerinprogress-productbookinglist');
    Route::get('providerdelivered-productbookinglist', [ProviderProductBookingListController::class, 'deliveredproviderProductBooking'])->name('providerdelivered-productbookinglist');
    Route::get('providercancelled-productbookinglist', [ProviderProductBookingListController::class, 'cancelledproviderProductBooking'])->name('providercancelled-productbookinglist');
    Route::get('providerpending-productbookinglist', [ProviderProductBookingListController::class, 'pendingproviderProductBooking'])->name('providerpending-productbookinglist');
    Route::get('providercancelledbyuser-productbookinglist', [ProviderProductBookingListController::class, 'cancelledbyUserproviderProductBooking'])->name('providercancelledbyuser-productbookinglist');
    Route::get('get-providerproductbooking-counts', [ProviderProductBookingListController::class, 'getProviderProductBookingCounts'])->name('get-providerproductbooking-counts');




    // TaxController
    Route::get('tax-list', [TaxController::class, 'index'])->name('tax-list');
    Route::get('tax-add', [TaxController::class, 'addTax'])->name('tax-add');
    Route::post('tax-save', [TaxController::class, 'saveTax'])->name('tax-save');
    Route::get('tax-edit/{id}', [TaxController::class, 'editTax'])->name('tax-edit');
    Route::post('tax-update/{id}', [TaxController::class, 'updateTax'])->name('tax-update');
    Route::post('tax-delete/{id}', [TaxController::class, 'deleteTax'])->name('tax-delete');
    Route::get('change-taxstatus/{id}',  [TaxController::class, 'changeTaxStatus'])->name('change-taxstatus');
    Route::post('/toggle-user-type', [TaxController::class, 'toggleUserType'])->name('toggle-user-type');



    // LanguageListController
    Route::get('language-list', [LanguageListController::class, 'index'])->name('language-list');
    Route::get('language-translatelist/{status_id}', [LanguageListController::class, 'languageTranslateList'])->name('language-translatelist');
    Route::get('language-add', [LanguageListController::class, 'addLanguageDynamic'])->name('language-add');
    Route::post('language-save', [LanguageListController::class, 'saveLanguageDynamic'])->name('language-save');
    Route::get('language-edit/{status_id}', [LanguageListController::class, 'editLanguageDynamic'])->name('language-edit');
    Route::post('language-update/{status_id}', [LanguageListController::class, 'updateLanguageDynamic'])->name('language-update');
    Route::get('change-languageliststatus/{status_id}',  [LanguageListController::class, 'changeLanguageListStatus'])->name('change-languageliststatus');
    Route::post('change-languagelistdefaultstatus', [LanguageListController::class, 'changeLanguageListeDefaultStatus'])->name('change-languagelistdefaultstatus');


    // TaxController
    Route::get('payout-listprovider', [PayOutListProviderController::class, 'index'])->name('payout-listprovider');
    Route::get('change-payoutlistprovider/{id}',  [PayOutListProviderController::class, 'ChangeProviderPayoutListStatus'])->name('change-payoutlistprovider');
});
