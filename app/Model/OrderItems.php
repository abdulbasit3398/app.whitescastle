<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    public function order()
    {
        $this->belongsTo('App\Model\Orders');
    }
    public function menu()
    {
        return $this->hasOne('App\MenuItems','id','menu_item_id');
    }
    public function deals()
    {
        return $this->hasOne('App\Model\Deals','id','menu_item_id');
    }
}
