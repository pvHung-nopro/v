<?php
namespace App\Service;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductService{
    public function home($request,$page = 6){
      return  Product::select('*')->orderBy('id','desc')->where('is_feature',1)->paginate($page);

    }

   public function productId($id){
    $product =   Product::leftjoin('categories','products.category_id','=','categories.id')
    ->leftjoin('sub_categories','products.sub_category_id','=','sub_categories.id')
    ->leftjoin('brands','products.brand_id','=','brands.id')->where('products.id',$id)
    ->addSelect('products.*','categories.name as category_name','sub_categories.name as sub_categories_name','brands.name as brand_name')
    ->get();

    return $product;
   }


   public function search_product($search,$page){
       return   Product::where('name','LIKE','%'.$search."%")->paginate($page);
   }

  public function filter_product($data = [], $page = 6){
      return Product::select('*')->whereBetween('price',[$data['min'],$data['max']])->paginate($page);
  }



}
