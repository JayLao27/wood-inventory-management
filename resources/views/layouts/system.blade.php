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
        <style>
            #pageLoader .loader-container {
                text-align: center;
                position: relative;
            }

            #pageLoader .logo-wrapper {
                position: relative;
                width: 260px;
                height: 260px;
                margin: 0 auto 28px;
            }

            #pageLoader .logo {
                width: 100%;
                height: 100%;
                object-fit: contain;
                filter: brightness(0) invert(1);
                animation: logoFloat 3s ease-in-out infinite;
            }

            @keyframes logoFloat {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-12px); }
            }

            #pageLoader .circle-glow {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 240px;
                height: 240px;
                border-radius: 50%;
                border: 3px solid rgba(255, 255, 255, 0.15);
                animation: pulse 2s ease-in-out infinite;
            }

            @keyframes pulse {
                0%, 100% {
                    transform: translate(-50%, -50%) scale(1);
                    opacity: 0.3;
                }
                50% {
                    transform: translate(-50%, -50%) scale(1.08);
                    opacity: 0.6;
                }
            }

            #pageLoader .rotating-gear {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 300px;
                height: 300px;
                border: 2px dashed rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                animation: rotate 8s linear infinite;
            }

            @keyframes rotate {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(360deg); }
            }

            #pageLoader .rotating-gear::before {
                content: '';
                position: absolute;
                top: -4px;
                left: 50%;
                width: 8px;
                height: 8px;
                background: #ffffff;
                border-radius: 50%;
                transform: translateX(-50%);
            }

            #pageLoader .loading-text {
                color: #ffffff;
                font-size: 20px;
                font-weight: 300;
                letter-spacing: 4px;
                text-transform: uppercase;
                margin-bottom: 16px;
                animation: textPulse 2s ease-in-out infinite;
            }

            @keyframes textPulse {
                0%, 100% { opacity: 0.5; }
                50% { opacity: 1; }
            }

            #pageLoader .progress-bar {
                width: 260px;
                height: 3px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                margin: 0 auto;
                overflow: hidden;
                position: relative;
            }

            #pageLoader .progress-fill {
                height: 100%;
                background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0.3) 0%,
                    #ffffff 50%,
                    rgba(255, 255, 255, 0.3) 100%);
                border-radius: 10px;
                animation: progressSlide 2s ease-in-out infinite;
                width: 50%;
            }

            @keyframes progressSlide {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(200%); }
            }

            #pageLoader .dots {
                margin-top: 12px;
                display: flex;
                justify-content: center;
                gap: 8px;
            }

            #pageLoader .dot {
                width: 8px;
                height: 8px;
                background: #ffffff;
                border-radius: 50%;
                animation: dotBounce 1.4s ease-in-out infinite;
            }

            #pageLoader .dot:nth-child(1) { animation-delay: 0s; }
            #pageLoader .dot:nth-child(2) { animation-delay: 0.2s; }
            #pageLoader .dot:nth-child(3) { animation-delay: 0.4s; }

            @keyframes dotBounce {
                0%, 60%, 100% {
                    transform: translateY(0);
                    opacity: 0.4;
                }
                30% {
                    transform: translateY(-12px);
                    opacity: 1;
                }
            }

            #pageLoader .particles {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                pointer-events: none;
            }

            #pageLoader .particle {
                position: absolute;
                width: 2px;
                height: 2px;
                background: #ffffff;
                border-radius: 50%;
                opacity: 0;
                animation: particleFloat 4s ease-in-out infinite;
            }

            @keyframes particleFloat {
                0% {
                    transform: translateY(0) translateX(0);
                    opacity: 0;
                }
                20% { opacity: 0.6; }
                100% {
                    transform: translateY(-180px) translateX(var(--drift));
                    opacity: 0;
                }
            }

            #pageLoader .particle:nth-child(1) { left: 20%; animation-delay: 0s; --drift: 20px; }
            #pageLoader .particle:nth-child(2) { left: 40%; animation-delay: 0.8s; --drift: -15px; }
            #pageLoader .particle:nth-child(3) { left: 60%; animation-delay: 1.6s; --drift: 25px; }
            #pageLoader .particle:nth-child(4) { left: 80%; animation-delay: 2.4s; --drift: -20px; }
            #pageLoader .particle:nth-child(5) { left: 30%; animation-delay: 3.2s; --drift: 15px; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Loading Indicator -->
        <div id="pageLoader" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[9999] hidden items-center justify-center">
            <div class="loader-container">
                <div class="logo-wrapper">
                    <div class="rotating-gear"></div>
                    <div class="circle-glow"></div>
                    <img src="{{ asset('images/Logo.png') }}" alt="RM Wood Works" class="logo">
                    <div class="particles">
                        <div class="particle"></div>
                        <div class="particle"></div>
                        <div class="particle"></div>
                        <div class="particle"></div>
                        <div class="particle"></div>
                    </div>
                </div>
                <div class="loading-text">Loading</div>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <div class="dots">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
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
        @stack('modals')
    </body>
</html>
