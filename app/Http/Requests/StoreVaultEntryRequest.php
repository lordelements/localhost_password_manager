<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVaultEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'website_name' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'string', 'url', 'max:255'],
            'username' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'password_encrypted' => ['required', 'string', 'max:1024'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'favorite' => ['boolean'],
            'folder_id' => [
                'nullable',
                Rule::exists('folders', 'id')->where('user_id', $userId),
            ],
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where('user_id', $userId),
            ],
            'tags' => ['nullable', 'array'],
            'tags.*' => [
                Rule::exists('tags', 'id')->where('user_id', $userId),
            ],
        ];
    }
}