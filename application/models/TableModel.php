<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TableModel extends CI_Model
{

    function createTable($liveFormData)
    {

        $get_column_names = $liveFormData['columnToShow'];

        $column_names_of_table = explode(",", $get_column_names); // column names
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

        if( in_array('address', $column_names_of_table) && in_array('state', $column_names_of_table) && in_array('district', $column_names_of_table)  ){
            // unset($column_names_of_table[4]);
            // unset($column_names_of_table[5]);
            // unset($column_names_of_table[6]);
            // echo "hello";

            array_splice($column_names_of_table , 4 , 3 );
            $column_names_of_table[4] = 'concat_ws("," , address , state , district)';
            $column_names_of_table[5] = 'pincode';

        }



        

        // Offset of data
        $offset = ($current_page_opened - 1) * $limit;

        foreach ($liveFormData as $key => $value) {
            $this->db->like($key, $value);
        }
        $this->db->order_by($sort_on_column, $order_by);
        $result = $this->db->select($column_names_of_table)->get($table_name, $limit, $offset);

        $offset += 1;

        if ($result->num_rows()) {

            $table = "";
            foreach ($result->result_array() as $row) {
                $table .= "<tr><td>$offset</td>";
                for ($i = 0; $i < count($column_names_of_table); $i++) {
                    $table .= "<td>" . ucwords($row[$column_names_of_table[$i]]) . "</td>";
                }
                $offset++;
                $table .= "<td class='text-center'>
                <button class='btn btn-primary rounded-circle' id='editBtn'  data-editid='{$row[$column_names_of_table[0]]}' data-key='" . array_values($column_names_of_table)[0] . "' data-tableName='{$table_name}'><i class='bi bi-pencil-fill'></i></button>
                </td>
                <td class='text-center'>
                <button class='btn btn-danger rounded-circle' id='deleteBtn' data-deleteid='{$row[$column_names_of_table[0]]}' data-tableName='{$table_name}'><i class='bi bi-x-square-fill'></i></button>
                </td>
                </tr>";
            }

            $this->load->helper('pagination');
            $ulData = pageination_builder($liveFormData, $table_name, $current_page_opened, $limit);


            return json_encode(['table' => $table, 'pagination' => $ulData]);
        } else {

            return json_encode(['table' => "<td class='text-center' colspan='" . (count($column_names_of_table) + 3) . "'><h4>No record found</h4></td>", 'pagination' => ""]);
        }
    }
}
