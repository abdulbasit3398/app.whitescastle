<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Discounts;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discounts::orderBy('id', 'DESC')->get();
        return view('admin.discount.index')->with(compact('discounts'));
    }

    public function store(Request $request)
    {
        $check = Discounts::where('coupon_code', $request->coupon_code)->first();
        if(!$check)
        {
            if($request->discount_id)
            {
                $item = Discounts::find($request->discount_id);
            }else{
                $item = new Discounts;
            }

            $item->coupon_code = $request->coupon_code;
            $item->coupon_type = $request->coupon_type;
            $item->coupon_value = $request->coupon_value;
            $item->user_id = 0;
            $item->per_user_limit = $request->per_user_limit?$request->per_user_limit:0;
            $item->usage_limit = $request->usage_limit?$request->usage_limit:0;
            $item->status = $request->status;
            if($request->discount_id)
            {}else{
                $item->added_by = \Auth::user()->id;
            }
            $item->save();
            return redirect()->back()->with('success', 'your message,here');  
        }
        else
        {
            $check->coupon_code = $request->coupon_code;
            $check->coupon_type = $request->coupon_type;
            $check->coupon_value = $request->coupon_value;
            $check->user_id = 0;
            $check->per_user_limit = $request->per_user_limit?$request->per_user_limit:0;
            $check->usage_limit = $request->usage_limit?$request->usage_limit:0;
            $check->status = $request->status;
            $check->save();

            return redirect()->back()->with('success', 'Coupon code added.');  
        }

         
    }
}
