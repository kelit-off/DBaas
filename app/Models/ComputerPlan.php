<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComputerPlan extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'shared_cpu', 'cpu_cores', 'memory_mb', 'storage_mb'];

    public function pricingPlans()
    {
        return $this->belongsToMany(PricingPlan::class, 'pricing_computer_plan');
    }

    public function computerInstances()
    {
        return $this->hasMany(ComputerInstance::class);
    }
}
