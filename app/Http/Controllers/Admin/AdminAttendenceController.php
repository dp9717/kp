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
use App\Models\Attendence;
use App\Models\AttendenceStudent;
use App\Models\ProcessAppFlow;
use App\Http\Requests\User\AttendenceRequest;
use App\Exports\User\AttendenceExport;
use Excel;
class AdminAttendenceController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->approvalDate = date('Y-m-d');
    }
    public function index(Request $request)
    {
        $batches = Batch::batchAttendencePluck();
        extract($_GET);
        $data=Attendence::orderBy('id','DESC');
        $search = $request->search ?? '';
        $batch = $request->batch ?? '';
        $student = $request->student ?? '';
        if(isset($request->search) && !empty($request->search)){
             $data->where('batch_id',$request->search);//$request->search
        }
        $students=[]; 
        if(isset($request->batch) && !empty($request->batch)){
            $b = Batch::where(['slug'=>$batch])->first();
            if ($b) {
                $data->where('batch_id',$b->id);
                $students = Batch::batchAttendenceStPluck($b->id);
            }
        }
        if(isset($request->student) && !empty($request->student)){
            $s = BatchStudent::where(['slug'=>$student])->first();
            if ($s) {
               // $data->where('student_id',$s->id);
            }
        }
        if (isset($export)) {
            $userExp = $data->with('batch','attStudent.student')->get()->toArray();
            $arrays = [$userExp];
            return $this->dataExport($arrays);
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin.attendence.list',compact('data','search','page','total','batch','batches','students','student'));
    }

    public function edit($slug)
    {
        $s = count(Attendence::status());
        $data=Attendence::where(['slug' => $slug])->first();
        if($data){
            return view('admin.attendence.edit',['data'=>$data]);
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
        
    }
    
    public function update(Request $request,$slug=null)
    {
        $s = count(Attendence::status());
        $b_data=Attendence::where(['slug' => $slug])->first(); 
        if($b_data){
            $b = Batch::where(['id'=>$b_data->batch_id])->first();
            $start_date =(isset($b->start_date) && $b->start_date) ? $b->start_date : ''; 
            $end_date =(isset($b->end_date) && $b->end_date) ? $b->end_date : ''; 

            $request->validate([
                            'attendence_date'=>'required|date|after_or_equal:'.$b->start_date.'|before_or_equal:'.$b->end_date,
                        ]);

                if($b->students){
                    foreach ($b->students as $key => $value) {
                        $data=AttendenceStudent::where(['student_id'=>$value->id,'batch_id'=>$b_data->batch_id,'attendence_id'=>$b_data->id])->first();
                        $ps = $request->attendence[$value->id];
                        $data->attendence=Helper::removetag($ps);
                        //$data->attendence_date = date('Y-m-d');
                        if ($data->save()) {
                            $days = Helper::diffInDays($start_date,$end_date);
                            $persen = AttendenceStudent::where(['student_id'=>$value->id,'batch_id'=>$b_data->batch_id,'attendence'=>1])->count();
                            $per = Attendence::calPercent($persen,$days);
                            BatchStudent::where(['id'=>$value->id,'batch_id'=>$b_data->batch_id])->update(['attendence_percent'=>$per]);
                        }
                        
                    }
                    //$b_data->status = 2;
                    return to_route('admin.attendences')->with('success', 'Saved successfully !');
                }else{
                      return back()->with('failed', 'Wrong access or try again.');
                  }

            }else{
               return back()->with('failed', 'Data not found.');
            }
    }


    public function dataExport($arrays=[])
    {
        return Excel::download(new AttendenceExport($arrays), 'attendence-data-'.date('d-m-y').'.xlsx');
    }
}

