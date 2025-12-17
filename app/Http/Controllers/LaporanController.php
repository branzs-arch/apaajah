<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Student;
use App\Models\Guru;
use App\Models\Inventory;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::query();

        // Filter by Date Range
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        // Filter by Role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        // Filter by Status (Simplified logic based on date)
        if ($request->status) {
            $today = now()->format('Y-m-d');
            if ($request->status == 'terlambat') {
                $query->where('tanggal_kembali', '<', $today);
            } elseif ($request->status == 'aktif') {
                $query->where('tanggal_kembali', '>=', $today);
            }
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->get();

        // Enrich data with relationships
        $peminjaman->map(function($item) {
            if ($item->role == 'siswa') {
                $student = Student::find($item->peminjam_id);
                $item->peminjam_nama = $student ? $student->nama_lengkap : 'N/A';
                $item->identitas = $student ? $student->nisn : '-';
            } else {
                $guru = Guru::find($item->peminjam_id);
                $item->peminjam_nama = $guru ? $guru->nama_lengkap : 'N/A';
                $item->identitas = $guru ? $guru->nip : '-';
            }
            
            $inventory = Inventory::find($item->barang_id);
            $item->barang_nama = $inventory ? $inventory->nama_barang : 'N/A';
            $item->kode_barang = $inventory ? $inventory->kode_barang : '-';
            
            return $item;
        });

        return view('laporan.index', compact('peminjaman'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PeminjamanExport(
            $request->start_date, 
            $request->end_date, 
            $request->role, 
            $request->status
        ), 'laporan-peminjaman-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Peminjaman::query();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->status) {
            $today = now()->format('Y-m-d');
            if ($request->status == 'terlambat') {
                $query->where('tanggal_kembali', '<', $today);
            } elseif ($request->status == 'aktif') {
                $query->where('tanggal_kembali', '>=', $today);
            }
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->get();

        // Enrich data
        $peminjaman->map(function($item) {
            if ($item->role == 'siswa') {
                $student = Student::find($item->peminjam_id);
                $item->peminjam_nama = $student ? $student->nama_lengkap : 'N/A';
                $item->identitas = $student ? $student->nisn : '-';
            } else {
                $guru = Guru::find($item->peminjam_id);
                $item->peminjam_nama = $guru ? $guru->nama_lengkap : 'N/A';
                $item->identitas = $guru ? $guru->nip : '-';
            }
            
            $inventory = Inventory::find($item->barang_id);
            $item->barang_nama = $inventory ? $inventory->nama_barang : 'N/A';
            $item->kode_barang = $inventory ? $inventory->kode_barang : '-';
            
            return $item;
        });

        $pdf = Pdf::loadView('laporan.pdf', compact('peminjaman'));
        return $pdf->download('laporan-peminjaman-' . date('Y-m-d') . '.pdf');
    }
}
