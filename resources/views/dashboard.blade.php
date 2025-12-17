<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-slate-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Dashboard Overview
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Selamat datang kembali, <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ Auth::user()->name }}</span>. Berikut adalah ringkasan data sekolah.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                <!-- Siswa Card -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                            <i class="fas fa-user-graduate text-2xl text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-slate-700 px-2 py-1 rounded-full">Total</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Siswa</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Data Siswa Aktif</p>
                    <a href="{{ route('student.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center group">
                        Lihat Detail <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <!-- Guru Card -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-lg">
                            <i class="fas fa-chalkboard-teacher text-2xl text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-slate-700 px-2 py-1 rounded-full">Total</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Guru</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Data Guru Pengajar</p>
                    <a href="{{ route('guru.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 flex items-center group">
                        Lihat Detail <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <!-- Inventaris Card -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-3 rounded-lg">
                            <i class="fas fa-boxes text-2xl text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-slate-700 px-2 py-1 rounded-full">Total</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Inventaris</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Barang Sekolah</p>
                    <a href="{{ route('inventory.index') }}" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 flex items-center group">
                        Lihat Detail <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <!-- Peminjaman Card -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-orange-50 dark:bg-orange-900/20 p-3 rounded-lg">
                            <i class="fas fa-handshake text-2xl text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-slate-700 px-2 py-1 rounded-full">Aktif</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Peminjaman</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Transaksi Berjalan</p>
                    <a href="{{ route('peminjaman.index') }}" class="text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 flex items-center group">
                        Lihat Detail <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

            </div>

            <!-- Quick Actions & System Info -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Quick Actions -->
                <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('student.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-gray-50 dark:bg-slate-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors group border border-transparent hover:border-blue-200 dark:hover:border-blue-800">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-plus text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">Siswa Baru</span>
                        </a>
                        
                        <a href="{{ route('guru.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-gray-50 dark:bg-slate-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors group border border-transparent hover:border-indigo-200 dark:hover:border-indigo-800">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-plus text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">Guru Baru</span>
                        </a>

                        <a href="{{ route('inventory.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-gray-50 dark:bg-slate-700 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors group border border-transparent hover:border-purple-200 dark:hover:border-purple-800">
                            <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-plus text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-purple-600 dark:group-hover:text-purple-400">Barang Baru</span>
                        </a>

                        <a href="{{ route('peminjaman.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-gray-50 dark:bg-slate-700 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors group border border-transparent hover:border-orange-200 dark:hover:border-orange-800">
                            <div class="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-900/50 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-plus text-orange-600 dark:text-orange-400"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-orange-600 dark:group-hover:text-orange-400">Peminjaman</span>
                        </a>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Status Sistem</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-slate-700/50">
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Database</span>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/30 px-2 py-1 rounded">Connected</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-slate-700/50">
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Server</span>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/30 px-2 py-1 rounded">Online</span>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-slate-700">
                            <p class="text-xs text-center text-gray-400 dark:text-gray-500">
                                Last updated: {{ now()->format('H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>