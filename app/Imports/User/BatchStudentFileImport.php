<?php

namespace App\Imports\User;

use App\Models\BatchStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Auth;
use App\Helpers\Helper;
use Illuminate\support\Str;

class BatchStudentFileImport implements ToModel, WithStartRow,WithHeadingRow,WithValidation,SkipsOnFailure
{
    use Importable,SkipsFailures;
    /**
    * @param Collection $collection
    */
    protected $batch_id;

    function __construct($batch = null)
    {
         $this->batch_id = $batch;
    }
    public function startRow():int
    {
        return 2;
    }
    public function model(array $row)
    {
        if ($row['student_name']) {
            $s_ary=new BatchStudent;
            $s_ary->batch_id = $this->batch_id;
            $s_ary->name = $row['student_name'];
            $s_ary->email = $row['student_email'] ?? '';
            $s_ary->contact = $row['student_contact'] ?? '';
            $s_ary->slug=Str::of(Helper::removetag(($row['student_name'].' '.time().rand(11111,99999))))->slug('-');
            $s_ary->save();
            return $s_ary;
        }
        return [];
    }

    public function rules(): array
    {
        return [
                    
        ];
    }
}