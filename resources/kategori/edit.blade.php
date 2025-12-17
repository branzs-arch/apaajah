<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-yellow-500 to-yellow-600">
                    <h2 class="text-2xl font-bold text-white">
                        <i class="fas fa-edit mr-2"></i>Edit Kategori
                    </h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('kategori.update', $kategori->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ $kategori->deskripsi }}</textarea>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                            <a href="{{ route('kategori.index') }}" class="px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">Batal</a>
                            <button type="submit" class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>