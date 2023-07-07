<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\Module;
use App\Http\Requests\Admin\ModuleRequest;
use App\Exports\Admin\ModuleExport;
use Excel;
class AdminModuleController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index(Request $request)
    {
        extract($_GET);
        $data=Module::orderBy('id','DESC');
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        if(isset($request->search) && !empty($request->search)){
             $data->where('name', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%");
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
        return view('admin.module.list',compact('data','search','page','total','account_status'));

    }

    public function add($value='')
    {
        return view('admin.module.add');
    }
    public function edit($slug)
    {
        $data=Module::where('slug',$slug)->first();
        if($data){
            return view('admin.module.edit',['data'=>$data]);
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
        
    }

    public function insert(ModuleRequest $request)
    {
        $data=new Module;
        $data->name=Helper::removetag($request->name);
        $data->description=Helper::removetag($request->description);
        $data->duration=Helper::removetag($request->duration);
        
        $data->slug=Str::of(Helper::removetag(($request->name.' '.time().rand(11111,99999))))->slug('-');

         if($data->save()){
            return to_route('admin.modules')->with('success', 'Saved successfully !');
         }else{
             return back()->with('error', 'Failed ! try again.');
         }
    }
    public function update(ModuleRequest $request,$slug=null)
    {
        $data=Module::where(['slug'=>$slug])->first();  

        if($data){
            $data->name=Helper::removetag($request->name);
            $data->description=Helper::removetag($request->description);
            $data->duration=Helper::removetag($request->duration);
            
            $data->slug=Str::of(Helper::removetag(($request->name.' '.time().rand(11111,99999))))->slug('-');
            
             if($data->save()){
                return to_route('admin.modules')->with('success', 'Updated successfully !');
             }else{
                 return back()->with('error', 'Failed ! try again.');
             }
        }else{
           return redirect()->route('admin.modules')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
        $request->validate(['status'=>'required|numeric|in:1,2']);
        $data=Module::where('slug',$slug)->first();
        if($data){
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
        $data=Module::where('slug',$slug)->first();
        if($data->delete()){
            return back()->with('success', 'Removed successfully !');
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
    }

    public function trashedData(Request $request)
    {
        extract($_GET);
        $data=Module::onlyTrashed()->orderBy('id','DESC');
        $search = $request->search ?? '';
        $account_status = $request->account_status ?? '';
        if(isset($request->search) && !empty($request->search)){
             $data->where('name', 'LIKE', "%$request->search%")->orWhere('slug', 'LIKE', "%$request->search%");
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
        return view('admin.module.trashedList',compact('data','search','page','total','account_status'));

    }

    public function restoreData(Request $request,$slug)
    {
       $data=Module::onlyTrashed()->where('slug',$slug)->first();
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
        $data=Module::onlyTrashed()->where('slug',$slug)->first();
        if($data->forceDelete()){
            return back()->with('success', 'Permanent removed successfully !');
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
    }

    public function dataExport($arrays=[])
    {
        return Excel::download(new ModuleExport($arrays), 'module-data-'.date('d-m-y').'.xlsx');
    }
}
