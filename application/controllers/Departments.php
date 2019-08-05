<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		// if($this->input->is_ajax_request()){

		// }
		$this->data['departments'] = $this->model->get("departments");
		$this->data['page_title'] = 'Department';
		//$this->data['sub_page_title'] = 'Overview &amp; stats';
		$this->load_content('department/department_list', $this->data);
	}

	public function save(){
		$response = array(
			'error' =>true
		);
		if($this->input->is_ajax_request()){
			if($this->input->server("REQUEST_METHOD") == "POST"){
				$id = $this->input->post('department_id');
				$data = array(
					'name'			=> $this->input->post('name'),
					'description'	=> $this->input->post('description')
				);
				if($this->model->insert_update($data, 'departments', $id, 'id')){
					$response['error'] = false;
					$type = 'message';
					$msg = '';
					if($id){
						$msg = 'Department updated successfully.';
					}else{
						$msg = 'Department inserted successfully.';
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