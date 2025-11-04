<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('klaim_metode', function (Blueprint $table) {
            // Tambah kolom untuk menyimpan nilai komponen
            $table->integer('partisipasi')->nullable();
            $table->integer('proyek')->nullable();
            $table->integer('kuis')->nullable();
            $table->integer('tugas')->nullable();
            $table->integer('uts')->nullable();
            $table->integer('uas')->nullable();
            // Tambah kolom untuk snapshot data mata kuliah
            $table->string('kode_matkul')->nullable();
            $table->string('nama_matkul')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('klaim_metode', function (Blueprint $table) {
            $table->dropColumn([
                'partisipasi',
                'proyek',
                'kuis',
                'tugas',
                'uts',
                'uas',
                'kode_matkul',
                'nama_matkul'
            ]);
        });
    }
};