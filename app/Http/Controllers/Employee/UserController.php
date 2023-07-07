<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Captcha;
use Validator;
use App\Helpers\Helper;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Role;
use App\Models\State;
use App\Models\City;
use App\Models\Taluk;
use App\Models\Pincode;
use App\Models\UserRole;
use App\Models\UserAddress;
use App\Http\Requests\User\UserRequest;
class UserController extends Controller
{
    function __construct($foo = null)
    {
        $this->foo = $foo;
        $this->path = 'upload/user/';
    }

    public function login($value='')
    {
        if (isset(auth()->user()->id) && auth()->user()->is_admin==1) {
            return to_route('user.home');
        }else if (isset(auth()->user()->id) && auth()->user()->is_admin==0) {
            return to_route('admin.home');
        }else{
            return view('employee.auth.login');
        } 
    }

    public function checkCapcha(Request $request)
    { 
        $validator =Validator::make($request->all(), ['captcha' => 'required|captcha', // this will validate captcha
        ],['captcha.captcha'=>'Captcha does not match..']);

        if ($validator->passes()) {
            return response()->json(['status'=>1,'msg'=>'Added new records.']);
        }


        return response()->json(['status'=>0,'msg'=>$validator->errors()->first('captcha')]);
    }

    public function refreshCaptcha(Request $request)
    {
        return response()->json([
            'captcha' => Captcha::img()
        ]);
    }

    public function chkLogin(Request $request)
    {
        $input = $request->all();
     
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
     
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        { 
            //if (auth()->user()->is_admin == 0) {
                return redirect()->route('user.home');
            // }else {
            //     echo 'user dashboard under maintenance';
            // }
        }else{
            return redirect()->route('user.login')
                ->with('failed','Email-Address And Password Are Wrong.');
        }
    }

    public function register($value='')
    {
        $role = Role::rolePluck();
        $state = State::statePluck();
        $city = [];//City::cityPluck();
        $taluk = [];//Taluk::talukPluck();
        $pincode =[];//Pincode::where('id','<',20)->pluck('pincode','slug');// Pincode::pincodePluck();
        $qualification = User::qualification();
        $profession = User::profession();
        return view('employee.auth.register',['role'=>$role,'state'=>$state,'city'=>$city,'taluk'=>$taluk,'pincode'=>$pincode,'pincode'=>$pincode,'qualification'=>$qualification,'profession'=>$profession]);
    }

    public function store(UserRequest $request)
    {
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
        $data->status=2;
        $data->qualification=Helper::removetag($request->qualification);
        $data->profession=Helper::removetag($request->profession);
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
            
            return to_route('user.login')->with('success', 'Account created ! Wait for system approval mail');
         }else{
             return back()->with('error', 'Failed ! try again.');
         }
    }

    public function mailPasswordView($value='')
    {
        $data=User::where('token_key',$value)->where('is_admin',1)->first();
        return view('employee.auth.mailPasswordView', ['data'=>$data]);
    }

    public function tokenStore(Request $request,$value='')
    {
        $request->validate(['new_password'=>'required|min:8','confirm_password'=>'required|same:new_password']);
        $data=User::where('token_key',$value)->where('is_admin',1)->first();
        if ($data) {
            $data->fill([
            'password' => \Hash::make($request->new_password),
            'original_password' => $request->new_password,'token_key'=>null
            ])->save();
            return to_route('user.login')->with('success', 'Password changed Successfully.');
        }else{
            return to_route('user.login')->with('error', 'Failed ! User not found.');
        }
    }
}
