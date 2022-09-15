<?php

namespace Aphly\LaravelShop\Controllers\Front;

use Aphly\LaravelShop\Models\Chapter;
use Aphly\LaravelShop\Models\Novel;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $res['title'] = 'Home index';
        $res['hot']  = Novel::where(['status'=>1,'display'=>1])->orderBy('viewed','desc')->limit(12)->get();
        $res['new']  = Novel::where(['status'=>1,'display'=>1])->orderBy('created_at','desc')->limit(12)->get();
        $res['recommend']  = Novel::where(['status'=>1,'display'=>1,'recommend'=>1])->limit(12)->get();
        $res['update']  = DB::table('novel as n')->leftJoin('novel_chapter as nc','n.id','=','nc.novel_id')
                        ->where(['n.status'=>1,'n.display'=>1,'nc.display'=>1,'nc.status'=>1])
                        ->groupBy('n.id')
                        ->selectRaw('n.*,max(nc.created_at) as nc_created_at')
                        ->orderBy('nc_created_at','desc')->limit(12)->get();
        return $this->makeView('laravel-novel::front.home.index',['res'=>$res]);
    }


}
