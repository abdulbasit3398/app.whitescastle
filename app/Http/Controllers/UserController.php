<?php

    namespace App\Http\Controllers;

    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;

    class UserController extends Controller
    {
        public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }

        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }

        public function getAuthenticatedUser()
        {
                    try {

                            if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found'], 404);
                            }

                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
        }

        public function customers()
        {
                $customers = User::where('type', 'user')->orderBy('id', 'DESC')->get();
                return view('admin.customers.index')->with(compact('customers'));
        }

        public function customer_store(Request $request)
        {
                if($request->user_id)
                {
                        $item = User::find($request->user_id);
                }else{
                        $item = new User;
                }
                
                $item->name = $request->name;
                $item->last_name = $request->last_name;
                $item->email = $request->email;
                $item->socialType = 'phone';
                $item->phoneNo = $request->phone;
                $item->type = 'user';
                if($request->user_id)
                {}else{
                        $item->password = Hash::make($request->password);
                }
                $item->save();
                return redirect()->back()->with('success', 'your message,here');   
        }

        public function staff()
        {
                $staff = User::where('type', '!=', 'user')->where('type', '!=', 'manager')->get();
                return view('admin.staff.index')->with(compact('staff'));
        }

        public function staff_store(Request $request)
        {
                if($request->user_id)
                {
                        $item = User::find($request->user_id);
                }else{
                        $item = new User;
                }
                
                $item->name = $request->name;
                $item->last_name = $request->last_name;
                $item->email = $request->email;
                $item->socialType = 'phone';
                $item->phoneNo = $request->phone;
                $item->type = $request->type;
                if($request->user_id)
                {}else{
                        $item->password = Hash::make($request->password);
                }
                $item->save();
                return redirect()->back()->with('success', 'your message,here'); 
        }
    }