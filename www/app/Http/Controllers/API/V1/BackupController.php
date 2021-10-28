<?php

namespace App\Http\Controllers\API\V1;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\DumpController;

class BackupController extends BaseController
{
    private $dumpController;

// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DumpController $dump)
    {
        $this->middleware('auth:api');
        $this->dumpController = $dump;
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
        return $this->dumpController->listDumps();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Veicoli\BackupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store() {}

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Veicolo  $veicolo
     * @return \Illuminate\Http\Response
     */
    public function update($id) {}

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {}
// #endregion API Methods
}
