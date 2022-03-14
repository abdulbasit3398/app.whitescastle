<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\MenuItems;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $table = 'categories';

    public function products()
    {
        return $this->hasMany('App\MenuItems', 'category_id');
    }

    public function sub_categories()
    {
        return $this->hasMany('App\SubCategories');
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
