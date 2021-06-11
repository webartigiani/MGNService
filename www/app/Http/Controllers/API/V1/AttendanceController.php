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
        $perPage = $request->input("per_page", 50);         // 50 records per page
        $page = $request->input("page", 1);                 // page number
        if($page < 1) { $page = 1; }
        $skip = ($page - 1) * $perPage;                     // records to skip
        if($skip < 0) { $skip = 0; }

        // generates SQL query for pagination
        $sql = $this->listAttendancesQuery($startDate, $endDate, $search, $notatwork, $orderBy);
        if ($limit > 0) $sql .= " limit {$limit}";

        // TEMP: to export full SQL query
        #echo $sql;
        #return;

        // checks if we have working days in selected period...
        if ($sql == '') {
            // no working day selected
            $result_p = new LengthAwarePaginator([], 0, $perPage, 0);
            return $this->sendResponse($result_p, 'Empty Attendances List');
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

        DB::table('attendances')
            ->where('id', $id)
            ->delete();
        return $this->sendResponse('OK', 'Presenza eliminata');
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
    $sql = $this->listAttendancesQuery($s, $e, $search, $notatwork, 'ref_date, nome, cognome');

    // TEMP:
    //echo $sql;
    //return;

    $sql = "select
                day_date, worker_id, nome, cognome, codice_fiscale, matricola, entrance_date, entrance_ip, exit_date, exit_ip,
                case
                    when chk < 0 then 'Assente'
                    when chk = 0 then 'Incompleta'
                    else 'Presente'
                end as presence,
                concat(LPAD(CONVERT(duration_h_int, char), 2, '0'),':',LPAD(CONVERT(residual_m_int, char), 2, '0')) as working_time,
                concat(LPAD(CONVERT(abscence_h_int, char), 2, '0'),':',LPAD(CONVERT(abscence_minutes_int, char), 2, '0')) as abscence_time,
                abscence_justification, abscence_justification_desc,
                concat(LPAD(CONVERT(total_h_int, char), 2, '0'),':',LPAD(CONVERT(total_minutes_int, char), 2, '0')) as total_time
            from (
                {$sql}
            ) tbl";

    $header = "Giorno;Dipendente;Nome;Cognome;Codice Fiscale;Matricola;Entrata;IP Entrata;Uscita;IP Uscita;Presenza;Ore Lavorate;Ore Assenza;Cod. Giustificativo Assenza;Giustificativo Assenza;Ore Totali";
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
        worker_id,
        ref_date,
        duration_h_int hours, residual_m_int minutes,
        abscence_h_int absence_hours, abscence_minutes_int abscence_minutes, abscence_justification,
        chk
    from (
        {$sql}
    ) tbl";

    // TEMP
    //echo $sql;
    //return;

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
        $hours = $row->hours;                       // ore eff. lavorate
        $minutes = $row->minutes;                   // minuti lavorati aggiuntivi, orario effettivo
        $absence_hours = $row->absence_hours;       // ore assenza giustificate
        $abscence_minutes = $row->abscence_minutes; // minuti assenza aggiuntivi
        $abscence_justification = $row->abscence_justification; // giustificativo assenza
        $giornodiriposo = 'N';
        //NO!!! if ($row->chk <= 0) $giornodiriposo = 'S';  // giorno di riposo se assente o incompleto

        $codiceazienda = str_pad($codiceazienda, 6, "0", STR_PAD_LEFT);     // codice azienda con zero-padding-left 6 cifre
        $workerID = str_pad($workerID, 7, "0", STR_PAD_LEFT);               // id dipendente con zero-padding-left 7 cifre

        // se cambia il dipendente...
        if ($workerID != $lastWorkerID) {
            if ($lastWorkerID != '') {
                // chiude ramo XML dipendente precedente
                $output .= "\t\t</Movimenti>";
                $output .= "\t</Dipendente>\r\n";
            }

            // apre ramo XML dipendente corrente
            $output .= "\t<Dipendente CodAziendaUfficiale=\"{$codiceazienda}\" CodDipendenteUfficiale=\"{$workerID}\">";
            $output .= "\t\t<Movimenti GenerazioneAutomaticaDaTeorico=\"N\">\r\n";
        }   // /se cambia il dipendente...
        $lastWorkerID = $workerID;              // memorizza dipendente corrente

        // esporta dati presenze (del dipendente corrente)
        $output .= "\t\t\t<Movimento>";
        $output .= "\t\t\t\t<CodGiustificativoUfficiale>{$giustificativo}</CodGiustificativoUfficiale>";
        $output .= "\t\t\t\t<Data>{$refdate}</Data>\r\n";
        if ($giornodiriposo == 'N') $output .= "\t\t\t\t<NumOre>{$hours}.{$minutes}</NumOre>\r\n";      // ore lavorate nel formato HH.mm
        $output .= "\t\t\t\t<GiornoDiRiposo>{$giornodiriposo}</GiornoDiRiposo>";
        $output .= "\t\t\t</Movimento>\r\n";

        // se c'è assenza o riposo, esportiamo un ulteriore movimento
        if ($abscence_justification != '') {
            if ($abscence_justification == '_R') {
                // giustificativo (custom) giornata di riposo
                $output .= "\t\t\t<Movimento>";
                $output .= "\t\t\t\t<Data>{$refdate}</Data>\r\n";
                $output .= "\t\t\t\t<GiornoDiRiposo>S</GiornoDiRiposo>";
                $output .= "\t\t\t</Movimento>\r\n";
            } else {
                // giustificativo assenza
                $output .= "\t\t\t<Movimento>";
                $output .= "\t\t\t\t<CodGiustificativoUfficiale>{$abscence_justification}</CodGiustificativoUfficiale>";
                $output .= "\t\t\t\t<Data>{$refdate}</Data>\r\n";
                if ($giornodiriposo == 'N') $output .= "\t\t\t\t<NumOre>{$absence_hours}.{$abscence_minutes}</NumOre>\r\n";      // ore giustificate nel formato HH.mm
                $output .= "\t\t\t\t<GiornoDiRiposo>{$giornodiriposo}</GiornoDiRiposo>";
                $output .= "\t\t\t</Movimento>\r\n";
            }
        }
    }   // /foreach...

    // chiude dati ultimo dipendente elaborato
    $output .= "\t\t</Movimenti>";
    $output .= "\t</Dipendente>";

    // aggiunge header e footer
    $output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<Fornitura>
{$output}
</Fornitura>";

    // export as plain text
    return $this->sendExportPlain($output, 'text/xml');
}

public function exportNotes(Request $request) {
    /**
     * Exports notes as CSV
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
    $sql = $this->listAttendancesQuery($s, $e, $search, $notatwork, 'ref_date, nome, cognome');

    $sql = "select
            day_date, worker_id, nome, cognome,
            replace(replace(notes, '\n', ' '), ';', '') notes
            from (
                {$sql}
            ) tbl
            where IFNULL(notes, '') <> ''
            ";
    // TEMP:
    //echo $sql;
    //return;

    $header = "Giorno;Dipendente;Nome;Cognome;Note";
    $dbdata = DB::select(DB::raw($sql));
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

    public function listGiustificativi() {
        $tableName = 'giustificativi';
        $data = DB::table($tableName)->where('inclusion', 'Si') ->orderby('description')->get();
        return $data;
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
            1	id	decimal	NO
            2	ref_date	varchar	NO
            3	worker_id	bigint	NO
            4	nome	varchar	NO
            5	cognome	varchar	NO
            6	codice_fiscale	varchar	NO
            7	matricola	varchar	NO
            8	worker_status	int	NO
            9	day_date	varchar	NO
            10	entrance_date	varchar	YES
            11	entrance_ip	varchar	YES
            12	exit_date	varchar	YES
            13	exit_ip	varchar	YES
            14	duration_m	bigint	NO
            15	duration_h	decimal	NO
            16	duration_h_int	bigint	NO
            17	residual_m	bigint	NO
            18	residual_m_int	bigint	NO
            19	chk	bigint	NO
            20	abscence_m	bigint	NO
            21	abscence_h_int	bigint	NO
            22	abscence_minutes_int	bigint	NO
            23	abscence_justification	varchar	NO
            24	abscence_justification_desc	varchar	NO
            25	total_m	bigint	NO
            26	total_h_int	bigint	YES
            27	total_minutes_int	bigint	YES
        */

        $innerSQL = '';
        $sql = '';

        // normalizes arguments
        $searchQuery = trim(strtolower($searchQuery));
        $orderBy = trim(strtolower($orderBy));
        $p = $this->utils->getPeriodDays($startDate, $endDate);     // gets the dates period


// #region Calendar
        /*
        1st of all:
        creates an inner SQL query to select all days in calendar between start/end date
        this will result in something like this
            select '28/05/2021' as day_date, '2021-05-28' as ref_date
            union
            select '27/05/2021' as day_date, '2021-05-27' as ref_date
            ...
        */
        // selected a period higher than just one day?
        if ($startDate != $endDate) {
            // loops through days in period
            // NOTE: period DOES NOT CONSIDER last day in interval
            foreach ($p as $dt) {
                $dow = $this->utils->getWeekday($dt);       // gets the day-of-week (sunday:0)
                if ($dow > 0) {
                    // from monday(1) to saturday(6)
                    if ($innerSQL != '') $innerSQL .= "union\n";
                    $innerSQL .= "select '" . $dt->format("d/m/Y") . "' as day_date, ";
                    $innerSQL .= "'" . $dt->format("Y-m-d") . "' as ref_date\n";
                } else {
                    // Sunday...
                }
            }
        } else {
            // just one day interval
        }

        // Add or Use last day (if itsn't sunday)
        $dow = $this->utils->getWeekday($endDate);
        if ($dow > 0) {
            // from monday(1) to saturday(6)
            if ($innerSQL != '') $innerSQL .= "union\n";
            $innerSQL .= "select '" . $endDate->format("d/m/Y") . "' as day_date, ";
            $innerSQL .= "'" . $endDate->format("Y-m-d") . "' as ref_date\n";
        } else {
            // Sunday...
        }
// #endregion Calendar

// #region Check Calendar
        // checks if we have working days in selected period...
        if ($innerSQL == '') {
            // no day to export
            return '';
        }
// #endregion Check Calendar

// #region Main SQL Query
        /* Creates the main SQL query, than
            > starts from calendar to get all days in the selected period
            > joins attendances table and abscences table to get attendances and abscences by day and worker
            > where there's no attencance and no abscence, it consider worker abscente
            > calculates worked minutes, abscence minutes and total
            > rounds worked minutes and abscence minutes by env('MINUTE_ROUND')
        */
                $sql = "
                    select results.*,
                        /*
                            calculates minutes total, and total hours and minutes (ready for format HH:mm)
                        */
                        results.duration_m + results.abscence_m as total_m,
                        ((results.duration_m + results.abscence_m) DIV 60) total_h_int,
                        ((results.duration_m + results.abscence_m) DIV " . env('MINUTE_ROUND') . " * " . env('MINUTE_ROUND') . ") - (60 * ((results.duration_m + results.abscence_m) DIV 60)) total_minutes_int
                    from
                        (
                            select presenze.*,
                                /* also exports notes */
                                IFNULL(wn.notes, '') notes,
                                /*
                                    gets user abscence for the day
                                    and calculates abscence minutes and abscence hours and minutes (ready for format HH:mm)
                                    joins giustificativi to get justification description
                                */
                                IFNULL(assenze.abscence_minutes, 0) abscence_m,
                                IFNULL(assenze.abscence_minutes DIV 60, 0) abscence_h_int,
                                IFNULL((assenze.abscence_minutes DIV " . env('MINUTE_ROUND') . " * " . env('MINUTE_ROUND') . "), 0) - (60 * IFNULL(assenze.abscence_minutes DIV 60, 0)) abscence_minutes_int,
                                IFNULL(assenze.abscence_justification, '') abscence_justification,
                                IFNULL(giustificativi.description, '') abscence_justification_desc
                            from
                                (
                                select *
                                    from (
                                        select
                                            /*
                                                selects workers data, attendance data,
                                                and calculates worked minutes by day and also worked hours and minutes (ready for format HH:mm)
                                            */
                                            IFNULL(att.id, 0) id, calendar.ref_date,
                                            w.id worker_id, w.nome, w.cognome, w.codice_fiscale, w.matricola, w.stato worker_status,
                                            calendar.day_date,
                                            att.entrance_date, att.entrance_ip,
                                            att.exit_date, att.exit_ip,
                                            IFNULL(att.duration_m, 0) duration_m,
                                            IFNULL(att.duration_h, 0) duration_h,
                                            IFNULL(att.duration_h_int, 0) duration_h_int,
                                            IFNULL(att.residual_m, 0) residual_m,
                                            IFNULL((att.residual_m DIV " . env('MINUTE_ROUND') . " * " . env('MINUTE_ROUND') . "), 0) residual_m_int,
                                            IFNULL(att.chk, -1) chk
                                        from
                                        (   /*
                                                select days of period from calendar
                                            */
                                            {$innerSQL}
                                        ) calendar
                                        /*
                                            cross join workers to multiply results on all workers
                                        */
                                        cross join workers w
                                        /*
                                            left join attendances to get attendances, or empty records in case of abscence
                                        */
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
                /*
                    do search...
                */
                nome like '%" . $searchQuery . "%'
                or cognome like '%" . $searchQuery . "%'
                or codice_fiscale like '%" . $searchQuery . "%'
            )";
        }

        $sql .= " ) presenze
                    /* join absences to get abscence if present */
                    left outer join absences assenze
                        on presenze.worker_id = assenze.worker_id
                        and presenze.ref_date = assenze.ref_date
                    /* join giustificativi to get its description if present */
                    left outer join giustificativi
                        on assenze.abscence_justification = giustificativi.code
                    /* join worker_notes to get notes if present */
                    left outer join workers_notes wn
                        on  presenze.worker_id = wn.worker_id
                        and presenze.ref_date = wn.ref_date
            ) results
        ";

        // order by
        if ($orderBy != '') $sql .= " order by " . $orderBy;
// #endregion Main SQL Query

        return $sql;
    }
// #endregion Private Methods
}
