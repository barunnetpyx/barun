<?php 
Class tag_model extends CI_Model {
	function saveTag(){
		$post = $this->input->post();
		$data['ma_affid'] = $post['name'];
		$data['code_desc'] = nl2br($post['code_desc']);
		$data['status'] = 1;
		$data['code'] = trim(urlencode(addslashes($post['code'])));
		$this->db->insert('ma_tags', $data);
		return $this->db->insert_id();
	}
	function getAllTags(){
		$this->db->select('a.*, u.name, u.id as userid');
        $this->db->from('ma_tags AS a');
		$this->db->join('users AS u', 'u.id = a.ma_affid', 'left');
		$query = $this->db->get();
        return $query->result();
	}
	function getTheTag($id){
		$this->db->select('*');
        $this->db->from('ma_tags');
		$this->db->where('id', $id);
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}
	function getUserTags($id){
		$this->db->select('a.*, u.name, u.id as userid');
        $this->db->from('ma_tags AS a');
		$this->db->join('users AS u', 'u.id = a.ma_affid', 'left');
		$this->db->where('u.id', $id);
		$query = $this->db->get();
        return $query->result();
	}
	function getTheTagState($id){
		$this->db->select('status');
        $this->db->from('ma_tags');
		$this->db->where('id', $id);
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}
	function setStatus($id){
		$prevState = $this->getTheTagState($id);
		$status = '1';
		if( $prevState->status == 1 ){
			$status = '0';
		}
		$post['status'] = $status;
		$this->db->where('id', $id);
		$this->db->update('ma_tags', $post); 
		return true;
 	}
 	function editTag(){
 		$post = $this->input->post();
		
		$data['code_desc'] = nl2br($post['code_desc']);
		$data['code'] = trim(urlencode(addslashes($post['code'])));
		$this->db->where('id', $post['id']);
		$this->db->update('ma_tags', $data);
		return true;

 	}
}
?>