<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});

Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
    Route::get('profile', 'ProfileController@profile');
    Route::put('profile', 'ProfileController@updateProfile');
    Route::post('change-password', 'ProfileController@changePassword');

    Route::apiResources([
        'user' => 'UserController',
        'worker' => 'WorkerController',
        'timbrata' => 'TimbrataController',
        'veicolo' => 'VeicoloController',
        'device' => 'DeviceController',
        'attendance' => 'AttendanceController',
        'abscence' => 'AbsenceController'
    ]);
    Route::get('workers/export', 'WorkerController@export');                    // export worker as CSV
    Route::get('workers/counters', 'WorkerController@getCounters');             // contatori dipendenti
    Route::get('workers/atwork', 'WorkerController@listAtWork');                // dipendenti presenti
    Route::get('workers/notatwork', 'WorkerController@listNotAtWork');          // dipendenti non presenti
    Route::get('veichles/counters', 'VeicoloController@getCounters');           // contatori dipendenti
    Route::get('veichles/inuse', 'VeicoloController@listInUse');                // veicoli in uso
    Route::get('attendances/giustificativi', 'AttendanceController@listGiustificativi');    // lists giustificativi
    Route::get('attendances/export', 'AttendanceController@export');            // export attendances as CSV
    Route::get('attendances/export-xml', 'AttendanceController@exportXML');     // export attendances as XML
});
