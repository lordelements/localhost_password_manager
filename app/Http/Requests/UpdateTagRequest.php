<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateTagRequest extends StoreTagRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tags', 'name')
                    ->where('user_id', $this->user()->id)
                    ->ignore($this->route('tag')),
            ],
        ];
    }
}