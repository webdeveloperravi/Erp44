<?php

use Google\Client;
use sendotp\sendotp;
use Google\Service\Gmail;
use App\Models\Front\User;
use Illuminate\Http\Request;
use App\Model\Front\Blog_Post;
use App\Model\Guard\UserStore;
use Google\Service\Gmail\Message;
use App\Model\Admin\Setting\Guard;
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Master\Country;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Model\Admin\Master\CountryCode;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Organization\AddressType;
use App\Http\Controllers\front\FrontController;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

Route::middleware('storeChecker')->group(function () {

    //products routes
   
    Route::get('/', [FrontController::class, 'home'])->name('9gemhome');
    Route::view('/{product_name}/{product_item_id}/product-details', 'front.product-details')->name('9gem_product_details');
    Route::view('/search', 'front.search_results')->name('9gem_search_results');
    Route::view('/{product_name}/product_items_list', 'front.product-items-list')->name('9gem_product_items_list');
    Route::get('/{product_name}/product_items_list/catalogue',  [FrontController::class, 'proCatalogue'])->name('9gem_product_items_list_catalogue');
    Route::get('/search/catalogue/{query}',  [FrontController::class, 'searchCatalogue'])->name('pro_search_catalogue');
    Route::view('/my-cart', 'front.user-cart')->name('9gem_user_cart');
    Route::view('/checkout', 'front.checkout')->name('9gem_user_checkout');
    Route::get('/order/{slug}/shipping_details', [FrontController::class, 'shippingDetails'])->name('9gem_user_order_shipping_details');
    Route::post('/order/shipping_details', [FrontController::class, 'shippingDetailsPost'])->name('9gem_user_order_shipping_details_post');
    Route::post('/user/place-order', [FrontController::class, 'userPlaceOrder'])->name('9gem_user_place_order');
    Route::view('/user/order-placed', 'front.thankyou')->name('9gem_order_placed')->middleware('OrderPlaced');
    Route::post('/user/add-new-address',  [FrontController::class, 'addUserNewAddress'])->name('9gem_add_new_address');
    Route::get('/user/account/orders/{order_id}/order-details',  [FrontController::class, 'userOrderDetails'])->name('9gem_user_order_details');
    Route::post('/user/cancel-order',  [FrontController::class, 'cancelOrder'])->name('9gem_cancel_order');
    Route::get('/user/order/{slug}/track',  [FrontController::class, 'trackOrder'])->name('9gem_track_order');
    Route::get('capture_payment', [FrontController::class, 'captureOnlinePayment']);


    //blogs routes
    Route::prefix('blog')->group(function () {

        Route::get('/{category}/list_all_blogs', [FrontController::class, 'list_all_blogs'])->name('9gem_allblogs');
        Route::get('/search', [FrontController::class, 'blogSearchResults'])->name('9gem_blog_search');
        Route::get('/{tag}', [FrontController::class, 'tagRelatedBlogs'])->name('9gem_tag_related_blog');
        Route::get('/{category}/view_blog/{blog_slug}/{blogname}', [FrontController::class, 'post_details'])->name('9gem_blog_details');
        Route::post('/comment', [FrontController::class, 'post_comment'])->name('9gem_post_comment');
        Route::get('category/{category_id}/catalogue', [FrontController::class, 'catalogue'])->name('9gem_blog_catalogue');
        Route::post('/comment', [FrontController::class, 'post_comment'])->name('9gem_post_comment');
    });



    //pages routes
    Route::prefix('page')->group(function () {
        Route::get('{url_slug}', [FrontController::class, 'page_details'])->name('page.details');
    });

    //user 
    Route::prefix('user')->group(function () {
        Route::get('register', [FrontController::class, 'userRegister'])->name('9gem_user_register');
        Route::post('register', [FrontController::class, 'userRegisterPost'])->name('9gem_user_register_post');
        Route::get('get-country-states', [FrontController::class, 'getStates'])->name('9gem_get_states');
        Route::get('get-country-cities', [FrontController::class, 'getcities'])->name('9gem_get_cities');
        Route::view('login', 'front.user_login')->name('9gem_user_login');
        Route::post('login', [FrontController::class, 'user_login_post'])->name('9gem_user_login_post');
        Route::post('login/verifyOtp', [FrontController::class, 'verifyOtp'])->name('9gem_user_login_verify_otp');
        Route::any('login/resendOtp', [FrontController::class, 'resendOtp'])->name('9gem_resend_otp');
        Route::get('logout', [FrontController::class, 'admin_logout'])->name('9gem_user_logout');
        Route::get('account', [FrontController::class, 'show_user_account'])->name('9gem_user_account')->middleware('UserAuth');
        Route::get('wishlist', [FrontController::class, 'show_user_wishlist'])->name('9gem_user_wishlist')->middleware('UserAuth');
        Route::get('/get_youtube_token', [FrontController::class, 'get_youtube_token'])->name('9gem_get_youtube_token');
    });
});





// Route::group(['middleware' => 'GetUtubeToken'], function () {
//     Route::get('/admin/youtube_video/upload', [FrontController::class, 'admin_video_upload'])->name('9gem_video_upload');
//     Route::post('/admin/youtube_video/upload', [FrontCotroller::class, 'admin_video_upload_post'])->name('9gem_video_upload_post');
//     Route::post('/admin/google_drive_upload', [FrontController::class, 'google_drive_upload'])->name('9gem_google_drive_upload');
// });





// Route::get('/googlemaps', function () {-
//     return view('front.googlemaps');
// })->name('googlemaps');

// Route::get('/getlocation', [FrontController::class, 'getlonglat'])->name('getlocation');



// Route::get('/gmail', function (Request $request) {



//     // dd($res->json()['access_token']);

//     $client = new Client(); //class from google api-client library
//     $client->setApplicationName('webtecz-gmail');
//     $client->setScopes([
//         'https://mail.google.com/',
//         'https://www.googleapis.com/auth/gmail.modify',
//         'https://www.googleapis.com/auth/gmail.compose',
//         'https://www.googleapis.com/auth/gmail.send',

//     ]);

//     $client->setAuthConfig(public_path('creds\gmail.json'));
//     $client->setAccessType('offline');
//     $res = Http::asForm()->post('https://oauth2.googleapis.com/token', [
//         'client_id' => '57586386431-sva2cffrsl589u85oq0ifoacs43nt8q6.apps.googleusercontent.com',
//         'client_secret' => 'EQ53J7A2rK7erMh3TMezmypx',
//         'refresh_token' => '1//0gS_Z_topL3-cCgYIARAAGBASNwF-L9IrPEEt7pvKy6SmaXuE49g1ssi8uv6szwEACOQq8tYaPY0nRBoMaz1rNZPxlAAsNictez4',
//         'grant_type' => 'refresh_token',

//     ]);
//     $authUrl = $client->createAuthUrl();

//     if ($request->all()) {
//         $authCode = $request['code'];
//         // Exchange authorization code for an access token.
//         $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
//         // dd($accessToken);
//         $client->setAccessToken($res->json()['access_token']);
//         $service = new Google\Service\Gmail($client);

//         $message = new Google\Service\Gmail\Message();
//         $sender = "webdeveloperravikumar@gmail.com"; //authenticated user email
//         $to = "developer4@webtecz.com";
//         $subject = "test subject";
//         $messageText = "hey bro!, what's up!";
//         $rawMessageString = "From: <{$sender}>\r\n";
//         $rawMessageString .= "To: <{$to}>\r\n";
//         $rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode($subject) . "?=\r\n";
//         $rawMessageString .= "MIME-Version: 1.0\r\n";
//         $rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
//         $rawMessageString .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
//         $rawMessageString .= "{$messageText}\r\n";

//         $rawMessage = strtr(base64_encode($rawMessageString), array('+' => '-', '/' => '_'));
//         $message->setRaw($rawMessage);
//         try {
//             $message = $service->users_messages->send('webdeveloperravikumar@gmail.com', $message);
//             print 'Message with ID: ' . $message->getId() . ' sent.';
//             return response()->json('Email sent successfully');
//         } catch (Exception $e) {
//             print 'An error occurred: ' . $e->getMessage();
//         }
//     } else {
//         return redirect($authUrl);
//     }
// });


// Route::view('/amazon-aws-s3-file_upload', 'front.awsTest')->name('aws');
// Route::post('/amazon-aws-s3-file_upload', [FrontController::class, 'aws'])->name('aws');





// Route::view('razorpay', 'front.razorpay')->name('razorpay');
// Route::post('razorpay', function (Request $request) {

//     $total_amount = 20000; //total payment amount 
//     $order_slug = 1100; //total payment amount
//     $user_id = 1001; //total payment amount

//     $encrypt_method = "AES-256-CBC";
//     $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
//     $secret_iv = '5fgf5HJ5g27'; // user define secret key
//     $key = hash('sha256', $secret_key);
//     $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
//     $total_amount = openssl_encrypt($total_amount, $encrypt_method, $key, 0, $iv);
//     $order_slug = openssl_encrypt($order_slug, $encrypt_method, $key, 0, $iv);

//     $total_amount = base64_encode($total_amount); //encrypted payment amount
//     $order_slug = base64_encode($order_slug); //encrypted payment amount

//     return redirect('https://9gem.in/api/razorpay?amt=' . $total_amount . '&slug=' . $order_slug . '&user_id=' . $user_id); //payment initialization
// })->name('razorpay_post');

// return UserStore::addSelect([
//     'guard' => Guard::select('name')
//         ->whereColumn('guard_id', 'guard.id')
//         ->limit(1)
// ])->get()->take(10)->dump();


Route::view('welcome', 'email_templates.msg91.welcome');
Route::view('welcome_2', 'email_templates.msg91.welcome_2');


// Route::view('webhook', 'webhook');
// Route::view('facebook', 'facebook');
