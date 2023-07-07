<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taluk extends Model
{
    use HasFactory;
    public function city($value='')
    {
        return $this->hasOne('\App\Models\City','id','city_id')->select('id', 'name', 'slug', 'status', 'state_id')->orderBy('name','asc');
    }

    public function pincode($value='')
    {
        return $this->hasMany('\App\Models\Pincode','taluk_id','id')->select('id', 'pincode', 'slug', 'status','taluk_id');
    }

    public static function talukPluck($city_id=0)
    {
        return Taluk::where(['status'=>1,'city_id'=>$city_id])->pluck('name','slug');
    }
    public static function id($value='')
    {
        return Taluk::where(['status'=>1,'slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return Taluk::where(['status'=>1,'id'=>$value])->first()->slug;
    }
    public static function name($value='')
    {
        return Taluk::where(['status'=>1,'id'=>$value])->first()->name;
    }
}
