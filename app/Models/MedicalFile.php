<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicalFile extends Model
{
    protected $fillable = [
        'patient_id',
        'reference',
        'notes',
        'etablissement_id',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    // protected static function booted()
    // {
    //     static::creating(function ($medicalFile) {
    //         $medicalFile->reference = 'MF-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
    //     });
    // }

    public function hospitalizations()
    {
        return $this->hasMany(Hospitalization::class);
    }

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    protected static function booted(): void
    {
        // static::creating(function ($medicalFile) {
        //     $medicalFile->reference = 'MF-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
        // });
        static::creating(function ($medicalFile) {
            $medicalFile->reference = 'MF-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

            if ($medicalFile->patient) {
                $medicalFile->etablissement_id = $medicalFile->patient->etablissement_id;
            }
        });

        // Filtrage multi-tenants automatique
        static::addGlobalScope('tenant', function ($query) {
            if ($tenant = \Filament\Facades\Filament::getTenant()) {
                $query->where('etablissement_id', $tenant->id);
            }
        });
    }
}
