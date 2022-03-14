@extends('layouts.app')

@section('page_title','Customers')
@section('container_class','container-full')

@section('content')
<style>
	.modal-footer{display: flex}
</style>
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">New Customer</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.customers.store')}}" enctype="multipart/form-data" method="POST">
			@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">First Name</label>
							<input type="text" name="name" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Last Name</label>
							<input type="text" name="last_name" class="form-control" required />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Email</label>
							<input type="text" name="email" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Password</label>
							<input type="password" name="password" class="form-control" required />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="label-control">Phone</label>
					<input type="text" name="phone" class="form-control" required />
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
		  <h4 class="modal-title">Edit Customer</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.customers.store')}}" enctype="multipart/form-data" method="POST">
			@csrf
			<input type="hidden" name="user_id" id="user_id">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">First Name</label>
							<input type="text" name="name" id="ename" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Last Name</label>
							<input type="text" name="last_name" id="elast_name" class="form-control" required />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Email</label>
							<input type="text" name="email" id="eemail" class="form-control" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Phone</label>
							<input type="text" name="phone" id="ephone" class="form-control" required />
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
				<h4 class="box-title">Customers</h4>
				<a href="#" data-toggle="modal" data-target="#AddModal"><img src="{{asset('assets/admin/images/svg-icon/flat-color-icons/SVG/plus.svg')}}" class="pull-right"  width='32' alt=""></a>
			</div>
			
			<div class="box-body p-0">
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="thead-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Phone</th>
								<th scope="col">Total Orders</th>
								<th scope="col">Created Date</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($customers as $item)
								<tr>
									<th scope="row">{{$item->id}}</th>
									<td>{{$item->name}} {{$item->last_name}}</td>
									<td>{{$item->email}}</td>
									<td>{{$item->phoneNo}}</td>
									<td>{{$item->orders->count()}}</td>
									<td>{{$item->created_at}}</td>
									<td><span class="badge badge-sm badge-primary"  data-toggle="modal" data-target="#EditModal" rel="{{$item}}">Edit</span></td>
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
        $('#EditModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var item = JSON.parse(button.attr('rel'));
            modal.find('#user_id').val(item.id);
            modal.find('#ename').val(item.name);
			modal.find('#elast_name').val(item.last_name);
			modal.find('#eemail').val(item.email);
			modal.find('#ephone').val(item.phoneNo);
        });
    </script>
@endpush