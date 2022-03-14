<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    //
    public function admin()
    {
        return $this->belongsTo('App\User', 'user_id')->whereType('manager');
    }

    public function orders()
    {
        return $this->hasMany('App\Model\Orders', 'branch_id');
    }
}
