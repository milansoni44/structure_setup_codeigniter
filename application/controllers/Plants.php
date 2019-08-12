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
		if($this->input->is_ajax_request()){
			$colsArr = array(
				'name',
				'description',
				'action'
			);
			$query = $this->model->common_select('plants.*')->common_get('plants');
			echo $this->model->common_datatable($colsArr, $query);die;
		}
		$this->data['page_title'] = 'Plant';
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

	public function pl_export(){
		$query = $this->model->common_select('plants.name as plant_name, description')->common_get('plants');

		$resultData = $this->db->query($query)->result_array();
		$headerColumns = implode(',', array_keys($resultData[0]));
		$filename = 'plants-'.time().'.xlsx';
		$title = 'Plant List';
		$sheetTitle = 'Plant List';
		$this->export( $filename, $title, $sheetTitle, $headerColumns,  $resultData );
	}
 }