<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::orderBy('created_at', 'desc')->get();
        return view('inventory.index', compact('inventories'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_barang' => 'required|unique:inventories,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'nullable|string|max:50',
            'kondisi' => 'required|string|max:100',
            'lokasi' => 'nullable|string|max:150',
            'tanggal_masuk' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $data['added_by'] = auth()->user()->name ?? 'Admin';
        Inventory::create($data);
        return redirect()->route('inventory.index')->with('success', 'Data inventaris berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, string $id)
    {
        $inventory = Inventory::findOrFail($id);

        $data = $request->validate([
            'kode_barang' => 'required|unique:inventories,kode_barang,' . $inventory->id,
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'nullable|string|max:50',
            'kondisi' => 'required|string|max:100',
            'lokasi' => 'nullable|string|max:150',
            'tanggal_masuk' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        // Keep original added_by or update to current user? User said "ditambahkan oleh yang ada di peminjaman tolong diterapkan di tambahkan data guru, data siswa, dan inventaris"
        // In Peminjaman, it's readonly and shows who added it. Usually added_by shouldn't change on update unless specified.
        // Let's keep it as is for update if it exists, but the user might want to see who updated it too? 
        // User asked for "ditambahkan oleh" specifically.
        $data['added_by'] = auth()->user()->name;
        $inventory->update($data);
        return redirect()->route('inventory.index')->with('success', 'Data inventaris berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        Inventory::destroy($id);
        return redirect()->route('inventory.index')->with('success', 'Data inventaris berhasil dihapus');
    }
}
