<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IndexController extends CI_Controller{

    public function index(){

        // $this->load->view('index');
        if (!isset($_SESSION['email'])) {
            header("location:".base_url()."logincontroller");
            // exit;
        }
        else{
            header("location:".base_url()."dashboardcontroller/layout");
            // exit;
        }

    }

}

















































