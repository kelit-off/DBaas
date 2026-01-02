<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'monthly_price', 'currency'];

    public function computePlans()
    {
        return $this->belongsToMany(ComputePlan::class, 'pricing_compute_plan');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
