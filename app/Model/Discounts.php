<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    public function DiscountOrders()
    {
        return $this->hasMany('App\Model\Orders','discount_id');
    }
}
