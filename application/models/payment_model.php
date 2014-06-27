<?php 
Class payment_model extends CI_Model {
	function getAllPayment(){
		$this->db->select('*, p.status as pay_status');
        $this->db->from('tbl_payment AS p');
		$this->db->join('users AS u', 'u.id = p.userID', 'left');
		$this->db->where('p.pay_type', '2');
		$query = $this->db->get();
        return $query->result();
	}
	function getThePayment($id){
		$this->db->select('*, p.status as pay_status');
        $this->db->from('tbl_payment AS p');
		$this->db->join('users AS u', 'u.id = p.userID', 'left');
		$this->db->where('p.pay_type', '2');
		$this->db->where('p.payID', $id);
		$query = $this->db->get();
        return $query->row();
	}
	function getUserPayment($id){
		$this->db->select('*, p.status as pay_status');
        $this->db->from('tbl_payment AS p');
		$this->db->join('users AS u', 'u.id = p.userID', 'left');
		$this->db->where('p.pay_type', '2');
		$this->db->where('u.id', $id);
		$query = $this->db->get();
        return $query->result();
	}
	function savePayment(){
		$post = $this->input->post();
		
		$post['userID'] = $post['name'];
		
		if($post['method'] == 'PayPal'){
			$post['method']  = '1';
		}else{
			$post['method']  = '2';
		}
		$post['to_date'] = date("Y-m-d H:i:s", strtotime($post['interval_month']));
		$post['pay_type'] = '2'; $post['status'] ='0'; 
		unset($post['addPayment']); unset($post['interval_month']); unset($post['name']); unset($post['payment_method']);
		//echo "<pre>", print_r($post); echo "</pre>"; die;
		$this->db->insert('tbl_payment', $post);
		return $this->db->insert_id();
		
	}
	function editPayment(){
		$post = $this->input->post();
		$data['transactionID'] = $post['trans_id'];
		$data['payDate'] = date("Y-m-d H:i:s", strtotime($post['pay_month']));
		$data['status'] = '1';
		$this->db->where('payID', $post['payID']);
		$this->db->update('tbl_payment', $data); 
	}
}	