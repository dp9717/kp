<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStateHead extends Model
{
    use HasFactory;
    public function stateHead($value='')
    {
        return $this->hasOne('\App\Models\User','id','state_head_id');
    }
}
