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

// Download Dumps route
Route::get('/download-dump/', function() {
    $f = request('f');
    $path = public_path() . "/dumps/";
    return response()->download($path . $f);
});

/**
 * IonicAPP API
 * require
 *      Authorization:Bearer env('IONIC_APP_TOKEN')
 */
Route::group([
    'middleware' => ['api', 'cors'],
    'namespace' => 'App\\Http\\Controllers\\API\\APP'
], function ($router) {continueTracking
    Route::get('app/update/', 'ApiController@autoUpdate');                                          // returns AppUpdate XML
    Route::get('api/app/ping/', 'ApiController@ping');                                              // APP/API Routes
    Route::get('api/app/workers/list/', 'ApiController@listWorkers');
    Route::get('api/app/veichles/list/', 'ApiController@listVeichles');
    Route::post('api/app/devices/add/', 'ApiController@registerDevice');
    Route::post('api/app/workers/startTrackingSession', 'ApiController@startTrackingSession');      // tracking-session management
    Route::post('api/app/workers/continueTracking', 'ApiController@continueTracking');
    Route::post('api/app/workers/stopTrackingSession', 'ApiController@stopTrackingSession');
    Route::get('api/app/backup/tracking', 'ApiController@backupTracking');                         // Backup/Dumps API

    // WebSite Called APIs
    Route::post('api/website/workers/timbra', 'ApiController@timbra');
    Route::get('api/ws/workers/list/', 'ApiController@listWorkersWS');
});

Auth::routes(['verify' => true]);
Route::get('home', function () { return redirect('/dashboard'); });

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
