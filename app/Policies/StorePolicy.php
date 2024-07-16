<?php

namespace App\Policies;

use App\Models\Store\Store;
use App\Models\User;

class StorePolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function create(User $user, Store $store): bool
    {
        return $user->id === $store->user_id;
    }
    public function update(User $user, Store $store): bool
    {
        return $user->id === $store->user_id;
    }
    public function delete(User $user, Store $store): bool
    {
        return $user->id === $store->user_id;
    }
}
