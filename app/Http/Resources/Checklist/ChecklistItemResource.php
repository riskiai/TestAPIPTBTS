<?php

namespace App\Http\Resources\Checklist;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'checklist_id' => $this->checklist_id,
            'name' => $this->name,
            'status' => $this->status ? 'completed' : 'incomplete', // Menampilkan status sebagai teks
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
