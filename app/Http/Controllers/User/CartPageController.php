<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartPageController extends Controller
{
   public function MyCart(){
       return view('frontend.wishlist.view_mycart');
   } // End Method

   public function GetCartProduct(){
       $carts = Cart::content();
       $cartQty = Cart::count();
       $cartTotal = Cart::subtotal();
       
       return response()->json(array(
              'carts' => $carts,
              'cartQty' => $cartQty,
              'cartTotal' => round($cartTotal),
       ));
   } // End Method

   public function RemoveCartProduct($rowId){
      Cart::remove($rowId);
       
      if (Session::has('coupon')) {
          Session::forget('coupon');
      }

      return response()->json(['success' => 'Successfull Remove From Cart']);

   } // End Method

   //------cart increment -----///
   public function CartIncrement($rowId){
        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty + 1);
        if (Session::has('coupon')) {

            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();
            
            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::subtotal() * $coupon->coupon_discount / 100),
                'total_amount' => round(Cart::subtotal() - Cart::subtotal() * $coupon->coupon_discount / 100),
            ]);
        }

        return response()->json('increment');

   }// End Method 

   //----- cart decrement ---///
   public function CartDecrement($rowId){
    $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty - 1);
        
        if (Session::has('coupon')) {

            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();
            
            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::subtotal() * $coupon->coupon_discount / 100),
                'total_amount' => round(Cart::subtotal() - Cart::subtotal() * $coupon->coupon_discount / 100),
            ]);
        }

        return response()->json('Decrement');

   } // End Method
}
