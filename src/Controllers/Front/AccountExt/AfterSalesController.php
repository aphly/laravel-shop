<?php

namespace Aphly\LaravelShop\Controllers\Front\AccountExt;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\CommonUploadFile;
use Aphly\Laravel\Models\CommonUser;
use Aphly\Laravel\Models\RemoteEmail;
use Aphly\LaravelShop\Controllers\Front\Controller;

use Aphly\LaravelShop\Models\Sale\AfterSales;
use Aphly\LaravelShop\Models\Sale\AfterSalesHistory;
use Aphly\LaravelShop\Models\Sale\AfterSalesImage;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderHistory;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Setting\Config;
use Illuminate\Http\Request;

class AfterSalesController extends Controller
{
    public function index()
    {
        $res['list'] = AfterSales::where(['uid'=>CommonUser::uid()])->where('delete_at',0)->with('order')
            ->orderBy('created_at','desc')->Paginate(config('base.perPage'))->withQueryString();
        $res['title'] = 'My After Sales';
        return $this->makeView('laravel-shop::front.account_ext.after_sales.index',['res'=>$res]);
    }

    public function detail(Request $request){
        $res['info'] = AfterSales::where(['uid'=>CommonUser::uid(),'id'=>$request->query('id',0)])->where('delete_at',0)->with('img')->firstOr404();
        $res['orderInfo'] = Order::where(['uid'=>CommonUser::uid(),'id'=>$res['info']->order_id])->where('delete_at',0)->firstOr404();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['info']->order_id)->with('orderOption')->get();
        $res['title'] = 'After Sales Detail';
        $res['afterSalesHistory'] = AfterSalesHistory::where('after_sales_id',$res['info']->id)->orderBy('created_at','asc')->get();
        foreach ($res['info']->img as $val){
            $val->image_src = CommonUploadFile::getPath($val->image,$val->disk);
        }
        return $this->makeView('laravel-shop::front.account_ext.after_sales.detail',['res'=>$res]);
    }

    public function form(Request $request){
        $res['title'] = 'After Sales Form';
        $res['orderInfo'] = Order::where(['uid'=>CommonUser::uid(),'id'=>$request->query('order_id',0)])->where('delete_at',0)->firstOr404();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['orderInfo']->id)->with('orderOption')->get();
        $res['info'] = AfterSales::where('id',$request->query('id',0))->with('product')->firstOrNew();
        return $this->makeView('laravel-shop::front.account_ext.after_sales.form',['res'=>$res]);
    }

    public function save(Request $request){
        $shop_config = Config::findAll();
        $res['orderInfo'] = Order::where(['uid'=>CommonUser::uid(),'id'=>$request->query('order_id',0)])->where('delete_at',0)->firstOr404();
        $info = AfterSales::where(['uid'=>CommonUser::uid(),'order_id'=>$request->query('order_id',0)])->where('delete_at',0)->first();
        if(!empty($info)){
            throw new ApiException(['code'=>0,'msg'=>'After-sales service has been requested for this order.']);
        }
        if($res['orderInfo']->order_status_id==3){
            $orderHistory = OrderHistory::where(['order_status_id'=>2,'order_id'=>$res['orderInfo']->id])->firstOrError();
            if($orderHistory->created_at->timestamp+365*24*3600<time()){
                throw new ApiException(['code'=>2,'msg'=>'The after-sales period has expired.']);
            }
            $insertData = $file_paths =  [];
            $UploadFile = new CommonUploadFile(1);
            if($request->hasFile("files")){
                $file_paths = $UploadFile->uploads(4,$request->file("files"), 'public/shop/after_sales');
            }
            $input = $request->all();
            $input['uid'] = CommonUser::uid();
            $input['id'] = app('Snowflake')->nextId();
            $info = AfterSales::create($input);
            if($info->save()){
                foreach ($file_paths as $v){
                    $insertData[] = ['after_sales_id'=>$info->id,'image'=>$v,'disk'=>$UploadFile->disk()];
                }
                if ($insertData) {
                    AfterSalesImage::insert($insertData);
                }
                AfterSalesHistory::create([
                    'after_sales_id'=>$info->id,
                    'uid'=>CommonUser::uid(),
                    'content'=>$input['content']??'',
                ]);
                $res['orderInfo']->addOrderHistory($info->order, 4);
                $notify = trim($shop_config['after_sales_email']);
                if($notify){
                    (new RemoteEmail())->send([
                        'email'=>$notify,
                        'title'=>'After-sales from '.$res['orderInfo']->email,
                        'content'=>$input['content'],
                    ]);
                }
            }
            throw new ApiException(['code'=>0,'msg'=>'Success','data'=>['redirect'=>'/account_ext/after_sales']]);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'Order error']);
        }

    }

    public function del(Request $request){
        $info = AfterSales::where(['uid'=>CommonUser::uid(),'id'=>$request->query('id',0)])->where('status',1)->first();
        if(!empty($info)){
            $info->update(['delete_at'=>time()]);
            throw new ApiException(['code'=>0,'msg'=>'Delete success','data'=>['redirect'=>'/account_ext/after_sales']]);
        }
        throw new ApiException(['code'=>1,'msg'=>'Delete fail']);
    }

    public function saveHistory(Request $request){
        $id = $request->query('id',0);
        $info = AfterSales::where(['uid'=>CommonUser::uid(),'id'=>$id,'status'=>0])->where('delete_at',0)->first();
        if(!empty($info)){
            $input = $request->all();
            AfterSalesHistory::create([
                'after_sales_id'=>$info->id,
                'uid'=>CommonUser::uid(),
                'content'=>$input['content']??'',
            ]);
            throw new ApiException(['code'=>0,'msg'=>'Success','data'=>['redirect'=>'/account_ext/after_sales/detail?id='.$id]]);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'fail']);
        }
    }

}
