@extends('layouts.app')

@section('page_title','Banner')
@section('container_class','container-full')

@section('content')
<style>
	.modal-footer{display: flex}
</style>
<div class="modal fade" id="MenuModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">New Banner</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.banner.store')}}" autocomplete="false" enctype="multipart/form-data" method="POST">
			@csrf
			<div class="modal-body">
				
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Banner Name</label>
							<input type="text" name="banner_name" class="form-control" required />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Banner image</label>
							<input type="file" name="banner_image" class="form-control" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label-control">Banner url</label>
							<input type="text" name="banner_url" class="form-control" required />
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
				<h4 class="box-title">Banner</h4>
				<a href="#" data-toggle="modal" data-target="#MenuModal"><img src="{{asset('assets/admin/images/svg-icon/flat-color-icons/SVG/plus.svg')}}" class="pull-right"  width='32' alt=""></a>
			</div>
			
			<div class="box-body p-0">
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="thead-light">
							<tr>
								<th scope="col">Banner Name</th>
								<th scope="col">Banner image</th>
								<th scope="col">Banner URL</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							 @foreach($banners as $banner)
							 	<tr>
							 		<td>{{$banner->banner_name}}</td>
							 		<td><img src="{{$banner->banner_image}}" width="100"> </td>
							 		<td>{{$banner->banner_url}}</td>
							 		<td>
							 			<a href="{{route('admin.banner.delete',$banner->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
    });
  </script>
@endpush