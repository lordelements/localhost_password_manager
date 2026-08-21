<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Dashboard
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Overview of your secure password vault and recent activity.</p>
            </div>
            <div>
                <a href="{{ route('vault-entries.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-medium rounded-xl shadow-sm transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    <span>Go to Vault</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Stat Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Total Passwords Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Total Passwords</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">{{ $totalEntries }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Favorites Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Favorites</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">{{ $favoriteCount }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/50 flex items-center justify-center text-amber-500 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content Lists Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recently Added Section -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100 dark:border-gray-700/60">
                            <h3 class="font-semibold text-base text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Recently Added
                            </h3>
                        </div>

                        <div class="divide-y divide-gray-100 dark:divide-gray-700/45">
                            @forelse ($recentEntries as $entry)
                                <div class="py-3.5 first:pt-0 last:pb-0 flex items-center justify-between group">
                                    <div>
                                        <a href="{{ route('vault-entries.show', $entry) }}" class="font-medium text-gray-900 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                            {{ $entry->website_name }}
                                        </a>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $entry->created_at->diffForHumans() }}</div>
                                    </div>
                                    <span class="text-gray-300 dark:text-gray-600 group-hover:text-indigo-500 transition-colors">→</span>
                                </div>
                            @empty
                                <div class="py-8 text-center">
                                    <p class="text-sm text-gray-400 dark:text-gray-500">No entries yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100 dark:border-gray-700/60">
                            <h3 class="font-semibold text-base text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Recent Activity
                            </h3>
                        </div>

                        <div class="divide-y divide-gray-100 dark:divide-gray-700/45">
                            @forelse ($recentActivity as $log)
                                <div class="py-3.5 first:pt-0 last:pb-0">
                                    <div class="text-sm text-gray-800 dark:text-gray-200 font-medium">{{ $log->description }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $log->created_at->diffForHumans() }}</div>
                                </div>
                            @empty
                                <div class="py-8 text-center">
                                    <p class="text-sm text-gray-400 dark:text-gray-500">No activity yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>