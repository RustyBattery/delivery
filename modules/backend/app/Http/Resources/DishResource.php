<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'photo' => $this->photo ? env('AWS_TAKE_URL').'/'.env('AWS_BUCKET').'/'.$this->photo : null,
            'category' => $this->category,
            'is_vegetarian' => $this->is_vegetarian,
            'price' => $this->price,
            'rating' => round($this->rating(), 2),
            'rating_count' => $this->ratings()->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
