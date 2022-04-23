<?php
class Map extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

    }

    public function index(){
        if (empty($this->session->userdata('user'))) {
			redirect('welcome/index');
		}
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('map/map_view');
        $this->load->view('templates/footer');
    }
}
