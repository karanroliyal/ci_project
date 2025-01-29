<?php
defined('BASEPATH') or exit('No direct script access allowed');


class AutoCompleteModel extends CI_Model{

    function client($clientName){

        $this->db->like($clientName);

        $result = $this->db->get('client_master')->result();

        return json_encode(['object' => $result]);

    }

    function item($itemName){

        if(isset($itemName['arrId'])){
            $arrId = $_POST['arrId'];
    
        $ids = implode(" ," ,$arrId);

            $this->db->where_not_in('id', $ids);
            unset($itemName['arrId']);
            
        }

        $this->db->like($itemName);

        $result = $this->db->get('item_master')->result();

        return json_encode(['object' => $result]);

    }

}















