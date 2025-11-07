<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Khotbah extends Model
{
     use HasFactory;

    protected $table = 'khotbahs'; // pastikan sesuai dengan nama tabel kamu

protected $fillable = [
    'judul',
    'isi',
    'author',
    'tanggal'
];

}