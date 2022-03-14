<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    //
    public function sub_category_items()
    {
        return $this->hasMany('App\MenuItems', 'sub_category_id');
    }

    public function maincategory()
    {
        return $this->belongsTo('App\Model\Category');
    }

    public function getImageUrlAttribute($value)
    {
        if($value)
        {
            $url = asset($value);
        }else{
            $url = asset('assets/admin/images/Inteligentnyobiektwektorowy-2.png');
        }
        return $url;
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
