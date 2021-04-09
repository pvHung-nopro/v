<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected  $guarded = [];

    public function users()
    {
        return $this->belongsToMany('App\User','table_user_role','roles_id','user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission','table_permission_role','roles_id','permission_id');
    }
}
