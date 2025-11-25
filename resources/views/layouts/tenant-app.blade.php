<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="m-0 p-0">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', tenant('clinic_name') ?? 'MultiImune')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: '#eff6ff',
                                500: '#3b82f6',
                                600: '#2563eb',
                                700: '#1d4ed8',
                            }
                        }
                    }
                }
            }
        </script>
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-50 via-blue-50/30 to-cyan-50/30 m-0 p-0" style="margin: 0 !important; padding: 0 !important;" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex" style="margin: 0; padding: 0;">
            @include('layouts.tenant-sidebar')

            <!-- Main Content -->
            <main class="flex-1 lg:ml-64 flex flex-col">
                @include('layouts.tenant-header')
                
                <div class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
                    <div class="max-w-7xl mx-auto">
                        @yield('content')
                    </div>
                </div>

                @include('layouts.tenant-footer')
            </main>
        </div>
        
        @stack('scripts')
    </body>
</html>