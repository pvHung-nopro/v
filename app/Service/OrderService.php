<?php
namespace App\Service;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderService{

    public function randCode($length = 10)
    {
     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
     $charactersLength = strlen($characters);
     $randomString = '';
     for ($i = 0; $i < $length; $i++) {
         $randomString .= $characters[rand(0, $charactersLength - 1)];
     }
     return $randomString;

    }

    public function save( $request,array $data,$id=null)
   {
    return Order::updateOrCreate([
        'id'=> $id
    ],
    [
       'code'        => $this->randCode(),
       'customer_id' => $data['customer_id'],
       'content'     => $request->content
    ]);
   }
}
