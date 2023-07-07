<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

use App\Models\Role;
use App\Models\User;
use App\Models\Batch;
use App\Models\BatchStudent;
use App\Models\Assesment;
use App\Models\AssesmentStudent;
use App\Models\ProcessAppFlow;
use App\Http\Requests\User\AssesmentRequest;
use App\Exports\User\AssesmentExport;
use Excel;
class AdminAssesmentController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->approvalDate = date('Y-m-d');
    }
    public function index(Request $request)
    {
        $batches = Batch::batchAssesmentPluck();
        extract($_GET);
        $data=Assesment::orderBy('id','DESC');//->where('grade', '!=', -1);
        $search = $request->search ?? '';
        $batch = $request->batch ?? '';
        $student = $request->student ?? '';
        // if(isset($request->search) && !empty($request->search)){
        //      $data->where('batch_id',$request->search);//$request->search
        // }
        $students=[];
        if(isset($request->batch) && !empty($request->batch)){
            $b = Batch::where(['slug'=>$batch])->first();
            if ($b) {
                $data->where('batch_id',$b->id);
                $students = Batch::batchAssesmentStPluck($b->id);
            }
        }
        if(isset($request->student) && !empty($request->student)){
            $s = BatchStudent::where(['slug'=>$student])->first();
            if ($s) {
               // $data->where('student_id',$s->id);
            }
        }
        if (isset($export)) {
            $userExp = $data->with('attStudent.student','batch')->get()->toArray();
            $arrays = [$userExp];
            return $this->dataExport($arrays);
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin.assesment.list',compact('data','search','page','total','batch','batches','students','student'));

    }
    
    public function edit($slug)
    {
        $s = count(Assesment::status());
        $data=Assesment::where(['slug' => $slug])->first();
        if($data){
            $batch = Assesment::batchPluck();
            return view('admin.assesment.edit',['batch'=>$batch, 'data'=>$data]);
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
        
    }

    public function update(Request $request,$slug=null)
    {
        
        $s = count(Assesment::status());
        $a_data=Assesment::where(['slug' => $slug])->first(); 
        $b_data = \App\Models\Batch::where(['slug'=>Batch::slug($a_data->batch_id ?? 0)])->first();
        if($b_data){

            if($b_data->students){
                $chk = '';
                $data = array();
                foreach ($b_data->students as $key => $value) {
                    $ps = ($request->grade[$value->id]) ?? '-1';
                    $grade=Helper::removetag($ps);
                    //$data->status = 2;
                    $data = [
                        'grade' => $grade
                    ];
                    $chk = AssesmentStudent::where('assesment_id', $a_data->id)->where('student_id', $value->id)->update($data);
                }
                $second_level_id = Auth()->user()->id;
                $second_level_ary = json_encode(User::userAry(Auth()->user()->id));
                $second_level_date = $this->approvalDate;
                $data = [
                        'second_level_id' => $second_level_id,
                        'second_level_ary' => $second_level_ary,
                        'second_level_date' => $second_level_date
                    ];
                Assesment::where('batch_id', $b_data->id)->update($data);
                if($chk){
                    return to_route('admin.assesments')->with('success', 'Saved successfully !');
                }else{
                    return back()->with('failed', 'Wrong access or try again.');
                }
            } else{
                  return back()->with('failed', 'Wrong access or try again.');
            }
        }else{
           return back()->with('failed', 'Data not found.');
        }
    }


    public function dataExport($arrays=[])
    {
        return Excel::download(new AssesmentExport($arrays), 'assesment-data-'.date('d-m-y').'.xlsx');
    }
}

