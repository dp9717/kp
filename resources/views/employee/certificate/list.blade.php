<x-user-home-layout>

<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <h1>Total Certificate :  {{ $total }} </h1>
                        </div>
                         
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="{{ route('user.home') }}">Home</a> <span class="bread-slash">/</span>
                                </li>
                                <li><span class="bread-blod">Certificate</span>
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
                                    @if(\App\Models\ProcessAppFlow::permission(10,1))
                                        <a class="btn btn-custon-four btn-default text-success add" href="{{ route('user.addCertificate') }}" title="Add"><i class="fa fa-plus"></i></a>
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-9">
                                {!! Form::open(['method'=>'GET','files'=>true])!!}
                                <div class="row yemm_serachbox">
                                  <div class="col-sm-12 col-md-5">
                                      <div class="form-group">
                                        {{ Form::select('batch',$batches,[$batch],['class'=>'form-control','placeholder'=>'All Batches','onchange'=>'$("#student").val(null);this.form.submit()']) }}
                                      </div>
                                  </div>
                                  <div class="col-sm-12 col-md-5">
                                      <div class="form-group">
                                        {{ Form::select('student',$students,[$student],['class'=>'form-control', 'id' => 'student', 'placeholder'=>'All Student','onchange'=>'this.form.submit()']) }}
                                      </div>
                                  </div>
                                    <div class="col-sm-12 col-md-1 main_serach">
                                        <div class="form-group">
                                             {!! Html::decode(Form::button('<i class="fa fa-search"></i>',['type' => 'submit', 'class'=>'btn btn-dark'])) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-1 exportSec">
                                        <div class="form-group">
                                             <button class="btn btn-custon-four btn-default text-success certiBtn" type="button" title="Download Certificate" name="export"><i class="fa fa-file-excel-o"></i></button>
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
                  <div class="download_load" style="display: none;">
                    <span>Certificate is downloading <img src="{{ asset('public/images/simple_loading.gif') }}" alt=""></span>
                  </div>
                    <div class="static-table-list">
                        <table class="table" id="dom-jqry1">
                            <thead>
                                <tr>
                                  <th class="nosort checkallCerti sorting_asc sticky_scroll col-scr-1" tabindex="0" aria-controls="dom-jqry1" rowspan="1" colspan="1" aria-sort="ascending" aria-label=": activate to sort column descending"><i class="fa fa-check"></i></th>
                                  <th>Sr:</th>
                                  <th>Batch code</th>
                                  <th>Student</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @forelse($data as $result)
                                  @php
                                    $stData = \App\Models\BatchStudent::where('batch_id', $result->batch_id);
                                    if(isset($student) && !empty($student)) {
                                      $stData->where('slug', $student);
                                    }
                                    $students = $stData->get();
                                  @endphp
                                  @if(isset($students) && !empty($students))
                                    @foreach($students as $s_key => $s_val)
                                      <tr>
                                        <td class="sticky_scroll col-scr-1">
                                            <div class="checkbox-fade fade-in-primary m-0">
                                                <label>
                                                    <input type="checkbox" class="global_filter" id="global_regex" name="certiCheck" data-batch="{{ \App\Models\Batch::slug($result->batch_id) }}" data-certificate="{{ $result->slug }}" value="{{ $s_val->slug }}">
                                                    <span class="cr">
                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ ++$page }}</td>
                                        <td>
                                           {{ \App\Models\Batch::slug($result->batch_id) }}
                                        </td>
                                        <td>{{ $s_val->name }}</td>
                                           
                                        </td>
                                        <td class="">
                                          <button type="button" class="btn btn-custon-four btn-default text-success view" data-slug="{{ $result->slug }}" title="View">
                                            <i class="fa fa-eye"></i>
                                          </button>
                                          
                                          @if(\App\Models\ProcessAppFlow::permission(10,count(\App\Models\Certificate::status())))
                                              {!! Html::decode(link_to_route('user.editCertificate','<i class="fa fa-edit"></i>',[ $result->slug ],['class'=>'btn btn-custon-four btn-default text-info edit','title'=>'Edit'])) !!}
                                          @endif

                                          {!! Html::decode(link_to_route('user.downloadCertificate','<i class="fa fa-file-pdf-o"></i>',[ 'batch' => \App\Models\Batch::slug($result->batch_id), 'student' => $s_val->slug, 'slug' => $result->slug ],['class'=>'btn btn-custon-four btn-default text-info download','title'=>'Edit'])) !!}
                                        </td>
                                      </tr>
                                    @endforeach
                                  @endif
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
              data:{slug:slug , _token: '{{csrf_token()}}',type:'certificateView'},
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

    $('.checkallCerti').on('click', function() {
      if($('#dom-jqry1').find('input[name="certiCheck"]').prop('checked') == true) {
        $('#dom-jqry1').find('input[name="certiCheck"]').prop('checked', false); 
      } else {
        $('#dom-jqry1').find('input[name="certiCheck"]').prop('checked', true); 
      }
    });

    $(document).on('click', '.certiBtn', function() {
      $(".download_load").css('display', 'block');
      var url="{{ route('user.bulkCertificate') }}";
      var site_url = "{{ env('APP_URL') }}"
      var stArray = [];
      var batchArray = [];
      var certiArray = [];
      $.each($("input[name='certiCheck']:checked"), function(){            
        stArray.push($(this).val());
        batchArray.push($(this).data('batch'));
        certiArray.push($(this).data('certificate'));
      });
      if (stArray.length > 0) {
        var student;
        var batch;
        var certificate;
        student = stArray.join(',') ;
        batch = batchArray.join(',');
        certificate = certiArray.join(',');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: url,
          type: "post",
          data: { 'student': student, 'batch': batch, 'certificate': certificate},
          success: function(response){
            $(".download_load").css('display', 'none');
            window.location = site_url + response.path;
          }
        });
      }
    });
  });
</script>