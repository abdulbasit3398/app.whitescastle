<?php

namespace App\Http\Controllers;

use App\Model\AdminSetting;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function admin_setting($value)
    {
        $setting = AdminSetting::where('filed_name',$value)->first();
        if($setting)
            return $setting->field_value;
        else
            return 0;
    }
}
