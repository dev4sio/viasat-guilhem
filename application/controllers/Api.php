<?php
class Api extends CI_Controller
{
    private $geoJsonFileContent = null;
    private $viafleetApiKey = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }


    private function CsvToJson($fileName)
    {
        $url = getcwd() . '\\application\\controllers\\uploads\\';
        $stream = fopen($url . $fileName, "r");
        //header du csv
        $key = fgetcsv($stream, "0", ","); // la premiere ligne est parsée alors le pointeur passe à la ligne suivante

        $json = array();

        while ($row = fgetcsv($stream, "1024", ",")) { //commence par l'index 1, fgetcsv retourne false à la fin
            $json[] = array_combine($key, $row);
        }

        // release file handle
        fclose($stream);

        // encode array to json
        return json_encode($json);
    }

    public function getChargingStations()
    {
        header('Content-Type: application/json'); // Specify the type of data
        echo $this->CsvToJson('chargingStations.csv');
    }

    public function getDevices()
    {
        $url = "https://pro.viafleet.io/api/geo/devices";

        header('Content-Type: application/json'); // Specify the type of data
        $ch = curl_init(); // Initialise cUR
        curl_setopt($ch, CURLOPT_URL, $url);
        /// AUTH
        $authorization = "Authorization: Basic YWRtaW4tdGVwaWY6OGdoMzRzWUU=";
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            $authorization,
        )); 
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $result = curl_exec($ch); // Execute the cURL statement
        curl_close($ch); // Close 
        echo $result;die();

    }
}
