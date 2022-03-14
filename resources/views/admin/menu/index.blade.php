@extends('layouts.app')



@section('page_title','Menu')

@section('container_class','container-full')



@section('content')

<style>

	.modal-footer{display: flex}

</style>

<div class="modal fade" id="MenuModal" tabindex="-1" role="dialog">

	<div class="modal-dialog modal-md" role="document">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title">New Menu</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			</div>

			<form action="{{route('admin.menu.store')}}" enctype="multipart/form-data" method="POST">

				@csrf

				<div class="modal-body">

					<div class="row">

						<div class="col-md-6">

							<div class="form-group">

								<label class="label-control">Name</label>

								<input type="text" name="name" class="form-control" required />

							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">

								<label class="label-control">Category</label>

								<select name="category_id" class="form-control" required>

									<option value="">Select Category</option>

									@foreach ($categories as $item)

									<option value="{{$item->id}}">{{$item->name}}</option>	

									@endforeach

								</select>

							</div>

						</div>

					</div>



					<div class="form-group">

						<label class="label-control">image</label>

						<input type="file" name="img_url" class="form-control" />

					</div>



					<div class="row">

						<div class="col-md-6">

							<div class="form-group">

								<label class="label-control">Preparation Time</label>

								<input type="text" name="preparation_time" class="form-control" required />

							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">

								<label class="label-control">Calories</label>

								<input type="number" name="calories" min="0" class="form-control" required />

							</div>

						</div>

					</div>

					<div class="row">

						<div class="col-md-6">

							<div class="form-group">



								<input type="checkbox" name="is_discount" id="basic_checkbox_1" value="1" class="filled-in">

								<label for="basic_checkbox_1" class="mb-0 h-15">Is Discount</label> 

								<input type="number" name="discount_percentage" class="form-control" placeholder="Discount Percentage" />

							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">

								<input type="checkbox" name="is_vat" id="basic_checkbox_2" value="1" class="filled-in">

								<label for="basic_checkbox_2" class="mb-0 h-15">Is VAT</label> 

								<input type="number" name="vat_percentage" class="form-control" placeholder="VAT Percentage" />

							</div>

						</div>

					</div>



					<div class="row">

						<div class="col-12">

							<div class="form-check1">

								<input class="form-check-input defaultCheck1" name="variations" type="checkbox" value="1" id="defaultCheck1">

								<label class="form-check-label" for="defaultCheck1">

									Variations

								</label>

							</div>

						</div>

					</div>

					<div class="row variations" style="display: none;">

						<div class="col-md-12">

							<table class="table">

								<thead>

									<th>Size type</th>

									<th>Price</th>

									<th></th>

								</thead>

								<tbody class="input_fields_wrap">

									<tr>

										<td><input type="text" name="sizetype[]" class="sizetype form-control" placeholder="Size Type" /></td>

										<td><input type="text" name="price[]" class="sizetype form-control" placeholder="Price" /></td>

										<td><button class="btn btn-default btn-md add_field_button">Add</button></td>

									</tr>

								</tbody>

							</table>

							

						</div>

						

					</div>

					<div class="row no-variations">

						<div class="col-md-12">

							<input type="text" name="static_price" class="form-control" placeholder="Price" />

						</div>

					</div>





					<div class="form-group">

						<label class="label-control">Description</label>

						<textarea name="description" id="description" class="form-control" rows="5"></textarea>

					</div>

					<div class="form-group">

						<input type="checkbox" name="is_out_of_stock" id="basic_checkbox_3" value="1" class="filled-in">

						<label for="basic_checkbox_3" class="mb-0 h-15">Is out of stock?</label>

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

				<h4 class="modal-title">Edit Menu</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			</div>

			<form action="{{route('admin.menu.store')}}" enctype="multipart/form-data" method="POST">

				@csrf

				<input type="hidden" name="menu_id" id="menu_id">

				<div class="modal-body">

					<div class="row">

						<div class="col-md-6">

							<div class="form-group">

								<label class="label-control">Name</label>

								<input type="text" name="name" id="ename" class="form-control" required />

							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">

								<label class="label-control">Category</label>

								<select name="category_id" id="ecategory_id" class="form-control" required>

									<option value="">Select Category</option>

									@foreach ($categories as $item)

									<option value="{{$item->id}}">{{$item->name}}</option>	

									@endforeach

								</select>

							</div>

						</div>

					</div>



					<div class="form-group">

						<label class="label-control">image</label>

						<input type="file" name="img_url" class="form-control" />

					</div>



					<div class="row">

						<div class="col-md-6">

							<div class="form-group">

								<label class="label-control">Preparation Time</label>

								<input type="text" name="preparation_time" id="epreparation_time" class="form-control" required />

							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">

								<label class="label-control">Calories</label>

								<input type="number" name="calories" id="ecalories" min="0" class="form-control" required />

							</div>

						</div>

					</div>

					<div class="row">

						<div class="col-md-6">

							<div class="form-group">



								<input type="checkbox" name="is_discount" id="basic_checkbox_1" value="1" class="filled-in">

								<label for="basic_checkbox_1" class="mb-0 h-15">Is Discount</label> 

								<input type="number" name="discount_percentage" id="ediscount_percentage" class="form-control" placeholder="Discount Percentage" />

							</div>

						</div>

						<div class="col-md-6">

							<div class="form-group">

								<input type="checkbox" name="is_vat" id="basic_checkbox_2" value="1" class="filled-in">

								<label for="basic_checkbox_2" class="mb-0 h-15">Is VAT</label> 

								<input type="number" name="vat_percentage" id="evat_percentage" class="form-control" placeholder="VAT Percentage" />

							</div>

						</div>

					</div>

					<div class="row">

						<div class="col-12">

							<div class="form-check1">

								<input class="form-check-input defaultCheck1" name="variations" type="checkbox" value="1" id="defaultCheck1">

								<label class="form-check-label" for="defaultCheck1">

									Variations

								</label>

							</div>

						</div>

					</div>

					<div class="row variations" style="display: none;">

						<div class="col-md-12">

							<table class="table">

								<thead>

									<th>Size type</th>

									<th>Price</th>

									<th></th>

								</thead>

								<tbody class="input_fields_wrap">

									<tr>

										<td><input type="text" name="sizetype[]" class="sizetype form-control" placeholder="Size Type" /></td>

										<td><input type="text" name="price[]" class="sizetype form-control" placeholder="Price" /></td>

										<td><button class="btn btn-default btn-md add_field_button">Add</button></td>

									</tr>

								</tbody>

							</table>



						</div>



					</div>

					<div class="row no-variations">

						<div class="col-md-12">

							<input type="text" name="static_price" class="form-control" placeholder="Price" />

						</div>

					</div>

					<div class="form-group">

						<label class="label-control">Description</label>

						<textarea name="description" id="edescription" class="form-control" rows="5"></textarea>

					</div>

					<div class="form-group">

						<input type="checkbox" name="is_out_of_stock" id="eis_out_of_stock" value="1" class="filled-in">

						<label for="eis_out_of_stock" class="mb-0 h-15">Is out of stock?</label>

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

				<h4 class="box-title">Menu</h4>

				<a href="#" data-toggle="modal" data-target="#MenuModal"><img src="{{asset('assets/admin/images/svg-icon/flat-color-icons/SVG/plus.svg')}}" class="pull-right"  width='32' alt=""></a>

			</div>

			

			<div class="box-body p-0">

				<div class="table-responsive">

					<table class="table mb-0">

						<thead class="thead-light">

							<tr>

								<th scope="col">#</th>

								<th scope="col">Image</th>

								<th scope="col">Name</th>

								<th scope="col">Size</th>

								<th scope="col">Price</th>

								<th scope="col">Prep Time</th>

								<th scope="col">Discount</th>

								<th scope="col">VAT</th>

								<th scope="col">Created Date</th>

								<th scope="col">Action</th>

							</tr>

						</thead>

						<tbody>

							@foreach ($menues as $menu)

							<tr>

								<th scope="row">{{$menu->id}}</th>

								<td><img src="{{$menu->image_url}}" alt="product iamge" width="100"></td>

								<td>{{$menu->name}}</td>

								@if($menu->variation == 1)

								<td>



									@php

									$size_types = @json_decode($menu->sizetype);

									@endphp



									@foreach ($size_types as $key => $value)

									{{$value}} <br>

									@endforeach

								</td>

								<td>

									@php

									$prices = @json_decode($menu->price);

									@endphp



									@foreach ($prices as $key => $value)

									Rs. {{$value}} <br>

									@endforeach

								</td>

								@else

								<td></td>

								<td>Rs. {{$menu->static_price}}</td>

								@endif

								<td>{{$menu->preparation_time}}</td>

								<td>{{$menu->discount_percentage}}%</td>

								<td>{{$menu->vat_percentage}}%</td>

								<td>{{$menu->created_at}}</td>

								<td>
									<a href="{{route('admin.editmenu', ['id' => $menu->id])}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> 
									<!-- <span class="badge badge-sm badge-success">View</span></td> -->
									<!-- <a href="{{route('admin.menu.delete', ['id' => $menu->id])}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>  -->
									<a href="#" class="btn btn-danger" onclick="
		                              if(confirm('you want to delete?'))
		                              {
		                                event.preventDefault();
		                                document.getElementById('delete-form-{{$menu->id}}').submit();
		                              }
		                              else
		                              {
		                                event.preventDefault();
		                              }

		                            ">
		                              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
		                            </a>

									<form id="delete-form-{{$menu->id}}" method="post" style="display: none;" action="{{route('admin.menu.delete')}}">
										<input type="hidden" name="id" value="{{$menu->id}}">
			                          {{csrf_field()}}
			                          {{method_field('DELETE')}}
			                        </form>

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

			$('.defaultCheck1').change(function(){

				if(this.checked)

				{

					$('.no-variations').hide();

					$('.variations').show();

				}

				else{

					$('.no-variations').show();

					$('.variations').hide();

				}



			});

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

	$('#EditModal').on('show.bs.modal', function (event) {

		var button = $(event.relatedTarget);

		var modal = $(this);

		var item = JSON.parse(button.attr('rel'));

		modal.find('#menu_id').val(item.id);

		modal.find('#ename').val(item.name);

		modal.find('#elast_name').val(item.last_name);

		modal.find('#eemail').val(item.email);

		modal.find('#ephone').val(item.phoneNo);

		modal.find('#type option[value="'+item.type+'"]').prop('selected', true);

	});



</script>

@endpush