<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['user_id', 'branch_id', 'address', 'latitude', 'longitude', 'status'];
    public function order_items()
    {
        return $this->hasMany('App\Model\OrderItems', 'order_id');
    }
    
    public function discount()
    {
        return $this->belongsTo('App\Model\Discounts');
    }

    public function customer()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Model\Branches', 'branch_id');
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return Date('D d M Y h:i a', strtotime($value));
    // }
}
