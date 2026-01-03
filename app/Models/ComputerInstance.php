<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerInstance extends Model
{
    protected $fillable = [
        'project_id',
        'computer_plan_id',
        'cpu',
        'memory_mb',
        'storage_mb',
        'role', // primary, replica, analytics...
        'status',
        'host',
        'port',
        'db_user',      // utilisateur principal de l'instance
        'db_password',  // mot de passe principal (chiffré)
        'slug',         // pour namespace / helm / sous-domaine
    ];

    /**
     * Relation vers le projet
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relation vers le plan de compute
     */
    public function computePlan()
    {
        return $this->belongsTo(ComputerPlan::class);
    }

    /**
     * Une instance peut avoir plusieurs bases
     */
    public function databases()
    {
        return $this->hasMany(Database::class);
    }
}
