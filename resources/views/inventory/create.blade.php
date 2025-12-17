<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-purple-500 to-purple-600">
                    <h2 class="text-2xl font-bold text-white">Tambah Inventory</h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('inventory.store') }}">
                        @csrf

                        @if ($errors->any())
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <p class="font-semibold">Terdapat kesalahan:</p>
                            </div>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kode Barang *</label>
                                <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Barang *</label>
                                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                                <input type="text" name="kategori" value="{{ old('kategori') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah *</label>
                                <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Satuan</label>
                                <input type="text" name="satuan" value="{{ old('satuan') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" placeholder="Pcs, Unit, dll">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kondisi *</label>
                                <select name="kondisi" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                                    <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keterangan</label>
                                <textarea name="keterangan" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ old('keterangan') }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ditambahkan Oleh</label>
                                <input type="text" value="{{ auth()->user()->name }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 dark:text-gray-400 focus:outline-none cursor-not-allowed" readonly>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('inventory.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">Batal</a>
                            <button type="submit" class="px-6 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>