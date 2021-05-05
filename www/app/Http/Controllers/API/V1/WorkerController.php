<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Workers\WorkerRequest;
use App\Models\Worker;
use Illuminate\Http\Request;
use DB;

class WorkerController extends BaseController
{
    protected $worker = '';

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
        $worker = $this->worker->create([
            'nome' => $request->get('nome'),
            'cognome' => $request->get('cognome'),
            'codice_fiscale' => $request->get('codice_fiscale'),
            'modo_timbratura' => $request->get('modo_timbratura'),
            'data_assunzione' => $request->get('data_assunzione'),
            'data_cessazione' => $request->get('data_cessazione'),
        ]);
        return $this->sendResponse($worker, 'Dipendente Creato con successo');
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
        $worker->update($request->all());
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
}
