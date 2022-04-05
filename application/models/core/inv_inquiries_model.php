<?php
class Inv_inquiries_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_stocks($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcodes_new');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}	
	// rhan start get all data in stock_master_temp
	public function get_stocks_master_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master_new_temp');
			if($id != null)
				$this->db->where('stock_id',$id);
			$this->db->order_by('date_added DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//rhan end 
	
	//rhan start reject
	public function reject_add_stock($id=null){
		$res ='';
		$sql_stock_cards ="DELETE FROM  pos_stock_cards_temp WHERE stock_id=".$id;
			$res = mysql_query($sql_stock_cards);
			
		$sql_stock_discounts ="DELETE FROM  pos_stock_discounts_temp WHERE stock_id=".$id;
			$res = mysql_query($sql_stock_discounts);
			
		$sql_stock_master ="DELETE FROM  stock_master_new_temp WHERE stock_id=".$id;
			$res = mysql_query($sql_stock_master);
		
		if($res)
			return 'success';
		return 'error';
	}
	//rhan end
	
	//rhan start approve
	public function stock_barcode_approval($id=null){
	
	//stock_master
	$sql_stock_master = "INSERT INTO stock_master_new
						(
						stock_code,
						category_id,
						tax_type_id,
						description,
						report_uom,
						report_qty,
						mb_flag,
						is_consigned,
						sales_account,
						cogs_account,
						inventory_account,
						adjustment_account,
						assembly_cost_account,
						standard_cost,
						last_cost,
						cost_of_sales,
						is_saleable,
						senior_citizen_tag,
						earn_suki_points,
						earn_urc_points,
						date_added,
						inactive,
						approval_remarks)
							SELECT 
							stock_code,
							category_id,
							tax_type_id,
							description,
							report_uom,
							report_qty,
							mb_flag,
							is_consigned,
							sales_account,
							cogs_account,
							inventory_account,
							adjustment_account,
							assembly_cost_account,
							standard_cost,
							last_cost,
							cost_of_sales,
							is_saleable,
							senior_citizen_tag,
							earn_suki_points,
							earn_urc_points,
							date_added,
							inactive,
							approval_remarks
							FROM stock_master_new_temp WHERE stock_id = ".$id;	
							
		$query = mysql_query($sql_stock_master);
		
		$last_id = mysql_insert_id();
		
		//update stock_id in pos_stock_cards_temp and pos_stock_discounts_temp table
		$sql_update_pos_stock_cards_temp_stockid = "UPDATE pos_stock_cards_temp SET stock_id = '".$last_id."' WHERE stock_id=".$id;
			mysql_query($sql_update_pos_stock_cards_temp_stockid);
		$sql_update_pos_stock_discounts_temp_stockid = "UPDATE pos_stock_discounts_temp SET stock_id = '".$last_id."' WHERE stock_id=".$id; 
			mysql_query($sql_update_pos_stock_discounts_temp_stockid);
		
		//pos_stock_cards_temp
		$sql_pos_stock_cards_temp = "
									INSERT INTO	pos_stock_cards
									(
									id,
									stock_id,
									sales_type_id,
									card_type_id,
									is_enabled,
									inactive
									)
									SELECT 
									id,
									stock_id,
									sales_type_id,
									card_type_id,
									is_enabled,
									inactive
									FROM pos_stock_cards_temp WHERE stock_id ='".$last_id."'
									";
		$query = mysql_query($sql_pos_stock_cards_temp);
		
		
		
		//pos_stock_discounts_temp
		$sql_pos_stock_discounts_temp="
									  INSERT INTO pos_stock_discounts
									  (
										id,
										stock_id,
										sales_type_id,
										pos_discount_id,
										disc_enabled,
										inactive
									  )
									  SELECT 
										id,
										stock_id,
										sales_type_id,
										pos_discount_id,
										disc_enabled,
										inactive
									  FROM pos_stock_discounts_temp WHERE stock_id ='".$last_id."'
									  ";
		$queries = mysql_query($sql_pos_stock_discounts_temp);		

	
		
		if($queries){
		$sql_stock_cards ="DELETE FROM  pos_stock_cards_temp WHERE stock_id=".$last_id;
			$res = mysql_query($sql_stock_cards);
			
		$sql_stock_discounts ="DELETE FROM  pos_stock_discounts_temp WHERE stock_id=".$last_id;
			$res = mysql_query($sql_stock_discounts);
			
		$sql_stock_master ="DELETE FROM  stock_master_new_temp WHERE stock_id=".$id;
			$res = mysql_query($sql_stock_master);
			
			if($res){
			 return 'success';	
			}else{
				return 'error';		
			}
			
		}
	}
	//rhan end
	
	// rhan start get all data in stock_master_temp
	public function get_stocks_temp($id=null){
		$sql = "SELECT * FROM stock_master_new_temp WHERE stock_id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result;
	}
	//rhan end 
	
	// rhan start get category
	public function get_category($id=null){
		$sql = "SELECT description FROM stock_categories_new WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->description;
	}
	//rhan end 
	
	// rhan start get category
	// public function get_user_name($id=null){
		// $sql = "SELECT fname,mname,lname FROM users WHERE id=".$id;
		// echo $sql;
		// $query = mysql_query($sql);
		// $result = mysql_fetch_object($query); 
		// return $result->fname.' '.$result->mname.' '.$result->lname;
	// }
	public function get_user_name($id=null){
		$sql = "SELECT fname,mname,lname, suffix FROM users WHERE id=".$id;
		// echo $sql."<br>";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
			return $row->fname." ".$row->mname." ".$row->lname." ".$row->suffix;
		else
			return false;
	}
	//rhan end 
		
	///rhan start_get_stock_deletion_for_approval
		
	public function get_stock_deletion_approval($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_deletion_approval');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
   }
	
	//rhan end
	
	public function get_stocks_temp_load($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master_new_temp');
			if($id != null)
				$this->db->where('stock_id',$id);
			$this->db->order_by('date_added DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	// rhan start get all marginal markdown in stock_barcode_scheduled_markdown_temp
	public function get_stock_barcode_marginal_markdown_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_marginal_markdown_temp');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->order_by('datetime_added DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//rhan end 
	
	// rhan start get all schedule markdown in stock_barcode_scheduled_markdown_temp
	public function get_stock_barcode_scheduled_markdown_temp($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_scheduled_markdown_temp');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->order_by('datetime_added DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//rhan end 
	
	// rhan start get all schedule markdown in stock_barcode_scheduled_markdown_temp
	public function get_stock_logs($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_logs');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->order_by('date_modified DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//rhan end 
	
	
  // rhan start get all get_barcode_prices_update
	public function get_barcode_prices_update($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_prices_approval');
			if($id != null)
				$this->db->where('id',$id);
			$this->db->order_by('date_modified DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//rhan end 
	
	//rhan start get branch name
		public function get_branch_name($id=null){
		$sql = "SELECT name FROM branches WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->name;
	}
	//rhan end 
	
	//rhan start get branch name
		public function get_branch_code($id=null){
		$sql = "SELECT code FROM branches WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->code;
	}
	//rhan end 
	
	
	public function reject_prices_update($id=null){
		 $sql2 ="UPDATE stock_logs SET approval_status = '2' WHERE id=".$id;
		 $res = mysql_query($sql2);
		 
				
		if($res)
			return 'success';
		return 'error';
	}
	
	public function reject_barcode_prices_update_db($id=null){
		 $sql2 ="UPDATE stock_barcode_prices_approval SET approval_status = '2' WHERE id=".$id;
		 $res = mysql_query($sql2);		
		if($res)
			return 'success';
		return 'error';
	}


	 //rhan start reject marginal markdown
	public function reject_marginal_markdown($id=null){
		$sql ="DELETE FROM  stock_barcode_marginal_markdown_temp WHERE id=".$id;
		$res = mysql_query($sql);
				
		if($res){
			return 'success';
		}else{
		return 'error';
		}
	}
	//rhan end
	
 //rhan start reject schedule markdown
	public function reject_schedule_markdown($id=null){
		$sql ="DELETE FROM  stock_barcode_scheduled_markdown_temp WHERE id=".$id;
		$res = mysql_query($sql);
				
		if($res)
			return 'success';
		return 'error';
	}
	//rhan end
	public function schedule_markdown_approvals($id=null){
	
		$sql = "
				INSERT INTO	stock_barcode_scheduled_markdown
	            (
				stock_id,
				barcode,
				branch_id,
				sales_type_id,
				start_date,
				end_date,
				start_time,
				end_time,
				markdown,
				original_price,
				discounted_price,
				datetime_added,
				datetime_modified,
				added_by,
				modified_by,
				inactive,
				approval_remarks
				)
				SELECT
				stock_id,
				barcode,
				branch_id,
				sales_type_id,
				start_date,
				end_date,
				start_time,
				end_time,
				markdown,
				original_price,
				discounted_price,
				datetime_added,
				datetime_modified,
				added_by,
				modified_by,
				inactive,
				approval_remarks
				FROM stock_barcode_scheduled_markdown_temp WHERE id ='".$id."'
				";
		$query = mysql_query($sql);
		  if($query){
			$sql ="DELETE FROM  stock_barcode_scheduled_markdown_temp WHERE id=".$id;
				$res = mysql_query($sql);
				if($res)
					return 'success';  
				return 'error';
		  }else{
			 return 'error';
		  }
		
	}
	//rhan get schedule markdown
	public function schedule_markdown_view($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_scheduled_markdown_temp');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	
	// rhan start get all stock barcode prices
	public function get_stock_barcode_prices($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcodes_new_temp');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//rhan end 
	// mhae start get all supplier stocks
	public function get_supplier_stocks($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_stocks_temp');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//mhae end 
	public function get_supplier_stocks_temp_load($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('supplier_stocks_temp');
			if($id != null)
				$this->db->where('id',$id);
			//$this->db->order_by('date_added DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	//rhan start get sales_type name
	public function sales_type($id=null){
		$sql = "SELECT sales_type FROM sales_types WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->sales_type;
	}
	//rhan end 
	
	 //rhan start reject schedule markdown
	public function reject_stock_barcode_price($id=null){
		// $sql ="DELETE FROM  stock_barcode_prices_temp WHERE id=".$id;
		// $res = mysql_query($sql);
		
	  $sql ="DELETE FROM  stock_barcodes_new_temp WHERE barcode=".$id;
		mysql_query($sql);
	 
	 $sql1 ="DELETE FROM  stock_barcode_prices_temp WHERE barcode=".$id;
		$ret = mysql_query($sql1);
				
		if($ret)
			return 'success';
		return 'error';
	}
	//rhan end

	public function reject_stock_deletion($id=null){			
		$sql1="UPDATE stock_deletion_approval SET approval_status = '2' WHERE id=".$id;	
		$results_query = mysql_query($sql1);
		
		if($results_query)
			return 'success';
		return 'error';
	}
	
//mhae start reject
	public function reject_add_supplier_stocks($id=null){
		$res ='';
			
		$sql_stock_master ="DELETE FROM  supplier_stocks_temp WHERE id=".$id;
			$res = mysql_query($sql_stock_master);
		
		if($res)
			return 'success';
		return 'error';
	}
	//mhae end
		
 //rhan get schedule markdown
	public function barcode_prices_view($barcode=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcode_prices_temp');
			if($barcode != null)
				$this->db->where('barcode',$barcode);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
//Movements Approval - Mhae
	public function get_movements_approval($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('movements');
			//$this->db->join('movement_details', 'movements.id = movement_details.header_id');
			if($id != null)
				$this->db->where('id',$id);
			//$this->db->where('status = 1');
			$this->db->order_by('date_created DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_movements_details_approval($id=null, $branch_id=null){
		$sql = "SELECT * FROM `movements` JOIN `movement_details` ON `movements`.`id` = `movement_details`.`header_id` AND `movements`.`branch_id` = `movement_details`.`branch_id` WHERE `movements`.`id` = '".$id."' AND `movements`.`branch_id` = '".$branch_id."'";
		$query = $this->db->query($sql);
		$result = $query->result();
		// echo $this->db->last_query();
		return $result;
	}
	public function reject_added_movements($items, $id){
		$this->db->where('id', $id);
		$this->db->update('movements', $items);
		return 'success';
	}
	public function user_name($person_id=null){
		$sql = " SELECT CONCAT(fname, ' ', mname, ' ', lname, ' ', suffix) AS person FROM `users` WHERE id=".$person_id;
		$query = $this->db->query($sql);
		$result = $query->result();
		$res = $result[0];
		return $res->person;
	}
	
//Movements Approval - Mhae
//-----AUDIT TRAIL-----APM-----START
	public function write_to_audit_trail($items=array())
	{
		$this->db->insert('audit_trail',$items);
		$id = $this->db->insert_id();
		return $id;
	}
//-----AUDIT TRAIL-----APM-----END

	public function get_stocks_master($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master_new');
			if($id != null)
				$this->db->where('stock_id',$id);
				$this->db->where('inactive',0);
			$this->db->order_by('date_added DESC');
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_search_stock_details($ref=null,$start_date=null,$end_date=null){
		$this->db->trans_start();
			$sub_query = $this->db->query('SELECT subcat_id FROM stock_categories_new WHERE id = "'.$ref.'"');
			$sub_result = $sub_query->result();
			foreach($sub_result as $val){
				$res = $val->subcat_id;
			}
			//echo $res;
			if($res == 0){
				$query = $this->db->query('SELECT * FROM stock_master_new WHERE category_id IN (SELECT id FROM stock_categories_new WHERE subcat_id = "'.$ref.'") AND date(date_added) >= "'.$start_date.'" AND date(date_added) <= "'.$end_date.'" ORDER BY date_added DESC');
			}else{
				$query = $this->db->query('SELECT * FROM stock_master_new WHERE category_id = "'.$ref.'" AND date(date_added) >= "'.$start_date.'" AND date(date_added) <= "'.$end_date.'" ORDER BY date_added DESC');
			}
				$result = $query->result();
		$this->db->trans_complete();
		$this->db->last_query();
		
		return $result;
	}
	public function tax_type_id_to_name($id=''){
		$sql = "SELECT tax_type_name FROM stock_tax_types_new WHERE id = $id ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
		return $row->tax_type_name;
		return false;
	}
	public function category_short_desc($cat_id=''){
		$sql = "SELECT short_desc FROM stock_categories_new WHERE id = $cat_id ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
		return $row->short_desc;
		return false;
	}
	public function get_stock_deletion_stock_id($id=''){
		$sql = "SELECT stock_id FROM stock_deletion_approval WHERE id = $id ";
		$query = $this->db->query($sql);
		$row = $query->row();
		if ($row != null)
		return $row->stock_id;
		return false;
	}
	public function get_stock_deletion_details($_id = NULL){	
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_master_new');
			$this->db->where('stock_id',$_id);
			$query  = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
	public function get_stock_barcode_prices_($id=null){
		$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('stock_barcodes_new_temp');
			if($id != null)
				$this->db->where('barcode',$id);
			$query = $this->db->get();
			$result = $query->result();
		$this->db->trans_complete();
		return $result;
	}
}