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
			$data['updated_by'] = USER_ID;
			$this->db->where($whereCol, $id);
			$this->db->update($table, $data);
		}else{
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['created_by'] = USER_ID;
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

	public function common_select($fields){
		$this->fields = $fields;
		return $this;
	}

	public function common_join($joinedTable, $joinClause, $joinType = NULL){
		$this->joinedTable[] = $joinedTable;
		$this->joinClause[] = $joinClause;
		if($joinType){
			$this->joinType[] = $joinType;
		}
		return $this;
	}

	public function common_get($table){
		$this->table = $table;
		$str = "";
		if(is_array($this->joinedTable) && !empty($this->joinedTable)){
			for($i = 0; $i < sizeof($this->joinedTable); $i++){
				$str .= " ".$this->joinType[$i]." JOIN ".$this->joinedTable[$i]." ON ".$this->joinClause[$i];
			}
		}

		return "SELECT 
					$this->fields
				FROM $this->table
				$str
		";
	}

	/*
		Developer: Milan Soni
		Date: 06-08-2019
		Description: common data table function which is used for generate formal datatable
	*/
	public function common_datatable($columns = array(), $query, $whereClause = NULL){
		$request= $_REQUEST;
		$where = " WHERE 1=1 ";
		$where .= ($whereClause) ? " AND $whereClause ":"";
        $cols = $columns;
        $sql = $query;
		$rs = $this->db->query($sql.$where);
		$records_total = $this->db->affected_rows();
		$records_filtered = $records_total;
		
		if( !empty($request['search']['value']) ) {

			$search_value = $this->db->escape_like_str($request['search']['value']);
			$where .= "AND ( ";
			if(is_array($columns)){
				array_pop($columns);	// remove last index from the array
				$intCount = COUNT($columns);
				$intIteration = 1;
				foreach($columns as $col):
					if($intIteration == $intCount){
						$where .="$col LIKE '%".$search_value."%' ";
					}else{
						$where .="$col LIKE '%".$search_value."%' OR ";
					}
					$intIteration += 1;
				endforeach;
			}
            $where .= " )";
		}
		$sql .= $where;
		if( count($request['order']) > 0 ) {
			
			$temp = array();
			
			foreach($request['order'] as $order){
				$temp[]= "".$columns[$order['column']]." ".$order['dir'];
			}

			$sql .= " ORDER BY ";
			$sql .= implode(",",$temp);
		}
		
		$c = $this->db->query($sql);
		$records_filtered = $this->db->affected_rows();
		
		$sql .= " LIMIT ".$request['start']." ,".$request['length'];

		$rs = $this->db->query($sql);
		$data =  $rs->result_array();
		$CI =& get_instance();
		foreach($data as $k=>$val){
			$data[$k]['link'] = $val;
		}

		$json_data = array(
			"draw"            => intval( $request['draw'] ),
			"recordsTotal"    => intval( $records_total ),
			"recordsFiltered" => intval( $records_filtered ),
			"data"            => $data,
		);
		return json_encode($json_data);
	}
}