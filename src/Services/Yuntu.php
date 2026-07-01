<?php
namespace Aphly\LaravelShop\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Yuntu
{
    public $environment = '';

    const SANDBOX_URL = "https://openapi-sbx.yunexpress.cn";
    const LIVE_URL = 'https://openapi.yunexpress.cn';

    public $appId = 'ec8345f7681a';
    public $appSecret = '58e5bf8df7494ffbab64d18c6ccb9788';
    public $sourceKey = 'exbtkueg';

    function __construct()
    {

    }

    public function generateBaseUrl(): string {
        return ($this->environment == 'LIVE' ? self::LIVE_URL : self::SANDBOX_URL) ;
    }

    function generateSignatureContent($timestamp, $method, $uri, $body = null) {
        $params = [
            'date' => $timestamp,
            'method' => $method,
            'uri' => $uri,
        ];
        if (!empty($body)) {
            $params['body'] = $body;
        }
        ksort($params);
        $signatureContent = http_build_query($params, '', '&');
        return urldecode($signatureContent);
    }

    function generateSha256Signature($data, $key){
        return utf8_encode(base64_encode(hash_hmac('sha256', $data,$key,true)));
    }

    function getToken(){
        return Cache::remember('yuntu_token',3600, function () {
            $url = $this->generateBaseUrl()."/openapi/oauth2/token";
            // 设置body
            $data = array(
                'grantType' => 'client_credentials',
                'appId' => $this->appId,
                'appSecret' => $this->appSecret,
                'sourceKey' => $this->sourceKey
            );
            $jsonData = json_encode($data);
            $ch = curl_init($url);
            $options = array(
                CURLOPT_SSL_VERIFYPEER=>false,
                CURLOPT_SSL_VERIFYHOST=>false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $jsonData,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            );
            curl_setopt_array($ch, $options);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                die('Curl error: ' . $error);
            }
            curl_close($ch);
            $data = json_decode($response, true);
            return $data['accessToken'];
        });
    }

    public function http($method, $uri, $bodyString){
        $url = $this->generateBaseUrl().$uri;
        $timestamp = time() . "000";
        $ch = curl_init($url);
        if($method=='GET'){
            $options = array(
                CURLOPT_SSL_VERIFYPEER=>false,
                CURLOPT_SSL_VERIFYHOST=>false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Accept-Language:en-US',
                    'Content-Type: application/json;charset=utf-8',
                    'token: ' . $this->getToken() ,
                    'date: '  . $timestamp,
                    'sign: ' . $this->generateSha256Signature($this->generateSignatureContent($timestamp, $method, $uri, $bodyString),$this->appSecret)
                ),
            );
        }else{
            $options = array(
                CURLOPT_SSL_VERIFYPEER=>false,
                CURLOPT_SSL_VERIFYHOST=>false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $bodyString,
                CURLOPT_HTTPHEADER => array(
                    'Accept-Language:en-US',
                    'Content-Type: application/json;charset=utf-8',
                    'token: ' . $this->getToken() ,
                    'date: '  . $timestamp,
                    'sign: ' . $this->generateSha256Signature($this->generateSignatureContent($timestamp, $method, $uri, $bodyString),$this->appSecret)
                ),
            );
        }
        //Log::debug(json_encode($options));
        // 应用这些选项到cURL会话
        curl_setopt_array($ch, $options);
        // 执行cURL会话并获取响应
        $response = curl_exec($ch);
        // 检查是否有错误发生
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
        }
        // 关闭cURL会话
        curl_close($ch);
        // 输出响应内容
        Log::debug($response);
        return json_decode($response,true);
    }

    public function createOrder($product_code,$orderInfo,$orderShipping,$orderProduct) {
        $uri = "/v1/order/package/create";
        if($orderInfo->delivery_address_2){
            $address_lines = [
                $orderInfo->delivery_address_1,
                $orderInfo->delivery_address_2?:''
            ];
        }else{
            $address_lines = [
                $orderInfo->delivery_address_1
            ];
        }
        $declaration_info = [];
        foreach ($orderProduct as $val){
            $declaration_info[] = [
                'quantity'=>(int)$val->quantity,
                'unit_price'=>(float)$val->price,
                'unit_weight'=>(float)$val->product->declaration_unit_weight,
                'name_local'=>$val->product->declaration_name_local,
                'name_en'=>$val->product->declaration_name_en,
                'hs_code'=>$val->product->declaration_hs_code,
                'material'=>$val->product->declaration_material,
                'brand'=>$val->product->declaration_brand,
                'remark'=>$val->product->declaration_remark,
            ];
        }
        $bodyString = [
            'product_code'=>$product_code,
            "customer_order_number"=> (string)$orderInfo->id,
//            "weight_unit"=>"KG",
//            "size_unit"=> "CM",
            'packages'=>[
                [
                'weight'=>(float)$orderShipping->weight,
                'length'=>(float)$orderShipping->length,
                'width'=>(float)$orderShipping->width,
                'height'=>(float)$orderShipping->height,
                ]
            ],
            'receiver'=>[
                'first_name'=>$orderInfo->delivery_firstname,
                'last_name'=>$orderInfo->delivery_lastname,
                'country_code'=>$orderInfo->delivery_country_code,
                'province'=>$orderInfo->delivery_zone,
                'city'=>$orderInfo->delivery_city,
                'address_lines'=>$address_lines,
                'postal_code'=>$orderInfo->delivery_postcode,
                'phone_number'=>$orderInfo->delivery_telephone,
                "email"=> $orderInfo->email,
            ],
            'declaration_info'=>$declaration_info,

        ];

        return $this->http("POST",$uri,json_encode($bodyString));
    }

    public function createLabel($order_number) {
        $uri = "/v1/order/label/get?order_number=".$order_number;
        return $this->http("GET",$uri,null);
    }

    public function createTrack($order_number) {
        $uri = "/v1/track-service/info/get?order_number=".$order_number;
        return $this->http("GET",$uri,null);
    }
}
