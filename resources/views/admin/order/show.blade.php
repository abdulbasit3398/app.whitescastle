@extends('layouts.app')

@section('page_title','Orders')
@section('container_class','container-full')

@section('page-script')
<script type="text/javascript">
	$(document).ready(function() {
	    $('#example').DataTable({
	    	"ordering": false
	    });
	} );
</script>
@endsection
@section('content')
<style type="text/css">
	.label-top{
		float: right;
		font-size: 15px !important;
	}
</style>
<div class="row">
	<div class="col-12">
		<div class="box">
			<div class="box-header with-border">
				<h4 class="box-title">Order #{{$order->id}}</h4>
				@if($order->status == 'delivered')
				<label class="label label-success label-top" >{{ucwords($order->status)}}</label>
				@elseif($order->status == 'canceled')
				<label class="label label-danger label-top" >{{ucwords($order->status)}}</label>
				@else
				<label class="label label-warning label-top" >{{ucwords($order->status)}}</label>
				@endif
			</div>
			
			<div class="box-body">
				<div class="row">
					<div class="col-md-3">
						<h4>Customer Name</h4>
						<p>{{$order->customer->name}} {{$order->customer->last_name}}</p>
					</div>
					<div class="col-md-3">
						<h4>Mobile No</h4>
						<p>{{$order->customer->phoneNo}}</p>
					</div>
					<div class="col-md-3">
						<h4>Customer Address</h4>
						<p>{{$order->address}}</p>
					</div>
					<div class="col-md-3">
						<h4>Order Amount</h4>
						<p>Rs.{{$order->total_amount-$order->discount_amount}}</p>
					</div>
				</div>
				<br/>
				<div class="table-responsive">
					<table class="table table-striped table-bordered" id="example">
						<thead class="thead-light">
							<tr>
								<th scope="col">Item Name</th>
								<th scope="col">Variation</th>
								<th scope="col">Quantity</th>
								<th scope="col">Price</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($order->order_items as $item)
								@if($item->is_offer == 0)
								<tr>
									<td>{{($item->menu) ? $item->menu->name : 'Not Found'}}</td>
									<td>{{$item->sizetype}}</td>
									<td>{{$item->quantity}}</td>
									<td>{{$item->price}}</td>
								</tr>
								@else
								<tr>
									<td>{{($item->deals) ? $item->deals->deal_name : 'Not Found'}}</td>
									<td>
										@foreach($item->deals->deal_items as $deal_items)
										{{$deal_items->menu_item->name.' | '.$deal_items->sizeType.' | '.$deal_items->quantity}}
										<br/>
										@endforeach
									</td>
									<td>{{$item->quantity}}</td>
									<td>{{$item->price}}</td>
								</tr>
								@endif
							@endforeach
							
							
						</tbody>
					</table>
					
					
				</div>

			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')

@endpush