<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
	<div class="w-full max-w-sm bg-white rounded-lg shadow p-6">
		<h1 class="text-xl font-semibold mb-1">Welcome</h1>
		<p class="text-gray-600 mb-4">Sign in to continue</p>

		@if($errors->any())
			<div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800">
				<ul class="list-disc list-inside">
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" action="{{ route('login.attempt') }}" class="grid gap-3">
			@csrf
			<div>
				<label class="text-sm">Email</label>
				<input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
			</div>
			<div>
				<label class="text-sm">Password</label>
				<input type="password" name="password" required class="w-full border rounded px-3 py-2">
			</div>
			<label class="inline-flex items-center gap-2 text-sm">
				<input type="checkbox" name="remember" class="border rounded">
				Remember me
			</label>
			<button type="submit" class="w-full bg-gray-800 text-white rounded py-2">Sign in</button>
		</form>

		<div class="text-xs text-gray-500 mt-4">
			Demo: manager@worker.com / manager123
		</div>
	</div>
</body>
</html>
