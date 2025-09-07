<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unit_ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama_ruangan');
            $table->timestamps();
            
            $table->foreign('nip')->references('nip')->on('users')->onDelete('cascade');
            $table->index('nip');
        });
    }

    public function down()
    {
        Schema::dropIfExists('unit_ruangan');
    }
};