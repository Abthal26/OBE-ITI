<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OBE System') - OBE ITI</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #64748b;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
        }
        
        .sidebar-link:hover {
            background-color: #f1f5f9;
            color: #334155;
        }
        
        .sidebar-link.active {
            background-color: #4f46e5;
            color: white;
        }
        
        .sidebar-link.active svg {
            color: white;
        }
        
        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            border: 1px solid #e2e8f0;
        }
        
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: #4f46e5;
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
        }
        
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
        }
        
        .btn-secondary:hover {
            background-color: #e2e8f0;
        }
        
        .btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: #ef4444;
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
        }
        
        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.15s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.375rem;
        }
        
        .table-header {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background-color: #f8fafc;
        }
        
        .table-cell {
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
            color: #475569;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-info { background-color: #dbeafe; color: #1e40af; }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans bg-slate-50 text-slate-900 antialiased">
    <div x-data="{ sidebarOpen: true, mobileMenuOpen: false }" class="min-h-screen">
        
        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" x-cloak @click="mobileMenuOpen = false" 
             class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden"></div>
        
        <!-- Sidebar -->
        <aside 
            :class="[
                sidebarOpen ? 'lg:w-64' : 'lg:w-20',
                mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
            ]"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 transition-all duration-200 ease-out"
        >
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="h-16 flex items-center gap-3 px-4 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition.opacity class="font-bold text-lg text-slate-900">
                        OBE ITI
                    </span>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
                    @auth
                        @php $userRole = auth()->user()->role; @endphp
                        
                        {{-- Admin Menu --}}
                        @if($userRole === 'admin')
                            <div class="mb-6">
                                <p x-show="sidebarOpen" class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Master Data
                                </p>
                                
                                <a href="{{ route('admin.cpls.index') }}" class="sidebar-link {{ request()->routeIs('admin.cpls.*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <span x-show="sidebarOpen">CPL</span>
                                </a>
                                
                                <a href="{{ route('admin.courses.index') }}" class="sidebar-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span x-show="sidebarOpen">Mata Kuliah</span>
                                </a>
                                
                                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span x-show="sidebarOpen">Pengguna</span>
                                </a>
                                
                                <a href="{{ route('admin.students.index') }}" class="sidebar-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <span x-show="sidebarOpen">Mahasiswa</span>
                                </a>
                            </div>
                            
                            <div class="mb-6">
                                <p x-show="sidebarOpen" class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Akses Cepat
                                </p>
                                
                                <a href="{{ route('dosen.dashboard') }}" class="sidebar-link {{ request()->routeIs('dosen.*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span x-show="sidebarOpen">Input Nilai</span>
                                </a>
                                
                                <a href="{{ route('kaprodi.dashboard') }}" class="sidebar-link {{ request()->routeIs('kaprodi.*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <span x-show="sidebarOpen">Laporan</span>
                                </a>
                            </div>
                        @endif
                        
                        {{-- Dosen Menu --}}
                        @if($userRole === 'dosen')
                            <div class="mb-6">
                                <p x-show="sidebarOpen" class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Menu
                                </p>
                                
                                <a href="{{ route('dosen.dashboard') }}" class="sidebar-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span x-show="sidebarOpen">Dashboard</span>
                                </a>
                            </div>
                            
                            <div>
                                <p x-show="sidebarOpen" class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Bantuan
                                </p>
                                
                                <div x-show="sidebarOpen" class="px-3 py-2 text-xs text-slate-500 leading-relaxed">
                                    Pilih mata kuliah dari dashboard untuk mengelola CPMK, Asesmen, dan Nilai.
                                </div>
                            </div>
                        @endif
                        
                        {{-- Kaprodi Menu --}}
                        @if($userRole === 'kaprodi')
                            <div class="mb-6">
                                <p x-show="sidebarOpen" class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Menu
                                </p>
                                
                                <a href="{{ route('kaprodi.dashboard') }}" class="sidebar-link {{ request()->routeIs('kaprodi.dashboard') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span x-show="sidebarOpen">Dashboard</span>
                                </a>
                            </div>
                            
                            <div>
                                <p x-show="sidebarOpen" class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Laporan
                                </p>
                                
                                <a href="{{ route('kaprodi.reports.cpl') }}" class="sidebar-link {{ request()->routeIs('kaprodi.reports.cpl*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span x-show="sidebarOpen">Capaian CPL</span>
                                </a>
                                
                                <a href="{{ route('kaprodi.reports.courses') }}" class="sidebar-link {{ request()->routeIs('kaprodi.reports.courses*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span x-show="sidebarOpen">Per Mata Kuliah</span>
                                </a>
                            </div>
                        @endif
                    @endauth
                </nav>
                
                <!-- User Section -->
                @auth
                <div class="p-3 border-t border-slate-100">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div x-show="sidebarOpen" class="flex-1 text-left min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <svg x-show="sidebarOpen" class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute bottom-full left-0 right-0 mb-1 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 text-left text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
                
                <!-- Toggle Button (Desktop) -->
                <button 
                    @click="sidebarOpen = !sidebarOpen" 
                    class="hidden lg:flex absolute -right-3 top-20 w-6 h-6 bg-white border border-slate-200 rounded-full items-center justify-center shadow-sm hover:bg-slate-50 transition-colors z-50"
                >
                    <svg :class="sidebarOpen ? '' : 'rotate-180'" class="w-3.5 h-3.5 text-slate-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main :class="sidebarOpen ? 'lg:pl-64' : 'lg:pl-20'" class="min-h-screen transition-all duration-200">
            <!-- Top Bar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-6 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <div>
                        <h1 class="text-lg font-semibold text-slate-900">@yield('title', 'Dashboard')</h1>
                        @hasSection('subtitle')
                            <p class="text-sm text-slate-500">@yield('subtitle')</p>
                        @endif
                    </div>
                </div>
                
                <!-- Breadcrumb / Quick Actions -->
                <div class="flex items-center gap-2">
                    @yield('actions')
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="p-4 lg:p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show"
                         class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                        <button @click="show = false" class="text-red-500 hover:text-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        <div class="flex items-center gap-2 mb-1 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Terjadi kesalahan:
                        </div>
                        <ul class="list-disc list-inside pl-6 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>
