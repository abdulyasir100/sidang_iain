<?php

namespace App\Models;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogSidang extends Model
{
    protected $table = 'logsidang';
    protected $guarded = [];
    protected $primaryKey = 'idlogsidang';

    public function Jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'idjadwal');
    }
}
