<?php

namespace App\Http\Requests\Sharing;

use App\Http\Requests\FormRequest;

class StoreSharingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                  => 'required|string|max:100',
            'sharing_user_group_id' => 'integer|min:1',
            'record_ids'            => 'required|array',
        ];
    }
}
