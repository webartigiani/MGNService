<?php
/**
 * AttendanceController
 * controller presenze
 */
namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Attendance\AttendanceRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\api\V1\WorkerController;
use App\Http\Controllers\UtilsController;
use DB;
use DateTime;

class AttendanceController extends BaseController
{
    protected $attendance = '';
    private $workerController;
    private $utils;

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Attendance $attendance, WorkerController $workerController, UtilsController $utilsController)
    {
        $this->attendance = $attendance;
        $this->workerController = $workerController;
        $this->utils = $utilsController;
    }
// #endregion Constructor

// #region API Methods
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   /**
        * GET       api/attendance
        * params    {"show":true,"date_start":"2021-05-01","date_end":"2021-05-31","query":"filippo"}
        */

        /*
            Creates an inner SQL query to select all days in calendar between start/end date
            es:
                select '28/05/2021' as day_date, '2021-05-28' as ref_date
                union
                select '27/05/2021' as day_date, '2021-05-27' as ref_date
                ...
        */
        $params = $request->all();
        $s = new DateTime($params['date_start']);               // start date
        $e = new DateTime($params['date_end']);                 // end date
        $search = trim(strtolower($params['query']));           // search string
        $notatwork = $params['notatwork'];                      // notatwork

        $p = $this->utils->getPeriodDays($s, $e);       // get period

        //return $this->sendResponse($notatwork, 'CHECK');

        $innerSQL = '';
        $sql = '';

        // selected a period higher than just one day?
        if ($s != $e) {
            // loops through days in period
            // NOTE: period DOES NOT CONSIDER last day in interval
            foreach ($p as $dt) {
                $dow = $this->utils->getWeekday($dt);       // gets the day-of-week (sunday:0)
                if (($dow > 0) && ($dow < 6)) {
                    if ($innerSQL != '') $innerSQL .= "union\n";
                    $innerSQL .= "select '" . $dt->format("d/m/Y") . "' as day_date, ";
                    $innerSQL .= "'" . $dt->format("Y-m-d") . "' as ref_date\n";
                } else {
                    // Saturday or Sunday...
                }
            }
        } else {
            // just one day interval
        }

        // Add or Use last day
        if ($innerSQL != '') $innerSQL .= "union\n";
        $innerSQL .= "select '" . $e->format("d/m/Y") . "' as day_date, ";
        $innerSQL .= "'" . $e->format("Y-m-d") . "' as ref_date\n";

        // Creates the main SQL query
        $sql = "select *
                from (
                    select
                        IFNULL(att.id, 0) id, calendar.ref_date,
                        w.id worker_id, w.nome, w.cognome, w.codice_fiscale, w.matricola,
                        calendar.day_date,
                        att.entrance_date, att.entrance_ip,
                        att.exit_date, att.exit_ip,
                        IFNULL(att.duration_m, 0) duration_m,
                        IFNULL(att.duration_h, 0) duration_h,
                        IFNULL(att.duration_h_int, 0) duration_h_int,
                        IFNULL(att.chk, -1) chk
                    from
                    (
                        {$innerSQL}
                    ) calendar
                    cross join workers w
                    left outer join export_v_attendances att
                        on att.day_date = calendar.day_date
                        and att.worker_id = w.id
                ) presenze
            where
                1=1
                ";

            if ($notatwork == 'true') {
                //$sql .= " and (chk <= 0 or IFNULL(att.chk, -1) = -1)";   // show only not at work?
                $sql .= " and chk <= 0";   // show only not at work?
            }
            if ($search != '') {
                $sql .= " and (
                    nome like '%" . $search . "%'
                    or cognome like '%" . $search . "%'
                    or codice_fiscale like '%" . $search . "%'
                )";
            }
            $sql .= " order by ref_date, id";

            //return $this->sendResponse($sql, 'QUERY');

        $dbdata = DB::select(DB::raw($sql));
        return $this->sendResponse($dbdata, 'Attendances List');

        //$dbdata = $query->orderBy('day_date')->orderBy('worker_id')->paginate(50);
        //return $this->sendResponse($dbdata, 'Attendances List');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Attendance\AttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceRequest $request)
    {

        // inserts data
        /*
        $dbdata = $this->worker->create([
            'codice_azienda' => env('CODICE_AZIENDA'),
            'denominazione_azienda' => env('DENOMINAZIONE_AZIENDA'),
            'nome' => $data['nome'],
            'cognome' => $data['cognome'],
            'codice_fiscale' => $data['codice_fiscale'],
            'matricola' => $data['matricola'],
            'modo_timbratura' => $data['modo_timbratura'],
            'data_assunzione' => $data['data_assunzione'],
            'data_cessazione' => $data['data_cessazione']
        ]);
        return $this->sendResponse($dbdata, 'Nuova Timbrata Creata');
        */
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->attendance->findOrFail($id);
        return $this->sendResponse($data, 'Dettagli Presenza');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceRequest $request, $id)
    {
        $attendance = $this->attendance->findOrFail($id);

        // get form normalized data
        $data = $this->normalizeData($request->all());

        // Updates data
        $attendance->update($data);
        return $this->sendResponse($attendance, 'Presenza aggiornata');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $attendance = $this->attendance->findOrFail($id);
        $attendance->delete();
        return $this->sendResponse($attendance, 'Presenza eliminata');
    }
// #endregion API Methods

// #region API Export Methods
public function export(Request $request) {
    // based on the view 'export_v_workers_view'

    $params = $request->all();
    $query = DB::table('export_v_attendances')
    ->select('day_date', 'worker_id', 'nome','cognome', 'codice_fiscale', 'matricola', 'entrance_date', 'entrance_ip', 'exit_date', 'exit_ip',  'duration_h', 'chk');

    // applies filters
    if (isset($params['date_start'])) {
        $query->where('ref_date', '>=', $params['date_start'] . ' 00:00:00');
    }
    if (isset($params['date_end'])) {
        $query->where('ref_date', '<=', $params['date_end'] . ' 23:59:59');
    }
    $header = 'Giorno;Dipendente;Nome;Cognome;Codice Fiscale;Matricola;Entrata;IP Entrata;Uscita;IP Uscita;Ore Lavorate;Controllo';
    $dbdata = $query->orderBy('ref_date')->orderBy('worker_id')->get();
    return $this->sendExport($header, $dbdata, ';', 'text/csv');
}
// #endregion API Export Methods

// #region Public Methods
    /**
     * Returns true if the specified id exists
     */
    public function exists($id) {
        $tableName = 'attendances';
        $data = DB::table($tableName)->where('id', $id)->take(1)->get();
        if (isset($data)) return isset($data[0]);
        return false;
    }

    /**
     * Returns the specified record
     */
    public function get($id) {
        //if (!$this->exists($id)) return null;
        $tableName = 'attendances';
        $data = DB::table($tableName)->where('id', $id)->take(1)->get();
        return $data[0];
    }

// #endregion Public Methods

// #region Private Methods
    /*
     * Normalizes worker data
     */
    private function normalizeData($data) {
        return $data;
    }
// #endregion Private Methods
}
