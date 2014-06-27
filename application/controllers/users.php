<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->model('user', '', TRUE);
		//$this->output->enable_profiler(TRUE);
		if(!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    function index() {
		$data['title'] = "Add User";
        $this->load->helper(array(
            'form'
        ));
		if($this->session->userdata('logged_in')) {
			$user = $this->session->userdata('logged_in'); 
			if($user['type'] == 1){
				$this->load->view('user_view', $data);
			}else{
				redirect('users/detail/'. $user['id']);
			}
        }else{
			redirect('login');
		}
    }
	function addUser() {
		if($this->input->post('addUser')){
			//This method will have the credentials validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|is_unique[users.username]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
			$this->form_validation->set_rules('url', 'URL', 'trim|prep_url');
			$this->form_validation->set_rules('remarks', 'Remarks', 'trim|prep_for_form');
			
			if ($this->form_validation->run() == FALSE) {
				//Field validation failed.  User redirected to login page
				$this->load->view('user_view');
			} else {
				//process save;				
				if($this->user->saveUser() > 0){		
					redirect('users/all');
				}else{
					redirect('users');
				}
			}
        }else{
			redirect('users');
		}
    }
	function all(){
		$this->load->helper('text');
		$data['title'] = "Monitisation Users";
		$data['users'] = $this->user->getAllUsers();
		$user = $this->session->userdata('logged_in'); 
		if($user['type'] == 1){
			$this->load->view('user_list', $data);
		}else{
			redirect('users/detail/'. $user['id']);
		}	
	}
	function detail($id = 1){
		
		$this->load->helper(array(
            'form'
        ));
		
		$this->load->model('api_model', '', TRUE);
		$data['title'] = " User Details";
		$logedInUser = $this->session->userdata('logged_in'); 
		if($logedInUser['type'] != 1){
			$id = $logedInUser['id'];
		}
		$data['user'] = $this->user->getTheUser($id);
		
		$apiData = $this->api_model->getTheAPI($id);
		
		if(count($apiData) > 0){
			$apiDataUnserialse = $this->api_model->unserialize_from_db($apiData->api_data);
			$data['api'] = '<div id="tune_'.($apiData->api_token).'"></div>
<script type="text/javascript">
window.onload=function(){
	tune_height="'.($apiDataUnserialse['height']).'"; tune_width="'.($apiDataUnserialse['width']).'"; tune_set_volume="'.($apiDataUnserialse['volume']).'";
	var scr=document.createElement("script"); scr.type="text/javascript"; scr.src="http://www.tunechannel.tv/api.js?token='.($apiData->api_token).'";
	document.getElementsByTagName("body")[0].appendChild(scr);
}
</script>';
		}
		
		if( count($data['user']) > 0) {
			$this->load->view('user_detail', $data);
		}else{
			redirect('users/all');
		}
	}
	function edit($id = 1){
		
		$this->load->helper(array(
            'form'
        ));
		$logedInUser = $this->session->userdata('logged_in'); 
		if($logedInUser['type'] != 1){
			$id = $logedInUser['id'];
		}
		$this->load->model('api_model', '', TRUE);
		$data['title'] = " Edit User";		
		$data['user'] = $this->user->getTheUser($id);
		$this->load->view('user_edit', $data);
		
	}
	function status($id = 1){
		$logedInUser = $this->session->userdata('logged_in'); 
		if($logedInUser['type'] == 1){
			$data['user'] = $this->user->setStatus($id);
			redirect('users/all');
		}else{
			redirect('users/detail');
		}
	}
	function uploadStatus($id = 1){
		$logedInUser = $this->session->userdata('logged_in'); 
		if($logedInUser['type'] == 1){
			$data['user'] = $this->user->setUploadStatus($id);
			redirect('users/all');
		}else{
			redirect('users/detail');
		}
		
		
	}
	function editUser() {
		$this->load->model('api_model', '', TRUE);
		if($this->input->post('EditUser')){
			//This method will have the credentials validation
			$this->load->library('form_validation');
			
			$post = $this->input->post();
			
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('payment_method', 'Payment method', 'required');
			if($post['payment_method'] == 1){
				$this->form_validation->set_rules('payment_paypal', 'Paypal Email', 'trim|required|valid_email');
			}else{
				$this->form_validation->set_rules('payment_bank_account_name', 'Name (as in Account)', 'trim|required|xss_clean');
				$this->form_validation->set_rules('payment_bank_account_no', 'Account number', 'trim|required|xss_clean');
				$this->form_validation->set_rules('payment_bank_account_res_add', 'Residential Address', 'trim|required|xss_clean');
				$this->form_validation->set_rules('payment_bank_swift_code', 'Swift Code', 'trim|required|xss_clean');
			}
			if(isset($post['npassword']) && !empty($post['npassword'])){
				$this->form_validation->set_rules('npassword', 'Password', 'trim|md5');
			}
			$this->form_validation->set_rules('url', 'URL', 'trim|required|prep_url');
			$this->form_validation->set_rules('remarks', 'Remarks', 'trim|prep_for_form');
			
			if ($this->form_validation->run() == FALSE) {
				
				$data['user'] = $this->user->getTheUser($this->input->post('userId'));
				//Field validation failed.  User redirected to login page
				$this->load->view('user_edit', $data);
			}else{
				//process save;				
				if($this->user->editUser() > 0){	
					$this->api_model->checkTheURL($this->input->post('url'), $this->input->post('userId'));
					redirect('users/all');
				}else{
					redirect('users');
				}
			}
        }else{
			redirect('users/all');
		}
    }	
    
}

?>