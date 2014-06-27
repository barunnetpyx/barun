<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Dashboard extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		//$this->output->enable_profiler(TRUE);
    }
    
    function index() {
		$data['title'] = "Welcome to Dashboard";
        if ($this->session->userdata('logged_in')) {
            $session_data     = $this->session->userdata('logged_in');
            $data['username'] = $session_data['username'];
            $this->load->view('dashboard_view', $data);
        } else {
            redirect('login');
        }
    }    
    function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('login');
    }
    
}

?>
