<?php

namespace Aphly\LaravelShop\Controllers\Front\Account;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Account\Address;
use Aphly\LaravelShop\Models\Account\Customer;
use Aphly\LaravelShop\Models\Common\Country;
use Aphly\LaravelShop\Models\Common\Zone;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $res['title'] = '';
        $res['list'] = Address::where(['uuid'=>session('user')['uuid']])->orderBy('id','desc')->Paginate(config('shop.perPage'))->withQueryString();
        $country_ids = $zone_ids = [];
        foreach ($res['list'] as $val){
            $country_ids[] = $val['country_id'];
            $zone_ids[] = $val['zone_id'];
        }
        $res['country'] = (new Country)->findAllIds($country_ids);
        $res['zone'] = (new Zone)->findAllIds($zone_ids);
        $res['customer'] = Customer::find(session('user')['uuid']);
        return $this->makeView('laravel-shop::account.address',['res'=>$res]);
    }

    public function save(Request $request){
        $address_id = $request->query('address_id',0);
        if($request->isMethod('post')){
            $input = $request->all();
            if(!$address_id){
                $input['uuid'] = session('user')['uuid'];
            }
            $address = Address::updateOrCreate(['uuid'=>session('user')['uuid'],'id'=>$address_id],$input);
            $default = $request->input('default',0);
            if($default){
                Customer::where(['uuid'=>session('user')['uuid']])->update(['address_id'=>$address->id]);
            }else{
                if($address_id == $address->id){
                    Customer::where(['uuid'=>session('user')['uuid']])->update(['address_id'=>0]);
                }
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/account/address']]);
        }else{
            $res['title'] = '';
            $res['country'] = (new Country)->getListOpenCache();
            $country_keys = array_keys($res['country']);
            $res['info'] = Address::where(['uuid'=>session('user')['uuid'],'id'=>$address_id])->firstOrNew();
            if($res['info'] && in_array($res['info']->country_id,$country_keys)){
                $res['zone'] = (new Zone)->getListOpenCache($res['info']->country_id);
            }
            $res['customer'] = Customer::find(session('user')['uuid']);
            return $this->makeView('laravel-shop::account.address_form',['res'=>$res]);
        }
    }

    public function remove(Request $request){
        Address::where(['uuid'=>session('user')['uuid'],'id'=>$request->id])->delete();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/account/address']]);
    }

    public function country(Request $request){
        $list = (new Zone)->getListOpenCache($request->id);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>$list]);
    }
}
