<?php

namespace App\Http\Controllers\Admin;

use App\Model\Orders;
use App\Model\Branches;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

	public function index()
	{
		if(\Auth::user()->type == 'admin')
		{
			$orders = Orders::orderBy('id', 'DESC')->limit(500)->get();
			// $orders = Orders::orderBy('id', 'DESC')->paginate(10);
		}else{
			$branch_id = \Auth::user()->branch->id;
			$orders = Orders::Where('branch_id', $branch_id)->orderBy('id', 'DESC')->limit(500)->get();
			// $orders = Orders::Where('branch_id', $branch_id)->orderBy('id', 'DESC')->paginate(10);
		}

		return view('admin.index')->with(compact('orders'));
	}

	public function order_summary()
	{
		if(isset($_GET['date_from']))
		{
			$date_from = date('Y-m-d',strtotime($_GET['date_from']));
			$date_to = date('Y-m-d',strtotime($_GET['date_to']));
			$branch = isset($_GET['branch_id']) ? $_GET['branch_id'] : 'all';
			$order_status = isset($_GET['order_status']) ? $_GET['order_status'] : 'all';

			if($branch != 'all' && $order_status != 'all')
				$data['orders'] = Orders::where([['branch_id',$branch],['status',$order_status]])->whereBetween('created_at',[$date_from,$date_to])->get();
			elseif($branch != 'all')
				$data['orders'] = Orders::where('branch_id',$branch)->whereBetween('created_at',[$date_from,$date_to])->get();
			elseif($order_status != 'all')
				$data['orders'] = Orders::where('status',$order_status)->whereBetween('created_at',[$date_from,$date_to])->get();
			else
				$data['orders'] = Orders::whereBetween('created_at',[$date_from,$date_to])->get();


			// $data['orders'] = Orders::where('branch_id',$branch)->whereBetween('created_at',[$date_from,$date_to])->get();
		}
		$data['branches'] = Branches::all();
		return view('admin.order_summary',compact('data'));
	}
}	
