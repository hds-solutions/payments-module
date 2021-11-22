<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\CreditNote as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CreditNotePolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('credit_note.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('credit_note.crud.show');
    }

    public function create(User $user) {
        return $user->can('credit_note.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('credit_note.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('credit_note.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('credit_note.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('credit_note.crud.destroy');
    }
}
