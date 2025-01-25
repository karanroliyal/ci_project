<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EditController extends CI_Controller{

    public function edit(){

        $data = $this->input->post();
        $this->load->model('editmodel');
        $data_from_model = $this->editmodel->edit_data($data);
        echo $data_from_model;

    }

}