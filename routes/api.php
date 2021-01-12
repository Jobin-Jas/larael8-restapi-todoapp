<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::get("task", [TodoController::class,'task']);
    Route::post("addtask", [TodoController::class,'addtask']);
    Route::put("update/{task_id}", [TodoController::class,'update']);
    Route::delete("delete/{task_id}", [TodoController::class,'delete']); 
});
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::get('/login',[UserController::class,'login'])->name('login');


