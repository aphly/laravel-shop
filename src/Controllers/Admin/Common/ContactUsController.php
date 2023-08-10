<?php

namespace Aphly\LaravelShop\Controllers\Admin\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Editor;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\RemoteEmail;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Common\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public $index_url = '/shop_admin/contact_us/index';

    private $currArr = ['name'=>'联系我们','key'=>'contact_us'];

    public $imgSize = 1;

    public function index(Request $request)
    {
        $res['search']['email'] = $request->query('email', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = ContactUs::when($res['search'],
                            function ($query, $search) {
                                if($search['email']!==''){
                                    $query->where('email', 'like', '%' . $search['email'] . '%');
                                }
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.common.contact_us.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['info'] = ContactUs::where('id',$request->query('id',0))->firstOrNew();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        $res['imgSize'] = $this->imgSize;
        return $this->makeView('laravel-shop::admin.common.contact_us.detail',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $input = $request->all();
        $info = ContactUs::where('id',$id)->first();
        if(!empty($info)){
            $input['content'] = (new Editor)->edit($info->content,$request->input('content'));
            $info->update($input);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = ContactUs::whereIn('id',$post)->get();
            foreach($data as $val){
                (new Editor)->del($val->content);
            }
            ContactUs::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function reply(Request $request)
    {
        $input = $request->all();
        $input['email'] = trim($input['email']);
        if($input['email'] && $input['content']){
            (new RemoteEmail())->send([
                'email'=>$input['email'],
                'title'=>$input['title'],
                'content'=>$input['content'],
                'type'=>config('common.email_type'),
                'queue_priority'=>0,
                'is_cc'=>0
            ]);
        }
        throw new ApiException(['code'=>0,'msg'=>'send ok','data'=>[]]);
    }

}
