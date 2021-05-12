<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * IonicAPP API
 * require
 *      Authorization:Bearer env('IONIC_APP_TOKEN')
 */
Route::namespace('App\\Http\\Controllers\\API\\APP')->group(function () {
    Route::get('api/app/workers/list/', 'ApiController@listWorkers');
    Route::get('api/app/veichles/list/', 'ApiController@listVeichles');
    Route::post('api/app/devices/add/', 'ApiController@registerDevice');
});



Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('home', function () {
    return redirect('/dashboard');
});

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
