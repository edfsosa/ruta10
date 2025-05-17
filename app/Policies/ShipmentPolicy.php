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
    public function viewAny(User $user): bool
    {
        // Superadministrador y Administrador ve todos
        if ($user->hasRole('Superadministrador') || $user->hasRole('Administrador')) {
            return true;
        }
        
        return $user->hasPermissionTo('ver envios');
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
        return $user->hasPermissionTo('ver envios') && $user->id === $shipment->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('crear envios');
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
        return $user->hasPermissionTo('editar envios') && $user->id === $shipment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shipment $shipment): bool
    {
        // Superadministrador y Administrador puede eliminar todos
        if ($user->hasRole('Superadministrador') || $user->hasRole('Administrador')) {
            return true;
        }

        // Asumiendo que el modelo Shipment tiene una relación con el usuario que lo creó
        return $user->hasPermissionTo('eliminar envios') && $user->id === $shipment->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Shipment $shipment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Shipment $shipment): bool
    {
        return false;
    }
}
