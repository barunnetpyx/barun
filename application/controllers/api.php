<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->model('api_model', '', TRUE);
		//$this->output->enable_profiler(TRUE);
		$user = $this->session->userdata('logged_in'); 
		if (!$this->session->userdata('logged_in') || $user['type'] != 1 ) {
		
		}
    }
    function index(){
		$user = $this->session->userdata('logged_in'); 
		if (!$this->session->userdata('logged_in') || $user['type'] != 1 ) {
			redirect('users/all/');
		}
		$data['title'] = "All API";
		$data['apis']  = $this->api_model->getAllApi();
		$this->load->view('api_view', $data );
	}
	
    function createAPI(){
		$user = $this->session->userdata('logged_in'); 
		if($this->input->post('addAPI') && $user['type'] == 1 ){
			//This method will have the credentials validation
			$this->load->library('form_validation');
			$this->form_validation->set_rules('p_height', 'Height', 'trim|required|xss_clean|numeric');			
			$this->form_validation->set_rules('p_width', 'Width', 'trim|required|xss_clean|numeric');			
			$this->form_validation->set_rules('p_volume', 'Volume', 'trim|required|xss_clean|numeric');			
			//$this->form_validation->set_rules('p_code', 'Ad Code', 'trim|required|prep_for_form');			
			$this->form_validation->set_rules('url', 'URL', 'trim|prep_url|required');
			$this->form_validation->set_rules('userId', 'User ', 'trim|required|is_unique[api_catalog.m_affid]');
			
			if ($this->form_validation->run() == FALSE) {
				//Field validation failed.  User redirected to login page
				$data['title'] = "Create API";
				$data['user'] = $this->input->post('userId');
				$data['url'] = $this->input->post('url');
				$this->load->view('api_create_view', $data );
				
			} else {
				$this->api_model->saveAPI();
				redirect('users/detail/' . $this->input->post('userId'));
			}
        }else{
			redirect('users/all/');
		}
	}
	function edit($id = 1){
		$user = $this->session->userdata('logged_in'); 
		if (!$this->session->userdata('logged_in') || $user['type'] != 1 ) {
			redirect('users/detail/');
		}
		$this->load->library('form_validation');
		$data['title'] = "Edit API";
		$data['api']  = $this->api_model->getTheAPIfrmId($id);
		$data['api']->api_data = $this->api_model->unserialize_from_db($data['api']->api_data);
		$this->load->view('api_edit_view', $data );
	}
	function editAPI(){
		$user = $this->session->userdata('logged_in'); 
		if($this->input->post('addAPI') && $user['type'] == 1 ){
			//This method will have the credentials validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('p_height', 'Height', 'trim|required|xss_clean|numeric');			
			$this->form_validation->set_rules('p_width', 'Width', 'trim|required|xss_clean|numeric');			
			$this->form_validation->set_rules('p_volume', 'Volume', 'trim|required|xss_clean|numeric');			
			//$this->form_validation->set_rules('p_code', 'Ad Code', 'trim|required|prep_for_form');			
			
			if ($this->form_validation->run() == FALSE) {
				//Field validation failed.  User redirected to login page
				$data['title'] = "Edit API";
				$data['api']  = $this->api_model->getTheAPIfrmId($this->input->post('apiID'));
				$data['api']->api_data = $this->api_model->unserialize_from_db($data['api']->api_data);
				$this->load->view('api_edit_view', $data );
				
			} else {
				$this->api_model->editAPI();
				redirect('api');
			}
        }else{
			redirect('api');
		}
	}
	function status($id = 1){
		$logedInUser = $this->session->userdata('logged_in'); 
		if($logedInUser['type'] == 1){
			$this->api_model->setStatus($id);
			redirect('api');
		}else{
			redirect('users/detail');
		}
	}
	function video(){
		$user = $this->session->userdata('logged_in'); 
		if($user['type'] == 1 ){
			$data['title'] = "Manage API video";
			$data['videos'] = $this->api_model->getVideos();
			$data['playlist'] = $this->api_model->getPlaylist();

			$this->load->view('api_video_view', $data );
		}else{
			redirect('users/detail');
		}	
	}
	function videoAssign($video_id){
		$user = $this->session->userdata('logged_in'); 
		if($user['type'] == 1 ){
			if($this->api_model->setPlaylist($video_id)){
				redirect('api/video');
			}else{
				redirect('api/video');
			}
		}else{
			redirect('users/detail');
		}	
	}
	function videoUnAssign($video_id){
		$user = $this->session->userdata('logged_in'); 
		if($user['type'] == 1 ){
			if($this->api_model->deletePlaylist($video_id)){
				redirect('api/video');
			}else{
				redirect('api/video');
			}
		}else{
			redirect('users/detail');
		}		
	}
    
}

?>
