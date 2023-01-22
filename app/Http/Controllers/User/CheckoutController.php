<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ShipDistrict;
use App\Models\ShipState;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function DistrictGetAjax($division_id){
        $ship = ShipDistrict::where('division_id',$division_id)->orderBy('district_name','ASC')->get();
        return json_encode($ship);
    } // end method

    public function StateGetAjax($district_id){
        $ship = ShipState::where('district_id',$district_id)->orderBy('state_name','ASC')->get();
        return json_encode($ship);
    } // end method

    public function CheckoutStore(Request $request){
        // dd($request->all());
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['post_code'] = $request->post_code;
        $data['division_id'] = $request->division_id;
        $data['district_id'] = $request->district_id;
        $data['state_id'] = $request->state_id;
        $data['notes'] = $request->notes;
        $cartTotal = Cart::subtotal();               
        $cartQty = Cart::count();
        

        if ($request->payment_method == 'paystack') {
           return view('frontend.payment.paystack',compact('data','cartTotal','cartQty'));
        }elseif ($request->payment_method == 'card') {
            return 'card';
        }else {
            return view('frontend.payment.cash',compact('data','cartTotal','cartQty'));
        }

    } // end method
}
