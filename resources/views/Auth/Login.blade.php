<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RM Wood Works Login</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFF1DA] min-h-screen flex items-center justify-center relative overflow-hidden">

	<!-- Forest Background Placeholder -->
	<div class="absolute bottom-0 left-0 w-full">
		<!-- Replace with your own forest background -->
		<img src="/images/forest-placeholder.png" alt="Forest Background" class="w-full object-cover opacity-90">
	</div>

	<!-- Main Container -->
	<div class="relative z-10 flex w-full max-w-6xl items-center justify-between px-6 py-10">

		<!-- Left Logo Section -->
		<div class="flex flex-col items-center justify-center text-center w-1/2 hidden md:flex">
			<img src="/images/logo.png" alt="RM Wood Works Logo" class="w-80 mb-4">
		</div>

		<!-- Login Card -->
		<div class="bg-white/30 backdrop-blur-md p-10 rounded-2xl shadow-md w-full max-w-md">
			<div class="flex flex-col items-center mb-6">
				<img src="/images/logo.png" alt="RM Wood Works Small Logo" class="w-16 mb-2">
				<h1 class="text-2xl font-semibold text-[#7A3E00]">RM Wood Works</h1>
				<p class="text-sm text-[#A0522D]">Management System Login</p>
			</div>

			@if($errors->any())
				<div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 w-full">
					<ul class="list-disc list-inside">
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
				@csrf
				<div>
					<label class="block text-sm font-semibold text-[#A0522D]">Email</label>
					<input type="email" name="email" value="{{ old('email') }}" required
						class="w-full border border-[#FFD699] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#D2691E] bg-white">
				</div>
				<div>
					<label class="block text-sm font-semibold text-[#A0522D]">Password</label>
					<input type="password" name="password" required
						class="w-full border border-[#FFD699] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#D2691E] bg-white">
				</div>
				<label class="inline-flex items-center gap-2 text-sm text-[#7A3E00]">
					<input type="checkbox" name="remember" class="border rounded">
					Remember me
				</label>
				<button type="submit"
					class="w-full bg-[#D2691E] text-white py-2 rounded-md hover:bg-[#A0522D] transition-colors">
					Sign In
				</button>
			</form>
			
			<div class="mt-6 bg-white/70 rounded-md p-4 text-sm">
				<p class="font-semibold text-[#A0522D] mb-1">Demo accounts:</p>
				<ul class="text-[#7A3E00] space-y-1">
					<li><b>Admin:</b> admin@rmwoodworks.com / admin123</li>
					<li><b>Manager:</b> manager@rmwoodworks.com / manager123</li>
					<li><b>Worker:</b> worker@rmwoodworks.com / worker123</li>
				</ul>
			</div>
		</div>
	</div>

</body>
</html>
