<?php
class Upd_inquiries_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	// mhae start get all supplier biller code
	public function get_supplier_biller_code($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_biller_code_approval');
			
			if($id != null)
				$this->db->where('id',$id);
			$this->db->order_by("id", "desc");
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//mhae end 
	public function reject_add_supplier_biller_code($items, $id){
		$this->db->where('id', $id);
		$this->db->update('supplier_biller_code_approval', $items);
		return 'success';
	}	
	public function approve_add_supplier_biller_code($items, $id){
		$this->db->where('id', $id);
		$this->db->update('supplier_biller_code_approval', $items);
		return 'success';
	}	
	public function approve_branch_add_supplier_master_biller_code($items, $id, $id_){
		$branch = array('default');
		$branch_name =  array();
			$test = $this->get_all_branches();
			foreach($test as $val){
				 array_push ($branch,$val->code);		
			}
			//return var_dump($branch);
			$num_branch = count($branch);
			$num =0;
			while($num_branch != $num){
				$num = $num + 1;
				$bdb = $this->load->database($branch[$num-1],TRUE);
				$connected = $bdb->initialize();
				if($connected){
					
					$sql11 = "UPDATE supplier_master SET biller_code = '".$items['biller_code']."'
							WHERE supplier_id = '$id' ";
					mysql_query($sql11);		
				}else{
					if($branch_name == null){
					array_push($branch_name,'update:'.$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
				}
			}
			$branch_name_con =  implode($branch_name);	
			$bdb = $this->load->database('default',TRUE);
			$cons = $bdb->initialize();
			if ($branch_name_con != ''){
					$sql11 = "UPDATE supplier_biller_code_approval SET branch_no_con = '$branch_name_con'  WHERE id = '$id_' ";
					mysql_query($sql11);		
											//echo 'success';
			}
	}
	public function check_biller_code($_id = NULL){	
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_biller_code_approval');
			$this->db->where('id',$_id);
			$query  = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_all_branches($id=null){
			$this->db->trans_start();
				$this->db->select('code');
				$this->db->from('branches');
				if($id != null)
					$this->db->where('id',$id);
				$this->db->where('inactive',0);
				$query = $this->db->get();
				$result = $query->result();
			$this->db->trans_complete();
			return $result;
		}	
	//mhae end
		//-----AUDIT TRAIL-----APM-----START
	public function write_to_audit_trail($items=array())
	{
		$this->db->insert('audit_trail',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	//-----AUDIT TRAIL-----APM-----END
	
}
?>