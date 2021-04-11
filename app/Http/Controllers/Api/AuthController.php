<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Socialites;
use App\Models\Socialites as ModelsSocialites;
use Validator;
use Socialite;
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


     public function login(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'email' => 'required|string|email',
             'password' => 'required|string',
             'remember_me' => 'boolean'
         ]);

         if ($validator->fails()) {
             return response()->json([
                 'status' => 'fails',
                 'message' => $validator->errors()->first(),
                 'errors' => $validator->errors()->toArray(),
             ]);
         }

         $credentials = request(['email', 'password']);

         if (!Auth::attempt($credentials)) {
             return response()->json([
                 'status' => 'fails',
                 'message' => 'Unauthorized'
             ], 401);
         }

         $user = $request->user();
         $tokenResult = $user->createToken('Personal Access Token');
         $token = $tokenResult->token;

         if ($request->remember_me) {
             $token->expires_at = Carbon::now()->addWeeks(1);
         }

         $token->save();

         return response()->json([
             'status' => 'success',
             'access_token' => $tokenResult->accessToken,
             'token_type' => 'Bearer',
             'expires_at' => Carbon::parse(
                 $tokenResult->token->expires_at
             )->toDateTimeString()
         ]);
     }



     public function logout(Request $request){

     if(Auth::guard('api')->check()){
        Auth::guard('api')->user()->token()->revoke();
        Auth::logout();
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
            $user =  Auth::guard('api')->user();
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

     public function redirectToGoogle($ocialite)
     {

          return Socialite::driver($ocialite)->stateless()->redirect();
     }


     public function handleGoogleCallback($ocialite)
     {
         try {


             $user = Socialite::driver($ocialite)->stateless()->user();
          //    dd($user);
             $socialiteProvider =   Socialites::where('provider_id',$user->getId())->first();

             if(!$socialiteProvider)
             {
                 $userId = User::where('email',$user->getEmail())->first();
                 if($userId){
                    return response()->json([
                        'status'=>false,
                        'message'=>'email đã tồn tại'
                    ]);
                 }else{
                     $users = new User();
                     $users->name = $user->getName();
                     $users->email = $user->getEmail();
                     $users->password = bcrypt(12345678);
                     $users->save();

                 }
                 $provider = new Socialites();
                 $provider->provider_id = $user->getId();
                 $provider->email = $user->getEmail();
                 $provider->provider  = $ocialite ;
                 $provider->save();

                 $userId = User::where('email',$user->getEmail())->first();
                 $tokenResult = $user->createToken('Personal Access Token');
                 $token = $tokenResult->token;
                 Auth::login($userId,true) ;
                return response()->json([
                    'status'=> true,
                    'token'=>  $token,
                    'message'=> 'login thành công '
                ]);

             }else{
              $userId = User::where('email',$user->getEmail())->first();
             }
             $tokenResult = $user->createToken('Personal Access Token');
             $token = $tokenResult->token;
             Auth::login($userId,true) ;
             return response()->json([
                'status'=> true,
                'token'=>  $token,
                'message'=> 'login thành công '
            ]);




         } catch (\Exception $e) {
             return response()->json([
                 'status'=>false,
                 'errors'=> $e->getMessage()
             ]);
         }



     }



}
