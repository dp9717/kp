<x-admin-home-layout>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="breadcome-list">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="button-style-four btn-mg-b-10">
                        <a class="btn btn-custon-four btn-default text-success back" href="{{ route('admin.roles') }}" title="Back"><i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <ul class="breadcome-menu">
                        <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                        </li>
                        <li><span class="bread-blod">Trashed Roles</span>
                        </li>
                    </ul>
                </div>
            </div>
           
            <!--  -->
        </div>
    </div>
</div>
 <div class="static-table-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="sparkline8-hd">
                                <div class="main-sparkline8-hd">
                                    <h1>Trashed Roles ({{ $total }})
                                 </h1>
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
                                                  
                                                  <td class="">
                                                    {!! Html::decode(link_to_route('admin.restoreRole','<i class="fa fa fa-history restore"></i>',[$result->slug],['class'=>'btn btn-custon-four btn-default text-info restore','title'=>'Restore'])) !!}

                                                    {{--!! Html::decode(link_to_route('admin.hardDltRole','<i class="fa fa-trash"></i>',[$result->slug],['class'=>'btn btn-custon-four btn-default text-danger hardDlt','title'=>'Permanent Remove','onclick'=>'return removeData()'])) !!--}}
                                                    
                                                  </td>
                                                </tr>
                                               @empty
                                               <tr>
                                                  <td colspan="4" class="text-center">Data Not Available</td>
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
</x-admin-home-layout>
