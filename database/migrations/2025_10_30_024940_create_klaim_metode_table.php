<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klaim_metode', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliah')->onDelete('cascade');
            $table->enum('metode', ['PjBL', 'CBL']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klaim_metode');
    }
};
