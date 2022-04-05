<?php
ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
set_time_limit(0);

class Operation_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}
	
	function get_negative_item(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		$this->bdb->trans_start();
			if($connected){

				$sql = "select n.*,v.description as vendor,c.description as category from Products n inner join vendor v on v.vendorcode = n.vendorcode left join LevelField1 c on c.LevelField1Code = n.LevelField1Code where n.SellingArea < 0";
			
				$qry = $this->bdb->query($sql);
				$result = $qry->result();
				$this->bdb->trans_complete();
				return $result;
			}
	}

	function get_sort_details($category = null, $supplier= null){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_start();
				$sql = "select top 100 n.*,v.description as vendor,c.description as category from Products n inner join vendor v on v.vendorcode = n.vendorcode left join LevelField1 c on c.LevelField1Code = n.LevelField1Code where  n.SellingArea < 0  ";


				if(!empty($category)){
					$sql .= "AND c.description = '".$category."'";
				}

				if(!empty($supplier)){
					$sql .= "AND v.description = '".$supplier."'";
				}

				$sql .= "ORDER BY n.SellingArea ASC";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
				$this->bdb->trans_complete();
				return $result;
			}
	}

	function item_adjustment_modal($id = null,$next_trans){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		$this->bdb->trans_start();
			if($connected){
				$this->bdb->trans_start();
					$sql = "select n.*,v.description as vendor,c.description as category from Products n inner join vendor v on v.vendorcode = n.vendorcode left join LevelField1 c on c.LevelField1Code = n.LevelField1Code where  n.SellingArea < 0 and n.ProductID = '".$id."' order by n.SellingArea ASC";

				$query = $this->bdb->query($sql);
				$result = $query->result();
			$this->bdb->trans_complete();
			return $result;
			}
	}

	function get_next_trans($aria_db=null){
		$this->bdb = $this->load->database($aria_db,TRUE);
		$connected = $this->bdb->initialize();
		$this->bdb->trans_start();
			if($connected){
				$this->bdb->trans_start();

					$sql = "SELECT MAX(a_id) as total_trans from 0_adjustment_header where a_movement_no = '' and a_status=1";

				$query = $this->bdb->query($sql);
				$result = $query->row();
			$this->bdb->trans_complete();
				if ($result != null)
						return $result->total_trans;
					else
						return false;
			}
	}

	function getCounter(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_start();

					$sql = "SELECT Counter FROM Counters WHERE TransactionTypeCode = 'IGSA'";

				$query = $this->bdb->query($sql);
				$result = $query->row();
			$this->bdb->trans_complete();
				if ($result != null)
						return $result->total_trans;
					else
						return false;
			}
	}

	function add_new_stock_move($data= array(),$aria_db){

		$this->bdb = $this->load->database($aria_db,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
					$user_id = $data['user_id'];
					$trans_num = $data['trans_num'];
					$date_adjustment = $data['date_adjustment'];
					$product_id = $data['product_id'];
					$qty = $data['qty'];
					$uom_qty = $data['uom_qty'];
					$unit = $data['unit'];
					$unit_cost = $data['unit_cost'];
					$cost = $data['cost'];
					$total = $data['total'];
					$remarks = $data['remarks'];
				
			$this->bdb->trans_start(TRUE);
				$result = '';
				$sql= "INSERT INTO 0_stock_moves (trans_no,stock_id,type,loc_code,tran_date,person_id,price,price_pcs,reference,qty,qty_pcs,multiplier,i_uom,standard_cost) values ('".$trans_num."','".$product_id."',17,2,'".$date_adjustment."','".$user_id."','".$cost."','".$unit_cost."','".$trans_num."','".$qty."','".$uom_qty."','".$qty."','".$unit."','".$total."')";

				$sql1="INSERT INTO 0_adjustment_header (a_id,a_trans_no,a_ms_movement_id,a_movement_code,a_movement_no,a_type,a_date_created,a_date_posted,a_ref,a_from_location,a_to_location,a_created_by,a_posted_by,a_status) values('".$trans_num."','".$trans_num."','','IGSA','',17,'".$date_adjustment."','','".$trans_num."','SELLING AREA','SELLING AREA','".$user_id."','',1)";

				$result['sql'] = $this->bdb->query($sql);
				$result['sql1'] = $this->bdb->query($sql1);

			$this->bdb->trans_complete();

			return $result;
			}
	}

	function uom_details($uom = null){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_start();
				$sql = "SELECT * FROM UOM where UOM ='".$uom."' ";
				$query = $this->bdb->query($sql);
				$result = $query->result();
				$this->bdb->trans_complete();
				return $result;
			}
	}

	function get_adjustment_inquiry($aria_db = null ){
		$this->bdb = $this->load->database($aria_db,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_start();
				$sql = "SELECT * FROM 0_stock_moves where type= 17 AND loc_code =2  order by tran_date desc limit 100";
				$query = $this->bdb->query($sql);
				$result = $query->result();
				$this->bdb->trans_complete();
				return $result;
			}
	}

}
?>