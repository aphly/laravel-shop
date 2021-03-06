<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Mail\MailSend;
use Aphly\LaravelAdmin\Models\User;
use Aphly\LaravelAdmin\Models\UserAuth;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Mail\Forget;
use Aphly\LaravelShop\Mail\Verify;
use Aphly\LaravelShop\Models\Customer\Customer;
use Aphly\LaravelShop\Models\Common\Setting;
use Aphly\LaravelShop\Requests\LoginRequest;
use Aphly\LaravelShop\Requests\RegisterRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function config;
use function redirect;
use function session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $res['user'] = session('user');
        return $this->makeView('laravel-shop::front.home.index',['res'=>$res]);
    }

    public function autoLogin(Request $request)
    {
        try {
            $decrypted = Crypt::decryptString($request->token);
            $user = User::where('token',$decrypted)->first();
            if(!empty($user)){
                Auth::guard('user')->login($user);
                return redirect('/index');
            }
        } catch (DecryptException $e) {
            throw new ApiException(['code'=>1,'msg'=>'Token_error','data'=>['redirect'=>'/index']]);
        }
    }

    public function login(loginRequest $request)
    {
        if($request->isMethod('post')) {
            $arr['identifier'] = $request->input('identifier');
            $arr['identity_type'] = config('laravel.identity_type');
            $userAuth = UserAuth::where($arr)->first();
            if(!empty($userAuth)){
                $key = 'user_'.$request->ip();
                if($this->limiter($key,5)){
                    if(Hash::check($request->input('credential',''),$userAuth->credential)){
                        $user = User::find($userAuth->uuid);
                        if($user->status==1){
                            Auth::guard('user')->login($user);
                            $userAuth->last_login = time();
                            $userAuth->last_ip = $request->ip();
                            $userAuth->save();
                            $user->token = Str::random(64);
                            $user->token_expire = time()+120*60;
                            $user->save();
                            $user_arr = $user->toArray();
                            $user_arr['identity_type'] = $userAuth->identity_type;
                            $user_arr['identifier'] = $userAuth->identifier;
                            session()->forget(['user','customer']);
                            session(['user'=>$user_arr]);
                            Customer::makeSession($user_arr['uuid']);
                            Customer::initCart();
                            $redirect = Cookie::get('refer');
                            $redirect = $redirect??'/index';
                            throw new ApiException(['code'=>0,'msg'=>'login success','data'=>['redirect'=>$redirect,'user'=>$user_arr]]);
                        }else{
                            throw new ApiException(['code'=>3,'msg'=>'???????????????','data'=>['redirect'=>'/index']]);
                        }
                    }else{
                        $this->limiterIncrement($key,15*60);
                    }
                }else{
                    throw new ApiException(['code'=>2,'msg'=>'??????????????????????????????15??????','data'=>['redirect'=>'/index']]);
                }
            }
            throw new ApiException(['code'=>1,'msg'=>'?????????????????????','data'=>['redirect'=>'/index']]);
        }else{
            $res['title'] = '';
            return $this->makeView('laravel-shop::front.home.login',['res'=>$res]);
        }
    }

    public function register(RegisterRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $post['identity_type'] = config('shop.identity_type');
            $post['uuid'] = Helper::uuid();
            $post['credential'] = Hash::make($post['credential']);
            $post['last_login'] = time();
            $post['last_ip'] = $request->ip();
            $userAuth = UserAuth::create($post);
            if($userAuth->id){
                $arr['nickname'] = str::random(8);
                $arr['token'] = $arr['uuid'] = $userAuth->uuid;
                $arr['token_expire'] = time();
                $user = User::create($arr);
                Auth::guard('user')->login($user);
                $user_arr = $user->toArray();
                $user_arr['identity_type'] = $userAuth->identity_type;
                $user_arr['identifier'] = $userAuth->identifier;
                session()->forget(['user','customer']);
                session(['user'=>$user_arr]);
                $redirect = Cookie::get('refer');
                $redirect = $redirect??'/customer/account';

                //??????
                $setting = Setting::findAll();
                $group_id = $setting['config']['group']??1;
                $customer = Customer::create(['uuid'=>$userAuth->uuid,'group_id'=>$group_id]);
                Customer::makeSession($customer->uuid);
                Customer::initCart();
                (new MailSend())->do($post['identifier'],new Verify($userAuth));
                throw new ApiException(['code'=>0,'msg'=>'????????????','data'=>['redirect'=>$redirect,'user'=>$user_arr]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'????????????']);
            }
        }else{
            $res['title'] = '';
            return $this->makeView('laravel-shop::front.home.login',['res'=>$res]);
        }
    }

    public function logout(Request $request)
    {
        session()->forget('user');
        Auth::guard('user')->logout();
        Customer::logout();
        throw new ApiException(['code'=>0,'msg'=>'????????????','data'=>['redirect'=>'/login']]);
    }

    public function mailVerifyCheck(Request $request)
    {
        try {
            $decrypted = Crypt::decryptString($request->token);
            if($decrypted>=time()){
                $userAuth = UserAuth::find($request->id);
                if($userAuth){
                    $userAuth->verified = 1;
                    $userAuth->save();
                    throw new ApiException(['code'=>0,'msg'=>'email activation succeeded','data'=>['redirect'=>'/index']]);
                }
                throw new ApiException(['code'=>3,'msg'=>'user not found','data'=>['redirect'=>'/index']]);
            }else{
                throw new ApiException(['code'=>2,'msg'=>'Token Expire','data'=>['redirect'=>'/index']]);
            }
        } catch (DecryptException $e) {
            throw new ApiException(['code'=>1,'msg'=>'Token Error','data'=>['redirect'=>'/index']]);
        }
    }

    public function mailVerify()
    {
        $user = Auth::guard('user')->user();
        $userauth = UserAuth::where(['identity_type'=>'email','uuid'=>$user->uuid])->first();
        if(!empty($userauth)){
            (new MailSend())->do($userauth->identifier,new Verify($userauth));
            throw new ApiException(['code'=>0,'msg'=>'email sent','data'=>['redirect'=>'/index']]);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'email not exist','data'=>['redirect'=>'/index']]);
        }
    }


    public function forget(Request $request)
    {
        if($request->isMethod('post')) {
            $userauth = UserAuth::where(['identity_type'=>'email','identifier'=>$request->input('identifier','')])->first();
            if(!empty($userauth)){
                (new MailSend())->do($userauth->identifier,new Forget($userauth));
                throw new ApiException(['code'=>0,'msg'=>'email sent','data'=>['redirect'=>'/index']]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'email not exist','data'=>['redirect'=>'/index']]);
            }
        }else{
            $res['title'] = '';
            return $this->makeView('laravel-shop::front.home.forget',['res'=>$res]);
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            $decrypted = Crypt::decryptString($request->token);
            $decrypted = explode(',',$decrypted);
            $id = $decrypted[0]??0;
            $time = $decrypted[1]??0;
            if($id && $time>=time()) {
                $userAuth = UserAuth::find($id);
                if($userAuth){
                    if($request->isMethod('post')) {
                        $validator = Validator::make($request->all(), [
                            'credential' => 'required|between:6,64|alpha_num',
                        ]);
                        if ($validator->fails()) {
                            throw new ApiException(['code'=>11000,'msg'=>'??????????????????','data'=>$validator->errors()]);
                        }
                        $arr = $validator->safe()->only(['credential']);
                        $userAuth->changePassword($userAuth->uuid,$arr['credential']);
                        throw new ApiException(['code'=>0,'msg'=>'password reset success','data'=>['redirect'=>'/index']]);
                    }else{
                        $res['title'] = '';
                        $res['token'] = $request->token;
                        return $this->makeView('laravel::index.forget-password', ['res' => $res]);
                    }
                }else{
                    throw new ApiException(['code'=>3,'msg'=>'user error','data'=>['redirect'=>'/index']]);
                }
            }else{
                throw new ApiException(['code'=>2,'msg'=>'Token Expire','data'=>['redirect'=>'/index']]);
            }
        } catch (DecryptException $e) {
            throw new ApiException(['code'=>1,'msg'=>'Token Error','data'=>['redirect'=>'/index']]);
        }
    }


}
