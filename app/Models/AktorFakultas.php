<?php

namespace App\Models;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AktorFakultas extends Model
{
    protected $table = 'aktorfakultas';
    protected $guarded = [];
    protected $primaryKey = 'idAktor';

    public function Akun()
    {
        return $this->belongsTo(Akun::class, 'idAkun', 'idAkun');
    }
}
