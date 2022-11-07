<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\AktorFakultas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DosenPembimbing extends Model
{
    protected $table = 'dosenpembimbing';
    protected $guarded = [];

    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'idmahasiswa');
    }

    public function Dosen()
    {
        return $this->belongsTo(AktorFakultas::class, 'id_dosen', 'idAktor');
    }
}
