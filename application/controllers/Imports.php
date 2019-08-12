<?php  
 defined('BASEPATH') OR exit('No direct script access allowed'); 
 /** Developer: Milan Soni 
  * Created Date: 2019-08-06 16:33:20 
  * Created By : CLI 
 */ 
 
 class Imports extends MY_Controller {
 	private $uploadPath;
 	public function __construct() {
 	 	parent::__construct();
 	 	$this->uploadPath = FCPATH."tags".DIRECTORY_SEPARATOR;
 	}

 	public function import_equipment_tags(){
 		if( $this->input->server('REQUEST_METHOD') == 'POST' ){
 			// echo "<pre>"; print_r($_FILES);die;
 			if(isset($_FILES['import_tags']['name']) && $_FILES['import_tags']['name'] != ""){
 				$allowedExtensions = array("xls","xlsx");
 				$ext = pathinfo($_FILES['import_tags']['name'], PATHINFO_EXTENSION);
 				if(in_array($ext, $allowedExtensions)){
 					$file_size = $_FILES["import_tags"]["size"]/1024;
 					if($file_size < 50){
						$file = $this->uploadPath.$_FILES['import_tags']['name'];
						/*$isUploaded = copy($_FILES['import_tags']['tmp_name'], $file);
						if($isUploaded) {
							
						}*/
						$intCount = 1;
						$arrData = $this->readExcel($_FILES['import_tags']['tmp_name']);
						foreach($arrData as $data){
							if($intCount != 1 && $intCount != 2){
								$arrEquipmentData['tag_no'] = $data['A'];
								$arrEquipmentData['equipment_use'] = $data['B'];
								$eq = $data['C'];
								$plant = $data['D'];
								// check whether equipment exist or not
								if($equipments = $this->db->get_where('equipments', array('name'=>$eq))->row_array()){
									$arrEquipmentData['equipment_id'] = $equipments['id'];
								}else{
									$arrEquipmentData['equipment_id'] = $this->model->insert_update(array('name'=>$eq),'equipments');
								}

								// check whether plant exist or not
								if($plants = $this->db->get_where('plants', array('name'=>$eq))->row_array()){
									$arrEquipmentData['plant_id'] = $plants['id'];
								}else{
									$arrEquipmentData['plant_id'] = $this->model->insert_update(array('name'=>$eq),'plants');
								}

								$eqTags = $arrEquipmentData;
								unset($arrEquipmentData['equipment_use']);
								// check whether data of equipment_tags already exist or not
								if(!$this->db->get_where('equipment_tags', $arrEquipmentData)->row_array()){
									$this->model->insert_update($eqTags, 'equipment_tags');
								}
							}
							$intCount++;
						}
						$this->flash('message', 'Tags import successfully.');
 					}else{
 						$this->flash('error', 'Up to 50 MB file upload size is allowed.');
 					}
 				}else{
 					$this->flash('error', 'File you are importing is not valid. Please upload only xls or xlsx file.');
 				}
 			}else{
 				$this->flash('error', 'Please select file to upload.');
 			}
 			redirect('imports/import_equipment_tags', 'location');
 		}
 		$this->data['page_title'] = 'Import Equipments';
 		$this->load_content('import/import_equipment_tags', $this->data);
 	}

 	public function import_equipments(){
 		if( $this->input->server('REQUEST_METHOD') == 'POST' ){
 			// echo "<pre>"; print_r($_FILES);die;
 			if(isset($_FILES['import_tags']['name']) && $_FILES['import_tags']['name'] != ""){
 				$allowedExtensions = array("xls","xlsx");
 				$ext = pathinfo($_FILES['import_tags']['name'], PATHINFO_EXTENSION);
 				if(in_array($ext, $allowedExtensions)){
 					$file_size = $_FILES["import_tags"]["size"]/1024;
 					if($file_size < 50){
						$file = $this->uploadPath.$_FILES['import_tags']['name'];
						/*$isUploaded = copy($_FILES['import_tags']['tmp_name'], $file);
						if($isUploaded) {
							
						}*/
						$intCount = 1;
						$arrData = $this->readExcel($_FILES['import_tags']['tmp_name']);
						foreach($arrData as $data){
							if($intCount != 1 && $intCount != 2){
								$arrEquipmentData['tag_no'] = $data['A'];
								$arrEquipmentData['equipment_use'] = $data['B'];
								$eq = $data['C'];
								$plant = $data['D'];
								// check whether equipment exist or not
								if($equipments = $this->db->get_where('equipments', array('name'=>$eq))->row_array()){
									$arrEquipmentData['equipment_id'] = $equipments['id'];
								}else{
									$arrEquipmentData['equipment_id'] = $this->model->insert_update(array('name'=>$eq),'equipments');
								}

								// check whether plant exist or not
								if($plants = $this->db->get_where('plants', array('name'=>$eq))->row_array()){
									$arrEquipmentData['plant_id'] = $plants['id'];
								}else{
									$arrEquipmentData['plant_id'] = $this->model->insert_update(array('name'=>$eq),'plants');
								}

								$eqTags = $arrEquipmentData;
								unset($arrEquipmentData['equipment_use']);
								// check whether data of equipment_tags already exist or not
								if(!$this->db->get_where('equipment_tags', $arrEquipmentData)->row_array()){
									$this->model->insert_update($eqTags, 'equipment_tags');
								}
							}
							$intCount++;
						}
						$this->flash('message', 'Tags import successfully.');
 					}else{
 						$this->flash('error', 'Up to 50 MB file upload size is allowed.');
 					}
 				}else{
 					$this->flash('error', 'File you are importing is not valid. Please upload only xls or xlsx file.');
 				}
 			}else{
 				$this->flash('error', 'Please select file to upload.');
 			}
 			redirect('imports/import_equipments', 'location');
 		}
 		$this->data['page_title'] = 'Import Equipments';
 		$this->load_content('import/import_equipments', $this->data);
 	}
}