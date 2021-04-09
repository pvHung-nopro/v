<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ProductService;
use App\Service\CategoryService;
use App\Service\SubCategoryService;

class SubCategoryController extends Controller
{
    public $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService){
        $this->subCategoryService = $subCategoryService;
    }

    public function subcategoryProduct($id,$page){
        try{
          $subcategory_product =  $this->subCategoryService->subcategory_product($id,$page);
            return response()->json([
                'status'=> true,
                'data'=> $subcategory_product
            ]);
        }catch(\Exception $e){
            return  response()->json([
                'status'=>false,
                'errors'=>$e->getMessage()
         ]);
        }
    }
}
