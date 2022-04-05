<?php
ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
set_time_limit(0);

class operation_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}
	
	function get_connection(){
		//$this->ddb = $this->load->database('branch_server', true);
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected)
			return 'connected';
        else
        	return 'disconnected';
	}


	function get_negative_item(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
			if($connected){

				$sql = "select top 100 n.*,v.description as vendor,c.description as category from Products n 
				inner join vendor v on v.vendorcode = n.vendorcode 
				left join LevelField1 c on c.LevelField1Code = n.LevelField1Code where n.SellingArea < 0 and n.inactive = 0 ";
			
				$qry = $this->bdb->query($sql);
				$result = $qry->result();
		//		$this->bdb->trans_complete();
				return $result;
			}
	}



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
	
	public function update_users($user,$id){
		$this->db->where('id', $id);
		$this->db->update('users', $user);

		return $this->db->last_query();
	}

	// LAWRENZE
	function get_aria_db($branch_code){
		$sql = "SELECT aria_db,db_133,description FROM 0_branch WHERE branch_code = '".$branch_code."' ";
		$query = $this->db->query($sql);
		$row = $query->row();
		
		if ($row != null)
			return $row;
		else
			return false;
	}

	function get_133_db($branch_code){
		$sql = "SELECT aria_db,db_133,description FROM 0_branch WHERE db_133 = '".$branch_code."' ";
		$query = $this->db->query($sql);
		$row = $query->row();
		
		if ($row != null)
			return $row;
		else
			return false;
	}

	function get_branches(){
		$sql = "SELECT db_133,description FROM 0_branch ORDER BY description ASC";
		$query = $this->db->query($sql);
    	return $query->result_array();
	}
	// ./LAWRENZE

	public function get_users($id=null)
	{
		//$this->db->trans_start();
			$this->db->select('*');
			$this->db->from('users');
			if($id != null)
				$this->db->where('id',$id);
			$query = $this->db->get();
		$result = $query->result();
		//$this->db->trans_complete();
		return $result;	
	}

	public function get_role($id=null){
		$sql = "SELECT role FROM user_roles WHERE id=".$id;
		$query = mysql_query($sql);
		$result = mysql_fetch_object($query); 
		return $result->role;
	}

function get_viewing_details(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
			//	$this->bdb->trans_start();
				$sql = "select top 100 n.*,v.description as vendor,c.description as category
				 from Products n inner join vendor v on v.vendorcode = n.vendorcode left join LevelField1 c 
				 on c.LevelField1Code = n.LevelField1Code where n.inactive = 0 and n.SellingArea < 0  and v.consignor != 1 ORDER BY n.SellingArea ASC  ";

				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
			}
	}

	function get_sort_details($category = null, $supplier= null){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
		//		$this->bdb->trans_start();
				$sql = "select top 100 pos.*,n.*,v.description as vendor,c.description as category from 
						Products n 
						left join  (select DISTINCT ProductID as pp,min(qty) as qty from POS_Products GROUP BY ProductID) as  pos on n.ProductID = pos.pp 
						inner join vendor v on v.vendorcode = n.vendorcode 
						left join LevelField1 c on c.LevelField1Code = n.LevelField1Code 
						where (n.SellingArea < 0 and v.consignor != 1) and n.inactive = 0 ";

// 				$sql = "select top 100 pos.*,n.*,v.description as vendor,c.description as category 
// from Products n 
// inner join vendor v on v.vendorcode = n.vendorcode 
// left join LevelField1 c on c.LevelField1Code = n.LevelField1Code 
// left join POS_Products pos on n.ProductID = pos.ProductID
// where (n.SellingArea < 0 and v.consignor != 1) AND pos.uom = 'PC' ";


				if($category && $supplier){
					$sql .= "AND c.description = '".$category."' AND v.vendorcode = '".$supplier."' ORDER BY n.SellingArea ASC";
				}else if($supplier){
					$sql .= "AND v.vendorcode = '".$supplier."' ORDER BY n.SellingArea ASC";
				}else if($category){
					$sql .= "AND c.description = '".$category."' ORDER BY n.SellingArea ASC";
				}else{
					$sql .= "ORDER BY n.SellingArea ASC";
				}


				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
			}
	}
	
	//add cc_auto_info
		//add cc_auto_info
	function add_info_cc($autoid = NULL){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		date_default_timezone_set('Asia/Manila');
		$now = date('Y-m-d H:i:s');
		
		if($connected){	
			$sql = "Insert into TempCC_Auto_Info (AutoID,Branch,DateTrans) values ('$autoid','$user_branch','$now')";
			$this->bdb->trans_begin();
			$result = $this->bdb->query($sql);
			$this->bdb->query($sql2);
			
			// $this->bdb->trans_complete();

			if ($this->bdb->trans_status() === FALSE) {
	            //if something went wrong, rollback everything
	            $this->bdb->trans_rollback();
	       		return 'error';
	        } else {
	            //if everything went right, delete the data from the database
	            $this->db->trans_commit();
	            return 'success';
	        }
		}
	}
	
	//add product details for cycle count -Paul
	function add_details_cc($infoid = NULL){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		
		if($connected){	
			$sql = "Insert into TempCC_Auto_Details(InfoID,ProductID,GlobalID,Barcode,Branch)
					Select $infoid,ProductID,GlobalID,Barcode,Branch from TempCycleCount";
			
			$this->bdb->trans_begin();
			$result = $this->bdb->query($sql);
			$this->bdb->query($sql2);
			//$this->bdb->trans_complete();

			if ($this->bdb->trans_status() === FALSE) 
			{
			        $this->bdb->trans_rollback();
			        return 'error';
			}
			else
			{
			        $this->bdb->trans_commit();
			        return 'success';
			}
		}
	}
	
	function up_cat($id= NULL, $cat = NULL,$days = NULL,$weeks = NULL){
		$user    = $this->session->userdata('user');
		$user_id = $user['id']; 
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		date_default_timezone_set('Asia/Manila');
		$now = date('Y-m-d H:i:s');
		
		if($connected){	
			$this->bdb->trans_begin();
			$sql = "Update TempCC_Category SET CategoryName = '$cat', Schedule = '$weeks', Day= '$days' Where CategoryID = '$id'";
			$result = $this->bdb->query($sql);
			//$this->bdb->trans_complete();
			// $sql2 = "Insert INTO TempCC_Category_Details 
			// 	(ProductID, ProductCode, Barcode, Description, 
			// 	uom, Branch, GlobalID, UserID, CategoryID) 
			// 	Select ProductID, ProductCode, Barcode, Description, 
			// 	uom, Branch, GlobalID, UserID, (Select Max(CategoryID) from TempCC_Category) 
			// 	from TempCycleCount";

			// $result = $this->bdb->query($sql2);
			
			// $sql3="Delete from TempCycleCount";
			// $this->bdb->query($sql3);

			if ($this->bdb->trans_status() === FALSE) 
			{
			        $this->bdb->trans_rollback();
			        return 'error';
			}
			else
			{
			        $this->bdb->trans_commit();
			        return 'success';
			}
		}
	}

	function save_cat($cat = NULL,$days = NULL,$weeks = NULL){
		$user    = $this->session->userdata('user');
		$user_id = $user['id']; 
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		date_default_timezone_set('Asia/Manila');
		$now = date('Y-m-d H:i:s');
		
		if($connected){	
			$this->bdb->trans_begin();
			$sql = "Insert into TempCC_Category (CategoryName,UserID,DateCreated,Schedule,Day,Branch) values ('$cat','$user_id','$now','$weeks','$days','$user_branch')";
			
			$this->bdb->query($sql);

			$sql2 = "Insert INTO TempCC_Category_Details 
				(ProductID, ProductCode, Barcode, Description, 
				uom, Branch, GlobalID, UserID, CategoryID) 
				Select ProductID, ProductCode, Barcode, Description, 
				uom, Branch, GlobalID, UserID, (Select Max(CategoryID) from TempCC_Category) 
				from TempCycleCount";

			$result = $this->bdb->query($sql2);
			
			$sql3="Delete from TempCycleCount";
			$this->bdb->query($sql3);
			//$this->bdb->trans_complete();

			if ($this->bdb->trans_status() === FALSE) 
			{
			        $this->bdb->trans_rollback();
			        return 'error';
			}
			else
			{
			       	$this->bdb->trans_commit();
			        return 'success';
			}
		}
	}

	function addto_cat($cat = NULL){
		$user    = $this->session->userdata('user');
		$user_id = $user['id']; 
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		date_default_timezone_set('Asia/Manila');
		$now = date('Y-m-d H:i:s');
		
		if($connected){	
			$this->bdb->trans_begin();
			//$sql = "Insert into TempCC_Category (CategoryName,UserID,DateCreated,Schedule,Day,Branch) values ('$cat','$user_id','$now','$weeks','$days','$user_branch')";
			
			//$this->bdb->query($sql);

			$sql2 = "Insert INTO TempCC_Category_Details 
				(ProductID, ProductCode, Barcode, Description, 
				uom, Branch, GlobalID, UserID, CategoryID) 
				Select ProductID, ProductCode, Barcode, Description, 
				uom, Branch, GlobalID, UserID, '$cat'
				from TempCycleCount";

			$result = $this->bdb->query($sql2);
			
			$sql3="Delete from TempCycleCount";
			$this->bdb->query($sql3);

			$sql4 = "Update TempCC_Category SET DateLastModified = '".$now."' where CategoryID = '".$cat."'";
			$this->bdb->query($sql4);


			//$this->bdb->trans_complete();

			if ($this->bdb->trans_status() === FALSE) 
			{
			        $this->bdb->trans_rollback();
			        return 'error';
			}
			else
			{
			        $this->bdb->trans_commit();
			        return 'success';
			}
		}
	}

	function r_add_prod_cc($prod = NULL){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
        $id = $user['id'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		
		if($connected){	


			$sql2 = "Select * from TempRecount where Barcode = '$prod' ";
			//AND UserID = ".$id." 
			$this->bdb->trans_begin();

			$result = $this->bdb->query($sql2);
			$ctr = $result->num_rows();
			if($ctr >= 1)
			{
				return 'duplicate';
			}
			else
			{
				$sql = "Insert into TempRecount(ProductID,ProductCode,Barcode,Description,uom,recount,GlobalID,UserID)
					Select a.ProductID,a.ProductCode,a.Barcode,a.Description,a.uom,0,b.GlobalID,'$id' 
					from POS_Products a left join Products b on a.ProductID = b.ProductID
					where Barcode = '".$prod."'";
			
				$result = $this->bdb->query($sql);
			}

			//$this->bdb->trans_complete();	
			if($this->bdb->trans_status() === FALSE)
				{
				       $this->bdb->trans_rollback();
				        return 'error';
				}
				else
				{
				       $this->bdb->trans_commit();
				        return 'success';
				}
		}
	}

	//add product details for cycle count -Paul
	function add_prod_cc($prod = NULL){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
        $id = $user['id'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		
		if($connected){	


			$sql2 = "Select * from TempCycleCount where Barcode = '$prod' AND Branch = '$user_branch'";
			$this->bdb->trans_begin();

			$result = $this->bdb->query($sql2);
			$ctr = $result->num_rows();
			if($ctr >= 1)
			{
				return 'duplicate';
			}
			else
			{
				$sql = "Insert into TempCycleCount(ProductID,ProductCode,Barcode,Description,uom,Branch,GlobalID,UserID)
					Select a.ProductID,a.ProductCode,a.Barcode,a.Description,a.uom,'$user_branch',b.GlobalID,'$id' 
					from POS_Products a left join Products b on a.ProductID = b.ProductID
					where Barcode = '".$prod."'";
			
				$result = $this->bdb->query($sql);
			}

			//$this->bdb->trans_complete();	
			if($this->bdb->trans_status() === FALSE)
				{
				       $this->bdb->trans_rollback();
				        return 'error';
				}
				else
				{
				       $this->bdb->trans_commit();
				        return 'success';
				}
		}
	}


	function getcat(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
			//if($connected){
				//$this->bdb->trans_start();		
				$sql = "SELECT * FROM TempCC_Category WHERE Branch = '$user_branch'";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
				//$this->bdb->trans_complete();
				return $result;
			//}
	}
	
	
	function get_cat_list(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
			//if($connected){
			//	$this->bdb->trans_start();		
				$sql = "SELECT CategoryID,CategoryName FROM TempCC_Category WHERE Branch = '$user_branch'";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
			//}
	}

	function get_cat_details($id){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
			//if($connected){
			//	$this->bdb->trans_start();		
				$sql = "SELECT * FROM TempCC_Category_Details WHERE CategoryID = '$id'";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
		//	}
	}

	//get auto details for cycle count -Paul
	function get_auto_details($id){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
			//if($connected){
			//	$this->bdb->trans_start();		
				$sql = "select a.*,b.*,c.uom,c.qty,CAST(b.CostOfSales as float) cos from TempCC_Auto_Details a 
				left join Products b on a.ProductID=b.ProductID 
				left join POS_Products c on a.Barcode = c.Barcode
				left join TempCC_Auto_Info d on a.InfoID = d.InfoId
				where a.InfoID = '".$id."' ORDER BY b.Description ASC";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
		//	}
	}

	//get Current sales from MYsql 0.179
	function getCurrentSales($productId){
		$result = "";
		$this->bdb = $this->load->database('mynova',TRUE);
		$sql = "SELECT current_sales FROM for_website_products_current_sales WHERE ProductID = $productId";
		$query = $this->bdb->query($sql);
		$ctr = $query->num_rows();
		if($ctr > 0)
		{
			$result = $query->row()->current_sales;
		}

		return $result;
	}
	
	function checkauto($id){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
	//	$connected = $this->bdb->initialize();
		
			//if($connected){
				//$this->bdb->trans_start();		
				$sql = "Select SaveDate from TempCC_Auto_Info where InfoId = '$id'";
				$query = $this->bdb->query($sql);
				$row = $query->row();
				return $row->SaveDate;	
				//return $result;
		//	}
	}

	function certify($user,$pass)
	{
		$this->db = $this->load->database('default',TRUE);
	//		$connected = $this->db->initialize();
	//	if($connected){
		//	$this->db->trans_start();
			$pass2 = md5($pass);
			$sql = "Select a.*,b.role as user_role from users a left join user_roles b on a.role = b.id where (a.username = '".$user."'
			AND a.password = '".$pass2."') AND (a.role = '5' OR a.role = '1')";

			$query = $this->db->query($sql);
			$ctr = $query->num_rows();
			$result = $query->row();
			//$this->db->trans_complete();
			//$row = mysql_num_rows($query);
			if($ctr >= 1)
			 {
				return $result->id;	
			 	//return $row;			
			 }
			 else
			 {
				return 'error';
			// 	//return $row;			
			 }
			
	//	}
	}

	//variance report -Van
	function get_variance_report_details($id)
	{
		$user    = $this->session->userdata('user');
        	$user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$sql = "SELECT 
				a.TransNo,
				a.ActualCount,
				a.ProductID,
				a.Barcode,
				b.Description,
				c.uom,
				a.CostOfSale,
				a.FreezeInv,
				a.Damaged,
				a.Variance,
				e.CategoryName
			FROM TempCC_Auto_Details a 
			LEFT JOIN Products b 
				ON a.ProductID=b.ProductID 
			LEFT JOIN POS_Products c 
				ON a.Barcode = c.Barcode
			INNER JOIN TempCC_Auto_Info d
				ON a.InfoID = d.InfoId
			INNER JOIN TempCC_Category e
				ON d.CategoryID = e.CategoryID
			WHERE a.InfoID = '".$id."' 
			ORDER BY b.Description ASC";
				
		$query = $this->bdb->query($sql);
		$result = $query->result();
		return $result;
	}

	function get_auto_details2($id){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
			//if($connected){
			//	$this->bdb->trans_start();		
				$sql = "select a.ActualCount,a.ProductID,a.Barcode,b.Description,c.uom,b.CostOfSales,b.SellingArea from TempCC_Auto_Details a left join Products b on a.ProductID=b.ProductID left join POS_Products c on a.Barcode = c.Barcode where a.InfoID = '".$id."' ORDER BY b.Description ASC";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
		//	}
	}
	
	function r_get_auto_details2(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
			//if($connected){
			//	$this->bdb->trans_start();		
				$sql = "select a.ProductID,a.Barcode,b.Description,c.uom,b.CostOfSales,b.SellingArea from TempRecount a left join Products b on a.ProductID=b.ProductID left join POS_Products c on a.Barcode = c.Barcode ORDER BY b.Description ASC";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
		//	}
	}

	//get product details for cycle count -Paul
	function get_bar_details($prod = NULL,$vendor_code = NULL){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
			//if($connected){
			//	$this->bdb->trans_start();		
				//$sql = "select top 100 n.* from POS_Products n where n.Barcode LIKE '%".$prod."%' OR n.Description LIKE '%".$prod."%' ORDER BY n.Description ASC";
				//change query for supplier filter - Van
				$sql = "SELECT top 100 n.* 
					FROM POS_Products n 
					INNER JOIN VENDOR_Products vp
						ON n.ProductID = vp.ProductID
					WHERE (n.Barcode LIKE '%".$prod."%' OR n.Description LIKE '%".$prod."%')
						AND vp.VendorCode = '$vendor_code'
					ORDER BY n.Description ASC";
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
			//}
	}

	function r_get_bar_details($prod = NULL){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
			//if($connected){
			//	$this->bdb->trans_start();		
				$sql = "select top 100 n.* from POS_Products n where n.Barcode LIKE '%".$prod."%' OR n.Description LIKE '%".$prod."%' ORDER BY n.Description ASC";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
			//}
	}


	
	
	//get max autoid cc_auto_info -Paul
	function get_maxautoid_cc(){		
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		
			//if($connected){		
			//	$this->bdb->trans_start();		
				$sql = "SELECT MAX(AutoID) as autoid from TempCC_Auto_Info where Branch = '$user_branch'";
				$query = $this->bdb->query($sql);	
				$result = $query->row();
			//	$this->bdb->trans_complete();
				return $result->autoid;		
		//	}	
	}
	
		
	function get_info_cc(){		
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
		//	if($connected){		
		//		$this->bdb->trans_start();		
				$sql = "SELECT MAX(InfoId) as infoid from TempCC_Auto_Info";
				$query = $this->bdb->query($sql);				
				$result = $query->row();
		//		$this->bdb->trans_complete();
				return $result->infoid;
		//	}	
	}
	

	function r_get_cc(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		$user    = $this->session->userdata('user');
        $user_id = $user['id']; 
		//	if($connected){
		//		$this->bdb->trans_start();		
				$sql = "select a.*,b.*,a.UserID,c.barcode,c.uom,c.qty,CAST(b.CostOfSales as float) cos from TempRecount a 
				left join Products b on a.ProductID=b.ProductID 
				left join POS_Products c on a.Barcode = c.Barcode
				ORDER BY b.Description ASC";

				//where (a.UserID = ".$user_id." OR  a.UserID is null)
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
		//		$this->bdb->trans_complete();
				return $result;
		//	}
	}


	//get cc details -Paul
	function get_cc(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
		//	if($connected){
		//		$this->bdb->trans_start();		
				$sql = "Select n.* from TempCycleCount n where n.Branch = '$user_branch' ORDER BY n.Description ASC";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
		//		$this->bdb->trans_complete();
				return $result;
		//	}
	}

	function get_auto_info($id){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
	//	$connected = $this->bdb->initialize();
		
	//		if($connected){
	//			$this->bdb->trans_start();		
				$sql = "SELECT 
						n.*,
						b.CategoryName,
						b.Day,
						b.Schedule,
						c.ProductID,
						c.Barcode,
						c.ActualCount,
						c.Variance,
						c.TotalCostAdjustment
					FROM TempCC_Auto_Info n 
					LEFT JOIN TempCC_Category b 
						ON n.CategoryID = b.CategoryID
					INNER JOIN TempCC_Auto_Details c
						ON n.InfoId =  c.InfoID
					WHERE n.Branch = '$user_branch' 
					AND n.InfoId = '$id' ";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
	//			$this->bdb->trans_complete();
				return $result;
	//		}
	}



	function get_cat_info($id){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
		//	if($connected){
				//$this->bdb->trans_start();		
				$sql = "SELECT * from TempCC_Category where CategoryID = '$id'";
				
				$query = $this->bdb->query($sql);
				$result = $query->result();
		//		$this->bdb->trans_complete();
				return $result;
		//	}
	}

	//get cc info
	function get_auto_cc(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		
	//		if($connected){
		//		$this->bdb->trans_start();		
				$sql = "Select TOP 10 a.*,b.CategoryName from TempCC_Auto_Info a 
				left join TempCC_Category b on a.CategoryID = b.CategoryID
				where a.Branch = '$user_branch' AND cast(a.DateTrans as date) > '2020-11-01'
				ORDER BY (CASE WHEN SaveDate IS NULL THEN 1 ELSE 0 END) DESC, a.SaveDate DESC, a.DateTrans ASC";
				$query = $this->bdb->query($sql);
				$result = $query->result();
		//		$this->bdb->trans_complete();
				return $result;
		//	}
	}

	function filter_auto_cc($from,$to,$status){
		$user    = $this->session->userdata('user');
       	 	$user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$sql = "";
		switch($status)
		{
			case 0://all
				$sql = "Select a.*,b.CategoryName from TempCC_Auto_Info a 
					left join TempCC_Category b on a.CategoryID = b.CategoryID
					where a.Branch = '$user_branch' AND CAST(a.DateTrans AS DATE) >= CAST('$from' AS DATE) AND CAST(a.DateTrans AS DATE) <= CAST('$to' AS DATE)					ORDER BY (CASE WHEN SaveDate IS NULL THEN 1 ELSE 0 END) DESC, a.SaveDate DESC, a.DateTrans ASC";
			break;
			case 1://posted
				$sql = "Select a.*,b.CategoryName from TempCC_Auto_Info a 
					left join TempCC_Category b on a.CategoryID = b.CategoryID
					where a.Branch = '$user_branch' AND CAST(a.DateTrans AS DATE) >= CAST('$from' AS DATE) AND CAST(a.DateTrans AS DATE) <= CAST('$to' AS DATE)						AND (a.TransNoIGNSA IS NOT NULL OR a.TransNoIGSA IS NOT NULL)
					ORDER BY (CASE WHEN SaveDate IS NULL THEN 1 ELSE 0 END) DESC, a.SaveDate DESC, a.DateTrans ASC";
			break;
			case 2://for posting
				$sql = "Select a.*,b.CategoryName from TempCC_Auto_Info a 
					left join TempCC_Category b on a.CategoryID = b.CategoryID
					where a.Branch = '$user_branch' AND CAST(a.DateTrans AS DATE) >= CAST('$from' AS DATE) AND CAST(a.DateTrans AS DATE) <= CAST('$to' AS DATE)						AND (a.TransNoIGNSA IS NULL AND a.TransNoIGSA IS NULL)
					ORDER BY (CASE WHEN SaveDate IS NULL THEN 1 ELSE 0 END) DESC, a.SaveDate DESC, a.DateTrans ASC";
			break;
		}

		$query = $this->bdb->query($sql);
		$result = $query->result();
		return $result;
	}
	
	function get_trans_details($trans=NULL,$trans2=NULL,$aria_db=NULL)
	{
		$this->bdb = $this->load->database($aria_db,TRUE);
		//$connected = $this->bdb->intialiaze();

		// if($connected)
		// {
			$sql = "SELECT DISTINCT a.trans_id,a.*,b.a_created_by,b.a_movement_code,c.memo_ FROM `0_stock_moves` a 
				LEFT JOIN `0_adjustment_header` b ON a.trans_no = b.a_trans_no
				LEFT JOIN `0_comments` c ON a.trans_no = c.id 
				where a.type = '17' AND b.a_type = '17' AND c.type = '17' AND a.trans_no IN ('".$trans."','".$trans2."')";
			
			$query = $this->bdb->query($sql);
			$result = $query->result();
			return $result;
		//}
	}
	

		function r_add_adjustment_headerigsa($alldata=null,$remarks=null,$total=null,$trans_num=null,$data= array(),$aria_db){

		$this->bdb = $this->load->database($aria_db,TRUE);
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb2 = $this->load->database($user_branch,TRUE);
		date_default_timezone_set('Asia/Manila');
			$now = date('Y-m-d');
			$connected2 = $this->bdb2->initialize();
			$connected = $this->bdb->initialize();
			if($connected){
					$user_id = $data['user_id'];
					$trans_num = $data['trans_num'];
					$date_adjustment = $data['date_adjustment'];
				
				$with_error = array();
				$result = '';
				$sql_row="SELECT a_trans_no from 0_adjustment_header where a_trans_no='".$trans_num."'";
				$query = $this->bdb->query($sql_row);
				$res_row = $query->row();
				if ($res_row != null){						
					return 'error';	
				}else{
					$sql1="INSERT INTO 0_adjustment_header (a_id,a_trans_no,a_movement_code,a_movement_no,a_type,a_date_created,a_ref,a_from_location,a_to_location,a_created_by,a_posted_by,a_status) values('".$trans_num."','".$trans_num."','IGSA','',17,'".$date_adjustment."','".$trans_num."','SELLING AREA','SELLING AREA','".$user_id."','',1)";
					$this->bdb->trans_begin();
					$result = $this->bdb->query($sql1);
					if($result){
						 foreach ($alldata as $value) {
						 	$stockmoves_ = array(
									'trans_no'=>$trans_num,
									'stock_id'=>$value[5],
									'type'=> '17',
									'loc_code'=>'2',
									'tran_date'=>$date_adjustment,
									'person_id'=> $user_id,
									'price'=>$value[1],
									'price_pcs'=>$value[1],
									'reference'=>$trans_num,
									'qty'=>$value[0],
									'qty_pcs'=>$value[0] * $value[2],
									'multiplier'=>$value[2],
									'i_uom'=>$value[3],
									'standard_cost'=>$value[1],
									'barcode'=>''
							);

						 	$comments_ = array(
						 		'type'=> 17,
								'id'=>$trans_num,
								'date_'=>$date_adjustment,
								'memo_'=>$remarks
						 	);

							$results_ = $this->add_stock_move_($comments_,$stockmoves_,$this->bdb);
							
							if($results_ == 'error'){
								array_push($with_error,$results_);
							} 
				        }
					        if(empty($with_error)){
								 $this->bdb->trans_commit();
								if($connected2)
								{
									$sqlrc="INSERT INTO TempRecount_Details VALUES ('$trans_num','$user_branch','IGSA','$now')";
									$res = $this->bdb2->query($sqlrc);
									if($res)
									{
									   //  $this->bdb2->trans_rollback();
									   	return 'success';
									}
									else
									{
									   // $this->bdb2->trans_commit();
									  	return 'error';
									}
								}
					        }
					        else
					        {
								$this->bdb->trans_rollback();
								return 'error-';
					        }			        
					}else
					{
						$this->bdb->trans_rollback();
						return 'error';
					}	
				}
			}		
			else
			{
				// $this->bdb2->trans_commit();
			  	return 'error';
			}
	}


	function r_add_adjustment_headerignsa($alldata2=null,$remarks=null,$total=null,$trans_num=null,$data= array(),$aria_db){

		$this->bdb = $this->load->database($aria_db,TRUE);
		$user = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb2 = $this->load->database($user_branch,TRUE);
		date_default_timezone_set('Asia/Manila');
			$now = date('Y-m-d H:i:s');
			$connected2 = $this->bdb2->initialize();
			$connected = $this->bdb->initialize();
			if($connected){
					$user_id = $data['user_id'];
					$trans_num = $data['trans_num']+1;
					$date_adjustment = $data['date_adjustment'];
				
				$with_error = array();
				$result = '';
				$sql_row="SELECT a_trans_no from 0_adjustment_header where a_trans_no='".$trans_num."'";
				$query = $this->bdb->query($sql_row);
				$res_row = $query->row();
				if ($res_row != null){						
					return 'error';	
				}else{
					$sql1="INSERT INTO 0_adjustment_header (a_id,a_trans_no,a_movement_code,a_movement_no,a_type,a_date_created,a_ref,a_from_location,a_to_location,a_created_by,a_posted_by,a_status) values('".$trans_num."','".$trans_num."','IGNSA','',17,'".$date_adjustment."','".$trans_num."','SELLING AREA','SELLING AREA','".$user_id."','',1)";
					$this->bdb->trans_begin();
					$result = $this->bdb->query($sql1);
					if($result){
						 foreach ($alldata2 as $value) {
						 	$stockmoves_ = array(
									'trans_no'=>$trans_num,
									'stock_id'=>$value[5],
									'type'=> '17',
									'loc_code'=>'2',
									'tran_date'=>$date_adjustment,
									'person_id'=> $user_id,
									'price'=>$value[1],
									'price_pcs'=>$value[1],
									'reference'=>$trans_num,
									'qty'=>$value[0],
									'qty_pcs'=>$value[0] * $value[2],
									'multiplier'=>$value[2],
									'i_uom'=>$value[3],
									'standard_cost'=>$value[1],
									'barcode'=>''
							);

						 	$comments_ = array(
						 		'type'=> 17,
								'id'=>$trans_num,
								'date_'=>$date_adjustment,
								'memo_'=>$remarks
						 	);

							$results_ = $this->add_stock_move_($comments_,$stockmoves_,$this->bdb);
							
							if($results_ == 'error'){
								array_push($with_error,$results_);
							} 
				        }
					        if(empty($with_error))
					        {
								 $this->bdb->trans_commit();
									if($connected2)
									{
									//$this->bdb2->trans_begin();
										$sqlrc="INSERT INTO TempRecount_Details VALUES ('$trans_num','$user_branch','IGNSA','$now')";
										$res = $this->bdb2->query($sqlrc);
										if($res)
									 	{
								      	//  $this->bdb2->trans_rollback();
								      		return 'success';
										}
										else
										{
								       	// $this->bdb2->trans_commit();
								      		return 'error';
										}
									}
									else
									{
										return 'error';
									}
					        }
					        else
					        {
								$this->bdb->trans_rollback();
								return 'error-';
					        }

					}
					else{
						$this->bdb->trans_rollback();
						return 'error';
					}	
				}
			}
			else
			{
				return 'error';
			}
		
	}



	function add_adjustment_headerigsa($alldata=null,$remarks='',$total=null,$trans_num=null,$data= array(),$aria_db,$infoid=NULL){


		$this->bdb = $this->load->database($aria_db,TRUE);
		$user = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb2 = $this->load->database($user_branch,TRUE);
		date_default_timezone_set('Asia/Manila');
			$now = date('Y-m-d H:i:s');
			//$connected2 = $this->bdb2->initialize();
			$connected = $this->bdb->initialize();
			if($connected){
					$user_id = $data['user_id'];
					//$trans_num = $data['trans_num']+1;
					$date_adjustment = $data['date_adjustment'];
				
				$with_error = array();
				$result = '';
				$sql_row="SELECT a_trans_no from 0_adjustment_header where a_trans_no='".$trans_num."'";
				$query = $this->bdb->query($sql_row);
				$res_row = $query->row();
				if ($res_row != null){						
					return 'duplicate';	
				}else{

					$sql1="INSERT INTO 0_adjustment_header (a_id,a_trans_no,a_movement_code,a_movement_no,a_type,a_date_created,a_ref,a_from_location,a_to_location,a_created_by,a_posted_by,a_status) values('".$trans_num."','".$trans_num."','IGSA','',17,'".$date_adjustment."','".$trans_num."','SELLING AREA','SELLING AREA','".$user_id."','',1)";
					$this->bdb->trans_begin();
					$result = $this->bdb->query($sql1);

					if($result){

						 foreach ($alldata as $value) {

						 	$price = ($value[3] / $value[0]);
						 	$price_pcs = ($value[3] / ($value[0] * $value[1]));
						 	$multiplier = $value[1];
						 	$qty =  $value[0]; 
						 	$qty_pcs = $value[1] * $value[0]; 

						 	$stockmoves_ = array(

									'trans_no'=>$trans_num,
									'stock_id'=>$value[4],
									'type'=> '17',
									'loc_code'=>'2',
									'tran_date'=>$date_adjustment,
									'person_id'=> $user_id,
									'price'=>$price,
									'price_pcs'=>$price_pcs,
									'reference'=>$trans_num,
									'qty'=>$qty,
									'qty_pcs'=>$qty_pcs,
									'multiplier'=>$multiplier,
									'i_uom'=>$value[2],
									'standard_cost'=>$price_pcs,
									'barcode'=>$value[6]
							);

							 $results_ = $this->add_stock_movs($stockmoves_,$this->bdb);
							
							if($results_ == 'error'){

								array_push($with_error,$results_);
							} 
							$this->saveActualCount($value[7],$this->bdb2,$infoid,$value[4],$value[8],$value[9],$value[0],$value[10],$trans_num,$value[3]);
				        	}

				        	$comments_ = array(
						 		'type'=> 17,
								'id'=>$trans_num,
								'date_'=>$date_adjustment,
								'memo_'=>$remarks
						 	);

							$results_ = $this->add_comments($comments_,$this->bdb);

					        if(empty($with_error)){
					   			
								 $this->bdb->trans_commit();			
								 	$sql="Update TempCC_Auto_Info SET TransNoIGSA = '$trans_num', SaveDate = '$now' where InfoId = '$infoid'";
									$this->bdb2->query($sql);
			  	  
								 return 'success';
					        }
					        else
					        {
								$this->bdb->trans_rollback();
								return 'error';
					        }

					}
					else
					{
						$this->bdb->trans_rollback();
						//return 'error';
					}	
				}
			}
		
	}

function saveActualCount($actual_count,$bdb2,$info_id,$product_id,$freeze_inv,$costofsale,$variance,$damaged,$trans_num,$total_cost){
	$sql = "UPDATE TempCC_Auto_Details 
		SET ActualCount = $actual_count,
			FreezeInv = $freeze_inv,
			CostOfSale = $costofsale,
			Variance = $variance,
			Damaged = $damaged,
			TransNo = $trans_num,
			TotalCostAdjustment = $total_cost
		WHERE InfoID = $info_id
			AND ProductID = $product_id";
	$bdb2->query($sql);
}	


function add_adjustment_headerignsa($alldata2=null,$remarks='',$total=null,$trans_num=null,$data= array(),$aria_db,$infoid=NULL){

		$this->bdb = $this->load->database($aria_db,TRUE);
		$user = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb2 = $this->load->database($user_branch,TRUE);
		date_default_timezone_set('Asia/Manila');
			$now = date('Y-m-d H:i:s');
			//$connected2 = $this->bdb2->initialize();
			$connected = $this->bdb->initialize();
			if($connected){
					$user_id = $data['user_id'];
					//$trans_num = $data['trans_num']+1;
					$date_adjustment = $data['date_adjustment'];
				
				$with_error = array();
				$result = '';
				$sql_row="SELECT a_trans_no from 0_adjustment_header where a_trans_no='".$trans_num."'";
				$query = $this->bdb->query($sql_row);
				$res_row = $query->row();
				if ($res_row != null){						
					return 'duplicate';	
				}else{
					$sql1="INSERT INTO 0_adjustment_header (a_id,a_trans_no,a_movement_code,a_movement_no,a_type,a_date_created,a_ref,a_from_location,a_to_location,a_created_by,a_posted_by,a_status) values('".$trans_num."','".$trans_num."','IGNSA','',17,'".$date_adjustment."','".$trans_num."','SELLING AREA','SELLING AREA','".$user_id."','',1)";
					$this->bdb->trans_begin();
					$result = $this->bdb->query($sql1);
					if($result){

						 foreach ($alldata2 as $value) {
						 	$absolute_variance = abs($value[0]);

							$price = ($value[3] / $absolute_variance);
						 	$price_pcs = ($value[3] / ($absolute_variance * $value[1]));
						 	$multiplier = $value[1];
						 	$qty =  $absolute_variance; 
						 	$qty_pcs = $value[1] * $absolute_variance; 

						 	$stockmoves_ = array(
									'trans_no'=>$trans_num,
									'stock_id'=>$value[4],
									'type'=> '17',
									'loc_code'=>'2',
									'tran_date'=>$date_adjustment,
									'person_id'=> $user_id,
									'price'=>$price,
									'price_pcs'=>$price_pcs,
									'reference'=>$trans_num,
									'qty'=>$qty,
									'qty_pcs'=>$qty_pcs,
									'multiplier'=>$multiplier,
									'i_uom'=>$value[2],
									'standard_cost'=>$price_pcs,
									'barcode'=>$value[6]
							);

						 	

							$results_ = $this->add_stock_movs($stockmoves_,$this->bdb);
							
							if($results_ == 'error'){
								array_push($with_error,$results_);
							} 
							$this->saveActualCount($value[7],$this->bdb2,$infoid,$value[4],$value[8],$value[9],$value[0],$value[10],$trans_num,$value[3]);
				        }

				        	$comments_ = array(
						 		'type'=> 17,
								'id'=>$trans_num,
								'date_'=>$date_adjustment,
								'memo_'=>$remarks
						 	);

							$results_ = $this->add_comments($comments_,$this->bdb);


					        if(empty($with_error)){
					   
								 $this->bdb->trans_commit();	
								 	$sql="Update TempCC_Auto_Info SET TransNoIGNSA = '$trans_num', SaveDate = '$now' where InfoId = '$infoid'";
									$this->bdb2->query($sql);
			  
								 return 'success';
					        }
					        else
					        {
								$this->bdb->trans_rollback();
								return 'error->>';
					        }

					}else{
						$this->bdb->trans_rollback();
						//return 'error';
					}	
				}
			}
		
	}


	

	function item_adjustment_modal($id = null,$next_trans){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
		//	if($connected){
			//	$this->bdb->trans_start();
					$sql = "select top 100 n.*,v.description as vendor,c.description as category from Products n 
					inner join vendor v on v.vendorcode = n.vendorcode left join LevelField1 c on c.LevelField1Code = n.LevelField1Code 
					where  n.SellingArea < 0 and n.ProductID = '".$id."' and  n.inactive = 0 order by n.SellingArea ASC";

				$query = $this->bdb->query($sql);
				$result = $query->result();
		//	$this->bdb->trans_complete();
			return $result;
		//	}
	}

	function get_next_trans($aria_db=null){
		$this->bdb = $this->load->database($aria_db,TRUE);
	//	$connected = $this->bdb->initialize();
	//	$this->bdb->trans_start();
		//	if($connected){
		//		$this->bdb->trans_start();

					$sql = "SELECT MAX(a_id) as total_trans from 0_adjustment_header";

				$query = $this->bdb->query($sql);
				$result = $query->row();
		//	$this->bdb->trans_complete();
				if ($result != null)
						return $result->total_trans;
					else
						return false;
		//	}
	}

function get_trans_no_count($aria_db=null)
	{
		$this->db = $this->load->database($aria_db,TRUE);
		//$connected = $this->bdb->initialize();

		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);

			$sql = "SELECT DISTINCT trans_no FROM TempCC_NegativeInventory order by trans_no DESC";
		//$sql = "SELECT tran_date,count(trans_id) as total FROM 0_stock_moves WHERE trans_no = '5777'";//
		$query = $this->bdb->query($sql);
			$result = $query->result();
				//$this->bdb->trans_complete();
				//if ($result != null)
				
						return $result;
				//	else
						//return false;
	}

function get_count_neg($aria_db=null,$trans2=null){
		
		$this->db = $this->load->database($aria_db,TRUE);
		
		$connected = $this->bdb->initialize();

		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		
		if($trans2 == null)
		{
			$sql = "SELECT tran_date,IFNULL(count(trans_id),'0') as total 
				FROM 0_stock_moves where trans_id IN ('') group by tran_date order by tran_date DESC";
		}
		else
		{
		$sql = "SELECT tran_date,count(trans_id) as total FROM 0_stock_moves WHERE trans_no IN ($trans2) group by tran_date order by tran_date DESC LIMIT 7";
		}
				$query = $this->db->query($sql);
				$result = $query->result();
				//$this->bdb->trans_complete();
				if ($result != null)
						return $result;
					else
						return false;
			//}
	}
	function get_count_cyc($aria_db=null){
		
		$this->bdb = $this->load->database($aria_db,TRUE);
		$connected = $this->bdb->initialize();
		date_default_timezone_set('Asia/Manila');
		$now = date('Y-m-d');
	//	$this->bdb->trans_start();
		//	if($connected){
		//		$this->bdb->trans_start();

					$sql = "Select Count(InfoId) as ctr from TempCC_Auto_Info where SaveDate IS NULL";

				$query = $this->bdb->query($sql);
				$result = $query->row();
		//		$this->bdb->trans_complete();
				if ($result != null)
						return $result->ctr;
					else
						return false;
		//	}
	}

	// LAWRENZE
	function get_pricematch_report(){
		$db = $this->load->database('newdatacenter',TRUE);
		$sql = "SELECT COUNT(lineid) as 'TotalItems', dateposted_branch FROM pricechangehistory_branch GROUP BY (dateposted_branch) ORDER BY dateposted_branch DESC LIMIT 2";
		$query = $db->query($sql);
		$result = $query->result();
		if ($result != null)
			return $result;
		else
			return false;
	}

	function get_pricematch_report_excel($dateFrom, $dateTo, $branch){
		$db = $this->load->database('newdatacenter',TRUE);
		$sql = "SELECT * FROM pricechangehistory_branch WHERE dateposted_branch BETWEEN '".$dateFrom."' AND '".$dateTo."' AND branch ='".$branch."' AND throw = 1";
		$query = $db->query($sql);
		$result = $query->result();
		if ($result != null)
			return $result;
		else
			return false;
	}
	// ./LAWRENZE

	function get_tomorrow($tom,$week)
	{
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
	//	$connected = $this->bdb->initialize();
	//		if($connected){
	//			$this->bdb->trans_start();
				//$sql = "SELECT top 100 * from possible_no_display order by past30days desc";
				$sql="Select Top 50 * from TempCC_Category where Day LIKE '%$tom%' AND (Schedule LIKE '%$week%' or Schedule = 'Weekly')";
				$query = $this->bdb->query($sql);
				$result = $query->result();
	//			$this->bdb->trans_complete();
				if($result){
					return $result;
				}else{
					return false;
				}
		//	}
	}

	function get_count_nodisp($user_branch=null){
		
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		date_default_timezone_set('Asia/Manila');
		$now = date('Y-m-d');
		//$this->bdb->trans_start();
		//	if($connected){
		//		$this->bdb->trans_start();

// 					$sql = "select TOP 5 Count(id) as 'counter',date_ 
// from possible_no_display 
// where status = '1'
// group by date_ order by date_ DESC";

		$sql = "

SELECT TOP 7 
        date_,
        (
            COUNT(
                NULLIF( id, 0 )
            )
        ) AS counter
       FROM
        possible_no_display where status = '1'
    GROUP BY
        date_ ORDER BY date_ DESC";

				$query = $this->bdb->query($sql);
				$result = $query->result();
				//$this->bdb->trans_complete();
				if ($result != null)
						return $result;
					else
						return false;
		//	}
	}

	

	function getCounter(){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		//	if($connected){
					$sql = "SELECT Counter FROM Counters WHERE TransactionTypeCode = 'IGSA'";

				$query = $this->bdb->query($sql);
				$result = $query->row();
		//	$this->bdb->trans_complete();
				if ($result != null)
						return $result->total_trans;
					else
						return false;
			//}
	}



/*	function add_stock_move($data= array(),$aria_db){

		$this->bdb = $this->load->database($aria_db,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
					$user_id = $data['user_id'];
					$trans_num = $data['trans_num'];
					$date_adjustment = $data['date_adjustment'];
					$product_id = $data['product_id'];
					$ad_qty_ = $data['ad_qty_'];
					$uom_qty = $data['uom_qty'];
					$unit = $data['unit'];
					$unit_cost = $data['unit_cost'];
					$cost = $data['cost'];
					$total = $data['total'];
					$remarks = $data['remarks'];
					
					if ($cost == '') {
						$cost = 0;
					}else{
						$cost = $data['cost'];
					}
				
			$this->bdb->trans_start(TRUE);
				$result = '';
				$sql= "INSERT INTO 0_stock_moves (trans_no,stock_id,type,loc_code,tran_date,person_id,price,price_pcs,reference,qty,qty_pcs,multiplier,i_uom,standard_cost,barcode) values ('".$trans_num."','".$product_id."',17,2,'".$date_adjustment."','".$user_id."','".$cost."','".$cost."','".$trans_num."','".$ad_qty_."','".$ad_qty_*$uom_qty."','".$uom_qty."','".$unit."','".$cost."','')";

				$sql1= "INSERT INTO 0_comments (type,id,date_,memo_) values (17,'".$trans_num."','".$date_adjustment."','".$remarks."')";

				$result['stockmoves'] = $this->bdb->query($sql);
				$result['comments'] = $this->bdb->query($sql1);

			$this->bdb->trans_complete();

				if ($result) {
					return $result;
				}else{
					$this->db->_error_message();
				}

			}
	}*/
	function add_stock_movs($stock_moves,$aria_db){
		$res_ = $aria_db->insert('0_stock_moves',$stock_moves);
			 if($res_){
			 	return 'success';
			 }else{
			 	return 'error';
			 }

	}	

	function add_comments($comments,$aria_db){
		$res_ = $aria_db->insert('0_comments',$comments);
			 if($res_){
			 	return 'success';
			 }else{
			 	return 'error';
			 }


	}	

	function add_stock_move_($comments,$stock_moves,$aria_db){		
			$res_ = $aria_db->insert('0_stock_moves',$stock_moves);
			$res_1 = $aria_db->insert('0_comments',$comments);
			 if($res_ == 1 && $res_1 == 1){
			 	return 'success';
			 }else{
			 	return 'error';
			 }

	}
	
	

	function add_adjustment_header($alldata=null,$remarks=null,$total=null,$trans_num=null,$data= array(),$aria_db){

		$this->bdb = $this->load->database($aria_db,TRUE);
		$user    = $this->session->userdata('user');
		$user_id = $user['id']; 
        $user_branch = $user['branch'];
		$this->bdb2 = $this->load->database($user_branch,TRUE);
		date_default_timezone_set('Asia/Manila');
			$now = date('Y-m-d');
			$connected2 = $this->bdb2->initialize();
			$connected = $this->bdb->initialize();
			if($connected){
					$user_id = $data['user_id'];
					$trans_num = $data['trans_num'];
					$date_adjustment = $data['date_adjustment'];
				
				$with_error = array();
				$result = '';
				$sql_row="SELECT a_trans_no from 0_adjustment_header where a_trans_no='".$trans_num."'";
				$query = $this->bdb->query($sql_row);
				$res_row = $query->row();
				if ($res_row != null){						
					return 'error';	
				}else{
					$sql1="INSERT INTO 0_adjustment_header (a_id,a_trans_no,a_movement_code,a_movement_no,a_type,a_date_created,a_ref,a_from_location,a_to_location,a_created_by,a_posted_by,a_status) values('".$trans_num."','".$trans_num."','IGSA','',17,'".$date_adjustment."','".$trans_num."','SELLING AREA','SELLING AREA','".$user_id."','',1)";
					$this->bdb->trans_begin();
					$result = $this->bdb->query($sql1);
					if($result){
						 foreach ($alldata as $value) {
						 	$stockmoves_ = array(
									'trans_no'=>$trans_num,
									'stock_id'=>$value[5],
									'type'=> '17',
									'loc_code'=>'2',
									'tran_date'=>$date_adjustment,
									'person_id'=> $user_id,
									'price'=>$value[1],
									'price_pcs'=>$value[1],
									'reference'=>$trans_num,
									'qty'=>$value[0],
									'qty_pcs'=>$value[0] * $value[2],
									'multiplier'=>$value[2],
									'i_uom'=>$value[3],
									'standard_cost'=>$value[1],
									'barcode'=>''
							);

						 	$comments_ = array(
						 		'type'=> 17,
								'id'=>$trans_num,
								'date_'=>$date_adjustment,
								'memo_'=>$remarks
						 	);

							$results_ = $this->add_stock_move_($comments_,$stockmoves_,$this->bdb);
							
							if($results_ == 'error'){
								array_push($with_error,$results_);
							} 
				        }
					        if(empty($with_error)){
					        		
					        	$sqlcc="Insert into TempCC_NegativeInventory (userid,branch,trans_no,trans_date) values ('$user_id','$user_branch','$trans_num','$now')";
							 	$res = $this->bdb2->query($sqlcc);
								 $this->bdb->trans_commit();
								return 'success';
					        }else{
								$this->bdb->trans_rollback();
								return 'error-';
					        }

					}else{
						$this->bdb->trans_rollback();
						return 'error';
					}	
				}
			}

									// $sqlcc="Insert into TempCC_NegativeInventory (userid,branch,trans_no,trans_date) values ('$user_id','$user_branch','$trans_num','$now')";
							 	// 	$res = $this->bdb2->query($sqlcc);
							 		
								 // 	//$this->bdb2->trans_complete();
								 // 	if ($res)
									// {
								 //       // $this->bdb2->trans_rollback();
								 //      	return 'success';
									// }
									// else
									// {
								 //        //$this->bdb2->trans_commit();
								 //      	return 'error';
									// }
	}



	

	function uom_details($uom = null){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
			//if($connected){
			//	$this->bdb->trans_start();
				$sql = "SELECT * FROM UOM where UOM ='".$uom."' ";
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
		//	}
	}


	function get_adjustment_inquiry($aria_db = null ){
		$this->bdb = $this->load->database($aria_db,TRUE);
	//	$connected = $this->bdb->initialize();
		//	if($connected){
		//		$this->bdb->trans_start();
				$sql = "SELECT t2.trans_id,t1.*,sum(t2.standard_cost * t2.qty * t2.multiplier) as total FROM 0_adjustment_header t1 inner join 0_stock_moves t2 on t1.a_trans_no = t2.trans_no where a_movement_code = 'IGSA' and a_movement_no = '' group by t1.a_trans_no limit 100";
				$query = $this->bdb->query($sql);
				$result = $query->result();
		//		$this->bdb->trans_complete();
				return $result;
		//	}
	}


	function get_no_display($branch=null){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		date_default_timezone_set('Asia/Manila');
		$now = date('Y-m-d');
		//$connected = $this->bdb->initialize();
		//	if($connected){
			//	$this->bdb->trans_start();
				$yes = date('Y-m-d',strtotime("-1 days"));
				$sql = "SELECT top 100 * from possible_no_display where date_ = '$yes' order by past30days desc";
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				if($result){
					return $result;
				}else{
					return false;
				}
		//	}
	}

	// LAWRENZE
	
	// ./LAWRENZE
	function get_no_display_search($branch=null,$date=null,$category=null){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		//	if($connected){
		//		$this->bdb->trans_start();
				if($category)
				{
					$sql="SELECT top 100 a.*,b.LevelField1Code,c.Description as category from possible_no_display a
					LEFT JOIN Products b on a.productid=b.ProductID
					LEFT JOIN LevelField1 c on b.LevelField1Code = c.LevelField1Code
					where date_ ='$date' AND c.Description = '$category' order by past30days desc";
				}
				else
				{
					$sql = "SELECT top 100 * from possible_no_display where date_ ='".$date."' order by past30days desc ";
				}
				//$sql = "SELECT top 100 * from possible_no_display where date_ ='".$date."' order by past30days desc ";
				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				if($result){
					return $result;
				}else{
					return false;
				}
			//}
	}



	function delete_adjustment($a_id = null, $aria_db = null){
		$this->bdb = $this->load->database($aria_db,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_begin();
				$this->bdb->where('a_trans_no',$a_id);
				$this->bdb->delete('0_adjustment_header');
				//$this->bdb->trans_complete();

				 if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		       		// return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		          //  return TRUE;
		         }
			}
	}

	function delete_stock_moves($a_id = null, $aria_db = null){
		$this->bdb = $this->load->database($aria_db,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_begin();
				$this->bdb->where('trans_no',$a_id);
				$this->bdb->delete('0_stock_moves');
				//$this->bdb->trans_complete();

				 if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		       		// return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		          //  return TRUE;
		         }
			}
	}
		
		function get_branch_name($branch = null){
		$this->bdb = $this->load->database('default',TRUE);
	//	$connected = $this->bdb->initialize();
			//if($connected){
			//	$this->bdb->trans_start();
				$sql = "SELECT description from 0_branch where branch_code = '".$branch."'";
				$query = $this->bdb->query($sql);
				$result = $query->row();
			//	$this->bdb->trans_complete();
				if ($result != null)
						return $result->description;
					else
						return false;
			//}

	}

	function get_adjustment_history($asset_id = null,$aria_db = null){
		$this->bdb = $this->load->database($aria_db,TRUE);
		//$connected = $this->bdb->initialize();
		//	if($connected){

		//		$this->bdb->trans_start();
				$sql = "SELECT t1.a_date_created,t1.a_trans_no,t1.a_from_location,t1.a_to_location,t1.a_created_by,t1.a_posted_by,t2.stock_id,t2.price,t2.price_pcs,t2.qty,t2.qty_pcs,t2.multiplier,t2.i_uom,
					t2.standard_cost,t2.barcode,t3.memo_ from 0_adjustment_header t1
					INNER JOIN 0_stock_moves t2
					on t1.a_trans_no = t2.trans_no
					INNER JOIN 0_comments t3
					ON t3.id = t1.a_trans_no
					WHERE t1.a_trans_no='".$asset_id."' and t1.a_type=17 and t1.a_status=1 limit 0,50";

				$query = $this->bdb->query($sql);
				$result = $query->result();
			//	$this->bdb->trans_complete();
				return $result;
		//	}
	}
	
	function r_delete_cc($id)
	{
		$user = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
			if($connected){
				$this->bdb->trans_begin();
				$sql = "Delete from TempRecount where Barcode = '".$id."' ";
				$qry = $this->bdb->query($sql);
				//$this->bdb->trans_complete();

				if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		       		// return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		          //  return TRUE;
		        }
				
			}
	}

	function r_update_cc($id)
	{
		$user = $this->session->userdata('user');
		$user_id = $user['id']; 
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
			if($connected){
				$this->bdb->trans_begin();
				$sql = "Update TempRecount  set UserID ='".$user_id."' where Barcode = '".$id."' ";
				$qry = $this->bdb->query($sql);
				//$this->bdb->trans_complete();

				if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		       		// return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		          //  return TRUE;
		        }
				
			}
	}

	function delete_recount()
	{
		$user = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
			if($connected){
				$this->bdb->trans_begin();
				$sql = "Delete from TempRecount";
				$qry = $this->bdb->query($sql);
				//$this->bdb->trans_complete();

				if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		       		// return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		          //  return TRUE;
		        }
				
			}
	}


	function delete_cc($id)
	{
		$user = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
			if($connected){
				$this->bdb->trans_begin();
				$sql = "Delete from TempCycleCount where Barcode = '".$id."' ";
				$qry = $this->bdb->query($sql);
				//$this->bdb->trans_complete();

				if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		       		// return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		          //  return TRUE;
		        }
				
			}
	}
	//delete all branch tempcyclecount -Van
	function delete_all_cc()
	{
		$user = $this->session->userdata('user');
        	$user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
			if($connected){
				$this->bdb->trans_begin();
				$sql = "Delete from TempCycleCount where Branch = '".$user_branch."' ";
				$qry = $this->bdb->query($sql);
				//$this->bdb->trans_complete();

				if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		       		// return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		          //  return TRUE;
		        }
				
			}
	}


		function delete_cat($id)
	{
		$user = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
			if($connected){
				$this->bdb->trans_begin();
				$sql = "Delete from TempCC_Category where CategoryID = '".$id."' ";
				$qry = $this->bdb->query($sql);

				$sql2 = "Delete from TempCC_Category_Details where CategoryID = '".$id."'";
				$qry2 = $this->bdb->query($sql2);

				//$this->bdb->trans_complete();
				 if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		       		// return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		          //  return TRUE;
		        }
			}
	}

	function delete_catprod($cat = NULL,$bar = NULL)
	{
		$user = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
		date_default_timezone_set('Asia/Manila');
		$now = date('Y-m-d H:i:s');
		//$this->bdb->trans_start();
			if($connected){
				$this->bdb->trans_begin();

				$sql2 = "Delete from TempCC_Category_Details where CategoryID = '".$cat."' AND Barcode = '".$bar."'";
				$qry2 = $this->bdb->query($sql2);

				$sql3 = "Update TempCC_Category SET DateLastModified = '".$now."' where CategoryID = '".$cat."'";
				$this->bdb->query($sql3);

			//	$this->bdb->trans_complete();
				 if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		       		// return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		          //  return TRUE;
		        }

				
			}
	}
	
	function product_desc($stock_id){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
		//	if($connected){

				$sql = "SELECT Description from Products where ProductID = '".$stock_id."' ";
			
				$qry = $this->bdb->query($sql);
				$result = $qry->row();
			//	$this->bdb->trans_complete();
				if ($result != null)
					return $result->Description;
				else
					return false;
		//	}
	}

function get_cost($stock_id){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		//$connected = $this->bdb->initialize();
		//$this->bdb->trans_start();
		//	if($connected){

				$sql = "SELECT CostOfSales from Products where ProductID = '".$stock_id."' ";
			
				$qry = $this->bdb->query($sql);
				$result = $qry->row();
			//	$this->bdb->trans_complete();
				if ($result != null)
					return $result->CostOfSales;
				else
					return false;
		//	}
	}

	function get_ad_top_details($asset_id = null,$aria_db = null){
		$this->bdb = $this->load->database($aria_db,TRUE);
		//$connected = $this->bdb->initialize();
		//	if($connected){

		//		$this->bdb->trans_start();
				$sql = "SELECT * from 0_adjustment_header WHERE a_trans_no='".$asset_id."' and a_type=17 and a_status=1 group by a_trans_no";

				$query = $this->bdb->query($sql);
				$result = $query->result();
		//		$this->bdb->trans_complete();
				return $result;
		//	}
	}

	function get_smart_display(){
		$this->bdb = $this->load->database('smart',TRUE);
	//	$connected = $this->bdb->initialize();
			//if($connected){

		//		$this->bdb->trans_start();
				$sql = "SELECT top 50 * from eloadingRequest ORDER BY date_added DESC";

				$query = $this->bdb->query($sql);
				$result = $query->result();
		//		$this->bdb->trans_complete();
				return $result;
			//}
	}

	function get_smart_display_search($branch=null,$or_num=null,$targetSubsAccount=null,$postype =null){

		$ms ='';
		$my ='';
		if($postype == 'no'){
			$databases = 'smart';
			$ms = 'top 100';

		}else{
			$databases = 'smartmy';
			$my = 'limit 100';
		}
		$this->bdb = $this->load->database($databases,TRUE);
		//$connected = $this->bdb->initialize();
		//	if($connected){
			//	$this->bdb->trans_start();
				$sql = "SELECT $ms  * from eloadingRequest ";


				if($branch && $or_num){
					$sql .= "WHERE terminalID = '".$branch."' AND ORNo = '".$or_num."' ORDER BY trans_date DESC $my ";
				}else if($targetSubsAccount && $or_num){
					$sql .= "WHERE targetSubsAccount like '%".$targetSubsAccount."%' AND ORNo = '".$or_num."' ORDER BY trans_date DESC $my ";
				}else if($targetSubsAccount && $branch){
					$sql .= "WHERE targetSubsAccount like '%".$targetSubsAccount."%' AND terminalID = '".$branch."' ORDER BY trans_date DESC $my ";

				}else if($branch){
					$sql .= "WHERE terminalID ='".$branch."' ORDER BY trans_date DESC $my";
				}else if($or_num){
					$sql .= "WHERE ORNo ='".$or_num."' ORDER BY trans_date DESC $my";
				}else if($targetSubsAccount){
					$sql .= "WHERE targetSubsAccount like '%".$targetSubsAccount."%' ORDER BY trans_date DESC $my";
				}else{
					$sql .= "ORDER BY trans_date DESC $my";
				}

				$query = $this->bdb->query($sql);
				$result = $query->result();
				return $result;
	}


	//--------------------- DAN ------------------------//
	function view_data_display($id,$user_branch){
		$this->ddb = $this->load->database($user_branch,TRUE);
		$sql = "SELECT ph.barcode,
		PriceModecode,
		dateposted,
		PostedBy,
		fromsrp,
		tosrp,
		UOM,
		markup
		FROM pricechangehistory  AS ph WHERE productid = $id 
		AND dateposted BETWEEN GETDATE()-30  AND GETDATE() 
		ORDER BY lineid DESC
		";
				$query = $this->ddb->query($sql);
				$result = $query->result();
				return $result;
	}

	function view_markup_display($id,$user_branch){
		$this->ddb = $this->load->database($user_branch,TRUE);
		$sql = "SELECT 
		ProductCode,
		Barcode,
		Description,
		uom,
		qty,
		markup,
		srp,
		PriceModeCode
		FROM POS_Products WHERE ProductID = $id 
		ORDER BY Barcode DESC
		";
				$query = $this->ddb->query($sql);
				$result = $query->result();
				return $result;
	}

	function view_srp_computation_display($id,$user_branch,$barcode){
		$this->ddb = $this->load->database($user_branch,TRUE);
		$sql = "SELECT 
		ProductCode,
		Barcode,
		Description,
		uom,
		markup,
		srp
		FROM POS_Products WHERE ProductID = $id 
		AND Barcode = $barcode
		ORDER BY Barcode DESC
		";
				$query = $this->ddb->query($sql);
				$result = $query->result();
				return $result;
	}

	function view_tn($id,$user_branch){
		$this->ddb = $this->load->database($user_branch,TRUE);
		$sql = "SELECT 
		ToDescription,
		FromDescription
		FROM Movements WHERE MovementNo = ? 
		";
				$query = $this->ddb->query($sql,array($id));
				$result = $query->result();
				return $result;
	}

	function view_name($id,$user_branch){
		$this->ddb = $this->load->database($user_branch,TRUE);
		$sql = "SELECT 
		name
		FROM MarkUsers WHERE userid = $id
		";
				$query = $this->ddb->query($sql);
				$result = $query->result();
				return $result;
	}

	function get_view_data_display($user_branch){
		$this->ddb = $this->load->database($user_branch,TRUE);
		$sql = "SELECT top 50 p.*,
		ph.TransactionID,
		ph.TransactionNo,
		ph.DatePosted,
		ph.Description AS Description2,
		ph.BeginningSellingArea,
		ph.BeginningStockRoom,
		ph.SellingAreaIn,
		ph.SellingAreaOut, 
		ph.StockRoomIn,
		ph.StockRoomOut,
		ph.UnitCost, (SELECT name FROM MarkUsers WHERE userid =  ph.PostedBy) AS Name,
		ph.Barcode
		FROM ProductHistory  AS ph
		INNER JOIN (SELECT ProductID,Description,SellingArea FROM Products WHERE inactive  = 0 ) AS p
		ON ph.ProductID = p.ProductID
		ORDER BY ph.LineID DESC
		";
				$query = $this->ddb->query($sql);
				$result = $query->result();
				return $result;
	}

	function get_view_data_display_search($user_branch,$description=null,$barcode=null,$tdate,$fdate){
		$this->ddb = $this->load->database($user_branch,TRUE);
				$sql = "SELECT top 500 p.*,
				ph.TransactionID,
				ph.TransactionNo,
				ph.DatePosted,
				ph.Description AS Description2,
				ph.BeginningSellingArea,
				ph.BeginningStockRoom,
				ph.SellingAreaIn,
				ph.SellingAreaOut, 
				ph.StockRoomIn,
				ph.StockRoomOut,
				ph.UnitCost AS Unit2,
				ph.Barcode,
				ph.UnitCost, 
				(SELECT name FROM MarkUsers WHERE userid =  ph.PostedBy) AS Name,
       			(SELECT TOP 1 ProductID FROM POS_Products WHERE Barcode = ph.Barcode and ph.ProductID = ProductID) AS PID
				FROM ProductHistory  AS ph
				INNER JOIN (SELECT ProductID,Description,SellingArea,CostOfSales FROM Products WHERE inactive  = 0 ) AS p
				ON ph.ProductID = p.ProductID
				INNER JOIN POS_Products AS pos
				ON ph.Barcode = pos.Barcode and ph.ProductID = pos.ProductID
				";
				
				if($fdate && $tdate && $description){
					$sql .= "WHERE ph.DatePosted BETWEEN '".$tdate."' AND '".$fdate."' AND p.Description LIKE '".$description."%' ORDER BY ph.LineID DESC";
				}else if($fdate && $tdate && $barcode){
					$sql .= "WHERE ph.DatePosted BETWEEN '".$tdate."' AND '".$fdate."' AND ph.Barcode = '".$barcode."' ORDER BY ph.LineID DESC";
				}else if($fdate && $tdate && $barcode && $description){
					$sql .= "WHERE ph.DatePosted BETWEEN '".$tdate."' AND '".$fdate."' AND ph.Barcode = '".$barcode."' AND p.Description LIKE '".$description."%' ORDER BY ph.LineID DESC";
				}else if($fdate && $tdate){
					$sql .= "WHERE ph.DatePosted BETWEEN '".$fdate."' AND '".$tdate."'  ORDER BY ph.LineID DESC";
				}else{
					$sql .= "ORDER BY ph.LineID DESC";
				}
				$query = $this->ddb->query($sql);
				$result = $query->result();
				return $result;

	}

	//--------------------- DAN ------------------------//

	function get_prod_uom($branch = null, $prod_code = null){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
	//	$connected = $this->bdb->initialize();
		//	if($connected){
			//	$this->bdb->trans_start();
				$sql = "SELECT b.* FROM
						(SELECT MIN(qty) as qty FROM POS_Products where ProductCode = '$prod_code') a 
						JOIN 
						(SELECT * from POS_Products where ProductCode = '$prod_code') b
						on a.qty = b.qty";

				//$sql = "SELECT b.*,a.* FROM Products a left join POS_Products b on a.ProductCode = b.ProductCode where b.ProductCode = '$prod_code' and b.uom = 'PC' ";
				$query = $this->bdb->query($sql);
				$result = $query->result();
		//		$this->bdb->trans_complete();
				return $result;
		//	}
	}

	function get_prod_uom2($branch = null, $bcode = null){
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
	//	$connected = $this->bdb->initialize();
		//	if($connected){
			//	$this->bdb->trans_start();
				$sql = "SELECT uom,qty FROM POS_Products where Barcode ='".$bcode."' ";
				$query = $this->bdb->query($sql);
				$result = $query->result();
		//		$this->bdb->trans_complete();
				return $result;
		//	}
	}

	
	function update_status($prod_id= null,$aria_db,$remarks = NULL){

		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		date_default_timezone_set('Asia/Manila');
		$now = date('Y-m-d');
			$connected = $this->bdb->initialize();
			if($connected){
				$prod_id = $prod_id;
				$this->bdb->trans_begin();
				$sql= "UPDATE possible_no_display set status =1, remarks = '$remarks',tran_date = '$now' where id ='".$prod_id."'";
				$result= $this->bdb->query($sql);
				//$this->bdb->trans_complete();
				 if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		        	//return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		            return $result;
		        }
			//return $result;
			}
	}


	function update_statusUncheck($prod_id= null,$aria_db){

		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$this->bdb->trans_begin();
				$prod_id = $prod_id;
				$this->bdb->trans_start(TRUE);
				$sql= "UPDATE possible_no_display set status =0 where id ='".$prod_id."' ";

				$result= $this->bdb->query($sql);

				//$this->bdb->trans_complete();

				 if ($this->bdb->trans_status() === FALSE) {
		            //if something went wrong, rollback everything
		            $this->bdb->trans_rollback();
		        	//return FALSE;
		        } else {
		            //if everything went right, commit the data to the database
		            $this->bdb->trans_commit();
		            return $result;
		        }
			//return $result;
			}
	}

}
?>