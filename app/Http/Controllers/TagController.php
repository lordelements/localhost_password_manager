<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display all tags belonging to the logged-in user.
     * withCount('vaultEntries') here counts through the belongsToMany
     * pivot relationship (vault_entry_tag), not a direct foreign key —
     * Eloquent handles the extra join automatically.
     */
    public function index(Request $request): View
    {
        $tags = $request->user()
            ->tags()
            ->withCount('vaultEntries')
            ->orderBy('name')
            ->get();

        return view('tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('tags.create');
    }

    /**
     * Handle the submitted "create tag" form.
     * Same ownership-safe pattern as folders/categories — scoped through
     * the user's own tags() relationship.
     */
    public function store(StoreTagRequest $request): RedirectResponse
    {
        $request->user()->tags()->create($request->validated());

        return redirect()
            ->route('tags.index')
            ->with('status', 'Tag created.');
    }

    /**
     * Display a single tag and every vault entry tagged with it.
     * $tag->vaultEntries() here is the belongsToMany relationship —
     * it queries through the pivot table, unlike Folder/Category
     * which query a direct foreign key.
     */
    public function show(Request $request, Tag $tag): View
    {
        $this->authorize('view', $tag);

        $entries = $tag->vaultEntries()->with(['folder', 'category'])->latest()->paginate(15);

        return view('tags.show', compact('tag', 'entries'));
    }

    public function edit(Request $request, Tag $tag): View
    {
        $this->authorize('update', $tag);

        return view('tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        $this->authorize('update', $tag);

        $tag->update($request->validated());

        return redirect()
            ->route('tags.index')
            ->with('status', 'Tag updated.');
    }

    /**
     * Delete a tag.
     * Unlike Folder/Category (which use nullOnDelete on a foreign key),
     * the vault_entry_tag pivot table rows for this tag need to be
     * removed explicitly. The migration's cascadeOnDelete() on
     * vault_entry_tag.tag_id actually handles this automatically at the
     * database level, but we call detach() here too for clarity and so
     * the behavior doesn't silently depend on DB-level cascade alone.
     */
    public function destroy(Request $request, Tag $tag): RedirectResponse
    {
        $this->authorize('delete', $tag);

        $tag->vaultEntries()->detach();
        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with('status', 'Tag deleted.');
    }
}