<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;

use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Taluk;
use App\Models\Pincode;
use App\Models\CentreCreation;
use App\Models\Vendor;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Batch;
use App\Models\Attendence;
use App\Models\Assesment;
use App\Models\Certificate;
class UserAjaxController extends Controller
{
    public function ajaxUserView(Request $request)
    {
        switch ($request->type) {
            case 'centreCreationView':
                $data = CentreCreation::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('employee.centre-creation.view',['data'=>$data]);
                break;
            case 'vendorView':
                $data = Vendor::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('employee.vendor.view',['data'=>$data]);
                break;
            case 'partnerView':
                $data = Partner::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('employee.partner.view',['data'=>$data]);
                break;
            case 'projectView':
                $data = Project::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('employee.project.view',['data'=>$data]);
                break;
            case 'batchView':
                $data = Batch::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('employee.batch.view',['data'=>$data]);
                break;
            case 'attendenceView':
                $data = Attendence::where(['slug'=>$request->slug])->first();
                return view('employee.attendence.view',['data'=>$data]);
                break;
            case 'assesmentView':
                $data = Assesment::where(['slug'=>$request->slug])->first();
                return view('employee.assesment.view',['data'=>$data]);
                break;
            case 'attendenceStudentView':
                $data = Batch::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('employee.attendence.batchStudentView',['data'=>$data]);
                break;
            case 'assesmentStudentView':
                $data = Batch::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('employee.assesment.batchStudentView',['data'=>$data]);
                break;
            case 'certificateView':
                $data = Certificate::where(['slug'=>$request->slug])->first();
                return view('employee.certificate.view',['data'=>$data]);
                break;
            case 'certificateVendorView':
                $data = Vendor::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('employee.certificate.certificateVendorView',['data'=>$data]);
                break;
            default:
                echo "No data found";
                break;
        } 
    }
    public function ajaxAddressDropdown(Request $request)
    {
            
        switch ($request->type) {
            case 'state':
                $state_id = State::where(['slug'=>$request->slug, 'status'=>1])->first()->id ?? 0;
                $data =City::cityPluck($state_id);
                return view('employee.ajax.addressDropdown',['data'=>$data,'type'=>$request->type]);
                break;
            case 'city':
                $city_id = City::where(['slug'=>$request->slug, 'status'=>1])->first()->id ?? 0;
                $data = Taluk::talukPluck($city_id);
                return view('employee.ajax.addressDropdown',['data'=>$data,'type'=>$request->type]);
                break;
            case 'taluk':
                $taluk_id = Taluk::where(['slug'=>$request->slug, 'status'=>1])->first()->id ?? 0;
                $data =Pincode::pincodePluck($taluk_id);
                return view('employee.ajax.addressDropdown',['data'=>$data,'type'=>$request->type]);
                break;
            default:
                echo "";
                break;
        }
    }

    public function ajaxAddressByPincodeDropdown(Request $request)
    {
        //slug (pincode)
        $p_data = Pincode::with('taluk','taluk.city','taluk.city.state')->where(['status'=>1,'slug'=>$request->slug])->first();
        $res = ['state_name'=>'','city_name'=>'','taluk_name'=>'','pincode'=>''];
        if ($p_data) {
            $stname = $p_data->taluk->city->state->name ?? '';
            $cname = $p_data->taluk->city->name ?? '';
            $tname = $p_data->taluk->name ?? '';
            $res = ['state_name'=>$stname,'city_name'=>$cname,'taluk_name'=>$tname,'pincode'=>$p_data->slug];
        }
        echo json_encode($res);
    }
}
