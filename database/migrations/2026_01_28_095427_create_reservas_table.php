<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iduser')->constrained('users')->onDelete('cascade');
            $table->foreignId('idvacacion')->constrained('vacaciones')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['iduser', 'idvacacion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};