<x-user-home-layout>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading">
                                   <h1>Add Batch</h1>
                                </div> 
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li><a href="{{ route('user.home') }}">Home</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><a href="{{ route('user.batches') }}">Batch</a> <span class="bread-slash">/</span>
                                    </li>
                                    <li><span class="bread-blod">Add</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                       
                        <!--  -->
                    </div>
                </div>
                <!-- pro -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form method="post" action="{{ route('user.saveBatch') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Batch</h1></div> 


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="project">Project</label>
                                        {{ Form::select('project',$projects,[],['class'=>'form-control','id'=>'project','placeholder'=>'Choose Project'])}}
                                        <span class="text-danger">{{ $errors->first('project') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trainer">Trainer</label>
                                        {{ Form::select('trainer',$trainers,[],['class'=>'form-control','id'=>'trainer','placeholder'=>'Choose Trainer'])}}
                                        <span class="text-danger">{{ $errors->first('trainer') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_date">Training Start Date</label>
                                        {{-- Form::date('start_date','',['class'=>'form-control','id'=>'start_date','placeholder'=>'Start Date'])--}}
                                        <div class="data-custon-pick" id="syncDate">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="start_date" class="form-control" id="" placeholder="Start Date">
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        {{-- Form::date('end_date','',['class'=>'form-control','id'=>'end_date','placeholder'=>'End Date'])--}}
                                        <div class="data-custon-pick" id="syncDate2">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="end_date" class="form-control" id="" placeholder="End Date">
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_time">Training Start Time</label>
                                        {{ Form::time('start_time','',['class'=>'form-control','id'=>'start_time','placeholder'=>'Start Time'])}}
                                        <span class="text-danger">{{ $errors->first('start_time') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="end_time">End Time</label>
                                        {{ Form::time('end_time','',['class'=>'form-control','id'=>'end_time','placeholder'=>'End Time'])}}
                                        <span class="text-danger">{{ $errors->first('end_time') }}</span>
                                    </div>
                                </div>

                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="modules">Training Module</label>
                                        {{ Form::select('module',$modules,[],['class'=>'form-control','id'=>'modules','placeholder'=>'Choose Module'])}}
                                        <span class="text-danger">{{ $errors->first('modules') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="location">Centre</label>
                                        {{ Form::select('location',$locations,[],['class'=>'form-control','id'=>'location','placeholder'=>'Choose Centre'])}}
                                        <span class="text-danger">{{ $errors->first('location') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stateCoOrdinators">State Co-Ordinator</label>
                                        {{ Form::select('state_co_ordinator',$stateCoOrdinators,[],['class'=>'form-control','id'=>'stateCoOrdinators','placeholder'=>'Choose State Co-Ordinator'])}}
                                        <span class="text-danger">{{ $errors->first('stateCoOrdinators') }}</span>
                                    </div>
                                </div>
                            <!--  -->
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="upload_file">Upload File</label>
                                        {{ Form::file('upload_file[]',['class'=>'form-control','id'=>'upload_file','placeholder'=>'Upload File','multiple'=>true])}}
                                        <span class="text-danger">{{ $errors->first('upload_file.*') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="form_section">
                            <div class="row">
                                <div class="col-md-12"> <h1>Additional information</h1></div>   
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::textarea('additional_information','',['class'=>'form-control','id'=>'designation','placeholder'=>'Additional information'])}}
                                        <span class="text-danger">{{ $errors->first('additional_information') }}</span>
                                    </div>
                                </div> 
                            </div>
                        </div> 
                        <!-- YLTP --> 
                        <div class="form_section">
                            <div class="col-md-12"> <h1>YLTP</h1></div> 
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="course_start_date">Course Start Date</label>
                                        {{-- Form::date('course_start_date','',['class'=>'form-control','id'=>'course_start_date','placeholder'=>'Course Start Date'])--}}
                                        <div class="data-custon-pick" id="syncDate3">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="course_start_date" class="form-control" id="" placeholder="Course Start Date">
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('course_start_date') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="course_end_date">Course End Date</label>
                                        {{-- Form::date('course_end_date','',['class'=>'form-control','id'=>'course_end_date','placeholder'=>'Course End Date'])--}}
                                        <div class="data-custon-pick" id="syncDate4">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="course_end_date" class="form-control" id="" placeholder="Course End Date">
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('course_end_date') }}</span>
                                    </div>
                                </div>
                               <div class="col-md-6">
                                 <div class="form-group">
                                      {{ Form::label('Name','Teacher Name') }}
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                 <div class="form-group">
                                      {{ Form::label('Code','Teacher Code') }}
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                         
                                <div class="row">
                                   <div class="col-md-6">
                                     <div class="form-group">
                                           {{ Form::text('tch_name[]','',['class'=>'form-control','placeholder'=>'Name','required'=>true]) }}
                                          <span class="text-danger">{{ $errors->first('name.*')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                     <div class="form-group">
                                          {{ Form::text('tch_code[]','',['class'=>'form-control','placeholder'=>'Code']) }}
                                          <span class="text-danger">{{ $errors->first('tch_code.*')}}</span>
                                        </div>
                                    </div>
                                </div>
                              
                                <div id="GoodsT">
                                </div>
                                <div class="col-md-12 text-right">
                                    {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plusT'])) !!}
                                </div>
                            </div>
                        </div> 
                        <!-- student --> 
                        <div class="form_section">
                            <div class="col-md-12"> <h1>Student</h1></div> 
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                      {{ Form::label('Import Student Data','Import Student Data') }}
                                      {{ Form::file('import_student',['class'=>'form-control','id'=>'import_student','placeholder'=>'Import File','multiple'=>false])}}
                                        <span class="text-danger">{{ $errors->first('import_student') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('Download File Format','Download File Format') }}
                                    <div class="form-group">
                                      <a class="btn btn-custon-four btn-default text-success export" href="{{ route('user.exportStudentFormat') }}" title="Export"><i class="fa fa-file-excel-o"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-4">
                                 <div class="form-group">
                                      {{ Form::label('Name','Name') }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                 <div class="form-group">
                                      {{ Form::label('Email','Email') }}
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                 <div class="form-group">
                                      {{ Form::label('Contact','Contact') }}
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                         
                                <div class="row">
                                   <div class="col-md-4">
                                     <div class="form-group">
                                           {{ Form::text('st_name[]','',['class'=>'form-control','placeholder'=>'Name','required'=>false]) }}
                                          <span class="text-danger">{{ $errors->first('name.*')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                     <div class="form-group">
                                          {{ Form::email('st_email[]','',['class'=>'form-control','placeholder'=>'Email']) }}
                                          <span class="text-danger">{{ $errors->first('email.*')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                     <div class="form-group">
                                          {{ Form::text('st_contact[]','',['class'=>'form-control','placeholder'=>'Contact']) }}
                                          <span class="text-danger">{{ $errors->first('Contact.*')}}</span>
                                        </div>
                                    </div>
                                </div>
                              
                                <div id="Goods">
                                </div>
                                <div class="col-md-12 text-right">
                                    {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                                </div>
                            </div>
                        </div> 
                          
                       
                                      
                        <div class="col-md-12 form_btnbox">
                            <button type="submit" class="btn btn-custon-save btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
                <!-- end pro -->
                
                <!--  -->
               
            </div>
            
        </div>
    </div>
</x-user-home-layout>
<script type="text/javascript">

  /*student*/
    $('.plus').click(function(){
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD Goods" id="removeItemRow'+cls+'"><div class="col-md-4"> <div class="form-group"><input class="form-control" placeholder="Name" id="" name="st_name[]" type="text" required></div></div><div class="col-md-4"> <div class="form-group"> <input class="form-control" placeholder="Email" id="" name="st_email[]" type="email"></div></div><div class="col-md-3"> <div class="form-group"><input class="form-control" placeholder="Contact" id="" name="st_contact[]" type="text"> </div></div><div class="col-md-1 ItemRemove"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash"></i></button></div></div></div>';
    $('#Goods').append(clone);
    var cls = $('.Goods').length;
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
       // ($(this).text(p_sr++));
    });
    if (cls) {
     // $('.trash').show();
    }
  });
  function removeItemRow(argument) {
   // alert();
    $('#removeItemRow'+argument).remove();
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  }

    /*techer*/
    $('.plusT').click(function(){
    var cls = $('.GoodsT').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="row newGD GoodsT" id="removeItemRowT'+cls+'"><div class="col-md-6"> <div class="form-group"><input class="form-control" placeholder="Name" id="" name="tch_name[]" type="text" required></div></div><div class="col-md-5"> <div class="form-group"> <input class="form-control" placeholder="Code" id="" name="tch_code[]" type="text" required ></div></div><div class="col-md-1 ItemRemoveT"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash"></i></button></div></div></div>';
    $('#GoodsT').append(clone);
    var cls = $('.GoodsT').length;
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
       // ($(this).text(p_sr++));
    });
    if (cls) {
      //$('.trash').show();
    }
  });
  function removeItemRowT(argument) {
   // alert();
    $('#removeItemRowT'+argument).remove();
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  } 
</script>