<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Workers\WorkerRequest;
use App\Models\Worker;
use Illuminate\Http\Request;
use DB;

class WorkerController extends BaseController
{
    protected $worker = '';

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Worker $worker)
    {
        $this->middleware('auth:api');
        $this->worker = $worker;
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
        $workers = DB::table('workers')->get();
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
