<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public static function status($value=null)
    {
        $data = [ 1 => 'Create', 2 => 'View/Download'];
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

    public function student($value='')
    {
        return $this->hasOne('\App\Models\BatchStudent','id','student_id');
    }

    public function batch($value='')
    {
        return $this->hasOne('\App\Models\Batch','id','batch_id');
    }

    public static function batchCertificatePluck($value='')
    {
        return $users = \DB::table('batches')
            ->join('certificates', 'batches.id', '=', 'certificates.batch_id')
            ->select('batches.*')
            ->pluck('slug','slug');
    }

    public static function hardCopy($value=null)
    {
        $data = [ 
            1 => 'Yes',
            2 => 'No'
        ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function certificateHeadings($value=null)
    {
        $data = [ 
            1 => 'Certificate of Achievement',
            2 => 'Certificate of Participation'
        ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function certificateValidities($value='')
    {
        $data = [ 
            1 => 'Date',
            2 => 'No Expiry'
        ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function printingVendor()
    {
        return Vendor::where('status', 3)
                ->where('service', 'like', "%1%")
                ->pluck('name', 'slug');
    }

    public static function id($value='')
    {
        return Certificate::where(['slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return Certificate::where(['id'=>$value])->first()->slug;
    }

}
