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
            'reciprocal_name' => 'nullable|string|max:50',
            'type'            => 'required|integer|in:-1,1',
            'category_id'     => 'required|integer',
            'amount'          => 'required|numeric|min:1|max:400000000',
            'transaction_at'  => 'required|date',
            'remarks'         => 'nullable|string|max:200',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'reciprocal_name' => $this->reciprocal_name ?: '',
            'amount'          => floatval($this->amount),
            'remarks'         => $this->remarks ?: '',
        ]);
    }
}
