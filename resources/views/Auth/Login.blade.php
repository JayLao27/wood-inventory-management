<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RM Woodworks - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="m-0 font-sans bg-[#FFF1DA] flex h-screen">

  <!-- Left Panel -->
  <div class="flex-1 flex items-center justify-center bg-contain bg-center bg-no-repeat" 
       style="background-image: url('{{ asset('images/woodworks-bg.png') }}');">
    <img src="{{ asset('images/logo.png') }}" alt="RM Woodworks Logo" class="max-w-[300px]">
  </div>

  <!-- Right Panel -->
  <div class="flex-1 flex items-center justify-center">
    <div class="bg-[#fff9f1] p-10 rounded-xl shadow-md w-full max-w-md text-center">
      <img src="{{ asset('images/logo.png') }}" alt="Small Logo" class="h-14 mb-4 mx-auto">
      <h2 class="m-0 text-[22px] font-semibold text-[#6B3D00]">RM Woodworks</h2>
      <p class="text-sm mb-5 text-[#A75F00]">Management System Login</p>

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" required
               class="w-full px-4 py-3 border border-[#FFD28C] rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#E17100]">
        <input type="password" name="password" placeholder="Enter your password" required
               class="w-full px-4 py-3 border border-[#FFD28C] rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#E17100]">
        <button type="submit" 
                class="w-full py-3 bg-[#E17100] text-white text-base font-semibold rounded-md hover:bg-[#c86000] transition">
          Sign In
        </button>
      </form>

      <!-- Demo Accounts -->
      <div class="bg-[#FFF1DA] border border-[#FFD28C] rounded-md p-3 mt-6 text-left text-sm">
        <p class="font-semibold text-[#E17100]">Demo accounts:</p>
        <p>Admin: admin@rmwoodworks.com / admin123</p>
        <p>Manager: manager@rmwoodworks.com / manager123</p>
        <p>Worker: worker@rmwoodworks.com / worker123</p>
      </div>
    </div>
  </div>

</body>
</html>
