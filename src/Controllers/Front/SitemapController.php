<?php

namespace Aphly\LaravelShop\Controllers\Front;


use Aphly\LaravelShop\Models\Catalog\Category;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Common\Information;
use Aphly\LaravelShop\Models\Common\InformationCategory;

class SitemapController extends Controller
{
    public function index()
    {
        $res['product_category'] = Category::where('status', 1)->select(['id'])->get();
        $res['product'] = Product::where('status', 1)->where('date_available', '<', time())->select(['id','updated_at'])->get();
        $res['information_category'] = InformationCategory::where('status', 1)->select(['id'])->get();
        $res['information'] = Information::where('status', 1)->select(['id','updated_at'])->get();
        $xml = $this->temp($res);
        return response($xml)->header('Content-Type','application/xml; charset=utf-8');
    }

    function temp($res)
    {
        $date = now()->toDateString();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // 首页
        $xml.= '<url>';
        $xml.= '<loc>'. url('/'). '</loc>';
        $xml.= '<lastmod>'.$date. '</lastmod>';
        $xml.= '<changefreq>daily</changefreq>';
        $xml.= '<priority>0.8</priority>';
        $xml.= '</url>';

        //产品分类
        foreach ($res['product_category'] as $item){
            $xml.= '<url>';
            $xml.= '<loc>'. url("/product?category_id={$item->id}"). '</loc>';
            $xml.= '<lastmod>'.$date.'</lastmod>';
            $xml.= '<changefreq>weekly</changefreq>';
            $xml.= '</url>';
        }

        //产品
        foreach ($res['product'] as $item){
            $xml.= '<url>';
            $xml.= '<loc>'. url("/product/{$item->id}"). '</loc>';
            $xml.= '<lastmod>'. $item->updated_at->format('Y-m-d'). '</lastmod>';
            $xml.= '<changefreq>weekly</changefreq>';
            $xml.= '</url>';
        }

        //文章分类
        foreach ($res['information_category'] as $item){
            $xml.= '<url>';
            $xml.= '<loc>'. url("/information/index?category_id={$item->id}"). '</loc>';
            $xml.= '<lastmod>'.$date.'</lastmod>';
            $xml.= '<changefreq>weekly</changefreq>';
            $xml.= '</url>';
        }

        //文章
        foreach ($res['information'] as $item){
            $xml.= '<url>';
            $xml.= '<loc>'. url("/information/{$item->id}"). '</loc>';
            $xml.= '<lastmod>'. $item->updated_at->format('Y-m-d'). '</lastmod>';
            $xml.= '<changefreq>weekly</changefreq>';
            $xml.= '</url>';
        }

        $xml.= '</urlset>';
        return $xml;
    }
}
