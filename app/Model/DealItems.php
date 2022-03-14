<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DealItems extends Model
{
  public function order()
  {
    $this->belongsTo('App\Model\Deals');
  }
  public function menu_item()
  {
    return $this->hasOne('App\MenuItems','id','menu_item_id');
  }
}
