<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotesResource extends JsonResource
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
            'text' => $this->text,
            'checked' => $this->checked,
            'tags' => $this->tags->map(fn($el) => ["id" => $el->id, "text" => $el->text]),
            'date_created' => date('d-M-Y', strtotime($this->created_at)),
        ];
    }
}
