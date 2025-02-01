<?php
defined('BASEPATH') or exit('No direct script access allowed');


class TableController extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){

        $livedata = $this->input->post();

        $this->load->model('tablemodel');

        $modelData = $this->tablemodel->createTable($livedata);

        echo $modelData;

    }

    public function delete(){

        $deleteData = $this->input->post();

        $this->load->model('tablemodel');

        echo $this->tablemodel->delete($deleteData);

    }

    public function dashboardData(){

        $this->load->model('tablemodel');
        echo $this->tablemodel->dashboardFunction();
        

    }

}