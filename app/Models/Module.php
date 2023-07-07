<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Module extends Model
{
    use HasFactory,SoftDeletes;

    public static function status($value=null)
    {
        $data = [ 1 => 'Active', '2' => 'Inactive'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function id($value='')
    {
        return Module::where(['slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return Module::where(['id'=>$value])->first()->slug;
    }

    public static function moduleAry($value='')
    {
        return Module::where('id',$value)->select('name', 'duration', 'description', 'status', 'slug')->first();
    }

    public function batch() {
        return $this->hasMany('\App\Models\Batch','module_id','id');
    }
}
