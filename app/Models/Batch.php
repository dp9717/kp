<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Batch extends Model
{
    use HasFactory,SoftDeletes;
    public static function status($value=null)
    {
        $data = [ 1 => 'Pending', 2 => 'Reject' , 3 => 'State Head Approved', 4 => 'HO Admin Approved', 5 => 'Approved' ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function statusAssign($value=null)
    {
        $data = [ 1 , 3 , 4, 5 ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function statusApprovalArray($status=null)
    {
         $data = [ 2 => 'Reject' , $status => 'Approved'];
         return $data;
    }
    public static function adminSstatusApprovalArray($status=null)
    {
         $data = [ 2 => 'Reject', $status => 'Approved'];
         return $data;
    }

    public function file($value='')
    {
        return $this->hasMany('\App\Models\BatchFile','batch_id','id');
    }

    public static function id($value='')
    {
        return Batch::where(['slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return Batch::where(['id'=>$value])->first()->slug;
    }

    public function project($value='')
    {
        return $this->hasOne('\App\Models\Project','id','project_id');
    }

    public function trainer($value='')
    {
        return $this->hasOne('\App\Models\User','id','trainer_id');
    }
    public function location($value='')
    {
        return $this->hasOne('\App\Models\CentreCreation','id','location_id');
    }

    public function stateCoOrdinator($value='')
    {
        return $this->hasOne('\App\Models\User','id','state_co_ordinator_id');
    }

    public static function projects($value='')
    {
        return Project::where(['status'=>count(\App\Models\Project::status())])->pluck('name','slug');
    }

    public static function trainers($value='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q){
            $q->where('role_id',7);
        })->pluck('name','slug');
    }

    public static function locations($value='')
    {
        return CentreCreation::where(['status'=>count(\App\Models\CentreCreation::status())])->pluck('name','slug');
    }

    public static function stateCoOrdinators($value='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q){
            $q->where('role_id',10);
        })->pluck('name','slug');
    }

    public static function modules($value='')
    {
        return Module::where('status',1)->pluck('name','slug');
    }

    public function students($value='')
    {
        return $this->hasMany('\App\Models\BatchStudent','batch_id','id');
    }

    public static function batchAttendencePluck($value='')
    {
        return $users = \DB::table('batches')
            ->join('attendences', 'batches.id', '=', 'attendences.batch_id')
            ->select('batches.*')
            ->pluck('slug','slug');
    }

    public static function batchAssesmentPluck($value='')
    {
        return $users = \DB::table('batches')
            ->join('assesments', 'batches.id', '=', 'assesments.batch_id')
            ->select('batches.*')
            ->pluck('slug','slug');
    }

    public static function batchAttendenceStPluck($bid='')
    {
        return BatchStudent::where(['batch_id'=>$bid])->pluck('name','slug');
    }

    public static function batchAssesmentStPluck($bid='')
    {
        return BatchStudent::where(['batch_id'=>$bid])->pluck('name','slug');
    }

    public static function batchCertificateStPluck($bid='')
    {
        return BatchStudent::where(['batch_id'=>$bid])->pluck('name','slug');
    }

    public static function authUserByStatus($status='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q) use ($status){
            $q->whereHas('permission',function($r) use ($status){
                $r->where(['status_id'=>$status,'process_id'=>3]);
            });
        })->pluck('name','slug');
    }
}

