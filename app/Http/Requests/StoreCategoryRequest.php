<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // Uniqueness is scoped per-user, so two different users
                // can both have a category named "Work" without conflict.
                Rule::unique('categories', 'name')->where('user_id', $this->user()->id),
            ],
        ];
    }
}