<?php
ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
set_time_limit(0);


class Asset_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	 function check_duplicate_asset($asset_no){
		 $sql = "SELECT * FROM 0_asset WHERE asset_no = '".$asset_no."'";
			$query = $this->db->query($sql);
				$row = $query->row();
			return $row;
	 }
	 
	 function count_asset_numbers($branch_code,$asset_type,$division_code,$department_code,$unit_code_pad){
	 
		 $sql1 = "SELECT MAX(count)  AS max_no FROM  0_asset_numbers WHERE branch_code ='". $branch_code.  "' AND
		 asset_type ='".$asset_type."' AND division_code ='". $division_code . "' AND  department_code = '". $department_code. "'AND unit_code=".$unit_code_pad."";
			$query = $this->db->query($sql1);
				$row = $query->row();
					if ($row != null)
						return $row->max_no;
					else
						return false;
			 
	 }
	 
	 function insert_asset($asset_details = array()){ 
		 $this->db->trans_start();
			$res =  $this->db->insert('0_asset',$asset_details);
			if($res){
				$id = $this->db->insert_id();
				return $id;
			}else{
				return false;
			}
		$this->db->trans_complete();
	 }	
	 
	 function insert_assign_asset_details($asset_assign_details = array()){ 
		 $this->db->trans_start();
			 $this->db->insert('0_assign_asset',$asset_assign_details);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
				return $id;
	 }	
	 
	 function insert_asset_transfer_details($asset_transfer_details = array()){ 
		 $this->db->trans_start();
			 $this->db->insert('0_asset_transfer_details',$asset_transfer_details);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
				return $id;
	 }	
	 
	 
	 function insert_asset_transfer_header($asset_transfer_header = array()){ 
		 $this->db->trans_start();
			 $this->db->insert('0_asset_transfer_header',$asset_transfer_header);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
				return $id;
	 }	
	 
	
	
	
	 function insert_asset_history($asset_details_history = array()){ 
		 $this->db->trans_start();
			 $this->db->insert('0_asset_history',$asset_details_history);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
				return $id;
	 }	 
	 
	 function  insert_asset_numbers($asset_numbers= array()){ 
		 $this->db->trans_start();
			 $this->db->insert('0_asset_numbers',$asset_numbers);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
			return $id;
	 }	
	 
	 function get_asset_acquisition_life($asset_id = null){
		
		$sql = "SELECT acquisition_cost,life_span FROM 0_asset WHERE id = '".$asset_id."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row;
			else
				return false;
	}
	 
	function get_asset_c_repair($asset_id = null){
		
		$sql = "SELECT SUM(cost) as repairs_cost FROM 0_asset_repair WHERE asset_id = '".$asset_id."' and type='Capitalizable' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->repairs_cost;
			else
				return '0';
	}
	
	
	function get_count_depre_months($date_,$id){
		
		$sql = "SELECT COUNT(amount) as dep_count FROM 0_asset_depreciation_details WHERE asset_id =".$id." and _date >'".$date_."' ";
		
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->dep_count;
			else
				return '0';
		
	}	
	
	function get_total_depre_amount($date_,$id){		
	
	$sql = "SELECT SUM(amount) as amount FROM 0_asset_depreciation_details WHERE asset_id =".$id." and _date <='".$date_."' ";
		
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->amount;
			else
				return '0';
	}
	
	public function get_salvage_value($id){
		
		 $sql = " SELECT salvage_value FROM 0_asset WHERE id =".$id." ";
		 	$query = $this->db->query($sql);
			$row = $query->row();
			if ($row != null){
		 		return $row->salvage_value;
			}else{
		 		return '0';
		 	}

	}	


	function get_total_depre_amount_for_disposal($date_,$id){		
	$sql = "SELECT SUM(amount) as amount FROM 0_asset_depreciation_details WHERE asset_id =".$id." and _date <= '".$date_."' ";
		
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->amount;
			else
				return '0';
	}


	function get_total_remaining_disposal_amount($date_,$id){		
	$sql = "SELECT SUM(amount) as amount FROM 0_asset_depreciation_details WHERE asset_id =".$id." and _date >= '".$date_."' ";
		
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->amount;
			else
				return '0';
	}


	
	
	function get_asset_repair_life($asset_id = null){
		
		$sql = "SELECT SUM(additional_life) as repairs_life  FROM 0_asset_repair WHERE asset_id = '".$asset_id."' and type='Capitalizable' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->repairs_life;
			else
				return '0';
	}
	

	function get_asset_descriptions_db($asset_id = null){
		
		$sql = "SELECT item_description FROM 0_asset WHERE id = '".$asset_id."' ";
		//return $sql;
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->item_description;
			else
				return false;
	}
	
	
	
	function get_hs_hr_user($emp_number = null){
			$sql = "SELECT first_name,last_name FROM hs_hr_users WHERE emp_number ='".$emp_number."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->first_name.' '.$row->last_name;
			else
				return false;
	}

	function get_asset_list($c_branch = null,$asset_no = null,$assined_p = null){

		$sql = "SELECT * FROM 0_asset WHERE disposed <> 1  ";

			if($c_branch){
				$sql .= "AND c_branch_code LIKE '%".$c_branch."%' ";
			}
			if($asset_no){
				$sql .= "AND asset_no LIKE '%".$asset_no."%'";
			}
			if($assined_p){
				$sql .= "AND assign_to LIKE '%".$assined_p."%'";
			}

			///return $sql;

		
			$query = $this->db->query($sql);
			$result = $query->result();
			
			if ($result != null)
				return $result;
			else
				return false;

	}


	function get_asset_no_db($asset_id = null){
		
		$sql = "SELECT asset_no FROM 0_asset WHERE id = '".$asset_id."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->asset_no;
			else
				return false;
	}
	 
	function get_asset_descripiton_db($asset_id = null){
		
		$sql = "SELECT item_description FROM 0_asset WHERE id = '".$asset_id."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->item_description;
			else
				return false;
	}
	
	function get_username($user_id = null){
		
		$sql = "SELECT fname,lname FROM users WHERE id = '".$user_id."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->fname.' '.$row->lname;
			else
				return false;
	}
	
	function department_name($dep_code = null){
		
		$sql = "SELECT department_description FROM 0_department WHERE department_code = '".$dep_code."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->department_description;
			else
				return false;
	}
	
	function get_asset_branch_drop($branch_code = ''){
	
	
		$on_process_asset ='';
		$assigned_asset = $this->get_assigned_asset();
		$array_aa = array();
		foreach($assigned_asset as $aa){
			//echo $aa->asset_id;
			array_push($array_aa,$aa->asset_id);
		}
		$on_process_asset =  implode($array_aa,',');
		
			if($on_process_asset == null)
				$on_process_asset = 0;
	
			$this->db->trans_start();
				$query = $this->db->query('
							SELECT *
							FROM 0_asset
							WHERE 
							c_branch_code = "'.$branch_code.'"
							AND 
							disposed <> 1
							AND 
							id NOT IN('.$on_process_asset.')
							ORDER BY id DESC
							');
				$res = $query->result();
			$this->db->trans_complete();
		
			return $res;
	
			// $this->db->trans_start();
			// $this->db->select('*');
			// $this->db->from('0_asset');
			 // if($branch_code != null)
			    // $this->db->where('c_branch_code',$branch_code);
				// $this->db->where('disposed <>',1);
			// $this->db->order_by('id desc');
			// $query = $this->db->get();
			// $result = $query->result();
		// $this->db->trans_complete();
		// return $result;
	}
	
	function get_asset_type_drop($asset_type = null){
			$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset');
			if($asset_type != null)
				$this->db->where('asset_type',$asset_type);
				$this->db->where('disposed <>',1);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	function get_asset($asset_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset');
			if($asset_id != null)
				$this->db->where('id',$asset_id);
				$this->db->where('disposed <>' ,1);
				$this->db->where('acquisition_cost >=' ,3500);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	

	function get_asset_request_header($asset_id = null){

		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_request_asset_header');
			if($asset_id != null)
				$this->db->where('id',$asset_id);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	
	function get_asset_trans_details($asset_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_transfer_details');
			if($asset_id != null)
				$this->db->where('asset_transfer_id',$asset_id);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	function get_check_temp_out($user_id = null,$trans_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_checking_temp');
			//if($user_id != null)
				//$this->db->where('user_id',$user_id);
				$this->db->where('asset_transfer_id',$trans_id);
			$this->db->where('out',1);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	
	
	function get_transfer_header($datefrom,$dateto,$transferno){
		
		
		
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_transfer_header');
			if($transferno){
				$this->db->where('id',$transferno);
			}
			if($datefrom){
				$this->db->where("date_delivered >= ", date('Y-m-d',strtotime($datefrom)));
				$this->db->where("date_delivered <= ",date('Y-m-d',strtotime($dateto)));
			}
			
		//	$this->db->where('asset_transfer_id',$trans_id);
		//	$this->db->where('in',1);
		//	$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}	
	
	function get_check_temp_in($user_id = null,$trans_id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_checking_temp');
		//	if($user_id != null)
				//$this->db->where('user_id',$user_id);
				$this->db->where('asset_transfer_id',$trans_id);
			$this->db->where('in',1);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	function process_check_out($trans_id=null, $user_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_transfer_details');
			$this->db->where('asset_transfer_id',$trans_id);
			//$this->db->where('user_id',);
			$this->db->where('out',1);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	function process_check_temp_out($trans_id=null, $user_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_checking_temp');
			$this->db->where('asset_transfer_id',$trans_id);
		//	$this->db->where('user_id',$user_id);
			$this->db->where('out',1);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	function process_check_temp_in($trans_id=null, $user_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_checking_temp');
			$this->db->where('asset_transfer_id',$trans_id);
			//$this->db->where('user_id',$user_id);
			$this->db->where('in',1);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	function check_details_temp($trans_id=null, $asset_no=null, $user_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_checking_temp');
			$this->db->where('asset_transfer_id',$trans_id);
			$this->db->where('asset_no',$asset_no);
		//	$this->db->where('user_id',$user_id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		if($result){
			return $result;	
		}else{
			return 'no_data';
		}
	}
	public function get_asset_no_id($asset_no=null){
		$sql = "SELECT * FROM 0_asset WHERE asset_no = '$asset_no' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->id;
		else
			return false;
	}
	
	public function get_asset_no($assetid=null){
		$sql = "SELECT * FROM 0_asset WHERE id = '$assetid' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->asset_no;
		else
			return false;
	}
	
	
	public function get_asset_no_id_details($asset_no=null){
		$sql = "SELECT * FROM 0_asset WHERE asset_no = '$asset_no' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row;
		else
			return false;
	}
	
	public function delete_remaining_months($asset_id=null,$_date=null){
		
		//$sql = "DELETE FROM 0_asset_depreciation_details WHERE asset_id = ".." and _date > '".$_date."' ";
		$this->db->where('asset_id',$asset_id);
		$this->db->where('_date >=',$_date);
		$this->db->delete('0_asset_depreciation_details');

	}
	
	public function delete_remaining_months_for_disposal($asset_id=null,$_date=null){
		
		//$sql = "DELETE FROM 0_asset_depreciation_details WHERE asset_id = ".." and _date > '".$_date."' ";
		$this->db->where('asset_id',$asset_id);
		$this->db->where('_date >=',$_date);
		$this->db->delete('0_asset_depreciation_details');

	}
	
	public function delete_remaining_gl_months($asset_id=null,$_date=null,$aria_db){
		$this->bdb = $this->load->database($aria_db,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->where('type_no',$asset_id);
				$this->bdb->where('tran_date >',$_date);
				$this->bdb->delete('0_gl_trans');
			}
	}
	
	
	public function delete_remaining_gl_months_for_disposal($asset_id=null,$_date=null,$aria_db){
		$this->bdb = $this->load->database($aria_db,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->where('type_no',$asset_id);
				$this->bdb->where('tran_date >=',$_date);
				$this->bdb->delete('0_gl_trans');
			}
	}
	
	public function update_reprint_tag($trans_id=null){
		$details = array('reprint'=> 1);
		$this->db->where('id',$trans_id);
		$this->db->update('0_asset_transfer_header',$details);	
	}

	public function upd_salvage_value($asset_id=null,$current_details=array()){
		$this->db->where('id',$asset_id);
		$this->db->update('0_asset',$current_details);	
	}



	
	function del_check_temp($trans_id = null, $asset_no = null, $user = null){
		$this->db->where('asset_transfer_id',$trans_id);
		$this->db->where('asset_no',$asset_no);
	//	$this->db->where('user_id',$user);
		$this->db->delete('0_asset_checking_temp');
	}	
	function del_transfer_temp($trans_id = null, $user = null){
		$this->db->where('asset_transfer_id',$trans_id);
	//	$this->db->where('user_id',$user);
		$this->db->delete('0_asset_checking_temp');
	}
	
	function current_loc_upd_status($asset_id=null,$current_details=array()){
		$this->db->where('id',$asset_id);
		$this->db->update('0_asset',$current_details);	
	}
	
	function upd_status($trans_id=null, $asset_id=null,$out_details=array()){
		$this->db->where('asset_transfer_id',$trans_id);
		$this->db->where('asset_id',$asset_id);
		$this->db->update('0_asset_transfer_details',$out_details);	
		
	}
	function upd_transfer_status($trans_id=null, $details=array()){
		$this->db->where('id',$trans_id);
		$this->db->update('0_asset_transfer_header',$details);	
		
	}
	public function check_asset_id_out($trans_id=null, $asset_id=null){
		$sql = "SELECT * FROM 0_asset_transfer_details WHERE asset_transfer_id = '$trans_id' AND asset_id = '$asset_id' AND `out` = 0";
		//$sql = "SELECT * FROM 0_asset_transfer_details WHERE asset_transfer_id = '$trans_id' AND `out` = 0";
		//echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row;
		else
			return false;
	}
	public function check_asset_id_in($trans_id=null, $asset_id=null){
		$sql = "SELECT * FROM 0_asset_transfer_details WHERE asset_transfer_id = '$trans_id' AND asset_id = '$asset_id' AND `in` = 0 AND `out` = 1";
	//	$sql = "SELECT * FROM 0_asset_transfer_details WHERE asset_transfer_id = '$trans_id' AND asset_id = '$asset_id' AND `in` = 0 AND `out` = 1";
		//echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row;
		else
			return false;
	}
	public function write_to_checking_temp($items){
		$this->db->insert('0_asset_checking_temp',$items);
		$id = $this->db->insert_id();
		return $id;
	}

	function get_asset_transfer_details2(){
		
			$query = $this->db->query("
						SELECT 
						h.id,
						h.from_branch,
						h.to_branch,
						h.to_department,
						h.to_unit,
						d.asset_transfer_id,
						d.date_in,
						d.date_out,
						d.asset_id,
						d.asset_type,
						d.description,
						d.`in`,
						d.`out`,
						d.confirmed_in
						FROM 0_asset_transfer_header as h INNER JOIN 0_asset_transfer_details as d 
						ON h.id = d.asset_transfer_id
						ORDER BY id DESC
						");
			$res = $query->result();
			return $res;		
		
	}
	
	function get_asset_transfer_details($asset_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_transfer_details');
			if($asset_id != null)
				$this->db->where('asset_transfer_id',$asset_id);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}



		function get_asset_disposal($asset_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_disposal');
			$this->db->where('is_disposed <>',1);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}




	function get_branch_c($id = null){
			$query = $this->db->query("
									SELECT c_branch_code FROM 0_asset WHERE id ='".$id."'
									
									");
						$res = $query->row();
						return $res->c_branch_code;


	}


	function get_asset_transfer_details_in($id = null){
		$sql = "SELECT COUNT(*) as tr_in FROM 0_asset_transfer_details WHERE `asset_transfer_id` = (SELECT `id` FROM 0_asset_transfer_header WHERE `id` = '".$id."') AND `in` = 0";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->tr_in;
	}
	function get_asset_transfer_details_out($id = null){
		$sql = "SELECT COUNT(*) as tr_out FROM 0_asset_transfer_details WHERE `asset_transfer_id` = (SELECT `id` FROM 0_asset_transfer_header WHERE `id` = '".$id."') AND `out` = 0";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->tr_out;
	}
	function get_asset_transfer_details_with_out($id = null){
		$sql = "SELECT COUNT(*) as tr_out FROM 0_asset_transfer_details WHERE `asset_transfer_id` = (SELECT `id` FROM 0_asset_transfer_header WHERE `id` = '".$id."') AND `out` = 1";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		//return $sql;
		return $res->tr_out;
	}
	function get_asset_transfer_details_with_in($id = null){
		$sql = "SELECT COUNT(*) as tr_in FROM 0_asset_transfer_details WHERE `asset_transfer_id` = (SELECT `id` FROM 0_asset_transfer_header WHERE `id` = '".$id."') AND `in` = 1";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->tr_in;
	}
	function count_asset_transfer_details($id = null){
		$sql = "SELECT COUNT(*) as tr_in FROM 0_asset_transfer_details WHERE `asset_transfer_id` = (SELECT `id` FROM 0_asset_transfer_header WHERE `id` = '".$id."')";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->tr_in;
	}
	function check_asset_in_history($id = null){
		$sql = "SELECT COUNT(*) as num FROM 0_asset_history WHERE `asset_id` = '".$id."' ";			
		$query = mysql_query($sql);
		$res = mysql_fetch_object($query);
		return $res->num;
	}
	function del_asset($id = null){
		$this->db->where('id',$id);
		$this->db->delete('0_asset');
	}	
	function del_asset_history($id = null){
		$this->db->where('asset_id',$id);
		$this->db->delete('0_asset_history');
	}	
	function get_asset_transfer_header($asset_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_transfer_header');
			if($asset_id != null)
				$this->db->where('id',$asset_id);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	function get_asset_transfer_header_($asset_department_code = null,$depcode = null){
		$this->db->trans_start();
				$this->db->select('*');
				$this->db->from('0_asset_transfer_header');
				//if($asset_department_code != null)
				//	$this->db->where('to_department',$asset_department_code);
				//	$this->db->where('status <>',3);
				$this->db->order_by('id desc');
				$query = $this->db->get();
				$result = $query->result();
			$this->db->trans_complete();
			return $result;
		
	}
	
	
	function get_asset_transfer_header_in($asset_department_code = null,$depcode = null){
		// $query = $this->db->query("SELECT * FROM 0_asset_transfer_header WHERE to_department IN(".$asset_department_code.") AND from_branch = '".$branch_code."' OR to_branch = '".$branch_code."' ORDER BY id DESC");
			// $res = $query->result();
			// return $res;
		if($depcode == 10){
			$this->db->trans_start();
				$this->db->select('*');
				$this->db->from('0_asset_transfer_header');
				//if($asset_department_code != null)
					//$this->db->where('to_department',$asset_department_code);
					$this->db->where('status <>',3);
				$this->db->order_by('id desc');
				$query = $this->db->get();
				$result = $query->result();
			$this->db->trans_complete();
			return $result;
		}else{
			$this->db->trans_start();
				$this->db->select('*');
				$this->db->from('0_asset_transfer_header');
				if($asset_department_code != null)
					$this->db->where('to_department',$asset_department_code);
					$this->db->where('status <>',3);
				$this->db->order_by('id desc');
				$query = $this->db->get();
				$result = $query->result();
			$this->db->trans_complete();
			return $result;
		}
	
	
	}
	
	function get_asset_request_details($asset_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_request_asset_details');
			if($asset_id != null)
				$this->db->where('request_id',$asset_id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	
	function insert_depreciation_details($asset_dep_details = array()){
		 $this->db->trans_start();
			 $this->db->insert('0_asset_depreciation_details',$asset_dep_details);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
			return $id;
		
	}
	
	function get_asset_type($asset_type_code){
		$sql = "SELECT description FROM 0_asset_type WHERE asset_type_code = '".$asset_type_code."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->description;
			else
				return false;
	}
	function get_asset_gl_account($asset_type=null){
		$sql = "SELECT gl_debit,gl_credit FROM 0_asset_type WHERE asset_type_code = '".$asset_type."'";
			$query = $this->db->query($sql);
			$row = $query->row();
			if ($row != null)
				return $row;
			else
				return false;
			
		
	}
	function get_trans_id($id){
			$sql = "SELECT out_trans_id FROM 0_asset_transfer_header WHERE id = '".$id."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->out_trans_id;
			else
				return false;
	}
	function get_aria_db($branch_code){
	
			$sql = "SELECT aria_db FROM 0_branch WHERE branch_code = '".$branch_code."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->aria_db;
			else
				return false;
	}
	
	function get_branch_desc($branch_code){
	
			$sql = "SELECT description FROM 0_branch WHERE branch_code = '".$branch_code."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->description;
			else
				return false;
	}
	
	
	function insert_gl_trans($gl_details = array(),$aria_db,$amount){
	
		$this->bdb = $this->load->database($aria_db,TRUE);
			$connected = $this->bdb->initialize();
				if($connected){
					$this->bdb->trans_start();
						$this->bdb->insert('0_gl_trans',$gl_details);
							$id = $this->bdb->insert_id();
					$this->bdb->trans_complete();

				}
	}
	
	function insert_request_asset_details($data = null){
		$this->db->trans_start();
			 $this->db->insert('0_request_asset_details',$data);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
			return $id;
		
	}
	
	function insert_request_header_details($request_asset_header_details = null){
		$this->db->trans_start();
			 $this->db->insert('0_request_asset_header',$request_asset_header_details);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
			return $id;
	}
	function insert_request_asset_temp($request_asset_details = null){
		
		 $this->db->trans_start();
			 $this->db->insert('0_request_asset_details_temp',$request_asset_details);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
			return $id;
		
	}
	
	function del_request_temp($ref = null){
		$this->db->where('id',$ref);
		$this->db->delete('0_request_asset_details_temp');
	}	
	
	function delete_temp_request_asset_details($ref = null){
		$this->db->where('user_id',$ref);
		$this->db->delete('0_request_asset_details_temp');
	}
	
	function get_request_asset_list_temp($ref = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_request_asset_details_temp');
			if($ref != null)
				$this->db->where('user_id',$ref);
			$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	function upd_request_status($upd_details=array(),$id = null){
		$this->db->where('id',$id);
		$this->db->update('0_request_asset_header',$upd_details);	
		
	}
	function unit_name($unit_code = null){
		
		$sql = "SELECT unit_description FROM 0_unit WHERE unit_code = '".$unit_code."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->unit_description;
			else
				return false;
	}
	
	function get_manager_dept_code($ref = null){
		$this->db->trans_start();
			$this->db->select('department_code');
			$this->db->from('0_department');
			if($ref != null)
				$this->db->where('manager_id',$ref);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_user_department_code($depcode=null){
		$sql = "SELECT asset_dept_code,manager_id,department_id FROM hr_department WHERE department_id = '$depcode' ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row;
		else
			return false;
	}

	function get_department_id($user_id = null){
		
		$sql = "SELECT department_id FROM users WHERE id = '".$user_id."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->department_id;
			else
				return false;
	}

	function get_asset_temp($id = null){
		$query = $this->db->query("SELECT * FROM 0_asset_checking_temp WHERE asset_transfer_id = $id ");
			$res = $query->result();
			return $res;	
		
	}
   function get_assigned_asset($dep_code = null){
	
			$query = $this->db->query("SELECT * FROM 0_asset_transfer_details WHERE confirmed_in = 0 ");
			$res = $query->result();
			return $res;	
	}
	
	function get_asset_request_header_in($dep_code = null,$is_manager,$depid){
	
	//	if($is_manager == '1'){
		if($depid == 10){
			$query = $this->db->query("SELECT * FROM 0_request_asset_header ORDER BY id DESC");
			$res = $query->result();
			return $res;
		}else{
			$query = $this->db->query("SELECT * FROM 0_request_asset_header  ORDER BY id DESC");
			//$query = $this->db->query("SELECT * FROM 0_request_asset_header WHERE to_department IN(".$dep_code.")  ORDER BY id DESC");
			$res = $query->result();
			return $res;
		}
				
	//	}else{
			// $query = $this->db->query("SELECT * FROM 0_request_asset_header WHERE to_department IN(".$dep_code.") AND to_branch = '".$branch_code."' ORDER BY id DESC");
			// $res = $query->result();
			// return $res;
		//	$query = $this->db->query("SELECT * FROM 0_request_asset_header WHERE to_department IN(".$dep_code.") ORDER BY id DESC");
		//	$res = $query->result();
		//	return $res;
		//}
			
	}
	
	
	function get_transfer_dep_asset($date_in = null, $asset_id = null, $aria_db = null){
	
		$this->bdb = $this->load->database($aria_db,TRUE);
			$connected = $this->bdb->initialize();
				if($connected){
					$this->bdb->trans_start();
					$this->bdb->select('*');
					$this->bdb->from('0_gl_trans');					
					$this->bdb->where('type_no',$asset_id);
					$this->bdb->where('tran_date >=',$date_in);
					$query = $this->bdb->get();
					$result = $query->result();
					$this->bdb->trans_complete();
					return $result;
				}
	}
	
	function insert_transfer_dep_details($depre_details = null,$aria_db = null){
		$this->bdb = $this->load->database($aria_db,TRUE);
			$connected = $this->bdb->initialize();
				if($connected){
					 $this->bdb->trans_start();
						 $this->bdb->insert('0_gl_trans',$depre_details);
						 $id = $this->bdb->insert_id();
					$this->bdb->trans_complete();
						return $id;
				}
	}
	
	
	public function delete_transfered_dep_months($asset_id = null,$aria_db = null,$date_in = null){
		
		$this->bdb = $this->load->database($aria_db,TRUE);
			$connected = $this->bdb->initialize();
				if($connected){
						$this->bdb->where('type_no',$asset_id);
						$this->bdb->where('tran_date >=',$date_in);
						$this->bdb->delete('0_gl_trans');
				}
	}
	
	
	function get_asset_history_details($asset_id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_history');
			if($asset_id != null)
				$this->db->where('asset_id',$asset_id);
				$this->db->order_by('stamp desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}

	function get_history_details($asset_id = null){
		$this->db->trans_start();
			$sql = "SELECT * from 0_asset_history where asset_id ='".$asset_id."' order by stamp desc ";
			$query = $this->db->query($sql);
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	
	public function get_last_branch_history($asset_id=null){
	
		$sql = "SELECT  branch_code,department_code FROM 0_asset_history  WHERE asset_id = '".$asset_id."' ORDER BY stamp DESC LIMIT 1";
		//echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row;
		else
			return false;
	}
	
	
     function insert_repair_asset_details($insert_repair_asset_details = null){
		
		 $this->db->trans_start();
			 $this->db->insert('0_asset_repair',$insert_repair_asset_details);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
			return $id;
		
	}
	
	 function  insert_asset_disposal_details($asset_disposal_details = array()){ 
		 $this->db->trans_start();
			 $this->db->insert('0_asset_disposal',$asset_disposal_details);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
			return $id;
	 }	
	 
	 function update_status($id = null,$upd_details=array()){
		$this->db->where('id',$id);
		$this->db->update('0_asset',$upd_details);	
		
	 }

	 function update_status_($id = null,$upd_details=array()){
		$this->db->where('asset_id',$id);
		$this->db->update('0_asset_disposal',$upd_details);	
		
	 }


	 
	 function upd_transfer_branch_code($upd_transfer_branch_code=null, $asset_id=null,$date_in =null){
		$this->db->where('asset_id',$asset_id);
		$this->db->where('_date >=',$date_in);
		$this->db->update('0_asset_depreciation_details',$upd_transfer_branch_code);	
		
	} 

	function get_asset_p_assigned($id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('users');
			//if($asset_id != null)
				$this->db->where('id',$id);
			//$this->db->order_by('id desc');
			$query = $this->db->get();
			if($query){
					$row = $query->row();
			}
//			$result = $query->result();
		$this->db->trans_complete();
		return $row;
	}
	
	function get_asset_trans_header($id = null){

		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_transfer_header');
			//if($asset_id != null)
				$this->db->where('id',$id);
			//$this->db->order_by('id desc');
			$query = $this->db->get();
			$row = $query->row();
//			$result = $query->result();
		$this->db->trans_complete();
		return $row;
	}
	
	function get_asset_transferout_details($id = null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('0_asset_transfer_details');
			//if($asset_id != null)
				$this->db->where('asset_transfer_id',$id);
		//	$this->db->order_by('id desc');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	public function get_asset_id($asset_no=null){
		$sql = "SELECT id FROM 0_asset WHERE asset_no = '$asset_no' ";
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->id;
		else
			return 0;
	}
	
	public function check_process_out_db($asset_id,$transfer_id){
		$sql = "SELECT id FROM 0_asset_transfer_details WHERE asset_id = '".$asset_id."' AND asset_transfer_id = '".$transfer_id."' ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->id;
		else
			return null;
	}
	
	
	
	public function get_orange_users($username=null,$password=null){
		
		$this->bdb = $this->load->database('orange',TRUE);
			$connected = $this->bdb->initialize();
				if($connected){
				$query = $this->bdb->query("
										SELECT  
										u.user_name,
										u.user_password,
										u.first_name,
										u.last_name,
										u.emp_number,
										i.department_id,
										i.sub_department_id
										FROM hs_hr_users as u 
										INNER JOIN hr_emp_job_info as i 
										ON  u.emp_number = i.emp_id
										WHERE user_name =  '".$username ."' AND user_password = '".$password."' AND sub_department_id = '36'
										");
					
					$res = $query->result();
					return $res;	
					
				}
			
	}
	
	function insert_orange_users($new_users_details = array()){ 
		 $this->db->trans_start();
			 $this->db->insert('users',$new_users_details);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
				return $id;
	 }
	 
	 
	 
	 public function get_user_details($id=null,$username=null,$password=null,$pin=null){
		$this->db = $this->load->database('default',TRUE);
			$connected = $this->db->initialize();
		if($connected){
			$this->db->trans_start();
				$this->db->select('users.*, user_roles.role as user_role,user_roles.access as access, user_roles.id as user_role_id');
				$this->db->from('users');
				$this->db->join('user_roles','users.role = user_roles.id','LEFT');
				if($id != null){
					$this->db->where('users.id',$id);
				}
				if($pin != null){
					$this->db->where('users.pin',$pin);
				}
				if($username != null && $password != null){
					$this->db->where('users.username',$username);
					$this->db->where('users.password',md5($password));
				}
				$this->db->where('sub_department_id',36);
				$this->db->where('users.inactive',0);
				$query = $this->db->get();
				$result = $query->result();
			$this->db->trans_complete();


			if(count($result) > 0){
				if(count($result) == 1){
					return $result[0];
				}
				else{
					return $result;
				}
			}
			else{
				return array();
			}
		}
	}
	 
	 
	 
	
	
	
	

	
}
?>