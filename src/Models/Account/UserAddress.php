<?php

namespace Aphly\LaravelShop\Models\Account;

use Aphly\LaravelShop\Models\Setting\Country;
use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelShop\Models\Setting\Zone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = 'shop_user_address';

    protected $fillable = [
        'uid','firstname','lastname','address_1','address_2','city','postcode','country_id','zone_id','telephone','default','country_code'
    ];


    public function getAddress($address_id) {
        $info = self::where(['id'=>$address_id,'uid'=>CommonUser::uid()])->first();
        if(!empty($info)){
            $country = (new Country)->findAll();
            $zone = (new Zone)->findAll();
            return [
                'id'     		 => $info['id'],
                'firstname'      => $info['firstname'],
                'lastname'       => $info['lastname'],
                'company'        => $info['company'],
                'address_1'      => $info['address_1'],
                'address_2'      => $info['address_2'],
                'postcode'       => $info['postcode'],
                'city'           => $info['city'],
                'zone_id'        => $info['zone_id'],
                'zone_name'      => $zone[$info['zone_id']]['name']??'',
                'zone_code'      => $zone[$info['zone_id']]['code']??'',
                'country_id'     => $info['country_id'],
                'country_name'   => $country[$info['country_id']]['name']??'',
                'country_code'   => $country[$info['country_id']]['iso_code_2']??'',
                'iso_code_2'     => $country[$info['country_id']]['iso_code_2']??'',
                'iso_code_3'     => $country[$info['country_id']]['iso_code_3']??'',
                'address_format' => $country[$info['country_id']]['address_format']??'',
                'telephone'      => $info['telephone']??'',
                'default'        => $info['default']??0,
            ];
        }else{
            return [];
        }
    }

    public function getAddresses($uid = false,$limit=0) {
        $uid = $uid?:CommonUser::uid();
        $address_data = [];
        if($limit){
            $data = self::where(['uid'=>$uid])->orderBy('default','desc')->limit($limit)->get()->toArray();
        }else{
            $data = self::where(['uid'=>$uid])->orderBy('default','desc')->get()->toArray();
        }
        $country = (new Country)->findAll();
        $zone = (new Zone)->findAll();
        foreach ($data as $v){
            $address_data[] = [
                'id'     		 => $v['id'],
                'firstname'      => $v['firstname'],
                'lastname'       => $v['lastname'],
                'address_1'      => $v['address_1'],
                'address_2'      => $v['address_2'],
                'postcode'       => $v['postcode'],
                'city'           => $v['city'],
                'zone_id'        => $v['zone_id'],
                'zone_name'      => $zone[$v['zone_id']]['name']??'',
                'zone_code'      => $zone[$v['zone_id']]['code']??'',
                'country_id'     => $v['country_id'],
                'country_name'   => $country[$v['country_id']]['name']??'',
                'country_code'   => $country[$v['country_id']]['iso_code_2']??'',
                'iso_code_2'     => $country[$v['country_id']]['iso_code_2']??'',
                'iso_code_3'     => $country[$v['country_id']]['iso_code_3']??'',
                'address_format' => $country[$v['country_id']]['address_format']??'',
                'telephone'      => $v['telephone']??'',
                'default'        => $v['default']??0,
            ];
        }
        return $address_data;
    }
}
