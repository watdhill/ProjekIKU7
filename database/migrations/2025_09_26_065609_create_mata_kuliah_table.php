<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departemen_id')->constrained('departemen')->onDelete('cascade');
            $table->integer('semester'); // sekarang integer (1,2,3,4)
            $table->string('kode_matkul');
            $table->string('nama_matkul');
            $table->integer('sks');
            $table->string('metode')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};