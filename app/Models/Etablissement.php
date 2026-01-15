<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etablissement extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function appointments():HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function patients():HasMany
    {
        return $this->hasMany(Patient::class);
    }
}
