<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\ProcessVideo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/job', function () {
    foreach(range(1, 100) as $i) {
        ProcessVideo::dispatch();
    }

    return view('welcome');
});

Route::get('/form', function () {
    return view('form');
});

Route::get('/', [App\Http\Controllers\VideoController::class, 'index']);
Route::get('/uploader', [App\Http\Controllers\VideoController::class, 'uploader']);
Route::post('/upload', [App\Http\Controllers\VideoController::class, 'store']);

// use laracasts queues tutorial
// create ProcessLowResVideo, ProcessRegularResVideo, ProcessHighResVideo - give priority to regular, high res video
