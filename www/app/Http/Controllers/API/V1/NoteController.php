<?php
/**
 * AbscenceController
 * controller presenze
 */
namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Notes\NoteRequest;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\API\V1\WorkerController;
use App\Http\Controllers\UtilsController;
use DB;
use DateTime;

class NoteController extends BaseController
{
    protected $notes = '';
    private $workerController;
    private $utils;

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Notes $notes, WorkerController $workerController, UtilsController $utilsController)
    {
        $this->notes = $notes;
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
     * Inserts/Updates an abscence
     *
     * @param  App\Http\Requests\Notes\NoteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteRequest $request)
    {
        $data = $this->normalizeData($request->all());

        $workerID =                 $data['worker_id'];
        $ref_date =                 $data['ref_date'];
        $notes =                    trim($data['notes']);

// #region Validations
        if (!$this->workerController->exists($workerID)) {
            // worker doesn't exists
            $this->sendError('Dipendente non trovato', [], 404);
        }
// #endregion Validations

        // $this->workerController->deleteAbscence($workerID, $ref_date);

        if ($this->workerController->addNotes($workerID, $ref_date, $notes)) {
            // justification added/updated/removed
            if ($notes != '')
                return $this->sendResponse('OK', 'Note registrate correttamente');
            else
                return $this->sendResponse('OK', 'Note cancellate correttamente');
        } else {
            return $this->sendError('Errore durante la registrazione delle note. Prego, riprova.', [], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   // NOTES: there's no show
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(NoteRequest $request, $id)
    {   // NOTES: there's no update. just store
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   // NOTE: there's no delete
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
