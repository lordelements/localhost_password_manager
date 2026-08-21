<?php

namespace App\Policies;

use App\Models\Folder;
use App\Models\User;

class FolderPolicy
{
    /**
     * Determine whether the user can view this folder.
     * Called by $this->authorize('view', $folder) in FolderController@show.
     */
    public function view(User $user, Folder $folder): bool
    {
        return $folder->user_id === $user->id;
    }

    /**
     * Determine whether the user can create folders.
     * No specific folder to check yet, so this just allows any
     * logged-in user to create their own folder.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update this folder.
     * Called by $this->authorize('update', $folder) in
     * FolderController@edit and @update.
     */
    public function update(User $user, Folder $folder): bool
    {
        return $folder->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete this folder.
     * Called by $this->authorize('delete', $folder) in
     * FolderController@destroy.
     */
    public function delete(User $user, Folder $folder): bool
    {
        return $folder->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore a soft-deleted folder.
     * Not applicable — folders are hard-deleted (no soft deletes),
     * so this can never be true.
     */
    public function restore(User $user, Folder $folder): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete this folder.
     * Same as above — no soft-delete system in place, so this policy
     * method is unreachable in practice, kept only because Laravel's
     * default policy stub includes it.
     */
    public function forceDelete(User $user, Folder $folder): bool
    {
        return false;
    }
}