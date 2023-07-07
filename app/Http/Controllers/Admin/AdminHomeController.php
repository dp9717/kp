<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\Role;
use App\Models\Setting;

use App\Models\ProcessAssign;
use App\Models\ProcessPermission;
use App\Models\ProcessAppFlow;
use App\Models\CentreCreation;
use App\Models\Batch;
use App\Models\Project;
use App\Models\Module;
class AdminHomeController extends Controller
{
    function __construct($foo = null)
    {
        $this->foo = $foo;
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
        return view('admin.home', compact('projectArrList', 'centreArrList', 'moduleArrList', 'centre_stats', 'module_stats', 'project_stats', 'centreList', 'projects', 'moduleArr', 'completedBatchArr', 'progressBatchArr', 'compBgColorArr', 'progBgColorArr', 'demographicData'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('admin.login');
    }

    public function profile(Request $request)
    {
        return view('admin.auth.profile', [
            'user' => auth()->user(),
        ]);
    }

    public function profileSave(Request $request)
    {
        $request->validate(['name'=>'required','email'=>'required|email|unique:App\Models\User,email,'.auth()->user()->id]);
        $data = User::find(auth()->user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        if ($data->save()) {
            return to_route('admin.profile')->with('success','Profile updated successfully');
        }else{
            return to_route('admin.profile')->with('failed','Try again');
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

            return redirect()->route('admin.profile')->with('success', 'Password changed Successfully');

        } else {

            return redirect()->route('admin.profile')->with('failed','Sorry ! Current password does not match');
        }
    }

    public function setting(Request $request)
    {
        return view('admin.setting',['data'=>Setting::first()]);
    }

    public function settingSave(Request $request)
    {
        $path = 'upload/setting/';
        $logo =$moblogo =$fevicon ='';
        if ($request->logo) {
            $logo = 'mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        if ($request->moblogo) {
            $moblogo = 'mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        if ($request->fevicon) {
           // $fevicon = 'mimes:jpeg,png,jpg,gif,svg,ico|max:2048';
        }

        $request->validate(['title'=>'required','logo'=>$logo]);

        $preLogo = $preMoblogo = $preFevicon = '';
        if (Setting::count()) {
            $data = Setting::first();
            $preLogo = $data->logo;
            $preMoblogo = $data->moblogo;
            $preFevicon = $data->fevicon;
        }else{
            $data = new Setting;
        }
        $data->title = $request->title;
        if ($request->logo) {
            $logoName='logo.'.$request->logo->extension();
            $data->logo=$path.$logoName;
        }
        if ($request->moblogo) {
            $moblogoName='moblogo.'.$request->moblogo->extension();
            $data->moblogo=$path.$moblogoName;
        }
        if ($request->fevicon) {
            $feviconName='fevicon.'.$request->fevicon->extension();
            $data->fevicon=$path.$feviconName;
        }
        if ($data->save()) {
            if ($request->logo) {
                if(file_exists(public_path($preLogo)) && $preLogo){
                    unlink(public_path($preLogo));
                }
                 $request->logo->move(public_path($path),$logoName);
            }

            if ($request->moblogo) {
                if(file_exists(public_path($preMoblogo)) && $preMoblogo){
                    unlink(public_path($preMoblogo));
                }
                 $request->moblogo->move(public_path($path),$moblogoName);
            }

            if ($request->fevicon) {
                if(file_exists(public_path($preFevicon)) && $preFevicon){
                    unlink(public_path($preFevicon));
                }
                 $request->fevicon->move(public_path($path),$feviconName);
            }
            return to_route('admin.setting')->with('success','Setting updated successfully');
        }else{
            return to_route('admin.setting')->with('failed','Try again');
        }

    }

    public function process_assign_view(Request $request)
    {
        return view('admin.process_assign.view');
    }

    public function process_assign(Request $request)
    {
        ProcessAssign::truncate();
        if (isset($request->process_assign) && count($request->process_assign)) {
            foreach($request->process_assign as $key => $val){
                $rold_id = Role::where('slug',$key)->first()->id;
                if (count($val)) {
                    foreach($val as $p_key => $p_val){
                        ProcessAssign::insert(['role_id'=>$rold_id,'process_id'=>$p_val]);
                    }
                }
            }
        }
        return back()->with('success','saved successfully');
    }

    public function process_permission_view(Request $request,$slug='')
    {
        $role = Role::where('slug',$slug)->first();
        if ($role) {
            $process = ProcessAssign::where(['role_id'=>$role->id])->get();
            return view('admin.process_permission.view',['role'=>$role,'process'=>$process]);
        }else{
            return back()->with('failed','Try again');
        }
        
    }

    public function process_permission(Request $request,$slug='')
    {
        $role = Role::where('slug',$request->slug)->first();
        ProcessPermission::where(['role_id'=>$role->id])->delete();
        if (isset($request->process_permission) && count($request->process_permission)) {
            foreach($request->process_permission as $key => $val){
                if (count($val)) {
                    foreach($val as $p_key => $p_val){
                        ProcessPermission::insert(['role_id'=>$role->id,'process_id'=>$key,'permission_id'=>$p_val]);
                    }
                }
            }
        }
        return to_route('admin.roles')->with('success','saved successfully');
    }

    public function process_flow($value='')
    {
        $proc = Helper::process();
       
        return view('admin.process_permission.process_flow',['process'=>$proc]);
        
    }

    public function process_flow_save(Request $request)
    {
        if (isset($request->process_flow) && count($request->process_flow)) {
            foreach($request->process_flow as $pro_id => $val){
                //print_r($pro_id);
                ProcessAppFlow::where(['process_id'=>$pro_id])->delete();
                if (count($val)) {
                    foreach($val as $status_id => $p_val){
                        //print_r($status_id);
                        if (count($p_val)) {
                            foreach($p_val as $role_key => $role_slug){
                                $role_id = Role::where('slug',$role_slug)->first()->id;
                                ProcessAppFlow::insert(['role_id'=>$role_id,'process_id'=>$pro_id,'status_id'=>$status_id]);  
                            }
                        }
                    }
                }
            }
        }
        return to_route('admin.process_flow')->with('success','saved successfully');
    }
}
