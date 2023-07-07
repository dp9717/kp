<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;

class AdminRoleController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=Role::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin.role.list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
        $category = Role::category();
        return view('admin.role.add',['category'=>$category]);
    }
    public function edit($slug)
    {
        $data=Role::where('slug',$slug)->first();
        if($data){
            $category = Role::category();
            return view('admin.role.edit',['category'=>$category,'data'=>$data]);
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
        
    }

    public function insert(RoleRequest $request)
    {
        $data=new Role;
        $data->name=Helper::removetag($request->name);
        $data->category_id= $request->category;
        $data->slug=Str::of(Helper::removetag($request->name))->slug('-');
        if($data->save()){
            return to_route('admin.roles')->with('success', 'Saved successfully !');
        }else{
            return back()->with('error', 'Failed ! try again.');
        }
    }
    public function update(RoleRequest $request,$slug=null)
    {
        $time=time();
        $data=Role::where(['slug'=>$slug])->first();  
        if($data){
            $data->name=Helper::removetag($request->name);
            $data->slug=Str::of(Helper::removetag($request->name))->slug('-');
            $data->signature = $request->signature ? 1 : 0;
            if($data->save()){
                return to_route('admin.roles')->with('success', 'Saved successfully !');
            }else{
                return back()->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.roles')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
        $request->validate(['status'=>'required|numeric|in:1,2']);
       $data=$data=Role::where(['slug'=>$slug])->first();  
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
        return back()->with('error', 'Failed ! try again.');
        $data=Role::where('slug',$slug)->first();
        if($data->delete()){
            return back()->with('success', 'Removed successfully !');
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
    }

    public function trashedData($name='')
    {
        extract($_GET);
        $data=Role::onlyTrashed()->orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin.role.trashedList',compact('data','name','page','total'));

    }

    public function restoreData(Request $request,$slug)
    {
       $data=Role::onlyTrashed()->where('slug',$slug)->first();
        if($data){
            $data->restore();
            return back()->with('success', 'Restored successfully !');
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
    }

    public function hardDltData($slug)
    {
        return back()->with('error', 'Failed ! try again.');
        $data=Role::onlyTrashed()->where('slug',$slug)->first();
        if($data->forceDelete()){
            return back()->with('success', 'Permanent removed successfully !');
        }else{
           return back()->with('error', 'Failed ! try again.');
        }
    }

}
