<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comment_text' => $this->comment_text,
            'user' => UserResource::make($this->whenLoaded('user')),
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
