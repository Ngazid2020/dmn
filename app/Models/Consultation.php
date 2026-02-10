<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultation extends Model
{
    protected $fillable = [
        'medical_file_id',
        'patient_id',
        'user_id',
        'etablissement_id',
        'complaint',
        'diagnosis',
        'notes',
        'consulted_at',
    ];

    protected $casts = [
        'consulted_at' => 'datetime',
    ];

    // =========================
    // RELATIONS
    // =========================

    public function medicalFile(): BelongsTo
    {
        return $this->belongsTo(MedicalFile::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    // =========================
    // MULTI-TENANCY GLOBAL SCOPE
    // =========================

    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function ($query) {
            if ($tenant = \Filament\Facades\Filament::getTenant()) {
                $query->where('etablissement_id', $tenant->id);
            }
        });

        // Optionnel : assigner automatiquement le tenant à la création
        static::creating(function ($consultation) {
            if ($tenant = \Filament\Facades\Filament::getTenant()) {
                $consultation->etablissement_id = $tenant->id;
            }
        });
    }
}
