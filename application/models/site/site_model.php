<?php
class Site_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
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

	public function get_db_now($format='php',$dateOnly=false){
		if($dateOnly)
			$query = $this->db->query("SELECT DATE(now()) as today");
		else
			$query = $this->db->query("SELECT now() as today");
		$result = $query->result();
		foreach($result as $val){
			$now = $val->today;
		}
		if($format=='php')
			return date('m/d/Y H:i:s',strtotime($now));
		else
			return $now;
	}

	public function update_language($items,$id){
		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->update('users',$items);
		$this->db->trans_complete();
		return $this->db->last_query();
	}

	public function get_company_profile(){
		$this->db->trans_start();
			$this->db->select('company_profile.*');
			$this->db->from('company_profile');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result[0];
	}

	public function get_custom_val($tbl,$col,$where=null,$val=null,$returnAll=false){
		if(is_array($col)){
			$colTxt = "";
			foreach ($col as $col_txt) {
				$colTxt .= $col_txt.",";
			}
			$colTxt = substr($colTxt,0,-1);
			$this->db->select($tbl.".".$colTxt);
		}
		else{
			$this->db->select($tbl.".".$col);
		}
		$this->db->from($tbl);

		if($where != '' || $val != '')
			$this->db->where($tbl.".".$where,$val);

		$query = $this->db->get();
		$result = $query->result();
		if($returnAll){
			return $result;
		}
		else{
			if(count($result) > 0){
				if(count($result) == 1)
					return $result[0];
				else
					return $result;
			}
			else
				return "";
		}
	}
	
	public function get_active_custom_val($tbl,$col,$where=null,$val=null,$returnAll=false){
		if(is_array($col)){
			$colTxt = "";
			foreach ($col as $col_txt) {
				$colTxt .= $col_txt.",";
			}
			$colTxt = substr($colTxt,0,-1);
			$this->db->select($tbl.".".$colTxt);
		}
		else{
			$this->db->select($tbl.".".$col);
		}
		$this->db->from($tbl);

		if($where != '' || $val != '')
			$this->db->where($tbl.".".$where,$val);
		
		//---#GET ALL ACTIVE VALUES ONLY
		$this->db->where($tbl.".inactive", 0);

		$query = $this->db->get();
		$result = $query->result();
		if($returnAll){
			return $result;
		}
		else{
			if(count($result) > 0){
				if(count($result) == 1)
					return $result[0];
				else
					return $result;
			}
			else
				return "";
		}
	}

	public function update_profile($user,$id){
		$this->db->where('id', $id);
		$this->db->update('users', $user);

		return $this->db->last_query();
	}
	
	// public function get_next_ref($type_id=null){
		// $this->db->select("*");
		// $this->db->from("trans_types");
		// $this->db->where("trans_type",$type_id);
		// $query = $this->db->get();
		// $result = $query->result();
		// $res = $result[0];
		// return $res;
	// }
	
	public function update_trans_types_next_type_no($prev_ref,$trans_type_id){
		$new_ref = $prev_ref+1;
		$this->db->where('trans_type', $trans_type_id);
		// $this->db->update('trans_types',array('next_ref'=>$new_ref),array('type_id'=>$trans_type));
		$this->db->update('trans_types',array('next_type_no'=>$new_ref));
		// echo $this->db->last_query();
		return $this->db->last_query();
	}

	public function update_trans_types_next_ref($new_ref,$trans_type_id){
		// $new_ref = $prev_ref+1;
		$this->db->where('trans_type', $trans_type_id);
		// $this->db->update('trans_types',array('next_ref'=>$new_ref),array('type_id'=>$trans_type));
		$this->db->update('trans_types',array('next_ref'=>$new_ref));
		// echo $this->db->last_query();
		return $this->db->last_query();
	}

	// private function update_trans_type_ref($items,$trans_type)
	// {
		// $this->db->where('trans_type',$trans_type);
		// $this->db->update('trans_types',$items);
	// }

	// function increment($reference)
	// {
		// $reference = preg_replace('/\s+/', "", $reference);
		// if (preg_match('/^(\D*?)(\d+)(.*)/', $reference, $result) == 1) {
		   // list($all, $prefix, $number, $postfix) = $result;
		   // $dig_count = strlen($number); // How many digits? eg. 0003 = 4
		   // $fmt = '%0' . $dig_count . 'd'; // Make a format string - leading zeroes
		   // $nextval =  sprintf($fmt, intval($number + 1)); // Add one on, and put prefix back on

		   // $new_ref=$prefix.$nextval.$postfix;
		// }
		// else
			// $new_ref=$reference;

	  // // display_error($new_ref);
	        // return $new_ref;

	  // /*
	        // if (is_numeric($reference))
	         // return $reference + 1;
	        // else
	      // return $reference;
	     // */
	// }

	// public function add_trans_ref($items)
	// {
		// # To be added later
		// // if (!isset($items['reference']) || !isset($items['type_no']) || !isset($items['trans_type']) || !isset($items['next_type_no']))
		// // 	throw new Exception('Reference array has missing indexes');

		// // $items['reference'] = preg_replace('/\s+/', "", $reference);

		// $this->db->insert('trans_refs',$items);
		// $inc_ref = $this->increment($items['reference']);
		// $this->update_trans_type_ref(array('next_type_no'=>((int) $items['type_no']+1),'next_ref'=>$inc_ref),$items['trans_type']);
		// // return $this->db->insert_id();
	// }

	// public function check_duplicate_ref($trans_type,$reference)
	// {
		// $this->db->select('*');
		// $this->db->from('trans_refs');
		// $this->db->where('trans_type',$trans_type);
		// $this->db->where('reference',$reference);

		// $query = $this->db->get();
		// $rows = $query->result();

		// if ($rows) {
			// $inc_ref = $this->increment($reference);
			// $bat = $this->check_duplicate_ref($trans_type,$inc_ref);
			// return $bat;
		// }
		// else
			// return $reference;
	// }
	//---------- FOR NEW PO [ 07 28 2015 ] ---------- START
	public function get_next_ref($type_id=null){
		$this->db->select("*");
		$this->db->from("trans_types");
		$this->db->where("trans_type",$type_id);
		$query = $this->db->get();
		$result = $query->result();
		// echo $this->db->last_query();
		$res = $result[0];
		return $res;
	}
	function increment($reference)
	{
		$reference = preg_replace('/\s+/', "", $reference);
		if (preg_match('/^(\D*?)(\d+)(.*)/', $reference, $result) == 1) {
		   list($all, $prefix, $number, $postfix) = $result;
		   $dig_count = strlen($number); // How many digits? eg. 0003 = 4
		   $fmt = '%0' . $dig_count . 'd'; // Make a format string - leading zeroes
		   $nextval =  sprintf($fmt, intval($number + 1)); // Add one on, and put prefix back on

		   $new_ref=$prefix.$nextval.$postfix;
		}
		else
			$new_ref=$reference;

	  // display_error($new_ref);
	        return $new_ref;

	  /*
	        if (is_numeric($reference))
	         return $reference + 1;
	        else
	      return $reference;
	     */
	}
	public function check_duplicate_ref($trans_type,$reference)
	{
		$this->db->select('*');
		$this->db->from('trans_refs');
		$this->db->where('trans_type',$trans_type);
		$this->db->where('reference',$reference);

		$query = $this->db->get();
		$rows = $query->result();

		if ($rows) {
			$inc_ref = $this->increment($reference);
			$bat = $this->check_duplicate_ref($trans_type,$inc_ref);
			return $bat;
		}
		else
			return $reference;
	}
	private function update_trans_type_ref($items,$trans_type)
	{
		$this->db->where('trans_type',$trans_type);
		$this->db->update('trans_types',$items);
	}
	public function add_trans_ref($items)
	{
		# To be added later
		// if (!isset($items['reference']) || !isset($items['type_no']) || !isset($items['trans_type']) || !isset($items['next_type_no']))
		// 	throw new Exception('Reference array has missing indexes');

		// $items['reference'] = preg_replace('/\s+/', "", $reference);

		$this->db->insert('trans_refs',$items);
		$inc_ref = $this->increment($items['reference']);
		$this->update_trans_type_ref(array('next_type_no'=>((int) $items['type_no']+1),'next_ref'=>$inc_ref),$items['trans_type']);
		// return $this->db->insert_id();
	}
	//---------- FOR NEW PO [ 07 28 2015 ] ---------- END]]
	
	
	
	public function get_branch_users($branch,$username=null,$password=null){
		if($branch == 'TNOV'){
			$branch = 'srs_aria_nova';
		}elseif($branch == 'TAQU'){
			$branch = 'srs_aria_antipolo_quezon';
		}elseif($branch == 'TAMA'){
			$branch = 'srs_aria_antipolo_manalo';
		}elseif($branch == 'TCAI'){
		    $branch = 'srs_aria_cainta';
		}elseif($branch == 'TCAM'){
			$branch = 'srs_aria_camarin';
		}elseif($branch == 'TCA2'){
			$branch = 'srs_aria_cainta_san_juan';
		}elseif($branch == 'TMAL'){
			$branch = 'srs_aria_malabon';
		}elseif($branch == 'TNAV'){
			$branch = 'srs_aria_navotas';
		}elseif($branch == 'TIMU'){
			$branch = 'srs_aria_imus';
		}elseif($branch == 'TGAG'){
			$branch = 'srs_aria_gala';
		}elseif($branch == 'TTON'){
			$branch = 'srs_aria_tondo';
		}elseif($branch == 'TVAL'){
			$branch = 'srs_aria_valenzuela';
		}elseif($branch == 'TBAG'){
			$branch = 'srs_aria_b_silang'; 
		}elseif($branch == 'TCOM'){
			$branch = 'srs_aria_comembo';
		}elseif($branch == 'TSAN'){
			$branch = 'srs_aria_san_pedro'; 
		}elseif($branch == 'TALA'){
			$branch = 'srs_aria_alaminos';
		}elseif($branch == 'TPUN'){
			$branch = 'srs_aria_punturin_val';
		}elseif($branch == 'TLAP'){
			$branch = 'srs_aria_talon_uno';
		}elseif($branch == 'TPAT'){
			$branch = 'srs_aria_pateros';
		}elseif($branch == 'TBGB'){
			$branch = 'srs_aria_bagumbong';
		}elseif($branch == 'TMOL'){
			$branch = 'srs_aria_molino';
		}elseif($branch == 'TGVL'){
			$branch = 'srs_aria_graceville';
		}elseif($branch == 'TMON'){
			$branch = 'srs_aria_montalban';
		}elseif($branch == 'TMANG'){
			$branch = 'srs_aria_manggahan';
		}elseif($branch == 'TSAP'){
			$branch = 'srs_aria_s_palay'; 
		}elseif($branch == 'TSIS'){
			$branch = 'srs_aria_san_isidro';
		}
		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
				if($connected){
				$query = $this->bdb->query("
										SELECT user_id,password,real_name,role_id
										FROM 0_users
										WHERE 
										user_id = '".$username."'
										AND
										password = '".md5($password)."'
										");
					
					$res = $query->result();
					return $res;
				}
					
		
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
										i.department_id
										FROM hs_hr_users as u 
										INNER JOIN hr_emp_job_info as i 
										ON  u.emp_number = i.emp_id
										WHERE user_name =  '".$username ."' AND user_password = '".$password."'
										");
					
					$res = $query->result();
					return $res;	
					// $this->bdb->select('*');
					// $this->bdb->from('hs_hr_users');
					// $this->bdb->where('user_name',$username);
					// $this->bdb->where('user_password',$password);
					// $query = $this->bdb->get();
					// $result = $query->result();
					
					// return $result;
				}
			
	}
	
	
	function insert_orange_users($new_users_details = array()){ 
		 $this->db->trans_start();
			 $this->db->insert('users',$new_users_details);
				$id = $this->db->insert_id();
		$this->db->trans_complete();
				return $id;
	 }	

	public function get_prod_cat($returnAll=false){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		$this->bdb->trans_start();
			
			$sql = "select c.description,c.LevelField1Code from Products n 
					inner join vendor v on v.vendorcode = n.vendorcode 
					left join LevelField1 c on c.LevelField1Code = n.LevelField1Code 
					where c.description !='' AND c.LevelField1Code !='' AND  n.SellingArea < 0 ";

			$query = $this->bdb->query($sql);
			$result = $query->result();
		$this->bdb->trans_complete();
		if($returnAll){
			return $result;
		}
		else{
			if(count($result) > 0){
				if(count($result) == 1)
					return $result[0];
				else
					return $result;
			}
			else
				return "";
		}
	}

	public function get_cc_cat($returnAll=false){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		$this->bdb->trans_start();
			
			$sql = "Select CategotyName, CategoryID FROM TempCC_Category";

			$query = $this->bdb->query($sql);
			$result = $query->result();
		$this->bdb->trans_complete();
		if($returnAll){
			return $result;
		}
		else{
			if(count($result) > 0){
				if(count($result) == 1)
					return $result[0];
				else
					return $result;
			}
			else
				return "";
		}
	}

	public function get_units($returnAll=false){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		$this->bdb->trans_start();
			
			$sql = "SELECT * FROM UOM";

			$query = $this->bdb->query($sql);
			$result = $query->result();
		$this->bdb->trans_complete();
		if($returnAll){
			return $result;
		}
		else{
			if(count($result) > 0){
				if(count($result) == 1)
					return $result[0];
				else
					return $result;
			}
			else
				return "";
		}
	}

	public function get_supplier($returnAll=false){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		$this->bdb->trans_start();
			
			$sql = "SELECT vendorcode,description FROM vendor ORDER BY description ASC";

			$query = $this->bdb->query($sql);
			$result = $query->result();
		$this->bdb->trans_complete();
		if($returnAll){
			return $result;
		}
		else{
			if(count($result) > 0){
				if(count($result) == 1)
					return $result[0];
				else
					return $result;
			}
			else
				return "";
		}
	}
}
?>