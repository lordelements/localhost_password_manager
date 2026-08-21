<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Folder
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update the name of this folder.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700/60 p-6 sm:p-8">
                <form method="POST" action="{{ route('folders.update', $folder) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <x-input-label for="name" value="Folder Name" class="text-gray-700 dark:text-gray-300 font-medium" />
                        <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-2xs focus:border-indigo-500 focus:ring-indigo-500"
                            :value="old('name', $folder->name)" required autofocus placeholder="e.g. Personal, Work, Banking" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-end gap-4">
                        <a href="{{ route('folders.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Cancel
                        </a>
                        <x-primary-button class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 focus:ring-indigo-500 text-sm font-medium shadow-sm transition-all">
                            Update Folder
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>