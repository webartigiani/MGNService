<?php
/**
 * TrackingSessionController
 * provides methods to create, start, stop tracking sessions
 *
 * NOTE: TrackingSessionController functions, used to track devices via APP/API
 *          are invoked from Controllers/API/APP/ApiController
 */
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\UtilsController;
use DB;

class TrackingSessionController extends Controller
{
    private $utils;

//#region Contructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UtilsController $utils)
    {
        $this->utils = $utils;
    }
//#endregion Contructor

//#region Public Methods

    /**
     * Create new tracking session
     * for the specified worker with the specified veichle and device
     * at the specified GPS data
     *
     * Returns the new tracking-session-id
     */
    public function startNew($worker, $worker_password, $veichle, $device, $gpsData, &$errorMessage) {

        $errorMessage = '';
        $worker_password = strval($worker_password);

        // Checks worker: id, status, modo_timbratura (0|1), password, cessazione, deleted
        $sql = "select count(*) value from workers where id = {$worker->id} and password_timbratura like '%{$worker_password}' and stato = 1 and modo_timbratura <= 1 and data_cessazione is null and deleted_at is null";
        $data = DB::select($sql);
        $result = $data[0]->value;
        if ($result <> 1) {
            $errorMessage = 'Dipendente inesistente, occupato, non disponibile, o non abilitato al tipo di timbratura';
            return '';
        }

        // Checks veichle 1: id, status, enabled, deleted
        $sql = "select count(*) value from veichles where id = {$veichle->id} and enabled = 1 and deleted_at is null";
        $data = DB::select($sql);
        $result = $data[0]->value;
        if ($result <> 1) {
            $errorMessage = 'Veicolo inesistente, occupato o non disponibile';
            return '';
        }

        // Checks veichle 2: status
        $sql = "select count(*) value from veichles where id = {$veichle->id} and status = 0";
        $data = DB::select($sql);
        $result = $data[0]->value;
        if ($result <> 1) {
            $errorMessage = 'Veicolo occupato';
            return '';
        }

        // Checks device 1: id, status, enabled, deleted
        $sql = "select count(*) value from devices where uuid = '{$device->uuid}' and enabled = 1 and deleted_at is null";
        $data = DB::select($sql);
        $result = $data[0]->value;
        if ($result <> 1) {
            $errorMessage = 'Dispositivo non trovato o disabilitato';
            return '';
        }

        // Checks device 2: status
        $sql = "select count(*) value from devices where uuid = '{$device->uuid}' and status = 0";
        $data = DB::select($sql);
        $result = $data[0]->value;
        if ($result <> 1) {
            $errorMessage = 'Dispositivo occupato';
            return '';
        }

        // gets the device ID
        $sql = "select id from devices where uuid = '{$device->uuid}' limit 1";
        $data = DB::select($sql);
        $deviceID = $data[0]->id;

        // calculates the session-id
        //$sessionID = $this->utils->OraItaliana()->format('YmdHis') . '-' . $worker->id . '-' . $veichle->id . '-' . $deviceID;
        $sessionID = dechex(time()) . '-' . $worker->id . '-' . $veichle->id . '-' . $deviceID;

        // Creates the tracking-session
        $thisID = DB::table('tracking_sessions')->insertGetId(
            array(
                'session_id' => $sessionID,
                'device' => $deviceID,
                'worker' => $worker->id,
                'veichle' => $veichle->id,
                'start_date_time' => $this->utils->OraItaliana(),
                'created_at' =>  $this->utils->OraItaliana(),
                'updated_at' => $this->utils->OraItaliana()
            )
        );

        if ($thisID > 0) {
            DB::table('workers')
                ->where('id', $worker->id)
                ->update([
                    'tracking_session' => $sessionID,
                    'data_stato' => $this->utils->OraItaliana(),
                    'latitude' => $gpsData->latitude,
                    'longitude' => $gpsData->longitude,
                    'accuracy' => $gpsData->accuracy,
                    'last_position' => $this->utils->OraItaliana(),
                    'updated_at' => $this->utils->OraItaliana()
                ]
            );
            DB::table('veichles')
                ->where('id', $veichle->id)
                ->update([
                    'tracking_session' => $sessionID,
                    'device' => $deviceID,
                    'worker' => $worker->id,
                    'status' => 1,
                    'status_date' => $this->utils->OraItaliana(),
                    'updated_at' => $this->utils->OraItaliana()
                ]
            );
            DB::table('devices')
                ->where('id', $deviceID)
                ->update([
                    'connection_type' => $device->connection_type,
                    'tracking_session' => $sessionID,
                    'status' => 1,
                    'status_date' => $this->utils->OraItaliana(),
                    'latitude' => $gpsData->latitude,
                    'longitude' => $gpsData->longitude,
                    'accuracy' => $gpsData->accuracy,
                    'last_position' => $this->utils->OraItaliana(),
                    'updated_at' => $this->utils->OraItaliana()
                ]
            );

            // Creates the 1st tracking-data
            $this->track($sessionID, $gpsData, 'running');
            return $sessionID;

        } else {
            // error creating the tracking_sessions record
            $errorMessage = 'Errore inatteso';
            return '';
        }
    }

    // Adds GPS data to tracking session, and returns true if succedes
    public function track($trackingSessionID, $gpsData, $navigationStatus) {

        $trackingSessionID = trim(strtolower($trackingSessionID));
        $navigationStatus = trim(strtolower($navigationStatus));        // running, paused, background, etc...
        if ($trackingSessionID == '') return false;

        if ($this->sessionExists($trackingSessionID)) {
            if ($this->isSessionOpen($trackingSessionID)) {
                if (!$this->sessionHasData($trackingSessionID, $gpsData)) {

                    // tracking-session exists and it's opened
                    $thisID = DB::table('tracking_data')->insertGetId(
                        array(
                            'session_id' => $trackingSessionID,
                            'latitude' => $gpsData->latitude,
                            'longitude' => $gpsData->longitude,
                            'accuracy' => $gpsData->accuracy,
                            'distance' => $gpsData->distance,
                            'is_valid' => $gpsData->valid,
                            'gps_timestamp' => $gpsData->timestamp,
                            'navigation_status' => $navigationStatus,
                            'connection_status' => 1,
                            'created_at' =>  $this->utils->OraItaliana(),
                            'updated_at' => $this->utils->OraItaliana()
                        )
                    );

                    if ($thisID > 0) {
                        // insert ok: updates session
                        DB::table('tracking_sessions')
                            ->where('session_id', $trackingSessionID)
                            ->update([
                                'updated_at' => $this->utils->OraItaliana()
                            ]);

                        // updates device geo-location and last_position
                        $sql = "update devices set
                                is_online = 1,
                                latitude = '{$gpsData->latitude}',
                                longitude = '{$gpsData->longitude}',
                                accuracy = '{$gpsData->accuracy}',
                                last_position = '" . $this->utils->OraItaliana()->format('Y-m-d H:i:s') . "'
                            where
                                id in (select device from tracking_sessions where session_id = '{$trackingSessionID}')
                            limit 1
                        ";
                        DB::update($sql);

                        // updates worker geo-location and last_position
                        $sql = "update workers set
                                latitude = '{$gpsData->latitude}',
                                longitude = '{$gpsData->longitude}',
                                accuracy = '{$gpsData->accuracy}',
                                last_position = '" . $this->utils->OraItaliana()->format('Y-m-d H:i:s') . "'
                            where
                                id in (select worker from tracking_sessions where session_id = '{$trackingSessionID}')
                            limit 1
                        ";
                        DB::update($sql);

                        // updates veichle geo-location and last_position
                        $sql = "update veichles set
                                latitude = '{$gpsData->latitude}',
                                longitude = '{$gpsData->longitude}',
                                accuracy = '{$gpsData->accuracy}',
                                last_position = '" . $this->utils->OraItaliana()->format('Y-m-d H:i:s') . "'
                            where
                                id in (select veichle from tracking_sessions where session_id = '{$trackingSessionID}')
                            limit 1
                        ";
                        DB::update($sql);
                    }
                    return ($thisID > 0);
                } else {
                    // this point (gps_timestamp) is already saved
                    // we return true, without saving point
                    // NOTE: this scenario occurs when user unlock device after a display stand-by
                    return true;
                }
            } else {
                // tracking-session is closed
                return false;
            }
        } else {
            // tracking-session not exists
            return false;
        }
    }

    // Ends up the specified tracking-session, and returns true if succeeds
    public function endSession($trackingSessionID) {

        $trackingSessionID = trim(strtolower($trackingSessionID));
        if ($trackingSessionID == '') return false;

        if ($this->sessionExists($trackingSessionID)) {
            if ($this->isSessionOpen($trackingSessionID)) {
                // tracking-session exists and it's opened

                DB::table('tracking_sessions')
                ->where('session_id', $trackingSessionID)
                ->update([
                    'end_date_time' => $this->utils->OraItaliana(),
                    'updated_at' => $this->utils->OraItaliana()
                ]);

                // updates device geo-location and last_position
                $sql = "update devices set
                    status = 0,
                    status_date = '" . $this->utils->OraItaliana()->format('Y-m-d H:i:s') . "',
                    tracking_session = null,
                    latitude = null,
                    longitude = null,
                    accuracy = null,
                    last_position = null
                where
                    id in (select device from tracking_sessions where session_id = '{$trackingSessionID}')
                limit 1
                ";
                DB::update($sql);

                // updates worker geo-location and last_position
                $sql = "update workers set
                    data_stato = '" . $this->utils->OraItaliana()->format('Y-m-d H:i:s') . "',
                    tracking_session = null,
                    latitude = null,
                    longitude = null,
                    accuracy = null,
                    last_position = null
                where
                    id in (select worker from tracking_sessions where session_id = '{$trackingSessionID}')
                limit 1
                ";
                DB::update($sql);

                // updates veichle geo-location and last_position
                $sql = "update veichles set
                    status = 0,
                    device = 0,
                    worker = 0,
                    status_date = '" . $this->utils->OraItaliana()->format('Y-m-d H:i:s') . "',
                    tracking_session = null,
                    latitude = null,
                    longitude = null,
                    accuracy = null,
                    last_position = null
                where
                    id in (select veichle from tracking_sessions where session_id = '{$trackingSessionID}')
                limit 1
                ";
                DB::update($sql);

                return true;
            } else {
                // tracking-session is closed
                return false;
            }
        } else {
            // tracking-session not exists
            return false;
        }
    }

    // Ends up all the tracking sessions for the specified worker
    public function endUserSessions($workerID) {

        if ($workerID < 1) return;

        $openedSessions = DB::table('tracking_sessions')
            ->where('worker', $workerID)
            ->whereNull('end_date_time')->get();
        foreach($openedSessions as $session) {
            $this->endSession($session->session_id);
        }
    }

    // Returns true if the speciefied tracking-session-id exists
    public function sessionExists($trackingSessionID) {

        $trackingSessionID = trim(strtolower($trackingSessionID));
        if ($trackingSessionID == '') return false;

        $sql = "select count(*) value from tracking_sessions where session_id = '{$trackingSessionID}' limit 1";
        $data = DB::select($sql);
        $result = $data[0]->value;
        return ($result == 1);
    }

    // Returns true if the specified tracking-session is still opened (not terminated)
    public function isSessionOpen($trackingSessionID) {

        $trackingSessionID = trim(strtolower($trackingSessionID));
        if ($trackingSessionID == '') return false;

        $sql = "select count(*) value from tracking_sessions where session_id = '{$trackingSessionID}' and end_date_time is null limit 1";
        $data = DB::select($sql);
        $result = $data[0]->value;
        return ($result == 1);
    }

    // Returns true if we already got this point: based on the GPS timestamp
    public function sessionHasData($trackingSessionID, $gpsData) {

        $trackingSessionID = trim(strtolower($trackingSessionID));
        if ($trackingSessionID == '') return false;

        $sql = "select count(*) value from tracking_data where session_id = '{$trackingSessionID}' and gps_timestamp = '{$gpsData->timestamp}' limit 1";
        $data = DB::select($sql);
        $result = $data[0]->value;

        return ($result > 0);
    }
//#endregion Public Methods
}
