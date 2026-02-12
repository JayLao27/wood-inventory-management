<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Loading Indicator -->
        <div id="pageLoader" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[9999] hidden items-center justify-center">
            <div class="bg-white rounded-lg p-6 shadow-2xl flex items-center gap-3">
                <svg class="animate-spin h-6 w-6 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 font-medium">Loading...</span>
            </div>
        </div>

        <div class="flex h-screen bg-gray-100">@include('layouts.sidebar')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                @yield('main-content')
            </div>
        </div>

        <script>
            // Show loading indicator on navigation
            document.addEventListener('DOMContentLoaded', function() {
                const loader = document.getElementById('pageLoader');
                const links = document.querySelectorAll('a:not([target="_blank"])');
                
                links.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Only show loader for navigation links (not javascript:void, #, or current page)
                        const href = this.getAttribute('href');
                        if (href && href !== '#' && !href.startsWith('javascript:') && href !== window.location.pathname) {
                            loader.classList.remove('hidden');
                            loader.classList.add('flex');
                        }
                    });
                });

                // Hide loader when page is fully loaded (backup)
                window.addEventListener('pageshow', function() {
                    loader.classList.add('hidden');
                    loader.classList.remove('flex');
                });
            });
        </script>
    </body>
</html>
