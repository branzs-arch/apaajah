<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Inventory extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'inventories';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'jumlah',
        'satuan',
        'kondisi',
        'lokasi',
        'tanggal_masuk',
        'keterangan',
        'added_by',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function peminjamen()
    {
        return $this->hasMany(Peminjaman::class, 'barang_id');
    }

    public function getTotalDipinjamAttribute()
    {
        return $this->peminjamen()->where('status', 'dipinjam')->sum('jumlah');
    }
}
