<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    protected $fillable = [
        'computer_instance_id',
        'project_id',
        'name',
        'username',
        'password', // chiffré si nécessaire
        'role',     // main, branch, analytics...
        'host',     // host de connexion
        'port',
    ];

    protected $casts = [
        'port' => 'integer',
    ];

    /**
     * Une base appartient à un projet
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Une base appartient à une instance
     */
    public function computeInstance()
    {
        return $this->belongsTo(ComputerInstance::class);
    }
}
