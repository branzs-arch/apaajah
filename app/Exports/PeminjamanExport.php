<?php

namespace App\Exports;

use App\Models\Peminjaman;
use App\Models\Student;
use App\Models\Guru;
use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $role;
    protected $status;

    public function __construct($startDate = null, $endDate = null, $role = null, $status = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->role = $role;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Peminjaman::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal_pinjam', [$this->startDate, $this->endDate]);
        }

        if ($this->role) {
            $query->where('role', $this->role);
        }

        // Status filter logic (simplified based on date)
        if ($this->status) {
            $today = now()->format('Y-m-d');
            if ($this->status == 'terlambat') {
                $query->where('tanggal_kembali', '<', $today);
            } elseif ($this->status == 'aktif') {
                $query->where('tanggal_kembali', '>=', $today);
            }
        }

        return $query->get();
    }

    public function map($peminjaman): array
    {
        // Get peminjam name
        $peminjamNama = 'N/A';
        $identitas = 'N/A';
        
        if ($peminjaman->role == 'siswa') {
            $student = Student::find($peminjaman->peminjam_id);
            if ($student) {
                $peminjamNama = $student->nama_lengkap;
                $identitas = $student->nisn;
            }
        } else {
            $guru = Guru::find($peminjaman->peminjam_id);
            if ($guru) {
                $peminjamNama = $guru->nama_lengkap;
                $identitas = $guru->nip;
            }
        }

        // Get barang name
        $inventory = Inventory::find($peminjaman->barang_id);
        $barangNama = $inventory ? $inventory->nama_barang : 'N/A';
        $kodeBarang = $inventory ? $inventory->kode_barang : 'N/A';

        // Determine status
        $status = 'Aktif';
        if (\Carbon\Carbon::parse($peminjaman->tanggal_kembali)->lt(now())) {
            $status = 'Terlambat';
        }

        return [
            $peminjaman->id,
            $peminjamNama,
            ucfirst($peminjaman->role),
            $identitas,
            $barangNama,
            $kodeBarang,
            $peminjaman->tanggal_pinjam,
            $peminjaman->tanggal_kembali,
            $status,
            $peminjaman->keterangan,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Peminjam',
            'Role',
            'NISN/NIP',
            'Nama Barang',
            'Kode Barang',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
