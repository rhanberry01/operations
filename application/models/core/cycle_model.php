<?php
ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
set_time_limit(0);

class cycle_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	function get_prod_details($bcode= null,$branch_code= null){
		$this->bdb = $this->load->database($branch_code,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_start();
				$sql = "SELECT Description,uom,srp FROM POS_Products WHERE Barcode = '".$bcode."'";

				$query = $this->bdb->query($sql);
				$result = $query->result();
				$this->bdb->trans_complete();
				return $result;
				}
	}

	function get_cycle_count(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch']; 
		$aria_db = $this->asset->get_aria_db($user_branch);
		$this->bdb = $this->load->database($aria_db,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_start();
				
				$sql = "SELECT * FROM 0_cycle_count ORDER BY date_created DESC";

				$query = $this->bdb->query($sql);
				$result = $query->result();
				$this->bdb->trans_complete();
				return $result;
			}
	}

	function product_desc($bcode,$branch_code){
		$this->bdb = $this->load->database($branch_code,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_start();
				$sql = "SELECT Description FROM POS_Products WHERE Barcode = '".$bcode."'";

				$query = $this->bdb->query($sql);
				$row = $query->row();
				$this->bdb->trans_complete();
				if ($row != null)
					return $row->Description;
				else
					return false;
				}
	}

	function get_branch($branch_code){
	
			$sql = "SELECT description FROM 0_branch WHERE branch_code = '".$branch_code."' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row != null)
				return $row->description;
			else
				return false;
	}

	function add_new_count($data= array(),$aria_db){
		$this->bdb = $this->load->database($aria_db,TRUE);

		$user_id = $data['user_id'];
		$uom = $data['uom'];
		$cost = $data['cost'];
		$branch_code = $data['branch_code'];
		$bcode = $data['bcode'];
		$date = $data['date'];
		$connected = $this->bdb->initialize();
		if($connected){

			$this->bdb->trans_start();
			$result = '';
			$sql = "INSERT INTO 0_cycle_count (branch_code,bcode,uom,cost,user,status,date_created) values ('".$branch_code."','".$bcode."','".$uom."','".$cost."','".$user_id."',0,'".$date."')";

			$output = $this->bdb->query($sql);
			
			$result = array('status'=>200,'message'=>'Item Save','result'=>$output);

			$this->bdb->trans_complete();
			return $result;
		}
	}

	function certify_item($id= null,$aria_db){

		$this->bdb = $this->load->database($aria_db,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				
			$this->bdb->trans_start(TRUE);
				$sql= "UPDATE 0_cycle_count set status =1 where id ='".$id."' ";

				$output= $this->bdb->query($sql);
				$result = array('status'=>200,'message'=>'Item Certified','result'=>$output);

			$this->bdb->trans_complete();

			return $result;
			}
	}

	function delete_sku($id= null,$aria_db){

		$this->bdb = $this->load->database($aria_db,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				
			$this->bdb->trans_start(TRUE);
				$sql= "DELETE from 0_cycle_count where id ='".$id."' ";

				$result= $this->bdb->query($sql);

			$this->bdb->trans_complete();

			return $result;
			}
	}
}
?>

