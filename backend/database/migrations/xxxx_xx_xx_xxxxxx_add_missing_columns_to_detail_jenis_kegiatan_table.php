<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_jenis_kegiatan', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_jenis_kegiatan', 'signature_pelaksana')) {
                $table->longText('signature_pelaksana')->nullable()->after('hasil_temuan');
            }
            if (!Schema::hasColumn('detail_jenis_kegiatan', 'signature_pj')) {
                $table->longText('signature_pj')->nullable()->after('signature_pelaksana');
            }
            if (!Schema::hasColumn('detail_jenis_kegiatan', 'dokumentasi')) {
                $table->json('dokumentasi')->nullable()->after('signature_pj');
            }
            if (!Schema::hasColumn('detail_jenis_kegiatan', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('dokumentasi');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('detail_jenis_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['signature_pelaksana', 'signature_pj', 'dokumentasi', 'created_by']);
        });
    }
};