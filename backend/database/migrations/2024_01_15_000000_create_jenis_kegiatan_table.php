<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('golongan');
            $table->string('jenis_kegiatan');
            $table->timestamps();
            
            // Index untuk performa
            $table->index('nip');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_kegiatan');
    }
};