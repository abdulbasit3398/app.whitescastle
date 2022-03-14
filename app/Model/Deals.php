<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Deals extends Model
{
    public function deal_items()
    {
        return $this->hasMany('App\Model\DealItems', 'deal_id');
    }

    public function getImageUrlAttribute($value)
    {
        if($value)
        {
            $url = asset('public/'.$value);
        }else{
            $url = '';
        }
        return $url;
    }
}
