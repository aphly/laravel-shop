<?php

namespace Aphly\LaravelShop\Controllers\Front\Common;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\CommonUser;
use Aphly\LaravelShop\Controllers\Front\Controller;
use Aphly\LaravelShop\Models\Common\ContactUs;
use Aphly\LaravelShop\Models\Common\Information;
use Aphly\LaravelShop\Models\Common\InformationCategory;
use Illuminate\Http\Request;

class InformationController extends Controller
{

    function detail(Request $request){
        if($request->isMethod('post')) {
            $input = $request->all();
            $input['uid'] = CommonUser::uid();
            ContactUs::create($input);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }else{
            $res['info'] = Information::where('id',$request->id)->where('status',1)->with('category')->firstOr404();
            $res['info']->content = str_replace('HOSTEMAIL',config('base.email'),
                str_replace('HOSTNAME',config('base.hostname'),$res['info']->content));
            $res['title'] = $res['info']->title;
            return $this->makeView('laravel-shop::front.common.information.detail',['res'=>$res]);
        }
    }

    function index(Request $request){
        $res['search']['title'] = $request->query('title', '');
        $res['search']['category_id'] = $request->query('category_id', '');
        $res['informationCategory'] = InformationCategory::where('status',1)->get()->keyBy('id');
        if(empty($res['informationCategory'][$res['search']['category_id']])){
            throw new ApiException(['code'=>0,'msg'=>'404','data'=>['redirect'=>'/404']]);
        }
        $res['title'] = $res['informationCategory'][$res['search']['category_id']]['name'];
        $res['list'] = Information::when($res['search'],
            function ($query, $search) {
                if($search['title']!==''){
                    $query->where('title', 'like', '%' . $search['title'] . '%');
                }
            })->where('information_category_id',$res['search']['category_id'])->where('status',1)
            ->orderBy('id', 'desc')
            ->Paginate(config('base.perPage'))->withQueryString();
        $res['list']->transform(function ($item){
            $item->content = $this->get_article_summary($item->content,90);
            return $item;
        });
        return $this->makeView('laravel-shop::front.common.information.index',['res'=>$res]);
    }

    function get_article_summary(string $html, int $len = 30): string
    {
        $text = strip_tags($html);
        $text = str_replace(["&nbsp;","\r","\n"], '', $text);
        $text = trim($text);
        if(mb_strlen($text, 'UTF-8') <= $len){
            return $text;
        }
        return mb_substr($text, 0, $len, 'UTF-8') . '…';
    }


}
