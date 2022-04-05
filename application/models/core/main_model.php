<?php
	ini_set('MAX_EXECUTION_TIME', -1);
	class Main_model extends CI_Model {
		var $mb;	
		var $mb2;	
		public function __construct(){
			parent::__construct();
			$this->mb = $this->load->database('default',true); //yung name ng main db sa database.php
		}
		
		
		public function set_mb2($branch_code=null)
		{
			// odbc_close_all();
			switch($branch_code){
				case 'srs_nova':
				$this->mb2 = $this->load->database('srs_nova',TRUE);
				break;
				case 'srs_tondo':
				$this->mb2 = $this->load->database('srs_tondo',TRUE);
				break;
				// case 'srsnav':
				// $this->mb2 = $this->load->database('srsm_navo',TRUE);
				// break;
				// case 'srst':
				// $this->mb2 = $this->load->database('srsm_ton',TRUE);
				// break;
				// case 'srsc':
				// $this->mb2 = $this->load->database('srsm_cama',TRUE);
				// break;
				// case 'srsant1':
				// $this->mb2 = $this->load->database('srsm_ant1gf',TRUE);
				// break;
				// case 'srsant2':
				// $this->mb2 = $this->load->database('srsm_ant2em',TRUE);
				// break;
				// case 'srsm':
				// $this->mb2 = $this->load->database('srsm_mala',TRUE);
				// break;
				// case 'srsg':
				// $this->mb2 = $this->load->database('srsm_gal',TRUE);
				// break;
				// case 'srscain':
				// $this->mb2 = $this->load->database('srsm_cainta',TRUE);
				// break;
				// case 'srsval':
				// $this->mb2 = $this->load->database('srsm_val',TRUE);
				// break;			
				// case 'datacenter':
				// $this->mb2 = $this->load->database('srs_datacenter',TRUE);
				// break;
			}
			return $this->mb2->initialize();
		}
		//rhan start reject schedule markdown
		
		public function approved_stock_deletion($stock_id=null,$user=null,$id=null){
			
			
			$sql = "SELECT branch_no_con FROM stock_deletion_approval WHERE id = '$id' ";
			$query = $this->db->query($sql);
			$row = $query->row();
			$name = explode('|',$row->branch_no_con);
			$branch_name = array();
			if ($row->branch_no_con != ''){
				$num_branch = count($name);
				$total = $num_branch;
				$branch = array();
				$num =0;
				while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
				}
				}else{
				
				$branch = array('default');
				$test = $this->get_all_branches();
				foreach($test as $val){
					array_push ($branch,$val->code);		
				}
				$num_branch = count($branch);	
				
				
				$num_branch = count($branch);	
				$num =0;
				while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					
					if($connected){
						$sql1="UPDATE stock_master_new SET inactive  = '1' WHERE stock_id=".$stock_id;	
						$results_query = mysql_query($sql1);
						
						}else{
						if($branch_name == null){
							array_push($branch_name,$branch[$num-1]);
							}else{
							array_push($branch_name,'|'.$branch[$num-1]);	
						}
					}
				}
				$branch_name_con =  implode($branch_name);	
				$bdb = $this->load->database('default',TRUE);
				$cons = $bdb->initialize();
				$date = date('Y-m-d');
				if($branch_name_con == ''){
					$sql11 = "UPDATE stock_deletion_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
					mysql_query($sql11);
					echo 'success';
					}else{
					$sql11 = "UPDATE stock_deletion_approval SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
					mysql_query($sql11);		
					echo 'success';
				}
				
				
			}
		}
		//rhan end
		
		
		public function get_branch_code($id=null){
			$sql= "SELECT code FROM branches WHERE id = ".$id;
			$query = mysql_query($sql);
			$result = mysql_fetch_object($query); 
			return $result->code;
			//return $sql ;
		}
		
		public function get_supplier_name($id=null){
			$sql = "SELECT supp_name FROM supplier_master WHERE supplier_id=".$id;
			$query = mysql_query($sql);
			$result = mysql_fetch_object($query); 
			return $result->supp_name;
		}
		public function get_stock_code($id=null){
			$sql= "SELECT stock_code FROM stock_master_new WHERE stock_id = ".$id;
			$query = mysql_query($sql);
			$result = mysql_fetch_object($query); 
			return $result->stock_code;
			//return $sql ;
		}
		
		public function get_sales_type_desc($id=null){
			$sql= "SELECT sales_type FROM sales_types WHERE id = ".$id;
			$query = mysql_query($sql);
			$result = mysql_fetch_object($query); 
			return $result->sales_type;
			//return $sql ;
		}
		//multiple updates approval
		
		public function multiple_updates_approvals($update_ids = array(),$user = null){
			$ids = count($update_ids);
			$counter = 0;
			while($counter != $ids){
				$data = explode (':', $update_ids[$counter]);
				$id = $data[0];
				if($data[1] != 'All'){
					$branch_code  = $this->get_branch_code($data[1]);
				}
				$branch = $data[1];
				$type = $data[2];
				
				$sql='SELECT * FROM stock_logs WHERE id='.$id;
				$query = mysql_query($sql);
				$res = mysql_fetch_object($query);
				$branch_name = array();
				
				switch($type){
					
					case 'Update Stock Master Details':	
					
					$sql = "SELECT branch_no_con FROM stock_logs WHERE id = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
						$num_branch = count($name);
						$total = $num_branch;
						$branch = array();
						$num =0;
						while($total != $num){
							array_push($branch,$name[$num]);
							$num++;	
						}
						}else{
						
						$branch = array('default');
						$test = $this->get_all_branches();
						foreach($test as $val){
							array_push ($branch,$val->code);		
						}
						$num_branch = count($branch);	
						
					}
					
					$num_branch = count($branch);	
					$num =0;
					while($num_branch != $num){
						$num = $num + 1;
						$bdb = $this->load->database($branch[$num-1],TRUE);
						$connected = $bdb->initialize();
						
						if($connected){
							
							$need_to_update = explode('||',$res->affected_field_values);
							$no_need_to_update =  count($need_to_update);
							$sample = array();
							$nums=0; 
							//	return $no_need_to_update;
							while($no_need_to_update != $nums){
								array_push($sample ,$nums);
								$nums = $nums + 1;
								$fields_and_data = explode(':',$need_to_update[$nums-1]);
								$old_and_new_datas = explode('|',$fields_and_data[1]); 
								$old_data = $old_and_new_datas[0];
								$new_data = $old_and_new_datas[1];
								$fields = $fields_and_data[0];
								
								
								if (strpos($fields,'disc') !== false) {
									$disc  = explode('_',$fields);
									
									$sql_disc = "SELECT * FROM pos_discounts WHERE short_desc='".$disc[0]."'";
									$query = mysql_query($sql_disc);
									$result = mysql_fetch_object($query);
									$rows = mysql_num_rows($query);
									//	return $res->stock_id.' '.$result->id.' '.$new_data;
									
									if($rows){
										//$sql="UPDATE pos_stock_discounts SET disc_enabled = '".$new_data."' WHERE stock_id=".$res->stock_id." AND pos_discount_id =".$result->id;	
										$sql = "INSERT INTO pos_stock_discounts (stock_id,sales_type_id,pos_discount_id,disc_enabled) VALUES (".$res->stock_id.",'1',".$result->id.",".$new_data.")
										ON DUPLICATE KEY UPDATE disc_enabled=".$new_data;
										mysql_query($sql);
										
									}
									
									}elseif(strpos($fields,'crd') !== false){
									
									$disc  = explode('_',$fields);
									$sql_disc = "SELECT * FROM customer_card_types WHERE name ='".$disc[0]."'";
									$query = mysql_query($sql_disc);
									$results = mysql_fetch_object($query);
									$rows = mysql_num_rows($query);
									
									if($rows){
										$sql = "INSERT INTO pos_stock_cards (stock_id,sales_type_id,card_type_id,is_enabled) VALUES (".$res->stock_id.",'1',".$results->id.",".$new_data.")
										ON DUPLICATE KEY UPDATE is_enabled=".$new_data;
										mysql_query($sql);
									}
									}else{
									$sql1="UPDATE stock_master_new SET ".$fields." = '".$new_data."' WHERE stock_id=".$res->stock_id;	
									$results_query = mysql_query($sql1);	
								}
								
								
								// if($fields == 'PWD_disc'){
								// $sql="UPDATE pos_stock_discounts SET disc_enabled = '".$new_data."' WHERE stock_id=".$res->stock_id." AND pos_discount_id = 1 ";	
								// mysql_query($sql);
								// }elseif($fields == 'SC_disc'){
								// $sql="UPDATE pos_stock_discounts SET disc_enabled = '".$new_data."' WHERE stock_id=".$res->stock_id." AND pos_discount_id = 2 ";	
								// mysql_query($sql);
								
								// }else{
								// $sql1="UPDATE stock_master_new SET ".$fields." = '".$new_data."' WHERE stock_id=".$res->stock_id;	
								// $results_query = mysql_query($sql1);
								// }
							}
							
							}else{
							
							if($branch_name == null){
								array_push($branch_name,$branch[$num-1]);
								}else{
								array_push($branch_name,'|'.$branch[$num-1]);	
							}
						}
						
					}
					$branch_name_con =  implode($branch_name);	
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$date = date('Y-m-d');
					if($branch_name_con == ''){
						$sql11 = "UPDATE stock_logs SET approval_status = '1' , date_checked = '".$date."', approved_by = '".$user."' WHERE id = '$id' ";
						mysql_query($sql11);
						echo 'success';
						}else{
						$sql11 = "UPDATE stock_logs SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
						mysql_query($sql11);		
						//	return 'no_con||unable to update '.$branch_name_con.' no connection' ;
						echo 'success';
					}
					
					break;
					
					case 'Update All Supplier Stock Details':	
					
					$sql = "SELECT branch_no_con FROM stock_logs WHERE id = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
						$num_branch = count($name);
						$total = $num_branch;
						$branch = array();
						$num =0;
						while($total != $num){
							array_push($branch,$name[$num]);
							$num++;	
						}
						}else{
						
						$branch = array('default');
						$test = $this->get_all_branches();
						foreach($test as $val){
							array_push ($branch,$val->code);		
						}
						$num_branch = count($branch);		
						
					}
					
					$num_branch = count($branch);	
					$num =0;
					while($num_branch != $num){
						$num = $num + 1;
						$bdb = $this->load->database($branch[$num-1],TRUE);
						$connected = $bdb->initialize();
						if($connected){
							
							$need_to_update = explode('||',$res->affected_field_values);
							$no_need_to_update =  count($need_to_update);
							$sample = array();
							$nums=0; 
							//	return $no_need_to_update;
							while($no_need_to_update != $nums){
								array_push($sample ,$nums);
								$nums = $nums + 1;
								$fields_and_data = explode(':',$need_to_update[$nums-1]);
								$old_and_new_datas = explode('|',$fields_and_data[1]); 
								$old_data = $old_and_new_datas[0];
								$new_data = $old_and_new_datas[1];
								$fields = $fields_and_data[0];
								
								$sql1="UPDATE supplier_stocks SET ".$fields." = '".$new_data."' WHERE  supp_id =".$res->supplier_stock_code." AND stock_id=".$res->stock_id;	
								mysql_query($sql1);
								
							}
							
							}else{
							
							if($branch_name == null){
								array_push($branch_name,$branch[$num-1]);
								}else{
								array_push($branch_name,'|'.$branch[$num-1]);	
							}
						}
						
					}
					$branch_name_con =  implode($branch_name);	
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$date = date('Y-m-d');
					if($branch_name_con == ''){
						$sql11 = "UPDATE stock_logs SET approval_status = '1' , date_checked = '".$date."', approved_by = '".$user."' WHERE id = '$id' ";
						mysql_query($sql11);
						//	return 'success';
						//	echo 'success';
						}else{
						$sql11 = "UPDATE stock_logs SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
						mysql_query($sql11);		
						//	echo 'success';
						//	return 'no_con||unable to update '.$branch_name_con.' no connection' ;
						//	return $sql11;
					}
					
					
					
					break;
					
					case 'Update Supplier Stock Details':
					
					$sql='SELECT * FROM stock_logs WHERE id='.$id;
					$query = mysql_query($sql);
					$res = mysql_fetch_object($query);
					
					$bdb = $this->load->database($branch_code,TRUE);
					$connected = $bdb->initialize();
					if($connected){
						
						$nums = 0;
						$need_to_update = explode('||',$res->affected_field_values);
						$no_need_to_update =  count($need_to_update);
						while($no_need_to_update != $nums){
							
							$nums = $nums + 1;
							$fields_and_data = explode(':',$need_to_update[$nums-1]);
							$old_and_new_datas = explode('|',$fields_and_data[1]); 
							$old_data = $old_and_new_datas[0];
							$new_data = $old_and_new_datas[1];
							$fields = $fields_and_data[0];
							
							$bdb = $this->load->database($branch_code,TRUE);
							$connected = $bdb->initialize();
							
							$sql1="UPDATE supplier_stocks SET ".$fields." = '".$new_data."' WHERE  supp_id =".$res->supplier_stock_code." AND stock_id=".$res->stock_id;	
							mysql_query($sql1);	
							
							$bdd = $this->load->database('default',TRUE);
							$connected = $bdd->initialize();
							
							$sqllocal="UPDATE supplier_stocks SET ".$fields." = '".$new_data."' WHERE stock_id = ".$res->stock_id." AND branch_id=".$branch;	
							mysql_query($sqllocal);	
							
							
						}
						
						$bdb = $this->load->database('default',TRUE);
						$connected = $bdb->initialize();
						$date = date('Y-m-d');
						$sqlupdate = "UPDATE stock_logs SET approval_status = '1' , date_checked = '".$date."', approved_by = '".$user."' WHERE id = '$id' ";
						$results = mysql_query($sqlupdate);
						//	return 'success';
						
						
						}else{
						$sql11 = "UPDATE stock_logs SET branch_no_con = '$branch'  WHERE id = '$id' ";
						mysql_query($sql11);		
						//return 'no_con||unable to update '.$branch.' no connection' ;
						//	return $sql11;
					}
					
					
					
					break;
					
					
				}
				
				$counter++;
			}
		}
		
		//end
		public function get_branch_id($code=null){
			$sql= "SELECT id FROM branches WHERE code = '".$code."' ";
			$query = mysql_query($sql);
			$result = mysql_fetch_object($query); 
			return $result->id;
			//return $sql;
		}
		
		//rhan start multiple barcode_prices_approval
		public function multiple_barcode_prices_updates_approvals($update_ids = array(),$user = null){
			$ids = count($update_ids);
			$counter = 0;
			
			while($counter != $ids){
				
				$barcode_price_details = explode(':',$update_ids[$counter]);
				$stock_id  = $barcode_price_details[0];
				$barcode  = $barcode_price_details[1];
				$sales_type  = $barcode_price_details[2];
				$affected  = $barcode_price_details[3];
				$id  = $barcode_price_details[4];
				
				
				$fields_and_data = explode('||',$affected);
				$fields = $fields_and_data[0];
				$update_data =  $fields_and_data[1];
				
				
				if(strpos($fields,'*') !== false){
					
					//return $update_data.' '.$fields;
					$fields_branch = explode('*',$fields);
					$branch = $fields_branch[0];
					$field = $fields_branch[1];
					
					if($branch == 'All'){
						
						$sql = "SELECT branch_no_con FROM stock_barcode_prices_approval WHERE id =".$id;
						$query = $this->db->query($sql);
						$row = $query->row();
						$name = explode('|',$row->branch_no_con);
						$branch_name = array();
						if ($row->branch_no_con != ''){
							$num_branch = count($name);
							$total = $num_branch;
							$branch = array();
							$num =0;
							while($total != $num){
								array_push($branch,$name[$num]);
								$num++;	
							}
							}else{
							
							$branch = array('default');
							$test = $this->get_all_branches();
							foreach($test as $val){
								array_push ($branch,$val->code);		
							}
							$num_branch = count($branch);	
							
						}
						
						$num_branch = count($branch);	
						$num =0;
						while($num_branch != $num){
							$num = $num + 1;
							$bdb = $this->load->database($branch[$num-1],TRUE);
							$connected = $bdb->initialize();
							
							if($connected){
								$old_new_data = explode('|',$update_data);
								$new_data = $old_new_data[1];
								if($field == 'prevailing_unit_price'){
									$sql1 = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data.",price = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type;
									$res =  mysql_query($sql1);
									}else{
									$sql1 = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type;
									$res =  mysql_query($sql1);
								}
								
								}else{
								if($branch_name == null){
									array_push($branch_name,$branch[$num-1]);
									}else{
									array_push($branch_name,'|'.$branch[$num-1]);	
								}
							}
							
						}
						$branch_name_con =  implode($branch_name);	
						$bdb = $this->load->database('default',TRUE);
						$cons = $bdb->initialize();
						$date = date('Y-m-d');
						if($branch_name_con == ''){
							$sql11 = "UPDATE stock_barcode_prices_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
							$res = mysql_query($sql11);
							//return $res;
							//return 'success';
							}else{
							$sql11 = "UPDATE stock_barcode_prices_approval SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
							mysql_query($sql11);		
							//return 'no_con||unable to update '.$branch_name_con.' no connection' ;
							//return $sql11;
						}
						
						}else{
						
						$bdb = $this->load->database($branch,TRUE);
						$connected = $bdb->initialize();
						
						if($connected){
							$old_new_data = explode('|',$update_data);
							$new_data = $old_new_data[1];
							$branch_id = $this->get_branch_id($branch);
							if($field == 'prevailing_unit_price'){
								$sql1 = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data.", price = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type." AND branch_id =".$branch_id."";
								mysql_query($sql1);
								
							}else{
								$sql1 = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type." AND branch_id =".$branch_id."";
								mysql_query($sql1);
							}
							$b = $this->load->database('default',TRUE);
							$b->initialize();
							
							if($field == 'prevailing_unit_price'){
								$sqldef = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data." , price = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type." AND branch_id =".$branch_id."";
								mysql_query($sqldef);
								//return $sqldef;		
							
							}else{
								$sqldef = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type." AND branch_id =".$branch_id."";
								mysql_query($sqldef);
								//return $sqldef;	
							}
							
							$date = date('Y-m-d');
							$sqlUP = "UPDATE stock_barcode_prices_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
							$res = mysql_query($sqlUP);
							//return $res;		
							
							}else{
							$sql11 = "UPDATE stock_barcode_prices_approval SET branch_no_con = '$branch'  WHERE id = '$id' ";
							mysql_query($sql11);	
							//	return $sql11;
							
						}
						
						
						//-------single branch
					}
					
					
					
					
					}else if (strpos($fields,'price') !== false) {
					$branch_price = explode('_',$fields);
					$old_new_data = explode('|',$update_data);
					$new_data = $old_new_data[1];
					$branch =  $branch_price[0].'_'.$branch_price[1];
					$branch_id = $this->get_branch_id($branch);
					
					$bdb = $this->load->database($branch,TRUE);
					$connected = $bdb->initialize();	
					if($connected){
						$sql1 = "UPDATE stock_barcode_prices SET price = '".$new_data."' WHERE branch_id =".$branch_id." AND sales_type_id=".$sales_type." AND barcode = ".$barcode." ";
						$res =  mysql_query($sql1);
						$dbd = $this->load->database('default',TRUE);
						$connected = $dbd->initialize();	
						$sqldef = "UPDATE stock_barcode_prices SET price = '".$new_data."' WHERE branch_id =".$branch_id." AND sales_type_id=".$sales_type." AND barcode = ".$barcode." ";
						$res =  mysql_query($sqldef);
						
						$date = date('Y-m-d');
						$sqlup = "UPDATE stock_barcode_prices_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
						$res = mysql_query($sqlup);
						
						}else{
						$branch_price = explode('_',$fields);
						$branch =  $branch_price[0].'_'.$branch_price[1];
						$sql11 = "UPDATE stock_barcode_prices_approval SET branch_no_con = '$branch'  WHERE id = '$id' ";
						mysql_query($sql11);		
						//	return 'no_con||unable to update '.$branch.' no connection' ;
					}
					
					
					
					}else{
					
					$sql = "SELECT branch_no_con FROM stock_barcode_prices_approval WHERE id =".$id;
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					$branch_name = array();
					if ($row->branch_no_con != ''){
						$num_branch = count($name);
						$total = $num_branch;
						$branch = array();
						$num =0;
						while($total != $num){
							array_push($branch,$name[$num]);
							$num++;	
						}
						}else{
						
						$branch = array('default');
						$test = $this->get_all_branches();
						foreach($test as $val){
							array_push ($branch,$val->code);		
						}
						$num_branch = count($branch);	
						
					}
					
					$num_branch = count($branch);	
					$num =0;
					while($num_branch != $num){
						$num = $num + 1;
						$bdb = $this->load->database($branch[$num-1],TRUE);
						$connected = $bdb->initialize();
						
						if($connected){
							$old_new_data = explode('|',$update_data);
							$new_data = $old_new_data[1];
							$sql1 = "UPDATE stock_barcodes_new SET ".$fields." = '".$new_data."' WHERE barcode ='".$barcode."' AND stock_id=".$stock_id;
							$res =  mysql_query($sql1);
							}else{
							
							if($branch_name == null){
								array_push($branch_name,$branch[$num-1]);
								}else{
								array_push($branch_name,'|'.$branch[$num-1]);	
							}
						}
						
					}
					$branch_name_con =  implode($branch_name);	
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$date = date('Y-m-d');
					if($branch_name_con == ''){
						$sql11 = "UPDATE stock_barcode_prices_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
						$res = mysql_query($sql11);
						//return $res;
						//return 'success';
						}else{
						$sql11 = "UPDATE stock_barcode_prices_approval SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
						mysql_query($sql11);		
						//return 'no_con||unable to update '.$branch_name_con.' no connection' ;
						//return $sql11;
					}
					
					
					
				}
				$counter++;
			}
		}
		//rhan end
		
		//rhan start update_barcode_prices_approval
		public function update_barcode_prices_approval($stock_id=null,$barcode=null,$sales_type=null,$affected=null,$id=null,$user=null){
			//return $sales_type;
			$fields_and_data = explode('||',$affected);
			$fields = $fields_and_data[0];
			$update_data =  $fields_and_data[1];
			
			if(strpos($fields,'*') !== false){
				
				//return $update_data.' '.$fields;
				$fields_branch = explode('*',$fields);
				$branch = $fields_branch[0];
				$field = $fields_branch[1];
				
				if($branch == 'All'){
					
					$sql = "SELECT branch_no_con FROM stock_barcode_prices_approval WHERE id =".$id;
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					$branch_name = array();
					if ($row->branch_no_con != ''){
						$num_branch = count($name);
						$total = $num_branch;
						$branch = array();
						$num =0;
						while($total != $num){
							array_push($branch,$name[$num]);
							$num++;	
						}
						}else{
						
						$branch = array('default');
						$test = $this->get_all_branches();
						foreach($test as $val){
							array_push ($branch,$val->code);		
						}
						$num_branch = count($branch);	
						
					}
					
					$num_branch = count($branch);	
					$num =0;
					while($num_branch != $num){
						$num = $num + 1;
						$bdb = $this->load->database($branch[$num-1],TRUE);
						$connected = $bdb->initialize();
						
						if($connected){
							$old_new_data = explode('|',$update_data);
							$new_data = $old_new_data[1];
							if($field == 'prevailing_unit_price'){
								$sql1 = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data.", price = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type;
								$res =  mysql_query($sql1);
								}else{
									$sql1 = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type;
									$res =  mysql_query($sql1);
							}
							
							}else{
							if($branch_name == null){
								array_push($branch_name,$branch[$num-1]);
							}else{
								array_push($branch_name,'|'.$branch[$num-1]);	
							}
						}
						
					}
					$branch_name_con =  implode($branch_name);	
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$date = date('Y-m-d');
					if($branch_name_con == ''){
						$sql11 = "UPDATE stock_barcode_prices_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
						$res = mysql_query($sql11);
						return $res;
						//return 'success';
						}else{
						$sql11 = "UPDATE stock_barcode_prices_approval SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
						mysql_query($sql11);		
						return 'no_con||unable to update '.$branch_name_con.' no connection' ;
						return $sql11;
					}
					
					}else{
					
					$bdb = $this->load->database($branch,TRUE);
					$connected = $bdb->initialize();
					
					if($connected){
						$old_new_data = explode('|',$update_data);
						$new_data = $old_new_data[1];
						$branch_id = $this->get_branch_id($branch);
						
						if($field == 'prevailing_unit_price'){
							$sql1 = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data.", price = ".$field." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type." AND branch_id =".$branch_id."";
							mysql_query($sql1);
						}else{
							$sql1 = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type." AND branch_id =".$branch_id."";
							mysql_query($sql1);
						}
					
					
					$b = $this->load->database('default',TRUE);
					$b->initialize();
					
					if($field == 'prevailing_unit_price'){
					
						$sqldef = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data.",price = ".$field." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type." AND branch_id =".$branch_id."";
						mysql_query($sqldef);
						//return $sqldef;		
					
					}else{
						$sqldef = "UPDATE stock_barcode_prices SET ".$field." = ".$new_data." WHERE barcode ='".$barcode."' AND sales_type_id=".$sales_type." AND branch_id =".$branch_id."";
						mysql_query($sqldef);
					}
					
					$date = date('Y-m-d');
					$sqlUP = "UPDATE stock_barcode_prices_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
					$res = mysql_query($sqlUP);
					return $res;		
					
					}else{
					$sql11 = "UPDATE stock_barcode_prices_approval SET branch_no_con = '$branch'  WHERE id = '$id' ";
					mysql_query($sql11);	
					return $sql11;
					
					}
					
					
					//-------single branch
					}
					
					
					
					
					}
					else if (strpos($fields,'price') !== false) {
					$branch_price = explode('_',$fields);
					$old_new_data = explode('|',$update_data);
					$new_data = $old_new_data[1];
					$branch =  $branch_price[0].'_'.$branch_price[1];
					$branch_id = $this->get_branch_id($branch);
					
					$bdb = $this->load->database($branch,TRUE);
					$connected = $bdb->initialize();	
					if($connected){
					$sql1 = "UPDATE stock_barcode_prices SET price = '".$new_data."' WHERE branch_id =".$branch_id." AND sales_type_id=".$sales_type." AND barcode = ".$barcode." ";
					$res =  mysql_query($sql1);
					$dbd = $this->load->database('default',TRUE);
					$connected = $dbd->initialize();	
					$sqldef = "UPDATE stock_barcode_prices SET price = '".$new_data."' WHERE branch_id =".$branch_id." AND sales_type_id=".$sales_type." AND barcode = ".$barcode." ";
					$res =  mysql_query($sqldef);
					$date = date('Y-m-d');
					$sqlup = "UPDATE stock_barcode_prices_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
					$resss = mysql_query($sqlup);
					
					return $resss;
					}else{
					$branch_price = explode('_',$fields);
					$branch =  $branch_price[0].'_'.$branch_price[1];
					$sql11 = "UPDATE stock_barcode_prices_approval SET branch_no_con = '$branch'  WHERE id = '$id' ";
					mysql_query($sql11);		
					return 'no_con||unable to update '.$branch.' no connection' ;
					}
					
					
					
					}else{
					
					$sql = "SELECT branch_no_con FROM stock_barcode_prices_approval WHERE id =".$id;
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					$branch_name = array();
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					
					$branch = array('default');
					$test = $this->get_all_branches();
					foreach($test as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);	
					
					}
					
					$num_branch = count($branch);	
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					
					if($connected){
					$old_new_data = explode('|',$update_data);
					$new_data = $old_new_data[1];
					$sql1 = "UPDATE stock_barcodes_new SET ".$fields." = '".$new_data."' WHERE barcode ='".$barcode."' AND stock_id=".$stock_id;
					$res =  mysql_query($sql1);
					}else{
					
					if($branch_name == null){
					array_push($branch_name,$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
					}
					
					}
					$branch_name_con =  implode($branch_name);	
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$date = date('Y-m-d');
					if($branch_name_con == ''){
					$sql11 = "UPDATE stock_barcode_prices_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
					$res = mysql_query($sql11);
					return $res;
					//return 'success';
					}else{
					$sql11 = "UPDATE stock_barcode_prices_approval SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
					mysql_query($sql11);		
					return 'no_con||unable to update '.$branch_name_con.' no connection' ;
					return $sql11;
					}
					
					
					}
					
					}
					//rhan end
					
					public function updates_approvals($branch_ids=null,$branch=null,$id=null,$user=null){
					
					$sql='SELECT * FROM stock_logs WHERE id='.$id;
					$query = mysql_query($sql);
					$res = mysql_fetch_object($query);
					$branch_name = array();
					
					switch($res->type){
					
					case 'Update Stock Master Details':	
					
					$sql = "SELECT branch_no_con FROM stock_logs WHERE id = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					
					$branch = array('default');
					$test = $this->get_all_branches();
					foreach($test as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);	
					
					}
					
					$num_branch = count($branch);	
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					
					if($connected){
					
					$need_to_update = explode('||',$res->affected_field_values);
					$no_need_to_update =  count($need_to_update);
					$sample = array();
					$nums=0; 
					//	return $no_need_to_update;
					while($no_need_to_update != $nums){
					array_push($sample ,$nums);
					$nums = $nums + 1;
					$fields_and_data = explode(':',$need_to_update[$nums-1]);
					$old_and_new_datas = explode('|',$fields_and_data[1]); 
					$old_data = $old_and_new_datas[0];
					$new_data = $old_and_new_datas[1];
					$fields = $fields_and_data[0];
					
					//return $fields;
					if (strpos($fields,'disc') !== false) {
					$disc  = explode('_',$fields);
					
					$sql_disc = "SELECT * FROM pos_discounts WHERE short_desc='".$disc[0]."'";
					$query = mysql_query($sql_disc);
					$result = mysql_fetch_object($query);
					$rows = mysql_num_rows($query);
					//	return $res->stock_id.' '.$result->id.' '.$new_data;
					
					if($rows){
					//$sql="UPDATE pos_stock_discounts SET disc_enabled = '".$new_data."' WHERE stock_id=".$res->stock_id." AND pos_discount_id =".$result->id;	
					$sql = "INSERT INTO pos_stock_discounts (stock_id,sales_type_id,pos_discount_id,disc_enabled) VALUES (".$res->stock_id.",'1',".$result->id.",".$new_data.")
					ON DUPLICATE KEY UPDATE disc_enabled=".$new_data;
					mysql_query($sql);
					
					}
					
					
					}elseif(strpos($fields,'crd') !== false){
					
					$disc  = explode('_',$fields);
					$sql_disc = "SELECT * FROM customer_card_types WHERE name ='".$disc[0]."'";
					$query = mysql_query($sql_disc);
					$results = mysql_fetch_object($query);
					$rows = mysql_num_rows($query);
					
					if($rows){
					$sql = "INSERT INTO pos_stock_cards (stock_id,sales_type_id,card_type_id,is_enabled) VALUES (".$res->stock_id.",'1',".$results->id.",".$new_data.")
					ON DUPLICATE KEY UPDATE is_enabled=".$new_data;
					mysql_query($sql);
					}
					}else{
					$sql1="UPDATE stock_master_new SET ".$fields." = '".$new_data."' WHERE stock_id=".$res->stock_id;	
					$results_query = mysql_query($sql1);	
					}
					
					
					
					
					
					// if($fields == 'PWD_disc'){
					// $sql="UPDATE pos_stock_discounts SET disc_enabled = '".$new_data."' WHERE stock_id=".$res->stock_id." AND pos_discount_id = 1 ";	
					// mysql_query($sql);
					// }elseif($fields == 'SC_disc'){
					// $sql="UPDATE pos_stock_discounts SET disc_enabled = '".$new_data."' WHERE stock_id=".$res->stock_id." AND pos_discount_id = 2 ";	
					// mysql_query($sql);
					
					// }else{
					// $sql1="UPDATE stock_master_new SET ".$fields." = '".$new_data."' WHERE stock_id=".$res->stock_id;	
					// $results_query = mysql_query($sql1);
					
					// }
					}
					
					
					}else{
					
					if($branch_name == null){
					array_push($branch_name,$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
					}
					
					}
					$branch_name_con =  implode($branch_name);	
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$date = date('Y-m-d');
					if($branch_name_con == ''){
					$sql11 = "UPDATE stock_logs SET approval_status = '1' , date_checked = '".$date."', approved_by = '".$user."' WHERE id = '$id' ";
					mysql_query($sql11);
					return 'success';
					}else{
					$sql11 = "UPDATE stock_logs SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
					mysql_query($sql11);		
					return 'no_con||unable to update '.$branch_name_con.' no connection' ;
					return $sql11;
					}
					
					break;
					
					case 'Update All Supplier Stock Details':	
					
					$sql = "SELECT branch_no_con FROM stock_logs WHERE id = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					
					$branch = array('default');
					$test = $this->get_all_branches();
					foreach($test as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);		
					
					}
					
					$num_branch = count($branch);	
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					if($connected){
					
					$need_to_update = explode('||',$res->affected_field_values);
					$no_need_to_update =  count($need_to_update);
					$sample = array();
					$nums=0; 
					//	return $no_need_to_update;
					while($no_need_to_update != $nums){
					array_push($sample ,$nums);
					$nums = $nums + 1;
					$fields_and_data = explode(':',$need_to_update[$nums-1]);
					$old_and_new_datas = explode('|',$fields_and_data[1]); 
					$old_data = $old_and_new_datas[0];
					$new_data = $old_and_new_datas[1];
					$fields = $fields_and_data[0];
					
					
					if($fields == 'is_default'){
					
					$sql1="UPDATE supplier_stocks SET ".$fields." = '".$new_data."' WHERE  supp_id = ".$res->supplier_stock_code." AND stock_id=".$res->stock_id ;	
					mysql_query($sql1);
					
					$sql2="UPDATE supplier_stocks SET ".$fields." = '0' WHERE supp_id != ".$res->supplier_stock_code." AND stock_id=".$res->stock_id ;	
					mysql_query($sql2);
					
					}else{
					$sql1="UPDATE supplier_stocks SET ".$fields." = '".$new_data."' WHERE supp_id = ".$res->supplier_stock_code." AND stock_id=".$res->stock_id;	
					mysql_query($sql1);
					}
					
					}
					
					}else{
					
					if($branch_name == null){
					array_push($branch_name,$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
					}
					
					}
					$branch_name_con =  implode($branch_name);	
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$date = date('Y-m-d');
					if($branch_name_con == ''){
					$sql11 = "UPDATE stock_logs SET approval_status = '1' , date_checked = '".$date."', approved_by = '".$user."' WHERE id = '$id' ";
					mysql_query($sql11);
					return 'success';
					}else{
					$sql11 = "UPDATE stock_logs SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
					mysql_query($sql11);		
					//	return 'no_con||unable to update '.$branch_name_con.' no connection' ;
					//	return $sql11;
					}
					
					
					
					break;
					
					case 'Update Supplier Stock Details':
					
					$sql='SELECT * FROM stock_logs WHERE id='.$id;
					$query = mysql_query($sql);
					$res = mysql_fetch_object($query);
					
					$bdb = $this->load->database($branch,TRUE);
					$connected = $bdb->initialize();
					if($connected){
					
					$nums = 0;
					$need_to_update = explode('||',$res->affected_field_values);
					$no_need_to_update =  count($need_to_update);
					while($no_need_to_update != $nums){
					
					$nums = $nums + 1;
					$fields_and_data = explode(':',$need_to_update[$nums-1]);
					$old_and_new_datas = explode('|',$fields_and_data[1]); 
					$old_data = $old_and_new_datas[0];
					$new_data = $old_and_new_datas[1];
					$fields = $fields_and_data[0];
					
					if($fields == 'is_default'){
					
					$bdb = $this->load->database($branch,TRUE);
					$connected = $bdb->initialize();
					
					$sql1="UPDATE supplier_stocks SET ".$fields." = '".$new_data."' WHERE branch_id =".$res->branch." AND supp_id = ".$res->supplier_stock_code." AND stock_id=".$res->stock_id ;	
					mysql_query($sql1);
					
					$sql2="UPDATE supplier_stocks SET ".$fields." = '0' WHERE supp_id != ".$res->supplier_stock_code." AND branch_id =".$res->branch." AND stock_id=".$res->stock_id ;	
					mysql_query($sql2);
					
					
					$bdd = $this->load->database('default',TRUE);
					$connected = $bdd->initialize();
					
					$sqllocal="UPDATE supplier_stocks SET ".$fields." = '".$new_data."' WHERE supp_id = ".$res->supplier_stock_code." AND stock_id = ".$res->stock_id." AND branch_id=".$branch_ids;	
					mysql_query($sqllocal);
					
					$sql2="UPDATE supplier_stocks SET ".$fields." = '0' WHERE supp_id != ".$res->supplier_stock_code." AND branch_id =".$res->branch." AND stock_id=".$res->stock_id ;	
					mysql_query($sql2);
					
					}else{
					$bdb = $this->load->database($branch,TRUE);
					$connected = $bdb->initialize();
					
					$sql1="UPDATE supplier_stocks SET ".$fields." = '".$new_data."' WHERE supp_id = ".$res->supplier_stock_code." AND stock_id=".$res->stock_id;	
					mysql_query($sql1);	
					
					$bdd = $this->load->database('default',TRUE);
					$connected = $bdd->initialize();
					
					$sqllocal="UPDATE supplier_stocks SET ".$fields." = '".$new_data."' WHERE supp_id = ".$res->supplier_stock_code." AND stock_id = ".$res->stock_id." AND branch_id=".$branch_ids;	
					mysql_query($sqllocal);	
					
					}
					
					
					
					
					}
					
					$bdb = $this->load->database('default',TRUE);
					$connected = $bdb->initialize();
					$date = date('Y-m-d');
					$sqlupdate = "UPDATE stock_logs SET approval_status = '1' , date_checked = '".$date."', approved_by = '".$user."' WHERE id = '$id' ";
					$results = mysql_query($sqlupdate);
					return 'success';
					
					
					}else{
					$sql11 = "UPDATE stock_logs SET branch_no_con = '$branch'  WHERE id = '$id' ";
					mysql_query($sql11);		
					//return 'no_con||unable to update '.$branch.' no connection' ;
					//	return $sql11;
					}
					
					
					
					break;
					
					
					}
					
					
					
					// if($res->type == 'Updated Stock Master Details'){
					
					// $sql = "SELECT branch_no_con FROM stock_logs WHERE id = '$id' ";
					// $query = $this->db->query($sql);
					// $row = $query->row();
					// $name = explode('|',$row->branch_no_con);
					
					// if ($row->branch_no_con != ''){
					// $num_branch = count($name);
					// $total = $num_branch;
					// $branch = array();
					// $num =0;
					// while($total != $num){
					// array_push($branch,$name[$num]);
					// $num++;	
					// }
					// }else{
					
					// $branch = array('default');
					// $test = $this->get_all_branches();
					// foreach($test as $val){
					// array_push ($branch,$val->code);		
					// }
					// $num_branch = count($branch);		
					
					// }
					
					// $num_branch = count($branch);	
					// $num =0;
					// while($num_branch != $num){
					// $num = $num + 1;
					// $bdb = $this->load->database($branch[$num-1],TRUE);
					// $connected = $bdb->initialize();
					
					// if($connected){
					
					// $need_to_update = explode('||',$res->affected_field_values);
					// $no_need_to_update =  count($need_to_update);
					// $sample = array();
					// $nums=0; 
					// //	return $no_need_to_update;
					// while($no_need_to_update != $nums){
					// array_push($sample ,$nums);
					// $nums = $nums + 1;
					// $fields_and_data = explode(':',$need_to_update[$nums-1]);
					// $old_and_new_datas = explode('|',$fields_and_data[1]); 
					// $old_data = $old_and_new_datas[0];
					// $new_data = $old_and_new_datas[1];
					// $fields = $fields_and_data[0];
					// if($fields == 'PWD_disc'){
					// $sql="UPDATE pos_stock_discounts SET disc_enabled = '".$new_data."' WHERE stock_id=".$res->stock_id." AND pos_discount_id = 1 ";	
					// mysql_query($sql);
					// }elseif($fields == 'SC_disc'){
					// $sql="UPDATE pos_stock_discounts SET disc_enabled = '".$new_data."' WHERE stock_id=".$res->stock_id." AND pos_discount_id = 2 ";	
					// mysql_query($sql);
					
					// }else{
					// $sql1="UPDATE stock_master_new SET ".$fields." = '".$new_data."' WHERE stock_id=".$res->stock_id;	
					// mysql_query($sql1);
					
					// }
					// }
					
					
					// }else{
					
					// if($branch_name == null){
					// array_push($branch_name,$branch[$num-1]);
					// }else{
					// array_push($branch_name,'|'.$branch[$num-1]);	
					// }
					// }
					
					// }
					// $branch_name_con =  implode($branch_name);	
					// $bdb = $this->load->database('default',TRUE);
					// $cons = $bdb->initialize();
					// $date = date('Y-m-d');
					// if($branch_name_con == ''){
					// $sql11 = "UPDATE stock_logs SET approval_status = '1' , date_checked = '".$date."', approved_by = '".$user."' WHERE id = '$id' ";
					// mysql_query($sql11);
					// return 'success';
					// }else{
					// $sql11 = "UPDATE stock_logs SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
					// mysql_query($sql11);		
					// return 'no_con||unable to update '.$branch_name_con.' no connection' ;
					// return $sql11;
					// }
					
					// }
					// return ':p';
					
					
					
					// $branch = $this->get_branch_code($res->branch);
					// $table = $res->affected_tables;
					// $affected_values = $res->affected_field_values;
					// $data = explode('||',$affected_values);
					// $barcode = explode(':',$data[0]);
					// $sales_type_id = explode(':',$data[1]);
					// $price = explode(':',$data[2]);
					
					// $db = $this->load->database($branch,TRUE);
					// $con  = $db->initialize();
					
					// if($con){
					// $sql="UPDATE ".$table." SET price = ".$price[1]." WHERE barcode = '".$barcode[1]."' and sales_type_id = ".$sales_type_id[1]." and branch_id = ".$res->branch."";	
					// $query  = mysql_query($sql);
					
					
					// $db = $this->load->database('default',TRUE);
					// $con  = $db->initialize();	
					// $sql1="UPDATE ".$table." SET price = ".$price[1]." WHERE barcode = '".$barcode[1]."' and sales_type_id = ".$sales_type_id[1]." and branch_id = ".$res->branch."";	
					// mysql_query($sql1);
					
					// // $sql2 ="DELETE FROM  stock_logs WHERE id=".$id;
					// // mysql_query($sql2);
					// $sql2 ="UPDATE stock_logs SET approval_status = '1' WHERE id=".$id;
					// mysql_query($sql2);
					
					
					// //return $branch;
					// }
					
					// $res  = mysql_query($sql);
					
					//return $query ;
					//return $sql ;
					
					//return $res->affected_field_values;
					
					}
					
					public function schedule_marginal_approvals($branch=null,$id=null){
					
					
					$db = $this->load->database('default',TRUE);
					$db->initialize();
					
					$this->db->select('*');
					$this->db->from('stock_barcode_marginal_markdown_temp');
					if($id != null)
					$this->db->where('id',$id);
					$query = $this->db->get();
					$result = $query->result();
					
					$db_branch = $this->load->database($branch,TRUE);
					$connected =  $db_branch->initialize();
					
					if($connected){
					foreach($result as $val){
					
					
					$sql2 = "INSERT INTO stock_barcode_marginal_markdown
					(stock_id,
					barcode,
					branch_id,
					sales_type_id,
					qty,
					markup,
					unit_price,
					datetime_added,
					datetime_modified,
					modified_by) 
					VALUES (".$val->stock_id.",
					'".$val->barcode."',
					".$val->branch_id.",
					".$val->sales_type_id.",
					".$val->qty.",
					".$val->markup.",
					".$val->unit_price.",
					'".$val->datetime_added."',
					'".$val->datetime_modified."',
					'".$val->modified_by."')
					ON DUPLICATE KEY UPDATE qty='".$val->qty."', 
					markup=".$val->markup.",
					unit_price=".$val->unit_price."";
					mysql_query($sql2);
					
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					
					$sql1 = "INSERT INTO stock_barcode_marginal_markdown
					(stock_id,
					barcode,
					branch_id,
					sales_type_id,
					qty,
					markup,
					unit_price,
					datetime_added,
					datetime_modified,
					modified_by) 
					VALUES (".$val->stock_id.",
					'".$val->barcode."',
					".$val->branch_id.",
					".$val->sales_type_id.",
					".$val->qty.",
					".$val->markup.",
					".$val->unit_price.",
					'".$val->datetime_added."',
					'".$val->datetime_modified."',
					'".$val->modified_by."')
					ON DUPLICATE KEY UPDATE qty='".$val->qty."', 
					markup=".$val->markup.",
					unit_price=".$val->unit_price."";
					mysql_query($sql1);
					
					
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					if($con){
					$sql ="DELETE FROM  stock_barcode_marginal_markdown_temp WHERE id=".$id;
					$ret = mysql_query($sql);
					if($ret)
					return 'success';
					return 'error';
					}
					
					}
					}else{
					
					$sql1 = "UPDATE stock_barcode_marginal_markdown_temp SET branch_no_con = '$branch'  WHERE id = '$id' ";
					mysql_query($sql1);	
					return 'no_con';
					}
					
					
					}
					
					public function schedule_markdown_approvals($branch=null,$id=null){
					
					$db = $this->load->database('default',TRUE);
					$db->initialize();
					
					$this->db->select('*');
					$this->db->from('stock_barcode_scheduled_markdown_temp');
					if($id != null)
					$this->db->where('id',$id);
					$query = $this->db->get();
					$result = $query->result();
					
					$db_branch = $this->load->database($branch,TRUE);
					$connected =  $db_branch->initialize();
					
					if($connected){
					
					foreach($result as $val){
					
					$sql = "INSERT INTO stock_barcode_scheduled_markdown
					(stock_id,
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
					inactive)
					VALUES
					('".$val->stock_id."',
					'".$val->barcode."',
					'".$val->branch_id."',
					'".$val->sales_type_id."',
					'".$val->start_date."',
					'".$val->end_date."',
					'".$val->start_time."',
					'".$val->end_time."',
					'".$val->markdown."',
					'".$val->original_price."',
					'".$val->discounted_price."',
					'".$val->datetime_added."',
					'".$val->datetime_modified."',
					'".$val->added_by."',
					'".$val->modified_by."',
					'".$val->inactive."')";
					mysql_query($sql);
					
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					$sql1 = "INSERT INTO stock_barcode_scheduled_markdown
					(stock_id,
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
					inactive)
					VALUES
					('".$val->stock_id."',
					'".$val->barcode."',
					'".$val->branch_id."',
					'".$val->sales_type_id."',
					'".$val->start_date."',
					'".$val->end_date."',
					'".$val->start_time."',
					'".$val->end_time."',
					'".$val->markdown."',
					'".$val->original_price."',
					'".$val->discounted_price."',
					'".$val->datetime_added."',
					'".$val->datetime_modified."',
					'".$val->added_by."',
					'".$val->modified_by."',
					'".$val->inactive."')";
					$res = mysql_query($sql1);
					
					if($res){
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					if($con){
					$sql ="DELETE FROM  stock_barcode_scheduled_markdown_temp WHERE id=".$id;
					$ret = mysql_query($sql);
					if($ret)
					return 'success';
					return 'error';
					}
					}
					}
					}else{
					$sql1 = "UPDATE stock_barcode_scheduled_markdown_temp SET branch_no_con = '$branch'  WHERE id = '$id' ";
					mysql_query($sql1);	
					return 'no_con';
					}
					}
					
					#############all_stock_barcode_approval##########
					
					public function get_barcode_prices($l_barcode = '',$branch = ''){
					$sql = "SELECT * FROM stock_barcode_prices_temp WHERE branch_id = ".$branch." AND barcode IN (".$l_barcode.") ";				
					$query = $this->db->query($sql);
					$bar_prices_result = $query->result();	
					return $bar_prices_result;
					}
					
					
					
					public function add_stock_barcode_approval($old_id=null,$user=null){
					
					
					$bdb = $this->load->database('default',TRUE);
					$connected = $bdb->initialize();
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('stock_master_new_temp');
					if($old_id != null)
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$result = $query->result(); // result for stock_master in temporary table 
					$this->db->trans_complete();
					
					//return var_dump($result);
					
					$no_connection = array();
					$branch_name = array();
					$var1=array();
					
					// $sql = "SELECT branch_no_con FROM stock_master_new_temp WHERE stock_id = '$old_id' ";
					// $query = $this->db->query($sql);
					// $row = $query->row();
					// $name = explode('|',$row->branch_no_con);
					
					// if ($row->branch_no_con != ''){
					// $num_branch = count($name);
					// $total = $num_branch;
					// $branch = array();
					// $num =0;
					// while($total != $num){
					// array_push($branch,$name[$num]);
					// $num++;	
					// }
					
					//	}else{
					
					$barcode  = array('');
					$branch = array('');
					$test = $this->get_all_branches();
					foreach($test as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);	
					//return var_dump($branch);
					$bdb = $this->load->database('default',TRUE);
					$connected = $bdb->initialize();	
					
					foreach($result as $val){	
					$sql = "INSERT INTO stock_master_new
		            (
					stock_code,
					category_id,
					tax_type_id,
					description,
					report_uom,
					report_qty,
					mb_flag,
					is_consigned,
					inventory_account,
					adjustment_account,
					assembly_cost_account,
					standard_cost,
					last_cost,
					cost_of_sales,
					is_saleable,
					senior_citizen_tag,
					earn_suki_points,
					date_added,
					inactive)
					VALUES
					(
					'".$val->stock_code."',
					'".$val->category_id."',
					'".$val->tax_type_id."',
					'".$val->description."',
					'".$val->report_uom."',
					'".$val->report_qty."',
					'".$val->mb_flag."',
					'".$val->is_consigned."',
					'".$val->inventory_account."',
					'".$val->adjustment_account."',
					'".$val->assembly_cost_account."',
					'".$val->standard_cost."',
					'".$val->last_cost."',
					'".$val->cost_of_sales."',
					'".$val->is_saleable."',
					'".$val->senior_citizen_tag."',
					'".$val->earn_suki_points."',
					'".$val->date_added."',
					'".$val->inactive."')";
					$res = mysql_query($sql);
					
					$new_id = mysql_insert_id();
					}
					
					##pos_stock_cards & pos_stock_discounts##
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_cards_temp');
					$this->db->where('stock_id',$old_id);//
					$query = $this->db->get();
					$result_cards = $query->result();
					$this->db->trans_complete();
					foreach($result_cards as $val_cards){
					$sql ="INSERT INTO pos_stock_cards
					(
					stock_id,
					sales_type_id,
					card_type_id,
					is_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_cards->sales_type_id."',
					'".$val_cards->card_type_id."',
					'".$val_cards->is_enabled."',
					'".$val_cards->inactive."'
					)";
					mysql_query($sql);
					}
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_discounts_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_discount = $query->result();
					$this->db->trans_complete();
					
					foreach($result_discount as $val_dis){
					$sql ="INSERT INTO pos_stock_discounts
					(
					stock_id,
					sales_type_id,
					pos_discount_id,
					disc_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_dis->sales_type_id."',
					'".$val_dis->pos_discount_id."',
					'".$val_dis->disc_enabled."',
					'".$val_dis->inactive."'
					)";
					$success = mysql_query($sql);
					}			
					##pos_stock_cards & pos_stock_discounts##
					
					
					######BARCODE
					
					$this->db->select('*');
					$this->db->from('stock_barcodes_new_temp');
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$bar_result = $query->result();	
					
					foreach($bar_result as $val_bar){
					$bran_def = $this->load->database('default',TRUE);
					$bran_def->initialize();
					
					$sql = "INSERT INTO stock_barcodes_new
					(stock_id,
					barcode,
					short_desc,
					description,
					uom,
					qty,
					sales_type_id,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_bar->barcode."',
					'".$val_bar->short_desc."',
					'".$val_bar->description."',
					'".$val_bar->uom."',
					'".$val_bar->qty."',
					'".$val_bar->sales_type_id."',
					'".$val_bar->inactive."')";													
					$res = mysql_query($sql);
					
					array_push ($barcode,$val_bar->barcode);
					}
					
					unset($barcode[0]);
					$l_barcode = implode( ',', $barcode);	
					
					######BARCODE
					//	}
					
					$num =0;
					$nums = $num_branch-1;
					while($nums != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num],TRUE);
					$connected = $bdb->initialize();
					
					if($connected){
					
					foreach($result as $val){	
					
					$sql = "INSERT INTO stock_master_new
		            (
					stock_id,
					stock_code,
					category_id,
					tax_type_id,
					description,
					report_uom,
					report_qty,
					mb_flag,
					is_consigned,
					inventory_account,
					adjustment_account,
					assembly_cost_account,
					standard_cost,
					last_cost,
					cost_of_sales,
					is_saleable,
					senior_citizen_tag,
					earn_suki_points,
					date_added,
					inactive)
					VALUES
					(
					".$new_id.",
					'".$val->stock_code."',
					'".$val->category_id."',
					'".$val->tax_type_id."',
					'".$val->description."',
					'".$val->report_uom."',
					'".$val->report_qty."',
					'".$val->mb_flag."',
					'".$val->is_consigned."',
					'".$val->inventory_account."',
					'".$val->adjustment_account."',
					'".$val->assembly_cost_account."',
					'".$val->standard_cost."',
					'".$val->last_cost."',
					'".$val->cost_of_sales."',
					'".$val->is_saleable."',
					'".$val->senior_citizen_tag."',
					'".$val->earn_suki_points."',
					'".$val->date_added."',
					'".$val->inactive."')";
					mysql_query($sql);		  
					}
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_cards_temp');
					$this->db->where('stock_id',$old_id);//
					$query = $this->db->get();
					$result_cards = $query->result();
					$this->db->trans_complete();
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_discounts_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_discount = $query->result();
					$this->db->trans_complete();
					
					
					$bdb = $this->load->database($branch[$num],TRUE);
					$cons = $bdb->initialize();
					//discount and cards
					if($cons){
					foreach($result_cards as $val_cards){
					$sql ="INSERT INTO pos_stock_cards
					(
					stock_id,
					sales_type_id,
					card_type_id,
					is_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_cards->sales_type_id."',
					'".$val_cards->card_type_id."',
					'".$val_cards->is_enabled."',
					'".$val_cards->inactive."'
					)";
					mysql_query($sql);
					}
					
					foreach($result_discount as $val_dis){
					$sql ="INSERT INTO pos_stock_discounts
					(
					stock_id,
					sales_type_id,
					pos_discount_id,
					disc_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_dis->sales_type_id."',
					'".$val_dis->pos_discount_id."',
					'".$val_dis->disc_enabled."',
					'".$val_dis->inactive."'
					)";
					mysql_query($sql);
					}
					
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					
					}
					//cost of sale
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('stock_cost_of_sales_temp');
					$this->db->where('stock_id',$old_id);
					$this->db->where('branch_id',$num);
					$query = $this->db->get();
					$result_cost_sale = $query->result();
					$this->db->trans_complete();
					
					foreach($result_cost_sale as $val_cos){
					
					$db_cost = $this->load->database($branch[$num],TRUE);
					$db_con_cost = $db_cost->initialize();
					if($db_con_cost){
					$sql="INSERT INTO stock_cost_of_sales
					(stock_id,
					branch_id,
					cost_of_sales,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_cos->branch_id."',
					'".$val_cos->cost_of_sales."',
					'".$val_cos->inactive."') ";
					mysql_query($sql);
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					}
					
					$def = $this->load->database('default',TRUE);
					$def->initialize();
					
					$sql1="INSERT INTO stock_cost_of_sales
					(stock_id,
					branch_id,
					cost_of_sales,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_cos->branch_id."',
					'".$val_cos->cost_of_sales."',
					'".$val_cos->inactive."') ";
					mysql_query($sql1);
					
					}
					
					//branch stock_	
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('branch_stocks_temp');
					$this->db->where('stock_id',$old_id);//l
					$this->db->where('branch_id',$num);
					$query = $this->db->get();
					$result_branch_cost = $query->result();
					$this->db->trans_complete();
					
					
					foreach($result_branch_cost as $val_bcos){
					
					
					$db_b = $this->load->database($branch[$num],TRUE);
					$db_b_con = $db_b->initialize();
					
					if($db_b_con){
					$sql = "INSERT INTO branch_stocks
					(stock_id,
					branch_id,
					qty,
					stock_loc_id)
					VALUES
					('".$new_id."',
					'".$val_bcos->branch_id."',
					'".$val_bcos->qty."',
					'".$val_bcos->stock_loc_id."')";
					mysql_query($sql);
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					}
					
					
					$def_b = $this->load->database('default',TRUE);
					$def_b->initialize();
					
					$sql1 = "INSERT INTO branch_stocks
					(stock_id,
					branch_id,
					qty,
					stock_loc_id)
					VALUES
					('".$new_id."',
					'".$val_bcos->branch_id."',
					'".$val_bcos->qty."',
					'".$val_bcos->stock_loc_id."')";
					mysql_query($sql1);
					
					}
					
					// //############supplier_stock##############################//	
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('supplier_stocks_temp');
					$this->db->where('stock_id',$old_id);
					$this->db->where('branch_id',$this->get_branch_id($branch[$num]));
					$query = $this->db->get();
					$supp_bran_results = $query->result();
					$this->db->trans_complete();	
					//return $this->get_branch_id($branch[$num]);
					
					foreach($supp_bran_results as $supp_val_bran){
					$supp_bran = $this->load->database($branch[$num],TRUE);
					$supp_bran_con =  $supp_bran->initialize();
					if($supp_bran_con){
					$sql = "INSERT INTO supplier_stocks
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					is_default,
					avg_net_cost,
					inactive)
					VALUES
					('".$new_id."',
					'".$supp_val_bran->supp_stock_code."',
					'".$supp_val_bran->description."',
					'".$supp_val_bran->supp_id."',
					'".$supp_val_bran->branch_id."',
					'".$supp_val_bran->uom."',
					'".$supp_val_bran->qty."',
					'".$supp_val_bran->unit_cost."',
					'".$supp_val_bran->disc_percent1."',
					'".$supp_val_bran->disc_percent2."',
					'".$supp_val_bran->disc_percent3."',
					'".$supp_val_bran->disc_amount1."',
					'".$supp_val_bran->disc_amount2."',
					'".$supp_val_bran->disc_amount3."',
					'".$supp_val_bran->avg_cost."',
					'".$supp_val_bran->net_cost."',
					'".$supp_val_bran->is_default."',
					'".$supp_val_bran->avg_net_cost."',
					'".$supp_val_bran->inactive."')";
					
					$res = mysql_query($sql);
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					}
					}		
					$def_temp = $this->load->database('default',TRUE);
					$def_temp->initialize();
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('supplier_stocks_temp');
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$supp_results = $query->result();
					$this->db->trans_complete();
					
					
					foreach($supp_results as $supp_val){	
					
					$supp_def = $this->load->database('default',TRUE);
					$supp_def->initialize();
					
					$sql = "INSERT INTO supplier_stocks
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					is_default,
					avg_net_cost,
					inactive)
					VALUES
					('".$new_id."',
					'".$supp_val->supp_stock_code."',
					'".$supp_val->description."',
					'".$supp_val->supp_id."',
					'".$supp_val->branch_id."',
					'".$supp_val->uom."',
					'".$supp_val->qty."',
					'".$supp_val->unit_cost."',
					'".$supp_val->disc_percent1."',
					'".$supp_val->disc_percent2."',
					'".$supp_val->disc_percent3."',
					'".$supp_val->disc_amount1."',
					'".$supp_val->disc_amount2."',
					'".$supp_val->disc_amount3."',
					'".$supp_val->avg_cost."',
					'".$supp_val->net_cost."',
					'".$supp_val->is_default."',
					'".$supp_val->avg_net_cost."',
					'".$supp_val->inactive."')";
					
					$res = mysql_query($sql);
					
					
					$sql = "INSERT INTO supplier_stocks_history
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					avg_net_cost,
					inactive, 
					added_by,
					datetime_added,
					checked_by,
					datetime_checked)
					VALUES
					('".$new_id."',
					'".$supp_val->supp_stock_code."',
					'".$supp_val->description."',
					'".$supp_val->supp_id."',
					'".$supp_val->branch_id."',
					'".$supp_val->uom."',
					'".$supp_val->qty."',
					'".$supp_val->unit_cost."',
					'".$supp_val->disc_percent1."',
					'".$supp_val->disc_percent2."',
					'".$supp_val->disc_percent3."',
					'".$supp_val->disc_amount1."',
					'".$supp_val->disc_amount2."',
					'".$supp_val->disc_amount3."',
					'".$supp_val->avg_cost."',
					'".$supp_val->net_cost."',
					'".$supp_val->avg_net_cost."',
					'".$supp_val->inactive."',
					'".$supp_val->added_by."',
					'".$supp_val->datetime_added."',
					'".$user."',
					'".date('Y-m-d H:i:s')."')";
					$res = mysql_query($sql);
					
					}
					
					//############supplier_stock##############################//	
					
					
					
					//######################BARCODE########################//
					$this->db->select('*');
					$this->db->from('stock_barcodes_new_temp');
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$bar_result = $query->result();	
					
					foreach($bar_result as $val_bar){
					
					$db_bran = $this->load->database($branch[$num],TRUE);
					$db_bran_con = $db_bran->initialize();		
					if($db_bran_con){
					$sql1 = "INSERT INTO stock_barcodes_new
					(stock_id,
					barcode,
					short_desc,
					description,
					uom,
					qty,
					sales_type_id,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_bar->barcode."',
					'".$val_bar->short_desc."',
					'".$val_bar->description."',
					'".$val_bar->uom."',
					'".$val_bar->qty."',
					'".$val_bar->sales_type_id."',
					'".$val_bar->inactive."')";
					
					$res = mysql_query($sql1);
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					}
					
					$prices_result = $this->get_barcode_prices($l_barcode,$num);
					
					foreach($prices_result as $val_bar_price){		
					$db_bran_price = $this->load->database($branch[$num],TRUE);
					$db_bran_price_con  = $db_bran_price->initialize();	
					if($db_bran_price_con){
					$sql = "INSERT INTO stock_barcode_prices
					(barcode,
					sales_type_id,
					price,
					branch_id,
					computed_srp,
					prevailing_unit_price,
					landed_cost_markup,
					cost_of_sales_markup)
					VALUES
					('".$val_bar_price->barcode."',
					'".$val_bar_price->sales_type_id."',
					'".$val_bar_price->price."',
					'".$val_bar_price->branch_id."',
					'".$val_bar_price->computed_srp."',
					'".$val_bar_price->prevailing_unit_price."',
					'".$val_bar_price->landed_cost_markup."',
					'".$val_bar_price->cost_of_sales_markup."')";					
					
					mysql_query($sql);
					
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					
					}
					
					$db_bran_price_def = $this->load->database('default',TRUE);
					$db_bran_price_def->initialize();
					
					$sql = "INSERT INTO stock_barcode_prices
					(barcode,
					sales_type_id,
					price,
					branch_id,
					computed_srp,
					prevailing_unit_price,
					landed_cost_markup,
					cost_of_sales_markup)
					VALUES
					('".$val_bar_price->barcode."',
					'".$val_bar_price->sales_type_id."',
					'".$val_bar_price->price."',
					'".$val_bar_price->branch_id."',
					'".$val_bar_price->computed_srp."',
					'".$val_bar_price->prevailing_unit_price."',
					'".$val_bar_price->landed_cost_markup."',
					'".$val_bar_price->cost_of_sales_markup."')";					
					
					mysql_query($sql);	 
					}
					
					}		// //######################BARCODE########################//
					
					
					}else{
					/*
					if($no_connection == null){
					array_push($no_connection,$branch[$num]);
					array_push($branch_name,$branch[$num]);
					}else{
					array_push($no_connection,'|'.$branch[$num]);
					array_push($branch_name,'|'.$branch[$num]);	
					}
					*/
					
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					array_push($branch_name,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					array_push($branch_name,$branch[$num]);
					}
					}
					
					}
					
					}	
					
					$branch_not_con =  implode($no_connection);
					$branch_name_con =  implode($branch_name);
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					
					if($num_branch == $num+1 && $branch_not_con == null){
					
					$sql_stock_cards ="DELETE FROM  pos_stock_cards_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_cards);
					
					$sql_stock_discounts ="DELETE FROM  pos_stock_discounts_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_discounts);
					
					$sql_stock_cost ="DELETE FROM  stock_cost_of_sales_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_cost);
					
					$sql_branch_stock_cost ="DELETE FROM  branch_stocks_temp WHERE stock_id=".$old_id;
					mysql_query($sql_branch_stock_cost);	
					
					$sql_stock_master ="DELETE FROM  stock_master_new_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_master);
					
					$sql_suppliers_stock ="DELETE FROM  supplier_stocks_temp WHERE stock_id=".$old_id;
					mysql_query($sql_suppliers_stock);
					
					$del_bar = array();	
					$sql = "SELECT * FROM stock_barcodes_new_temp WHERE stock_id = ".$old_id." ";				
					$query = $this->db->query($sql);
					$res = $query->result();
					
					foreach($res as $res_bar){
					array_push ($del_bar,$res_bar->barcode);	
					}
					
					$del_barcode = implode( ',', $del_bar);	
					$sql1 ="DELETE FROM  stock_barcode_prices_temp WHERE barcode IN (".$del_barcode.")";
					$ret = mysql_query($sql1);
					
					$sql ="DELETE FROM  stock_barcodes_new_temp WHERE stock_id=".$old_id;
					$result = mysql_query($sql);
					unset($del_bar);
					
					
					
					
					if($result)
					return 'success||All branches has been updated';
					return 'error';
					
					}else{
					$sql1 = "UPDATE stock_master_new_temp SET branch_no_con = '$branch_not_con',branch_no_con_id = '$new_id' WHERE stock_id = '$old_id' ";
					mysql_query($sql1);	
					
					$chk  = count($no_connection);
					if($chk > 1){
					$branch_name = explode('|',$branch_not_con);
					$num_branch = count($branch_name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$this->get_branch_id($branch_name[$num]));
					$num++;	
					}
					
					$upd_br =  $del_barcode = implode( ',', $branch);
					}else{
					$upd_br = $this->get_branch_id($no_connection[0]);
					}
					
					$sql1 = "UPDATE supplier_stocks_temp SET branch_no_con = '$branch_not_con', checked_by = '$user' , datetime_checked = '".date('Y-m-d H:i:s')."',branch_no_con_id = '$new_id'  WHERE stock_id = '$old_id' AND branch_id IN (".$upd_br.") ";
					mysql_query($sql1);	
					
					$del_suppliers_stock ="DELETE FROM  supplier_stocks_temp WHERE stock_id=".$old_id." AND branch_id NOT IN (".$upd_br.")";
					mysql_query($del_suppliers_stock);
					
					
					$sql11 = "UPDATE stock_barcodes_new_temp SET branch_no_con = '$branch_not_con' ,branch_no_con_id = '$new_id' WHERE stock_id = '$old_id' ";
					mysql_query($sql11);
					
					return 'no_con||unable to update '.$branch_not_con.' no connection' ;
					}
					
					}	
					
					//rhan start approve
					public function stock_barcode_approval($old_id=null){
					
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('stock_master_new_temp');
					if($old_id != null)
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$result = $query->result(); // result for stock_master in temporary table 
					$this->db->trans_complete();
					
					$no_connection = array();
					$branch_name = array();
					$var1=array();
					
					$sql = "SELECT branch_no_con FROM stock_master_new_temp WHERE stock_id = '$old_id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					
					}else{
					
					$branch = array('');
					$test = $this->get_all_branches();
					foreach($test as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);		
					
					
					$bdb = $this->load->database('default',TRUE);
					$connected = $bdb->initialize();	
					
					foreach($result as $val){	
					$sql = "INSERT INTO stock_master_new
		            (
					stock_code,
					category_id,
					tax_type_id,
					description,
					report_uom,
					report_qty,
					mb_flag,
					is_consigned,
					inventory_account,
					adjustment_account,
					assembly_cost_account,
					standard_cost,
					last_cost,
					cost_of_sales,
					is_saleable,
					senior_citizen_tag,
					earn_suki_points,
					date_added,
					inactive)
					VALUES
					(
					'".$val->stock_code."',
					'".$val->category_id."',
					'".$val->tax_type_id."',
					'".$val->description."',
					'".$val->report_uom."',
					'".$val->report_qty."',
					'".$val->mb_flag."',
					'".$val->is_consigned."',
					'".$val->inventory_account."',
					'".$val->adjustment_account."',
					'".$val->assembly_cost_account."',
					'".$val->standard_cost."',
					'".$val->last_cost."',
					'".$val->cost_of_sales."',
					'".$val->is_saleable."',
					'".$val->senior_citizen_tag."',
					'".$val->earn_suki_points."',
					'".$val->date_added."',
					'".$val->inactive."')";
					$res = mysql_query($sql);
					
					$new_id = mysql_insert_id();
					}
					}
					
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					
					if($connected){
					
					
					foreach($result as $val){	
					
					$sql = "INSERT INTO stock_master_new
		            (
					stock_id,
					stock_code,
					category_id,
					tax_type_id,
					description,
					report_uom,
					report_qty,
					mb_flag,
					is_consigned,
					inventory_account,
					adjustment_account,
					assembly_cost_account,
					standard_cost,
					last_cost,
					cost_of_sales,
					is_saleable,
					senior_citizen_tag,
					earn_suki_points,
					date_added,
					inactive)
					VALUES
					(
					".$new_id.",
					'".$val->stock_code."',
					'".$val->category_id."',
					'".$val->tax_type_id."',
					'".$val->description."',
					'".$val->report_uom."',
					'".$val->report_qty."',
					'".$val->mb_flag."',
					'".$val->is_consigned."',
					'".$val->inventory_account."',
					'".$val->adjustment_account."',
					'".$val->assembly_cost_account."',
					'".$val->standard_cost."',
					'".$val->last_cost."',
					'".$val->cost_of_sales."',
					'".$val->is_saleable."',
					'".$val->senior_citizen_tag."',
					'".$val->earn_suki_points."',
					'".$val->date_added."',
					'".$val->inactive."')";
					mysql_query($sql);		  
					}
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_cards_temp');
					$this->db->where('stock_id',$old_id);//
					$query = $this->db->get();
					$result_cards = $query->result();
					$this->db->trans_complete();
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_discounts_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_discount = $query->result();
					$this->db->trans_complete();
					
					
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$cons = $bdb->initialize();
					//discount and cards
					if($cons){
					foreach($result_cards as $val_cards){
					$sql ="INSERT INTO pos_stock_cards
					(
					stock_id,
					sales_type_id,
					card_type_id,
					is_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_cards->sales_type_id."',
					'".$val_cards->card_type_id."',
					'".$val_cards->is_enabled."',
					'".$val_cards->inactive."'
					)";
					mysql_query($sql);
					}
					
					foreach($result_discount as $val_dis){
					$sql ="INSERT INTO pos_stock_discounts
					(
					stock_id,
					sales_type_id,
					pos_discount_id,
					disc_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_dis->sales_type_id."',
					'".$val_dis->pos_discount_id."',
					'".$val_dis->disc_enabled."',
					'".$val_dis->inactive."'
					)";
					$success = mysql_query($sql);
					}
					}
					//cost of sale
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('stock_cost_of_sales_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_cost_sale = $query->result();
					$this->db->trans_complete();
					
					foreach($result_cost_sale as $val_cos){
					
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$val_cos->branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					foreach($result_bran as $datas){
					
					$db_cost = $this->load->database($datas->code,TRUE);
					$db_con_cost = $db_cost->initialize();
					if($db_con_cost){
					$sql="INSERT INTO stock_cost_of_sales
					(stock_id,
					branch_id,
					cost_of_sales,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_cos->branch_id."',
					'".$val_cos->cost_of_sales."',
					'".$val_cos->inactive."') ";
					mysql_query($sql);
					}
					}
					
					$def = $this->load->database('default',TRUE);
					$def_con =  $def->initialize();
					if($def_con){
					$sql1="INSERT INTO stock_cost_of_sales
					(stock_id,
					branch_id,
					cost_of_sales,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_cos->branch_id."',
					'".$val_cos->cost_of_sales."',
					'".$val_cos->inactive."') ";
					
					mysql_query($sql1);
					}
					}
					//branch stock_	
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('branch_stocks_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_branch_cost = $query->result();
					$this->db->trans_complete();
					
					foreach($result_branch_cost as $val_bcos){
					
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$val_bcos->branch_id);
					$query = $this->db->get();
					$res_bran = $query->result();
					
					foreach($res_bran as $data){
					
					$db = $this->load->database($data->code,TRUE);
					$db->initialize();
					
					$sql = "INSERT INTO branch_stocks
					(stock_id,
					branch_id,
					qty,
					stock_loc_id)
					VALUES
					('".$new_id."',
					'".$val_bcos->branch_id."',
					'".$val_bcos->qty."',
					'".$val_bcos->stock_loc_id."')";
					mysql_query($sql);
					
					}
					
					$def = $this->load->database('default',TRUE);
					$def->initialize();
					
					$sql1 = "INSERT INTO branch_stocks
					(stock_id,
					branch_id,
					qty,
					stock_loc_id)
					VALUES
					('".$new_id."',
					'".$val_bcos->branch_id."',
					'".$val_bcos->qty."',
					'".$val_bcos->stock_loc_id."')";
					mysql_query($sql1);
					}
					
					}else{
					if($no_connection == null){
					array_push($no_connection,$branch[$num-1]);
					array_push($branch_name,$branch[$num-1]);
					}else{
					array_push($no_connection,'|'.$branch[$num-1]);
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
					}
					
					}	
					$branch_not_con =  implode($no_connection);
					$branch_name_con =  implode($branch_name);
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					if($num_branch == $num && $branch_not_con == null){
					
					$sql_stock_cards ="DELETE FROM  pos_stock_cards_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_cards);
					
					$sql_stock_discounts ="DELETE FROM  pos_stock_discounts_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_discounts);
					
					$sql_stock_cost ="DELETE FROM  stock_cost_of_sales_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_cost);
					
					$sql_branch_stock_cost ="DELETE FROM  branch_stocks_temp WHERE stock_id=".$old_id;
					mysql_query($sql_branch_stock_cost);	
					
					$sql_stock_master ="DELETE FROM  stock_master_new_temp WHERE stock_id=".$old_id;
					$result = mysql_query($sql_stock_master);
					
					
					if($result)
					return 'success||All branches has been updated';
					return 'error';
					}else{
					$sql1 = "UPDATE stock_master_new_temp SET branch_no_con = '$branch_not_con',branch_no_con_id = '$new_id' WHERE stock_id = '$old_id' ";
					mysql_query($sql1);		
					return 'no_con||unable to update '.$branch_not_con.' no connection' ;
					}
					
					}
					public function barcode_prices_approvals($barcode=null){
					
					$this->db->select('*');
					$this->db->from('stock_barcodes_new_temp');
					$this->db->where('barcode',$barcode);
					$query = $this->db->get();
					$result = $query->result();	
					$branch_no_con = array();
					$no_brcon='';
					foreach($result as $val){
				 	$sql = "SELECT branch_no_con FROM stock_barcodes_new_temp WHERE barcode = '$barcode' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					$branch = array('default');
					$test = $this->get_all_branches();
					foreach($test as $val_bran){
					array_push ($branch,$val_bran->code);		
					}
					$num_branch = count($branch);		
					
					}
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					if($connected){
					
					$sql = "INSERT INTO stock_barcodes_new
					(stock_id,
					barcode,
					short_desc,
					description,
					uom,
					qty,
					sales_type_id,
					inactive)
					VALUES
					('".$val->stock_id."',
					'".$val->barcode."',
					'".$val->short_desc."',
					'".$val->description."',
					'".$val->uom."',
					'".$val->qty."',
					'".$val->sales_type_id."',
					'".$val->inactive."')";
					
					$res = mysql_query($sql);
					
					if($res){
					
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					
					
					$this->db->select('*');
					$this->db->from('stock_barcode_prices_temp');
					if($barcode != null)
					$this->db->where('barcode',$barcode);
					$this->db->where('branch_id',$num-1);
					$query = $this->db->get();
					$result_bar = $query->result();	
					
					foreach($result_bar as $value){
					// $this->db->select('*');
					// $this->db->from('branches');
					// $this->db->where('id',$value->branch_id);
					// $query = $this->db->get();
					// $result_bran = $query->result();
					
					$db = $this->load->database('default',TRUE);
					$cons = $db->initialize();
					
					//foreach($result_bran as $data){
					$db = $this->load->database($branch[$num-1],TRUE);
					$con = $db->initialize();
					
					if($con){
					$sql = "INSERT INTO stock_barcode_prices
					(barcode,
					sales_type_id,
					price,
					branch_id,
					computed_srp,
					prevailing_unit_price,
					landed_cost_markup,
					cost_of_sales_markup)
					VALUES
					('".$value->barcode."',
					'".$value->sales_type_id."',
					'".$value->price."',
					'".$value->branch_id."',
					'".$value->computed_srp."',
					'".$value->prevailing_unit_price."',
					'".$value->landed_cost_markup."',
					'".$value->cost_of_sales_markup."')";
					
					mysql_query($sql);
					}
					//}
					$this->load->database('default',TRUE);
					$db->initialize();
					
					$sql = "INSERT INTO stock_barcode_prices
					(barcode,
					sales_type_id,
					price,
					branch_id,
					computed_srp,
					prevailing_unit_price,
					landed_cost_markup,
					cost_of_sales_markup)
					VALUES
					('".$value->barcode."',
					'".$value->sales_type_id."',
					'".$value->price."',
					'".$value->branch_id."',
					'".$value->computed_srp."',
					'".$value->prevailing_unit_price."',
					'".$value->landed_cost_markup."',
					'".$value->cost_of_sales_markup."')";
					
					mysql_query($sql);
					
					}
					
					}
					
					
					
					}else{
					
					if($branch_no_con == null){
					array_push($branch_no_con,$branch[$num-1]);
					}else{
					array_push($branch_no_con,'|'.$branch[$num-1]);
					}
					}			
					
					}
					}//FOR EACH			 
					$no_brcon = implode($branch_no_con);	
					if($branch_no_con == null){
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					if($con){
					$sql ="DELETE FROM  stock_barcodes_new_temp WHERE barcode=".$barcode;
					mysql_query($sql);
					
					$sql1 ="DELETE FROM  stock_barcode_prices_temp WHERE barcode=".$barcode;
					$ret = mysql_query($sql1);
					if($ret)
					return 'success||All Branches has been updated' ;
					return 'errors';
					}
					}else{
					$dbs = $this->load->database('default',TRUE);
					$dbs->initialize();
					$sql1 = "UPDATE stock_barcodes_new_temp SET branch_no_con = '$no_brcon'  WHERE barcode = '$barcode' ";
					$rets = mysql_query($sql1);
					if($rets)
					return 'no_con||unable to update '.$no_brcon.' no connection' ;
					return 'error';
					}
					
					}//barcode_prices_approvals
					
					public function get_stock_master_temp_data($old_id){
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('stock_master_new_temp');
					if($old_id != null)
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$result = $query->result(); // result for stock_master in temporary table 
					$this->db->trans_complete();
					return $result;
					}
					############# add multiple
					
					public function add_multiple_stock_barcode_approval($stock_ids=array(),$user=null){
					$ids = count($stock_ids);
					$numss = 0;
					$no_con_array = array();
					$try1 = array();
					
					
					while($ids != $numss){
					
					$numss = $numss + 1;
					$old_id = $stock_ids[$numss-1];
					
					
					#############################################################
					
					$bdb = $this->load->database('default',TRUE);
					$connected = $bdb->initialize();
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('stock_master_new_temp');
					if($old_id != null)
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$result = $query->result(); // result for stock_master in temporary table 
					$this->db->trans_complete();
					
					//return var_dump($result);
					
					$no_connection = array();
					$branch_name = array();
					$var1=array();
					
					// $sql = "SELECT branch_no_con FROM stock_master_new_temp WHERE stock_id = '$old_id' ";
					// $query = $this->db->query($sql);
					// $row = $query->row();
					// $name = explode('|',$row->branch_no_con);
					
					// if ($row->branch_no_con != ''){
					// $num_branch = count($name);
					// $total = $num_branch;
					// $branch = array();
					// $num =0;
					// while($total != $num){
					// array_push($branch,$name[$num]);
					// $num++;	
					// }
					
					//	}else{
					
					$barcode  = array('');
					$branch = array('');
					$test = $this->get_all_branches();
					foreach($test as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);	
					//return var_dump($branch);
					$bdb = $this->load->database('default',TRUE);
					$connected = $bdb->initialize();	
					
					foreach($result as $val){	
					$sql = "INSERT INTO stock_master_new
		            (
					stock_code,
					category_id,
					tax_type_id,
					description,
					report_uom,
					report_qty,
					mb_flag,
					is_consigned,
					inventory_account,
					adjustment_account,
					assembly_cost_account,
					standard_cost,
					last_cost,
					cost_of_sales,
					is_saleable,
					senior_citizen_tag,
					earn_suki_points,
					date_added,
					inactive)
					VALUES
					(
					'".$val->stock_code."',
					'".$val->category_id."',
					'".$val->tax_type_id."',
					'".$val->description."',
					'".$val->report_uom."',
					'".$val->report_qty."',
					'".$val->mb_flag."',
					'".$val->is_consigned."',
					'".$val->inventory_account."',
					'".$val->adjustment_account."',
					'".$val->assembly_cost_account."',
					'".$val->standard_cost."',
					'".$val->last_cost."',
					'".$val->cost_of_sales."',
					'".$val->is_saleable."',
					'".$val->senior_citizen_tag."',
					'".$val->earn_suki_points."',
					'".$val->date_added."',
					'".$val->inactive."')";
					$res = mysql_query($sql);
					
					$new_id = mysql_insert_id();
					}
					
					##pos_stock_cards & pos_stock_discounts##
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_cards_temp');
					$this->db->where('stock_id',$old_id);//
					$query = $this->db->get();
					$result_cards = $query->result();
					$this->db->trans_complete();
					foreach($result_cards as $val_cards){
					$sql ="INSERT INTO pos_stock_cards
					(
					stock_id,
					sales_type_id,
					card_type_id,
					is_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_cards->sales_type_id."',
					'".$val_cards->card_type_id."',
					'".$val_cards->is_enabled."',
					'".$val_cards->inactive."'
					)";
					mysql_query($sql);
					}
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_discounts_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_discount = $query->result();
					$this->db->trans_complete();
					
					foreach($result_discount as $val_dis){
					$sql ="INSERT INTO pos_stock_discounts
					(
					stock_id,
					sales_type_id,
					pos_discount_id,
					disc_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_dis->sales_type_id."',
					'".$val_dis->pos_discount_id."',
					'".$val_dis->disc_enabled."',
					'".$val_dis->inactive."'
					)";
					$success = mysql_query($sql);
					}			
					##pos_stock_cards & pos_stock_discounts##
					
					
					######BARCODE
					
					$this->db->select('*');
					$this->db->from('stock_barcodes_new_temp');
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$bar_result = $query->result();	
					
					foreach($bar_result as $val_bar){
					$bran_def = $this->load->database('default',TRUE);
					$bran_def->initialize();
					
					$sql = "INSERT INTO stock_barcodes_new
					(stock_id,
					barcode,
					short_desc,
					description,
					uom,
					qty,
					sales_type_id,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_bar->barcode."',
					'".$val_bar->short_desc."',
					'".$val_bar->description."',
					'".$val_bar->uom."',
					'".$val_bar->qty."',
					'".$val_bar->sales_type_id."',
					'".$val_bar->inactive."')";													
					$res = mysql_query($sql);
					
					array_push ($barcode,$val_bar->barcode);
					}
					
					unset($barcode[0]);
					$l_barcode = implode( ',', $barcode);	
					
					######BARCODE
					//	}
					
					$num =0;
					$nums = $num_branch-1;
					while($nums != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num],TRUE);
					$connected = $bdb->initialize();
					
					if($connected){
					
					foreach($result as $val){	
					
					$sql = "INSERT INTO stock_master_new
		            (
					stock_id,
					stock_code,
					category_id,
					tax_type_id,
					description,
					report_uom,
					report_qty,
					mb_flag,
					is_consigned,
					inventory_account,
					adjustment_account,
					assembly_cost_account,
					standard_cost,
					last_cost,
					cost_of_sales,
					is_saleable,
					senior_citizen_tag,
					earn_suki_points,
					date_added,
					inactive)
					VALUES
					(
					".$new_id.",
					'".$val->stock_code."',
					'".$val->category_id."',
					'".$val->tax_type_id."',
					'".$val->description."',
					'".$val->report_uom."',
					'".$val->report_qty."',
					'".$val->mb_flag."',
					'".$val->is_consigned."',
					'".$val->inventory_account."',
					'".$val->adjustment_account."',
					'".$val->assembly_cost_account."',
					'".$val->standard_cost."',
					'".$val->last_cost."',
					'".$val->cost_of_sales."',
					'".$val->is_saleable."',
					'".$val->senior_citizen_tag."',
					'".$val->earn_suki_points."',
					'".$val->date_added."',
					'".$val->inactive."')";
					mysql_query($sql);		  
					}
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_cards_temp');
					$this->db->where('stock_id',$old_id);//
					$query = $this->db->get();
					$result_cards = $query->result();
					$this->db->trans_complete();
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_discounts_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_discount = $query->result();
					$this->db->trans_complete();
					
					
					$bdb = $this->load->database($branch[$num],TRUE);
					$cons = $bdb->initialize();
					//discount and cards
					if($cons){
					foreach($result_cards as $val_cards){
					$sql ="INSERT INTO pos_stock_cards
					(
					stock_id,
					sales_type_id,
					card_type_id,
					is_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_cards->sales_type_id."',
					'".$val_cards->card_type_id."',
					'".$val_cards->is_enabled."',
					'".$val_cards->inactive."'
					)";
					mysql_query($sql);
					}
					
					foreach($result_discount as $val_dis){
					$sql ="INSERT INTO pos_stock_discounts
					(
					stock_id,
					sales_type_id,
					pos_discount_id,
					disc_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_dis->sales_type_id."',
					'".$val_dis->pos_discount_id."',
					'".$val_dis->disc_enabled."',
					'".$val_dis->inactive."'
					)";
					mysql_query($sql);
					}
					
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					
					}
					//cost of sale
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('stock_cost_of_sales_temp');
					$this->db->where('stock_id',$old_id);
					$this->db->where('branch_id',$num);
					$query = $this->db->get();
					$result_cost_sale = $query->result();
					$this->db->trans_complete();
					
					foreach($result_cost_sale as $val_cos){
					
					$db_cost = $this->load->database($branch[$num],TRUE);
					$db_con_cost = $db_cost->initialize();
					if($db_con_cost){
					$sql="INSERT INTO stock_cost_of_sales
					(stock_id,
					branch_id,
					cost_of_sales,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_cos->branch_id."',
					'".$val_cos->cost_of_sales."',
					'".$val_cos->inactive."') ";
					mysql_query($sql);
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					}
					
					$def = $this->load->database('default',TRUE);
					$def->initialize();
					
					$sql1="INSERT INTO stock_cost_of_sales
					(stock_id,
					branch_id,
					cost_of_sales,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_cos->branch_id."',
					'".$val_cos->cost_of_sales."',
					'".$val_cos->inactive."') ";
					mysql_query($sql1);
					
					}
					
					//branch stock_	
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('branch_stocks_temp');
					$this->db->where('stock_id',$old_id);//l
					$this->db->where('branch_id',$num);
					$query = $this->db->get();
					$result_branch_cost = $query->result();
					$this->db->trans_complete();
					
					
					foreach($result_branch_cost as $val_bcos){
					
					
					$db_b = $this->load->database($branch[$num],TRUE);
					$db_b_con = $db_b->initialize();
					
					if($db_b_con){
					$sql = "INSERT INTO branch_stocks
					(stock_id,
					branch_id,
					qty,
					stock_loc_id)
					VALUES
					('".$new_id."',
					'".$val_bcos->branch_id."',
					'".$val_bcos->qty."',
					'".$val_bcos->stock_loc_id."')";
					mysql_query($sql);
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					}
					
					
					$def_b = $this->load->database('default',TRUE);
					$def_b->initialize();
					
					$sql1 = "INSERT INTO branch_stocks
					(stock_id,
					branch_id,
					qty,
					stock_loc_id)
					VALUES
					('".$new_id."',
					'".$val_bcos->branch_id."',
					'".$val_bcos->qty."',
					'".$val_bcos->stock_loc_id."')";
					mysql_query($sql1);
					
					}
					
					// //############supplier_stock##############################//	
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('supplier_stocks_temp');
					$this->db->where('stock_id',$old_id);
					$this->db->where('branch_id',$this->get_branch_id($branch[$num]));
					$query = $this->db->get();
					$supp_bran_results = $query->result();
					$this->db->trans_complete();	
					//return $this->get_branch_id($branch[$num]);
					
					foreach($supp_bran_results as $supp_val_bran){
					$supp_bran = $this->load->database($branch[$num],TRUE);
					$supp_bran_con =  $supp_bran->initialize();
					if($supp_bran_con){
					$sql = "INSERT INTO supplier_stocks
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					is_default,
					avg_net_cost,
					inactive)
					VALUES
					('".$new_id."',
					'".$supp_val_bran->supp_stock_code."',
					'".$supp_val_bran->description."',
					'".$supp_val_bran->supp_id."',
					'".$supp_val_bran->branch_id."',
					'".$supp_val_bran->uom."',
					'".$supp_val_bran->qty."',
					'".$supp_val_bran->unit_cost."',
					'".$supp_val_bran->disc_percent1."',
					'".$supp_val_bran->disc_percent2."',
					'".$supp_val_bran->disc_percent3."',
					'".$supp_val_bran->disc_amount1."',
					'".$supp_val_bran->disc_amount2."',
					'".$supp_val_bran->disc_amount3."',
					'".$supp_val_bran->avg_cost."',
					'".$supp_val_bran->net_cost."',
					'".$supp_val_bran->is_default."',
					'".$supp_val_bran->avg_net_cost."',
					'".$supp_val_bran->inactive."')";
					
					$res = mysql_query($sql);
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					}
					}		
					$def_temp = $this->load->database('default',TRUE);
					$def_temp->initialize();
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('supplier_stocks_temp');
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$supp_results = $query->result();
					$this->db->trans_complete();
					
					
					foreach($supp_results as $supp_val){	
					
					$supp_def = $this->load->database('default',TRUE);
					$supp_def->initialize();
					
					$sql = "INSERT INTO supplier_stocks
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					is_default,
					avg_net_cost,
					inactive)
					VALUES
					('".$new_id."',
					'".$supp_val->supp_stock_code."',
					'".$supp_val->description."',
					'".$supp_val->supp_id."',
					'".$supp_val->branch_id."',
					'".$supp_val->uom."',
					'".$supp_val->qty."',
					'".$supp_val->unit_cost."',
					'".$supp_val->disc_percent1."',
					'".$supp_val->disc_percent2."',
					'".$supp_val->disc_percent3."',
					'".$supp_val->disc_amount1."',
					'".$supp_val->disc_amount2."',
					'".$supp_val->disc_amount3."',
					'".$supp_val->avg_cost."',
					'".$supp_val->net_cost."',
					'".$supp_val->is_default."',
					'".$supp_val->avg_net_cost."',
					'".$supp_val->inactive."')";
					
					$res = mysql_query($sql);
					
					
					$sql = "INSERT INTO supplier_stocks_history
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					avg_net_cost,
					inactive, 
					added_by,
					datetime_added,
					checked_by,
					datetime_checked)
					VALUES
					('".$new_id."',
					'".$supp_val->supp_stock_code."',
					'".$supp_val->description."',
					'".$supp_val->supp_id."',
					'".$supp_val->branch_id."',
					'".$supp_val->uom."',
					'".$supp_val->qty."',
					'".$supp_val->unit_cost."',
					'".$supp_val->disc_percent1."',
					'".$supp_val->disc_percent2."',
					'".$supp_val->disc_percent3."',
					'".$supp_val->disc_amount1."',
					'".$supp_val->disc_amount2."',
					'".$supp_val->disc_amount3."',
					'".$supp_val->avg_cost."',
					'".$supp_val->net_cost."',
					'".$supp_val->avg_net_cost."',
					'".$supp_val->inactive."',
					'".$supp_val->added_by."',
					'".$supp_val->datetime_added."',
					'".$user."',
					'".date('Y-m-d H:i:s')."')";
					$res = mysql_query($sql);
					
					}
					
					//############supplier_stock##############################//	
					
					
					
					//######################BARCODE########################//
					$this->db->select('*');
					$this->db->from('stock_barcodes_new_temp');
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$bar_result = $query->result();	
					
					foreach($bar_result as $val_bar){
					
					$db_bran = $this->load->database($branch[$num],TRUE);
					$db_bran_con = $db_bran->initialize();		
					if($db_bran_con){
					$sql1 = "INSERT INTO stock_barcodes_new
					(stock_id,
					barcode,
					short_desc,
					description,
					uom,
					qty,
					sales_type_id,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_bar->barcode."',
					'".$val_bar->short_desc."',
					'".$val_bar->description."',
					'".$val_bar->uom."',
					'".$val_bar->qty."',
					'".$val_bar->sales_type_id."',
					'".$val_bar->inactive."')";
					
					$res = mysql_query($sql1);
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					}
					
					$prices_result = $this->get_barcode_prices($l_barcode,$num);
					
					foreach($prices_result as $val_bar_price){		
					$db_bran_price = $this->load->database($branch[$num],TRUE);
					$db_bran_price_con  = $db_bran_price->initialize();	
					if($db_bran_price_con){
					$sql = "INSERT INTO stock_barcode_prices
					(barcode,
					sales_type_id,
					price,
					branch_id,
					computed_srp,
					prevailing_unit_price,
					landed_cost_markup,
					cost_of_sales_markup)
					VALUES
					('".$val_bar_price->barcode."',
					'".$val_bar_price->sales_type_id."',
					'".$val_bar_price->price."',
					'".$val_bar_price->branch_id."',
					'".$val_bar_price->computed_srp."',
					'".$val_bar_price->prevailing_unit_price."',
					'".$val_bar_price->landed_cost_markup."',
					'".$val_bar_price->cost_of_sales_markup."')";					
					
					mysql_query($sql);
					
					}else{
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					}
					}
					
					}
					
					$db_bran_price_def = $this->load->database('default',TRUE);
					$db_bran_price_def->initialize();
					
					$sql = "INSERT INTO stock_barcode_prices
					(barcode,
					sales_type_id,
					price,
					branch_id,
					computed_srp,
					prevailing_unit_price,
					landed_cost_markup,
					cost_of_sales_markup)
					VALUES
					('".$val_bar_price->barcode."',
					'".$val_bar_price->sales_type_id."',
					'".$val_bar_price->price."',
					'".$val_bar_price->branch_id."',
					'".$val_bar_price->computed_srp."',
					'".$val_bar_price->prevailing_unit_price."',
					'".$val_bar_price->landed_cost_markup."',
					'".$val_bar_price->cost_of_sales_markup."')";					
					
					mysql_query($sql);	 
					}
					
					}		// //######################BARCODE########################//
					
					
					}else{
					/*
					if($no_connection == null){
					array_push($no_connection,$branch[$num]);
					array_push($branch_name,$branch[$num]);
					}else{
					array_push($no_connection,'|'.$branch[$num]);
					array_push($branch_name,'|'.$branch[$num]);	
					}
					*/
					
					if($no_connection == null){
					if(!in_array($branch[$num],$no_connection)){
					array_push($no_connection,$branch[$num]);
					array_push($branch_name,$branch[$num]);
					array_push($no_con_array,$branch[$num]);
					}
					}else{
					if(!in_array('|'.$branch[$num],$no_connection) || !in_array($branch[$num],$no_connection) ){
					array_push($no_connection,'|'.$branch[$num]);
					array_push($branch_name,$branch[$num]);
					array_push($no_con_array,$branch[$num]);
					}
					}
					
					}
					
					}	
					
					$branch_not_con =  implode($no_connection);
					$branch_name_con =  implode($branch_name);
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					
					if($num_branch == $num+1 && $branch_not_con == null){
					
					$sql_stock_cards ="DELETE FROM  pos_stock_cards_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_cards);
					
					$sql_stock_discounts ="DELETE FROM  pos_stock_discounts_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_discounts);
					
					$sql_stock_cost ="DELETE FROM  stock_cost_of_sales_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_cost);
					
					$sql_branch_stock_cost ="DELETE FROM  branch_stocks_temp WHERE stock_id=".$old_id;
					mysql_query($sql_branch_stock_cost);	
					
					$sql_stock_master ="DELETE FROM  stock_master_new_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_master);
					
					$sql_suppliers_stock ="DELETE FROM  supplier_stocks_temp WHERE stock_id=".$old_id;
					mysql_query($sql_suppliers_stock);
					
					$del_bar = array();	
					$sql = "SELECT * FROM stock_barcodes_new_temp WHERE stock_id = ".$old_id." ";				
					$query = $this->db->query($sql);
					$res = $query->result();
					
					foreach($res as $res_bar){
					array_push ($del_bar,$res_bar->barcode);	
					}
					
					$del_barcode = implode( ',', $del_bar);	
					$sql1 ="DELETE FROM  stock_barcode_prices_temp WHERE barcode IN (".$del_barcode.")";
					$ret = mysql_query($sql1);
					
					$sql ="DELETE FROM  stock_barcodes_new_temp WHERE stock_id=".$old_id;
					$result = mysql_query($sql);
					unset($del_bar);
					
					//if($result)
					//	 return 'success||All branches has been updated';
					// return 'error';
					
					}else{
					$sql1 = "UPDATE stock_master_new_temp SET branch_no_con = '$branch_not_con',branch_no_con_id = '$new_id' WHERE stock_id = '$old_id' ";
					mysql_query($sql1);	
					
					$chk  = count($no_connection);
					if($chk > 1){
					$branch_name = explode('|',$branch_not_con);
					$num_branch = count($branch_name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$this->get_branch_id($branch_name[$num]));
					$num++;	
					}
					
					$upd_br =  $del_barcode = implode( ',', $branch);
					}else{
					$upd_br = $this->get_branch_id($no_connection[0]);
					}
					
					$sql1 = "UPDATE supplier_stocks_temp SET branch_no_con = '$branch_not_con', checked_by = '$user' , datetime_checked = '".date('Y-m-d H:i:s')."',branch_no_con_id = '$new_id'  WHERE stock_id = '$old_id' AND branch_id IN (".$upd_br.") ";
					mysql_query($sql1);	
					
					$del_suppliers_stock ="DELETE FROM  supplier_stocks_temp WHERE stock_id=".$old_id." AND branch_id NOT IN (".$upd_br.")";
					mysql_query($del_suppliers_stock);
					
					$sql11 = "UPDATE stock_barcodes_new_temp SET branch_no_con = '$branch_not_con' ,branch_no_con_id = '$new_id' WHERE stock_id = '$old_id' ";
					mysql_query($sql11);
					
					//return 'no_con||unable to update '.$branch_not_con.' no connection' ;
					}
					
					#############################################################
					
					
					}
					
					$branch_nocon =  implode($no_con_array);
					if($branch_nocon != null){
					return 'no_con||unable to update no connection' ;
					}else{
					return 'success||All branches has been updated'; 
					}
					
					
					
					}
					
					
					############# add multiple
					
					
					//rhan mulltiple approval
					
					public function multiple_stock_barcode_approval($stock_ids=array()){
					
					$ids = count($stock_ids);
					$nums = 0;
					
					$no_con_array = array();
					while($ids != $nums){
					$nums = $nums + 1;
					$old_id = $stock_ids[$nums-1];
					//rhan start
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('stock_master_new_temp');
					if($old_id != null)
					$this->db->where('stock_id',$old_id);
					$query = $this->db->get();
					$result = $query->result(); // result for stock_master in temporary table 
					$this->db->trans_complete();
					
					$no_connection = array();
					$branch_name = array();
					$var1=array();
					
					$sql = "SELECT branch_no_con FROM stock_master_new_temp WHERE stock_id = '$old_id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					
					}else{
					
					$branch = array('');
					$test = $this->get_all_branches();
					foreach($test as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);		
					
					
					$bdb = $this->load->database('default',TRUE);
					$connected = $bdb->initialize();	
					
					foreach($result as $val){	
					$sql = "INSERT INTO stock_master_new
		            (
					stock_code,
					category_id,
					tax_type_id,
					description,
					report_uom,
					report_qty,
					mb_flag,
					is_consigned,
					inventory_account,
					adjustment_account,
					assembly_cost_account,
					standard_cost,
					last_cost,
					cost_of_sales,
					is_saleable,
					senior_citizen_tag,
					earn_suki_points,
					date_added,
					inactive)
					VALUES
					(
					'".$val->stock_code."',
					'".$val->category_id."',
					'".$val->tax_type_id."',
					'".$val->description."',
					'".$val->report_uom."',
					'".$val->report_qty."',
					'".$val->mb_flag."',
					'".$val->is_consigned."',
					'".$val->inventory_account."',
					'".$val->adjustment_account."',
					'".$val->assembly_cost_account."',
					'".$val->standard_cost."',
					'".$val->last_cost."',
					'".$val->cost_of_sales."',
					'".$val->is_saleable."',
					'".$val->senior_citizen_tag."',
					'".$val->earn_suki_points."',
					'".$val->date_added."',
					'".$val->inactive."')";
					$res = mysql_query($sql);
					
					$new_id = mysql_insert_id();
					}
					}
					
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					
					if($connected){
					
					
					foreach($result as $val){	
					
					$sql = "INSERT INTO stock_master_new
		            (
					stock_id,
					stock_code,
					category_id,
					tax_type_id,
					description,
					report_uom,
					report_qty,
					mb_flag,
					is_consigned,
					inventory_account,
					adjustment_account,
					assembly_cost_account,
					standard_cost,
					last_cost,
					cost_of_sales,
					is_saleable,
					senior_citizen_tag,
					earn_suki_points,
					date_added,
					inactive)
					VALUES
					(
					".$new_id.",
					'".$val->stock_code."',
					'".$val->category_id."',
					'".$val->tax_type_id."',
					'".$val->description."',
					'".$val->report_uom."',
					'".$val->report_qty."',
					'".$val->mb_flag."',
					'".$val->is_consigned."',
					'".$val->inventory_account."',
					'".$val->adjustment_account."',
					'".$val->assembly_cost_account."',
					'".$val->standard_cost."',
					'".$val->last_cost."',
					'".$val->cost_of_sales."',
					'".$val->is_saleable."',
					'".$val->senior_citizen_tag."',
					'".$val->earn_suki_points."',
					'".$val->date_added."',
					'".$val->inactive."')";
					mysql_query($sql);		  
					}
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_cards_temp');
					$this->db->where('stock_id',$old_id);//
					$query = $this->db->get();
					$result_cards = $query->result();
					$this->db->trans_complete();
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('pos_stock_discounts_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_discount = $query->result();
					$this->db->trans_complete();
					
					
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$cons = $bdb->initialize();
					//discount and cards
					if($cons){
					foreach($result_cards as $val_cards){
					$sql ="INSERT INTO pos_stock_cards
					(
					stock_id,
					sales_type_id,
					card_type_id,
					is_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_cards->sales_type_id."',
					'".$val_cards->card_type_id."',
					'".$val_cards->is_enabled."',
					'".$val_cards->inactive."'
					)";
					mysql_query($sql);
					}
					
					foreach($result_discount as $val_dis){
					$sql ="INSERT INTO pos_stock_discounts
					(
					stock_id,
					sales_type_id,
					pos_discount_id,
					disc_enabled,
					inactive
					) 
					VALUES
					(
					'".$new_id."',
					'".$val_dis->sales_type_id."',
					'".$val_dis->pos_discount_id."',
					'".$val_dis->disc_enabled."',
					'".$val_dis->inactive."'
					)";
					$success = mysql_query($sql);
					}
					}
					//cost of sale
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('stock_cost_of_sales_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_cost_sale = $query->result();
					$this->db->trans_complete();
					
					foreach($result_cost_sale as $val_cos){
					
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$val_cos->branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					foreach($result_bran as $datas){
					
					$db = $this->load->database($datas->code,TRUE);
					$db->initialize();
					
					$sql="INSERT INTO stock_cost_of_sales
					(stock_id,
					branch_id,
					cost_of_sales,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_cos->branch_id."',
					'".$val_cos->cost_of_sales."',
					'".$val_cos->inactive."') ";
					mysql_query($sql);
					
					}
					
					$def = $this->load->database('default',TRUE);
					$def->initialize();
					
					$sql1="INSERT INTO stock_cost_of_sales
					(stock_id,
					branch_id,
					cost_of_sales,
					inactive)
					VALUES
					('".$new_id."',
					'".$val_cos->branch_id."',
					'".$val_cos->cost_of_sales."',
					'".$val_cos->inactive."') ";
					
					mysql_query($sql1);
					
					}
					//branch stock_	
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('branch_stocks_temp');
					$this->db->where('stock_id',$old_id);//l
					$query = $this->db->get();
					$result_branch_cost = $query->result();
					$this->db->trans_complete();
					
					foreach($result_branch_cost as $val_bcos){
					
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$val_bcos->branch_id);
					$query = $this->db->get();
					$res_bran = $query->result();
					
					foreach($res_bran as $data){
					
					$db = $this->load->database($data->code,TRUE);
					$db->initialize();
					
					$sql = "INSERT INTO branch_stocks
					(stock_id,
					branch_id,
					qty,
					stock_loc_id)
					VALUES
					('".$new_id."',
					'".$val_bcos->branch_id."',
					'".$val_bcos->qty."',
					'".$val_bcos->stock_loc_id."')";
					mysql_query($sql);
					
					}
					
					$def = $this->load->database('default',TRUE);
					$def->initialize();
					
					$sql1 = "INSERT INTO branch_stocks
					(stock_id,
					branch_id,
					qty,
					stock_loc_id)
					VALUES
					('".$new_id."',
					'".$val_bcos->branch_id."',
					'".$val_bcos->qty."',
					'".$val_bcos->stock_loc_id."')";
					mysql_query($sql1);
					}
					
					}else{
					if($no_connection == null){
					array_push($no_connection,$branch[$num-1]);
					array_push($branch_name,$branch[$num-1]);
					array_push($no_con_array,$branch[$num-1]);
					}else{
					array_push($no_connection,'|'.$branch[$num-1]);
					array_push($branch_name,'|'.$branch[$num-1]);	
					array_push($no_con_array,'|'.$branch[$num-1]);	
					}
					}
					
					}	
					
					$branch_not_con =  implode($no_connection);
					$branch_name_con =  implode($branch_name);
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					if($num_branch == $num && $branch_not_con == null){
					
					$sql_stock_cards ="DELETE FROM  pos_stock_cards_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_cards);
					
					$sql_stock_discounts ="DELETE FROM  pos_stock_discounts_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_discounts);
					
					$sql_stock_cost ="DELETE FROM  stock_cost_of_sales_temp WHERE stock_id=".$old_id;
					mysql_query($sql_stock_cost);
					
					$sql_branch_stock_cost ="DELETE FROM  branch_stocks_temp WHERE stock_id=".$old_id;
					mysql_query($sql_branch_stock_cost);	
					
					$sql_stock_master ="DELETE FROM  stock_master_new_temp WHERE stock_id=".$old_id;
					$result = mysql_query($sql_stock_master);
					
					}else{
					$sql1 = "UPDATE stock_master_new_temp SET branch_no_con = '$branch_not_con',branch_no_con_id = '$new_id' WHERE stock_id = '$old_id' ";
					mysql_query($sql1);		
					}
					
					//rhan end			
					} 
					$branch_nocon =  implode($no_con_array);
					if($branch_nocon != null){
					return 'no_con||unable to update no connection' ;
					}else{
					return 'success||All branches has been updated'; 
					}
					
					}
					
					///mutiple barcode prices approval
					public function multiple_barcode_prices_approvals($barcode_ids = array()){
					
					$ids = count($barcode_ids);
					
					//return $ids;
					$nums = 0;
					$branch_no_con = array();
					$no_brcon='';
					while($ids != $nums){
					$nums = $nums + 1;
					$barcode = $barcode_ids[$nums-1];
					
					$this->db->select('*');
					$this->db->from('stock_barcodes_new_temp');
					$this->db->where('barcode',$barcode);
					$query = $this->db->get();
					$result = $query->result();	
					
					foreach($result as $val){
				 	$sql = "SELECT branch_no_con FROM stock_barcodes_new_temp WHERE barcode = '$barcode' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					$branch = array('default');
					$test = $this->get_all_branches();
					foreach($test as $val_bran){
					array_push ($branch,$val_bran->code);		
					}
					$num_branch = count($branch);		
					
					}
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					if($connected){
					
					$sql = "INSERT INTO stock_barcodes_new
					(stock_id,
					barcode,
					short_desc,
					description,
					uom,
					qty,
					sales_type_id,
					inactive)
					VALUES
					('".$val->stock_id."',
					'".$val->barcode."',
					'".$val->short_desc."',
					'".$val->description."',
					'".$val->uom."',
					'".$val->qty."',
					'".$val->sales_type_id."',
					'".$val->inactive."')";
					
					$res = mysql_query($sql);
					
					if($res){
					
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					
					
					$this->db->select('*');
					$this->db->from('stock_barcode_prices_temp');
					if($barcode != null)
					$this->db->where('barcode',$barcode);
					$query = $this->db->get();
					$result_bar = $query->result();	
					
					foreach($result_bar as $value){
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$value->branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					$db = $this->load->database('default',TRUE);
					$cons = $db->initialize();
					
					foreach($result_bran as $data){
					$db = $this->load->database($data->code,TRUE);
					$con = $db->initialize();
					
					if($con){
					$sql = "INSERT INTO stock_barcode_prices
					(barcode,
					sales_type_id,
					price,
					branch_id,
					computed_srp,
					prevailing_unit_price,
					landed_cost_markup,
					cost_of_sales_markup)
					VALUES
					('".$value->barcode."',
					'".$value->sales_type_id."',
					'".$value->price."',
					'".$value->branch_id."',
					'".$value->computed_srp."',
					'".$value->prevailing_unit_price."',
					'".$value->landed_cost_markup."',
					'".$value->cost_of_sales_markup."')";
					
					$result = mysql_query($sql);
					}
					}
					$this->load->database('default',TRUE);
					$db->initialize();
					
					$sql = "INSERT INTO stock_barcode_prices
					(barcode,
					sales_type_id,
					price,
					branch_id,
					computed_srp,
					prevailing_unit_price,
					landed_cost_markup,
					cost_of_sales_markup)
					VALUES
					('".$value->barcode."',
					'".$value->sales_type_id."',
					'".$value->price."',
					'".$value->branch_id."',
					'".$value->computed_srp."',
					'".$value->prevailing_unit_price."',
					'".$value->landed_cost_markup."',
					'".$value->cost_of_sales_markup."')";
					
					$result = mysql_query($sql);
					
					}
					
					}
					
					
					
					}else{
					if($branch_no_con == null){
					array_push($branch_no_con,$branch[$num-1]);
					}else{
					array_push($branch_no_con,'|'.$branch[$num-1]);
					}
					}			
					
					}
					}//FOR EACH			 
					$no_brcon = implode($branch_no_con);	
					if($branch_no_con == null){
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					if($con){
					$sql ="DELETE FROM  stock_barcodes_new_temp WHERE barcode=".$barcode;
					mysql_query($sql);
					
					$sql1 ="DELETE FROM  stock_barcode_prices_temp WHERE barcode=".$barcode;
					$ret = mysql_query($sql1);
					}
					}else{
					$sql1 = "UPDATE stock_barcodes_new_temp SET branch_no_con = '$no_brcon'  WHERE barcode = '$barcode' ";
					mysql_query($sql1);		
					}
					
					}//while
					if($no_brcon != null){
					return 'no_con||unable to update '.$no_brcon.' no connection' ;
					}else{
					return 'success||All branches has been updated';
					
					}
					
					
					
					
					}//prices approval end
					
					public function multiple__stock_deletion_approval($stock_ids = array(),$user){
					$ids = count($stock_ids);
					
					$nums = 0;
					while($ids != $nums){
					$nums = $nums + 1;
					$id_stock_id = explode(':',$stock_ids[$nums-1]);
					$stock_id = $id_stock_id[0];
					$id = $id_stock_id[1];
					
					$sql = "SELECT branch_no_con FROM stock_deletion_approval WHERE id = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					$branch_name = array();
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					
					$branch = array('default');
					$test = $this->get_all_branches();
					foreach($test as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);	
					
					
					$num_branch = count($branch);	
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					
					if($connected){
					$sql1="UPDATE stock_master_new SET inactive  = '1' WHERE stock_id=".$stock_id;	
					$results_query = mysql_query($sql1);
					
					}else{
					if($branch_name == null){
					array_push($branch_name,$branch[$num-1]);
					}else{
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
					}
					}
					$branch_name_con =  implode($branch_name);	
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$date = date('Y-m-d');
					if($branch_name_con == ''){
					$sql11 = "UPDATE stock_deletion_approval SET approval_status = '1' , date_checked = '".$date."', checked_by = '".$user."' WHERE id = '$id' ";
					mysql_query($sql11);
					//echo 'success';
					}else{
					$sql11 = "UPDATE stock_deletion_approval SET branch_no_con = '$branch_name_con'  WHERE id = '$id' ";
					mysql_query($sql11);		
					//echo 'success';
					}
					
					}	
					
					
					
					}
					return 'success';
					}
					
					//mhae start approve
					public function multiple_supplier_stocks_approvals($stock_ids = array(), $user){
					$ids = count($stock_ids);
					$nums = 0;
					while($ids != $nums){
					$nums = $nums + 1;
					$id = $stock_ids[$nums-1];
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('supplier_stocks_temp');
					if($id != null)
					$this->db->where('id',$id);
					$query = $this->db->get();
					$result = $query->result();
					$this->db->trans_complete();
					
					$no_connection = array();
					$branch_name = array();
					$var1=array();
					
					$sql = "SELECT branch_no_con, branch_id FROM supplier_stocks_temp WHERE id = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$row->branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					$branch = array('default');
					
					foreach($result_bran as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);		
					
					
					}
					
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					if($connected){
					foreach($result as $val){				
					$sql = "INSERT INTO supplier_stocks
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					is_default,
					avg_net_cost,
					inactive)
					VALUES
					('".$val->stock_id."',
					'".$val->supp_stock_code."',
					'".$val->description."',
					'".$val->supp_id."',
					'".$val->branch_id."',
					'".$val->uom."',
					'".$val->qty."',
					'".$val->unit_cost."',
					'".$val->disc_percent1."',
					'".$val->disc_percent2."',
					'".$val->disc_percent3."',
					'".$val->disc_amount1."',
					'".$val->disc_amount2."',
					'".$val->disc_amount3."',
					'".$val->avg_cost."',
					'".$val->net_cost."',
					'".$val->is_default."',
					'".$val->avg_net_cost."',
					'".$val->inactive."')";
					
					$res = mysql_query($sql);
					$sql = "INSERT INTO supplier_stocks_history
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					avg_net_cost,
					inactive, 
					added_by,
					datetime_added,
					checked_by,
					datetime_checked)
					VALUES
					('".$val->stock_id."',
					'".$val->supp_stock_code."',
					'".$val->description."',
					'".$val->supp_id."',
					'".$val->branch_id."',
					'".$val->uom."',
					'".$val->qty."',
					'".$val->unit_cost."',
					'".$val->disc_percent1."',
					'".$val->disc_percent2."',
					'".$val->disc_percent3."',
					'".$val->disc_amount1."',
					'".$val->disc_amount2."',
					'".$val->disc_amount3."',
					'".$val->avg_cost."',
					'".$val->net_cost."',
					'".$val->avg_net_cost."',
					'".$val->inactive."',
					'".$val->added_by."',
					'".$val->datetime_added."',
					'".$user."',
					'".date('Y-m-d H:i:s')."')";
					
					$res = mysql_query($sql);
					
					
					}
					
					}else{
					if($no_connection == null){
					array_push($no_connection,$branch[$num-1]);
					array_push($branch_name,$branch[$num-1]);
					}else{
					array_push($no_connection,'|'.$branch[$num-1]);
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
					}
					}	
					
					$branch_not_con =  implode($no_connection);
					$branch_name_con =  implode($branch_name);
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					if($num_branch == $num && $branch_not_con == null){
					
					$sql_stock_master ="DELETE FROM  supplier_stocks_temp WHERE id=".$id;
					$result = mysql_query($sql_stock_master);
					
					}else{
					$sql1 = "UPDATE supplier_stocks_temp SET branch_no_con = '$branch_name_con', checked_by = '$user', datetime_checked = '".date('Y-m-d H:i:s')."' WHERE id = '$id' ";
					mysql_query($sql1);		
					}
					
					}
					if($branch_not_con != null){
					return 'no_con||unable to update '.$branch_not_con.' no connection' ;
					}else{
					return 'success||All branches has been updated';
					
					}	
					}
					public function stock_supplier_stocks_approval($id=null, $user=null){
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('supplier_stocks_temp');
					if($id != null)
					$this->db->where('id',$id);
					$query = $this->db->get();
					$result = $query->result();
					$this->db->trans_complete();
					
					$no_connection = array();
					$branch_name = array();
					$var1=array();
					
					$sql = "SELECT branch_no_con, branch_id FROM supplier_stocks_temp WHERE id = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$row->branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					$branch = array('default');
					
					foreach($result_bran as $val){
					array_push ($branch,$val->code);		
					}
					$num_branch = count($branch);		
					
					}
					
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					if($connected){
					foreach($result as $val){				
					$sql = "INSERT INTO supplier_stocks
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					is_default,
					avg_net_cost,
					inactive)
					VALUES
					('".$val->stock_id."',
					'".$val->supp_stock_code."',
					'".$val->description."',
					'".$val->supp_id."',
					'".$val->branch_id."',
					'".$val->uom."',
					'".$val->qty."',
					'".$val->unit_cost."',
					'".$val->disc_percent1."',
					'".$val->disc_percent2."',
					'".$val->disc_percent3."',
					'".$val->disc_amount1."',
					'".$val->disc_amount2."',
					'".$val->disc_amount3."',
					'".$val->avg_cost."',
					'".$val->net_cost."',
					'".$val->is_default."',
					'".$val->avg_net_cost."',
					'".$val->inactive."')";
					
					$res = mysql_query($sql);
					
					$sql = "INSERT INTO supplier_stocks_history
					(stock_id,
					supp_stock_code,
					description,
					supp_id,
					branch_id,
					uom,
					qty,
					unit_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					avg_cost,
					net_cost,
					avg_net_cost,
					inactive, 
					added_by,
					datetime_added,
					checked_by,
					datetime_checked)
					VALUES
					('".$val->stock_id."',
					'".$val->supp_stock_code."',
					'".$val->description."',
					'".$val->supp_id."',
					'".$val->branch_id."',
					'".$val->uom."',
					'".$val->qty."',
					'".$val->unit_cost."',
					'".$val->disc_percent1."',
					'".$val->disc_percent2."',
					'".$val->disc_percent3."',
					'".$val->disc_amount1."',
					'".$val->disc_amount2."',
					'".$val->disc_amount3."',
					'".$val->avg_cost."',
					'".$val->net_cost."',
					'".$val->avg_net_cost."',
					'".$val->inactive."',
					'".$val->added_by."',
					'".$val->datetime_added."',
					'".$user."',
					'".date('Y-m-d H:i:s')."')";
					$res = mysql_query($sql);
					
					}
					
					}else{
					if($no_connection == null){
					array_push($no_connection,$branch[$num-1]);
					array_push($branch_name,$branch[$num-1]);
					}else{
					array_push($no_connection,'|'.$branch[$num-1]);
					array_push($branch_name,'|'.$branch[$num-1]);	
					}
					}
					}	
					
					$branch_not_con =  implode($no_connection);
					$branch_name_con =  implode($branch_name);
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					if($num_branch == $num && $branch_not_con == null){
					
					$sql_stock_master ="DELETE FROM  supplier_stocks_temp WHERE id=".$id;
					$result = mysql_query($sql_stock_master);
					
					
					if($result)
					return 'success||All branches has been updated';
					return 'error';
					}else{
					$sql1 = "UPDATE supplier_stocks_temp SET branch_no_con = '$branch_name_con', checked_by = '$user', datetime_checked = '".date('Y-m-d H:i:s')."' WHERE id = '$id' ";
					mysql_query($sql1);		
					return 'no_con||unable to update '.$branch_not_con.' no connection' ;
					}
					
					}
					
					public function approve_added_movements($id=null, $branch_id= null, $user=null){
					
					$sql = "SELECT * FROM `movements` JOIN `movement_details` ON `movements`.`id` = `movement_details`.`header_id` AND `movements`.`branch_id` = `movement_details`.`branch_id` WHERE `movements`.`id` = '".$id."' AND `movements`.`branch_id` = '".$branch_id."'";
					$query = $this->db->query($sql);
					$result = $query->result();
					//	return var_dump($result);
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('movement_details');
					//	$this->db->join('movement_details', 'movements.id = movement_details.header_id');
					if($id != null)
					$this->db->where('header_id',$id);
					$query_ = $this->db->get();
					$result_ = $query_->result();
					$this->db->trans_complete();
					
					$br_ = '';
					//$sql = "SELECT branch_no_con, branch_id FROM movements WHERE id = '$id' ";
					//		$query = $this->db->query($sql);
					//		$row = $query->row();
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id', $branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					$branch = array('default');
					
					foreach($result_bran as $val){
					$br_ = $val->code;
					$br_1 = $val->code;
					array_push ($branch,$val->code);	
					}
					//return var_dump($branch);
					$num_branch = count($branch);		
					foreach($result as $val){
					$branch_id = $val->branch_id;
					$stock_id =$val->stock_id;
					//return $branch_id;
					//echo $br;
					$br = $this->load->database($br_,TRUE);
					$br_cons = $br->initialize();
					if($br_cons){
					$br_qty = $new_quantity = 0;
					
					
					//$br_qty = $this->get_branch_stock_qty_row($stock_id, $branch_i);
					$sql = "SELECT SUM(qty) as qty FROM `branch_stocks` WHERE stock_id = $stock_id AND branch_id=$branch_id";
					$query = mysql_query($sql);
					$row = mysql_fetch_array($query); 
					if ($row!= null){
					$br_qty = $row[0];
					//return $br_qty;
					}else{
					return 'Quantity for this stock does not exist. Unable to process transaction.';
					}
					
					$uom_qty = $this->get_uom_qty($val->uom);
					$qty_ = $val->qty * $uom_qty;
					//return $br_qty;
					$unit_cost_pcs = $val->unit_cost / $qty_;
					
					if($val->movement_type_id == 24){
					$new_quantity = $br_qty + $qty_;
					}else{
					$new_quantity = $br_qty - $qty_;
					}
					
					//$br_cost = $this->get_branch_stock_cost_of_sales_row($stock_id, $branch_id);
					$sql = "SELECT * FROM `stock_cost_of_sales` WHERE stock_id = $stock_id AND branch_id=$branch_id";
					$query = mysql_query($sql);
					$row = mysql_fetch_array($query); 
					$query = $this->db->query($sql);
					$row = $query->row();
					if ($row != null){
					$br_cost = $row->cost_of_sales;
					//return $row->cost_of_sales;
					}else{
					return false;
					}
					
					$extended = ($val->qty * $uom_qty) * $val->unit_cost;
					//return $new_quantity;
					//$new_cost = $br_cost * $uom_qty;
					//return $br_cost;
					if($new_quantity == 0){
					$cost_of_sales_ = 0;
					}else{
					$cost_of_sales = (($br_qty*$br_cost)+$extended)/($new_quantity);
					$cost_of_sales_ = round($cost_of_sales, 4);
					//return $cost_of_sales_;
					}
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					if($connected){
					$sql = "Update branch_stocks SET qty = '".$new_quantity."' WHERE stock_id = '".$val->stock_id."' AND branch_id = '".$val->branch_id."' AND stock_loc_id = '".$val->stock_location."'";												
					$res = mysql_query($sql);
					
					$sql1 = "Update stock_cost_of_sales SET last_cost_of_sales = '".$br_cost."', cost_of_sales = '".$cost_of_sales_."' WHERE stock_id = '".$val->stock_id."' AND branch_id = '".$val->branch_id."'";												
					$res1 = mysql_query($sql1);
					
					$sql2 = "INSERT INTO stock_moves_branch
					(branch_id,
					type,
					trans_no,
					reference,
					stock_id,
					barcode,
					stock_location,
					trans_date,
					user_id,
					unit_cost,
					unit_cost_pcs,
					qty,
					qty_pcs,
					stock_uom,
					standard_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_percent4,
					disc_percent5,
					disc_percent6,
					is_visible)
					VALUES
					('".$val->branch_id."',
					'".$val->movement_type_id."',
					'".$val->movement_no."',
					'".$val->reference."',
					'".$val->stock_id."',
					'".$val->barcode."',
					'".$val->stock_location."',
					'".$val->transaction_date."',
					'".$user."',
					'".$val->unit_cost."',
					'".$unit_cost_pcs."',
					'".$val->qty."',
					'".$qty_."',
					'".$val->uom."',
					'".$val->unit_cost."',
					'0',
					'0',
					'0',
					'0',
					'0',
					'0',
					'1')";
					$res2 = mysql_query($sql2);
					
					}
					}
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql_stock_master ="Update movements SET status = 1, posted_by = '$user', date_posted = '".date('Y-m-d H:i:s')."' WHERE id = '$id' AND branch_id = '$branch_id'";
					$result = mysql_query($sql_stock_master);		
					
					$br1 = $this->load->database($br_,TRUE);
					$br_cons1 = $br->initialize();
					if($br_cons1){
					$sql_stock_master ="Update movements SET status = 1, posted_by = '$user', date_posted = '".date('Y-m-d H:i:s')."' WHERE id = '$id' ";
					$result = mysql_query($sql_stock_master);
					
					}
					
					}else{
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql1 = "UPDATE movements SET branch_no_con = '$br_', posted_by = '$user', date_posted = '".date('Y-m-d H:i:s')."' WHERE id = '$id' AND branch_id = '$branch_id'";
					mysql_query($sql1);		
					return 'no_con||unable to update '.$br_.' no connection' ;
					
					}
					}
					if($result)
					return 'success||Branch has been updated';
					return 'error';
					
					}
					
					public function multiple_added_movement_approvals($movement_ids = array(), $user=null){
					//	return $movement_ids;	
					$ids = count($movement_ids);
					$nums = 0;
					$branch_no_con = array();
					while($ids != $nums){
					$nums = $nums + 1;
					$id_branch = $movement_ids[$nums-1];
					$id_br  = explode('_',$id_branch);
					$id = $id_br[0];
					$branch_id = $id_br[1];
					$db = $this->load->database('default',TRUE);
					$db->initialize();
					
					$sql = "SELECT * FROM `movements` JOIN `movement_details` ON `movements`.`id` = `movement_details`.`header_id` AND `movements`.`branch_id` = `movement_details`.`branch_id` WHERE `movements`.`id` = '".$id."' AND `movements`.`branch_id` = '".$branch_id."'";
					$query = $this->db->query($sql);
					$result = $query->result();
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('movement_details');
					//	$this->db->join('movement_details', 'movements.id = movement_details.header_id');
					if($id != null)
					$this->db->where('header_id',$id);
					$query_ = $this->db->get();
					$result_ = $query_->result();
					$this->db->trans_complete();
					
					$no_connection = array();
					$branch_name = array();
					$var1=array();
					$br = '';
					
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					$branch = array('default');
					
					foreach($result_bran as $val){
					$br_ = $val->code;
					$br_1 = $val->code;
					array_push ($branch,$val->code);	
					}
					$num_branch = count($branch);		
					
					foreach($result as $val){
					$branch_id = $val->branch_id;
					$stock_id =$val->stock_id;
					//echo $br;
					$br = $this->load->database($br_,TRUE);
					$br_cons = $br->initialize();
					if($br_cons){
					$br_qty = $new_quantity = 0;
					
					
					//$br_qty = $this->get_branch_stock_qty_row($stock_id, $branch_i);
					$sql = "SELECT SUM(qty) as qty FROM `branch_stocks` WHERE stock_id = $stock_id AND branch_id=$branch_id";
					$query = mysql_query($sql);
					$row = mysql_fetch_array($query); 
					if ($row!= null){
					$br_qty = $row[0];
					//	return $br_qty;
					}else{
					return 'Quantity for this stock does not exist. Unable to process transaction.';
					}
					
					$uom_qty = $this->get_uom_qty($val->uom);
					$qty_ = $val->qty * $uom_qty;
					//return $br_qty;
					$unit_cost_pcs = $val->unit_cost / $qty_;
					
					if($val->movement_type_id == 24){
					$new_quantity = $br_qty + $qty_;
					}else{
					$new_quantity = $br_qty - $qty_;
					}
					
					//$br_cost = $this->get_branch_stock_cost_of_sales_row($stock_id, $branch_id);
					$sql = "SELECT * FROM `stock_cost_of_sales` WHERE stock_id = $stock_id AND branch_id=$branch_id";
					$query = mysql_query($sql);
					$row = mysql_fetch_array($query); 
					$query = $this->db->query($sql);
					$row = $query->row();
					if ($row != null){
					$br_cost = $row->cost_of_sales;
					//return $row->cost_of_sales;
					}else{
					return false;
					}
					
					$extended = ($val->qty * $uom_qty) * $val->unit_cost;
					//return $new_quantity;
					//$new_cost = $br_cost * $uom_qty;
					//return $br_cost;
					if($new_quantity == 0){
					$cost_of_sales_ = 0;
					}else{
					$cost_of_sales = (($br_qty*$br_cost)+$extended)/($new_quantity);
					$cost_of_sales_ = round($cost_of_sales, 4);
					//return $cost_of_sales_;
					}
					//return $cost_of_sales_;
					$num =0;
					while($num_branch != $num){
					$num = $num + 1;
					$bdb = $this->load->database($branch[$num-1],TRUE);
					$connected = $bdb->initialize();
					if($connected){
					if($val->movement_type_id == 24){
					$sql = "Update branch_stocks SET qty += '".$qty_."' WHERE stock_id = '".$val->stock_id."' AND branch_id = '".$val->branch_id."' AND stock_loc_id = '".$val->stock_location."'";												
					$res = mysql_query($sql);
					}else{
					$sql = "Update branch_stocks SET qty -= '".$qty_."' WHERE stock_id = '".$val->stock_id."' AND branch_id = '".$val->branch_id."' AND stock_loc_id = '".$val->stock_location."'";												
					$res = mysql_query($sql);
					}			
					$sql1 = "Update stock_cost_of_sales SET last_cost_of_sales = '".$br_cost."', cost_of_sales = '".$cost_of_sales_."' WHERE stock_id = '".$val->stock_id."' AND branch_id = '".$val->branch_id."'";												
					$res1 = mysql_query($sql1);
					
					$sql2 = "INSERT INTO stock_moves_branch
					(branch_id,
					type,
					trans_no,
					reference,
					stock_id,
					barcode,
					stock_location,
					trans_date,
					user_id,
					unit_cost,
					unit_cost_pcs,
					qty,
					qty_pcs,
					stock_uom,
					standard_cost,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_percent4,
					disc_percent5,
					disc_percent6,
					is_visible)
					VALUES
					('".$val->branch_id."',
					'".$val->movement_type_id."',
					'".$val->movement_no."',
					'".$val->reference."',
					'".$val->stock_id."',
					'".$val->barcode."',
					'".$val->stock_location."',
					'".$val->transaction_date."',
					'".$user."',
					'".$val->unit_cost."',
					'".$unit_cost_pcs."',
					'".$val->qty."',
					'".$qty_."',
					'".$val->uom."',
					'".$val->unit_cost."',
					'0',
					'0',
					'0',
					'0',
					'0',
					'0',
					'1')";
					$res2 = mysql_query($sql2);
					}
					}
					// }
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql_stock_master ="Update movements SET status = 1, posted_by = '$user', date_posted = '".date('Y-m-d H:i:s')."' WHERE id = '$id' AND branch_id = '$branch_id'";
					$result = mysql_query($sql_stock_master);
					
					
					$br1 = $this->load->database($br_,TRUE);
					$br_cons1 = $br->initialize();
					if($br_cons1){
					
					$sql_stock_master ="Update movements SET status = 1, posted_by = '$user', date_posted = '".date('Y-m-d H:i:s')."' WHERE id = '$id' ";
					$result = mysql_query($sql_stock_master);
					}
					
					}else{
					array_push($branch_no_con,$br_);
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql1 = "UPDATE movements SET branch_no_con = '$br_', posted_by = '$user', date_posted = '".date('Y-m-d H:i:s')."' WHERE id = '$id' AND branch_id = '$branch_id'";
					mysql_query($sql1);			
					}
					}
					}
					if($branch_no_con){
					$branch_no_connection = implode($branch_no_con);
					return 'no_con|| '.$branch_no_connection.' unable to update';
					}else{
					return 'success||All branches has been updated';
					}
					}
					public function approve_added_purchase_orders($id=null, $user=null){
					
					$this->db->select('*');
					$this->db->from('purch_orders');
					$this->db->join('purch_order_details', 'purch_orders.order_no = purch_order_details.order_no');
					$this->db->where('purch_orders.order_no',$id);
					$query = $this->db->get();
					$result = $query->result();
					
					//echo var_dump($result);
					
					$this->db->select('*');
					$this->db->from('purch_order_details');
					//	$this->db->join('movement_details', 'movements.id = movement_details.header_id');
					if($id != null)
					$this->db->where('order_no',$id);
					$query_ = $this->db->get();
					$result_ = $query_->result();
					
					//echo var_dump($result_);
					
					$no_connection = array();
					$branch_name = array();
					$var1=array();
					$br = '';
					$sql = "SELECT * FROM purch_orders WHERE order_no = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$row->branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					$branch = array('default');
					
					foreach($result_bran as $val){
					$br_ = $val->code;
					array_push ($branch,$val->code);	
					}
					$num_branch = count($branch);		
					}
					foreach($result as $val){
					//echo $br;
					$br = $this->load->database($br_,TRUE);
					$br_cons = $br->initialize();
					if($br_cons){
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql_stock_master ="Update purch_orders SET status = 1, posted_by = '$user', date_posted= '".date('Y-m-d H:i:s')."' WHERE order_no = '$id' ";
					$result = mysql_query($sql_stock_master);
					$br1 = $this->load->database($br_,TRUE);
					$br_cons1 = $br->initialize();
					if($br_cons1){
					
					$sql1 = "INSERT INTO purch_orders
					(order_no,
					branch_id,
					supplier_id,
					comments,
					ord_date,
					reference,
					requisition_no,
					into_stock_location,
					delivery_address,
					delivery_date,
					total_amt,
					status,
					created_by,
					date_created,
					posted_by,
					date_posted)
					VALUES
					('".$val->order_no."',
					'".$val->branch_id."',
					'".$val->supplier_id."',
					'".$val->comments."',
					'".$val->ord_date."',
					'".$val->reference."',
					'".$val->requisition_no."',
					'".$val->into_stock_location."',
					'".$val->delivery_address."',
					'".$val->delivery_date."',
					'".$val->total_amt."',
					'1',
					'".$val->created_by."',
					'".$val->date_created."',
					'".$user."',
					'".date('Y-m-d H:i:s')."')";
					$res1 = mysql_query($sql1);
					
					foreach($result_ as $val_){
					$sql2 = "INSERT INTO purch_order_details
					(line_id,
					order_no,
					stock_id,
					description,
					uom,
					qty,
					pack,
					unit_cost,
					std_unit_cost,
					qty_ordered,
					qty_received,
					qty_invoiced,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					extended)
					VALUES
					('".$val_->line_id."',
					'".$val_->order_no."',
					'".$val_->stock_id."',
					'".$val_->description."',
					'".$val_->uom."',
					'".$val_->qty."',
					'".$val_->pack."',
					'".$val_->unit_cost."',
					'".$val_->std_unit_cost."',
					'".$val_->qty_ordered."',
					'".$val_->qty_received."',
					'".$val_->qty_invoiced."',
					'".$val_->disc_percent1."',
					'".$val_->disc_percent2."',
					'".$val_->disc_percent3."',
					'".$val_->disc_amount1."',
					'".$val_->disc_amount2."',
					'".$val_->disc_amount3."',
					'".$val_->extended."')";
					$res2 = mysql_query($sql2);
					}
					}
					if($result)
					return 'success||Branch has been updated';
					return 'error';
					}else{
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql1 = "UPDATE purch_orders SET branch_no_con = '$br_', posted_by = '$user', date_posted = '".date('Y-m-d H:i:s')."' WHERE order_no = '$id' ";
					mysql_query($sql1);		
					return 'no_con||unable to update '.$br_.' no connection' ;
					
					}
					}	
					
					}
					public function multiple_approve_added_purchase_orders($purchase_ids= array(), $user=null){
					$ids = count($purchase_ids);
					$nums = 0;
					$branch_no_con = array();
					while($ids != $nums){
					$nums = $nums + 1;
					$id = $purchase_ids[$nums-1];
					
					
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('purch_orders');
					$this->db->join('purch_order_details', 'purch_orders.order_no = purch_order_details.order_no');
					if($id != null)
					$this->db->where('purch_orders.order_no',$id);
					$query = $this->db->get();
					$result = $query->result();
					$this->db->trans_complete();
					$this->db->trans_start();
					$this->db->select('*');
					$this->db->from('purch_order_details');
					//	$this->db->join('movement_details', 'movements.id = movement_details.header_id');
					if($id != null)
					$this->db->where('order_no',$id);
					$query_ = $this->db->get();
					$result_ = $query_->result();
					
					
					$no_connection = array();
					$branch_name = array();
					$var1=array();
					$br = '';
					$sql = "SELECT branch_no_con, branch_id FROM purch_orders WHERE order_no = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					//echo var_dump($row);	
					if ($row->branch_no_con != ''){
					$num_branch = count($name);
					$total = $num_branch;
					$branch = array();
					$num =0;
					while($total != $num){
					array_push($branch,$name[$num]);
					$num++;	
					}
					}else{
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$row->branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					$branch = array('default');
					
					foreach($result_bran as $val){
					$br_ = $val->code;
					array_push ($branch,$val->code);	
					}
					$num_branch = count($branch);		
					}
					foreach($result as $val){
					//echo $br;
					$br = $this->load->database($br_,TRUE);
					$br_cons = $br->initialize();
					if($br_cons){
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql_stock_master ="Update purch_orders SET status = 1, posted_by = '$user', date_posted= '".date('Y-m-d H:i:s')."' WHERE order_no = '$id' ";
					$result = mysql_query($sql_stock_master);
					
					
					$br1 = $this->load->database($br_,TRUE);
					$br_cons1 = $br->initialize();
					if($br_cons1){
					
					$sql1 = "INSERT INTO purch_orders
					(order_no,
					branch_id,
					supplier_id,
					comments,
					ord_date,
					reference,
					requisition_no,
					into_stock_location,
					delivery_address,
					delivery_date,
					total_amt,
					status,
					created_by,
					date_created,
					posted_by,
					date_posted)
					VALUES
					('".$val->order_no."',
					'".$val->branch_id."',
					'".$val->supplier_id."',
					'".$val->comments."',
					'".$val->ord_date."',
					'".$val->reference."',
					'".$val->requisition_no."',
					'".$val->into_stock_location."',
					'".$val->delivery_address."',
					'".$val->delivery_date."',
					'".$val->total_amt."',
					'1',
					'".$val->created_by."',
					'".$val->date_created."',
					'".$user."',
					'".date('Y-m-d H:i:s')."')";
					$res1 = mysql_query($sql1);
					
					foreach($result_ as $val_){
					$sql2 = "INSERT INTO purch_order_details
					(line_id,
					order_no,
					stock_id,
					description,
					uom,
					qty,
					pack,
					unit_cost,
					std_unit_cost,
					qty_ordered,
					qty_received,
					qty_invoiced,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					extended)
					VALUES
					('".$val_->line_id."',
					'".$val_->order_no."',
					'".$val_->stock_id."',
					'".$val_->description."',
					'".$val_->uom."',
					'".$val_->qty."',
					'".$val_->pack."',
					'".$val_->unit_cost."',
					'".$val_->std_unit_cost."',
					'".$val_->qty_ordered."',
					'".$val_->qty_received."',
					'".$val_->qty_invoiced."',
					'".$val_->disc_percent1."',
					'".$val_->disc_percent2."',
					'".$val_->disc_percent3."',
					'".$val_->disc_amount1."',
					'".$val_->disc_amount2."',
					'".$val_->disc_amount3."',
					'".$val_->extended."')";
					$res2 = mysql_query($sql2);
					}
					}
					
					}else{
					array_push($branch_no_con,$br_);
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql1 = "UPDATE purch_orders SET branch_no_con = '$br_', posted_by = '$user', date_posted = '".date('Y-m-d H:i:s')."' WHERE order_no = '$id' ";
					mysql_query($sql1);			
					}
					}
					}
					if($branch_no_con){
					$branch_no_connection = implode($branch_no_con);
					return 'no_con|| '.$branch_no_connection.' unable to update';
					}else{
					return 'success||All branches has been updated';
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
					
					public function multiple_barcode_marginal_approvals($markdown_ids = array()){
					
					$ids = count($markdown_ids);
					$nums = 0;
					$branch_no_con = array();
					$no_brcon='';
					while($ids != $nums){
					$nums = $nums + 1;
					
					$markdown_branch_and_id = $markdown_ids[$nums-1];
					$branch_and_id = explode(':',$markdown_branch_and_id);
					$branch = $this->get_branch_code($branch_and_id[1]);
					$id = $branch_and_id[0];
					
					
					
					$db = $this->load->database('default',TRUE);
					$db->initialize();
					
					$this->db->select('*');
					$this->db->from('stock_barcode_marginal_markdown_temp');
					if($id != null)
					$this->db->where('id',$id);
					$query = $this->db->get();
					$result = $query->result();
					
					$db_branch = $this->load->database($branch,TRUE);
					$connected =  $db_branch->initialize();
					if($connected){
					
					foreach($result as $val){
					
					// $sql = "INSERT INTO stock_barcode_marginal_markdown
					// (stock_id,
					// barcode,
					// branch_id,
					// sales_type_id,
					// qty,
					// markup,
					// unit_price,
					// datetime_added,
					// datetime_modified,
					// added_by,
					// modified_by)
					// VALUES
					// ('".$val->stock_id."',
					// '".$val->barcode."',
					// '".$val->branch_id."',
					// '".$val->sales_type_id."',
					// '".$val->qty."',
					// '".$val->markup."',
					// '".$val->unit_price."',
					// '".$val->datetime_added."',
					// '".$val->datetime_modified."',
					// '".$val->added_by."',
					// '".$val->modified_by."')";
					// mysql_query($sql);
					
					$sql2 = "INSERT INTO stock_barcode_marginal_markdown
					(stock_id,
					barcode,
					branch_id,
					sales_type_id,
					qty,
					markup,
					unit_price,
					datetime_added,
					datetime_modified,
					modified_by) 
					VALUES (".$val->stock_id.",
					'".$val->barcode."',
					".$val->branch_id.",
					".$val->sales_type_id.",
					".$val->qty.",
					".$val->markup.",
					".$val->unit_price.",
					'".$val->datetime_added."',
					'".$val->datetime_modified."',
					'".$val->modified_by."')
					ON DUPLICATE KEY UPDATE qty='".$val->qty."', 
					markup=".$val->markup.",
					unit_price=".$val->unit_price."";
					mysql_query($sql2);
					
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					
					// $sql1 = "INSERT INTO stock_barcode_marginal_markdown
					// (stock_id,
					// barcode,
					// branch_id,
					// sales_type_id,
					// qty,
					// markup,
					// unit_price,
					// datetime_added,
					// datetime_modified,
					// added_by,
					// modified_by)
					// VALUES
					// ('".$val->stock_id."',
					// '".$val->barcode."',
					// '".$val->branch_id."',
					// '".$val->sales_type_id."',
					// '".$val->qty."',
					// '".$val->markup."',
					// '".$val->unit_price."',
					// '".$val->datetime_added."',
					// '".$val->datetime_modified."',
					// '".$val->added_by."',
					// '".$val->modified_by."')";
					
					// $res = mysql_query($sql1);
					$sql1 = "INSERT INTO stock_barcode_marginal_markdown
					(stock_id,
					barcode,
					branch_id,
					sales_type_id,
					qty,
					markup,
					unit_price,
					datetime_added,
					datetime_modified,
					modified_by) 
					VALUES (".$val->stock_id.",
					'".$val->barcode."',
					".$val->branch_id.",
					".$val->sales_type_id.",
					".$val->qty.",
					".$val->markup.",
					".$val->unit_price.",
					'".$val->datetime_added."',
					'".$val->datetime_modified."',
					'".$val->modified_by."')
					ON DUPLICATE KEY UPDATE qty='".$val->qty."', 
					markup=".$val->markup.",
					unit_price=".$val->unit_price."";
					mysql_query($sql1);
					
					
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					if($con){
					$sql ="DELETE FROM  stock_barcode_marginal_markdown_temp WHERE id=".$id;
					$ret = mysql_query($sql);
					}
					
					}
					}else{
					array_push($branch_no_con,$branch);
					$sql1 = "UPDATE stock_barcode_marginal_markdown_temp SET branch_no_con = '$branch'  WHERE id = '$id' ";
					mysql_query($sql1);	
					}
					
					}//while
					
					if($branch_no_con){
					$branch_no_connection = implode($branch_no_con);
					return 'no_con|| '.$branch_no_connection.' unable to update';
					}else{
					return 'success||All branches has been updated';
					}
					
					}//end
					
					
					public function multiple_barcode_markdown_approvals($markdown_ids = array()){
					
					$ids = count($markdown_ids);
					$nums = 0;
					$branch_no_con = array();
					$no_brcon='';
					while($ids != $nums){
					$nums = $nums + 1;
					
					$markdown_branch_and_id = $markdown_ids[$nums-1];
					$branch_and_id = explode(':',$markdown_branch_and_id);
					$branch = $this->get_branch_code($branch_and_id[1]);
					$id = $branch_and_id[0];
					
					
					
					$db = $this->load->database('default',TRUE);
					$db->initialize();
					
					$this->db->select('*');
					$this->db->from('stock_barcode_scheduled_markdown_temp');
					if($id != null)
					$this->db->where('id',$id);
					$query = $this->db->get();
					$result = $query->result();
					
					$db_branch = $this->load->database($branch,TRUE);
					$connected =  $db_branch->initialize();
					
					if($connected){
					
					foreach($result as $val){
					
					$sql = "INSERT INTO stock_barcode_scheduled_markdown
					(stock_id,
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
					inactive)
					VALUES
					('".$val->stock_id."',
					'".$val->barcode."',
					'".$val->branch_id."',
					'".$val->sales_type_id."',
					'".$val->start_date."',
					'".$val->end_date."',
					'".$val->start_time."',
					'".$val->end_time."',
					'".$val->markdown."',
					'".$val->original_price."',
					'".$val->discounted_price."',
					'".$val->datetime_added."',
					'".$val->datetime_modified."',
					'".$val->added_by."',
					'".$val->modified_by."',
					'".$val->inactive."')";
					mysql_query($sql);
					
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					$sql1 = "INSERT INTO stock_barcode_scheduled_markdown
					(stock_id,
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
					inactive)
					VALUES
					('".$val->stock_id."',
					'".$val->barcode."',
					'".$val->branch_id."',
					'".$val->sales_type_id."',
					'".$val->start_date."',
					'".$val->end_date."',
					'".$val->start_time."',
					'".$val->end_time."',
					'".$val->markdown."',
					'".$val->original_price."',
					'".$val->discounted_price."',
					'".$val->datetime_added."',
					'".$val->datetime_modified."',
					'".$val->added_by."',
					'".$val->modified_by."',
					'".$val->inactive."')";
					$res = mysql_query($sql1);
					if($res){
					$db = $this->load->database('default',TRUE);
					$con = $db->initialize();
					if($con){
					$sql ="DELETE FROM  stock_barcode_scheduled_markdown_temp WHERE id=".$id;
					$ret = mysql_query($sql);
					// if($ret)
					// return 'success';
					// return 'error';
					}
					}
					}
					}else{
					array_push($branch_no_con,$branch);
					$sql1 = "UPDATE stock_barcode_scheduled_markdown_temp SET branch_no_con = '$branch'  WHERE id = '$id' ";
					mysql_query($sql1);	
					}
					
					}//while
					
					if($branch_no_con){
					$branch_no_connection = implode($branch_no_con);
					return 'no_con|| '.$branch_no_connection.' unable to update';
					}else{
					return 'success||All branches has been updated';
					}
					
					
					}//end
					
					public function get_barcode_desc($barcode=null){
					$sql= "SELECT description FROM stock_barcodes_new WHERE barcode = '".$barcode."'";
					$query = mysql_query($sql);
					$result = mysql_fetch_object($query); 
					return $result->description;
					//return $sql ;
					}
					public function main_receiving_details($id=null){
					
					$this->db->select('*');
					$this->db->from('receiving_headers');
					$this->db->join('receiving_details', 'receiving_headers.id = receiving_details.receiving_id');
					$this->db->where('receiving_headers.id',$id);
					$query = $this->db->get();
					$result = $query->result();
					
					//echo var_dump($result);
					
					$this->db->select('*');
					$this->db->from('receiving_details');
					//	$this->db->join('movement_details', 'movements.id = movement_details.header_id');
					if($id != null)
					$this->db->where('receiving_id',$id);
					$query_ = $this->db->get();
					$result_ = $query_->result();
					
					//echo var_dump($result_);
					
					foreach($result as $val){
					//echo $br;
					$br = $this->load->database('central_db_default',TRUE);
					$br_cons = $br->initialize();
					if($br_cons){
					$sql1 = "INSERT INTO receiving_headers
					(id,
					purch_order_no,
					branch_id,
					supplier_id,
					reference,
					source_invoice_no,
					delivery_date,
					stock_location,
					receiving_comments,
					locked,
					status,
					created_by,
					datetime_created,
					posted_by,
					datetime_posted,
					branch_no_con)
					VALUES
					('".$val->id."',
					'".$val->purch_order_no."',
					'".$val->branch_id."',
					'".$val->supplier_id."',
					'".$val->reference."',
					'".$val->source_invoice_no."',
					'".$val->delivery_date."',
					'".$val->stock_location."',
					'".$val->receiving_comments."',
					'".$val->locked."',
					'".$val->status."',
					'".$val->created_by."',
					'".$val->datetime_created."',
					'".$val->posted_by."',
					'".$val->datetime_posted."',
					'".$val->branch_no_con."')";
					$res1 = mysql_query($sql1);
					
					foreach($result_ as $val_){
					$sql2 = "INSERT INTO receiving_details
					(line_id,
					branch_id,
					receiving_id,
					po_line_id,
					stock_id,
					description,
					receiving_uom,
					receiving_qty,
					qty_received,
					qty_invoiced,
					extended,
					receiving_notes)
					VALUES
					('".$val_->line_id."',
					'".$val_->branch_id."',
					'".$val_->receiving_id."',
					'".$val_->po_line_id."',
					'".$val_->stock_id."',
					'".$val_->description."',
					'".$val_->receiving_uom."',
					'".$val_->receiving_qty."',
					'".$val_->qty_received."',
					'".$val_->qty_invoiced."',
					'".$val_->extended."',
					'".$val_->receiving_notes."')";
					$res2 = mysql_query($sql2);
					$branch_id = $val->branch_id;
					$stock_loc_id = $val->stock_location;
					$stock_id = $val_->stock_id;
					
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					
					$sql = "SELECT * FROM `branch_stocks` WHERE stock_id = $stock_id AND branch_id=$branch_id AND stock_loc_id=$stock_loc_id";
					$query = $this->db->query($sql);
					$row = $query->row();
					$qty = $row->qty;
					
					$sql1 = "SELECT * FROM `stock_cost_of_sales` WHERE stock_id = $stock_id AND branch_id=$branch_id";
					$query1 = $this->db->query($sql1);
					$row1 = $query1->row();
					$cost_of_sales = $row1->cost_of_sales;
					
					$bdb = $this->load->database('central_db_default',TRUE);
					$cons = $bdb->initialize();
					
					$sql_br ="Update branch_stocks SET qty = '$qty' WHERE stock_id = '$stock_id' AND branch_id = '$branch_id' AND stock_loc_id = '$stock_loc_id'";
					$result = mysql_query($sql_br);
					
					$sql_cost ="Update stock_cost_of_sales SET cost_of_sales = '$cost_of_sales' WHERE stock_id = '$stock_id' AND branch_id = '$branch_id'";
					$result = mysql_query($sql_cost);
					}
					
					
					}else{
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql_br ="Update receiving_headers SET branch_no_con = 'main_server' WHERE id = '$id'";
					$result = mysql_query($sql_br);
					}
					}	
					}
					public function get_uom_qty($uom=null){
					$sql = "SELECT qty FROM stock_uoms WHERE unit_code = '$uom' ";
					// echo $sql."<br>";
					$query = $this->db->query($sql);
					$row = $query->row();
					if ($row != null)
					return $row->qty;
					else
					return false;
					}
					public function main_movement_details($id=null){
					
					$this->db->select('*');
					$this->db->from('movements');
					$this->db->join('movement_details', 'movements.id = movement_details.header_id');
					$this->db->where('movements.id',$id);
					$query = $this->db->get();
					$result = $query->result();
					
					//echo var_dump($result);
					
					$this->db->select('*');
					$this->db->from('movement_details');
					//	$this->db->join('movement_details', 'movements.id = movement_details.header_id');
					if($id != null)
					$this->db->where('header_id',$id);
					$query_ = $this->db->get();
					$result_ = $query_->result();
					
					//echo var_dump($result_);
					
					foreach($result as $val){
					//echo $br;
					$br = $this->load->database('central_db_default',TRUE);
					$br_cons = $br->initialize();
					if($br_cons){
					$sql1 = "INSERT INTO movements
					(id,
					movement_type_id,
					movement_no,
					reference,
					branch_id,
					transaction_date,
					status,
					created_by,
					date_created,
					posted_by,
					date_posted,
					total_amount,
					remarks,
					stock_location
					)
					VALUES
					('".$val->id."',
					'".$val->movement_type_id."',
					'".$val->movement_no."',
					'".$val->reference."',
					'".$val->branch_id."',
					'".$val->transaction_date."',
					'".$val->status."',
					'".$val->created_by."',
					'".$val->date_created."',
					'".$val->posted_by."',
					'".$val->date_posted."',
					'".$val->total_amount."',
					'".$val->remarks."',
					'".$val->stock_location."')";
					$res1 = mysql_query($sql1);
					
					foreach($result_ as $val_){
					$sql2 = "INSERT INTO movement_details
					(line_id,
					branch_id,
					header_id,
					stock_id,
					barcode,
					description,
					uom,
					qty,
					unit_cost,
					pack,
					avg_unit_cost)
					VALUES
					('".$val_->line_id."',
					'".$val_->branch_id."',
					'".$val_->header_id."',
					'".$val_->stock_id."',
					'".$val_->barcode."',
					'".$val_->description."',
					'".$val_->uom."',
					'".$val_->qty."',
					'".$val_->unit_cost."',
					'".$val_->pack."',
					'".$val_->avg_unit_cost."')";
					$res2 = mysql_query($sql2);
					}
					
					
					}else{
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql_br ="Update movements SET branch_no_con = 'main_server' WHERE id = '$id'";
					$result = mysql_query($sql_br);
					}
					}	
					}
					public function main_purchase_orders_details($id=null){
					
					$this->db->select('*');
					$this->db->from('purch_orders');
					$this->db->join('purch_order_details', 'purch_orders.order_no = purch_order_details.order_no');
					$this->db->where('purch_orders.order_no',$id);
					$query = $this->db->get();
					$result = $query->result();
					
					//echo var_dump($result);
					
					$this->db->select('*');
					$this->db->from('purch_order_details');
					//	$this->db->join('movement_details', 'movements.id = movement_details.header_id');
					if($id != null)
					$this->db->where('order_no',$id);
					$query_ = $this->db->get();
					$result_ = $query_->result();
					
					$sql = "SELECT branch_no_con, branch_id FROM purch_orders WHERE order_no = '$id' ";
					$query = $this->db->query($sql);
					$row = $query->row();
					$name = explode('|',$row->branch_no_con);
					//echo var_dump($row);	
					
					$this->db->select('*');
					$this->db->from('branches');
					$this->db->where('id',$row->branch_id);
					$query = $this->db->get();
					$result_bran = $query->result();
					
					
					foreach($result_bran as $val){
					$br_ = $val->code;
					
					}	
					//return var_dump($result_bran);
					
					foreach($result as $val){
					$br = $this->load->database($br_,TRUE);
					$br_cons = $br->initialize();
					//echo $br_cons;
					if($br_cons){
					$sql1 = "INSERT INTO purch_orders
					(order_no,
					branch_id,
					supplier_id,
					comments,
					ord_date,
					reference,
					requisition_no,
					into_stock_location,
					delivery_address,
					delivery_date,
					total_amt,
					status,
					created_by,
					date_created,
					posted_by,
					date_posted)
					VALUES
					('".$val->order_no."',
					'".$val->branch_id."',
					'".$val->supplier_id."',
					'".$val->comments."',
					'".$val->ord_date."',
					'".$val->reference."',
					'".$val->requisition_no."',
					'".$val->into_stock_location."',
					'".$val->delivery_address."',
					'".$val->delivery_date."',
					'".$val->total_amt."',
					'".$val->status."',
					'".$val->created_by."',
					'".$val->date_created."',
					'".$val->posted_by."',
					'".$val->date_posted."')";
					$res1 = mysql_query($sql1);
					
					foreach($result_ as $val_){
					$sql2 = "INSERT INTO purch_order_details
					(line_id,
					order_no,
					stock_id,
					description,
					uom,
					qty,
					pack,
					unit_cost,
					std_unit_cost,
					qty_ordered,
					qty_received,
					qty_invoiced,
					disc_percent1,
					disc_percent2,
					disc_percent3,
					disc_amount1,
					disc_amount2,
					disc_amount3,
					extended)
					VALUES
					('".$val_->line_id."',
					'".$val_->order_no."',
					'".$val_->stock_id."',
					'".$val_->description."',
					'".$val_->uom."',
					'".$val_->qty."',
					'".$val_->pack."',
					'".$val_->unit_cost."',
					'".$val_->std_unit_cost."',
					'".$val_->qty_ordered."',
					'".$val_->qty_received."',
					'".$val_->qty_invoiced."',
					'".$val_->disc_percent1."',
					'".$val_->disc_percent2."',
					'".$val_->disc_percent3."',
					'".$val_->disc_amount1."',
					'".$val_->disc_amount2."',
					'".$val_->disc_amount3."',
					'".$val_->extended."')";
					$res2 = mysql_query($sql2);
					}
					
					}else{
					$bdb = $this->load->database('default',TRUE);
					$cons = $bdb->initialize();
					$sql_br ="Update purch_orders SET branch_no_con = '$br_' WHERE order_no = '$id'";
					$result = mysql_query($sql_br);
					//echo $sql_br;
					}
					}	
					}		
					}	
					?>					