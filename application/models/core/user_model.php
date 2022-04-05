<?php
class User_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	public function get_users($id=null,$args=array()){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('users');
			if($id != null){
				if(is_array($id))
				{
					$this->db->where_in('users.id',$id);
				}else{
					$this->db->where('users.id',$id);
				}
			}
			if(!empty($args)){
				foreach ($args as $col => $val) {
					if(is_array($val)){
						if(!isset($val['use'])){
							$this->db->where_in($col,$val);
						}
						else{
							$func = $val['use'];
							if(isset($val['third'])){
								if(isset($val['operator'])){
									$this->db->$func($col." ".$val['operator']." ".$val['val']);
								}
								else
									$this->db->$func($col,$val['val'],$val['third']);
							}
							else{
								$this->db->$func($col,$val['val']);
							}
						}
					}
					else
						$this->db->where($col,$val);
				}
			}
			$this->db->order_by('fname');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
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