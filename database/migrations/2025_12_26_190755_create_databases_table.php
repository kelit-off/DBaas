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
        Schema::create('databases', function (Blueprint $table) {
            $table->id();

            // Projet lié
            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            // Instance liée
            $table->foreignId('computer_instance_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Infos de la base
            $table->string('name')->default('main');
            $table->string('username')->default('postgres');
            $table->text('password'); // mot de passe chiffré
            $table->string('role')->default('main');

            // Connexion
            $table->string('host')->nullable();
            $table->integer('port')->default(5432);

            $table->timestamps();

            // Une base unique par projet
            $table->unique(['project_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databases');
    }
};
