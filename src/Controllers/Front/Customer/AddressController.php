<?php

namespace Aphly\LaravelShop\Controllers\Front\Customer;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Account\Address;
use Aphly\LaravelShop\Models\Account\Customer;
use Aphly\LaravelShop\Models\Common\Country;
use Aphly\LaravelShop\Models\Common\Zone;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $res['list'] = Address::where(['uuid'=>Customer::uuid()])->orderBy('id','desc')->Paginate(config('shop.perPage'))->withQueryString();
        $country_ids = $zone_ids = [];
        foreach ($res['list'] as $val){
            $country_ids[] = $val['country_id'];
            $zone_ids[] = $val['zone_id'];
        }
        $res['country'] = (new Country)->findAllIds($country_ids);
        $res['zone'] = (new Zone)->findAllIds($zone_ids);
        $res['customer'] = Customer::find(Customer::uuid());
        return $this->makeView('laravel-shop::front.customer.address',['res'=>$res]);
    }

    public function save(Request $request){
        $address_id = $request->query('address_id',0);
        if($request->isMethod('post')){
            $input = $request->all();
            if(!$address_id){
                $input['uuid'] = Customer::uuid();
            }
            $address = Address::updateOrCreate(['uuid'=>Customer::uuid(),'id'=>$address_id],$input);
            $default = $request->input('default',0);
            if($default){
                Customer::where(['uuid'=>Customer::uuid()])->update(['address_id'=>$address->id]);
            }else{
                if($address_id == $address->id){
                    Customer::where(['uuid'=>Customer::uuid()])->update(['address_id'=>0]);
                }
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/customer/address']]);
        }else{
            $res['title'] = '';
            $res['country'] = (new Country)->findAll(1);
            $country_keys = array_keys($res['country']);
            $res['info'] = Address::where(['uuid'=>Customer::uuid(),'id'=>$address_id])->firstOrNew();
            if($res['info'] && in_array($res['info']->country_id,$country_keys)){
                $res['zone'] = (new Zone)->findAllByCountry($res['info']->country_id);
            }else{
                $res['zone'] = [];
            }
            $res['customer'] = Customer::find(session('user')['uuid']);
            return $this->makeView('laravel-shop::front.customer.address_form',['res'=>$res]);
        }
    }

    public function remove(Request $request){
        Address::where(['uuid'=>Customer::uuid(),'id'=>$request->id])->delete();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/customer/address']]);
    }

    public function country(Request $request){
        $list = (new Zone)->findAllByCountry($request->id);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>$list]);
    }
}
