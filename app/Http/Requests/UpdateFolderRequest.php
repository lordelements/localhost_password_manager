<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateFolderRequest extends StoreFolderRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('folders', 'name')
                    ->where('user_id', $this->user()->id)
                    ->ignore($this->route('folder')),
            ],
        ];
    }
}