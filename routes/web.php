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

// JADBudget
Route::middleware([JADBudgetAuthenticate::class])->group(function(){
    Route::get('/JADBudget/dashboard', [JADBudgetController::class, "dashboard"]);
    Route::get('/JADBudget/profile', [JADBudgetController::class, "profile"]);
    Route::post('/JADBudget/getUserInfos', [JADBudgetController::class, "getUserInfos"]);
    Route::post('/JADBudget/getTransactions', [JADBudgetController::class, "getTransactions"]);
});

Route::get('/JADBudget', [JADBudgetController::class, "index"]);
Route::get('/JADBudget/disconnect', [JADBudgetController::class, "disconnect"]);
Route::post('/JADBudget/login', [JADBudgetController::class, "login"])->middleware('throttle:login_attempts');
Route::post('/JADBudget/signin', [JADBudgetController::class, "signin"])->middleware('throttle:signin_attempts');

// JADBudgetV2
Route::view('/JADBudgetV2', 'JADBudgetV2.index');

Route::controller(JADBudgetController::class)->group(function(){
    Route::post('/JADBudgetV2/loginV2', "index");
    Route::post('/JADBudgetV2/signinV2', "signin");
    Route::get('/JADBudgetV2/disconnect', "disconnect");
    Route::get('/JADBudgetV2/logout', "disconnect");
});

Route::middleware([JADBudgetAuthenticate::class])->group(function(){
    Route::controller(JADBudgetController::class)->group(function(){
        Route::get('/JADBudgetV2/dashboard', 'dashboard');
        Route::post('/JADBudgetV2/getUserInfos', 'getUserInfos');
        Route::post('/JADBudgetV2/getTransactionsByType', 'getTransactionByType');
        Route::post('/JADBudget/deleteTransaction', [JADBudgetController::class, "deleteTransaction"]);
        Route::post('/JADBudget/addTransaction', [JADBudgetController::class, "addTransaction"]);
        Route::post('/JADBudgetV2/updateUserInfos', [JADBudgetController::class, "updateUserInfos"]);
    });
});