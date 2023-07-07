<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model
{
    use HasFactory,SoftDeletes;
    public static function status($value=null)
    {
        $data = [ 1 => 'Pending', 2 => 'Reject' , 3 => 'Approved' ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function statusAssign($value=null)
    {
        $data = [ 1 , 3 ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function statusApprovalArray($status=null)
    {
        //CentreCreation::status();
         $data = [ 1 => 'Pending', 2 => 'Reject' , 3 => 'Approved' ];
         if ($status) {
             for ($i=1; $i < ($status+1); $i++) { 
                 if($i!=2) unset($data[$i]);
             }
         }
         return $data;
    }

    public function file($value='')
    {
        return $this->hasMany('\App\Models\ProjectFile','project_id','id');
    }

    public static function fundedby($value=null)
    {
        $data = [ 1 => 'Gov', 2 => 'Pvt' , 3 => 'Other' ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
    public static function mouSigned($value=null)
    {
        $data = [ 'yes' => 'Yes', 'no' => 'No' ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function pjManager($value='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q){
            $q->where('role_id',3);
        })->pluck('name','slug');
    }

    public static function pjStateHead($value='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q){
            $q->where('role_id',4);
        })->pluck('name','slug');
    }

    public static function pjRegionalHead($value='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q){
            $q->where('role_id',10);
        })->pluck('name','slug');
    }

    public static function centre($value='')
    {
        return CentreCreation::where('status',count(CentreCreation::status()))->pluck('name','slug');
    }
 
    public static function partner($value='')
    {
        return Partner::where('status',count(\App\Models\Partner::status()))->pluck('name','slug');
    }

    public function partners($value='')
    {
        return $this->hasMany('\App\Models\ProjectPartner','project_id','id');
    }

    public function centres($value='')
    {
        return $this->hasMany('\App\Models\ProjectCentreCreation','project_id','id');
    }

    public function stateHead($value='')
    {
        return $this->hasMany('\App\Models\ProjectStateHead','project_id','id');
    }

    public function regHead($value='')
    {
        return $this->hasMany('\App\Models\ProjectRegionalHead','project_id','id');
    }

    public function manager($value='')
    {
        return $this->hasOne('\App\Models\User','id','project_manager_id');
    }

    public static function id($value='')
    {
        return Project::where(['slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return Project::where(['id'=>$value])->first()->slug;
    }

    public static function projectAry($value='')
    {
        return Project::where('id',$value)->select('name', /*'duration',*/ 'funded_by', 'mou_signed', 'mou_start_date', 'mou_end_date', 'target_number', 'est_fund_value', 'additional_information', 'slug', 'status')->first();
    }

    public static function authUserByStatus($status='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q) use ($status){
            $q->whereHas('permission',function($r) use ($status){
                $r->where(['status_id'=>$status,'process_id'=>1]);
            });
        })->pluck('name','slug');
    }
}
