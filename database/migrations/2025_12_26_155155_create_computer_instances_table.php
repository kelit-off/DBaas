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
        Schema::create('computer_instances', function (Blueprint $table) {
            $table->id();

            // Liens
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('computer_plan_id')->constrained()->cascadeOnDelete();

            // Ressources
            $table->unsignedTinyInteger('cpu')->nullable();
            $table->unsignedInteger('memory_mb')->default(1024);
            $table->unsignedInteger('storage_mb')->default(10240);

            // Rôle et statut
            $table->string('role')->default('primary'); // primary, replica, analytics
            $table->string('status')->default('pending'); // pending, active, failed

            // Connexion PostgreSQL
            $table->string('host')->nullable();
            $table->integer('port')->default(5432);
            $table->string('db_user')->default('postgres');
            $table->text('db_password'); // mot de passe chiffré
            $table->string('slug')->unique(); // slug pour namespace / helm / sous-domaine

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_instances');
    }
};
