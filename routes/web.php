<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('emails.otp', [
        'firstName' => 'tejas',
        'otp' => '123456'
    ]);
});
