<!DOCTYPE html>
<html lang="th">

<head>
	<title>Thailad Staff Management System</title>
	<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="ระบบจัดการข้อมูลบุคลากรและนายจ้าง - Thailad Staff Management System" />
	<meta name="keywords" content="staff,management,thai,worker,employer,ระบบจัดการ,บุคลากร,นายจ้าง">
	<meta name="author" content="SKM Team" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Favicon icon -->
	<link rel="icon" href="{{URL::asset('/template/dist/assets/images/SKM-logo.png')}}" type="image/png">
	
	<!-- Modern CSS Libraries -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
/* Professional Modern UI System */
:root {
	/* Professional Color Palette */
	--primary-color: #6366f1;
	--primary-light: #8b5cf6;
	--primary-dark: #4f46e5;
	--primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	
	--secondary-color: #64748b;
	--accent-color: #06d6a0;
	--success-color: #22c55e;
	--warning-color: #f59e0b;
	--danger-color: #ef4444;
	--info-color: #3b82f6;
	
	/* Professional Grays */
	--gray-50: #f8fafc;
	--gray-100: #f1f5f9;
	--gray-200: #e2e8f0;
	--gray-300: #cbd5e1;
	--gray-400: #94a3b8;
	--gray-500: #64748b;
	--gray-600: #475569;
	--gray-700: #334155;
	--gray-800: #1e293b;
	--gray-900: #0f172a;
	
	/* Professional Shadows */
	--shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
	--shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
	--shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
	--shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
	--shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
	--shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
	
	/* Professional Border Radius */
	--radius-sm: 0.375rem;
	--radius-md: 0.5rem;
	--radius-lg: 0.75rem;
	--radius-xl: 1rem;
	--radius-2xl: 1.5rem;
	
	/* Professional Typography */
	--font-weight-medium: 500;
	--font-weight-semibold: 600;
	--font-weight-bold: 700;
}

/* Modern Professional Base Styling */
* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}

html, body {
	margin: 0;
	padding: 0;
	border: none;
	outline: none;
}

body {
	font-family: 'Inter', 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
	background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
	color: var(--gray-800);
	line-height: 1.6;
	font-size: 0.95rem;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	margin: 0;
	padding: 0;
}

/* Professional Layout System */
.pcoded-navbar {
	position: fixed;
	top: 0;
	left: 0;
	width: 260px;
	height: 100vh;
	z-index: 1000;
	transition: all 0.3s ease;
}

.pcoded-header {
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	height: 70px;
	z-index: 1001;
	padding-left: 260px;
}

.pcoded-main-container {
	margin-left: 260px;
	margin-top: 70px;
	min-height: calc(100vh - 70px);
	background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

.pcoded-wrapper {
	width: 100%;
	position: relative;
}

.pcoded-content {
	padding: 30px;
	background: transparent;
	min-height: calc(100vh - 70px);
}

.pcoded-inner-content {
	padding: 0;
	max-width: 100%;
}

/* Mobile Responsive */
@media (max-width: 991px) {
	.pcoded-navbar {
		transform: translateX(-100%);
	}
	
	.pcoded-navbar.mob-open {
		transform: translateX(0);
	}
	
	.pcoded-header {
		padding-left: 0;
	}
	
	.pcoded-main-container {
		margin-left: 0;
	}
}

/* Import Modern Font */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

/* Professional Modern Form Controls */
.form-control, .form-select {
	border: 2px solid var(--gray-200);
	border-radius: var(--radius-lg);
	padding: 0.875rem 1.125rem;
	font-size: 0.95rem;
	font-weight: var(--font-weight-medium);
	color: var(--gray-700);
	transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
	box-shadow: var(--shadow-xs);
	background: white;
}

.form-control:focus, .form-select:focus {
	border-color: var(--primary-color);
	box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
	outline: none;
	transform: translateY(-1px);
}

.form-control::placeholder {
	color: var(--gray-400);
	font-weight: normal;
}

.form-label {
	font-weight: var(--font-weight-semibold);
	color: var(--gray-700);
	margin-bottom: 0.625rem;
	font-size: 0.9rem;
	display: flex;
	align-items: center;
}

.form-label i {
	margin-right: 0.5rem;
	color: var(--primary-color);
}

.form-text {
	color: var(--gray-500);
	font-size: 0.8rem;
	margin-top: 0.375rem;
}

/* Professional Input Groups */
.input-group {
	box-shadow: var(--shadow-xs);
	border-radius: var(--radius-lg);
	overflow: hidden;
}

.input-group .form-control {
	border-radius: 0;
	border-right: none;
	box-shadow: none;
}

.input-group-text {
	background: var(--gray-100);
	border: 2px solid var(--gray-200);
	border-left: none;
	color: var(--gray-600);
	font-weight: var(--font-weight-medium);
}

/* Professional Validation States */
.is-valid {
	border-color: var(--success-color) !important;
	box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1) !important;
}

.is-invalid {
	border-color: var(--danger-color) !important;
	box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
}

.valid-feedback, .invalid-feedback {
	font-size: 0.8rem;
	font-weight: var(--font-weight-medium);
	margin-top: 0.5rem;
	display: flex;
	align-items: center;
}

.valid-feedback i, .invalid-feedback i {
	margin-right: 0.375rem;
}

/* Select2 Styling */
.select2-container .select2-selection--single {
	height: 48px;
	border: 2px solid var(--border-color);
	border-radius: var(--border-radius);
	padding: 0;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
	line-height: 44px;
	padding-left: 16px;
	color: var(--dark-color);
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
	height: 44px;
}

.select2-container--default.select2-container--focus .select2-selection--single {
	border-color: var(--primary-color);
}

/* Professional Modern Button System */
.btn {
	font-weight: var(--font-weight-semibold);
	font-size: 0.9rem;
	padding: 0.75rem 1.75rem;
	border-radius: var(--radius-lg);
	border: 2px solid transparent;
	transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
	position: relative;
	overflow: hidden;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	text-decoration: none;
	cursor: pointer;
}

.btn:focus {
	outline: none;
	box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
}

/* Primary Button */
.btn-primary {
	background: var(--primary-gradient);
	color: white;
	box-shadow: var(--shadow-md);
}

.btn-primary:hover {
	transform: translateY(-2px);
	box-shadow: var(--shadow-xl);
	background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
}

.btn-primary:active {
	transform: translateY(0);
}

/* Outline Buttons */
.btn-outline-primary {
	background: white;
	color: var(--primary-color);
	border-color: var(--primary-color);
}

.btn-outline-primary:hover {
	background: var(--primary-color);
	color: white;
	transform: translateY(-1px);
	box-shadow: var(--shadow-lg);
}

.btn-outline-secondary {
	background: white;
	color: var(--gray-600);
	border-color: var(--gray-300);
}

.btn-outline-secondary:hover {
	background: var(--gray-600);
	color: white;
	border-color: var(--gray-600);
	transform: translateY(-1px);
}

/* Success Button */
.btn-success {
	background: linear-gradient(135deg, var(--success-color) 0%, #16a34a 100%);
	color: white;
	box-shadow: var(--shadow-md);
}

.btn-success:hover {
	transform: translateY(-2px);
	box-shadow: var(--shadow-lg);
}

/* Warning Button */
.btn-warning {
	background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
	color: white;
	box-shadow: var(--shadow-md);
}

.btn-warning:hover {
	transform: translateY(-2px);
	box-shadow: var(--shadow-lg);
}

/* Danger Button */
.btn-danger {
	background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
	color: white;
	box-shadow: var(--shadow-md);
}

.btn-danger:hover {
	transform: translateY(-2px);
	box-shadow: var(--shadow-lg);
}

/* Button Sizes */
.btn-sm {
	padding: 0.5rem 1.25rem;
	font-size: 0.8rem;
}

.btn-lg {
	padding: 1rem 2.5rem;
	font-size: 1rem;
}

/* Button Group */
.btn-group .btn {
	border-radius: 0;
	margin-right: 0;
}

.btn-group .btn:first-child {
	border-top-left-radius: var(--radius-lg);
	border-bottom-left-radius: var(--radius-lg);
}

.btn-group .btn:last-child {
	border-top-right-radius: var(--radius-lg);
	border-bottom-right-radius: var(--radius-lg);
}

/* Floating Action Button */
.btn-floating {
	width: 56px;
	height: 56px;
	border-radius: 50%;
	padding: 0;
	box-shadow: var(--shadow-lg);
	position: fixed;
	bottom: 2rem;
	right: 2rem;
	z-index: 1000;
}

.btn-floating:hover {
	transform: translateY(-4px) scale(1.05);
	box-shadow: var(--shadow-2xl);
}

/* Professional Content Area */
.pcoded-content {
	background: transparent;
}

/* Professional Modern Cards */
.card {
	background: white;
	border: 1px solid #e2e8f0;
	border-radius: 16px;
	box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
	transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
	overflow: hidden;
	margin-bottom: 30px;
}

.card:hover {
	box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
	transform: translateY(-2px);
	border-color: rgba(99, 102, 241, 0.2);
}

.card-header {
	background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
	border-bottom: 1px solid var(--gray-200);
	padding: 1.75rem 2rem;
	position: relative;
}

.card-header::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	height: 3px;
	background: var(--primary-gradient);
}

.card-header h4, .card-header h5 {
	margin: 0;
	font-weight: var(--font-weight-bold);
	color: var(--gray-800);
	display: flex;
	align-items: center;
}

.card-header small {
	color: var(--gray-500);
	font-size: 0.875rem;
	margin-top: 0.25rem;
	display: block;
}

.card-body {
	padding: 2rem;
}

/* Professional Statistics Cards */
.stats-card {
	background: white;
	border: 1px solid var(--gray-200);
	border-radius: var(--radius-xl);
	padding: 1.75rem;
	box-shadow: var(--shadow-md);
	transition: all 0.3s ease;
	position: relative;
	overflow: hidden;
}

.stats-card::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 4px;
	background: var(--primary-gradient);
}

.stats-card:hover {
	transform: translateY(-4px);
	box-shadow: var(--shadow-xl);
}

.stats-card-primary {
	background: var(--primary-gradient);
	color: white;
	border: none;
}

.stats-card-primary::before {
	background: rgba(255, 255, 255, 0.2);
}

.stats-number {
	font-size: 2.25rem;
	font-weight: var(--font-weight-bold);
	line-height: 1;
	margin-bottom: 0.5rem;
}

.stats-label {
	font-size: 0.9rem;
	font-weight: var(--font-weight-medium);
	opacity: 0.9;
}

.stats-icon {
	font-size: 2.5rem;
	opacity: 0.2;
	position: absolute;
	right: 1.5rem;
	top: 50%;
	transform: translateY(-50%);
}

/* Professional Modern Sidebar */
.pcoded-navbar {
	background: linear-gradient(180deg, #1e293b 0%, #334155 50%, #475569 100%);
	border-right: 1px solid rgba(255, 255, 255, 0.05);
	box-shadow: 4px 0 15px rgba(0, 0, 0, 0.15);
	overflow-y: auto;
	overflow-x: hidden;
	margin: 0;
}

.pcoded-navbar::-webkit-scrollbar {
	width: 4px;
}

.pcoded-navbar::-webkit-scrollbar-track {
	background: rgba(255, 255, 255, 0.1);
}

.pcoded-navbar::-webkit-scrollbar-thumb {
	background: rgba(99, 102, 241, 0.5);
	border-radius: 2px;
}

.pcoded-navbar .navbar-content {
	background: transparent;
	padding: 0;
}

.pcoded-navbar .navbar-brand {
	padding: 15px 20px;
	border-bottom: 1px solid rgba(255, 255, 255, 0.08);
	background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
	text-align: center;
	position: relative;
	overflow: hidden;
	height: 70px;
	display: flex;
	align-items: center;
	justify-content: center;
}

.pcoded-navbar .navbar-brand::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 50%);
	transform: translateX(-100%);
	transition: transform 0.6s ease;
}

.pcoded-navbar .navbar-brand:hover::before {
	transform: translateX(100%);
}

/* Professional User Profile Section */
.pcoded-navbar .user-profile-section {
	background: linear-gradient(135deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.2) 100%);
	margin: 15px;
	border-radius: 12px;
	padding: 0;
	border: 1px solid rgba(255, 255, 255, 0.1);
}

.pcoded-navbar .main-menu-header {
	display: flex;
	align-items: center;
	padding: 15px 20px;
	background: transparent;
}

.pcoded-navbar .profile-avatar {
	width: 45px;
	height: 45px;
	border-radius: 50%;
	background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
	display: flex;
	align-items: center;
	justify-content: center;
	margin-right: 12px;
	box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.pcoded-navbar .profile-avatar i {
	font-size: 24px;
	color: white;
}

.pcoded-navbar .user-details {
	flex: 1;
}

.pcoded-navbar .user-details .username {
	display: block;
	color: #ffffff;
	font-weight: 600;
	font-size: 14px;
	margin-bottom: 2px;
}

.pcoded-navbar .user-details .user-role {
	display: block;
	color: #94a3b8;
	font-size: 11px;
	font-weight: 400;
}

/* Professional Menu System */
.pcoded-navbar .pcoded-inner-navbar {
	padding: 10px 0 20px 0;
}

.pcoded-navbar .pcoded-inner-navbar .pcoded-navigation-label {
	color: #64748b;
	font-size: 11px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 1.2px;
	padding: 20px 25px 8px;
	margin-top: 10px;
	position: relative;
}

.pcoded-navbar .pcoded-inner-navbar .pcoded-navigation-label::after {
	content: '';
	position: absolute;
	bottom: 0;
	left: 25px;
	right: 25px;
	height: 1px;
	background: linear-gradient(90deg, transparent 0%, rgba(99, 102, 241, 0.3) 50%, transparent 100%);
}

.pcoded-navbar .pcoded-inner-navbar .nav-item {
	margin: 3px 15px;
	position: relative;
}

.pcoded-navbar .pcoded-inner-navbar .nav-link {
	color: #cbd5e1;
	padding: 14px 20px;
	border-radius: 12px;
	font-weight: 500;
	font-size: 14px;
	transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
	position: relative;
	display: flex;
	align-items: center;
	overflow: hidden;
	border: 1px solid transparent;
}

.pcoded-navbar .pcoded-inner-navbar .nav-link::after {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	width: 0;
	height: 100%;
	background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
	transition: width 0.4s ease;
	z-index: 0;
}

.pcoded-navbar .pcoded-inner-navbar .nav-link:hover::after {
	width: 100%;
}

.pcoded-navbar .pcoded-inner-navbar .nav-link:hover {
	color: white;
	border-color: rgba(34, 197, 94, 0.3);
	transform: translateX(5px);
	box-shadow: 0 5px 15px rgba(34, 197, 94, 0.2);
}

.pcoded-navbar .pcoded-inner-navbar .nav-link.active {
	background: linear-gradient(135deg, rgba(34, 197, 94, 0.25) 0%, rgba(16, 185, 129, 0.15) 100%);
	color: white;
	border-color: rgba(34, 197, 94, 0.4);
	box-shadow: 0 5px 15px rgba(34, 197, 94, 0.3);
	transform: translateX(5px);
}

.pcoded-navbar .pcoded-inner-navbar .nav-link.active::after {
	width: 100%;
}

.pcoded-navbar .pcoded-inner-navbar .nav-link .pcoded-micon,
.pcoded-navbar .pcoded-inner-navbar .nav-link .pcoded-mtext {
	position: relative;
	z-index: 1;
}

.pcoded-navbar .pcoded-inner-navbar .nav-link .pcoded-micon {
	width: 20px;
	height: 20px;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	margin-right: 15px;
	font-size: 16px;
	transition: all 0.3s ease;
}

.pcoded-navbar .pcoded-inner-navbar .nav-link:hover .pcoded-micon,
.pcoded-navbar .pcoded-inner-navbar .nav-link.active .pcoded-micon {
	color: #ffffff;
	transform: scale(1.1);
}

.pcoded-navbar .pcoded-inner-navbar .nav-link .pcoded-mtext {
	font-size: 14px;
	font-weight: 500;
	transition: all 0.3s ease;
}

/* Professional Modern Header */
.pcoded-header {
	background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #8b5cf6 100%) !important;
	box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
	border-bottom: 1px solid rgba(255, 255, 255, 0.1);
	backdrop-filter: blur(10px);
	margin: 0;
	border: none;
}

.pcoded-header .m-header {
	background: transparent;
	padding: 0 30px;
	height: 70px;
	display: flex;
	align-items: center;
	justify-content: flex-start;
	width: 100%;
}

.pcoded-header .mobile-menu {
	display: none;
	background: none;
	border: none;
	color: white;
	font-size: 18px;
	padding: 8px 12px;
	border-radius: 8px;
	transition: all 0.3s ease;
	text-decoration: none;
}

.pcoded-header .mobile-menu:hover {
	background: rgba(255, 255, 255, 0.1);
}

.pcoded-header .header-brand {
	display: flex;
	align-items: center;
	margin-right: 40px;
}

@media (max-width: 991px) {
	.pcoded-header .mobile-menu {
		display: block;
	}
	
	.pcoded-header .header-brand {
		margin-left: 10px;
		margin-right: 20px;
	}
	
	.pcoded-header .header-brand span {
		font-size: 14px;
	}
	
	.pcoded-header .header-brand img {
		height: 30px;
		margin-right: 8px;
	}
	
	.pcoded-header .navbar-nav .nav-link {
		padding: 8px 12px;
		font-size: 12px;
		margin: 0 2px;
	}
	
	.pcoded-header .navbar-nav .nav-link i {
		font-size: 14px;
		margin-right: 6px;
	}
	
	.pcoded-header .navbar-nav .nav-link span {
		font-size: 12px;
	}
}

.pcoded-header .b-brand {
	display: flex;
	align-items: center;
	color: white !important;
	text-decoration: none;
	font-weight: 700;
	font-size: 18px;
}

.pcoded-header .navbar-nav {
	display: flex;
	align-items: center;
	margin: 0;
	padding: 0;
	flex-direction: row;
	list-style: none;
}

.pcoded-header .navbar-collapse {
	display: flex !important;
	flex: 1;
	justify-content: space-between;
	align-items: center;
}

.pcoded-header .navbar-nav .nav-link {
	color: white !important;
	font-weight: 500;
	padding: 10px 16px;
	border-radius: 8px;
	transition: all 0.3s ease;
	margin: 0 5px;
	text-decoration: none;
	display: flex;
	align-items: center;
	flex-direction: row;
	font-size: 14px;
	white-space: nowrap;
}

.pcoded-header .navbar-nav .nav-link i {
	font-size: 16px;
	margin-right: 8px;
}

.pcoded-header .navbar-nav .nav-link span {
	font-size: 14px;
	font-weight: 500;
}

.pcoded-header .navbar-nav .nav-link:hover {
	background: rgba(255, 255, 255, 0.1);
	transform: translateY(-1px);
}

.pcoded-header .navbar-nav .nav-item {
	position: relative;
}

.pcoded-header .navbar-nav .dropdown-toggle::after {
	margin-left: 8px;
	border-top: 0.3em solid;
	border-right: 0.3em solid transparent;
	border-bottom: 0;
	border-left: 0.3em solid transparent;
}

/* Header Breadcrumb */
.pcoded-header .page-header {
	background: transparent;
	padding: 0;
	margin: 0;
	display: flex;
	align-items: center;
}

.pcoded-header .page-header .page-block {
	border: none;
	background: transparent;
}

.pcoded-header .page-header .page-block .breadcrumb {
	background: transparent;
	padding: 0;
	margin: 0;
}

.pcoded-header .page-header .page-block .breadcrumb .breadcrumb-item {
	color: rgba(255, 255, 255, 0.8);
	font-size: 14px;
}

.pcoded-header .page-header .page-block .breadcrumb .breadcrumb-item.active {
	color: white;
	font-weight: 600;
}

.pcoded-header .m-header .b-brand img {
	max-height: 40px;
	filter: brightness(1.1);
}

.pcoded-header .m-header .b-brand {
	color: white !important;
	text-decoration: none;
	font-weight: 700;
	font-size: 18px;
}

/* Professional User Dropdown */
.dropdown-toggle {
	color: white !important;
	background: rgba(255, 255, 255, 0.1) !important;
	border: 1px solid rgba(255, 255, 255, 0.2) !important;
	padding: 8px 15px !important;
	border-radius: 8px !important;
	transition: all 0.3s ease !important;
	text-decoration: none !important;
}

.dropdown-toggle:hover {
	background: rgba(255, 255, 255, 0.2) !important;
}

.dropdown-toggle:focus {
	box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
}

.dropdown-menu {
	border: none;
	box-shadow: 0 5px 15px rgba(0,0,0,0.1);
	border-radius: 8px;
	padding: 5px 0;
	margin-top: 8px;
	min-width: 200px;
	background: white;
	position: absolute;
	z-index: 1050;
	display: none;
}

.dropdown-menu.show {
	display: block;
}

.dropdown-item {
	padding: 10px 20px;
	font-size: 14px;
	color: #2C3E50;
	transition: all 0.2s ease;
	display: flex;
	align-items: center;
}

.dropdown-item i {
	margin-right: 10px;
	width: 16px;
}

.dropdown-item:hover {
	background: #6366f1;
	color: white;
}

/* Professional Modern Table Styling */
.table-container {
	background: white;
	border-radius: var(--radius-xl);
	overflow: hidden;
	box-shadow: var(--shadow-lg);
	border: 1px solid var(--gray-200);
	margin-bottom: 2rem;
}

.table {
	margin-bottom: 0;
	border-collapse: separate;
	border-spacing: 0;
}

.table thead th {
	background: linear-gradient(135deg, var(--gray-800) 0%, var(--gray-700) 100%);
	color: white;
	font-weight: var(--font-weight-semibold);
	font-size: 0.875rem;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	padding: 1.25rem 1.5rem;
	border: none;
	position: relative;
	vertical-align: middle;
}

.table thead th:first-child {
	border-top-left-radius: var(--radius-xl);
}

.table thead th:last-child {
	border-top-right-radius: var(--radius-xl);
}

.table tbody td {
	padding: 1.25rem 1.5rem;
	border-bottom: 1px solid var(--gray-100);
	border-right: none;
	border-left: none;
	vertical-align: middle;
	font-size: 0.9rem;
	color: var(--gray-700);
}

.table tbody tr {
	transition: all 0.2s ease;
}

.table tbody tr:hover {
	background: linear-gradient(135deg, var(--gray-50) 0%, rgba(99, 102, 241, 0.02) 100%);
	transform: translateY(-1px);
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.table tbody tr:last-child td:first-child {
	border-bottom-left-radius: var(--radius-xl);
}

.table tbody tr:last-child td:last-child {
	border-bottom-right-radius: var(--radius-xl);
}

.table tbody tr:last-child td {
	border-bottom: none;
}

/* Professional Table Cell Content */
.table-avatar {
	width: 40px;
	height: 40px;
	border-radius: 50%;
	background: var(--primary-gradient);
	display: inline-flex;
	align-items: center;
	justify-content: center;
	color: white;
	font-weight: var(--font-weight-semibold);
	font-size: 0.875rem;
	margin-right: 0.75rem;
}

.table-status-badge {
	display: inline-flex;
	align-items: center;
	padding: 0.375rem 0.875rem;
	border-radius: 9999px;
	font-size: 0.75rem;
	font-weight: var(--font-weight-medium);
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.table-status-badge.active {
	background: rgba(34, 197, 94, 0.1);
	color: #16a34a;
	border: 1px solid rgba(34, 197, 94, 0.2);
}

.table-status-badge.inactive {
	background: rgba(239, 68, 68, 0.1);
	color: #dc2626;
	border: 1px solid rgba(239, 68, 68, 0.2);
}

.table-status-badge.pending {
	background: rgba(245, 158, 11, 0.1);
	color: #d97706;
	border: 1px solid rgba(245, 158, 11, 0.2);
}

.table-actions {
	display: flex;
	gap: 0.5rem;
	align-items: center;
}

.table-action-btn {
	width: 36px;
	height: 36px;
	border-radius: var(--radius-md);
	border: none;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	font-size: 0.875rem;
	transition: all 0.2s ease;
	cursor: pointer;
}

.table-action-btn.edit {
	background: rgba(59, 130, 246, 0.1);
	color: #3b82f6;
}

.table-action-btn.edit:hover {
	background: rgba(59, 130, 246, 0.2);
	transform: translateY(-1px);
}

.table-action-btn.delete {
	background: rgba(239, 68, 68, 0.1);
	color: #ef4444;
}

.table-action-btn.delete:hover {
	background: rgba(239, 68, 68, 0.2);
	transform: translateY(-1px);
}

/* Professional DataTable Customization */
.dataTables_wrapper {
	padding: 1.5rem 2rem;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
	margin-bottom: 1.5rem;
}

.dataTables_wrapper .dataTables_length label,
.dataTables_wrapper .dataTables_filter label {
	font-weight: var(--font-weight-semibold);
	color: var(--gray-700);
	margin-bottom: 0.5rem;
}

.dataTables_wrapper .dataTables_length select,
.dataTables_wrapper .dataTables_filter input {
	border: 2px solid var(--gray-200);
	border-radius: var(--radius-lg);
	padding: 0.625rem 1rem;
	font-size: 0.9rem;
	transition: all 0.3s ease;
	box-shadow: var(--shadow-xs);
}

.dataTables_wrapper .dataTables_length select:focus,
.dataTables_wrapper .dataTables_filter input:focus {
	border-color: var(--primary-color);
	box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.dataTables_wrapper .dataTables_info {
	color: var(--gray-600);
	font-size: 0.9rem;
	font-weight: var(--font-weight-medium);
}

.dataTables_wrapper .dataTables_paginate {
	margin-top: 1.5rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
	border: 2px solid var(--gray-200);
	background: white;
	color: var(--gray-600);
	padding: 0.5rem 0.875rem;
	margin: 0 0.125rem;
	border-radius: var(--radius-md);
	font-weight: var(--font-weight-medium);
	transition: all 0.2s ease;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
	background: var(--primary-color);
	color: white;
	border-color: var(--primary-color);
	transform: translateY(-1px);
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
	background: var(--primary-gradient);
	color: white;
	border-color: var(--primary-color);
	box-shadow: var(--shadow-md);
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
	opacity: 0.5;
	cursor: not-allowed;
}

/* Professional DataTable Processing */
.dataTables_processing {
	background: rgba(255, 255, 255, 0.95);
	border: 1px solid var(--gray-200);
	border-radius: var(--radius-lg);
	padding: 1.5rem;
	font-weight: var(--font-weight-semibold);
	color: var(--gray-700);
	box-shadow: var(--shadow-xl);
}

/* Responsive DataTable */
@media (max-width: 768px) {
	.dataTables_wrapper {
		padding: 1rem;
	}
	
	.dataTables_wrapper .dataTables_length,
	.dataTables_wrapper .dataTables_filter {
		text-align: center;
		margin-bottom: 1rem;
	}
	
	.dataTables_wrapper .dataTables_paginate .paginate_button {
		padding: 0.375rem 0.625rem;
		font-size: 0.8rem;
	}
}

/* Alert Styling */
.alert {
	border-radius: var(--border-radius);
	border: none;
	box-shadow: var(--box-shadow);
}

.alert-success {
	background: linear-gradient(135deg, #d1fae5, #a7f3d0);
	color: #065f46;
}

.alert-danger {
	background: linear-gradient(135deg, #fee2e2, #fecaca);
	color: #991b1b;
}

.alert-warning {
	background: linear-gradient(135deg, #fef3c7, #fde68a);
	color: #92400e;
}

/* Loading Animation */
.loader-bg {
	background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
	.card-body {
		padding: 16px;
	}
	
	.btn {
		padding: 10px 20px;
		font-size: 13px;
	}
	
	.table thead th,
	.table tbody td {
		padding: 12px 8px;
		font-size: 13px;
	}
}

/* Professional Animation System */
.fade-in {
	animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
	from { 
		opacity: 0; 
		transform: translateY(20px); 
	}
	to { 
		opacity: 1; 
		transform: translateY(0); 
	}
}

.slide-up {
	animation: slideUp 0.4s ease-out;
}

@keyframes slideUp {
	from { 
		transform: translateY(15px); 
		opacity: 0; 
	}
	to { 
		transform: translateY(0); 
		opacity: 1; 
	}
}

.scale-in {
	animation: scaleIn 0.3s ease-out;
}

@keyframes scaleIn {
	from {
		transform: scale(0.95);
		opacity: 0;
	}
	to {
		transform: scale(1);
		opacity: 1;
	}
}

/* Loading Animation */
.loading {
	position: relative;
	overflow: hidden;
}

.loading::after {
	content: '';
	position: absolute;
	top: 0;
	left: -100%;
	width: 100%;
	height: 100%;
	background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
	animation: loading 1.5s infinite;
}

@keyframes loading {
	0% { left: -100%; }
	100% { left: 100%; }
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
			<!-- Brand Section -->
			<div class="navbar-brand">
				<span style="color: white; font-weight: 600; font-size: 16px; letter-spacing: 1px;">MENU</span>
			</div>
			
			<div class="navbar-content scroll-div " >
				
				<div class="user-profile-section">
					<div class="main-menu-header">
						<div class="profile-avatar">
							<i class="fas fa-user-circle"></i>
						</div>
						<div class="user-details">
							<span class="username">{{Auth::user()->name}}</span>
							<small class="user-role">Administrator</small>
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

					<li class="nav-item">
						<a href="{{route('dashboard.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>

					<li class="nav-item">
						<a href="{{route('customers.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">ข้อมูลนายจ้าง</span></a>
					   
					</li>
					<li class="nav-item">
				
						<a href="{{route('labours.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-user"></i></span><span class="pcoded-mtext">ข้อมูลคนงาน</span></a>
					</li>

					<li class="nav-item">
						<a href="{{route('import-labours.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-download-cloud"></i></span><span class="pcoded-mtext">import ข้อมูลจาก Recuite</span></a>
					</li>

					{{-- <li class="nav-item">
						<a href="{{route('asset.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-monitor"></i></span><span class="pcoded-mtext">ข้อมูลทรัพย์สิน</span></a>
					</li> --}}
					
					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-layout"></i></span><span class="pcoded-mtext">รายงาน</span></a>
						<ul class="pcoded-submenu">
							<li><a href="{{route('report.labours.index')}}">รายงานข้อมูลคนงาน</a></li>
							{{-- <li><a href="layout-horizontal.html" target="_blank">Horizontal</a></li> --}}
						</ul>
					</li>

					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Setting</span></a>
						<ul class="pcoded-submenu">
							<li><a href="{{route('managedocs.index')}}">ManageDocument</a></li>
							<li><a href="{{route('global-sets.index')}}">GlobalSets</a></li>
		
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
	<header class="pcoded-header navbar navbar-expand-lg">
		<div class="m-header">
			<a class="mobile-menu" id="mobile-collapse" href="#" onclick="toggleMobileMenu()">
				<i class="fas fa-bars"></i>
			</a>
			
			<div class="header-brand">
				<img src="{{URL::asset('/template/dist/assets/images/SKM-logo.png')}}" alt="SKM Logo" style="height: 35px; margin-right: 10px;">
				<span style="color: white; font-weight: 700; font-size: 18px;">Thai Labor Management System</span>
			</div>
			
			<div class="navbar-collapse">
				<ul class="navbar-nav me-auto">
					@canany(['create-role', 'edit-role', 'delete-role'])
						<li class="nav-item">
							<a class="nav-link" href="{{ route('roles.index') }}">
								<i class="fas fa-user-shield"></i>
								<span>Manage Roles</span>
							</a>
						</li>
					@endcanany
					@canany(['create-user', 'edit-user', 'delete-user'])
						<li class="nav-item">
							<a class="nav-link" href="{{ route('users.index') }}">
								<i class="fas fa-users"></i>
								<span>Manage Users</span>
							</a>
						</li>
					@endcanany
				</ul>
				
				<ul class="navbar-nav ms-auto">
					@auth
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
							</a>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="#!">
									<i class="fas fa-user me-2"></i>Profile
								</a>
								<a class="dropdown-item" href="#!">
									<i class="fas fa-cog me-2"></i>Settings
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									<i class="fas fa-sign-out-alt me-2"></i>Logout
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</div>
						</li>
					@else
						<li class="nav-item">
							<a class="nav-link" href="{{ route('login') }}">
								<i class="fas fa-sign-in-alt me-2"></i>Login
							</a>
						</li>
					@endauth
				</ul>
			</div>
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
	
	<!-- Custom JavaScript -->
	<script>
		// Mobile Menu Toggle
		function toggleMobileMenu() {
			const navbar = document.querySelector('.pcoded-navbar');
			navbar.classList.toggle('mob-open');
		}
		
		// Initialize tooltips and dropdowns
		document.addEventListener('DOMContentLoaded', function () {
			// Initialize Bootstrap tooltips
			var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
			var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
				return new bootstrap.Tooltip(tooltipTriggerEl);
			});
			
			// Initialize Bootstrap dropdowns
			var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
			var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
				return new bootstrap.Dropdown(dropdownToggleEl);
			});
			
			// Initialize Select2
			if (typeof $.fn.select2 !== 'undefined') {
				$('.select2').select2({
					theme: 'bootstrap-5'
				});
			}
			
			// Initialize DataTable with professional settings
			if (typeof $.fn.DataTable !== 'undefined') {
				$('.professional-datatable').DataTable({
					language: {
						url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json'
					},
					responsive: true,
					pageLength: 25,
					lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "ทั้งหมด"]],
					dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
					columnDefs: [{
						targets: 'no-sort',
						orderable: false
					}],
					order: [[0, 'asc']],
					drawCallback: function() {
						// Re-initialize tooltips after table redraw
						$('[data-bs-toggle="tooltip"]').tooltip();
					}
				});
			}
			
			// Add fade-in animation to cards
			document.querySelectorAll('.card').forEach(function(card, index) {
				card.style.animationDelay = (index * 0.1) + 's';
				card.classList.add('fade-in');
			});
			
			// Close mobile menu when clicking outside
			document.addEventListener('click', function(e) {
				const navbar = document.querySelector('.pcoded-navbar');
				const mobileMenu = document.getElementById('mobile-collapse');
				
				if (navbar.classList.contains('mob-open') && 
					!navbar.contains(e.target) && 
					!mobileMenu.contains(e.target)) {
					navbar.classList.remove('mob-open');
				}
			});
		});
		
		// Add loading animation to buttons
		function addLoadingToButton(button) {
			const originalText = button.innerHTML;
			button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังประมวลผล...';
			button.disabled = true;
			
			// Return function to reset button
			return function() {
				button.innerHTML = originalText;
				button.disabled = false;
			};
		}
		
		// Professional alert system
		function showAlert(type, message, title = '') {
			// You can integrate with SweetAlert2 or similar library here
			const alertClass = type === 'success' ? 'alert-success' : 
							   type === 'error' ? 'alert-danger' :
							   type === 'warning' ? 'alert-warning' : 'alert-info';
							   
			const alertHtml = `
				<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
					<strong>${title}</strong> ${message}
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
			`;
			
			const container = document.querySelector('.pcoded-content');
			if (container) {
				container.insertAdjacentHTML('afterbegin', alertHtml);
			}
		}
	</script>

</body>


</html>
