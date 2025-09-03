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
    return redirect('/JADBudget');
});

// JADBudgetV2
Route::view('/JADBudget', 'JADBudget.index');

Route::controller(JADBudgetController::class)->group(function(){
    Route::post('/JADBudget/signinV2', "signin")->middleware('throttle:signin_attempts');;
    Route::get('/JADBudget/disconnect', "disconnect");
    Route::get('/JADBudget/logout', "disconnect");
    Route::post('/JADBudget/login', "login")->middleware('throttle:login_attempts');
});

Route::middleware([JADBudgetAuthenticate::class])->group(function(){
    Route::controller(JADBudgetController::class)->group(function(){
        Route::get('/JADBudget/dashboard', 'dashboard');
        Route::post('/JADBudget/getUserInfos', 'getUserInfos');
        Route::post('/JADBudget/getLastConnectionTime', 'getLastConnectionTime');
        Route::post('/JADBudget/getTransactionsByType', 'getTransactionByType');
        Route::post('/JADBudget/deleteTransaction', [JADBudgetController::class, "deleteTransaction"]);
        Route::post('/JADBudget/addTransaction', [JADBudgetController::class, "addTransaction"]);
        Route::post('/JADBudget/updateUserInfos', [JADBudgetController::class, "updateUserInfos"]);
        Route::post('/JADBudget/updatePassword', [JADBudgetController::class, "updatePassword"]);
    });
});