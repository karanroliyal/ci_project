<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TableModel extends CI_Model{

    function createTable($liveFormData){

        $get_column_names = $liveFormData['columnToShow'];

        $column_names_of_table = explode(",",$get_column_names); // column names
        unset($liveFormData['columnToShow']);

        $table_name = $liveFormData['table_name']; // table name
        unset($liveFormData['table_name']);

        $limit = $liveFormData['pageLimit']; // limit of table data
        unset($liveFormData['pageLimit']);

        $sort_on_column = $liveFormData['sortOn']; // column name on which sorting is perfomed
        unset($liveFormData['sortOn']);

        $order_by = $liveFormData['sortOrder']; // ASC or DESC
        unset($liveFormData['sortOrder']);

        $current_page_opened = $liveFormData['currentPage']; // which page is open
        unset($liveFormData['currentPage']);


        


        $result = $this->db->select($column_names_of_table)->get('user_master')->result();

        return json_encode(['result' => $result]);

    } 

}


