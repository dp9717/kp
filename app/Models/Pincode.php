<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    use HasFactory;
    public function taluk($value='')
    {
        return $this->hasOne('\App\Models\Taluk','id','taluk_id')->select('id', 'name', 'slug', 'status', 'city_id')->orderBy('name','asc');
    }

    public static function pincodePluck($taluk_id='')
    {
        return Pincode::where(['status'=>1,'taluk_id'=>$taluk_id])->pluck('pincode','slug');
    }

    public static function fullAddress($value='',$address='')
    {
        $data = Pincode::with('taluk','taluk.city','taluk.city.state')->where(['status'=>1,'slug'=>$value])->first();
        if ($data) {
            return [
                    'address'=>$address,
                    'taluk'=>$data->taluk->name ?? '',
                    'city'=>$data->taluk->city->name ?? '',
                    'state'=>$data->taluk->city->state->name ?? '',
                    'pincode'=>$data->pincode ?? ''
            ];
        }else{
            return [
                    'address'=>'',
                    'taluk'=>'',
                    'city'=>'',
                    'state'=>'',
                    'pincode'=>''
            ];
        }
        
    }

    public static function id($value='')
    {
        return Pincode::where(['status'=>1,'slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return Pincode::where(['status'=>1,'id'=>$value])->first()->slug;
    }
}
