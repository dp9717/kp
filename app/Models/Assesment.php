<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Assesment extends Model
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

    public static function grade($value=null)
    {
        $data = [ -1 => 'None', 1 => 'A', 2 => 'B',3 =>'C',4 =>'D',5 =>'E'];
        if ($value) {
            return $data[$value];
        }else{
            $dt = Arr::except($data,[-1]);
            return $dt;
        }
    }
    public static function gradeView($value=null)
    {
        $data = [  1 => 'A', 2 => 'B',3 =>'C',4 =>'D',5 =>'E',-1 => 'None',];
        if ($value) {
            return $data[$value];
        }else{
            $dt = $data;
            return $dt;
        }
    }

    public function attStudent($value='')
    {
        return $this->hasMany('\App\Models\AssesmentStudent','assesment_id','id');
    }

    public function batch($value='')
    {
        return $this->hasOne('\App\Models\Batch','id','batch_id');
    }

    public static function totGrade($assId=0,$grade=0)
    {
        return AssesmentStudent::where(['assesment_id'=>$assId,'grade'=>$grade])->count();
    }
}
