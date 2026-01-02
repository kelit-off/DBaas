<?php

namespace Database\Seeders;

use App\Models\ComputePlan;
use App\Models\PricingPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PricingComputePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $free = PricingPlan::where('code', 'free')->first();

        $allPlans = PricingPlan::where('code', '!=', 'free')->get();

        $allCompute = ComputePlan::pluck('id')->toArray();

        $nano = ComputePlan::where('code', 'nano')->first();
        
        // Free → nano only
        $free->computePlans()->sync([$nano->id]);

        // Tous les autres → tout
        foreach ($allPlans as $plan) {
            $plan->computePlans()->sync($allCompute);
        }
    }
}
