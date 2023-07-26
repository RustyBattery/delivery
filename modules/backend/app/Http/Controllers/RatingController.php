<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\CustomerRatingResource;
use App\Models\Dish;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(BaseRequest $request){
        $data = $request->validated();
        $ratings = auth()->user->customer()->ratings()->getBase($data);
        $meta = $ratings["meta"] ?? [];
        return response(array_merge(["data" => CustomerRatingResource::collection($ratings["data"])], $meta), 200);
    }

    public function create(RatingRequest $request, Dish $dish)
    {
        $data = $request->validated();
        $customer = auth()->user->customer();
        if(!$customer->check_create_rating($dish)){
            throw new CustomException("Forbidden", 403);
        }
        $customer->rating_dishes()->attach($dish, $data);
        return response(["message" => "Succsess"], 200);
    }

    public function update(RatingRequest $request, Rating $rating)
    {
        $data = $request->validated();
        if($rating->customer_id != auth()->user->customer()->id){
            throw new CustomException("Forbidden", 403);
        }
        $rating->update($data);
        return response(["message" => "Succsess"], 200);
    }

    public function delete(Rating $rating)
    {
        if($rating->customer_id != auth()->user->customer()->id){
            throw new CustomException("Forbidden", 403);
        }
        $rating->delete();
        return response(["message" => "Succsess"], 200);
    }

    public function check(Dish $dish)
    {
        return response(["check" => auth()->user->customer()->check_create_rating($dish)], 200);
    }

}
