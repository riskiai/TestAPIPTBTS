<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Models\ChecklistItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Checklist\ChecklistItemRequest;
use App\Http\Resources\Checklist\ChecklistItemResource;

class ChecklistItemController extends BaseController
{
    // Get all items by checklist ID
    public function index($checklistId)
    {
        $checklist = Checklist::where('user_id', Auth::id())->find($checklistId);

        if (!$checklist) {
            return $this->sendError('Checklist not found.', [], 404);
        }

        $items = $checklist->items; // Mengambil semua item terkait checklist

        // Menggunakan resource untuk memformat output
        return $this->sendResponse(ChecklistItemResource::collection($items), 'Checklist items retrieved successfully.');
    }



    // Create new item in checklist
    public function store(ChecklistItemRequest $request, $checklistId)
    {
        $checklist = Checklist::where('user_id', Auth::id())->find($checklistId);

        if (!$checklist) {
            return $this->sendError('Checklist not found.', [], 404);
        }

        $item = ChecklistItem::create([
            'checklist_id' => $checklistId,
            'name' => $request->itemName,
            'status' => false,
        ]);

        return $this->sendResponse($item, 'Checklist item created successfully.');
    }

    // Get checklist item by ID
    public function show($checklistId, $itemId)
    {
        $item = ChecklistItem::where('checklist_id', $checklistId)->find($itemId);

        if (!$item) {
            return $this->sendError('Checklist item not found.', [], 404);
        }

        return $this->sendResponse($item, 'Checklist item retrieved successfully.');
    }

    // Update checklist item status
    public function updateStatus($checklistId, $itemId)
    {
        $item = ChecklistItem::where('checklist_id', $checklistId)->find($itemId);

        if (!$item) {
            return $this->sendError('Checklist item not found.', [], 404);
        }

        $item->status = !$item->status; // Toggle status
        $item->save();

        return $this->sendResponse($item, 'Checklist item status updated successfully.');
    }

    // Delete checklist item by ID
    public function destroy($checklistId, $itemId)
    {
        $item = ChecklistItem::where('checklist_id', $checklistId)->find($itemId);

        if (!$item) {
            return $this->sendError('Checklist item not found.', [], 404);
        }

        $item->delete();

        return $this->sendResponse(null, 'Checklist item deleted successfully.');
    }

    // Rename checklist item
    public function rename(Request $request, $checklistId, $itemId)
    {
        $request->validate([
            'itemName' => 'required|string|max:255',
        ]);

        $item = ChecklistItem::where('checklist_id', $checklistId)->find($itemId);

        if (!$item) {
            return $this->sendError('Checklist item not found.', [], 404);
        }

        $item->name = $request->itemName;
        $item->save();

        return $this->sendResponse($item, 'Checklist item renamed successfully.');
    }
}
