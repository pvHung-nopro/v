<?php
  namespace App\Service;
  use App\Models\Product;
  use App\Models\Category;
  use App\Models\SubCategory;
  use App\Models\Brand;
  use Illuminate\Http\Request;


  class BrandService{
      public function brand_product($id,$page){
         return Brand::join('products','products.brand_id','brands.id')
         ->where('brands.id',$id)->addSelect('products.*')
         ->orderBy('products.id','desc')->paginate($page);
      }
  }

