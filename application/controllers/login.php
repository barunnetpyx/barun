<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$data['title'] = " User Login";
        $this->load->helper(array(
            'form'
        ));
        $this->load->view('login_view', $data);
		 if ($this->session->userdata('logged_in')) {
            $session_data     = $this->session->userdata('logged_in');
            $data['username'] = $session_data['username'];
            $this->load->view('dashboard_view', $data);
			redirect('dashboard');
        }
    }
    
}

?>
