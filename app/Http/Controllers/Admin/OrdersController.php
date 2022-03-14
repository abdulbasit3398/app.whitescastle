<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Orders;
use DB;
class OrdersController extends Controller
{
  public function index()
  {
    if(\Auth::user()->type == 'admin')
    {
      $orders = Orders::orderBy('id', 'DESC')->limit(500)->get();
    }else{
      $branch_id = \Auth::user()->branch->id;
      $orders = Orders::Where('branch_id', $branch_id)->orderBy('id', 'DESC')->limit(500)->get();
    }
    return view('admin.order.index')->with(compact('orders'));
    
  }
  public function show(Orders $order)
  {
    if( Auth::user()->type == 'admin')
      return view('admin.order.show',compact('order'));
    
    if(Auth::user()->branch->id != $order->branch_id && Auth::user()->type != 'admin')
      return redirect(404);

    return view('admin.order.show',compact('order'));
  }
  public function CheckNewOrders()
  {
    if(\Auth::user()->type == 'admin')
    {
      $orders = Orders::where('is_notified', 0)->get();
      DB::table('orders')->Where('is_notified', '0')->update(array('is_notified' => 1));
    }else{
      $branch_id = \Auth::user()->branch->id;
      $orders = Orders::Where('branch_id', $branch_id)->Where('is_notified', 0)->get();
      DB::table('orders')->Where('branch_id', $branch_id)->Where('is_notified', '0')->update(array('is_notified' => 1));
    }
    return response()->json($orders);
  }

  public function UpdateStatus(Request $request)
  {
    if($request->order_id)
    {
      $item = Orders::find($request->order_id);
      $item->status = $request->status;
      $item->save();

      $this->send_notification($request->order_id,$request->status);
    }
    return redirect()->back()->with('success', 'your message,here'); 
  }
  public function send_notification($order_id,$status)
  {
    $order = Orders::findOrFail($order_id);
    if($order->customer->deviceToken)
    {
      $title = $order->customer->name.' '.$order->customer->last_name.', your order updated';
      $body = "Your order is now ".ucfirst($status);
      
      $token = $order->customer->deviceToken;  
      $from = env('FIREBASE_CREDENTIALS');

      $msg = array
            (
              'body'  => $body,
              'title' => $title,
              'type' => "order",
              'receiver' => 'erw',
              'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
              'sound' => 'mySound'/*Default sound*/
            );

      $fields = array
              (
                  'to'        => $token,
                  'notification'  => $msg,
                  'data' => $msg
              );

      $headers = array
              (
                  'Authorization: key=' . $from,
                  'Content-Type: application/json'
              );
      $ch = curl_init();
      curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
      curl_setopt( $ch,CURLOPT_POST, true );
      curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
      curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
      $result = curl_exec($ch );
      curl_close( $ch );

    }
  }
}
