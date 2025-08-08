<?php

namespace App\Policies;

use App\Models\User;
use App\Models\product;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny( $user): bool
    {
        return $user->hasPermissionTo('Read-Products');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view( $user, product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create( $user): bool
    {
        return $user->hasPermissionTo('Create-Product');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $user, product $product): bool
    {
        //
        return $user->hasPermissionTo('Update-Product');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $user, product $product): bool
    {
        return $user->hasPermissionTo('Delete-Product');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore( $user, product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete( $user, product $product): bool
    {
        //
    }
}
