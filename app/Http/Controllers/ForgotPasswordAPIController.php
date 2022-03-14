<?php

namespace App\Http\Controllers;

use Hash;
use Mail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordAPIController extends Controller
{

    use SendsPasswordResetEmails;
    
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function __construct()
    {
        $this->middleware('apikey.verify');
    }
    public function sendResetLinkEmail(Request $request)
    {
      $user_email = $user_phone = null;
      // Validate user input
      $validator = Validator::make($request->all(), [
          'email' => ['required', 'email', 'max:255' ],
      ]);

      if($validator->fails()){
        $validator1 = Validator::make($request->all(), [
          'phoneNo' => ['required', 'max:255' ],
        ]);
        if ($validator1->fails())
            return response()->json(['status' => false,'message' => $validator->errors()], 422);
      }
      if(isset($request->email))
        $user_email = User::where('email',$request->email)->first();
      elseif(isset($request->phoneNo))
        $user_phone = User::where('phoneNo',$request->phoneNo)->first();
      else
        return response()->json(['status' => false, 'message' => 'No User Found.'], 200);

      if($user_email)
      {
        $reset_otp = substr(number_format(time() * rand(),0,'',''),0,4);
        $user_email->password_reset_otp = $reset_otp;
        $user_email->save();

        $data['subject'] = 'Password Reset';
        $data['reset_otp'] = $reset_otp;
        $data['name'] = $user_email->name.' '.$user_email->last_name;
        $email = $request->email;

        Mail::send('auth.password_reset_mail',$data, function($message) use ($email,$data)
        {
          $message->to($email, $data['name'])->subject($data['subject']);
        });

        return response()->json(['status' => true, 'message' => 'mail_sent'], 200);

      }
      elseif($user_phone)
      {
        $reset_otp = substr(number_format(time() * rand(),0,'',''),0,4);
        $user_phone->password_reset_otp = $reset_otp;
        $user_phone->save();

        $username = $this->admin_setting('JAZZ_USERNAME');
        $password = $this->admin_setting('JAZZ_PASSWORD');
        $mask = $this->admin_setting('JAZZ_MASK');
        $message = 'Please do not share your OTP with anyone. Your OTP is '.$reset_otp;
        $message = strval($message);

        $cURLConnection = curl_init();

        $curl = curl_init();
        $link = 'https://connect.jazzcmt.com/sendsms_url.html?Username='.$username.'&Password='.$password.'&From='.$mask.'&To='.$request->phoneNo.'&Message='.$message;
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


        return response()->json(['status' => true, 'message' => 'mail_sent'], 200);
      }
      else
      {
        return response()->json(['status' => false, 'message' => 'user_not_found'], 200);
      }


    }

    public function reset(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255' ],
            'password' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false,'message' => $validator->errors()], 422);
        }

        $user = User::where('email',$request->email)->first();

        if($user)
        {
            if($user->password_reset_otp != 0)
            {
                if($request->otp != $user->password_reset_otp)
                    return response()->json(['status' => false, 'message' => 'OTP is not valid.'], 200);

                $user->password_reset_otp = 0;
                $user->password = Hash::make($request['password']);
                $user->save();
                return response()->json(['status' => true, 'message' => 'password_reset'], 200);
            }
            
            return response()->json(['status' => false, 'message' => 'OTP not found.'], 200);

        }
        else
        {
            return response()->json(['status' => false, 'message' => 'No user found.'], 200);
        }

    }

}