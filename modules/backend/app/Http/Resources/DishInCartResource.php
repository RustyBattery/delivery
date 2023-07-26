<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DishInCartResource extends JsonResource
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
            'photo' => $this->photo ? env('AWS_TAKE_URL').'/'.env('AWS_BUCKET').'/'.$this->photo : null,
            'restaurant' => ["id" => $this->restaurant()->id, "name" => $this->restaurant()->name],
            'count' => $this->pivot->count,
            'price' => $this->price * $this->pivot->count,
            'created_at' => $this->pivot->created_at,
            'updated_at' => $this->pivot->updated_at,
        ];
    }
}
