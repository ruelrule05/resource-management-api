<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Http\Requests\StoreInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\Http\Resources\InventoryItemResource;

class InventoryItemController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryItem::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('quantity_min')) {
            $query->where('quantity', '>=', $request->input('quantity_min'));
        }
        if ($request->has('quantity_max')) {
            $query->where('quantity', '<=', $request->input('quantity_max'));
        }

        if ($request->has('sort_by') && in_array($request->input('sort_by'), ['name', 'quantity', 'sku', 'status', 'created_at'])) {
            $sortDirection = $request->input('sort_direction', 'asc');
            $query->orderBy($request->input('sort_by'), $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->input('per_page', 10);
        $inventoryItems = $query->paginate($perPage)->appends($request->query());

        return InventoryItemResource::collection($inventoryItems);
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
