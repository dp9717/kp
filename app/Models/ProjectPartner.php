<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPartner extends Model
{
    use HasFactory;
    public function partner($value='')
    {
        return $this->hasOne('\App\Models\Partner','id','partner_id');
    }

    public function project($value='')
    {
        return $this->hasOne('\App\Models\Project','id','project_id');
    }
}
