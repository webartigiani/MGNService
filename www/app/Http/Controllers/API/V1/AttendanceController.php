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
use DB;

class AttendanceController extends BaseController
{
    protected $attendance = '';
    private $workerController;

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Attendance $attendance, WorkerController $workerController)
    {
        $this->attendance = $attendance;
        $this->workerController = $workerController;
    }
// #endregion Constructor

// #region API Methods
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   /*
        v_timbrate: see migration
        */
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
