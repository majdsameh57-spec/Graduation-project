<?php

namespace App\Policies;

use App\Models\User;
use App\Models\branch;
use Illuminate\Auth\Access\Response;

class BranchPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, branch $branch): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create( $user): bool
    {
        //
        return $user->hasPermissionTo('Create-Branch');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $user): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $user): bool
    {
        return $user->hasPermissionTo('Delete-Branch');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore( $user): bool
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
