<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-02 09:20:30 
  * Created By : CLI 
 */ 
 
 class Plants extends MY_Controller {
 
 	 public function __construct() {
 	 	 parent::__construct();
 	 }

 	public function index()
	{
		// if($this->input->is_ajax_request()){

		// }
		$this->data['plants'] = $this->model->get("plants");
		$this->data['page_title'] = 'Plant';
		//$this->data['sub_page_title'] = 'Overview &amp; stats';
		$this->load_content('plant/plant_list', $this->data);
	}

	public function save(){
		$response = array(
			'error' =>true
		);
		if($this->input->is_ajax_request()){
			if($this->input->server("REQUEST_METHOD") == "POST"){
				$id = $this->input->post('plant_id');
				$data = array(
					'name'			=> $this->input->post('name'),
					'description'	=> $this->input->post('description')
				);
				if($this->model->insert_update($data, 'plants', $id, 'id')){
					$response['error'] = false;
					$type = 'message';
					$msg = '';
					if($id){
						$msg = 'Plant updated successfully.';
					}else{
						$msg = 'Plant inserted successfully.';
					}
					$response['message'] = $msg;
				}
			}else{
				$msg = 'Some error occured. Try again later.';
				$type = 'error';
				$response['message'] = $msg;
			}
		}else{
			$msg = 'No direct script access allowed.';
			$type = 'error';
			$response['message'] = $msg;
		}
		$this->flash($type, $msg);
		echo json_encode($response);die;
	}
 }