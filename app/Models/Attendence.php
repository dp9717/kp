<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    use HasFactory;
    public static function status($value=null)
    {
        $data = [ 1 => 'Create', 2 => 'Update'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
    public static function statusAssign($value=null)
    {
        $data = [ 1 , 2 ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function batchPluck($value='')
    {
        return Batch::where(['status'=>count(\App\Models\Batch::status())])->pluck('slug','slug');
    } 

    public static function attendenceAry($value=null)
    {
        $data = [ 1 => 'Present', 2 => 'Absent' ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public function attStudent($value='')
    {
        return $this->hasMany('\App\Models\AttendenceStudent','attendence_id','id');
    }

    public function batch($value='')
    {
        return $this->hasOne('\App\Models\Batch','id','batch_id');
    }

    public static function calPercent($att='',$days=0)
    {
        if ($days != 0) {
            $percent = $att / $days * 100;
        } else {
            $percent = 0;
        }
        return round($percent,2);
    }

    public static function totAttendence($value=0,$st=0)
    {
        return AttendenceStudent::where(['attendence_id'=>$value,'attendence'=>$st])->count();
    }
}
