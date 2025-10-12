<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sales Orders & Customers</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
	<div class="container mx-auto mt-6">
		<div class="flex justify-between items-center mb-4">
			<div></div>
			<div>
				@auth
					<span class="text-sm text-gray-700 mr-3">{{ auth()->user()->name }}</span>
					<form method="POST" action="{{ route('logout') }}" class="inline">
						@csrf
						<button class="px-3 py-1 text-sm bg-gray-800 text-white rounded">Logout</button>
					</form>
				@else
					<a href="{{ route('login') }}" class="text-sm text-blue-700">Login</a>
				@endauth
			</div>
		</div>

		@if(session('success'))
			<div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
		@endif
		@if($errors->any())
			<div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800">
				<ul class="list-disc list-inside">
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		@yield('content')
	</div>

	<script>
		function openModal(id) {
			document.getElementById(id).classList.remove('hidden');
		}
		function closeModal(id) {
			document.getElementById(id).classList.add('hidden');
		}
	</script>
</body>
</html>
