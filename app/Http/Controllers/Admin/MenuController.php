<?php



namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\MenuItems;
use App\Model\Category;



class MenuController extends Controller

{
    //
    public function index()
    {
        $menues = MenuItems::orderBy('id', 'DESC')->get();
        $categories = Category::get();
        return view('admin.menu.index')->with(compact('menues','categories'));
    }
    public function edit_menu($id = 0)
    {
        $menu = MenuItems::findOrFail($id);
        $categories = Category::get();
        return view('admin.menu.edit')->with(compact('categories', 'menu'));
    }
    public function store(Request $request)
    {
        if($request->file('img_url'))
        {   
            $path = $request->file('img_url')->store('/uploads');
        }else{
            $path = '';
        }

        // $path = Storage::putFile('uploads', $request->file('img_url'));
        $price = @json_encode($request->price);
        $sizetype = @json_encode($request->sizetype);

        if($request->menu_id)

        {
            $menu = MenuItems::find($request->menu_id);

        }else{

            $menu = new MenuItems;

        }

        

        $menu->name = $request->name;

        $menu->category_id = $request->category_id;

        $menu->sub_category_id = 0;

        $menu->description = @addslashes($request->description);

        $menu->preparation_time = $request->preparation_time;

        $menu->calories = $request->calories;

        $menu->discount = $request->is_discount?$request->is_discount:0;

        $menu->discount_percentage = $request->discount_percentage? $request->discount_percentage:0;

        $menu->is_vat = $request->is_vat?$request->is_vat:0;

        $menu->vat_percentage = $request->vat_percentage?$request->vat_percentage:0;

        $menu->variation = $request->variations?$request->variations:0;

        $menu->static_price = $request->static_price?$request->static_price:0;

        $menu->price = $price;

        $menu->sizetype = $sizetype;

        $menu->is_out_of_stock = $request->is_out_of_stock?$request->is_out_of_stock:0;

        if(!empty($path))

        {

            $menu->image_url = $path;

        }



        $menu->save();



        return redirect()->back()->with('success', 'menu updated');   

    }
    public function delete(Request $request)
    {
        $menu = MenuItems::findOrFail($request->id);
        unlink(str_replace(env('APP_URL'), '', $menu->image_url));
        $menu->delete();
        return redirect()->back();

    }

}

