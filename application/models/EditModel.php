<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EditModel extends CI_Model{

    function edit_data($editData){

        $table_name = $editData['table']; // table name
        $id = $editData['id']; // id
        $key = $editData['key']; // key 


        $query = $this->db->where($key, $id)->get($table_name);

        $result =  $query->row();

        // removing password from data 
        
        if (isset($editData['password'])) {
            if($result->password){
                unset($result->password);
            }
        }

        return json_encode($result);

    }

}