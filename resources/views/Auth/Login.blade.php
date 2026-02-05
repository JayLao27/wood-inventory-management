<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RM Wood Works Login</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<style>
		@keyframes float {
			0%, 100% { transform: translateY(0px); }
			50% { transform: translateY(-20px); }
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

		@keyframes slideInRight {
			from {
				opacity: 0;
				transform: translateX(30px);
			}
			to {
				opacity: 1;
				transform: translateX(0);
			}
		}

		.animate-float {
			animation: float 6s ease-in-out infinite;
		}

		.animate-fade-in-up {
			animation: fadeInUp 0.8s ease-out forwards;
		}

		.animate-slide-in-right {
			animation: slideInRight 0.8s ease-out forwards;
		}

		.glass-effect {
			background: rgba(255, 255, 255, 0.85);
			backdrop-filter: blur(20px);
			border: 1px solid rgba(255, 255, 255, 0.3);
		}

		.input-focus {
			transition: all 0.3s ease;
		}

		.input-focus:focus {
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(210, 105, 30, 0.15);
		}

		/* Wood grain pattern overlay */
		.wood-pattern {
			background-image: 
				repeating-linear-gradient(
					90deg,
					rgba(139, 69, 19, 0.03) 0px,
					transparent 1px,
					transparent 2px,
					rgba(139, 69, 19, 0.03) 3px
				);
		}

		/* Particle effect */
		.particle {
			position: absolute;
			background: rgba(210, 105, 30, 0.3);
			border-radius: 50%;
			pointer-events: none;
			animation: particle-float 15s infinite ease-in-out;
		}

		@keyframes particle-float {
			0%, 100% {
				transform: translate(0, 0) rotate(0deg);
				opacity: 0;
			}
			10%, 90% {
				opacity: 1;
			}
			50% {
				transform: translate(100px, -100px) rotate(180deg);
			}
		}
	</style>
</head>
<body class="bg-gradient-to-br from-[#FFF1DA] via-[#FFE4B5] to-[#FFDAB9] min-h-screen flex items-center justify-center relative overflow-hidden">

	<!-- Animated Background Particles -->
	<div class="absolute inset-0 overflow-hidden pointer-events-none">
		<div class="particle w-2 h-2" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
		<div class="particle w-3 h-3" style="top: 60%; left: 80%; animation-delay: 3s;"></div>
		<div class="particle w-2 h-2" style="top: 40%; left: 60%; animation-delay: 6s;"></div>
		<div class="particle w-4 h-4" style="top: 80%; left: 30%; animation-delay: 9s;"></div>
		<div class="particle w-2 h-2" style="top: 15%; left: 70%; animation-delay: 12s;"></div>
	</div>

	<!-- Forest Background -->
	<div class="absolute bottom-0 left-0 w-full h-1/2 opacity-20">
		<img src="/images/forest-placeholder.png" alt="Forest Background" class="w-full h-full object-cover">
	</div>

	<!-- Wood grain overlay -->
	<div class="absolute inset-0 wood-pattern pointer-events-none"></div>

	<!-- Main Container -->
	<div class="relative z-10 flex w-full max-w-7xl items-center justify-between px-6 py-10 gap-12" style="transform: scale(0.8); transform-origin: center;">

		<!-- Left Branding Section -->
		<div class="flex-1 hidden lg:flex flex-col items-center justify-center animate-fade-in-up">
			<div class="animate-float">
				<img src="/images/logo.png" alt="RM Wood Works Logo" class="w-96 drop-shadow-2xl filter brightness-105">
			</div>
			<div class="mt-8 text-center space-y-3">
				<h2 class="text-4xl font-bold text-[#5D2E0F] tracking-tight">Welcome Back</h2>
				<p class="text-lg text-[#8B5A2B] max-w-md leading-relaxed">
					Crafting excellence in wood since 1990. Manage your operations with ease.
				</p>
				<div class="flex items-center justify-center gap-6 mt-6 text-[#A0522D]">
					<div class="flex flex-col items-center">
						<div class="w-12 h-12 bg-white/40 rounded-full flex items-center justify-center mb-2">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
						</div>
						<span class="text-sm font-medium">Secure</span>
					</div>
					<div class="flex flex-col items-center">
						<div class="w-12 h-12 bg-white/40 rounded-full flex items-center justify-center mb-2">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
							</svg>
						</div>
						<span class="text-sm font-medium">Fast</span>
					</div>
					<div class="flex flex-col items-center">
						<div class="w-12 h-12 bg-white/40 rounded-full flex items-center justify-center mb-2">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
							</svg>
						</div>
						<span class="text-sm font-medium">Reliable</span>
					</div>
				</div>
			</div>
		</div>

		<!-- Login Card -->
		<div class="flex-1 max-w-md w-full animate-slide-in-right">
			<div class="glass-effect p-8 rounded-3xl shadow-2xl">
				<!-- Header -->
				<div class="flex flex-col items-center mb-8">
					<div class="w-20 h-20 bg-gradient-to-br from-[#D2691E] to-[#8B4513] rounded-2xl flex items-center justify-center mb-4 shadow-lg">
						<img src="/images/logo.png" alt="RM Wood Works" class="w-14 h-14 object-contain">
					</div>
					<h1 class="text-3xl font-bold text-[#5D2E0F] mb-1">RM Wood Works</h1>
					<p class="text-sm text-[#A0522D] font-medium">Management System</p>
				</div>

				<!-- Error Messages -->
				@if($errors->any())
					<div class="mb-6 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 animate-fade-in-up">
						<div class="flex items-start gap-3">
							<svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
							</svg>
							<ul class="text-sm space-y-1 flex-1">
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				<!-- Login Form -->
				<form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
					@csrf
					
					<!-- Email Input -->
					<div>
						<label class="block text-sm font-semibold text-[#5D2E0F] mb-2">
							Email Address
						</label>
						<div class="relative">
							<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
								<svg class="w-5 h-5 text-[#A0522D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
								</svg>
							</div>
							<input type="email" name="email" value="{{ old('email') }}" required
								class="input-focus w-full border-2 border-[#FFD699] rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D2691E] focus:border-transparent bg-white text-[#5D2E0F] placeholder-[#A0522D]/50"
								placeholder="you@example.com">
						</div>
					</div>

					<!-- Password Input -->
					<div>
						<label class="block text-sm font-semibold text-[#5D2E0F] mb-2">
							Password
						</label>
						<div class="relative">
							<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
								<svg class="w-5 h-5 text-[#A0522D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
								</svg>
							</div>
							<input type="password" name="password" required
								class="input-focus w-full border-2 border-[#FFD699] rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#D2691E] focus:border-transparent bg-white text-[#5D2E0F] placeholder-[#A0522D]/50"
								placeholder="Enter your password">
						</div>
					</div>

					<!-- Remember Me -->
					<div class="flex items-center justify-between">
						<label class="inline-flex items-center gap-2 text-sm text-[#5D2E0F] font-medium cursor-pointer group">
							<input type="checkbox" name="remember" 
								class="w-4 h-4 border-2 border-[#D2691E] rounded text-[#D2691E] focus:ring-2 focus:ring-[#D2691E] focus:ring-offset-0 cursor-pointer">
							<span class="group-hover:text-[#D2691E] transition-colors">Remember me</span>
						</label>
						<a href="#" class="text-sm text-[#D2691E] hover:text-[#A0522D] font-medium transition-colors">
							Forgot password?
						</a>
					</div>

					<!-- Submit Button -->
					<button type="submit"
						class="w-full bg-gradient-to-r from-[#D2691E] to-[#CD853F] text-white py-3.5 rounded-xl font-semibold text-base
							hover:from-[#A0522D] hover:to-[#8B4513] 
							active:scale-[0.98]
							transition-all duration-200 
							shadow-lg hover:shadow-xl
							flex items-center justify-center gap-2">
						<span>Sign In</span>
						<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
						</svg>
					</button>
				</form>
				
				<!-- Demo Accounts -->
				<div class="mt-8 bg-gradient-to-br from-white/60 to-white/80 rounded-xl p-5 border border-[#FFD699]/30">
					<div class="flex items-center gap-2 mb-3">
						<svg class="w-5 h-5 text-[#D2691E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
						</svg>
						<p class="font-bold text-[#5D2E0F] text-sm">Demo Accounts</p>
					</div>
					<div class="grid grid-cols-1 gap-2 text-xs">
						<div class="bg-white/50 rounded-lg px-3 py-2 hover:bg-white/80 transition-colors">
							<p class="font-semibold text-[#5D2E0F]">Admin</p>
							<p class="text-[#8B5A2B] font-mono">admin@rmwoodworks.com / admin123</p>
						</div>
						<div class="bg-white/50 rounded-lg px-3 py-2 hover:bg-white/80 transition-colors">
							<p class="font-semibold text-[#5D2E0F]">Inventory Clerk</p>
							<p class="text-[#8B5A2B] font-mono">inventory@rmwoodworks.com / inventory123</p>
						</div>
						<div class="bg-white/50 rounded-lg px-3 py-2 hover:bg-white/80 transition-colors">
							<p class="font-semibold text-[#5D2E0F]">Procurement Officer</p>
							<p class="text-[#8B5A2B] font-mono">procurement@rmwoodworks.com / procurement123</p>
						</div>
						<details class="group">
							<summary class="bg-white/50 rounded-lg px-3 py-2 hover:bg-white/80 transition-colors cursor-pointer list-none flex items-center justify-between">
								<span class="font-semibold text-[#5D2E0F] text-xs">View more accounts</span>
								<svg class="w-4 h-4 text-[#A0522D] group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
								</svg>
							</summary>
							<div class="mt-2 space-y-2">
								<div class="bg-white/50 rounded-lg px-3 py-2 hover:bg-white/80 transition-colors">
									<p class="font-semibold text-[#5D2E0F]">Workshop Staff</p>
									<p class="text-[#8B5A2B] font-mono">workshop@rmwoodworks.com / workshop123</p>
								</div>
								<div class="bg-white/50 rounded-lg px-3 py-2 hover:bg-white/80 transition-colors">
									<p class="font-semibold text-[#5D2E0F]">Sales Clerk</p>
									<p class="text-[#8B5A2B] font-mono">sales@rmwoodworks.com / sales123</p>
								</div>
								<div class="bg-white/50 rounded-lg px-3 py-2 hover:bg-white/80 transition-colors">
									<p class="font-semibold text-[#5D2E0F]">Accounting Staff</p>
									<p class="text-[#8B5A2B] font-mono">accounting@rmwoodworks.com / accounting123</p>
								</div>
							</div>
						</details>
					</div>
				</div>
			</div>

			<!-- Footer -->
			<div class="mt-6 text-center">
				<p class="text-sm text-[#8B5A2B]">
					© 2024 RM Wood Works. All rights reserved.
				</p>
			</div>
		</div>
	</div>

</body>
</html>