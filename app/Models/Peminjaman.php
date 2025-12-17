<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Peminjaman extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'peminjamen';

    protected $fillable = [
        'peminjam_id',
        'role',
        'barang_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'keterangan',
        'added_by',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_pengembalian' => 'date',
    ];

    // Polymorphic relationship
    public function peminjam()
    {
        return $this->morphTo();
    }
}
