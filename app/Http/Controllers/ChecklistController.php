<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Checklist\ChecklistRequest;
use App\Http\Resources\Checklist\ChecklistCollection;
use App\Models\Checklist;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends BaseController
{
    // Get all checklists for the authenticated user
    public function index()
    {
        $checklists = Checklist::where('user_id', Auth::id())->get();
        return $this->sendResponse(ChecklistCollection::collection($checklists), 'Checklists retrieved successfully.');
    }

    // Create new checklist
    public function store(ChecklistRequest $request)
    {
        $checklist = Checklist::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return $this->sendResponse(new ChecklistCollection($checklist), 'Checklist created successfully.');
    }

    // Delete checklist by ID
    public function destroy($id)
    {
        $checklist = Checklist::where('user_id', Auth::id())->find($id);

        if (!$checklist) {
            return $this->sendError('Checklist not found.', [], 404);
        }

        $checklist->delete();

        return $this->sendResponse(null, 'Checklist deleted successfully.');
    }

}
