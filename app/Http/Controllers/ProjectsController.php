<?php

namespace App\Http\Controllers;

use App\Jobs\ProvisionPostgresInstance;
use App\Models\Database;
use App\Models\Project;
use App\Models\Team;
use App\Services\ProjectService;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'team' => 'required|exists:teams,slug',
            'password' => 'required|string',
            'region' => 'required|string'
        ]);

        $team = Team::with(["pricingPlan:id,code,name", 'pricingPlan.computerPlans:id,code'])->where("slug", $request->team)->first();

        if ($team->pricingPlan->code == "free") {
            $computer_plan_id = $team->pricingPlan->computerPlans->first()->id;
        } else {

        }

        $project = Project::create([
            'name' => $request->name,
            'team_id' => $team->id,
            'slug' => Str::random(20),
            'environment' => 'production',
            'region' => $request->region,
        ]);

        $project->password = $request->password;

        ProvisionPostgresInstance::dispatch($team->pricingPlan->computerPlans->first(), $project);



        return response()->json(['project' => $project], 201);
    }

    public function create($team_id)
    {

        return inertia('projects/create', [
            'team_id' => $team_id,
            'teams' => (new TeamService())->getListe()
        ]);
    }

    public function showGlobal(Request $request, $project_id)
    {
        return Inertia::render('projects/dashboard', [
            "slug" => $project_id,
            "project" => (new ProjectService)->get($project_id)
        ]);
    }
}
