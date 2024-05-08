<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class VideoResource extends JsonResource
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
            'title' => $this->title,
            'description'=> $this->description,
            'author' => new UserResource($this->author),
            'file' => URL::signedRoute('video.file',['video' => $this->id]),
            'category' => CategoryResource::collection($this->category),
        ];
    }
}
