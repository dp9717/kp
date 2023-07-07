<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Module;

class AdminAjaxController extends Controller
{
    function __construct($foo = null)
    {
        $this->foo = $foo;
    }

    public function ajaxAdminView(Request $request)
    {
        switch ($request->type) {
            case 'userView':
                $data = User::withTrashed()->where(['slug'=>$request->slug, 'is_admin'=>1])->first();
                return view('admin.user.view',['data'=>$data]);
                break;
            case 'moduleView':
                $data = Module::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('admin.module.view',['data'=>$data]);
                break;
            case 'centreCreationView':
                $data = CentreCreation::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('admin.centre-creation.view',['data'=>$data]);
                break;
            case 'vendorView':
                $data = Vendor::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('admin.vendor.view',['data'=>$data]);
                break;
            case 'partnerView':
                $data = Partner::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('admin.partner.view',['data'=>$data]);
                break;
            case 'projectView':
                $data = Project::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('admin.project.view',['data'=>$data]);
                break;
            case 'batchView':
                $data = Batch::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('admin.batch.view',['data'=>$data]);
                break;
            case 'attendenceView':
                $data = Attendence::where(['slug'=>$request->slug])->first();
                return view('admin.attendence.view',['data'=>$data]);
                break;
            case 'assesmentView':
                $data = Assesment::where(['slug'=>$request->slug])->first();
                return view('admin.assesment.view',['data'=>$data]);
                break;
            case 'attendenceStudentView':
                $data = Batch::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('admin.attendence.batchStudentView',['data'=>$data]);
                break;
            case 'assesmentStudentView':
                $data = Batch::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('admin.assesment.batchStudentView',['data'=>$data]);
                break;
            case 'certificateView':
                $data = Certificate::where(['slug'=>$request->slug])->first();
                return view('admin.certificate.view',['data'=>$data]);
                break;
            case 'certificateVendorView':
                $data = Vendor::withTrashed()->where(['slug'=>$request->slug])->first();
                return view('admin.certificate.certificateVendorView',['data'=>$data]);
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
                return view('admin.ajax.addressDropdown',['data'=>$data,'type'=>$request->type]);
                break;
            case 'city':
                $city_id = City::where(['slug'=>$request->slug, 'status'=>1])->first()->id ?? 0;
                $data = Taluk::talukPluck($city_id);
                return view('admin.ajax.addressDropdown',['data'=>$data,'type'=>$request->type]);
                break;
            case 'taluk':
                $taluk_id = Taluk::where(['slug'=>$request->slug, 'status'=>1])->first()->id ?? 0;
                $data =Pincode::pincodePluck($taluk_id);
                return view('admin.ajax.addressDropdown',['data'=>$data,'type'=>$request->type]);
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
