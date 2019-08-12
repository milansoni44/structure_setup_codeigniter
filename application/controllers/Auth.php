<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-06 16:34:45 
  * Created By : CLI 
 */ 
 
 class Auth extends CI_Controller {
 
 	public function __construct() {
 	 	parent::__construct();
 	 	$this->load->helper('url');
 	 	$this->load->library('session');
 	}

 	public function login(){
 		// check whether user already logged in or not
 		if( $this->session->userdata('id') ){
 			$this->session->set_flashdata('message', 'You are already logged in.');
 			redirect('departments', 'location');
 		}
 		if($this->input->server('REQUEST_METHOD') == 'POST'){
 			// echo "<pre>"; print_r($_REQUEST);die;
 		}
 		$response = array(
 			"error"=>true
 		);
 		if($this->input->is_ajax_request()){
 			// echo "<pre>"; print_r($_REQUEST);die;
 			
 			$username = $this->input->post('username');
 			$password = $this->input->post('password');
 			$redirect  = $this->input->post('redirect_url');

 			if($username && $password){
 				$query = $this->db->select("*")
 								  ->from('users')
 								  ->where("(users.email = '{$username}' OR users.username = '{$username}')")
 								  ->where('password', $password)
 								  ->get()
 								  ->row_array();
 				if(!empty($query)){
 					$msg = 'You are logged in successfully.';
 					$type = 'message';
					$response = array(
						'error'=>false,
						'message'=>$msg,
						'redirect_url'=>$redirect
					);
					$this->session->set_userdata($query);
 				}else{
 					$type = 'error';
 					$msg = 'Username or password is wrong.';
 					$response['message'] = $msg;	
 				}
 			}else{
 				$type = 'error';
 				$msg = 'Username and password is required.';
 				$response['message'] = $msg;
 			}
 			$this->session->set_flashdata($type, $msg);
 			echo json_encode($response);die;
 		}

 		$this->data['page_title'] = "Login";
 		$this->load->view('auth/login', $this->data);
 	}

 	public function logout(){
 		$this->session->sess_destroy();
 		redirect('auth/login', 'location');
 		die;
 	}
 }