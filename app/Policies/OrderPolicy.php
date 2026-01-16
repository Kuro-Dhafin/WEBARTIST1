<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
     public function manage(User $user, Order $order): bool
    {
        return $user->role === 'artist'
            && $order->service->artist_id === $user->id;
    }

    public function accept(User $user, Order $order): bool
    {
        return $this->manage($user, $order)
            && $order->status === 'pending';
    }

    public function reject(User $user, Order $order): bool
    {
        return $this->manage($user, $order)
            && $order->status === 'pending';
    }

    public function complete(User $user, Order $order): bool
    {
        return $this->manage($user, $order)
            && $order->status === 'accepted';
    }
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function view(User $user, Order $order): bool
    {
        return $order->buyer_id === $user->id
            || $order->service->artist_id === $user->id;
    }

    public function create(User $user, Service $service): bool
    {
        return $user->role === 'buyer';
    }

 public function cancel(User $user, Order $order): bool
    {
        return $user->role === 'buyer'
            && $order->buyer_id === $user->id
            && $order->status === 'pending';
    }


    public function updateStatus(User $user, Order $order): bool
    {
        return $user->isArtist()
            && $order->service->artist_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Create order for a given service
     */

    public function update(User $user, Order $order): bool
    {
        return false;
    }

    public function delete(User $user, Order $order): bool
    {
        return false;
    }
}
