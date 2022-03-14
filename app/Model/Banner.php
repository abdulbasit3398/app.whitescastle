<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    public function getBannerImageAttribute($value)
    {
        return env('APP_URL').'public/'.$value;
    }
}
