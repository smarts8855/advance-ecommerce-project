<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    

    public function redirectToGateway(Request $request)
    {
        if (Session::has('coupon')){
            $total_amount= Session::get('coupon')['total_amount'];
        }else{
            $total_amount = round(Cart::subtotal());
        }
        // $paystack = new Paystack();
        $user = Auth::user();
        // $request->email = $user->email;
        // $request->amount = $total_amount * 100;
        // $request->reference = Paystack::genTranxRef();
        // $request->key = "config('paystack.secretKey')";
        // $request->order_id = uniqid();
        
        $data = array(
            "amount" => $total_amount * 100,
            "reference" => Paystack::genTranxRef(),
            "email" => $user->email,
            "currency" => "NGN",
            "order_id" => uniqid(),
            "metadata" => [
                'post_code' => $request->post_code,
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'state_id' => $request->state_id,
                'note' => $request->note,
            ]
        );
    
        return Paystack::getAuthorizationUrl($data)->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        // dd($paymentDetails);
        if (Session::has('coupon')){
            $total_amount= Session::get('coupon')['total_amount'];
        }else{
            $total_amount = round(Cart::subtotal());
        }
        
      
        

        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'division_id' => $paymentDetails['data']['metadata']['division_id'],
            'district_id' => $paymentDetails['data']['metadata']['district_id'],
            'state_id' => $paymentDetails['data']['metadata']['state_id'],
            'name' => $paymentDetails['data']['customer']['first_name'],
            'email' => $paymentDetails['data']['customer']['email'],
            'phone' => $paymentDetails['data']['customer']['phone'],
            'post_code' => $paymentDetails['data']['metadata']['post_code'],
            'notes' =>  $paymentDetails['data']['metadata']['note'],

            'payment_type' => 'paystack',
            'payment_method' => 'paystack',
            'payment_type' => $paymentDetails['data']['channel'],
            'currency' => $paymentDetails['data']['currency'],
            'amount' => $total_amount,
            'order_number' => $paymentDetails['data']['customer']['id'],
            'transaction_id' => $paymentDetails['data']['customer']['customer_code'],
            
            'invoice_no' => 'SMT'.mt_rand(10000000,99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'status' => 'pending',
            'created_at' => Carbon::now(),
        ]);

        // Start Send Email
           $invoice = Order::findOrFail($order_id);
           $data =[
              'invoice_no' => $invoice->invoice_no,
              'amount' => $total_amount,
              'name' => $invoice->name,
              'email' => $invoice->email,            
              'payment_type' => $invoice->payment_type,            
                          
           ];

           Mail::to($invoice->email)->send(new OrderMail($data));

        //End Send Email

        $carts = Cart::content();
        foreach ($carts as  $cart) {
            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $cart->id,
                'color' => $cart->options->color,
                'size' => $cart->options->size,
                'qty' => $cart->qty,
                'price' =>$cart->price,
                'created_at' => Carbon::now(),
            ]);
        }

        if(Session::has('coupon')){
            Session::forget('coupon');
        }

        Cart::destroy();

        $notification = array(
            'message' => 'Your Order Place Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('dashboard')->with($notification);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}