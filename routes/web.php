<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\JADBudgetController;
use App\Http\Controllers\JADeveloppementController;
use App\Providers\RouteServiceProvider;

use App\Http\Middleware\JADBudgetAuthenticate;
use App\Models\User;

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
    Route::post('/JADBudget/addTransaction', [JADBudgetController::class, "addTransaction"]);
    Route::post('/JADBudget/deleteTransaction', [JADBudgetController::class, "deleteTransaction"]);
    Route::post('/JADBudget/updateUserInfos', [JADBudgetController::class, "updateUserInfos"]);
});

Route::get('/JADBudget', [JADBudgetController::class, "index"]);
Route::get('/JADBudget/disconnect', [JADBudgetController::class, "disconnect"]);
Route::post('/JADBudget/login', [JADBudgetController::class, "login"])->middleware('throttle:login_attempts');
Route::post('/JADBudget/signin', [JADBudgetController::class, "signin"])->middleware('throttle:signin_attempts');

// JADBudgetV2
Route::get('/JADBudgetV2', function(){
    return view('JADBudgetV2.index');
});

Route::post('/JADBudgetV2/loginV2', function(Request $r){
    if (Auth::attempt(["name" => $r->login, "password" => $r->password]))
        return response()->json([
            "action" => "login"
        ], 200);
    else return response()->json([], 401);
});

Route::get('/JADBudgetV2/dashboard', function(){
    if (!Auth::check()) return redirect('/JADBudgetV2');
    return view('JADBudgetV2.dashboard', [
        "username" => (User::where('id', Auth::id())->first())->name
    ]);
});

Route::post('/JADBudgetV2/getUserInfos', function(){
    $user = Auth::user();
    return response()->json([
        "login" => $user->name,
        "email" => $user->email
    ], 200);
});

Route::post('/JADBudgetV2/signinV2', function(Request $r){
    return response()->json([
        "login" => $login,
        "email" => $r->email,
        "password" => $r->password,
        "action" => "signin"
    ], 200);
});