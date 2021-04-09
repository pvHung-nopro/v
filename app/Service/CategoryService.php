<?php
namespace App\Service;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;



class CategoryService{
    public function category_list($limit)
    {
        return Category::with('subcategory')->where('is_feature',1)->limit($limit)->get();
    }

    public function category_product($id,$page){
        return Category::join('products','products.category_id','categories.id')
        ->where('categories.id',$id)->addSelect('products.*')
        ->orderBy('products.id','desc')->paginate($page);
    }
}
