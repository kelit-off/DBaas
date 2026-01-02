<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    public function getListe() {

    }

    public function get($slug) {
        return Project::with([
            "computeInstances.computePlan",
            "databases",
        ])
        ->where("slug", $slug)->first();
    }
}
