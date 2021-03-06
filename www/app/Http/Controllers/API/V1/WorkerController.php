<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Workers\WorkerRequest;
use App\Models\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\TrackingSessionController;
use App\Http\Controllers\UtilsController;
use DB;
use Hamcrest\Util;

class WorkerController extends BaseController
{
    protected $worker = '';
    private $utils;
    private $TSC;

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Worker $worker, UtilsController $utilsController, TrackingSessionController $tsc)
    {
        $this->middleware('auth:api');
        $this->worker = $worker;
        $this->utils = $utilsController;
        $this->TSC = $tsc;
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
        * GET       api/workers
        * params    {"show":true,"hiring_status":"1","status":"1","hiring_date_start":"2021-05","hiring_date_end":"2021-06","query":"filippo"}
        */

        $params = $request->all();
        $query = DB::table('workers');

        // applies filters
        if (isset($params['hiring_status'] )) {
            /**
             * hiring_status
             * -1:  tutti
             * 1:   assunti
             * 0:   cessati
             */
            if ($params['hiring_status'] == 0) $query->whereNotNull('data_cessazione');
            if ($params['hiring_status'] == 1) $query->whereNull('data_cessazione');
        }
        if ($params['status'] >= 0) {
            /**
             * status
             * -1:  tutti
             * 1:   presente oggi
             * 0:   assente oggi
             */
            $query->where('stato', $params['status']);
        }

        if (isset($params['hiring_date_start'])) {
            $fromDate = $params['hiring_date_start'] . '-01';
            $query->where('data_assunzione', '>=', $fromDate);
        }

        if (isset($params['hiring_date_end'])) {
            // finds the last day of the specified month
            $toDate = date("Y-m-t", strtotime($params['hiring_date_end'] . '-01'));
            $query->where('data_assunzione', '<=', $toDate);
        }
        if (isset($params['query'])) {
            $search = trim(strtolower($params['query']));
            if ($search != '') {
                $query->where(function($q) use ($search) {
                    $q->where('cognome', 'like', '%' . $search . '%')
                    ->orWhere('nome', 'like', '%' . $search . '%')
                    ->orWhere('codice_fiscale', 'like', '%' . $search . '%');
                });
            }
        }
        $query->whereNull('deleted_at');                 // not deleted
        $query->orderBy('id');
        $workers = $query->latest()->paginate(10);
        return $this->sendResponse($workers, 'Workers List');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Workers\WorkerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkerRequest $request)
    {
        // get form normalized data
        $data = $this->normalizeData($request->all());

        // creates a new password
        $password_timbrata = $this->generateRandomString(5);

        // inserts data
        $worker = $this->worker->create([
            'codice_azienda' => env('CODICE_AZIENDA'),
            'denominazione_azienda' => env('DENOMINAZIONE_AZIENDA'),
            'nome' => $data['nome'],
            'cognome' => $data['cognome'],
            'codice_fiscale' => $data['codice_fiscale'],
            'matricola' => 0,
            'email' => $data['email'],
            'telefono' => $data['telefono'],
            'ore_settimanali' => $data['ore_settimanali'],
            'pausa_orario' => $data['pausa_orario'],
            'modo_timbratura' => $data['modo_timbratura'],
            'data_assunzione' => $data['data_assunzione'],
            'data_cessazione' => $data['data_cessazione'],
            'password_timbratura' => $password_timbrata
        ]);

        // sets matricola as ID
        DB::table('workers')
        ->where('id', $worker->id)
        ->update(
            array(
                'matricola' => $worker->id,
            )
        );
        return $this->sendResponse($worker, 'Nuovo dipendente Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $worker = $this->worker->findOrFail($id);
        return $this->sendResponse($worker, 'Dettagli dipendente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(WorkerRequest $request, $id)
    {
        $worker = $this->worker->findOrFail($id);

        // get form normalized data
        $data = $this->normalizeData($request->all());

        // Updates data
        $worker->update($data);
        return $this->sendResponse($worker, 'Dipendente aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $worker = $this->worker->findOrFail($id);
        $worker->delete();
        return $this->sendResponse($worker, 'Il dipendente ?? stato eliminato');
    }
// #endregion API Methods

// #region API Export Methods
public function export(Request $request) {
    // based on the view 'export_v_workers_view'
    $header = 'Codice azienda;Denominazione;Dipendente;Cognome;Nome;Codice fiscale;Data assunzione;Data cessazione';
    $dbdata = DB::table('export_v_workers')->get();
    return $this->sendExport($header, $dbdata, ';', 'text/csv');
}
public function exportCodes(Request $request) {
    // based on the view 'export_v_workers_view'
    $header = 'Dipendente;Codice Timbrata';

    $sql = "select
        concat(nome, ' ' , cognome) nome_cognome, password_timbratura
        from
            workers
        where
            data_cessazione is null
        and deleted_at is null
        order by nome, cognome";
    $dbdata = DB::select(DB::raw($sql));
    return $this->sendExport($header, $dbdata, ';', 'text/csv');
}

// #endregion API Export Methods

// #region Public API methods
    /**
     * Returns the list of workers
     */
    public function list() {
        $workers = DB::table('workers')->get();
        return $this->sendResponse($workers, 'Workers List');
    }

    /**
     * Returns Workers counters
     */
    public function getCounters() {
        $dbdata = DB::table('v_workers_counter')->get();
        return $this->sendResponse($dbdata, 'Workers Counters');
    }
    /**
     * Lists workers at work
     */
    public function listAtWork() {
        $sql = "select id, concat(nome, ' ', cognome) item FROM
                v_workers where stato = 1
                order by item";
        $dbdata = DB::select(DB::raw($sql));
        return $this->sendResponse($dbdata, 'Workers at work');
    }
    /**
     * Lists workers not at work
     */
    public function listNotAtWork() {
        $sql = "select id, concat(nome, ' ', cognome) item FROM
                v_workers where stato = 0
                order by item";
        $dbdata = DB::select(DB::raw($sql));
        return $this->sendResponse($dbdata, 'Workers not at work');
    }
// #endregion Public API methods

// #region Public Methods
    /**
     * Returns true if the specified id exists
     */
    public function exists($id) {
        $tableName = 'workers';
        $data = DB::table($tableName)->where('id', $id)->take(1)->get();
        if (isset($data)) return isset($data[0]);
        return false;
    }

    /**
     * Returns the specified record
     */
    public function get($id) {
        if (!$this->exists($id)) return null;
        $tableName = 'attendances';
        $data = DB::table($tableName)->where('id', $id)->take(1)->get();
        return $data[0];
    }

    /**
     * Returns true if the specified worker exists, and has the specified password_timbratura
     */
    public function verifyCodiceTimbrata($id, $codice_timbratura) {
        $tableName = 'workers';
        $data = DB::table($tableName)->where('id', $id)->where('password_timbratura', $codice_timbratura)->whereNull('deleted_at')->whereNull('data_cessazione')->take(1)->get();
        if (isset($data)) return isset($data[0]);
        return false;
    }

    /**
     * Returns true if the specified worker exists and is hired
     */
    public function isHired($id) {
        $tableName = 'workers';
        $data = DB::table($tableName)->where('id', $id)->whereNull('deleted_at')->whereNull('data_cessazione')->take(1)->get();
        if (isset($data)) return isset($data[0]);
        return false;
    }

    /**
     * Esegue timbratura dipendente in data odierna
     * Non esegue:
     * - se il dipendente non esiste
     * - se il dipendente non risulta assunto
     * - se il giorno corrente ?? domenica
     * - se il codice timbrata non ?? corretto
     * Esegue:
     * - timbratura in entrata se non sono presenti timbrature in data odierna
     * - timbratura in uscita se presente quella in entrata, ma manca quella in uscita
     * - non esegue alcuna timbratura se entrambe presenti in data odierna
     * restituisce l'id della timbratura, oppure 0 in caso di errore
     *
     * NOTE:
     * - quando esegue timbratura in uscita, verifica e termina eventuali tragitti in corso
     *   tramite:   TrackingSessionController: $TSC->endSession(session_id))
     */
    public function timbra($workerID, $codice_timbratura, &$errorMessage) {

        $codice_timbratura = trim($codice_timbratura);
        $errorMessage = '';
        $dow = date('w');                   // giorno della settimana (Sunday=0)

        $dow = 1;           // NOTE: we actually by-pass check of the day-of-week, cause time-zone

        // verifica se il dipendente esiste
        if ($this->exists($workerID)) {
            // verifica se il dipendente ?? assunto
            if ($this->isHired($workerID)) {
                // checks worker's password
                if ($this->verifyCodiceTimbrata($workerID, $codice_timbratura)) {

                    if ($dow > 0) {
                        // from Monday to Saturday
                        $today = $this->utils->OraItaliana()->format('Y-m-d');          // today's date
                        $ip = $this->utils->UserIpAddress();                            // user's ip

                        $thisID = $this->hasTimbrataEntrata($workerID, $today);
                        if ($thisID == 0) {
                            // prima timbrata in entrata non ancora esistente
                            // esegue prima timbrata in entrata e ottiene il suo ID
                            $thisID = DB::table('attendances')->insertGetId(
                                array(
                                    'worker' => $workerID,
                                    'entrance_date' => $this->utils->OraItaliana(),
                                    'entrance_ip' => $ip,
                                    'check' => 0,
                                    'created_at' =>  $this->utils->OraItaliana(),
                                    'updated_at' => $this->utils->OraItaliana()
                                )
                            );
                            $this->setStatus($workerID, 1);             // sets worker's status to 1
                        } else {
                            // prima timbrata in entrata gi?? esistente
                            // verifica se manca prima timbrata in uscita
                            if ($this->hasTimbrataUscita($workerID, $today) == 0) {
                                // esegue prima timbrata in uscita
                                DB::table('attendances')->where('id', $thisID)
                                ->update(
                                    array(
                                        'exit_date' => $this->utils->OraItaliana(),
                                        'exit_ip' => $ip,
                                        'check' => 1,
                                        'updated_at' => $this->utils->OraItaliana()
                                    )
                                );
                                $this->TSC->endUserSessions($workerID); // ends up all tracking sessions for current worker
                                $this->setStatus($workerID, 0);         // sets worker's status to 0
                            } else {
                                // prime timbrate E/U entrambi esistenti
                                // Se il dipendente ?? abilitato alla pausa, verifica le seconde timbrate giornaliere

                                if ($this->canPauseOrario($workerID)) {
                                    // Dipendente abilitato alla pausa in orario di lavoro.
                                    // Verifica seconda timbrata in entrata
                                    $thisID = $this->hasTimbrataEntrata2($workerID, $today);
                                    if ($thisID == 0) {
                                        // seconda timbrata in entrata non ancora esistente
                                        // esegue seconda timbrata in entrata e ottiene il suo ID
                                        $thisID = $this->hasTimbrataUscita($workerID, $today);
                                        DB::table('attendances')->where('id', $thisID)
                                        ->update(
                                            array(
                                                'entrance_date_2' => $this->utils->OraItaliana(),
                                                'entrance_ip_2' => $ip,
                                                'check' => 0,
                                                'updated_at' => $this->utils->OraItaliana()
                                            )
                                        );
                                        $this->setStatus($workerID, 1);             // sets worker's status to 1
                                    } else {
                                        // seconda timbrata in entrata gi?? esistente
                                        // verifica se manca seconda timbrata in uscita
                                        if ($this->hasTimbrataUscita2($workerID, $today) == 0) {
                                            // esegue seconda timbrata in uscita
                                            DB::table('attendances')->where('id', $thisID)
                                            ->update(
                                                array(
                                                    'exit_date_2' => $this->utils->OraItaliana(),
                                                    'exit_ip_2' => $ip,
                                                    'check' => 1,
                                                    'updated_at' => $this->utils->OraItaliana()
                                                )
                                            );
                                            $this->TSC->endUserSessions($workerID); // ends up all tracking sessions for current worker
                                            $this->setStatus($workerID, 0);         // sets worker's status to 0
                                        } else {
                                            // Dipendente abilitato alla pausa in orario di lavoro.
                                            // Ha gi?? eseguito le prime e seconde timbrate E/U della giornata
                                            // Non pu?? eseguire ulteriori timbrate nella giornata corrente
                                            $errorMessage = 'Hai gi?? eseguito tutte le timbrate della giornata.';
                                            return 0;
                                        }
                                    }
                                } else {
                                    // Dipendente NON abilitato alla pausa in orario di lavoro.
                                    // Ha gi?? eseguito le prime timbrate E/U della giornata
                                    // Non pu?? eseguire ulteriori timbrate nella giornata corrente
                                    $errorMessage = 'Hai gi?? eseguito tutte le timbrate della giornata.';
                                    return 0;
                                }
                            }
                        }
                        return $thisID;
                    } else {
                        // today is sunday
                        $errorMessage = 'Giorno non lavorativo.';
                        return 0;
                    }
                } else {
                    // password not valid
                    $errorMessage = 'Hai digitato un codice timbrata non valido.';
                    return 0;
                }
            } else {
                // worker not hired
                $errorMessage = 'Il dipendente selezionato non ?? presente in archivio o non ?? abilitato.';
                return 0;
            }
        } else {
            // worker doesn't exists
            $errorMessage = 'Dipendente non trovato.';
            return 0;
        }
    }

    /**
     * Sets worker's status
     */
    public function setStatus($workerID, $status) {
        if (!$this->exists($workerID)) return false;    // checks worker if exists
        if (!$this->isHired($workerID)) return false;   // checks worker if is hired

        if ($status < 0) $status = 0;
        if ($status > 1) $status = 1;

        DB::table('workers')->where('id', $workerID)
        ->update(
            array(
                'stato' => $status,
                'data_stato' => $this->utils->OraItaliana(),
                'updated_at' => $this->utils->OraItaliana()
            )
        );
        return true;
    }

    /**
     * returns true if the employee is enabled to take breaks during working hours (e.g. lunch break)
     */
    public function canPauseOrario($id) {
        $tableName = 'workers';
        $data = DB::table($tableName)->where('id', $id)->where('pausa_orario', true)->take(1)->get();
        if (isset($data)) return isset($data[0]);
        return false;
    }

    /**
     * if the specified worker has an attendace for 1st entrance in the specified date
     * returns its id
     * otherwise returns 0
     */
    public function hasTimbrataEntrata($id, $date) {
        $ret = 0;
        $startDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';

        $tableName = 'attendances';
        $data = DB::table($tableName)->where('worker', $id)->whereBetween('entrance_date', [$startDate, $toDate])->take(1)->get();
        if (isset($data)) {
          if (isset($data[0])) $ret = $data[0]->id;
        }
        return $ret;
    }

    /**
     * if the specified worker has and attendace for 1st exit in the specified date
     * returns its id
     * otherwise returns 0
     */
    public function hasTimbrataUscita($id, $date) {
        $ret = 0;
        $startDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';

        $tableName = 'attendances';
        $data = DB::table($tableName)->where('worker', $id)->whereBetween('exit_date', [$startDate, $toDate])->take(1)->get();
        if (isset($data)) {
            if (isset($data[0])) $ret = $data[0]->id;
          }
        return $ret;
    }

    /**
     * if the specified worker has an attendace for 2nd entrance in the specified date
     * returns its id
     * otherwise returns 0
     */
    public function hasTimbrataEntrata2($id, $date) {
        $ret = 0;
        $startDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';

        $tableName = 'attendances';
        $data = DB::table($tableName)->where('worker', $id)->whereBetween('entrance_date_2', [$startDate, $toDate])->take(1)->get();
        if (isset($data)) {
          if (isset($data[0])) $ret = $data[0]->id;
        }
        return $ret;
    }

    /**
     * if the specified worker has and attendace for 2nd exit in the specified date
     * returns its id
     * otherwise returns 0
     */
    public function hasTimbrataUscita2($id, $date) {
        $ret = 0;
        $startDate = $date . ' 00:00:00';
        $toDate = $date . ' 23:59:59';

        $tableName = 'attendances';
        $data = DB::table($tableName)->where('worker', $id)->whereBetween('exit_date_2', [$startDate, $toDate])->take(1)->get();
        if (isset($data)) {
            if (isset($data[0])) $ret = $data[0]->id;
          }
        return $ret;
    }

    /**
     * Removes an abscence for the specified worker in the specified date
     * Returns true if succeedes
     */
    public function deleteAbscence($id, $date) {
        if (!$this->exists($id)) return false;          // worker not found!

        DB::table('absences')
            ->where('worker_id', $id)
            ->where('ref_date', $date)
            ->delete();
        return true;
    }
    /**
     * Register an abscence for the specified worker in the specified date
     * Returns true if succeedes
     */
    public function addAbscence($id, $date, $minutes, $justification) {

        // normalizes arguments
        $justification = trim(strtoupper($justification));

        // validates arguments
        if (!$this->exists($id)) return false;          // worker not found!
        if ($minutes < 0) return false;                 // minutes not valid
        if ($justification == '') return false;         // justification code missing

        $this->deleteAbscence($id, $date);              // deletes previous abscence for the specified worker in the specified date
        if ($minutes == 0) return true;                 // nothing else to do: return true

        // registers abscence
        $thisID = DB::table('absences')->insertGetId(
            array(
                'worker_id' => $id,
                'ref_date' => $date,
                'abscence_minutes' => $minutes,
                'abscence_justification' => $justification,
                'created_at' =>  $this->utils->OraItaliana(),
                'updated_at' => $this->utils->OraItaliana()
            )
        );
        return ($thisID > 0);
    }

    /**
     * Removes an extra-ordinary work for the specified worker in the specified date
     * Returns true if succeedes
     */
    public function deleteExtraOrdinary($id, $date) {
        if (!$this->exists($id)) return false;          // worker not found!

        DB::table('extraordinaries')
            ->where('worker_id', $id)
            ->where('ref_date', $date)
            ->delete();
        return true;
    }
    /**
     * Register an extra-ordinary work time for the specified worker in the specified date
     * Returns true if succeedes
     */
    public function addExtraOrdinary($id, $date, $minutes, $justification) {

        // normalizes arguments
        $justification = trim(strtoupper($justification));

        // validates arguments
        if (!$this->exists($id)) return false;          // worker not found!
        if ($minutes < 0) return false;                 // minutes not valid
        if ($justification == '') return false;         // justification code missing

        $this->deleteExtraOrdinary($id, $date);         // deletes previous extra-ordinary work for the specified worker in the specified date
        if ($minutes == 0) return true;                 // nothing else to do: return true

        // registers abscence
        $thisID = DB::table('extraordinaries')->insertGetId(
            array(
                'worker_id' => $id,
                'ref_date' => $date,
                'extraordinary_minutes' => $minutes,
                'extraordinary_justification' => $justification,
                'created_at' =>  $this->utils->OraItaliana(),
                'updated_at' => $this->utils->OraItaliana()
            )
        );
        return ($thisID > 0);
    }

    /**
     * Removes a note for the specified worker in the specified date
     * Returns true if succeedes
     */
    public function deleteNotes($id, $date) {
        if (!$this->exists($id)) return false;          // worker not found!

        DB::table('workers_notes')
            ->where('worker_id', $id)
            ->where('ref_date', $date)
            ->delete();
        return true;
    }
    /**
     * Register a note for the specified worker in the specified date
     * Returns true if succeedes
     */
    public function addNotes($id, $date, $notes) {

        // normalizes arguments
        $notes = trim($notes);

        // validates arguments
        if (!$this->exists($id)) return false;          // worker not found!

        $this->deleteNotes($id, $date);                 // deletes previous notes for the specified worker in the specified date
        if ($notes == '') return true;                  // nothing else to do: return true

        // registers abscence
        $thisID = DB::table('workers_notes')->insertGetId(
            array(
                'worker_id' => $id,
                'ref_date' => $date,
                'notes' => $notes,
                'created_at' =>  $this->utils->OraItaliana(),
                'updated_at' => $this->utils->OraItaliana()
            )
        );
        return ($thisID > 0);
    }
// #endregion Public Methods

// #region Private Methods
    /*
     * Normalizes worker data
     */
    private function normalizeData($data) {
        $data['nome'] =  strtoupper(trim($data['nome']));
        $data['cognome'] =  strtoupper(trim($data['cognome']));
        $data['codice_fiscale'] =  strtoupper(trim($data['codice_fiscale']));
        $data['email'] =  strtolower(trim($data['email']));
        $data['telefono'] =  strtoupper(trim($data['telefono']));
        return $data;
    }
    private function generateRandomString($length = 10) {
        $characters = '0123456';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
// #endregion Private Methods
}
