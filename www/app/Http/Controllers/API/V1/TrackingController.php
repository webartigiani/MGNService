<?php
/**
 * TrackingController
 * controller presenze
 */
namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\API\V1\WorkerController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\TrackingSessionController;
use DB;
use DateTime;
use Illuminate\Pagination\Paginator;
use \Illuminate\Pagination\LengthAwarePaginator;

class TrackingController extends BaseController
{
    private $utils;
    private $TSC;
// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UtilsController $utilsController, TrackingSessionController $trackinSessionController)
    {
        $this->utils = $utilsController;
        $this->TSC = $trackinSessionController;
    }
// #endregion Constructor

// #region API Methods
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startDate = null;
        $endDate = null;
        $status = -1;
        $search = '';
        $context = '';
        $orderBy = 'session_status desc, start_date_time desc';

        $params = $request->all();

        $startDate = new DateTime($params['date_start']);
        $endDate = new DateTime($params['date_end']);
        if (isset($params['status'])) $status = intval(trim(strtolower($params['status'])));    // status
        if (isset($params['query'])) $search = trim(strtolower($params['query']));              // search query
        if (isset($params['orderby'])) $orderBy = trim(strtolower($params['orderby']));         // order by

        // pagination
        $perPage = $request->input("per_page", 50);         // 50 records per page
        $page = $request->input("page", 1);                 // page number
        if($page < 1) { $page = 1; }
        $skip = ($page - 1) * $perPage;                     // records to skip
        if($skip < 0) { $skip = 0; }

        // generates SQL query for pagination
        $sql = $this->baseQuery($startDate, $endDate, $status, $search, $orderBy);

        // TEMP: to export full SQL query
        //die($sql);

        // checks if we have working days in selected period...
        if ($sql == '') {
            // no working day selected
            $result_p = new LengthAwarePaginator([], 0, $perPage, 0);
            return $this->sendResponse($result_p, 'Empty Tracking-Sessions List');
        }

        // if we have days to export
        $dbdata = DB::select(DB::raw($sql));

        /** To paginate RAW Data for LaravelPaginator
         * *****************************************
         * - turn array into a collection
         * - count records
         * - skip records to skip
         * - take records to take
         * - gets all
         * - get a paginator by LengthAwarePaginator
         */
        $dbdata = collect($dbdata);
        $totalCount = $dbdata->count();
        $results = $dbdata
            ->skip($skip)
            ->take($perPage)
            ->all();
        $results = array_values($results);              // IMPORTANT: makes sure array doesn't have keys (from 2nd page)
        $result_p = new LengthAwarePaginator($results, $totalCount, $perPage, $page);
        return $this->sendResponse($result_p, 'Tracking Sessions List');
    }

    /**
     * Inserts/Updates an abscence
     *
     * @param  App\Http\Requests\Notes\NoteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   // NOTE: there's no store here
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   // NOTES: there's no show

        $sessionID = '';

        $tableName = 'tracking_sessions';
        $data = DB::table($tableName)->where('id', $id)->take(1)->get();
        if (isset($data)) {
            if (isset($data[0])) {
                $data = $data[0];
                $sessionID = $data->session_id;
            }
        }

        // Depending on Map Provider
        $columns = 'latitude, longitude';
        if (trim(strtolower(env("MIX_MAP_PROVIDER"))) == 'mapbox') {
            // mapBox (mapbox.com) requires latitude and longitude inverted
            $columns = 'longitude, latitude';
        }

        if ($sessionID != '') {
            $sql = "select
                        /* replace to change a single JSON object into
                            an array ready to be used by openstreetmap */
                        replace(replace(replace(replace(json_data, '\"', ''), ':', ','), '{', '['), '}', ']') latlngs
                    from
                        (
                            select
                                /*
                                    selects as json object
                                */
                                JSON_ARRAYAGG(JSON_OBJECT({$columns})) as json_data
                            from tracking_data
                            where
                                session_id = '{$sessionID}'
                            order by id
                    )
                results";
            $dbdata = DB::select(DB::raw($sql));
            if (!isset($dbdata[0]->latlngs)) return $this->sendError('Dati tragitto non trovati', [], 403);

            $latlngs = json_decode($dbdata[0]->latlngs);    // extracts lat-lng array data
            $first = $latlngs[0];                           // get the 1st and the last position
            $last = $latlngs[count($latlngs) - 1];

            // extracts also tracking_session data
            $sql = $this->baseQuery(new DateTime('2000-01-01'), new DateTime(date("Y-m-d")), -1,'', 'id desc');
            $sql = "select * from
                        (
                            {$sql}
                        ) tbl
                    where
                        session_id = '{$sessionID}'
                    limit 1";

            $dbdata = DB::select(DB::raw($sql));

            $result = new \stdClass();                      // creates an output object
            $result->session = $dbdata[0];                  // adds session data
            $result->start = $first;
            $result->end = $last;
            $result->latlngs = $latlngs;

            return $this->sendResponse($result, 'Tracking Data ' . $sessionID);
        } else {
            // session not found
            return $this->sendError('Tragitto non trovato', [], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   // NOTES: there's no update. just store
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   // NOTE: there's no delete: we stop tracking session

        $id = trim(strtolower($id));

        if ($this->TSC->endSession($id)) {
            return $this->sendResponse('OK', 'endSession ' . $id);
        } else {
            return $this->sendError('Si è verificato un errore durante il tentativo di interruzione del tragitto. Prego, riprovare.', [], 403);
        }
    }
// #endregion API Methods


// #region Public Methods
// #endregion Public Methods

// #region Private Methods
    /*
     * Normalizes worker data
     */
    private function normalizeData($data) {
        return $data;
    }

    private function baseQuery($startDate, $endDate, $status, $searchQuery, $orderBy) {

        $sql = "select * from
                (
                    select
                        /* calculates the status of the current tracking_session: 1 if still running; 0 if terminated */
                        case
                            when (ts.end_date_time is NULL) then 1
                            else 0
                            end session_status,
                        /* get main session data */
                        ts.id, ts.session_id, ts.start_date_time, ts.end_date_time,
                        /* calculates timediff */
                        timediff(ts.end_date_time, ts.start_date_time) duration,
                        /* get worker data */
                        ts.worker worker_id, w.nome, w.cognome, w.stato worker_status,
                        /* get veichle data */
                        ts.veichle veichle_id, v.manufacter veichle_manufacter, v.model veichle_model, v.licence_plate veichle_licence_plate, v.status veichle_status,
                        /* get device data */
                        ts.device device_id, d.manufacter device_manufacter,
                        d.model device_model, d.platform device_platform, d.`version` device_version, d.`uuid` device_uuid, d.is_online device_online, d.app_version device_app_version
                    from tracking_sessions ts
                    inner join workers w
                        on ts.worker = w.id
                    inner join veichles v
                        on ts.veichle = v.id
                    inner join devices d
                        on ts.device = d.id
                ) results
                where
                    /* filters on dates */
                    start_date_time >= '{$startDate->format('Y-m-d')} 00:00:00'
                    and (
                        end_date_time <= '{$endDate->format('Y-m-d')} 23:59:59'
                        or end_date_time is null
                    )";
                if ($status >= 0) $sql .= " and session_status = {$status}";
                if ($searchQuery != '') {
                    $sql .= " and (
                        /*
                            do search...
                        */
                        nome like '%" . $searchQuery . "%'
                        or cognome like '%" . $searchQuery . "%'
                        or veichle_manufacter like '%" . $searchQuery . "%'
                        or veichle_model like '%" . $searchQuery . "%'
                        or veichle_licence_plate like '%" . $searchQuery . "%'
                        or device_manufacter like '%" . $searchQuery . "%'
                        or device_model like '%" . $searchQuery . "%'
                        or device_platform like '%" . $searchQuery . "%'
                        or device_uuid like '%" . $searchQuery . "%'
                    )";
                }
                $sql .= " order by {$orderBy}";
        return $sql;
    }
// #endregion Private Methods
}
