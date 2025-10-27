<!DOCTYPE html>
<html lang="th">

<head>
	<title>Thailad Staff Management - เข้าสู่ระบบ</title>
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="ระบบจัดการข้อมูลบุคลากรและนายจ้าง - Thailad Staff Management System" />
	<meta name="keywords" content="staff,management,thai,worker,employer,login">
	<meta name="author" content="SKM Team" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Favicon icon -->
	<link rel="icon" href="{{URL::asset('/template/dist/assets/images/SKM-logo.png')}}" type="image/png">

	<!-- Modern CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	
	<style>
		:root {
			--primary: #2563eb;
			--primary-dark: #1d4ed8;
			--secondary: #64748b;
			--success: #10b981;
			--danger: #ef4444;
			--warning: #f59e0b;
			--light: #f8fafc;
			--dark: #1e293b;
		}

		body {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			min-height: 100vh;
			display: flex;
			align-items: center;
		}

		.auth-wrapper {
			width: 100%;
			padding: 2rem 0;
		}

		.auth-content {
			max-width: 450px;
			margin: 0 auto;
			padding: 0 1rem;
		}

		.login-card {
			background: white;
			border-radius: 20px;
			box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
			border: none;
			padding: 3rem 2.5rem;
			position: relative;
			overflow: hidden;
		}

		.login-card::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			height: 4px;
			background: linear-gradient(90deg, var(--primary), var(--primary-dark));
		}

		.logo-container {
			text-align: center;
			margin-bottom: 2rem;
		}

		.logo {
			max-width: 120px;
			height: auto;
			filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
		}

		.app-title {
			color: var(--dark);
			font-size: 1.5rem;
			font-weight: 700;
			margin: 1rem 0 0.5rem;
		}

		.app-subtitle {
			color: var(--secondary);
			font-size: 0.9rem;
			margin-bottom: 2rem;
		}

		.form-floating {
			margin-bottom: 1.5rem;
		}

		.form-floating .form-control {
			border: 2px solid #e2e8f0;
			border-radius: 12px;
			padding: 1rem 0.75rem;
			height: auto;
			font-size: 1rem;
			transition: all 0.3s ease;
		}

		.form-floating .form-control:focus {
			border-color: var(--primary);
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
		}

		.form-floating label {
			color: var(--secondary);
			font-weight: 500;
		}

		.btn-login {
			background: linear-gradient(135deg, var(--primary), var(--primary-dark));
			border: none;
			border-radius: 12px;
			padding: 0.875rem 2rem;
			font-weight: 600;
			font-size: 1rem;
			letter-spacing: 0.5px;
			transition: all 0.3s ease;
			width: 100%;
			margin-top: 1rem;
		}

		.btn-login:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
		}

		.form-check-input:checked {
			background-color: var(--primary);
			border-color: var(--primary);
		}

		.invalid-feedback {
			display: block;
			width: 100%;
			margin-top: 0.25rem;
			font-size: 0.875rem;
			color: var(--danger);
		}

		.is-invalid {
			border-color: var(--danger) !important;
		}

		.fade-in {
			animation: fadeInUp 0.6s ease-out;
		}

		@keyframes fadeInUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		@media (max-width: 576px) {
			.login-card {
				padding: 2rem 1.5rem;
				margin: 1rem;
			}
			
			.auth-content {
				padding: 0 0.5rem;
			}
		}
	</style>
</head>

<body>
	<div class="auth-wrapper">
		<div class="auth-content">
			<div class="login-card fade-in">
				<div class="logo-container">
					<img src="{{URL::asset('/template/dist/assets/images/SKM-logo.png')}}" alt="SKM Logo" class="logo">
					<h1 class="app-title">Thailad Staff Management</h1>
					<p class="app-subtitle">ระบบจัดการข้อมูลบุคลากรและนายจ้าง</p>
				</div>

				<form method="POST" action="{{ route('login') }}" id="loginForm">
					@csrf

					<div class="form-floating">
						<input type="email" 
							   class="form-control @error('email') is-invalid @enderror" 
							   id="email" 
							   name="email" 
							   value="{{ old('email') }}" 
							   placeholder="name@example.com"
							   required 
							   autocomplete="email" 
							   autofocus>
						<label for="email">
							<i class="fas fa-envelope me-2"></i>อีเมล
						</label>
						@error('email')
							<div class="invalid-feedback">
								<i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
							</div>
						@enderror
					</div>

					<div class="form-floating">
						<input type="password" 
							   class="form-control @error('password') is-invalid @enderror" 
							   id="password" 
							   name="password" 
							   placeholder="รหัสผ่าน"
							   required 
							   autocomplete="current-password">
						<label for="password">
							<i class="fas fa-lock me-2"></i>รหัสผ่าน
						</label>
						@error('password')
							<div class="invalid-feedback">
								<i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
							</div>
						@enderror
					</div>

					<div class="form-check mb-3">
						<input class="form-check-input" type="checkbox" name="remember" id="remember" 
							   {{ old('remember') ? 'checked' : '' }}>
						<label class="form-check-label" for="remember">
							<i class="fas fa-check me-2"></i>จดจำการเข้าสู่ระบบ
						</label>
					</div>

					<button type="submit" class="btn btn-primary btn-login">
						<i class="fas fa-sign-in-alt me-2"></i>เข้าสู่ระบบ
					</button>
				</form>

				@if (session('status'))
					<div class="alert alert-success mt-3" role="alert">
						<i class="fas fa-info-circle me-2"></i>{{ session('status') }}
					</div>
				@endif
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

	<script>
		// Form validation and animation
		document.getElementById('loginForm').addEventListener('submit', function(e) {
			const submitBtn = this.querySelector('.btn-login');
			submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังเข้าสู่ระบบ...';
			submitBtn.disabled = true;
		});

		// Auto focus on email field
		document.getElementById('email').focus();
	</script>

</body>
</html>