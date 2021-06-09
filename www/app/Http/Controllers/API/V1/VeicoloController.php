<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Veicoli\VeicoloRequest;
use App\Models\Veichle;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\UtilsController;

class VeicoloController extends BaseController
{
    protected $veicolo = '';
    private $utils;

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Veichle $veicolo, UtilsController $utils)
    {
        $this->middleware('auth:api');
        $this->veicolo = $veicolo;
        $this->utils = $utils;
    }
// #endregion Constructor

// #region API Methods
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $veicoli = DB::table('v_veichles')->latest()->paginate(10);
        return $this->sendResponse($veicoli, 'Veichles List');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Veicoli\VeicoloRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VeicoloRequest $request)
    {
        // get form normalized data
        $data = $this->normalizeData($request->all());

        // inserts data
        $veicolo = $this->veicolo->create([
            'manufacter' => $data['manufacter'],
            'model' => $data['model'],
            'licence_plate' => $data['licence_plate'],
            'status' => 0,
            'enabled' => $data['enabled'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        return $this->sendResponse($veicolo, 'Nuovo Veicolo Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $veicolo = $this->veicolo->findOrFail($id);
        return $this->sendResponse($veicolo, 'Dettagli veicolo');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Veicolo  $veicolo
     * @return \Illuminate\Http\Response
     */
    public function update(VeicoloRequest $request, $id)
    {
        $veicolo = $this->veicolo->findOrFail($id);

        // get form normalized data
        $data = $this->normalizeData($request->all());

        // Updates data
        $veicolo->update($data);
        return $this->sendResponse($veicolo, 'Veicolo aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $ret = DB::table('veichles')
            ->where('id', $id)
            ->update(
                array(
                    'enabled' => 0,
                    'updated_at' => $this->utils->OraItaliana()
                )
            );
        return $this->sendResponse('OK', 'Il veicolo è stato disabilitato');
    }
// #endregion API Methods

// #region Public API Methods
    /**
     * Returns Workers counters
     */
    public function getCounters() {
        $dbdata = DB::table('v_veichles_counter')->get();
        return $this->sendResponse($dbdata, 'Veichles Counters');
    }
    /**
     * Lists veichels in use:
     */
    public function listInUse() {
        $sql = "select id, concat(manufacter, ' ', model, ' (', licence_plate, ')') item FROM
                v_veichles where status = 1
                order by item";
        $dbdata = DB::select(DB::raw($sql));
        return $this->sendResponse($dbdata, 'Workers not at work');
    }
// #endregion Public API Methods

// #region Private Methods
    /*
     * Normalizes veicolo data
     */
    private function normalizeData($data) {
        $data['manufacter'] =  strtoupper(trim($data['manufacter']));
        $data['model'] =  strtoupper(trim($data['model']));
        $data['licence_plate'] =  strtoupper(trim($data['licence_plate']));
        return $data;
    }
// #endregion Private Methods
}
