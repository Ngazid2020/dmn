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
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    protected static function booted()
    {
        static::creating(function ($medicalFile) {
            $medicalFile->reference = 'MF-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
        });
    }
}
