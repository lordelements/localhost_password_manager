<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends StoreCategoryRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // ->ignore() excludes this category's own current row from
                // the uniqueness check, so renaming "Work" to "Work" (unchanged)
                // doesn't falsely trigger a duplicate error.
                Rule::unique('categories', 'name')
                    ->where('user_id', $this->user()->id)
                    ->ignore($this->route('category')),
            ],
        ];
    }
}