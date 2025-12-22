<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

function checkAdminPermission($permission)
{
    $user = Auth::user();

    if (!$user || !$user->roles) {
        return false;
    }

    if($user->roles->name === "Super-Admin"){
        return true;
    }
    
    return $user->roles->permissions->contains('slug', $permission);
}