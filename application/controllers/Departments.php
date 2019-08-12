<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends MY_Controller {
	public function __construct(){
		parent::__construct();
		// echo "<pre>"; print_r($this->session->all_userdata());die;
	}

	public function index()
	{
		if($this->input->is_ajax_request()){
			$colsArr = array(
				'name',
				'description',
				'action'
			);

			$query = $this->model->common_select('departments.*')->common_get('departments');
			echo $this->model->common_datatable($colsArr, $query);die;
		}
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

	public function dept_export(){
		$query = $this->model->common_select('departments.name AS department_name, description')->common_get('departments');

		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'departments-'.time().'.xlsx';
		$title = 'Department List';
		$sheetTitle = 'Department List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}

	public function sample(){
		$this->generate_sample_qr();
	}
}