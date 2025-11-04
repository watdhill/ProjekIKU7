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
        Schema::table('klaim_metode', function (Blueprint $table) {
            $table->string('kode_matkul')->nullable()->after('mata_kuliah_id');
            $table->string('nama_matkul')->nullable()->after('kode_matkul');

            // Komponen persentase
            $table->integer('partisipasi')->nullable()->after('metode');
            $table->integer('proyek')->nullable()->after('partisipasi');
            $table->integer('kuis')->nullable()->after('proyek');
            $table->integer('tugas')->nullable()->after('kuis');
            $table->integer('uts')->nullable()->after('tugas');
            $table->integer('uas')->nullable()->after('uts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klaim_metode', function (Blueprint $table) {
            $table->dropColumn([
                'kode_matkul', 'nama_matkul',
                'partisipasi', 'proyek', 'kuis', 'tugas', 'uts', 'uas'
            ]);
        });
    }
};
