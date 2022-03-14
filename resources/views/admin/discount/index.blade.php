@extends('layouts.app')

@section('page_title','Discounts')
@section('container_class','container-full')

@section('content')
<style>
	.modal-footer{display: flex}
</style>
<div class="modal fade" id="DiscountModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">New Discount</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.discount.store')}}" enctype="multipart/form-data" method="POST">
			@csrf
			<div class="modal-body">
				<div class="form-group">
					<label class="label-control">Coupon Code</label>
					<input type="text" name="coupon_code" class="form-control" required />
				</div>
				<div class="form-group">
					
					<input type="radio" name="coupon_type" id="basic_radio_1" value="fixed" checked class="filled-in">
			  		<label for="basic_radio_1" class="mb-0 h-15">Fixed Amount</label> 

					<input type="radio" name="coupon_type" id="basic_radio_2" value="percentage" class="filled-in">
			  		<label for="basic_radio_2" class="mb-0 h-15">Percentage</label> 
					<input type="text" name="coupon_value" class="form-control" placeholder="Coupon Value" required />
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Per user limit</label>
							<input type="text" name="per_user_limit" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Usage limit</label>
							<input type="number" name="usage_limit" min="0" class="form-control" />
						</div>
					</div>
					
				</div>
				
				<div class="form-group">
					<label class="label-control">Status</label>
					<select name="status" class="form-control" required>
						<option value="1">Active</option>
						<option value="0">Expired</option>
					</select>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</form>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="EditDiscountModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Edit Discount</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.discount.store')}}" enctype="multipart/form-data" method="POST">
			@csrf
			<input type="hidden" name="discount_id" id="discount_id" value="0">
			<div class="modal-body">
				<div class="form-group">
					<label class="label-control">Coupon Code</label>
					<input type="text" name="coupon_code" id="coupon_code" class="form-control" required />
				</div>
				<div class="form-group">
					
					<input type="radio" name="coupon_type" id="basic_radio_1" value="fixed" checked class="filled-in">
			  		<label for="basic_radio_1" class="mb-0 h-15">Fixed Amount</label> 

					<input type="radio" name="coupon_type" id="basic_radio_2" value="percentage" class="filled-in">
			  		<label for="basic_radio_2" class="mb-0 h-15">Percentage</label> 
					<input type="text" name="coupon_value" id="coupon_value" class="form-control" placeholder="Coupon Value" required />
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Per user limit</label>
							<input type="text" name="per_user_limit" id="per_user_limit" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Usage limit</label>
							<input type="number" name="usage_limit" id="usage_limit" min="0" class="form-control" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="label-control">Status</label>
					<select name="status" id="status" class="form-control" required>
						<option value="1">Active</option>
						<option value="0">Expired</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</form>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row">
 
	 
	<div class="col-12">
		<div class="box">
			<div class="box-header with-border">
				<h4 class="box-title">Discounts</h4>
				<a href="#" data-toggle="modal" data-target="#DiscountModal"><img src="{{asset('assets/admin/images/svg-icon/flat-color-icons/SVG/plus.svg')}}" class="pull-right"  width='32' alt=""></a>
			</div>
			
			<div class="box-body p-0">
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="thead-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Coupon Code</th>
								<th scope="col">Coupon Type</th>
								<th scope="col">Value</th>
								<th scope="col">Per user limit</th>
								<th scope="col">Total Usage limit</th>
								<th scope="col">Number of time used</th>
								<th scope="col">Status</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($discounts as $item)
								<tr>
									<th scope="row">{{$item->id}}</th>
									<td>{{$item->coupon_code}}</td>
									<td>{{$item->coupon_type}}</td>
									<td>
										@if ($item->coupon_type == 'fixed')
										Rs.
										@endif
										{{$item->coupon_value}}
										@if ($item->coupon_type != 'fixed')
										%
										@endif
									</td>
									<td>{{$item->per_user_limit}}</td>
									<td>{{$item->usage_limit}}</td>
									<td>{{$item->DiscountOrders->count()}}</td>
									<td>
										@if ($item->status == 1)
											<span class="badge badge-sm badge-success">Active</span>
										@else
											<span class="badge badge-sm badge-danger">Expired</span>
										@endif	
									</td>
									<td><span class="badge badge-sm badge-primary" data-toggle="modal" data-target="#EditDiscountModal" rel="{{$item}}">Edit</span></td>
								</tr>
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
        $('#EditDiscountModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var item = JSON.parse(button.attr('rel'));
            modal.find('#discount_id').val(item.id);
            modal.find('#coupon_code').val(item.coupon_code);
			modal.find('input[name="coupon_type"][value="'+item.coupon_type+'"]').prop('checked', true);
			modal.find('#coupon_value').val(item.coupon_value);
			modal.find('#per_user_limit').val(item.per_user_limit);
			modal.find('#usage_limit').val(item.usage_limit);
			modal.find('#status option[value="'+item.status+'"]').prop('selected', true);
		});
    </script>
@endpush