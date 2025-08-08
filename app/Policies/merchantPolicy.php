<?php

namespace App\Policies;

use App\Models\User;
use App\Models\merchant;
use Illuminate\Auth\Access\Response;

class merchantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        //
        return $user->hasPermissionTo('Read-Merchants');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user): bool
    {
        return $user->hasPermissionTo('Read-Merchants');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasPermissionTo('Create-Merchant');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user): bool
    {
        return $user->hasPermissionTo('Update-Merchant');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user): bool
    {
        return $user->hasPermissionTo('Delete-Merchant');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, merchant $merchant): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, merchant $merchant): bool
    {
        //
    }

    public function editPermission($user)
    {
        return $user->hasPermissionTo('Edit-User-Permission');
    }

    public function updatePermission($user)
    {
        return $user->hasPermissionTo('Update-User-Permission');
    }
}
