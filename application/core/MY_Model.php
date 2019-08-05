<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{
	protected $table;
	protected $joinClause;
	protected $joinType;
	protected $fields;
	protected $joinedTable;

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
			return $this->db->get_where($table, array($whereCol=>$id, 'status'=>1))->row_array();
		}else{
			return $this->db->get_where($table, array('status'=>1))->result_array();
		}
	}

	public function maintenance_select($fields){
		$this->fields = $fields;
		return $this;
	}

	public function maintenance_join($joinedTable, $joinClause, $joinType = NULL){
		$this->joinedTable[] = $joinedTable;
		$this->joinClause[] = $joinClause;
		if($joinType){
			$this->joinType[] = $joinType;
		}
		return $this;
	}

	public function maintenance_get($table){
		$this->table = $table;
		$str = "";
		if(is_array($this->joinedTable) && !empty($this->joinedTable)){
			for($i = 0; $i < sizeof($this->joinedTable); $i++){
				$str .= " ".$this->joinType[$i]." JOIN ".$this->joinedTable[$i]." ON ".$this->joinClause[$i];
			}
		}

		return $this->db->query("SELECT 
					$this->fields
				FROM $this->table
				$str
		")->result_array();
	}
}