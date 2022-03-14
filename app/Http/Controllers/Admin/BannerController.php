<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index',compact('banners'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'banner_name' => 'required',
            'banner_image' => 'required|file',
            'banner_url' => 'required',
        ]);

        if($request->file('banner_image'))
        {   
            $path = $request->file('banner_image')->store('/uploads');
        }else{
            $path = '';
        }

        $banner = new Banner;
        $banner->banner_name = $request->banner_name;
        $banner->banner_image = $path;
        $banner->banner_url = $request->banner_url;
        $banner->save();

        return redirect()->back();
    }
    public function delete(Banner $banner)
    {
        unlink('public/'.str_replace(env('APP_URL'), '', $banner->getOriginal('banner_image')));
        $banner->delete();
        return redirect()->back();
    }
}
