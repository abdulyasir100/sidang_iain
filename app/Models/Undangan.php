<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\AktorFakultas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Undangan extends Model
{
    protected $table = 'undangan';
    protected $guarded = [];
    protected $primaryKey = 'idundangan';

    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'idmahasiswa');
    }

    public function Dosen()
    {
        return $this->belongsTo(AktorFakultas::class, 'id_dosen', 'idAktor');
    }

    public function AdminProdi()
    {
        return $this->belongsTo(AktorFakultas::class, 'id_adminprodi', 'idAktor');
    }

    public function Jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'idjadwal');
    }

}
