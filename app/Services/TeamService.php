<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class TeamService
{
    public function getListe()
    {
        return Team::with([
            'PricingPlan:id,code,name',
            'projects:id,team_id,name', // sélectionne seulement les colonnes nécessaires
            'projects.computeInstances:id,project_id,computer_plan_id',
            'projects.computeInstances.computerPlan:id,code,name',
        ])
            ->withCount('projects')
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->get();
    }

    public function get($slug)
    {
        return Team::with([
            'PricingPlan:id,code,name',
            'projects:id,team_id,name', // sélectionne seulement les colonnes nécessaires
            'projects.computeInstances:id,project_id,name,computer_plan_id',
            'projects.computeInstances.computerPlan:id,code,name',
            'users'
        ])
            ->withCount('projects')
            ->where('slug', $slug)
            ->first();
    }
}
