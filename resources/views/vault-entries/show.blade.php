<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">{{ $vaultEntry->website_name }}</h2>
                    @if ($vaultEntry->favorite)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800/60">
                            ★ Favorite
                        </span>
                    @endif
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Detailed credentials and security info for this entry.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('vault-entries.edit', $vaultEntry) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-medium rounded-xl shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Edit Entry</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 sm:p-8 space-y-6" x-data="{ show: false }">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-gray-100 dark:border-gray-700/60">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Website URL</div>
                        <div>
                            @if($vaultEntry->website_url)
                                <a href="{{ $vaultEntry->website_url }}" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1.5 break-all">
                                    {{ $vaultEntry->website_url }}
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="text-sm text-gray-400">—</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Username</div>
                        <div class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $vaultEntry->username ?? '—' }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-gray-100 dark:border-gray-700/60">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Email</div>
                        <div class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $vaultEntry->email ?? '—' }}</div>
                    </div>

                    <div>
    <div class="text-sm text-gray-500">Password</div>
    <div x-data="passwordReveal({{ $vaultEntry->id }})">
        <div class="flex items-center gap-3">
            <span x-show="!revealed">••••••••••••</span>
            <span x-show="revealed" x-text="password"></span>
            <button @click="revealed ? hide() : openPrompt()" class="text-sm text-indigo-600" x-text="revealed ? 'Hide' : 'Reveal'"></button>
        </div>

        <div x-show="promptOpen" x-cloak
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
            @keydown.escape.window="promptOpen = false">
            <div class="bg-white rounded-lg p-6 w-full max-w-sm" @click.outside="promptOpen = false">
                <h3 class="font-medium text-gray-800 mb-3">Confirm your password</h3>
                <input type="password" x-model="confirmPassword" @keydown.enter="submit()"
                    class="block w-full rounded-md border-gray-300 shadow-sm mb-2"
                    placeholder="Account password" autofocus>
                <p x-show="error" x-text="error" class="text-sm text-red-600 mb-2"></p>
                <div class="flex gap-3 mt-3">
                    <button @click="submit()" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">Confirm</button>
                    <button @click="promptOpen = false" class="text-sm text-gray-600">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pb-6 border-b border-gray-100 dark:border-gray-700/60">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Folder</div>
                        <div class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            @if($vaultEntry->folder)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                    {{ $vaultEntry->folder->name }}
                                </span>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Category</div>
                        <div class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            @if($vaultEntry->category)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300">
                                    {{ $vaultEntry->category->name }}
                                </span>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Tags</div>
                        <div class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            {{ $vaultEntry->tags->pluck('name')->join(', ') ?: '—' }}
                        </div>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Notes</div>
                    <div class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/40 p-4 rounded-xl border border-gray-200 dark:border-gray-700/60 whitespace-pre-line">{{ $vaultEntry->notes ?? '—' }}</div>
                </div>

            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('vault-entries.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    ← Back to Vault
                </a>

                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('vault-entries.destroy', $vaultEntry) }}"
                        onsubmit="return confirm('Delete this entry? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 dark:bg-red-950/40 dark:hover:bg-red-900/60 text-red-600 dark:text-red-400 text-sm font-medium rounded-xl border border-red-200 dark:border-red-900/50 transition-colors">
                            Delete Entry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
<script>
function passwordReveal(entryId) {
    return {
        revealed: false,
        promptOpen: false,
        confirmPassword: '',
        password: '',
        error: '',
        hideTimer: null,

        openPrompt() {
            this.error = '';
            this.confirmPassword = '';
            this.promptOpen = true;
        },

        async submit() {
            this.error = '';
            try {
                const response = await fetch(`/vault-entries/${entryId}/reveal`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ password: this.confirmPassword }),
                });

                const data = await response.json();

                if (!response.ok) {
                    this.error = data.message || 'Something went wrong.';
                    return;
                }

                this.password = data.password;
                this.revealed = true;
                this.promptOpen = false;

                // Auto re-hide after 20 seconds, matching the sequence
                // diagram from Sprint 2 (step 9-10: reveal, then auto-clear).
                clearTimeout(this.hideTimer);
                this.hideTimer = setTimeout(() => this.hide(), 20000);
            } catch (e) {
                this.error = 'Network error. Please try again.';
            }
        },

        hide() {
            this.revealed = false;
            this.password = '';
            clearTimeout(this.hideTimer);
        },
    };
}
</script>
@endpush
</x-app-layout>