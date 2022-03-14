@extends('layouts.app')

@section('page_title','Branches')
@section('container_class','container-full')

@section('content')
<style>
	.modal-footer{display: flex}
</style>
<div class="modal fade" id="MenuModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">New Branch</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.branches.store')}}" autocomplete="false" enctype="multipart/form-data" method="POST">
			@csrf
			<div class="modal-body">
				
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Branch Code</label>
							<input type="text" name="branch_code" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Brance Name</label>
							<input type="text" name="branch_name" class="form-control" required />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">First Name</label>
							<input type="text" name="f_name" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Last Name</label>
							<input type="text" name="l_name" class="form-control" required />
						</div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Email</label>
							<input type="email" name="branch_email" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Password</label>
							<input type="password" name="password" class="form-control" autocomplete="false" required />
						</div>
						
					</div>
				</div>
				<div class="form-group">
					<label class="label-control">Phone</label>
					<input type="number" name="branch_phone" class="form-control" required />
				</div>
				<div class="form-group">
					<label class="label-control">Address</label>
					<textarea name="branch_address" id="branch_address" class="form-control" rows="5"></textarea>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Latitude</label>
							<input type="text" name="branch_latitude" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Longitude</label>
							<input type="text" name="branch_longitude" class="form-control" required />
						</div>
					</div>
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

<div class="modal fade" id="EditModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Edit Branch</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.branches.store')}}" autocomplete="off" enctype="multipart/form-data" method="POST">
			@csrf
			<input type="hidden" name="branch_id" id="branch_id" value="0">
			<div class="modal-body">
				
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Branch Code</label>
							<input type="text" name="branch_code" id="ebranch_code" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Brance Name</label>
							<input type="text" name="branch_name" id="ebranch_name" class="form-control" required />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">First Name</label>
							<input type="text" name="f_name" id="ef_name" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Last Name</label>
							<input type="text" name="l_name" id="el_name" class="form-control" required />
						</div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Email</label>
							<input type="email" name="branch_email" id="ebranch_email" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Change Password</label>
							<input type="password" name="oldpassword" style="display: none" />
							<input type="password" name="password" id="epassword" class="form-control" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="label-control">Phone</label>
					<input type="number" name="branch_phone" id="ebranch_phone" class="form-control" required />
				</div>
				<div class="form-group">
					<label class="label-control">Address</label>
					<textarea name="branch_address" id="ebranch_address" class="form-control" rows="5"></textarea>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Latitude</label>
							<input type="text" name="branch_latitude" id="ebranch_latitude" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Longitude</label>
							<input type="text" name="branch_longitude" id="ebranch_longitude" class="form-control" required />
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Status</label>
							<select class="form-control" name="status" id="status">
								<option value="1">Active</option>
								<option value="0">Deactive</option>
							</select>
						</div>
					</div>
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
				<h4 class="box-title">Branches</h4>
				<a href="#" data-toggle="modal" data-target="#MenuModal"><img src="{{asset('assets/admin/images/svg-icon/flat-color-icons/SVG/plus.svg')}}" class="pull-right"  width='32' alt=""></a>
			</div>
			
			<div class="box-body p-0">
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="thead-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Branch Code</th>
								<th scope="col">Name</th>
								<th scope="col">Phone</th>
								<th scope="col">email</th>
								<th scope="col">Address</th>
								<th scope="col">Latitude</th>
								<th scope="col">Longitude</th>
								<th scope="col">Admin</th>
								<th scope="col">Created Date</th>
								<th scope="col">Status</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($branches as $item)
							@if($item->admin)
								<tr>
									<th scope="row">{{$item->id}}</th>
									<td>{{$item->branch_code}}</td>
									<td>{{$item->branch_name}}</td>
									<td>{{$item->branch_phone}}</td>
									<td>{{$item->branch_email}}</td>
									<td>{{$item->branch_address}}</td>
									<td>{{$item->branch_latitude}}</td>
									<td>{{$item->branch_longitude}}</td>
									<td>{{$item->admin->name}} {{$item->admin->last_name}}</td>
									<td>{{date('m-d-Y',strtotime($item->created_at))}}</td>
									<td>
										@if($item->active == 1)
											<span class="badge badge-sm badge-success">Active</span>
										@else
											<span class="badge badge-sm badge-danger">Deactive</span>
										@endif
									</td>
									<td><span class="badge badge-sm badge-primary" data-toggle="modal" data-target="#EditModal" rel="{{$item}}">Edit</span></td>
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
    $('#EditModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var modal = $(this);
      var item = JSON.parse(button.attr('rel'));
			console.log(item);
      modal.find('#branch_id').val(item.id);
      modal.find('#ebranch_code').val(item.branch_code);
			modal.find('#ebranch_name').val(item.branch_name);
			modal.find('#ef_name').val(item.admin.name);
			modal.find('#el_name').val(item.admin.last_name);
			modal.find('#ebranch_email').val(item.branch_email);
			modal.find('#ebranch_phone').val(item.branch_phone);
			modal.find('#ebranch_address').val(item.branch_address);
			modal.find('#ebranch_latitude').val(item.branch_latitude);
			modal.find('#ebranch_longitude').val(item.branch_longitude);
			modal.find('#status').val(item.active).change();
    });
  </script>
@endpush