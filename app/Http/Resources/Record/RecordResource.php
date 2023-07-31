<?php

namespace App\Http\Resources\Record;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'user_id'         => $this->user_id,
            'reciprocal_name' => $this->reciprocal_name,
            'type'            => $this->type,
            'type_name'       => Record::TYPE_SUB === $this->type ? '支出' : '收入',
            'category_id'     => $this->category_id,
            'category'        => $this->whenLoaded('category'),
            'amount'          => $this->amount / 100,
            'transaction_at'  => $this->transaction_at->format('Y-m-d'),
            'remarks'         => $this->remarks,
            'created_at'      => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'      => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
