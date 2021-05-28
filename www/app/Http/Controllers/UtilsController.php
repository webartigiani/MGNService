<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use DatePeriod;
use DateInterval;

class UtilsController extends Controller
{
    #region Date/Time Functions
    public function OraItaliana() {
        // data ora correnti in timezone Europe/Rome
        return new DateTime("now", new DateTimeZone('Europe/Rome'));
    }

    function getWeekday($date) {
        // returns the day-of-week for the given date
        // NOTE:    Sunday is 0
        $date = $date->format("Y-m-d");
        return date('w', strtotime($date));
    }

    function getPeriodDays($begin, $end) {
        /**
         * Returns a DatePeriod, day-by-day, from $begin and $end date
         * SAMPLE:
         *      $s = new DateTime('2021-05-06');    // start date
         *      $e = new DateTime('2021-05-28');    // end date
         *      $p = getPeriodDays($s, $e)  // get period
         *      foreach ($p as $dt) {
         *          echo $dt->format("Y-m-d l\n");
         *      }
         */

        $interval = DateInterval::createFromDateString('1 day');
        return new DatePeriod($begin, $interval, $end);
    }
    #endregion Date/Time Functions

    #region Client Functions
    public function UserIpAddress() {
        // returns the user IP
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
    #endregion Client Functions

    #region String Functions
    public function randomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    #endregion String Functions

    #region Normalization Functions
    public function normalizePhoneNumber($number) {
        $number = strtolower(trim($number));
        $number = trim(str_replace(' ', '', $number));
        $number = trim(str_replace('-', '', $number));
        $number = trim(str_replace('/', '', $number));
        $number = trim(str_replace('\\', '', $number));
        $number = trim(str_replace('.', '', $number));
        $number = trim(str_replace('+39', '', $number));
        $number = trim(str_replace('+', '', $number));
        return $number;
    }
    #endregion Normalization Functions

    #region Validations
    public function isValidName($value) {
        // returns true if $value
        // only contains letters, apostrophes and whitespaces
        $pattern = "/^[a-zA-Z' ]*$/i";
        return (preg_match($pattern, $value) != 0);
    }
    public function isValidMailAddress($value) {
        // returns true if $value
        // is a valid email address
        $pattern = "/^[a-z0-9._-]+\@[a-z0-9._-]+\.[a-z0-9]{2,5}$/i";
        return (preg_match($pattern, $value) != 0);
    }
    public function isValidFiscalCode($value) {
        // returns true if $value
        // is a valid fiscal-code
        $pattern = "/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]/i";
        return (preg_match($pattern, $value) != 0);
    }
    public function isValidVATNumber($value) {
        // returns true if $value
        // is a valid vat-number
        $pattern = "/^[0-9]{11}$/";
        return (preg_match($pattern, $value) != 0);
    }
    public function validateVATNumber(&$vatNumber, &$countryCode, &$companyName, &$address, &$zip, &$city, &$state) {
        /*  returns true if VAT number is valid and exists in VIES registry
            also returns
                - vatNumber             correct vat number
                - countryCode           correct country code
                - companyName           companyName
                - address
                - zip
                - city
                - province code


            see:     https://ec.europa.eu/taxation_customs/vies/technicalInformation.html

            POST SOAP:  http://ec.europa.eu/taxation_customs/vies/services/checkVatService

            returns (not valid)
                [
                "countryCode" => "IT"
                "vatNumber" => "XXX"
                "requestDate" => "2021-04-09+02:00"
                "valid" => "false"
                "name" => "---"
                "address" => "---"
                ]

            returns (valid)
                [
                "countryCode" => "IT"
                "vatNumber" => "02804070361"
                "requestDate" => "2021-04-09+02:00"
                "valid" => "true"
                "name" => "AGILE TELECOM S.P.A."
                "address" => """
                    VIA DELLE MAGLIAIE 53
                    41012 CARPI MO
                    """
                ]

        */

        // resets arguments
        $companyName = '';
        $address = '';
        $zip = '';
        $city = '';
        $state = '';

        // normalizes arguments
        $countryCode = strtoupper(trim($countryCode));
        if ($countryCode == '') $countryCode = 'IT';
        $vatNumber = strtoupper(trim($vatNumber));
        $vatNumber = trim(str_replace($countryCode, '', $vatNumber));

        // validates vat number via regex
        if (!$this->isValidVATNumber($vatNumber)) return false;

        $timeout = 30;
        $url = 'http://ec.europa.eu/taxation_customs/vies/services/checkVatService';

        $response = array ();
        $pattern = '/<(%s).*?>([\s\S]*)<\/\1/';
        $keys = array (
                'countryCode',
                'vatNumber',
                'requestDate',
                'valid',
                'name',
                'address'
        );
        $content = "<s11:Envelope xmlns:s11='http://schemas.xmlsoap.org/soap/envelope/'>
                        <s11:Body>
                            <tns1:checkVat xmlns:tns1='urn:ec.europa.eu:taxud:vies:services:checkVat:types'>
                            <tns1:countryCode>%s</tns1:countryCode>
                            <tns1:vatNumber>%s</tns1:vatNumber>
                            </tns1:checkVat>
                        </s11:Body>
                        </s11:Envelope>";
        $opts = array (
                'http' => array (
                        'method' => 'POST',
                        'header' => "Content-Type: text/xml; charset=utf-8; SOAPAction: checkVatService",
                        'content' => sprintf ( $content, $countryCode, $vatNumber ),
                        'timeout' => $timeout
                )
        );
        $ctx = stream_context_create ( $opts );
        $result = file_get_contents ( $url, false, $ctx );
        if (preg_match ( sprintf ( $pattern, 'checkVatResponse' ), $result, $matches )) {
            foreach ( $keys as $key )
                preg_match ( sprintf ( $pattern, $key ), $matches [2], $value ) && $response [$key] = $value [2];
        }

        /* returns
            [
            "countryCode" => "IT"
            "vatNumber" => "XXX"
            "requestDate" => "2021-04-09+02:00"
            "valid" => "false"
            "name" => "---"
            "address" => "---"
            ]
        */
        try {
            // try if service is offline
            $ret = $response['valid'];
            if ($ret) {
                $companyName = $response['name'];
                $countryCode = $response['countryCode'];
                $tmp = $response['address'];

                $arr = explode("\n", $tmp);
                try {
                    $address = $arr[0];         // address
                    $tmp = $arr[1];             // zip city province
                    $arr = explode(" ", $tmp);  // splits and parse zip city province
                    try {
                        $zip = $arr[0];                     // zip
                        $state = $arr[count($arr)-1];       // province
                        for ($i = 1; $i < (count($arr)-1); $i++) {
                            $city .= $arr[$i] . ' ';        // city
                        }
                    } catch (Exception $e) {
                    }
                } catch (Exception $e) {
                }
            }
        } catch (Exception $e) {}

        $address = trim(ucwords(strtolower($address)));
        $city = trim(ucwords(strtolower($city)));
        $zip = trim(strtoupper($zip));
        $state = trim(strtoupper($state));
        return $ret;
    }

    public function isValidPhoneNumber($value) {
        // returns true if $value
        // is a valid phone-number
        $pattern = "/^[0-9]+\/[0-9]+$/";
        return (preg_match($pattern, $value) != 0);
    }
    #endregion Validations
}
