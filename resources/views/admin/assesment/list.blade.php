<x-admin-home-layout>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <h1>Total Assesment :  {{ $total }} </h1>
                        </div>
                         
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="{{ route('admin.home') }}">Home</a> <span class="bread-slash">/</span>
                                </li>
                                <li><span class="bread-blod">Assesment</span>
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
                                    
                                </div>

                            </div>
                            <div class="col-md-9">
                                {!! Form::open(['method'=>'GET','files'=>true])!!}
                                <div class="row yemm_serachbox">
                                    <div class="col-sm-12 col-md-5"></div>
                                  <div class="col-sm-12 col-md-5">
                                      <div class="form-group">
                                        {{ Form::select('batch',$batches,[$batch],['class'=>'form-control','placeholder'=>'All Batches','onchange'=>'$("#student").val(null);this.form.submit()']) }}
                                      </div>
                                  </div>
                                  {{--<div class="col-sm-12 col-md-5">
                                      <div class="form-group">
                                        {{ Form::select('student',$students,[$student],['class'=>'form-control', 'id' => 'student', 'placeholder'=>'All Student','onchange'=>'this.form.submit()']) }}
                                      </div>
                                  </div>--}}
                                    <div class="col-sm-12 col-md-1 main_serach">
                                        <div class="form-group">
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
                                    <th>Batch code</th>
                                    <th>Total Student</th>
                                    @forelse(\App\Models\Assesment::gradeView() as $g_key => $g_val)
                                        <th>Grade {{ $g_val }}</th>
                                    @empty
                                    @endforelse
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @forelse($data as $result)
                                    <tr>
                                      <td>{{ ++$page }}</td>
                                     
                                      <td>
                                         {{ \App\Models\Batch::slug($result->batch_id) }}
                                      </td>
                                      <td>
                                         {{ $result->batch->students ? count($result->batch->students) : 0 }}
                                      </td>
                                       @forelse(\App\Models\Assesment::gradeView() as $g_key => $g_val)
                                            <td>{{ \App\Models\Assesment::totGrade($result->id,$g_key) }}</td>
                                        @empty
                                        @endforelse
                                      
                                      <td class="">

                                        <button type="button" class="btn btn-custon-four btn-default text-success view" data-slug="{{ $result->slug }}" title="View">
                                          <i class="fa fa-eye"></i>
                                        </button>
                                            {!! Html::decode(link_to_route('admin.editAssesment','<i class="fa fa-edit"></i>',[ $result->slug ],['class'=>'btn btn-custon-four btn-default text-info edit','title'=>'Edit'])) !!}
                                      </td>
                                    </tr>
                                   @empty
                                   <tr>
                                      <td colspan="{{5+count(\App\Models\Assesment::gradeView())}}" class="text-center">Data Not Available</td>
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
              data:{slug:slug , _token: '{{csrf_token()}}',type:'assesmentView'},
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