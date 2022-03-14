@extends('layouts.app')

@section('page_title','Pricing')
@section('container_class','container')

@section('content')

<div id="profile-edit" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Card Payment</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<form role="form" action="{{ route('payment') }}" method="post" class="require-validation" data-cc-on-file="false"
					data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
					@csrf
					<input type="hidden" name="package" id="package">
					<div class='form-row row'>
						<div class='col-xs-12 form-group required'>
							<label class='control-label'>Name on Card</label> <input
							class='form-control' name="name_on_card" type='text'>
						</div>
						<div class='col-xs-12 form-group required'>
							<label class='control-label'>Card Number</label> <input
							autocomplete='off' class='form-control card-number' name="card_number" size='20'
							type='text'>
						</div>
						<div class='col-xs-12 col-md-4 form-group cvc required'>
							<label class='control-label'>CVC</label> <input autocomplete='off'
							class='form-control card-cvc' name="cvc" placeholder='ex. 311' size='4'
							type='text'>
						</div>
					</div>

				 

					<div class='form-row row'>
						
						<div class='col-xs-12 col-md-4 form-group expiration required'>
							<label class='control-label'>Expiration Month</label> <input
							class='form-control card-expiry-month' name="experiation_month" placeholder='MM' size='2'
							type='text'>
						</div>
						<div class='col-xs-12 col-md-4 form-group expiration required'>
							<label class='control-label'>Expiration Year</label> <input
							class='form-control card-expiry-year' name="expiration_year" placeholder='YYYY' size='4'
							type='text'>
						</div>

					</div>

					<div class='form-row row'>
						<div class='col-md-12 error form-group hide'>
							<div class='alert-danger alert'>Please correct the errors and try
							again.</div>
						</div>
					</div>

					<div class="form-row row">
						<div class='col-xs-12 col-md-12 form-group ' >
							<button class="btn btn-primary my-30" type="submit">Pay Now</button>
						</div>
					</div>

					</form>
			</div>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@if(\Session::has('success'))
<div class="alert alert-success alert-dismissible fade show">
	{!! \Session::get('success') !!}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

<div class="row">
	<!-- <div class="col-lg-4">
		<div class="box pull-up">
			<div class="box-body text-center">
				<h4 class="price text-info">
					<sup>$</sup>5<sup>.99</sup>
					<span>per month</span>
				</h4>
				<h5 class="text-uppercase text-primary">Starter</h5>

				<hr>
				<p><strong>1 GB</strong> Storage</p>
				<p><strong>24x7</strong> Support</p>
				<p><strong>15</strong> Project</p>
				<p><strong>3</strong> User</p>
				<a class="btn btn-primary my-30 package-modal" data-toggle="modal" data-target="#profile-edit" data-package="basic">Select plan</a>
			</div>
		</div>
	</div> -->
	<div class="col-lg-4">
		<div class="box pull-up">
			<div class="box-body text-center">
				<h4 class="price text-info">
					<sup>€</sup>50<sup>.00</sup>
					<span>per month</span>
				</h4>
				<h5 class="text-uppercase text-primary">Premium</h5>

				<hr>
				<p><strong>5 GB</strong> Storage</p>
				<p><strong>24x7</strong> Support</p>
				<p><strong>50</strong> Project</p>
				<p><strong>10</strong> User</p>

				<a class="btn btn-primary my-30 package-modal" data-toggle="modal" data-target="#profile-edit" data-package="premium">Select plan</a>
			</div>
		</div>
	</div>

</div>

@endsection

@section('page-script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
	$(function() {
		$('.package-modal').click(function(){
			$('#package').val('');
			var data_id = '';

	    if (typeof $(this).data('package') !== 'undefined') {

	      package = $(this).data('package');
	      $('#package').val(package);
	    }
		});
		

		var $form         = $(".require-validation");
		$('form.require-validation').bind('submit', function(e) {
			var $form         = $(".require-validation"),
			inputSelector = ['input[type=email]', 'input[type=password]',
			'input[type=text]', 'input[type=file]',
			'textarea'].join(', '),
			$inputs       = $form.find('.required').find(inputSelector),
			$errorMessage = $form.find('div.error'),
			valid         = true;
			$errorMessage.addClass('hide');

			$('.has-error').removeClass('has-error');
			$inputs.each(function(i, el) {
				var $input = $(el);
				if ($input.val() === '') {
					$input.parent().addClass('has-error');
					$errorMessage.removeClass('hide');
					e.preventDefault();
				}
			});

			if (!$form.data('cc-on-file')) {
				e.preventDefault();
				Stripe.setPublishableKey($form.data('stripe-publishable-key'));
				Stripe.createToken({
					number: $('.card-number').val(),
					cvc: $('.card-cvc').val(),
					exp_month: $('.card-expiry-month').val(),
					exp_year: $('.card-expiry-year').val()
				}, stripeResponseHandler);
			}

		});

		function stripeResponseHandler(status, response) {
			if (response.error) {
				$('.error')
				.removeClass('hide')
				.find('.alert')
				.text(response.error.message);
			} else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
          }
        }

      });
    </script>

    @endsection