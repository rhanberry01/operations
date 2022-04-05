<?php
function audit_header_page($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-list-ol')."  AUDIT TRAIL"=>array('href'=>'#audit','class'=>'tab_link','load'=>'audit/audit_trail/','id'=>'audit_link'),
						// fa('fa-money')." BARCODE PRICES"=>array('href'=>'#price','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_stock_barcode_prices/','id'=>'price_link'),
						// fa('fa-book')." SCHEDULE MARKDOWN"=>array('href'=>'#markdown','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_inquiry_schedule_markdown/','id'=>'markdown_link'),
						// fa('fa-book')." UPDATE STOCK BARCODE/PRICES"=>array('href'=>'#update','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_update_inquiry/','id'=>'update_link'),
						// fa('fa-truck')."SUPPLIER STOCKS"=>array('href'=>'#supplier_stock','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_supplier_stocks/','id'=>'supplier_stock_link'),
						// fa('fa-minus-square-o')."STOCK FOR DELETION"=>array('href'=>'#stock_deletion','class'=>'tab_link load-tab','load'=>'inv_inquiries/stock_deletion_approval/','id'=>'stock_deletion_link'),
						// fa('fa-bar-chart')."MARGINAL MARKDOWN"=>array('href'=>'#marginal','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_inquiry_marginal_markdown/','id'=>'marginal_link'),

					);
					//$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'audit','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						// $CI->make->sTabPane(array('id'=>'price','class'=>'tab-pane'));
						// $CI->make->eTabPane();
						// $CI->make->sTabPane(array('id'=>'markdown','class'=>'tab-pane'));
						// $CI->make->eTabPane();
						// $CI->make->sTabPane(array('id'=>'supplier_stock','class'=>'tab-pane'));
						// $CI->make->eTabPane();
						// $CI->make->sTabPane(array('id'=>'stock_deletion','class'=>'tab-pane'));
						// $CI->make->eTabPane();
						// $CI->make->sTabPane(array('id'=>'marginal','class'=>'tab-pane '));
						// $CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}

function build_audit_trail_list($res=array())
{
	$CI =& get_instance();
	
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								'Action Description' => array('width'=>'25%'),
								'Content' => array('width'=>'25%'),
								'Date & Time' => array('width'=>'25%'),
								'User' => array('width'=>'25%'),
								// ' ' => array('width'=>'10%')
								);
							$rows = array();
							$type_desc = $supp_stock_id = $supp_stock_code = $supp_branch = '';
							$complete_desc = $main_stock_code = $main_stock_desc = '';
							$lvl1 = $lvl2 = $lvl3 = $lvl4 = $lvl5 = $lvl6 = $lvl_old = $lvl_new = $sublvl1 = $col_name = $col_desc_new = $col_desc_old = '';
							$ar_count = $ar_counter1 = $countme2 = 0;
							$countme = 1;
							foreach ($res as $val) {
								$type_desc = $val->type_desc;
								$new_type_desc = "";
								
								if(date('Y-m-d', strtotime($val->stamp)) <= date('Y-m-d', strtotime("+1 week"))){
									$new_type_desc .= $val->type_desc." <span class='label label-success'>NEW</span>";
								}else{
									$new_type_desc .= $val->type_desc;
								}
								
								switch($type_desc){
									case 'Add Stock' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[1]); //stock code
											$main_stock_desc = explode(':', $lvl1[2]); //description
											$complete_desc = "Stock Code : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_code[1], '"')."</span> <br>".
																  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_desc[1], '"')."</span>";
											break;
									case 'Updated Stock Master Details' :		
											$complete_desc = '';
											$lvl1 = explode("|=|", $val->description); // Separates pk_id=1 from stock_code=OLD:8717644190524
											$sublvl1 = explode("=", $lvl1[0]); //Separates pk_id from value 1
											// echo "PK VALUE [".$lvl1[0]."] :".$CI->audit_model->get_stock_desc_from_stock_id($sublvl1[1])."<br>";
											$ar_count = count($lvl1);
											$lvl2 = explode("|--|", $lvl1[1]); //Separates columns with old and new values
											$ar_counter1 = count($lvl2);
											// echo "Array Count:".$ar_count."<br>";
											// echo "2nd Array Counter:".$ar_counter1."<br>";
											$complete_desc .= "Updated Stock <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($sublvl1[1])."</span><br>";
											
											for($countme=0; $countme < $ar_counter1; $countme++){ //loop depending on total count of columns with old and new values
												$lvl3 = explode('|-|', $lvl2[$countme]);
												// echo $lvl3[0]."<===>".$lvl3[1]."<br>"; //lvl3[0]~~>COL NAME AND OLD VAL while lvl3[1]~~>NEW VALUE
												$lvl4 = explode('=', $lvl3[0]); //Separates column name from column's old value
												$lvl_old = explode(':', $lvl4[1]);
												$lvl_new = explode(':', $lvl3[1]);
												// echo "Column Name: ".$lvl4[0].'<~~~> OLD VAL:'.$lvl4[1]."<br>";
												// echo "New Val: ".$lvl3[1]."<br>";
												$col_name = $lvl4[0];
												$this_cols_only = array('mb_flag', 'category_id', 'PWD_disc', 'SC_disc', 'URC_crd', 'SUKI_crd');
												
												if(in_array($lvl4[0], $this_cols_only)){
													$col_desc_old = $CI->audit_model->get_description_from_id($col_name, $lvl_old[1]);
													$col_desc_new = $CI->audit_model->get_description_from_id($col_name, $lvl_new[1]);
												}else{
													$col_desc_old = $lvl_old[1];
													$col_desc_new = $lvl_new[1];
												}
												// echo $col_name."<-->".$col_desc_new."<br>"; //working
												$complete_desc .= "Changed <span style='text-decoration: underline; color:#f56954;'>".$lvl4[0]."</span> from <!--span style='color: #f56954;'-->".$col_desc_old."<!--/span--> to <span style='color: #5cb85c; font-weight: bold; text-decoration: underline;'>".$col_desc_new."</span><br>";
											}
											$complete_desc = $complete_desc;
											break;
									case 'Added Stock Barcode Details' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description);
											$lvl2 = explode('=', $lvl1[15]);
											$lvl3 = explode('=', $lvl1[16]);
											$lvl4 = explode('=', $lvl1[17]);
											$complete_desc = "Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($lvl2[1], '"')."</span> <br>".
																  "Short Description : <span style='font-weight: bold; color:#367fa9;'>".str_replace('+', ' ', $lvl3[1])."</span> <br>".
																  "Description : <span style='font-weight: bold; color:#367fa9;'>".str_replace('+', ' ', $lvl4[1])."</span>";
											break;
									case 'Updated Stock Barcode Details' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
											}
											$complete_desc = $complete_desc;
											break;
									case 'Added Supplier Stock' :
											$complete_desc = '';
											// echo "Add Supplier Stock : ".$val->id."</br>";
											$lvl1 = explode("|=|", $val->description); // Separates stock_id, supp_stock_code, branch from the rest
											// echo $lvl1[0]."<~~~>".$lvl1[1]."<br>";
											$lvl2 = explode("&", $lvl1[0]); //Separates stock_id, supp_stock_code and branch from their corresponding values
											$supp_stock_id = explode("=", $lvl2[0]);
											$supp_stock_code = explode("=", $lvl2[1]);
											$supp_branch = explode("=", $lvl2[2]);
											// echo $supp_stock_id[1]."--".$supp_stock_code[1]."--".$supp_branch[1]."<br>";
											$complete_desc .= "Added Supplier Stock <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($supp_stock_id[1])."</span><br>";
											$complete_desc .= "Supplier Stock Code: ".$supp_stock_code[1]."<br>";
											$complete_desc .= "Branch: ".$CI->audit_model->get_description_from_id('branch_id', $supp_branch[1])."<br>";
											$complete_desc = $complete_desc;
											break;
									case 'Updated Supplier Stock' :		
											$complete_desc = '';
											$lvl1 = explode("|=|", $val->description); // Separates first 3 important fields from the rest
											$lvl2 = explode("&", $lvl1[0]); //Separates stock_id, supp_stock_code and branch from their corresponding values
											$supp_stock_id = explode("=", $lvl2[0]);
											$supp_stock_code = explode("=", $lvl2[1]);
											$supp_branch = explode("=", $lvl2[2]);
											$complete_desc .= "Updated Supplier Stock <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>[".$supp_stock_code[1]."] ".$CI->audit_model->get_stock_desc_from_stock_id($supp_stock_id[1])."</span><br>";
											// $complete_desc .= $complete_desc;
											break;
									case 'Add Single Stock Barcode Markdown':
											$complete_desc = '';
											$lvl1 = explode("||", $val->description); // Separates first 3 important fields from the rest
											$lvl4 = explode(':', $lvl1[3]);
											// echo $lvl1[0]."<--->".$lvl1[1].'<-->'.$lvl1[2].'<br>';
											$supp_stock_id = explode(":", $lvl1[1]);
											$complete_desc .= "Added New Barcode for <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($supp_stock_id[1])."</span><br>";
											$complete_desc .= $lvl1[2]."<br>";
											$complete_desc = $complete_desc;
											break;
									case 'Add Stock Barcode Markdown - All Branches':
											$complete_desc = '';
											$lvl1 = explode("||", $val->description); // Separates first 3 important fields from the rest
											$lvl4 = explode(':', $lvl1[3]);
											// echo $lvl1[0]."<--->".$lvl1[1].'<-->'.$lvl1[2].'<br>';
											$supp_stock_id = explode(":", $lvl1[1]);
											$complete_desc .= "Added New Barcode for <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($supp_stock_id[1])."</span><br>";
											$complete_desc .= $lvl1[2]."<br>";
											$complete_desc .= "Branch: ".$CI->audit_model->get_description_from_id('branch_id', $lvl4[1])."<br>";
											$complete_desc = $complete_desc;
											break;
									case 'Add New Supplier':
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); // Separates first 3 important fields from the rest
											// echo $lvl1[0]."---".$lvl1[1]."<br>";
											$lvl2 = explode("=", $lvl1[1]); // Separates first 3 important fields from the rest
											$complete_desc .= "Supplier : [ ".$CI->audit_model->get_description_from_id('supplier_id_to_code', $lvl2[1])." ]".$CI->audit_model->get_description_from_id('supplier_id', $lvl2[1])."<br>";
											$complete_desc = $complete_desc;
											break;
									case 'Edit Supplier' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
											}
											$complete_desc = $complete_desc;
											break;
									case 'Add Customer' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_customer_code = explode(':', $lvl1[1]); 
											$main_customer_desc = explode(':', $lvl1[2]); 
											$complete_desc = "Customer Code : <span style='font-weight: bold; color:#367fa9;'>".trim($main_customer_code[1], '"')."</span> <br>".
																  "Customer Name : <span style='font-weight: bold; color:#367fa9;'>".trim($main_customer_desc[1], '"')."</span>";
											break;
										case 'Edit Customer' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
									case 'Add Customer Card Types' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_card_type_name = explode(':', $lvl1[1]); 
											$main_card_type_desc = explode(':', $lvl1[2]); 
											$complete_desc = "Card Name : <span style='font-weight: bold; color:#367fa9;'>".trim($main_card_type_name[1], '"')."</span> <br>".
																  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_card_type_desc[1], '"')."</span>";
											break;
									case 'Edit Customer Card Type' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Customer Cards' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_card_name = explode(':', $lvl1[1]); 
											$main_card_desc = explode(':', $lvl1[2]); 
											$complete_desc = "Card No : <span style='font-weight: bold; color:#367fa9;'>".trim($main_card_name[1], '"')."</span> <br>".
																  "Card Name : <span style='font-weight: bold; color:#367fa9;'>".trim($main_card_desc[1], '"')."</span>";
											break;
										case 'Edit Customer Card' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Sales Persons' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_sales_name = explode(':', $lvl1[1]); 
										
											$complete_desc = "Sales Person Name : <span style='font-weight: bold; color:#367fa9;'>".trim($main_sales_name[1], '"')."</span>";
											break;
										case 'Edit Sales Person' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Customer Branches' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_customer_id = explode(':', $lvl1[1]); 
											$main_customer_name = explode(':', $lvl1[2]); 
										
											$complete_desc = "Deptors ID : <span style='font-weight: bold; color:#367fa9;'>".trim($main_customer_id[1], '"')."</span> </br>".
													  "Branch Name : <span style='font-weight: bold; color:#367fa9;'>".trim($main_customer_name[1], '"')."</span>";
											break;
										case 'Edit Customer Branch' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Branch' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_branch_code = explode(':', $lvl1[1]); 
											$main_branch_name = explode(':', $lvl1[2]); 
										
											$complete_desc = "Branch Code : <span style='font-weight: bold; color:#367fa9;'>".trim($main_branch_code[1], '"')."</span> </br>".
													  "Branch Name : <span style='font-weight: bold; color:#367fa9;'>".trim($main_branch_name[1], '"')."</span>";
											break;
										case 'Edit Branch' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Payment Type' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_payment_type = explode(':', $lvl1[1]); 
										
											$complete_desc = "Payment Type: <span style='font-weight: bold; color:#367fa9;'>".trim($main_payment_type[1], '"')."</span>";
											break;
										case 'Edit Payment Type' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Payment Type Code' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_branch_code = explode(':', $lvl1[1]); 
											$main_branch_name = explode(':', $lvl1[2]); 
										
											$complete_desc = "Payment Type ID: <span style='font-weight: bold; color:#367fa9;'>".trim($main_branch_code[1], '"')."</span> </br>".
													  "Code : <span style='font-weight: bold; color:#367fa9;'>".trim($main_branch_name[1], '"')."</span>";
											break;
										case 'Edit Payment Type Code' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Acquiring Bank' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_bank_name = explode(':', $lvl1[1]); 
											$main_gl_bank = explode(':', $lvl1[2]); 
										
											$complete_desc = " Bank Name: <span style='font-weight: bold; color:#367fa9;'>".trim($main_bank_name[1], '"')."</span> </br>".
													  "GL BANK ACCOUNT : <span style='font-weight: bold; color:#367fa9;'>".trim($main_gl_bank[1], '"')."</span>";
											break;
										case 'Edit Acquiring Bank' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Discount Type' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_discount_type = explode(':', $lvl1[1]); 
											$main_description = explode(':', $lvl1[2]); 
										
											$complete_desc = " Discount Type: <span style='font-weight: bold; color:#367fa9;'>".trim($main_discount_type[1], '"')."</span> </br>".
													  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_description[1], '"')."</span>";
											break;
										case 'Edit Discount Type' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Unit of Measurement' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_uom_code = explode(':', $lvl1[1]); 
											$main_uom_description = explode(':', $lvl1[2]); 
										
											$complete_desc = " UOM Code: <span style='font-weight: bold; color:#367fa9;'>".trim($main_uom_code[1], '"')."</span> </br>".
													  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_uom_description[1], '"')."</span>";
											break;
										case 'Edit Unit of Measurement' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Stock Location' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_location_code = explode(':', $lvl1[1]); 
											$main_stock_location_description = explode(':', $lvl1[2]); 
										
											$complete_desc = " Stock Location Code: <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_location_code[1], '"')."</span> </br>".
													  "Stock Location Name : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_location_description[1], '"')."</span>";
											break;
										case 'Edit Stock Location' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Stock Category' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_cat_sdesc = explode(':', $lvl1[1]); 
											$main_stock_cat_desc = explode(':', $lvl1[2]); 
										
											$complete_desc = " Stock Category Name: <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_cat_sdesc[1], '"')."</span> </br>".
													  "Short Description: <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_cat_desc[1], '"')."</span>";
											break;
										case 'Edit Stock Category' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Movement Type' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_movement_type_desc = explode(':', $lvl1[1]);
										
											$complete_desc = " Movement Type Description: <span style='font-weight: bold; color:#367fa9;'>".trim($main_movement_type_desc[1], '"')."</span>";
											break;
										case 'Edit Movement Type' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Add Currency' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_curr_abbrev = explode(':', $lvl1[1]);
											$main_currency_name = explode(':', $lvl1[2]);
										
											$complete_desc = " Abbreviation: <span style='font-weight: bold; color:#367fa9;'>".trim($main_curr_abbrev[1], '"')."</span></br>".
																" Currency: <span style='font-weight: bold; color:#367fa9;'>".trim($main_currency_name[1], '"')."</span>";
											break;
										case 'Edit Currency' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Added Movement Entry' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_movement_id = explode(':', $lvl1[0]);
											$main_branch_code = explode(':', $lvl1[1]);
											$created_by = explode(':', $lvl1[2]);
											$main_transaction_date = explode(':', $lvl1[3]);
										
											$a = $CI->make->A(
												'&nbsp;&nbsp; View More',
												'View More',
												array('class'=>'action_btns movement_view_link',
													'ref_desc'=>'view me',
													'_id'=>$main_movement_id[1],
												//	'barcode'=>$val->barcode,
													'title'=>'view added movement entry',
													'return'=>'false'));
													
											$complete_desc = "Branch: <span style='font-weight: bold; color:#367fa9;'>".trim($main_branch_code[1], '"')."</span></br>".
															"Created By: <span style='font-weight: bold; color:#367fa9;'>".trim($created_by[1], '"')."</span></br>".
															"Transaction Date: <span style='font-weight: bold; color:#367fa9;'>".$main_transaction_date[1]."</span>".$a;
											break;
										case 'Added Purchase Orders' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_po_id = explode(':', $lvl1[0]);
											$main_branch_code = explode(':', $lvl1[1]);
											$created_by = explode(':', $lvl1[2]);
											$main_delivery_date = explode(':', $lvl1[3]);
										
											$a = $CI->make->A(
												'&nbsp;&nbsp; View More',
												'View More',
												array('class'=>'action_btns po_view_link',
													'ref_desc'=>'view me',
													'_id'=>$main_po_id[1],
												//	'barcode'=>$val->barcode,
													'title'=>'view added purchase orders',
													'return'=>'false'));
													
											$complete_desc = "Branch: <span style='font-weight: bold; color:#367fa9;'>".trim($main_branch_code[1], '"')."</span></br>".
															"Created By: <span style='font-weight: bold; color:#367fa9;'>".trim($created_by[1], '"')."</span></br>".
															"Delivery Date: <span style='font-weight: bold; color:#367fa9;'>".$main_delivery_date[1]."</span>".$a;
											break;
										case 'Approved Movement Entry' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_movement_id = explode(':', $lvl1[0]);
											$main_branch_code = explode(':"', $lvl1[1]);
											$main_created_by = explode(':', $lvl1[2]);
											$main_transaction_date = explode(':', $lvl1[3]);
											$branch_id = $CI->audit_model->get_branch_id($main_branch_code[1]);
									
											$a = $CI->make->A(
												'&nbsp;&nbsp; View More',
												'View More',
												array('class'=>'action_btns movement_view_link',
													'ref_desc'=>'view me',
													'_id'=>$main_movement_id[1],
													'branch_id'=>$branch_id,
												//	'barcode'=>$val->barcode,
													'title'=>'view approved movement entry',
													'return'=>'false'));
										$complete_desc = "Branch: <span style='font-weight: bold; color:#367fa9;'>".trim($main_branch_code[1], '"')."</span></br>".
															"Created By: <span style='font-weight: bold; color:#367fa9;'>".$main_created_by[1]."</span></br>".
															"Transaction Date: <span style='font-weight: bold; color:#367fa9;'>".$main_transaction_date[1]."</span>".$a;
											break;
										case 'Approved Purchase Orders' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_po_id = explode(':', $lvl1[0]);
											$main_branch_code = explode(':', $lvl1[1]);
											$main_created_by = explode(':', $lvl1[2]);
											$main_delivery_date = explode(':', $lvl1[3]);
											$a = $CI->make->A(
												'&nbsp;&nbsp; View More',
												'View More',
												array('class'=>'action_btns po_view_link',
													'ref_desc'=>'view me',
													'_id'=>$main_po_id[1],
												//	'barcode'=>$val->barcode,
													'title'=>'view approved purchase orders',
													'return'=>'false'));
										$complete_desc = "Branch: <span style='font-weight: bold; color:#367fa9;'>".trim($main_branch_code[1], '"')."</span></br>".
															"Created By: <span style='font-weight: bold; color:#367fa9;'>".$main_created_by[1]."</span></br>".
															"Transaction Date: <span style='font-weight: bold; color:#367fa9;'>".$main_delivery_date[1]."</span>".$a;
											break;
										case 'Rejected Movement Entry' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_movement_id = explode(':', $lvl1[0]);
											$branch_id = explode(':', $lvl1[1]);
											$main_remarks = explode(':', $lvl1[2]);
											$a = $CI->make->A(
												'&nbsp;&nbsp; View Details',
												'View Details',
												array('class'=>'action_btns movement_view_link',
													'ref_desc'=>'view me',
													'_id'=>$main_movement_id[1],
													'branch_id'=>$branch_id[1],
												//	'barcode'=>$val->barcode,
													'title'=>'view rejected movement entry',
													'return'=>'false'));
										$complete_desc = "Remarks: <span style='font-weight: bold; color:#367fa9;'>".trim($main_remarks[1], '"')."</span>".$a;
											break;
										case 'Rejected Purchase Orders' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_po_id = explode(':', $lvl1[0]);
											$main_remarks = explode(':', $lvl1[1]);
											$a = $CI->make->A(
												'&nbsp;&nbsp; View Details',
												'View Details',
												array('class'=>'action_btns po_view_link',
													'ref_desc'=>'view me',
													'_id'=>$main_po_id[1],
												//	'barcode'=>$val->barcode,
													'title'=>'view rejected purchase orders',
													'return'=>'false'));
										$complete_desc = "Remarks: <span style='font-weight: bold; color:#367fa9;'>".trim($main_remarks[1], '"')."</span>".$a;
											break;
										case 'Received Purchase Orders' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_po_id = explode(':', $lvl1[1]);
											$main_reference = explode(':', $lvl1[2]);
											$main_invoice = explode(':', $lvl1[3]);
											
										$complete_desc = "PO Order No.: <span style='font-weight: bold; color:#367fa9;'>".trim($main_po_id[1], '"')."</span></br>"."Reference: <span style='font-weight: bold; color:#367fa9;'>".trim($main_reference[1], '"')."</span></br>"."Invoice No.: <span style='font-weight: bold; color:#367fa9;'>".trim($main_invoice[1], '"')."</span>";
											break;	
										case 'Canceled Purchase Orders' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_po_id = explode(':', $lvl1[0]);
											$a = $CI->make->A(
												'&nbsp;&nbsp; View Details',
												'View Details',
												array('class'=>'action_btns po_view_link',
													'ref_desc'=>'view me',
													'_id'=>$main_po_id[1],
												//	'barcode'=>$val->barcode,
													'title'=>'view canceled purchase orders',
													'return'=>'false'));
										$complete_desc = "Purchase Order No.: <span style='font-weight: bold; color:#367fa9;'>".trim($main_po_id[1], '"')."</span>".$a;
											break;
										case 'Modify Purchase Orders' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
												if($lvl5[0] == 'branch_id'){
													$complete_desc.= "";
												}elseif($lvl5[0] == 'supplier_id'){
													$complete_desc.= "";
												}elseif($lvl5[0] == 'stock_location'){
													$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
													if($lvl_old[1] == null){
														$complete_desc .="OLD : ''<br>
																			NEW : <span style='font-weight: bold; color:#367fa9;'>".$CI->audit_model->get_stock_location($lvl_new[1])."</span><br>
																		";
													}elseif($lvl_new[1] == null){
														$complete_desc .="OLD : ".$CI->audit_model->get_stock_location($lvl_old[1])."<br>
																			NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																		";
													}else{
														$complete_desc .="OLD : ".$CI->audit_model->get_stock_location($lvl_old[1])."<br>
																			NEW : <span style='font-weight: bold; color:#367fa9;'>".$CI->audit_model->get_stock_location($lvl_new[1])."</span><br>
																		";
													}
												}elseif($lvl5[0] == 'undefined'){
													$srs = explode('_', $lvl_new[1]);
														$complete_desc .= ($srs[0] == 'srs' ? "Updated <span style='font-weight: bold; color:#367fa9;'>branch</span><br>" : "Updated <span style='font-weight: bold; color:#367fa9;'>supplier</span><br>");
														if($lvl_old[1] == null){
															$complete_desc .="OLD : ''<br>
																				NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																			";
														}elseif($lvl_new[1] == null){
															$complete_desc .="OLD : ".$lvl_old[1]."<br>
																				NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																			";
														}else{
															$complete_desc .="OLD : ".$lvl_old[1]."<br>
																				NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																			";
															}
												}else{
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
												}
											}
											
											$complete_desc = $complete_desc;
											break;
										case 'Extend Delivery Date' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_po_id = explode(':', $lvl1[0]);
											$main_old = explode(':', $lvl1[2]);
											$main_new = explode(':', $lvl1[1]);
											$a = $CI->make->A(
												'&nbsp;&nbsp; View Details',
												'View Details',
												array('class'=>'action_btns po_view_link',
													'ref_desc'=>'view me',
													'_id'=>$main_po_id[1],
												//	'barcode'=>$val->barcode,
													'title'=>'view canceled purchase orders',
													'return'=>'false'));
										$complete_desc = "Purchase Order No.: <span style='font-weight: bold; color:#367fa9;'>".trim($main_po_id[1], '"')."</span></br>".
														"Old Delivery Date.: <span style='font-weight: bold; color:#367fa9;'>".date('Y-M-d', strtotime($main_old[1]))."</span></br>".
														"New Delivery Date.: <span style='font-weight: bold; color:#367fa9;'>".date('Y-M-d', strtotime($main_new[1]))."</span>".$a;
											break;
										case 'Generate New Purchase Orders' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_po_id = explode(':', $lvl1[0]);
											$a = $CI->make->A(
												'&nbsp;&nbsp; View Details',
												'View Details',
												array('class'=>'action_btns po_view_link',
													'ref_desc'=>'view me',
													'_id'=>$main_po_id[1],
												//	'barcode'=>$val->barcode,
													'title'=>'view canceled purchase orders',
													'return'=>'false'));
										$complete_desc = "Purchase Order No.: <span style='font-weight: bold; color:#367fa9;'>".trim($main_po_id[1], '"')."</span>".$a;
											break;
										case 'Add New User' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_po_id = explode(':', $lvl1[0]);
											$main_emp_id = explode(':', $lvl1[1]);
											$main_name = explode(':', $lvl1[2]);
										
										$complete_desc = "Employee ID: <span style='font-weight: bold; color:#367fa9;'>".trim($main_emp_id[1], '"')."</span></br>".
															"Employee Name: <span style='font-weight: bold; color:#367fa9;'>".$main_name[1]."</span>";
											break;
										case 'Edit User' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
										case 'Approved Biller Code' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_id = explode(':', $lvl1[0]);
											$main_supp_name = explode(':', $lvl1[1]);
											$main_biller_code = explode(':', $lvl1[2]);
										
										$complete_desc = "Supplier ID: <span style='font-weight: bold; color:#367fa9;'>".trim($main_id[1], '"')."</span></br>".
															"Supplier Name: <span style='font-weight: bold; color:#367fa9;'>".$main_supp_name[1]."</span></br>".
															"Biller Code: <span style='font-weight: bold; color:#367fa9;'>".$main_biller_code[1]."</span>";
											break;
										case 'Rejected Biller Code' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_id = explode(':', $lvl1[0]);
											$main_supp_name = explode(':', $lvl1[1]);
											$main_biller_code = explode(':', $lvl1[2]);
											$main_remarks = explode(':', $lvl1[3]);
										
										$complete_desc = "Supplier ID: <span style='font-weight: bold; color:#367fa9;'>".trim($main_id[1], '"')."</span></br>".
															"Supplier Name: <span style='font-weight: bold; color:#367fa9;'>".$main_supp_name[1]."</span></br>".
															"Biller Code: <span style='font-weight: bold; color:#367fa9;'>".$main_biller_code[1]."</span></br>".
															"Remarks: <span style='font-weight: bold; color:#367fa9;'>".$main_remarks[1]."</span>";
											break;
										case 'Approved Stock Deletion' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[1]); //stock code
											$main_stock_desc = explode(':', $lvl1[2]); //description
											$complete_desc = "Stock Code : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_code[1], '"')."</span> <br>".
																  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_desc[1], '"')."</span>";
											break;
										case 'Rejected Stock Deletion' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[1]); //stock code
											$main_stock_desc = explode(':', $lvl1[2]); //description
											$complete_desc = "Stock Code : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_code[1], '"')."</span> <br>".
																  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_desc[1], '"')."</span>";
											break;
										case 'Approved Stock Barcode Price' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_short_desc= explode(':', $lvl1[2]); 
											$main_description= explode(':', $lvl1[3]); 
											$complete_desc = "Stock ID : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_code[1], '"')."</span> <br>".
																"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
																"Short Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_short_desc[1], '"')."</span> <br>".
																  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_description[1], '"')."</span>";
											break;
										case 'Rejected Stock Barcode Price' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_short_desc= explode(':', $lvl1[2]); 
											$main_description= explode(':', $lvl1[3]); 
											$complete_desc = "Stock ID : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_code[1], '"')."</span> <br>".
																"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
																"Short Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_short_desc[1], '"')."</span> <br>".
																  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_description[1], '"')."</span>";
											break;
										case 'Approved Supplier Stock' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_desc= explode(':', $lvl1[2]); 
											$main_branch_code= explode(':', $lvl1[3]); 
											$complete_desc = "Stock ID : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_code[1], '"')."</span> <br>".
																"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
																"Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_desc[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										case 'Rejected Supplier Stock' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_desc= explode(':', $lvl1[2]); 
											$main_branch_code= explode(':', $lvl1[3]); 
											$complete_desc = "Stock ID : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_code[1], '"')."</span> <br>".
															"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
															"Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_desc[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										case 'Approved Schedule Markdown' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_branch_code= explode(':', $lvl1[2]); 
											$complete_desc = "Approved New Barcode for <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($main_stock_code[1])."</span> <br>".
															"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										case 'Rejected Schedule Markdown' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_branch_code= explode(':', $lvl1[2]); 
											$complete_desc = "Rejected New Barcode for <span style='font-weight: bold; color:#367fa9;  text-decoration: underline;' >".$CI->audit_model->get_stock_desc_from_stock_id($main_stock_code[1])."</span> <br>".
															"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										case 'Approved Stock' :
										$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_description= explode(':', $lvl1[1]); 
											$complete_desc = "Stock Code : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_code[1], '"')."</span> <br>".
																  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_description[1], '"')."</span>";
											break;
										case 'Rejected Stock' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_description= explode(':', $lvl1[1]); 
											$complete_desc = "Stock Code : <span style='font-weight: bold; color:#367fa9;'>".trim($main_stock_code[1], '"')."</span> <br>".
																  "Description : <span style='font-weight: bold; color:#367fa9;'>".trim($main_description[1], '"')."</span>";
											break;
										case 'Approved Marginal Markdown' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_branch_code= explode(':', $lvl1[2]); 
											$complete_desc = "Approved New Barcode for <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($main_stock_code[1])."</span> <br>".
															"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										case 'Rejected Marginal Markdown' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_branch_code= explode(':', $lvl1[2]); 
											$complete_desc = "Rejected New Barcode for <span style='font-weight: bold; color:#367fa9;  text-decoration: underline;' >".$CI->audit_model->get_stock_desc_from_stock_id($main_stock_code[1])."</span> <br>".
															"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										case 'Approved Updated Stock Barcodes and Prices' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_branch_code= explode(':', $lvl1[2]); 
											$complete_desc = "Approved Updated Barcode for <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($main_stock_code[1])."</span> <br>".
															"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										case 'Rejected Updated Stock Barcodes and Prices' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_barcode= explode(':', $lvl1[1]); 
											$main_branch_code= explode(':', $lvl1[2]); 
											$complete_desc = "Rejected Updated Barcode for <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($main_stock_code[1])."</span> <br>".
															"Barcode: <span style='font-weight: bold; color:#367fa9;'>".trim($main_barcode[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										case 'Approved Updated Stock General and Stock Details' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_type= explode(':', $lvl1[1]); 
											$main_branch_code= explode(':', $lvl1[2]); 
											$complete_desc = "Approved Updated Barcode for <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($main_stock_code[1])."</span> <br>".
															"Type: <span style='font-weight: bold; color:#367fa9;'>".trim($main_type[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										case 'Rejected Updated Stock General and Stock Details' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_stock_code = explode(':', $lvl1[0]); //stock code
											$main_type= explode(':', $lvl1[1]); 
											$main_branch_code= explode(':', $lvl1[2]); 
											$complete_desc = "Approved Updated Barcode for <span style='font-weight: bold; color:#367fa9; text-decoration: underline;'>".$CI->audit_model->get_stock_desc_from_stock_id($main_stock_code[1])."</span> <br>".
															"Type: <span style='font-weight: bold; color:#367fa9;'>".trim($main_type[1], '"')."</span> <br>".
																  "Branch : <span style='font-weight: bold; color:#367fa9;'>".$main_branch_code[1]."</span>";
											break;
										default:
											$complete_desc = 'Default content';
											break;
										case 'Added Branch Counter' :
											$complete_desc = '';
											// echo "Add Stock : ".$val->id."</br>";
											$lvl1 = explode("||", $val->description);
											$main_branch = explode(':', $lvl1[1]);
											$main_counter_no = explode(':', $lvl1[2]);
										
											$complete_desc = " Branch: <span style='font-weight: bold; color:#367fa9;'>".trim($main_branch[1], '"')."</span></br>".
																" Counter #: <span style='font-weight: bold; color:#367fa9;'>".trim($main_counter_no[1], '"')."</span>";
											break;
										case 'Edit Branch Counter' :
											$complete_desc = '';
											$lvl1 = explode("&", $val->description); # lvl1[0] -> stock_id,  lvl1[1] -> barcode and the rest...
											$lvl2 = explode("|=|", $lvl1[1]); #separates barcode from the rest
											$lvl3 = explode("|--|", $lvl2[1]);
											$ar_count = count($lvl3);
											// echo $lvl3[0]."<~~~~~>".$lvl3[1]."<br>";
											// echo "Array Count : ".$ar_count."<br>";
											for($countme=0; $countme < $ar_count; $countme++){
												// echo "counter:".$countme."<br>";
												$lvl4 = explode('|-|', $lvl3[$countme]);
												$lvl5 = explode('=', $lvl4[0]);
												// $lvl6 = explode(':', $lvl5[1]);
												// echo $lvl4[0]."<~~~~~>".$lvl4[1]."<br>";
												$lvl_old = explode(':', $lvl5[1]);
												$lvl_new = explode(':', $lvl4[1]);
												// echo $lvl5[0]."<~~~~~>".$lvl5[1]."<br>";
												// echo $lvl6[0]."<~~~~~>".$lvl6[1]."<br>";
											
												$complete_desc .= "Updated <span style='font-weight: bold; color:#367fa9;'>".$lvl5[0]."</span><br>";
												if($lvl_old[1] == null){
													$complete_desc .="OLD : ''<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}elseif($lvl_new[1] == null){
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>''</span><br>
																	";
												}else{
													$complete_desc .="OLD : ".$lvl_old[1]."<br>
																		NEW : <span style='font-weight: bold; color:#367fa9;'>".$lvl_new[1]."</span><br>
																	";
												}
											}
											$complete_desc = $complete_desc;
											break;
								}
								
								$rows[] = array(
									array('text'=>$new_type_desc, 'params'=>array()),
									array('text'=>$complete_desc, 'params'=>array()),
									array('text'=>date('M-d-Y,  h:i A', strtotime($val->stamp)), 'params'=>array()),
									array('text'=>"<!--span class='label label-warning' style='size: 18px;'-->".$CI->audit_model->user_name($val->user)."<!--/span-->", 'params'=>array()),
									// array('text'=>'', 'params'=>array()),
								);
							}
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	return $CI->make->code();
}