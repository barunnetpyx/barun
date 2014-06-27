<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Video extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
		$this->load->model('video_model', '', TRUE);
		//$this->output->enable_profiler(TRUE);
		$user = $this->session->userdata('logged_in'); 
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}elseif($user['can_upload'] != 1){
			redirect('dashboard');
		}
    }
    function index(){
		$user = $this->session->userdata('logged_in'); 
		$data['title'] = "All Video";
		if($user['type'] == 2 ) $data['videos']  = $this->video_model->getUserVideo(intval($user['id']));
		else $data['videos']  = $this->video_model->getAllVideo();
		$this->load->view('video_view', $data );
	}
	function add(){
		$user = $this->session->userdata('logged_in'); 
		$this->load->library('form_validation');
		$data['title'] = "New Video";
		if($user['type'] == 1 ) {
			$this->load->model('user', '', TRUE);
			$data['user'] = $this->user->getAllUploadableUsers(); 	
		} 
		if($this->input->post('addVideo')){
			//This method will have the credentials validation
			$this->form_validation->set_rules('v_type', 'Video type', 'trim|required|xss_clean|numeric');
			if($user['type'] == 1 ) {
				$this->form_validation->set_rules('v_user', 'User', 'trim|required|xss_clean|numeric');
			}			
			if($this->input->post('v_type') == 5){
				$this->form_validation->set_rules('v_youtube', 'YouTube', 'trim|required|callback_validate_youtube');
			}else{
				$this->form_validation->set_rules('v_title', 'Title', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('v_video', 'Video', 'required');			
				$this->form_validation->set_rules('v_duration', 'Duration', 'trim|required|min_length[3]|max_length[5]|callback_validate_time');
				$this->form_validation->set_rules('v_desc', 'Video description', 'trim|required|xss_clean');
			}
			if ($this->form_validation->run() == FALSE) {
				//Field validation failed.  User redirected to login page
				$this->load->view('video_create_view', $data);
				
			} else {
				$v_video = $this->input->post('v_video');
				$v_type = $this->input->post('v_type');
				$post = $this->input->post();
				if($user['type'] == 1 ) {
					$post['user'] =  $this->input->post('v_user');
					$user['username'] = $this->user->getTheUser($post['user'])->username;
				}else $post['user'] = $user['id'];

				if($v_type == 3 && !empty($_FILES)){
					$config['file_name'] = preg_replace('/[^a-zA-Z0-9-_]/','', $user['username'].'_'.random_string('alnum', 16));
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'mp4|flv';
					$config['max_size']	= '100000';
					
					//echo "<pre>"; print_r($config); echo "</pre>"; die;

					$this->load->library('upload', $config);	
					if ( ! $this->upload->do_upload("v_video")) {
						$data['error'] = $this->upload->display_errors();
						$this->form_validation->set_message('invalid_file', $this->upload->display_errors());
						$this->load->view('video_create_view', $data);
					}else{						
						$post['upload'] = $this->upload->data();
						/*Create Snapshot of the video*/
						$videoPath = './uploads/'.$post['upload']['file_name'];
						$video = escapeshellcmd($videoPath);
						$cmd = "ffmpeg -i $video 2>&1";
						$second = 5;
						$imagePath  = './uploads/images/img_'.$post['upload']['file_name'].'.jpg';
						$cmd = shell_exec("ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $imagePath 2>&1");
						/* /Create Snapshot of the video*/ 
						$post['video_thumb'] = 'img_'.$post['upload']['file_name'].'.jpg';
						$this->video_model->saveVideo($post);
						redirect('video');
					}
				}else if($v_type == 5){
					$this->load->library('YouTube');
					$youtube_url = "http://www.youtube.com/watch?v=".$this->input->post('v_youtube');
					$this->youtube->url = $youtube_url;
					$this->youtube->url2id();
					$info = $this->youtube->info();
					//echo "<pre>"; print_r($info); die;
					if(empty($info)){
						$data['error'] = "Not a valid YouTube video";
						$this->load->view('video_create_view', $data);
					}elseif (filter_var(trim($info['titulo'][0],FILTER_SANITIZE_STRING)) == "Horeee !!! SDA dkk Tersangka Korupsi Dana Haji" || filter_var(trim($info['titulo'][0],FILTER_SANITIZE_STRING)) == "Secundum ASD Atrial Septal Defect Repair") {
						$data['error'] = "Not a valid YouTube video";
						$this->load->view('video_create_view', $data);
					}

					else{
						$user['username'] = preg_replace('/[^a-zA-Z0-9-_]/','', $user['username']); 
						$image = $this->youtube->thumb_url("large");
						$target = "./uploads/images/" .$user['username']; 
						$you_image = file_get_contents($image);
						$imagePath1 = $target.'_you_'.$this->input->post('v_youtube').'.jpg';
						if(file_put_contents($imagePath1, $you_image)){
							$post['video_thumb'] = $user['username'].'_you_'.$this->input->post('v_youtube').'.jpg';
						}
						$post['v_title'] = filter_var(trim($info['titulo'][0],FILTER_SANITIZE_STRING));
						if(isset($info['tempo'])) $post['v_duration'] = trim(filter_var(trim($info['tempo'],FILTER_SANITIZE_STRING)));
						else $post['v_duration'] = '0:00';
						if(isset($info['descricao'])) $post['v_desc'] = filter_var(trim( htmlspecialchars(stripcslashes($info['descricao'])),FILTER_SANITIZE_STRING));
						else $info['descricao'] = "";
						$post['v_desc']= preg_replace( '/\s+/', ' ', $post['v_desc'] );
						$post['upload']['file_name'] = $this->input->post('v_youtube');
						$this->video_model->saveVideo($post);
						redirect('video');
					}
				}
			}
		}else{
			$this->load->view('video_create_view', $data);
		}
       
	}
	function edit( $id = 0 ){
		$data['title'] = 'Edit Video';
		$user = $this->session->userdata('logged_in'); 
		$this->load->library('form_validation');
		$this->load->model('user', '', TRUE);
		if ($this->input->post('editVideo')) {
			/*Edit Video*/
			$post = $this->input->post();
			$data['video'] = $video = $this->video_model->getTheEditVideo($post['v_user'], $post['videoId']);
			//This method will have the credentials validation
			$this->form_validation->set_rules('v_type', 'Video type', 'trim|required|xss_clean|numeric');
			if($this->input->post('v_type') == 5){
				$this->form_validation->set_rules('v_youtube', 'YouTube', 'trim|required|callback_validate_youtube');
			}else{
				$this->form_validation->set_rules('v_title', 'Title', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('v_video', 'Video', 'required');			
				$this->form_validation->set_rules('v_duration', 'Duration', 'trim|required|min_length[3]|max_length[5]|callback_validate_time');
				$this->form_validation->set_rules('v_desc', 'Video description', 'trim|required|xss_clean');
			}
			if ($this->form_validation->run() == FALSE) {
				//Field validation failed.  User redirected to login page
				$this->load->view('video_edit_view', $data);
				
			} else {
				$v_video = $this->input->post('v_video');
				$v_type = $this->input->post('v_type');
				
				$user['username'] = $this->user->getTheUser($post['v_user'])->username;

				if($v_type == 3 && !empty($_FILES)){
					$config['file_name'] = preg_replace('/[^a-zA-Z0-9-_]/','', $user['username'].'_'.random_string('alnum', 16));
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'mp4|flv';
					$config['max_size']	= '100000';
					
					//echo "<pre>"; print_r($config); echo "</pre>"; die;

					$this->load->library('upload', $config);	
					if ( ! $this->upload->do_upload("v_video")) {
						$data['error'] = $this->upload->display_errors();
						$this->form_validation->set_message('invalid_file', $this->upload->display_errors());
						$this->load->view('video_edit_view', $data);
					}else{						
						$post['upload'] = $this->upload->data();
						/*Create Snapshot of the video*/
						$videoPath = './uploads/'.$post['upload']['file_name'];
						$video = escapeshellcmd($videoPath);
						$cmd = "ffmpeg -i $video 2>&1";
						$second = 5;
						$imagePath  = './uploads/images/img_'.$post['upload']['file_name'].'.jpg';
						$cmd = shell_exec("ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $imagePath 2>&1");
						/* /Create Snapshot of the video*/ 
						$post['video_thumb'] = 'img_'.$post['upload']['file_name'].'.jpg';
						$this->video_model->editVideo($post);
						redirect('video');
					}
				}else if($v_type == 5){
					$this->load->library('YouTube');
					$youtube_url = "http://www.youtube.com/watch?v=".$this->input->post('v_youtube');
					$this->youtube->url = $youtube_url;
					$this->youtube->url2id();
					$info = $this->youtube->info();
					//echo "<pre>"; print_r($info); die;
					if(empty($info)){
						$data['error'] = "Not a valid YouTube video";
						$this->load->view('video_edit_view', $data);
					}elseif (filter_var(trim($info['titulo'][0],FILTER_SANITIZE_STRING)) == "Horeee !!! SDA dkk Tersangka Korupsi Dana Haji" || filter_var(trim($info['titulo'][0],FILTER_SANITIZE_STRING)) == "Secundum ASD Atrial Septal Defect Repair") {
						$data['error'] = "Not a valid YouTube video";
						$this->load->view('video_edit_view', $data);
					}

					else{
						$user['username'] = preg_replace('/[^a-zA-Z0-9-_]/','', $user['username']); 
						$image = $this->youtube->thumb_url("large");
						$target = "./uploads/images/" .$user['username']; 
						$you_image = file_get_contents($image);
						$imagePath1 = $target.'_you_'.$this->input->post('v_youtube').'.jpg';
						if(file_put_contents($imagePath1, $you_image)){
							$post['video_thumb'] = $user['username'].'_you_'.$this->input->post('v_youtube').'.jpg';
						}
						$post['v_title'] = filter_var(trim($info['titulo'][0],FILTER_SANITIZE_STRING));
						if(isset($info['tempo'])) $post['v_duration'] = trim(filter_var(trim($info['tempo'],FILTER_SANITIZE_STRING)));
						else $post['v_duration'] = '0:00';
						if(isset($info['descricao'])) $post['v_desc'] = filter_var(trim( htmlspecialchars(stripcslashes($info['descricao'])),FILTER_SANITIZE_STRING));
						else $info['descricao'] = "";
						$post['v_desc']= preg_replace( '/\s+/', ' ', $post['v_desc'] );
						$post['upload']['file_name'] = $this->input->post('v_youtube');
						$this->video_model->editVideo($post);
						redirect('video');
					}
				}
			}
			/* / Edit Video*/
		}elseif ($id != 0 ) {
			$user = $this->session->userdata('logged_in'); 
			if($user['type'] == 1 ) $video = $this->video_model->getTheEditVideo(0, $id);
			else $video = $this->video_model->getTheEditVideo($user['id'], $id);
			if (count($video) == 1) {
				$data['video'] = $video;
				$this->load->view('video_edit_view', $data);
			}else{
				redirect('video');	
			}
			
		}else{
			redirect('video');
		}
	}
	public function validate_time($str)	{
		//Assume $str SHOULD be entered as HH:MM
		$str = explode(':', $str);
		$hh = $str[0];
		$mm = $str[1];
		if (!is_numeric($hh) || !is_numeric($mm)) {
		    $this->form_validation->set_message('validate_time', 'Not numeric');
		    return FALSE;
		}
		else if ((int) $hh > 59 || (int) $mm > 59) {
		    $this->form_validation->set_message('validate_time', 'Invalid time');
		    return FALSE;
		}
		else if (mktime((int) $hh, (int) $mm) === FALSE) {
		    $this->form_validation->set_message('validate_time', 'Invalid time');
		    return FALSE;
		}
		return TRUE;
	}
	function validate_youtube($youtube){
		$user = $this->session->userdata('logged_in'); 
		if($user['type'] == 1 ) {
			$user['id'] =  $this->input->post('v_user');			
		}
		if($this->video_model->checkYouTube($user['id'], $youtube) == 0) return TRUE;
		else { 
			$this->form_validation->set_message('validate_youtube', 'YouTube Video already exist with this account');
			return FALSE;
		}	
	}
	function preview($id = 0){
		if($id != 0){
			$video['data'] = $this->video_model->getTheVideo($id);
			//echo count($video['dat'])
			if(count($video['data']) >= 1){
				$this->load->view('video_preview_view', $video);
			}else{
				redirect('video');
			}
		}
	}
	function status($id = 0){
		if($id != 0){
			$this->video_model->setStatus($id);
			redirect('video');
		}else{
			redirect('video');
		}
	}
}	