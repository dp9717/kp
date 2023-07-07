<x-admin-home-layout>
    <div class="main-content">
        <div class="container-fluid dashboard_main">
            <div class="row">
                <div class="col-md-12">
                    <div class="top_header_dash">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="heading_dash">
                                    <h3>Hello Gurudev 👋🏼,</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="dash_right_icon">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <img src="{{ asset('public/images/user_setting.png') }}">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="{{ asset('public/images/notification.png') }}">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::open(['method'=>'GET','files'=>true])!!}
                    <div class="col-md-12">
                        <section class="pms_application">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Project Selection</label>
                                            {{ Form::select('proj',$projectArrList,[],['class'=>'form-control','id'=>'proj','placeholder'=>'Choose Project'])}}
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Centre Selection</label>
                                            {{ Form::select('centre',$centreArrList,[],['class'=>'form-control','id'=>'centre','placeholder'=>'Choose Centre'])}}
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>State</label>
                                            <select class="form-control">
                                              <option>Status</option>
                                              <option>COE - Bengaluru</option>
                                              <option>COE - Bidadi</option>
                                              <option>CEO - Mysuru</option>
                                              <option>CEO - Leh</option>
                                              <option>CEO - Khunti</option>
                                            </select>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> From</label>
                                                <input class="form-control" type="date" value="30-06-2023">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>To</label>
                                                <input class="form-control" type="date" value="01-07-2023">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="col-md-9 dashboard_outer">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="dash_manual_box">
                                    <div class="box_top">
                                        @php
                                            $totProjects = $projects->count();
                                            $approvedProjects = $projects->where('status', 3)->count();
                                            $pendingProjects = $projects->where('status', 1)->count();
                                            $prjPercent = ($approvedProjects / $totProjects)* 100;
                                        @endphp
                                        <h4>Project’s Summary ( 2022-23)</h4>
                                        <div class="box">
                                            <div class="chart project_sum_chart" data-percent="{{ $prjPercent }}" data-scale-color="#68A691">
                                                <span>{{$prjPercent}}%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="project_prograss_bar">
                                        <h5>Approved -  {{ $approvedProjects }}</h5>
                                        <div class="progress skill-bar">
                                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="{{ $prjPercent }}" aria-valuemin="0" aria-valuemax="100">    
                                            </div>
                                        </div>
                                        <h6>Total  Projects - {{ $totProjects }}</h6>
                                    </div>
                                    <ul class="projects_count">
                                        <li>Completed - 100</li>
                                        <li>In Progress - 100</li>
                                        <li>Pending - {{ $pendingProjects }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="dash_manual_box">
                                    <div class="box_top">
                                        <h4>Projects</h4>
                                        <div class="projects_type">
                                            <span>Type:</span> 
                                            {{ Form::select('project_stats',Helper::filterPrjType(),[$project_stats],['class'=>'form-control','id'=>'project_stats','placeholder'=>'Choose Status','onchange'=>'this.form.submit()'])}}
                                        </div>
                                    </div>
                                    <div class="projects_table">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Project Name</th>
                                                    <th>Tat</th>
                                                    <th>Started On</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($projects->where('status', 3) as $p_key => $p_val)
                                                    @php
                                                        $Days = Helper::diffInDays($p_val->mou_end_date, date('Y-m-d'));
                                                        if($Days > 1) {
                                                            $tatDays= $Days + 1;
                                                        } else {
                                                            $tatDays= $Days - 1;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $p_val->name }}</td>
                                                        <td>{{ $tatDays + 1 }} Days</td>
                                                        <td>{{ Helper::date($p_val->mou_start_date, 'd/m/y') }}</td>
                                                        <td><button class="btn complet">Completed</button></td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                                <tr>
                                                    <td>AOL- Rural D......</td>
                                                    <td>26 Days</td>
                                                    <td>09:30:12 - 28/03/23</td>
                                                    <td><button class="btn exte">Extended</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="dash_manual_box">
                                    <div class="box_top">
                                        <h4>Student's Journey - Summary</h4>
                                        <div class="projects_type">
                                            <span>Type:</span> 
                                            <select>
                                                <option>All</option>    
                                                <option>type</option>    
                                                <option>type</option>    
                                                <option>type</option>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="traning_chart" id="bar1-chart">
                                        <canvas id="barchart1"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="dash_manual_box">
                                    <div class="box_top">
                                        <h4>Traning Stats</h4>
                                        <div class="projects_type">
                                            <span>Type:</span> 
                                            {{ Form::select('module_stats',$moduleArrList,[$module_stats],['class'=>'form-control','id'=>'module_stats','placeholder'=>'Choose Module', 'onchange'=>'this.form.submit()'])}}
                                        </div>
                                    </div>
                                    <div class="traning_chart" id="bar2-chart">
                                        <canvas id="barchart2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dash_manual_box">
                                    <div class="box_top">
                                        <h4>Centre Stats</h4>
                                        <div class="state_search_box">
                                            <input type="text" name="centre_stats" placeholder="Type to search" value="{{ $centre_stats }}">
                                            <button class="btn search_icon" type="submit">
                                                <img src="{{ asset('public/images/search_icon.png') }}">
                                            </button>
                                        </div>
                                        <div class="projects_type">
                                            <span>Type:</span> 
                                            <select>
                                                <option>All</option>    
                                                <option>type</option>    
                                                <option>type</option>    
                                                <option>type</option>    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="projects_table Centre_stats">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Centre Name</th>
                                                    <th>Training in prog</th>
                                                    <th>NO of admission</th>
                                                    <th>Enrolled</th>
                                                    <th>Available</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($centreList as $centre)
                                                    @php
                                                        $totBatch = $totAdmission = $totEnrolledSt = $totAvailable = 0;

                                                        $totBatch = $centre->batch->count();
                                                        $totAdmission = $totBatch * 20;

                                                        $totEnrolledSt = \App\Models\CommonModel::getTotalBatchStudents($centre->batch);
                                                    
                                                        $totAvailable = $totAdmission - $totEnrolledSt;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $centre->name ?? '' }}</td>
                                                        <td>{{ $totBatch }}</td>
                                                        <td>{{ $totAdmission }}</td>
                                                        <td>{{ $totEnrolledSt }}</td>
                                                        <td>{{ $totAvailable }}</td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dash_manual_box demographic">
                                    <div class="box_top">
                                        <h4>Demographic stats</h4>
                                    </div>
                                    <div class="state_list">
                                        <ul>
                                            <li>Centre’s <strong>{{ $demographicData['centre'] }}</strong></li>
                                            <li>Batch <strong>{{ $demographicData['batch'] }}</strong></li>
                                            <li>No of candidates <strong>{{ $demographicData['nofcandidate'] }}</strong></li>
                                            <li>States <strong>{{ $demographicData['state'] }}</strong></li>
                                            <li>Districts <strong>{{ $demographicData['district'] }}</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dash_manual_box demographic">
                                    <div class="box_top">
                                        <h4>Service ticket Stats</h4>
                                    </div>
                                    <div class="state_list">
                                        <ul>
                                            <li>Total <strong>10</strong></li>
                                            <li class="reso">Resolved <strong>10</strong></li>
                                            <li class="pannd">Pending <strong>10</strong></li>
                                            <li>Avg Res Time <strong>10</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="announcements_box">
                            <div class="announ_heading">
                                <h3>Announcements</h3>
                                <a href="#" class="open_slider_btn">+</a>
                            </div>
                            <div class="announ_slider">
                                <div class="owl-carousel owl-theme">
                                    <div class="item">
                                        <div class="sldier_profile">
                                            <img src="{{ asset('public/images/gurudav_img.png') }}">
                                            <span>Gurudev</span>
                                        </div>
                                        <img src="{{ asset('public/images/art_logo01.png') }}" class="center_logo">
                                        <p>qui dolorem ipsum, quia dolor sit amet consectetur adipisci velit, sed quia non numquam eius modi tempora incidunt, </p>
                                        <button class="btn">Mark As read</button>
                                    </div>
                                    <div class="item">
                                        <div class="sldier_profile">
                                            <img src="{{ asset('public/images/gurudav_img.png') }}">
                                            <span>Gurudev</span>
                                        </div>
                                        <img src="{{ asset('public/images/art_logo01.png') }}" class="center_logo">
                                        <p>qui dolorem ipsum, quia dolor sit amet consectetur adipisci velit, sed quia non numquam eius modi tempora incidunt, </p>
                                        <button class="btn">Mark As read</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="announcements_box event">
                            <div class="announ_heading">
                                <h3>Upcoming Events</h3>
                                <a href="#" class="open_event_btn">+</a>
                            </div>
                            <div class="event_box_inner">
                                <ul>
                                    <li>
                                        <img src="{{ asset('public/images/calendar.png') }}">
                                        Today From 03:00 PM till 4:30 PM
                                    </li>
                                    <li>
                                        <img src="{{ asset('public/images/calendar.png') }}">
                                        Today From 03:00 PM till 4:30 PM
                                    </li>
                                    <li>
                                        <img src="{{ asset('public/images/calendar.png') }}">
                                        Today From 03:00 PM till 4:30 PM
                                    </li>
                                    <li>
                                        <img src="{{ asset('public/images/calendar.png') }}">
                                        Today From 03:00 PM till 4:30 PM
                                    </li>
                                    <li>
                                        <img src="{{ asset('public/images/calendar.png') }}">
                                        Today From 03:00 PM till 4:30 PM
                                    </li>
                                </ul>
                            </div>                    
                        </div>
                    </div>
                {!! Form::Close() !!}
            </div> 
        </div>
    </div>
</x-admin-home-layout> 
<script type="text/javascript">
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        autoplay:false,
        nav:true,
        dots: false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    })
</script>

<script type="text/javascript">
    $(".open_slider_btn").click(function(){
      $(".announ_slider").toggleClass("open_slider", 1000, "easeOutSine");
    });

     $(".open_event_btn").click(function(){
      $(".event_box_inner").toggleClass("open_event", 1000, "easeOutSine");
    });
</script>
<script type="text/javascript">
    $(function() {
      $('.chart').easyPieChart({
        size: 45,
        barColor: "#68A691",
        scaleLength: 0,
        lineWidth: 5,
        trackColor: "#CBD5E1",
        lineCap: "circle",
        animate: 2000,
      });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.progress .progress-bar').css("width",
            function() {
                return $(this).attr("aria-valuenow") + "%";
            }
        )
    });
</script>
<script type="text/javascript">
    (function ($) {
     "use strict";
         /*----------------------------------------*/
        /*  1.  Bar Chart
        /*----------------------------------------*/

        var ctx = document.getElementById("barchart1");
        var barchart1 = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Enrolled", "Assessed", "Certified", "Placed"],
                datasets: [{
                    label: 'Completed',
                    data: [25000, 19000, 30000, 50000],
                    backgroundColor: [
                        '#0fd960',
                        '#0fd960',
                        '#0fd960',
                        '#0fd960'
                    ],
                }, {
                    label: 'Pending',
                    data: [40000, 50000, 60000, 20000],
                    backgroundColor: [
                        '#fa916f',
                        '#fa916f',
                        '#fa916f',
                        '#fa916f'
                    ],
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                scales: {
                    xAxes: [{
                        //barThickness: 2,  // number (pixels) or 'flex'
                        //maxBarThickness: 5, 
                        ticks: {
                            autoSkip: true,
                            maxRotation: 0,
                            fontColor: "#000", // this here
                        },
                        barPercentage: 1.0,
                        categoryPercentage: 0.4,
                        gridLines: {
                            display:false
                        },
                    }],
                    yAxes: [{
                        ticks: {
                            autoSkip: true,
                            maxRotation: 0,
                            fontColor: "#0F88D9", // this here
                            min: 0,
                            callback: (val) => {
                                if (!val) return 0;
                                const units = ['', 'K', 'M', 'B'];
                                const k = 1000;
                                const magnitude = Math.floor(Math.log(val) / Math.log(k));
                                return (
                                  val / Math.pow(k, magnitude) + ' ' + units[magnitude]
                                );
                            },
                        },
                        gridLines: {
                            display:false
                        },
                    }]
                }
            }
        });

        /*----------------------------------------*/
        /*  2.  Bar Chart
        /*----------------------------------------*/

        var ctx = document.getElementById("barchart2");
        var barchart2 = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($moduleArr),
                datasets: [{
                    label: 'Completed',
                    data: @json($completedBatchArr),
                    backgroundColor: @json($compBgColorArr),
                }, {
                    label: 'In Progress',
                    data: @json($progressBatchArr),
                    backgroundColor: @json($progBgColorArr),
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                scales: {
                    xAxes: [{
                        //barThickness: 2,  // number (pixels) or 'flex'
                        //maxBarThickness: 5, 
                        ticks: {
                            autoSkip: true,
                            maxRotation: 0,
                            fontColor: "#000", // this here
                        },
                        barPercentage: 1.0,
                        categoryPercentage: 0.4,
                        gridLines: {
                            display:false
                        },
                    }],
                    yAxes: [{
                        ticks: {
                            autoSkip: true,
                            maxRotation: 0,
                            fontColor: "#0F88D9", // this here
                            min: 0,
                            // callback: (val) => {
                            //     if (!val) return 0;
                            //     const units = ['', 'K', 'M', 'B'];
                            //     const k = 1000;
                            //     const magnitude = Math.floor(Math.log(val) / Math.log(k));
                            //     return (
                            //       val / Math.pow(k, magnitude) + ' ' + units[magnitude]
                            //     );
                            // },
                        },
                        gridLines: {
                            display:false
                        },
                    }]
                }
            }
        });
    })(jQuery); 
</script>