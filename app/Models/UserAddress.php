<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    public function userState($value='')
    {
        return $this->hasOne('\App\Models\State','id','state_id');
    }

    public function userCity($value='')
    {
        return $this->hasOne('\App\Models\City','id','city_id');
    }

    public function userTaluk($value='')
    {
        return $this->hasOne('\App\Models\Taluk','id','taluk_id');
    }

    public function userPincode($value='')
    {
        return $this->hasOne('\App\Models\Pincode','id','pincode_id');
    }
}
