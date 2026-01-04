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
        Schema::create('computer_plans', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();        // nano, small, medium, large
            $table->string("name");
            $table->boolean('shared_cpu');
            $table->unsignedTinyInteger('cpu_cores')->nullable();
            $table->unsignedInteger('memory_mb');
            $table->unsignedInteger('storage_mb');
            $table->unsignedInteger("price_per_month");
            $table->boolean("public");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_plans');
    }
};
