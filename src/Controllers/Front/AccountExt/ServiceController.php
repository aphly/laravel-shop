<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelPayment\Models\PaymentRefund;
use Aphly\LaravelShop\Controllers\Front\Controller;

use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderHistory;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Sale\Service;
use Aphly\LaravelShop\Models\Sale\ServiceHistory;
use Aphly\LaravelShop\Models\Sale\ServiceImage;
use Aphly\LaravelShop\Models\Sale\ServiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $res['list'] = Service::where(['uuid'=>User::uuid()])->where('delete_at',0)->with('product')->with('order')
            ->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        $res['title'] = 'Service';
        return $this->makeView('laravel-shop-front::account_ext.service.index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = Service::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->where('delete_at',0)->with('order')->with('img')->firstOr404();
        $res['title'] = 'Service Detail';
        $res['serviceHistory'] = ServiceHistory::where('service_id',$res['info']->id)->orderBy('created_at','asc')->get();
        $res['serviceProduct'] = ServiceProduct::where('service_id',$res['info']->id)->with(['orderProduct'=>function ($query){
            return $query->with(['orderOption']);
        }])->get();
        $res['orderRefund'] = PaymentRefund::where(['payment_id'=>$res['info']->order->payment_id,'status'=>2])->get();
        foreach ($res['info']->img as $val){
            $val->image_src = UploadFile::getPath($val->image,$val->remote);
        }
        return $this->makeView('laravel-shop-front::account_ext.service.detail',['res'=>$res]);
    }

    public function service_pre($request){
        $res['orderInfo'] = Order::where(['uuid'=>User::uuid(),'id'=>$request->query('order_id',0)])->where('delete_at',0)->firstOr404();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['orderInfo']->id)->with('orderOption')->get()->keyBy('id');
        return $res;
    }

    public function form(Request $request){
        $res = $this->service_pre($request);
        $total_all = $res['orderInfo']->total*(100-$this->shop_setting['service_refund_fee'])/100;
        list($refund_amount,$res['refund_amount_format']) = Currency::codeFormat($total_all,$res['orderInfo']->currency_code);
        $res['info'] = Service::where('id',$request->query('id',0))->with('product')->firstOrNew();
        return $this->makeView('laravel-shop-front::account_ext.service.form',['res'=>$res]);
    }

    public function save(Request $request){
        $info = Service::where(['uuid'=>User::uuid(),'order_id'=>$request->query('order_id',0)])->where('delete_at',0)->first();
        if(!empty($info)){
            throw new ApiException(['code'=>0,'msg'=>'Orders have been requested for after-sales','data'=>['redirect'=>'/account_ext/service']]);
        }else{
            $res = $this->service_pre($request);
            if($res['orderInfo']->order_status_id==3){
                $orderHistory = OrderHistory::where(['order_status_id'=>2,'order_id'=>$res['orderInfo']->id])->firstOrError();
                if($orderHistory->created_at->timestamp+180*24*3600<time()){
                    throw new ApiException(['code'=>2,'msg'=>'After-sales time has expired'.$orderHistory->created_at,'data'=>['redirect'=>'/account_ext/service']]);
                }
                $insertData = $file_paths =  [];
                $UploadFile = new UploadFile(1);
                if($request->hasFile("files")){
                    $file_paths = $UploadFile->uploads(4,$request->file("files"), 'public/shop/service');
                }
                $input = $request->all();
                $input['uuid'] = User::uuid();
                $info = Service::create($input);
                $info->addServiceHistory($info,1);
                $service_product_arr = [];
                $total_all = 0;
                if(!empty($input['order_product'])){
                    foreach ($res['orderProduct'] as $val){
                        if(isset($input['order_product'][$val['id']])){
                            $order_product_id = $val['id'];
                            $quantity = max($input['order_product'][$val['id']],0);
                            $quantity = min($quantity,$val['quantity']);
                            if($quantity){
                                $total = $val['real_total']*$quantity/$val['quantity'];
                                list($total,$total_format) = Currency::codeFormat($total,$res['orderInfo']->currency_code);
                                $service_product_arr[] = [
                                    'service_id'=>$info->id,
                                    'order_product_id'=>$order_product_id,
                                    'quantity'=>$quantity,
                                    'total'=>$total,
                                    'total_format'=>$total_format
                                ];
                                $total_all += $total;
                            }
                        }
                    }
                }else{
                    foreach ($res['orderProduct'] as $val){
                        $service_product_arr[] = [
                            'service_id'=>$info->id,
                            'order_product_id'=>$val->id,
                            'quantity'=>$val->quantity,
                            'total'=>$val->total,
                            'total_format'=>$val->total_format
                        ];
                        $total_all += $val->total;
                    }
                }
                if($info->service_action_id==2){
                    $total_all = $total_all*(100-$this->shop_setting['service_return_fee'])/100;
                }else if($info->service_action_id==1){
                    $total_all = $res['orderInfo']->total*(100-$this->shop_setting['service_refund_fee'])/100;
                }
                list($refund_amount,$refund_amount_format) = Currency::codeFormat($total_all,$res['orderInfo']->currency_code);
                $info->refund_amount = $refund_amount;
                $info->refund_amount_format = $refund_amount_format;
                if($info->save()){
                    ServiceProduct::insert($service_product_arr);
                }
                foreach ($file_paths as $v){
                    $insertData[] = ['service_id'=>$info->id,'image'=>$v,'remote'=>$UploadFile->isRemote()];
                }
                if ($insertData) {
                    ServiceImage::insert($insertData);
                }
                throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/account_ext/service']]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'order error']);
            }
        }
    }

    public function del(Request $request){
        $info = Service::where(['uuid'=>User::uuid(),'id'=>$request->query('id',0)])->whereIN('service_status_id',[1,2])->first();
        if(!empty($info)){
            $info->update(['delete_at'=>time()]);
            throw new ApiException(['code'=>0,'msg'=>'Delete success','data'=>['redirect'=>'/account_ext/service']]);
        }
        throw new ApiException(['code'=>1,'msg'=>'Delete fail']);
    }

    public function returnExchange3(Request $request){
        $input = $request->all();
        $info = Service::where(['uuid'=>User::uuid(),'id'=>$input['service_id']])->firstOrError();
        $info->addServiceHistory($info,4,$input);
        throw new ApiException(['code'=>0,'msg'=>'Request success','data'=>['redirect'=>'/account_ext/service/detail?id='.$info->id]]);
    }

    public function returnExchange4(Request $request){
        $input = $request->all();
        $info = Service::where(['uuid'=>User::uuid(),'id'=>$input['service_id']])->firstOrError();
        $info->c_shipping = $input['c_shipping'];
        $info->c_shipping_no = $input['c_shipping_no'];
        $info->save();
        throw new ApiException(['code'=>0,'msg'=>'Request success','data'=>['redirect'=>'/account_ext/service/detail?id='.$info->id]]);
    }



}
