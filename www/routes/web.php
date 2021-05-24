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

use App\Http\Controllers\Api\APP\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

/**
 * IonicAPP API
 * require
 *      Authorization:Bearer env('IONIC_APP_TOKEN')
 */
Route::group([
    'middleware' => ['api', 'cors'],
    'namespace' => 'App\\Http\\Controllers\\API\\APP'
], function ($router) {
    Route::get('app/update/', 'ApiController@autoUpdate');
    Route::get('api/app/ping/', 'ApiController@ping');
    Route::get('api/app/workers/list/', 'ApiController@listWorkers');
    Route::get('api/app/veichles/list/', 'ApiController@listVeichles');
    Route::post('api/app/devices/add/', 'ApiController@registerDevice');
    Route::post('api/app/workers/startTrackingSession', 'ApiController@startTrackingSession');      // tracking-session management
    Route::post('api/app/workers/continueTracking', 'ApiController@continueTracking');
    Route::post('api/app/workers/stopTrackingSession', 'ApiController@stopTrackingSession');
});

Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('home', function () {
    return redirect('/dashboard');
});

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
