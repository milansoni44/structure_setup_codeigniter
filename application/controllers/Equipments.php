<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-02 09:53:43 
  * Created By : CLI 
 */ 
 
 class Equipments extends MY_Controller {
 
 	 public function __construct() {
 	 	 parent::__construct();
 	 }

 	 public function index(){
 	 	if($this->input->is_ajax_request()){

 	 	}
 	 	$this->load_content('equipment/equipment_list', $this->data);
 	 }
 }