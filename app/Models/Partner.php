<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Partner extends Model
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
        return $this->hasMany('\App\Models\PartnerFile','partner_id','id');
    }

    public static function id($value='')
    {
        return Partner::where(['slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return Partner::where(['id'=>$value])->first()->slug;
    }

    public function projectPartner($value='')
    {
        return $this->hasMany('\App\Models\ProjectPartner','partner_id','id');
    }

    public static function authUserByStatus($status='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q) use ($status){
            $q->whereHas('permission',function($r) use ($status){
                $r->where(['status_id'=>$status,'process_id'=>5]);
            });
        })->pluck('name','slug');
    }
}
