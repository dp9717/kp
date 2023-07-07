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
use App\Models\AssesmentStudent;
use App\Models\Vendor;
use App\Models\Certificate;
use App\Models\ProcessAppFlow;
use App\Http\Requests\User\CertificateRequest;
use App\Exports\User\CertificateExport;
use Excel, PDF;
use File;
use ZipArchive;
use Response;
class UserCertificateController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
        $this->approvalDate = date('Y-m-d');
        $this->path = 'upload/certificate/';
    }
    public function index(Request $request)
    {
        $batches = Certificate::batchCertificatePluck();
        extract($_GET);
        $data=Certificate::orderBy('id','DESC');
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
                $students = Batch::batchCertificateStPluck($b->id);
            }
        }
        // if(isset($request->student) && !empty($request->student)){
        //     $s = BatchStudent::where(['slug'=>$student])->first();
        //     if ($s) {
        //         $data->where('student_id',$s->id);
        //     }
        // }
        // if (isset($export)) {
        //     $userExp = $data->with('student','batch')->get()->toArray();
        //     $arrays = [$userExp];
        //     return $this->dataExport($arrays);
        // }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('employee.certificate.list',compact('data','search','page','total','batch','batches', 'students','student'));

    }

    public function downloadCertificate($batch='', $student='', $slug='', $type=1)
    {
        if($batch && $student && $slug) {
            $partnerArr = array();
            $certificate=Certificate::orderBy('id','DESC');
            if($batch) {
                $certificate->where('batch_id', Batch::id($batch));
            }
            if($slug) {
                $certificate->where('slug', $slug);
            }
            $certificate = $certificate->first();
            $batchData = Batch::where('slug', $batch)->first();
            $projectPartners = $batchData->project->partners;
            foreach($projectPartners as $key => $val) {
                $partnerArr[] = $val->partner->name ?? '';
            }
            $studentData = BatchStudent::where('batch_id', Batch::id($batch))->where('slug', $student)->first();
            $assesmentData = AssesmentStudent::where('batch_id', Batch::id($batch))->where('student_id', $studentData->id)->first();
            $filename = 'certificate_'.$student.'_'.date('Ymdhis').'.pdf';
            $data = ['title' => 'Certificate PDF', 'certificate' => $certificate, 'batch' => $batchData, 'student' => $studentData, 'assesment' => $assesmentData, 'partners' => $partnerArr];
            $pdf = PDF::loadView('export.certificateDownloadPdf', $data)->setPaper('a4', 'landscape');
            if($type == 1){
                return $pdf->download($filename);
            } else {
                $pdf->save(public_path('upload/generatecertificatezip/'.$filename));
            }
        } else {
            return to_route('user.certificates')->with('failed', 'Wrong access or try again.');
        }
    }

    public function add($value='')
    {
        $batch = Certificate::batchPluck();
        $vendors = Certificate::printingVendor();
        return view('employee.certificate.add',['batch'=>$batch, 'vendors' => $vendors]);
    }
    public function edit($slug)
    {
        $s = count(Certificate::status());
        $data=Certificate::where(['slug' => $slug])->first();
        if($data){
            if (\App\Models\ProcessAppFlow::permission(10,count(\App\Models\Certificate::status()))) {
                $batch = Certificate::batchPluck();
                $vendors = Certificate::printingVendor();
                return view('employee.certificate.edit',['batch'=>$batch, 'vendors' => $vendors, 'data'=>$data]);
            }else{
               return back()->with('failed', 'Wrong access or try again.');
            }
        }else{
           return back()->with('failed', 'Wrong access or try again.');
        }
        
    }

    public function insert(CertificateRequest $request)
    {
        if(\App\Models\ProcessAppFlow::permission(10,1)){
            $isExists = Certificate::where('batch_id', Batch::id($request->batch))->count();
            if(!$isExists) {
                $logo1_file = $logo2_file = $logo3_file = '';
                $time=rand(1111,9999).time();
                $path = $this->path;

                $data=new Certificate;

                $name1 = isset($request->name[0]) ? $request->name[0] : '';
                $name2 = isset($request->name[1]) ? $request->name[1] : '';
                $name3 = isset($request->name[2]) ? $request->name[2] : '';

                $designation1 = isset($request->designation[0]) ? $request->designation[0] : '';
                $designation2 = isset($request->designation[1]) ? $request->designation[1] : '';
                $designation3 = isset($request->designation[2]) ? $request->designation[2] : '';

                $company1 = isset($request->company[0]) ? $request->company[0] : '';
                $company2 = isset($request->company[1]) ? $request->company[1] : '';
                $company3 = isset($request->company[2]) ? $request->company[2] : '';

                $signature1 = isset($request->signature[0]) ? $request->signature[0] : '';
                $signature2 = isset($request->signature[1]) ? $request->signature[1] : '';
                $signature3 = isset($request->signature[2]) ? $request->signature[2] : '';

                if ($request->logo1_file) {
                    $logo1_file = $request->logo1_file;
                    $logo1Name='logo1'.$time.'.'.$logo1_file->extension();
                    $data->logo1_file=$path.$logo1Name;
                }
                if ($request->logo2_file) {
                    $logo2_file = $request->logo2_file;
                    $logo2Name='logo2'.$time.'.'.$logo2_file->extension();
                    $data->logo2_file=$path.$logo2Name;
                }
                if ($request->logo3_file) {
                    $logo3_file = $request->logo3_file;
                    $logo3Name='logo3'.$time.'.'.$logo3_file->extension();
                    $data->logo3_file=$path.$logo3Name;
                }

                $data->batch_id=Helper::removetag(Batch::id($request->batch));
                $data->certi_heading=Helper::removetag($request->certificate_heading);

                $data->issued_on=Helper::date($request->issued_on,'Y-m-d');
                $data->certificate_type=Helper::removetag($request->certificate_validity);
                $data->validity_date = (($request->validity_date != "" || $request->validity_date != null) && $request->certificate_validity == 1) ? Helper::date($request->validity_date, 'Y-m-d') : '';

                $data->hard_copy=Helper::removetag($request->hard_copy);
                $data->needed_by=Helper::date($request->needed_by,'Y-m-d');
                
                $data->vendor_id=Helper::removetag(Vendor::id($request->vendor));
                $data->vendor_ary=Helper::removetag(Vendor::vendorAry(Vendor::id($request->vendor)));
                $data->additional_information=Helper::removetag($request->additional_information);
                $data->slug=Str::of(Helper::removetag((time().rand(11111,99999))))->slug('-');

                $data->name1 = Helper::removetag($name1);
                $data->designation1 = Helper::removetag($designation1);
                $data->company1 = Helper::removetag($company1);
                $data->name2 = Helper::removetag($name2);
                $data->designation2 = Helper::removetag($designation2);
                $data->company2 = Helper::removetag($company2);
                $data->name3 = Helper::removetag($name3);
                $data->designation3 = Helper::removetag($designation3);
                $data->company3 = Helper::removetag($company3);

                if ($signature1) {
                    $signature1Name='signature1'.$time.'.'.$signature1->extension();
                    $data->signature1=$path.$signature1Name;
                }
                if ($signature2) {
                    $signature2Name='signature2'.$time.'.'.$signature2->extension();
                    $data->signature2=$path.$signature2Name;
                }
                if ($signature3) {
                    $signature3Name='signature3'.$time.'.'.$signature3->extension();
                    $data->signature3=$path.$signature3Name;
                }

                $data->user_id = Auth()->user()->id;
                $data->user_ary = json_encode(User::userAry(Auth()->user()->id));
                if(\App\Models\ProcessAppFlow::permission(10,2)){
                    $data->status = 2;
                    $data->second_level_id = Auth()->user()->id;
                    $data->second_level_ary = json_encode(User::userAry(Auth()->user()->id));
                    $data->second_level_date = $this->approvalDate;
                }
                if($data->save()) {
                    /*code*/
                    $moduleData = Batch::where('slug', $request->batch)->first()->module_ary ?? '';
                    $mname = json_decode($moduleData)->name ?? '';
                    $cv = explode(' ', $mname);
                    $f = '';
                    if (count($cv)) {
                        foreach ($cv as $key => $value) {
                            $f .= $value[0];
                        }
                    }
                    /*endcode*/
                    $data->slug=Helper::ProcessUniqueCode($data->id,10,$f);
                    $data->save();

                    if ($request->logo1_file) {
                        $request->logo1_file->move(public_path($path),$logo1Name);
                    }
                    if ($request->logo2_file) {
                        $request->logo2_file->move(public_path($path),$logo2Name);
                    }
                    if ($request->logo3_file) {
                        $request->logo3_file->move(public_path($path),$logo3Name);
                    }
                    if ($signature1) {
                        $signature1->move(public_path($path),$signature1Name);
                    }
                    if ($signature2) {
                        $signature2->move(public_path($path),$signature2Name);
                    }
                    if ($signature3) {
                        $signature3->move(public_path($path),$signature3Name);
                    }
                }
            } else {
                return back()->with('failed', 'Certificate is already exists for this batch.');
            }
            return to_route('user.certificates')->with('success', 'Saved successfully !');
        }else{
             return back()->with('failed', 'Permission denied.');
         }
    }

    public function update(CertificateRequest $request,$slug=null)
    {
        $s = count(Certificate::status());
        $data=Certificate::where(['slug' => $slug])->first(); 
        if($data){
            if (\App\Models\ProcessAppFlow::permission(10,count(\App\Models\Certificate::status()))) {
                
                $path = $this->path;
                $time=rand(1111,9999).time();

                $logo1_file = $logo2_file = $logo3_file = '';
                $preLogo1_file = $data->logo1_file;
                $preLogo2_file = $data->logo2_file;
                $preLogo3_file = $data->logo3_file;

                $preSignature1 = $data->signature1;
                $preSignature2 = $data->signature2;
                $preSignature3 = $data->signature3;

                $name1 = isset($request->name[0]) ? $request->name[0] : '';
                $name2 = isset($request->name[1]) ? $request->name[1] : '';
                $name3 = isset($request->name[2]) ? $request->name[2] : '';

                $designation1 = isset($request->designation[0]) ? $request->designation[0] : '';
                $designation2 = isset($request->designation[1]) ? $request->designation[1] : '';
                $designation3 = isset($request->designation[2]) ? $request->designation[2] : '';

                $company1 = isset($request->company[0]) ? $request->company[0] : '';
                $company2 = isset($request->company[1]) ? $request->company[1] : '';
                $company3 = isset($request->company[2]) ? $request->company[2] : '';

                $signature1 = isset($request->signature[0]) ? $request->signature[0] : '';
                $signature2 = isset($request->signature[1]) ? $request->signature[1] : '';
                $signature3 = isset($request->signature[2]) ? $request->signature[2] : '';

                if ($request->logo1_file) {
                    $logo1_file = $request->logo1_file;
                    $logo1Name='logo1'.$time.'.'.$logo1_file->extension();
                    $data->logo1_file=$path.$logo1Name;
                }
                if ($request->logo2_file) {
                    $logo2_file = $request->logo2_file;
                    $logo2Name='logo2'.$time.'.'.$logo2_file->extension();
                    $data->logo2_file=$path.$logo2Name;
                }
                if ($request->logo3_file) {
                    $logo3_file = $request->logo3_file;
                    $logo3Name='logo2'.$time.'.'.$logo3_file->extension();
                    $data->logo3_file=$path.$logo3Name;
                }

                $data->batch_id=Helper::removetag(Batch::id($request->batch));
                $data->certi_heading=Helper::removetag($request->certificate_heading);

                $data->issued_on=Helper::date($request->issued_on,'Y-m-d');
                $data->certificate_type=Helper::removetag($request->certificate_validity);
                $data->validity_date = (($request->validity_date != "" || $request->validity_date != null) && $request->certificate_validity == 1) ? Helper::date($request->validity_date, 'Y-m-d') : '';

                $data->hard_copy=Helper::removetag($request->hard_copy);
                $data->needed_by=Helper::date($request->needed_by,'Y-m-d');
                
                $data->vendor_id=Helper::removetag(Vendor::id($request->vendor));
                $data->vendor_ary=Helper::removetag(Vendor::vendorAry(Vendor::id($request->vendor)));
                $data->additional_information=Helper::removetag($request->additional_information);

                $data->name1 = Helper::removetag($name1);
                $data->designation1 = Helper::removetag($designation1);
                $data->company1 = Helper::removetag($company1);
                $data->name2 = Helper::removetag($name2);
                $data->designation2 = Helper::removetag($designation2);
                $data->company2 = Helper::removetag($company2);
                $data->name3 = Helper::removetag($name3);
                $data->designation3 = Helper::removetag($designation3);
                $data->company3 = Helper::removetag($company3);

                if ($signature1) {
                    $signature1Name='signature1'.$time.'.'.$signature1->extension();
                    $data->signature1=$path.$signature1Name;
                }
                if ($signature2) {
                    $signature2Name='signature2'.$time.'.'.$signature2->extension();
                    $data->signature2=$path.$signature2Name;
                }
                if ($signature3) {
                    $signature3Name='signature3'.$time.'.'.$signature3->extension();
                    $data->signature3=$path.$signature3Name;
                }

                //$data->status = 2;
                $second_level_id = Auth()->user()->id;
                $second_level_ary = json_encode(User::userAry(Auth()->user()->id));
                $second_level_date = $this->approvalDate;

                if($data->save()) {
                    /*code*/
                    $moduleData = Batch::where('slug', $request->batch)->first()->module_ary ?? '';
                    $mname = json_decode($moduleData)->name ?? '';
                    $cv = explode(' ', $mname);
                    $f = '';
                    if (count($cv)) {
                        foreach ($cv as $key => $value) {
                            $f .= $value[0];
                        }
                    }
                    /*endcode*/
                    $data->slug=Helper::ProcessUniqueCode($data->id,10,$f);
                    $data->save();

                    if ($request->logo1_file) {
                        $request->logo1_file->move(public_path($path),$logo1Name);
                        if(file_exists(public_path($preLogo1_file)) && $preLogo1_file){
                            unlink(public_path($preLogo1_file));
                        }
                    }
                    if ($request->logo2_file) {
                        $request->logo2_file->move(public_path($path),$logo2Name);
                        if(file_exists(public_path($preLogo2_file)) && $preLogo2_file){
                            unlink(public_path($preLogo2_file));
                        }
                    }
                    if ($request->logo3_file) {
                        $request->logo3_file->move(public_path($path),$logo3Name);
                        if(file_exists(public_path($preLogo3_file)) && $preLogo3_file){
                            unlink(public_path($preLogo3_file));
                        }
                    }
                    if ($signature1) {
                        $signature1->move(public_path($path),$signature1Name);
                        if(file_exists(public_path($preSignature1)) && $preSignature1){
                            unlink(public_path($preSignature1));
                        }
                    }
                    if ($signature2) {
                        $signature2->move(public_path($path),$signature2Name);
                        if(file_exists(public_path($preSignature2)) && $preSignature2){
                            unlink(public_path($preSignature2));
                        }
                    }
                    if ($signature3) {
                        $signature3->move(public_path($path),$signature3Name);
                        if(file_exists(public_path($preSignature3)) && $preSignature3){
                            unlink(public_path($preSignature3));
                        }
                    }
                    return to_route('user.certificates')->with('success', 'Saved successfully !');
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

    public function bulkCertificate(Request $request)
    {
        $zip = new ZipArchive;
        $student = explode(',', $request->student);
        $batch = explode(',', $request->batch);
        $certificate = explode(',', $request->certificate);
        foreach($student as $key => $st) {
            $this->downloadCertificate($batch[$key], $st, $certificate[$key], 2);
        }
        $fileName = 'certificates_'.date('Ymdhis').'.zip';
        $fiArr = array();
        if ($zip->open(public_path('upload/generatecertificatezip/'.$fileName), ZipArchive::CREATE) === TRUE)
        {
            $files = File::files(public_path('upload/generatecertificatezip/'));
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $extension = pathinfo($relativeNameInZipFile, PATHINFO_EXTENSION);
                if($extension == 'pdf'){
                    $zip->addFile($value, $relativeNameInZipFile);
                }
                $fiArr[] = $relativeNameInZipFile;
            }
            $zip->close();
        }
        foreach ($fiArr as $key => $fl) {
            unlink('public/upload/generatecertificatezip/'.$fl);
        }
        $path = 'public/upload/generatecertificatezip/'.$fileName;
        return Response::json([
                'success' => true,
                'path' => $path
            ], 200);
    }

    public function dataExport($arrays=[])
    {
        return Excel::download(new CertificateExport($arrays), 'certificate-data-'.date('d-m-y').'.xlsx');
    }
}

