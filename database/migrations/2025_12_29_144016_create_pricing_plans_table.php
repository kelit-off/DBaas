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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();

            // Identification
            $table->string('code')->unique();           // free, pro, team
            $table->string('name');

            // Pricing
            $table->integer('monthly_price_cents');     // 0, 2500, 9900
            $table->integer('start_credit_cents')->nullable(); // compute credits

            // Hard limits (Free only)
            $table->integer('max_projects')->nullable();          // null = unlimited
            $table->integer('max_compute_instances')->nullable(); // null = unlimited

            // Included quotas
            $table->integer('included_disk_gb')->nullable();          // per project
            $table->integer('included_egress_gb')->nullable();        // per month
            $table->integer('included_cached_egress_gb')->nullable(); // per month
            $table->integer('included_file_storage_gb')->nullable();  // total

            // Overage pricing (per GB, in cents)
            $table->integer('disk_overage_price_cents')->nullable();
            $table->integer('egress_overage_price_cents')->nullable();
            $table->integer('cached_egress_overage_price_cents')->nullable();
            $table->integer('file_storage_overage_price_cents')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
