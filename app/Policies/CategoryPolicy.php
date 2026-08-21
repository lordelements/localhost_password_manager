<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view this category.
     */
    public function view(User $user, Category $category): bool
    {
        return $category->user_id === $user->id;
    }

    /**
     * Determine whether the user can create categories.
     * Any logged-in user can create their own — no existing record to check yet.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update this category.
     */
    public function update(User $user, Category $category): bool
    {
        return $category->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete this category.
     */
    public function delete(User $user, Category $category): bool
    {
        return $category->user_id === $user->id;
    }

    /**
     * Not applicable — categories are hard-deleted, no soft-delete support.
     */
    public function restore(User $user, Category $category): bool
    {
        return false;
    }

    /**
     * Not applicable — same reason as restore().
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return false;
    }
}