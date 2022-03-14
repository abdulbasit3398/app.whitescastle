@extends('layouts.app')

@section('page_title','Order Summary')
@section('container_class','container-full')

@section('custom-head')
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-datepicker.css')}}">
@endsection

@section('page-script')
<script src="{{asset('assets/admin/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
	$('.datepicker').datepicker();
	$(document).ready(function() {
		$('#example').DataTable({
			"ordering": false
		});
	});
</script>
@endsection

@section('content')
<style type="text/css">
#toast-container > .toast {
	max-width: 1200px;
	width: 90%;
}
.datepicker > div {
    display: block ;
}
</style>

<div class="row">
	
	<div class="col-12">
		<form action="{{route('admin.order-summary')}}" method="get">
		<div class="box">
			<div class="box-body">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="form-label">From</label>
							<input type="text" name="date_from" class="form-control datepicker" required>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="form-label">To</label>
							<input type="text" name="date_to" class="form-control datepicker" required>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="form-label">Branch</label>
							<select class="form-control" name="branch_id">
								<option value="all">All</option>
								@foreach($data['branches'] as $branch)
								<option value="{{$branch->id}}">{{$branch->branch_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="form-label">Order Status</label>
							<select class="form-control" name="order_status">
								<option value="all">All</option>
								<option value="pending">Pending</option>
								<option value="preparing">Preparing</option>
								<option value="picked">Picked</option>
								<option value="on-the-way">On the Way</option>
								<option value="delivered">Delivered</option>
								<option value="canceled">Canceled</option>

							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Search</button>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
		


		@if(isset($_GET['date_from']))
		<div class="box">
			<div class="box-body ">
				<div class="table-responsive">
					<table class="table table-striped table-bordered" id="example">
						<thead class="thead-light">
							<tr>
								<th scope="col" style="text-align: center;">Date</th>
								<th scope="col">Order Id</th>
								<th scope="col">Customer</th>
								<th scope="col">Address</th>
								<th scope="col">Mobile No</th>
								<th scope="col">Total Items</th>
								<th scope="col">Total Amount</th>
								<th scope="col">Branch</th>
								<th scope="col">Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data['orders'] as $order)
								@if($order->customer)
								<tr>
									<td style="text-align: center;">
										{{$order->created_at->diffForHumans()}}
										<p>{{Date('D d M Y h:i a', strtotime($order->created_at))}}</p>
									</td>
									<td>{{$order->id}}</td>
									<td>{{$order->customer->name}} {{$order->customer->last_name}}</td>
									<td>{{$order->address}}</td>
									<td>{{$order->customer->phoneNo}}</td>
									<td>{{$order->order_items->count()}}</td>
									<td>Rs.{{$order->total_amount-$order->discount_amount}}</td>
									<td>{{($order->branch) ? $order->branch->branch_name : '' }}</td>
									<td>
										@if($order->status == 'delivered')
										<label class="label label-success" >{{ucwords($order->status)}}</label>
										@elseif($order->status == 'canceled')
										<label class="label label-danger" >{{ucwords($order->status)}}</label>
										@else
										<label class="label label-warning" >{{ucwords($order->status)}}</label>
										@endif
									</td>
								</tr>
								@endif
							@endforeach
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
		@endif
	</div>
</div>

@endsection