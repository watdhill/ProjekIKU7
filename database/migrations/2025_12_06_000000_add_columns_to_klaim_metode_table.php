<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('klaim_metode', function (Blueprint $table) {
            // Add mata kuliah fields if they don't exist
            if (!Schema::hasColumn('klaim_metode', 'kode_matkul')) {
                $table->string('kode_matkul')->after('metode');
            }
            if (!Schema::hasColumn('klaim_metode', 'nama_matkul')) {
                $table->string('nama_matkul')->after('kode_matkul');
            }
            
            // Add komponen fields with default values if they don't exist
            if (!Schema::hasColumn('klaim_metode', 'partisipasi')) {
                $table->integer('partisipasi')->default(0)->after('nama_matkul');
            }
            if (!Schema::hasColumn('klaim_metode', 'proyek')) {
                $table->integer('proyek')->default(0)->after('partisipasi');
            }
            if (!Schema::hasColumn('klaim_metode', 'kuis')) {
                $table->integer('kuis')->default(0)->after('proyek');
            }
            if (!Schema::hasColumn('klaim_metode', 'tugas')) {
                $table->integer('tugas')->default(0)->after('kuis');
            }
            if (!Schema::hasColumn('klaim_metode', 'uts')) {
                $table->integer('uts')->default(0)->after('tugas');
            }
            if (!Schema::hasColumn('klaim_metode', 'uas')) {
                $table->integer('uas')->default(0)->after('uts');
            }
        });

        // Update existing NULL values to 0
        DB::table('klaim_metode')
            ->whereNull('partisipasi')
            ->orWhereNull('proyek')
            ->orWhereNull('kuis')
            ->orWhereNull('tugas')
            ->orWhereNull('uts')
            ->orWhereNull('uas')
            ->update([
                'partisipasi' => 0,
                'proyek' => 0,
                'kuis' => 0,
                'tugas' => 0,
                'uts' => 0,
                'uas' => 0
            ]);
    }

    public function down(): void
    {
        Schema::table('klaim_metode', function (Blueprint $table) {
            $table->dropColumn([
                'kode_matkul',
                'nama_matkul',
                'partisipasi',
                'proyek',
                'kuis',
                'tugas',
                'uts',
                'uas'
            ]);
        });
    }
};