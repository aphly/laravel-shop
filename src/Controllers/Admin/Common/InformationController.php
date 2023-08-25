<?php

namespace Aphly\LaravelShop\Controllers\Admin\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Editor;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\NewsCategory;
use Aphly\LaravelShop\Controllers\Admin\Controller;
use Aphly\LaravelShop\Models\Common\Information;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class InformationController extends Controller
{
    public $index_url = '/shop_admin/information/index';

    private $currArr = ['name'=>'信息','key'=>'information'];

    public $imgSize = 1;

    public function index(Request $request)
    {
        $res['search']['title'] = $request->query('title', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Information::when($res['search'],
                            function ($query, $search) {
                                if($search['title']!==''){
                                    $query->where('title', 'like', '%' . $search['title'] . '%');
                                }
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-shop::admin.common.information.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['info'] = Information::where('id',$request->query('id',0))->firstOrNew();
        $res['newsCategoryList'] = NewsCategory::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/shop_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        $res['imgSize'] = $this->imgSize;
        return $this->makeView('laravel-shop::admin.common.information.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $input = $request->all();
        $info = Information::where('id',$id)->first();
        if(!empty($info)){
            $input['content'] = (new Editor)->edit($info->content,$request->input('content'));
            $info->update($input);
        }else{
            $input['content'] =  (new Editor)->add($request->input('content'));
            Information::create($input);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Information::whereIn('id',$post)->get();
            foreach($data as $val){
                (new Editor)->del($val->content);
            }
            Information::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function uploadImg(Request $request){
        $file = $request->file('img');
        if($file){
            $UploadFile = (new UploadFile($this->imgSize));
            try{
                $image = $UploadFile->upload($file,'public/editor_temp/information','local');
            }catch(ApiException $e){
                $err = ["errno"=>$e->code,"message"=>$e->msg];
                return $err;
            }
            $res = ["errno"=>0,"data"=>["url"=>$UploadFile->getPath($image,'local')]];
        }else{
            $res = ["errno"=>1,"data"=>[]];
        }
        return $res;
    }


}
