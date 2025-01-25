<?php
defined('BASEPATH') or exit('No direct script access allowed');


class InsertModel extends CI_Model
{

    // This function insert data into database
    function insert($formData)
    {

        $update = "";
        if (isset($formData['action'])) {
            $id = $formData['id'];
            unset($formData['id']);
            $update = $formData['action'];
            unset($formData['action']);
        } else {
            unset($formData['id']);
        }

        if (isset($formData['upload-path-of-image'])) {
            unset($formData['upload-path-of-image']);
        }

        $table_name = $formData['table'];

        unset($formData['table']);



        // array element to String 
        foreach ($formData as $key => $value) {

            if (is_array($value)) {
                $val = implode(", ", $value);
                $formData[$key] = $val;
            }
        }

        if($update == 'update'){
            $this->db->where('id', $id);
            $this->db->update($table_name, $formData);
        }else{
            $this->db->insert($table_name, $formData);
        }


        return json_encode(['status' => 'success', 'form' => $formData, 'table_name' => $table_name]);
    }
}
