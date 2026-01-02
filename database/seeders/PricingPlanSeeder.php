<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingPlan;

class PricingPlanSeeder extends Seeder
{
    public function run(): void
    {
        PricingPlan::truncate();

        PricingPlan::insert([
            [
                'code' => 'free',
                'name' => 'Free',

                'monthly_price_cents' => 0,
                'start_credit_cents' => 0,

                'max_projects' => 2,
                'max_compute_instances' => 1,

                'included_disk_gb' => 1,
                'included_egress_gb' => 0,
                'included_cached_egress_gb' => 0,
                'included_file_storage_gb' => 0,

                'disk_overage_price_cents' => null,
                'egress_overage_price_cents' => null,
                'cached_egress_overage_price_cents' => null,
                'file_storage_overage_price_cents' => null,
            ],
            [
                'code' => 'pro',
                'name' => 'Pro',

                'monthly_price_cents' => 2500,
                'start_credit_cents' => 1000,

                'max_projects' => null,
                'max_compute_instances' => null,

                'included_disk_gb' => 8,
                'included_egress_gb' => 250,
                'included_cached_egress_gb' => 250,
                'included_file_storage_gb' => 100,

                'disk_overage_price_cents' => 13,
                'egress_overage_price_cents' => 9,
                'cached_egress_overage_price_cents' => 3,
                'file_storage_overage_price_cents' => 2,
            ],
            [
                'code' => 'team',
                'name' => 'Team',

                'monthly_price_cents' => 59900,
                'start_credit_cents' => 1000,

                'max_projects' => null,
                'max_compute_instances' => null,

                'included_disk_gb' => 8,
                'included_egress_gb' => 250,
                'included_cached_egress_gb' => 250,
                'included_file_storage_gb' => 100,

                'disk_overage_price_cents' => 13,
                'egress_overage_price_cents' => 9,
                'cached_egress_overage_price_cents' => 3,
                'file_storage_overage_price_cents' => 2,
            ],
        ]);
    }
}
