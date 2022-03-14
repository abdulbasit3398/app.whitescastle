<!DOCTYPE html>
<html lang="en">

	@include('includes.head')

<body class="hold-transition light-skin sidebar-mini theme-primary">
	
	<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Order Notification</h5>
	        <button type="button" class="close stop-sound" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p>
	        	<h3>New Order Placed.</h3>
	        	<a class="btn btn-primary" href="{{route('admin.orders')}}">Check now</a>
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary stop-sound" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
 
	<div class="wrapper">

		@include('includes.header')

		<!-- Left side column. contains the logo and sidebar -->
		@include('includes.sidebar')

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<div class="@yield('container_class')">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="mr-auto">
							<h3 class="page-title">@yield('page_title')</h3>
						</div>				
					</div>
				</div>
				<!-- Main content -->
				<section class="content">
					@section('content')
						@show
				</section>
				<!-- /.content -->
			</div>

		</div>
		<!-- /.content-wrapper -->
		@include('includes.footer')

		<!-- Control Sidebar -->
		@include('includes.control_sidebar')
		<!-- /.control-sidebar -->

		<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>

	</div>
	<!-- ./wrapper -->	 
	
	<!-- Vendor JS -->
	@include('includes.scripts')
	
	@stack('scripts')
</body>
</html>
