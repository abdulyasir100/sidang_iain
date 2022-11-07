<?php

namespace App\Models;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $guarded = [];
    protected $primaryKey = 'idmahasiswa';

    /**
     * Get the user that owns the Mahasiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'idAkun');
    }

}
