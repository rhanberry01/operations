<?php
ini_set('MAX_EXECUTION_TIME', -1);
ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
set_time_limit(0);	
ini_set('memory_limit', '-1');

class Sales_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}


	// public function SingleV($id=null){
	// $sql = "SELECT products.productcode as Product_Code,
	//  products.description as [Description], 
	// reportuom as UOM,
	//  0 as Quantity, 
	// 0 as Quantity_Percentage, 
	// sum(extended) as Sales,
	//  case when sum(totalcost) = 0 then 0 else (sum(extended) - (sum(totalcost)))/sum(extended)*100 end  as GPM_Percent,
	//  sum(extended) - (sum(totalcost)) as Profit,
	//  sum(totalcost) as CostofSales,
	//  sum(extended) - (sum(extended) / 1.12) as mIncVAT,
	//  sum(charges) as mCharges,sum(discount) as mDiscounts,
	//  sum(retextended) as mReturns, sum(extended) / 246360.4 * 100 as mPercExtended 
	//  From(select vendor_products.averagenetcost, finishedsales.QtyReturned,
	//  finishedsales.productid,finishedsales.averageunitcost * case when [return]=1 
	// then convert(money,0-totalqty) else totalqty end as totalcost,
	// (chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
	//  (allowance * finishedsales.qty) + (amountdiscounted * finishedsales.qty) + 
	// (extended-(extended * finishedsales.multiplier)) as discount,
	//  0 as rettotalqty, 
	// 0 as retextended, totalqty, round(extended * finishedsales.multiplier,4) as extended,
	//  '1325 STAR MARKETING' AS VENDOR from finishedsales 
	// left join products on products.productid=finishedsales.productid 
	// left join vendor_products on finishedsales.productid=vendor_products.productid  
	// where products.vendorcode = '" 569 "'
	// GROUP BY products.productcode,products.description,reportuom

	// 	";
	// 	$query = $this->db->query($sql);
	// 	$row = $query->row();
	// 	if ($row != null)
	// 	return $row->name;
	// 	return false;
	
	
	// }
	/********************
	UOMs
	********************/

	//===================OJT===================================


 public function ping($host,$port=80,$timeout=1)
    {

            $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
            
            if ( ! $fsock )
            {
                     error_reporting(0);
                    return FALSE;
            }
            else
            {

                    return TRUE;
            }

    }


	public function get_fresh_section_data($barcode,$branch,$ip){
			$ping_results = $this->ping($ip);
          	if($ping_results){
			$this->bdb = $this->load->database($branch,TRUE);
			/* }
			$connected = $this->bdb->initialize();
			if($connected){*/// p.FieldACode='FRSEC'  and

					$sql ="
							SELECT p.ProductID as ProductID,p.Description as Description,
							p.CostOfSales as CostofSales,pp.uom as UOM,
							pp.markup as Markup,pp.srp as Srp,pp.Barcode as Barcode
							  FROM [Products] as p
							  LEFT JOIN [POS_Products] as pp
							  ON p.ProductID=pp.ProductID 
							  where p.LevelField1Code='9092'
							  and (p.LevelField2Code='0006' OR p.LevelField2Code='0001')
							  and (pp.PriceModeCode='R' or pp.PriceModeCode='W')
							  and pp.Barcode = '".$barcode."'
						";

						$query = $this->bdb->query($sql);
						//$res = $query->result_array();
						return $query;
			}else{
				return 'disconected';
			}

	}

	public function get_fresh_section_details($barcode){
		$all_branch = array();

		$branch_list  = $this->get_branch_list();
		$count = 0;
		$count_branch =  count($branch_list);
		foreach ($branch_list as $val) {

	        	$main133 = $val->code;
	            $branch = $val->branchmain;
	            $name = $val->name;
				$ip = $val->ping;
          		$res = $this->get_fresh_section_data($barcode,$branch,$ip);	
          		
          		if($res != 'disconected'){

          			while ($row = $res->_fetch_assoc()){
          				$_row = $row;
						$_row['branch'] = $branch;
						$_row['branch_name'] = $name;
						$_row['branch_main'] = $main133;
						array_push($all_branch, $_row); 
          			}
      			}else{
  					$_row = array('ProductID'=>'No Connection','Description'=>'No Connection','CostofSales'=>'-','UOM'=>'-','Markup'=>'-','Srp'=>'-','Barcode'=>'-');
					$_row['branch'] = $branch;
					$_row['branch_name'] = $name;
					$_row['branch_main'] = $main133;
					array_push($all_branch, $_row); 
      			}

			$count++;
	    }
	    if($count == $count_branch){
	    	
			return	$all_branch;
	    }
		

	}

	public function update_srp($srp,$Markup,$branch,$user,$barcode,$old_srp,$uom,$productid){
		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			
			if($connected){
				$sql = "
					UPDATE POS_Products
					SET srp = ".$srp." , LastDateModified = '".date('Y-m-d H:i:s')."'
					where Barcode = '".$barcode."'
				 ";
				$query = $this->bdb->query($sql);
				
				$items = array(
			            'productid'=>$productid,
			            'barcode' =>$barcode,
			            'dateposted'=>date('Y-m-d H:i:s'),  
			            'postedby'=>$user,
			            'fromsrp'=>$old_srp,
			            'tosrp'=>$srp,
			            'UOM'=>$uom,
			            'markup'=>$Markup
			        ); 	

				$this->bdb->insert('pricechangehistory',$items);
				$x=$this->bdb->insert_id();

				return 'connected'; 


			}
		
	}

	public function update_markup($srp,$Markup,$branch,$user,$barcode,$old_srp,$uom,$productid){
		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			
			if($connected){
					$sql = "
					UPDATE POS_Products
					SET markup = ".$Markup." , LastDateModified = '".date('Y-m-d H:i:s')."'
					where Barcode = '".$barcode."'

				 ";
				$query = $this->bdb->query($sql);

				$items = array(
			            'productid'=>$productid,
			            'barcode' =>$barcode,
			            'dateposted'=>date('Y-m-d H:i:s'),  
			            'postedby'=>$user,
			            'fromsrp'=>$old_srp,
			            'tosrp'=>$srp,
			            'UOM'=>$uom,
			            'markup'=>$Markup
			        ); 	

				$this->bdb->insert('pricechangehistory',$items);
				$x=$this->bdb->insert_id();
				
				return 'connected'; 

			}

		
	}


	public function upd_sales_line_cost($branch,$ProductID,$From,$To){
		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			
			if($connected){

				$sql = "
					Update FS
					SET 
					fs.AverageUnitCost = vp.averagenetcost
					from FinishedSales as fs 
					inner join VENDOR_Products as vp on fs.ProductID = vp.ProductID
					where fs.ProductID = '".$ProductID."' and CAST(fs.LogDate as date) between '".$From."' and '".$To."'

				 ";
				$query = $this->bdb->query($sql);
				return 'connected'; 
			}else{
				return 'not connected'; 
			}



	}



	public function upd_sales_line($branch,$ProductID,$LineID,$Qty,$Packing,$TotalQty){
			$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			
			if($connected){

				$sql = "
					UPDATE FinishedSales
					SET 
					Qty = ".$Qty.",
					Packing = ".$Packing.",
					TotalQty = ".$TotalQty."
					WHERE ProductID ='".$ProductID."' and LineID = ".$LineID."

				 ";
				$query = $this->bdb->query($sql);
				return 'connected'; 
			}else{
				return 'not connected'; 
			}


	}


	public function get_special_fr_pos($br=null,$from=null,$to=null){

		$this->bdb = $this->load->database($br,TRUE);
		$connected = $this->bdb->initialize();
		
		if($connected){
		
			$sql = "select  ProductID,cast(logdate as date) as dates,Barcode,Description,UOM,sum((case when [return]=1 then convert(money,0-totalqty) else totalqty end)) as TotalQty,
					sum(Extended) as 'sales',
					(SUM((averageunitcost) * (case when [return]=1 then convert(money,0-totalqty) else totalqty end))) as COST,
					((sum(Extended)) - (SUM((averageunitcost) * (case when [return]=1 then convert(money,0-totalqty) else totalqty end)))) as GP
					from FinishedSales
					where cast(logdate as date) >= '".$from."' 
					and cast(logdate as date) <= '".$to."' and 
					ProductID IN
					(select productid from Products
					where GlobalID IN ('14212','4237','15190','7855','7857',	
										'2004874428',
										'2004864906',
										'11977',
										'2004864471',
										'2004864474',
										'2004864473',
										'2004864475',
										'2004864472',
										'2004864471',
										'7855',
										'14257',
										'2004870795',
										'17745',
										'9500', 
										'9501', 
										'8951',
										'999000690727',
										'8518',
										'999000692622'))
					GROUP BY ProductID,cast(logdate as date),Barcode,Description,UOM
					ORDER BY ProductID";
			$query = $this->bdb->query($sql);
			$res = $query->result();
			return $res;
		
		}


	}
	public function get_smart_pos($from=null,$to=null){

		$this->bdb = $this->load->database('SMART',TRUE);
			$connected = $this->bdb->initialize();
			
			if($connected){
			
				$sql = "select 
						requestRefNo,
						planCode,
						sourceAccount,
						targetSubsAccount,
						terminalID,
						address,
						ORNo,
						BranchCode,
						trans_date,
						amountDeduct
						from eloadingRequest
						where cast(trans_date as date)  between  '".$from."' and '".$to."'
						and respcode = '0000' ORDER BY BranchCode";
				$query = $this->bdb->query($sql);
				$res = $query->result();
				return $res;
			
			}

	

	}

	public function singlevendor($id=null){
			$this->bdb = $this->load->database('srs_gag',TRUE);
			$connected = $this->bdb->initialize();
			
			if($connected){
			
				$sql = "SELECT * FROM vendor ";
				$query = $this->bdb->query($sql);
				$res = $query->result();
				
				return $res;
				
				// $sql = "SELECT * from vendor";
				// $res = $this->$sql->result();
				// return $res;
			}

	 }	

	 public function get_owner($vendorcode=null){
	 	$this->bdb = $this->load->database('sgp',TRUE);
	 	$connected = $this->bdb->initialize();

	 	if($connected){

	 		$sql   = "SELECT TOP 1 PURCHASER as owner from tblSalesGP where VENDORCODE='".$vendorcode."'";
	 		$query = $this->bdb->query($sql);
	 		$res   = $query->row();

	 		if($res){
	 			return $res->owner;
	 		}else{
	 			return false;
	 		}
	 	}
	 }

public function get_datacenter_details($barcode = null,$branch=null,$description=null){

	$this->bdb = $this->load->database($branch,TRUE);
	 	$connected = $this->bdb->initialize();

	 	if($connected){
	 		$sql   = "  select 
						p.ProductID as ProductID ,
						p.Description as Description,
						pp.Barcode as Barcode,
						pp.markup as markup,
						pp.PointsEnabled as PointsEnabled,
						pp.SeniorCitizenTag as SeniorCitizenTag,
						pp.pVatable as pVatable ,
						pp.srp as  srp,
						vp.averagenetcost as averagenetcost,
						p.CostOfSales as CostOfSales ,
						pp.uom as uom,
						pp.qty as qty
						from Products as p 
						inner join  POS_Products as pp  on p.ProductID = pp.ProductID
						inner join VENDOR_Products as vp on p.ProductID = vp.ProductID and vp.defa = 1
						where  ('".$barcode."' ='' OR pp.Barcode = '".$barcode."')  and  ('".$description."' ='' OR p.Description LIKE '%".$description."%');
					";

						
	 		$query = $this->bdb->query($sql);
	 		$res   = $query->result();

	 		if($res){
	 			return $res;
	 		}else{
	 			return false;
	 		}
	 	}

}



public function get_cashier_user($branch = null,$id=null){
	 	$this->bdb = $this->load->database($branch,TRUE);
	 	$connected = $this->bdb->initialize();

	 	if($connected){

	 		$sql   = "SELECT name  from MarkUsers where userid=".$id."";
	 		$query = $this->bdb->query($sql);
	 		$res   = $query->row();

	 		if($res){
	 			return $res->name;
	 		}else{
	 			return false;
	 		}
	 	}
}










	  public function get_vendor_category($branch,$vendorcode=null){
	 	$this->bdb = $this->load->database($branch,TRUE);
	 	$connected = $this->bdb->initialize();

	 	if($connected){

	 		$sql   = "SELECT description from vendor where vendorcode ='".$vendorcode."'";
	 		$query = $this->bdb->query($sql);
	 		$res   = $query->row();

	 		if($res){
	 			return $res->description;
	 		}else{
	 			return false;
	 		}
	 	}
	 }
	  public function get_user($id){
	  	$this->bdb = $this->load->database('default',TRUE);
	 	$connected = $this->bdb->initialize();

	 	if($connected){

	 		$sql   = "SELECT name from users where id ='".$id."'";
	 		$query = $this->bdb->query($sql);
	 		$res   = $query->row();

	 		if($res){
	 			return $res->name;
	 		}else{
	 			return false;
	 		}
	 	}

	  }
	  public function veeeeendor($branch,$vendorcode=null){
	 	$this->bdb = $this->load->database($branch,TRUE);
	 	$connected = $this->bdb->initialize();

	 	if($connected){

	 		$sql   = "SELECT description from vendor where vendorcode ='".$vendorcode."'";
	 		$query = $this->bdb->query($sql);
	 		$res   = $query->row();

	 		if($res){
	 			return $res->description;
	 		}else{
	 			return false;
	 		}
	 	}
	 }


	 public function get_UOM($branch,$UOM=null){
	 	$this->bdb = $this->load->database($branch,TRUE);
	 	$connected = $this->bdb->initialize();

	 	if($connected){

	 		$sql   = "SELECT Qty from UOM where UOM='".$UOM."'";
	 		$query = $this->bdb->query($sql);
	 		
	 		if($query){
				$res   = $query->row();
	 			return $res->Qty;
	 		}else{

	 			return 0;
	 		}	 		
	 	}
	 }
	  public function get_UOMI($branch,$UOM=null){
	 	$this->bdb = $this->load->database($branch,TRUE);
	 	$connected = $this->bdb->initialize();

	 	if($connected){

	 		$sql   = "SELECT Qty from UOM where UOM='".$UOM."'";
	 		$query = $this->bdb->query($sql);
	 		if($query){
	 			$res   = $query->row_array();
	 			return $res['Qty'];
	 		}else{
	 			return  0;
	 		}

	 		
	 	}
	 }

	  public function get_vvendor($vendor=NULL){
	 	$this->bdb = $this->load->database('srs_gag',TRUE);
	 	$connected = $this->bdb->initialize();

	 	if($connected){

	 		$sql   = "SELECT Qty from UOM where UOM='".$vendor."'";
	 		$query = $this->bdb->query($sql);
	 		$res   = $query->row();

	 		return $res;
	 		
	 	}
	 }



	

	 //================CHARLES====================

	 // public function svendor($id=null){
		// 	$this->bdb = $this->load->database('srs_gag',TRUE);
		// 	$connected = $this->bdb->initialize();

		// 	if($connected){

		// 		$sql = " SELECT products.productcode, 
		// 							products.description,
		// 							reportuom as 'UOM' FROM finishedsales left join products on products.ProductID=finishedsales.ProductID";
		// 		$query = $this->bdb->query($sql);
		// 		$res = $query->result();
			
		// 		return $res;
		// 	}

		// 		return 'NC';


	 // }


	 //================CHARLES====================

 	public function add_vendor($items){
		$this->db->insert('selected_vendor',$items);
		$x=$this->db->insert_id();
		return $x;
	}

	public function SingleVendorDP($team=null){
		$this->bdb = $this->load->database($team,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT vendorcode,description FROM vendor order by description";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}

	}

	public function ReloadSingleVendorDP($branch=null){
		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT vendorcode,description FROM vendor order by description";
				
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}

	}
	public function ProductVendorDrop($branch){
		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT vendorcode,description FROM vendor order by description";
				
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}

	}
	public function get_branch_list($barcode=null,$branch=null){

				$sql = "SELECT * FROM branches";
				$query = $this->db->query($sql);
				$res = $query->result();
				return $res;
 
	}	

	public function Groupqwe($id=null){
		$this->bdb = $this->load->database('default',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT code,description FROM team";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}

	}

	// View Finished Sales
	public function get_fsales_data($user_branch=null,$from=null,$to=null,$barcode=null){
			$this->bdb = $this->load->database($user_branch,TRUE);	
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "
					SELECT
					fs.TransactionNo,
					fs.ProductCode,fs.ProductID,fs.[return],fs.voided,
					fs.Barcode,
					fs.lineID, 
					fs.Description, 
					fs.UOM, 
					fs.Qty, 
					fs.Packing,
					fs.TotalQty,
					vp.averagenetcost as LandedCost,
					fs.AverageUnitCost,
					fs.Price,
					fs.Extended,
					fs.PriceModeCode,
					fs.UserID, 
					fs.TerminalNo,
					fs.PriceOverride,
					fs.LogDate
					from finishedsales as fs
					inner join VENDOR_Products as vp on fs.ProductID = vp.ProductID and defa = 1
					where CAST(fs.LogDate as date) between '".$from."' and '".$to."' and fs.ProductID = '".$barcode."' order by TotalQty desc";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}else{
				return 'no connetion';
			}

	}

	public function get_fsales_data_($user_branch=null,$from=null,$to=null,$barcode=null){
			$this->bdb = $this->load->database($user_branch,TRUE);	
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "
					SELECT
					fs.TransactionNo,
					fs.ProductCode,fs.ProductID,fs.[return],fs.voided,
					fs.Barcode,
					fs.lineID, 
					fs.Description, 
					fs.UOM, 
					fs.Qty, 
					fs.Packing,
					fs.TotalQty,
					vp.averagenetcost as LandedCost,
					fs.AverageUnitCost,
					fs.Price,
					fs.Extended,
					fs.PriceModeCode,
					fs.UserID, 
					fs.TerminalNo,
					fs.PriceOverride,
					fs.LogDate
					from finishedsales as fs
					inner join VENDOR_Products as vp on fs.ProductID = vp.ProductID and defa = 1
					where CAST(fs.LogDate as date) between '".$from."' and '".$to."' and fs.voided = 0
					and fs.ProductID = '".$barcode."' order by TotalQty desc";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}else{
				return 'no connetion';
			}

	}

	// View Finished Sales
		

	public function get_upcost_list(){
			$this->bdb = $this->load->database('default',TRUE);	
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT * from update_cost where isupd = 0 order by id desc";
				$query = $this->bdb->query($sql);
				$res = $query->result();
				return $res;

			}else{
				return 'no connetion';
			}

	}

	public function get_upcost_list_id($id){
			$this->bdb = $this->load->database('default',TRUE);	
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT * from update_cost where id = ".$id." ";
				$query = $this->bdb->query($sql);
				$res = $query->row();
				return $res;

			}else{
				return 'no connetion';
			}

	}


	public function upd_cost_sales($id){
			$this->bdb_ = $this->load->database('default',TRUE);	
			$connected = $this->bdb_->initialize();
			if($connected){
				$sql = "UPDATE update_cost SET isupd = 1 where id = ".$id." ";
				$query = $this->bdb_->query($sql);
				return $sql;
			}else{
				return 'no connetion';
			}

	}


	public function get_fsales_data_ER($branch=null,$LineID=null,$ProductID=null){
			$this->bdb = $this->load->database($branch,TRUE);	
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "
				SELECT
				Barcode,
				lineID, 
				Description, 
				UOM, 
				Qty, 
				Packing,
				TotalQty,
				AverageUnitCost,
				Price,
				Extended,
				PriceModeCode,
				UserID, 
				TerminalNo,
				LogDate
				from finishedsales
				where ProductID = '".$ProductID."'  and LineID IN (".$LineID.")";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}else{
				return 'no connetion';
			}

	}


public function branchmain($code=null){
			$this->bdb = $this->load->database('default',TRUE);	
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select branchmain,ping FROM branches where code = '".$code."'";
				$query = $this->bdb->query($sql);
				$res = $query->row();
				return $res;

			}

	}



	public function BranchDP($id=null){
			$this->bdb = $this->load->database('default',TRUE);	
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select code,name,branchmain FROM branches";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}

	}

	public function BranchDP1($id=null){
			$this->bdb = $this->load->database('dtc',TRUE);	
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select code,name FROM branches";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}

	}

	public function CategoryNewDb($id=null){
		$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT * FROM LevelField1 order by description , LevelField1Code";
				$query = $this->bdb->query($sql);
				$res = $query->result();
				return $res;
			}

	}

	public function Getname($code){
		$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT Description FROM LevelField1 WHERE LevelField1Code = '".preg_replace('/\s+/', '',$code). "'";
				$query = $this->bdb->query($sql);
				if($query){
					$res = $query->row();
					return $res->Description;
				}else{
					return "SELECT Description FROM LevelField1 WHERE LevelField1Code = '".preg_replace('/\s+/', '',$code). "'";
				}
			

			}

	}

	
	// 	public function GetVendorNaaame($code=null){
	// 	$this->bdb = $this->load->database('srs_gag',TRUE);
	// 		$connected = $this->bdb->initialize();
	// 		if($connected){
	// 			$sql = "SELECT description FROM vendor WHERE vendorcode = ".$code."";
	// 			$query = $this->bdb->query($sql);
	// 			if($query){
	// 				$res = $query->row();
	// 				return $res->description;
	// 			}else{
	// 				return 'error';
	// 			}
			

	// 		}

	// }
		public function GetOfftakeName($branch=null,$code=null){


		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT description FROM vendor WHERE vendorcode = '".$code."'";
				 $query = $this->bdb->query($sql);
				 if($query){
				 	$res = $query->row();
					return $res->description;
				 }else{
					return 'error';
				}

	}
}
		public function GetOfftakeName1($branch=null,$code=null){


		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT description FROM vendor WHERE vendorcode = '".$code."'";
				 $query = $this->bdb->query($sql);
				 if($query){
				 	$res = $query->row();
					return $res->description;
				 }else{
					return 'error';
				}

	}
}

	public function GetBranchName($code=null){
		$this->bdb = $this->load->database('default',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT description FROM branches WHERE code = '".$code."'";
				$query = $this->bdb->query($sql);
				if($query){
					$res = $query->row();
					return $res->description;
				}else{
					return 'error';
				}
			

			}

	}

	public function GetBranchNameall(){
		$this->bdb = $this->load->database('default',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT * FROM branches where inactive = 0";
				$query = $this->bdb->query($sql);
				if($query){
					$res = $query->result();
					return $res;
				}else{
					return 'error';
				}
			

			}

	}



	public function GetVendorName($branch,$code=null){
		$this->bdb = $this->load->database('srs_gag',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT vendorcode as VENDOR FROM Products WHERE vendorcode = '".$code."'";
				$query = $this->bdb->query($sql);
				if($query){
					$res = $query->row();
					return $res->vendorcode;
				}else{
					return 'error';
				}
			

			}

	}
	public function GetDeptName($code=null){
		$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT Description FROM FieldA WHERE FieldACode = '".$code."'";
				$query = $this->bdb->query($sql);
				if($query){
					$res = $query->row();
					return $res->Description;
				}else{
					return 'error';
				}
			

			}

	}

	public function GetBrandName($code=null){
		$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT Description FROM FieldB where FieldBCode = '".$code."'";
				$query = $this->bdb->query($sql);
				if($query){
					$res = $query->row();
					return $res->Description;
				}else{
					return 'error';
				}
			

			}

	}

	public function GetClassName($code=null){
		$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT  Description  FROM FieldC where FieldCCode = '".$code."'  ";
				$query = $this->bdb->query($sql);
				if($query){
					$res = $query->row();
					return $res->Description;
				}else{
					return 'error';
				}
			

			}

	}

	public function GetCountryName($code=null){
		$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT Description FROM FieldE where FieldECode = '".$code."'";
				$query = $this->bdb->query($sql);
				if($query){
					$res = $query->row();
					return $res->Description;
				}else{
					return 'error';
				}
			

			}

	}

	public function add_data_up_cost($items){
		$this->bdb = $this->load->database('default',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$this->db->insert('update_cost',$items);
				$x=$this->db->insert_id();
				return $x;
			}
	}


	public function GetCategoryName($code=null){
		$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT Description FROM LevelField1 WHERE LevelField1Code = '".$code."'";
				$query = $this->bdb->query($sql);
				if($query){
					$res = $query->row();
					return $res->Description;
				}else{
					return 'error';
				}
			

			}

	}


	public function PriceMode($id=null){
			$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT pricemodecode , description FROM pricemode";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}
	}
	public function Countrydb($id=null){
			$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT FieldECode , Description FROM FieldE";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}
	}
	public function Branddb($id=null){
			$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT FieldBCode , Description FROM FieldB";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}
	}
	public function Departmentdb($id=null,$branch=null){
			$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT FieldACode , Description FROM FieldA";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}
	}
	public function CategoryDb($id=null){
			$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){

				$sql = "SELECT FieldCCode , Description  FROM FieldC  ";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
				
		}
}
	public function Yeardb($id=null,$branch=null){
			$this->bdb = $this->load->database('dtc',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "SELECT FieldDCode , Description FROM FieldD";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}
	}
	//START - Wakol
	// function get_barangay($id=null){
	//  	$user = $this->session->userdata('user');
	// 	$this->bdb = $this->load->database($user['branch'],TRUE);
	// 	$connected = $this->dbb->initialize();
	// 	if($connected){
	// 		$this->bdb->trans_start();
	// 			$this->bdb->select('*');
	// 			$this->bdb->from('Customer_Address');
	// 			if($id != null)
	// 				$this->bdb->where('AddressId',$id);
	// 			$query = $this->bdb->get();
	// 			$result = $query->result();
	// 		$this->bdb->trans_complete();
	// 		return $result;
	// 	}else{
	// 		return 'not connected';
	// 	}
	// }

		//>>>>>>>>>>>	
	public function get_vendor($date_from=null,$date_to=null,$description=null,$branch=null){
		
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		$sql='';
		$sql = "	select
				products.ProductID as Product_id,
				products.productcode as Product_Code,
				products.description as [Description],
				Products.vendorcode as VENDOR,
				reportuom as UOM,
				sum(case when extended < 0 then  (0 - (totalqty/products.reportqty))  
							else (totalqty/products.reportqty) end) as Quantity,
				sum(extended) as Sales,
					case when sum(totalcost) = 0 
						then 0 
					else (sum(extended) - (sum(totalcost)))/sum(extended)*100 end  as GPM_Percent,
				sum(extended) - (sum(totalcost)) as Profit,
				sum(totalcost) as CostofSales,
				sum(extended) - (sum(extended) / 1.12) as mIncVAT
				  From 
				(select 
					vendor_products.averagenetcost, 
					finishedsales.QtyReturned,
				    finishedsales.productid,
				  (averageunitcost / case when finishedsales.Pvatable = 2 then 1.12 else 1 end)* 
						case 
							when [return]=1
								then convert(money,0-totalqty) 
						else totalqty end as TotalCost,
				(chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
				(allowance * finishedsales.qty) + (amountdiscounted * finishedsales.qty) + (extended-(extended * finishedsales.multiplier)) as discount,
				0 as rettotalqty,
				0 as retextended,
				totalqty,
				round( (extended * finishedsales.multiplier) / case when finishedsales.Pvatable = 1 then 1.12 else 1 end  ,4)  as extended
				From finishedsales left join products on products.productid=finishedsales.productid 
				left join vendor_products on finishedsales.productid=vendor_products.productid 
				where products.vendorcode = '".$description."' and logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0  
				and vendor_products.defa=1
				Union All select vendor_products.averagenetcost,
				finishedsales.QtyReturned, finishedsales.productid,
				0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended From finishedsales left join products on products.productid=finishedsales.productid left join vendor_products on finishedsales.productid=vendor_products.productid
				WHERE PRODUCTS.VENDORCODE = '".$description."' AND LOGDATE >= '".$date_from."' AND LOGDATE <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1) as finishedsales left join products on products.productid=finishedsales.productid group by
				 products.productid,products.productcode,products.description,reportuom,Products.vendorcode order by  products.description
				";		


	 	$query = $this->bdb->query($sql);	

			$res = $query->result();
			if($res){
				return $res;	
			}else{
				return false;
			}

			}
		}
		
	
	public function AVendor($id = null){

				$user = $this->session->userdata('user');
				$this->bdb= $this->load->database('srs_gag',TRUE);
				$connected = $this->bdb->initialize();
				if($connected){
					$this->bdb->trans_start();
						$this->bdb->select('*');
						$this->bdb->from('vendor');
						if($id != null)
							$this->bdb->where('daterange',$id);
						$query = $this->bdb->get();
						$result = $query->result();
					$this->bdb->trans_complete();
					return $result;
				}else{
					return 'not connected';
				}


			}
	

	public function get_allvendor($date_from=null,$date_to=null,$branch){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			$sql='';

			$sql = "SELECT 
new.VENDOR as VENDOR,
new.PRODUCTID as PRODUCTID,
new.Product_Code as Product_Code,
new.Description as Description,
new.UOMs as UOM,
NULLIF(new.reportqty ,0) as reportqty,
sum(new.Quantity)as Quantity,
sum(new.TQty)as TQty,
sum(new.Sales)as Sales,
CASE
	WHEN sum(new.Profit) = 0 AND sum(new.Sales) = 0
	THEN 0
	ELSE ((sum(new.Profit) / sum(new.Sales)) *100) 
END as GPM_Percent,
sum(new.Profit)as Profit,
sum(new.CostofSales)as CostofSales,
sum(new.mIncVAT)as mIncVAT,
sum(new.Override)as Override,
sum(new.discounts)as discounts,
sum(Returns) as Returns
FROM
(select
finishedsales.description1 as VENDOR,
products.ProductID as PRODUCTID,
products.productcode as Product_Code,
products.description as Description,
Products.vendorcode as VENDOR1,
reportuom as UOMs,
products.reportqty as reportqty ,
sum(case when extended < 0 then  (0 - (totalqty/NULLIF(products.reportqty,0)))  
else (totalqty/NULLIF(products.reportqty,0) ) end) as Quantity,
sum(case when extended < 0 then  (0 - (totalqty)) else (totalqty) end) as TQty,
0 as Quantity_Percentage,
sum(extended) as Sales,
case when sum(totalcost) = 0 
then 0 
else (sum(extended) - (sum(totalcost)))/NULLIF(sum(extended),0)*100 end  as GPM_Percent,
sum(extended) - (sum(totalcost)) as Profit,
sum(totalcost) as CostofSales,
sum(extended) - (sum(extended) / 1.12) as mIncVAT,
finishedSales.av as v,
finishedSales.tosrp,
FinishedSales.UOM,
case when finishedSales.PriceOverride = 1
	 then (((finishedSales.tosrp / finishedsales.Packing) * (sum(case when extended < 0 then  (0 - (totalqty)) else (totalqty) end))) - sum(extended))
	 else 0
 end as [Override],
 SUM(finishedSales.discount) as discounts,
 finishedSales.Packing as packing,
(NULLIF(finishedSales.tosrp,0) / finishedsales.Packing) as trsp,
sum(FinishedSales.[Return]) as Returns
From 
(select 
CASE WHEN FinishedSales.[Return] = 1 THEN round((extended * finishedsales.multiplier) / case when finishedsales.Pvatable = 1 then 1.12 else 1 end  ,4) ELSE 0 END AS [Return],
vendor.description as description1,
vendor_products.averagenetcost as av, 
finishedsales.QtyReturned,
finishedsales.productid,
(averageunitcost /
																case when finishedsales.Pvatable =1 OR finishedsales.Pvatable = 2 then 1.12  
				else 1 end 
																)* case when [return]=1 then convert(money,0-totalqty) 
															 else totalqty end as TotalCost,					
															 (chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
amountdiscounted  as discount,
0 as rettotalqty,
0 as retextended,
totalqty,
round((extended * finishedsales.multiplier) / case when finishedsales.Pvatable = 1 then 1.12 else 1 end  ,4)  as extended,
prch.tosrp  as tosrp,
finishedSales.PriceOverride as PriceOverride,finishedSales.UOM,finishedSales.Packing
From finishedsales left join products on products.productid=finishedsales.productid
INNER JOIN vendor on vendor.vendorcode = Products.vendorcode
left join vendor_products on finishedsales.productid=vendor_products.productid
left join (select
			DISTINCT
			cc.productid as  productid
			,MAX(bb.tosrp) as tosrp
			,bb.dateposted as dateposted
			,bb.UOM as  uom
			from
			(select productid as productid,MAX(dateposted) as dateposted from  pricechangehistory where CAST(dateposted AS DATE) <= '".$date_to."'  group by productid) as cc
			INNER JOIN (select productid as productid,tosrp as tosrp ,dateposted as dateposted,PriceModecode as pricemode, UOM as UOM from  pricechangehistory) as bb
			ON cc.productid = bb.productid and cc.dateposted = bb.dateposted 
			--and bb.pricemode = 'R'
			GROUP BY cc.productid,bb.dateposted,bb.UOM
			) as prch
	on  finishedsales.ProductID  = prch.productid and finishedsales.UOM = prch.uom
where logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0  
and vendor_products.defa=1 
Union All 
select 
CASE WHEN FinishedSales.[Return] = 1 THEN round((extended * finishedsales.multiplier) / case when finishedsales.Pvatable = 1 then 1.12 else 1 end  ,4) ELSE 0 END AS [Return],
vendor.description,
vendor_products.averagenetcost,
finishedsales.QtyReturned, finishedsales.productid,
0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended, 0  as tosrp , 0 as PriceOverride,finishedSales.uom,finishedSales.Packing
From finishedsales 
join products on products.productid=finishedsales.productid 
INNER JOIN vendor on vendor.vendorcode = Products.vendorcode
left join vendor_products on finishedsales.productid=vendor_products.productid
WHERE logdate >= '".$date_from."' and logdate <= '".$date_to."'  AND VOIDED = 0   AND [RETURN] = 1)   
as finishedsales 
left join products on products.productid=finishedsales.productid 
left join (select
			DISTINCT
			cc.productid as  productid
			,MAX(bb.tosrp) as tosrp
			,bb.dateposted as dateposted
			,bb.UOM
			from
			(select productid as productid,MAX(dateposted) as dateposted from  pricechangehistory where CAST(dateposted AS DATE) <= '".$date_to."'  group by productid) as cc
			INNER JOIN (select productid as productid,tosrp as tosrp ,dateposted as dateposted , PriceModecode as pricemode, UOM as UOM from  pricechangehistory) as bb
			ON cc.productid = bb.productid  and cc.dateposted = bb.dateposted 
			GROUP BY cc.productid,bb.dateposted,bb.UOM
			) as prch
	on  finishedsales.ProductID  = prch.productid and finishedSales.uom = prch.UOM
group by
products.productid,products.productcode,products.description,reportuom,
 finishedsales.description1,Products.vendorcode,finishedSales.av,finishedsales.tosrp,finishedSales.PriceOverride,finishedSales.uom,reportqty,finishedSales.Packing
 HAVING sum(extended) <> 0 ) as new 
GROUP BY 
VENDOR,
PRODUCTID,
Product_Code,
Description,
UOMs,
reportqty
order by  VENDOR";

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;

		}

	}
/* 
BAK 12617
public function get_allvendor($date_from=null,$date_to=null,$branch){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			$sql='';

			$sql = "select
					finishedsales.description1 as VENDOR,
					products.ProductID as PRODUCTID,
					products.productcode as Product_Code,
					products.description as Description,
					Products.vendorcode as VENDOR1,
					reportuom as UOM,
					products.reportqty as reportqty ,
					sum(case when extended < 0 then  (0 - (totalqty/NULLIF(products.reportqty,0)))  
					else (totalqty/NULLIF(products.reportqty,0) ) end) as Quantity,
					sum(case when extended < 0 then  (0 - (totalqty)) else (totalqty) end) as TQty,
					0 as Quantity_Percentage,
					sum(extended) as Sales,
					case when sum(totalcost) = 0 
					then 0 
					else (sum(extended) - (sum(totalcost)))/NULLIF(sum(extended),0)*100 end  as GPM_Percent,
					sum(extended) - (sum(totalcost)) as Profit,
					sum(totalcost) as CostofSales,
					sum(extended) - (sum(extended) / 1.12) as mIncVAT,
					finishedSales.av as v,
					finishedSales.tosrp,
					FinishedSales.UOM,
					case when finishedSales.PriceOverride = 1
						 then (((finishedSales.tosrp / finishedsales.Packing) * (sum(case when extended < 0 then  (0 - (totalqty)) else (totalqty) end))) - sum(extended))
						 else 0
					 end as [Override],
					 SUM(finishedSales.discount) as discounts,
					 finishedSales.Packing as packing,
					(finishedSales.tosrp / finishedsales.Packing) as trsp
					From 
					(select 
					vendor.description as description1,
					vendor_products.averagenetcost as av, 
					finishedsales.QtyReturned,
					finishedsales.productid,
					(averageunitcost /
                                          case when finishedsales.Pvatable =1 OR finishedsales.Pvatable = 2 then 1.12  
				          else 1 end 
                                          )* case when [return]=1 then convert(money,0-totalqty) 
                                         else totalqty end as TotalCost,					
                                         (chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
					amountdiscounted  as discount,
					0 as rettotalqty,
					0 as retextended,
					totalqty,
					round( (extended * finishedsales.multiplier) / case when finishedsales.Pvatable = 1 then 1.12 else 1 end  ,4)  as extended,
					prch.tosrp  as tosrp,
					finishedSales.PriceOverride as PriceOverride,finishedSales.UOM,finishedSales.Packing
					From finishedsales left join products on products.productid=finishedsales.productid
					INNER JOIN vendor on vendor.vendorcode = Products.vendorcode
					left join vendor_products on finishedsales.productid=vendor_products.productid
					left join (select
								DISTINCT
								cc.productid as  productid
								,MAX(bb.tosrp) as tosrp
								,bb.dateposted as dateposted
								,bb.UOM as  uom
								from
								(select productid as productid,MAX(dateposted) as dateposted from  pricechangehistory where CAST(dateposted AS DATE) <= '".$date_to."' group by productid) as cc
								INNER JOIN (select productid as productid,tosrp as tosrp ,dateposted as dateposted,PriceModecode as pricemode, UOM as UOM from  pricechangehistory) as bb
								ON cc.productid = bb.productid and cc.dateposted = bb.dateposted 
								--and bb.pricemode = 'R'
								GROUP BY cc.productid,bb.dateposted,bb.UOM
								) as prch
						on  finishedsales.ProductID  = prch.productid and finishedsales.UOM = prch.uom
					where logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0 
					and vendor_products.defa=1 
					Union All 
					select 
					vendor.description,
					vendor_products.averagenetcost,
					finishedsales.QtyReturned, finishedsales.productid,
					0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended, 0  as tosrp , 0 as PriceOverride,finishedSales.uom,finishedSales.Packing
					From finishedsales 
					join products on products.productid=finishedsales.productid 
					INNER JOIN vendor on vendor.vendorcode = Products.vendorcode
					left join vendor_products on finishedsales.productid=vendor_products.productid
					WHERE logdate >= '".$date_from."' and logdate <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1 ) 
					as finishedsales 
					left join products on products.productid=finishedsales.productid 
					left join (select
								DISTINCT
								cc.productid as  productid
								,MAX(bb.tosrp) as tosrp
								,bb.dateposted as dateposted
								,bb.UOM
								from
								(select productid as productid,MAX(dateposted) as dateposted from  pricechangehistory where CAST(dateposted AS DATE) <= '".$date_to."' group by productid) as cc
								INNER JOIN (select productid as productid,tosrp as tosrp ,dateposted as dateposted , PriceModecode as pricemode, UOM as UOM from  pricechangehistory) as bb
								ON cc.productid = bb.productid  and cc.dateposted = bb.dateposted 
								GROUP BY cc.productid,bb.dateposted,bb.UOM
								) as prch
						on  finishedsales.ProductID  = prch.productid and finishedSales.uom = prch.UOM
					group by
					products.productid,products.productcode,products.description,reportuom,
					 finishedsales.description1,Products.vendorcode,finishedSales.av,finishedsales.tosrp,finishedSales.PriceOverride,finishedSales.uom,reportqty,finishedSales.Packing
					 HAVING sum(extended) <> 0
					order by  VENDOR";

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;

		}

	}



*/
/*	public function get_allvendor($date_from=null,$date_to=null,$branch){
		
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		$sql='';

		$sql = "select
				finishedsales.description1 as VENDOR,
				products.ProductID as PRODUCTID,
				products.productcode as Product_Code,
				products.description as Description,
				Products.vendorcode as VENDOR1,
				reportuom as UOM,
				sum(case when extended < 0 then  (0 - (totalqty/products.reportqty))  
				else (totalqty/products.reportqty) end) as Quantity,
				0 as Quantity_Percentage,
				sum(extended) as Sales,
				case when sum(totalcost) = 0 
				then 0 
				else (sum(extended) - (sum(totalcost)))/sum(extended)*100 end  as GPM_Percent,
				sum(extended) - (sum(totalcost)) as Profit,
				sum(totalcost) as CostofSales,
				sum(extended) - (sum(extended) / 1.12) as mIncVAT,
				finishedSales.av as v	
				From 
				(
				select 
				vendor.description as description1,
				vendor_products.averagenetcost as av, 
				finishedsales.QtyReturned,
				finishedsales.productid,
				(averageunitcost / case when finishedsales.Pvatable = 2 then 1.12 else 1 end) * 
				case 
				when [return]=1
				then convert(money,0-totalqty) 
				else totalqty end as TotalCost,
				(chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
				(allowance * finishedsales.qty) + (amountdiscounted * finishedsales.qty) + (extended-(extended * finishedsales.multiplier)) as discount,
				0 as rettotalqty,
				0 as retextended,
				totalqty,
				round(extended * finishedsales.multiplier,4) as extended
				From finishedsales left join products on products.productid=finishedsales.productid
				INNER JOIN vendor on vendor.vendorcode = Products.vendorcode
				left join vendor_products on finishedsales.productid=vendor_products.productid 
				where logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0  
				and vendor_products.defa=1
				Union All 
				select 
				vendor.description,
				vendor_products.averagenetcost,
				finishedsales.QtyReturned, finishedsales.productid,
				0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended 
				From finishedsales 
				join products on products.productid=finishedsales.productid 
				INNER JOIN vendor on vendor.vendorcode = Products.vendorcode
				left join vendor_products on finishedsales.productid=vendor_products.productid
				WHERE LOGDATE >= '".$date_from."' AND LOGDATE <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1) 
				as finishedsales 
				left join products on products.productid=finishedsales.productid 
				group by
				products.productid,products.productcode,products.description,reportuom,
				 finishedsales.description1,Products.vendorcode,finishedSales.av 
				order by  VENDOR
				";		


			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
			// return $sql.'<---';	
		}

		
	}
*/
// 	public function print_all(){
// 		$user = $this->session->userdata('user');
// 		$connected = $this->bdb = $this->load->database('srs_gag',TRUE);
// 		$connected = $this->bdb->initialize();
// 		if($connected){
// 			if($date_from == ""&&$date_to == "" )
// 				$sql='';
// 				$sql = "select * from finishedsales where d
// 				";		


// 			$query = $this->bdb->query($sql);	
// 			$res = $query->result();
// 			return $res;	
// 	}
// }	
// public function print_allvendor(){
	// 	$user = $this->session->userdata('user');
	// 	$connected = $this->bdb = $this->load->database('srs_gag',TRUE);
	// 	$connected = $this->bdb->initialize();
	// 	if($connected){
			
	// 		$sql='';
	// 		$sql = "select * from finishedsales
	// 			WHERE Description = ".$productname."
				
	// 			";

	// 		$query = $this->bdb->query($sql);	
	// 		$num = $query->num_rows();
	// 		$res = $query->result();
	// 		return $res;
	// 	}
	// }

	public function SalesSum($id=null, $date_from=null, $date_to=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database('srs_gag',TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			$sql = '';
			$sql ="Select SUM(extended) as Sales from finishedsales where DateTime BETWEEN '".$date_from."' AND '".$date_to."' ";

			$query = $this->bdb->query($sql);	

			$res = $query->result();
			return $res;	
		}


	}
	

	public function get_offtakeSvendor($date_from=null,$date_to=null,$description=null,$branch=null){


		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		$sql='';

		$sql = " 
		select dbo.FinishedSales.ProductID AS PRODUCTID,
		dbo.Products.Description AS DESCRIPTION, 
		dbo.Products.reportuom AS UOM, 
		dbo.Products.SellingArea AS SA, 
		dbo.Products.StockRoom AS WH,
		dbo.VENDOR_Products.totalcost as totalcost, 
		dbo.Products.SellingArea + dbo.Products.StockRoom as TOTAL_INVNTRY, 
		SUM(dbo.FinishedSales.TotalQty) AS OFFTAKE, 
		SUM(dbo.FinishedSales.TotalQty) AS OFFTAKE_CS ,
		((SUM(dbo.FinishedSales.TotalQty)/1)*7) as SEVEN_DAYS_OT, 
		SUM(dbo.Products.SellingArea + dbo.Products.StockRoom) as try,
		(SUM(dbo.FinishedSales.TotalQty)/(1*7)) as WEEKS, 
		0 as LANDED_COST, 
		0  as TOTAL_AMOUNT, 
		dbo.Products.StockRoom as TOTAL_OFFTAKE, 
		dbo.Products.vendorcode as VENDOR 
		FROM dbo.FinishedSales, dbo.Products, dbo.VENDOR_Products 
		WHERE dbo.FinishedSales.ProductID = dbo.Products.ProductID 
		AND dbo.Products.ProductID = dbo.VENDOR_Products.ProductID 
		AND (dbo.FinishedSales.DateTime 
		BETWEEN '".$date_from."' AND '".$date_to."') 
		AND (dbo.FinishedSales.[Return] = 0 and dbo.FinishedSales.[Voided] != 1) 
		AND (dbo.VENDOR_Products.defa = 1 ) AND dbo.Products.vendorcode = '".$description."'
		GROUP BY dbo.Products.vendorcode, dbo.FinishedSales.ProductID, 
		dbo.Products.ProductID, dbo.Products.Description, dbo.Products.StockRoom, 
		dbo.Products.SellingArea, dbo.Products.reportuom, dbo.VENDOR_Products.qty * dbo.VENDOR_Products.totalcost, 
		dbo.Products.SellingArea + dbo.Products.StockRoom,  dbo.Products.StockRoom,dbo.VENDOR_Products.totalcost ORDER BY products.description
			
		
		";	
		// select dbo.FinishedSales.ProductID AS PRODUCTID,
		// dbo.Products.Description AS DESCRIPTION, 
		// dbo.Products.reportuom AS UOM, 
		// dbo.Products.SellingArea AS SA, 
		// dbo.Products.StockRoom AS WH,
		// dbo.VENDOR_Products.totalcost as totalcost, 
		// dbo.Products.SellingArea + dbo.Products.StockRoom as TOTAL_INVNTRY, 
		// SUM(dbo.FinishedSales.TotalQty) AS OFFTAKE, 
		// SUM(dbo.FinishedSales.TotalQty) AS OFFTAKE_CS ,
		// ((SUM(dbo.FinishedSales.TotalQty)/1)*7) as SEVEN_DAYS_OT, 
		// SUM(dbo.Products.SellingArea + dbo.Products.StockRoom) as try,
		// (SUM(dbo.FinishedSales.TotalQty)/(1*7)) as WEEKS, 
		// 0 as LANDED_COST, 
		// 0  as TOTAL_AMOUNT, 
		// dbo.Products.StockRoom as TOTAL_OFFTAKE, 
		// dbo.Products.vendorcode as VENDOR 
		// FROM dbo.FinishedSales, dbo.Products, dbo.VENDOR_Products 
		// WHERE dbo.FinishedSales.ProductID = dbo.Products.ProductID 
		// AND dbo.Products.ProductID = dbo.VENDOR_Products.ProductID 
		// AND (dbo.FinishedSales.DateTime 
		// BETWEEN '".$date_from."' AND '".$date_to."') 
		// AND (dbo.FinishedSales.[Return] = 0) 
		// AND (dbo.VENDOR_Products.defa = 1) AND dbo.Products.vendorcode = '".$description."'
		// GROUP BY dbo.Products.vendorcode, dbo.FinishedSales.ProductID, 
		// dbo.Products.ProductID, dbo.Products.Description, dbo.Products.StockRoom, 
		// dbo.Products.SellingArea, dbo.Products.reportuom, dbo.VENDOR_Products.qty * dbo.VENDOR_Products.totalcost, 
		// dbo.Products.SellingArea + dbo.Products.StockRoom,  dbo.Products.StockRoom,dbo.VENDOR_Products.totalcost ORDER BY products.description
			


		$query = $this->bdb->query($sql);	

			$res = $query->result();
			return $res;	
		}

	}
	

	public function get_description($id = null){

		$user = $this->session->userdata('user');
		$this->dbb = $this->load->database('srs_gag',TRUE);
		$connected = $this->dbb->initialize();
		if($connected){
			$this->dbb->trans_start();
				$this->dbb->select('*');
				$this->dbb->from('vendor');
				if($id != null)
					$this->dbb->where('description',$id);
				$query = $this->dbb->get();
				$result = $query->result();
			$this->dbb->trans_complete();
			return $result;
		}else{
			return 'not connected';
		}


	}





	public function delete_v_list($user_id){
		$this->dbb = $this->load->database('default',TRUE);
		$connected = $this->dbb->initialize();

		if($connected)
		{
			$query = "DELETE FROM selected_vendor where user ='".$user_id."' ";
			$result = $this->dbb->query($query);
		}
	}

	public function get_v_list($user_id){

		$this->dbb = $this->load->database('default',TRUE);
		$connected = $this->dbb->initialize();

		if($connected)
		{
			$query = "SELECT * FROM selected_vendor where user ='".$user_id."' ";
			$result = $this->dbb->query($query);
			if(!$result)
			{
				return false;
			}
			else
			{
				return $result->result();
			}
		}


	}





	public function vendorcodelist(){
		 $user = $this->session->userdata('user');
            $user_id = $user['id'];

         $vendors  =   $this->get_v_list($user_id);
         $v = array();
         foreach ($vendors as $vs) {
         	# code...

         	$vr = "'".$vs->vendorcode."'";
         	array_push($v,$vr);
         }

         $ve = implode(",",$v);

         return $ve;


	}

	public function getAllSupp($branch,$vendor)
	{
		
		$this->dbb = $this->load->database($branch,TRUE);
		$connected = $this->dbb->initialize();

		if($connected)
		{
			$query = "SELECT  * FROM vendor  where vendorcode in (".$vendor.")";
			$result = $this->dbb->query($query);
			if(!$result)
			{
				return false;
			}
			else
			{
				return $result->result();
			}
		}
	}




	public function getAllCategories()
	{
		$this->dbb = $this->load->database('dtc',TRUE);
		$connected = $this->dbb->initialize();

		if($connected)
		{
			//$this->db->trans_start();
			$query = "SELECT * FROM LevelField1 ORDER BY Description ASC";
			$result = $this->dbb->query($query);
			if(!$result)
			{
				return false;
			}
			else
			{
				return $result->result();
			}
		}
	}
	public function OfftakeAVendor($id = null){

				$user = $this->session->userdata('user');
				$this->bdb= $this->load->database('srs_gag',TRUE);
				$connected = $this->bdb->initialize();
				if($connected){
					$this->bdb->trans_start();
						$this->bdb->select('*');
						$this->bdb->from('vendor');
						if($id != null)
							$this->bdb->where('daterange',$id);
						$query = $this->bdb->get();
						$result = $query->result();
					$this->bdb->trans_complete();
					return $result;
				}else{
					return 'not connected';
				}


			}
	
	//=========================================WAKOL=================================================

	public function get_Offtakeallvendor($date_from=null,$date_to=null,$branch=null){
		
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		$sql='';
		$sql = "select 
		dbo.FinishedSales.ProductID AS PRODUCTID,
		dbo.Products.Description AS DESCRIPTION, 
		dbo.Products.reportuom AS UOM, 
		dbo.Products.SellingArea AS SA, 
		dbo.Products.StockRoom AS WH,
		 dbo.vendor.description as Vendor,
		dbo.Products.SellingArea + dbo.Products.StockRoom as TOTAL_INVNTRY, 
		SUM(dbo.FinishedSales.TotalQty) AS OFFTAKE, 
		dbo.Products.reportuom AS OFFTAKE_CS ,
		dbo.Products.StockRoom as SEVEN_DAYS_OT, 
		dbo.Products.StockRoom as WEEKS, 
		dbo.VENDOR_Products.totalcost as LANDED_COST,
		dbo.Products.StockRoom as TOTAL_AMOUNT, 
		dbo.Products.StockRoom as TOTAL_OFFTAKE,
		dbo.Products.vendorcode as VENDOR1 
		FROM dbo.FinishedSales, dbo.Products, dbo.VENDOR_Products , dbo.vendor
		WHERE dbo.FinishedSales.ProductID = dbo.Products.ProductID 
		AND dbo.Products.ProductID = dbo.VENDOR_Products.ProductID and dbo.Products.vendorcode = dbo.vendor.vendorcode
		 AND (dbo.FinishedSales.DateTime 
		 BETWEEN '".$date_from."' AND '".$date_to."') 
			AND (dbo.FinishedSales.[Return] = 0 and dbo.FinishedSales.[Voided] != 1) 
		  AND (dbo.VENDOR_Products.defa = 1) 
		 GROUP BY dbo.Products.vendorcode, dbo.FinishedSales.ProductID, 
		dbo.Products.ProductID,vendor.description, dbo.Products.Description, dbo.Products.StockRoom, 
		dbo.Products.SellingArea, dbo.Products.reportuom, dbo.VENDOR_Products.qty * dbo.VENDOR_Products.totalcost, 
		dbo.Products.SellingArea + dbo.Products.StockRoom,  dbo.Products.StockRoom,dbo.VENDOR_Products.totalcost ORDER BY Vendor

		";

		$query = $this->bdb->query($sql);	

			$res = $query->result();
			return $res;	
		}
		
	}

	//end

	//==================================OVERSTOCK START ==========================================
	public function get_overstock($date_from=null,$date_to=null,$description=null,$branch){
		
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		$sql='';
				$sql = "select
				FinishedSales.ProductID AS PRODUCTID, 
				vendor.description AS VENDOR, 
				Products.Description AS DESCRIPTION, 
				Products.reportuom AS UOM, 
				Products.reportqty AS qty, 
				'' AS OVERSTOCK, 
				VENDOR_Products.totalcost AS UNIT_COST, 
				0 AS TOTAL_COST,
				 0 AS DAYS_TO_SELL, 
				SUM(FinishedSales.TotalQty) AS OFFTAKE, 
				Products.SellingArea + Products.StockRoom AS TOTAL_INVNTRY 
				FROM FinishedSales 
				INNER JOIN Products ON FinishedSales.ProductID = Products.ProductID 
				INNER JOIN VENDOR_Products ON Products.ProductID = VENDOR_Products.ProductID 
				INNER JOIN vendor ON Products.vendorcode = vendor.vendorcode 
				WHERE (FinishedSales.DateTime BETWEEN '".$date_from."' AND '".$date_to."') 
				AND Products.vendorcode = '".$description."' AND (FinishedSales.[Return] = 0 and FinishedSales.[Voided] != 1) AND (VENDOR_Products.defa = 1) 
				GROUP BY Products.vendorcode, FinishedSales.ProductID,VENDOR_Products.totalcost, Products.ProductID, Products.Description, Products.reportuom, VENDOR_Products.qty * VENDOR_Products.totalcost, Products.SellingArea + Products.StockRoom, Products.reportqty, vendor.description 
				ORDER BY VENDOR,Description

				";		


		$query = $this->bdb->query($sql);	

			$res = $query->result();
			return $res;	
		}
		
	}
	public function Overstock($id = null){

		$user = $this->session->userdata('user');
		$this->bdb = $this->load->database('srs_gag',TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			$this->bdb->trans_start();
				$this->bdb->select('*');
				$this->bdb->from('vendor');
				if($id != null)
					$this->bdb->where('description',$id);
				$query = $this->bdb->get();
				$result = $query->result();
			$this->bdb->trans_complete();
			return $result;
		}else{
			return 'not connected';
		}


	}
	public function get_overstockAll($date_from=null,$date_to=null,$branch){
		
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		
		$connected = $this->bdb->initialize();
		if($connected){
		$sql='';
				$sql = "select
						FinishedSales.ProductID AS PRODUCTID, 
						vendor.description AS VENDOR, 
						Products.Description AS DESCRIPTION, 
						Products.reportuom AS UOM, 
						Products.reportqty AS qty, 
						'' AS OVERSTOCK, 
						VENDOR_Products.totalcost AS UNIT_COST, 
						0 AS TOTAL_COST,
						 0 AS DAYS_TO_SELL, 
						SUM(FinishedSales.TotalQty) AS OFFTAKE, 
						Products.SellingArea + Products.StockRoom AS TOTAL_INVNTRY 
						FROM FinishedSales 
						INNER JOIN Products ON FinishedSales.ProductID = Products.ProductID 
						INNER JOIN VENDOR_Products ON Products.ProductID = VENDOR_Products.ProductID 
						INNER JOIN vendor ON Products.vendorcode = vendor.vendorcode 
						WHERE (FinishedSales.DateTime BETWEEN '".$date_from."' AND '".$date_to."') 
						AND (FinishedSales.[Return] = 0 and  FinishedSales.[Voided] != 1) AND (VENDOR_Products.defa = 1) 
						GROUP BY Products.vendorcode, FinishedSales.ProductID,VENDOR_Products.totalcost, Products.ProductID, Products.Description, Products.reportuom, VENDOR_Products.qty * VENDOR_Products.totalcost, Products.SellingArea + Products.StockRoom, Products.reportqty, vendor.description 
						ORDER BY VENDOR,Description
				";		


		$query = $this->bdb->query($sql);
			if($query){
				$res = $query->result();
					return $res;
			}	

				
		}
		
	}
	public function OverstockAll($id = null){

		$user = $this->session->userdata('user');
		$this->bdb = $this->load->database('srs_gag',TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			$this->bdb->trans_start();
				$this->bdb->select('*');
				$this->bdb->from('vendor');
				if($id != null)
					$this->bdb->where('description',$id);
				$query = $this->bdb->get();
				$result = $query->result();
			$this->bdb->trans_complete();
			return $result;
		}else{
			return 'not connected';
		}


	}

//***********
	public function get_cat_($branch,$date_from=null,$date_to=null,$description=null){
		
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected ){
			

			$sql = '';
			//query
				$sql = "select
						products.vendorcode as VENDOR,
						products.productcode as Product_Code,
						products.description as [Description],
						reportuom as UOM,
						sum(case when extended < 0 then  (0 - (totalqty/products.reportqty))  
							else (totalqty/products.reportqty) end) as Quantity,
						0 as Quantity_Percentage,
						 sum(extended) as Sales,
						0 as PSOS,
							case 
								when 
									sum(totalcost) = 0 then 0 
							else (sum(extended) - (sum(totalcost)))/sum(extended)*100 end  as GPM_Percent,
						sum(extended) - (sum(totalcost)) as Profit,
						0 as PSOP,
						sum(totalcost) as CostofSales,
						sum(extended) - (sum(extended) / 1.12) as mIncVAT,
						sum(charges) as mCharges,
						sum(discount) as mDiscounts,
						sum(retextended) as mReturns,
						sum(
									case 
										when extended < 0 
											then  (0 - (totalqty/products.reportqty)) 
									else (totalqty/products.reportqty) end)  / 563.554166666667 * 100 as mPercTotalQty,
						sum(extended) / 246360.4 * 100 as mPercExtend0ed 
						From (
									select vendor_products.averagenetcost,
												 finishedsales.QtyReturned,
						             finishedsales.productid,
							averageunitcost* case when [return]=1 then convert(money,0-totalqty) 
								else
						  totalqty end as TotalCost,
						(chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
						(allowance * finishedsales.qty) + (amountdiscounted * finishedsales.qty) + (extended-(extended * finishedsales.multiplier)) as discount,
						0 as rettotalqty,
						0 as retextended,
						totalqty,
						round(extended * finishedsales.multiplier,4) as extended
						From finishedsales left join
							products on products.productid=finishedsales.productid
						left join vendor_products on finishedsales.productid=vendor_products.productid  
						where products.LevelField1Code = '".$description."' and logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0   and vendor_products.defa=1
						Union All select vendor_products.averagenetcost, finishedsales.QtyReturned, finishedsales.productid,0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended From finishedsales left join products on products.productid=finishedsales.productid 
						left join vendor_products on finishedsales.productid=vendor_products.productid 
						WHERE PRODUCTS.LevelField1Code = '".$description."' AND LOGDATE >= '".$date_from."' AND LOGDATE <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1) as finishedsales left join products on products.productid=finishedsales.productid group by products.productid,products.productcode,products.description,reportuom, products.vendorcode order by  
						products.vendorcode 

						";		


		$query = $this->bdb->query($sql);
			if($query){
				$res = $query->result();
				return $res;
			}	
			
		}

	}


//***********

	public function get_cat($branch,$date_from=null,$date_to=null,$description=null){
		
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected ){
			

			$sql = '';
			//query
				$sql = "
						select
						finishedsales.description1 as VENDORS,
						finishedsales.ve as VENDOR,
						products.ProductID as PRODUCTID,
						products.productcode as Product_Code,
						products.description as Description,
						Products.vendorcode as VENDOR1,
						reportuom as UOM,
						products.reportqty as reportqty ,
						sum(case when extended < 0 then  (0 - (totalqty/NULLIF(products.reportqty,0)))  
						else (totalqty/NULLIF(products.reportqty,0) ) end) as Quantity,
						sum(case when extended < 0 then  (0 - (totalqty)) else (totalqty) end) as TQty,
						0 as Quantity_Percentage,
						sum(extended) as Sales,
						case when sum(totalcost) = 0 
						then 0 
						else (sum(extended) - (sum(totalcost)))/NULLIF(sum(extended),0)*100 end  as GPM_Percent,
						sum(extended) - (sum(totalcost)) as Profit,
						sum(totalcost) as CostofSales,
						sum(extended) - (sum(extended) / 1.12) as mIncVAT,
						finishedSales.av as v,
						finishedSales.tosrp,
						FinishedSales.UOM,
						case when finishedSales.PriceOverride = 1
							 then (((finishedSales.tosrp / finishedsales.Packing) * (sum(case when extended < 0 then  (0 - (totalqty)) else (totalqty) end))) - sum(extended))
							 else 0
						 end as [Override],
						 SUM(finishedSales.discount) as discounts,
						 finishedSales.Packing as packing,
						(finishedSales.tosrp / finishedsales.Packing) as trsp
						From 
						(select 
						vendor.description as description1,
						vendor.vendorcode as ve,
						vendor_products.averagenetcost as av, 
						finishedsales.QtyReturned,
						finishedsales.productid,
						(averageunitcost /
						case when finishedsales.Pvatable =1 OR finishedsales.Pvatable = 2 then 1.12  
										else 1 end 
						)* case when [return]=1 then convert(money,0-totalqty) 
						else totalqty end as TotalCost,
						(chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
						amountdiscounted  as discount,
						0 as rettotalqty,
						0 as retextended,
						totalqty,
						round( (extended * finishedsales.multiplier) / case when finishedsales.Pvatable = 1 then 1.12 else 1 end  ,4)  as extended, 
						prch.tosrp  as tosrp,
						finishedSales.PriceOverride as PriceOverride,finishedSales.UOM,finishedSales.Packing
						From finishedsales left join products on products.productid=finishedsales.productid
						INNER JOIN vendor on vendor.vendorcode = Products.vendorcode
						left join vendor_products on finishedsales.productid=vendor_products.productid
						left join (select
									DISTINCT
									cc.productid as  productid
									,MAX(bb.tosrp) as tosrp
									,bb.dateposted as dateposted
									,bb.UOM as  uom
									from
									(select productid as productid,MAX(dateposted) as dateposted from  pricechangehistory where CAST(dateposted AS DATE) <= '".$date_to."' group by productid) as cc
									INNER JOIN (select productid as productid,tosrp as tosrp ,dateposted as dateposted,PriceModecode as pricemode, UOM as UOM from  pricechangehistory) as bb
									ON cc.productid = bb.productid and cc.dateposted = bb.dateposted 
									and bb.pricemode = 'R'
									GROUP BY cc.productid,bb.dateposted,bb.UOM
									) as prch
							on  finishedsales.ProductID  = prch.productid and finishedsales.UOM = prch.uom
						where logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0 
						and vendor_products.defa=1  and products.LevelField1Code ='".$description."'
						Union All 
						select 
						vendor.description,
						vendor.vendorcode as ve,
						vendor_products.averagenetcost,
						finishedsales.QtyReturned, finishedsales.productid,
						0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended, 0  as tosrp , 0 as PriceOverride,finishedSales.uom,finishedSales.Packing
						From finishedsales 
						join products on products.productid=finishedsales.productid 
						INNER JOIN vendor on vendor.vendorcode = Products.vendorcode
						left join vendor_products on finishedsales.productid=vendor_products.productid
						WHERE logdate >= '".$date_from."' and logdate <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1  and products.LevelField1Code ='".$description."') 
						as finishedsales 
						left join products on products.productid=finishedsales.productid 
						left join (select
									DISTINCT
									cc.productid as  productid
									,MAX(bb.tosrp) as tosrp
									,bb.dateposted as dateposted
									,bb.UOM
									from
									(select productid as productid,MAX(dateposted) as dateposted from  pricechangehistory where CAST(dateposted AS DATE) <= '".$date_to."' group by productid) as cc
									INNER JOIN (select productid as productid,tosrp as tosrp ,dateposted as dateposted , PriceModecode as pricemode, UOM as UOM from  pricechangehistory) as bb
									ON cc.productid = bb.productid  and cc.dateposted = bb.dateposted 
									GROUP BY cc.productid,bb.dateposted,bb.UOM
									) as prch
							on  finishedsales.ProductID  = prch.productid and finishedSales.uom = prch.UOM 
						group by
						products.productid,products.productcode,products.description,reportuom,
						 finishedsales.description1,Products.vendorcode,finishedSales.av,finishedsales.tosrp,finishedSales.PriceOverride,finishedSales.uom,reportqty,finishedSales.Packing,finishedsales.ve
						 HAVING sum(extended) <> 0
						order by  VENDOR

		
					";		


		$query = $this->bdb->query($sql);
			if($query){
				$res = $query->result();
				return $res;
			}	
			
		}

	}
	public function get_catpercentage($branch,$date_from=null,$date_to=null,$description=null){
		
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected ){
			

			$sql = '';
			//query
				$sql = "
						SELECT
						sum(b.Sales) as Sales
						from
						(
						select
						 sum(extended) as Sales ,
						0 as PSOS,
							case 
								when 
									sum(totalcost) = 0 then 0 
							else (sum(extended) - (sum(totalcost)))/sum(extended)*100 end  as GPM_Percent,
						sum(extended) - (sum(totalcost)) as Profit,
						0 as PSOP,
						sum(totalcost) as CostofSales,	
						sum(extended) - (sum(extended) / 1.12) as mIncVAT,
						sum(charges) as mCharges,
						sum(discount) as mDiscounts,
						sum(retextended) as mReturns,

						sum(
									case 
										when extended < 0 
											then  (0 - (totalqty/products.reportqty)) 
									else (totalqty/products.reportqty) end)  / 563.554166666667 * 100 as mPercTotalQty,
						sum(extended) / 246360.4 * 100 as mPercExtend0ed 

						From (
									select 
								vendor_products.averagenetcost,
							 finishedsales.QtyReturned,
							 finishedsales.productid,
							(averageunitcost /
							case when finishedsales.Pvatable =1 OR finishedsales.Pvatable = 2 then 1.12  
							else 1 end 
							)* case when [return]=1 then convert(money,0-totalqty) 
							else totalqty end as TotalCost,

						(chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
						(allowance * finishedsales.qty) + (amountdiscounted * finishedsales.qty) + (extended-(extended * finishedsales.multiplier)) as discount,
						0 as rettotalqty,
						0 as retextended,
						totalqty,
						round( (extended * finishedsales.multiplier) / case when finishedsales.Pvatable = 1 then 1.12 else 1 end  ,4)  as extended 
						From finishedsales left join
							products on products.productid=finishedsales.productid
						left join vendor_products on finishedsales.productid=vendor_products.productid  
						where products.LevelField1Code = '".$description."' and logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0   and vendor_products.defa=1
						Union All select vendor_products.averagenetcost, finishedsales.QtyReturned, finishedsales.productid,0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended From finishedsales left join products on products.productid=finishedsales.productid 
						left join vendor_products on finishedsales.productid=vendor_products.productid 
						WHERE PRODUCTS.LevelField1Code = '".$description."' and logdate >= '".$date_from."' and logdate <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1) 
						as finishedsales left join products on products.productid=finishedsales.productid group by products.productid,products.productcode,products.description,reportuom, products.vendorcode) as b

						";		


		$query = $this->bdb->query($sql);
	 		if($query){
	 			$res   = $query->row();
	 			return $res->Sales;
	 		}else{
	 			return  0;
	 		}

	 		
	 	}
	 }

	 public function get_catpercentage1($branch,$date_from=null,$date_to=null,$description=null){
		
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected ){
			

			$sql = '';
			//query
				$sql = "
						SELECT
						sum(b.Profit) as Profit
						from
						(
						select
						 sum(extended) as Sales ,
						0 as PSOS,
							case 
								when 
									sum(totalcost) = 0 then 0 
							else (sum(extended) - (sum(totalcost)))/sum(extended)*100 end  as GPM_Percent,
						sum(extended) - (sum(totalcost)) as Profit,
						0 as PSOP,
						sum(totalcost) as CostofSales,	
						sum(extended) - (sum(extended) / 1.12) as mIncVAT,
						sum(charges) as mCharges,
						sum(discount) as mDiscounts,
						sum(retextended) as mReturns,

						sum(
									case 
										when extended < 0 
											then  (0 - (totalqty/products.reportqty)) 
									else (totalqty/products.reportqty) end)  / 563.554166666667 * 100 as mPercTotalQty,
						sum(extended) / 246360.4 * 100 as mPercExtend0ed 

						From (
									select 
								vendor_products.averagenetcost,
							 finishedsales.QtyReturned,
							 finishedsales.productid,
							averageunitcost* case when [return]=1 then convert(money,0-totalqty) 
								else
							totalqty end as TotalCost,
						(chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
						(allowance * finishedsales.qty) + (amountdiscounted * finishedsales.qty) + (extended-(extended * finishedsales.multiplier)) as discount,
						0 as rettotalqty,
						0 as retextended,
						totalqty,
						round( (extended * finishedsales.multiplier) / case when finishedsales.Pvatable = 1 then 1.12 else 1 end  ,4)  as extended 
						From finishedsales left join
							products on products.productid=finishedsales.productid
						left join vendor_products on finishedsales.productid=vendor_products.productid  
						where products.LevelField1Code = '".$description."' and logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0   and vendor_products.defa=1
						Union All select vendor_products.averagenetcost, finishedsales.QtyReturned, finishedsales.productid,0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended From finishedsales left join products on products.productid=finishedsales.productid 
						left join vendor_products on finishedsales.productid=vendor_products.productid 
						WHERE PRODUCTS.LevelField1Code = '".$description."' and logdate >= '".$date_from."' and logdate <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1) 
						as finishedsales left join products on products.productid=finishedsales.productid group by products.productid,products.productcode,products.description,reportuom, products.vendorcode) as b

						";		


		$query = $this->bdb->query($sql);
	 		if($query){
	 			$res   = $query->row();
	 			return $res->Profit;
	 		}else{
	 			return  0;
	 		}

	 		
	 	}
	 }
	  public function get_superSales($branch,$date_from=null,$date_to=null,$description=null){
		
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected ){
			

			$sql = '';
			//query
				$sql = "
						SELECT

						sum(a.Sales) as SSales
						from
						(select
						products.vendorcode as VENDOR,
						products.productcode as Product_Code,
						products.description as [Description],
						reportuom as UOM,
						sum(case when extended < 0 then  (0 - (totalqty/products.reportqty))  
							else (totalqty/products.reportqty) end) as Quantity,
						0 as Quantity_Percentage,
						 sum(extended) as Sales,
						0 as PSOS,
							case 
								when 
									sum(totalcost) = 0 then 0 
							else (sum(extended) - (sum(totalcost)))/sum(extended)*100 end  as GPM_Percent,
						sum(extended) - (sum(totalcost)) as Profit,
						0 as PSOP,
						sum(totalcost) as CostofSales,
						sum(extended) - (sum(extended) / 1.12) as mIncVAT,
						sum(charges) as mCharges,
						sum(discount) as mDiscounts,
						sum(retextended) as mReturns,
						sum(
									case 
										when extended < 0 
											then  (0 - (totalqty/products.reportqty)) 
									else (totalqty/products.reportqty) end)  / 563.554166666667 * 100 as mPercTotalQty,
						sum(extended) / 246360.4 * 100 as mPercExtend0ed 
						From (
									select vendor_products.averagenetcost,
												 finishedsales.QtyReturned,
						             finishedsales.productid,
							averageunitcost* case when [return]=1 then convert(money,0-totalqty) 
								else
						  totalqty end as TotalCost,
						(chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
						(allowance * finishedsales.qty) + (amountdiscounted * finishedsales.qty) + (extended-(extended * finishedsales.multiplier)) as discount,
						0 as rettotalqty,
						0 as retextended,
						totalqty,
						round(extended * finishedsales.multiplier,4) as extended
						From finishedsales left join
							products on products.productid=finishedsales.productid
						left join vendor_products on finishedsales.productid=vendor_products.productid  
						and logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0   and vendor_products.defa=1
						Union All select vendor_products.averagenetcost, finishedsales.QtyReturned, finishedsales.productid,0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended From finishedsales left join products on products.productid=finishedsales.productid 
						left join vendor_products on finishedsales.productid=vendor_products.productid 
						AND LOGDATE >= '".$date_from."' AND LOGDATE <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1) as finishedsales left join products on products.productid=finishedsales.productid group by products.productid,products.productcode,products.description,reportuom, products.vendorcode) as a

						";		


		$query = $this->bdb->query($sql);
	 		if($query){
	 			$res   = $query->row();
	 			return $res->SSales;
	 		}else{
	 			return  0;
	 		}

	 		
	 	}
	 }
	 public function get_superProfit($branch,$date_from=null,$date_to=null,$description=null){
		
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected ){
			

			$sql = '';
			//query
				$sql = "
						SELECT

						sum(a.Profit) as PProfit
						from
						(select
						products.vendorcode as VENDOR,
						products.productcode as Product_Code,
						products.description as [Description],
						reportuom as UOM,
						sum(case when extended < 0 then  (0 - (totalqty/products.reportqty))  
							else (totalqty/products.reportqty) end) as Quantity,
						0 as Quantity_Percentage,
						 sum(extended) as Sales,
						0 as PSOS,
							case 
								when 
									sum(totalcost) = 0 then 0 
							else (sum(extended) - (sum(totalcost)))/sum(extended)*100 end  as GPM_Percent,
						sum(extended) - (sum(totalcost)) as Profit,
						0 as PSOP,
						sum(totalcost) as CostofSales,
						sum(extended) - (sum(extended) / 1.12) as mIncVAT,
						sum(charges) as mCharges,
						sum(discount) as mDiscounts,
						sum(retextended) as mReturns,
						sum(
									case 
										when extended < 0 
											then  (0 - (totalqty/products.reportqty)) 
									else (totalqty/products.reportqty) end)  / 563.554166666667 * 100 as mPercTotalQty,
						sum(extended) / 246360.4 * 100 as mPercExtend0ed 
						From (
									select vendor_products.averagenetcost,
												 finishedsales.QtyReturned,
						             finishedsales.productid,
							averageunitcost* case when [return]=1 then convert(money,0-totalqty) 
								else
						  totalqty end as TotalCost,
						(chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
						(allowance * finishedsales.qty) + (amountdiscounted * finishedsales.qty) + (extended-(extended * finishedsales.multiplier)) as discount,
						0 as rettotalqty,
						0 as retextended,
						totalqty,
						round(extended * finishedsales.multiplier,4) as extended
						From finishedsales left join
							products on products.productid=finishedsales.productid
						left join vendor_products on finishedsales.productid=vendor_products.productid  
						and logdate >= '".$date_from."' and logdate <= '".$date_to."' and voided = 0   and vendor_products.defa=1
						Union All select vendor_products.averagenetcost, finishedsales.QtyReturned, finishedsales.productid,0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended From finishedsales left join products on products.productid=finishedsales.productid 
						left join vendor_products on finishedsales.productid=vendor_products.productid 
						AND LOGDATE >= '".$date_from."' AND LOGDATE <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1) as finishedsales left join products on products.productid=finishedsales.productid group by products.productid,products.productcode,products.description,reportuom, products.vendorcode) as a

						";		


		$query = $this->bdb->query($sql);
	 		if($query){
	 			$res   = $query->row();
	 			return $res->PProfit;
	 		}else{
	 			return  0;
	 		}

	 		
	 	}
	 }
	public function Category($id = null){

		$user = $this->session->userdata('user');
		$this->bdb = $this->load->database('srsnov',TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			$this->bdb->trans_start();
				$this->bdb->select('*');
				$this->bdb->from('vendor');
				if($id != null)
					$this->bdb->where('description',$id);
				$query = $this->bdb->get();
				$result = $query->result();
			$this->bdb->trans_complete();
			return $result;
		}else{
			return 'not connected';
		}


	}
	public function total($date_from = null,$date_to = null , $description = null) {

		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database('srs_gag',TRUE);
		$connected = $this->bdb->initialize();
		if($connected){

			$sql = '';
			//query
				$sql = "select sum(qty) from vendor_products";		


		$query = $this->bdb->query($sql);	

			$res = $query->result();
			return $res;	
			
		}
	}
	// public function SalesTotal($branch,$description=null,$date_from=null,$date_to=null,$Sales=null) {

	// 	$user = $this->session->userdata('user');
	// 	$connected = $this->bdb = $this->load->database($branch,TRUE);
	// 	$connected = $this->bdb->initialize();
	// 	if($connected){

	// 		$sql = '';
	// 		//query
	// 			$sql = "select
	// 					products.vendorcode as VENDOR,
	// 					products.productcode as Product_Code,
	// 					products.description as [Description],
	// 					reportuom as UOM,
	// 					sum(case when extended < 0 then  (0 - (totalqty/products.reportqty))  
	// 					else (totalqty/products.reportqty) end) as Quantity,
	// 					sum(extended) as Sales,
	// 					case 
	// 					when 
	// 					sum(totalcost) = 0 then 0 
	// 					else (sum(extended) - (sum(totalcost)))/sum(extended)*100 end  as GPM_Percent,
	// 					sum(extended) - (sum(totalcost)) as Profit,
	// 					sum(
	// 					case 
	// 					when extended < 0 
	// 					then  (0 - (totalqty/products.reportqty)) 
	// 					else (totalqty/products.reportqty) end)  / 563.554166666667 * 100 as mPercTotalQty,
	// 					sum(extended) / 246360.4 * 100 as mPercExtend0ed 
	// 					From (
	// 					select vendor_products.averagenetcost,
	// 					finishedsales.QtyReturned,
	// 					finishedsales.productid,
	// 					(averageunitcost / case when finishedsales.Pvatable = 2 then 1.12 else 1 end) * case when [return]=1 then convert(money,0-totalqty) 
	// 					else
	// 					totalqty end as TotalCost,
	// 					(chargeallowance * finishedsales.qty) + (chargeamountdiscounted * finishedsales.qty) as charges,
	// 					(allowance * finishedsales.qty) + (amountdiscounted * finishedsales.qty) + (extended-(extended * finishedsales.multiplier)) as discount,
	// 					0 as rettotalqty,
	// 					0 as retextended,
	// 					totalqty,
	// 					round(extended * finishedsales.multiplier,4) as extended
	// 					From finishedsales left join
	// 					products on products.productid=finishedsales.productid
	// 					left join vendor_products on finishedsales.productid=vendor_products.productid  
	// 					where products.LevelField1Code = '".$description."' AND LOGDATE >= '".$date_from."' AND LOGDATE <= '".$date_to."' and voided = 0   and vendor_products.defa=1
	// 					Union All select vendor_products.averagenetcost, finishedsales.QtyReturned, finishedsales.productid,0 as TotalCost,0 as charges,0 as discount,totalqty as rettotalqty ,abs(round(extended,4)) as retextended,0 as totalqty, 0 as extended From finishedsales left join products on products.productid=finishedsales.productid 
	// 					left join vendor_products on finishedsales.productid=vendor_products.productid 
	// 					WHERE PRODUCTS.LevelField1Code = '".$description."' AND LOGDATE >= '".$date_from."' AND LOGDATE <= '".$date_to."' AND VOIDED = 0   AND [RETURN] = 1)  as finishedsales left join products on products.productid=finishedsales.productid group by products.productid,products.productcode,products.description,reportuom, products.vendorcode order by  
	// 					products.vendorcode";		


	// 	$query = $this->bdb->query($sql);	

	// 	if($query){

	// 		$res = $query->row();

	// 		return $res;



	// 	}
			
			
	// 	}
	// }

	// public function Getname($code=null){
	// 	$this->bdb = $this->load->database('dtc',TRUE);
	// 		$connected = $this->bdb->initialize();
	// 		if($connected){
	// 			$sql = "SELECT Description FROM LevelField1 WHERE LevelField1Code = ".$code. "";
	// 			$query = $this->bdb->query($sql);
	// 			if($query){
	// 				$res = $query->row();
	// 				return $res->Description;
	// 			}else{
	// 				return 'error';
	// 			}
			

	// 		}

	// }
	public function productlisting($price=null,$description = null,$branch=null,$chckbox=null,$chckbox1=null,$chckbox2=null){
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			if($chckbox == 1 )
				$sql="";
		$sql=("select 
				PRODUCTCODE, 
				BARCODE, 
				DESCRIPTION, 
				pricemodecode as PRICEMODE, 
				srpuom as UOM, 
				SRP 
				From products 
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,
						markup,
						pricemodecode 
				from pos_products 
				where pricemodecode = '".$price."') as pos_products 
				on pos_products.productid = products.productid 
				left join 
					(select 
						defa,
						productid,
						uom as costuom,
						totalcost,
						averagecost,
						cost,
						vendorcode,
						discount1,
						discount2,
						discount3 from vendor_products ) as vendor_products 
				on vendor_products.productid = products.productid 
				where vendor_products.vendorcode = '".$description."' and pricemodecode = '".$price."' and  inactive=0  
				order by description");
			

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
		// if($connected){
		// 	if($chckbox == 1 && $chckbox1 == 0 && $chckbox2 == 0)
		// 	$query = $this->bdb->query("");
		// 	else if($chckbox1 == 1 && $chckbox == 0 && $chckbox2 == 0)
		// 	$query = $this->bdb->query("");
			
		// 	else 
		// 	$query = $this->bdb->query("");
			
		// 	$res = $query->result();
		// 	return $res;
				}
	}
	public function productlistinginact_det($priceinac=null,$costdesinac=null,$branch,$costchckboxinac=null,$costchckboxinac1=null,$costchckboxinac2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
			if($costchckboxinac1 == 1)
				$sql="";
		$sql=("select 
				PRODUCTCODE, 
				BARCODE, 
				DESCRIPTION, 
				pricemodecode as PRICEMODE, 
				srpuom as UOM, 
				SRP 
				From products 
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,
						markup, 
						pricemodecode from pos_products 
				where pricemodecode = '".$priceinac."') as pos_products 
				on pos_products.productid = products.productid 
				left join 
					(select 
						defa,
						productid,
						uom as costuom,
						totalcost,
						averagecost,
						cost,
						vendorcode,
						discount1,
						discount2,
						discount3 from vendor_products ) as vendor_products 
				on vendor_products.productid = products.productid 
				where vendor_products.vendorcode = '".$costdesinac."' and pricemodecode = '".$priceinac."' and  inactive=1  
				order by description");
			

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function productlistingActinact_det($priceinacact=null,$costdesinacact=null,$branch,$costchckboxinacact=null,$costchckboxinacact1=null,$costchckboxinacact2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){
			if($costchckboxinacact2 == 1)
				$sql="";
				$sql=("select 
				PRODUCTCODE, 
				BARCODE, 
				DESCRIPTION, 
				pricemodecode as PRICEMODE, 
				srpuom as UOM, 
				SRP 
				From products 
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,
						markup, 
						pricemodecode from pos_products 
				where pricemodecode = '".$priceinacact."') as pos_products 
				on pos_products.productid = products.productid 
				left join 
					(select 
						defa,
						productid,
						uom as costuom,
						totalcost,
						averagecost,
						cost,
						vendorcode,
						discount1,
						discount2,
						discount3 from vendor_products ) as vendor_products 
				on vendor_products.productid = products.productid 
				where vendor_products.vendorcode = '".$costdesinacact."' and pricemodecode = '".$priceinacact."' 
				order by description");
			

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}

	public function productlistingcost_det($pricecost=null,$costdes=null,$branch,$costchckbox=null,$costchckbox1=null,$costchckbox2=null,$cost=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		// if($connected){
	// 		if($yearch == 1 && $yearch1 == 0 && $yearch2 == 0)
	// 		$query = $this->bdb->query("");
	// 			else if($yearch == 0 && $yearch1 == 1 && $yearch2 == 0)
	// 			$query = $this->bdb->query("");
	// 			else if($yearch == 0 && $yearch1 == 0 && $yearch2 == 1)
	// 			$query = $this->bdb->query("");
	// 			else
	// 			$query = $this->bdb->query("");

	// 		$res = $query->result();
	// 		return $res;
	// 			}
	// }
			if($connected){
			// if($costchckbox1 == 0 && $costchckbox == 1 && $costchckbox2 == 0 && $cost == 1)
				$sql="";
				$sql=("select 
				productcode as PRODUCTCODE, 
				barcode AS BARCODE, 
				description AS DESCRIPTION, 
				pricemodecode AS PRICEMODE, 
				costuom AS UOM1, 
				cost AS COST, 
				str(averagecost,5,5) AS AVECOST, 
				str(discount1,5,5) AS DISCOUNT1, 
				str(discount2,5,5) AS DISCOUNT2, 
				str(discount3,5,5) AS DISCOUNT3, 
				str(totalcost,5,5) AS NET, 
				str((srp-(totalcost*qty))/nullif(srp, 0),4,4) as MARKUP, 
				srpuom AS UOM,
				qty as QTY, 
				srp AS SRP 
				From products 
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,
						markup,
						qty, 
						pricemodecode from pos_products where pricemodecode = '".$pricecost."') as pos_products 
				on pos_products.productid = products.productid 
				left join 
					(select 
						defa,
						productid,
						uom as costuom,
						totalcost,
						averagecost,
						cost,
						vendorcode,
						discount1,
						discount2,
						discount3 from vendor_products ) as vendor_products 
				on vendor_products.productid = products.productid 
				where vendor_products.vendorcode = '".$costdes."' and pricemodecode = '".$pricecost."' and  inactive=0  
				order by description");
			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function productdepartlisting($price=null,$dep=null,$branch,$ch=null,$ch1=null,$ch2=null){
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			if($ch == 1)
				$sql="";
		$sql=("select 
				PRODUCTCODE, 
				BARCODE, 
				DESCRIPTION, 
				pricemodecode as PRICEMODE, 
				srpuom as UOM, 
				SRP 
				From products 
				left join 
				(select 
				productid,
				barcode,
				uom as srpuom,
				srp,
				markup, 
				pricemodecode 
				from pos_products 
				where pricemodecode = '".$price."') as pos_products 
				on pos_products.productid = products.productid 
				left join 
				(select 
				defa,
				productid,
				uom as costuom,
				totalcost,
				averagecost,
				cost,
				vendorcode,
				discount1,
				discount2,
				discount3 
				from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
				where products.fieldacode = '".$dep."' and  defa = 1 and pricemodecode = '".$price."' and  inactive=0  
				order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function productdepartlistinginactive($price=null,$dep=null,$branch,$ch=null,$ch1=null,$ch2=null){
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		$sql="";
		$sql=("select 
			PRODUCTCODE, 
			BARCODE, 
			DESCRIPTION, 
			pricemodecode as PRICEMODE, 
			srpuom as UOM, 
			SRP 
			From products 
			left join 
				(select 
					productid,
					barcode,
					uom as srpuom,
					srp,
					markup, 
					pricemodecode from pos_products 
					where pricemodecode = '".$price."') as pos_products on pos_products.productid = products.productid 
			left join 
				(select 
					defa,
					productid,
					uom as costuom,
					totalcost,
					averagecost,
					cost,
					vendorcode,
					discount1,
					discount2,
					discount3 
					from vendor_products ) 
			as vendor_products on vendor_products.productid = products.productid 
			where products.fieldacode = '".$dep."' and  defa = 1 and pricemodecode = '".$price."' and  inactive=1  
			order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function productdepartlistingActinactive($price=null,$dep=null,$branch,$ch=null,$ch1=null,$ch2=null){
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		$sql="";
		$sql=("select 
			PRODUCTCODE, 
			BARCODE, 
			DESCRIPTION, 
			pricemodecode as PRICEMODE, 
			srpuom as UOM, 
			SRP 
			From products 
			left join 
				(select 
					productid,
					barcode,
					uom as srpuom,
					srp,
					markup, 
					pricemodecode from pos_products 
					where pricemodecode = '".$price."') as pos_products on pos_products.productid = products.productid 
			left join 
				(select 
					defa,
					productid,
					uom as costuom,
					totalcost,
					averagecost,
					cost,
					vendorcode,
					discount1,
					discount2,
					discount3 from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
			where products.fieldacode = '".$dep."' and  defa = 1 and pricemodecode = '".$price."' 

			order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function productlistingcost_depart($deptcost=null,$deptpricecost=null,$deptcostdes=null,$branch=null,$deptcostchckbox=null,$deptcostchckbox1=null,$deptcostchckbox2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($deptcostchckbox == 1 && $deptcost == 1)
		$sql="";
		$sql=("select 
			productcode as PRODUCTCODE, 
			barcode AS BARCODE, 
			description AS DESCRIPTION, 
			pricemodecode AS PRICEMODE, 
			costuom AS UOM1, 
			cost AS COST, 
			str(averagecost,5,5) AS AVECOST, 
			str(discount1,5,5) AS DISCOUNT1, 
			str(discount2,5,5) AS DISCOUNT2, 
			str(discount3,5,5) AS DISCOUNT3, 
			str(totalcost,5,5) AS NET, 
			str((srp-totalcost)/nullif(srp, 0),4,4) as MARKUP, 
			srpuom AS UOM, 
			srp AS SRP 
			From products 
			left join 
				(select 
					productid,
					barcode,
					uom as srpuom,
					srp,
					markup, 
					pricemodecode 
			from pos_products 
			where pricemodecode = '".$deptpricecost."') as pos_products on pos_products.productid = products.productid 
			left join 
				(select 
					defa,
					productid,
					uom as costuom,
					totalcost,
					averagecost,
					cost,
					vendorcode,
					discount1,
					discount2,
					discount3 
			from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
			where products.fieldacode = '".$deptcostdes."' and  defa = 1 and pricemodecode = '".$deptpricecost."' and  inactive=0  
			order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function productbrandlisting($brandprice=null,$brand = null,$branch,$brandch=null,$brandch1=null,$brandch2=null){
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			if($brandch == 1)
				$sql="";
				$sql=("select 
				PRODUCTCODE, 
				BARCODE, 
				DESCRIPTION, 
				pricemodecode as PRICEMODE, 
				srpuom as UOM, 
				SRP 
				From products 
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,
						markup, 
						pricemodecode 
				from pos_products 
				where pricemodecode = '".$brandprice."') as pos_products on pos_products.productid = products.productid 
				left join 
					(select 
						defa,
						productid,
						uom as costuom,
						totalcost,
						averagecost,
						cost,
						vendorcode,
						discount1,
						discount2,
						discount3 
				from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
				where products.fieldBcode = '".$brand ."' and  defa = 1 and pricemodecode = '".$brandprice."' and  inactive=0  
				order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function productinactivebrandlisting($brandinprice=null,$brandin = null,$branch,$brandinch=null,$brandinch1=null,$brandinch2=null){
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			if($brandinch1 == 1)
				$sql="";
				$sql=("select 
					PRODUCTCODE, 
					BARCODE, 
					DESCRIPTION, 
					pricemodecode as PRICEMODE, 
					srpuom as UOM, 
					SRP 
					From products 
					left join 
						(select 
							productid,
							barcode,
							uom as srpuom,
							srp,markup, 
							pricemodecode 
					from pos_products 
					where pricemodecode = '".$brandinprice."') as pos_products on pos_products.productid = products.productid 
					left join 
						(select 
							defa,
							productid,
							uom as costuom,
							totalcost,
							averagecost,
							cost,
							vendorcode,
							discount1,
							discount2,
							discount3 
					from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
					where products.fieldBcode = '".$brandin."' and  defa = 1 and pricemodecode = '".$brandinprice."' and  inactive=1  
					order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function ActiveInactiveBrand($brandainprice=null,$brandain = null,$branch,$brandainch=null,$brandainch1=null,$brandainch2=null){
		 $user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			if($brandainch2 == 1)
				$sql="";
				$sql=("select 
					PRODUCTCODE, 
					BARCODE, 
					DESCRIPTION, 
					pricemodecode as PRICEMODE, 
					srpuom as UOM, 
					SRP From products 
					left join 
						(select 
							productid,
							barcode,
							uom as srpuom,
							srp,
							markup, 
							pricemodecode 
					from pos_products 
					where pricemodecode = '".$brandainprice."') as pos_products on pos_products.productid = products.productid 
					left join 
						(select 
							defa,
							productid,
							uom as costuom,
							totalcost,
							averagecost,
							cost,
							vendorcode,
							discount1,
							discount2,
							discount3 
					from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
					where products.fieldBcode = '".$brandain."' and  defa = 1 and pricemodecode = '".$brandainprice."' 
					order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}

		public function ProductListingbrandcost($brandprice=null,$branddesc=null,$branch,$brandcheck=null,$brandcheck1=null,$brandcheck=null,$brandcost=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($brandcheck == 1 && $brandcost == 1)
		$sql="";
		$sql=("select 
				productcode as PRODUCTCODE, 
				barcode AS BARCODE, 
				description AS DESCRIPTION, 
				pricemodecode AS PRICEMODE, 
				costuom AS UOM1, 
				cost AS COST, 
				str(averagecost,5,5) AS AVECOST, 
				str(discount1,5,5) AS DISCOUNT1, 
				str(discount2,5,5) AS DISCOUNT2, 
				str(discount3,5,5) AS DISCOUNT3, 
				str(totalcost,5,5) AS NET, 
				str((srp-totalcost)/nullif(srp, 0),4,4) as MARKUP, 
				srpuom AS UOM,
				srp AS SRP 
				From products
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,markup, 
						pricemodecode 
						from pos_products where pricemodecode = '".$brandprice."') as pos_products on pos_products.productid = products.productid 
				left join 
					(select 
						defa,
						productid,
						uom as costuom,
						totalcost,
						averagecost,
						cost,
						vendorcode,
						discount1,
						discount2,
						discount3 
						from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
						where products.fieldBcode = '".$branddesc."' and  defa = 1 and pricemodecode = '".$brandprice."' and  inactive=0  order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
		public function productclasslisting($classprice=null,$class=null,$branch,$classch=null,$classch1=null,$classch2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($classch == 1 )
		$sql="";
		$sql=("select 
				PRODUCTCODE, 
				BARCODE, 
				DESCRIPTION, 
				pricemodecode as PRICEMODE, 
				srpuom as UOM, 
				SRP 
				From products 
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,markup, 
						pricemodecode 
				from pos_products 
				where pricemodecode = '".$classprice."') as pos_products on pos_products.productid = products.productid 
				left join 
					(select 
						defa,
						productid,
						uom as costuom,
						totalcost,
						averagecost,
						cost,
						vendorcode,
						discount1,
						discount2,
						discount3 
				from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
				where products.fieldCcode = '".$class."' and  defa = 1 and pricemodecode = '".$classprice."' and  inactive=0  
				order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function classinactive($classpriceinactive=null,$classinactive=null,$branch,$classchinactive=null,$classchinactive1=null,$classchinactive2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($classchinactive1 == 1 )
		$sql="";
		$sql=("select 
			PRODUCTCODE, 
			BARCODE, 
			DESCRIPTION, 
			pricemodecode as PRICEMODE, 
			srpuom as UOM, 
			SRP 
			From products 
			left join 
				(select 
					productid,
					barcode,
					uom as srpuom,
					srp,
					markup, 
					pricemodecode 
					from pos_products 
			where pricemodecode = '".$classpriceinactive."') as pos_products on pos_products.productid = products.productid 
			left join 
				(select 
					defa,
					productid,
					uom as costuom,
					totalcost,
					averagecost,
					cost,
					vendorcode,
					discount1,
					discount2,
					discount3 
			from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
			where products.fieldCcode = '".$classinactive."' and  defa = 1 and pricemodecode = '".$classpriceinactive."' and  inactive=1  
			order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function classactinactive($classpriceactinactive=null,$classactinactive=null,$branch,$classchactinactive=null,$classchactinactive1=null,$classchactinactive2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($classchactinactive == 1 )
		$sql="";
		$sql=("select 
					PRODUCTCODE, 
					BARCODE, 
					DESCRIPTION, 
					pricemodecode as PRICEMODE, 
					srpuom as UOM, 
					SRP 
					From products 
					left join 
						(select 
							productid,
							barcode,
							uom as srpuom,
							srp,
							markup, 
							pricemodecode 
					from pos_products 
					where pricemodecode = '".$classpriceactinactive."') as pos_products on pos_products.productid = products.productid 
					left join 
						(select 
							defa,
							productid,
							uom as costuom,
							totalcost,
							averagecost,
							cost,
							vendorcode,
							discount1,
							discount2,
							discount3 
					from vendor_products ) as vendor_products on vendor_products.productid = products.productid
					where products.fieldCcode = '".$classactinactive."' and  defa = 1 and pricemodecode = '".$classpriceactinactive."' 
					order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	

	public function productclasslistingcost($cclassprice=null,$cclass=null,$branch,$cclassch=null,$cclassch1=null,$cclassch2=null,$cclasscost=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($cclassch == 1 && $cclasscost == 1)
		$sql="";
		$sql=("select 
				productcode as PRODUCTCODE, 
				barcode AS BARCODE, 
				description AS DESCRIPTION, 
				pricemodecode AS PRICEMODE, 
				costuom AS UOM1, 
				cost AS COST, 
				str(averagecost,5,5) AS AVECOST, 
				str(discount1,5,5) AS DISCOUNT1, 
				str(discount2,5,5) AS DISCOUNT2, 
				str(discount3,5,5) AS DISCOUNT3, 
				str(totalcost,5,5) AS NET, 
				str((srp-totalcost)/nullif(srp, 0),4,4) as MARKUP, 
				srpuom AS UOM, 
				srp AS SRP 
				From products 
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,
						markup, 
						pricemodecode 
						from pos_products where pricemodecode = '".$cclassprice."') as pos_products on pos_products.productid = products.productid 
				left join 
					(select 
						defa,
						productid,
						uom as costuom,
						totalcost,
						averagecost,
						cost,
						vendorcode,
						discount1,
						discount2,
						discount3 from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
						where products.fieldCcode = '".$cclass."' and  defa = 1 and pricemodecode = '".$cclassprice."' and  inactive=0  
						order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function productyearlisting($yearprice=null,$year = null,$branch,$yearch=null,$yearch1=null,$yearch2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($yearch == 1 )
		$sql="";
		$sql=("select 
				PRODUCTCODE, 
				BARCODE, 
				DESCRIPTION, 
				pricemodecode as PRICEMODE, 
				srpuom as UOM, 
				SRP 
				From products 
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,
						markup, 
						pricemodecode 
				from pos_products 
				where pricemodecode = '".$yearprice."') as pos_products on pos_products.productid = products.productid 
				left join 
					(select 
						defa,
						productid,
						uom as costuom,
						totalcost,
						averagecost,
						cost,
						vendorcode,
						discount1,
						discount2,
						discount3 
				from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
				where products.fieldDcode = '".$year."' and  defa = 1 and pricemodecode = '".$yearprice."' and  inactive=0  
				order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function productinactiveyearlisting($yearprice=null,$year = null,$branch,$yearch=null,$yearch1=null,$yearch2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($yearch == 1 )
		$sql="";
		$sql=("select 
					PRODUCTCODE, 
					BARCODE, 
					DESCRIPTION, 
					pricemodecode as PRICEMODE, 
					srpuom as UOM, 
					SRP 
					From products 
					left join 
						(select 
							productid,
							barcode,
							uom as srpuom,
							srp,
							markup, 
							pricemodecode 
					from pos_products 
					where pricemodecode = '".$yearprice."') as pos_products on pos_products.productid = products.productid 
					left join 
						(select 
							defa,
							productid,
							uom as costuom,
							totalcost,
							averagecost,
							cost,
							vendorcode,
							discount1,
							discount2,
							discount3 
					from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
					where products.fieldDCcode = '".$year."' and  defa = 1 and pricemodecode = '".$yearprice."' and  inactive=1  
					order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function country_Actinactive($yearprice=null,$year = null,$branch,$yearch=null,$yearch1=null,$yearch2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($yearch == 1 )
		$sql="";
		$sql=("select 
					PRODUCTCODE, 
					BARCODE, 
					DESCRIPTION, 
					pricemodecode as PRICEMODE, 
					srpuom as UOM, 
					SRP 
					From products 
					left join 
						(select 
							productid,
							barcode,
							uom as srpuom,
							srp,
							markup, 
							pricemodecode 
					from pos_products 
					where pricemodecode = '".$yearprice."') as pos_products on pos_products.productid = products.productid 
					left join 
						(select 
							defa,
							productid,
							uom as costuom,
							totalcost,
							averagecost,
							cost,
							vendorcode,
							discount1,
							discount2,
							discount3 
					from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
					where products.fieldDcode = '".$year."' and  defa = 1 and pricemodecode = '".$yearprice."' 
					order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	// 	if($connected){
	// 		if($yearch == 1 && $yearch1 == 0 && $yearch2 == 0)
	// 		$query = $this->bdb->query("");
	// 			else if($yearch == 0 && $yearch1 == 1 && $yearch2 == 0)
	// 			$query = $this->bdb->query("");
	// 			else if($yearch == 0 && $yearch1 == 0 && $yearch2 == 1)
	// 			$query = $this->bdb->query("");
	// 			else
	// 			$query = $this->bdb->query("");

	// 		$res = $query->result();
	// 		return $res;
	// 			}
	// }
	public function productcountrylisting($countryprice=null,$country=null,$branch,$countrych=null,$countrych1=null,$countrych2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($countrych == 1 )
		$sql="";
		$sql=("select 
					PRODUCTCODE, 
					BARCODE, 
					DESCRIPTION, 
					pricemodecode as PRICEMODE, 
					srpuom as UOM, 
					SRP 
					From products 
					left join 
						(select 
							productid,
							barcode,
							uom as srpuom,
							srp,
							markup, 
							pricemodecode 
					from pos_products 
					where pricemodecode = '".$countryprice."') as pos_products on pos_products.productid = products.productid 
					left join 
						(select 
							defa,
							productid,
							uom as costuom,
							totalcost,
							averagecost,
							cost,
							vendorcode,
							discount1,
							discount2,
							discount3 
					from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
					where products.fieldEcode = '".$country."' and  defa = 1 and pricemodecode = '".$countryprice."' and  inactive=0  
					order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function country_inac($countryinac=null,$countryinc=null,$branch,$countinac=null,$countinac1=null,$countinac2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($countinac == 1 )
		$sql="";
		$sql=("select 
					PRODUCTCODE, 
					BARCODE, 
					DESCRIPTION, 
					pricemodecode as PRICEMODE, 
					srpuom as UOM, 
					SRP 
					From products 
					left join 
						(select 
							productid,
							barcode,
							uom as srpuom,
							srp,
							markup, 
							pricemodecode 
					from pos_products 
					where pricemodecode = '".$countryinac."') as pos_products on pos_products.productid = products.productid 
					left join 
						(select 
							defa,
							productid,
							uom as costuom,
							totalcost,
							averagecost,
							cost,
							vendorcode,
							discount1,
							discount2,
							discount3 
					from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
					where products.fieldEcode = '".$countryinc."' and  defa = 1 and pricemodecode = '".$countryinac."' and  inactive=1  
					order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function country_inac_active($country_price=null,$country=null,$branch,$countinactive=null,$countinactive1=null,$countinactive2=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($countinactive2 == 1 )
		$sql="";
		$sql=("select 
					PRODUCTCODE, 
					BARCODE, 
					DESCRIPTION, 
					pricemodecode as PRICEMODE, 
					srpuom as UOM, 
					SRP 
					From products 
					left join 
						(select 
							productid,
							barcode,
							uom as srpuom,
							srp,
							markup, 
							pricemodecode 
					from pos_products 
					where pricemodecode = '".$country_price."') as pos_products on pos_products.productid = products.productid 
					left join 
						(select 
							defa,
							productid,
							uom as costuom,
							totalcost,
							averagecost,
							cost,
							vendorcode,
							discount1,
							discount2,
							discount3 
					from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
					where products.fieldEcode = '".$country."' and  defa = 1 and pricemodecode = '".$country_price."' 
					order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	// 	if($connected){
	// 		if($countrych == 1 && $countrych1 == 0 && $countrych2 == 0)
	// 		$query = $this->bdb->query("");
	// 			else if($countrych == 0 && $countrych1 == 1 && $countrych2 == 0)

	// 			$query = $this->bdb->query("");
	// 			else if($countrych == 0 && $countrych1 == 0 && $countrych2 == 1)
	// 			$query = $this->bdb->query("");
	// 			else
	// 			$query = $this->bdb->query("");

	// 		$res = $query->result();
	// 		return $res;
	// 			}
	// }

	public function productcountrylistingcost($costprice=null,$country=null,$branch,$countrycost=null,$countrycost1=null,$countrycost2=null,$countrycost3=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($countrycost == 1 && $countrycost3 == 1)
		$sql="";
		$sql=("select 
			productcode as PRODUCTCODE, 
			barcode AS BARCODE, 
			description AS DESCRIPTION, 
			pricemodecode AS PRICEMODE, 
			costuom AS UOM1, 
			cost AS COST, 
			str(averagecost,5,5) AS AVECOST, 
			str(discount1,5,5) AS DISCOUNT1, 
			str(discount2,5,5) AS DISCOUNT2, 
			str(discount3,5,5) AS DISCOUNT3, 
			str(totalcost,5,5) AS NET, 
			str((srp-totalcost)/nullif(srp, 0),4,4) as MARKUP, 
			srpuom AS UOM, 
			srp AS SRP 
			From products 
				left join 
					(select 
						productid,
						barcode,
						uom as srpuom,
						srp,
						markup, 
						pricemodecode 
							from pos_products 
			where pricemodecode = '".$costprice."') as pos_products on pos_products.productid = products.productid 
			left join 
				(select 
					defa,
					productid,
					uom as costuom,
					totalcost,
					averagecost,
					cost,
					vendorcode,
					discount1,
					discount2,
					discount3 
			from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
			where products.fieldEcode = '".$country."' and  defa = 1 and pricemodecode = '".$costprice."' and  inactive=0  
			order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
				}
	}
	public function productcategorylisting($catprice=null,$cat=null,$branch,$catac=null,$catinc=null,$catai=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($catac == 1 )
		$sql="";
		$sql=("select PRODUCTCODE, BARCODE, DESCRIPTION, 
										pricemodecode as PRICEMODE, 
										srpuom as UOM, 
										SRP From products left join (select productid,barcode,
										uom as srpuom,srp,markup, pricemodecode from pos_products 
										where pricemodecode = '".$catprice."') as pos_products on pos_products.productid = products.productid 
										left join (select defa,productid,uom as costuom,totalcost,averagecost,cost,vendorcode,discount1,discount2,discount3 
										from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
										where products.LevelField1Code = '".$cat."' and  defa = 1 and pricemodecode = '". $catprice."' and  inactive=0  
										order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
			}
	}
	public function productcategorylistinginactive($catpriceinac1=null,$catinac1=null,$branch,$catac1=null,$catinc2=null,$catai3=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($catinc2 == 1 )
		$sql="";
		$sql=("select PRODUCTCODE, BARCODE, DESCRIPTION, 
											pricemodecode as PRICEMODE, 
											srpuom as UOM, SRP From products 
											left join (select productid,barcode,uom as srpuom,srp,markup, pricemodecode 
											from pos_products where pricemodecode = '".$catpriceinac1."') as pos_products on pos_products.productid = products.productid 
											left join (select defa,productid,uom as costuom,totalcost,averagecost,cost,vendorcode,discount1,discount2,discount3 from vendor_products ) 
											as vendor_products on vendor_products.productid = products.productid where products.LevelField1Code = '".$catinac1."' 
											and  defa = 1 and pricemodecode = '".$catpriceinac1."' and  inactive=1  order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
			}
	}
	public function product_active_inactive($catpriceactinc1=null,$catactinc1=null,$branch,$catac2=null,$catinc3=null,$catai4=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($catai4 == 1 )
		$sql="";
		$sql=("select PRODUCTCODE, BARCODE, DESCRIPTION, 
											pricemodecode as PRICEMODE, 
											srpuom as UOM, SRP From products 
											left join (select productid,barcode,uom as srpuom,srp,markup, pricemodecode 
											from pos_products where pricemodecode = '".$catpriceactinc1."') as pos_products on pos_products.productid = products.productid 
											left join (select defa,productid,uom as costuom,totalcost,averagecost,cost,vendorcode,discount1,discount2,discount3 from vendor_products ) 
											as vendor_products on vendor_products.productid = products.productid where products.LevelField1Code = '".$catactinc1."'  
											and  defa = 1 and pricemodecode ='".$catpriceactinc1."' order by description");
		

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
			}
	}
		// if($connected){
		// 	if( $catac == 1)
		// 	$query = $this->bdb->query("");
		// 		else if($catinc == 1)
		// 		$query = $this->bdb->query("");
		// 		else if($catai == 1)
		// 		$query = $this->bdb->query("");
		// 		else
		// 		$query = $this->bdb->query("select PRODUCTCODE, BARCODE, DESCRIPTION, 
		// 								pricemodecode as PRICEMODE, 
		// 								srpuom as UOM, 
		// 								SRP From products left join (select productid,barcode,
		// 								uom as srpuom,srp,markup, pricemodecode from pos_products 
		// 								where pricemodecode = '".$catprice."') as pos_products on pos_products.productid = products.productid 
		// 								left join (select defa,productid,uom as costuom,totalcost,averagecost,cost,vendorcode,discount1,discount2,discount3 
		// 								from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
		// 								where products.LevelField1Code = '".$cat."' and  defa = 1 and pricemodecode = '". $catprice."' and  inactive=0  
		// 								order by description");
		// 	$res = $query->result();
		// 	return $res;

		

	public function productcategorycost($categprice=null,$categdesc=null,$branch,$categCB=null,$categCB1=null,$categCB2=null,$categCB3=null){
		$user = $this->session->userdata('user');
		$connected = $this->bdb = $this->load->database($branch,TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
		if($categdesc == 1 && $categCB3 == 1)			
			$sql="";
			$sql="select 
			productcode as PRODUCTCODE, 
			barcode AS BARCODE, 
			description AS DESCRIPTION, 
			pricemodecode AS PRICEMODE, 
			costuom AS UOM1, 
			cost AS COST, 
			str(averagecost,5,5) AS AVECOST, 
			str(discount1,5,5) AS DISCOUNT1, 
			str(discount2,5,5) AS DISCOUNT2, 
			str(discount3,5,5) AS DISCOUNT3, 
			str(totalcost,5,5) AS NET, 
			str((srp-totalcost)/nullif(srp, 0),4,4) as MARKUP, 
			srpuom AS UOM, 
			srp AS SRP,
			markup as mm
			From products 
			left join 
				(select 
					productid,
					barcode,
					uom as srpuom,
					srp,
					markup, 
					pricemodecode 
			from pos_products 
			where pricemodecode = '".$categprice."') as pos_products on pos_products.productid = products.productid 
			left join 
				(select 
					defa,
					productid,
					uom as costuom,
					totalcost,
					averagecost,
					cost,
					vendorcode,
					discount1,
					discount2,
					discount3 
			from vendor_products ) as vendor_products on vendor_products.productid = products.productid 
			where products.LevelField1Code = '".$categdesc."' and  defa = 1 and pricemodecode = '".$categprice."' and  inactive=0  
			order by description";

			$query = $this->bdb->query($sql);	
			$res = $query->result();
			return $res;
		}

	}

	public function Prodlist($id = null,$branch =null){

		$user = $this->session->userdata('user');
		$this->bdb = $this->load->database('srs_gag',TRUE);
		$connected = $this->bdb->initialize();
		if($connected){
			$this->bdb->trans_start();
				$this->bdb->select('*');
				$this->bdb->from('vendor');
				if($id != null)
					$this->bdb->where('description',$id);
				$query = $this->bdb->get();
				$result = $query->result();
			$this->bdb->trans_complete();
			return $result;
		}else{
			return 'not connected';
		}


	}


	public function get_barcode($barcode=null,$branch=null){
		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
		// 	// if ($this->ping($ping)){
			
			$sql = "select 
					Products.ProductCode as ProductCode,
					POS_Products.Barcode as POSBarcode,
					VENDOR_Products.VendorProductCode as VendorProductCode,
					POS_Products.ProductID as POSProductid,
					POS_Products.Description as POSdescription,
					Products.Description as Productsdescription,
					CAST(CAST(SellingArea AS INT) / CAST(reportqty AS INT)AS VARCHAR)+'|'+CAST(CAST(SellingArea AS INT) % CAST(reportqty AS INT)AS VARCHAR) AS SellingArea,
					CAST(CAST(Damaged AS INT) / CAST(reportqty AS INT) AS VARCHAR)+'|'+CAST(CAST(Damaged AS INT) AS VARCHAR) AS BO_ROOM,
					CAST(CAST(OnOrder AS INT) / CAST(reportqty AS INT) AS VARCHAR)+'|'+CAST(CAST(OnOrder AS INT) % CAST(reportqty AS INT) AS VARCHAR) AS [order],
					Products.inactive as active,
					POS_Products.uom as POSUom,
					POS_Products.qty as POSQty,
					POS_Products.srp as POSSrp,
					POS_Products.LastDateModified as LastModified,
					Products.LastSellingDate as LastSellingDate,
					VENDOR_Products.VendorCode as VendorCode,
					VENDOR_Products.cost as VendorUnit_cost,
					VENDOR_Products.qty as VendorQty,
					VENDOR_Products.uom as VendorUom
					FROM POS_Products
					INNER JOIN Products ON POS_Products.ProductID = Products.ProductID
					INNER JOIN VENDOR_Products ON POS_Products.ProductID = VENDOR_Products.ProductID
					WHERE (POS_Products.Barcode = '".$barcode."') AND (VENDOR_Products.defa = 1)";
				
			$query = $this->bdb->query($sql);	
			if($query){
				$res = $query->result();
				return $res;
			}else{
				
				error_reporting(0);
			}

			

			// }	
	 }
 }


	 public function get_barcode_details($barcode=null,$branch=null){
	 	$this->bdb = $this->load->database('srs_gag',TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
			$sql="";
				$sql = "select 
						POS_Products.ProductID as Id,
						Products.Description as Descript,
						POS_Products.Barcode as Barcode,
						VENDOR_products.VendorProductCode as Code
						from POS_Products 
						LEFT JOIN 
						Products ON POS_Products.ProductCode = Products.ProductCode
						LEFT JOIN 
						vendor_products ON Products.ProductCode = vendor_products.VendorProductCode
						where POS_Products.ProductCode = '".$barcode."'";
			$query = $this->bdb->query($sql);
		$res = $query->result();		
	return $res;
			}
	 }





	 public function get_inventory_details($qwe=null,$branch=null,$box=null){
	 		$user = $this->session->userdata('user');
       		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select 
				products.productcode as PRODUCTCODE, 
				products.description as DESCRIPTION,
				products.CostOfSales as CostOfSales,	 
				products.reportuom as UOM, 
				products.reportqty as PACKING, 
				cast(cast(sellingarea as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(sellingarea as int)%cast(reportqty as int) as varchar) as SELLING_AREA, 
				cast(cast(stockroom as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(stockroom as int)%cast(reportqty as int) as varchar) as STOCK_ROOM,
				cast(cast(damaged as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(damaged as int)%cast(reportqty as int) as varchar) as BO_ROOM, 
				0 as PURCHASER 
				From products  
					left join 
						vendor_products on vendor_products.productid = products.productid 
					left join 
						(select
							productid,
							sum(qtysales) as mQtySales 
							from todatefinishedsales 
							where isnull([return],0) = 0 
							group by productid) as tdsales on products.productid = tdsales.productid 
							left join 
								(select 
								productid,
								sum(qtysales) as mQtyReturn 
								from todatefinishedsales 
								where isnull([return],0) = 1 
								group by productid) as tdreturns on products.productid = tdreturns.productid 
								where trackinventory = 1 and vendor_products.vendorcode = '".$qwe."'  
								order by DESCRIPTION";

				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
					}
		
		 }
		  public function get_inventoryloose_details($qwe=null,$branch=null,$box=null){
	 		$user = $this->session->userdata('user');
       		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select
										products.productcode as PRODUCTCODE, 
										products.description as DESCRIPTION, 
										products.reportuom as UOM, 
										products.reportqty as PACKING, 
										products.sellingarea - isnull(tdsales.mqtysales,0) + isnull(tdreturns.mqtyreturn,0) /products.reportqty as SELLING_AREA,
										products.stockroom/products.reportqty as STOCK_ROOM,
										products.damaged/products.reportqty as BO_ROOM,
										0 as PURCHASER 
										From products  
										left join 
										vendor_products on vendor_products.productid = products.productid 
										left join 
										(select 
										productid,
										sum(qtysales) as mQtySales 
										from todatefinishedsales 
										where isnull([return],0) = 0 
										group by productid) as tdsales 
										on products.productid = tdsales.productid 
										left join 
										(select productid,
										sum(qtysales) as mQtyReturn
										from todatefinishedsales 
										where isnull([return],0) = 1 
										group by productid) as tdreturns on products.productid = tdreturns.productid 
										where trackinventory = 1  and vendor_products.vendorcode = '".$qwe."'  
										order by DESCRIPTION";
				
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
					}
		
		 }
			// $query = $this->bdb->query("");

			// $res = $query->result();
			// return $res;
		

	  public function get_dept_details($department=null,$branch,$box1=null){
	  	$user = $this->session->userdata('user');
       $this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select  products.productcode as PRODUCTCODE, 
					products.description as DESCRIPTION, 
					products.reportuom as UOM, 
					products.reportqty as PACKING, 
					cast(cast(sellingarea as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(sellingarea as int)%cast(reportqty as int) as varchar)as SELLING_AREA, 
					cast(cast(stockroom as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(stockroom as int)%cast(reportqty as int) as varchar) as STOCK_ROOM,
					cast(cast(damaged as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(damaged as int)%cast(reportqty as int) as varchar) as BO_ROOM, 
					0 as PURCHASER 
					From products  
					left join 
					vendor_products on vendor_products.productid = products.productid
					left join 
					(select productid,sum(qtysales) as mQtySales 
					from todatefinishedsales 
					where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid 
					left join 
					(select productid,sum(qtysales) as mQtyReturn 
					from todatefinishedsales 
					where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid 
					where trackinventory = 1  and products.fieldacode = '".$department."'  
					order by DESCRIPTION";
				
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;

			}
		}
		public function get_deptloose_details($department=null,$branch,$box1=null){
	  	$user = $this->session->userdata('user');
       $this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select products.productcode as PRODUCTCODE,
					 products.description as DESCRIPTION, products.reportuom as UOM, 
					products.reportqty as PACKING, products.sellingarea - isnull(tdsales.mqtysales,0) + isnull(tdreturns.mqtyreturn,0) /products.reportqty 
					as SELLING_AREA,str(products.stockroom/products.reportqty,5,5) as STOCK_ROOM, str(products.damaged/products.reportqty,5,5) as BO_ROOM, 0 as PURCHASER 
					From products  left join vendor_products on vendor_products.productid = products.productid left join (select productid,sum(qtysales) as mQtySales 
					from todatefinishedsales where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid left join (select productid,
					sum(qtysales) as mQtyReturn from todatefinishedsales where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid
					where trackinventory = 1  and products.fieldacode = '".$department."'  order by DESCRIPTION";
				
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}

	   public function get_brand_details($brand=null,$branch,$box2=null){
       $this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select  products.productcode as PRODUCTCODE, 
					products.description as DESCRIPTION, 
					products.reportuom as UOM, 
					products.reportqty as PACKING, 
					cast(cast(sellingarea as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(sellingarea as int)%cast(reportqty as int) as varchar)as SELLING_AREA, 
					cast(cast(stockroom as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(stockroom as int)%cast(reportqty as int) as varchar) as STOCK_ROOM,
					cast(cast(damaged as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(damaged as int)%cast(reportqty as int) as varchar) as BO_ROOM, 
					0 as PURCHASER From products  
					left join 
					vendor_products on vendor_products.productid = products.productid 
					left join 
					(select productid,sum(qtysales) as mQtySales 
					from todatefinishedsales 
					where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid 
					left join 
					(select productid,
					sum(qtysales) as mQtyReturn 
					from todatefinishedsales 
					where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid 
					where trackinventory = 1  and products.fieldbcode = '306'  
					order by DESCRIPTION";
					$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}
		public function get_loosebrand_details($brand=null,$branch,$box2=null){
       $this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select products.productcode as PRODUCTCODE, products.description 
							as DESCRIPTION, products.reportuom as UOM, products.reportqty 
							as PACKING, products.sellingarea - isnull(tdsales.mqtysales,0) + isnull(tdreturns.mqtyreturn,0) /products.reportqty 
							as SELLING_AREA,str(products.stockroom/products.reportqty,5,5) as STOCK_ROOM,str(products.damaged/products.reportqty,5,5) 
							as BO_ROOM,0 as PURCHASER From products  left join vendor_products on vendor_products.productid = products.productid 
							left join (select productid,sum(qtysales) as mQtySales from todatefinishedsales where isnull([return],0) = 0 group by productid) 
							as tdsales on products.productid = tdsales.productid left join (select productid,sum(qtysales) as mQtyReturn from todatefinishedsales 
							where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid where trackinventory = 1 
							 and products.fieldbcode = '".$brand."'  order by DESCRIPTION";
				
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}

		 public function get_class_details($cls=null,$branch,$box3=null){
       $this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select  products.productcode as PRODUCTCODE, 
				products.description as DESCRIPTION, 
				products.reportuom as UOM, products.reportqty as PACKING, 
				cast(cast(sellingarea as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(sellingarea as int)%cast(reportqty as int) as varchar) as SELLING_AREA, 
				cast(cast(stockroom as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(stockroom as int)%cast(reportqty as int) as varchar) as STOCK_ROOM ,
				cast(cast(damaged as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(damaged as int)%cast(reportqty as int) as varchar) as BO_ROOM, 
				0 as PURCHASER 
				From products  
				left join 
				vendor_products on vendor_products.productid = products.productid 
				left join 
				(select productid,
				sum(qtysales) as mQtySales 
				from todatefinishedsales 
				where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid 
				left join (select productid,sum(qtysales) as mQtyReturn 
				from todatefinishedsales 
				where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid
			    where trackinventory = 1  and products.fieldccode = '".$cls."'  
			    order by DESCRIPTION";
					$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}
		public function get_classloose_details($cls=null,$branch,$box3=null){
       $this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select 
				products.productcode as PRODUCTCODE, 
				products.description as DESCRIPTION, 
				products.reportuom as UOM, 
				products.reportqty as PACKING, 
				products.sellingarea - isnull(tdsales.mqtysales,0) + isnull(tdreturns.mqtyreturn,0) /products.reportqty as SELLING_AREA,
				str(products.stockroom/products.reportqty,5,5) as STOCK_ROOM,
				str(products.damaged/products.reportqty,5,5) as BO_ROOM,
				 0 as PURCHASER 
				 From products  
				 left join vendor_products on vendor_products.productid = products.productid 
				 left join (select productid,sum(qtysales) as mQtySales from todatefinishedsales 
				 	where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid 
				left join (select productid,sum(qtysales) as mQtyReturn 
					from todatefinishedsales where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid 
						where trackinventory = 1  and products.fieldccode = '".$cls."'  
						order by DESCRIPTION";
				
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}
		public function get_country_details($ctry=null,$branch){
       $this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select  
				products.productcode as PRODUCTCODE, 
				products.description as DESCRIPTION, 
				products.reportuom as UOM, 
				products.reportqty as PACKING, 
				cast(cast(sellingarea as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(sellingarea as int)%cast(reportqty as int) as varchar) as SELLING_AREA, 
				cast(cast(stockroom as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(stockroom as int)%cast(reportqty as int) as varchar) as STOCK_ROOM ,
				cast(cast(damaged as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(damaged as int)%cast(reportqty as int) as varchar) as BO_ROOM, 
				0 as PURCHASER 
				From products  
				left join 
					vendor_products on vendor_products.productid = products.productid 
					left join (select productid,sum(qtysales) as mQtySales 
						from todatefinishedsales 
				where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid 
				left join (select productid,sum(qtysales) as mQtyReturn 
					from todatefinishedsales 
					where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid 
				where trackinventory = 1  and products.fieldecode = '".$ctry."'  order by DESCRIPTION";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}
		public function country_loose($ctry=null,$branch){
       $this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select 
				products.productcode as PRODUCTCODE, 
				products.description as DESCRIPTION, 
				products.reportuom as UOM, 
				products.reportqty as PACKING, 
				products.sellingarea - isnull(tdsales.mqtysales,0) + isnull(tdreturns.mqtyreturn,0) /products.reportqty as SELLING_AREA,
				str(products.stockroom/products.reportqty,5,5) as STOCK_ROOM,
				str(products.damaged/products.reportqty,5,5) as BO_ROOM, 
				0 as PURCHASER 
				From products  
				left join vendor_products on vendor_products.productid = products.productid 
				left join (select productid,sum(qtysales) as mQtySales 
					from todatefinishedsales 
					where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid 
				left join (select productid,sum(qtysales) as mQtyReturn 
					from todatefinishedsales 
					where isnull([return],0) = 1 group by productid) as tdreturns 
				on products.productid = tdreturns.productid where trackinventory = 1  and products.fieldecode = '".$ctry."'  
				order by DESCRIPTION";
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}
		public function get_category_det($catego=null,$branch,$box4=null){
       $this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select  products.productcode as PRODUCTCODE, 
				products.description as DESCRIPTION, 
				products.reportuom as UOM, products.reportqty as PACKING, 
				cast(cast(sellingarea as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(sellingarea as int)%cast(reportqty as int) as varchar) as SELLING_AREA, 
				cast(cast(stockroom as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(stockroom as int)%cast(reportqty as int) as varchar) as STOCK_ROOM ,
				cast(cast(damaged as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(damaged as int)%cast(reportqty as int) as varchar) as BO_ROOM, 
				0 as PURCHASER 
				From products  
				left join 
				vendor_products on vendor_products.productid = products.productid 
				left join 
				(select productid,
				sum(qtysales) as mQtySales 
				from todatefinishedsales 
				where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid 
				left join (select productid,sum(qtysales) as mQtyReturn 
				from todatefinishedsales 
				where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid
			    where trackinventory = 1  and products.fieldccode = '".$catego."'  
			    order by DESCRIPTION";
					$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}
		public function get_categoryloose_det($catego=null,$branch,$box4=null){
      		$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "select 
				products.productcode as PRODUCTCODE, 
				products.description as DESCRIPTION, 
				products.reportuom as UOM, 
				products.reportqty as PACKING, 
				products.sellingarea - isnull(tdsales.mqtysales,0) + isnull(tdreturns.mqtyreturn,0) /products.reportqty as SELLING_AREA,
				str(products.stockroom/products.reportqty,5,5) as STOCK_ROOM,str(products.damaged/products.reportqty,5,5) as BO_ROOM, 
				0 as PURCHASER 
				From products  
				left join vendor_products on vendor_products.productid = products.productid 
				left join (select productid,sum(qtysales) as mQtySales 
					from todatefinishedsales where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid 
				left join (select productid,sum(qtysales) as mQtyReturn 
					from todatefinishedsales where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid
					 where trackinventory = 1  and products.levelfield1code = '".$catego."'  order by DESCRIPTION'  
				order by DESCRIPTION";
				
				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}

		public function ProductBarcodeInsert($barcode=null,$branch=null){
			$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "";
				$sql = "Select ProductCode,LastDateModified,Description,LastSellingDate,Consigned,CostofSales,CostofSales,Vendorcode,LastPurchasedDate from Products where Products.ProductCode = '4800888143730'";

				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}

		}

		public function POSProductBarcodeInsert($branch=null,$id=null){
			$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "";
				$sql = "Select ProductCode,Barcode,Pricemodecode,Description from POS_Products";

				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}

		}

		public function VendorProductBarcodeInsert($branch=null,$id=null){
			$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "";
				$sql = "Select VendorProductCode,Description,Vendorcode as vendor_products";

				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}

		}

		public function ProductsChecking($productcode=null,$branch=null){
			$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "";
				$sql = "Select productcode as pos_products";

				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}
		}
		public function POSProductsChecking($productcode=null,$branch=null){
			$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "";
				$sql = "Select productcode as products";

				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}	
		}
		public function VendorProductsChecking($vendorproductcode=null,$branch=null){
			$this->bdb = $this->load->database($branch,TRUE);
			$connected = $this->bdb->initialize();
			if($connected){
				$sql = "";
				$sql = "Select VendorProductCode as vendor_products";

				$query = $this->bdb->query($sql);
				$res = $query->result();
			
				return $res;
			}				
		}


		//--------------------- DAN ------------------------//
	function ProductHistoryViewDataDisplay($id,$branch_view){
		$this->bdb = $this->load->database($branch_view,TRUE);
		$sql = "SELECT ph.barcode,
		PriceModecode,
		dateposted,
		(SELECT name FROM MarkUsers WHERE userid =  ph.PostedBy) AS PostedBy,
		fromsrp,
		tosrp,
		UOM,
		markup
		FROM pricechangehistory  AS ph WHERE productid = $id 
		AND dateposted BETWEEN GETDATE()-30  AND GETDATE() 
		ORDER BY lineid DESC
		";
				$query = $this->bdb->query($sql);
				$result = $query->result();
				return $result;
	}
	//babalikan
	function ViewMarkupDisplay($id,$branch_view){
		$this->ddb = $this->load->database($branch_view,TRUE);
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

	function ViewTN($id,$branch_view){
		$this->ddb = $this->load->database($branch_view,TRUE);
		$sql = "SELECT 
		ToDescription,
		FromDescription
		FROM Movements WHERE MovementNo = {$this->ddb->escape($id)} 
		";
				$query = $this->ddb->query($sql);
				$result = $query->result();
				return $result;
	}

	function GetProductHistory($branch){
		$this->bdb = $this->load->database($branch,TRUE);
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
				$query = $this->bdb->query($sql);
				$result = $query->result();
				return $result;
	}

	function ProductHistoryGetViewData($branch_input,$description=null,$barcode=null,$tdate,$fdate){
		$this->bdb = $this->load->database($branch_input,TRUE);
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
				ph.UnitCost AS Unit2,
				ph.Barcode,
				ph.UnitCost, 
				(SELECT name FROM MarkUsers WHERE userid =  ph.PostedBy) AS Name,
       			(SELECT TOP 1 ProductID FROM POS_Products WHERE Barcode = ph.Barcode) AS PID
				FROM ProductHistory  AS ph
				INNER JOIN (SELECT ProductID,Description,SellingArea,CostOfSales FROM Products WHERE inactive  = 0 ) AS p
				ON ph.ProductID = p.ProductID
				INNER JOIN POS_Products AS pos
				ON ph.Barcode = pos.Barcode
				";
				
				if($fdate && $tdate && $description){
					$sql .= "WHERE ph.DatePosted BETWEEN '".$tdate."' AND '".$fdate."' AND p.Description = '".$description."' ORDER BY ph.LineID DESC";
				}else if($fdate && $tdate && $barcode){
					$sql .= "WHERE ph.DatePosted BETWEEN '".$tdate."' AND '".$fdate."' AND ph.Barcode = '".$barcode."' ORDER BY ph.LineID DESC";
				}else if($fdate && $tdate && $barcode && $description){
					$sql .= "WHERE ph.DatePosted BETWEEN '".$tdate."' AND '".$fdate."' AND ph.Barcode = '".$barcode."' AND p.Description = '".$description."' ORDER BY ph.LineID DESC";
				}else if($fdate && $tdate){
					$sql .= "WHERE ph.DatePosted BETWEEN '".$fdate."' AND '".$tdate."'  ORDER BY ph.LineID DESC";
				}else{
					$sql .= "ORDER BY ph.LineID DESC";
				}
				$query = $this->bdb->query($sql);
				$result = $query->result();
				return $result;
	}

	//--------------------- DAN ------------------------//



// 	 public function get_class_details($cls=null,$branch=null,$box=null){
//        $this->bdb = $this->load->database($branch,TRUE);
// 			$connected = $this->bdb->initialize();
// 			if($connected){
// 			$sql="";
// 			$sql="";
	
// 				$query = $this->bdb->query($sql);
// 					$res = $query->result();		
// 				return $res;
// 			}
	
// 	 }
	 


// 	 public function get_year_details($yr=null,$branch=null,$box=null){
//        $this->bdb = $this->load->database('srs_gag',TRUE);
// 			$connected = $this->bdb->initialize();
// 			if($connected){
// 			$sql="";
// 			$sql="";
// 				$query = $this->bdb->query($sql);
// 					$res = $query->result();		
// 				return $res;
// 			}
	
// 	 }

// 	 public function get_country_details($country=null,$branch=null,$box=null){
//        $this->bdb = $this->load->database('srs_gag',TRUE);
// 			$connected = $this->bdb->initialize();
// 			if($connected){
// 			$sql="";
// 			$sql="select  products.productcode 
// 					as PRODUCTCODE, products.description 
// 					as DESCRIPTION, products.reportuom 
// 					as UOM, products.reportqty 
// 					as PACKING, 
// 					cast(cast(sellingarea as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(sellingarea as int)%cast(reportqty as int) 
// 					as varchar) 
// 					as SELLING_AREA, 
// 					cast(cast(stockroom as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(stockroom as int)%cast(reportqty as int) as varchar) 
// 					as STOCK_ROOM ,cast(cast(damaged as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(damaged as int)%cast(reportqty as int) as varchar) as BO_ROOM, 0 as PURCHASER 
// 					From products  left join vendor_products on vendor_products.productid = products.productid left join (select productid,sum(qtysales) as mQtySales 
// 					from todatefinishedsales where isnull([return],0) = 0 group by productid) as tdsales on products.productid = tdsales.productid left join (select productid,sum(qtysales) 
// 					as mQtyReturn from todatefinishedsales where isnull([return],0) = 1 group by productid) as tdreturns on products.productid = tdreturns.productid where trackinventory = 1  
// 					and products.fieldecode = 'SR'  order by DESCRIPTION";
// 				$query = $this->bdb->query($sql);
// 					$res = $query->result();		
// 				return $res;
// 			}
	
// 	 }

// 	 public function cat_results($cat=null,$branch=null,$box=null){
//        $this->bdb = $this->load->database('srs_gag',TRUE);
// 			$connected = $this->bdb->initialize();
// 			if($connected){
// 			$sql="";
// 			$sql="select  products.productcode as PRODUCTCODE, products.description as DESCRIPTION, 
// 				products.reportuom as UOM, products.reportqty 
// 				as PACKING, cast(cast(sellingarea as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(sellingarea as int)%cast(reportqty as int) as varchar) 
// 				as SELLING_AREA, cast(cast(stockroom as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(stockroom as int)%cast(reportqty as int) as varchar) 
// 				as STOCK_ROOM ,cast(cast(damaged as int)/cast(reportqty as int) as varchar) + ' | ' + cast(cast(damaged as int)%cast(reportqty as int) as varchar) 
// 				as BO_ROOM, 0 as PURCHASER From products  left join vendor_products 
// 				on vendor_products.productid = products.productid 
// 				left join (select productid,sum(qtysales) as mQtySales from todatefinishedsales 
// 				where isnull([return],0) = 0 group by productid) as tdsales 
// 				on products.productid = tdsales.productid left join (select productid,sum(qtysales) 
// 				as mQtyReturn from todatefinishedsales where isnull([return],0) = 1 group by productid) 
// 				as tdreturns on products.productid = tdreturns.productid where trackinventory = 1  
// 				and products.levelfield1code = '".$cat."'  order by DESCRIPTION";
// 				$query = $this->bdb->query($sql);
// 					$res = $query->result();		
// 				return $res;
// 			}
	
// 	 }


	//====================================== OVERSTOCK END ==============================================

	//=======================OJT================================
		// $this->db->trans_start();
			// $this->db->select('*');
			// $this->db->from('');

			// if($id != null){
				// $this->db->where('sales_orders.order_no',$id);
			// }
			// $this->db->where('sales_orders.order_no',1);
			// $this->db->order_by('order_no desc');
			// $query = $this->db->get();
			// $result = $query->result();
			// echo $this->db->last_query();
		// $this->db->trans_complete();
		// return $result;

	
// 	public function get_sales_order_header($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('sales_orders');
// 			// if($id != null){
// 				// $this->db->where('sales_orders.order_no',$id);
// 			// }
// 			$this->db->where('sales_orders.order_no',1);
// 			$this->db->order_by('order_no desc');
// 			$query = $this->db->get();
// 			$result = $query->result();
// 			// echo $this->db->last_query();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function add_sales_order_header($items){
// 		$this->db->insert('sales_orders',$items);
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_sales_order_header($item,$id){
// 		$this->db->where('id', $id);
// 		$this->db->update('sales_orders', $item);

// 		return $this->db->last_query();
// 	}
// 	//**********SALES PERSONS*****Allyn*****START
// 	public function get_sales_persons($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('sales_persons');
// 			if($id != null){
// 				$this->db->where('sales_persons.sales_person_id',$id);
// 			}
// 			$this->db->order_by('sales_person_id desc');
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function add_sales_persons($items){
// 		$this->db->insert('sales_persons',$items);
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_sales_persons($user,$id){
// 		$this->db->where('sales_person_id', $id);
// 		$this->db->update('sales_persons', $user);

// 		return $this->db->last_query();
// 	}
// 	//**********SALES PERSONS*****Allyn*****END
// 	//**********CREDIT STATUS*****Allyn*****START
// 	public function get_credit_status($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('credit_statuses');
// 			if($id != null){
// 				$this->db->where('credit_statuses.credit_status_id',$id);
// 			}
// 			$this->db->order_by('credit_status_id desc');
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function add_credit_status($items){
// 		$this->db->insert('credit_statuses',$items);
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_credit_status($user,$id){
// 		$this->db->where('credit_status_id', $id);
// 		$this->db->update('credit_statuses', $user);

// 		return $this->db->last_query();
// 	}
// 	//**********CREDIT STATUS*****Allyn*****END

// 	//*********Sales type******Jed
// 	public function get_sales_type($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('sales_types');
// 			if($id != null){
// 				$this->db->where('id',$id);
// 			}
// 			$this->db->order_by('id desc');
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function add_sales_type($items){
// 		$this->db->insert('sales_types',$items);
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_sales_type($user,$id){
// 		$this->db->where('id', $id);
// 		$this->db->update('sales_types', $user);

// 		return $this->db->last_query();
// 	}
// //**********SO ENTRY*****Allyn*****start
// 	public function get_so_header($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('sales_orders.*');
// 			$this->db->from('sales_orders');
// 			if($id != null)
// 				if(is_array($id))
// 				{
// 					$this->db->where_in('sales_orders.order_no',$id);
// 				}else{
// 					$this->db->where('sales_orders.order_no',$id);
// 				}
// 			$this->db->order_by('sales_orders.order_no desc');
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function add_so_header($items){
// 		// $this->db->set('reg_date', 'NOW()', FALSE);
// 		$this->db->insert('sales_orders',$items);
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_so_header($user,$id){
// 		$this->db->where('order_no', $id);
// 		$this->db->update('sales_orders', $user);

// 		return $this->db->last_query();
// 	}
// 	public function update_trans_types_next_ref($prev_ref,$trans_type_id){
// 		$new_ref = $prev_ref+1;
// 		$this->db->where('type_id', $trans_type_id);
// 		// $this->db->update('trans_types',array('next_ref'=>$new_ref),array('type_id'=>$trans_type));
// 		$this->db->update('trans_types',array('next_ref'=>$new_ref));
// 		// echo $this->db->last_query();
// 		return $this->db->last_query();
// 	}
// 	public function get_next_type_no($type_id=null){
// 		$this->db->select("next_ref");
// 		$this->db->from("trans_types");
// 		$this->db->where("type_id",$type_id);
// 		$query = $this->db->get();
// 		$result = $query->result();
// 		$res = $result[0];
// 		return $res->next_ref;
// 	}
	 // ===>
// 	public function get_so_items($id=null,$so_id=null,$item_id=null){
// 		$this->db->trans_start();
// 			$this->db->select("
// 				sales_order_details.*,
// 				IF(sales_order_details.stock_category <> '".LOCAL_ITEM."',stock_master.item_code,non_stock_master.item_code) as item_code,
// 				IF(sales_order_details.stock_category <> '".LOCAL_ITEM."',stock_master.name,non_stock_master.name) as name",false);
// 			$this->db->from('sales_order_details');
// 			$this->db->join('stock_master','sales_order_details.stock_id=stock_master.id','left');
// 			$this->db->join('non_stock_master','sales_order_details.stock_id=non_stock_master.id','left');
// 			if($id != null)
// 				if(is_array($id))
// 				{
// 					$this->db->where_in('sales_order_details.id',$id);
// 				}else{
// 					$this->db->where('sales_order_details.id',$id);
// 				}
// 			if($so_id != null){
// 				$this->db->where_in('sales_order_details.order_no',$so_id);
// 			}
// 			if($item_id != null){
// 				$this->db->where('sales_order_details.stock_id',$item_id);
// 			}
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function search_items($search=""){
// 		$this->db->trans_start();
// 			$this->db->select('stock_master.id,stock_master.item_code,stock_master.barcode,stock_master.name');
// 			$this->db->from('stock_master');
// 			if($search != ""){
// 				$this->db->like('stock_master.name', $search);
// 				$this->db->or_like('stock_master.item_code', $search);
// 				$this->db->or_like('stock_master.barcode', $search);
// 			}
// 			$this->db->order_by('stock_master.name');
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function search_debtors($search="",$debtor_id=null)
// 	{
// 		$this->db->select('debtor_id, debtor_code, name');
// 		$this->db->from('debtor_master');
// 		if ($search != "") {
// 			$this->db->like('debtor_master.debtor_code', $search);
// 			$this->db->or_like('debtor_master.name', $search);
// 		}
// 		if ($debtor_id) {
// 			$this->db->where('debtor_id',$debtor_id);
// 		}
// 		$this->db->order_by('debtor_master.name');
// 		$query = $this->db->get();
// 		$result = $query->result();
// 		return $result;
// 	}
// 	// public function get_item($item_id=null)
// 	// {
// 		// $this->db->select('
// 			// stock_master.*,
// 			// stock_categories.category_name as category,
// 			// stock_types.type as item_type,
// 			// ');
// 		// $this->db->from('stock_master');
// 		// $this->db->join('stock_categories','stock_master.category_id = stock_categories.stock_category_id');
// 		// // $this->db->join('subcategories','subcategories.sub_cat_id = stock_master.subcat_id','left');
// 		// $this->db->join('stock_types','stock_master.item_type = stock_types.id');
// 		// // $this->db->join('suppliers','stock_master.supplier_id = suppliers.supplier_id');
// 		// if (!is_null($item_id)) {
// 			// if (is_array($item_id))
// 				// $this->db->where_in('stock_master.id',$item_id);
// 			// else
// 				// $this->db->where('stock_master.id',$item_id);
// 		// }
// 		// $this->db->order_by('stock_master.name ASC');
// 		// $query = $this->db->get();
// 		// return $query->result();
// 	// }
// 	public function get_item($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('stock_master');
// 			if($id != null)
// 				$this->db->where('stock_master.id',$id);
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function get_details($where,$table){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from($table);
// 			if($where)
// 				$this->db->where($where);
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function add_so_item($items){
// 		$this->db->insert('sales_order_details',$items);
// 		// echo $this->db->last_query();
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_so_item($user,$id){
// 		$this->db->where('id', $id);
// 		$this->db->update('sales_order_details', $user);

// 		return $this->db->last_query();
// 	}
// 	public function delete_so_item($id){
// 		$this->db->where('id', $id);
// 		$this->db->delete('sales_order_details');
// 	}
// 	public function item_name($item_id=null){
// 		$this->db->select("name");
// 		$this->db->from("stock_master");
// 		$this->db->where("id",$item_id);
// 		$query = $this->db->get();
// 		$result = $query->result();
// 		$res = $result[0];
// 		return $res->name;
// 	}
// 	public function item_name_with_code($item_id=null){
// 		$this->db->select("item_code, name");
// 		$this->db->from("stock_master");
// 		$this->db->where("id",$item_id);
// 		$query = $this->db->get();
// 		$result = $query->result();
// 		$res = $result[0];
// 		return "[ ".$res->item_code." ]".$res->name;
// 	}
// 	//**********SO ENTRY*****Allyn*****end
// 	//-----AUDIT TRAIL-----APM-----START
// 	public function write_to_audit_trail($items=array())
// 	{
// 		$this->db->insert('audit_trail',$items);
// 		$id = $this->db->insert_id();
// 		return $id;
// 	}
// 	//-----AUDIT TRAIL-----APM-----END
	
// 	/* Sales Order Inquiry */
// 	/* Author : Caleb */
// 	public function get_sales_orders($where=null)
// 	{
// 		$this->db->select('
// 			sales_orders.order_no,
// 			sales_orders.trans_type,
// 			sales_orders.type_no,
// 			sales_orders.reference,
// 			sales_orders.debtor_id,
// 			debtor_master.name as debtor_name,
// 			sales_orders.debtor_branch_id,
// 			debtor_branches.branch_name,
// 			sales_orders.reference,
// 			sales_orders.order_date,
// 			sales_orders.sales_type,
// 			sales_types.sales_type sales_type_name,
// 			sales_orders.customer_ref,
// 			sales_orders.from_loc,
// 			sales_orders.deliver_to,
// 			sales_orders.delivery_address,
// 			sales_orders.phone,
// 			sales_orders.email,
// 			sales_orders.shipper_id,
// 			shipping_company.company_name shipper_name,
// 			sales_orders.shipping_cost,
// 			sales_orders.delivery_date,
// 			sales_orders.approved_date,
// 			sales_orders.status,
// 			sales_orders.inactive,
// 			sales_orders.remarks,
// 			IFNULL(SUM(sales_order_details.line_total),0) as order_total,
// 			SUM(IF(sales_order_details.discount_percentage > 10,1,0)) underpriced_count,
// 			users.fname,
// 			users.mname,
// 			users.lname
// 			',false);
// 		$this->db->from('sales_orders');
// 		$this->db->join('debtor_master','sales_orders.debtor_id = debtor_master.debtor_id');
// 		$this->db->join('debtor_branches','sales_orders.debtor_branch_id = debtor_branches.debtor_branch_id','left');
// 		$this->db->join('sales_types','sales_orders.sales_type = sales_types.id');
// 		$this->db->join('shipping_company','sales_orders.shipper_id = shipping_company.ship_company_id');
// 		$this->db->join('sales_order_details','sales_orders.order_no = sales_order_details.order_no','left');
// 		$this->db->join('users','sales_orders.person_id = users.id');
// 		if ($where)
// 			if (is_array($where))
// 				foreach ($where as $v) {
// 					if (isset($v['key']))
// 						$this->db->where($v['key'],$v['value'],$v['escape']);
// 					else
// 						$this->db->where($v);
// 				}
// 			else
// 				$this->db->where($where);
// 		$this->db->group_by('sales_order_details.order_no');

// 		$query = $this->db->get();
// 		// echo $this->db->last_query();
// 		return $query->result();
// 	}
// 	public function update_sales_order($items,$where=array())
// 	{
// 		if ($where)
// 			$this->db->where($where);
// 		$this->db->update('sales_orders',$items);
// 	}
// 	public function view_sales_order_details($where=null)
// 	{
// 		$this->db->select('*');
// 		$this->db->from('view_sales_order_details');
// 		if ($where)
// 			$this->db->where($where);
// 		$query = $this->db->get();
// 		return $query->result();
// 	}
// 	public function write_sales_delivery($items)
// 	{
// 		$this->db->insert('sales_deliveries',$items);
// 		$insert_id = $this->db->insert_id();
// 		return $insert_id;
// 	}
// 	public function get_sales_deliveries($where=null)
// 	{
// 		// $this->db->select('
// 		// 	sales_deliveries.order_no,
// 		// 	sales_deliveries.delivery_no,
// 		// 	debtor_master.name as customer_name,
// 		// 	debtor_branches.branch_name as customer_branch,
// 		// 	sales_orders.debtor_id,
// 		// 	sales_orders.debtor_branch_id,
// 		// 	sales_orders.deliver_to,
// 		// 	sales_orders.sales_type,
// 		// 	sales_types.sales_type as sales_type_name,
// 		// 	sales_deliveries.delivery_date,
// 		// 	sales_deliveries.invoice_due_date,
// 		// 	sales_deliveries.shipping_cost,
// 		// 	sales_deliveries.total_delivery_cost
// 		// 	',false);
// 		// $this->db->from('sales_deliveries');
// 		// $this->db->join('sales_orders','sales_deliveries.order_no = sales_orders.order_no');
// 		$this->db->select('
// 			sales_orders.order_no,
// 			sales_orders.trans_type,
// 			sales_orders.type_no,
// 			debtor_trans.debtor_id,
// 			debtor_trans.id delivery_no,
// 			debtor_trans.reference delivery_ref,
// 			debtor_master.name as customer_name,
// 			debtor_trans.debtor_branch_id,
// 			debtor_branches.branch_name as customer_branch,
// 			sales_orders.deliver_to,
// 			sales_orders.sales_type,
// 			sales_types.sales_type as sales_type_name,
// 			debtor_trans.trans_date as delivery_date,
// 			debtor_trans.invoice_due_date,
// 			debtor_trans.t_shipping_cost as shipping_cost,
// 			debtor_trans.t_amount as total_delivery_cost,
// 			debtor_trans.address
// 			',false);
// 		$this->db->from('debtor_trans');
// 		$this->db->join('sales_orders',
// 			'debtor_trans.src_trans_type = sales_orders.trans_type AND debtor_trans.src_type_no = sales_orders.type_no');
// 		$this->db->join('sales_types','sales_orders.sales_type = sales_types.id');
// 		$this->db->join('debtor_master','sales_orders.debtor_id = debtor_master.debtor_id');
// 		$this->db->join('debtor_branches','sales_orders.debtor_branch_id = debtor_branches.debtor_branch_id','left');
// 		if ($where)
// 			if (is_array($where)) {
// 				foreach ($where as $v) {
// 					if (isset($v['key']))
// 						$this->db->where($v['key'],$v['value'],$v['escape']);
// 					else
// 						$this->db->where($v);
// 				}
// 			}
// 			else
// 				$this->db->where($where);
// 		$this->db->order_by('debtor_trans.created_on ASC');
// 		$query = $this->db->get();
// 		return $query->result();
// 	}
// 	public function update_sales_deliveries($items,$delivery_no=array(),$where=array())
// 	{
// 		if ($where)
// 			if (is_array($where)) {
// 				foreach ($where as $v) {
// 					if (isset($v['key']))
// 						$this->db->where($v['key'],$v['value'],$v['escape']);
// 					else
// 						$this->db->where($v);
// 				}
// 			}
// 			else
// 				$this->db->where($where);
// 		if ($delivery_no)
// 			$this->db->where_in('id',$delivery_no);
// 		$this->db->update('debtor_trans',$items);
// 	}
// 	public function view_sales_delivery_items($delivery_no=null,$where=null)
// 	{
// 		$this->db->select('*');
// 		$this->db->from('view_sales_delivery_items');
// 		if ($delivery_no) {
// 			if (is_array($delivery_no)) {
// 				$this->db->where_in('delivery_no',$delivery_no);
// 			}
// 			else {
// 				$this->db->where('delivery_no',$delivery_no);
// 			}
// 		}
// 		if ($where)
// 			if (is_array($where)) {
// 				foreach ($where as $v) {
// 					if (isset($v['key']))
// 						$this->db->where($v['key'],$v['value'],$v['escape']);
// 					else
// 						$this->db->where($v);
// 				}
// 			}
// 			else
// 				$this->db->where($where);
// 		$query = $this->db->get();
// 		// echo $this->db->last_query();
// 		return $query->result();
// 	}
// 	public function write_debtor_trans($items)
// 	{
// 		$this->db->insert('debtor_trans',$items);
// 		$id = $this->db->insert_id();
// 		return $id;
// 	}
// 	public function get_debtor_trans($where=null,$limit=null)
// 	{
// 		$this->db->select('
// 			trans_types.name trans_name,
// 			debtor_trans.id,
// 			debtor_trans.trans_type,
// 			debtor_trans.type_no,
// 			debtor_trans.debtor_id,
// 			debtor_master.name customer_name,
// 			debtor_trans.debtor_branch_id,
// 			debtor_branches.branch_name customer_branch,
// 			debtor_trans.trans_date,
// 			debtor_trans.due_date,
// 			debtor_trans.reference,
// 			debtor_trans.t_amount,
// 			debtor_trans.loc_code,
// 			debtor_trans.allocated_amount,
// 			debtor_trans.remarks,
// 			debtor_trans.person_id,
// 			debtor_trans.created_on
// 			');
// 		$this->db->from('debtor_trans');
// 		$this->db->join('trans_types','debtor_trans.trans_type = trans_types.trans_type');
// 		$this->db->join('debtor_master','debtor_trans.debtor_id = debtor_master.debtor_id');
// 		$this->db->join('debtor_branches','debtor_trans.debtor_branch_id = debtor_branches.debtor_branch_id','left');
// 		if (is_array($where)) {
// 			foreach ($where as $v) {
// 				if (isset($v['key']))
// 					$this->db->where($v['key'],$v['value'],$v['escape']);
// 				else
// 					$this->db->where($v);
// 			}
// 		}
// 		else
// 			$this->db->where($where);
// 		$this->db->order_by('debtor_trans.created_on ASC');
// 		if ($limit)
// 			$this->db->limit($limit);
// 		$query = $this->db->get();
// 		return $query->result();
// 	}
// 	public function update_debtor_trans($items,$where=array())
// 	{
// 		if ($where)
// 			$this->db->where($where);
// 		$this->db->update('debtor_trans',$items);
// 	}
// 	public function update_debtor_trans_set($items,$where=array())
// 	{
// 		foreach ($items as $val) {
// 			$this->db->set($val['column'],$val['value'],isset($val['escape']) ? $val['escape'] : true);
// 		}
// 		if ($where)
// 			$this->db->where($where);
// 		$this->db->update('debtor_trans');
// 	}
// 	public function write_debtor_trans_details($items,$batch=false)
// 	{
// 		if (!$batch) {
// 			$this->db->insert('debtor_trans_details',$items);
// 			return $this->db->insert_id();
// 		} else {
// 			$this->db->insert_batch('debtor_trans_details',$items);
// 		}
// 	}
// 	public function update_debtor_trans_details_set($items,$where=array())
// 	{
// 		foreach ($items as $val) {
// 			$this->db->set($val['column'],$val['value'],isset($val['escape']) ? $val['escape'] : true);
// 		}
// 		if ($where)
// 			$this->db->where($where);
// 		$this->db->update('debtor_trans_details');
// 	}
// 	public function delete_debtor_trans_details($where=null)
// 	{
// 		if ($where)
// 			if (is_array($where)) {
// 				foreach ($where as $v) {
// 					if (isset($v['key']))
// 						$this->db->where($v['key'],$v['value'],$v['escape']);
// 					else
// 						$this->db->where($v);
// 				}
// 			}
// 			else
// 				$this->db->where($where);
// 		$this->db->delete('debtor_trans_details');
// 	}
// 	public function write_payment_allocation($items,$batch=false)
// 	{
// 		if (!$batch) {
// 			$this->db->insert('payment_allocations',$items);
// 			return $this->db->insert_id();
// 		} else {
// 			$this->db->insert_batch('payment_allocations',$items);
// 		}
// 	}
// 	public function write_sales_trans_items($items,$batch=false)
// 	{
// 		if (!$batch) {
// 			$this->db->insert('sales_trans_items',$items);
// 			return $this->db->insert_id();
// 		} else {
// 			$this->db->insert_batch('sales_trans_items',$items);
// 		}
// 	}
// 	public function write_non_stock_items($items,$batch=false)
// 	{
// 		if (!$batch) {
// 			$this->db->insert('non_stock_master',$items);
// 			return $this->db->insert_id();
// 		} else {
// 			$this->db->insert_batch('non_stock_master',$items);
// 		}
// 	}
// 	public function get_non_stock_items($where=null)
// 	{
// 		$this->db->select('
// 			non_stock_master.id,
// 			non_stock_master.item_code,
// 			non_stock_master.name,
// 			non_stock_master.description,
// 			non_stock_master.item_tax_type,
// 			non_stock_master.uom_id,
// 			ifnull(sum(non_stock_moves.qty),0) qoh', false);
// 		$this->db->from('non_stock_master');
// 		$this->db->join('non_stock_moves','non_stock_master.id = non_stock_moves.item_id AND non_stock_moves.visible = 1','left');
// 		if (is_array($where)) {
// 			foreach ($where as $v) {
// 				if (isset($v['key']))
// 					$this->db->where($v['key'],$v['value'],$v['escape']);
// 				else
// 					$this->db->where($v);
// 			}
// 		}
// 		else
// 			$this->db->where($where);
// 		// $this->db->where('non_stock_moves.visible',1);
// 		$this->db->group_by('non_stock_master.id');
// 		$query = $this->db->get();
// 		return $query->result();
// 	}

// 	////////////////JED//////////////////////////////
// 	/////////////////////////////////////////////////
// 	public function get_cn_header($id=null, $type=null){
// 		$this->db->trans_start();
// 			$this->db->select('debtor_trans.*');
// 			$this->db->from('debtor_trans');
// 			if($id != null)
// 				if(is_array($id))
// 				{
// 					$this->db->where_in('debtor_trans.id',$id);
// 				}else{
// 					$this->db->where('debtor_trans.id',$id);
// 				}

// 			if($type != null)
// 				$this->db->where('debtor_trans.trans_type',$type);

// 			//$this->db->order_by('sales_orders.order_no desc');
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function add_cn_header($items){
// 		// $this->db->set('reg_date', 'NOW()', FALSE);
// 		$this->db->insert('debtor_trans',$items);
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_cn_header($items,$id)
// 	{
// 		$this->db->where('id', $id);
// 		$this->db->update('debtor_trans', $items);

// 		return $this->db->last_query();
// 	}

// 	public function get_cn_items($id=null,$cn_id=null,$item_id=null)
// 	{
// 		$this->db->trans_start();
// 			$this->db->select("*");
// 			$this->db->from('view_credit_note_items');
// 			if($id != null)
// 				if(is_array($id))
// 				{
// 					$this->db->where_in('id',$id);
// 				}else{
// 					$this->db->where('id',$id);
// 				}
// 			if($cn_id != null){
// 				$this->db->where_in('credit_note_id',$cn_id);
// 			}
// 			if($item_id != null){
// 				$this->db->where('stock_id',$item_id);
// 			}
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function write_cn_trans_items($items,$batch=false)
// 	{
// 		if (!$batch) {
// 			$this->db->insert('cn_trans_items',$items);
// 			return $this->db->insert_id();
// 		} else {
// 			$this->db->insert_batch('cn_trans_items',$items);
// 		}
// 	}
// 	public function delete_cn_trans_item($item_id)
// 	{
// 		$sql = "
// 		DELETE
// 			debtor_trans_details,
// 			stock_moves,
// 			non_stock_moves
// 		FROM
// 			debtor_trans_details
// 		LEFT JOIN stock_moves
// 		ON debtor_trans_details.stock_id = stock_moves.item_id
// 			AND debtor_trans_details.debtor_trans_type = stock_moves.trans_type
// 			AND debtor_trans_details.debtor_type_no = stock_moves.type_no
// 			AND debtor_trans_details.id = stock_moves.reference_link
// 			AND debtor_trans_details.stock_category <> '".LOCAL_ITEM."'
// 		LEFT JOIN non_stock_moves ON debtor_trans_details.stock_id = non_stock_moves .item_id
// 			AND debtor_trans_details.debtor_trans_type = non_stock_moves .trans_type
// 			AND debtor_trans_details.debtor_type_no = non_stock_moves .type_no
// 			AND debtor_trans_details.id = non_stock_moves.reference_link
// 			AND debtor_trans_details.stock_category = '".LOCAL_ITEM."'
// 		WHERE
// 			debtor_trans_details.id = ".$item_id;

// 		$this->db->query($sql);
// 	}
// 	public function get_sales_invoices($where=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('debtor_trans');
// 			if ($where)
// 			if (is_array($where)) {
// 				foreach ($where as $v) {
// 					if (isset($v['key']))
// 						$this->db->where($v['key'],$v['value'],$v['escape']);
// 					else
// 						$this->db->where($v);
// 				}
// 			}
// 			else
// 				$this->db->where('id',$where);


// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function get_invoice_items($where=null,$join_target=false){
// 		$this->db->trans_start();
// 			$this->db->select('
// 				DISTINCT
// 				`debtor_trans_type`,
// 				`debtor_type_no`,
// 				`stock_id`,
// 				`description`,
// 				`unit_price`,
// 				`unit_tax`,
// 				`uom_id`,
// 				`qty`,
// 				`discount_percentage`,
// 				`client_code`,
// 				`stock_category`,
// 				`debtor_trans`.`reference`,
// 				`debtor_trans`.`trans_date`',false);
// 			$this->db->from('debtor_trans_details');
// 			if ($join_target) {
// 				$this->db->join('debtor_trans','
// 					debtor_trans_details.debtor_trans_type = debtor_trans.tar_trans_type AND debtor_trans_details.debtor_type_no = debtor_trans.tar_type_no');
// 			} else {
// 				$this->db->join('debtor_trans','
// 					debtor_trans_details.debtor_trans_type = debtor_trans.trans_type AND debtor_trans_details.debtor_type_no = debtor_trans.type_no');
// 			}
// 			if ($where)
// 				$this->db->where($where);

// 			$this->db->order_by('debtor_trans.type_no,debtor_trans_details.id');
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function get_delivery_header($where=null,$unprocessed_only=false,$limit=null)
// 	{
// 		$this->db->select('
// 			debtor_trans.id,
// 			debtor_trans.trans_type,
// 			debtor_trans.type_no,
// 			debtor_trans.debtor_id,
// 			debtor_master.name customer_name,
// 			debtor_trans.debtor_branch_id,
// 			debtor_branches.branch_name customer_branch,
// 			debtor_trans.trans_date,
// 			debtor_trans.invoice_due_date,
// 			sales_orders.reference "so_reference",
// 			sales_orders.order_no "so_order_no",
// 			sales_orders.trans_type "so_trans_type",
// 			sales_orders.type_no "so_type_no",
// 			sales_orders.sales_type "sales_type_id",
// 			sales_types.sales_type "sales_type_name",
// 			debtor_trans.reference,
// 			debtor_trans.shipper_id,
// 			debtor_trans.t_amount,
// 			debtor_trans.t_shipping_cost,
// 			debtor_trans.loc_code,
// 			debtor_trans.allocated_amount,
// 			debtor_trans.remarks,
// 			debtor_trans.person_id,
// 			debtor_trans.created_on,
// 			debtor_trans.pr_ref,
// 			debtor_trans.si_ref,
// 			debtor_trans.dr_ref,
// 			');
// 		$this->db->from('debtor_trans');
// 		$this->db->join('debtor_master','debtor_trans.debtor_id = debtor_master.debtor_id');
// 		$this->db->join('debtor_branches','debtor_trans.debtor_branch_id = debtor_branches.debtor_branch_id','left');
// 		$this->db->join('sales_orders','debtor_trans.src_trans_type = sales_orders.trans_type AND debtor_trans.src_type_no = sales_orders.type_no');
// 		$this->db->join('sales_types','sales_orders.sales_type = sales_types.id');
// 		if (is_array($where)) {
// 			foreach ($where as $v) {
// 				if (isset($v['key']))
// 					$this->db->where($v['key'],$v['value'],$v['escape']);
// 				else
// 					$this->db->where($v);
// 			}
// 		}
// 		else
// 			$this->db->where($where);

// 		if ($unprocessed_only) {
// 			$this->db->join('debtor_trans as debtor_trans_2',
// 				'debtor_trans.trans_type = debtor_trans_2.src_trans_type AND debtor_trans.type_no = debtor_trans_2.src_type_no',
// 				'left outer');
// 			$this->db->where('debtor_trans_2.src_trans_type',null);
// 			$this->db->where('debtor_trans_2.src_type_no',null);
// 		}

// 		$this->db->order_by('debtor_trans.trans_date ASC');
// 		if ($limit)
// 			$this->db->limit($limit);
// 		$query = $this->db->get();
// 		return $query->result();
// 	}
// 	public function debtor_previous_balances($where_array=null)
// 	{
// 		$balance_array = array(DELIVERY_NOTE,SALES_INVOICE);
// 			// DATE_FORMAT(debtor_trans.trans_date,'%Y') AS year,
// 		$this->db->select("
// 			debtor_trans.debtor_id,
// 			debtor_master.debtor_code,
// 			debtor_master.name AS debtor_name,
// 			fiscal_years.end_date AS fiscal_end,
// 			SUM(IF(debtor_trans.trans_type IN (".implode(",", $balance_array)."),t_amount - IFNULL(allocated_amount,0),-(t_amount - IFNULL(allocated_amount,0))) ) AS balance
// 			",false);
// 		$this->db->from('debtor_trans');
// 		$this->db->join('debtor_master','debtor_trans.debtor_id = debtor_master.debtor_id');
// 		$this->db->join('fiscal_years','debtor_trans.trans_date >= fiscal_years.begin_date AND debtor_trans.trans_date <= fiscal_years.end_date AND fiscal_years.is_closed = 1');
// 		$this->db->where('((debtor_trans.trans_type = '.DELIVERY_NOTE.' AND debtor_trans.tar_type_no IS NULL) OR debtor_trans.trans_type != '.DELIVERY_NOTE.')',null,false);
// 		$this->db->where('t_amount <> IFNULL(allocated_amount,0)',null,false);
// 		if ($where_array) {
// 			if (is_array($where_array)) {
// 				foreach ($where_array as $key => $value) {
// 					if (isset($value['key']))
// 						$this->db->where($value['key'],$value['value'],$value['escape']);
// 					else
// 						$this->db->where($value);
// 				}
// 			} else {
// 				$this->db->where($where_array);
// 			}
// 		}
// 		$this->db->group_by("debtor_name");
// 		$this->db->group_by("fiscal_end");
// 		$this->db->order_by("debtor_name ASC");
// 		$this->db->order_by("fiscal_end ASC");
// 		$query = $this->db->get();
// 		return $query->result();
// 	}
// 	public function debtor_bal_transactions($where_array=null)
// 	{
// 		$balance_array = array(DELIVERY_NOTE,SALES_INVOICE);
// 		$this->db->select("
// 			debtor_trans.id,
// 			debtor_trans.debtor_id,
// 			debtor_master.debtor_code,
// 			debtor_master.name AS debtor_name,
// 			trans_types.name AS trans_name,
// 			debtor_trans.reference trans_ref,
// 			debtor_trans.trans_date,
// 			debtor_trans.due_date,
// 			IF(debtor_trans.trans_type IN (5,8),debtor_trans.t_amount,-debtor_trans.t_amount) AS trans_amount,
// 			IFNULL(debtor_trans.allocated_amount,0) allocated_amount",false);
// 		$this->db->from('debtor_trans');
// 		$this->db->join('debtor_master','debtor_master.debtor_id = debtor_trans.debtor_id');
// 		$this->db->join('trans_types','debtor_trans.trans_type = trans_types.trans_type');
// 		$this->db->join('fiscal_years','debtor_trans.trans_date >= fiscal_years.begin_date AND debtor_trans.trans_date <= fiscal_years.end_date AND fiscal_years.is_closed = 0');
// 		$this->db->where('((debtor_trans.trans_type = '.DELIVERY_NOTE.' AND debtor_trans.tar_type_no IS NULL) OR debtor_trans.trans_type != '.DELIVERY_NOTE.')',null,false);
// 		if ($where_array) {
// 			if (is_array($where_array)) {
// 				foreach ($where_array as $key => $value) {
// 					if (isset($value['key']))
// 						$this->db->where($value['key'],$value['value'],$value['escape']);
// 					else
// 						$this->db->where($value);
// 				}
// 			} else {
// 				$this->db->where($where_array);
// 			}
// 		}
// 		$this->db->order_by("debtor_name ASC");
// 		$this->db->order_by("debtor_trans.id ASC");
// 		$query = $this->db->get();
// 		return $query->result();
// 	}
// 	public function write_bank_trans($items)
// 	{
// 		$this->db->insert('bank_trans',$items);
// 		$insert_id = $this->db->insert_id();
// 		return $insert_id;
// 	}
// 	public function write_cheque_details($items)
// 	{
// 		$this->db->insert('cheque_details',$items);
// 		$insert_id = $this->db->insert_id();
// 		return $insert_id;
// 	}
// 	//-----------SALES MAINTENANCE FUNCTIONS----------START
	
// 	//----------CUSTOMER MASTER----------START
// 	public function get_customer_master($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('customer_master');
// 			if($id != null)
// 				$this->db->where('cust_id',$id);
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function customer_code_exist_add_mode($cust_code=null){
// 		$sql = "SELECT * FROM customer_master WHERE cust_code = '$cust_code'";
// 		$query = mysql_query($sql);
// 		if(mysql_num_rows($query) == 0)
// 			return false;
// 		return true;
// 	}
// 	public function customer_code_exist_edit_mode($cust_code=null, $id=null){
// 		$sql = "SELECT * FROM customer_master WHERE cust_code = '$cust_code' AND cust_id != $id";
// 		$query = mysql_query($sql);
// 		if(mysql_num_rows($query) == 0)
// 			return false;
// 		return true;
// 	}
// 	public function add_customer($items){
// 		$this->db->insert('customer_master',$items);
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_customer($items,$cust_id){
// 		$this->db->where('cust_id', $cust_id);
// 		$this->db->update('customer_master', $items);

// 		return $this->db->last_query();
// 	}
// 	//----------CUSTOMER MASTER----------END
	
// //----------CUSTOMER CARD TYPES----------START-rhan

// public function get_customer_card_types($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('customer_card_types');
// 			if($id != null)
// 				$this->db->where('id',$id);
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function customer_card_types_exist_add_mode($name=null){
// 		$sql = "SELECT * FROM customer_card_types WHERE name = '$name'";
// 		$query = mysql_query($sql);
// 		if(mysql_num_rows($query) == 0)
// 			return false;
// 		return true; 
// 	}
// 	public function customer_card_types_exist_edit_mode($name=null, $id=null){
// 		$sql = "SELECT * FROM customer_card_types WHERE name = '$name' AND id != $id";
// 		$query = mysql_query($sql);
// 		if(mysql_num_rows($query) == 0)
// 			return false;
// 		return true;
// 	}
// 	public function add_customer_card_types($items){
// 		$this->db->insert('customer_card_types',$items);
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_customer_card_types($user,$id){
// 		$this->db->where('id', $id);
// 		$this->db->update('customer_card_types', $user);

// 		return $this->db->last_query();
// 	}

// //----------CUSTOMER CARD TYPES----------END-rhan

// //----------CUSTOMER CARD ----------START-rhan

// 	public function get_cust_cards($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('customer_cards');
// 			if($id != null)
// 				$this->db->where('id',$id);
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
	
// 		//Insert to DB
// 	public function add_customer_card($items)
// 	{
// 		$this->db->insert('customer_cards',$items);
// 		return $this->db->insert_id();
// 	}
// 	//Update DB
// 	public function update_customer_card($items,$id){
// 		$this->db->where('id', $id);
// 		$this->db->update('customer_cards', $items);
// 	}
	
// 	//validate product code
// 	public function cust_card_exist_add_mode($cust_code=null,$card_type=null){
// 		$sql = "SELECT * FROM customer_cards WHERE cust_id= '$cust_code' AND card_type ='$card_type' ";
// 		//echo $sql;
// 		$query = mysql_query($sql);
// 		if(mysql_num_rows($query) == 0)
// 			return false;
// 		return true;
// 	}
// 	public function cust_card_exist_edit_mode($cust_code=null,$card_type=null,$id=null){
// 		$sql = "SELECT * FROM customer_cards WHERE cust_id= '$cust_code' AND card_type ='$card_type' AND id != $id";
// 		$query = mysql_query($sql);
// 		if(mysql_num_rows($query) == 0)
// 			return false;
// 		return true;
// 	}
	
// 		public function customer_name($id){
// 		$sql = "SELECT description FROM customer_master WHERE cust_id = $id ";
// 		$query = $this->db->query($sql);
// 		$row = $query->row();
// 		if ($row != null)
// 		return $row->description;
// 		return false;
// 	}
// 		public function card_type_desc($id){
// 		$sql = "SELECT description FROM customer_card_types WHERE id = $id ";
// 		$query = $this->db->query($sql);
// 		$row = $query->row();
// 		if ($row != null)
// 		return $row->description;
// 		return false;
// 	}

// //----------CUSTOMER CARD----------END-rhan

// //----------SALES PERSON MASTER-----MHAE-----START
// 	public function get_sales_person_master($id=null){
// 		$this->db->trans_start();
// 			$this->db->select('*');
// 			$this->db->from('sales_person_master');
// 			if($id != null)
// 				$this->db->where('id',$id);
// 			$query = $this->db->get();
// 			$result = $query->result();
// 		$this->db->trans_complete();
// 		return $result;
// 	}
// 	public function sales_person_name_exist_add_mode($name=null){
// 		$sql = "SELECT * FROM sales_person_master WHERE name = '$name'";
// 		$query = mysql_query($sql);
// 		if(mysql_num_rows($query) == 0)
// 			return false;
// 		return true;
// 	}
// 	public function sales_person_name_exist_edit_mode($name=null, $id=null){
// 		$sql = "SELECT * FROM sales_person_master WHERE name = '$name' AND id != $id";
// 		$query = mysql_query($sql);
// 		if(mysql_num_rows($query) == 0)
// 			return false;
// 		return true;
// 	}
// 	public function add_sales_person($items){
// 		$this->db->insert('sales_person_master',$items);
// 		$x=$this->db->insert_id();
// 		return $x;
// 	}
// 	public function update_sales_person($items,$cust_id){
// 		$this->db->where('id', $cust_id);
// 		$this->db->update('sales_person_master', $items);

// 		return $this->db->last_query();
// 	}
// 	//----------CUSTOMER MASTER-----MHAE-----END
// 	//-----------SALES MAINTENANCE FUNCTIONS----------END
 }

?>