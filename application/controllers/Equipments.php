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

 	 public function index()
	{
		if($this->input->is_ajax_request()){
			$colsArr = array(
				'name',
				'description',
				'action'
			);
			$query = $this->model->common_select('equipments.*')->common_get('equipments');
			echo $this->model->common_datatable($colsArr, $query);die;
		}
		$this->data['page_title'] = 'Equipment';
		//$this->data['sub_page_title'] = 'Overview &amp; stats';
		$this->load_content('equipment/equipment_list', $this->data);
	}

	public function save(){
		$response = array(
			'error' =>true
		);
		if($this->input->is_ajax_request()){
			if($this->input->server("REQUEST_METHOD") == "POST"){
				$id = $this->input->post('equipment_id');
				$data = array(
					'name'			=> $this->input->post('name'),
					'description'	=> $this->input->post('description')
				);
				if($this->model->insert_update($data, 'equipments', $id, 'id')){
					$response['error'] = false;
					$type = 'message';
					$msg = '';
					if($id){
						$msg = 'Equipment updated successfully.';
					}else{
						$msg = 'Equipment inserted successfully.';
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

	public function eq_export(){
		$query = $this->model->common_select('equipments.name as equipment, description')->common_get('equipments');

		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'equipments-'.time().'.xlsx';
		$title = 'Equipments List';
		$sheetTitle = 'Equipments List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}
 }