<?php

namespace App\Http\Requests;

class UpdateVaultEntryRequest extends StoreVaultEntryRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['password_encrypted'] = ['nullable', 'string', 'max:1024'];

        return $rules;
    }
}