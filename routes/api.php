<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\APIController;

use App\Http\Middleware\APIAuthenticate;

// API routes for the Android Application

Route::middleware([APIAuthenticate::class])->group(function(){
    Route::get('/login', [APIController::class, 'login'])->name('login');
    Route::get('/checkToken', [APIController::class, 'isTokenValid']);
    Route::get('/retrieveDatas', [APIController::class, 'retrieveDatas'])->name('retrieveDatas');
    Route::get('/exportDatas', [APIController::class, 'exportDatas'])->name('exportDatas');
    Route::get('/deleteTransaction', [APIController::class, 'deleteTransaction'])->name('deleteTransaction');
    Route::get('/addTransaction', [APIController::class, 'addTransaction'])->name('addTransaction');
});