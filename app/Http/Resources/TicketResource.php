<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'title' => $this->title,
            'type' => $this->type,
            'assigned_to' => $this->assigned_to,
            'description' => $this->description,
            'label' => $this->label,
            'project' => $this->project,
            'order' => $this->order
        ];
    }
}