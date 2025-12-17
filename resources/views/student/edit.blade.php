<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-yellow-500 to-yellow-600">
                    <h2 class="text-2xl font-bold text-white">Edit Siswa</h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('student.update', $student->id) }}">
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
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NISN *</label>
                                <input type="text" name="nisn" value="{{ old('nisn', $student->nisn) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap *</label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $student->nama_lengkap) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tempat Lahir *</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $student->tempat_lahir) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Lahir *</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jurusan *</label>
                                <input type="text" name="jurusan" value="{{ old('jurusan', $student->jurusan) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Angkatan *</label>
                                <input type="text" name="angkatan" value="{{ old('angkatan', $student->angkatan) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">No HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $student->no_hp) }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat *</label>
                                <textarea name="alamat" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>{{ old('alamat', $student->alamat) }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ditambahkan Oleh</label>
                                <input type="text" value="{{ auth()->user()->name }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 dark:text-gray-400 focus:outline-none cursor-not-allowed" readonly>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="{{ route('student.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">Batal</a>
                            <button type="submit" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>