<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use App\User;
use App\Model\Branches;
use App\Model\Category;
use App\SubCategories;
use App\MenuItems;
use App\Model\Discounts;
use App\Model\Deals;
use App\Model\Orders;
use App\Model\Banner;
use App\Model\DealItems;
use App\Model\PhoneNumberOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
	public function __construct()
	{
		// $this->middleware('apikey.verify');
	}

	public function categories()
	{
        // dd(Category::find(2)->menu_item);
		$categories = Category::get();
		$cat = array();
		foreach ($categories as $category) {
			// $category->sub_categories;
			$category->products;
			$cat[] = $category;
		}
		return response()->json([
			'status' => true,
			'message' => 'fetch comments',
			'menu' => $cat
		]);
	}

	public function get_alldeals()
	{
		$banners = Banner::all();
		$deals = Deals::where('status', 1)->get();
		$deal_arr = array();
		foreach ($deals as $deal) {
			// $category->sub_categories;
			$deal->deal_items;
			$deal_arr[] = $deal;
		}
		return response()->json([
			'status' => true,
			'message' => 'fetch comments',
			'deals' => $deal_arr,
			'banners' => $banners,
		]);
	}

	public function checkCoupon(Request $request)
	{
		$this->validate($request,[
			'coupon_code' => 'string',
			// 'user_id' => 'string',
		]);

		$user_id = auth()->guard('api')->user()->id;
		$discount = Discounts::where([['coupon_code',$request->coupon_code],['status','!=','0']])->first();
		if($discount)
		{
			if($discount->usage_limit == 0 || $discount->usage_limit > $discount->DiscountOrders->count())
			{
				// return response()->json([
				// 	'status' => true,
				// 	'message' => $discount
				// ]);
				$user_count = Orders::where([['user_id',$user_id],['discount_id',$discount->id]])->count();
				if($user_count < $discount->per_user_limit)
				{
					return response()->json([
						'status' => true,
						'message' => $discount
					]);
				}else{
					return response()->json([
						'status' => false,
						'message' => 'Coupon expired.'
					]);	
				}
			}else{
				return response()->json([
					'status' => false,
					'message' => 'Coupon expired.'
				]);	
			}
		}else
		{
			return response()->json([
				'status' => false,
				'message' => 'Coupon not exist.'
			]);
		}

	}

	public function CalculatePrice(Request $request)
	{
		// if($coupon_id != 0 && !in_array("1",$data->is_offer))
		// 	return response()->json([
		// 		'status' => false,
		// 		'message' => 'Coupon can not apply on deals.'
		// 	]);

		$rawPostData = file_get_contents("php://input");
		$data = @json_decode($rawPostData);
		$product_ids = $data->product_ids;
		$sizeType = $data->product_sizes;
		$product_quantities = $data->product_quantities;
		$is_offer = $data->is_offer;
		$coupon_id = $data->coupon_id;
		$product_prices = array();
		$total_amount = $discount_amount = $item_price = 0;
		
		foreach ($product_ids as $key => $value) 
		{
			$quantity = $product_quantities[$key];

			$offer = $is_offer[$key];
			if($offer == 1)
			{
				$deal = Deals::find($value);
				$item_price = $deal->deal_price;
			}
			else
			{
				$size_type = $sizeType[$key];
				$item = MenuItems::find($value);
				if($item)
				{
					$price = $item->price?$item->price:0;
					$size = $item->sizetype?$item->sizetype:0;
					$price_arr = @json_decode($price);
					$size_arr = @json_decode($size);
					if(!empty($size_type))
					{
						$size_key = array_search($size_type,$size_arr);
						$item_price = (int)$price_arr[$size_key];
					}else{
						$item_price = (int)$price_arr[0];
					}
					
					
				}
			}
			$product_prices[] = $item_price*$quantity;
		}
		$total_amount = array_sum($product_prices);
		if($coupon_id != 0 && !in_array("1",$data->is_offer))
		{
			$discount = Discounts::find($coupon_id);
			if($discount)
			{
				if($discount->coupon_type == 'fixed')
				{
					$discount_amount = $discount->coupon_value;
				}else{
					$discount_amount = ($total_amount/100)*$discount->coupon_value;
				}
			}
		}
		$net_amount = $total_amount-$discount_amount;
		// Storage::put('attempt3.txt', $data->product_ids);
		return response()->json([
			'status' => true,
			'message' => array(
				'product_ids' => $product_ids, 
				'product_quantities' => $product_quantities, 
				'product_prices' => $product_prices,
				'coupon_id' => $coupon_id,
				'total_amount' => $total_amount,
				'discount_amount' => $discount_amount,
				'net_amount' => $net_amount

			)
		]);
	}

	public function test()
	{
		$data = array(
			'status' => true,
			'message' => 'Hello World',
		);
		return $data;
	}

	public function AllBranches()
	{
		$branches = Branches::where('active',1)->get();

		$data = array(
			'status' => true,
			'message' => $branches,
		);
		return $data;
	}
	public function FunctionName()
	{
		// $target_url = "https://connect.jazzcmt.com/upload_txt.html";
// $fname = 'test.txt';
// $cfile = new CURLFile(realpath($fname));
// $post = array (
//  'Username' => '03011156684',
//  'Password' => 'Allah786786123',
//  'From' => 'WHI8 CASTLE',
//  'Message' => 'Test Message'
//  // 'file_contents' => $cfile
//  );

// $ch = curl_init(); curl_setopt($ch,
// CURLOPT_URL, $target_url); curl_setopt($ch,
// CURLOPT_POST, 1); curl_setopt($ch,
// CURLOPT_HEADER, 0); curl_setopt($ch,
// CURLOPT_RETURNTRANSFER, 1); curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0
// (compatible;)"); curl_setopt($ch,
// CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
// curl_setopt($ch,
// CURLOPT_FRESH_CONNECT, 1);
// curl_setopt($ch, CURLOPT_FORBID_REUSE, 1); curl_setopt($ch,
// CURLOPT_TIMEOUT,
// 100); curl_setopt($ch, CURLOPT_POSTFIELDS,
// $post);
// $result = curl_exec ($ch); if ($result === FALSE) {
// echo "Error sending" . $fname . " " . curl_error($ch);
// curl_close ($ch);
// }else{
//  curl_close ($ch);
// echo "Result: " . $result;
// } 
// die();

      $msg = 'Your verification code is 1234';
      $receiverNumber = '03247763398';
      $username = $this->admin_setting('JAZZ_USERNAME');
				$password = $this->admin_setting('JAZZ_PASSWORD');
				$mask = $this->admin_setting('JAZZ_MASK');
				


				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://connect.jazzcmt.com/sendsms_url.html?Username=03011156684&Password=Allah786786123&From=WHI8%20CASTLE&To=+923247763398&Message=Your%20verification%20code%20is%206627',


				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'POST',
				));

				$response = curl_exec($curl);

				curl_close($curl);
				echo $response;
				dd($response);


				$cURLConnection = curl_init();
				$link = 'https://connect.jazzcmt.com/sendsms_url.html?Username='.$username.'&Password='.$password.'&From='.$mask.'&To='.$receiverNumber.'&Message='.$msg;
				$new_link = str_replace(" ","%20",$link);
				curl_setopt($cURLConnection, CURLOPT_URL, $new_link);
				curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

				$phoneList = curl_exec($cURLConnection);
				curl_close($cURLConnection);

				$jsonArrayResponse = json_decode($phoneList);
			if($phoneList == "Message Sent Successfully!")
			dd('yes');
       
	}
	public function sendOTP(Request $request)
	{
		$user = User::where('phoneNo',$request['phoneNo'])->first();
		if($user)
			return response()->json([
				'status' => false,
				'message' => 'Mobile Number already exist. Please select another.'
			]);

		if(env("TWILIO_ENV") == "test")
			$OTP = 1234;
		else
			$OTP = rand ( 1000 , 9999 );

		$receiverNumber = $request['phoneNo'];
		$message = 'Please do not share your OTP with anyone. Your OTP is '.$OTP;
		$message = strval($message);
		$prev_PhoneNumberOtp = PhoneNumberOtp::where('phoneNo',$receiverNumber)->first();
		if($prev_PhoneNumberOtp)
		{
			$prev_PhoneNumberOtp->otp = $OTP;
			$prev_PhoneNumberOtp->save();
		}
		else
		{
			$PhoneNumberOtp = new PhoneNumberOtp;
			$PhoneNumberOtp->phoneNo = $receiverNumber;
			$PhoneNumberOtp->otp = $OTP;
			$PhoneNumberOtp->save();
		}

		if(env("TWILIO_ENV") == "test")
		{
			return response()->json([
				'status' => true,
				'message' => 'OTP Sent.'
			]);
		}
		else
		{ 
			
      $username = $this->admin_setting('JAZZ_USERNAME');
			$password = $this->admin_setting('JAZZ_PASSWORD');
			$mask = $this->admin_setting('JAZZ_MASK');
			
			$cURLConnection = curl_init();

			$curl = curl_init();
			$link = 'https://connect.jazzcmt.com/sendsms_url.html?Username='.$username.'&Password='.$password.'&From='.$mask.'&To='.$receiverNumber.'&Message='.$message;
			$new_link = str_replace(" ","%20",$link);
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $new_link,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			));

			$response = curl_exec($curl);

			curl_close($curl);
			// echo $response;
			// dump($new_link);
			// dd($response);


			// $link = 'https://connect.jazzcmt.com/sendsms_url.html?Username='.$username.'&Password='.$password.'&From='.$mask.'&To='.$receiverNumber.'&Message='.$message;
			// $new_link = str_replace(" ","%20",$link);
			// curl_setopt($cURLConnection, CURLOPT_URL, $new_link);
			// curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

			// $phoneList = curl_exec($cURLConnection);

			// curl_close($cURLConnection);

			// $jsonArrayResponse = json_decode($phoneList);
			if($response == "Message Sent Successfully!")
				return response()->json([
					'status' => true,
					'message' => 'OTP Sent.'
				]);
			else
				return response()->json([
					'status' => false,
					'message' => 'There is some error sending OTP.'
				]);

			// Twilio CODE TO SEND OTP
			// try {

			// 	$account_sid = env('TWILIO_SID');
			// 	$auth_token = env('TWILIO_TOKEN');
			// 	$twilio_number = env('TWILIO_FROM');

			// 	$client = new Client($account_sid, $auth_token);
			// 	$client->messages->create($receiverNumber, [
			// 		'from' => 'Whitecastle', 
			// 		'body' => $message
			// 	]);

			// 	return response()->json([
			// 		'status' => true,
			// 		'message' => 'OTP Sent.'
			// 	]);
	  //     // dd('Your verification code is '.);

			// } catch (\Exception $e) {

			// 	return response()->json([
			// 		'status' => false,
			// 		'message' => $e->getMessage()
			// 	]);
			// }
		}
		
	}
	public function verifyOTP(Request $request)
	{
		$phoneNo = $request['phoneNo'];
		$otp = $request['otp'];

		$PhoneNumberOtp = PhoneNumberOtp::where('phoneNo',$phoneNo)->first();

		if($PhoneNumberOtp->otp == $otp)
			return response()->json([
				'status' => true,
				'message' => 'Number Verfied.'
			]);
		else
			return response()->json([
				'status' => false,
				'message' => 'Wrong OTP.'
			]);
	}
	public function search_products(Request $request)
	{
		$key_word = $request->key_word;
		$products = MenuItems::Where('name', 'like', '%' . $key_word . '%')->orWhere('description', 'like', '%' . $key_word . '%')->get();
		return response()->json([
			'status' => true,
			'message' => $products
		]);
	}
	public function product_detail(Request $request)
	{
		$product_id = $request->product_id;
		$product = MenuItems::find($product_id);
		if($product)
			return response()->json([
				'status' => true,
				'message' => $product
			]);
		else
			return response()->json([
				'status' => false,
				'message' => "Product not found."
			]);
	}
	public function get_banner($value='')
	{
		$banners = Banner::all();

		return response()->json([
				'status' => true,
				'message' => $banners
			]);
	}


}
