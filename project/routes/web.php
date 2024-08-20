<?php

use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    function () {
        return response()->json(
            [
                'name' => 'Customer API',
                'environment' => config('app.env'),
                'serverTime' => date('Y-m-d H:i:s'),
                'timezone' => config('app.timezone')
            ]
        );
    }
);
