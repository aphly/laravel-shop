<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\CommonUser;
use Aphly\Laravel\Models\CommonUserAuth;
use Aphly\LaravelShop\Controllers\Front\Controller;
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
            $Socialiteuser = Socialite::driver($request->driver)->user();
        } catch (\Exception $e) {
            throw new ApiException(['code'=>1,'msg'=>'Oauth Login Error ']);
        }
        $this->findOrCreateUserLogin($Socialiteuser,$request);
    }

    protected function findOrCreateUserLogin($Socialiteuser,$request)
    {
        if($request->driver=='google') {
            $post['id'] = $Socialiteuser->getEmail();
            if (!$post['id']) {
                throw new ApiException(['code' => 1, 'msg' => 'Fail']);
            }
            $post['id_type'] = 'email';
        }else if($request->driver=='facebook'){
            $post['id_type'] = 'email';
            $post['id'] = $Socialiteuser->getEmail();
            if(!$post['id']){
                $post['id'] = $Socialiteuser->getId();
                $post['id_type'] = 'facebook';
            }
        }

        $userAuthModel = CommonUserAuth::where($post);
        $userAuth = $userAuthModel->first();
        if(!empty($userAuth)){
            $user = CommonUser::where(['uid'=>$userAuth->uid])->firstOrError();
            $userAuthModel->update(['last_time'=>time(),'last_ip'=>$request->ip(),
                'user_agent' => $request->header('user-agent'),'accept_language' => $request->header('accept-language')]);
            (new Wishlist)->afterLogin();
            (new Cart)->afterLogin();
            Auth::guard('user')->login($user);
            throw new ApiException(['code'=>0,'msg'=>'login success','data'=>['redirect'=>$user->redirect()]]);
        }else{
            $post['uid'] = app('Snowflake')->nextId();
            $post['password'] = Hash::make(str::random(8));
            $post['last_ip'] = $request->ip();
            $post['last_time'] = time();
            $post['user_agent'] = $request->header('user-agent');
            $post['accept_language'] = $request->header('accept-language');
            $userAuth = CommonUserAuth::create($post);
            if ($userAuth->uid) {
                $user = CommonUser::create([
                    'nickname' => $Socialiteuser->getName(),
                    'uid' => $userAuth->uid,
                    'token' => Str::random(64),
                    'token_expire' => time() + 86400
                ]);
                (new Wishlist)->afterRegister();
                (new Cart)->afterRegister();
                Auth::guard('user')->login($user);
                throw new ApiException(['code' => 0, 'msg' => 'Login Success']);
            } else {
                throw new ApiException(['code' => 1, 'msg' => 'Login Fail']);
            }
        }
    }

}
