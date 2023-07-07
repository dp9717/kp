<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use App\Models\CentreCreation;
use App\Models\Module;
use App\Models\Batch;
use App\Models\BatchStudent;
use App\Models\BatchFile;
use App\Models\ProcessAppFlow;
use App\Http\Requests\User\BatchRequest;
use App\Exports\User\BatchExport;
use App\Exports\User\BatchStudentFileFormatExport;
use App\Imports\User\BatchStudentFileImport;
use Excel;
class AdminBatchController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->path = 'upload/batch/';
        $this->approvalDate = date('Y-m-d');
    }
    public function index(Request $request)
    {
        extract($_GET);
        $data=Batch::where('status','<',count(Batch::status()))->orderBy('id','DESC');
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        if(isset($request->search) && !empty($request->search)){
             $data->where(function($q) use($request) {
                $q->where('name', 'LIKE', "%$request->search%")->orWhere('pan', 'LIKE', "%$request->search%")->orWhere('gst', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%")->orWhere('cin', 'LIKE', "%$request->search%");
             });
        }
        if(isset($request->account_status) && !empty($request->account_status)){
             $data->where('status', $request->account_status);
        }
        if (isset($export)) {
            $userExp = $data->get()->toArray();
            $arrays = [$userExp];
            return $this->dataExport($arrays);
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin.batch.list',compact('data','search','page','total','account_status'));
    }
    
    public function edit($slug)
    {
        $s = count(Batch::status());
        $data=Batch::where(['slug' => $slug])->first();
        //$data=Batch::where(['slug' => $slug,'user_id'=>auth()->user()->id])->whereNotIn('status',[2,$s])->first();
        if($data){
            $projects = Batch::projects();
            $trainers = Batch::trainers();
            $locations = Batch::locations();
            $stateCoOrdinators = Batch::stateCoOrdinators();
            $module = Batch::modules();
            return view('admin.batch.edit',['projects'=>$projects,'trainers'=>$trainers,'locations'=>$locations,'stateCoOrdinators'=>$stateCoOrdinators,'modules'=>$module,'data'=>$data]);
            
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
    }

    public function update(BatchRequest $request,$slug=null)
    {
        $path = $this->path;
        $upload_file =  '';
        if ($request->upload_file) {
            $upload_file = 'mimes:jpeg,png,jpg,gif,svg|max:5048';
        }
        $request->validate(['upload_file.*'=>$upload_file]);

        $time=rand(1111,9999).time();
        $s = count(Batch::status());
        $data=Batch::where(['slug' => $slug])->first(); 
        if($data){
            $preUpload_file = $data->upload_file;
            $data->project_id=Helper::removetag(Project::id($request->project));
            $data->project_ary=Helper::removetag(Project::projectAry(Project::id($request->project)));

            $data->module_id = Helper::removetag(Module::id($request->module));
            $data->module_ary = Helper::removetag(Module::moduleAry(Module::id($request->module)));

            $data->trainer_id=Helper::removetag(User::id($request->trainer));
            $data->trainer_ary=Helper::removetag(User::userAry(User::id($request->trainer)));

            $data->start_date = Helper::date($request->start_date,'Y-m-d');
            $data->end_date = Helper::date($request->end_date,'Y-m-d');
            $data->start_time=Helper::removetag($request->start_time);
            $data->end_time=Helper::removetag($request->end_time);

            $data->location_id=Helper::removetag(CentreCreation::id($request->location));
            $data->location_ary=Helper::removetag(CentreCreation::centreAry(CentreCreation::id($request->location)));

            $data->state_co_ordinator_id=Helper::removetag(User::id($request->state_co_ordinator));
            $data->state_co_ordinator_ary=Helper::removetag(User::userAry(User::id($request->state_co_ordinator)));
           
            $data->additional_information=Helper::removetag($request->additional_information);

            if ($data->status==2) {
                $data->status = 1;
            }
            
            $data->course_start_date = Helper::date($request->course_start_date,'Y-m-d');
            $data->course_end_date = Helper::date($request->course_end_date,'Y-m-d');
            if ($request->tch_name) {
                $itemDetail=[];
                foreach ($request->tch_name as $qkey => $qvalue) {
                    if ($qvalue > 0) {
                            //other
                            $itemDetail[]=[
                                'name'=>$qvalue,
                                'code'=>$request->tch_code[$qkey]
                            ];
                    }
                }
                $data->course_teacher = json_encode($itemDetail);
            }
             if($data->save()){
                /*code*/
                $cname = CentreCreation::centreAry(CentreCreation::id($request->location))->name ?? '';
                $cname.=' '. Module::moduleAry(Module::id($request->module))->name ?? '';
                 $cv = explode(' ', $cname);
                 $f = '';
                 if (count($cv)) {

                     foreach ($cv as $key => $value) {
                         $f .= $value[0];
                     }
                 }
                /*endcode*/
                $data->slug=Helper::ProcessUniqueCode($data->id,3,$f);
                $data->save();
                if ($request->upload_file) {
                    foreach ($request->upload_file as $key => $img) {
                        if($img){
                            $imgName=(time().$key.$data->id).'.'.$img->extension();
                            $reqImg=new BatchFile;
                            $reqImg->batch_id = $data->id;
                            $reqImg->file_path = $path.$imgName;
                            $reqImg->file_type = $img->extension();
                            $reqImg->file_description = Helper::removetag($request->file_description[$key] ?? '') ?? '';
                            $reqImg->user_id = Auth()->user()->id;
                            if ($reqImg->save()) {
                                $img->move(public_path($path),$imgName);
                            }
                        }
                    }
                }
                if ($request->st_name) {
                    BatchStudent::where(['batch_id'=>$data->id])->delete();
                    foreach ($request->st_name as $s_key => $s_val) {
                        if($s_val){
                            $s_ary=new BatchStudent;
                            $s_ary->batch_id = $data->id;
                            $s_ary->name = $s_val;
                            $s_ary->email = $request->st_email[$s_key];
                            $s_ary->contact = $request->st_contact[$s_key];
                            $s_ary->slug=Str::of(Helper::removetag(($s_val.' '.time().rand(11111,99999))))->slug('-');
                            $s_ary->save();
                        }
                    }
                }
                if (request()->file('import_student')) {
                    $file = new BatchStudentFileImport($data->id);
                    $file->import(request()->file('import_student'));
                }
                if ($data->status == count(Batch::status())) {
                    return to_route('admin.batchApprovedList')->with('success', 'Updated successfully !');
                }
                return to_route('admin.batches')->with('success', 'Updated successfully !');
             }else{
                 return back()->with('failed', 'Wrong access or try again.');
             } 
        }else{
           return redirect()->route('admin.batches')->with('failed', 'Wrong access or try again.');
        }
    }

    /*public function statusChange(Request $request,$slug)
    {
        $request->validate(['status'=>'required|numeric|in:1,2']);
       $data=Batch::where('slug',$slug)->first();
        if($data){
            $data->status=$request->status;
            $data->save();
            return back()->with('success', 'Status changed successfully !');
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
    }*/

    public function remove($slug)
    {
        //return redirect()->back()->with('failed', 'Wrong access or try again.');
        $data=Batch::where('slug',$slug)->first();
        if ($data && $data->status < count(\App\Models\Batch::status())) {
                if($data->delete()){
                    return back()->with('success', 'Removed successfully !');
                }else{
                   return back()->with('failed', 'Wrong access or try again.');
                }
            }else{
               return back()->with('failed', 'Wrong access or try again.');
            }
    }

    public function trashedData(Request $request)
    {
        extract($_GET);
        $data=Batch::onlyTrashed()->orderBy('id','DESC');
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        if(isset($request->search) && !empty($request->search)){
             $data->where(function($q) use($request) {
                $q->where('name', 'LIKE', "%$request->search%")->orWhere('pan', 'LIKE', "%$request->search%")->orWhere('gst', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%")->orWhere('cin', 'LIKE', "%$request->search%");
             });
        }
        if(isset($request->account_status) && !empty($request->account_status)){
             $data->where('status', $request->account_status);
        }
        if (isset($export)) {
            $userExp = $data->get()->toArray();
            $arrays = [$userExp];
            return $this->dataExport($arrays);
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin.batch.trashedList',compact('data','search','page','total','account_status'));

    }

    public function restoreData(Request $request,$slug)
    {
       $data=Batch::onlyTrashed()->where('slug',$slug)->first();
        if($data){
            $data->restore();
            return back()->with('success', 'Restored successfully !');
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
    }

    public function hardDltData($slug)
    {
        //return back()->with('failed', 'Wrong access or try again.');
        $data=Batch::onlyTrashed()->where('slug',$slug)->first();
        $preUpload_file = $data->file ?? '';
        if($data->forceDelete()){
            if ($preUpload_file) {
                foreach ($preUpload_file as $key => $img) {
                    $prefile = $img->file_path ?? '';
                    if ($prefile && file_exists(public_path($prefile))) {
                            unlink(public_path($prefile));
                    }
                }
            }
            return back()->with('success', 'Permanent removed successfully !');
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
    }

    public function statusView($slug)
    {
        $data=Batch::where('slug',$slug)->where('status','!=',2)->first();
        if($data){
            $cur_status=$data->status;
            if($cur_status==1){
                $cur_status = 3;
            }
            if(!in_array($data->status,[1,2])){
                $cur_status = $data->status+1;
            }
            $status = Batch::adminSstatusApprovalArray($cur_status); 
            $users = Batch::authUserByStatus($cur_status);
            return view('admin.batch.statusView',['status'=>$status,'data'=>$data,'users'=>$users]); 
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
        
    }

    public function statusApprove(Request $request,$slug=null)
    {
        $path = $this->path;
        $time=rand(1111,9999).time();
        $data=Batch::where('slug',$slug)->where('status','!=',2)->first();
        if($data){
            $cur_status=$data->status;
            if($cur_status==1){
                $cur_status = 3;
            }
            if(!in_array($data->status,[1,2])){
                $cur_status = $data->status+1;
            }
            if($data->status < count(\App\Models\Batch::status())){

                 $data->status=$request->status;
                // $data->second_level_id = Auth()->user()->id;
                // $data->second_level_ary = json_encode(User::userAry(Auth()->user()->id));
                // $data->second_level_comment=Helper::removetag($request->comment);
                // $data->second_level_date=$this->approvalDate;
                // approval
                if($request->status==3){
                    $data->second_level_id = User::id($request->user);
                    $data->second_level_ary = json_encode(User::userAry(User::id($request->user)));
                    $data->second_level_date = $this->approvalDate;
                    $data->second_level_comment=Helper::removetag($request->comment);
                    $data->admin_second_level_approval=1;
                }
                if($request->status==4){
                    $data->third_level_id = User::id($request->user);
                    $data->third_level_ary = json_encode(User::userAry(User::id($request->user)));
                    $data->third_level_date = $this->approvalDate;
                    $data->third_level_comment=Helper::removetag($request->comment);
                    $data->admin_third_level_approval=1;
                }
                if($request->status==5){
                    $data->fourth_level_id = User::id($request->user);
                    $data->fourth_level_ary = json_encode(User::userAry(User::id($request->user)));
                    $data->fourth_level_date = $this->approvalDate;
                    $data->fourth_level_comment=Helper::removetag($request->comment);
                    $data->admin_fourth_level_approval=1;
                }
                // end approval

                if ($request->status==2) {
                    $data->rejected_by_id = Auth()->user()->id;
                    $data->rejected_by_ary = json_encode(User::userAry(Auth()->user()->id));
                    $data->rejected_by_comment=Helper::removetag($request->comment);
                    $data->rejected_by_date=$this->approvalDate;
                }
                 if($data->save()){
                    return to_route('admin.batches')->with('success', 'Request status updated successfully !');
                 }else{
                     return back()->with('failed', 'Wrong access or try again.');
                 }
            }else{
                 return to_route('admin.home')->with('failed', 'Access denied.');
             }
        }else{
           return redirect()->route('admin.batches')->with('failed', 'Wrong access or try again.');
        }
    }

    public function approvedList(Request $request)
    {
        extract($_GET);
        $data=Batch::where('status',count(Batch::status()))->orderBy('id','DESC');
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        if(isset($request->search) && !empty($request->search)){
             $data->where(function($q) use($request) {
                $q->where('name', 'LIKE', "%$request->search%")->orWhere('pan', 'LIKE', "%$request->search%")->orWhere('gst', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%")->orWhere('cin', 'LIKE', "%$request->search%");
             });
        }
        if(isset($request->account_status) && !empty($request->account_status)){
             $data->where('status', $request->account_status);
        }
        if (isset($export)) {
            $userExp = $data->get()->toArray();
            $arrays = [$userExp];
            return $this->dataExport($arrays);
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin.batch.approved',compact('data','search','page','total','account_status'));

    }

    public function fileRemove($file_id='',$slug='')
    {
        $data=Batch::where(['slug'=>$slug])->first();
        if($data){
            $data=BatchFile::where(['id'=>$file_id,'batch_id'=>$data->id])->first();
            $preImage =$data->file_path ?? '';
            if($data->delete()){
                if(file_exists(public_path($preImage)) && $preImage){
                    unlink(public_path($preImage));
                }
                return back()->with('success', 'File removed successfully !');
            }else{
               return back()->with('failed', 'Wrong access or try again.');
            }
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
    }

    public function dataExport($arrays=[])
    {
        return Excel::download(new BatchExport($arrays), 'batch-data-'.date('d-m-y').'.xlsx');
    }

    public function exportStudentFormat(Request $request)
    {
        $arrays=[];
        return Excel::download(new BatchStudentFileFormatExport($arrays), 'student-import-blank-'.date('d-m-y').'.xlsx');
    }
}