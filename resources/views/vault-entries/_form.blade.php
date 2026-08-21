<div class="space-y-6">
    <div>
        <x-input-label for="website_name" value="Website Name" />
        <x-text-input id="website_name" name="website_name" type="text" class="mt-1 block w-full" :value="old('website_name', $vaultEntry->website_name ?? '')"
            required autofocus />
        <x-input-error :messages="$errors->get('website_name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="website_url" value="Website URL" />
        <x-text-input id="website_url" name="website_url" type="url" class="mt-1 block w-full" :value="old('website_url', $vaultEntry->website_url ?? '')" />
        <x-input-error :messages="$errors->get('website_url')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="username" value="Username" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $vaultEntry->username ?? '')" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $vaultEntry->email ?? '')" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
    </div>

    <div x-data="{ show: false }">
        <x-input-label for="password_encrypted" value="Password" />
        <div class="relative mt-1">
            <input :type="show ? 'text' : 'password'" id="password_encrypted" name="password_encrypted"
                class="block w-full rounded-md border-gray-300 shadow-sm pr-16" value="{{ old('password_encrypted') }}"
                @if (!isset($vaultEntry)) required @endif
                placeholder="{{ isset($vaultEntry) ? 'Leave blank to keep current password' : '' }}">
            <button type="button" @click="show = !show" class="absolute inset-y-0 right-2 text-sm text-gray-500">
                <span x-text="show ? 'Hide' : 'Show'"></span>
            </button>
        </div>
        <x-input-error :messages="$errors->get('password_encrypted')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="folder_id" value="Folder" />
            <select id="folder_id" name="folder_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">— None —</option>
                @foreach ($folders as $folder)
                    <option value="{{ $folder->id }}" @selected(old('folder_id', $vaultEntry->folder_id ?? null) == $folder->id)>
                        {{ $folder->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('folder_id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="category_id" value="Category" />
            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">— None —</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $vaultEntry->category_id ?? null) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="tags" value="Tags" />
        <select id="tags" name="tags[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @php $selectedTags = old('tags', isset($vaultEntry) ? $vaultEntry->tags->pluck('id')->toArray() : []); @endphp
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" @selected(in_array($tag->id, $selectedTags))>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('tags')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="notes" value="Notes" />
        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $vaultEntry->notes ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2">
        <input type="checkbox" id="favorite" name="favorite" value="1" @checked(old('favorite', $vaultEntry->favorite ?? false))
            class="rounded border-gray-300">
        <x-input-label for="favorite" value="Mark as favorite" />
    </div>
</div>
