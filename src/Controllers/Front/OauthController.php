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

class OauthController extends Controller
{
    public $driver = ['facebook','google'];

    public function redirect(Request $request)
    {
        if(in_array($request->driver,$this->driver)){
            return Socialite::driver($request->driver)->redirect();
        }else{
            throw new ApiException(['code'=>1,'msg'=>'Oauth Type Error ']);
        }
    }

    public function handleCallback(Request $request)
    {
        if(!in_array($request->driver,$this->driver)){
            throw new ApiException(['code'=>1,'msg'=>'Oauth Type Error ']);
        }
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            throw new ApiException(['code'=>1,'msg'=>'Oauth Login Error ']);
        }
        $this->findOrCreateUserLogin($user,$request);
    }

    protected function findOrCreateUserLogin($oauthUser,$request)
    {
        if($request->driver=='google'){
            $post['id'] = $oauthUser->getEmail();
            if(!$post['id']){
                throw new ApiException(['code'=>1,'msg'=>'Fail']);
            }
            $post['id_type'] = 'email';
        }else{
            $post['id_type'] = 'email';
            $post['id'] = $oauthUser->getEmail();
            if(!$post['id']){
                $post['id'] = $oauthUser->getId();
                $post['id_type'] = 'oauth';
            }
        }

        $userAuthModel = UserAuth::where($post);
        $userAuth = $userAuthModel->first();
        if(!empty($userAuth)){
            $user = User::where(['uuid'=>$userAuth->uuid])->firstOrError();
            $userAuthModel->update(['last_time'=>time(),'last_ip'=>$request->ip(),'user_agent' => $request->header('user-agent'),'accept_language' => $request->header('accept-language')]);
            $user->generateToken();
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
                    'nickname' => $oauthUser->getName(),
                    'uuid' => $userAuth->uuid,
                    'access_token' => Str::random(64),
                    'access_token_expire' => time() + 86400,
                    'refresh_token' => Str::random(64),
                    'refresh_token_expire' => time() + 86400 * 365,
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
