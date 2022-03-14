@extends('layouts.app')

@section('page_title','How can we help?')
@section('container_class','container')

@section('content')

@if(\Session::has('success'))
<div class="alert alert-success alert-dismissible fade show">
	{!! \Session::get('success') !!}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

<div class="row">
	<div class="col-12">
		  <div class="box">
			<div class="box-header with-border">
			  <h6 class="box-title">You can find all of the questions and answers abour secure your account</h6>
			</div>
			<!-- /.box-header -->
			<form class="form" method="post" action="{{route('send_contact')}}" enctype="multipart/form-data">
				@csrf
				<div class="box-body">
					<h5 class="box-title text-info"><i class="ti-user mr-15"></i> Personal Info</h5>
					<hr class="my-15">
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label>First Name</label>
						  <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="form-group">
						  <label>Last Name</label>
						  <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
						</div>
					  </div>
					</div>
					<div class="row">
					  <div class="col-md-6">
						<div class="form-group">
						  <label >E-mail</label>
						  <input type="text" class="form-control" name="email" placeholder="E-mail" required>
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="form-group">
						  <label >Contact Number</label>
						  <input type="text" class="form-control" name="contact_number" placeholder="Phone" required>
						</div>
					  </div>
					</div>
					<h5 class="box-title text-info mb-0 mt-20"><i class="ti-file mr-15"></i> Give us the details </h5>
					<hr class="mb-15">								
					<div class="form-group">
					  <label>Select File</label>
					  <label class="file">
						<input type="file" name="file" id="file">
					  </label>
					</div>
					<div class="form-group">
					  <label>Message</label>
					  <textarea rows="5" class="form-control" name="message" placeholder="Write your message" required></textarea>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">
					  <i class="fa fa-paper-plane"></i> Submit
					</button>
				</div>  
			</form>
		  </div>
		  <!-- /.box -->			
	</div>				
</div>

@endsection

