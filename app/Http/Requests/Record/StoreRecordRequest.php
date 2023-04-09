<?php

namespace App\Http\Requests\Record;

use App\Http\Requests\FormRequest;

class StoreRecordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|\Illuminate\Contracts\Validation\Rule|string>
     */
    public function rules(): array
    {
        return [
            'type'        => 'required|integer|in:-1,1',
            'category_id' => 'required|integer',
            'amount'      => 'required|numeric|min:0',
            'remarks'     => 'nullable|string|max:200',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'amount' => intval($this->amount * 100),
        ]);
    }
}
