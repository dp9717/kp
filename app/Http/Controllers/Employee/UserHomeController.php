<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use App\Helpers\Helper;

use App\Models\Role;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Taluk;
use App\Models\Pincode;
use App\Models\UserRole;
use App\Models\UserAddress;
use App\Models\CentreCreation;
use App\Models\Batch;
use App\Models\Project;
use App\Models\Module;
class UserHomeController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->path = 'upload/user/';
    }

    public function home(Request $request)
    {
        //Filtering Vars
        $centre_stats = $request->centre_stats ?? '';
        $module_stats = $request->module_stats ?? '';
        $project_stats = $request->project_stats ?? '';
        
        //Common Filter Data DropDown Array
        $projectArrList = Project::where('status', 3)->orderBy('name', 'Asc')->pluck('name', 'slug');
        $centreArrList = CentreCreation::where('status', 3)->orderBy('name', 'Asc')->pluck('name', 'slug');
        $moduleArrList = Module::where('status', 1)->pluck('name', 'slug');

        //Get General Data 
        $centres = CentreCreation::with('batch', 'batch.students')->where('status', 3)->orderBy('name', 'Asc');
        $batches = Batch::where('status', 5)->get();
        $projects = Project::orderBy('name', 'Asc')->get();

        //Training Stat
        $moduleArr = $completedBatchArr = $progressBatchArr = $compBgColorArr = $progBgColorArr = [];
        
        $moduleData = Module::with('batch')->select('name', 'id')->where('status', 1);
        if(isset($module_stats) && !empty($module_stats)) {
            $moduleData->where('id', Module::id($module_stats))->get();
        }
        $modules = $moduleData->get();
        
        if(isset($modules) && !empty($modules)) {
            foreach ($modules as $m_key => $m_value) {
                array_push($moduleArr, $m_value->name);
                $compBatch = $progBatch = 0;
                if(isset($m_value->batch) && !empty($m_value->batch)) {
                    foreach ($m_value->batch as $b_key => $b_value) {
                        $days = \App\Helpers\Helper::diffInDays($b_value->end_date, date('Y-m-d'));
                        if($days >= 1) {
                            $progBatch+=1;
                        } else if($days < 1) {
                            $compBatch+=1;
                        }
                    }
                }
                array_push($completedBatchArr, $compBatch);
                array_push($progressBatchArr, $progBatch);
                array_push($compBgColorArr, '#0fd960');
                array_push($progBgColorArr, '#fa916f');
            }
        }

        //Centres Stat
        if(isset($centre_stats) && !empty($centre_stats)) {
            $centreList = $centres->where('name', 'LIKE', $centre_stats.'%');
        } 
        $centreList = $centres->get();

        //Demographic Data
        $noOfCandidate = \App\Models\CommonModel::getTotalBatchStudents($batches);
        $states = CentreCreation::with('batch', 'batch.students')->where('status', 3)->get()->groupBy('state_id')->count();
        $district = CentreCreation::with('batch', 'batch.students')->where('status', 3)->get()->groupBy('city_id')->count();         
        $demographicData = [
            'centre' => CentreCreation::with('batch', 'batch.students')->where('status', 3)->count(),
            'batch' => $batches->count(),
            'nofcandidate' => $noOfCandidate,
            'state' => $states,
            'district' => $district
        ];
        return view('employee.home', compact('projectArrList', 'centreArrList', 'moduleArrList', 'centre_stats', 'module_stats', 'project_stats', 'centreList', 'projects', 'moduleArr', 'completedBatchArr', 'progressBatchArr', 'compBgColorArr', 'progBgColorArr', 'demographicData'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('user.login');
    }

     public function profile(Request $request)
    {
        $data=User::where('id',auth()->user()->id)->where('is_admin',1)->first();
        $role = Role::rolePluck();
        $state = State::statePluck(); 
        $city = City::cityPluck($data->userAddress->userState->id ?? 0);
        $taluk = Taluk::talukPluck($data->userAddress->userCity->id ?? 0);
        $pincode =Pincode::pincodePluck($data->userAddress->userTaluk->id ?? 0);
        return view('employee.auth.profile', [
            'role'=>$role,'state'=>$state,'city'=>$city,'taluk'=>$taluk,'pincode'=>$pincode,'pincode'=>$pincode,'data'=>$data
        ]);
    }

    public function profileSave(Request $request)
    {
        $request->validate(['name'=>'required','email'=>'required|email|unique:App\Models\User,email,'.auth()->user()->id]);

        $path = $this->path;
        $pan_file = $aadhar_file = $resume_file = $other_file = '';
        if ($request->pan_file) {
            $pan_file = 'mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        if ($request->aadhar_file) {
            $aadhar_file = 'mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        if ($request->resume_file) {
            $resume_file = 'mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        if ($request->other_file) {
            $other_file = 'mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $time=rand(1111,9999).time();

        $data = User::find(auth()->user()->id);
        

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

        if ($data->save()) {
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
                // //role
                // $rhk = UserRole::where(['user_id'=>$data->id])->first();
                //     if ($rhk) {
                //         $u_role =$rhk;
                //     }else{
                //         $u_role = new UserRole;
                //     }
                // $u_role->user_id = $data->id;
                // $u_role->role_id = Role::id($request->role);
                // $u_role->save();
            return to_route('user.profile')->with('success','Profile updated successfully');
        }else{
            return to_route('user.profile')->with('failed','Try again');
        }

    }

    public function passwordSave(Request $request)
    {
        $request->validate(['current_password'=>'required','new_password'=>'required|min:8|same:confirm_password|different:current_password']);
        if (\Hash::check($request->current_password, auth()->user()->password)) 
       { 
            $user=User::where(['id'=>auth()->user()->id])->first();
           $user->fill([
            'password' => \Hash::make($request->new_password),
            'original_password' => $request->new_password
            ])->save();

            return redirect()->route('user.profile')->with('success', 'Password changed Successfully');

        } else {

            return redirect()->route('user.profile')->with('failed','Sorry ! Current password does not match');
        }
    }
}
