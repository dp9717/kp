<x-admin-home-layout>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">

                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <h1>Total Project : {{ $total }} </h1>
                            </div>
                             
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><span class="bread-blod">Project</span>
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
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="button-style-four btn-mg-b-10">
                                            <!--
                                            <a class="btn btn-custon-four btn-default text-success hardDltBtn" href="{{ route('admin.trashedPartner') }}" title="Restore"><i class="fa fa-trash"></i></a> -->
                                        </div>

                                    </div>
                                    <div class="col-md-9">
                                        {!! Form::open(['method'=>'GET','files'=>true])!!}
                                        <div class="row yemm_serachbox">
                                            
                                            <div class="col-sm-6 col-md-6">
                                              <div class="form-group">
                                                   
                                                {{ Form::select('account_status',\App\Models\Project::status(),[$account_status],['class'=>'form-control','placeholder'=>'Status']) }}
                                              </div>
                                          </div>
                                            <div class="col-sm-12 col-md-5 main_serach">
                                                <div class="form-group">
                                                     {{ Form::text('search',$search,['class'=>'form-control','placeholder'=>'Search by name']) }}
                                                     {!! Html::decode(Form::button('<i class="fa fa-search"></i>',['type' => 'submit', 'class'=>'btn btn-dark'])) !!}
                                                </div>
                                          </div>
                                          <div class="col-sm-12 col-md-1 exportSec">
                                                <div class="form-group">
                                                     <button class="btn btn-custon-four btn-default text-success exportBtn" title="Export" name="export"><i class="fa fa-file-excel-o"></i></button>
                                                </div>
                                          </div>
                                      </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            <!-- search -->
                           
                            <!-- end search -->
                        </div>
                        <div class="sparkline8-graph">
                            <div class="static-table-list">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sr:</th>
                                            <th>Name</th>
                                            <th>Duration</th>
                                            <th>Funded By</th>
                                            <th>EST Fund Value</th>
                                            <th>Unique code</th>
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
                                                 {{$result->duration }}
                                              </td>
                                              <td>
                                                 {{\App\Models\Project::fundedby($result->funded_by) }}
                                              </td>
                                              <td>
                                                 {{$result->est_fund_value }}
                                              </td>
                                              <td>
                                                 {{$result->slug}}
                                              </td>
                                              <td>
                                              
                                                {{ \App\Models\Project::status($result->status)}} 
                                              </td>
                                              
                                              <td class="">
                                                <button type="button" class="btn btn-custon-four btn-default text-success view" data-slug="{{ $result->slug }}" title="View">
                                                  <i class="fa fa-eye"></i>
                                                </button>
                                                    {!! Html::decode(link_to_route('admin.editProject','<i class="fa fa-edit"></i>',[$result->slug],['class'=>'btn btn-custon-four btn-default text-info edit','title'=>'Edit'])) !!}

                                                    {!! Html::decode(link_to_route('admin.removeProject','<i class="fa fa-trash"></i>',[$result->slug],['class'=>'btn btn-custon-four btn-default text-danger remove','title'=>'Remove','onclick'=>'return removeData()'])) !!}
                                              </td>
                                            </tr>
                                           @empty
                                           <tr>
                                              <td colspan="8" class="text-center">Data Not Available</td>
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

<script type="text/javascript">
  $(document).ready(function () {
    $(document).on('click', '.view', function() {
      var slug = $(this).attr('data-slug');
      if (slug) {
          var url="{{ route('admin.ajaxAdminView') }}";
            $.ajax({
              type:"POST",
              url:url,
              data:{slug:slug , _token: '{{csrf_token()}}',type:'projectView'},
              beforeSend: function(){
              // $('#preloader').show();
              },
              success:function(response){
                if (response) {
                    $('#PrimaryModalhdbgcl .modal-body').html(response);
                    $('#PrimaryModalhdbgcl').modal('show');
                }
               // $('#preloader').hide();
              }
            });
      }
    });
  });
</script>