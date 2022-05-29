<?php
class Charging_station_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_chargingStations(){
        
            $query = $this->db->query('SELECT * FROM chargingstations');
            return $query->result_array();
    
    }

}
