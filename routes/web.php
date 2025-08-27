<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\JADBudgetController;
use App\Http\Controllers\JADeveloppementController;
use App\Providers\RouteServiceProvider;

use App\Http\Middleware\JADBudgetAuthenticate;
use App\Models\User;
use App\Http\Requests\SigninRequest;

// JADeveloppemet 

// GET routes
Route::get('/', function(){
    return redirect('/JADBudgetV2');
});

// JADBudgetV2
Route::view('/JADBudgetV2', 'JADBudgetV2.index');

Route::controller(JADBudgetController::class)->group(function(){
    Route::post('/JADBudgetV2/signinV2', "signin")->middleware('throttle:signin_attempts');;
    Route::get('/JADBudgetV2/disconnect', "disconnect");
    Route::get('/JADBudgetV2/logout', "disconnect");
    Route::post('/JADBudget/login', "login")->middleware('throttle:login_attempts');
});

Route::middleware([JADBudgetAuthenticate::class])->group(function(){
    Route::controller(JADBudgetController::class)->group(function(){
        Route::get('/JADBudgetV2/dashboard', 'dashboard');
        Route::post('/JADBudgetV2/getUserInfos', 'getUserInfos');
        Route::post('/JADBudgetV2/getLastConnectionTime', 'getLastConnectionTime');
        Route::post('/JADBudgetV2/getTransactionsByType', 'getTransactionByType');
        Route::post('/JADBudget/deleteTransaction', [JADBudgetController::class, "deleteTransaction"]);
        Route::post('/JADBudget/addTransaction', [JADBudgetController::class, "addTransaction"]);
        Route::post('/JADBudgetV2/updateUserInfos', [JADBudgetController::class, "updateUserInfos"]);
        Route::post('/JADBudgetV2/updatePassword', [JADBudgetController::class, "updatePassword"]);
    });
});