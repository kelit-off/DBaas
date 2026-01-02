<?php

namespace Database\Seeders;

use App\Models\ComputePlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComputePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ComputePlan::truncate();

        ComputePlan::insert([
            [
                'code' => 'nano',
                'name' => 'Nano',
                'shared_cpu' => true,
                'public' => true,
                'cpu_cores' => 1,
                'memory_mb' => 512,
                'storage_mb' => 500,
                'price_per_month' => 0,
            ],
            [
                'code' => 'small',
                'name' => 'Small',
                'shared_cpu' => true,
                'public' => true,
                'cpu_cores' => 2,
                'memory_mb' => 2048,
                'storage_mb' => 5000,
                'price_per_month' => 1000,
            ],
            [
                'code' => 'medium',
                'name' => 'Medium',
                'shared_cpu' => false,
                'public' => true,
                'cpu_cores' => 4,
                'memory_mb' => 8192,
                'storage_mb' => 10000,
                'price_per_month' => 3000,
            ],
            [
                'code' => 'large',
                'name' => 'Large',
                'shared_cpu' => false,
                'public' => true,
                'cpu_cores' => 8,
                'memory_mb' => 16384,
                'storage_mb' => 50000,
                'price_per_month' => 7000,
            ],
        ]);
    }
}
