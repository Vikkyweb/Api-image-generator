<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    // public static $wrap = null; //to disable the resource from returning data{}
    public function toArray(Request $request): array
    {
        // return [
        //     'id' => $this->id,
        //     'title' => $this->title,
        //     'body' => $this->id,
        //     'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        //     'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        //     'user' => [
        //         'id' => $this->user->id,
        //         'name' => $this->user->name,
        //     ]
        // ];

        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            // 'user' => new UserResource($this->user)
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
