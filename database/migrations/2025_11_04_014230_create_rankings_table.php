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
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_points')->default(0);
            $table->integer('activities_completed')->default(0);
            $table->integer('hours_volunteered')->default(0);
            $table->integer('donations_made')->default(0);
            $table->integer('certificates_earned')->default(0);
            $table->enum('rank', ['Bronce', 'Plata', 'Oro', 'Platino', 'Diamante'])->default('Bronce');
            $table->integer('rank_position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};
