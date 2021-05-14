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
use DB;

class ApiController extends Controller
{

//#region Workers
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
//#endregion Workers

//#region Veichles
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
//#endregion Veichles

//#region Devices
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
            "accuracy": "10"
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
    $data = DB::table('devices')->where('serial', $payload['serial'])->take(1)->get();
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
                'manufacter' => $payload['manufacter'],
                'model' => $payload['model'],
                'is_virtual' => $payload['is_virtual'],
                'serial' => $payload['serial'],
                'uuid' => $payload['uuid'],
                'is_online' => true,
                'connection_type' => $payload['connection_type'],
                'enabled' => true,
                'created_at' =>  \Carbon\Carbon::now(), # new \Datetime()
                'updated_at' => \Carbon\Carbon::now(),  # new \Datetime()
            )
        );
    }

    if ($thisID > 0) {
        // updates device online status
        $ret = DB::table('devices')
        ->where('id', $thisID)
        ->update(
            array(
                'is_online' => true,
                'last_position' =>  \Carbon\Carbon::now(), # new \Datetime()
                'updated_at' => \Carbon\Carbon::now(),  # new \Datetime()
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
                    'last_position' =>  \Carbon\Carbon::now(), # new \Datetime()
                    'updated_at' => \Carbon\Carbon::now()  # new \Datetime()
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
//#endregion Devices

//#region Response/Utils

    public function ping() {
        return $this->sendResponse('OK', time());
    }
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

    private function routeAPP(Request $request) {
        return ($request->bearerToken() == env('IONIC_APP_TOKEN'));
    }
    private function redicretHome() {
        return redirect('home');
    }
//#endregion Response/Utils
}
