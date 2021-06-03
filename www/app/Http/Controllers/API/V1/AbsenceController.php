<?php
/**
 * AbscenceController
 * controller presenze
 */
namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Abscence\AbscenceRequest;
use App\Models\Abscence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\API\V1\WorkerController;
use App\Http\Controllers\UtilsController;
use DB;
use DateTime;

class AbsenceController extends BaseController
{
    protected $abscence = '';
    private $workerController;
    private $utils;

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Abscence $abscence, WorkerController $workerController, UtilsController $utilsController)
    {
        $this->abscence = $abscence;
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
    {   // not implemented
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Abscence\AbscenceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbscenceRequest $request)
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
    public function update(AbscenceRequest $request, $id)
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


// #region Public Methods
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
