<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function view(User $user, Service $service): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isArtist();
    }

    public function update(User $user, Service $service): bool
    {
        return $user->isArtist() && $service->artist_id === $user->id;
    }

    public function delete(User $user, Service $service): bool
    {
        return $this->update($user, $service);
    }

    public function approve(User $user, Service $service): bool
    {
        return $user->isAdmin();
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        return false;
    }

}
