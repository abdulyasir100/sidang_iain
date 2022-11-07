<?php

namespace App\Models;

use App\Models\Undangan;
use App\Models\Mahasiswa;
use App\Models\AktorFakultas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $guarded = [];
    protected $primaryKey = 'idjadwal';

    public function AdminProdi()
    {
        return $this->belongsTo(AktorFakultas::class, 'id_adminprodi', 'idAktor');
    }

    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'idmahasiswa');
    }

    public function Undangan()
    {
        return $this->hasMany(Undangan::class, 'idjadwal', 'id_jadwal');
    }

}
