<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tag extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->model('tag_model', '', TRUE);
		$this->load->model('user', '', TRUE);
		//$this->output->enable_profiler(TRUE);
		
    }
    function index(){
    	$data['tags']  = $this->tag_model->getAllTags();
    	$user = $this->session->userdata('logged_in'); 
		if (!$this->session->userdata('logged_in') || $user['type'] != 1 ) {
			$this->load->model('api_model', '', TRUE);	
			$apiData = $this->api_model->getTheAPI($user['id']);		
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
			$data['tags']  = $this->tag_model->getUserTags($user['id']);
		}
		$data['title'] = "All API";
		
		$this->load->view('tag_view', $data );
    }
    function create(){
		$user = $this->session->userdata('logged_in'); 
		if (!$this->session->userdata('logged_in') || $user['type'] != 1 ) {
			redirect('users/detail/');
		}
		$this->load->library('form_validation');
		$data['users'] = $this->user->getAllUsers();
		$data['title'] = "Create API";
		if($this->input->post('addScript') && $user['type'] == 1 ){
			//This method will have the credentials validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');			
			$this->form_validation->set_rules('code', 'Ad Code', 'trim|required|prep_for_form');
			$this->form_validation->set_rules('code_desc', 'Description', 'trim|required|prep_for_form');			
			
			if ($this->form_validation->run() == FALSE) {
				//Field validation failed.  User redirected to login page
				$this->load->view('tag_create_view', $data );
				
			} else {
				if($this->tag_model->saveTag() > 0){
					redirect('tag');
				}else{
					$this->load->view('tag_create_view', $data );	
				}
			}
        }else{		
			$this->load->view('tag_create_view', $data );
		}
	}
	function edit($id = 0){
		
		$user = $this->session->userdata('logged_in'); 
		if (!$this->session->userdata('logged_in') || $user['type'] != 1 ) {
			redirect('users/detail/');
		}
		$this->load->library('form_validation');
		$data['title'] = "Edit Tags";
		$data['tag'] = $this->tag_model->getTheTag($id);
		if($this->input->post('addScript') && $user['type'] == 1 ){
			//This method will have the credentials validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('code', 'Ad Code', 'trim|required|prep_for_form');
			$this->form_validation->set_rules('code_desc', 'Description', 'trim|required|prep_for_form');			
			
			if ($this->form_validation->run() == FALSE) {
				$post = $this->input->post();
				$data['tag'] = $this->tag_model->getTheTag($post['id'] );	
				$this->load->view('tag_edit_view', $data );	
				
			} else {
				if($this->tag_model->editTag() > 0){
					redirect('tag');
				}else{
					$this->load->view('tag_edit_view', $data );	
				}
			}
        }else{
        	if($id > 0){		
				$this->load->view('tag_edit_view', $data );
			}else{
				redirect('tag');
			}
		}
		
	}
    function createTag(){
		$user = $this->session->userdata('logged_in'); 
		if($this->input->post('addScript') && $user['type'] == 1 ){
			//This method will have the credentials validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');			
			$this->form_validation->set_rules('code', 'Ad Code', 'trim|required|prep_for_form');
			$this->form_validation->set_rules('code_desc', 'Description', 'trim|required|prep_for_form');			
			$data['users'] = $this->user->getAllUsers();
			$data['title'] = "Create API";
			if ($this->form_validation->run() == FALSE) {
				//Field validation failed.  User redirected to login page
				$this->load->view('tag_create_view', $data );
				
			} else {
				if($this->tag_model->saveTag() > 0){
					redirect('tag');
				}else{
					$this->load->view('tag_create_view', $data );	
				}
			}
        }else{
			redirect('tag');
		}
    }
    function status($id = 1){
		$logedInUser = $this->session->userdata('logged_in'); 
		if($logedInUser['type'] == 1){
			$this->tag_model->setStatus($id);
			redirect('tag');
		}else{
			redirect('users/detail');
		}
	}
}    