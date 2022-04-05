<?php
class Audit_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function get_audit_trail($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('audit_trail');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->order_by('stamp DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function user_name($person_id=null){
		$sql = " SELECT CONCAT(fname, ' ', mname, ' ', lname, ' ', suffix) AS person FROM `users` WHERE id=".$person_id;
		$query = $this->db->query($sql);
		$result = $query->result();
		$res = $result[0];
		return $res->person;
	}
	public function get_stock_location($id=null){
		if($id == 1){
			$stock_location = 'Selling Area';
		}else if($id == 2){
			$stock_location = 'Stock Room';
		}else{
			$stock_location = 'B.O. Room';
		}
		return $stock_location;
	}
	public function get_stock_desc_from_stock_id($stock_id=null){
		$sql = " SELECT description AS stock_desc FROM `stock_master_new` WHERE stock_id=".$stock_id;
		$query = $this->db->query($sql);
		$result = $query->result();
		$res = $result[0];
		return $res->stock_desc;
	}
	public function get_branch_id($code=null){
		$sql = "SELECT id FROM branches WHERE code='".$code."'";
		$query = $this->db->query($sql);
		$result = $query->result();
		$res = $result[0];
		return $res->id;
	}
	public function get_movement_type($id=null){
		$this->db->trans_start();
			$this->db->select('description');
			$this->db->from('movement_types');
			if($id != null)
				$this->db->where('movement_type_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_description_from_id($desc=null, $val=null){
		switch($desc){
			case 'mb_flag':
				if($val == 'm'){
					return 'make';
				}else{
					return 'buy';
				}
				break;
			case 'category_id':
				$sql = " SELECT short_desc FROM `stock_categories_new` WHERE id=".$val;
				$query = $this->db->query($sql);
				$result = $query->result();
				$res = $result[0];
				return $res->short_desc;
				
				break;
			case 'supplier_id':
				$sql = " SELECT supp_name FROM `supplier_master` WHERE supplier_id=".$val;
				$query = $this->db->query($sql);
				$result = $query->result();
				$res = $result[0];
				return $res->supp_name;
				
				break;
			case 'supplier_id_to_code':
				$sql = " SELECT short_name FROM `supplier_master` WHERE supplier_id=".$val;
				$query = $this->db->query($sql);
				$result = $query->result();
				$res = $result[0];
				return $res->short_name;
				
				break;
			case 'branch_id':
				if($val == 'all' || $val == 'All'){
					return 'All Branches';
				}else{
					$sql = " SELECT code FROM `branches` WHERE id=".$val;
					$query = $this->db->query($sql);
					$result = $query->result();
					$res = $result[0];
					return $res->code;
				}
				
				break;
			case 'PWD_disc':
			case 'SC_disc':
			case 'SUKI_crd':
			case 'URC_crd':
				if($val == 1){
					return 'YES';
				}else{
					return 'NO';
				}
				
				break;
			default:
				break;
		}
	}
}