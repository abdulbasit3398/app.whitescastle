@extends('layouts.app')

@section('page_title','Edit Menu')
@section('container_class','container-full')

@section('content')
<style>
	.modal-footer{display: flex}
</style>

<div class="row">
 
	 
	<div class="col-12">
		<div class="box">
			<div class="box-header with-border">
				<h4 class="box-title">Edit Menu</h4>
			</div>
			
			<div class="box-body p-0">
        <form action="{{route('admin.menu.store')}}" enctype="multipart/form-data" method="POST">
          @csrf
          <input type="hidden" name="menu_id" id="menu_id" value="{{$menu->id}}">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-control">Name</label>
                  <input type="text" name="name" id="ename" class="form-control" value="{{$menu->name}}" required />
                </div>
              </div>
              <div class="col-md-6">
                
                <div class="form-group">
                  <label class="label-control">Category</label>
                  <select name="category_id" id="ecategory_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $item)
                      <option value="{{$item->id}}" <?=$menu->category_id==$item->id? 'selected="selected"': ''?>>{{$item->name}}</option>	
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
                  <input type="text" name="preparation_time" value="{{$menu->preparation_time}}" id="epreparation_time" class="form-control" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-control">Calories</label>
                  <input type="number" name="calories" value="{{$menu->calories}}" id="ecalories" min="0" class="form-control" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  
                  <input type="checkbox" name="is_discount" <?=$menu->discount==1? 'checked="checked"': ''?> id="basic_checkbox_1" value="1" class="filled-in">
                    <label for="basic_checkbox_1" class="mb-0 h-15">Is Discount</label> 
                  <input type="number" name="discount_percentage" value="{{$menu->discount_percentage}}" id="ediscount_percentage" class="form-control" placeholder="Discount Percentage" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="checkbox" name="is_vat" <?=$menu->is_vat==1? 'checked="checked"': ''?> id="basic_checkbox_2" value="1" class="filled-in">
                    <label for="basic_checkbox_2" class="mb-0 h-15">Is VAT</label> 
                  <input type="number" name="vat_percentage" value="{{$menu->vat_percentage}}" id="evat_percentage" class="form-control" placeholder="VAT Percentage" />
                </div>
              </div>
            </div>
            <input type="hidden" value="{{$menu->variation?$menu->variation:0}}" name="variations">
            <div class="row">
              <div class="col-md-12">
                <table class="table">
                  <thead>
                    <th>Size type</th>
                    <th>Price</th>
                    <th></th>
                  </thead>
                  <tbody class="input_fields_wrap">
                    @php
                      $size_types = @json_decode($menu->sizetype);  
                      $prices = @json_decode($menu->price);
                      $i = 0  
                    @endphp
                    @foreach ($size_types as $key => $value)
                    @php 
                    $price = $prices[$key];
                    $i = $i+1;
                    @endphp
                    <tr>
                      <td><input type="text" name="sizetype[]" value="{{$value}}" class="sizetype form-control" placeholder="Size Type" required /></td>
                      <td><input type="text" name="price[]" value="{{$price}}" class="sizetype form-control" placeholder="Price" required /></td>
                      <td>
                        @if ($i == 1)
                          <button class="btn btn-default btn-md add_field_button">Add</button>
                        @else
                          <button class="btn btn-default btn-md remove_field">Remove</button>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>
                
              </div>
              
            </div>
            <div class="form-group">
              <label class="label-control">Description</label>
              <textarea name="description" id="edescription" class="form-control" rows="5">{{$menu->description}}</textarea>
            </div>
            <div class="form-group">
              <input type="checkbox" name="is_out_of_stock" <?=$menu->is_out_of_stock==1? 'checked="checked"': ''?> id="eis_out_of_stock" value="1" class="filled-in">
                <label for="eis_out_of_stock" class="mb-0 h-15">Is out of stock?</label>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
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
			var item = $('.menu_item').html();
      console.log(item);
			var x = 1; //initlal text box count
			$(add_button).click(function(e){ //on add input button click
				e.preventDefault();
				if(x < max_fields){ //max input box allowed
					x++; //text box increment
          $(wrapper).append('<tr> <td><input type="text" name="sizetype[]" class="form-control" placeholder="Size Type" /></td> <td><input type="text" name="price[]" class="form-control" placeholder="Quantity" required /></td> <td><button class="btn btn-default btn-md remove_field">Remove</button></td> </tr>');
					// $(wrapper).append('<tr> <td>'+item+'</td><td><input type="text" name="sizetype[]" class="form-control" placeholder="Size Type" /></td> <td><input type="text" name="quantity[]" class="form-control" placeholder="Quantity" required /></td> <td><button class="btn btn-default btn-md remove_field">Remove</button></td> </tr>'); //add input box
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