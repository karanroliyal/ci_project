<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DistrictModel extends CI_Model{

    public function district($state_id){

        $this->db->select('district_id');
        $this->db->select('district_name');
        $this->db->where('state_id' , $state_id['state_id']);
        $query = $this->db->get('district_master');


        $district_options = "";

        foreach($query->result_array() as $row){

            $district_options .= "<option class='dynamic_district' value='{$row['district_id']}'>{$row['district_name']}</option>";

        }

        echo json_encode(['district_options' => $district_options]);

        

    }

}


