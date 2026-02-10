<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalizationFollowUp extends Model
{
    protected $fillable = [
        'hospitalization_id',
        'date',
        'observations',
        'treatment',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relation avec l'hospitalisation parente.
     */
    public function hospitalization(): BelongsTo
    {
        return $this->belongsTo(Hospitalization::class);
    }
}
