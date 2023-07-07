<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssesmentStudent extends Model
{
    use HasFactory;
    public function student($value='')
    {
        return $this->hasOne('\App\Models\BatchStudent','id','student_id');
    }
}
