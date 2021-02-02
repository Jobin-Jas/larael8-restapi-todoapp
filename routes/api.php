<?php

use App\Http\Controllers\BlogPostController;
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
    Route::get("task", [TodoController::class, 'task']);
    Route::post("addtask", [TodoController::class, 'addtask']);
    Route::put("update", [TodoController::class, 'update']);
    Route::delete("delete/{task_id}", [TodoController::class, 'delete']);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/login', [UserController::class, 'login'])->name('login');


Route::group([
    'prefix' => 'blog-posts'
], function () {
    Route::get('/', [BlogPostController::class, 'index']);
    Route::post('/', [BlogPostController::class, 'store']);
    Route::get('/{blogPost}', [BlogPostController::class, 'show']);
    Route::put('/{blogPost}', [BlogPostController::class, 'update']);
    Route::delete('/{blogPost}', [BlogPostController::class, 'destroy']);
});

// Route::group([
//     'middleware' => 'auth:api',
//     'prefix' => 'users'
// ], function () {
//     Route::get('/', [UserController::class, 'index']);
//     Route::post('/', [UserController::class, 'store']);
//     Route::get('/{user}', [UserController::class, 'show']);
//     Route::put('/{user}', [UserController::class, 'update']);
//     Route::delete('/{user}', [UserController::class, 'destroy']);
// });

/*
/api/shops => GET => list of shops
/api/users => GET => list of users
/api/users => POST => create new user
/api/shops => POST => create new shops
/api/shops/1 => GET => return shop with id 1
/api/shops/1 => PUT => update details for shop with id 1
/api/shops/1 => delete => delete shop with id 1
*/

// Route::group([
//     'middleware' => 'auth:api',
//     'prefix' => 'shops'
// ], function () {
//     Route::get('/', [ShopController::class, 'index']);
//     Route::post('/', [ShopController::class, 'store']);
//     Route::get('/{shop}', [ShopController::class, 'show']);
//     Route::put('/{shop}', [ShopController::class, 'update']);
//     Route::delete('/{shop}', [ShopController::class, 'destroy']);
// });


