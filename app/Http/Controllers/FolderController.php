<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use App\Models\Folder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FolderController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a list of all folders belonging to the logged-in user.
     * withCount('vaultEntries') adds a vault_entries_count attribute to each
     * folder without an extra query per folder (avoids N+1 problem).
     */
    public function index(Request $request): View
    {
        $folders = $request->user()
            ->folders()
            ->withCount('vaultEntries')
            ->orderBy('name')
            ->get();

        return view('folders.index', compact('folders'));
    }

    /**
     * Show the empty "create a new folder" form.
     * No data needs to be loaded here since it's a blank form.
     */
    public function create(): View
    {
        return view('folders.create');
    }

    /**
     * Handle the submitted "create folder" form.
     * StoreFolderRequest runs validation automatically before this method
     * even executes (including the per-user unique name rule).
     * $request->user()->folders()->create(...) scopes the new folder to the
     * logged-in user automatically, so user_id can never be spoofed.
     */
    public function store(StoreFolderRequest $request): RedirectResponse
    {
        $request->user()->folders()->create($request->validated());

        return redirect()
            ->route('folders.index')
            ->with('status', 'Folder created.');
    }

    /**
     * Display a single folder and the vault entries inside it.
     * $this->authorize('view', $folder) checks FolderPolicy::view() —
     * blocks this request with a 403 if the folder belongs to someone else,
     * even though route-model binding already fetched it by ID.
     */
    public function show(Request $request, Folder $folder): View
    {
        $this->authorize('view', $folder);

        $entries = $folder->vaultEntries()->with('category')->latest()->paginate(15);

        return view('folders.show', compact('folder', 'entries'));
    }

    /**
     * Show the "edit this folder" form, pre-filled with existing data.
     * Authorization check happens before anything else, so a user can't
     * even see the edit form for a folder they don't own.
     */
    public function edit(Request $request, Folder $folder): View
    {
        $this->authorize('update', $folder);

        return view('folders.edit', compact('folder'));
    }

    /**
     * Handle the submitted "edit folder" form.
     * UpdateFolderRequest validates the new name (still unique per-user,
     * excluding this folder's own current name from that check).
     */
    public function update(UpdateFolderRequest $request, Folder $folder): RedirectResponse
    {
        $this->authorize('update', $folder);

        $folder->update($request->validated());

        return redirect()
            ->route('folders.index')
            ->with('status', 'Folder updated.');
    }

    /**
     * Delete a folder.
     * Vault entries inside this folder are NOT deleted — the database
     * migration set folder_id to nullOnDelete(), so entries just become
     * "unfiled" (folder_id becomes null) instead of being destroyed.
     * This protects the user's actual passwords from accidental data loss.
     */
    public function destroy(Request $request, Folder $folder): RedirectResponse
    {
        $this->authorize('delete', $folder);

        $folder->delete();

        return redirect()
            ->route('folders.index')
            ->with('status', 'Folder deleted.');
    }
}