<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    public function city($value='')
    {
        return $this->hasMany('\App\Models\City','state_id','id')->select('id', 'name', 'slug', 'status', 'state_id')->orderBy('name','asc');
    }

    public static function statePluck($value='')
    {
        return State::where('status',1)->pluck('name','slug');
    }

    public static function id($value='')
    {
        return State::where(['status'=>1,'slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return State::where(['status'=>1,'id'=>$value])->first()->slug;
    }

    public static function name($value='')
    {
        return State::where(['status'=>1,'id'=>$value])->first()->name;
    }
}
