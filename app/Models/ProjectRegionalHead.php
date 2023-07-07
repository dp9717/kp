<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRegionalHead extends Model
{
    use HasFactory;
    public function regStateHead($value='')
    {
        return $this->hasOne('\App\Models\User','id','regional_head_id');
    }
}
