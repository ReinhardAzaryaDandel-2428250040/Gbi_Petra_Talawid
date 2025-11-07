<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals'; // pastikan sesuai dengan nama tabel kamu

protected $fillable = [
    'hari',
    'jam',
    'penghotbah',
    'worship_leader',
    'kegiatan',
    'tempat'

    
];
}