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
        Schema::table('mata_kuliah', function (Blueprint $table) {
            // Simpan komponen persentase sebagai JSON (array of {nama,persentase})
            // Letakkan setelah kolom 'metode' agar tidak tergantung migrasi dokumen_path
            $table->json('komponen')->nullable()->after('metode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mata_kuliah', function (Blueprint $table) {
            $table->dropColumn('komponen');
        });
    }
};
