<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::orderBy('created_at', 'desc')->get();
        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => 'required|unique:gurus,nip',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'mata_pelajaran' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->input('is_active', 1);
        $data['added_by'] = auth()->user()->name ?? 'Admin';
        Guru::create($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $guru = Guru::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, string $id)
    {
        $guru = Guru::findOrFail($id);

        $data = $request->validate([
            'nip' => 'required|unique:gurus,nip,' . $guru->id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'mata_pelajaran' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        $data['added_by'] = auth()->user()->name;
        $guru->update($data);
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        Guru::destroy($id);
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus');
    }
}
