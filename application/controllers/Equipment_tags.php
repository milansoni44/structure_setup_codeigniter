<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-02 11:10:30 
  * Created By : CLI 
 */ 
 
 class Equipment_tags extends MY_Controller {
 	
 	public function __construct() {
 		parent::__construct();
 	}

 	public function index(){
									
		if($this->input->is_ajax_request()){
			$colsArr = array(
				'`equipments`.`name`',
				'`plants`.`name`',
				'`tag_no`',
				'`equipment_use`',
				'action'
			);

			$query = $this
						->model
						->common_select('equipment_tags.*, equipments.name AS `equipment_name`, `plants`.`name` AS 	`plant_name`')
						->common_join('equipments','equipments.id = equipment_tags.equipment_id','LEFT')
						->common_join('plants','plants.id = equipment_tags.plant_id','LEFT')
						->common_get('equipment_tags');
			echo $this->model->common_datatable($colsArr, $query, "equipment_tags.status = 1");die;
		}
 		

 		$this->data['page_title'] = "Equipment Tag";
 		$this->load_content('equipment_tag/tag_list', $this->data);
 	}

 	public function add_update( $id = NULL ){
 		$method = 'Add';
 		$msg = '';
 		$equipmentArr = array(
 			'equipment_id'		=> '',
 			'plant_id'			=> '',
 			'tag_no'			=> '',
 			'equipment_use'		=> ''
 		);
 		if($id){
 			$method = 'Update';
 			$equipmentArr = $this->model->get('equipment_tags', $id, 'id');
 		}

 		if( $this->input->server("REQUEST_METHOD") == "POST" ){
 			$dataArr = array(
 				'equipment_id'			=> $this->input->post('equipment_id'),
 				'plant_id'				=> $this->input->post('plant_id'),
 				'tag_no'				=> $this->input->post('tag_no'),
 				'equipment_use'			=> $this->input->post('equipment_use'),
 			);

 			if($this->model->insert_update($dataArr, 'equipment_tags', $id, 'id')){
				$type = 'message';
				if($id){
					$msg = 'Equipment Tag updated successfully.';
				}else{
					$msg = 'Equipment Tag inserted successfully.';
				}
			}else{
				$type = 'error';
				$msg = 'Some error occured. Try again later.';
			}
			$this->flash($type, $msg);
			redirect('equipment_tags/index', 'location');
 		}

 		$this->data['equipment_tags'] = $equipmentArr;
 		$this->data['id'] = $id;
 		$this->data['equipments'] = $this->model->get('equipments');
 		$this->data['plants'] = $this->model->get('plants');
 		$this->data['page_title'] = $method.' Equipment Tags';
 		$this->load_content('equipment_tag/add_update_tag', $this->data);
 	}
 }