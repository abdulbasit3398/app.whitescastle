@extends('layouts.app')

@section('page_title','Deals')
@section('container_class','container-full')

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
		<form action="{{route('admin.deals.statusupdate')}}" enctype="multipart/form-data" method="POST">
			@csrf
			<input type="hidden" name="deal_id" id="deal_id">
			<div class="modal-body">
				
				
				<div class="form-group">
					<label class="label-control">Status</label>
					<select name="status" class="form-control" id="status" required>
						<option value="1">Active</option>
            <option value="0">Expired</option>
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
							<th>Size</th>
							<th>Quantity</th>
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
			<div class="box-header with-border">
				<h4 class="box-title">Deals</h4>
				<a href="{{route('admin.newdeal')}}"><img src="{{asset('assets/admin/images/svg-icon/flat-color-icons/SVG/plus.svg')}}" class="pull-right"  width='32' alt=""></a>
			</div>
			
			<div class="box-body p-0">
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="thead-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Image</th>
								<th scope="col">Name</th>
								<th scope="col">Items</th>
								<th scope="col">Price</th>
								<th scope="col">Status</th>
								<th scope="col">Created Date</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($deals as $deal)
								<tr>
									<th scope="row">{{$deal->id}}</th>
									<td><img src="{{$deal->image_url?$deal->image_url: asset('assets/admin/images/Inteligentnyobiektwektorowy-2.png')}}" alt="product iamge" width="100"></td>
									<td>{{$deal->deal_name}}</td>
									<td>{{$deal->deal_items->count()}}</td>
									<td>Rs.{{$deal->deal_price}}</td>
									<td>
										@if ($deal->status == 1)
											<span class="badge badge-sm badge-primary" data-toggle="modal" data-target="#StatusModal" rel="{{$deal}}">Active</span>
										@else
											<span class="badge badge-sm badge-danger" data-toggle="modal" data-target="#StatusModal" rel="{{$deal}}">Expired</span>	
										@endif
									</td>
									<td>{{$deal->created_at}}</td>
									<td>
										<a href="{{route('admin.editdeal', ['id' => $deal->id])}}" class="badge badge-sm badge-primary" rel="{{$deal}}">Edit</a> 
										<span class="badge badge-sm badge-success" data-toggle="modal" data-target="#ViewModal" rel="{{$deal->deal_items}}">View</span>
									</td>
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
		$(document).ready(function() {
			var max_fields      = 10; //maximum input boxes allowed
			var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
			var add_button      = $(".add_field_button"); //Add button ID
			
			var x = 1; //initlal text box count
			$(add_button).click(function(e){ //on add input button click
				e.preventDefault();
				if(x < max_fields){ //max input box allowed
					x++; //text box increment
					$(wrapper).append('<tr> <td><input type="text" name="sizetype[]" class="form-control" placeholder="Size Type" required /></td> <td><input type="text" name="price[]" class="form-control" placeholder="Price" required /></td> <td><button class="btn btn-default btn-md remove_field">Remove</button></td> </tr>'); //add input box
				}
			});
			
			$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
				e.preventDefault(); $(this).parents('tr').remove(); x--;
			})
		});

		$('#StatusModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var modal = $(this);
      var item = JSON.parse(button.attr('rel'));
      modal.find('#deal_id').val(item.id);
			modal.find('#status option[value="'+item.status+'"]').prop('selected', true);
		});

		$('#ViewModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var modal = $(this);
      var obj = JSON.parse(button.attr('rel'));
			var detail = '';
      $.each(obj, function(key,item) {
				detail += '<tr><td>'+item.menu_item_name+'</td><td>'+item.sizeType+'</td><td>'+item.quantity+'</td></tr>';
			}); 
			modal.find('.order_detail').html(detail);
		});

	</script>
@endpush