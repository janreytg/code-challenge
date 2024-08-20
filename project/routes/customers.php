<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\CustomerController::class)->group(function () {
    Route::get('customers/', 'index')->name('customer.index');
    Route::get('customers/{customer}', 'show')->name('customer.show');
});
