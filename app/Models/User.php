<?php

namespace App\Models;

use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasTenants
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ============================
| MULTI-TENANCY FILAMENT
============================ */
    public function etablissements(): BelongsToMany
    {
        return $this->belongsToMany(Etablissement::class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->etablissements()->get();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->etablissements()->whereKey($tenant)->exists();
    }
}
