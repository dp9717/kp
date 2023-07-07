<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CentreCreation extends Model
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

    public static function centreHead($value='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q){
            $q->where('role_id',4);
        })->pluck('name','slug');
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
        return $this->hasMany('\App\Models\CentreCreationFile','centre_creation_id','id');
    }

    public static function id($value='')
    {
        return CentreCreation::where(['slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return CentreCreation::where(['id'=>$value])->first()->slug;
    }

    public static function centreAry($value='')
    {
        return CentreCreation::where('id',$value)->select('name', 'contact', 'email', 'address', 'state_id', 'city_id', 'taluk_id', 'pincode_id', 'full_address', 'additional_information', 'slug', 'status', 'centre_head_id', 'centre_head_ary')->first();
    }

    public static function authUserByStatus($status='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q) use ($status){
            $q->whereHas('permission',function($r) use ($status){
                $r->where(['status_id'=>$status,'process_id'=>2]);
            });
        })->pluck('name','slug');
    }

    public function batch() {
        return $this->hasMany('\App\Models\Batch', 'location_id','id');
    }
} 
