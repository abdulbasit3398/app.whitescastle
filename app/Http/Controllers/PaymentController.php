<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Session;
use Stripe;
use App\Model\UserPayment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
  public function paymentProcess(Request $request)
  {
  	$amount = 0;
  	if($request->package == 'premium')
  		$amount = 5000;
  	
  	$user_payment = new UserPayment;
  	$user_payment->user_id = Auth::id();
  	$user_payment->name_on_card = $request->name_on_card;
  	$user_payment->card_number = $request->card_number;
  	$user_payment->cvc = $request->cvc;
  	$user_payment->experiation_month = $request->experiation_month;
  	$user_payment->expiration_year = $request->expiration_year;
  	$user_payment->package = $request->package;
  	$user_payment->amount = $amount;
  	$user_payment->save();

    $user = User::find(Auth::id());
    $user->package = $request->package;
    $user->save();

  	Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    Stripe\Charge::create ([
            "amount" => $amount,
            "currency" => "eur",
            "source" => $request->stripeToken,
            "description" => "Payment for package." 
    ]);

    Session::flash('success', 'Payment successful!');
      
    return back();
  }
}
