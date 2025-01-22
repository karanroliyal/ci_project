<?php
defined('BASEPATH') or exit('No direct script access allowed');


class TableController extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){

        $livedata = $this->input->post();

        // print_r($livedata);

        $this->load->model('tablemodel');

        $modelData = $this->tablemodel->createTable($livedata);

        // print_r($modelData);

        echo $modelData;

    }

}