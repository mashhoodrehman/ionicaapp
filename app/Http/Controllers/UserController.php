<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
                    return response()->json(['error' => 'invalid_credentials' , 'code'=>'404']);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token']);
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
                    return response()->json(['msg' => $validator->errors()->toJson() , 'code' => 500]);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'profile' => $request->get('profile'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'));
        }

        public function getAuthenticatedUser()
            {
                    try {

                            if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found']);
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

            public function recover(Request $request)
{
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        $error_message = "Your email address was not found.";
        return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
    }
    try {
        Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject('Your Password Reset Link');
        });
    } catch (\Exception $e) {
        $error_message = $e->getMessage();
        return response()->json(['success' => false, 'error' => $error_message], 401);
    }
    return response()->json([
        'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
    ]);
}

}
