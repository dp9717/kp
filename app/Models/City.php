<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public function state($value='')
    {
        return $this->hasOne('\App\Models\State','id','state_id')->select('id', 'name', 'slug', 'status')->orderBy('name','asc');
    }
    public function taluk($value='')
    {
        return $this->hasMany('\App\Models\Taluk','city_id','id')->select('id', 'name', 'slug', 'status','city_id')->orderBy('name','asc');
    }

    public static function cityPluck($state_id=0)
    {
        return City::where(['status'=>1,'state_id'=>$state_id])->pluck('name','slug');
    }

    public static function id($value='')
    {
        return City::where(['status'=>1,'slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return City::where(['status'=>1,'id'=>$value])->first()->slug;
    }
    public static function name($value='')
    {
        return City::where(['status'=>1,'id'=>$value])->first()->name;
    }
}