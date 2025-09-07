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
        Schema::create('detail_jenis_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kegiatan');
            $table->string('nip');
            $table->string('unit');
            $table->datetime('tanggal_dibuat');
            $table->text('hasil_temuan')->nullable();
            $table->longText('signature_pelaksana')->nullable(); // Base64 encoded signature
            $table->longText('signature_pj')->nullable(); // Base64 encoded signature
            $table->json('dokumentasi')->nullable(); // Array of file paths
            $table->string('status')->default('draft'); // draft, submitted, approved, rejected
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index(['jenis_kegiatan', 'nip']);
            $table->index('created_by');
            $table->index('status');
            $table->index('tanggal_dibuat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jenis_kegiatan');
    }
};