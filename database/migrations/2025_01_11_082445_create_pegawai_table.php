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
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
        });

        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jabatan_id');
            $table->string('nip', 8)->unique();
            $table->string('nama');
            $table->year('tahun_masuk');
            $table->decimal('gaji_pokok', 15, 2);
            $table->decimal('jam_lembur', 8, 2)->nullable();
            $table->integer('jumlah_pelanggan')->nullable();
            $table->decimal('peningkatan_penjualan', 5, 2)->nullable();
            $table->timestamps();

            // Relasi ke tabel jabatan
            $table->foreign('jabatan_id')
                ->references('id')
                ->on('jabatan')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
        Schema::dropIfExists('pegawai');
    }
};
