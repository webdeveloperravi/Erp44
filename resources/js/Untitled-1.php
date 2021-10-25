<?php

namespace App\Http\Controllers\front;


use App\Order;
use Google_Client;
use App\Models\User;
use Aws\S3\S3Client;
use Razorpay\Api\Api;
use App\Helpers\Helper;
use Google\Service\Drive;
use Aws\S3\ObjectUploader;
use App\Model\Store\Ledger;
use Google\Service\YouTube;
use Illuminate\Support\Str;
use App\Model\Front\Service;
use Illuminate\Http\Request;
use App\Model\Front\Wishlist;
use App\Models\YoutubeUpload;
use App\Model\Front\Blog_Post;
use App\Model\Guard\UserStore;
use App\Model\Front\OrderAddOn;
use Aws\Exception\AwsException;
use Google\Http\MediaFileUpload;
use App\Model\Front\Blog_Comment;
use Google\Service\YouTube\Video;
use App\Model\Admin\Setting\Guard;
use App\Model\Admin\Master\Country;
use App\Model\Admin\Master\Product;
use Google\Service\Drive\DriveFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Model\Admin\Master\CountryCode;
use App\Model\Store\blogs\BlogCategory;
use App\Model\Store\StorePurchaseOrder;
use Google\Service\YouTube\VideoStatus;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Model\Admin\Master\CountryState;
use Google\Service\YouTube\VideoSnippet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\Master\ProductCategory;
use App\Model\Warehouse\InvoiceDetailGrade;
use App\Model\Admin\Master\CountryStateCity;
use App\Model\Admin\Organization\AddressType;
use App\Model\Store\StorePurchaseOrderDetail;
use App\Model\Admin\Organization\StoreAddress;
use App\Model\Warehouse\InvoiceDetailGradeProduct;


class FrontController extends Controller
{
    #####//Products section//#####

    function home()
    {
        $ledgers = Ledger::with('ledgerDetails.productStock')->where('account_id', session('account_id'))->get();
        return view('front.home', compact('ledgers'));
    }



    function proCatalogue($proName)
    {
        $result['proItems']  = Product::where('name', $proName)->first()->assignCategoryGradeItem()->Paginate(10);
        $result['proName']  = $proName;
        return view('front.pro-catalogue', $result);
    }


    function searchCatalogue($query)
    {

        $keywords = collect(explode(' ', $query))->filter();
        $result['proItems'] = InvoiceDetailGradeProduct::with(['product', 'productCategory', 'grade.grade', 'ratti', 'color', 'shape'])
            ->select('id', 'iname', 'gin', 'product_id', 'grade_id', 'ratti_id', 'shape_id', 'color_id', 'weight')
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $value) {
                    $q->orWhere('iname', 'like', '%' . $value . '%');
                    $q->orWhereHas('product', function (Builder  $query) use ($value) {
                        $query->where('name', 'like', '%' . $value . '%');
                    });
                    $q->orWhereHas('productCategory', function (Builder  $query) use ($value) {
                        $query->where('name', 'like', '%' . $value . '%');
                    });
                    $q->orWhereHas('grade.grade', function (Builder  $query) use ($value) {
                        $query->where('grade', 'like', '%' . $value . '%');
                    });
                    $q->orWhereHas('color', function (Builder  $query) use ($value) {
                        $query->where('color', 'like', '%' . $value . '%');
                    });
                    $q->orWhereHas('shape', function (Builder  $query) use ($value) {
                        $query->where('shape', 'like', '%' . $value . '%');
                    });
                    $q->orWhereHas('ratti', function (Builder  $query) use ($value) {
                        $query->where('rati_standard', 'like', '%' . $value . '%');
                    });
                }
            })->where('in_stock', 1)->Paginate(10);

        $result['proName']  = $query;
        return view('front.pro-catalogue', $result);
    }



    function addUserNewAddress(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'town' => 'required',
            'Address-Type' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required',
            'pincode' => 'required',
        ]);


        $result['country_id'] = $request['country'];
        $result['state_id'] = $request['state'];
        $result['city_id'] = $request['city'];
        $result['town_id'] = $request['town'];
        $result['address'] = $request['address'];
        $result['locality'] = $request['locality'];
        $result['landmark'] = $request['landmark'];
        $result['pincode'] = $request['pincode'];
        $result['store_id'] = session('user_id');
        $result['address_type_id'] = $request['Address-Type'];
        // dd($result);

        $newAddress_id = StoreAddress::create($result);

        if ($newAddress_id) {

            return back()->with('message', 'New Address Created Successfully');
        } else {
            return back()->withErrors(['Error While Creating New Address']);
        }
    }

    function getTotalCartAmount($cart_items, $addOnsAmount, $shippingCharges, $taxAmount, $subTotal)
    {



        foreach ($cart_items as $item) {

            $subTotal += $item['price'] * $item['product_qty'];

            if ($item['addOns'] != null) {
                foreach ($item['addOns'] as $addOn) {
                    $addOnData = explode(',', $addOn);
                    $addOnsAmount += $addOnData[2];
                }
            }
        }

        $subTotal = $addOnsAmount + $subTotal;
        $grandTotal = $subTotal + $taxAmount + $shippingCharges;
        return $grandTotal;
    }


    function PlaceOrder($orderMeta)
    {
        $user  = session('user');
        $user_id  = session('user_id');
        $current_store_account_id = session('account_id');
        $currentStore  = UserStore::find($current_store_account_id);
        $cart_items = $orderMeta['cart_items'];
        $cart_total_qty = $cart_items->sum('product_qty');
        $addOnsAmount = 0;
        $shippingCharges = 0;
        $taxAmount = 0;
        $subTotal = 0;
        $grandTotal = $this->getTotalCartAmount($cart_items, $addOnsAmount, $shippingCharges, $taxAmount, $subTotal);




        $ledger = Ledger::create([
            'guard_id_from' => $current_store_account_id,
            'guard_id_to' => $user['guard_id'],
            'voucher_type' => 3, //static - invoice
            'voucher_number' => 1001, //static
            'account_id' => $current_store_account_id,
            'from' => Null, //static
            'to' => Null, //static
            'amount_total' => $grandTotal,
            'addOnsAmount' => $addOnsAmount,
            'subTotal' => $subTotal,
            'taxAmount' => $taxAmount,
            'shippingCharges' => $shippingCharges,
            'qty_total' => $cart_total_qty,
            'comment' => 'customer invoice under specific store',
        ]);


        $newOrder = StorePurchaseOrder::create([
            'so_number' => $currentStore['so_number'],
            'po_number' => Null, //static 
            'seller_store_id' => $current_store_account_id,
            'buyer_store_id' => $user_id,
            'ledger_id' => $ledger->id,
            'slug' =>    Str::random(10),
            'tax' => null,
            'Tax_type' => null,
            'Discount' => null,
            'discount_type' => null,
            'discount_amount' => null,
            'ordernote' => $orderMeta['ordernote'],
            'shipping_address' => $orderMeta['address'],
            'shipping_charges' => null,
            'payment_status' =>  $orderMeta['payment_status'],
            'payment_method' =>   $orderMeta['paymentmethod'],
            'status' =>  $orderMeta['status'],
            'track_id' => null,
        ]);





        $cart_items->each(function ($item)  use ($newOrder) {
            $product_item = InvoiceDetailGradeProduct::find($item['product_id']);
            $order_detail = StorePurchaseOrderDetail::create([
                'store_purchase_order_id' => $newOrder->id,
                'product_category_id' => $product_item['product_category_id'], //static 
                'product_id' =>  $product_item['id'],
                'grade_id' =>  $product_item['grade_id'],
                'ratti_id' => $product_item['ratti_id'],
                'quantity' => $item['product_qty'],
                'confirmed_qty' => $item['product_qty'],
                'insert_qty' => $item['product_qty'],
                'temp_number' => Str::random(10),
                'status' => '1', //static
            ]);


            if ($item['addOns'] != null) {
                foreach ($item['addOns'] as $addOn) {
                    $addOnArr = explode(',', $addOn);

                    OrderAddOn::create([
                        'add_on_name' => $addOnArr[0],
                        'add_on_master_id' => $addOnArr[1],
                        'status' => 1,
                        'order_details_id' => $order_detail->id,
                    ]);
                }
            }
        });



        return $newOrder;
    }


    function userPlaceOrder(Request $request)
    {


        $request->validate([
            'paymentmethod' => 'required',
        ]);


        //final entering user whole order details for model


        $orderMeta['ordernote'] = $request['ordernote'];
        $orderMeta['address'] = $request['address'];
        $orderMeta['paymentmethod'] = $request['paymentmethod'];
        $orderMeta['status'] =  'accepted';
        $orderMeta['payment_status'] = 'pending';
        $orderMeta['cart_items'] = session('cart_items');
        $addOnsAmount = 0;
        $shippingCharges = 0;
        $taxAmount = 0;
        $subTotal = 0;



        if (session('user_login')) {
            //member user
            $request->validate([
                'address' => 'required|regex:/^[a-zA-Z0-9\s,-_]+$/',
            ]);

            $newOrder  = $this->PlaceOrder($orderMeta);
            if ($orderMeta['paymentmethod'] == "cash") {
                //order via cod for member user

                // $mailTo = session('user')['email'];
                // $mailFlag = Mail::send('email_templates.order_accepted', ['user' => session('user_id'), 'view_order_address' => route('9gem_user_order_details', $newOrder['id']), 'track_order_address' => route('9gem_track_order', $newOrder['slug']), 'sitename' =>   route('9gemhome')], function ($message) use ($mailTo) {
                //     $message->to($mailTo);
                //     $message->subject('Order Accepted');
                // });

                if ($newOrder['shipping_address']) {
                    Session::flash('order_placed', 1);
                    Session::flash('order_id', $newOrder->id);
                    Session::forget('cart_items');
                    return redirect()->route('9gem_order_placed');
                } else {
                    return redirect()->route('9gem_user_order_shipping_details', ['slug' => $newOrder['slug']]);
                }
            } elseif ($orderMeta['paymentmethod'] == "check") {
                //order via check for member user

            } else {
                //order via online - razorpay for guest user

                $user_id = session('user_id');
                $total_amount = $this->getTotalCartAmount($orderMeta['cart_items'], $addOnsAmount, $shippingCharges, $taxAmount, $subTotal) * 100; //total payment amount 
                $order_slug = $newOrder['slug']; //total payment amount

                $encrypt_method = "AES-256-CBC";
                $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
                $secret_iv = '5fgf5HJ5g27'; // user define secret key
                $key = hash('sha256', $secret_key);
                $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
                $total_amount = openssl_encrypt($total_amount, $encrypt_method, $key, 0, $iv);
                $order_slug = openssl_encrypt($order_slug, $encrypt_method, $key, 0, $iv);

                $total_amount = base64_encode($total_amount); //encrypted payment amount
                $order_slug = base64_encode($order_slug); //encrypted payment amount

                return redirect('https://9gem.in/api/razorpay?amt=' . $total_amount . '&slug=' . $order_slug . '&user_id=' . $user_id); //payment initialization

            }
        } else {
            //guest user

            $request->validate([
                'name' => 'required|string',
                'email' => 'required|unique:user_store,email|email',
                'phone_country_code_id' => 'required|integer',
                'phone' => 'required|digits_between:10,15',

            ]);

            //creating account for guest user
            $storeUser  = UserStore::create([
                'guard_id' => 6, //customer
                'account_group_id' => 17, //static
                'name' => $request['name'],
                'company_name' => null,
                'email' => $request['email'],
                'phone' =>  $request['phone'],
                'whats_app' => null,
                'phone_country_code_id' => $request['phone_country_code_id'],
                'whats_app_country_code_id' => null,
                'status' => 1,
                'type' => 'customer',
            ]);


            $mailTo = $request['email'];
            $mailFlag = Mail::send('email_templates.account_created', ['user' => $request['name'], 'email' => $request['email'], 'sitename' =>   request()->getHttpHost() . "/"], function ($message) use ($mailTo) {
                $message->to($mailTo);
                $message->subject('New Account Created Successfully');
            });



            //can send mail to user for new user id and other//

            Session::put('user', $storeUser);
            Session::put('user_id', $storeUser->id);
            Session::put('user_login', true);


            $newOrder = $this->PlaceOrder($orderMeta); //placing order

            if ($request['paymentmethod'] == "cash") {
                //order via cod for guest user

                // $mailTo = session('user')['email'];
                // $mailFlag = Mail::send('email_templates.order_accepted', ['user' => $request['name'], 'shipping_address' => route('9gem_user_order_shipping_details', $newOrder['slug']), 'sitename' =>   route('9gemhome')], function ($message) use ($mailTo) {
                //     $message->to($mailTo);
                //     $message->subject('Complete your shipping Details');
                // });

                return redirect()->route('9gem_user_order_shipping_details', ['slug' => $newOrder['slug']]);
            } elseif ($request['paymentmethod'] == "check") {
                //order via check for guest user

            } else {
                //order via online - razorpay for guest user

                $user_id = $storeUser->id;
                $total_amount = $this->getTotalCartAmount($orderMeta['cart_items'], $addOnsAmount, $shippingCharges, $taxAmount, $subTotal) * 100; //total payment amount 
                $order_slug = $newOrder['slug']; //total payment amount

                $encrypt_method = "AES-256-CBC";
                $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
                $secret_iv = '5fgf5HJ5g27'; // user define secret key
                $key = hash('sha256', $secret_key);
                $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
                $total_amount = openssl_encrypt($total_amount, $encrypt_method, $key, 0, $iv);
                $order_slug = openssl_encrypt($order_slug, $encrypt_method, $key, 0, $iv);

                $total_amount = base64_encode($total_amount); //encrypted payment amount
                $order_slug = base64_encode($order_slug); //encrypted payment amount

                return redirect('https://9gem.in/api/razorpay?amt=' . $total_amount . '&slug=' . $order_slug . '&user_id=' . $user_id); //payment initialization
            }
        }
    }

    function captureOnlinePayment(Request $request)
    {

        $order_slug = $request['order_slug'];
        $payment_id = $request['payment_id'];
        $total_amount = $request['amt'];
        $user_id = $request['user_id'];
        $status = $request['status'];

        if ($status) {
            //payment capturization and validation
            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
            $payment = $api->payment->fetch($payment_id);
            if (!empty($payment_id)) {
                try {
                    $response = $api->payment->fetch($payment_id)->capture(array('amount' => $total_amount)); //payment successfully captured  
                    $order = StorePurchaseOrder::where('slug', $order_slug)->first();   //updating details
                    $flag = $order->update(['payment_status' => 'paid']);

                    if ($flag) {

                        // $mailTo = UserStore::find($user_id)['email'];

                        // $mailFlag = Mail::send('email_templates.order_accepted', ['user' => $request['name'], 'shipping_address' => route('9gem_user_order_shipping_details', $order_slug), 'sitename' =>   route('9gemhome')], function ($message) use ($mailTo) {
                        //     $message->to($mailTo);
                        //     $message->subject('Complete your shipping Details');
                        // });
                        if ($order['shipping_address']) {
                            Session::flash('order_placed', 1);
                            Session::flash('order_id', $order['id']);
                            Session::forget('cart_items');
                            return redirect()->route('9gem_order_placed');
                        } else {
                            return redirect()->route('9gem_user_order_shipping_details', ['slug' => $order['slug']]);
                        }
                    } else {
                        return response()->json('Error While updating Order payment status');
                    }
                } catch (\Exception $e) {
                    return  $e->getMessage(); //payment capturing error
                }
            }
        } else {
            return response()->json('Payment failed or other technical issue found!');
        }
    }



    function shippingDetails($slug)
    {

        $result['order_slug'] = $slug;
        $result['addressTypes'] = AddressType::pluck('name', 'id');
        $result['countries'] = Country::pluck('name', 'id');
        $result['phoneCodes'] = CountryCode::pluck('phonecode', 'id');
        return view('front.shipping_details', $result);
    }

    function shippingDetailsPost(Request $request)
    {


        $request->validate([
            'order_slug' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'Address-Type' => 'required',
            'address' => 'required',
            'town' => 'required|integer',
            'locality' => 'required|string',
            'landmark' => 'required|string',
            'pincode' => 'required|numeric',
        ]);


        $user_shipping_address = StoreAddress::create([
            'address_type_id' => $request['Address-Type'],
            'store_id' => session('user_id'),
            'country_id' =>  $request['country'],
            'state_id' =>  $request['state'],
            'town_id' =>  $request['town'],
            'city_id' =>  $request['city'],
            'address' =>  $request['address'],
            'locality' =>  $request['locality'],
            'landmark' =>  $request['landmark'],
            'pincode' =>  $request['pincode']
        ]);


        $order = StorePurchaseOrder::where('slug', $request['order_slug'])->first();
        $flag = $order->update(['shipping_address' => $user_shipping_address->id]);


        if ($flag) {
            Session::flash('order_placed', 1);
            Session::flash('order_id', $order->id);
            Session::forget('cart_items');
            return redirect()->route('9gem_order_placed');
        } else {
            return back()->withErrors(['Something went wrong while saving shipping address']);
        }
    }

    function trackOrder()
    {
        dd('underwork');
    }

    function userOrderDetails($order_id)
    {
        $result['order'] =  StorePurchaseOrder::find($order_id);
        $result['orders_details'] =  $result['order']->purchaseOrderDetail;


        return view('front.Order_details', $result);
    }

    function cancelOrder(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'order_cancel_reason' => 'required'
        ]);

        if (session('user_id')) {
            $order = StorePurchaseOrder::find($request['order_id']);
            $ledger_id =  $order->ledger_id;
            Ledger::destroy($ledger_id);
            $orderDetails =    $order->purchaseOrderDetail;
            $orderDetails->each(function ($order_detail) {
                $order_detail->delete();
            });
            $order_trash_flag =  StorePurchaseOrder::where('id', $request['order_id'])->update(['status' => 'cancelled', 'cancelling_reason' => $request['order_cancel_reason']]);
            StorePurchaseOrder::destroy($request['order_id']);


            if ($order_trash_flag) {
                return redirect()->route('9gem_user_account')->with('message', 'Order Cancelled Successfully');
            } else {
                return abort(500);
            }
        } else {
            return abort(405);
        }
    }


    #####//blogs section//#####

    function tagRelatedBlogs($tag)
    {
        $result['posts'] = Blog_Post::where('tags', 'like', '%' . $tag . '%')->where('publish', 1)->get();
        $result['current_page'] = $tag;

        return view('front.blogslist', $result);
    }

    function blogSearchResults(Request $request)
    {
        // dd('win');
        $result['posts'] = Blog_Post::where('publish', 1)->where('title', 'like', '%' . $request['q'] . '%')->orWhere('description', 'like', '%' . $request['q'] . '%')->orWhere('tags', 'like', '%' . $request['q'] . '%')->get()->toArray();
        // dd($result);
        $result['current_page'] = $request['q'];
        return view('front.blogslist', $result);
    }

    function getRelatedPosts($cat_id)
    {
        $result = Blog_Post::where('publish', 1)->with(['users', 'comments'])->where('category_id', $cat_id)->get()->take(10);
        return $result;
    }

    function post_details($category, $slug)
    {

        $result['post'] = Blog_Post::with(['users', 'comments'])->where('slug', $slug)->first();

        //if published then show
        if ($result['post']->publish) {
            $result['related_posts'] = $this->getRelatedPosts($category);
            $result['comments'] = $result['post']->comments();
            return view('front.post_details', $result);
        } else {
            return abort(404);
        }
    }

    function list_all_blogs($id)
    {
        $result['posts'] =  Blog_Post::with('users')->where('category_id', $id)->where('publish', 1)->limit(50)->get()->toArray();

        $result['current_page'] = BlogCategory::find($id)->name;
        $result['cat_id'] = $id;
        return view('front.blogslist', $result);
    }

    function catalogue($cat_id)
    {

        $result['posts'] = Blog_Post::where('category_id', $cat_id)->Paginate(3);
        $result['cat'] = BlogCategory::find($cat_id)->name;
        $result['cat_id'] = $cat_id;
        return view('front.catalogue', $result);
    }




    function update_post(Request $request)
    {
        if ($request['f_img'] != null) {

            $post = Blog_Post::find($request['postid']);
            Storage::delete('public/uploads/blog_featured_imgs/' . $post['featured_img']);
            $img_slug = basename($request['f_img']->store('/public/uploads/blog_featured_imgs'));
            $request['featured_img'] = $img_slug;
        }

        $request['userid'] = session('user_id');

        if ($request['action'] == 'Update and Publish') {

            $request['publish'] = 1;
            $post = Blog_post::find($request['postid']);
            $flag = $post->fill($request->all())->save();
            if ($flag) {
                return redirect()->route('9gem_user_account')->with('message', 'post updated and published successfully');
            } else {
                return redirect()->route('9gem_user_account')->with('message', 'Error while updating post');
            }
        } elseif ($request['action'] == 'Update and make Draft') {

            $request['publish'] = 0;
            $post = Blog_post::find($request['postid']);
            $flag = $post->fill($request->all())->save();

            if ($flag) {
                return redirect()->route('user_account')->with('message', 'post updated and saved as draft successfully');
            } else {
                return redirect()->route('user_account')->with('message', 'Error while updating post');
            }
        } else {

            $post = Blog_post::find($request['postid']);
            $flag = $post->fill($request->all())->save();

            if ($flag) {
                return redirect()->route('9gem_user_account')->with('message', 'post updated successfully');
            } else {
                return redirect()->route('9gem_user_account')->with('message', 'Error while updating post');
            }
        }
    }

    function show_create_new_blog()
    {
        return view('front.create_new_blog');
    }


    function show_user_account()
    {
       

        $result['addressTypes'] = AddressType::pluck('name', 'id');
        $result['countries'] = Country::pluck('name', 'id');
        $result['phoneCodes'] = CountryCode::pluck('phonecode', 'id');
        $result['user_posts'] = Blog_post::with('category')->where('userid', session('user_id'))->get()->toArray();
        return view('front.account', $result);
    }



    // function getRelatedPosts($cat_id)
    // {
    //     $result = Blog_Post::with(['users', 'comments'])->where('category_id', $cat_id)->get()->take(10);
    //     return $result;
    // }


    function post_comment(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns|exists:user_store,email',
            'content' => 'required|min:3|max:255'
        ]);
        $comment  = Blog_Comment::create($request->all());
        // dd($comment);
        if ($comment->id) {
            return back()->with('message', 'commented successfully');
        } else {
            return back()->with('message', 'commented not successfully');
        }
    }






    //User section

    function user_login_post(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'email' => 'required|exists:user_store,email'
        ]);

        if (!empty($validated_data->errors()->toArray())) {
            $result['msg_type'] = 'error';
            $result['msg'] = $validated_data->errors()->toArray();
            return response($result);
        } else {

            $email = $request['email'];


            $user  = UserStore::where(['email' => $email])->get()->first()->toArray();
            $otpcode = rand(00000, 99999);
            $mailto = $email;

            // $mailFlag = Mail::send('email_templates.storeLoginOtp', ['otp' => $otpcode, 'title' => 'user login otp'], function ($message) use ($mailto) {
            //     $message->to($mailto);
            //     $message->subject('user login otp');
            // });
            $res = Http::get('https://api.msg91.com/api/v5/otp?template_id=614426e566c0a424c3743085&mobile=' . $mobile . '&authkey=366219AHCQOCsL6142f86aP1');

            Session::put('userLoginOtpcode', $otpcode);

            Session::put('user', $user);
            Session::put('user_id', $user['id']);

            $result['msg_type'] = 'success';
            $result['msg'] = 'Otp sent successfully to linked Email';


            return response()->json($result);
        }
    }

    function verifyOtp(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'otp' => 'required'
        ]);

        if (!empty($validated_data->errors()->toArray())) {
            $result['msg_type'] = 'error';
            $result['msg'] = $validated_data->errors()->toArray();
            return response($result);
        } else {
            if ($request['otp'] != session('userLoginOtpcode')) {
                $result['msg_type'] = 'error';
                $result['msg'] = ['otp' => 'please enter correct OTP'];
                return response($result);
            } else {
                // dd('win');
                Session::forget('userLoginOtpcode');
                Session::put('user_login', true);

                $result['msg_type'] = 'success';
                return response($result);
            }
        }
    }


    function getStates(Request $request)
    {

        // dd($request['']);
        $states = CountryState::where('country_id', $request['country_id'])->pluck('name', 'id');
        return response()->json($states);
    }

    function getcities(Request $request)
    {

        // dd($request['']);
        $cities = CountryStateCity::where('state_id', $request['state_id'])->pluck('name', 'id');
        return response()->json($cities);
    }

    function userRegister()
    {
        $result['addressTypes'] = AddressType::pluck('name', 'id');
        $result['countries'] = Country::pluck('name', 'id');
        $result['phoneCodes'] = CountryCode::pluck('phonecode', 'id');

        return view('front.user_register', $result);
    }

    function userRegisterPost(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'phone_country_code_id' => 'required|integer',
            'phone' => 'required|digits_between:10,15',
            'Country' => 'required',
            'State' => 'required',
            'City' => 'required',
            'Address-Type' => 'required',
            'Full-Address' => 'required|string',
            'Town' => 'required|integer',
            'Locality' => 'required|string',
            'Landmark' => 'required|string',
            'Pincode' => 'required|numeric',
            'g-recaptcha-response' => 'required',

        ]);
        // dd('win');
        $storeUserId  = UserStore::create([
            'guard_id' => 6, //customer
            'account_group_id' => 17, //static
            'name' => $request['name'],
            'company_name' => $request['company_name'],
            'email' => $request['email'],
            'phone' =>  $request['phone'],
            'whats_app' => $request['whats_app'],
            'phone_country_code_id' => $request['phone_country_code_id'],
            'whats_app_country_code_id' => $request['whats_app_country_code_id'],
            'status' => 1,
            'type' => 'customer',
        ])->id;


        StoreAddress::create([
            'address_type_id' => $request['Address-Type'],
            'store_id' => $storeUserId,
            'country_id' =>  $request['Country'],
            'state_id' =>  $request['State'],
            'town_id' =>  $request['Town'],
            'city_id' =>  $request['City'],
            'address' =>  $request['Full-Addres'],
            'locality' =>  $request['Locality'],
            'landmark' =>  $request['Landmark'],
            'pincode' =>  $request['Pincode']
        ]);


        return redirect()->route('9gem_user_login')->with('message', 'Account created Successfully, You May Login Now!');
    }

    function show_user_wishlist()
    {
        if (session()->has('user_login')) {
            $result['items'] = Wishlist::where('user_id', session('user_id'))->get();
        } else {
            $result['items'] = [];
        }

        return view('front.user-wishlist', $result);
    }

    function admin_logout()
    {
        Session::forget('user');
        Session::forget('user_id');
        Session::forget('user_login');
        Session::forget('cart_items');
        return redirect()->route('9gem_user_login');
    }


    function get_youtube_token(Request $request)
    {

        $client = new Google_Client();
        $client->setApplicationName('9gems');
        $client->setScopes([
            'email',
            'profile',
            'https://www.googleapis.com/auth/youtube.upload',
            'https://www.googleapis.com/auth/youtube',
            'https://www.googleapis.com/auth/youtubepartner',
            'https://www.googleapis.com/auth/youtube.force-ssl',
            'https://www.googleapis.com/auth/drive',
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive.appdata'
        ]);

        $client->setAuthConfig(public_path('creds\webtecz_utube_creds.json'));
        $client->setAccessType('offline');
        $authUrl = $client->createAuthUrl();

        if ($request->all()) {
            if (isset($request['code'])) {

                $authCode = $request['code'];
                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                if (!isset($accessToken['error'])) {
                    $token = $accessToken['access_token'];
                    $userinfo = Http::get('https://www.googleapis.com/oauth2/v3/userinfo?access_token=' . $token)->json();
                    $getCat_res = Http::withToken($token)->get('https://www.googleapis.com/youtube/v3/videoCategories?part=snippet&regionCode=IN');

                    if ($getCat_res->ok()) {
                        $result['cats'] = $getCat_res->json()['items'];
                    } else {
                        return abort(500);
                    }

                    setcookie('google_username', $userinfo['name'], time() + $accessToken['expires_in']);
                    setcookie('google_email', $userinfo['email'], time() + $accessToken['expires_in']);
                    setcookie('utubeAccessTokenn', $token, time() + $accessToken['expires_in']);
                    Session::put('cats', $result['cats']);

                    return redirect()->route('9gem_video_upload');
                } else {
                    return redirect()->route('9gemhome')->withErrors('message', 'invalid creds');
                }
            } else {
                return redirect()->route('9gemhome')->withErrors('message', 'invalid creds');
            }
        } else {
            return redirect($authUrl);
        }
    }


    function admin_video_upload()
    {

        return view('front.youtube_video_upload');
    }


    function admin_video_upload_post(Request $request)
    {


        // return Storage::download('public/creds/webtecz_utube_creds.json', 'new.ppt');

        // dd($request['privacy']);
        $request->validate([
            'title' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'videocat' => 'required|numeric',
            'description' => 'required|string',
            'vtags' => 'required|string',
            'privacy' => 'required|in:public,private',
            'video' => 'required',
        ]);

        $client = new Google_Client();
        $client->setApplicationName('9gems');

        $client->setScopes([
            'https://www.googleapis.com/auth/youtube.upload',
            'https://www.googleapis.com/auth/youtube',
            'https://www.googleapis.com/auth/youtubepartner',
            'https://www.googleapis.com/auth/youtube.force-ssl'
        ]);



        $client->setAuthConfig(public_path('creds\webtecz_utube_creds.json'));
        $client->setAccessType('offline');



        // Exchange authorization code for an access token.
        $client->setAccessToken($_COOKIE['utubeAccessTokenn']);


        $videoPath = $request['video']->getRealPath(); ## file path here
        $videoTitle = $request['title'];
        $videoDescription = $request['description'];
        $videoCategory = $request['videocat']; //please take a look at youtube video categories for videoCategory.Not so important for our example
        $videoTags =  explode(',', $request['vtags']);

        $youtube = new YouTube($client);


        // Create a snipet with title, description, tags and category id
        $snippet = new VideoSnippet();
        $snippet->setTitle($videoTitle);
        $snippet->setDescription($videoDescription);
        $snippet->setCategoryId($videoCategory);
        $snippet->setTags($videoTags);


        $status = new VideoStatus();
        $status->setPrivacyStatus($request['privacy']);

        // Create a YouTube video with snippet and status
        $video = new Video();
        $video->setSnippet($snippet);
        $video->setStatus($status);

        // Size of each chunk of data in bytes. Setting it higher leads faster upload (less chunks,
        // for reliable connections). Setting it lower leads better recovery (fine-grained chunks)
        $chunkSizeBytes = 1 * 1024 * 1024;


        // Setting the defer flag to true tells the client to return a request which can be called
        // with ->execute(); instead of making the API call immediately.
        $client->setDefer(true);

        // Create a request for the API's videos.insert method to create and upload the video.
        $insertRequest = $youtube->videos->insert("status,snippet", $video);

        // Create a MediaFileUpload object for resumable uploads.
        $media = new MediaFileUpload(
            $client,
            $insertRequest,
            'video/*',
            null,
            true,
            $chunkSizeBytes
        );
        $media->setFileSize($request['video']->getSize());


        // Read the media file and upload it chunk by chunk.
        $status = false;
        $handle = fopen($videoPath, "rb");
        while (!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }

        fclose($handle);


        if ($status->status['uploadStatus'] == 'uploaded') {
            $youtube_id = $status->id; //you got here youtube video id 

            $new_upload = YoutubeUpload::create([
                'username' => $_COOKIE['google_username'],
                'email' => $_COOKIE['google_email'],
                'uploaded_video_id' => $youtube_id
            ]);

            if ($new_upload->id) {
                return back()->with('message', 'Video uploaded successfully');
            } else {
                return  back()->with('message', 'Video is not uploaded successfully please try again later!!!');
            }

            //after getting id of video store video detail in local db along with user details


        } else {
            return  back()->with('message', 'Video is not uploaded successfully please try again later!!!');
        }

        $client->setDefer(true);
    }


    function google_drive_upload(Request $request)
    {
        // // Exchange authorization code for an access token.
        $client = new Google_Client();
        $client->setApplicationName('9gems');
        $client->setScopes([
            'https://www.googleapis.com/auth/drive',
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive.appdata'
        ]);

        $client->setAuthConfig(public_path('creds\webtecz_utube_creds.json'));

        $client->setAccessToken($_COOKIE['utubeAccessTokenn']);

        // // $client->setAccessType('offline');

        $service = new Drive($client);


        $fileMetadata = new DriveFile(array(
            'name' => 'ExpertPHP',
            'mimeType' => 'application/vnd.google-apps.folder'
        ));

        $folder = $service->files->create($fileMetadata, array(
            'fields' => 'id'
        ));


        $file = new DriveFile(array(
            'name' => 'newgeneratedfile',
            'parents' => array($folder->id)
        ));


        $result = $service->files->create($file, array(
            'data' => file_get_contents($request['video']),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media'
        ));

        dd($result);
    }

    function getlonglat(Request $request)
    {


        $res = Http::get('https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=AIzaSyBr4n-ESZ8D06z0UNdLA1_3Fg0EEmNRrdI');

        dd($res->json());
    }


    function aws(Request $request)
    {
        return UserStore::addSelect([
            'guard' => Guard::select('name')
                ->whereColumn('guard_id', 'guard.id')
                ->limit(1)
        ])->get()->take(10)->dump();

        if ($request->hasFile('image')) {
            $filename = basename($request->file('image')->storePublicly('videos/', 's3'));
            $path = Storage::disk('s3')->url('videos/' . $filename);
            dd($path);
            // return Storage::disk('s3')->response('images/' . $filename);//view file
        } else {
            return back();
        }


        // $key = null;
        // $secret = null;
        // $s3Client = new S3Client([
        //     'region' => 'us-east-2',
        //     'version' => '2006-03-01',
        //     'credentials' => [
        //         'key' => $key,
        //         'secret' => $secret
        //     ]
        // ]);

        // $bucket = 'your-bucket';
        // $key = 'my-file.zip';

        // // Using stream instead of file path
        // $source = fopen(public_path('front/icons/diamond.png'), 'rb');

        // $uploader = new ObjectUploader(
        //     $s3Client,
        //     $bucket,
        //     $key,
        //     $source
        // );

        // do {
        //     try {
        //         $result = $uploader->upload();
        //         if ($result["@metadata"]["statusCode"] == '200') {
        //             print('<p>File successfully uploaded to ' . $result["ObjectURL"] . '.</p>');
        //         }
        //         print($result);
        //     } catch (MultipartUploadException $e) {
        //         rewind($source);
        //         $uploader = new MultipartUploader($s3Client, $source, [
        //             'state' => $e->getState(),
        //         ]);
        //     }
        // } while (!isset($result));

        // fclose($source);
    }
}
