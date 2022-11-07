<?php

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('id_file');
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('Mahasiswa');
            $table->string('lokasi');
            $table->integer('tipe');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('file_mahasiswas');
    }
}
