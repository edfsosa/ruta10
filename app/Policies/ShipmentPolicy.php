<?php

namespace App\Policies;

use App\Models\Shipment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShipmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true; // Superadministrador y Administrador ve todos
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Shipment $shipment): bool
    {
        // Superadministrador y Administrador ve todos
        if ($user->hasRole('Superadministrador') || $user->hasRole('Administrador')) {
            return true;
        }


        // Asumiendo que el modelo Shipment tiene una relación con el usuario que lo creó
        return $user->hasRole('Conductor') && $user->id === $shipment->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shipment $shipment): bool
    {
        // Superadministrador y Administrador puede editar todos
        if ($user->hasRole('Superadministrador') || $user->hasRole('Administrador')) {
            return true;
        }

        // Asumiendo que el modelo Shipment tiene una relación con el usuario que lo creó
        return $user->hasRole('Conductor') && $user->id === $shipment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shipment $shipment): bool
    {
        return $user->hasRole('Superadministrador') || $user->hasRole('Administrador');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return false;
    }
}
