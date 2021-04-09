<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected  $guarded = [];
    public function categorys()
    {
        return $this->belongTo('App\Models\Category','category_id','id');
    }

    public function sub_categorys()
    {
        return $this->belongsTo('App\Models\SubCategory','sub_catagory_id','id');
    }

    public function brands(){
        return $this->belongsTo('App\Models\Band','brand_id','id');
    }

}
