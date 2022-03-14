@extends('layouts.app')

@section('page_title','New Deals')
@section('container_class','container-full')

@section('content')
<style>
	.modal-footer{display: flex}
</style>

<div class="row">
 
	 
	<div class="col-12">
		<div class="box">
			<div class="box-header with-border">
				<h4 class="box-title">New Deals</h4>
			</div>
			
			<div class="box-body p-0">
				<form action="{{route('admin.deals.store')}}" enctype="multipart/form-data" method="POST">
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
                <label class="label-control">image</label>
                <input type="file" name="img_url" class="form-control" />
              </div>
            </div>
          </div>
            
            
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-control">Price</label>
                  <input type="number" name="deal_price" min="0" class="form-control" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="label-control">Status</label>
                  <select name="status" id="status" class="form-control" required>
                    <option value="1">Active</option>
                    <option value="0">Expired</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <table class="table">
                  <thead>
                    <th>Menu Item</th>
                    <th>Size Type</th>
                    <th>Quantity</th>
                    <th></th>
                  </thead>
                  <tbody class="input_fields_wrap">
                    <tr>
                      <td class="menu_item">
                        <select name="menuitem[]" class="form-control menuitem" required>
                          <option value="">Select Menu</option>
                          @foreach ($menues as $item)
                            <option value="{{$item->id}}" rel="{{$item->sizetype}}">{{$item->name}}</option>	
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <select name="sizetype[]" class="form-control sizetype">
                          <option value="">Select Size</option>
                        </select>
                      </td>
                      <td><input type="text" name="quantity[]" class="form-control" placeholder="Quantity" required /></td>
                      <td><button class="btn btn-default btn-md add_field_button">Add</button></td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
              
            </div>
          </div>
          <div class="modal-footer">
            
            <button type="submit" class="btn btn-primary">Save</button>
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
					$(wrapper).append('<tr> <td>'+item+'</td><td><select name="sizetype[]" class="form-control sizetype"><option value="">Select Size</option></select></td> <td><input type="text" name="quantity[]" class="form-control" placeholder="Quantity" required /></td> <td><button class="btn btn-default btn-md remove_field">Remove</button></td> </tr>'); //add input box
				}
			});
			
			$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
				e.preventDefault(); $(this).parents('tr').remove(); x--;
			})
		});

    $(document).on('change', '.menuitem', function(event){
      var sizes = JSON.parse($(this).find(":selected").attr('rel'));
      var options = '<option value="">Select Size</option>';
      if($.trim(sizes) != '')
      {
        $.each(sizes, function(key,value) {
          options += '<option value="'+value+'">'+value+'</option>';
        });
      }
      $(this).closest('tr').find('.sizetype').html(options);
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