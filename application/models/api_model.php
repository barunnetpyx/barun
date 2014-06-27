<?php 
Class api_model extends CI_Model {
	function saveAPI(){
		$post = $this->input->post();
		//$post['video'] = reduce_multiples($post['video']);
		
		$serial['video_id'] = 'WP963715,WV793089';
		$serial['width'] = $post['p_width'];
		$serial['height'] = $post['p_height'];
		$serial['volume'] = $post['p_volume'];
		$serial['website'] = $post['url'];
		
		$data['api_token'] = random_string('alnum', 16);
		$data['api_type'] = 'video';
		$data['api_is_serialize'] = '1';
		$data['api_status'] = '1';
		$data['api_is_deleted'] = '0';
		$data['api_timestamp'] = date("Y-m-d H:i:s");
		$data['embed_type'] = '3';
		$data['api_data'] = $this->serialize_to_db($serial);
		$data['embed_adcode'] = trim(urlencode(addslashes($post['p_code'])));
		
		$data['m_affid'] = $post['userId'];
		
		
		$this->db->insert('api_catalog', $data);
		return $this->db->insert_id();
	}
	function getTheAPIfrmId($id){
		$this->db->select('api_id, api_data, embed_adcode, api_token');
        $this->db->from('api_catalog');
		$this->db->where('api_id', $id);
		$this->db->where('embed_type', '3');
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}
	function getTheAPI($id){
		$this->db->select('*');
        $this->db->from('api_catalog');
		$this->db->where('m_affid', $id);
		$this->db->where('embed_type', '3');
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}
	function checkTheURL($url, $id){
		$this->db->select('api_data');
        $this->db->from('api_catalog');
		$this->db->where('m_affid', $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		$apiData = $query->row();
		
		if(isset($apiData) && !empty($apiData)){
			$apiData = $this->unserialize_from_db($apiData->api_data);
			
			if($url !=  $apiData['website']){
				$apiData['website'] = $url;
				$data['api_data'] = $this->serialize_to_db($apiData);
				$this->db->where('m_affid', $id);
				$this->db->update('api_catalog', $data);	
				
			}
		}	
	}
	function getAllApi(){
		$this->db->select('a.api_id, a.api_token, a.api_timestamp, a.embed_adcode, a.api_status, u.name, u.id as userid');
        $this->db->from('api_catalog AS a');
		$this->db->join('users AS u', 'u.id = a.m_affid', 'left');
		$this->db->where('a.embed_type', '3');
		$query = $this->db->get();
        return $query->result();
	}
	function editAPI(){
		$post = $this->input->post();
		$data =array();
		$prevAPI = $this->checkPrevAPI($post['apiID']);
		$prevAPI->api_data = $this->unserialize_from_db($prevAPI->api_data);
		$flag = 0;
		if( $prevAPI->api_data['height'] != $post['p_height'] ){
			$data['api']['height'] = $post['p_height'];
			$flag = 1;
		}else{
			$data['api']['height'] = $prevAPI->api_data['height'];
		}
		if( $prevAPI->api_data['width'] != $post['p_width'] ){
			$data['api']['width'] = $post['p_width'];
			$flag = 1;
		}else{
			$data['api']['width'] = $prevAPI->api_data['width'];
		}
		if( $prevAPI->api_data['volume'] != $post['p_volume'] ){
			$data['api']['volume'] = $post['p_volume'];
			$flag = 1;
		}else{
			$data['api']['volume']	= $prevAPI->api_data['volume']; 
		}
		if( $prevAPI->embed_adcode != $post['p_code'] ){
			$data['embed_adcode'] = trim(urlencode(addslashes($post['p_code'])));
		}
		$data['api']['video_id'] = $prevAPI->api_data['video_id'];
		$data['api']['website'] = $prevAPI->api_data['website'];
		$data['api_data'] = $this->serialize_to_db($data['api']);
		unset($data['api']);
		$this->db->where('api_id', $post['apiID']);
		$this->db->update('api_catalog', $data);	
		return true;
		
	}
	function checkPrevAPI($id){
		$this->db->select('api_data, embed_adcode');
        $this->db->from('api_catalog');
		$this->db->where('api_id', $id);
		$this->db->limit(1);		
		$query = $this->db->get();		
		return $query->row();
	}
	function getTheAPIState($id){
		$this->db->select('api_status');
        $this->db->from('api_catalog');
		$this->db->where('api_id', $id);
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}
	function setStatus($id){
		$prevState = $this->getTheAPIState($id);
		$status = '1';
		if( $prevState->api_status == 1 ){
			$status = '0';
		}
		$post['api_status'] = $status;
		$this->db->where('api_id', $id);
		$this->db->update('api_catalog', $post); 
		return true;
 	}
 	function getVideos(){
 		$this->db->select('video_id, category_name,title, posted_date, video_full_url, video_upload_path, video_image_new, video_duration');
        $this->db->from('api_videos');
		$this->db->where('vd_api_id', '3');
		$this->db->where('SEC_TO_TIME(TIME_TO_SEC(video_duration)) < "01:00:00"  AND video_duration != "" AND video_duration !="00:00"');		
		$this->db->order_by('posted_date', 'desc');
		$this->db->limit(50);
		$query = $this->db->get();
        return $query->result();

 	}
 	function setPlaylist($video_id){
 		$check = $this->checkPlaylist($video_id);
 		if(count($check) == 0){
	 		$data['video_id'] = $video_id;
	 		$this->db->insert('ma_playlist', $data);
			return $this->db->insert_id();
		}else{
			return 0;
		}
 	}
 	function checkPlaylist($video_id){
 		$this->db->select('*');
        $this->db->from('ma_playlist');
		$this->db->where('video_id', $video_id);
		$query = $this->db->get();
        return $query->result();
 	}
 	function getPlaylist(){
 		$this->db->select('*');
        $this->db->from('ma_playlist');
		$query = $this->db->get();
        return $query->result();
 	}
 	function deletePlaylist($video_id){
 		$this->db->where('video_id', $video_id);
		$this->db->delete('ma_playlist'); 
		return true;
 	}
	function serialize_to_db($data=array()){
		return addslashes(serialize($data));
	}
	function unserialize_from_db($data){
	return unserialize(stripslashes($data));
	}
}

?>