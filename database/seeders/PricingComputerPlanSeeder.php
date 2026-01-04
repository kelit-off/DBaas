<?php

namespace Database\Seeders;

use App\Models\ComputerPlan;
use App\Models\PricingPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PricingComputerPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $free = PricingPlan::where('code', 'free')->first();

        $allPlans = PricingPlan::where('code', '!=', 'free')->get();

        $allCompute = ComputerPlan::pluck('id')->toArray();

        $nano = ComputerPlan::where('code', 'nano')->first();

        // Free → nano only
        $free->computerPlans()->sync([$nano->id]);

        // Tous les autres → tout
        foreach ($allPlans as $plan) {
            $plan->computerPlans()->sync($allCompute);
        }
    }
}
