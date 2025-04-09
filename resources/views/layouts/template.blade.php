<!DOCTYPE html>
<html lang="en">

<head>
    <title>thailadstaff</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
	
    <link rel="icon" href="{{URL::asset('/template/dist/assets/images/SKM-logo.png')}}" type="image/x-icon">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">

    <!-- vendor css -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



    <link rel="stylesheet" href="{{URL::asset('/template/dist/assets/css/style.css')}}">
	
	
		

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>



<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>


 
	
</head>

<style>
    .select2-container .select2-selection--single {
    height: 40px; /* กำหนดความสูงเป็น 40 พิกเซล */
    align: center;
	
}


    .form-control {
  border-radius: 5px;
  border: 1px solid #ccc;
}

</style>

<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar  ">
		<div class="navbar-wrapper ">
			<div class="navbar-content scroll-div " >
				
				<div class="">
					<div class="main-menu-header">
						<img class="img-radius" src="{{URL::asset('/template/dist/assets/images/user/avatar-2.jpg')}}" alt="User-Profile-Image">
						<div class="user-details">
							<span>{{Auth::user()->name}}</span>
							{{-- <div id="more-details">Thefirst<i class="fa fa-chevron-down m-l-5"></i></div> --}}
						</div>
					</div>
					<div class="collapse" id="nav-user-link">
						<ul class="list-unstyled">
							{{-- <li class="list-group-item"><a href="user-profile.html"><i class="feather icon-user m-r-5"></i>View Profile</a></li>
							<li class="list-group-item"><a href="#!"><i class="feather icon-settings m-r-5"></i>Settings</a></li> --}}
							<li class="list-group-item"><a href="auth-normal-sign-in.html"><i class="feather icon-log-out m-r-5"></i>Logout</a></li>
						</ul>
					</div>
				</div>
				
				<ul class="nav pcoded-inner-navbar ">
					<li class="nav-item pcoded-menu-caption">
						<label>Navigation</label>
					</li>
					{{-- <li class="nav-item">
					    <a href="{{route('employee.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">ข้อมูลสิทธิ์พนักงาน</span></a>
					</li>
					<li class="nav-item">
					    <a href="{{route('asset.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-monitor"></i></span><span class="pcoded-mtext">ข้อมูลทรัพย์สิน</span></a>
					</li> --}}
					
					{{-- <li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-layout"></i></span><span class="pcoded-mtext">Page layouts</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="layout-vertical.html" target="_blank">Vertical</a></li>
					        <li><a href="layout-horizontal.html" target="_blank">Horizontal</a></li>
					    </ul>
					</li> --}}

					{{-- <li class="nav-item pcoded-menu-caption">
						<label>Navigation</label>
					</li>
					<li class="nav-item">
					    <a href="index.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-layout"></i></span><span class="pcoded-mtext">Page layouts</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="layout-vertical.html" target="_blank">Vertical</a></li>
					        <li><a href="layout-horizontal.html" target="_blank">Horizontal</a></li>
					    </ul>
					</li> --}}
					{{-- <li class="nav-item pcoded-menu-caption">
						<label>UI Element</label>
					</li>
					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Basic</span></a>
						<ul class="pcoded-submenu">
							<li><a href="bc_alert.html">Alert</a></li>
							<li><a href="bc_button.html">Button</a></li>
							<li><a href="bc_badges.html">Badges</a></li>
							<li><a href="bc_breadcrumb-pagination.html">Breadcrumb & paggination</a></li>
							<li><a href="bc_card.html">Cards</a></li>
							<li><a href="bc_collapse.html">Collapse</a></li>
							<li><a href="bc_carousel.html">Carousel</a></li>
							<li><a href="bc_grid.html">Grid system</a></li>
							<li><a href="bc_progress.html">Progress</a></li>
							<li><a href="bc_modal.html">Modal</a></li>
							<li><a href="bc_spinner.html">Spinner</a></li>
							<li><a href="bc_tabs.html">Tabs & pills</a></li>
							<li><a href="bc_typography.html">Typography</a></li>
							<li><a href="bc_tooltip-popover.html">Tooltip & popovers</a></li>
							<li><a href="bc_toasts.html">Toasts</a></li>
							<li><a href="bc_extra.html">Other</a></li>
						</ul>
					</li> --}}
					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Setting</span></a>
						<ul class="pcoded-submenu">
							<li><a href="{{route('managedocs.index')}}">ระบบจัดการเอกสาร</a></li>
						</ul>
					</li>
					{{-- <li class="nav-item pcoded-menu-caption">
					    <label>Forms &amp; table</label>
					</li>
					<li class="nav-item">
					    <a href="form_elements.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Forms</span></a>
					</li>
					<li class="nav-item">
					    <a href="tbl_bootstrap.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-align-justify"></i></span><span class="pcoded-mtext">Bootstrap table</span></a>
					</li>
					<li class="nav-item pcoded-menu-caption">
						<label>Chart & Maps</label>
					</li>
					<li class="nav-item">
					    <a href="chart-apex.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-pie-chart"></i></span><span class="pcoded-mtext">Chart</span></a>
					</li>
					<li class="nav-item">
					    <a href="map-google.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-map"></i></span><span class="pcoded-mtext">Maps</span></a>
					</li>
					<li class="nav-item pcoded-menu-caption">
						<label>Pages</label>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-lock"></i></span><span class="pcoded-mtext">Authentication</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="auth-signup.html" target="_blank">Sign up</a></li>
					        <li><a href="auth-signin.html" target="_blank">Sign in</a></li>
					    </ul>
					</li>
					<li class="nav-item"><a href="sample-page.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Sample page</span></a></li> --}}

				</ul>
				
			
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">
		
			
				<div class="m-header">
					<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
					<a href="#!" class="b-brand">
						<!-- ========   change your logo hear   ============ -->
						<img src="{{URL::asset('/template/dist/assets/images/SKM-logo.png')}}" alt="" class="logo" style="width: 35%">
						<img src="{{URL::asset('/template/dist/assets/images/SKM-logo.png')}}" alt="" class="logo-thumb">
					</a>
					<a href="#!" class="mob-toggler">
						<i class="feather icon-more-vertical"></i>
					</a>
				</div>

				<div class="collapse navbar-collapse ">
					<ul class="navbar-nav mr-auto">

						<ul class="navbar-nav ms-auto ">
							<!-- Authentication Links -->
							@guest
								@if (Route::has('login'))
									<li class="nav-item">
										<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
									</li>
								@endif
	
								@if (Route::has('register'))
									<li class="nav-item">
										<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
									</li>
								@endif
							@else
								@canany(['create-role', 'edit-role', 'delete-role'])
									<li><a class="nav-link text-white" href="{{ route('roles.index') }}">Manage Roles</a></li>
								@endcanany
								@canany(['create-user', 'edit-user', 'delete-user'])
									<li><a class="nav-link text-white" href="{{ route('users.index') }}">Manage Users</a></li>
								@endcanany
								{{-- @canany(['create-product', 'edit-product', 'delete-product'])
									<li><a class="nav-link text-white" href="{{ route('products.index') }}">Manage Products</a></li>
								@endcanany --}}
								{{-- <li class="nav-item dropdown">
									<a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
										{{ Auth::user()->name }}
									</a>
	
									<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
										<a class="dropdown-item" href="{{ route('logout') }}"
										   onclick="event.preventDefault();
														 document.getElementById('logout-form').submit();">
											{{ __('Logout') }}
										</a>
	
										<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
											@csrf
										</form>
									</div>
								</li> --}}
							@endguest
						</ul>

						{{-- <li class="nav-item">
							<a href="#!" class="pop-search"><i class="feather icon-search"></i></a>
							<div class="search-bar">
								<input type="text" class="form-control border-0 shadow-none" placeholder="Search hear">
								<button type="button" class="close" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						</li> --}}
						{{-- <li class="nav-item">
							<div class="dropdown">
								<a class="dropdown-toggle h-drop" href="#" data-toggle="dropdown">
									Dropdown
								</a>
								<div class="dropdown-menu profile-notification ">
									<ul class="pro-body">
										<li><a href="user-profile.html" class="dropdown-item"><i class="fas fa-circle"></i> Profile</a></li>
										<li><a href="email_inbox.html" class="dropdown-item"><i class="fas fa-circle"></i> My Messages</a></li>
										<li><a href="auth-signin.html" class="dropdown-item"><i class="fas fa-circle"></i> Lock Screen</a></li>
									</ul>
								</div>
							</div>
						</li> --}}
						{{-- <li class="nav-item">
							<div class="dropdown mega-menu">
								<a class="dropdown-toggle h-drop" href="#" data-toggle="dropdown">
									Mega
								</a>
								<div class="dropdown-menu profile-notification ">
									<div class="row no-gutters">
										<div class="col">
											<h6 class="mega-title">UI Element</h6>
											<ul class="pro-body">
												<li><a href="#!" class="dropdown-item"><i class="fas fa-circle"></i> Alert</a></li>
												<li><a href="#!" class="dropdown-item"><i class="fas fa-circle"></i> Button</a></li>
												<li><a href="#!" class="dropdown-item"><i class="fas fa-circle"></i> Badges</a></li>
												<li><a href="#!" class="dropdown-item"><i class="fas fa-circle"></i> Cards</a></li>
												<li><a href="#!" class="dropdown-item"><i class="fas fa-circle"></i> Modal</a></li>
												<li><a href="#!" class="dropdown-item"><i class="fas fa-circle"></i> Tabs & pills</a></li>
											</ul>
										</div>
										<div class="col">
											<h6 class="mega-title">Forms</h6>
											<ul class="pro-body">
												<li><a href="#!" class="dropdown-item"><i class="feather icon-minus"></i> Elements</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-minus"></i> Validation</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-minus"></i> Masking</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-minus"></i> Wizard</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-minus"></i> Picker</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-minus"></i> Select</a></li>
											</ul>
										</div>
										<div class="col">
											<h6 class="mega-title">Application</h6>
											<ul class="pro-body">
												<li><a href="#!" class="dropdown-item"><i class="feather icon-mail"></i> Email</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-clipboard"></i> Task</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-check-square"></i> To-Do</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-image"></i> Gallery</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-help-circle"></i> Helpdesk</a></li>
											</ul>
										</div>
										<div class="col">
											<h6 class="mega-title">Extension</h6>
											<ul class="pro-body">
												<li><a href="#!" class="dropdown-item"><i class="feather icon-file-plus"></i> Editor</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-file-minus"></i> Invoice</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-calendar"></i> Full calendar</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-upload-cloud"></i> File upload</a></li>
												<li><a href="#!" class="dropdown-item"><i class="feather icon-scissors"></i> Image cropper</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</li> --}}
					</ul>
					<ul class="navbar-nav ml-auto">
						<li>
							<div class="dropdown">
								<a class="dropdown-toggle" href="#" data-toggle="dropdown">
									<i class="icon feather icon-bell"></i>
									<span class="badge badge-pill badge-danger">5</span>
								</a>
								<div class="dropdown-menu dropdown-menu-right notification">
									<div class="noti-head">
										<h6 class="d-inline-block m-b-0">Notifications</h6>
										<div class="float-right">
											<a href="#!" class="m-r-10">mark as read</a>
											<a href="#!">clear all</a>
										</div>
									</div>
									<ul class="noti-body">
										<li class="n-title">
											<p class="m-b-0">NEW</p>
										</li>
										<li class="notification">
											<div class="media">
												<img class="img-radius" src="{{URL::asset('/template/dist/assets/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
												<div class="media-body">
													<p><strong>John Doe</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>5 min</span></p>
													<p>New ticket Added</p>
												</div>
											</div>
										</li>
										<li class="n-title">
											<p class="m-b-0">EARLIER</p>
										</li>
										<li class="notification">
											<div class="media">
												<img class="img-radius" src="{{URL::asset('/template/dist/assets/images/user/avatar-2.jpg')}}" alt="Generic placeholder image">
												<div class="media-body">
													<p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>10 min</span></p>
													<p>Prchace New Theme and make payment</p>
												</div>
											</div>
										</li>
										<li class="notification">
											<div class="media">
												<img class="img-radius" src="{{URL::asset('/template/dist/assets/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
												<div class="media-body">
													<p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>12 min</span></p>
													<p>currently login</p>
												</div>
											</div>
										</li>
										<li class="notification">
											<div class="media">
												<img class="img-radius" src="{{URL::asset('/template/dist/assets/images/user/avatar-2.jpg')}}" alt="Generic placeholder image">
												<div class="media-body">
													<p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
													<p>Prchace New Theme and make payment</p>
												</div>
											</div>
										</li>
									</ul>
									<div class="noti-footer">
										<a href="#!">show all</a>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="dropdown drp-user">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="feather icon-user"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right profile-notification">
									<div class="pro-head">
										<img src="{{URL::asset('/template/dist/assets/images/user/avatar-1.jpg')}}" class="img-radius" alt="User-Profile-Image">
										<span>John Doe</span>
										<a href="auth-signin.html" class="dud-logout" title="Logout">
											<i class="feather icon-log-out"></i>
										</a>
									</div>
									<ul class="pro-body">
										<li><a href="user-profile.html" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
										<li><a href="email_inbox.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>
										<li><a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
				
			
	</header>
	<!-- [ Header ] end -->
	
	

<!-- [ Main Content ] start -->
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Thailad Staff</h5>
                        </div>
                        {{-- <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Form Components</a></li>
                            <li class="breadcrumb-item"><a href="#!">Form Elements</a></li>
                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            @yield('content')
        </div>
        <!-- [ Main Content ] end -->

    </div>
</section>



    <script src="{{URL::asset('/template/dist/assets/js/vendor-all.min.js')}}"></script>
    <script src="{{URL::asset('/template/dist/assets/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('/template/dist/assets/js/pcoded.min.js')}}"></script>
	




</body>


</html>
