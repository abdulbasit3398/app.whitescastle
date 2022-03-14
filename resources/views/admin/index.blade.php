@extends('layouts.app')

@section('page_title','Dashboard')
@section('container_class','container-full')

@section('page-script')
<script type="text/javascript">
	$(document).ready(function() {
	    $('#example').DataTable({
	    	"ordering": false
	    });
	} );
</script>
@endsection

@section('content')
<style type="text/css">
	#toast-container > .toast {
	    max-width: 1200px;
	    width: 90%;
	}
</style>
<div class="row">
	{{--
	<div class="col-xl-4 col-lg-6 col-12">
		<div class="box" >
			<div class="box-body" style="background-image: url({{asset('assets/admin/images/basic-package.png')}});background-repeat: no-repeat; ">
				<div class="text-center">
					<img src="{{asset('assets/admin/images/scrapping.png')}}" class="rounded w-70 mx-auto" alt="">
					<h3 class="mb-0">Scraping Express</h3>
					<p class="mt-20 mb-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
			<div class="box-footer" style="text-align: center;">
				<a href="#" class="btn btn-primary">Click Here</a>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-lg-6 col-12">
		<div class="box">
			<div class="box-body" style="background-image: url({{asset('assets/admin/images/premium-package.png')}});background-repeat: no-repeat; ">
				<div class="text-center">
					<img src="{{asset('assets/admin/images/mailing.png')}}" class="rounded w-70 mx-auto" alt="" style="margin-bottom: 21px">
					<h3 class="mb-0">Mailing & Sms</h3>
					<p class="mt-20 mb-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
			@if(\Auth::user()->package == 'premium')
			<div class="box-footer" style="text-align: center;">
				
				<a href="#" class="btn btn-primary">Click Here</a>
				
			</div>
			@endif
		</div>
	</div>
	<div class="col-xl-4 col-lg-6 col-12">
		<div class="box">
			<div class="box-body" style="background-image: url({{asset('assets/admin/images/premium-package.png')}});background-repeat: no-repeat; ">
				<div class="text-center">
					<img src="{{asset('assets/admin/images/desktop.png')}}" class="rounded w-70 mx-auto" alt="">
					<h3 class="mb-0">Desktop Express</h3>
					<p class="mt-20 mb-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
			@if(\Auth::user()->package == 'premium')
			<div class="box-footer" style="text-align: center;">
				
				<a href="#" class="btn btn-primary">Click Here</a>
				
			</div>
			@endif
		</div>
	</div>
	--}}
	
	<div class="col-12">
		<div class="box">
			<div class="box-header with-border">
				<h4 class="box-title">Orders Overview</h4>
			</div>
			<div class="box-body p-0">
				<div class="table-responsive">
					<table class="table table-striped table-bordered" id="example">
						<thead class="thead-light">
							<tr>
								<th scope="col" style="text-align: center;">Date</th>
								<th scope="col">Order Id</th>
								<th scope="col">Customer</th>
								<th scope="col">Address</th>
								<th scope="col">Total Items</th>
								<th scope="col">Total Amount</th>
								<th scope="col">Branch</th>
								<th scope="col">Status</th>
								<!-- <th scope="col">Action</th> -->
							</tr>
						</thead>
						<tbody>
							@foreach($orders as $item)
								@if($item->customer)
								<tr>
									<td style="text-align: center;">
										{{$item->created_at->diffForHumans()}}
										<p>{{Date('D d M Y h:i a', strtotime($item->created_at))}}</p>
									</td>
									<td>{{$item->id}}</td>
									<td>{{$item->customer->name}} {{$item->customer->last_name}}</td>
									<td>{{$item->address}}</td>
									<td>{{$item->order_items->count()}}</td>
									<td>Rs.{{$item->total_amount-$item->discount_amount}}</td>
									<td>{{($item->branch) ? $item->branch->branch_name : '' }}</td>
									<td>
										@if($item->status == 'delivered')
										<label class="label label-success" data-toggle="modal" data-target="#StatusModal" rel="{{$item}}">{{ucwords($item->status)}}</label>
										@elseif($item->status == 'canceled')
										<label class="label label-danger" data-toggle="modal" data-target="#StatusModal" rel="{{$item}}">{{ucwords($item->status)}}</label>
										@else
										<label class="label label-warning" data-toggle="modal" data-target="#StatusModal" rel="{{$item}}">{{ucwords($item->status)}}</label>
										@endif
									</td>
									 
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