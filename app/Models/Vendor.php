<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Vendor extends Model
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
        return $this->hasMany('\App\Models\VendorFile','vendor_id','id');
    }

    public static function services($value=null)
    {
        $data = [ 1 => 'Priting', 2 => 'Electrician Reparis' , 3 => 'Carpentary',4=>'IT Hardware',5=>'IT Software',6=>'Stationery',7=>'Transports',8=>'Ticketing',9=>'Others' ];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function vendorAry($value='')
    {
        return Vendor::where('id',$value)->select('id', 'name', 'gst', 'pan', 'address', 'state_id', 'city_id', 'taluk_id', 'pincode_id', 'full_address', 'additional_information', 'slug', 'poc', 'contact_from', 'contact_to', 'service')->first();
    }

    public static function id($value='')
    {
        return Vendor::where(['slug'=>$value])->first()->id;
    }

    public static function slug($value='')
    {
        return Vendor::where(['id'=>$value])->first()->slug;
    }

    public static function authUserByStatus($status='')
    {
        return User::where(['status'=>1,'is_admin'=>1])->whereHas('userRole',function($q) use ($status){
            $q->whereHas('permission',function($r) use ($status){
                $r->where(['status_id'=>$status,'process_id'=>4]);
            });
        })->pluck('name','slug');
    }
}