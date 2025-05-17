<?php

namespace App\Policies;

use App\Models\Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role as ModelsRole;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ver roles');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('ver roles');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('crear roles');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('editar roles');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('eliminar roles');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ModelsRole $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ModelsRole $role): bool
    {
        return false;
    }
}
