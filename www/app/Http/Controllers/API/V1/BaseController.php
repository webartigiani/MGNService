<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BaseController extends Controller
{

    public function index(Request $request)
    {
        return 'ok';
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param  array  $errorMessages
     * @param  int  $code
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Sends export
     * - of the specified data
     * - as contentType
     * - with the specified header
     * NOTES:
     *      by default, uses <br> ad row terminator
     *      this will be replaced client-side by \n\r
     */
    public function sendExport($header, $data, $columnSeparator = ';', $contentType = 'text/plain') {

        $output = '';                   // output
        $columnSeparator = ';';         // default column separator

        // normalizes arguments
        $columnSeparator = trim(strtolower($columnSeparator));
        $contentType = trim(strtolower($contentType));
        if ($columnSeparator == '') $columnSeparator = ';';     // default separator and content-type
        if ($contentType == '') $contentType = 'text/plain';

        // inserts header
        if ($header != '') $output = $header . "\r\n";

        // creates data
        foreach ($data as $row) {
            $output .= implode($columnSeparator, (array)$row) . "\r\n";
        }

        // sets headers
        $headers = array(
            'Content-Type' => $contentType
        );

        // exports
        return Response::make(rtrim($output, "\r\n"), 200, $headers);
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     *
     * @return \Illuminate\Http\Response
     */
    public function sendErrorLight($message)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return Unauthorized response.
     *
     * @param $error
     * @param  int  $code
     *
     * @return \Illuminate\Http\Response
     */
    public function unauthorizedResponse($error = 'Forbidden', $code = 403)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        return response()->json($response, $code);
    }
}
