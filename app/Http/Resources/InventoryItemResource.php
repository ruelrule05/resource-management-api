<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin InventoryItem */
class InventoryItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
