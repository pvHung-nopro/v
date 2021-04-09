<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected  $guarded = [];

    public function permissionChild()
    {
        return $this->hasMany('App\Models\Permission','parent_id');
    }
}
