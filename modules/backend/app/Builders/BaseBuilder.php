<?php

namespace App\Builders;

use App\Exceptions\CustomException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;

class BaseBuilder extends Builder
{
    public function filter($filters)
    {
        foreach ($filters as $filter){
            preg_match('/(.*)\.(.*)/', $filter['field'], $matches);
            if(count($filter['values']) > 1){
                if(isset($matches[0])){
                    $this->whereHas($matches[1], function($query) use ($matches, $filter) {
                        $query->whereIn($matches[1].'.'.$matches[2], $filter['values']);
                    });
                }
                else{
                    $this->whereIn($filter['field'], $filter['values']);
                }
            }
            else{
                if(isset($matches[0])){
                    $this->whereHas($matches[1], function($query) use ($matches, $filter) {
                        $query->where($matches[1].'.'.$matches[2], $filter['operator'], $filter['values'][0]);
                    });
                }
                else{
                    $this->where($filter['field'], $filter['operator'], $filter['values'][0]);
                }
            }
        }

        return $this;
    }

    public function search($search)
    {
        $this->where(function ($query) use ($search){
            foreach ($search['fields'] as $field){
                $query->orWhere($field, 'ilike', '%'.$search['value'].'%');
            }
        });
        return $this;
    }

    public function sort($sort)
    {
        if($sort["order_by"] == "asc"){
            $this->orderBy($sort["field"]);
        }
        else{
            $this->orderByDesc($sort["field"]);
        }
        return $this;
    }

    public function pagination($paginate)
    {
        $this->offset(($paginate["page"] - 1) * $paginate["size"])->limit($paginate["size"]);
        return $this;
    }

    public function getBase($data){
        $res = [];
        if(isset($data["filters"])){
            $this->filter($data["filters"]);
        }
        if(isset($data["search"])){
            $this->search($data["search"]);
        }
        if(isset($data["sort"])){
            $this->sort($data["sort"]);
        }
        if(isset($data["paginate"]) && $this->count()){
            if($data["paginate"]["page"] < 1) {
                $data["paginate"]["page"] = 1;
            }
            $res["meta"]["size"] = $data["paginate"]["size"];
            try{
                $res["meta"]["total"] = ceil($this->count()/$data["paginate"]["size"]);
            }
            catch (QueryException $exception){
                throw new CustomException("Invalid field", 422);
            }
            $res["meta"]["current_page"] = $res["meta"]["total"] >= $data["paginate"]["page"] ? $data["paginate"]["page"] : $res["total"];
            $data["paginate"]["page"] = $res["meta"]["current_page"];
            $this->pagination($data["paginate"]);
        }
        try{
            $res["data"] = $this->get();
            return $res;
        }
        catch (QueryException $exception){
            throw new CustomException("Invalid field", 422);
        }
    }
}
