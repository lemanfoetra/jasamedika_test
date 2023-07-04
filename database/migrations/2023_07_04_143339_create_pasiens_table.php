<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('id_pasien')->nullable();
            $table->string('nama')->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->string('kode_pro', 11)->nullable()->index();
            $table->string('kode_kab', 11)->nullable()->index();
            $table->string('kode_kec', 11)->nullable()->index();
            $table->string('kode_kel', 11)->nullable()->index();
            $table->text('alamat')->nullable();
            $table->string('rt', 6)->nullable();
            $table->string('rw', 6)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->char('jenis_kelamin', '1')->nullable()->comment('L/P');
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
        Schema::dropIfExists('pasiens');
    }
}
