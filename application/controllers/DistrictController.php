<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DistrictController extends CI_Controller{

    public function index(){

        $state_id = $this->input->post();
        $this->load->model('districtmodel');
        echo $this->districtmodel->district($state_id);

    }


}