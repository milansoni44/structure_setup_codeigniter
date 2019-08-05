<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function insert_update($data = array(), $table = NULL, $id = NULL,$whereCol = NULL){
		$this->db->trans_start();
		if($id){
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->db->where($whereCol, $id);
			$this->db->update($table, $data);
		}else{
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert($table, $data);
			$id = $this->db->insert_id();
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
	        return false;
		}
		return $id;
	}

	public function get( $table, $id = NULL, $whereCol = NULL ){
		if($id){
			return $this->db->get_where($table, array($whereCol=>$id))->result_row();
		}else{
			return $this->db->get($table)->result_array();
		}
	}
}