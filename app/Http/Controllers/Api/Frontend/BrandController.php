<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ProductService;
use App\Service\BrandService;

class BrandController extends Controller
{
    public $brandService;

    public function __construct(BrandService $brandService){
          $this->brandService  = $brandService;
    }

    public function brandProduct($id,$page){
        try{
             $brandProduct = $this->brandService->brand_product($id,$page);
              return response()->json([
                  'status'=> true,
                  'data'=>  $brandProduct
              ]);
          }catch(\Exception $e){
              return  response()->json([
                  'status'=>false,
                  'errors'=>$e->getMessage()
           ]);
          }
    }
}
