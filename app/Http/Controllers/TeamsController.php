<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use App\Models\Project;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TeamsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
        ]);

        $freePlanId = PricingPlan::where('code', 'free')->value('id');

        $team = Auth::user()->teams()->create([
            'name' => $request->name,
            'owner_id' => Auth::id(),
            'type' => $request->type,
            'slug' => Str::random(20),
            "pricing_plan_id" => $freePlanId
        ]);

        $team->users()->syncWithoutDetaching([
            Auth::id() => ['role' => 'owner'],
        ]);


        return response()->json(['team' => $team->load("pricingPlan")], 201);
    }

    public function create()
    {
        return Inertia::render('teams/create', []);
    }

    public function show($slug)
    {
        $projects = Project::with(["computeInstances.computerPlan"])->whereHas('team', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->get();

        return Inertia::render('teams/show', [
            "projects" => $projects,
            "slug" => $slug
        ]);
    }

    public function showMember($slug)
    {
        return Inertia::render("teams/member", [
            "team" => (new TeamService())->get($slug),
            'slug' => $slug
        ]);
    }

    public function showSettings($slug)
    {
        return Inertia::render("teams/settings/general", [
            "slug" => $slug,

        ]);
    }
}
