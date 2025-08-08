<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo('Read-Roles');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        return $user->hasPermissionTo('Read-Roles');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Role');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        return $user->hasPermissionTo('Update-Role');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        return $user->hasPermissionTo('Delete-Role');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete( $user): bool
    {
        //
    }
}
