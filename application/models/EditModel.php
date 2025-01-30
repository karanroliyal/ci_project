<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EditModel extends CI_Model
{

    function edit_data($editData)
    {

        $table_name = $editData['table']; // table name
        $id = $editData['id']; // id
        $key = $editData['key']; // key 

        $this->db->from($table_name);

        if ($table_name == "invoice_master") {

            $this->db->join('client_master cm', 'invoice_master.client_id = cm.id');
            $key = 'invoice_master.invoice_id';
        }

        $query = $this->db->where($key, $id)->get();

        $result =  $query->row();

        // removing password from data 

        if (isset($editData['password'])) {
            if ($result->password) {
                unset($result->password);
            }
        }

        

        if ($table_name == 'invoice_master') {

            $this->db->from('invoice');
            $this->db->join('item_master', 'invoice.item_id = item_master.id');
            $this->db->where('invoice_id',$id );
            $other = $this->db->get('')->result();
            return json_encode(['data'=>$result , 'item'=>$other]);

        }


        return json_encode($result);
    }
}
