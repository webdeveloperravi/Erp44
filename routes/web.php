<?php

use Google\Client;
use \Mailjet\Resources;
use Barryvdh\DomPDF\PDF;
use App\Model\Store\Ledger;
use App\Model\Guard\UserStore;
use App\Exports\TestingExport;
use App\Model\Store\LedgerDetail;
use Illuminate\Support\Collection;
use App\Model\Admin\Setting\Module;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use App\Model\Store\StockLedger\StoreStockLedger;
use App\Model\Warehouse\InvoiceDetailGradePacket;
use App\Model\Admin\Master\ProductGradeRateProfile;
use App\Model\Warehouse\InvoiceDetailGradeProduct;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('wallah', function () {

    // $data= UserStore::find(1001)->zones->each(function($q){
    //      $q->cities->each(function($qq){
    //            $qq->pluck('id');
    //      });
    // });
    dd(Module::find(23)->getAllParents());
    // $data  = UserStore::find(1001)->zones->pluck('id')->toArray();
    // $data = \App\Model\Admin\Organization\ZoneCity::whereIn('zone_id',$data)->pluck('city_id')->toArray();


    // // $data =  UserStore::with('zones.cities')->whereId(1001)->pluck('zones.cities.id');
    // dd($data);
});

Route::get('send', function () {

    $mobile = '919914263105';
    $securityPin = 9111;
    $response = Http::withHeaders([
        'authkey' => '366219AHCQOCsL6142f86aP1',
        'content-type' => 'application/JSON'
    ])->post('https://api.msg91.com/api/v5/flow/', [
        'flow_id' => '61545ff0b82ac0701c50add8',
        'sender' => 'Gemlab',
        'mobiles' => '919914263105',
        'pin' => $securityPin,
    ]);
    dd($response);
});

Route::get('dump', function () {
    UserStore::get()->each(function ($record) {
        $record->update(['security_pin' => bcrypt('1234')]);
    });
    dd('saab');

    $authUser = UserStore::find(auth('store')->user()->id);
    $store1Accounts = UserStore::where(['org_id' => $authUser->id])
        ->whereIn('type', ['user'])
        ->pluck('id')->toArray();
    $store1Accounts = array_merge($store1Accounts, [$authUser->id]);

    $countCarat = StoreStockLedger::whereIn('to', $store1Accounts)
        ->whereIn('voucher_type', [2, 1])
        ->get()->pluck('id')->toArray();

    $countCarat = LedgerDetail::where('new_ledger_id', null)->whereIn('ledger_id', $countCarat)->pluck('gin');
    dd($countCarat);
});

Route::get('email-send', function () {

    $res =  Http::post("https://api.msg91.com/api/v5/email/send",   [
        'to' => [array("name" => "Nand", "email" => "developer2@webtecz.com")],
        'from' => array("name" => "Ravi KUMAR", "email" => "developer4@9gem.in"),
        'domain' => '9gem.in',
        'mail_type_id' => '1',
        'template_id' => 'testTemplatee',
        'authkey' => '366219AVJcx9z5cdET61247ee8P1'
    ]);

    dd(json_decode((string)$res));
});
//     //         dd($res->json());



//        $res = Http::withBody(

//         {
//             "to": [
//               {
//                 "name": "Nand kishore",
//                 "email": "developer2@webtecz.com"
//               }
//             ],
//             "from": {
//               "name": "Ravi kumar",
//               "email": "developer4@9gem.in"
//             },
//             "domain": "9gem.in",
//             "mail_type_id": "1",
//             "template_id": "testTemplatee",
//             "authkey": "366219AHCQOCsL6142f86aP1"
//           }

//        )->post("https://api.msg91.com/api/v5/email/send");


// });

//   Http::post("https://api.msg91.com/api/v5/email/send")
//   ->withBody()


//   {

//     "to": [
//         {
//           "name": "Nand kishore",
//           "email": "developer2@webtecz.com"
//         }
//       ],
//       "from": {
//         "name": "Ravi kumar",
//         "email": "developer4@9gem.in"
//       },
//       "domain": "9gem.in",
//       "mail_type_id": "1",
//       "template_id": "testTemplatee",
//       "authkey": "366219AHCQOCsL6142f86aP1"
//     }

// });  








//     $client= new GuzzleHttpClient();
//   $response=$client->request('POST','https://api.msg91.com/api/v5/email/send',
//   'headers'=>[
//     'Content-Type'=>'application/json',
//     'Accept'=>'application/json',
//   ],
//   'json'=>[
//     'to'=>[ array("name"=>"Recipient Name", "email"=>"Recipient Email") ],
//     'from'=>array("name"=>"Sender Name", "email"=> "Sender Email"),
//     'cc'=>[array("email"=>"cc@dummy.com") , array("email"=>"test@dummy.com") ],
//     'bcc'=>[array("email"=>"bcc@dummy.com") , array("email"=>"testy@dummy.com") ],
//     'domain' => 'The domain which you have registered with us.',
//     'mail_type_id' => '1 for Transactional, 2 for Notificational, 3 for Promotional',
//     'in_reply_to'=>'Id of mail which you want to reply.',
//     'attachments'=>[array("filePath"=> "Public path for file.", "fileName"=>"File Name")],
//     'template_id' => 'YOUR_TEMPLATE_ID',
//     'variables'=> array(
//       'VAR1'=> 'VAR1 VALUE',
//       'VAR2'=> 'VAR2 VALUE'
//     ),
//     'authkey'=> 'YOUR_MSG91_AUTH_KEY'
//     ],
//   ]);
//   $body=$response->getBody();
//   print_r(json_decode((string)$body));

Route::get('collection', function () {
    return 'hello';
});



Route::get('batch-process', function () {

    //Delete Cash Acounts From UserStore
    // UserStore::where('name','Cash')->delete();

    //Delete cash accopunts
    // UserStore::where('account_group_id',13)->delete();

    //Delete Account Group Cash 13 UID





    LedgerDetail::where('total_amount', null)->orWhere('total_amount', 0)->get()->each(function ($record) {

        $amt = $record->product_amount;
        LedgerDetail::where('id', $record->id)->update(['total_amount' => $amt]);
    });

    $ledgers = Ledger::where('total_amount', 0)->orWhere('total_amount', null)->get()->each(function ($ledger) {
        $ledgerId = $ledger->id;

        $productsAmount = $ledger->countProductAmount($ledgerId);
        $rattiRateWithoutTax = $ledger->countRattiRateWithoutTax($ledgerId);
        $mrpWithoutTax = $ledger->countMrpWithoutTax($ledgerId);
        $discount = $ledger->countTotalDiscount($ledgerId);
        $amountWithDiscount = $ledger->countAmountWithDiscount($ledgerId);
        $tax = $ledger->countTotalTax($ledgerId);
        $totalAmount = $ledger->countTotalAmount($ledgerId);
        $totalQty = $ledger->countTotalQty($ledgerId);

        Ledger::where('id', $ledgerId)->update([
            'products_amount' => $productsAmount,
            'ratti_rate_without_tax' => $rattiRateWithoutTax,
            'mrp_without_tax' => $mrpWithoutTax,
            'discount_amount' => $discount,
            'amount_with_discount' => $amountWithDiscount,
            'tax_amount' => $tax,
            'total_amount' => $totalAmount,
            'qty_total' => $totalQty,
        ]);
    });
    return 'true';
});


Route::get('done-drome', function () {

    $details = LedgerDetail::whereHas('productStock', function ($q) {
        $q->where('product_id', 2)->where('grade_id', 2)->where('ratti_id', 2);
    })->with('ledger.userReceipt', 'ledger.userIssue')->get();


    $details = UserStore::query()
        // ->withCount('receiptLedgers.ledgerDetails')
        // ->whereHas('issuedLedgers.ledgerDetails',function($q){
        //     $q->where('new_ledger_id',null);
        // })
        // ->whereHas('issuedLedgers.ledgerDetails.productStock',function($q){
        //     $q->where('product_id',8)->orWhere('grade_id',2)->orWhere('ratti_id',2);
        // })
        ->whereHas('receiptLedgers.ledgerDetails.productStock', function ($q) {
            $q->where('product_id', 8)->orWhere('grade_id', 2)->orWhere('ratti_id', 2);
        })

        ->limit(2)
        ->get();
    dd($details);
});

// Route::domain('{subdomain}.'.config('app.short_url'))->group(function () {
//     Route::get('/checking', 'WebController@checking')->name('products.index'); 
// });
Route::get('update-rate-profiles', function () {

    // // InvoiceDetailGradeProduct::where('product_id','>',0)->update(['rate_profile_id'=>0]);
    // $data = InvoiceDetailGradeProduct::select('id','grade_id','product_id','rate_profile_id')
    // ->chunk(5000, function ($products) {
    //     foreach ($products as $product){

    //         $rateProfileId =  ProductGradeRateProfile::where([
    //             'product_id' => $product->product_id,
    //             'grade_id'=> $product->grade_id,
    //             'status'=> 1
    //         ])->first()->assignRateProfile->id ?? false;

    //         if($rateProfileId){
    //                 $product->update(['rate_profile_id' => $rateProfileId]); 
    //          }
    //     }
    // });
    // return 'Success';
    return 'falied';
});

Route::get('sidhu', function () {

    Ledger::where('voucher_type', 5)->get()->each(function ($record) {

        $from = $record->from;
        $to = $record->to;
        $accountId = StoreHelper::getUserStoreId($to);
        $record->update(['account_id' => $accountId]);
    });


    UserStore::where('account_group_id', 12)->update(['type' => 'bank']);
    // $p = InvoiceDetailGradeProduct::where('in_stock',0)->pluck('id')->toArray();
    // $d = LedgerDetail::pluck('gin')->toArray(); 
    // $saab[] = [''];
    // foreach($p as $pro){
    //     if(!in_array($pro,$d)){
    //         $saab[] = $pro;
    //     }
    // }
    // dd($saab);
    // foreach(LedgerDetail::where('total_amount',null)->get() as $detail){
    //      $detail->total_amount = $detail->product_amount ?? null;
    //      $detail->save();
    // }

    // foreach(Ledger::where('voucher_type',2)->get() as $ledger){

    //     $ledgerId = $ledger->id;
    //     $productsAmount = $ledger->countProductAmount($ledgerId);
    //     $rattiRateWithoutTax = $ledger->countRattiRateWithoutTax($ledgerId);
    //     $mrpWithoutTax = $ledger->countMrpWithoutTax($ledgerId);
    //     $discount = $ledger->countTotalDiscount($ledgerId);
    //     $amountWithDiscount = $ledger->countAmountWithDiscount($ledgerId);
    //     $tax = $ledger->countTotalTax($ledgerId);
    //     $totalAmount = $ledger->countTotalAmount($ledgerId);
    //     $totalQty = $ledger->countTotalQty($ledgerId);

    //     Ledger::where('id',$ledger->id) ->update([
    //         'products_amount' => $productsAmount,
    //         'ratti_rate_without_tax' => $rattiRateWithoutTax,
    //         'mrp_without_tax' => $mrpWithoutTax,
    //         'discount_amount' => $discount,
    //         'amount_with_discount' => $amountWithDiscount,
    //         'tax_amount' => $tax,
    //         'total_amount' => $totalAmount,
    //         'qty_total' => $totalQty,
    //     ]);
    // }    
    dd('saab2');
});

Route::get('/oauth/gmail', function () {
    return LaravelGmail::redirect();
});

Route::get('/oauth/gmail/callback', function () {
    LaravelGmail::makeToken();
    return redirect()->to('/');
});

Route::get('/oauth/gmail/logout', function () {
    LaravelGmail::logout(); //It returns exception if fails
    return redirect()->to('/');
});
Route::get('migrate', function () {
    return Artisan::call('migrate');
});


Route::get('burberry', function () {
    // $stores = UserStore::whereIn('type',['org','lab'])->each(function($store){
    //         $store->subDomain()->create(['name' => str_replace(' ', '',substr($store->company_name,0,8)) ?? "",'domain_type_id'=> 2]);
    // });
    dd('saab');
    // Session::put('reauthenticate.last_authentication',time()); 
    // Session::put('reauthenticate.timeout',600);  
    // return 'success';
    dd((time() - Session::get('reauthenticate.last_authentication')), Session::get('reauthenticate.timeout'));
    //   $url = 'https://platform.clickatell.com/v1/message';
    //   $curl = curl_init('https://platform.clickatell.com/v1/message'); 
    // $otp = "223344";

    //   $mj = new \Mailjet\Client('f64de8787c68023656dbb95360a1ed8b','90fa1eec0e8b3dc1c75567b434fe50da',true,['version' => 'v3.1']);
    //   $body = [
    //     'Messages' => [
    //       [
    //         'From' => [
    //           'Email' => "developer2@webtecz.com",
    //           'Name' => "Saab Badgal"
    //         ],
    //         'To' => [
    //           [
    //             'Email' => "saabbadgalj5@gmail.com",
    //             'Name' => "One More "
    //           ]
    //         ],
    //         'Subject' => "Saab 90879 jlhjh 9-70- 7 hkh ",
    //       //   'TextPart' => "My first",
    //         'HTMLPart' => view('email_templates.otp',compact($otp)),
    //         'CustomID' => "AppGettingStartedTest"
    //       ]
    //     ]
    //   ];
    //   $response = $mj->post(Resources::$Email, ['body' => $body]);
    //   $response->success() && var_dump($response->getData());


    // $mail->setHeader( $header, $value );

    // $client = new Client(); //class from google api-client library
    // $client->setApplicationName('webtecz-gmail');
    // $client->setScopes([
    //     'https://mail.google.com/',
    //     'https://www.googleapis.com/auth/gmail.modify',
    //     'https://www.googleapis.com/auth/gmail.compose',
    //     'https://www.googleapis.com/auth/gmail.send',

    // ]);

    // $client->setAuthConfig(public_path('credential.json'));
    // $client->setAccessType('offline');
    // $authUrl = $client->createAuthUrl();

    // if ($request->all()) {
    //     $authCode = $request['code'];
    //     // Exchange authorization code for an access token.
    //     $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    //     $client->setAccessToken($accessToken['access_token']);
    //     $service = new Google\Service\Gmail($client);

    //     $message = new Google\Service\Gmail\Message();
    //     $sender = "developer4@webtecz.com";
    //     $to = "saabbadgalj5@gmail.com";
    //     $subject = "test subject";
    //     $messageText = "hello nand paji, what's up!";
    //     $rawMessageString = "From: <{$sender}>\r\n";
    //     $rawMessageString .= "To: <{$to}>\r\n";
    //     $rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode($subject) . "?=\r\n";
    //     $rawMessageString .= "MIME-Version: 1.0\r\n";
    //     $rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
    //     $rawMessageString .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
    //     $rawMessageString .= "{$messageText}\r\n";

    //     $rawMessage = strtr(base64_encode($rawMessageString), array('+' => '-', '/' => '_'));
    //     $message->setRaw($rawMessage);
    //     try {
    //         $message = $service->users_messages->send('developer4@webtecz.com', $message);
    //         print 'Message with ID: ' . $message->getId() . ' sent.';
    //         // return $message;
    //         return response()->json('Email sent successfully');
    //     } catch (Exception $e) {
    //         print 'An error occurred: ' . $e->getMessage();
    //     }
    // } else {
    //     return redirect($authUrl);
    // }

    // $users = UserStore::get();
    // foreach($users as $user){
    //     if($user->phone){
    //         if($user->phone[0].$user->phone[1] == '91' && strlen($user->phone) > 10){
    //             // dump(str_replace(' ','',$user->phone));
    //             $country_code = '91';
    //             $phone_no = $user->phone;

    //             // dump('-'.preg_replace('/^\+?91|\|91|\D/', '', ($user->phone)));
    //             $user->update(['phone' => preg_replace('/^\+?91|\|91|\D/', '', ($user->phone))]);
    //         }
    //     }
    //     if($user->whats_app){
    //         if($user->whats_app[0].$user->whats_app[1] == '91' && strlen($user->whats_app) > 10){
    //             dump($user->whats_app);
    //             // dump(str_replace(' ','',$user->phone));
    //             $country_code = '91';
    //             $phone_no = $user->whats_app;

    //             // dump('-'.preg_replace('/^\+?91|\|91|\D/', '', ($user->phone)));
    //             $user->update(['whats_app' => preg_replace('/^\+?91|\|91|\D/', '', ($user->whats_app))]);
    //         }
    //     }
    //     if($user->whats_app == null && $user->phone != null){
    //         // dump($user->whats_app);
    //         $user->update(['whats_app' => $user->phone]);
    //     }
    //     if($user->phone == null && $user->whats_app != null){
    //         // dump($user->whats_app);
    //         $user->update(['phone' => $user->whats_app]);
    //     }
    // }
    // dd('saab');
    // dd($users);
    // dd(public_path().'/credential.json');
    //     $client = new Google\Client();
    // $client->setAuthConfig(public_path().'/credential.json'); 
    // $.ajax({
    //     url: "https://platform.clickatell.com/v1/message",
    //     method :"POST",
    //     dataType: 'json',
    //     headers:{
    //        "Authorization" : "qSrGgsZCQYOIf9WTP6He_w==",
    //        "Content-Type" : "application/json"
    //     },
    //     data : body
    //  });

    //  $response = Http::withHeaders([
    //     'Authorization' => 'qSrGgsZCQYOIf9WTP6He_w==',
    //     'Content-Type' => 'application/json'
    // ])->post('https://platform.clickatell.com/v1/message', [
    //     "messages"=> [ 
    //         [
    //             "channel"=> "sms",
    //             "to"=> '919914263105',
    //             "content"=>"Lead Verify Account to create New Store",
    //         ]
    //     ]
    // ]);
    // dd($response);

    // $ledgerId = 16;
    // $ledger = new Ledger;
    // $productsAmount = $ledger->countProductAmount($ledgerId);
    // $rattiRateWithoutTax = $ledger->countRattiRateWithoutTax($ledgerId);
    // $mrpWithoutTax = $ledger->countMrpWithoutTax($ledgerId);
    // $discount = $ledger->countTotalDiscount($ledgerId);
    // $amountWithDiscount = $ledger->countAmountWithDiscount($ledgerId);
    // $tax = $ledger->countTotalTax($ledgerId);
    // $totalAmount = $ledger->countTotalAmount($ledgerId);
    // $totalQty = $ledger->countTotalQty($ledgerId);

    // Ledger::where('id',$ledgerId) ->update([
    //     'products_amount' => $productsAmount,
    //     'ratti_rate_without_tax' => $rattiRateWithoutTax,
    //     'mrp_without_tax' => $mrpWithoutTax,
    //     'discount_amount' => $discount,
    //     'amount_with_discount' => $amountWithDiscount,
    //     'tax_amount' => $tax,
    //     'total_amount' => $totalAmount,
    //     'qty_total' => $totalQty,
    // ]);
    // TblIfvalue::doesnthave('item')->each(function($record){
    //     $record->delete();
    // });
    return "Success";
    // return view('burberry');
    // $pdf = app('dompdf.wrapper')->loadView('burberry');

    // return $pdf->stream('invoice.pdf');
})
    // ->middleware('Reauthenticate')
;


Route::get('done', function () {
    $disk = Storage::disk('gcs');

    $exists = $disk->exists('file.jpg');
    dd($exists);
});

Route::get('yes22', function () {

    // return Excel::download(new TestingExport, 'missingginsinitemtable.xlsx');
    //    $iofValues = TblIfvalue::doesntHave('item')->pluck('item_id')->toArray();
    $iofValues = TblIfvalue::has('item')->where('grade', '')->pluck('item_id')->toArray();
    //    $iofValues = TblIfvalue::has('item')->where('grade','') ->count();
    $iofValues = TblItem::whereIn('item_id', $iofValues)->get();

    dd($iofValues);
    // $gins = TblItem::select('id','icode')->get()->groupBy(['icode']); 
    // for($i = 11213153; $i <= 11330721;$i++){

    //     if(isset($gins[$i])){
    //     }else{
    //         $missing[] =[
    //             'gin' => $i,
    //         ];  
    //     } 
    // }  
    // $missingGins = collect($missing)->pluck('gin');  

    // // dd(collect($missingGins));
    // foreach(collect($missingGins) as $gin){
    //     dd($gin);
    // }
});
Route::get('bind', 'MyController@convertProductId');


Route::get('saab', function () {
    return view('test');

    // $product = InvoiceDetailGradeProduct::find(6); 
    // $rateProfile =  Helper::getRateProfile($product->product_id,$product->grade_id); 
    // $rate = Helper::getCalculateWeight($product->weight,$rateProfile->rate_profile_id);
    // dd($rate);
    // $gradePacket = InvoiceDetailGradePacket::find($packetId); 
    // dd($gradePacket->invoiceDetail);
    // $array  = ['store_id'=>'1','manager_id'=>'2','products'=>[
    //     '1','2','3','4','5'
    // ]];
    // $collect = collect($array);


    // $array = session()->get('array');
    // $ids = $array['products'];
    // $newIds = array_merge($ids,['6','7']);
    // $newArray = $array['products'=> $newIds];
    // dd($ids);
    // dd($ids);
    // session()->push('array',['products'=>'6']); 
    // dd($array);
    // session()->put('array',$array);
    // dd(session()->get('array'));

});

Route::view('email-template', 'email_templates\storeLoginOtp');
Route::view('barcode', 'barcode');
Route::get('barcode-packet', function () {
    try {
        // retreive all records from db
        $packet = InvoiceDetailGradePacket::find(1);
        return view('warehouse.gradesort_product.printPacketlabel', compact('packet'));
        view()->share('packet', $gradePacket);
        $pdf = PDF::loadView('warehouse.gradesort_product.printPacketlabel');

        // download PDF file with download method
        return $pdf->download('packet_' . $gradePacket->number . '.pdf');
    } catch (DOMPDF_Exception $e) {
        echo '<pre>', print_r($e), '</pre>';
    }
});

Route::get('barcode-export', 'WebController@barcodeExport')->name('barcode.Export');


Route::get('error/{code}', 'HomeController@errorCode')->name('errors');

Route::get('imports-view', 'MyController@importExportView')->name('export.index');
Route::post('import-2', 'MyController@import')->name('import_1');
Route::post('import-3', 'MyController@export')->name('export');

Route::get('clear', 'WebController@clear');



//WarehouseModule Not Found 
Route::view('warehouse-module-not-found', 'errors.module_not_authorized')->name('warehousemodulenotfound');


Route::view('/', 'home');

// Route::domain('{domain}.9gem.net')->group(function(){
//    Route::get('/',function($domain){
//       dd($domain);
//    });
// });

//SMS Email Verification
Route::get('lead-to-store-verify-email/{token}', 'VerificationController@verifyLeadEmail')->name('leadtostore.verifyemail');
Route::get('lead-to-store-verify-phone/{token}', 'VerificationController@verifyLeadPhone')->name('leadtostore.verifyphone');

//Verification Store Account
Route::get('store-account-verify-email/{token}', 'VerificationController@verifyStoreEmail')->name('store.account.verifyemail');
Route::get('store-account-verify-phone/{token}', 'VerificationController@verifyStorePhone')->name('store.account.verifyphone');



// Route::group(['domain'=>'9gem.net'],function(){
//     Route::view('/','welcome');
// });
Route::get('convert-2', 'WebController@convert_2');

Route::get('convert', 'WebController@convert');

Route::get('get-ip', 'WebController@getIp');

Route::get('yes', 'WebController@yes');


Route::get('product-grade-rate-profile', function () {

    $productGrade = InvoiceDetailGradeProduct::find(5);
    //dd($rateProfile);
    $rateProfile = Helper::getRateProfile($productGrade->product_id, $productGrade->grade_id);
    // dd($rateProfile);
    $productRate = Helper::getCalculateWeight($productGrade->weight, $rateProfile);
    dd($productRate);
});

Route::get('get-done', function () {
    return InvoiceDetailGradeProduct::where('id', '>', '113932')->forceDelete();
});

Route::view('ss', 'warehouse.gradesort_product.printFinalProductLabel1');



require_once __DIR__ . "/front.php";

// Route::view('/', 'home');
