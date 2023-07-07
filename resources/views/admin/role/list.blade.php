<x-admin-home-layout>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h1>Total Roles : {{ $total }} </h1>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><span class="bread-blod">Roles</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                       
                        <!--  -->
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table_area">
                        <div class="sparkline8-hd">
                            <div class="main-sparkline8-hd">
                                 <div class="button-style-four btn-mg-b-10">
                                    <a class="btn btn-custon-four btn-default text-success add" href="{{ route('admin.addRole') }}" title="Add"><i class="fa fa-plus"></i></a>
                                    {{--<a class="btn btn-custon-four btn-default text-success hardDltBtn" href="{{ route('admin.trashedRole') }}" title="Restore"><i class="fa fa-trash"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="sparkline8-graph">
                            <div class="static-table-list">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sr:</th>
                                            <th>Role</th>
                                            <th>Category</th>
                                             <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @forelse($data as $result)
                                            <tr>
                                              <td>{{ ++$page }}</td>
                                              <td>
                                                 {{$result->name}}
                                              </td>
                                              <td>
                                                 {{ \App\Models\Role::category($result->category_id) }}
                                              </td>
                                              <td>
                                              
                                                {!!Form::open(['route'=>['admin.changeRoleStatus',$result->slug],'file'=>'true'])!!}
                                                        {!! Form::select('status',['1'=>'Active','2'=>'Inactive'],[$result->status],['class'=>'form-control custom-select select2','onchange'=>'this.form.submit()','style'=>'width:100%'])!!}             
                                                   <span class="text-danger">{{ $errors->first('status')}}</span>               
                                                {!!Form::close()!!}
                                              </td>
                                              
                                              <td class="">
                                                {!! Html::decode(link_to_route('admin.editRole','<i class="fa fa-edit"></i>',[$result->slug],['class'=>'btn btn-custon-four btn-default text-info edit','title'=>'Edit'])) !!}

                                                {{--!! Html::decode(link_to_route('admin.removeRole','<i class="fa fa-trash"></i>',[$result->slug],['class'=>'btn btn-custon-four btn-default text-danger remove','title'=>'Remove','onclick'=>'return removeData()'])) !!--}}

                                                {{--!! Html::decode(link_to_route('admin.process_permission_view','<i class="fa fa-lock"></i>',[$result->slug],['class'=>'btn btn-custon-four btn-default text-info permission','title'=>'Permission'])) !!--}}
                                                
                                              </td>
                                            </tr>
                                           @empty
                                           <tr>
                                              <td colspan="5" class="text-center">Data Not Available</td>
                                            </tr>
                                          @endforelse
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 center-block pull-right pagination">
                                         {{$data->appends($_GET)->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</x-admin-home-layout>
