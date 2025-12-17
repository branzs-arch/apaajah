<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Guru;
use App\Models\Student;
use App\Models\Inventory;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::orderBy('created_at', 'desc')->get();

        // Add related data
        $peminjaman->map(function ($item) {
            // Get peminjam name
            if ($item->role == 'siswa') {
                $student = Student::find($item->peminjam_id);
                $item->peminjam_nama = $student ? $student->nama_lengkap : 'N/A';
            } else {
                $guru = Guru::find($item->peminjam_id);
                $item->peminjam_nama = $guru ? $guru->nama_lengkap : 'N/A';
            }

            // Get barang name
            $inventory = Inventory::find($item->barang_id);
            $item->barang_nama = $inventory ? $inventory->nama_barang : 'N/A';

            return $item;
        });

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $inventories = Inventory::where('jumlah', '>', 0)->get();
        $students = Student::where('is_active', 1)->get();
        $gurus = Guru::where('is_active', 1)->get();

        return view('peminjaman.create', compact('inventories', 'students', 'gurus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'peminjam_id' => 'required',
            'role' => 'required|in:siswa,guru',
            'barang_id' => 'required|exists:inventories,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($data['barang_id']);

        if ($inventory->jumlah < $data['jumlah']) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi. Tersedia: ' . $inventory->jumlah])->withInput();
        }

        // Set default values
        $data['added_by'] = auth()->user()->name ?? 'Admin';
        $data['status'] = 'dipinjam';

        // Update inventory stock
        $inventory->decrement('jumlah', $data['jumlah']);

        Peminjaman::create($data);
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan dan stok barang dikurangi');
    }

    public function edit(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $inventories = Inventory::all(); // Show all in edit
        $students = Student::where('is_active', 1)->get();
        $gurus = Guru::where('is_active', 1)->get();

        return view('peminjaman.edit', compact('peminjaman', 'inventories', 'students', 'gurus'));
    }

    public function update(Request $request, string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $data = $request->validate([
            'peminjam_id' => 'required',
            'role' => 'required|in:siswa,guru',
            'barang_id' => 'required|exists:inventories,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,kembali',
            'keterangan' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($data['barang_id']);

        // Handle stock logic
        if ($peminjaman->barang_id == $data['barang_id']) {
            // Same item, check difference in quantity
            $diff = $data['jumlah'] - $peminjaman->jumlah;

            if ($diff > 0 && $inventory->jumlah < $diff) {
                return back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk penambahan pinjaman. Tersedia: ' . $inventory->jumlah])->withInput();
            }

            // If status changed to 'kembali', return all items
            if ($peminjaman->status == 'dipinjam' && $data['status'] == 'kembali') {
                $inventory->increment('jumlah', $peminjaman->jumlah);
                // In 'kembali' state, the 'jumlah' in Peminjaman record stays what was borrowed
            } elseif ($peminjaman->status == 'kembali' && $data['status'] == 'dipinjam') {
                // Changing back to 'dipinjam', subtract again
                if ($inventory->jumlah < $data['jumlah']) {
                    return back()->withErrors(['jumlah' => 'Stok tidak mencukupi. Tersedia: ' . $inventory->jumlah])->withInput();
                }
                $inventory->decrement('jumlah', $data['jumlah']);
            } else if ($data['status'] == 'dipinjam') {
                // Both are 'dipinjam', just adjust the difference
                $inventory->decrement('jumlah', $diff);
            }
        } else {
            // Different item
            // 1. Return old item stock if it was 'dipinjam'
            if ($peminjaman->status == 'dipinjam') {
                $oldInventory = Inventory::find($peminjaman->barang_id);
                if ($oldInventory) {
                    $oldInventory->increment('jumlah', $peminjaman->jumlah);
                }
            }

            // 2. Subtract new item stock if new status is 'dipinjam'
            if ($data['status'] == 'dipinjam') {
                if ($inventory->jumlah < $data['jumlah']) {
                    // Revert? Actually since it's a validation step, it's better to check before incrementing old one or use DB::transaction
                    return back()->withErrors(['jumlah' => 'Stok barang baru tidak mencukupi. Tersedia: ' . $inventory->jumlah])->withInput();
                }
                $inventory->decrement('jumlah', $data['jumlah']);
            }
        }

        $data['added_by'] = auth()->user()->name;
        $peminjaman->update($data);
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Return stock if it was still borrowed
        if ($peminjaman->status == 'dipinjam') {
            $inventory = Inventory::find($peminjaman->barang_id);
            if ($inventory) {
                $inventory->increment('jumlah', $peminjaman->jumlah);
            }
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus dan stok dikembalikan');
    }
}
