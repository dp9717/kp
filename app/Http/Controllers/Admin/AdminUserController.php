<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

use App\Models\Role;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Taluk;
use App\Models\Pincode;
use App\Models\UserRole;
use App\Models\UserAddress;
use App\Http\Requests\Admin\UserRequest;
use App\Exports\Admin\UserExport;
use Excel;
use Mail;
use App\Mail\Admin\UserApprovalMail;
class AdminUserController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->path = 'upload/user/';
    }
    public function index(Request $request)
    {
        extract($_GET);
        $data=User::with('userRole.role','userAddress')->orderBy('id','DESC')->where('is_admin',1);
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        $user_role = $request->user_role ?? '';
        if(isset($request->search) && !empty($request->search)){
             $data->where('name', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%");
        }
        if(isset($request->account_status) && !empty($request->account_status)){
             $data->where('status', $request->account_status);
        }
        if(isset($request->user_role) && !empty($request->user_role)){
            $role_id = Role::id($request->user_role);
             $data->where(function($query) use ($role_id){
                $query->whereHas('userRole', function($q) use($role_id) { 
                    $q->where('role_id', $role_id);
                });
             });
        }
        if (isset($export)) {
            $userExp = $data->get()->toArray();
            $arrays = [$userExp];
            return $this->dataExport($arrays);
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin.user.list',compact('data','search','page','total','account_status','user_role'));

    }

    public function add($value='')
    {
        $role = Role::rolePluck();
        $state = State::statePluck();
        $city = [];//City::cityPluck();
        $taluk = [];//Taluk::talukPluck();
        $pincode =[];//Pincode::where('id','<',20)->pluck('pincode','slug');// Pincode::pincodePluck();
        $qualification = User::qualification();
        $profession = User::profession();
        return view('admin.user.add',['role'=>$role,'state'=>$state,'city'=>$city,'taluk'=>$taluk,'pincode'=>$pincode,'pincode'=>$pincode,'qualification'=>$qualification,'profession'=>$profession]);
    }
    public function edit($slug)
    {
        $data=User::where('slug',$slug)->where('is_admin',1)->first();
        if($data){
            $role = Role::rolePluck();
            $state = State::statePluck(); 
            $city = City::cityPluck($data->userAddress->userState->id ?? 0);
            $taluk = Taluk::talukPluck($data->userAddress->userCity->id ?? 0);
            $pincode =Pincode::pincodePluck($data->userAddress->userTaluk->id ?? 0);
            $qualification = User::qualification();
            $profession = User::profession();
            return view('admin.user.edit',['role'=>$role,'state'=>$state,'city'=>$city,'taluk'=>$taluk,'pincode'=>$pincode,'pincode'=>$pincode,'data'=>$data,'qualification'=>$qualification,'profession'=>$profession]);
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
        
    }

    public function insert(UserRequest $request)
    {
        $path = $this->path;
        $pan_file = $aadhar_file = $resume_file = $other_file = '';
        if ($request->pan_file) {
            $pan_file = 'mimes:jpeg,png,jpg,gif,svg|max:4096';
        }
        if ($request->aadhar_file) {
            $aadhar_file = 'mimes:jpeg,png,jpg,gif,svg|max:4096';
        }

        if ($request->resume_file) {
            $resume_file = 'mimes:jpeg,png,jpg,gif,svg|max:4096';
        }

        if ($request->other_file) {
            $other_file = 'mimes:jpeg,png,jpg,gif,svg|max:4096';
        }
        $time=rand(1111,9999).time();

        $data=new User;
        $data->name=Helper::removetag($request->name);
        $data->mobile=Helper::removetag($request->contact);
        $data->email=Helper::removetag($request->email);
        $data->office_no=Helper::removetag($request->office_no);
        $data->office_email=Helper::removetag($request->office_email);
        $data->designation=Helper::removetag($request->designation);
        $data->additional_information=Helper::removetag($request->additional_information);

        $data->slug=Str::of(Helper::removetag(($request->name.' '.time().rand(11111,99999))))->slug('-');
        $pass = User::password();
        $data->password=Hash::make($pass);
        $data->original_password=$pass;

        if ($request->pan_file) {
            $panName='pan'.$time.'.'.$request->pan_file->extension();
            $data->pan_file=$path.$panName;
        }
        if ($request->aadhar_file) {
            $aadharName='aadhar'.$time.'.'.$request->aadhar_file->extension();
            $data->aadhar_file=$path.$aadharName;
        }

        if ($request->resume_file) {
            $resumeName='resume'.$time.'.'.$request->resume_file->extension();
            $data->resume_file=$path.$resumeName;
        }

        if ($request->other_file) {
            $otherFileName='other'.$time.'.'.$request->other_file->extension();
            $data->other_file=$path.$otherFileName;
        }
        $data->qualification=Helper::removetag($request->qualification);
        $data->profession=Helper::removetag($request->profession);
        $data->token_key = Helper::randtoken();
         if($data->save()){
            $data->slug=Helper::userCode($data->id);
            $data->save();
            if ($request->pan_file) {
                $request->pan_file->move(public_path($path),$panName);
            }

            if ($request->aadhar_file) {
                $request->aadhar_file->move(public_path($path),$aadharName);
            }

            if ($request->resume_file) {
                $request->resume_file->move(public_path($path),$resumeName);
            }

            if ($request->other_file) {
                $request->other_file->move(public_path($path),$otherFileName);
            }

            $p_data = Pincode::with('taluk','taluk.city','taluk.city.state')->where(['status'=>1,'slug'=>$request->pincode])->first();
 
            if ($p_data) {
                $u_add = new UserAddress;
                $u_add->user_id = $data->id;
                $u_add->address = Helper::removetag($request->address);
                $u_add->state_id = $p_data->taluk->city->state->id;
                $u_add->city_id = $p_data->taluk->city->id;
                $u_add->taluk_id = $p_data->taluk->id;
                $u_add->pincode_id = $p_data->id;
                $u_add->full_address = json_encode(Pincode::fullAddress($request->pincode,Helper::removetag($request->address)));
                $u_add->save();
            }

            $u_role = new UserRole;
            $u_role->user_id = $data->id;
            $u_role->role_id = Role::id($request->role);
            $u_role->save();
            //email
                $m_data['subject'] = "Your Account verification for SSRDP’s Kaushal Path 1.0";
                $data->update(['token_key'=>Helper::randtoken()]);
                $m_data['link'] = route('user.mailPasswordView',$data->token_key);
                $m_data['data'] = $data;
                Mail::to([$data->mail])->send(new UserApprovalMail($m_data));
            // end email token_key
            return to_route('admin.users')->with('success', 'Saved successfully !');
         }else{
             return back()->with('error', 'Failed ! try again.');
         }
    }
    public function update(UserRequest $request,$slug=null)
    {
        $path = $this->path;
        $pan_file = $aadhar_file = $resume_file = $other_file = '';
        if ($request->pan_file) {
            $pan_file = 'mimes:jpeg,png,jpg,gif,svg|max:4096';
        }
        if ($request->aadhar_file) {
            $aadhar_file = 'mimes:jpeg,png,jpg,gif,svg|max:4096';
        }

        if ($request->resume_file) {
            $resume_file = 'mimes:jpeg,png,jpg,gif,svg|max:4096';
        }

        if ($request->other_file) {
            $other_file = 'mimes:jpeg,png,jpg,gif,svg|max:4096';
        }

        $time=rand(1111,9999).time();
        $data=User::where(['slug'=>$slug,'is_admin'=>1])->first();  

        if($data){
            $prePan = $data->pan_file;
            $preAadhar = $data->aadhar_file;
            $preResume = $data->resume_file;
            $preOtherFile = $data->other_file;

            if ($request->pan_file) {
                $panName='pan'.$time.'.'.$request->pan_file->extension();
                $data->pan_file=$path.$panName;
            }
            if ($request->aadhar_file) {
                $aadharName='aadhar'.$time.'.'.$request->aadhar_file->extension();
                $data->aadhar_file=$path.$aadharName;
            }

            if ($request->resume_file) {
                $resumeName='resume'.$time.'.'.$request->resume_file->extension();
                $data->resume_file=$path.$resumeName;
            }

            if ($request->other_file) {
                $otherFileName='other'.$time.'.'.$request->other_file->extension();
                $data->other_file=$path.$otherFileName;
            }

            
            $data->name=Helper::removetag($request->name);
            $data->mobile=Helper::removetag($request->contact);
            $data->email=Helper::removetag($request->email);
            $data->office_no=Helper::removetag($request->office_no);
            $data->office_email=Helper::removetag($request->office_email);
            $data->designation=Helper::removetag($request->designation);
            $data->additional_information=Helper::removetag($request->additional_information);
            // $pass = User::password();
            $pass = $request->password;
            $data->password=Hash::make($pass);
            $data->original_password=$pass;
            $data->qualification=Helper::removetag($request->qualification);
            $data->profession=Helper::removetag($request->profession);
             if($data->save()){

                if ($request->pan_file) {
                    $request->pan_file->move(public_path($path),$panName);
                    if(file_exists(public_path($prePan)) && $prePan){
                        unlink(public_path($prePan));
                    }
                }

                if ($request->aadhar_file) {
                    $request->aadhar_file->move(public_path($path),$aadharName);
                    if(file_exists(public_path($preAadhar)) && $preAadhar){
                        unlink(public_path($preAadhar));
                    }
                }

                if ($request->resume_file) {
                    $request->resume_file->move(public_path($path),$resumeName);
                    if(file_exists(public_path($preResume)) && $preResume){
                        unlink(public_path($preResume));
                    }
                }
                if ($request->other_file) {
                    $request->other_file->move(public_path($path),$otherFileName);
                    if(file_exists(public_path($preOtherFile)) && $preOtherFile){
                        unlink(public_path($preOtherFile));
                    }
                }

                $p_data = Pincode::with('taluk','taluk.city','taluk.city.state')->where(['status'=>1,'slug'=>$request->pincode])->first();

                if ($p_data) {
                    $chk = UserAddress::where(['user_id'=>$data->id])->first();
                    if ($chk) {
                        $u_add =$chk;
                    }else{
                        $u_add = new UserAddress;
                    }
                    $u_add->user_id = $data->id;
                    $u_add->address = Helper::removetag($request->address);
                    $u_add->state_id = $p_data->taluk->city->state->id;
                    $u_add->city_id = $p_data->taluk->city->id;
                    $u_add->taluk_id = $p_data->taluk->id;
                    $u_add->pincode_id = $p_data->id;
                    $u_add->full_address = json_encode(Pincode::fullAddress($request->pincode,Helper::removetag($request->address)));
                    $u_add->save();
                }
                //role
                $rhk = UserRole::where(['user_id'=>$data->id])->first();
                    if ($rhk) {
                        $u_role =$rhk;
                    }else{
                        $u_role = new UserRole;
                    }
                $u_role->user_id = $data->id;
                $u_role->role_id = Role::id($request->role);
                $u_role->save();
                return to_route('admin.users')->with('success', 'Updated successfully !');
             }else{
                 return back()->with('error', 'Failed ! try again.');
             }
        }else{
           return redirect()->route('admin.users')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
        $request->validate(['status'=>'required|numeric|in:1,2']);
        $data=User::where('slug',$slug)->where('is_admin',1)->first();
        if($data){
            if ($request->status==1) {
                //email
                    $m_data['subject'] = "Your Account verification for SSRDP’s Kaushal Path 1.0";
                    $data->update(['token_key'=>Helper::randtoken()]);
                    $m_data['link'] = route('user.mailPasswordView',$data->token_key);
                    $m_data['data'] = $data;
                    Mail::to([$data->email])->send(new UserApprovalMail($m_data));
                // end email token_key
            }
            $data->status=$request->status;
            $data->save();
            return back()->with('success', 'Status changed successfully !');
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        //return redirect()->back()->with('error', 'Failed ! try again.');
        $data=User::where('slug',$slug)->where('is_admin',1)->first();
        if($data->delete()){
            return back()->with('success', 'Removed successfully !');
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
    }

    public function trashedData(Request $request)
    {
        extract($_GET);
        $data=User::onlyTrashed()->where('is_admin',1)->orderBy('id','DESC');
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        $user_role = $request->user_role ?? '';
        if(isset($request->search) && !empty($request->search)){
             $data->where('name', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%");
        }
        if(isset($request->account_status) && !empty($request->account_status)){
             $data->where('status', $request->account_status);
        }
        if(isset($request->user_role) && !empty($request->user_role)){
            $role_id = Role::id($request->user_role);
             $data->where(function($query) use ($role_id){
                $query->whereHas('userRole', function($q) use($role_id) { 
                    $q->where('role_id', $role_id);
                });
             });
        }
        if (isset($export)) {
            $userExp = $data->get()->toArray();
            $arrays = [$userExp];
            return $this->dataExport($arrays);
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin.user.trashedList',compact('data','search','page','total','account_status','user_role'));

    }

    public function restoreData(Request $request,$slug)
    {
       $data=User::onlyTrashed()->where('slug',$slug)->where('is_admin',1)->first();
        if($data){
            $data->restore();
            return back()->with('success', 'Restored successfully !');
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
    }

    public function hardDltData($slug)
    {
        //return back()->with('error', 'Failed ! try again.');
        $data=User::onlyTrashed()->where('slug',$slug)->where('is_admin',1)->first();
        $prePan = $data->pan_file;
        $preAadhar = $data->aadhar_file;
        $preResume = $data->resume_file;
        $preOtherFile = $data->other_file;
        if($data->forceDelete()){
            if ($prePan && file_exists(public_path($prePan))) {
                        unlink(public_path($prePan));
                }

                if ($preAadhar && file_exists(public_path($preAadhar))) {
                        unlink(public_path($preAadhar));
                }

                if ($preResume && file_exists(public_path($preResume))) {
                        unlink(public_path($preResume));
                }
                if ($preOtherFile && file_exists(public_path($preOtherFile))) {
                        unlink(public_path($preOtherFile));
                }
            return back()->with('success', 'Permanent removed successfully !');
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
    }

    public function dataExport($arrays=[])
    {
        return Excel::download(new UserExport($arrays), 'user-data-'.date('d-m-y').'.xlsx');
    }
}
