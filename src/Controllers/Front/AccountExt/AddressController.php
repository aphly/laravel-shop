<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\Laravel\Requests\FormRequest;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Setting\Country;
use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelShop\Models\Account\UserAddress;
use Aphly\LaravelShop\Models\Setting\Zone;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $res['title'] = '';
        $res['list'] = UserAddress::where(['uid'=>CommonUser::uid()])->orderBy('id','desc')->Paginate(config('base.perPage'))->withQueryString();
        $country_ids = $zone_ids = [];
        foreach ($res['list'] as $val){
            $country_ids[] = $val['country_id'];
            $zone_ids[] = $val['zone_id'];
        }

        $res['country'] = (new Country)->findAllIds($country_ids);
        $res['zone'] = (new Zone)->findAllIds($zone_ids);
        return $this->makeView('laravel-shop::front.account_ext.address.index',['res'=>$res]);
    }

    public function save(FormRequest $request){
        $address_id = $request->query('address_id',0);
        if($request->isMethod('post')){
            $count = UserAddress::where(['uid'=>CommonUser::uid()])->count();
            if($count>=5){
                throw new ApiException(['code'=>0,'msg'=>'limit 5','data'=>['redirect'=>'/account_ext/address']]);
            }
            $input = $request->all();
            $request->validate($input,[
                'firstname' => 'required|between:2,32',
                'lastname' => 'required|between:2,32',
                'address_1' => 'required|between:2,255',
                'city' => 'required|between:2,128',
                'postcode' => 'required|numeric',
                'telephone' => 'required|numeric',
                'country_id' => 'required|numeric',
                'zone_id' => 'required|numeric',
            ]);
            if(!(new Order())->checkPostcode($input['postcode'],$input['country_code'])){
                throw new ApiException(['code'=>11000,'msg'=>'Postcode Code','data'=>['postcode'=>['The postal code format is incorrect']]]);
            }
            if(!$address_id){
                $input['uid'] = CommonUser::uid();
            }
            $input['default'] = isset($input['default'])?1:0;
            if($input['default']){
                UserAddress::where('uid',CommonUser::uid())->update(['default'=>0]);
            }
            UserAddress::updateOrCreate(['uid'=>CommonUser::uid(),'id'=>$address_id],$input);
//            if($default){
//                $this->user->update(['address_id'=>$address->id]);
//            }else{
//                if($address_id == $address->id){
//                    $this->user->update(['address_id'=>0]);
//                }
//            }
            $checkout = $request->query('checkout',0);
            if($checkout){
                throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>(new UserAddress)->getAddresses()]]);
            }else{
                throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/account_ext/address']]);
            }
        }else{
            $res['title'] = '';
            $res['country'] = (new Country)->findAll();
            $country_keys = array_keys($res['country']);
            $res['info'] = UserAddress::where(['uid'=>CommonUser::uid(),'id'=>$address_id])->firstOrNew();
            if($res['info'] && in_array($res['info']->country_id,$country_keys)){
                $res['zone'] = (new Zone)->findAllByCountry($res['info']->country_id);
            }else{
                $res['zone'] = [];
            }
            return $this->makeView('laravel-shop::front.account_ext.address.form',['res'=>$res]);
        }
    }

    public function remove(Request $request){
        UserAddress::where(['uid'=>CommonUser::uid(),'id'=>$request->id])->delete();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/account_ext/address']]);
    }

    public function country(Request $request){
        $list = (new Zone)->findAllByCountry($request->id);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>$list]);
    }
}
