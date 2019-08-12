<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-06 15:32:54 
  * Created By : CLI 
 */ 
 
 class Equipment_types extends MY_Controller {
 
 	 public function __construct() {
 	 	 parent::__construct();
 	 }

 	public function index()
	{
		if($this->input->is_ajax_request()){
			$colsArr = array(
				'name',
				'description',
				'action'
			);

			$query = $this->model->common_select('equipment_types.*')->common_get('equipment_types');
			echo $this->model->common_datatable($colsArr, $query);die;
		}
		$this->data['page_title'] = 'Equipment Type';
		//$this->data['sub_page_title'] = 'Overview &amp; stats';
		$this->load_content('equipment_type/equipment_type_list', $this->data);
	}

	public function save(){
		$response = array(
			'error' =>true
		);
		if($this->input->is_ajax_request()){
			if($this->input->server("REQUEST_METHOD") == "POST"){
				$id = $this->input->post('equipment_type_id');
				$data = array(
					'name'			=> $this->input->post('name'),
					'description'	=> $this->input->post('description')
				);
				if($this->model->insert_update($data, 'equipment_types', $id, 'id')){
					$response['error'] = false;
					$type = 'message';
					$msg = '';
					if($id){
						$msg = 'Equipment Type updated successfully.';
					}else{
						$msg = 'Equipment Type inserted successfully.';
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

	public function eq_type_export(){
		$query = $this->model->common_select('equipment_types.name as equipment_type, description')->common_get('equipment_types');

		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'equipment_type-'.time().'.xlsx';
		$title = 'Equipment Type List';
		$sheetTitle = 'Equipment Type List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}
 }