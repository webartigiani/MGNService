<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Device\DeviceRequest;
use App\Models\Device;
use Illuminate\Http\Request;
use DB;

class DeviceController extends BaseController
{
    protected $device = '';

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Device $device)
    {
        $this->middleware('auth:api');
        $this->device = $device;
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
        $device = DB::table('v_devices')->latest()->paginate(10);
        return $this->sendResponse($device, 'Devices List');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Devices\DeviceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviceRequest $request)
    {
        // get form normalized data
        $data = $this->normalizeData($request->all());

        // inserts data
        $device = $this->device->create([
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
        return $this->sendResponse($device, 'Nuovo device Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $device = $this->device->findOrFail($id);
        return $this->sendResponse($device, 'Dettagli Device');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(DeviceRequest $request, $id)
    {
        $device = $this->device->findOrFail($id);

        // get form normalized data
        $data = $this->normalizeData($request->all());

        // Updates data
        $device->update($data);
        return $this->sendResponse($device, 'Device aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $device = $this->worker->findOrFail($id);
        $device->delete();
        return $this->sendResponse($device, 'Il dispositivo è stato eliminato');
    }
// #endregion API Methods

// #region Public Methods
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
