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
use App\Models\ProjectFile;
use App\Models\ProcessAppFlow;

use App\Models\ProjectCentreCreation;
use App\Models\ProjectPartner;
use App\Models\ProjectRegionalHead;
use App\Models\ProjectStateHead;

use App\Models\CentreCreation;
use App\Models\Partner;

use App\Http\Requests\User\ProjectRequest;
use App\Exports\User\ProjectExport;
use Excel;
class AdminProjectController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->path = 'upload/project/';
        $this->approvalDate = date('Y-m-d');
    }
    public function index(Request $request)
    {
        extract($_GET);
        $data=Project::where('status','<',count(Project::status()))->orderBy('id','DESC');
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        if(isset($request->search) && !empty($request->search)){
             $data->where(function($q) use($request) {
                $q->where('name', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%");
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
        return view('admin.project.list',compact('data','search','page','total','account_status'));

    }

    public function edit($slug)
    {

        $s = count(Project::status());
        $data=Project::where(['slug' => $slug])->first();
        //$data=Project::where(['slug' => $slug,'user_id'=>auth()->user()->id])->whereNotIn('status',[2,$s])->first();
        if($data){
            
            $fundedby = Project::fundedby();
            $mouSigned = Project::mouSigned();

            $pjManager = Project::pjManager();
            $pjStateHead = Project::pjStateHead();
            $pjRegionalHead = Project::pjRegionalHead();

            $centre = Project::centre();
            $partner = Project::partner();
            return view('admin.project.edit',['fundedby'=>$fundedby,'data'=>$data,'mouSigned'=>$mouSigned,'pjManager'=>$pjManager,'pjStateHead'=>$pjStateHead,'pjRegionalHead'=>$pjRegionalHead,'centre'=>$centre,'partner'=>$partner]);
            
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
        
    }

    public function update(ProjectRequest $request,$slug=null)
    {
        $path = $this->path;
        $upload_file =  '';
        if ($request->upload_file) {
            $upload_file = 'mimes:jpeg,png,jpg,gif,svg|max:5048';
        }
        $request->validate(['upload_file.*'=>$upload_file]);

        $time=rand(1111,9999).time();
        $s = count(Project::status());
        $data=Project::where(['slug' => $slug])->first(); 
        if($data){
            $preUpload_file = $data->upload_file;

            $data->name=Helper::removetag($request->name);
            //$data->duration=Helper::removetag($request->duration);
            $data->mou_signed=Helper::removetag($request->mou_signed);
            if ($request->mou_signed=='yes') {
                $data->mou_start_date = Helper::date($request->mou_start_date,'Y-m-d');
                $data->mou_end_date = Helper::date($request->mou_end_date,'Y-m-d');
            }else{
                $data->mou_start_date =null;
                $data->mou_end_date = null;
            }
            
            $data->funded_by = $request->funded_by;
            $data->target_number=Helper::removetag($request->target_number);
            $data->est_fund_value=Helper::removetag($request->est_fund_value);
            $data->additional_information=Helper::removetag($request->additional_information);

            $data->project_manager_id = User::id($request->pjManager);
            $data->project_manager_ary = json_encode(User::userAry(User::id($request->pjManager)));

            $data->additional_information=Helper::removetag($request->additional_information);
            if ($data->status==2) {
                $data->status = 1;
            }
             if($data->save()){
                if ($request->upload_file) {
                    foreach ($request->upload_file as $key => $img) {
                        if($img){
                            $imgName=(time().$key.$data->id).'.'.$img->extension();
                            $reqImg=new ProjectFile;
                            $reqImg->project_id = $data->id;
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
                if ($request->centre) {
                    ProjectCentreCreation::where(['project_id'=>$data->id])->delete();
                    foreach ($request->centre as $c_key => $c_val) {
                        if($c_val){
                            $c=new ProjectCentreCreation;
                            $c->project_id = $data->id;
                            $c->centre_creation_id = CentreCreation::id($c_val);
                            $c->save();
                        }
                    }
                }

                if ($request->partner) {
                    ProjectPartner::where(['project_id'=>$data->id])->delete();
                    foreach ($request->partner as $p_key => $p_val) {
                        if($p_val){
                            $p=new ProjectPartner;
                            $p->project_id = $data->id;
                            $p->partner_id = Partner::id($p_val);
                            $p->contribute=$request->contribute[$p_key] ?? 0;
                            $p->save();
                        }
                    }
                }
                if ($request->pjRegionalHead) {
                    ProjectRegionalHead::where(['project_id'=>$data->id])->delete();
                    foreach ($request->pjRegionalHead as $reg_key => $reg_val) {
                        if($reg_val){
                            $reg=new ProjectRegionalHead;
                            $reg->project_id = $data->id;
                            $reg->regional_head_id = User::id($reg_val);
                            $reg->save();
                        }
                    }
                }

                if ($request->pjStateHead) {
                    ProjectStateHead::where(['project_id'=>$data->id])->delete();
                    foreach ($request->pjStateHead as $stHead_key => $stHead_val) {
                        if($stHead_val){
                            $stHead=new ProjectStateHead;
                            $stHead->project_id = $data->id;
                            $stHead->state_head_id = User::id($stHead_val);
                            $stHead->save();
                        }
                    }
                }

                if ($data->status == count(Project::status())) {
                    return to_route('admin.projectApprovedList')->with('success', 'Updated successfully !');
                }
                return to_route('admin.projects')->with('success', 'Updated successfully !');
             }else{
                 return back()->with('failed', 'Wrong access or try again.');
             } 

            
        }else{
           return redirect()->route('admin.projects')->with('failed', 'Wrong access or try again.');
        }
    }

    /*public function statusChange(Request $request,$slug)
    {
        $request->validate(['status'=>'required|numeric|in:1,2']);
       $data=Project::where('slug',$slug)->first();
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
        $data=Project::where('slug',$slug)->first();
        if ($data && $data->status < count(\App\Models\Project::status())) {
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
        $data=Project::onlyTrashed()->orderBy('id','DESC');
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        if(isset($request->search) && !empty($request->search)){
            $data->where(function($q) use($request) {
                $q->where('name', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%");
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
        return view('admin.project.trashedList',compact('data','search','page','total','account_status'));

    }

    public function restoreData(Request $request,$slug)
    {
       $data=Project::onlyTrashed()->where('slug',$slug)->first();
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
        $data=Project::onlyTrashed()->where('slug',$slug)->first();
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
        $data=Project::where('slug',$slug)->where('status','!=',2)->first();
        if($data){
            $cur_status=$data->status;
            if($cur_status==1){
                $cur_status = 3;
            }
            if(!in_array($data->status,[1,2])){
                $cur_status = $data->status+1;
            }
            if($data->status < count(\App\Models\Project::status())){
                $status = Project::statusApprovalArray($data->status);
                $users = Project::authUserByStatus($cur_status);
                return view('admin.project.statusView',['status'=>$status,'data'=>$data,'users'=>$users]);
            }else{
                 return back()->with('failed', 'Access denied.');
             }  
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
        
    }

    public function statusApprove(Request $request,$slug=null)
    {
        $path = $this->path;
        $time=rand(1111,9999).time();
        $data=Project::where('slug',$slug)->where('status','!=',2)->first();
        if($data){
            $cur_status=$data->status;
            if($cur_status==1){
                $cur_status = 3;
            }
            if(!in_array($data->status,[1,2])){
                $cur_status = $data->status+1;
            }
            if($data->status < count(\App\Models\Project::status())){

                $data->status=$request->status;
                $data->second_level_id = User::id($request->user);
                $data->second_level_ary = json_encode(User::userAry(User::id($request->user)));
                $data->second_level_comment=Helper::removetag($request->comment);
                $data->second_level_date=$this->approvalDate;
                $data->admin_second_level_approval=1;
                if ($request->status==2) {
                    $data->rejected_by_id = Auth()->user()->id;
                    $data->rejected_by_ary = json_encode(User::userAry(Auth()->user()->id));
                    $data->rejected_by_comment=Helper::removetag($request->comment);
                    $data->rejected_by_date=$this->approvalDate;
                }
                 if($data->save()){
                    return to_route('admin.projects')->with('success', 'Request status updated successfully !');
                 }else{
                     return back()->with('failed', 'Wrong access or try again.');
                 }
            }else{
                 return to_route('admin.home')->with('failed', 'Access denied.');
             }
        }else{
           return redirect()->route('admin.projects')->with('failed', 'Wrong access or try again.');
        }
    }

    public function approvedList(Request $request)
    {
        extract($_GET);
        $data=Project::where('status',count(Project::status()))->orderBy('id','DESC');
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        if(isset($request->search) && !empty($request->search)){
            $data->where(function($q) use($request) {
                $q->where('name', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%");
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
        return view('admin.project.approved',compact('data','search','page','total','account_status'));

    }

    public function fileRemove($file_id='',$slug='')
    {
        $data=Project::where(['slug'=>$slug])->first();
        if($data){
            $data=ProjectFile::where(['id'=>$file_id,'project_id'=>$data->id])->first();
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
        return Excel::download(new ProjectExport($arrays), 'project-data-'.date('d-m-y').'.xlsx');
    }
}
