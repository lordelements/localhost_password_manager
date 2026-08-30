<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-gray-900">Tag Management</h2>
                <p class="text-sm text-gray-500">Create and configure a new system tag.</p>
            </div>
            <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li><a href="{{ route('tags.index') }}" class="hover:text-gray-700">Tags</a></li>
                    <li><span class="mx-2 text-gray-400">/</span></li>
                    <li class="font-medium text-gray-800" aria-current="page">New</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-base font-semibold text-gray-800">Tag Details</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Please provide a unique name for the new tag.</p>
                </div>

                <!-- Form Body -->
                <div class="p-6">
                    <form method="POST" action="{{ route('tags.store') }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="name" value="Tag Name" class="text-gray-700 font-medium" />
                                <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm rounded-lg"
                                    :value="old('name')" placeholder="e.g., Urgent, Featured, V2.0" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Actions Toolbar -->
                        <div class="mt-8 pt-5 border-t border-gray-100 flex items-center justify-end gap-3">
                            <a href="{{ route('tags.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 focus:ring-indigo-500 rounded-lg shadow-sm">
                                Create Tag
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>