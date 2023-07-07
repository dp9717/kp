<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessAppFlow extends Model
{
    use HasFactory;

    public static function permission($process_id='',$status_id='')
    {
        return ProcessAppFlow::where(['role_id'=>auth()->user()->userRole->role_id,'status_id'=>$status_id,'process_id'=>$process_id])->count();
    }
}
