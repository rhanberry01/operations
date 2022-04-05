<?php
class Admin_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	public function get_user_roles($id=null,$exclude_admin=true){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('user_roles');
			if($id != null){
				$this->db->where('user_roles.id',$id);
			}
			if($exclude_admin)
				$this->db->where('user_roles.id !=', 1);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_user_roles($items){
		$this->db->insert('user_roles',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_user_roles($user,$id){
		$this->db->where('id', $id);
		$this->db->update('user_roles', $user);

		return $this->db->last_query();
	}

	/********************
	UOMs
	********************/
	public function get_uoms($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('uoms');
			if($id != null){
				$this->db->where('uoms.uom_id',$id);
			}
			$this->db->order_by('uom_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_uoms($items){
		$this->db->insert('uoms',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_uoms($user,$id){
		$this->db->where('uom_id', $id);
		$this->db->update('uoms', $user);

		return $this->db->last_query();
	}

	/********************
	Item Types
	********************/
	public function get_stock_tax_types($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_tax_types');
			if($id != null){
				$this->db->where('stock_tax_types.stock_tax_type_id',$id);
			}
			$this->db->order_by('stock_tax_type_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_stock_tax_types($items){
		$this->db->insert('stock_tax_types',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_stock_tax_types($user,$id){
		$this->db->where('stock_tax_type_id', $id);
		$this->db->update('stock_tax_types', $user);

		return $this->db->last_query();
	}
	/********************
	Item Categories
	********************/
	public function get_stock_categories($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_categories');
			if($id != null){
				$this->db->where('stock_categories.stock_category_id',$id);
			}
			$this->db->order_by('stock_category_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_stock_categories($items){
		$this->db->insert('stock_categories',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_stock_categories($user,$id){
		$this->db->where('stock_category_id', $id);
		$this->db->update('stock_categories', $user);

		return $this->db->last_query();
	}
	/********************
	Item Categories
	********************/
	public function get_stock_master($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master');
			if($id != null){
				$this->db->where('stock_master.id',$id);
			}
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_stock_master($items){
		$this->db->insert('stock_master',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_stock_master($user,$id){
		$this->db->where('id', $id);
		$this->db->update('stock_master', $user);

		return $this->db->last_query();
	}
	/********************
	Fiscal Years
	********************/
	public function get_fiscal_years($id=null,$where=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('fiscal_years');
			if($id != null){
				$this->db->where('fiscal_years.fiscal_year_id',$id);
			}
			if ($where) {
				if (is_array($where))
					foreach ($where as $value) {
						if (isset($value['key']))
							$this->db->where($value['key'],$value['value'],$value['escape']);
						else
							$this->db->where($value);
					}
				else
					$this->db->where($where);
			}
			$this->db->order_by('fiscal_year_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_fiscal_years($items){
		$this->db->insert('fiscal_years',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_fiscal_years($user,$id){
		$this->db->where('fiscal_year_id', $id);
		$this->db->update('fiscal_years', $user);

		return $this->db->last_query();
	}
	/********************
	Payment Terms
	********************/
	public function get_payment_terms($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('payment_terms');
			if($id != null){
				$this->db->where('payment_terms.payment_id',$id);
			}
			$this->db->order_by('payment_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_payment_terms($items){
		$this->db->insert('payment_terms',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_payment_terms($user,$id){
		$this->db->where('payment_id', $id);
		$this->db->update('payment_terms', $user);

		return $this->db->last_query();
	}

/**
	 * Get_tax_types
	 *
	 * @param	mixed	specifies where conditions for SQL
	 * @return	Object	return 'get' object instead of 'result'/'result_array'
	 *						for usage flexibility
	**/
	public function get_tax_types2($where=null)
	{
		$this->db->select('*');
		$this->db->from('tax_types');
		if ($where)
			$this->db->where($where);
		$query = $this->db->get();
		return $query;
	}
	public function write_tax_types($items)
	{
		$this->db->insert('tax_types',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	public function change_tax_types($items,$where=null)
	{
		if ($where)
			$this->db->where($where);
		$this->db->update('tax_types',$items);
	}

/********************
	Currrencies
	********************/
	// public function get_currencies($id=null){
		// $this->db->trans_start();
			// $this->db->select('*');
			// $this->db->from('currencies');
			// if($id != null){
				// $this->db->where('currencies.id',$id);
			// }
			// $this->db->order_by('id desc');
			// $query = $this->db->get();
			// $result = $query->result();
		// $this->db->trans_complete();
		// return $result;
	// }
	// public function add_currencies($items){
		// $this->db->insert('currencies',$items);
		// $x=$this->db->insert_id();
		// return $x;
	// }
	// public function update_currencies($user,$id){
		// $this->db->where('id', $id);
		// $this->db->update('currencies', $user);

		// return $this->db->last_query();
	// }
	
	//Get listing of products - active record
	
public function get_currencies($id=null){

	$this->db->trans_start();
		$this->db->select('*');
		$this->db->from('currencies_new');
		if($id != null)
			$this->db->where('id',$id);
		$query = $this->db->get();
		$result = $query->result();
	$this->db->trans_complete();
	return $result;
}
	
	
	
	public function add_currency($items)
	{
	
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('currencies_new',$items);
		return $this->db->insert_id();
		
	}
	//Update DB
	public function update_currency($items,$id){
		// $this->db->where('code', $id);
		$this->db->where('id', $id);
		$this->db->update('currencies_new', $items);
		
	}
	
	//validate product code
	public function abbrev_exist_add_mode($abbrev=null){
		$sql = "SELECT * FROM currencies_new WHERE abbrev = '$abbrev'";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function abbrev_exist_edit_mode($abbrev=null, $id=null){
		$sql = "SELECT * FROM currencies_new WHERE abbrev = '$abbrev' AND id != $id";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	//****************Jed*********************
	public function get_tax_types($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('taxes');
			if($id != null){
				$this->db->where('taxes.id',$id);
			}
			$this->db->order_by('taxes.id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_tax_types($items){
		$this->db->insert('taxes',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_tax_types($items,$id){
		$this->db->where('id', $id);
		$this->db->update('taxes', $items);

		return $this->db->last_query();
	}
	public function get_shipping_comp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('shipping_company');
			if($id != null){
				$this->db->where('ship_company_id',$id);
			}
			$this->db->order_by('ship_company_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function add_ship_comp($items){
		$this->db->insert('shipping_company',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_ship_comp($items,$id){
		$this->db->where('ship_company_id', $id);
		$this->db->update('shipping_company', $items);

		return $this->db->last_query();
	}
	public function get_form_setup($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('trans_types');
			if($id != null){
				$this->db->where('trans_type',$id);
			}
			$this->db->order_by('trans_type');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function update_form_setup($items,$id){
		$this->db->where('trans_type', $id);
		$this->db->update('trans_types', $items);

		return $this->db->last_query();
	}

	public function get_tax_groups($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('tax_groups');
			$this->db->join('tax_group_items','tax_group_items.tax_group_id=tax_groups.tax_group_id');
			if($id != null){
				$this->db->where('tax_groups.tax_group_id',$id);
			}
			$this->db->order_by('tax_groups.tax_group_id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function write_tax_groups($items){
		$this->db->insert('tax_groups',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function change_tax_groups($items,$id){
		$this->db->where('tax_group_id', $id);
		$this->db->update('tax_groups', $items);

		return $this->db->last_query();
	}
	public function write_tax_groups_items($items){
		$this->db->insert('tax_group_items',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function change_tax_groups_items($items,$id){
		$this->db->where('tax_group_id', $id);
		$this->db->update('tax_group_items', $items);

		return $this->db->last_query();
	}
	// public function write_tax_groups($items)
	// {
	// 	$this->db->insert('tax_groups',$items);
	// 	$id = $this->db->insert_id();
	// 	return $id;
	// }
	// public function change_tax_groups($items,$where=null)
	// {
	// 	if ($where)
	// 		$this->db->where($where);
	// 	$this->db->update('tax_groups',$items);
	// }

	//***********************Jed end***********************

	
	
	public function get_branches($id=null){

	$this->db->trans_start();
		$this->db->select('*');
		$this->db->from('branches');
		if($id != null)
			$this->db->where('id',$id);
		$query = $this->db->get();
		$result = $query->result();
	$this->db->trans_complete();
	return $result;
}



public function add_new_branch_stocks($branch_id,$i)
	{
		$sql = "INSERT IGNORE INTO branch_stocks(stock_id, branch_id, qty, stock_loc_id)SELECT stock_id, $branch_id, 0, $i FROM stock_master_new";
		$query = mysql_query($sql);
	
	}
	
		
	public function get_id_desc($id=null){
	$sql= "SELECT code FROM branches WHERE id =".$id;
	$query = mysql_query($sql);
	$result = mysql_fetch_object($query); 
	return $result->code;
	}
	
	public function add_new_per_branch_stocks($branch_id,$i)
	{
		$bdb = $this->load->database($this->get_id_desc($branch_id),TRUE);
	    $bdb->initialize();
		
		$sql1 = "INSERT IGNORE INTO branch_stocks(stock_id, branch_id, qty, stock_loc_id)SELECT stock_id, $branch_id, 0, $i FROM stock_master_new";
		$query = mysql_query($sql1);
		
		$bdb = $this->load->database('default',TRUE);
	    $bdb->initialize();
	}

public function add_branch($items){
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('branches',$items);
		return $this->db->insert_id();
	
}
public function add_per_branch($items){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('branches');		
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		
		$branch = array();
		$branch_name =  array();
			$test = $this->get_all_branches();
			foreach($test as $val){
				 array_push ($branch,$val->code);		
			}
			$num_branch = count($branch);
			$num =0;
			while($num_branch != $num){
				$num = $num + 1;
				$bdb = $this->load->database($branch[$num-1],TRUE);
				$connected = $bdb->initialize();
				if($connected){
					$sql1 = "TRUNCATE branches";
					mysql_query($sql1);	
				foreach($result as $val){
						$sql11 = "INSERT INTO branches(id,
													code,
													name,
													address,
													tin, 
													tel_no,
													mobile_no, 
													date_opened,
													branch_database, 
													branch_ip, 
													has_sa, has_bo, 
													has_sr, 
													inactive) VALUES( 
													 '".$val->id."',
													 '".$val->code."',
													 '".$val->name."',
													 '".$val->address."',
													 '".$val->tin."',
													 '".$val->tel_no."',
													 '".$val->mobile_no."',
													 '".$val->date_opened."',
													 '".$val->branch_database."',
													 '".$val->branch_ip."',
													 '".$val->has_sa."',
													 '".$val->has_bo."',
													 '".$val->has_sr."',
													 '".$val->inactive."')";
									mysql_query($sql11);		
				}
				}else{
					if($branch_name == null){
					array_push($branch_name,'add:'.$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
				}
			}
			$branch_name_con =  implode($branch_name);	
			
			$bdb = $this->load->database('default',TRUE);
			$cons = $bdb->initialize();
			if ($branch_name_con != ''){
					$sql11 = "UPDATE branches SET branch_no_con = '$branch_name_con'  WHERE code = '".$items['code']."' ";
					mysql_query($sql11);		
											//echo 'success';
			}
	
	
}
	//Update DB
	public function update_branch($items,$id){
		// $this->db->where('code', $id);
		$branch = array('default');
		$branch_name =  array();
			$test = $this->get_all_branches();
			foreach($test as $val){
				 array_push ($branch,$val->code);		
			}
			$num_branch = count($branch);
			$num =0;
			while($num_branch != $num){
				$num = $num + 1;
				$bdb = $this->load->database($branch[$num-1],TRUE);
				$connected = $bdb->initialize();
				if($connected){
					
					$sql11 = "UPDATE branches SET code = '".$items['code']."',
												name = '".$items['name']."',
												address = '".$items['address']."',
												tin = '".$items['tin']."',
												tel_no = '".$items['tel_no']."',
												mobile_no = '".$items['mobile_no']."',
												date_opened = '".$items['date_opened']."',
												branch_database = '".$items['branch_database']."',
												branch_ip = '".$items['branch_ip']."',
												has_sa = '".$items['has_sa']."',
												has_bo = '".$items['has_bo']."',
												has_sr = '".$items['has_sr']."',
												inactive = '".$items['inactive']."'

							WHERE id = '$id' ";
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
					$sql11 = "UPDATE branches SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
					mysql_query($sql11);		
											//echo 'success';
			}
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
	
	//validate product code
	public function code_exist_add_mode($code=null,$branch=null){
		$sql = "SELECT * FROM branches WHERE code = '$code' OR name ='$branch'" ;
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	
	public function code_exist_edit_mode($code=null, $id=null){
		$sql = "SELECT * FROM branches WHERE code = '$code' AND id != $id";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}

	
	
	//----------PAYMENT TYPES----------JOSHUA-----START
	public function get_payment_types($id=null){

	$this->db->trans_start();
		$this->db->select('*');
		$this->db->from('payment_types');
		if($id != null)
			$this->db->where('id',$id);
		$query = $this->db->get();
		$result = $query->result();
	$this->db->trans_complete();
	return $result;
	}

	public function add_payment_types($items)
	{
	
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('payment_types',$items);
		return $this->db->insert_id();
		
	}
	//Update DB
	public function update_payment_types($items,$id){
		// $this->db->where('code', $id);
		$this->db->where('id', $id);
		$this->db->update('payment_types', $items);
		
	}
	
	//validate product code
	public function name_exist_add_mode($name=null){
		$sql = "SELECT * FROM payment_types WHERE name = '$name'";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function name_exist_edit_mode($name=null, $id=null){
		$sql = "SELECT * FROM payment_types WHERE name = '$name' AND id != $id";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	//----------PAYMENT TYPES----------JOSHUA-----END
	//----------ACQUIRING BANKS--------MHAE-------START
	public function get_acquiring_banks($id=null){
	$this->db->trans_start();
		$this->db->select('*');
		$this->db->from('acquiring_banks');
		if($id != null)
			$this->db->where('id',$id);
		$query = $this->db->get();
		$result = $query->result();
	$this->db->trans_complete();
	return $result;
	}
	public function add_acquiring_banks($items)
	{
		$this->db->insert('acquiring_banks',$items);
		return $this->db->insert_id();
	}
	public function update_acquiring_banks($items,$id){
		$this->db->where('id', $id);
		$this->db->update('acquiring_banks', $items);
	}
	public function bank_name_exist_add_mode($bank_name=null){
		$sql = "SELECT * FROM acquiring_banks WHERE acquiring_bank = '$bank_name'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function bank_name_exist_edit_mode($bank_name=null, $id=null){
		$sql = "SELECT * FROM acquiring_banks WHERE acquiring_bank = '$bank_name' AND id != $id";
		$query = mysql_query($sql);
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	//----------ACQUIRING BANKS--------MHAE-------END
	
	
	
//----------PAYMENT TYPE CODE----------RHAN-----START
	
		public function get_payment_type_codes($id=null)
		{
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('payment_type_codes');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;	
		}
		
		public function add_payment_type_codes($items)
		{
			$this->db->insert('payment_type_codes',$items);
			return $this->db->insert_id();
		}
		
		//Update DB
		public function update_payment_type_codes($items,$id)
		{
			$this->db->where('id', $id);
			$this->db->update('payment_type_codes', $items);
		}
		
		//validate product code
		public function type_code_exist_add_mode($code=null,$con_code=null)
		{
			$sql = "SELECT * FROM payment_type_codes WHERE code = '$code' AND confirmation_code = '$con_code' ";
			$query = mysql_query($sql);
			
			//echo $sql;
			if(mysql_num_rows($query) == 0)
				return false;
			return true;
		}
		public function type_code_exist_edit_mode($code=null, $con_code=null, $id=null)
		{
			$sql = "SELECT * FROM payment_type_codes WHERE code = '$code' AND confirmation_code = '$con_code' AND id != $id";
			$query = mysql_query($sql);
			if(mysql_num_rows($query) == 0)
				return false;
			return true;
		}
		
		public function payment_types_name($id)
		{
		$sql = "SELECT name FROM payment_types WHERE id = $id ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
		return $row->name;
		return false;
	}
	
	
	//----------PAYMENT TYPE CODE----------RHAN-----END
	
   //----------Suppliers----------RHAN-----START
	public function get_supplier_master_list($id=null)
	{
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_master');
			if($id != null)
				$this->db->where('purchaser_id',$id);
			$query = $this->db->get();
		$result = $query->result();
		$this->db->trans_complete();
		return $result;	
	}
	public function get_supplier_master($id=null)
	{
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_master');
			if($id != null)
				$this->db->where('supplier_id',$id);
			$query = $this->db->get();
		$result = $query->result();
		$this->db->trans_complete();
		return $result;	
	}
	
		public function add_supplier($items)
		{
			$this->db->insert('supplier_master',$items);
			return $this->db->insert_id();
		}
		public function add_per_branch_supplier($id){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_master');		
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		
		$branch = array();
		$branch_name =  array();
			$test = $this->get_all_branches();
			foreach($test as $val){
				 array_push ($branch,$val->code);		
			}
			$num_branch = count($branch);
			$num =0;
			while($num_branch != $num){
				$num = $num + 1;
				$bdb = $this->load->database($branch[$num-1],TRUE);
				$connected = $bdb->initialize();
				if($connected){
					$sql1 = "TRUNCATE supplier_master";
					mysql_query($sql1);	
				foreach($result as $val){
						$sql11 = "INSERT INTO supplier_master(supplier_id,
															short_name,
															supp_name,
															address,
															email_po,
															email_payment,
															biller_code,
															curr_code,
															payment_terms,
															dimension_id,
															dimension2_id,
															tax_group_id,
															purchase_account,
															payable_account,
															payment_discount_account,
															tin,
															contact_person,
															contact_nos,
															fax_no,
															purchaser_id,
															dr_inv,
															is_consignor,
															consignment_percent,
															is_cwo,
															group_id,
															delivery_lead_time,
															po_schedule,
															selling_days,
															inactive) 
													VALUES( 
													 '".$val->supplier_id."',
													 '".$val->short_name."',
													 '".$val->supp_name."',
													 '".$val->address."',
													 '".$val->email_po."',
													 '".$val->email_payment."',
													 '".$val->biller_code."',
													 '".$val->curr_code."',
													 '".$val->payment_terms."',
													 '".$val->dimension_id."',
													 '".$val->dimension2_id."',
													 '".$val->tax_group_id."',
													 '".$val->purchase_account."',
													 '".$val->payable_account."',
													 '".$val->payment_discount_account."',
													 '".$val->tin."',
													 '".$val->contact_person."',
													 '".$val->contact_nos."',
													 '".$val->fax_no."',
													 '".$val->purchaser_id."',
													 '".$val->dr_inv."',
													 '".$val->is_consignor."',
													 '".$val->consignment_percent."',
													 '".$val->is_cwo."',
													 '".$val->group_id."',
													 '".$val->delivery_lead_time."',
													 '".$val->po_schedule."',
													 '".$val->selling_days."',
													 '".$val->inactive."')";
									mysql_query($sql11);		
				}
				}else{
					if($branch_name == null){
					array_push($branch_name,'add:'.$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
				}
			}
			$branch_name_con =  implode($branch_name);	
			
			$bdb = $this->load->database('default',TRUE);
			$cons = $bdb->initialize();
			if ($branch_name_con != ''){
					$sql11 = "UPDATE supplier_master SET branch_no_con = '$branch_name_con'  WHERE supplier_id = '".$id."' ";
					mysql_query($sql11);		
					//echo 'success';
			}	
	}
		public function add_supplier_biller_code($items)
		{
			$this->db->insert('supplier_biller_code_approval',$items);
			return $this->db->insert_id();
		}

		//Update DB
		public function update_supplier($items,$id)
		{
			$this->db->where('supplier_id', $id);
			$this->db->update('supplier_master', $items);
		}
		public function update_per_branch_supplier($items,$id){
		$branch = array('default');
		$branch_name =  array();
			$test = $this->get_all_branches();
			foreach($test as $val){
				 array_push ($branch,$val->code);		
			}
			$num_branch = count($branch);
			$num =0;
			while($num_branch != $num){
				$num = $num + 1;
				$bdb = $this->load->database($branch[$num-1],TRUE);
				$connected = $bdb->initialize();
				if($connected){
					
					$sql11 = "UPDATE supplier_master SET short_name = '".$items['short_name']."',
											   supp_name = '".$items['supp_name']."',
											   contact_nos = '".$items['contact_nos']."',
											   address = '".$items['address']."',
											   contact_person = '".$items['contact_person']."',
											   email_po = '".$items['email_po']."',
											   email_payment = '".$items['email_payment']."',
											   tin = '".$items['tin']."',
											   fax_no = '".$items['fax_no']."',
											   purchaser_id = '".$items['purchaser_id']."',
											   biller_code = '".$items['biller_code']."',
											   tax_group_id = '".$items['tax_group_id']."',
											   payment_terms = '".$items['payment_terms']."',
											   dr_inv = '".$items['dr_inv']."',
											   is_consignor = '".$items['is_consignor']."',
											   consignment_percent = '".$items['consignment_percent']."',
											   is_cwo = '".$items['is_cwo']."',
											   group_id = '".$items['group_id']."',
											   delivery_lead_time = '".$items['delivery_lead_time']."',
											   po_schedule = '".$items['po_schedule']."',
											   selling_days = '".$items['selling_days']."',
											   inactive = '".$items['inactive']."',
											   payment_discount_account = '".$items['payment_discount_account']."',
											   payable_account = '".$items['payable_account']."',
											   purchase_account = '".$items['purchase_account']."'
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
					$sql11 = "UPDATE supplier_master SET branch_no_con = '$branch_name_con'  WHERE supplier_id = '$id' ";
					mysql_query($sql11);		
											//echo 'success';
			}
	}
		
		//validate supplier code
		public function supplier_exist_add_mode($code=null)
		{
			$sql = "SELECT * FROM supplier_master WHERE supplier_code = '$code' ";
			$query = mysql_query($sql);
			
			//echo $sql;
			if(mysql_num_rows($query) == 0)
				return false;
			return true;
		}
		public function supplier_exist_edit_mode($code=null,$id=null)
		{
			$sql = "SELECT * FROM supplier_master WHERE supplier_code = '$code'  AND supplier_id != $id";
			$query = mysql_query($sql);
			if(mysql_num_rows($query) == 0)
				return false;
			return true;
		}
		//validate supplier name
		public function supplier_name_exist_add_mode($name=null)
		{
			$sql = "SELECT * FROM supplier_master WHERE supp_name = '$name' ";
			$query = mysql_query($sql);
			
			//echo $sql;
			if(mysql_num_rows($query) == 0)
				return false;
			return true;
		}
		public function supplier_name_exist_edit_mode($name=null,$id=null)
		{
			$sql = "SELECT * FROM supplier_master WHERE supp_name = '$name'  AND supplier_id != $id";
			$query = mysql_query($sql);
			if(mysql_num_rows($query) == 0)
				return false;
			return true;
		}
		

	
	
	//----------Suppliers----------RHAN-----END
	
	//----------DISCOUNT TYPES----------JOSHUA-----START
	public function get_discount_types($id=null){

	$this->db->trans_start();
		$this->db->select('*');
		$this->db->from('pos_discounts');
		if($id != null)
			$this->db->where('id',$id);
		$query = $this->db->get();
		$result = $query->result();
	$this->db->trans_complete();
	return $result;
	}
	
	public function add_discount_types($items)
	{
	
		// $this->db->set('reg_date','NOW()',FALSE);
		$this->db->insert('pos_discounts',$items);
		return $this->db->insert_id();
		
	}
	//Update DB
	public function update_discount_types($items,$id){
		// $this->db->where('code', $id);
		$this->db->where('id', $id);
		$this->db->update('pos_discounts', $items);
		
	}
	
	//validate product code
	public function short_desc_exist_add_mode($short_desc=null){
		$sql = "SELECT * FROM pos_discounts WHERE short_desc = '$short_desc'";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function short_desc_exist_edit_mode($short_desc=null, $id=null){
		$sql = "SELECT * FROM pos_discounts WHERE short_desc = '$short_desc' AND id != $id";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	//----------DISCOUNT TYPES----------JOSHUA-----END
	public function write_to_supplier_master_group($items)
	{
		$this->db->insert('supplier_master_group',$items);
		return $this->db->insert_id();
	}
	public function get_all_active_supp_group($where,$table){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from($table);
			if($where)
				$this->db->where($where);
			$query = $this->db->get();
			$result = $query->result();
			// echo $this->db->last_query();
		$this->db->trans_complete();
		return $result;
	}
	public function get_supp_group_name_from_id($group_id=null){
		// if ($unit_code != null){
			$sql = "SELECT name FROM supplier_master_group WHERE id = '$group_id' ";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->name;
			else
				return false;
		// }else
			// return false;
	}
	//-----AUDIT TRAIL-----APM-----START
	public function write_to_audit_trail($items=array())
	{
		$this->db->insert('audit_trail',$items);
		$id = $this->db->insert_id();
		return $id;
	}
	//-----AUDIT TRAIL-----APM-----END
	public function get_branch_code_from_id($branch_id=null){
			$sql = "SELECT code FROM branches WHERE id = '$branch_id' ";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->code;
			else
				return false;
	}
	public function get_max_supplier_id(){
		// if ($unit_code != null){
			$sql = "SELECT MAX(supplier_id) as max_supplier_id FROM supplier_master";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return $row->max_supplier_id;
			else
				return false;
	}
	public function get_next_supplier_id(){
		// if ($unit_code != null){
			$sql = "SELECT MAX(supplier_id) as max_supplier_id FROM supplier_master";
			// echo $sql."<br>";
			$query = $this->db->query($sql);
			$row = $query->row();
			// echo $sql."<br>";
			if ($row != null)
				return ($row->max_supplier_id)+1;
			else
				return false;
	}
	// USER
	public function get_users($id=null)
	{
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('users');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
		$result = $query->result();
		$this->db->trans_complete();
		return $result;	
	}
	
	// ------------------------------------edited lester -----------------------------------
	public function get_role($id=null){
		$sql = "SELECT role FROM user_roles WHERE id=".$id;
		// $query = mysql_query($sql);
		// $result = mysql_fetch_object($query); 
		// return $result->role;

		$query = $this->db->query($sql);
			$row = $query->row();
			if ($row != null)
				return ($row->role);
			else
				return false;
	}

	// ------------------------------------edited lester -----------------------------------

	public function ename_exist_add_mode($fname=null, $mname=null, $lname=null){
		$sql = "SELECT * FROM users WHERE fname = '$fname' AND mname = '$mname' AND lname = '$lname' ";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	public function ename_exist_edit_mode($fname=null, $mname=null, $lname=null, $id=null){
		$sql = "SELECT * FROM users WHERE fname = '$fname' AND mname = '$mname' AND lname = '$lname' AND id != $id";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function add_users($items){
		$this->db->set('reg_date', 'NOW()', FALSE);
		$this->db->insert('users',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function add_per_branch_users($id){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('users');		
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		
		$branch = array();
		$branch_name =  array();
			$test = $this->get_all_branches();
			foreach($test as $val){
				 array_push ($branch,$val->code);		
			}
			$num_branch = count($branch);
			$num =0;
			while($num_branch != $num){
				$num = $num + 1;
				$bdb = $this->load->database($branch[$num-1],TRUE);
				$connected = $bdb->initialize();
				if($connected){
					$sql1 = "TRUNCATE users";
					mysql_query($sql1);	
				foreach($result as $val){
						$sql11 = "INSERT INTO users(id,
													emp_id,
													username,
													password,
													pin,
													fname,
													mname,
													lname,
													suffix,
													role,
													email,
													gender,
													reg_date,
													inactive) 
													VALUES( 
													 '".$val->id."',
													 '".$val->emp_id."',
													 '".$val->username."',
													 '".$val->password."',
													 '".$val->pin."',
													 '".$val->fname."',
													 '".$val->mname."',
													 '".$val->lname."',
													 '".$val->suffix."',
													 '".$val->role."',
													 '".$val->email."',
													 '".$val->gender."',
													 '".$val->reg_date."',
													 '".$val->inactive."')";
									mysql_query($sql11);		
				}
				}else{
					if($branch_name == null){
					array_push($branch_name,'add:'.$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
				}
			}
			$branch_name_con =  implode($branch_name);	
			
			$bdb = $this->load->database('default',TRUE);
			$cons = $bdb->initialize();
			if ($branch_name_con != ''){
					$sql11 = "UPDATE users SET branch_no_con = '$branch_name_con'  WHERE id = '".$id."' ";
					mysql_query($sql11);		
					//echo 'success';
			}	
	}
	public function update_users($user,$id){
		$this->db->where('id', $id);
		$this->db->update('users', $user);

		return $this->db->last_query();
	}
	public function update_per_branch_users($items,$id){
		$branch = array('default');
		$branch_name =  array();
			$test = $this->get_all_branches();
			foreach($test as $val){
				 array_push ($branch,$val->code);		
			}
			$num_branch = count($branch);
			$num =0;
			while($num_branch != $num){
				$num = $num + 1;
				$bdb = $this->load->database($branch[$num-1],TRUE);
				$connected = $bdb->initialize();
				if($connected){
					
					$sql11 = "UPDATE users SET fname = '".$items['fname']."',
											   mname = '".$items['mname']."',
											   lname = '".$items['lname']."',
											   suffix = '".$items['suffix']."',
											   role = '".$items['role']."',
											   email = '".$items['email']."',
											   gender = '".$items['gender']."'
							WHERE id = '$id' ";
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
					$sql11 = "UPDATE users SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
					mysql_query($sql11);		
											//echo 'success';
			}
	}
	
	//BRANCH COUNTER
	public function get_branch_counters($id=null)
	{
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('branch_counters');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
		$result = $query->result();
		$this->db->trans_complete();
		return $result;	
	}
	public function br_counter_exist_add_mode($branch_id=null, $counter_no=null){
		$sql = "SELECT * FROM branch_counters WHERE branch_id = '$branch_id' AND counter_no = '$counter_no'";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function br_counter_exist_edit_mode($id=null, $branch_id=null, $counter_no=null){
		$sql = "SELECT * FROM branch_counters WHERE branch_id = '$branch_id' AND counter_no = '$counter_no' AND id != '$id'";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function get_branch_tin($id=null){
		$sql = "SELECT tin FROM branches WHERE id=".$id;
		// echo $sql."<br>";
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->tin;
	}
	public function add_counter($items){
		$this->db->insert('branch_counters',$items);
		$result = $this->db->insert_id();
		return $result;
	}
	public function add_branch_counter($id, $items, $branch){
		$bdb = $this->load->database($branch,TRUE);
		$connected = $bdb->initialize();
			if($connected){
				$sql11 = "INSERT INTO branch_counters(id,
											branch_id,
											counter_no,
											tin,
											permit_no,
											serial_no,
											min,
											inactive) 
												VALUES( 
												 '".$id."',
												 '".$items['branch_id']."',
												 '".$items['counter_no']."',
												 '".$items['tin']."',
												 '".$items['permit_no']."',
												 '".$items['serial_no']."',
												 '".$items['min']."',
												 '".$items['inactive']."')";
									mysql_query($sql11);		
			}else{
				$bdb = $this->load->database('default',TRUE);
				$cons = $bdb->initialize();
				$branch = 'add:'.$branch;
				$sql11 = "UPDATE branch_counters SET branch_no_con = '$branch'  WHERE id = '$id' ";
				mysql_query($sql11);
			}
	}
	public function update_counter($br_counter,$id){
		$this->db->where('id', $id);
		$this->db->update('branch_counters', $br_counter);

		return $this->db->last_query();
	}
	public function update_branch_counter($id, $items, $branch){
		$bdb = $this->load->database($branch,TRUE);
		$connected = $bdb->initialize();
			if($connected){
					$sql11 = "UPDATE branch_counters SET branch_id = '".$items['branch_id']."',
											   counter_no = '".$items['counter_no']."',
											   tin = '".$items['tin']."',
											   permit_no = '".$items['permit_no']."',
											   serial_no = '".$items['serial_no']."',
											   min = '".$items['min']."',
											   inactive = '".$items['inactive']."'
							WHERE id = '$id' ";
					mysql_query($sql11);		
			}else{
				$bdb = $this->load->database('default',TRUE);
				$cons = $bdb->initialize();
				$sql = "SELECT branch_no_con FROM branch_counters WHERE id =".$id;
				$query = $this->db->query($sql);
				$row = $query->row();
				$name = explode('|',$row->branch_no_con);
				if($row->branch_no_con != ''){
					$branch = $row->branch_no_con.'||update:'.$branch;
				}else{
					$branch = 'update:'.$branch;
				}
				$sql11 = "UPDATE branch_counters SET branch_no_con = '$branch'  WHERE id = '$id' ";
				mysql_query($sql11);
			}
	}

	//Brancher


	// ______________________________________________________ new lester _________________________________________
	public function get_branch($code=null)
	{
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_branch');
			if($code != null)
				$this->db->where('branch_code',$code);
			$query = $this->db->get();
		$result = $query->result();
		$this->db->trans_complete();
		return $result;	
	}

	public function branch_name_exist($branch_code=null){
		$sql = "SELECT * FROM 0_branch WHERE branch_code = '$branch_code'";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	
	public function branch_name_edit($branch_code=null){
		$sql = "SELECT * FROM users WHERE branch_code = '$branch_code' ";
		$query = mysql_query($sql);
		//echo $sql;
		if(mysql_num_rows($query) == 0)
			return false;
		return true;
	}
	public function add_new_branch($items){
		// $this->db->set('reg_date', 'NOW()', FALSE);
		$this->db->insert('0_branch',$items);
		$x=$this->db->insert_id();
		return $x;
	}
	public function update_new_branch($items,$branch_code){
		$this->db->where('branch_code', $branch_code);
		$this->db->update('0_branch', $items);

		return $this->db->last_query();
	}

	// ______________________________________________________ new lester _________________________________________
	
}
?>