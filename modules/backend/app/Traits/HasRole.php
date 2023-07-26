<?php

namespace App\Traits;

trait HasRole
{
    public function hasRole($roles){
        $roles = is_string($roles) ? explode('|', $roles) : $roles;
        foreach ((array)$roles as $role){
            if(isset($this->roles[$role])){
                return true;
            }
        }
        return false;
    }
}
