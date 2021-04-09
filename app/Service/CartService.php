<?php
namespace App\Service;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Cart;
use Illuminate\Http\Request;
use Session;
  class CartService{

     public function store($id)
     {
     $product_price = Product::find($id)->price;
      $product =   Cart::where('product_id',$id)->first();
      if (!$product){
          $qty = 0 ;
      }else{
        $qty = (int) $product->qty ;
      }

         Cart::updateOrCreate([
             'product_id'=>$id
         ],[
            'qty' => $qty+1,
            'total'=> ($qty+1)*$product_price
         ]);

         $total = Cart::all();
         return $total->count();
     }

     public function show_cart()
     {
        return   Cart::join('products','carts.product_id','products.id')
          ->addSelect('products.*','carts.qty as cart_qty','carts.total as total')->get();
     }


     public function update($request,$id)
     {

         $qty = $request->qty;
         $cart = Cart::find($id);
         $productId = $cart->product_id;
         $product_price = Product::find($productId)->price;
         $cart->qty = $qty;
         $cart->total = $qty*$product_price;
       return  $cart->save();
     }

     public function deleted($id)
     {
         return Cart::destroy($id);
     }

     public function deleted_all(){
         return Cart::truncate();
     }




  }
