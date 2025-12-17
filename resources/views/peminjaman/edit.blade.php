<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-yellow-500 to-yellow-600">
                    <h2 class="text-2xl font-bold text-white">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Peminjaman
                    </h2>
                    <p class="text-yellow-100 text-sm mt-1">Ubah data peminjaman yang sudah ada</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}">
                        @csrf
                        @method('PUT')

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

                            <!-- Role Peminjam -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Role Peminjam <span class="text-red-500">*</span>
                                </label>
                                <select name="role" id="role" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-yellow-500 focus:ring-yellow-500" required onchange="loadPeminjam()">
                                    <option value="">Pilih Role</option>
                                    <option value="siswa" {{ old('role', $peminjaman->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="guru" {{ old('role', $peminjaman->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                                </select>
                            </div>

                            <!-- Peminjam -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Peminjam <span class="text-red-500">*</span>
                                </label>
                                <select name="peminjam_id" id="peminjam_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-yellow-500 focus:ring-yellow-500" required>
                                    <option value="">Pilih Peminjam</option>
                                    <!-- Options will be loaded via JS or server-side fallback -->
                                    @if($peminjaman->role == 'siswa')
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('peminjam_id', $peminjaman->peminjam_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->nama_lengkap }} ({{ $student->nisn }})
                                    </option>
                                    @endforeach
                                    @else
                                    @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ old('peminjam_id', $peminjaman->peminjam_id) == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama_lengkap }} ({{ $guru->nip }})
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- Barang -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Barang yang Dipinjam <span class="text-red-500">*</span>
                                </label>
                                <select name="barang_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-yellow-500 focus:ring-yellow-500" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach($inventories as $item)
                                    <option value="{{ $item->id }}" {{ old('barang_id', $peminjaman->barang_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_barang }} ({{ $item->kode_barang }}) - Stok: {{ $item->jumlah }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jumlah -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jumlah Barang <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="jumlah" value="{{ old('jumlah', $peminjaman->jumlah) }}" min="1" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-yellow-500 focus:ring-yellow-500" required>
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Pinjam <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-yellow-500 focus:ring-yellow-500" required>
                            </div>

                            <!-- Tanggal Kembali -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Kembali <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-yellow-500 focus:ring-yellow-500" required>
                            </div>


                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status Peminjaman <span class="text-red-500">*</span>
                                </label>
                                <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-yellow-500 focus:ring-yellow-500" required>
                                    <option value="dipinjam" {{ old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="kembali" {{ old('status', $peminjaman->status) == 'kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                                </select>
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Keterangan
                                </label>
                                <textarea name="keterangan" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-yellow-500 focus:ring-yellow-500" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan', $peminjaman->keterangan) }}</textarea>
                            </div>

                            <!-- Added By (ReadOnly/Hidden) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ditambahkan Oleh
                                </label>
                                <input type="text" value="{{ $peminjaman->added_by }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 dark:text-gray-400 focus:outline-none cursor-not-allowed" readonly>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end space-x-4">
                            <a href="{{ route('peminjaman.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 font-medium">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition duration-300 shadow-lg hover:shadow-yellow-500/30 -translate-y-0.5 active:translate-y-0">
                                <i class="fas fa-save mr-2"></i>Update Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function loadPeminjam() {
            const role = document.getElementById('role').value;
            const peminjamSelect = document.getElementById('peminjam_id');
            const currentPeminjamId = "{{ old('peminjam_id', $peminjaman->peminjam_id) }}";

            if (!role) {
                peminjamSelect.innerHTML = '<option value="">Pilih Role Terlebih Dahulu</option>';
                return;
            }

            peminjamSelect.innerHTML = '<option value="">Loading...</option>';

            // Ambil data berdasarkan role
            let data = [];

            @if(isset($students))
            const students = @json($students);
            @endif

            @if(isset($gurus))
            const gurus = @json($gurus);
            @endif

            if (role === 'siswa' && typeof students !== 'undefined') {
                data = students;
            } else if (role === 'guru' && typeof gurus !== 'undefined') {
                data = gurus;
            }

            peminjamSelect.innerHTML = '<option value="">Pilih ' + (role === 'siswa' ? 'Siswa' : 'Guru') + '</option>';

            data.forEach(function(item) {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.nama_lengkap + ' (' + (item.nisn || item.nip) + ')';

                // Keep selected if role matches
                if (item.id == currentPeminjamId) {
                    option.selected = true;
                }

                peminjamSelect.appendChild(option);
            });
        }
    </script>
    @endpush
</x-app-layout>