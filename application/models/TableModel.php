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

        $image_path_get = "";
        if(isset($liveFormData['imagePath'])){
            $image_path_get = $liveFormData['imagePath'];
            unset($liveFormData['imagePath']);
        }

        $current_page_opened = $liveFormData['currentPage']; // which page is open
        unset($liveFormData['currentPage']);

        if (in_array('address', $column_names_of_table) && in_array('state', $column_names_of_table) && in_array('district', $column_names_of_table)) {
            array_splice($column_names_of_table, 4, 3);
            $column_names_of_table[4] = 'concat_ws("," , address , sm.state_name , dm.district_name)';
            $column_names_of_table[5] = 'pincode';
        }

        $join_column=[];
        $join_on=[];

        // If there is join avalilable in query 

        if (isset($liveFormData['join_columns'])) {

            $get_join_columns = $liveFormData['join_columns'];
            $get_join_on = $liveFormData['join_on'];

            unset($liveFormData['join_columns']);
            unset($liveFormData['join_on']);

            $join_column = explode(",", $get_join_columns); // join column names
            $join_on = explode(",", $get_join_on); // join column on


        }


        // Offset of data
        $offset = ($current_page_opened - 1) * $limit;


        $this->db->order_by($sort_on_column, $order_by);
         $this->db->select($column_names_of_table)->from($table_name);

         
        $this->db->group_start();
        foreach ($liveFormData as $key => $value) {
            $this->db->like($key, $value);
        }
        $this->db->group_end();

        // if any join available
        if (isset($join_column)) {

            for ($i = 0; $i < count($join_column); $i++) {

                $result = $this->db->join($join_column[$i], $join_on[$i]);

            }
            
        }

        $result = $this->db->get('' , $limit , $offset);

        $offset += 1;

        if ($result->num_rows() > 0 ) {

            $table = "";
            foreach ($result->result_array() as $row) {
                $table .= "<tr><td>$offset</td>";
                for ($i = 0; $i < count($column_names_of_table); $i++) {

                    if($column_names_of_table[$i] == 'image'){

                        $table .= "<td> <img class='table-image' src='" . base_url().$image_path_get."/".$row[$column_names_of_table[$i]] . "'></td>";

                    }
                    elseif($column_names_of_table[$i] == 'item_price'){
                        $table .= "<td> ₹" .  ucwords($row[$column_names_of_table[$i]]) . "</td>";
                    }
                    else{
                        $table .= "<td>" . ucwords($row[$column_names_of_table[$i]]) . "</td>";
                    }

                }
                $offset++;

                // for pdf and mail columns
                if($table_name=='invoice_master'){
                    $table .=  "<td><a><i class='bi bi-file-earmark-pdf-fill text-danger' data-pdfId='{$row[$column_names_of_table[0]]}'></i></a></td>
                    
                                <td><i class='bi bi-envelope-plus-fill text-success' data-mailId='{$row[$column_names_of_table[0]]}'></i></td>";
                }

                $table .= "<td class='text-center'>
                <button class='btn btn-primary rounded-circle' id='editBtn'  data-editid='{$row[$column_names_of_table[0]]}' data-key='" . array_values($column_names_of_table)[0] . "' data-tableName='{$table_name}'><i class='bi bi-pencil-fill'></i></button>
                </td>
                <td class='text-center'>
                <button class='btn btn-danger rounded-circle' id='deleteBtn' data-key='" . array_values($column_names_of_table)[0] . "' data-deleteid='{$row[$column_names_of_table[0]]}' data-tableName='{$table_name}'><i class='bi bi-x-square-fill'></i></button>
                </td>
                </tr>";
            }

            $this->load->helper('pagination');
            $ulData = pageination_builder($liveFormData, $table_name, $current_page_opened, $limit , $join_column , $join_on);


            return json_encode(['table' => $table, 'pagination' => $ulData, 'query' => $this->db->last_query()]);
        } else {

            return json_encode(['table' => "<td class='text-center' colspan='" . (count($column_names_of_table) + 3) . "'><h4>No record found</h4></td>", 'pagination' => "" , 'query' => $this->db->last_query()]);
        }
    }


    function delete($deleteData)
    {

        $this->db->where($deleteData['key'], $deleteData['deleteid']);
        $this->db->delete($deleteData['tableName']);
    }
}
