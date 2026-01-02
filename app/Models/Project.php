<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'slug',
        'region',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function computeInstances()
    {
        return $this->hasMany(ComputeInstance::class);
    }

    public function databases()
    {
        return $this->hasMany(Database::class);
    }
}
