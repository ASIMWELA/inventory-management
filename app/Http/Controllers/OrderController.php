<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Orders;
use App\Models\product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $user;
    protected $cartPrice;


    public function __construct()
    {
        $this->middleware('auth:api')->except(['getAllProductCategories', 'getCategory']);
        $this->user = $this->guard()->user();
        $this->cart = array();
    }

    public function addToCart($productId){

        $order = new Orders;

        $product = product::where('id', '=', $productId)->first();

        if(is_null($product)){
            return response()->json([
                'status'=>'error',
                'message'=>'No product found with the specified Id'
            ]);
        }
        $user = User::where('userName', '=', $this->user->userName)->first();

        if(is_null($user)){
            return response()->json([
                'status'=>'error',
                'message'=>'No user found with the specified name'
            ]);
        }

        $product->quantity = ($product->quantity)-1;
        $order->orderName =$user->userName;
        $order->user_id = $user->id;
        $order->details = $user->userName .'_'.$product->name;
        $order->product_id = $product->id;
        $order->status = 'SHOPPING CART';
        $order->orderDate = date("Y-m-d h:i");
        $order->subtotal = $product->price_per_unit;
        $product->save();
        $order->save();

        $orderList = Orders::where('status', 'SHOPPING CART')->where('orderName', $user->userName)->get();

        $this->cartPrice = 0;
        foreach ($orderList as $order){
            $this->cartPrice += floatval($order->subtotal);
        }
        return response()->json([
           "status"=>"ok",
            'cartPrice'=>$this->cartPrice,
            "orders"=>$orderList
        ], 200);
    }

    public function confirmOrder($orderId): \Illuminate\Http\JsonResponse
    {
        $order = Orders::where('id', '=', $orderId)->where('status', 'PENDING')->update([
            'status'=>'COMPLETE'
        ]);

        if($order == 0){
            return response()->json([
                'status'=>'error',
                'message'=>'No order found with name given'
            ], 404);
        }
        return response()->json([
            'status'=>'ok',
            'message'=>'order successfully completed'
        ]);
    }

    public function resetCartPrice(){
        $this->cartPrice = 0;
        return response()->json([
           'status'=>'ok',
           'message'=>'Reset success'
        ]);
    }

    public function checkoutOrder(): \Illuminate\Http\JsonResponse
    {
        Orders::where('status', 'SHOPPING CART')->where('orderName', $this->user->userName)->update([
            'status'=>'PENDING'
        ]);

        $orders = Orders::where('status', 'PENDING')->where('orderName', $this->user->userName)->paginate(9);

        $this->cartPrice = 0;
        return response()->json([
           'status'=>'ok',
           'message'=>'checkout successful',
           'Orders'=>$orders
        ]);


    }

    public function getOrders(){

        $orders = Orders::where('status', 'PENDING')->paginate(8);

        if(is_null($orders)){
            return response()->json([
               'status'=>'error',
               'message'=>'No orders'
            ]);
        }
        return response()->json([
           'status'=>'ok',
           'orders'=>$orders
        ]);

    }

    public function getCompletedOrders(){
        $completedOrders = Orders::where('status', 'COMPLETE')->paginate(9);
        if(is_null($completedOrders)){
            return response()->json([
               'status'=>'ok',
               'message'=>'No completed Orders Yet'
            ]);
        }

        return response()->json([
           'status'=>'ok',
           'orders'=>$completedOrders
        ]);
    }

    public function getCompletedOrderByUserName($userName){

        $orders = Orders::where('status', 'COMPLETE')->where('orderName', $userName)->paginate(9);
        if(is_null($orders)){
            return response()->json([
               'status'=>'ok',
               'Message'=>'No orders Completed Yet'
            ]);
        }

        return response()->json([
            'status'=>'ok',
            'orders'=>$orders
        ]);

    }

    private function guard()
    {
        return Auth::guard();
    }
}
