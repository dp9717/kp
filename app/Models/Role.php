<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Role extends Model
{
    use HasFactory,SoftDeletes;

    public static function category($value=null)
    {
        $data = [ 1 => 'HO', '2' => 'General' , 3 => 'General 1' , 4 => 'General 2'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function rolePluck($value='')
    {
        return Role::where('status',1)->pluck('name','slug');
    }

    public static function id($value='')
    {
        return Role::where(['status'=>1,'slug'=>$value])->first()->id;
    }
    
}
