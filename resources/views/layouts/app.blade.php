<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'POS System') }}</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 overflow-y-auto transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0"
             :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <span class="text-white text-2xl font-semibold">{{ config('app.name') }}</span>
                </div>
            </div>

            <nav class="mt-10">
                <x-nav-link route="dashboard" icon="fas fa-home">
                    Dashboard
                </x-nav-link>
                
                <x-nav-link route="pos.index" icon="fas fa-cash-register">
                    POS
                </x-nav-link>
                
                @if(auth()->user()->isAdmin())
                    <x-nav-link route="products.index" icon="fas fa-box">
                        Products
                    </x-nav-link>
                    
                    <x-nav-link route="categories.index" icon="fas fa-tags">
                        Categories
                    </x-nav-link>
                    
                    <x-nav-link route="brands.index" icon="fas fa-copyright">
                        Brands
                    </x-nav-link>
                @endif
                
                <x-nav-link route="sales.index" icon="fas fa-chart-line">
                    Sales
                </x-nav-link>
            </nav>
        </div>

        <!-- Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <div class="flex items-center">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button class="flex items-center text-gray-700 hover:text-gray-900">
                                <span class="mx-2">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </x-slot>

                        <x-dropdown-link href="{{ route('profile.edit') }}">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-dropdown>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-6">
                @if(session('success'))
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-init="setTimeout(() => show = false, 3000)"
                         class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-init="setTimeout(() => show = false, 3000)"
                         class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
