<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected  $guarded = [];
    public function categorys()
    {
         return $this->belongsTo('App\Models\Category','category_id','id');
    }
   public function product_subcategorys()
   {
       return $this->hasMany('App\Models\Product','sub_category_id','id');
   }
}
