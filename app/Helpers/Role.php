<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Role
{
    public static function isAdmin()
    {
        if (!Auth::check()) {
            return false;
        }

        if (Auth::user()->role == 'admin') {
            return true;
        }
    }

    public static function isUser()
    {
        if (!Auth::check()) {
            return false;
        }

        if (Auth::user()->role == 'user') {
            return true;
        }
    }
}
