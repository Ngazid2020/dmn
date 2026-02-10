<?php

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource as BaseRoleResource;

class RoleResource extends BaseRoleResource
{
    // Désactive la tenancy sur le modèle Role
    protected static ?string $tenantOwnershipRelationshipName = null;
}