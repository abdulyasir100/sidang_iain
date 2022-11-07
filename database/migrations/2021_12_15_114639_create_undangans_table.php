<?php

use App\Models\Mahasiswa;
use App\Models\AktorFakultas;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUndangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('undangan', function (Blueprint $table) {
            $table->bigIncrements('id_undangan');
            $table->foreign('id_adminprodi')->references('id_aktor')->on('AktorFakultas');
            $table->foreign('id_dosen')->references('id_aktor')->on('AktorFakultas');
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('Mahasiswa');
            $table->string('tempat');
            $table->dateTime('tanggal');
            $table->integer('status');
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
        Schema::dropIfExists('undangans');
    }
}
