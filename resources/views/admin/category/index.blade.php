@extends('layouts.app')

@section('page_title','Categories')
@section('container_class','container-full')

@section('content')
<style>
	.modal-footer{display: flex}
</style>
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  
		  <h4 class="modal-title">New Category</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.categories.store')}}" enctype="multipart/form-data" method="POST">
			@csrf
			<div class="modal-body">
				<div class="form-group">
					<label class="label-control">Name</label>
					<input type="text" name="name" class="form-control" required />
				</div>
				<div class="form-group">
					<label class="label-control">Currency Symbol</label>
					<input type="text" name="currency_symbol" class="form-control" required />
				</div>
				<div class="form-group">
					<label class="label-control">image</label>
					<input type="file" name="img_url" class="form-control" />
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

<div class="modal fade" id="EditcategoryModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  
		  <h4 class="modal-title">Edit Category</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<form action="{{route('admin.categories.store')}}" enctype="multipart/form-data" method="POST">
			@csrf
            <input type="hidden" name="category_id" id="category_id" value="">
			<div class="modal-body">
				<div class="form-group">
					<label class="label-control">Name</label>
					<input type="text" name="name" id="name" class="form-control" required />
				</div>
				<div class="form-group">
					<label class="label-control">Currency Symbol</label>
					<input type="text" name="currency_symbol" id="currency_symbol" class="form-control" required />
				</div>
				<div class="form-group">
					<label class="label-control">image</label>
					<input type="file" name="img_url" class="form-control" />
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
				<h4 class="box-title">Categories</h4>
				<a href="#" data-toggle="modal" data-target="#categoryModal"><img src="{{asset('assets/admin/images/svg-icon/flat-color-icons/SVG/plus.svg')}}" class="pull-right"  width='32' alt=""></a>
			</div>
			
			<div class="box-body p-0">
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="thead-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Image</th>
								<th scope="col">Name</th>
								<th scope="col">Sub Categories</th>
								<th scope="col">Created Date</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($categories as $category)
								<tr>
									<th scope="row">{{$category->id}}</th>
									<td><img src="{{$category->image_url}}" alt="product iamge" width="100"></td>
									<td>{{$category->name}}</td>
									<td>{{$category->sub_categories->count()}}</td>
									<td>{{$category->created_at}}</td>
									<td><span class="badge badge-sm badge-primary" data-toggle="modal" data-target="#EditcategoryModal" rel="{{$category}}">Edit</span> <a href="{{route('admin.subcategories', ['id' => $category->id])}}" class="badge badge-sm badge-success">View</span></td>
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
        $('#EditcategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var subcat = JSON.parse(button.attr('rel'));
            modal.find('#category_id').val(subcat.id);
            modal.find('#name').val(subcat.name);
			modal.find('#currency_symbol').val(subcat.currency_symbol);
        });
    </script>
@endpush