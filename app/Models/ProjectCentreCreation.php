<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCentreCreation extends Model
{
    use HasFactory;
    public function centreCreation($value='')
    {
        return $this->hasOne('\App\Models\CentreCreation','id','centre_creation_id');
    }
}
