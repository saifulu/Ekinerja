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
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom belum ada sebelum menambahkan
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'golongan')) {
                $table->string('golongan')->nullable()->after('nip');
            }
            if (!Schema::hasColumn('users', 'instansi')) {
                $table->string('instansi')->nullable()->after('golongan');
            }
            if (!Schema::hasColumn('users', 'ruangan')) {
                $table->string('ruangan')->nullable()->after('instansi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nip', 'golongan', 'instansi', 'ruangan']);
        });
    }
};
