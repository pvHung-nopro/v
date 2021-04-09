<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ProductService;

class ProductController extends Controller
{
     public $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function home(Request $request,$page)
    {
        try {
         $homeProduct   =   $this->productService->home($request,$page);
         return response()->json([
             'status'=> true,
             'data'=> $homeProduct
         ]);
            }catch(\Exception $e){
               return  response()->json([
                      'status'=>false,
                      'errors'=>$e->getMessage()
               ]);
            }



    }




    public function productId($id){
         try{
             $productId = $this->productService->productId($id);
             return response()->json([
                 'status'=>true,
                 'data'=>$productId
            ]);
         }catch(\Exception $e){
           return response()->json([
               'status'=>false,
               'errors'=>$e->getMessage()
           ]);
         }
    }


    public function productSale($limit){
        try{

        }catch(\Exception $e){

        }

    }

    public function searchProduct(Request $request,$page = 6){
        try{
            $search = $request->name;
              $searchProduct = $this->productService->search_product($search,$page);
              return response()->json([
                 'status'=>true,
                 'data'=> $searchProduct
              ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'errors'=>$e->getMessage()
            ]);
            }

    }


    public function filterProduct(Request $request,$page){
        try{
            $filter_min = $request->min;
            $filter_max = $request->max;

         $data = [
             'min'=> $filter_min,
             'max'=> $filter_max
         ];
              $filteProduct = $this->productService->filter_product($data,$page);
              return response()->json([
                 'status'=>true,
                 'data'=> $filteProduct
              ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'errors'=>$e->getMessage()
            ]);
            }

    }


}
