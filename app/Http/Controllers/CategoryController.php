<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a list of all categories belonging to the logged-in user.
     * withCount('vaultEntries') adds a vault_entries_count attribute to each
     * category without an extra query per category (avoids N+1 problem).
     */
    public function index(Request $request): View
    {
        $categories = $request->user()
            ->categories()
            ->withCount('vaultEntries')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the empty "create a new category" form.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Handle the submitted "create category" form.
     * StoreCategoryRequest validates the name (including per-user uniqueness)
     * before this method runs. Scoping through $request->user()->categories()
     * means user_id can never be spoofed via the request.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $request->user()->categories()->create($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('status', 'Category created.');
    }

    /**
     * Display a single category and the vault entries inside it.
     * $this->authorize('view', $category) blocks this with a 403 if the
     * category belongs to a different user, even though route-model binding
     * already fetched it by ID.
     */
    public function show(Request $request, Category $category): View
    {
        $this->authorize('view', $category);

        $entries = $category->vaultEntries()->with('folder')->latest()->paginate(15);

        return view('categories.show', compact('category', 'entries'));
    }

    /**
     * Show the "edit this category" form, pre-filled with existing data.
     */
    public function edit(Request $request, Category $category): View
    {
        $this->authorize('update', $category);

        return view('categories.edit', compact('category'));
    }

    /**
     * Handle the submitted "edit category" form.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);

        $category->update($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('status', 'Category updated.');
    }

    /**
     * Delete a category.
     * Vault entries inside this category are NOT deleted — the migration set
     * category_id to nullOnDelete(), so entries just become "uncategorized"
     * instead of being destroyed. Protects actual password data from loss.
     */
    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('status', 'Category deleted.');
    }
}