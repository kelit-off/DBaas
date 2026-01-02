<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'owner_id',
        'type',
        'slug',
        'pricing_plan_id', // lien vers PricingPlan
    ];

    /* =======================
     | Relations
     ======================= */

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role');
            // ->withTimestamps();
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function pricingPlan()
    {
        return $this->belongsTo(PricingPlan::class);
    }

    /* =======================
     | Route Binding
     ======================= */

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
