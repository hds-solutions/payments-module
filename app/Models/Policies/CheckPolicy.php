<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\Check as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CheckPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('checks.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('checks.crud.show');
    }

    public function create(User $user) {
        return $user->can('checks.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('checks.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('checks.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('checks.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('checks.crud.destroy');
    }
}
