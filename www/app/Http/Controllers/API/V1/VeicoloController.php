<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Veicoli\VeicoloRequest;
use App\Models\Veicolo;
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
    public function __construct(Veicolo $veicolo)
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
        $data['nome'] =  strtoupper(trim($data['nome']));
        $data['cognome'] =  strtoupper(trim($data['cognome']));
        $data['codice_fiscale'] =  strtoupper(trim($data['codice_fiscale']));
        $data['matricola'] =  strtoupper(trim($data['matricola']));
        return $data;
    }
}
