<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\ProductService;
use App\Service\CategoryService;


class CategoryController extends Controller
{
    public $productService;
    public $categoryService;
    public function __construct(CategoryService $categoryService , ProductService $productService){
          $this->categoryService = $categoryService;
          $this->productService = $productService;
    }

    public function categoryList($limit)
    {
       try{
          $categoryList = $this->categoryService->category_list($limit);
          return response()->json([
              'status'=>true,
              'data'=>$categoryList
          ]);
       }catch(\Exception $e){
        return  response()->json([
            'status'=>false,
            'errors'=>$e->getMessage()
     ]);
       }
    }

    public function categoryProduct($id,$page){
        try{
            $category_product  = $this->categoryService->category_product($id,$page);
            return response()->json([
                'status'=>true,
                'data'=>$category_product
            ]);
        }catch(\Exception $e){
            return  response()->json([
                'status'=>false,
                'errors'=>$e->getMessage()
         ]);
        }
    }
}
