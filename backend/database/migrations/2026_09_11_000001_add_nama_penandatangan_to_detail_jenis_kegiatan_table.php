<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('detail_jenis_kegiatan', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_jenis_kegiatan', 'nama_pelaksana')) {
                $table->string('nama_pelaksana')->nullable()->after('hasil_temuan');
            }
            if (!Schema::hasColumn('detail_jenis_kegiatan', 'nama_pj')) {
                $table->string('nama_pj')->nullable()->after('nama_pelaksana');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_jenis_kegiatan', function (Blueprint $table) {
            if (Schema::hasColumn('detail_jenis_kegiatan', 'nama_pelaksana')) {
                $table->dropColumn('nama_pelaksana');
            }
            if (Schema::hasColumn('detail_jenis_kegiatan', 'nama_pj')) {
                $table->dropColumn('nama_pj');
            }
        });
    }
};

