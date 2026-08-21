<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $category->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow sm:rounded-lg divide-y divide-gray-200">
                @forelse ($entries as $entry)
                    <div class="px-6 py-4">
                        <a href="{{ route('vault-entries.show', $entry) }}" class="text-indigo-600">
                            {{ $entry->website_name }}
                        </a>
                        <span class="text-sm text-gray-500">{{ $entry->folder->name ?? '' }}</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">No entries in this category yet.</div>
                @endforelse
            </div>

            {{ $entries->links() }}

            <a href="{{ route('categories.index') }}" class="text-sm text-gray-600">← Back to Categories</a>
        </div>
    </div>
</x-app-layout>