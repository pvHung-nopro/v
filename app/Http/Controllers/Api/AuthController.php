<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Carbon\Carbon;


class AuthController extends Controller
{
     public function register(Request $request){
        try{
            $v = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password'  => 'required|min:3',
                'passwordConfim' => 'required|same:password'
            ]);
            if ($v->fails())
            {
                return response()->json([
                    'status' => false,
                    'message' => 'no register',
                    'code' => 422
                ], 422);
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Sign Up Success',
               ], 200);
          }catch(\Exception $e){
                return response()->json([
                   'status'=>false,
                   'message'=>$e->getMessage(),
                ],401);
          };

     }
     protected function login(Request $request){
         try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string|min:3',
                'remember_me' => 'boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()->toArray(),
                ]);
            }

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }else{

                $user = $request->user();
                $tokenResult = $user->createToken('hung dep trai');
                $token = $tokenResult->token;

                if ($request->remember_me) {
                    $token->expires_at = Carbon::now()->addWeeks(1);
                }

                $token->save();

                return response()->json([
                    'status' => true,
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ]);

            }



         }catch(\Exception $e){
               return response()->json([
                   'status' => false,
                   'message'=>$e->getMessage()
               ]);
         }

     }


     public function logout(Request $request){

     if($request->user()->token()){
        $request->user()->token()->revoke();
        return response()->json([
            'status'=>true,
            'message' => 'Successfully logged out'
        ]);
     }else{
         return response()->json([
             'status'=>false,
             'message'=>'no token!'
          ]);
     }


     }

     public function me(Request $request){
         try{
            $user = $request->user();
            return response()->json([
                'status'=>true,
                'user'=>$user
            ]);
         }catch(\Exception $e){
             return response()->json([
                 'message'=>$e->getMessage()
             ]);
         }

     }
}
