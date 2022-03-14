<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Model\Deals;
use App\Model\DealItems;
use App\MenuItems;
use DB;
class DealsController extends Controller
{
  public function index()
  {
    $deals = Deals::orderBy('id', 'DESC')->get();
    return view('admin.deals.index')->with(compact('deals'));
  }

  public function UpdateStatus(Request $request)
    {
        if($request->deal_id)
        {
            $item = Deals::find($request->deal_id);
            $item->status = $request->status;
            $item->save();
            
        }
        return redirect()->back()->with('success', 'your message,here'); 
    }

  public function new_deal()
  {
    $menues = MenuItems::orderBy('id', 'DESC')->get();
    return view('admin.deals.new')->with(compact('menues'));
  }

  public function edit_deal($id = 0)
  {
    $deal = Deals::find($id);
    $menues = MenuItems::orderBy('id', 'DESC')->get();
    return view('admin.deals.edit')->with(compact('menues', 'deal'));
  }

  public function store(Request $request)
  {
    if($request->file('img_url'))
    {   
      $path = $request->file('img_url')->store('/uploads');
    }else{
      $path = '';
    }
    $deal = new Deals;
    $deal->deal_name = $request->name;
    $deal->image_url = $path;
    $deal->deal_price = $request->deal_price;
    $deal->status = $request->status;
    $deal->save();
    $menuitem = $request->menuitem;
    $product_sizes = $request->sizetype;
    $product_quantities = $request->quantity;
    foreach ($menuitem as $key => $value) {
      $quantity = $product_quantities[$key];
      $size_type = $product_sizes[$key];
      $item = MenuItems::find($value);

      $dealitem = new DealItems;
      $dealitem->deal_id = $deal->id;
      $dealitem->menu_item_id = $value;
      $dealitem->menu_item_name = $item->name;
      $dealitem->quantity = $quantity;
      $dealitem->sizetype = $size_type? $size_type: '';
      $dealitem->save();
     
    }
    // return redirect()->back()->with('success', 'your message,here');   
    return redirect('admin/deals');
  }

  public function update(Request $request)
  {
    if($request->file('img_url'))
    {   
      $path = $request->file('img_url')->store('/uploads');
    }else{
      $path = '';
    }
    $deal = Deals::find($request->deal_id);
    $deal->deal_name = $request->name;
    if(!empty($path))
    {
      $deal->image_url = $path;
    }
    $deal->deal_price = $request->deal_price;
    $deal->status = $request->status;
    $deal->save();
    DB::table('deal_items')->where('deal_id', $deal->id)->delete();
    $menuitem = $request->menuitem;
    $product_sizes = $request->sizetype;
    $product_quantities = $request->quantity;
    foreach ($menuitem as $key => $value) {
      $quantity = $product_quantities[$key];
      $size_type = $product_sizes[$key];
      $item = MenuItems::find($value);

      $dealitem = new DealItems;
      $dealitem->deal_id = $deal->id;
      $dealitem->menu_item_id = $value;
      $dealitem->menu_item_name = $item->name;
      $dealitem->quantity = $quantity;
      $dealitem->sizetype = $size_type? $size_type: '';
      $dealitem->save();
     
    }
    // return redirect()->back()->with('success', 'your message,here');   
    return redirect('admin/deals');
  }
}
