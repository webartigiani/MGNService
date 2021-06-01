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
use App\Http\Controllers\API\V1\WorkerController;
use App\Http\Controllers\UtilsController;
use DB;
use DateTime;
use Illuminate\Pagination\Paginator;
use \Illuminate\Pagination\LengthAwarePaginator;

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
        $startDate = null;
        $endDate = null;
        $search = '';
        $notatwork = false;
        $context = '';
        $orderBy = '';
        $limit = 0;

        $params = $request->all();
        if (isset($params['context'])) $context = trim(strtolower($params['context'])); // context (es. dashboard)

        switch ($context) {
            case '':
                // no context: we have all filters and no limit
                $startDate = new DateTime($params['date_start']);
                $endDate = new DateTime($params['date_end']);
                if (isset($params['query'])) $search = trim(strtolower($params['query']));          // search query
                if (isset($params['notatwork'])) $notatwork = ($params['notatwork'] == 'true');     // notatwork (as bool)
                $limit = 0;
                $orderBy = 'ref_date, nome, cognome';
                break;

            case 'dashboard':
                // dashboard: we show 7days attendances
                // we have no filter, no search query, but we limit to 20 results
                $startDate = new DateTime(date("Y-m-d"));
                $endDate = new DateTime(date("Y-m-d"));
                $startDate = date_add($startDate, date_interval_create_from_date_string(" -7 days"));
                $search = '';
                $notatwork = false;
                $limit = 30;                               // limit > 0 (no filters)
                $orderBy = 'id desc';
                break;
        }

        // pagination
        $perPage = $request->input("per_page", 10);        // records per page
        $page = $request->input("page", 1);                 // page number
        if($page < 1) { $page = 1; }
        $skip = ($page - 1) * $perPage;                     // records to skip
        if($skip < 0) { $skip = 0; }

        // generates SQL query for pagination
        $sql = $this->listAttendancesQuery($startDate, $endDate, $search, $notatwork, $orderBy);
        if ($limit > 0) $sql .= " limit {$limit}";

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

        $result_p = new LengthAwarePaginator($results, $totalCount, $perPage, $page);
        return $this->sendResponse($result_p, 'Attendances List');
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
        $data['check'] = 0;

        // updaters entrance/exit time with input times and ref_date
        if (isset($data['entrance_time'])) {
            $data['entrance_date'] = $data['ref_date'] . ' ' . $data['entrance_time'];
            $data['entrance_ip'] = '0.0.0.0';
        } else {
            $data['entrance_date'] = null;
            $data['entrance_ip'] = '0.0.0.0';
            $data['check']  = -1;
        }
        if (isset($data['exit_time'])) {
            $data['exit_date'] = $data['ref_date'] . ' ' . $data['exit_time'];
            $data['exit_ip'] = '0.0.0.0';
            $data['check'] = 1;
        } else {
            $data['exit_date'] = null;
            $data['exit_ip'] = '0.0.0.0';
        }

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
        //$this->authorize('isAdmin');              // NOTE: it doesn't work!!!!
        $attendance = $this->attendance->findOrFail($id);
        $attendance->delete();
        return $this->sendResponse($attendance, 'Presenza eliminata');
    }
// #endregion API Methods

// #region API Export Methods
public function export(Request $request) {
    /**
     * Exports presenze as CSV
     * NOTES: uses all filters
     */

    // gets filters
    $params = $request->all();
    $s = new DateTime($params['date_start']);                       // start date
    $e = new DateTime($params['date_end']);                         // end date
    $search = '';
    if (isset($params['query'])) $search = trim(strtolower($params['query']));           // search string
    $notatwork = ($params['notatwork'] == 'true');                  // notatwork (as bool)

    // gets the base-SQL to list attendances, then incapsulate it into a dedicate-SQL-query
    $sql = $this->listAttendancesQuery($s, $e, $search, $notatwork, 'ref_date, worker_id');
    $sql = "select
        day_date, worker_id, nome, cognome, codice_fiscale, matricola, entrance_date, entrance_ip, exit_date, exit_ip,  duration_h, chk
    from (
        {$sql}
    ) tbl";

    $header = 'Giorno;Dipendente;Nome;Cognome;Codice Fiscale;Matricola;Entrata;IP Entrata;Uscita;IP Uscita;Ore Lavorate;Controllo';
    $dbdata = DB::select(DB::raw($sql));
    return $this->sendExport($header, $dbdata, ';', 'text/csv');
}

public function exportXML(Request $request) {
    /**
     * Exports presenze as XML (Zucchetti, TRRIPW.XML)
     * NOTES: filters by dates
     */

    // gets filters
    $params = $request->all();
    $s = new DateTime($params['date_start']);                       // start date
    $e = new DateTime($params['date_end']);                         // end date
    $search = '';
    if (isset($params['query'])) $search = trim(strtolower($params['query']));           // search string
    $notatwork = ($params['notatwork'] == 'true');                  // notatwork (as bool)

    // gets the base-SQL to list attendances, then incapsulate it into a dedicate-SQL-query
    $sql = $this->listAttendancesQuery($s, $e, $search, $notatwork, 'worker_id, ref_date');
    $sql = "select
        worker_id, ref_date, duration_h_int hours, chk
    from (
        {$sql}
    ) tbl";
    $dbdata = DB::select(DB::raw($sql));

    $output = '';
    $lastWorkerID = '';
    $workerID = '';

    // creates data
    foreach ($dbdata as $row) {

        $giustificativo = "01";                     // giustificativo ufficiale
        $codiceazienda = trim(env("CODICE_AZIENDA"));
        $workerID = $row->worker_id;                // ID dipendente corrente
        $refdate = $row->ref_date;                  // data riferimento YYYY-MM-DD
        $hours = $row->hours;                       // ore lavorate
        $giornodiriposo = 'N';
        if ($row->chk <= 0) $giornodiriposo = 'S';  // giorno di riposo se assente o incompleto

        $codiceazienda = str_pad($codiceazienda, 6, "0", STR_PAD_LEFT);     // codice azienda con zero-padding-left 6 cifre
        $workerID = str_pad($workerID, 7, "0", STR_PAD_LEFT);               // id dipendente con zero-padding-left 7 cifre

        // se cambia il dipendente...
        if ($workerID != $lastWorkerID) {
            if ($lastWorkerID != '') {
                // chiude ramo XML dipendente precedente
                $output .= "\t\t</Movimenti>
\t</Dipendente>\r\n";
            }

            // apre ramo XML dipendente corrente
            $output .= "\t<Dipendente CodAziendaUfficiale=\"{$codiceazienda}\" CodDipendenteUfficiale=\"{$workerID}\">
\t\t<Movimenti GenerazioneAutomaticaDaTeorico=\"N\">\r\n";
        }   // /se cambia il dipendente...
        $lastWorkerID = $workerID;              // memorizza dipendente corrente

        // esporta dati presenze (del dipendente corrente)
        $output .= "\t\t\t<Movimento>
\t\t\t\t<CodGiustificativoUfficiale>{$giustificativo}</CodGiustificativoUfficiale>
\t\t\t\t<Data>{$refdate}</Data>\r\n";

        if ($giornodiriposo == 'N') $output .= "\t\t\t\t<NumOre>{$hours}</NumOre>\r\n";   // giorno lavorativo
        $output .= "\t\t\t\t<GiornoDiRiposo>{$giornodiriposo}</GiornoDiRiposo>
\t\t\t</Movimento>\r\n";
    }   // /foreach...


    // chiude dati ultimo dipendente elaborato
    $output .= "\t\t</Movimenti>
\t</Dipendente>";

    // aggiunge header e footer
    $output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<Fornitura>
{$output}
</Fornitura>";

    // export as plain text
    return $this->sendExportPlain($output, 'text/xml');
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

    /**
     * Extracts and returns attendances
     * from date $startDate
     * to date $endDate
     * with $searchQuery
     * only not-at-work if $notAtWork
     */
    private function listAttendancesQuery($startDate, $endDate, $searchQuery, $notAtWork, $orderBy) {
        /*  Returns an SQL Query to select attendances
            Creates an inner SQL query to select all days in calendar between start/end date
            es:
                select '28/05/2021' as day_date, '2021-05-28' as ref_date
                union
                select '27/05/2021' as day_date, '2021-05-27' as ref_date
                ...
        */

        $innerSQL = '';
        $sql = '';

        // normalizes arguments
        $searchQuery = trim(strtolower($searchQuery));
        $orderBy = trim(strtolower($orderBy));

        $p = $this->utils->getPeriodDays($startDate, $endDate);     // gets the period

        // selected a period higher than just one day?
        if ($startDate != $endDate) {
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
        $innerSQL .= "select '" . $endDate->format("d/m/Y") . "' as day_date, ";
        $innerSQL .= "'" . $endDate->format("Y-m-d") . "' as ref_date\n";

        // Creates the main SQL query
        $sql = "select *
                from (
                    select
                        IFNULL(att.id, 0) id, calendar.ref_date,
                        w.id worker_id, w.nome, w.cognome, w.codice_fiscale, w.matricola, w.stato worker_status,
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

        if ($notAtWork) $sql .= " and chk <= 0";        // show only not at work?
        if ($searchQuery != '') {
            $sql .= " and (
                nome like '%" . $searchQuery . "%'
                or cognome like '%" . $searchQuery . "%'
                or codice_fiscale like '%" . $searchQuery . "%'
            )";
        }
        if ($orderBy != '') $sql .= " order by " . $orderBy;
        return $sql;
    }
// #endregion Private Methods
}
