<x-user-home-layout>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <h1>Total Attendence :  {{ $total }} </h1>
                        </div>
                         
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="{{ route('user.home') }}">Home</a> <span class="bread-slash">/</span>
                                </li>
                                <li><span class="bread-blod">Attendence</span>
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
                                    @if(\App\Models\ProcessAppFlow::permission(8,1))
                                        <a class="btn btn-custon-four btn-default text-success add" href="{{ route('user.addAttendence') }}" title="Add"><i class="fa fa-plus"></i></a>
                                    @endif
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
                                        {{ Form::select('student',$students,[$student],['class'=>'form-control','placeholder'=>'All Student','onchange'=>'this.form.submit()','id'=>'student']) }}
                                      </div>
                                  </div>--}}
                                    <div class="col-sm-12 col-md-1 main_serach">
                                        <div class="form-group">
                                             {{-- Form::text('search',$search,['class'=>'form-control','placeholder'=>'Search by batch code']) --}}
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
                                    <th>Batch</th>
                                    <th>Total Student</th>
                                    <th>Date</th>
                                    @forelse(\App\Models\Attendence::attendenceAry() as $p_key => $p_val)
                                        <th>{{$p_val}}</th>
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
                                         <p>Code : {{ $result->batch->slug ?? '' }}<br>
                                         Module : {{ json_decode($result->batch->module_ary)->name ?? '' }}<br>
                                         Centre : {{ $result->batch->location->name ?? '' }}</p>
                                      </td>
                                      <td>
                                         {{ $result->batch->students ? count($result->batch->students) : 0 }}
                                      </td>
                                      <td>
                                         {{ Helper::date($result->attendence_date,'d M Y') }}
                                      </td>
                                     
                                      @forelse(\App\Models\Attendence::attendenceAry() as $p_key => $p_val)
                                         <td>
                                             {{ \App\Models\Attendence::totAttendence($result->id,$p_key) }}
                                          </td>
                                        @empty
                                        @endforelse
                                      
                                      
                                      <td class="">

                                        <button type="button" class="btn btn-custon-four btn-default text-success view" data-slug="{{ $result->slug }}" title="View">
                                          <i class="fa fa-eye"></i>
                                        </button>
                                        
                                        @if(\App\Models\ProcessAppFlow::permission(8,count(\App\Models\Attendence::status())))
                                            {!! Html::decode(link_to_route('user.editAttendence','<i class="fa fa-edit"></i>',[ $result->slug ],['class'=>'btn btn-custon-four btn-default text-info edit','title'=>'Edit'])) !!}
                                        @endif
                                      </td>
                                    </tr>
                                   @empty
                                   <tr>
                                      <td colspan="{{5+count(\App\Models\Attendence::attendenceAry())}}" class="text-center">Data Not Available</td>
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

</x-user-home-layout>

<script type="text/javascript">
  $(document).ready(function () {
    $(document).on('click', '.view', function() {
      var slug = $(this).attr('data-slug');
      if (slug) {
          var url="{{ route('user.ajaxUserView') }}";
            $.ajax({
              type:"POST",
              url:url,
              data:{slug:slug , _token: '{{csrf_token()}}',type:'attendenceView'},
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
