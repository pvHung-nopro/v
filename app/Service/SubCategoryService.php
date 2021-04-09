<?php
namespace App\Service;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;


class SubCategoryService{

    public function subcategory_product($id,$page = 6 ){
        return SubCategory::join('products','products.sub_category_id','sub_categories.id')
        ->where('sub_categories.id',$id)->addSelect('products.*')
        ->orderBy('products.id','desc')->paginate($page);
    }
}
