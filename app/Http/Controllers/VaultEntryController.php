<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVaultEntryRequest;
use App\Http\Requests\UpdateVaultEntryRequest;
use App\Models\Category;
use App\Models\Folder;
use App\Models\Tag;
use App\Models\VaultEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VaultEntryController extends Controller
{
    // Display
    public function index(Request $request): View
    {
        $entries = $request->user()
            ->vaultEntries()
            ->with(['folder', 'category', 'tags'])
            ->latest()
            ->paginate(15);

        return view('vault-entries.index', compact('entries'));
    }

    public function create(Request $request): View
    {
        $folders = $request->user()->folders;
        $categories = $request->user()->categories;
        $tags = $request->user()->tags;

        return view('vault-entries.create', compact('folders', 'categories', 'tags'));
    }

    public function store(StoreVaultEntryRequest $request): RedirectResponse
    {
        $entry = $request->user()->vaultEntries()->create($request->validated());

        if ($request->filled('tags')) {
            $entry->tags()->sync($request->input('tags'));
        }

        $request->user()->activityLogs()->create([
            'action' => 'password_added',
            'description' => "Added entry \"{$entry->website_name}\"",
        ]);

        return redirect()
            ->route('vault-entries.index')
            ->with('status', 'Vault entry created.');
    }

    public function show(Request $request, VaultEntry $vaultEntry): View
    {
        $this->authorizeOwnership($request, $vaultEntry);

        $vaultEntry->load(['folder', 'category', 'tags']);

        return view('vault-entries.show', compact('vaultEntry'));
    }

    public function edit(Request $request, VaultEntry $vaultEntry): View
    {
        $this->authorizeOwnership($request, $vaultEntry);

        $folders = $request->user()->folders;
        $categories = $request->user()->categories;
        $tags = $request->user()->tags;
        $vaultEntry->load('tags');

        return view('vault-entries.edit', compact('vaultEntry', 'folders', 'categories', 'tags'));
    }

    public function update(UpdateVaultEntryRequest $request, VaultEntry $vaultEntry): RedirectResponse
    {
        $this->authorizeOwnership($request, $vaultEntry);

        $vaultEntry->fill($request->validated())->save();

        if ($request->has('tags')) {
            $vaultEntry->tags()->sync($request->input('tags', []));
        }

        $request->user()->activityLogs()->create([
            'action' => 'password_updated',
            'description' => "Updated entry \"{$vaultEntry->website_name}\"",
        ]);

        return redirect()
            ->route('vault-entries.show', $vaultEntry)
            ->with('status', 'Vault entry updated.');
    }

    public function destroy(Request $request, VaultEntry $vaultEntry): RedirectResponse
    {
        $this->authorizeOwnership($request, $vaultEntry);

        $name = $vaultEntry->website_name;
        VaultEntry::destroy($vaultEntry->id);

        $request->user()->activityLogs()->create([
            'action' => 'password_deleted',
            'description' => "Deleted entry \"{$name}\"",
        ]);

        return redirect()
            ->route('vault-entries.index')
            ->with('status', 'Vault entry deleted.');
    }

    protected function authorizeOwnership(Request $request, VaultEntry $vaultEntry): void
    {
        abort_unless($vaultEntry->user_id === $request->user()->id, 403);
    }
}