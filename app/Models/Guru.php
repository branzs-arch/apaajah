<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Guru extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gurus';

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'mata_pelajaran',
        'no_hp',
        'added_by',
        'is_active',
    ];
}
