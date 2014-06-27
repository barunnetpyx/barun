<?php 
Class video_model extends CI_Model {
	function getAllVideo(){
		$this->db->select('a.*, u.name, u.id as uid');
        $this->db->from('ma_video AS a');
		$this->db->join('users AS u', 'u.id = a.m_affid', 'left');
		$query = $this->db->get();
        return $query->result();
	}
	function getUserVideo($userId){
		$this->db->select('a.*, u.name, u.id as uid');
        $this->db->from('ma_video AS a');
		$this->db->join('users AS u', 'u.id = a.m_affid', 'left');
		$this->db->where('m_affid', intval($userId));
		$query = $this->db->get();
        return $query->result();

	}
	function saveVideo($post){
		$data['m_affid'] = $post['user'];
		$data['title'] = $post['v_title'];
		$data['description'] = $post['v_desc'];
		$data['duration'] = $post['v_duration'];
		$data['video_path'] = $post['upload']['file_name'];
		$data['api'] = $post['v_type'];
		$data['video_thumb'] = $post['video_thumb'];
		$this->db->insert('ma_video', $data);
		return $this->db->insert_id();
	}
	function editVideo($post){
		//echo "<pre>"; print_r($post); echo "</pre>"; die;
		$data['title'] = $post['v_title'];
		$data['description'] = $post['v_desc'];
		$data['duration'] = $post['v_duration'];
		$data['video_path'] = $post['upload']['file_name'];
		$data['api'] = $post['v_type'];
		$data['video_thumb'] = $post['video_thumb'];
		$this->db->where('id', $post['videoId']);
		$this->db->where('m_affid', $post['v_user']);
		$this->db->update('ma_video', $data);	
	}
	function checkYouTube($user, $youtube){
		$this->db->select('a.*, u.name, u.id as uid');
        $this->db->from('ma_video AS a');
		$this->db->join('users AS u', 'u.id = a.m_affid', 'left');
		$this->db->where('m_affid', intval($user));
		$this->db->where('video_path', $youtube);
		$query = $this->db->get();
        return $query->num_rows();
	}
	function getTheVideo($id){
		$this->db->select('a.*, u.name, u.id as uid');
        $this->db->from('ma_video AS a');
		$this->db->join('users AS u', 'u.id = a.m_affid', 'left');
		$this->db->where('a.id', intval($id));
		$query = $this->db->get();
        return $query->row();
	}
	function getTheEditVideo($userId, $id){
		$this->db->select('a.*');
        $this->db->from('ma_video AS a');
		$this->db->where('a.id', intval($id));
		if ($userId != 0) {
			$this->db->where('a.m_affid', intval($userId));
		}
		$query = $this->db->get();
        return $query->row();
	}
	function getTheVideoState($id){
		$this->db->select('status');
        $this->db->from('ma_video');
        $this->db->where('id', $id);
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}
	function setStatus($id){
		$prevState = $this->getTheVideoState($id);
		$status = 1;
		if( $prevState->status == 1 ){
			$status = 0;
		}
		$post['status'] = $status;
		$this->db->where('id', $id);
		$this->db->update('ma_video', $post); 
		return true;
 	}
 	
}