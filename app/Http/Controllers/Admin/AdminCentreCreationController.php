<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

use App\Models\Role;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Taluk;
use App\Models\Pincode;
use App\Models\CentreCreation;
use App\Models\CentreCreationFile;
use App\Models\ProcessAppFlow;

use App\Http\Requests\User\CentreCreationRequest;
use App\Exports\User\CentreCreationExport;
use Excel;
class AdminCentreCreationController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->path = 'upload/centre-creation/';
        $this->approvalDate = date('Y-m-d');
    }
    public function index(Request $request)
    {
        extract($_GET);
        $data=CentreCreation::where('status','<',count(CentreCreation::status()))->orderBy('id','DESC');
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
        return view('admin.centre-creation.list',compact('data','search','page','total','account_status'));

    }

    public function edit($slug)
    {
        $s = count(CentreCreation::status());
        $data=CentreCreation::where(['slug' => $slug])->first();
        //$data=CentreCreation::where(['slug' => $slug,'user_id'=>auth()->user()->id])->whereNotIn('status',[2,$s])->first();
        if($data){
                //$data->status = 1;
                $role = CentreCreation::centreHead();
                $state = State::statePluck(); 
                $city = City::cityPluck($data->state_id ?? 0);
                $taluk = Taluk::talukPluck($data->city_id ?? 0);
                $pincode =Pincode::pincodePluck($data->taluk_id ?? 0);
                return view('admin.centre-creation.edit',['role'=>$role,'state'=>$state,'city'=>$city,'taluk'=>$taluk,'pincode'=>$pincode,'pincode'=>$pincode,'data'=>$data]);
            
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
        
    }
    
    public function update(CentreCreationRequest $request,$slug=null)
    {
        $path = $this->path;
        $upload_file =  '';
        if ($request->upload_file) {
            $upload_file = 'mimes:jpeg,png,jpg,gif,svg|max:5048';
        }
        $request->validate(['upload_file.*'=>$upload_file]);

        $time=rand(1111,9999).time();
        $s = count(CentreCreation::status());
        $data=CentreCreation::where(['slug' => $slug])->first(); 
        if($data){
                $preUpload_file = $data->upload_file;
                $data->name=Helper::removetag($request->name);
                $data->contact=Helper::removetag($request->contact);
                $data->email=Helper::removetag($request->email);
                $data->additional_information=Helper::removetag($request->additional_information);
                
                $data->centre_head_id = User::id($request->centre_head);
                $data->centre_head_ary = json_encode(User::userAry(User::id($request->centre_head)));
                
                $data->address=Helper::removetag($request->address);
                $p_data = Pincode::with('taluk','taluk.city','taluk.city.state')->where(['status'=>1,'slug'=>$request->pincode])->first();
                $data->state_id = $p_data->taluk->city->state->id;
                $data->city_id = $p_data->taluk->city->id;
                $data->taluk_id = $p_data->taluk->id;
                $data->pincode_id = $p_data->id;
                $data->full_address = json_encode(Pincode::fullAddress($request->pincode,Helper::removetag($request->address)));

                if ($data->status==2) {
                    $data->status = 1;
                }
               
                 if($data->save()){
                    if ($request->upload_file) {
                        foreach ($request->upload_file as $key => $img) {
                            if($img){
                                $imgName=(time().$key.$data->id).'.'.$img->extension();
                                $reqImg=new CentreCreationFile;
                                $reqImg->centre_creation_id = $data->id;
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
                    if ($data->status == count(CentreCreation::status())) {
                        return to_route('admin.centreCreationApprovedList')->with('success', 'Updated successfully !');
                    }
                    return to_route('admin.centreCreations')->with('success', 'Updated successfully !');
                 }else{
                     return back()->with('failed', 'Wrong access or try again.');
                 } 
        }else{
           return redirect()->route('admin.centreCreations')->with('failed', 'Wrong access or try again.');
        }
    }

    /*public function statusChange(Request $request,$slug)
    {
        $request->validate(['status'=>'required|numeric|in:1,2']);
       $data=CentreCreation::where('slug',$slug)->first();
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
        $data=CentreCreation::where('slug',$slug)->first();
        if ($data && $data->status < count(\App\Models\CentreCreation::status())) {
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
        $data=CentreCreation::onlyTrashed()->orderBy('id','DESC');
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
        return view('admin.centre-creation.trashedList',compact('data','search','page','total','account_status'));

    }

    public function restoreData(Request $request,$slug)
    {
       $data=CentreCreation::onlyTrashed()->where('slug',$slug)->first();
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
        $data=CentreCreation::onlyTrashed()->where('slug',$slug)->first();
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
        $data=CentreCreation::where('slug',$slug)->where('status','!=',2)->first();
        if ($data && $data->status < count(\App\Models\CentreCreation::status())) {
            $cur_status=$data->status;
            if($cur_status==1){
                $cur_status = 3;
            }
            if(!in_array($data->status,[1,2])){
                $cur_status = $data->status+1;
            }
            $users = CentreCreation::authUserByStatus($cur_status);
            $status = CentreCreation::statusApprovalArray($data->status);
            return view('admin.centre-creation.statusView',['status'=>$status,'data'=>$data,'users'=>$users]);
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
    }

    public function statusApprove(Request $request,$slug=null)
    {
        $path = $this->path;
        $time=rand(1111,9999).time();
        $data=CentreCreation::where('slug',$slug)->where('status','!=',2)->first();
        if($data){
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
                return to_route('admin.centreCreations')->with('success', 'Request status updated successfully !');
             }else{
                 return back()->with('failed', 'Wrong access or try again.');
             }
            
        }else{
           return redirect()->route('admin.centreCreations')->with('failed', 'Wrong access or try again.');
        }
    }

    public function approvedList(Request $request)
    {
        extract($_GET);
        $data=CentreCreation::where('status',count(CentreCreation::status()))->orderBy('id','DESC');
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
        return view('admin.centre-creation.approved',compact('data','search','page','total','account_status'));

    }

    public function fileRemove($file_id='',$slug='')
    {
        $data=CentreCreation::where(['slug'=>$slug])->first();
        if($data){
            $data=CentreCreationFile::where(['id'=>$file_id,'centre_creation_id'=>$data->id])->first();
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
        return Excel::download(new CentreCreationExport($arrays), 'centre-data-'.date('d-m-y').'.xlsx');
    }
    
}
