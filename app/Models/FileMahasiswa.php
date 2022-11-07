<?php

namespace App\Models;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileMahasiswa extends Model
{
    protected $table = 'filemahasiswa';
    protected $guarded = [];
    protected $primaryKey = 'idfile';

    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'idmahasiswa');
    }
}
