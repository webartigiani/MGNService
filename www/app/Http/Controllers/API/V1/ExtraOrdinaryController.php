<?php
/**
 * ExtraOrdinaryController.php
 * controller straordinari
 */
namespace App\Http\Controllers\API\V1;

use App\Http\Requests\ExtraOrdinary\ExtraOrdinaryRequest;
use App\Models\ExtraOrdinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\API\V1\WorkerController;
use App\Http\Controllers\UtilsController;
use DB;
use DateTime;

class ExtraOrdinaryController extends BaseController
{
    protected $extraOrdinary = '';
    private $workerController;
    private $utils;

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ExtraOrdinary $extraOrdinary, WorkerController $workerController, UtilsController $utilsController)
    {
        $this->extraOrdinary = $extraOrdinary;
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
     * Inserts/Updates an ExtraOrdinary
     *
     * @param  App\Http\Requests\ExtraOrdinary\ExtraOrdinaryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExtraOrdinaryRequest $request)
    {
        $data = $this->normalizeData($request->all());

        $workerID =                 $data['worker_id'];
        $ref_date =                 $data['ref_date'];
        $extraordinary_time =            $data['extraordinary_time'];
        $extraordinary_justification =   $data['extraordinary_justification'];

// #region Validations
        if (!$this->workerController->exists($workerID)) {
            // worker doesn't exists
            $this->sendError('Dipendente non trovato', [], 404);
        }
        if (!$this->justificationExists($extraordinary_justification)) {
            // jiustification code doesn't exists
            $this->sendError('Giustificativo straordinario non trovato', [], 404);
        }
// #endregion Validations

        // $this->workerController->deleteAbscence($workerID, $ref_date);
        $time = explode(':', $extraordinary_time);
        $minutes = intval($time[1]) + (intval($time[0]) * 60);

        if ($this->workerController->addExtraOrdinary($workerID, $ref_date, $minutes, $extraordinary_justification)) {
            // justification added/updated/removed
            if ($minutes > 0)
                return $this->sendResponse('OK', 'Straordinario registrato correttamente');
            else
                return $this->sendResponse('OK', 'Straordinario cancellato correttamente');
        } else {
            return $this->sendError('Errore durante la registrazione dello straordinario. Prego, riprova.', [], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->abscence->findOrFail($id);
        return $this->sendResponse($data, 'Dettagli Straordinario');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(ExtraOrdinaryRequest $request, $id)
    {
        // there's no update: just store
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
    /**
     * Returns true if the specified justification code for extra-ordinary work
     */
    public function justificationExists($code) {
        $tableName = 'giustificativi';
        $data = DB::table($tableName)->where('used_for', 'STR')->where('code', $code)->take(1)->get();
        if (isset($data)) return isset($data[0]);
        return false;
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
