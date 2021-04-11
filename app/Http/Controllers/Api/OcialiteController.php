<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
// use App\Models\SocialAccount;
// use App\Models\Socialites as ModelsSocialites;
use App\Models\Socialites;
use Auth;
use DB;
use App\User;

class OcialiteController extends Controller
{
    public function loginUrl($ocialite)
    {
        // return response()->json([
        //     'url' => Socialite::driver($ocialite)->stateless()->redirect()->getTargetUrl(),
        // ]);

       return  Socialite::driver($ocialite)->stateless()->redirect();
    }

    public function loginCallback($ocialite)
    {
        try {


            $user = Socialite::driver($ocialite)->stateless()->user();


            // dd($user);
            $socialiteProvider =   DB::table('socialites')->where('provider_id',$user->getId())->first();


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
                $provider = DB::table('socialites')->insert([
                    'provider_id'=>$user->getId(),
                    'email'=>$user->getEmail(),
                    'provider'=>$ocialite,
                ]);
                // $provider->provider_id = $user->getId();
                // $provider->email = $user->getEmail();
                // $provider->provider  = $ocialite ;
                // $provider->save();

                $userId = User::where('email',$user->getEmail())->first();

                Auth::login($userId,true) ;
               return response()->json([
                   'status'=> true,
                //    'token'=>  $token,
                   'message'=> 'login thành công '
               ]);

            }else{
             $userId = User::where('email',$user->getEmail())->first();
            }

            Auth::login($userId,true) ;
            return response()->json([
               'status'=> true,

               'message'=> 'login thành công '
           ]);




        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'errors'=> $e->getMessage()
            ]);
        }

        // $googleUser = Socialite::driver('google')->stateless()->user();
        // $user = null;

        // DB::transaction(function () use ($googleUser, &$user) {
        //     $socialAccount = SocialAccount::firstOrNew(
        //         ['social_id' => $googleUser->getId(), 'social_provider' => 'google'],
        //         ['social_name' => $googleUser->getName()]
        //     );

        //     if (!($user = $socialAccount->user)) {
        //         $user = User::create([
        //             'email' => $googleUser->getEmail(),
        //             'name' => $googleUser->getName(),
        //         ]);
        //         $socialAccount->fill(['user_id' => $user->id])->save();
        //     }
        // });

        // return response()->json([
        //     // 'user' => new UserResource($user),
        //     'google_user' => $googleUser,
        // ]);
    }
}
