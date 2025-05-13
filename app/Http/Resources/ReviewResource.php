<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i'),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'room' => [
                'id' => $this->room->id,
                'room_number' => $this->room->room_number,
                'building' => $this->room->building->name ?? null,
            ],
            'is_owner' => $request->user() ? $request->user()->id === $this->user_id : false,
        ];
    }
}
