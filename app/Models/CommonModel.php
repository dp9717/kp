<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonModel extends Model
{
    use HasFactory;

    public static function getTotalBatchStudents($batchs) {
    	$students = 0;
    	if(isset($batchs)) {
    		foreach($batchs as $batch) {
    			$students+= $batch->students->count();
    		}
    	}
    	return $students;
    }
}
