<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\MenuItems;
use App\Model\Discounts;
use App\Model\Deals;
use App\Model\Orders;
use Twilio\Rest\Client;
use App\Model\OrderItems;
use App\Model\UserAddress;
use App\Model\OrderFeedback;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('apikey.verify');
      $this->middleware('auth:api', ['except' => ['login','register','check_duplicate_number', 'Order']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
      // $message = $this->check_duplicate_email($request['email']);
      // if($message == 'exist')
      //   return response()->json([
      //     'status' => false,
      //     'message' => 'Email already registered.',
      //   ]);

      if($request['socialType'] != 'phone' && $request['socialType'] != Null)
      {
        if(!$request['socialId'])
          return response()->json([
            'status' => false,
            'message' => 'socialId is required.',
          ]);

        // $this->validate($request,[
        //   'socialId' => ['string','required'],
        // ]);

        if($request['name'])
        {
          $message = $this->check_duplicate_email($request['email']);
          if($message == 'exist')
            return response()->json([
              'status' => false,
              'message' => 'Email already registered.',
            ]);
          $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'socialType' => ['string','max:255'],
            'deviceToken' => ['string'],
            'deviceType' => ['string'],
            'phoneNo' => ['string','unique:users'],
            'socialId' => ['string'],
          ]);

      
          $request['password'] = '12345678';

          $user = User::create([
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'socialType' => $request['socialType'],
            'deviceToken' => $request['deviceToken'],
            'deviceType' => $request['deviceType'],
            'phoneNo' => $request['phoneNo'],
            'socialId' => $request['socialId'],
            'password' => Hash::make($request['password']),
          ]);

          $credentials = request(['email', 'password']);
          $token = auth()->guard('api')->attempt($credentials);
          
          $message = array(
            'id' => $user->id,
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phoneNo' => $request['phoneNo'],
            'access_token' => $token,
            'token_type' => 'bearer',
                // 'expires_in' => auth()->factory()->getTTL() * 60
            'expires_in' => auth('api')->factory()->getTTL() * 60
          );
          return response()->json([
            'status' => true,
            'message' => $message,
          ]);

        }

        $socialId = $request['socialId'];
        if($socialId)
          $user = User::where('socialId',$socialId)->first();
        if($user)
        {
          $user->deviceToken = $request['deviceToken'];
          $user->save();
          $request['email'] = $user->email;
          $request['password'] = '12345678';
          $credentials = request(['email', 'password']);
          $token = auth()->guard('api')->attempt($credentials);

          return $this->respondWithTokenUser($token);

          
        }
        else
        {
          return response()->json([
            'status' => false,
            'message' => 'user_not_exist',
          ]);
        }

      }

      $message = $this->check_duplicate_email($request['email']);
      if($message == 'exist')
        return response()->json([
          'status' => false,
          'message' => 'Email already registered.',
        ]);
      $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'socialType' => ['string','max:255'],
        'deviceToken' => ['string'],
        'deviceType' => ['string'],
        'phoneNo' => ['string','unique:users'],
        'socialId' => ['string'],
      ]);

      $user = User::create([
        'name' => $request['name'],
        'last_name' => $request['last_name'],
        'email' => $request['email'],
        'socialType' => $request['socialType'],
        'deviceToken' => $request['deviceToken'],
        'deviceType' => $request['deviceType'],
        'phoneNo' => $request['phoneNo'],
        'socialId' => $request['socialId'],
        'password' => Hash::make($request['password']),
      ]);

      $credentials = request(['email', 'password']);
      $token = auth()->guard('api')->attempt($credentials);

      $message = array(
        'id' => $user->id,
        'name' => $request['name'],
        'last_name' => $request['last_name'],
        'email' => $request['email'],
        'phoneNo' => $request['phoneNo'],
        'access_token' => $token,
        'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60
        'expires_in' => auth('api')->factory()->getTTL() * 60
      );

      return response()->json([
        'status' => true,
        'message' => $message,
      ]);
    }

    public function login(Request $request)
    {
      if($request->email)
        $credentials = request(['email', 'password']);
      else if($request->phoneNo)
        $credentials = request(['phoneNo', 'password']);
      else
        return response()->json(['status' => false, 'message' => 'unauthorized'], 200);

      if (! $token = auth()->guard('api')->attempt($credentials)) {
        return response()->json(['status' => false, 'message' => 'unauthorized'], 200);
      }

      $user = User::find(auth()->guard('api')->user()->id);
      $user->deviceToken = $request->deviceToken;
      $user->deviceType = $request->deviceType;
      $user->save();

      return $this->respondWithTokenUser($token);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
      return response()->json([
        'status' => true,
        'message' => auth()->guard('api')->user()
      ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
      auth()->guard('api')->logout();

      return response()->json(['status' => true,'message' => 'logged_out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
      return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
      $message = array(
        'access_token' => $token,
        'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60
        'expires_in' => auth('api')->factory()->getTTL() * 60,

      );
      return response()->json([
        'status' => true,
        'message' => $message
      ]);
    }

    protected function respondWithTokenUser($token)
    {
      $user = User::findOrFail(auth()->guard('api')->user()->id);
      $message = array(
        'access_token' => $token,
        'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60
        'expires_in' => auth('api')->factory()->getTTL() * 60,
        'user' => $user

      );
      return response()->json([
        'status' => true,
        'message' => $message
      ]);
    }

    public function check_duplicate_number(Request $request)
    {
      $this->validate($request,[
        'phoneNo' => 'required|string',
      ]);
      $phoneNo = substr($request->phoneNo, -10);
      $user = User::where('phoneNo', 'like', '%' . $phoneNo)->first();
      if($user)
      {
        return response()->json([
          'status' => false,
          'message' => 'Mobile Number already exist. Please select another.'
        ]);
      }
      else
      {
        return response()->json([
          'status' => true,
          'message' => 'phoneNo_not_exist'
        ]);
      }


    }

    public function edit_profile(Request $request)
    {
      $this->validate($request,[
        'name' => 'string',
        'last_name' => 'string',
      ]);

      $user = auth()->guard('api')->user();

      // $user = User::find($request->user_id);
      if($user)
      {
        if(isset($request->name))
          $user->name = $request->name;
        if(isset($request->last_name))
          $user->last_name = $request->last_name;
        if(isset($request->password))
          $user->password = $request->password;
        if(isset($request->push_notification)) 
          $user->push_notification = $request->push_notification;
        if($request->user_image)
        {
          $image = $request->user_image;  // your base64 encoded
          $image = str_replace('data:image/jpeg;base64,', '', $image);
          $image = str_replace(' ', '+', $image);
          $imageName = time().'.'.'jpeg';
          \File::put(storage_path(). '/images/' . $imageName, base64_decode($image));

          $user->user_image = $imageName;
        }
        $user->save();

        return response()->json([
          'status' => true,
          'message' => $user
        ]);
      }

      return response()->json([
        'status' => false,
        'message' => 'User not exist.'
      ]);
    }

    public function save_user_address(Request $request)
    {
      $this->validate($request,[
        // 'user_id' => 'int',
        'title' => 'string',
        'address' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
      ]);
      $user = auth()->guard('api')->user();
      $prev_address = UserAddress::where('user_id',$user->id)->count();
      if($prev_address >= 5)
        return response()->json([
          'status' => false,
          'message' => 'You can add maximum 5 address.'
        ]);

      $user_address = new UserAddress;
      // $user_address->user_id = $request->user_id;
      $user_address->user_id = $user->id;
      $user_address->title = $request->title;
      $user_address->address = @addslashes($request->address);
      $user_address->latitude = $request->latitude;
      $user_address->longitude = $request->longitude;
      // $user = User::find($request->user_id);
      $user_address->save();

      return response()->json([
        'status' => true,
        'message' => $user_address
      ]);
      
    }
    public function delete_user_address(Request $request)
    {
      $this->validate($request,[
        'address_id' => 'required',
      ]);
      $address_id = $request->address_id;
      $user = auth()->guard('api')->user();

      $address = UserAddress::where([['user_id',$user->id],['id',$address_id]])->first();
      if(!$address)
        return response()->json([
          'status' => false,
          'message' => 'Address not found.'
        ]);

      $address->delete();

      return response()->json([
        'status' => true,
        'message' => 'Address deleted successfully.'
      ]);

    }
    public function get_user_address(Request $request)
    {
      // $this->validate($request,[
      //   'user_id' => 'int',
      // ]);
      $user = auth()->guard('api')->user();
      // $request->user_id
      $user_addresss = Null;
      $user_addresss = UserAddress::where('user_id',$user->id)->get();
      return response()->json([
        'status' => true,
        'message' => $user_addresss
      ]);
      
    }

    public function get_order(Request $request)
    {
      $this->validate($request,[
        'order_id' => 'int',
      ]);
      // $user = auth()->guard('api')->user();
      // $request->user_id
      $order = Orders::find($request->order_id);
      if(!$order)
        return response()->json([
          'status' => false,
          'message' => 'System not found any record.',
        ]);

      $order_items = $order->order_items;
      foreach ($order_items as $key => $item) {
        $mitem = MenuItems::find($item->menu_item_id);
        $order->order_items[$key]['item_name'] = $mitem->name;
      }
      
      $order->customer;
      $order->branch;

      return response()->json([
        'status' => true,
        'message' => array(
          'order' => $order,
        )
      ]);
      
    }
    public function get_allorders()
    {
      $user = auth()->guard('api')->user();
      // $request->user_id
      // $orders = Orders::where('user_id', $user->id)->get();
      $orders = Orders::where([['user_id', $user->id],['status','=','canceled']])->orWhere([['user_id', $user->id],['status','=','delivered']])->paginate(10);
      $orders_arr = array();
      foreach ($orders as $order) {
        // $category->sub_categories;
        $order_items = $order->order_items;
        foreach ($order_items as $key => $item) {
          $mitem = MenuItems::find($item->menu_item_id);
          if($mitem)
            $order->order_items[$key]['item_name'] = $mitem->name;
          
        }
        $order->customer;
        $order->branch;
        $orders_arr[] = $order;
      }
      
      return response()->json([
        'status' => true,
        'message' => array(
          'orders' => $orders_arr,
        )
      ]);
      
    }
    public function get_current_orders()
    {
      $user = auth()->guard('api')->user();
      // $request->user_id
      // $orders = Orders::where('user_id', $user->id)->get();
      $orders = Orders::where([['user_id', $user->id],['status','!=','canceled'],['status','!=','delivered']])->paginate(10);
      $orders_arr = array();
      foreach ($orders as $order) {
        // $category->sub_categories;
        // $order->order_items;
        $order_items = $order->order_items;
        foreach ($order_items as $key => $item) {
          $mitem = MenuItems::find($item->menu_item_id);
          if($mitem)
            $order->order_items[$key]['item_name'] = $mitem->name;
        }
        $order->customer;
        $order->branch;
        $orders_arr[] = $order;
      }
      
      return response()->json([
        'status' => true,
        'message' => array(
          'orders' => $orders_arr,
        )
      ]);
      
    }

    public function Order(Request $request)
    {
      $this->validate($request,[
        'user_id' => 'required',
      ]);

      $now = date('H:i');
      // if($now < env('HOTEL_START_TIME') || $now > env('HOTEL_END_TIME'))
      if($now > $this->admin_setting('HOTEL_START_TIME') && $now < $this->admin_setting('HOTEL_END_TIME'))
        return response()->json([
          'status' => false,
          'message' => 'Resturant closed.'
        ]);

      
        

      $current_orders = Orders::where([['user_id', $request->user_id],['status','!=','canceled'],['status','!=','delivered']])->count();
      if($current_orders >= 1)
        return response()->json([
          'status' => false,
          'message' => 'Already have current order'
        ]);

      $rawPostData = file_get_contents("php://input");
      $data = @json_decode($rawPostData);

      $product_ids = $data->product_ids;
      $is_offer = $data->is_offer;
      $product_sizes = $data->product_sizes;
      $product_quantities = $data->product_quantities;
      $total_amount = 0;
      foreach ($product_ids as $key => $value) 
      {
        $quantity = $product_quantities[$key];
        $size_type = $product_sizes[$key];

        $offer = $is_offer[$key];
        if($offer == 1)
        {
          $deal = Deals::find($value);
          $item_price = $deal->deal_price;
        }
        else
        {
          $item = MenuItems::find($value);
          if($item->variation == 0)
            $item_price = $item->static_price;
          else
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

      if($total_amount < $this->admin_setting('MINIMUM_ORDER_PRICE'))
        return response()->json([
          'status' => false,
          'message' => 'Minimum order price is '.$this->admin_setting('MINIMUM_ORDER_PRICE')
        ]);
        
      if(!empty($data))
      {
        $product_ids = $data->product_ids;
        $product_quantities = $data->product_quantities;
        $is_offer = $data->is_offer;
        $product_sizes = $data->product_sizes;
        $coupon_id = $data->coupon_id;

        $order = new Orders;
        $order->user_id = $request->user_id;
        $order->branch_id = $request->branch_id;
        $order->discount_id = $request->coupon_id?$request->coupon_id:0;
        $order->address = @addslashes($request->address?$request->address:'');
        $order->latitude = $request->lat;
        $order->longitude = $request->lng;
        $order->delivery_mode = $request->delivery_mode?$request->delivery_mode:'';
        $order->payment_mode = $request->payment_mode?$request->payment_mode:'cash';
        $order->status = 'pending';
        $order->order_from = 'app';
        $order->additional_info = $request->additional_info?$request->additional_info:'';
        $order->save();

        $product_prices = array();
        $total_amount = 0;
        $discount_amount = 0;
        foreach ($product_ids as $key => $value) 
        {
          $quantity = $product_quantities[$key];
          $size_type = $product_sizes[$key];

          $offer = $is_offer[$key];
          if($offer == 1)
          {
            $deal = Deals::find($value);
            $item_price = $deal->deal_price;
          }
          else
          {
            $item = MenuItems::find($value);
            if($item->variation == 0)
              $item_price = $item->static_price;
            else
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
          
          $orderitem = new OrderItems;
          $orderitem->order_id = $order->id;
          $orderitem->is_offer = $offer;
          $orderitem->menu_item_id = $value;
          $orderitem->quantity = $quantity;
          $orderitem->price = $item_price;
          $orderitem->sizetype = $size_type? $size_type: '';
          $orderitem->save();
          $product_prices[] = $item_price*$quantity;
        }

        $total_amount = array_sum($product_prices);

        

        if($coupon_id != 0)
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
        $order_id = 100+$order->id;
        $order->order_id = $order_id;
        $order->total_amount = $total_amount;
        $order->discount_amount = $discount_amount;
        $order->save();
        // $order->order_items;
        $order_items = $order->order_items;
        foreach ($order_items as $key => $item)
        {
          if($item->is_offer == 1)
          {
            $ditem = Deals::find($item->menu_item_id);
            $order->order_items[$key]['item_name'] = $ditem->deal_name;
          }
          else
          {
            $mitem = MenuItems::find($item->menu_item_id);
            $order->order_items[$key]['item_name'] = $mitem->name;
          }
          
        }
        $order->customer;
        $order->branch;

        return response()->json([
          'status' => true,
          'message' => array(
            'order' => $order,
          )
        ]);
      }else{
        return response()->json([
          'status' => false
        ]);
      }


    }

    public function create_order_feedback(Request $request)
    {
      $this->validate($request,[
        'order_id' => 'required|int',
        'message' => 'required',
        'rating' => 'required',
      ]);

      $user = auth()->guard('api')->user();
      $feedback = new OrderFeedback;
      $feedback->user_id = $user->id;
      $feedback->order_id = $request->order_id;
      $feedback->message = $request->message;
      $feedback->rating = $request->rating;
      $feedback->save();

      return response()->json([
        'status' => true,
        'message' => array(
          'feedback' => $feedback,
        )
      ]);

    }
    public function check_duplicate_email($email)
    {
      $user = User::where('email',$email)->first();
      if($user)
        return 'exist';
      else
        return 'not_exist';

    }

  }
