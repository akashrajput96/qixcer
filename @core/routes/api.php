<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ServiceController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'v1'],function(){
    Route::get('/country',[UserController::class,'country']);
    Route::get('country/service-city/{id}',[UserController::class,'serviceCity']);
    Route::get('country/service-city/service-area/{country_id}/{city_id}',[UserController::class,'serviceArea']);
    Route::post('/register',[UserController::class,'register']);
    Route::post('/login',[UserController::class,'login']);
    Route::post('/send-otp-in-mail',[UserController::class,'sendOTP']);
    Route::post('/reset-password',[UserController::class,'resetPassword']);

    Route::group(['prefix' => 'user/','middleware' => 'auth:sanctum'],function (){
        Route::post('logout',[UserController::class,'logout']);
        Route::get('profile',[UserController::class,'profile']);
        Route::post('change-password',[UserController::class,'changePassword']);
        Route::post('update-profile',[UserController::class,'updateProfile']);
        Route::post('/add-service-rating/{id}',[ServiceController::class,'serviceRating']);
    });

    // Home page
    Route::get('/slider',[SliderController::class,'slider']);
    Route::get('/category',[CategoryController::class,'category']);

    Route::get('/top-services',[ServiceController::class,'topService']);
    Route::get('/latest-services',[ServiceController::class,'latestService']);
    Route::get('/service-details/{id}',[ServiceController::class,'serviceDetails']);

});
