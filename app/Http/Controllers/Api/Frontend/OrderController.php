<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ProductService;
use App\Service\OrderService;
use App\Http\Requests\Checkout;
use App\Models\OrderDetail;
use App\Service\CustomerService;
use App\Service\OrderDetailService;
use App\Service\CartService;
use App\Jobs\SendEmail;
use App\Mail\TestMail;
use Mail;
use Auth;
use Validation;


class OrderController extends Controller
{
    protected $orderService;
    protected $customerService;
    protected $orderDetailService;
    protected $cartService;

    public function __construct(OrderService $orderService ,CustomerService $customerService,
    OrderDetailService $orderDetailService , CartService $cartService){
         $this->orderService = $orderService;
         $this->customerService = $customerService;
         $this->orderDetailService = $orderDetailService;
         $this->cartService = $cartService;
    }

    public function order(Request $ret,Checkout $request)
  {
    try {


        $cartcheck = Cart::all()->toArray();

        if($cartcheck == []){
           return response()->json([
            'status'=>false,
            'data'=>  'bạn chưa mua hàng'
        ]);
        }else{
            $customer = $this->customerService->save($request);
            $order =  $this->orderService->save($request,['customer_id'=>$customer->id]);
            $orderId = $order->id;
            $cart = $this->cartService->show_cart();
            $this->orderDetailService->store($orderId,$cart);
            $this->cartService->deleted_all();

            $time = 1;
            for ($i = 0; $i < 1; $i++) {
                dispatch(new SendEmail(Auth::guard('api')->user()))->delay(now()->addSeconds($time));
            }
            return response()->json([
                'status'=>true,
                'data'=>  $cartcheck
            ]);
        }

     }catch(\Exception $e){
        return  response()->json([
               'status'=>false,
               'errors'=>$e->getMessage()
        ]);
     }
  }
}
