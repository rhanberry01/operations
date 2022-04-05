<?php
class Customer_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}
	// public function get_branch_details(){
	// 	$this->db->trans_start();
	// 		$this->db->select('*');
	// 		$this->db->from('branch_details');
	// 		$this->db->where('branch_details.branch_code',BRANCH_CODE);
	// 		$query = $this->db->get();
	// 		$result = $query->result();
	// 	$this->db->trans_complete();
	// 	return $result;
	// } 
	
	public function get_customer_master($id=null){
	
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('customer_master');
			if($id != null)
				$this->db->where('cust_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function customer_master_exist_add_mode($cust_code=null){
		$sql = "SELECT * FROM customer_master WHERE cust_code = '$cust_code'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true; 
	}
	
	public function customer_master_exist_edit_mode($cust_code=null, $id=null){
		$sql = "SELECT * FROM customer_master WHERE cust_code = '$cust_code' AND cust_id != $id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function add_customer_master($items){
		$this->db->insert('customer_master', $items);
		return $this->db->insert_id();
	}

	public function update_customer_master($items,$id){
		// $this->db->where('code', $id);
		$this->db->where('cust_id', $id);
		$this->db->update('customer_master', $items);
	}
	
	// public function get_cust($id=null){
	
		// $this->db->trans_start();
			// $this->db->select('*');
			// $this->db->from('customers');
			// if($id != null)
				// $this->db->where('cust_id',$id);
			// $query = $this->db->get();
			// $result = $query->result();
		// $this->db->trans_complete();
		// return $result;
	// }
	
	
	public function get_debtors($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('debtor_master');
			if($id != null)
				$this->db->where('debtor_id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_customer($items)
	{
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('customer',$items);
		return $this->db->insert_id();
	}
	public function update_customer($items,$id){
		// $this->db->where('code', $id);
		$this->db->where('debtor_id', $id);
		$this->db->update('debtor_master', $items);
	}
	/* DEBTOR BRANCHES */
	/* Author: Caleb */
	public function get_debtor_branches($where=null)
	{
		$this->db->select('
			debtor_branches.debtor_id,
			debtor_master.debtor_code,
			debtor_master.name debtor_name,
			debtor_branches.debtor_branch_id,
			debtor_branches.branch_name,
			debtor_branches.branch_address,
			debtor_branches.branch_post_address,
			debtor_branches.area,
			debtor_branches.phone,
			debtor_branches.fax,
			debtor_branches.contact_person,
			debtor_branches.inv_location,
			debtor_branches.tax_grp,
			debtor_branches.default_shipper,
			debtor_branches.email,
			debtor_branches.sales_account,
			debtor_branches.sales_discount_account,
			debtor_branches.receivables_account,
			debtor_branches.payment_discount_account,
			debtor_branches.default_shipper default_shipper_id,
			shipping_company.company_name default_shipper_name,
			debtor_branches.currency,
			debtor_branches.sales_person_id,
			sales_persons.name sales_person_name
			');
		$this->db->from('debtor_branches');
		$this->db->join('debtor_master','debtor_branches.debtor_id = debtor_master.debtor_id');
		$this->db->join('shipping_company','debtor_branches.default_shipper = shipping_company.ship_company_id','left');
		$this->db->join('sales_persons','debtor_branches.sales_person_id = sales_persons.sales_person_id','left');
		if ($where)
			$this->db->where($where);

		$query = $this->db->get();
		return $query->result();
	}
	public function write_debtor_branch($items)
	{
		$this->db->insert('debtor_branches',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function change_debtor_branch($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('debtor_branches',$items);
	}
	public function get_details($where,$table){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from($table);
			if($where)
				$this->db->where($where);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
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