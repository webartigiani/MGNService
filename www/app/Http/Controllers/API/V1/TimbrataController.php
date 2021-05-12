<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Timbrate\TimbrataRequest;
use App\Models\Timbrata;
use Illuminate\Http\Request;
use DB;

class TimbrataController extends BaseController
{
    protected $timbrata = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Timbrata $timbrata)
    {
        $this->middleware('auth:api');
        $this->timbrata = $timbrata;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   /*
        v_timbrate: see migration
        */

        // filters, order by, order direction, limit
        $filter_date = trim(strtolower($request->filters_date));
        $order_by = trim(strtolower($request->order_by));
        $order_dir = trim(strtolower($request->order_dir));
        $limit = intval(trim(strtolower($request->limit)));

        if ($order_by == '') $order_by = 'date_time';
        if ($order_dir != 'desc') $order_dir = 'asc';
        if ($limit <= 0) $limit = 999999999;

        // normalizes filters
        $dateFrom = '';
        $dateTo = '';

        if ($filter_date != '') {
            $dateFrom = $filter_date . ' 00:00:00';
            $dateTo = $filter_date . ' 23:59:59';
        }

        $data = DB::table('v_timbrate')
            ->whereBetween('date_time', [$dateFrom, $dateTo])
            ->take($limit)
            ->orderBy('date_time', 'desc')
            ->get();
        return $this->sendResponse($data, 'Timbrate List');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Workers\TimbrataRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimbrataRequest $request)
    {
        // get form normalized data
        $data = $this->normalizeData($request->all());

        // inserts data
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
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->timbrata->findOrFail($id);
        return $this->sendResponse($data, 'Dettagli timbrata');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(TimbrataRequest $request, $id)
    {
        $timbrata = $this->timbrata->findOrFail($id);

        // get form normalized data
        $data = $this->normalizeData($request->all());

        // Updates data
        $timbrata->update($data);
        return $this->sendResponse($timbrata, 'Timbrata aggiornata');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $timbrata = $this->timbrata->findOrFail($id);
        $timbrata->delete();
        return $this->sendResponse($timbrata, 'Timbrata eliminata');
    }

    /*
     * Normalizes worker data
     */
    public function normalizeData($data) {
        return $data;
    }
}
