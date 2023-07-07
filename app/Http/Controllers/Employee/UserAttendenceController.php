<?php

namespace App\Http\Controllers\Employee;

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
class UserAttendenceController extends Controller
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
        return view('employee.attendence.list',compact('data','search','page','total','batch','batches','students','student'));
    }

    public function add($value='')
    {
        $batch = Attendence::batchPluck();
        return view('employee.attendence.add',['batch'=>$batch]);
    }
    public function edit($slug)
    {
        $s = count(Attendence::status());
        $data=Attendence::where(['slug' => $slug])->first();
        if($data){
            if (\App\Models\ProcessAppFlow::permission(8,count(\App\Models\Attendence::status()))) {
                return view('employee.attendence.edit',['data'=>$data]);
            }else{
               return back()->with('failed', 'Wrong access or try again.');
            }
            
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
        
    }

    public function insert(AttendenceRequest $request)
    {
        //print_r($request->input());
        if(\App\Models\ProcessAppFlow::permission(8,1)){
            $b_data = Batch::where(['slug'=>$request->batch ?? 0])->first();
            $start_date =(isset($b_data->start_date) && $b_data->start_date) ? $b_data->start_date : ''; 
            $end_date =(isset($b_data->end_date) && $b_data->end_date) ? $b_data->end_date : ''; 
            if (Attendence::where(['batch_id'=>$b_data->id,'attendence_date'=>$request->attendence_date])->count()) {
                return back()->with('failed', 'Already submitted for this date.');
            }else{
                if($b_data->students){

                    
                    $dataAt=new Attendence;
                    $dataAt->batch_id=Helper::removetag($b_data->id);
                    $dataAt->slug=Str::of(Helper::removetag((time().rand(11111,99999))))->slug('-');
                    $dataAt->user_id = Auth()->user()->id;
                    $dataAt->user_ary = json_encode(User::userAry(Auth()->user()->id));
                    if(\App\Models\ProcessAppFlow::permission(8,2)){
                        $dataAt->status = 2;
                        $dataAt->second_level_id = Auth()->user()->id;
                        $dataAt->second_level_ary = json_encode(User::userAry(Auth()->user()->id));
                        $dataAt->second_level_date = $this->approvalDate;
                    }
                    $dataAt->attendence_date = date('Y-m-d');
                    if ($dataAt->save()) {
                        foreach ($b_data->students as $key => $value) {
                            $data=new AttendenceStudent;
                            $data->attendence_id=Helper::removetag($dataAt->id);
                            $data->batch_id=Helper::removetag($b_data->id);
                            $data->student_id=Helper::removetag($value->id);
                            $ps = $request->attendence[$value->id];
                            $data->attendence=Helper::removetag($ps);
                            $data->slug=Str::of(Helper::removetag((time().rand(11111,99999))))->slug('-').$dataAt->id;
                            
                            if ($data->save()) {
                                $days = Helper::diffInDays($start_date,$end_date);
                                $persent = AttendenceStudent::where(['student_id'=>$value->id,'batch_id'=>$b_data->id,'attendence'=>1])->count();
                                $per = Attendence::calPercent($persent,$days);
                                BatchStudent::where(['id'=>$value->id,'batch_id'=>$b_data->id])->update(['attendence_percent'=>$per]);
                            }
                        }
                    }
                    return to_route('user.attendences')->with('success', 'Saved successfully !');
                }else{
                      return back()->with('failed', 'Wrong access or try again.');
                }
            }
        }else{
             return back()->with('failed', 'Permission denied.');
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
            if (\App\Models\ProcessAppFlow::permission(8,count(\App\Models\Attendence::status()))) {
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
                            if(\App\Models\ProcessAppFlow::permission(8,2)){
                                $b_data->status = 2;
                                $b_data->second_level_id = Auth()->user()->id;
                                $b_data->second_level_ary = json_encode(User::userAry(Auth()->user()->id));
                                $b_data->second_level_date = $this->approvalDate;
                                $b_data->save();
                            }
                            return to_route('user.attendences')->with('success', 'Saved successfully !');
                        }else{
                              return back()->with('failed', 'Wrong access or try again.');
                          }
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

