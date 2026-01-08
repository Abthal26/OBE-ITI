<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBE System - Outcome Based Education</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased">
    <!-- Hero Section -->
    <div class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 left-0 w-full h-full" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
        </div>
        
        <!-- Decorative Blobs -->
        <div class="absolute top-20 right-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        
        <!-- Navigation -->
        <nav class="relative z-20 px-6 py-5">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">OBE ITI</span>
                </div>
                
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition-all shadow-lg hover:shadow-xl">
                    Login
                </a>
            </div>
        </nav>
        
        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 pt-20 pb-32">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-8 border border-white/20">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Sistem Pendidikan Berbasis Capaian
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                        Outcome Based
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-pink-300 to-yellow-300">Education System</span>
                    </h1>
                    
                    <p class="text-xl text-indigo-100 mb-10 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                        Kelola Capaian Pembelajaran Lulusan (CPL) dan Capaian Pembelajaran Mata Kuliah (CPMK) dengan mudah dan otomatis.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('login') }}" class="group px-8 py-4 bg-white text-indigo-600 font-semibold rounded-xl hover:bg-indigo-50 transition-all shadow-xl hover:shadow-2xl inline-flex items-center justify-center gap-3">
                            Mulai Sekarang
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="hidden lg:block">
                    <div class="relative">
                        <!-- Main Card -->
                        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 shadow-2xl">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-lg">CPL Achievement</h3>
                                    <p class="text-indigo-200 text-sm">Program Learning Outcomes</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="bg-white/5 rounded-xl p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-white font-medium">CPL-1</span>
                                        <span class="text-green-300 font-bold">85%</span>
                                    </div>
                                    <div class="w-full h-3 bg-white/20 rounded-full overflow-hidden">
                                        <div class="w-[85%] h-full bg-gradient-to-r from-green-400 to-emerald-400 rounded-full"></div>
                                    </div>
                                </div>
                                
                                <div class="bg-white/5 rounded-xl p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-white font-medium">CPL-2</span>
                                        <span class="text-blue-300 font-bold">78%</span>
                                    </div>
                                    <div class="w-full h-3 bg-white/20 rounded-full overflow-hidden">
                                        <div class="w-[78%] h-full bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full"></div>
                                    </div>
                                </div>
                                
                                <div class="bg-white/5 rounded-xl p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-white font-medium">CPL-3</span>
                                        <span class="text-purple-300 font-bold">92%</span>
                                    </div>
                                    <div class="w-full h-3 bg-white/20 rounded-full overflow-hidden">
                                        <div class="w-[92%] h-full bg-gradient-to-r from-purple-400 to-pink-400 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Badge -->
                        <div class="absolute -top-4 -right-4 bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                            ✓ Auto Calculate
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="py-24 px-6 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="text-indigo-600 font-semibold text-sm uppercase tracking-wider">Fitur</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-2 mb-4">Fitur Utama Sistem</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Sistem OBE yang lengkap untuk mengelola dan memantau capaian pembelajaran</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-indigo-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors">
                        <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pemetaan CPL & CPMK</h3>
                    <p class="text-gray-600">Kelola hubungan antara CPL program studi dengan CPMK setiap mata kuliah secara terstruktur.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="group bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-colors">
                        <svg class="w-8 h-8 text-emerald-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Perhitungan Otomatis</h3>
                    <p class="text-gray-600">Sistem menghitung capaian CPMK dan CPL secara otomatis berdasarkan bobot dan nilai asesmen.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="group bg-white rounded-2xl p-8 border-2 border-gray-100 hover:border-purple-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center mb-6 group-hover:bg-purple-600 transition-colors">
                        <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Laporan Komprehensif</h3>
                    <p class="text-gray-600">Generate laporan capaian per mahasiswa, kelas, dan program studi dengan visualisasi yang jelas.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Roles Section -->
    <div class="py-24 px-6 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="text-indigo-600 font-semibold text-sm uppercase tracking-wider">Akses</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-2 mb-4">Berdasarkan Peran</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Setiap pengguna memiliki akses yang disesuaikan dengan perannya</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Admin -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-500 to-rose-600 flex items-center justify-center mb-6 shadow-lg shadow-red-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Admin</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Kelola Program Studi
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Kelola CPL
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Kelola Pengguna & Mahasiswa
                        </li>
                    </ul>
                </div>
                
                <!-- Kaprodi -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mb-6 shadow-lg shadow-blue-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Kaprodi</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Lihat Laporan CPL
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Monitor Capaian Prodi
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Export Laporan
                        </li>
                    </ul>
                </div>
                
                <!-- Dosen -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center mb-6 shadow-lg shadow-emerald-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Dosen</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Input Nilai Asesmen
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Kelola CPMK & Asesmen
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Lihat Laporan Mata Kuliah
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="py-8 px-6 bg-gray-900">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} OBE System ITI. Built with Laravel.</p>
        </div>
    </footer>
</body>
</html>
