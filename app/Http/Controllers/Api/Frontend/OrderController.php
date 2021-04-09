<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ProductService;
use App\Service\OrderService;
use App\Http\Requests\Checkout;
use App\Models\OrderDetail;
use App\Service\CustomerService;
use App\Service\OrderDetailService;
use App\Service\CartService;
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
         $customer = $this->customerService->save($request);
         $order =  $this->orderService->save($request,['customer_id'=>$customer->id]);
         $orderId = $order->id;
         $cart = $this->cartService->show_cart();
         $this->orderDetailService->store($orderId,$cart);
         $this->cartService->deleted_all();

        return response()->json([
            'status'=>true,
            'data'=>    $customer->id
        ]);
     }catch(\Exception $e){
        return  response()->json([
               'status'=>false,
               'errors'=>$e->getMessage()
        ]);
     }
  }
}
