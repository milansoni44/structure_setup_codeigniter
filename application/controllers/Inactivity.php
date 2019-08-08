<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-07 13:24:10 
  * Created By : CLI 
 */ 
 
 class Inactivity extends CI_Controller {
 
 	public function __construct() {
 	 	 parent::__construct();
 	 	 $this->load->helper('url');
 	}

 	public function check_inactivity(){
 		$response = array();
		$sessionLife = time() - $this->session->userdata('last_time');
		if( $sessionLife > INACTIVITY_TIMER_START_TIME &&  $sessionLife < INACTIVITY_TIMER_END_TIME ){
			$response = array(
				'start_timer'=>true,
				'redirect_url'=>NULL
			);
		}else if( $sessionLife > INACTIVITY_TIMER_END_TIME ){
			$response = array(
				'start_time'=>false,
				'redirect_url'=>base_url().'index.php/auth/logout'
			);
		}
		echo json_encode($response);die;
	}

	public function clear_cache(){
		$this->output->delete_cache('/cache');
	}
 }