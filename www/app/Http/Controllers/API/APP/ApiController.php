<?php
/**
 * IonicAPP API
 * Http/Controllers/API/APP
 * require
 *      Authorization:Bearer env('IONIC_APP_TOKEN')
 */
namespace App\Http\Controllers\Api\APP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use DB;

use App\Http\Controllers\API\V1\WorkerController;
use App\Http\Controllers\API\V1\AttendanceController;
use App\Http\Controllers\TrackingSessionController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\DumpController;


class ApiController extends Controller
{
    private $utils;
    private $TSC;
    private $workerController;
    private $attendanceController;
    private $dumpController;
    protected $url;

// #region Contructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TrackingSessionController $tsc, UtilsController $utils,
        UrlGenerator $url, WorkerController $workerController, AttendanceController $attendanceController,
        DumpController $dump)
    {
        $this->TSC = $tsc;
        $this->utils = $utils;
        $this->url = $url;
        $this->workerController = $workerController;
        $this->attendanceController = $attendanceController;
        $this->dumpController = $dump;
    }
// #endregion Contructor

// #region App Update
public function autoUpdate(Request $request) {
    /**
     * autoUpdate
     * GET  app/update/
     * returns XML for AppUpdate APP plugin
     */
    $deviceUUID = $request->d;          //  gets device UUID from query-string

    $appName =      env('APP_NAME');
    $dummy =        explode('.', trim(strtolower(env('APP_VERSION'))));
    $appUrl =       $this->url->to('/downloads/' . env('APP_URI'));

    /* for Debug
        UUID 27a53d7ce75ba7e7 is my Dogee N20
        We want to force download of dummy APP version 9.9.9

        if ($deviceUUID == '27a53d7ce75ba7e7') {
            $dummy = explode('.', trim(strtolower('9.9.9')));
        }
    */

    // converts version number from x.y.z format into x0y0z
    $appVersion = $dummy[0] . '0' . $dummy[1] . '0' . $dummy[2];
    ?>
<update>
<version><?= $appVersion ?></version>
<name><?= $appName ?></name>
<url><?= $appUrl ?></url>
</update><?php
}
// #endregion App Update

// #region Utils
    public function ping() {
        return $this->sendResponse('OK', time());
    }
// #endregion Utils

// #region Tracking Methods
    public function startTrackingSession(Request $request)
    {/* startTrackingSession
        login worker with veichle and device and starts a tracking session

        POST: api/app/workers/startTrackingSession

        RESPONSE:
        {
            "success": true,
            "data": "OK",
            "message": "20210518140719-1-1-2"
        }
        */
        // validates APP authorization
        if (!$this->routeAPP($request)) return $this->redicretHome();
        $payload = $request->json()->all();         // gets payload

        // #region Validations
        // 1. checks veichle:   must have
        //                      - enabled=true
        //                      - status=0
        $veichle = DB::table('veichles')->where('id', $payload['veichle']['id'])->where('enabled', true)->where('status', 0)->whereNull('deleted_at')->take(1)->get();
        if (isset($veichle)) {
            if ($veichle->count() < 1) return $this->sendError('Veicolo in uso o non abilitato', ['Il veicolo selezionato è in uso o non è abilitato.'], 403);
            $veichle = $veichle[0];
        } else {
            return $this->sendError('Veicolo in uso o non abilitato', ['Il veicolo selezionato è in uso o non è abilitato.'], 403);
        }

        // 2. checks if device is enabled
        $device = DB::table('devices')->where('uuid', $payload['device']['uuid'])->where('enabled', true)->whereNull('deleted_at')->take(1)->get();
        if (isset($device)) {
            if ($device->count() < 1) return $this->sendError('Dispositivo non abilitato', ['Il dispositivo non è abilitato.'], 403);
            $device = $device[0];
        } else {
            return $this->sendError('Dispositivo non abilitato', ['Il dispositivo non è abilitato.'], 403);
        }

        // 3. checks worker's password
        $worker = DB::table('workers')->where('id', $payload['worker']['id'])->where('password_timbratura', $payload['password'])->take(1)->get();
        if (isset($worker)) {
            if ($worker->count() < 1) return $this->sendError('Codice non corretto', ['Codice timbratura non valido.'], 403);
        } else {
            return $this->sendError('Password non valida', ['Codice timbratura non valido.'], 403);
        }

        // 4. checks worker:    must have
        //                      - modo_timbratura: 0|1
        //                      - data_cessazione: null
        $worker = DB::table('workers')->where('id', $payload['worker']['id'])->where('modo_timbratura', '<=', 1)->whereNull('data_cessazione')->whereNull('deleted_at')->take(1)->get();
        if (isset($worker)) {
            if ($worker->count() < 1) return $this->sendError('Operatore impegnato', ['L\'operatore selezionato risulta essere impegnato o non abilitato alla timbratura in mobilità'], 403);
            $worker = $worker[0];
        } else {
            return $this->sendError('Operatore impegnato', ['L\'operatore selezionato risulta essere impegnato o non abilitato alla timbratura in mobilità.'], 403);
        }

        // 5. re-checks worker: must have
        //                      - stato: 1
        $worker = DB::table('workers')->where('id', $payload['worker']['id'])->where('stato', 1)->take(1)->get();
        if (isset($worker)) {
            if ($worker->count() < 1) return $this->sendError('Timbrata mancante', ['Prima di avviare il veicolo devi timbrare l\'entrata.'], 403);
            $worker = $worker[0];
        } else {
            return $this->sendError('Timbrata mancante', ['Prima di avviare il veicolo devi timbrare l\'entrata.'], 403);
        }
        // #endregion Validations

        // converts GPS data into an object
        $gpsData = (object) $payload['gps'];

        // updates worker status
        $err = '';

        $sessionID = $this->TSC->startNew($worker, $payload['password'], $veichle, $device, $gpsData, $err);
        if ($sessionID != '') {
            return $this->sendResponse('OK', $sessionID);
        } else {
            // errore durante l'avvio della sessione di tracking
            return $this->sendError('Errore interno', ['Si è verificato un errore durante l\'avvio della sessione. Errore: ' . $err], 403);
        }
    }

    public function continueTracking(Request $request) {
        /**
         * Continues tracking user on veichle
         */

        if (!$this->routeAPP($request)) return $this->redicretHome();

        $payload = $request->json()->all();         // gets payload

        $sessionID = $payload['session_id'];                    // sessionID
        $navigationStatus = $payload['navigation_status'];      // nagigation_status
        $gpsData = (object) $payload['gps'];                    // GPS data

        // checks if tracking-session exists and it's opened
        if ($this->TSC->sessionExists($sessionID)) {
            if ($this->TSC->isSessionOpen($sessionID)) {
                if ($this->TSC->track($sessionID, $gpsData, $navigationStatus)) {
                    // tracking data saved
                    return $this->sendResponse('OK', time());
                } else {
                    // error inserting tracking data
                    // TODO ?
                }
            } else {
                // tracking session is closed: returns 404 error
                return $this->sendError('Sessione terminata', ['La sessione di navigazione risulta già terminata'], 404);
            }
        } else {
            // tracking session doesn't exists
            return $this->sendError('Sessione non trovata', ['Sessione di navigazione non trovata'], 403);
        }
    }

    public function stopTrackingSession(Request $request) {
        /**
         * Stops tracking a veichle
         */

        if (!$this->routeAPP($request)) return $this->redicretHome();

        $payload = $request->json()->all();         // gets payload

        $sessionID = $payload['session_id'];        // sessionID

        // checks if tracking-session exists and it's opened
        if ($this->TSC->sessionExists($sessionID)) {
            if ($this->TSC->isSessionOpen($sessionID)) {

                if ($this->TSC->endSession($sessionID)) {
                    // tracking data saved
                    return $this->sendResponse('OK', time());
                } else {
                    // error updating tracking data
                    // TODO ?
                }
            } else {
                // tracking session is closed
                return $this->sendError('Sessione terminata', ['La sessione di navigazione risulta già terminata'], 403);
            }
        } else {
            // tracking session doesn't exists
            return $this->sendError('Sessione non trovata', ['Sessione di navigazione non trovata'], 403);
        }
    }

    public function backupTracking(Request $request) {
        //$x = $this->dumpController->listDumps();
        //die(json_encode(($x)));

        $res = $this->dumpController->dumpTracking();
        die("backup eseguito su {$res}");

        $data = DB::table('tracking_data')
                ->where('session_id', '=', $trackingSessionID)
                ->whereNull('osrm_done')
                ->orderBy('id', 'asc')
                ->limit(300)
                ->get();

        foreach($data as $r) {
            $url = "http://router.project-osrm.org/nearest/v1/driving/{$r->longitude},{$r->latitude}?number=1&radiuses={$radiuses}&generate_hints=true&hints={$lastHint}";

            $response = Http::accept('application/json')->get($url);
            $result = $response->json();

            $code = strtoupper($result['code']);

            if ($code == 'OK') {
                $lastHint = $result['waypoints'][0]['hint'];
                $new_latitude = $result['waypoints'][0]['location'][1];
                $new_longitude = $result['waypoints'][0]['location'][0];
                $distance = $result['waypoints'][0]['distance'];

                // response
                echo "OK OSRM Nearest API (id {$r->id}): OLD COORDS: {$r->latitude}, {$r->longitude}; NEW COORDS: {$new_latitude}, {$new_longitude}<br>";

                // updates data
                DB::table('tracking_data')
                    ->where('id', $r->id)
                    ->update(
                        array(
                            'osrm_prev_latitude' => $r->latitude,
                            'osrm_prev_longitude' => $r->longitude,
                            'latitude' => $new_latitude,
                            'longitude' => $new_longitude,
                            'osrm_distance' => $distance,
                            'osrm_done' => true,
                            'updated_at' => DB::raw('NOW()')
                        )
                    );

            } else {
                // errore
                echo "Errore OSRM Nearest API (id {$r->id}): ERROR '{$code}', URL: {$url}<br>";
            }
        }
    }

    public function AdjustPoints() {
        //  1       160ms
        //  10      4.60"
        //  50      24.60"
        // 100      49.70"
        // 300      2' 29.70"
        /*

        // settings
        $radiuses = 50;         // (INT) raggio, in metri, per rilevare il punto più vicino
        $lastHint = '';         // last hint from each response

        foreach($data as $r){
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "http://router.project-osrm.org/nearest/v1/driving/{$r->longitude},{$r->latitude}?number=1&radiuses={$radiuses}&generate_hints=true&hints={$lastHint}",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            $result = json_decode($response);

            if ($result->code == 'Ok') {
                $lastHint = $result->waypoints[0]->hint;
                $new_latitude = $result->waypoints[0]->location[1];
                $new_longitude = $result->waypoints[0]->location[0];
                $distance = $result->waypoints[0]->distance;

                $sql = "update tracking_data set
                    osrm_prev_latitude = {$r->latitude},
                    osrm_prev_longitude = {$r->longitude},
                    latitude = {$new_latitude},
                    longitude = {$new_longitude},
                    osrm_distance = {$distance},
                    osrm_done = 1
                where id = {$r->id}";
                DB::update($sql);

                echo "OK {$r->id}<br>';
            } else {
                echo 'cazzo cazzo!<br>';
                exit();
            }
            curl_close($curl);
        }
        */
    }
// #endregion Tracking methods

// #region Workers
    public function timbra(Request $request) {

        $data = $request->json()->all();         // gets payload

        $workerID = $data['worker']['id'];
        $codice_timbrata = $data['codice_timbrata'];
        $error = '';

        $tID =  $this->workerController->timbra($workerID, $codice_timbrata, $error);

        if ($tID > 0) {
            $dbdata = $this->attendanceController->get($tID);
            return $this->sendResponse($dbdata, 'Timbrata Creata');
        } else {
            // timbrata fallita
            return $this->sendErrorLight($error);
        }
    }

    public function listWorkers(Request $request)
    {/* listWorkers
        list free, enabled workers

        GET api/app/workers/list/

        RESPONSE:
            {
                "success": true,
                "data": [
                    {
                        "id": 8,
                        "name": "ANNA",
                        "surname": "E. NACCAH"
                    },
                    ...
                ],
                "message": "Workers List"
            }
        */

        // validates APP authorization
        if (!$this->routeAPP($request)) return $this->redicretHome();
        $result = DB::table('app_v_workers')->get();
        return $this->sendResponse($result, 'Workers List');
    }
    public function listWorkersWS(Request $request)
    {/* listWorkersWS
        list free, enabled workers for website

        GET api/app/workers/list/

        RESPONSE:
            {
                "success": true,
                "data": [
                    {
                        "id": 8,
                        "name": "ANNA",
                        "surname": "E. NACCAH"
                    },
                    ...
                ],
                "message": "Workers List"
            }
        */
        $result = DB::table('website_v_workers')->get();
        return $this->sendResponse($result, 'Workers List');
    }
// #endregion Workers

// #region Veichles
    public function listVeichles(Request $request)
    {/* listVeichles
        lists free, enabled veichles

        GET api/app/veichles/list/

        RESPONSE:
            {
                "success": true,
                "data": [
                    {
                        "id": 1,
                        "manufacter": "Citroen",
                        "model": "C3",
                        "licence_plate": "XX123XX"
                    },
                    ...
                ],
                "message": "Veichles List"
            }
        */

        // validates APP authorization
        if (!$this->routeAPP($request)) return $this->redicretHome();

        $result = DB::table('app_v_veichles')->get();
        return $this->sendResponse($result, 'Veichles List');
    }
// #endregion Veichles

// #region Devices
    public function registerDevice(Request $request)
    {/* registerDevice
        register/updates a device when APP starts

        POST api/app/devices/add

        REQUEST SAMPLE:
            {
                "platform": "Android",
                "version": "9.0.0",
                "manufacter": "Dogee",
                "model": "N20",
                "is_virtual": false,
                "serial": "20c8bef9-3f86-4ddc-a8c6-c496428a05b7",
                "uuid": "aae5ba8eed5a",
                "connection_type": "wifi",
                "latitude": "41.19317221073727",
                "longitude": "16.599785497829647",
                "accuracy": "10",
                "connection_type": "wifi",
                "app_version": "1.0.0"
            }

        RESPONSE:

            > case: dispositivo disabilitato (devices.enabled=0) dallo Staff
            > returns status 403
            {
                "success": false,
                "message": "Dispositivo disabilitato",
                "data": [
                    "Il tuo dispositivo non è abilitato ad eseguire le timbrature in mobilità. Contatta l'amministrazione."
                ]
            }

        */


        // validates APP authorization
        if (!$this->routeAPP($request)) return $this->redicretHome();

        $thisID = 0;                                // device.id
        $ret = 0;
        $ret2 = 0;
        $payload = $request->json()->all();         // gets payload

        // checks if device exists: and point to the 1st record
        $data = DB::table('devices')->where('uuid', $payload['uuid'])->take(1)->get();
        if (isset($data)) {
            if (count($data) == 0)
                $data = null;
            else
                $data = $data[0];
        }

        // if device exists, checks if it's enabled and gets its ID
        // if disabled: returns status 403
        if (isset($data)) {
            if (!$data->enabled)
                return $this->sendError('Dispositivo disabilitato', ['Il tuo dispositivo non è abilitato ad eseguire le timbrature in mobilità. Contatta l\'amministrazione.'], 403);
            else
                $thisID = $data->id;
        } else {
            // Device not exists: registers it and gets its ID
            $thisID = DB::table('devices')->insertGetId(
                array(
                    'platform' => $payload['platform'],
                    'version' => $payload['version'],
                    'manufacter' => ucwords($payload['manufacter']),
                    'model' => $payload['model'],
                    'is_virtual' => $payload['is_virtual'],
                    'serial' => $payload['serial'],
                    'uuid' => $payload['uuid'],
                    'is_online' => true,
                    'connection_type' => $payload['connection_type'],
                    'app_version' => $payload['app_version'],
                    'enabled' => true,
                    'created_at' =>  $this->utils->OraItaliana(),
                    'updated_at' => $this->utils->OraItaliana()
                )
            );
        }

        if ($thisID > 0) {
            // updates device online status
            $ret = DB::table('devices')
            ->where('id', $thisID)
            ->update(
                array(
                    'version' => $payload['version'],
                    'is_online' => true,
                    'connection_type' => $payload['connection_type'],
                    'app_version' => $payload['app_version'],
                    'last_position' =>  $this->utils->OraItaliana(),
                    'updated_at' => $this->utils->OraItaliana()
                )
            );

            // updates device geo-location: if we have a valid location
            if (($payload['latitude'] != '') && ($payload['longitude'] != '')) {
                // NOTE:    we do not check this update result
                //          because data could not be changed since previous insert
                $ret2 = DB::table('devices')
                ->where('id', $thisID)
                ->update(
                    array(
                        'is_online' => true,
                        'latitude' => $payload['latitude'],
                        'longitude' => $payload['longitude'],
                        'accuracy' => $payload['accuracy'],
                        'last_position' =>  $this->utils->OraItaliana(),
                        'updated_at' => $this->utils->OraItaliana()
                    )
                );
            }
        }

        // return
        if ($ret > 0) {
            // device insert/update OK: returns device data
            $data = DB::table('devices')->where('serial', $payload['serial'])->take(1)->get();
            return $this->sendResponse($data, 'Device');
        } else {
            // update/insert error: returns error  with status 500
            return $this->sendError('Errore di sistema', ['Si è verificato un errore durante l\'attivazione del tuo dispositivo. Contatta l\'amministrazione.'], 500);
        }
        //return $data;
    }
// #endregion Devices

// #region Response/Utils
    /**
     * Returns the specific result, by and additional message
     * Returns status 200
     *{
     *    "success": true,
     *    "data": [
     *        {
     *            "id": 1...
     *        },
     *        {
     *            "id": 2...
     *        }
     *    ],
     *    "message": "additional message"
     *}
     *
     * USAGE:
     *      $result = DB::table('veichles')->get();
     *      return $this->sendResponse($result, 'Veichles List');
     */
     public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * Returns an http error
     * with optional data and http-status (default:404)
     * {
     *  "success": false,
     *  "message": "codice errore",
     *  "data": [
     *    "dato 1",
     *    "dato 2"
     *  ]
     * }
     *
     * USAGE:
     *  return $this->sendError('codice errore', ['dato 1', 'dato 2'], 500);
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     *
     * @return \Illuminate\Http\Response
     */
    public function sendErrorLight($message)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    private function routeAPP(Request $request) {
        return ($request->bearerToken() == env('IONIC_APP_TOKEN'));
    }
    private function redicretHome() {
        return redirect('home');
    }
// #endregion Response/Utils
}
