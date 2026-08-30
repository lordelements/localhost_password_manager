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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

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

    // public function update(UpdateVaultEntryRequest $request, VaultEntry $vaultEntry): RedirectResponse
    // {
    //     $this->authorizeOwnership($request, $vaultEntry);

    //     $vaultEntry->fill($request->validated())->save();

    //     if ($request->has('tags')) {
    //         $vaultEntry->tags()->sync($request->input('tags', []));
    //     }

    //     $request->user()->activityLogs()->create([
    //         'action' => 'password_updated',
    //         'description' => "Updated entry \"{$vaultEntry->website_name}\"",
    //     ]);

    //     return redirect()
    //         ->route('vault-entries.show', $vaultEntry)
    //         ->with('status', 'Vault entry updated.');
    // }

    public function update(UpdateVaultEntryRequest $request, VaultEntry $vaultEntry): RedirectResponse
    {
        $this->authorizeOwnership($request, $vaultEntry);

        $data = $request->validated();

        // If the password field was left blank, don't overwrite the
        // existing encrypted password — "blank" means "no change",
        // not "set to empty string".
        if (! $request->filled('password_encrypted')) {
            unset($data['password_encrypted']);
        }

        $vaultEntry->update($data);

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



    /**
     * Re-verify the user's account password, then return the decrypted
     * vault entry password as JSON. This is called via fetch() from the
     * show view, not a normal page load — matches the secure reveal flow
     * designed in Sprint 2 (re-auth -> decrypt -> log -> return).
     */
    public function reveal(Request $request, VaultEntry $vaultEntry): JsonResponse
    {
        $this->authorizeOwnership($request, $vaultEntry);

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        // Re-check the account's master password against the currently
        // logged-in user's stored hash. This does NOT re-log them in —
        // it's a lightweight confirmation, similar to Laravel's built-in
        // "confirm password" screens.
        if (! Hash::check($request->input('password'), $request->user()->password)) {
            return response()->json(['message' => 'Incorrect password.'], 422);
        }

        $request->user()->activityLogs()->create([
            'action' => 'password_revealed',
            'description' => "Revealed password for \"{$vaultEntry->website_name}\"",
        ]);

        return response()->json([
            // password_encrypted is auto-decrypted here because of the
            // 'encrypted' cast on the model — this returns plaintext.
            'password' => $vaultEntry->password_encrypted,
        ]);
    }

    protected function authorizeOwnership(Request $request, VaultEntry $vaultEntry): void
    {
        abort_unless($vaultEntry->user_id === $request->user()->id, 403);
    }
}