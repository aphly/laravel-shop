<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Account\Address;
use Aphly\LaravelShop\Models\Common\Country;
use Aphly\LaravelShop\Models\Common\Zone;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $res['title'] = '';
        $res['list'] = Address::where(['uuid'=>session('user')['uuid']])->Paginate(config('shop.perPage'))->withQueryString()->toArray();
        return $this->makeView('laravel-shop::account.address',['res'=>$res]);
    }


    public function add(Request $request){
        if($request->isMethod('post')){
            $input = $request->all();
            $input['uuid'] = session('user')['uuid'];
            Address::create($input);
            throw new ApiException(['code'=>1,'msg'=>'success','data'=>['redirect'=>'/account/address']]);
        }else{
            $res['title'] = '';
            $res['country'] = (new Country)->getListOpenCache();
            return $this->makeView('laravel-shop::account.address_form',['res'=>$res]);
        }
    }

    public function edit(Request $request){
        if($request->isMethod('post')){
            Address::where(['uuid'=>session('user')['uuid'],'id'=>$request->id])->update($request->all());
            throw new ApiException(['code'=>1,'msg'=>'success','data'=>['redirect'=>'/account/address']]);
        }else{
            $res['title'] = '';
            $res['country'] = (new Country)->getListOpenCache();
            return $this->makeView('laravel-shop::account.address_form',['res'=>$res]);
        }
    }

    public function country(Request $request){
        $list = (new Zone)->getListOpenCache($request->id);
        throw new ApiException(['code'=>1,'msg'=>'success','data'=>$list]);
    }
}
