<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderShortResource extends JsonResource
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
            "id" => $this->id,
            "customer_id" => $this->customer_id,
            "restaurant" => $this->restaurant,
            "cook_id" => $this->cook_id,
            "courier_id" => $this->courier_id,
            "delivery_time" => $this->delivery_time,
            "order_time" => $this->order_time,
            "address" => $this->address,
            "price" => $this->price,
            "status" => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
