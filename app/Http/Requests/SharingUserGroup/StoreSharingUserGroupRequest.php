<?php

namespace App\Http\Requests\SharingUserGroup;

use App\Http\Requests\FormRequest;

class StoreSharingUserGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:100',
            'user_ids'       => 'required|array',
            'sharing_ratios' => 'required|array',
        ];
    }
}
