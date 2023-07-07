<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchStudent extends Model
{
    use HasFactory;
    public function studentAttendence($value='')
    {
        return $this->hasMany('\App\Models\Attendence','student_id','id');
    }

    public function studentAssesment($value='')
    {
        return $this->hasMany('\App\Models\Assesment','student_id','id');
    }
}
