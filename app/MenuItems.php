<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{

    public function orders(Type $var = null)
    {
        $this->hasMany('App\Model\OrderItems');
    }
    
    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo('App\SubCategories', 'sub_category_id');
    }

    public function getImageUrlAttribute($value)
    {
        if($value)
        {
            $url = asset('public').'/'.$value;
        }else{
            $url = asset('assets/admin/images/Inteligentnyobiektwektorowy-2.png');
        }
        return $url;
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getSizetypeAttribute($value)
    {
        return ucwords($value);
    }
    public function order_item()
    {
        return $this->belongsTo('App\Model\OrderItems');
    }
}
