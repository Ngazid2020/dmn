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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function medicalFiles(): HasMany
    {
        return $this->hasMany(MedicalFile::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }
    public function hospitalizations(): HasMany
    {
        return $this->hasMany(Hospitalization::class);
    }

    public function hospitalizationFollowUps()
    {
        return $this->hasManyThrough(
            \App\Models\HospitalizationFollowUp::class,
            \App\Models\Hospitalization::class,
            'etablissement_id', // clé étrangère sur Hospitalization
            'hospitalization_id', // clé étrangère sur HospitalizationFollowUp
            'id', // clé locale sur Etablissement
            'id' // clé locale sur Hospitalization
        );
    }
}
