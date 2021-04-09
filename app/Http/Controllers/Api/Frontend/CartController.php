<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ProductService;
use App\Service\CartService;

class CartController extends Controller
{
    public $cartService;
    public function __construct(CartService $cartService)
    {
      $this->cartService = $cartService;
    }
      public function store($id)
      {

        try {
                  $cartStore = $this->cartService->store($id);
                  return response()->json([
                      'status'=>true,
                      'data'=>$cartStore
                  ]);
               }catch(\Exception $e){
                  return  response()->json([
                         'status'=>false,
                         'errors'=>$e->getMessage()
                  ]);
               }
      }

      public function showCart()
      {
        try {
            $showCart = $this->cartService->show_cart();
            return response()->json([
                'status'=>true,
                'data'=> $showCart
            ]);
         }catch(\Exception $e){
            return  response()->json([
                   'status'=>false,
                   'errors'=>$e->getMessage()
            ]);
         }
      }

      public function update(Request $request,$id)
      {
        try {
            $updateCart = $this->cartService->update($request,$id);
            return response()->json([
                'status'=>true,
                'data'=>  $updateCart
            ]);
         }catch(\Exception $e){
            return  response()->json([
                   'status'=>false,
                   'errors'=>$e->getMessage()
            ]);
         }
      }

      public function deletedCart($id)
      {
        try {
            $deletedCart = $this->cartService->deleted($id);
            return response()->json([
                'status'=>true,
                'data'=>  $deletedCart
            ]);
         }catch(\Exception $e){
            return  response()->json([
                   'status'=>false,
                   'errors'=>$e->getMessage()
            ]);
         }
      }

      public function deltedCartall()
      {
        try {
            $deletedCart_all = $this->cartService->deleted_all();
            return response()->json([
                'status'=>true,
                'data'=> $deletedCart_all
            ]);
         }catch(\Exception $e){
            return  response()->json([
                   'status'=>false,
                   'errors'=>$e->getMessage()
            ]);
         }



      }
}
