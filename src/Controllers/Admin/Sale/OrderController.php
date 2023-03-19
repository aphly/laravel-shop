<?php

namespace Aphly\LaravelShop\Controllers\Admin\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\OrderHistory;
use Aphly\LaravelShop\Models\Sale\OrderProduct;
use Aphly\LaravelShop\Models\Sale\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public $index_url='/shop_admin/order/index';

    public function index(Request $request)
    {
        $res['search']['id'] = $id = $request->query('id',false);
        $res['search']['email'] = $email = $request->query('email',false);
        $res['search']['status'] = $status = $request->query('status',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Order::when($id,
                function($query,$id) {
                    return $query->where('id', $id);
                })->when($email,
                function($query,$email) {
                    return $query->where('email', $email);
                })->when($status,
                function($query,$status) {
                    return $query->where('order_status_id', $status);
                })
            ->with('orderStatus')->orderBy('created_at','desc')->Paginate(config('admin.perPage'))->withQueryString();
        $res['orderStatus'] = OrderStatus::get();
        return $this->makeView('laravel-shop::admin.sale.order.index',['res'=>$res]);
    }

    public function view(Request $request)
    {
        $res['info'] = Order::where(['id'=>$request->query('id',0)])->with('orderStatus')
            ->with(['orderTotal'=>function ($query) {
                $query->orderBy('sort', 'asc');
            }])->firstOrError();
        $res['orderProduct'] = OrderProduct::where('order_id',$res['info']->id)->with('orderOption')->get();
        $res['orderHistory'] = OrderHistory::where('order_id',$res['info']->id)->with('orderStatus')->orderBy('created_at','asc')->get();
        $res['orderStatus'] = OrderStatus::get();
        return $this->makeView('laravel-shop::admin.sale.order.view',['res'=>$res]);
    }

    public function historySave(Request $request)
    {
        $input = $request->all();
        $res['info'] = Order::where(['id'=>$request->input('order_id',0)])->firstOrError();
        $res['info']->addOrderHistory($res['info'], $input['order_status_id'],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/shop_admin/order/view?id='.$res['info']->id]]);
    }

//    public function form(Request $request)
//    {
//        $order_id = $request->query('id',0);
//        $res['order'] = Order::where('id',$order_id)->firstOrNew();
//        return $this->makeView('laravel-shop::admin.sale.order.form',['res'=>$res]);
//    }
//
//    public function save(Request $request){
//        $input = $request->all();
//        $input['date_add'] = $input['date_add']??time();
//        $input['date_start'] = $input['date_start']?strtotime($input['date_start']):0;
//        $input['date_end'] = $input['date_end']?strtotime($input['date_end']):0;
//        Order::updateOrCreate(['id'=>$request->query('id',0)],$input);
//        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
//    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Order::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function download(Request $request)
    {
        $res['search']['id'] = $id = $request->query('id',false);
        $res['search']['email'] = $email = $request->query('email',false);
        $res['search']['status'] = $status = $request->query('status',false);

        $res['list'] = Order::when($id,
            function($query,$id) {
                return $query->where('id', $id);
            })->when($email,
            function($query,$email) {
                return $query->where('email', $email);
            })->when($status,
            function($query,$status) {
                return $query->where('order_status_id', $status);
            })->with('orderHistory')->with('orderShipping')->get();
        $res['orderStatus'] = OrderStatus::get()->keyBy('id')->toArray();
        $header = ["ID", "email", "total_format", "items", "status","paid time",'shipping_id','快递号'];
        $listData = [];
        foreach ($res['list'] as $val) {
            $paid_time = '';
            foreach ($val->orderHistory as $v){
                if($v->order_status_id==2){
                    $paid_time = $v->created_at;
                    break;
                }
            }
            $listData[] = [
                $val->id,$val->email,$val->total_format,$val->items,$res['orderStatus'][$val->order_status_id]['cn_name'],$paid_time,$val->orderShipping->name,''
            ];
        }
        $path = public_path().'/download/';
        File::isDirectory($path) or File::makeDirectory($path, $mode = 0777, true, true);
        $config = ['path' => $path];
        $fileName = date('Y_m_d_H_i_s').'-'.mt_rand(10000,99999).'_export.xlsx';
        $xlsxObject = new \Vtiful\Kernel\Excel($config);
        $filePath = $xlsxObject->fileName($fileName, 'sheet1')->header($header)->data($listData)->output();
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        ob_clean();
        flush();
        if (copy($filePath, 'php://output') === false) {
            // Throw exception
        }
        @unlink($filePath);
    }

    public function shipped(Request $request)
    {
        $file_path = (new UploadFile(5,1,['xlsx']))->upload($request->file('file'), 'private/order/shipped');
        $path = storage_path().'\\app\\'.$file_path;
        if(file_exists($path)){
            $arr = pathinfo($path);
            $config   = ['path' => $arr['dirname']];
            $excel    = new \Vtiful\Kernel\Excel($config);
            $excel->openFile($arr['basename'])->openSheet();
            $i = 1;
            while (($row = $excel->nextRow()) !== NULL) {
                if ($i == 1) {
                    $i++;
                    continue;
                } else {
                    if ($row[0]) {
                        $input['notify']=1;
                        $input['override']=1;
                        $input['shipping_no'] = $row[7];
                        $res['info'] = Order::where(['id'=>$row[0]])->whereIn('order_status_id',[2,3])->first();
                        if(!empty($res['info'])){
                            $res['info']->addOrderHistory($res['info'], 3,$input);
                        }
                    }
                }
            }
            $excel->close();
            @unlink($path);
        }
        throw new ApiException(['code'=>0,'msg'=>'操作成功']);
    }

}
