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
<style>
	.modal-footer{display: flex}
</style>

<div class="modal fade" id="StatusModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Update Status</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.orders.statusupdate')}}" enctype="multipart/form-data" method="POST">
			@csrf
			<input type="hidden" name="order_id" id="order_id">
			<div class="modal-body">
				
				
				<div class="form-group">
					<label class="label-control">Status</label>
					<select name="status" class="form-control" id="status" required>
						<option value="pending">Pending</option>
						<option value="preparing">Preparing</option>
						<option value="picked">Picked</option>
						<option value="on-the-way">On the Way</option>
						<option value="delivered">Delivered</option>
						<option value="canceled">Canceled</option>
					</select>
				</div>
						
					
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		</form>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="ViewModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Order Detail</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		
			<div class="modal-body">
			
				<div class="table-responsive">
					<table class="table">
						<thead>
							<th>Item Name</th>
							<th>Quantity</th>
							<th>Price</th>
						</thead>
						<tbody class="order_detail"></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="row">
 
	 
	<div class="col-12">
		<div class="box">
			 
			
			<div class="box-body">
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
								<!-- <th scope="col">Delivery Mode</th> -->
								<th scope="col">Branch</th>
								<th scope="col">Status</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orders as $item)
								@if($item->customer)
								<tr>
									<td style="text-align: center;">
										{{$item->created_at->diffForHumans()}}
										<p>{{Date('D d M Y h:i a', strtotime($item->created_at))}}</p>
									</td>
									<td>{{$item->id}}</td>
									<td>{{$item->customer->name}} {{$item->customer->last_name}}</td>
									<td>{{$item->address}}</td>
									<td>{{$item->customer->phoneNo}}</td>
									<td>{{$item->order_items->count()}}</td>
									<td>Rs.{{$item->total_amount-$item->discount_amount}}</td>
									<!-- <td>{{$item->delivery_mode}}</td> -->
									<td>{{($item->branch) ? $item->branch->branch_name : '' }}</td>
									<td>
										@if($item->status == 'delivered')
										<label class="label label-success" rel="{{$item}}">{{ucwords($item->status)}}</label>
										@elseif($item->status == 'canceled')
										<label class="label label-danger" rel="{{$item}}">{{ucwords($item->status)}}</label>
										@else
										<label class="label label-warning" data-toggle="modal" data-target="#StatusModal" rel="{{$item}}">{{ucwords($item->status)}}</label>
										@endif
									</td>
									<td>
										<a href="{{route('admin.order.show',$item->id)}}" class="btn btn-success" target="_blank">
											<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
										</a>
										<!-- <span class="badge badge-sm badge-primary" data-toggle="modal" data-target="#ViewModal" rel="{{$item->order_items}}">View</span> -->
									</td>
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
    <script>
    	$(document).ready(function(){
    		setTimeout(location.reload.bind(location), 600000);
    	});
        $('#StatusModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var item = JSON.parse(button.attr('rel'));
            
			modal.find('#order_id').val(item.id);
			modal.find('#status option[value="'+item.status+'"]').prop('selected', true);
		});
		$('#ViewModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var obj = JSON.parse(button.attr('rel'));
            console.log(obj);
			var detail = '';
            $.each(obj, function(key,item) {
				detail += '<tr><td>'+item.name+'</td><td>'+item.quantity+'</td><td>'+item.price+'</td></tr>';
			}); 
			modal.find('.order_detail').html(detail);
		});
    </script>
@endpush