<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Workers\WorkerRequest;
use App\Models\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\UtilsController;
use DB;
use Hamcrest\Util;

class WorkerController extends BaseController
{
    protected $worker = '';
    private $utils;

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Worker $worker, UtilsController $utilsController)
    {
        $this->middleware('auth:api');
        $this->worker = $worker;
        $this->utils = $utilsController;
    }
// #endregion Constructor

// #region API Methods
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = DB::table('workers')->latest()->paginate(10);
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

        // inserts data
        $worker = $this->worker->create([
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
        return $this->sendResponse($worker, 'Il dipendente è stato eliminato');
    }
// #endregion API Methods

// #region Public API methods
    /**
     *
     */
    public function list() {
        $workers = DB::table('workers')->get();
        return $this->sendResponse($workers, 'Workers List');
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
     * Esegue:
     * - timbratura in entrata se non sono presenti timbrature in data odierna
     * - timbratura in uscita se presente quella in entrata, ma manca quella in uscita
     * - non esegue alcuna timbratura se entrambe presenti in data odierna
     * restituisce l'id della timbratura, oppure 0 in caso di errore
     */
    public function timbra($workerID, $codice_timbratura, &$errorMessage) {

        $codice_timbratura = trim($codice_timbratura);
        $errorMessage = '';

        // verifica se il dipendente esiste
        if ($this->exists($workerID)) {
            // verifica se il dipendente è assunto
            if ($this->isHired($workerID)) {
                // checks worker's password
                if ($this->verifyCodiceTimbrata($workerID, $codice_timbratura)) {

                    $today = $this->utils->OraItaliana()->format('Y-m-d');          // today's date
                    $ip = $this->utils->UserIpAddress();                            // user's ip

                    $thisID = $this->hasTimbrataEntrata($workerID, $today);
                    if ($thisID == 0) {
                        // timbrata in entrata non ancora esistente
                        // esegue timbrata in entrata e ottiene il suo ID
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
                        // timbrata in entrata già esistente
                        // verifica se manca timbrata in uscita
                        if ($this->hasTimbrataUscita($workerID, $today) == 0) {
                            // esegue timbrata in uscita
                            DB::table('attendances')->where('id', $thisID)
                            ->update(
                                array(
                                    'exit_date' => $this->utils->OraItaliana(),
                                    'exit_ip' => $ip,
                                    'check' => 1,
                                    'updated_at' => $this->utils->OraItaliana()
                                )
                            );
                            $this->setStatus($workerID, 0);         // sets worker's status to 0
                        } else {
                            // timbrate E/U entrambi esistenti
                            // non è richiesta timbratura
                            $errorMessage = 'hai già eseguito tutte le timbrate della giornata';
                            return 0;
                        }
                    }
                    return $thisID;
                } else {
                    // password not valid
                    $errorMessage = 'hai digitato un codice timbrata non valido';
                    return 0;
                }
            } else {
                // worker not hired
                $errorMessage = 'il dipendente selezionato non è presente in archivio o non è abilitato';
                return 0;
            }
        } else {
            // worker doesn't exists
            $errorMessage = 'Dipendente non trovato';
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
     * if the specified worker has en attendace entrance in the specified date
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
     * if the specified worker has en attendace exit in the specified date
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
// #endregion Public Methods

// #region Private Methods
    /*
     * Normalizes worker data
     */
    private function normalizeData($data) {
        $data['nome'] =  strtoupper(trim($data['nome']));
        $data['cognome'] =  strtoupper(trim($data['cognome']));
        $data['codice_fiscale'] =  strtoupper(trim($data['codice_fiscale']));
        $data['matricola'] =  strtoupper(trim($data['matricola']));
        return $data;
    }
// #endregion Private Methods
}
