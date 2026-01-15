<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'blood_group',
        'allergies',
        'medical_history',
        'emergency_contact',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    // Relations
    public function medicalFile(): HasOne
    {
        return $this->hasOne(MedicalFile::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function hospitalizations()
    {
        return $this->hasMany(Hospitalization::class);
    }

    public function etablissement():BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
}
