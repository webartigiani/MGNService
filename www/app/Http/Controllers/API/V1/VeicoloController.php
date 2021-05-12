<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Veicoli\VeicoloRequest;
use App\Models\Veichle;
use Illuminate\Http\Request;
use DB;

class VeicoloController extends BaseController
{
    protected $veicolo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Veichle $veicolo)
    {
        $this->middleware('auth:api');
        $this->veicolo = $veicolo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $veicoli = DB::table('v_veichles')->get();
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
            'status_date' => \Carbon\Carbon::now(),
            'enabled' => $data['enabled']
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
        $veicolo = $this->veicolo->findOrFail($id);
        $veicolo->delete();
        return $this->sendResponse($veicolo, 'Il veicolo è stato eliminato');
    }

    /*
     * Normalizes veicolo data
     */
    public function normalizeData($data) {
        $data['manufacter'] =  strtoupper(trim($data['manufacter']));
        $data['model'] =  strtoupper(trim($data['model']));
        $data['licence_plate'] =  strtoupper(trim($data['licence_plate']));
        return $data;
    }
}
