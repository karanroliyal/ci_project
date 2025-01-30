<?php
defined('BASEPATH') or exit('No direct script access allowed');


class InsertModel extends CI_Model
{

    // This function insert data into database
    function insert($formData)
    {


        unset($formData['id']);

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


        $this->db->insert($table_name, $formData);


        return json_encode(['status' => 'success', 'form' => $formData, 'table_name' => $table_name]);
    }

    // This function update data into database
    function update($formData)
    {

        $id = $formData['id'];
        unset($formData['id']);
        $table_name = $formData['table'];
        unset($formData['table']);

        $this->db->where('id', $id);
        $this->db->update($table_name, $formData);
        return json_encode(['status' => 'success', 'form' => $formData, 'table_name' => $table_name]);
    }

    // Insert data only for Invoice_master 
    function insertInvoice($formData)
    {

        $table_name = $formData['table']; // table name
        unset($formData['table']);
        unset($formData['name']);
        unset($formData['phone']);
        unset($formData['email']);
        unset($formData['address']);
        unset($formData['item_name']);
        unset($formData['invoice_id']);
        $item_id = $formData['item_id'];
        unset($formData['item_id']);
        $quantity = $formData['quantity'];
        unset($formData['quantity']);
        $amount = $formData['amount'];
        unset($formData['amount']);
        unset($formData['item_price']);


        if ($this->db->insert($table_name, $formData)) {



            $formData['invoice_id'] = $this->db->insert_id(); // last inserted id

            unset($formData['invoice_number']);
            unset($formData['invoice_date']);
            unset($formData['client_id']);
            unset($formData['total_amount']);


            for ($i = 0; $i < count($item_id); $i++) {

                $formData['item_id'] = $item_id[$i];
                $formData['quantity'] = $quantity[$i];
                $formData['amount'] = $amount[$i];

                if (!empty(trim($item_id[$i]))  &&  !empty(trim($quantity[$i])) &&  !empty(trim($amount[$i]))) {

                    $this->db->insert('invoice', $formData);
                }
            }
        }


        return  json_encode(['success' => true]);
    }

    // Update invoice for Invoice_master
    function updateInvoice($updateData)
    {

        unset($updateData['name']);
        unset($updateData['phone']);
        unset($updateData['email']);
        unset($updateData['address']);
        unset($updateData['item_name']);
        unset($updateData['item_price']);
        $table_name = $updateData['table'];
        unset($updateData['table']);
        unset($updateData['action']);
        $quantity = $updateData['quantity'];
        unset($updateData['quantity']);
        $amount = $updateData['amount'];
        unset($updateData['amount']);
        $item_id = $updateData['item_id'];
        unset($updateData['item_id']);
        $id = $updateData['invoice_id'];
        unset($updateData['invoice_id']);

        $this->db->where('invoice_id', $id);

        if ($this->db->update($table_name, $updateData)) {

            $this->db->where('invoice_id', $id);
            if($this->db->delete('invoice')){

                for ($i = 0; $i < count($item_id); $i++) {

                    $formData['item_id'] = $item_id[$i];
                    $formData['quantity'] = $quantity[$i];
                    $formData['amount'] = $amount[$i];
                    $formData['invoice_id'] = $id;

                    if (!empty(trim($item_id[$i]))  &&  !empty(trim($quantity[$i])) &&  !empty(trim($amount[$i]))) {

                        $this->db->insert('invoice', $formData);
                        

                    }
    
                   
                }

                return  json_encode(['success' => true]);

            }
            

        }
    }

    // Generate invoice number
    function generateInvoiveNumber()
    {

        $data = $this->db->select('invoice_id')->from('invoice_master')->order_by('invoice_id', 'desc')->limit(1)->get()->row();

        echo json_encode($data);
    }
}
