<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected  $guarded = [];
    public function subcategory()
    {
        return $this->hasMany('App\Models\SubCategory','category_id','id');
    }

    public function category_products()
    {
        return $this->hasMany('App\Models\Product','category_id','id');
    }

}
