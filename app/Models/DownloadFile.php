<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadFile extends Model
{
    protected $table = 'download_file';
    protected $guarded = [];
    protected $primaryKey = 'idfile';
}
