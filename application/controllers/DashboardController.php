<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller{

    public function index(){

        $this->load->view('dashboard');

    }
    public function layout(){

        $this->load->view('layout');

    }

}