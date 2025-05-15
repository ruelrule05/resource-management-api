<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Http\Requests\StoreInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\Http\Resources\InventoryItemResource;

class InventoryItemController extends Controller
{
    public function index()
    {
        return InventoryItemResource::collection(InventoryItem::all());
    }

    public function store(StoreInventoryItemRequest $request)
    {
        $data = $request->validated();

        return new InventoryItemResource(InventoryItem::create($data));
    }

    public function show(InventoryItem $inventoryItem)
    {
        return new InventoryItemResource($inventoryItem);
    }

    public function update(UpdateInventoryItemRequest $request, InventoryItem $inventoryItem)
    {
        $data = $request->validated();

        $inventoryItem->update($data);

        return new InventoryItemResource($inventoryItem);
    }

    public function destroy(InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();

        return response()->json();
    }
}
