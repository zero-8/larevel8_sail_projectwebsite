<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\EarthRemindersController;
use App\Http\Controllers\UserDetailsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', LoginController::class);

Route::post('/logout', function (Request $request) {
    $time_start = microtime(true);
    auth()->guard('web')->logout();
    $request->session()->invalidate();
    $time_end = microtime(true);
    $timeend = $time_end - $time_start;

    return response()->json([
        'success' => true,
        '_elapsed_time' => $timeend,
    ], 200);
});


Route::post('/register', [RegisterController::class, 'register']);

// Route::group(['middleware' => 'auth:sanctum', 'throttle:1000,1'], function () {


Route::get('/msgoftheday', [App\Http\Controllers\MessageofthedayController::class, 'index']);

Route::post('/post/create', [PostController::class, 'create']);

Route::post('/post/get', [PostController::class, 'index']);

Route::post('/ckeditor', [PostController::class, 'ckeditor']);

Route::post('/post/datatable', [PostController::class, 'datatable']);
Route::post('/post/delete', [PostController::class, 'datatable_delete']);
Route::post('/post/update', [PostController::class, 'update']);
Route::post('/post/list', [PostController::class, 'show']);
Route::get('/post/list/{page}', [PostController::class, 'show_by_get']);
Route::post('/post/getbyslug', [PostController::class, 'show_by_slug']);
Route::get('/post/slug/{slug}', [PostController::class, 'index']);



Route::get('/blog/page/{page}/item/{perpage}', [BlogController::class, 'show']);
Route::post('/blog/create', [BlogController::class, 'create']);
Route::post('/blog/datatable', [BlogController::class, 'datatable']);
Route::delete('/blog/delete/{id}', [BlogController::class, 'delete']);
Route::post('/blog/update/{id}', [BlogController::class, 'update']);
Route::get('/blog/{slug}', [BlogController::class, 'index']);

Route::get('/news/page/{page}/item/{perpage}', [NewsController::class, 'show']);
Route::post('/news/create', [NewsController::class, 'create']);
Route::post('/news/datatable', [NewsController::class, 'datatable']);
Route::delete('/news/delete/{id}', [NewsController::class, 'delete']);
Route::post('/news/update/{id}', [NewsController::class, 'update']);
Route::get('/news/{slug}', [NewsController::class, 'index']);


Route::get('/quotes/page/{page}/item/{perpage}', [QuotesController::class, 'show']);
Route::post('/quotes/create', [QuotesController::class, 'create']);
Route::post('/quotes/datatable', [QuotesController::class, 'datatable']);
Route::delete('/quotes/delete/{id}', [QuotesController::class, 'delete']);
Route::post('/quotes/update/{id}', [QuotesController::class, 'update']);
Route::get('/quotes/{slug}', [QuotesController::class, 'index']);



Route::get('/er/page/{page}/item/{perpage}/date/{date}', [EarthRemindersController::class, 'show']);

Route::get('/er/page/{page}/item/{perpage}/month/{month}', [EarthRemindersController::class, 'show_month']);

Route::post('/er/create', [EarthRemindersController::class, 'create']);
Route::post('/er/datatable', [EarthRemindersController::class, 'datatable']);
Route::delete('/er/delete/{id}', [EarthRemindersController::class, 'delete']);
Route::post('/er/update/{id}', [EarthRemindersController::class, 'update']);
Route::get('/er/{slug}', [EarthRemindersController::class, 'index']);




Route::get('/user_details', [UserDetailsController::class, 'show']);

Route::get('/user_details/username/{username}', [UserDetailsController::class, 'show_username']);


Route::post('/user_details/create', [UserDetailsController::class, 'create']);
Route::post('/user_details/datatable', [UserDetailsController::class, 'datatable']);
Route::delete('/user_details/delete/{id}', [UserDetailsController::class, 'delete']);
Route::post('/user_details/update/{id}', [UserDetailsController::class, 'update']);
Route::get('/user_details/{slug}', [UserDetailsController::class, 'index']);
