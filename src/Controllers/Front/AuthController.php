<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\Comm;
use Aphly\Laravel\Models\User;
use Aphly\Laravel\Models\UserAuth;
use Aphly\LaravelShop\Models\Account\Wishlist;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            throw new ApiException(['code'=>1,'msg'=>'Google Login Error ']);
        }
        $this->findOrCreateUserLogin($user,$request);
    }

    protected function findOrCreateUserLogin($googleUser,$request)
    {
        $post['id'] = $googleUser->getEmail();
        if(!$post['id']){
            throw new ApiException(['code'=>1,'msg'=>'Fail']);
        }
        $post['id_type'] = 'email';
        $userAuthModel = UserAuth::where($post);
        $userAuth = $userAuthModel->first();
        if(!empty($userAuth)){
            $user = User::where(['uuid'=>$userAuth->uuid])->firstOrError();
            $userAuthModel->update(['last_time'=>time(),'last_ip'=>$request->ip(),'user_agent' => $request->header('user-agent'),'accept_language' => $request->header('accept-language')]);
            $user->generateWebToken();
            (new Wishlist)->afterLogin();
            (new Cart)->afterLogin();
            Auth::guard('user')->login($user);
            throw new ApiException(['code'=>0,'msg'=>'login success','data'=>['redirect'=>$user->redirect()]]);
        }else{
            $comm = Comm::where('host',config('base.local_host'))->firstOrError();
            $post['uuid'] = Helper::uuid();
            $post['password'] = Hash::make(str::random(8));
            $post['last_ip'] = $request->ip();
            $post['last_time'] = time();
            $post['user_agent'] = $request->header('user-agent');
            $post['accept_language'] = $request->header('accept-language');
            $userAuth = UserAuth::create($post);
            if ($userAuth->uuid) {
                $user = User::create([
                    'nickname' => $googleUser->getName(),
                    'uuid' => $userAuth->uuid,
                    'web_token' => Str::random(64),
                    'web_token_expire' => time() + 120 * 60,
                    'comm_id'=>$comm->id
                ]);
                (new Wishlist)->afterRegister();
                (new Cart)->afterRegister();
                Auth::guard('user')->login($user);
                throw new ApiException(['code' => 0, 'msg' => 'Register success', 'data' => ['redirect' => $user->redirect()]]);
            } else {
                throw new ApiException(['code' => 1, 'msg' => 'Register fail']);
            }
        }
    }

}
