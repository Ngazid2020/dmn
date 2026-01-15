<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospitalization extends Model
{
    protected $fillable = [
        'patient_id',
        'medical_file_id',
        'service',
        'room',
        'bed',
        'admitted_at',
        'discharged_at',
        'status',
        'reason',
        'notes',
    ];

    protected $casts = [
        'admitted_at' => 'datetime',
        'discharged_at' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalFile(): BelongsTo
    {
        return $this->belongsTo(MedicalFile::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(HospitalizationFollowUp::class);
    }

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
