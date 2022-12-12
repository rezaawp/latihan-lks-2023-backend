<?php

namespace App\Helpers;

class Formatter
{
    public static function response($status, $message, $data = [])
    {
        return [
            'status'        => $status,
            'message'       => $message,
            'data'          => $data
        ];
    }
}
