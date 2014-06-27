<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Payment extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('payment_model', '', TRUE);
		$this->load->model('user', '', TRUE);
		//$this->output->enable_profiler(TRUE);
		
	}
	function index(){
		$user = $this->session->userdata('logged_in'); 
		if (!$this->session->userdata('logged_in') ) {
			redirect('users');
		}
		$data['title'] = "All Payment";
		if($user['type'] != 1){
			$id = $user['id'];
			$data['payment']  = $this->payment_model->getUserPayment($id);
		}else{ 
			$data['payment']  = $this->payment_model->getAllPayment();
		}
		$this->load->view('payment_view', $data );
	}
	
	function add(){
		$data['title'] = "Add Payment";
		$this->load->helper(array(
			'form'
			));
		if($this->session->userdata('logged_in')) {
			$user = $this->session->userdata('logged_in'); 
			if($user['type'] == 1){
				
				$data['users'] = $this->user->getAllUsers();
				$this->load->view('payment_add', $data);
			}else{
				redirect('users/detail/'. $user['id']);
			}
		}else{
			redirect('login');
		}
	}
	function addPayment() {
		if($this->input->post('addPayment')){
			//This method will have the credentials validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('name', 'Affiliate name', 'trim|required|xss_clean|integer');
			$this->form_validation->set_rules('interval_month', 'Month', 'trim|required|xss_clean');
			$this->form_validation->set_rules('revenue_type', 'Revenue type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
			$this->form_validation->set_rules('impression', 'Impression', 'trim|integer');			
			
			if ($this->form_validation->run() == FALSE) {
				$data['title'] = "Add Payment";
				//Field validation failed.  User redirected to login page
				$data['users'] = $this->user->getAllUsers();
				$this->load->view('payment_add', $data);
			}else{
				//process save;				
				if($this->payment_model->savePayment() > 0){
					$this->sendAlert($this->input->post('name'), 1, $this->input->post('interval_month'));
					redirect('payment');
				}else{
					redirect('payment');
				}
			}
		}else{
			redirect('payment');
		}
	}
	function getMethod(){
		$id = $this->input->get('aff_id', TRUE);
		$user = $this->user->getTheUser($id);
		echo json_encode($user); die;
	}
	function edit($id){
		$user = $this->session->userdata('logged_in'); 
		if ($this->session->userdata('logged_in') && $user['type'] == 1) {
			$this->load->helper(array(
				'form'
				));
			$data['title'] = " Edit Payment";		
			$data['payment'] = $this->payment_model->getThePayment($id);
			$this->load->view('payment_edit', $data);
		}else{
			redirect('users');
		}
	}
	function editPayment() {
		if($this->input->post('addPayment')){
			//This method will have the credentials validation
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('trans_id', 'Transaction ID', 'trim|required|xss_clean');
			$this->form_validation->set_rules('pay_month', 'Pay Date', 'trim|required');
			
			
			if ($this->form_validation->run() == FALSE) {
				$data['title'] = "Add Payment";
				//Field validation failed.  User redirected to login page
				$post = $this->input->post();
				$id = $post['payID'];
				$data['payment'] = $this->payment_model->getThePayment($id);
				$this->load->view('payment_edit', $data);
			}else{
				$payment = $this->payment_model->editPayment();
				$post = $this->input->post();
				$payment = $this->payment_model->getThePayment($post['payID']);
				$this->sendAlert($payment->userID, 2);
				redirect('payment');
			}
		}else{
			redirect('payment');
		}
	}
	function sendAlert($userId, $type, $interval_month = 0){
		$user = $this->user->getTheUser($userId);
		$this->load->library('email');
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);

		$this->email->from('info@tunemedia.biz', 'TuneMedia');
		$this->email->to($user->email); 
		if(!empty($user->contact_email)){
			$this->email->cc($user->contact_email); 
		}
		
		$this->email->bcc('barun.netpyx@gmail.com'); 
		
		if($type == 1 && $interval_month != '0' ){
			$subject = "Payment Registered";
			$message = "<html>
			<head>
			<title></title>
			</head>
			<body>
			Dear ".$user->name.":<br/><br/>
			We would like to inform you that your payment for your contribution to our Share Revenue Affiliate Program is now being finalized and is being scheduled to be released by the 15th of ".$interval_month.".<br/>
			You will also receive a notification from us once payment is released.<br/>
			Thank you for your patience and continued support.<br/><br/>
			Truly Yours, <br/>
			TuneMedia Team
			
			</body>
			</html> ";
		}else{
			$subject = "Payment made";
			$message = "<html>
			<head>
			<title></title>
			</head>
			<body>
			Dear ".$user->name.":<br/><br/>
			We would like to inform you that our payment for your contribution to our Share Revenue Affiliate Program was released.<br/>
			Thank you for your patience and continued support.<br/><br/>
			Truly Yours,<br/>
			TuneMedia Team
			
			</body>
			</html> ";			
		}
		
		$this->email->subject($subject);
		$this->email->message($message);	

		$this->email->send();

		//echo $this->email->print_debugger();
	}
	
}	