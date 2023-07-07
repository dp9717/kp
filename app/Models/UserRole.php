<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    public function role($value='')
    {
        return $this->hasOne('\App\Models\Role','id','role_id')->select('id','name','slug');
    }

    public function permission($process_id='',$status_id='')
    {
        return $this->hasMany('\App\Models\ProcessAppFlow','role_id','role_id');
    }
}
