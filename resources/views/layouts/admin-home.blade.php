<!doctype html>
<html class="no-js" lang="en">
@php 
    $h = \App\Models\Setting::first();
    $logo = $h->logo ?? 'img/logo/logo.png';
    $moblogo = $h->moblogo ?? 'img/logo/logosn.png';
    $fevicon = $h->fevicon ?? 'img/favicon.ico';
 @endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $h->title ?? config('app.name')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
        ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('public/'.$fevicon) }}">
    <!-- Google Fonts
        ============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
        ============================================ -->
    {{ Html::style('public/css/bootstrap.min.css') }}
    <!-- Bootstrap CSS
        ============================================ -->
    {{ Html::style("public/css/font-awesome.min.css") }}
    <!-- owl.carousel CSS
    ============================================ -->
    {{ Html::style("public/css/owl.carousel.css") }}
    {{ Html::style("public/css/owl.theme.css") }}
    {{ Html::style("public/css/owl.transitions.css") }}
    {{ Html::style("public/css/owl.carousel.min.css") }}
    {{ Html::style("public/css/owl.theme.default.min.css") }}
    <!-- animate CSS
    ============================================ -->
    {{ Html::style("public/css/animate.css") }}
    <!-- normalize CSS
    ============================================ -->
    {{ Html::style("public/css/normalize.css") }}
    <!-- meanmenu icon CSS
    ============================================ -->
    {{ Html::style("public/css/meanmenu.min.css") }}
    <!-- main CSS
    ============================================ -->
    {{ Html::style("public/css/main.css") }}
    <!-- educate icon CSS
    ============================================ -->
    {{ Html::style("public/css/educate-custon-icon.css") }}
    <!-- morrisjs CSS
    ============================================ -->
    {{ Html::style("public/css/morrisjs/morris.css") }}
    <!-- mCustomScrollbar CSS
    ============================================ -->
    {{ Html::style("public/css/scrollbar/jquery.mCustomScrollbar.min.css") }}
    <!-- metisMenu CSS
    ============================================ -->
    {{ Html::style("public/css/metisMenu/metisMenu.min.css") }}
    {{ Html::style("public/css/metisMenu/metisMenu-vertical.css") }}
    <!-- calendar CSS
    ============================================ -->
    {{ Html::style("public/css/calendar/fullcalendar.min.css") }}
    {{ Html::style("public/css/calendar/fullcalendar.print.min.css") }}
    <!-- style CSS
    ============================================ -->
    {{ Html::style("public/style.css") }}
    <!-- responsive CSS
    ============================================ -->
    {{ Html::style('public/css/responsive.css') }}
    <!-- modernizr JS
    ============================================ -->
    {{ Html::script('public/js/vendor/modernizr-2.8.3.min.js') }}
    <!-- graph -->
    {{ Html::style("public/css/c3/c3.min.css") }}

</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Start Left menu area -->

    <div class="left-sidebar-pro">
        <nav id="sidebar" class="sidebar_outer">
            <div class="sidebar-header">
                <a href="{{route('admin.home')}}"><img class="main-logo" src="{{url('public/'.$logo)}}" alt="" /></a>
                <strong><a href="{{route('admin.home')}}"><img src="{{url('public/'.$moblogo)}}" alt="" /></a></strong>
            </div>
            <div class="left-custom-menu-adp-wrap comment-scrollbar">
                <nav class="sidebar-nav left-sidebar-menu-pro">
                    <ul class="metismenu" id="menu1">
                        <li class="{{ Helper::classActiveByRouteName(['admin.home']) }}">
                            <a title="Landing Page" href="{{ route('admin.home') }}" aria-expanded="false"><img src="{{ url('public/img/dashboard_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">Dashboard</span></a>
                        </li>
                        <li class="{{ Helper::classActiveByRouteName(['admin.attendences','admin.editAttendence']) }}">
                                    <a class="has-arrow" href="all-courses.html" aria-expanded="false"><img src="{{ url('public/img/attendence_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">{{Helper::process(8)}}</span></a>
                                    <ul class="submenu-angle" aria-expanded="false">
                                        <li><a title="Pending" href="{{ route('admin.attendences') }}" class="{{ Helper::classActiveByRouteName(['admin.attendences','admin.editAttendence']) }}"><span class="mini-sub-pro">All</span></a></li>
                                    </ul>
                                </li>
                           
                                <li class="{{ Helper::classActiveByRouteName(['admin.certificates','admin.editCertificate']) }}">
                                    <a class="has-arrow" href="all-courses.html" aria-expanded="false"><img src="{{ url('public/img/certificate_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">{{Helper::process(10)}}</span></a>
                                    <ul class="submenu-angle" aria-expanded="false">
                                        <li><a title="All" href="{{ route('admin.certificates') }}" class="{{ Helper::classActiveByRouteName(['admin.certificates','admin.editCertificate']) }}"><span class="mini-sub-pro">All</span></a></li>
                                    </ul>
                                </li> 
                           
                                <li class="{{ Helper::classActiveByRouteName(['admin.assesments','admin.editAssesment']) }}">
                                    <a class="has-arrow" href="all-courses.html" aria-expanded="false"><img src="{{ url('public/img/assesment_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">{{Helper::process(9)}}</span></a>
                                    <ul class="submenu-angle" aria-expanded="false">
                                        <li><a title="Pending" href="{{ route('admin.assesments') }}" class="{{ Helper::classActiveByRouteName(['admin.assesments','admin.editAssesment']) }}"><span class="mini-sub-pro">All</span></a></li>
                                    </ul>
                                </li>
                        <li class="{{ Helper::classActiveByRouteName(['admin.batches','admin.editBatch','admin.trashedBatch','admin.batchStatusView','admin.batchApprovedList']) }}">
                                    <a class="has-arrow" href="#" aria-expanded="false"><img src="{{ url('public/img/batch_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">{{Helper::process(3)}}</span></a>
                                    <ul class="submenu-angle" aria-expanded="false">
                                        <li><a title="Pending" href="{{ route('admin.batches') }}" class="{{ Helper::classActiveByRouteName(['admin.batches','admin.editBatch']) }}"><span class="mini-sub-pro">Pending</span></a></li>
                                        <li><a title="Approved" href="{{ route('admin.batchApprovedList') }}" class="{{ Helper::classActiveByRouteName(['admin.batchApprovedList']) }}"><span class="mini-sub-pro">Approved</span></a></li>
                                    </ul>
                        <li class="{{ Helper::classActiveByRouteName(['admin.projects','admin.projectApprovedList','admin.editProject','admin.trashedProject','admin.projectStatusView']) }}">
                                    <a class="has-arrow" href="#" aria-expanded="false"><img src="{{ url('public/img/project_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">{{Helper::process(1)}}</span></a>
                                    <ul class="submenu-angle" aria-expanded="false">
                                        <li><a title="Pending" href="{{ route('admin.projects') }}" class="{{ Helper::classActiveByRouteName(['admin.projects','admin.editProject']) }}"><span class="mini-sub-pro">Pending</span></a></li>
                                        <li><a title="Approved" href="{{ route('admin.projectApprovedList') }}" class="{{ Helper::classActiveByRouteName(['admin.projectApprovedList']) }}"><span class="mini-sub-pro">Approved</span></a></li>
                                    </ul>
                                </li>
                        <li class="{{ Helper::classActiveByRouteName(['admin.centreCreations','admin.editCentreCreation','admin.trashedCentreCreation','admin.centreCreationStatusView','admin.centreCreationApprovedList']) }}">
                            <a class="has-arrow" href="#" aria-expanded="false"><img src="{{ url('public/img/center_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">{{Helper::process(2)}}</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Pending" href="{{ route('admin.centreCreations') }}" class="{{ Helper::classActiveByRouteName(['admin.centreCreations','admin.editCentreCreation']) }}"><span class="mini-sub-pro">Pending</span></a></li>
                                <li><a title="Approved" href="{{ route('admin.centreCreationApprovedList') }}" class="{{ Helper::classActiveByRouteName(['admin.centreCreationApprovedList']) }}"><span class="mini-sub-pro">Approved</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Helper::classActiveByRouteName(['admin.vendors','admin.editVendor','admin.trashedVendor','admin.vendorStatusView','admin.vendorApprovedList']) }}">
                            <a class="has-arrow" href="all-courses.html" aria-expanded="false"><img src="{{ url('public/img/vendor_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">{{Helper::process(4)}}</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Pending" href="{{ route('admin.vendors','admin.editVendor') }}" class="{{ Helper::classActiveByRouteName(['admin.vendors']) }}"><span class="mini-sub-pro">Pending</span></a></li>
                                <li><a title="Approved" href="{{ route('admin.vendorApprovedList') }}" class="{{ Helper::classActiveByRouteName(['admin.vendorApprovedList']) }}"><span class="mini-sub-pro">Approved</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Helper::classActiveByRouteName(['admin.partners','admin.editPartner','admin.trashedPartner','admin.partnerStatusView','admin.partnerApprovedList']) }}">
                            <a class="has-arrow" href="all-courses.html" aria-expanded="false"><img src="{{ url('public/img/partner_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">{{Helper::process(5)}}</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Pending" href="{{ route('admin.partners') }}" class="{{ Helper::classActiveByRouteName(['admin.partners','admin.editPartner']) }}"><span class="mini-sub-pro">Pending</span></a></li>
                                <li><a title="Approved" href="{{ route('admin.partnerApprovedList') }}" class="{{ Helper::classActiveByRouteName(['admin.partnerApprovedList']) }}"><span class="mini-sub-pro">Approved</span></a></li>
                            </ul>
                        </li>
                        <li class="{{ Helper::classActiveByRouteName(['admin.users','admin.addUser','admin.editUser','admin.trashedUser']) }}">
                            <a class="has-arrow" href="#" aria-expanded="false"><img src="{{ url('public/img/user_icon2.png')}}" class="menu_icon_img" /> <span class="mini-click-non">User</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Add" href="{{ route('admin.addUser') }}" class="{{ Helper::classActiveByRouteName(['admin.addUser']) }}"><span class="mini-sub-pro">Add</span></a></li>

                                <li><a title="All" href="{{ route('admin.users') }}" class="{{ Helper::classActiveByRouteName(['admin.users','admin.editUser']) }}"><span class="mini-sub-pro">All</span></a></li>

                                <li><a title="Deleted" href="{{ route('admin.trashedUser') }}" class="{{ Helper::classActiveByRouteName(['admin.trashedUser']) }}"><span class="mini-sub-pro">Deleted</span></a></li>
                                
                            </ul>
                        </li>

                        
                        <li class="{{ Helper::classActiveByRouteName(['admin.modules','admin.addModule','admin.editModule','admin.trashedModule']) }}">
                            <a class="has-arrow" href="#" aria-expanded="false"><img src="{{ url('public/img/modules_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">Module</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Add" href="{{ route('admin.addModule') }}" class="{{ Helper::classActiveByRouteName(['admin.addModule']) }}"><span class="mini-sub-pro">Add</span></a></li>

                                <li><a title="All" href="{{ route('admin.modules') }}" class="{{ Helper::classActiveByRouteName(['admin.modules','admin.editModule']) }}"><span class="mini-sub-pro">All</span></a></li>

                                <li><a title="Deleted" href="{{ route('admin.trashedModule') }}" class="{{ Helper::classActiveByRouteName(['admin.trashedModule']) }}"><span class="mini-sub-pro">Deleted</span></a></li>
                                
                            </ul>
                        </li>
                       
                        <li class="{{ Helper::classActiveByRouteName(['admin.process_assign_view']) }}">
                            <a title="Landing Page" href="{{ route('admin.process_assign_view') }}" aria-expanded="false"><img src="{{ url('public/img/process_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">Assign Process</span></a>
                        </li>

                        <li class="{{ Helper::classActiveByRouteName(['admin.process_flow']) }}">
                            <a title="Landing Page" href="{{ route('admin.process_flow') }}" aria-expanded="false"><img src="{{ url('public/img/flow_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">Process Flow</span></a>
                        </li>

                        
                        <li class="{{ Helper::classActiveByRouteName(['admin.roles','admin.addRole','admin.editRole','admin.trashedRole']) }}">
                            <a class="has-arrow" href="#" aria-expanded="false"><img src="{{ url('public/img/role_icon.png')}}" class="menu_icon_img" /> <span class="mini-click-non">Role</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="Add" href="{{ route('admin.addRole') }}" class="{{ Helper::classActiveByRouteName(['admin.addRole']) }}"><span class="mini-sub-pro">Add</span></a></li>

                                <li><a title="All" href="{{ route('admin.roles') }}" class="{{ Helper::classActiveByRouteName(['admin.roles','admin.editRole']) }}"><span class="mini-sub-pro">All</span></a></li>

                                <li><a title="Deleted" href="{{ route('admin.trashedRole') }}" class="{{ Helper::classActiveByRouteName(['admin.trashedRole']) }}"><span class="mini-sub-pro">Deleted</span></a></li>
                            </ul>
                        </li>
                        
                       <!--  <li>
                            <a class="has-arrow" href="all-professors.html" aria-expanded="false"><span class="educate-icon educate-professor icon-wrap"></span> <span class="mini-click-non">Professors</span></a>
                            <ul class="submenu-angle" aria-expanded="false">
                                <li><a title="All Professors" href="all-professors.html"><span class="mini-sub-pro">All Professors</span></a></li>
                                <li><a title="Add Professor" href="add-professor.html"><span class="mini-sub-pro">Add Professor</span></a></li>
                                <li><a title="Edit Professor" href="edit-professor.html"><span class="mini-sub-pro">Edit Professor</span></a></li>
                                <li><a title="Professor Profile" href="professor-profile.html"><span class="mini-sub-pro">Professor Profile</span></a></li>
                            </ul>
                        </li> -->
                    </ul>
                </nav>
            </div>
        </nav>
    </div>
    <!-- End Left menu area -->
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
         <!-- <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                        <a href="{{route('admin.home')}}"><img class="main-logo" src="{{url('img/logo/logo.png')}}" alt="" /></a>
                    </div>
                </div>
            </div>
        </div> -->
        
        <div class="header-advance-area">
            <div class="header-top-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="header-top-wraper">
                                <div class="row">
                                    <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                        <div class="menu-switcher-pro">
                                            <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                    <i class="educate-icon educate-nav"></i>
                                                </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                        <div class="header-top-menu tabl-d-n">
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="header-right-info">
                                            <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                               
                                                <li class="nav-item {{ Helper::classOpenByRouteName(['admin.profile','admin.setting']) }}">
                                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                            <img src="img/product/pro4.jpg" alt="" />
                                                            <span class="admin-name">{{ auth()->user()->name ?? 'Account'}}</span>
                                                            <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                                                        </a>
                                                    <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                       
                                                        <li><a href="{{route('admin.profile')}}"><span class="edu-icon edu-user-rounded author-log-ic"></span>My Profile</a>
                                                        </li>
                                                        <li><a href="{{route('admin.setting')}}"><span class="edu-icon edu-settings author-log-ic"></span>Settings</a>
                                                        </li>
                                                        <li style="padding: 10px 20px;display: block;color: #303030;font-size: 14px;">

                                                            <form method="POST" action="{{ route('admin.logout') }}">
                                                                @csrf
                                                                    <button style="border:0px;background-color: white;" class="edu-icon edu-locked author-log-ic">Log Out</button>
                                                            </form>

                                                        </li>
                                                    </ul>
                                                </li>
                                               
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul class="mobile-menu-nav">
                                        <!-- <li><a data-toggle="collapse" data-target="#Charts" href="#">Home <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                            <ul class="collapse dropdown-header-top">
                                                <li><a href="{{route('admin.home')}}">Dashboard v.1</a></li>
                                                <li><a href="index-1.html">Dashboard v.2</a></li>
                                                <li><a href="index-3.html">Dashboard v.3</a></li>
                                                <li><a href="analytics.html">Analytics</a></li>
                                                <li><a href="widgets.html">Widgets</a></li>
                                            </ul>
                                        </li> -->
                                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                                        <li><a href="{{ route('admin.users') }}">User</a></li>
                                        <li><a href="{{ route('admin.process_assign_view') }}">Assign Process </a></li>
                                        <li><a href="{{ route('admin.process_flow') }}">Process Flow</a></li>
                                        <li><a href="{{ route('admin.roles') }}">Role</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu end -->
            
        </div>

         <div>
             
            @if(Session::has('success'))
                <div class="alert alert-success alertDiv" role="alert">
                    <strong>Success ! </strong> {{Session::get('success')}}
                </div>
            @elseif(Session::has('failed'))
                <div class="alert alert-danger alertDiv" role="alert">
                    <strong>Failed ! </strong> {{Session::get('failed')}}
                </div>
            @endif
         </div>                       
                                
        {{ $slot }}

        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-copy-right">
                            <p>Copyright © {{ date('Y') }} <strong>{{ $h->title ?? config('app.name')}}</strong>. All rights reserved. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- jquery
    ============================================ -->

    {{ Html::script('public/js/vendor/jquery-1.12.4.min.js') }}
    <!-- graph -->

    {{ Html::script('public/js/charts/Chart.js') }}
    {{ Html::script('public/js/c3-charts/d3.min.js') }}
    {{ Html::script('public/js/c3-charts/c3.min.js') }}
    {{ Html::script('public/js/c3-charts/c3-active.js') }}
    
    <!-- bootstrap JS
    ============================================ -->
    {{ Html::script('public/js/bootstrap.min.js') }}
    <!-- wow JS
    ============================================ -->
    {{ Html::script('public/js/wow.min.js') }}
    <!-- price-slider JS
    ============================================ -->
    {{ Html::script('public/js/jquery-price-slider.js') }}
    <!-- meanmenu JS
    ============================================ -->
    {{ Html::script('public/js/jquery.meanmenu.js') }}
    <!-- owl.carousel JS
    ============================================ -->
    {{ Html::script('public/js/owl.carousel.js') }}
    {{ Html::script('public/js/owl.carousel.min.js') }}
    <!-- sticky JS
    ============================================ -->
    {{ Html::script('public/js/jquery.sticky.js') }}
    <!-- scrollUp JS
    ============================================ -->
    {{ Html::script('public/js/jquery.scrollUp.min.js') }}
    <!-- counterup JS
    ============================================ -->
    {{ Html::script('public/js/counterup/jquery.counterup.min.js') }}
    {{ Html::script('public/js/counterup/waypoints.min.js') }}
    {{ Html::script('public/js/counterup/counterup-active.js') }}
    <!-- mCustomScrollbar JS
    ============================================ -->
    {{ Html::script('public/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}
    {{ Html::script('public/js/scrollbar/mCustomScrollbar-active.js') }}
    <!-- metisMenu JS
    ============================================ -->
    {{ Html::script('public/js/metisMenu/metisMenu.min.js') }}
    {{ Html::script('public/js/metisMenu/metisMenu-active.js') }}
    <!-- morrisjs JS
    ============================================ -->
    {{ Html::script('public/js/morrisjs/raphael-min.js') }}
    {{ Html::script('public/js/morrisjs/morris.js') }}
    {{ Html::script('public/js/morrisjs/morris-active.js') }}
    <!-- morrisjs JS
    ============================================ -->
    {{ Html::script('public/js/sparkline/jquery.sparkline.min.js') }}
    {{ Html::script('public/js/sparkline/jquery.charts-sparkline.js') }}
    {{ Html::script('public/js/sparkline/sparkline-active.js') }}
    <!-- calendar JS
    ============================================ -->
    {{ Html::script('public/js/calendar/moment.min.js') }}
    {{ Html::script('public/js/calendar/fullcalendar.min.js') }}
    {{ Html::script('public/js/calendar/fullcalendar-active.js') }}
    <!-- plugins JS
    ============================================ -->
    {{ Html::script('public/js/plugins.js') }}
    <!-- main JS
    ============================================ -->
    {{ Html::script('public/js/main.js') }}

    {{-- Html::script('public/js/easypiechart.min.js') --}}

    <!-- tawk chat JS
    ============================================ -->
    {{-- Html::script('public/js/tawk-chat.js') --}}
    @if(Session::has('success') || Session::has('failed'))
        <script type="text/javascript">
            setTimeout(function() {
                $('.alertDiv').fadeOut('slow');
            }, 1000);
        </script>
    @endif
    <!-- modal  -->
    <div class="modal modal-edu-general default-popup-PrimaryModal maincontent_popup fade" role="dialog" id="PrimaryModalhdbgcl">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header header-color-modal bg-color-1">
                
                <div class="modal-close-area modal-close-df">
                  <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                </div> 
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <a data-dismiss="modal" href="#">Close</a>
              </div>
            </div>
            <!-- modal-content  -->
          </div>
          <!-- modal-dialog -->
        </div>
        <!-- modal -->
        <script type="text/javascript">
           function removeData() {
               if(confirm("Are you sure you want to remove this?")){
                    return true;
               }
                return false;
           }

       </script>
</body>

</html>