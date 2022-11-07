<?php

use App\Models\Mahasiswa;
use App\Models\AktorFakultas;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosenPembimbingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_pembimbing', function (Blueprint $table) {
            $table->foreign('id_dosen')->references('id_aktor')->on('AktorFakultas');
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('Mahasiswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen_pembimbings');
    }
}
