<?php
defined('BASEPATH') or exit('No direct script access allowed');


class AutoComplete extends CI_Controller{

    public function client_autocomplete(){

        $searchString = $this->input->post();

        $this->load->model('AutoCompleteModel');

        echo $this->AutoCompleteModel->client($searchString);
        

    }

    public function item_autocomplete(){

        $searchString = $this->input->post();

        $this->load->model('AutoCompleteModel');

        echo $this->AutoCompleteModel->item($searchString);
        

    }

}