<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header & Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                Laporan Peminjaman
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Export data peminjaman ke Excel atau PDF</p>
                        </div>
                        <div class="flex space-x-3 mt-4 md:mt-0">
                            <a href="{{ route('laporan.excel', request()->all()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300 shadow flex items-center">
                                <i class="fas fa-file-excel mr-2"></i> Export Excel
                            </a>
                            <a href="{{ route('laporan.pdf', request()->all()) }}" class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300 shadow flex items-center">
                                <i class="fas fa-file-pdf mr-2"></i> Export PDF
                            </a>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('laporan.index') }}" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                                <select name="role" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Role</option>
                                    <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                <select name="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('laporan.index') }}" class="mr-3 px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">Reset</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-300">
                                <i class="fas fa-filter mr-2"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Pinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Kembali</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ket</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($peminjaman as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $item->peminjam_nama }}
                                        <div class="text-xs text-gray-500">{{ $item->identitas }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->role == 'siswa')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Siswa</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Guru</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $item->barang_nama }}
                                        <div class="text-xs text-gray-500">{{ $item->kode_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $today = \Carbon\Carbon::now();
                                            $returnDate = \Carbon\Carbon::parse($item->tanggal_kembali);
                                        @endphp
                                        @if($returnDate->lt($today))
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Terlambat</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ Str::limit($item->keterangan, 20) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada data yang sesuai filter
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
