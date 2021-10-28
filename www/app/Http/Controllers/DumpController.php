<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use DB;
use stdClass;

class DumpController extends Controller
{
    private $utils;
    private $dumpFolder = 'dumps';                  // dumps folder (under "public")

// #region Contructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UtilsController $utils)
    {
        $this->utils = $utils;
    }
// #endregion Contructor

    public function listDumps() {
        /* Returns the list of created dumps
            [
                {
                    "filename":"20210630_tracking.sql.gz",
                    "size":209172,
                    "date":"27-10-2021",
                    "time":"14:45:19"
                }
            ]
        */
        $ret = [];

        $path = public_path() . "/{$this->dumpFolder}";         // creates the public/dumps folder
        if (!File::exists($path)) File::makeDirectory($path);

        $files = File::allFiles($path);
        foreach($files as $file)
        {   $pi = pathinfo($file);              // gets file info

            $fileName = $pi['filename'] . '.' .  $pi['extension'];
            $fileSize = filesize("{$path}/{$fileName}");
            $fileTime = filemtime("{$path}/{$fileName}");

            $obj = new stdClass;
            $obj->filename = $fileName;
            $obj->size = $fileSize;
            $obj->date = date('d-m-Y', $fileTime);
            $obj->time = date('H:i:s', $fileTime);
            array_push($ret, $obj);
        }
        return $ret;
    }

    public function dumpTracking() {
        // Creates a "tracking" (sessions and data) dump
        //  > uses command:     php artisan db:masked-dump output-filename.sql --definition=tracking --gzip
        //  > path:             by default, masked-dump writes into ./public. We create a sub-folder "dumps"
        //  > fileName:         contains current date yyyymmdd
        //  > gzip:             compress the dump
        // Returns the generated filename, relative to root
        //  ex:     public/dumps/20211027_tracking.sql.gz

        $path = public_path() . "/{$this->dumpFolder}";         // creates the public/dumps folder
        if (!File::exists($path)) File::makeDirectory($path);

        $definition = 'tracking';                               // dump definition and filename suffix (see config/masked-dump.php)
        $fileName = $this->utils->OraItaliana()->format('Ymd') . "_{$definition}";
        Artisan::call("db:masked-dump {$this->dumpFolder}/{$fileName}.sql --definition={$definition} --gzip");
        // use  return Artisan::output();   to get the command output


        return "public/{$this->dumpFolder}/{$fileName}.sql.gz";
    }
}
