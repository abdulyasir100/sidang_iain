<?php

use App\Models\Akun;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAktorFakultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktor_fakultas', function (Blueprint $table) {
            $table->bigIncrements('id_aktor');
            $table->foreign('id_akun')->references('id_akun')->on('Akun');
            $table->string('nip');
            $table->integer('tipe');
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
        Schema::dropIfExists('aktor_fakultas');
    }
}
