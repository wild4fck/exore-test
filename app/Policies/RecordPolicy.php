<?php

namespace App\Policies;

use App\Models\Record;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): void {
    }

    /**
     * Determine whether the user can view the list by author.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $author
     * @return bool
     * @noinspection PhpUndefinedFieldInspection
     */
    public function viewByAuthor(User $user, User $author): bool {
        $accept = array_merge(array_column($user->myEmployees->toArray(), 'id'), [$user->id]);
        if (in_array($author->id, $accept)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return bool
     * @noinspection PhpUndefinedFieldInspection
     */
    public function create(User $user): bool {
        return $user->id > 0;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Record $record
     * @return bool
     * @noinspection PhpUndefinedFieldInspection
     */
    public function update(User $user, Record $record): bool {
        return $record->author->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Record $record
     * @return bool
     */
    public function delete(User $user, Record $record): bool {
        return $this->view($user, $record);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Record $record
     * @return bool
     * @noinspection PhpUndefinedFieldInspection
     */
    public function view(User $user, Record $record): bool {
        $accept = array_merge(array_column($user->myEmployees->toArray(), 'id'), [$user->id]);

        if (in_array($record->author->id, $accept)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Record $record
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Record $record): void {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Record $record
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Record $record): void {
    }
}
