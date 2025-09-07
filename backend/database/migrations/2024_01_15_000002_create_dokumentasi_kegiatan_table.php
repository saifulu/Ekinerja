<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumentasi_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_jenis_kegiatan_id');
            $table->string('nama_file');
            $table->string('path_file');
            $table->string('mime_type');
            $table->integer('ukuran_file');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('detail_jenis_kegiatan_id')
                  ->references('id')
                  ->on('detail_jenis_kegiatan')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumentasi_kegiatan');
    }
};