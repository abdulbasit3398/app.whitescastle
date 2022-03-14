@extends('layouts.app')

@section('page_title','My Account')
@section('container_class','container')

@section('content')

<div class="row">
	<div class="col-12">
		<div class="d-flex justify-content-start mb-30">
			<a href="javascript:void(0)" class="mr-10 btn btn-success">Personal</a>
		</div>
	</div>
	<div class="col-12">
		<div class="box">
			<div class="box-body">
				<h4 class="box-title">Personal Details</h4>
				<div class="media-list bb-1 bb-dashed border-light media-list-divided media-list-hover">
					<div class="media align-items-center" data-toggle="modal" data-target="#profile-edit">
					  <div class="media-body">
						  <div class="d-flex"><p class="mb-0 w-200">Full Name</p><p class="mb-0">Johen Doe</p></div>
					  </div>
					  <div class="media-right gap-items">
						<a class="media-action lead" href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-arrow-circle-right"></i></a>
					  </div>
					</div>
				</div>
				<div class="media-list bb-1 bb-dashed border-light media-list-divided media-list-hover">
					<div class="media align-items-center" data-toggle="modal" data-target="#profile-edit">
					  <div class="media-body">
						  <div class="d-flex"><p class="mb-0 w-200">Eamil</p><p class="mb-0">johendoe@gmail.com</p></div>
					  </div>
					  <div class="media-right gap-items">
						<a class="media-action lead" href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-arrow-circle-right"></i></a>
					  </div>
					</div>
				</div>
				<div class="media-list bb-1 bb-dashed border-light media-list-divided media-list-hover">
					<div class="media align-items-center" data-toggle="modal" data-target="#profile-edit">
					  <div class="media-body">
						  <div class="d-flex"><p class="mb-0 w-200">Phone Number</p><p class="mb-0">+1 123 456 7890</p></div>
					  </div>
					  <div class="media-right gap-items">
						<a class="media-action lead" href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-arrow-circle-right"></i></a>
					  </div>
					</div>
				</div>
				<div class="media-list bb-1 bb-dashed border-light media-list-divided media-list-hover">
					<div class="media align-items-center" data-toggle="modal" data-target="#profile-edit">
					  <div class="media-body">
						  <div class="d-flex"><p class="mb-0 w-200">Date Of Birth</p><p class="mb-0">02 April 1965</p></div>
					  </div>
					  <div class="media-right gap-items">
						<a class="media-action lead" href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-arrow-circle-right"></i></a>
					  </div>
					</div>
				</div>
				<div class="media-list bb-1 bb-dashed border-light media-list-divided media-list-hover">
					<div class="media align-items-center" data-toggle="modal" data-target="#profile-edit">
					  <div class="media-body">
						  <div class="d-flex"><p class="mb-0 w-200">Address</p><p class="mb-0">3927  Libby Street, Hawthorne, California, USA</p></div>
					  </div>
					  <div class="media-right gap-items">
						<a class="media-action lead" href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-arrow-circle-right"></i></a>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="box">
			<div class="box-body">
				<h4 class="box-title">Preferences</h4>
				<div class="media-list bb-1 bb-dashed border-light">
					<div class="media align-items-center">
					  <div class="media-body">
						  <div class="d-md-flex justify-content-start">
							  <p class="mb-0 w-200">Language</p>
							  <p class="mb-0 w-300">English (United State)</p>
							  <a href="#" class="text-info">Change Language</a>										  
						  </div>
					  </div>
					</div>
				</div>
				<div class="media-list bb-1 bb-dashed border-light">
					<div class="media align-items-center">
					  <div class="media-body">
						  <div class="d-md-flex justify-content-start">
							  <p class="mb-0 w-200">Date Format</p>
							  <p class="mb-0 w-300">DD/MM/YYYY</p>
							  <a href="#" class="text-info">Change</a>										  
						  </div>
					  </div>
					</div>
				</div>
				<div class="media-list bb-1 bb-dashed border-light">
					<div class="media align-items-center">
					  <div class="media-body">
						  <div class="d-md-flex justify-content-start">
							  <p class="mb-0 w-200">Timezone</p>
							  <p class="mb-0 w-300">Central Daylight Time Chicago (GMT-5)</p>
							  <a href="#" class="text-info">Change</a>										  
						  </div>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
