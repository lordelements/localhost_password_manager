<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Add Vault Entry
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Store a new set of credentials securely in your vault.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 sm:p-8">
                <form method="POST" action="{{ route('vault-entries.store') }}" class="space-y-6">
                    @csrf
                    @include('vault-entries._form', ['vaultEntry' => new \App\Models\VaultEntry])

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-end gap-4">
                        <a href="{{ route('vault-entries.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Cancel
                        </a>
                        <x-primary-button class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 focus:ring-indigo-500 text-sm font-medium shadow-sm transition-all">
                            Save Entry
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>