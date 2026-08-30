<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tags</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="p-4 bg-green-50 text-green-700 rounded-md text-sm">{{ session('status') }}</div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('tags.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">
                    + New Tag
                </a>
            </div>

            <div class="bg-white shadow sm:rounded-lg divide-y divide-gray-200">
                @forelse ($tags as $tag)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <a href="{{ route('tags.show', $tag) }}" class="text-indigo-600">
                            #{{ $tag->name }}
                            <span class="text-gray-400 text-sm">({{ $tag->vault_entries_count }})</span>
                        </a>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('tags.edit', $tag) }}" class="text-sm text-gray-600">Edit</a>
                            <form method="POST" action="{{ route('tags.destroy', $tag) }}"
                                onsubmit="return confirm('Delete this tag? It will be removed from all entries, but the entries themselves stay.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No tags yet. <a href="{{ route('tags.create') }}" class="text-indigo-600">Create one</a>.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>