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
use App\Http\Controllers\API\V1\Collection;

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

        // NOTE: to debug SQL query, use param "debug-query=y"
        if (isset($params['debug-query'])) {
            echo $sql;
            return;
        }

        // checks if we have working days in selected period...
        if ($sql == '') {
            // no working day selected
            $result_p = new LengthAwarePaginator([], 0, $perPage, 0);
            return $this->sendResponse($result_p, 'Empty Attendances List');
        }

        // TEMP
        // die($sql);               // to debug SQL
        // TEMP

        // if we have days to export
        $dbdata = DB::select(DB::raw($sql));

        /** IMPORTANT: to paginate RAW Data for LaravelPaginator
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
        if (isset($data['entrance_time_2'])) {
            $data['entrance_date_2'] = $data['ref_date'] . ' ' . $data['entrance_time_2'];
            $data['entrance_ip_2'] = '0.0.0.0';
            if (!isset($data['exit_time_2'])) $data['check']  = -1;
        } else {
            $data['entrance_date_2'] = null;
            $data['entrance_ip_2'] = '0.0.0.0';
        }
        if (isset($data['exit_time_2'])) {
            $data['exit_date_2'] = $data['ref_date'] . ' ' . $data['exit_time_2'];
            $data['exit_ip_2'] = '0.0.0.0';
            $data['check'] = 1;
            if (!isset($data['entrance_time_2'])) $data['check']  = -1;
        } else {
            $data['exit_date_2'] = null;
            $data['exit_ip_2'] = '0.0.0.0';
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

    $sql = "select
                day_date, worker_id, nome, cognome, codice_fiscale, matricola,
                entrance_date, entrance_ip, exit_date, exit_ip,
                entrance_date_2, entrance_ip_2, exit_date_2, exit_ip_2,
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

    $header = "Giorno;Dipendente;Nome;Cognome;Codice Fiscale;Matricola;Entrata;IP Entrata;Uscita;IP Uscita;Rientro;IP Rientro;Uscita;IP Uscita;Presenza;Ore Lavorate;Ore Assenza;Cod. Giustificativo Assenza;Giustificativo Assenza;Ore Totali";
    $dbdata = DB::select(DB::raw($sql));
    return $this->sendExport($header, $dbdata, ';', 'text/csv');
}

public function exportXML(Request $request) {
    /**
     * Exports presenze as XML (Zucchetti, TRRIPW.XML)
     * NOTES:   filters by dates
     * DOCS:    https://remote.cedbrianteo.it/PagheWEB/help/infinity/ITA/mergedProjects/Infinity_PagheWeb/intro/intro_interfaccia_presenze.htm#Formato_XML
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
        matricola,
        ref_date,
        duration_h_int hours, residual_m_int minutes,
        abscence_h_int absence_hours, abscence_minutes_int abscence_minutes, abscence_justification,
        extraordinary_h_int extraordinary_hours, extraordinary_minutes_int extraordinary_minutes, extraordinary_justification,
        ordinary_m, ordinary_h_int, ordinary_minutes_int, avg_hours_per_day,
        chk
    from (
        {$sql}
    ) tbl";

    // NOTE: to debug SQL query, use param "debug-query=y"
    if (isset($params['debug-query'])) {
        echo $sql;
        return;
    }

    $dbdata = DB::select(DB::raw($sql));

    $output = '';
    $lastWorkerID = '';
    $workerID = '';

    // creates data
    foreach ($dbdata as $row) {

        $giustificativo = "01";                     // giustificativo ufficiale
        $codiceazienda = trim(env("CODICE_AZIENDA"));
        $workerID = $row->worker_id;                // ID dipendente corrente
        $matr = $row->matricola;                    // Numero matricola
        $refdate = $row->ref_date;                  // data riferimento giornata di lavoro (YYYY-MM-DD)
        $hours = $row->hours;                       // ore e minuti orario di lavoro effettivo
        $minutes = $row->minutes;
        $absence_hours = $row->absence_hours;                   // ore e minuti assenza + giustif. assenza
        $abscence_minutes = $row->abscence_minutes;
        $abscence_justification = $row->abscence_justification;
        $extraordinary_hours = $row->extraordinary_hours;       // ore e minuti lavoro straordinario + giustif. straordinario
        $extraordinary_minutes = $row->extraordinary_minutes;
        $extraordinary_justification = $row->extraordinary_justification;
        $ordinary_m = $row->ordinary_m;                         // ore e minuti lavoro ordinario
        $ordinary_h_int = $row->ordinary_h_int;
        $ordinary_minutes_int = $row->ordinary_minutes_int;
        $avg_hours_per_day = $row->avg_hours_per_day;           // media ore giornaliere di lavoro
        /*  NOTA: avg_hours_per_day è il numero di ore settimanali del dipendente (da anagrafica) diviso 6gg lavorativi settimanali
            Questo dato ci serve, nel caso di straordinari NON giustificati, per esportare un numero massimo di ore ordinarie
            non superiore a quello previsto da contratto.
            NOTA: avg_hours_per_day è in decimali. Quindi: 6.67 sono 06:40
        **/
        $giornodiriposo = 'N';

        $codiceazienda = str_pad($codiceazienda, 6, "0", STR_PAD_LEFT);     // codice azienda con zero-padding-left 6 cifre
        $matr = str_pad($matr, 7, "0", STR_PAD_LEFT);                       // matricola

        // calcola ore e minuti della giornata di lavoro ordinario del dipendente, basata sulla media ore giornaliere
        /* ES:
                40      ore settimanali da contratto
                6       giorni lavorativi a settimana (da lun. a sab), per ogni dipendente
                6.67    media ore giornaliere
                06:40   corrispondente in 6 ore e 40 minuti
                400     corrispondente a 400 minuti
        **/
        $avg_hpd_hours_int = intval($avg_hours_per_day);
        $avg_hpd_mins_int = intval((60 / 100) * (($avg_hours_per_day - $avg_hpd_hours_int) * 100));
        $avg_hpd_minutes = ($avg_hpd_hours_int * 60) + $avg_hpd_mins_int;

        //echo "<br>Media ore giornaliere: {$avg_hours_per_day} =&gt; {$avg_hpd_hours_int}:{$avg_hpd_mins_int} ({$avg_hpd_minutes}')";

        // se cambia il dipendente...
        if ($workerID != $lastWorkerID) {
            if ($lastWorkerID != '') {
                // chiude ramo XML dipendente precedente
                $output .= "\t\t</Movimenti>";
                $output .= "\t</Dipendente>\r\n";
            }

            // apre ramo XML dipendente corrente
            $output .= "\t<Dipendente CodAziendaUfficiale=\"{$codiceazienda}\" CodDipendenteUfficiale=\"{$matr}\">\r\n";
            $output .= "\t\t<Movimenti GenerazioneAutomaticaDaTeorico=\"N\">\r\n";
        }   // /se cambia il dipendente...
        $lastWorkerID = $workerID;              // memorizza dipendente corrente

        // esporta dati presenza del dipendente corrente: ore totali o ore ordinarie se è presente straordinario
        if ($extraordinary_justification != '') {
            $hours = $ordinary_h_int;
            $minutes = $ordinary_minutes_int;
        }

        //echo "<br>Ore Ordinarie: {$hours}:{$minutes}";

        // se il dipendente ha lavorato - sia che abbia assenze giustificate, sia che abbia straordinari giustificati,
        // sia che abbia straordinari NON giustificati - nelle ore ordinarie esportiamo sempre NON PIU' della media
        // ore di lavoro giornaliero
        if ($ordinary_h_int > 0 || $ordinary_minutes_int > 0) {
            if ($ordinary_m > $avg_hpd_minutes) {
                // le ore di lavoro ordinario eccedono la media ore giornaliere:
                // modifichiamo ore ordinarie, allineandole a quelle da contratto
                $hours = $avg_hpd_hours_int;
                $minutes = $avg_hpd_mins_int;
            }
        }

        //echo "<br>Ore Ordinarie: {$hours}:{$minutes}<br>";

        $output .= "\t\t\t<Movimento>\r\n";
        $output .= "\t\t\t\t<CodGiustificativoUfficiale>{$giustificativo}</CodGiustificativoUfficiale>\r\n";
        $output .= "\t\t\t\t<Data>{$refdate}</Data>\r\n";
        if ($giornodiriposo == 'N') $output .= "\t\t\t\t<NumOre>{$hours}</NumOre>\r\n";             // ore e minuti lavorati
        if ($giornodiriposo == 'N') $output .= "\t\t\t\t<NumMinuti>{$minutes}</NumMinuti>\r\n";
        $output .= "\t\t\t\t<GiornoDiRiposo>{$giornodiriposo}</GiornoDiRiposo>\r\n";
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
                if ($giornodiriposo == 'N') $output .= "\t\t\t\t<NumOre>{$absence_hours}</NumOre>\r\n";             // ore e minuti assenza giustificata
                if ($giornodiriposo == 'N') $output .= "\t\t\t\t<NumMinuti>{$abscence_minutes}</NumMinuti>\r\n";
                $output .= "\t\t\t\t<GiornoDiRiposo>{$giornodiriposo}</GiornoDiRiposo>";
                $output .= "\t\t\t</Movimento>\r\n";
            }
        }

        // se c'è straordinario (es è giustificato) esportiamo un ulteriore movimento
        if ($extraordinary_justification != '') {
            $output .= "\t\t\t<Movimento>";
            $output .= "\t\t\t\t<CodGiustificativoUfficiale>{$extraordinary_justification}</CodGiustificativoUfficiale>";
            $output .= "\t\t\t\t<Data>{$refdate}</Data>\r\n";
            if ($giornodiriposo == 'N') $output .= "\t\t\t\t<NumOre>{$extraordinary_hours}</NumOre>\r\n";             // ore e minuti straordinario
            if ($giornodiriposo == 'N') $output .= "\t\t\t\t<NumMinuti>{$extraordinary_minutes}</NumMinuti>\r\n";
            $output .= "\t\t\t\t<GiornoDiRiposo>{$giornodiriposo}</GiornoDiRiposo>";
            $output .= "\t\t\t</Movimento>\r\n";
        }
    }   // /foreach...

    // chiude dati ultimo dipendente elaborato
    $output .= "\t\t</Movimenti>\r\n";
    $output .= "\t</Dipendente>\r\n";

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

    public function listGiustificativiAssenze() {
        // lista giustificativi assenze
        $tableName = 'giustificativi';
        $data = DB::table($tableName)->where('inclusion', 'Si')->where('used_for', 'ABS')->orderby('description')->get();
        return $data;
    }
    public function listGiustificativiStraordinari() {
        // lista giustificativi straordinari
        $tableName = 'giustificativi';
        $data = DB::table($tableName)->where('inclusion', 'Si')->where('used_for', 'STR')->orderby('description')->get();
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
            29  hours_per_week  int
            30  hours_per_day float
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
                    select finalResults.*,
                        /* Calcola ore e minuti di lavoro ordinario */
                        finalResults.cont_m - finalResults.extraordinary_m ordinary_m,
                        ((finalResults.cont_m - finalResults.extraordinary_m) DIV 60) ordinary_h_int,
                        ((finalResults.cont_m - finalResults.extraordinary_m)) - (60 * ((finalResults.cont_m - finalResults.extraordinary_m) DIV 60)) ordinary_minutes_int
                    from
                        (
                        select results.*,
                            /* Calcola i minuti lavorati totali dal dipendente nella giornata ore e minuti (per formato HH:mm) */
                            results.duration_m + results.abscence_m as total_m,
                            ((results.duration_m + results.abscence_m) DIV 60) total_h_int,
                            ((results.duration_m + results.abscence_m) DIV " . env('MINUTE_ROUND') . " * " . env('MINUTE_ROUND') . ") - (60 * ((results.duration_m + results.abscence_m) DIV 60)) total_minutes_int,

                            /* minuti contabili: minuti lavorati contabili (arrotondati a 15'), senza eventuali assenze giustificate */
                            (((results.duration_m) DIV 60) * 60) + ((results.duration_m) DIV 15 * 15) - (60 * ((results.duration_m) DIV 60)) cont_m,

                            /* media ore e minuti giornalieri, basati su ore_settimanali */
                            ROUND(results.ore_settimanali / 6, 2) avg_hours_per_day,
                            ROUND((results.ore_settimanali / 6) * 60, 0) avg_minutes_per_day
                        from
                            (
                                select presenze.*,
                                    /* esporta anche le note per il dipendente nella data di riferimento, se inserite dallo staff */
                                    IFNULL(wn.notes, '') notes,
                                    /*
                                        recupera l'assenza del dipendente - se giustificata - per il giorno corrente
                                        e calcola minuti di assenza, ore e minuti (per formato HH:mm).
                                        joina con table giustificativi per ottenere descrizione giustificativo assenza
                                    */
                                    IFNULL(assenze.abscence_minutes, 0) abscence_m,
                                    IFNULL(assenze.abscence_minutes DIV 60, 0) abscence_h_int,
                                    IFNULL((assenze.abscence_minutes DIV " . env('MINUTE_ROUND') . " * " . env('MINUTE_ROUND') . "), 0) - (60 * IFNULL(assenze.abscence_minutes DIV 60, 0)) abscence_minutes_int,
                                    IFNULL(assenze.abscence_justification, '') abscence_justification,
                                    IFNULL(giustificativi_assenze.description, '') abscence_justification_desc,

                                    /*
                                        recupera lo straordinario del dipendente - se inserito - per il giorno corrente
                                        e calcola minuti di straordinarig, ore e minuti (per formato HH:mm).
                                        joina con table giustificativi per ottenere descrizione giustificativo straordinario
                                    */
                                    IFNULL(straordinari.extraordinary_minutes, 0) extraordinary_m,
                                    IFNULL(straordinari.extraordinary_minutes DIV 60, 0) extraordinary_h_int,
                                    IFNULL((straordinari.extraordinary_minutes), 0) - (60 * IFNULL(straordinari.extraordinary_minutes DIV 60, 0)) extraordinary_minutes_int,
                                    IFNULL(straordinari.extraordinary_justification, '') extraordinary_justification,
                                    IFNULL(giustificativi_straordinari.description, '') extraordinary_justification_desc
                                from
                                    (
                                    select *
                                        from (
                                            select
                                                /*
                                                    seleziona i dati del dipendente e le sue presenze.
                                                    calcola i minuti lavorati per giornata, le ore e i minuti (per formato HH:mm)

                                                    FIX:
                                                    id=0 generato in caso di assenza potrebbe essere la causa di problemi
                                                    di visualizzazione e filtri nelle presenze.
                                                    Proviamo sostituendo id=0 in caso di assenza con un valore generato dalla data di riferimento + l'id del dipendente

                                                    era     IFNULL(att.id, 0) id, calendar.ref_date,
                                                    diventa IFNULL(att.id, concat(REPLACE(calendar.ref_date, '-', ''), w.id)) id, calendar.ref_date,
                                                */
                                                IFNULL(att.id, CONCAT(REPLACE(calendar.ref_date, '-', ''), w.id)) id, calendar.ref_date,
                                                w.id worker_id, w.nome, w.cognome, w.codice_fiscale, w.matricola, w.stato worker_status, w.pausa_orario,
                                                calendar.day_date,
                                                att.entrance_date, att.entrance_ip,
                                                att.exit_date, att.exit_ip,
                                                /* Considera anche seconda timbrata giornaliera */
                                                att.entrance_date_2, att.entrance_ip_2,
                                                att.exit_date_2, att.exit_ip_2,
                                                /* minuti lavorati, ore (float e int), minuti residui, sono calcolati dalla view export_v_attendances */
                                                IFNULL(att.duration_m, 0) duration_m,
                                                IFNULL(att.duration_h, 0) duration_h,
                                                IFNULL(att.duration_h_int, 0) duration_h_int,
                                                IFNULL(att.residual_m, 0) residual_m,
                                                IFNULL((att.residual_m DIV " . env('MINUTE_ROUND') . " * " . env('MINUTE_ROUND') . "), 0) residual_m_int,
                                                IFNULL(att.chk, -1) chk,
                                                /* data_cessazione e data_assunzione: non vengono esportati. Ci servono per poterci filtrare */
                                                w.data_cessazione, w.data_assunzione,
                                                /* ore_settimanali: necessarie per calcolare ore straordinarie giornaliere */
                                                w.ore_settimanali
                                            from
                                            (   /* seleziona i giorni del periodo dal calendario */
                                                {$innerSQL}
                                            ) calendar
                                            /* CROSS join con table workers per moltiplicare i record del calendario su ogni lavoratore */
                                            cross join workers w
                                            /* LEFT join con attendances per ottenere presenze o un record vuoto in caso di assenza */
                                            left outer join export_v_attendances att
                                                on att.day_date = calendar.day_date
                                                and att.worker_id = w.id
                                        ) presenze
                                    where
                                        /*  a) 	include i soli dipendenti il cui rapporto di lavoro è ancora in corso, o è cessato DOPO della data di riferimento:
                                                >= ref_date, fasi che venga fornita la presenza anche per il giorno di cessazione rapporto
                                            b)	include i soli dipendenti la cui data di assunzione è >= alla data di riferimento: escludendo quelli non ancora in forza
                                        */
                                        (data_cessazione IS NULL OR data_cessazione >= ref_date)
                                        and data_assunzione <= ref_date
                                        ";
            $sql .= " ) presenze
                        /* join con absences per ottenere dati presenza se esistenti */
                        left outer join absences assenze
                            on presenze.worker_id = assenze.worker_id
                            and presenze.ref_date = assenze.ref_date
                        /* join con giustificativi per ottenere giustificativi assenze se assegnati */
                        left outer join giustificativi giustificativi_assenze
                            on assenze.abscence_justification = giustificativi_assenze.code

                        /* join con extraordinaries per ottenere dati straordinari se esistenti */
                        left outer join extraordinaries straordinari
                            on presenze.worker_id = straordinari.worker_id
                            and presenze.ref_date = straordinari.ref_date
                        /* join con giustificativi per ottenere giustificativi straordinari se assegnati */
                        left outer join giustificativi giustificativi_straordinari
                            on straordinari.extraordinary_justification = giustificativi_straordinari.code

                        /* join con worker_notes per ottenere le note della giornata per il dipendente, se inserite */
                        left outer join workers_notes wn
                            on  presenze.worker_id = wn.worker_id
                            and presenze.ref_date = wn.ref_date
                ) results
            /*
                Apply filters
            */
            where
                1=1
            ";
        if ($searchQuery != '') {
            $sql .= " and
                /* search query */
                (nome like '%" . $searchQuery . "%'
                or cognome like '%" . $searchQuery . "%'
                or nome + ' ' + cognome like '%" . $searchQuery . "%'
                or codice_fiscale like '%" . $searchQuery . "%'
                )
            ";
        }
        if ($notAtWork) $sql .= " and chk <= 0";        // show only not at work?
        $sql .= ') finalResults ';

        // order by
        if ($orderBy != '') $sql .= " order by " . $orderBy;
// #endregion Main SQL Query

        return $sql;
    }
// #endregion Private Methods
}
