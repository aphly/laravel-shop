<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\DB;

class CategoryPath extends Model
{
    use HasFactory;
    protected $table = 'shop_category_path';
    protected $primaryKey = ['category_id','path_id'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'category_id','path_id','level'
    ];

    public function add($id,$pid){
        $level = 0;
        $data =  self::where('category_id',$pid)->orderBy('level','asc')->get()->toArray();
        $insertData = [];
        foreach ($data as $val){
            $insertData[] = ['category_id'=>$id,'path_id'=>$val['path_id'],'level'=>$level];
            $level++;
        }
        $insertData[] = ['category_id'=>$id,'path_id'=>$id,'level'=>$level];
        DB::table($this->table)->upsert($insertData, ['category_id', 'path_id']);
    }
}
