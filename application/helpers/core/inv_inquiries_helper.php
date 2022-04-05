<?php
function build_barcode_list_form($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
						//	$CI->make->A(fa('fa-plus').' New Stock Item',base_url().'inv_inquiries/barcode_list/',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								//'Stock Code' => array('width'=>'12%'),
								'Barcode' => array('width'=>'20%'),
								'Description' => array('width'=>'25%'),
								
								// 'Brand' => array(),
								'UOM' => array(),
								'Quantity' => array()
							//	' ' => array('width'=>'10%')
								);
							$rows = array();
							foreach ($list as $val) {
								// $link = "";
								$link = $CI->make->A(
									fa('fa-pencil fa-lg fa-fw'),
									base_url().'inv_inquiries/barcode_list/'.$val->id,
									array('return'=>'true',
										'title'=>'Barcode'.$val->barcode)
								);
								$rows[] = array(
									$val->barcode,
									$val->description,	
									$val->uom,
									$val->qty,
									//array('text'=>$link,'params'=>array('style'=>'text-align:center'))
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
function add_for_approval_list_form_new_item($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
	
	$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'file-spinner-add'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Approve all checked items','',array('class'=>'btn btn-primary','id'=>'btn_ids'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						    $CI->make->append('<br>');
							$CI->make->A(fa('fa-check-square-o').' Check All','',array('class'=>'btn btn-success','id'=>'btn_checks'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							//array('text'=>$check_all, 'params'=>array('style'=>'text-align:center'));
							$th = array(
								
								'Stock Code' => array('text-align'=>'center'),
								'Description' => array('text-align'=>'center'),		
								'Report_UOM' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								// 'Action' => array('colspan'=>'3','style'=>'text-align:center')
								
								);
							$rows = array();
							$tag = $test ='';
							foreach ($list as $val) {
								$tag = $test = '';
								$a = $b = $c = "";
								//$description = explode('||',$val->description);	
								//$stock_id = explode(':',$description[0]);
								
								$a = $CI->make->A(
													fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'stock_id'=>$val->stock_id,
													'title'=>'view this',
													'return'=>'false'));
								$b = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'stock_id'=>$val->stock_id,
													'title'=>'approve this',
													'return'=>'false'));
								$c = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'stock_id'=>$val->stock_id,
													'title'=>'reject this',
													'return'=>'false'));
								// $disabledcheck = $CI->make->A(
												// '&nbsp;&nbsp;'.fa('fa-check fa-lg fa-fw'),
												// '',
												// array(
													// 'return'=>'false'));	
								// $disabledclose = $CI->make->A(
											// '&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
											// '',
											// array(
												// 'return'=>'false'));	
													
							
								// if($val->approval_remarks == 0 ){
									// $tag .= " <span class='label label-info'>PENDING</span>";
								// }elseif($val->approval_remarks == 1){
									// $tag .= " <span class='label label-success'>APPROVED</span>";
								// }else{
									// $tag .=" <span class='label label-error'>REJECTED</span>";
								// } 
								//	$tag,
								// ($val->approval_status != '0' ?  '' : (array('text'=>$b, 'params'=>array('style'=>'text-align:center')))),	
								//	($val->approval_status != '0' ?  '' :(array('text'=>$c, 'params'=>array('style'=>'text-align:center')))),
								
								$branch_no_con = explode('|', $val->branch_no_con);
								$branch_ = count($branch_no_con);
								$counter = 0;
								$data = '';
								while($counter != $branch_){
									
									$data .= " <span class='label label-danger'>".$branch_no_con[$counter]."</span>";
									$counter++;
								}
								$rows[] = array(
									$val->stock_code,
									$val->description,
									$val->report_uom,
									array('text'=>$a, 'params'=>array('style'=>'text-align:center')),	
									($val->branch_no_con != null ?   (array("text"=>"No Connection :</br>".$data, 'params'=>array('style'=>'text-align:center'))) : (array('text'=>$b, 'params'=>array('style'=>'text-align:center')))),	
									($val->branch_no_con != null ?  '' : (array('text'=>$c, 'params'=>array('style'=>'text-align:center')))),	
									//(array('text'=>$b, 'disabled'=>$val->branch_no_con = null ? 'disabled': '', 'params'=>array('style'=>'text-align:center'))),	
									//(array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									 ($val->branch_no_con != null ?  '' : $CI->make->checkbox_($val->stock_id,array('class'=>'check_ids','id'=>$val->stock_id)))
										
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
//rhan start approval list form
function for_approval_list_form_new_item($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
	
	$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'file-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Approve all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						    $CI->make->append('<br>');
							$CI->make->A(fa('fa-check-square-o').' Check All','',array('class'=>'btn btn-success','id'=>'btn_check'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							//array('text'=>$check_all, 'params'=>array('style'=>'text-align:center'));
							$th = array(
								
								'Stock Code' => array('text-align'=>'center'),
								'Description' => array('text-align'=>'center'),		
								'Report_UOM' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								// 'Action' => array('colspan'=>'3','style'=>'text-align:center')
								
								);
							$rows = array();
							$tag = $test ='';
							foreach ($list as $val) {
								$tag = $test = '';
								$a = $b = $c = "";
								//$description = explode('||',$val->description);	
								//$stock_id = explode(':',$description[0]);
								
								$a = $CI->make->A(
													fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'stock_id'=>$val->stock_id,
													'title'=>'view this',
													'return'=>'false'));
								$b = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'stock_id'=>$val->stock_id,
													'title'=>'approve this',
													'return'=>'false'));
								$c = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'stock_id'=>$val->stock_id,
													'title'=>'reject this',
													'return'=>'false'));
								// $disabledcheck = $CI->make->A(
												// '&nbsp;&nbsp;'.fa('fa-check fa-lg fa-fw'),
												// '',
												// array(
													// 'return'=>'false'));	
								// $disabledclose = $CI->make->A(
											// '&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
											// '',
											// array(
												// 'return'=>'false'));	
													
							
								// if($val->approval_remarks == 0 ){
									// $tag .= " <span class='label label-info'>PENDING</span>";
								// }elseif($val->approval_remarks == 1){
									// $tag .= " <span class='label label-success'>APPROVED</span>";
								// }else{
									// $tag .=" <span class='label label-error'>REJECTED</span>";
								// } 
								//	$tag,
								// ($val->approval_status != '0' ?  '' : (array('text'=>$b, 'params'=>array('style'=>'text-align:center')))),	
								//	($val->approval_status != '0' ?  '' :(array('text'=>$c, 'params'=>array('style'=>'text-align:center')))),
								
								$branch_no_con = explode('|', $val->branch_no_con);
								$branch_ = count($branch_no_con);
								$counter = 0;
								$data = '';
								while($counter != $branch_){
									
									$data .= " <span class='label label-danger'>".$branch_no_con[$counter]."</span>";
									$counter++;
								}
								$rows[] = array(
									$val->stock_code,
									$val->description,
									$val->report_uom,
									array('text'=>$a, 'params'=>array('style'=>'text-align:center')),	
									($val->branch_no_con != null ?   (array("text"=>"No Connection :</br>".$data, 'params'=>array('style'=>'text-align:center'))) : (array('text'=>$b, 'params'=>array('style'=>'text-align:center')))),	
									($val->branch_no_con != null ?  '' : (array('text'=>$c, 'params'=>array('style'=>'text-align:center')))),	
									//(array('text'=>$b, 'disabled'=>$val->branch_no_con = null ? 'disabled': '', 'params'=>array('style'=>'text-align:center'))),	
									//(array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									 ($val->branch_no_con != null ?  '' : $CI->make->checkbox_($val->stock_id,array('class'=>'check_id','id'=>$val->stock_id)))
										
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

//rhan end

//rhaan start
function build_stock_main_form_load($item)
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/stock_db",array('id'=>'stock_main_form'));
		$CI->make->hidden('stock_id',iSetObj($item,'stock_id'));
		$CI->make->hidden('mode',((iSetObj($item,'stock_id')) ? 'edit' : 'add'));
		$CI->make->sDivRow(array('style'=>'margin:0px'));
			$CI->make->sDivCol(12);
				$CI->make->H(4,"General Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
				$CI->make->sDivRow();
					$CI->make->sDivCol(6);
						$CI->make->input('Stock Code','stock_code',iSetObj($item,'stock_code'),'Stock Code',array('class'=>'rOkay toUpper','maxchars'=>'20'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(6);
						$CI->make->stockCategoriesDrop('Category','category_id',iSetObj($item,'category_id'),'Select a category',array('class'=>'rOkay combobox'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->input('Stock Description','description',iSetObj($item,'description'),'Stock Name or Description',array('maxchars'=>'50','class'=>'rOkay toUpper','style'=>'font-weight:bolder;'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(4);
						$CI->make->stockUOMCodeDrop('Report UOM','report_uom',iSetObj($item,'report_uom'),'Select UOM',array('class'=>'rOkay combobox'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->input('Report Quantity','report_qty',iSetObj($item,'report_qty'),'Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->stockTaxTypeDrop('Tax Type','tax_type_id',iSetObj($item,'tax_type_id'),'Select Tax Type',array('class'=>'combobox'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(4);
						$CI->make->mbFlagDrop('Buy or Make','mb_flag',iSetObj($item,'mb_flag'),'Select an Option',array('class'=>'combobox'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->yesOrNoNumValDrop('Is Consigned?','is_consigned',iSetObj($item,'is_consigned'),'Select an Option',array('class'=>'combobox'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
					//	$CI->make->yesOrNoNumValDrop('Is Saleable?','is_saleable',iSetObj($item,'is_saleable'),'Select an Option',array('class'=>'combobox'), 1);
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				// $CI->make->sDivRow();
					// $CI->make->sDivCol(3);
						// $CI->make->input('Standard','standard_cost',iSetObj($item,'standard_cost'),'Standard Cost',array('class'=>'numbers-only','maxchars'=>'20', 'readonly'=>'readonly'));
					// $CI->make->eDivCol();
					// $CI->make->sDivCol(3);
						// $CI->make->input('Last Cost','last_cost',iSetObj($item,'last_cost'),'Last Cost',array('class'=>'numbers-only','maxchars'=>'20', 'readonly'=>'readonly'));
					// $CI->make->eDivCol();
					// $CI->make->sDivCol(3);

						// $CI->make->input('Cost of Sales','cost_of_sales',iSetObj($item,'cost_of_sales'),'Cost of Sales',array('class'=>'numbers-only','maxchars'=>'20', 'readonly'=>'readonly')); //-----TEMPORARILY REMOVED ROKAY
					// $CI->make->eDivCol();
					// $CI->make->sDivCol(3);
						// $CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>''));
					// $CI->make->eDivCol();
				// $CI->make->eDivRow();
				
			$CI->make->eDivCol();
	$CI->make->eForm();
 $CI->make->eDivRow();
 
$CI->make->sDivRow();
 $CI->make->sDivCol(6);
		$CI->make->H(4,"Allowed Card Types",array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
			$itm_array = $crd_vals = $db_prices = $new_items = array();
						$is_enabled = '';
						$crd_array = $CI->inventory_model->get_customer_card_types();
						if(!empty($item)){
							//-----EDIT MODE
							foreach($crd_array as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
								$is_enabled = $CI->inventory_model->is_card_type_enabled_temp(iSetObj($item,'stock_id'), $crd_vals->id);
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',$crd_vals->id);
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd',$is_enabled,'',array('class'=>'formInputSmall'), 0);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}else{
							//-----ADD MODE
							foreach($crd_array as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',iSetObj($crd_vals,'id'));
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd','','',array('class'=>'formInputSmall'),0);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}
	
$CI->make->eDivRow();
 $CI->make->sDivCol(6);
	
			$CI->make->H(4,"Discount Details",array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
		
						$itm_array = $this_vals = $db_prices = $new_items = array();
						$disc_stat = '';
						$itm_array = $CI->inventory_model->get_pos_discount_types();
						if(!empty($item)){
							//-----EDIT MODE
							foreach($itm_array as $this_vals){
								$inputs = $labels = "";
								$labels = $this_vals->description;
								$disc_stat = $CI->inventory_model->is_discount_type_enabled_temp(iSetObj($item,'stock_id'), $this_vals->id);
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',$this_vals->id);
										$CI->make->yesOrNoNumValDrop(ucwords($this_vals->description),$this_vals->short_desc.'_disc',$disc_stat,'',array('class'=>'formInputSmall'), 0);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}else{
							//-----ADD MODE
							foreach($itm_array as $this_vals){
								$inputs = $labels = "";
								$labels = $this_vals->description;
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',iSetObj($this_vals,'id'));
										$CI->make->yesOrNoNumValDrop(ucwords($this_vals->description),$this_vals->short_desc.'_disc','','',array('class'=>'formInputSmall'), 0);
								$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}
	
$CI->make->eDivRow();
 $CI->make->eDivCol();
			
	return $CI->make->code();
}
//rhan end

//rhan start approval tab inquiry

function approval_header_page($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						//fa('fa-th-large')." NEW STOCK ITEM"=>array('href'=>'#details','class'=>'tab_link','load'=>'inv_inquiries/approval_inquiry_new_item/','id'=>'details_link'),
						fa('fa-bar-chart')."NEW STOCK ITEM ALL"=>array('href'=>'#allnew','class'=>'tab_link load-tab','load'=>'inv_inquiries/add_approval_inquiry_new_item/','id'=>'allnew_link'),
						fa('fa-money')." BARCODE PRICES"=>array('href'=>'#price','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_stock_barcode_prices/','id'=>'price_link'),
						fa('fa-book')." SCHEDULE MARKDOWN"=>array('href'=>'#markdown','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_inquiry_schedule_markdown/','id'=>'markdown_link'),
					//	fa('fa-book')." UPDATE STOCK BARCODE/PRICES"=>array('href'=>'#update','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_update_inquiry/','id'=>'update_link'),
						fa('fa-truck')."SUPPLIER STOCKS"=>array('href'=>'#supplier_stock','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_supplier_stocks/','id'=>'supplier_stock_link'),
						fa('fa-minus-square-o')."STOCK FOR DELETION"=>array('href'=>'#stock_deletion','class'=>'tab_link load-tab','load'=>'inv_inquiries/stock_deletion_approval/','id'=>'stock_deletion_link'),
						fa('fa-bar-chart')."MARGINAL MARKDOWN"=>array('href'=>'#marginal','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_inquiry_marginal_markdown/','id'=>'marginal_link'),

					);
					
					//$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'allnew','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'price','class'=>'tab-pane'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'markdown','class'=>'tab-pane'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'supplier_stock','class'=>'tab-pane'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'stock_deletion','class'=>'tab-pane'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'marginal','class'=>'tab-pane '));
						$CI->make->eTabPane();
						//$CI->make->sTabPane(array('id'=>'allnew','class'=>'tab-pane '));
						//$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}

//rhan end
function approval_header_page_movements($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-mail-forward')."  MOVEMENTS APPROVAL"=>array('href'=>'#movements','class'=>'tab_link','load'=>'inv_inquiries/movement_approval/','id'=>'movements_link'),
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
						$CI->make->sTabPane(array('id'=>'movements','class'=>'tab-pane active'));
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


//rhan start approval list form marginal markdown
function for_approval_list_form_marginal_markdown($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'spinner_marginal'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Approve all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id_marginal'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						    $CI->make->append('<br>');
							$CI->make->A(fa('fa-check-square-o').' Check All','',array('class'=>'btn btn-success','id'=>'btn_check_marginal'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								
								'Barcode' => array('text-align'=>'center'),
								'Branch' => array('text-align'=>'center'),		
								'Sales Type' => array('text-align'=>'center'),
								'Qty' => array('text-align'=>'center'),
								'Markup' => array('text-align'=>'center'),
								'Unit Price' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								//'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								// 'Action' => array('colspan'=>'3','style'=>'text-align:center')
								
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag = '';
								$a = $b = $c = "";								
								$a = $CI->make->A(
													fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'_id'=>$val->id.':'.$val->branch_id,
											    	'view_id'=>$val->id,
													'barcode'=>$val->barcode,
													'title'=>'view this',
													'return'=>'false'));
								$b = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'_id'=>$val->id.':'.$val->branch_id,
											    	'view_id'=>$val->id,
													'barcode'=>$val->barcode,
													'title'=>'approve this',
													'return'=>'false'));
								$c = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'_id'=>$val->id.':'.$val->branch_id,
											    	'view_id'=>$val->id,
													'barcode'=>$val->barcode,
													'title'=>'reject this',
													'return'=>'false'));
								
								$branch_name = $CI->inv_inquiries_model->get_branch_name($val->branch_id);
								$sales_type = $CI->inv_inquiries_model->sales_type($val->sales_type_id);
								$rows[] = array(
									$val->barcode,
									$branch_name,
									$sales_type,
									$val->qty,
									$val->markup,
									$val->unit_price,
									($val->branch_no_con != null ?   (array("text"=>"<span class='label label-danger'>No Connection</span>", 'params'=>array('style'=>'text-align:center'))) : array('text'=>$b, 'params'=>array('style'=>'text-align:center'))),	
									($val->branch_no_con != null ? '' : array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									($val->branch_no_con != null ? '' : $CI->make->checkbox_($val->id,array('class'=>'check_id_marginal','id'=>$val->id.':'.$val->branch_id)))
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
//rhan end

//rhan start approval list form schedule markdown
function for_approval_list_form_sched_markdown($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'spinner_'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Approve all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id_markdown'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						    $CI->make->append('<br>');
							$CI->make->A(fa('fa-check-square-o').' Check All','',array('class'=>'btn btn-success','id'=>'btn_check_markdown'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								
								'Barcode' => array('text-align'=>'center'),
								'Branch' => array('text-align'=>'center'),		
							//	'Status' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								// 'Action' => array('colspan'=>'3','style'=>'text-align:center')
								
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag = '';
								$a = $b = $c = "";								
								$a = $CI->make->A(
													fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'_id'=>$val->id.':'.$val->branch_id,
											    	'view_id'=>$val->id,
													'stock_id'=>$val->stock_id,
													'title'=>'view this',
													'return'=>'false'));
								$b = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'_id'=>$val->id.':'.$val->branch_id,
													'view_id'=>$val->id,
													'stock_id'=>$val->stock_id,
													'title'=>'approve this',
													'return'=>'false'));
								$c = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'_id'=>$val->id.':'.$val->branch_id,
													'view_id'=>$val->id,
													'stock_id'=>$val->stock_id,
													'title'=>'reject this',
													'return'=>'false'));
								
								$branch_name = $CI->inv_inquiries_model->get_branch_name($val->branch_id);
								$rows[] = array(
									$val->barcode,
									$branch_name,
									//$tag,
									array('text'=>$a, 'params'=>array('style'=>'text-align:center')),	
									($val->branch_no_con != null ?   (array("text"=>"<span class='label label-danger'>No Connection</span>", 'params'=>array('style'=>'text-align:center'))) : array('text'=>$b, 'params'=>array('style'=>'text-align:center'))),	
									($val->branch_no_con != null ? '' : array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									($val->branch_no_con != null ? '' : $CI->make->checkbox_($val->id,array('class'=>'check_id_markdown','id'=>$val->id.':'.$val->branch_id)))
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

//rhan start barcode_prices_update_approval
function barcode_prices_update_approval_list($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'barcode_spinners'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							 $CI->make->A(fa('fa-plus').' Approved all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id_bpupdate'));
						 $CI->make->eDivCol();
						 $CI->make->sDivCol(12,'right');
						     $CI->make->append('<br>');
							 $CI->make->A(fa('fa-check-square-o').' Checked All','',array('class'=>'btn btn-success','id'=>'btn_check_bpupdate'));
						 $CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								
								'STOCK CODE' => array('text-align'=>'center'),
								'BARCODE' => array('text-align'=>'center'),
								// 'AFFECTED TABLES' => array('text-align'=>'center'),		
								'SALES TYPE' => array('text-align'=>'center'),
								'AFFECTED FIELD VALUES' => array('text-align'=>'center'),
								'STATUS' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								// 'Action' => array('colspan'=>'3','style'=>'text-align:center')
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag = '';
								 $b = $c = "";								
								
								$b = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'_id'=>$val->stock_id.':'.$val->barcode.':'.$val->sale_type_id.':'.$val->affected_values.':'.$val->id,
													'title'=>'approve this',
													'return'=>'false'));
								$c = $CI->make->A(
												fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'_id'=>$val->id,
													'title'=>'reject this',
													'return'=>'false'));
													
								
									if(($val->approval_status) == 0 ){
										$tag .= " <span class='label label-info'>PENDING</span>";
									}else if($val->approval_status == 1){
										$tag .= " <span class='label label-success'>APPROVED</span>";
									}else{
										$tag .=" <span class='label label-warning'>REJECTED</span>";
								    }
								
									$affected_values =  explode('||',$val->affected_values);
									$field = $affected_values[0];
									$old_new_data = explode('|',$affected_values[1]);
									$new_data = $old_new_data[1];
									$old_data = $old_new_data[0];
									
									$data = $field.": from  <span style='font-weight: bold; color:#FF0000;'>".$old_data."</span> to <span style='font-weight: bold; color:#00CC00; text-decoration: underline; '> ".$new_data."</span>" ;
								
								$branch_no_con = explode('|', $val->branch_no_con);
								$branch_ = count($branch_no_con);
								$counter_ = 0;
								$data_ = '';
								while($counter_ != $branch_){
									
									$data_ .= " <span class='label label-danger'>".$branch_no_con[$counter_]."</span>";
									$counter_++;
								}
								
								$rows[] = array(
									 $CI->main_model->get_stock_code($val->stock_id),
									 $val->barcode,
									 $CI->main_model->get_sales_type_desc($val->sale_type_id),
									 $data,
									 $tag,
									($val->branch_no_con != null ? (array("text"=>"No Connection :</br>".$data_, 'params'=>array('style'=>'text-align:center'))) : ($val->approval_status != '0' ?  '' : (array('text'=>$b, 'params'=>array('style'=>'text-align:center'))))),	
									($val->branch_no_con != null ? '' : ($val->approval_status != '0' ?  '' :(array('text'=>$c, 'params'=>array('style'=>'text-align:center'))))),
									($val->branch_no_con != null ? '' : ($val->approval_status != '0' ?  '' :$CI->make->checkbox_($val->id,array('class'=>'check_id_bpupdate','id'=>$val->stock_id.':'.$val->barcode.':'.$val->sale_type_id.':'.$val->affected_values.':'.$val->id))))
									
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

//rhan end

//rhan start approval list form schedule markdown
function for_approval_update_list($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'spinners_'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							 $CI->make->A(fa('fa-plus').' Approved all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id_update'));
						 $CI->make->eDivCol();
						 $CI->make->sDivCol(12,'right');
						     $CI->make->append('<br>');
							 $CI->make->A(fa('fa-check-square-o').' Checked All','',array('class'=>'btn btn-success','id'=>'btn_check_update'));
						 $CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								
								'TYPE' => array('text-align'=>'center'),
								'BRANCH' => array('text-align'=>'center'),
								// 'AFFECTED TABLES' => array('text-align'=>'center'),		
								'STOCK CODE' => array('text-align'=>'center'),
								'AFFECTED FIELD VALUES' => array('text-align'=>'center'),
								'STATUS' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								// 'Action' => array('colspan'=>'3','style'=>'text-align:center')
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag = '';
								 $b = $c = "";								
								// $a = $CI->make->A(
													// fa('fa-eye fa-lg fa-fw'),
												// '',
												// array('class'=>'action_btns view_link',
													// 'ref_desc'=>'view me',
													// 'stock_id'=>$val->id,
													// 'title'=>'view this',
													// 'return'=>'false'));
								$b = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'_id'=>$val->id.':'.$val->branch.':'.$val->type,
													'title'=>'approve this',
													'return'=>'false'));
								$c = $CI->make->A(
												fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'_id'=>$val->id,
													'title'=>'reject this',
													'return'=>'false'));
													
								
									if(($val->approval_status) == 0 ){
										$tag .= " <span class='label label-info'>PENDING</span>";
									}else if($val->approval_status == 1){
										$tag .= " <span class='label label-success'>APPROVED</span>";
									}else{
										$tag .=" <span class='label label-warning'>REJECTED</span>";
								    }
									
								$affeted = explode('||',$val->affected_field_values);
								$no_ = count($affeted);
								// echo $no_."<br>";
								$desc = "";
								
								
								$affected_values='';
								$nums =0;
								$need_to_update = explode('||',$val->affected_field_values);
								$no_need_to_update =  count($need_to_update);
								$counter=0;
								$msg_crd_disc='';
								$disc_crd = '';
								$data='';
								while($counter != $no_need_to_update ){
									
									//echo '~~>'.$datas[0];
									$field = explode(':',$need_to_update[$counter]);
									$datas = explode('|',$field[1]);
									$yesno = array('No','Yes');
									$vat = array('VAT','NON-VAT');
									$new ='';
									$old ='';
									
								if(strpos($field[0],'disc_amount') !== false)
								{
									$new = $datas[1];
									$old = $datas[0];
								}
								elseif(strpos($field[0],'disc_percent') !== false)
								{
									
									$new = $datas[1];
									$old = $datas[0];
								}
								elseif(strpos($field[0],'disc') !== false) 
								{
									
									$new = $yesno[$datas[1]];
									$old = $yesno[$datas[0]];
									$disc_crd = '1';
										
								}elseif(strpos($field[0],'crd') !== false)
								{
									
									$new = $yesno[$datas[1]];
									$old = $yesno[$datas[0]];
									$disc_crd = '1';
		
								}else
								{	
								
									$new = $datas[1];
									$old = $datas[0];
								}
	
								$data .= $field[0].": from  <span style='font-weight: bold; color:#FF0000;'>".$old."</span> to <span style='font-weight: bold; color:#00CC00; text-decoration: underline; '> ".$new."</span></br>" ;	
								
									$counter++;
								}
								if($disc_crd == '1'){
									$msg_crd_disc = 'cards  edited';
								}
								$branch_no_con = explode('|', $val->branch_no_con);
								$branch_ = count($branch_no_con);
								$counter_ = 0;
								$data_ = '';
								while($counter_ != $branch_){
									$data_ .= " <span class='label label-danger'>".$branch_no_con[$counter_]."</span>";
									$counter_++;
								}
								$rows[] = array(
									$val->type,
									($val->branch != 'All' ?  $CI->main_model->get_branch_code($val->branch) : 'All'),
									 $CI->main_model->get_stock_code($val->stock_id),
									$msg_crd_disc.'</br>'.$data,
									$tag,
								//	 array('text'=>$a, 'params'=>array('style'=>'text-align:center')),	
									($val->branch_no_con != null ? (array("text"=>"No Connection :</br>".$data_, 'params'=>array('style'=>'text-align:center'))) : ($val->approval_status != '0' ?  '' : (array('text'=>$b, 'params'=>array('style'=>'text-align:center'))))),	
									($val->branch_no_con != null ? '' : ($val->approval_status != '0' ?  '' :(array('text'=>$c, 'params'=>array('style'=>'text-align:center'))))),
									($val->branch_no_con != null ? '' : ($val->approval_status != '0' ?  '' :$CI->make->checkbox_($val->id,array('class'=>'check_id_update','id'=>$val->id.':'.$val->branch.':'.$val->type))))
									
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

function barcode_prices_view_form($items=array()){
	$CI =& get_instance();



		
	
	return $CI->make->code();
}
	//rhan end
	
	
//rhan start stock barcode prices approval form
function for_approval_list_form_barcode_prices($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Approve all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id_prices'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						    $CI->make->append('<br>');
							$CI->make->A(fa('fa-check-square-o').' Check All','',array('class'=>'btn btn-success','id'=>'btn_check_price'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								'Barcode' => array('text-align'=>'center'),
								'Description ' => array('text-align'=>'center'),		
								'UOM' => array('text-align'=>'center'),		
								'Quantity ' => array('text-align'=>'center'),		
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag = '';
								$a = $b = $c = "";	
						
								$a = $CI->make->A(
													fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'_id'=>$val->stock_id,
													'barcode'=>$val->barcode,
													'title'=>'view branch prices',
													'return'=>'false'));						
							
								$b = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'_id'=>$val->stock_id,
													'barcode'=>$val->barcode,
													'title'=>'approve this',
													'return'=>'false'));
								$c = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'_id'=>$val->stock_id,
													'barcode'=>$val->barcode,
													'title'=>'reject this',
													'return'=>'false'));
								
								$branch_no_con = explode('|', $val->branch_no_con);
								$branch_ = count($branch_no_con);
								$counter = 0;
								$data = '';
								while($counter != $branch_){
									
									$data .= " <span class='label label-danger'>".$branch_no_con[$counter]."</span>";
									$counter++;
								}
								
								$rows[] = array(
									$val->barcode,
									$val->description,
									$val->uom,
									$val->qty,
									(array('text'=>$a, 'params'=>array('style'=>'text-align:center'))),	
									($val->branch_no_con != null ?   (array("text"=>"No Connection :</br>".$data, 'params'=>array('style'=>'text-align:center'))) : array('text'=>$b, 'params'=>array('style'=>'text-align:center'))),	
									($val->branch_no_con != null ? '' : array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									($val->branch_no_con != null ?  '' : $CI->make->checkbox_($val->barcode,array('class'=>'check_id_price','id'=>$val->barcode)))
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

//rhan end

	//rhan start view schedule markdown
	function sched_markdown_view_form($items){
	$CI =& get_instance();
			$CI->make->sDivRow(array('style'=>'margin:2px;'));
				$CI->make->sDivCol(12,'center',0,array("style"=>''));
					$CI->make->sBox('success',array('div-form'));
						$CI->make->sBoxBody(array('style'=>''));
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($items,'inactive'),'',array('class'=>'inactive_dropdown'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6, 'left', 0, array('class'=>'branch_row'));
									$branch_code = $CI->inv_inquiries_model->get_branch_code($items['branch_id']);
									$CI->make->input('Branch','branch_id',$branch_code,null,array());
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->input('Date From','start_date',$items['start_date'],'',array('class'=>'rOkay'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->input('To','end_date',$items['end_date'],'',array('class'=>'rOkay'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->timefield('Time On','start_time',$items['start_time'],'Start Time', array('class'=>'rOkay'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->timefield('Time Off','end_time',$items['end_time'],'End Time', array('class'=>'rOkay'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->input('Markdown','markdown',null,$items['markdown'],array('class'=>'num_without_decimal formInputMini'),"%");
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->input('Discounted Price','discounted_price',null,$items['discounted_price'],array('class'=>'rOkay num_with_decimal'));
									
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
			$CI->make->eDivRow();	
	return $CI->make->code();
}
	//rhan end
//rhan start stock_deletion_approval	
function stock_deletion_form_approval($list)
{
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'s-spinner-stock-del'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Approved all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id_del_stocks'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						    $CI->make->append('<br>');
							$CI->make->A(fa('fa-check-square-o').' Checked All','',array('class'=>'btn btn-success','id'=>'btn_check_del_stocks'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								'Stock Code' => array('text-align'=>'center'),
								'Modified by' => array('text-align'=>'center'),		
								'Date Modified' => array('text-align'=>'center'),		
								'Status' => array('text-align'=>'center'),		
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
						
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag='';
								$b = $c = "";
								
									if(($val->approval_status) == 0 ){
										$tag .= " <span class='label label-info'>PENDING</span>";
									}else if($val->approval_status == 1){
										$tag .= " <span class='label label-success'>APPROVED</span>";
									}else{
										$tag .=" <span class='label label-warning'>REJECTED</span>";
									}
				
							
								$b = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'stock_id'=>$val->stock_id,
													'_id'=>$val->id,
													'stock_code'=>$val->stock_code,
													'title'=>'approve this',
													'return'=>'false'));
								$c = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'stock_id'=>$val->stock_id,
													'_id'=>$val->id,
													'stock_code'=>$val->stock_code,
													'title'=>'reject this',
													'return'=>'false'));
								$branch_no_con = explode('|', $val->branch_no_con);
								$branch_ = count($branch_no_con);
								$counter = 0;
								$data = '';
								while($counter != $branch_){
									
									$data .= " <span class='label label-danger'>".$branch_no_con[$counter]."</span>";
									$counter++;
								}
								
								$rows[] = array(
									$val->stock_code,
									$CI->inv_inquiries_model->get_user_name($val->modified_by),
									$val->date_modified,
									$tag,
									($val->branch_no_con != null ? (array("text"=>"No Connection :</br>".$data, 'params'=>array('style'=>'text-align:center'))) : ($val->approval_status != '0' ?  '' : (array('text'=>$b, 'params'=>array('style'=>'text-align:center'))))),	
									($val->branch_no_con != null ? '' : ($val->approval_status != '0' ?  '' :(array('text'=>$c, 'params'=>array('style'=>'text-align:center'))))),
									($val->branch_no_con != null ? '' : ($val->approval_status != '0' ?  '' :$CI->make->checkbox_($val->id,array('class'=>'check_del_id_update','id'=>$val->stock_id.':'.$val->id))))
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
//rhan end
//mahe start supplier stocks approval form
function for_approval_list_form_supplier_stocks($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'s-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Approved all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id_stocks'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						    $CI->make->append('<br>');
							$CI->make->A(fa('fa-check-square-o').' Checked All','',array('class'=>'btn btn-success','id'=>'btn_check_stocks'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								'Branch' => array('text-align'=>'center'),
								'Vendor Code' => array('text-align'=>'center'),		
								'Description' => array('text-align'=>'center'),		
								'Cost' => array('text-align'=>'center'),		
								'Avg. Cost' => array('text-align'=>'center'),		
								'Avg. Net Cost' => array('text-align'=>'center'),		
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$con_avg_cost = floor(($val->avg_cost*100))/100;
								$con_avg_net_cost = floor(($val->avg_net_cost*100))/100;
								$tag = '';
								$a = $b = $c = "";	
								
								$a = $CI->make->A(
													fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'_id'=>$val->id,
													'stock_id'=>$val->stock_id,
													'title'=>'view branch prices',
													'return'=>'false'));						
							
								$b = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'_id'=>$val->id,
													'stock_id'=>$val->stock_id,
													'title'=>'approve this',
													'return'=>'false'));
								$c = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'_id'=>$val->id,
													'stock_id'=>$val->stock_id,
													'title'=>'reject this',
													'return'=>'false'));
								
								$rows[] = array(
									$CI->inventory_model->get_branch_code_from_id($val->branch_id),
									$val->supp_stock_code,
									$val->description,
									$val->unit_cost,
									number_format($con_avg_cost, 2),
									$con_avg_net_cost,
									(array('text'=>$a, 'params'=>array('style'=>'text-align:center'))),	
									($val->branch_no_con != null ? (array("text"=>"<span class='label label-danger'>No Connection</span>", 'params'=>array('style'=>'text-align:center'))) : array('text'=>$b, 'params'=>array('style'=>'text-align:center'))),	
									($val->branch_no_con != null ? '' : array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									($val->branch_no_con != null ? '' : $CI->make->checkbox_($val->id,array('class'=>'check_id_stocks','id'=>$val->id)))
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
//mhae end
//mhae start
function build_supplier_stock_form_load($item = array(), $branch_name=null)
{
	$CI =& get_instance();
	$CI->make->sDiv(array('id'=>'adder_form_div'));
				$CI->make->sDivCol();
					$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
						$CI->make->sDivCol(12,'left',0,array("style"=>''));
							$CI->make->sBox('danger',array('div-form'));
								$CI->make->sBoxBody(array('style'=>''));
									$CI->make->sDivRow();
									$CI->make->hidden('supp_mode','add', array('class'=>'supp_mode'));	
									$CI->make->hidden('hidden_supplier_stock_id','', array('class'=>'c_hidden_supplier_stock_id'));
									//-----Supplier Details
										$CI->make->sDivCol(4);
											$CI->make->sDivRow();
												$CI->make->sDivCol();
													$CI->make->sDiv(array('id'=>'form_label_add'));
														// $CI->make->H(4,"Edit Supplier Details",array('id'=>'edit_supp_div', 'style'=>'margin-top:0px;margin-bottom:0px;'));
														$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
														$CI->make->hidden('supp_stock_mode','');
													$CI->make->eDiv();
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol();
													/*
													$CI->make->supplierMasterDrop('Supplier','supp_id',null,'Select Supplier',array('class'=>'rOkay combobox supp_dropdown'));
													$CI->make->hidden('hidden_supplier_id',iSetObj($item,'supp_id'));
													$CI->make->input('Supplier Stock Code','supp_stock_code',iSetObj($item,'supp_stock_code'),'Type Supplier Stock Code',array('class'=>'rOkay'));
													$CI->make->input('Description','description',iSetObj($item,'description'),'Type Supplier Stock Description',array('class'=>'rOkay desc_text'));
													// $CI->make->branchesDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
													$CI->make->branchesCodeDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
													*/
													
													$CI->make->supplierMasterDrop('Supplier','supp_id',iSetObj($item,'supp_id'),'Select Supplier',array('class'=>'rOkay combobox supp_dropdown', 'readonly'=>'readonly', 'old_val'=>''));
													$CI->make->input('Supplier Stock Code','supp_stock_code',iSetObj($item,'supp_stock_code'),'Type Supplier Stock Code',array('class'=>'rOkay toUpper supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
													$CI->make->input('Description','description',iSetObj($item,'description'),'Type Supplier Stock Description',array('class'=>'rOkay supp_desc_text toUpper supp_req_form', 'readonly'=>'readonly','old_val'=>''));
													// $CI->make->branchesDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
													// $CI->make->branchesDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
													$CI->make->branchesDrop('Branch','branch_id',iSetObj($item,'branch_id'),null,array('class'=>'rOkay combobox branch_dropdown', 'readonly'=>'readonly','old_val'=>''));
												
													$CI->make->hidden('hidden_branch_id','', array('class'=>'c_hidden_branch_id supp_req_form', 'old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eDivCol();
									//-----Supplier Details	
										$CI->make->sDivCol(4);
											$CI->make->sDivRow();
												$CI->make->sDivCol();
													$CI->make->H(4,"Cost Details",array('style'=>'margin-top:0px;margin-bottom:0px;'));
													$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											
											$CI->make->sDivRow();
												$CI->make->sDivCol(12);
													// $CI->make->stockUOMCodeDrop('UOM','uom',iSetObj($item,'uom'),'Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
													$CI->make->stockUOMCodeDrop('UOM','uom',iSetObj($item,'uom'),'Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
													$CI->make->hidden('hidden_stock_uom','', array('class'=>'c_hidden_stock_uom supp_req_form', 'readonly'=>'readonly','old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(12);
													// $CI->make->input('Quantity','qty',iSetObj($item,'qty'),'Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
													$CI->make->input('Quantity','qty',iSetObj($item,'qty'),'Quantity per UOM',array('class'=>'rOkay supp_req_form','maxchars'=>'20', 'readonly'=>'readonly','old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(12);
													$CI->make->input('Unit Cost','unit_cost',iSetObj($item,'unit_cost'),'',array('class'=>'rOkay num_with_decimal supp_req_form', 'readonly'=>'readonly','old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												// $CI->make->sDivCol(6);
													// $CI->make->input('Unit Cost','unit_cost','','',array('class'=>'rOkay'));
												// $CI->make->eDivCol();
												$CI->make->sDivCol(6);
													$CI->make->input('Average Cost','avg_cost',iSetObj($item,'avg_cost'),'',array('class'=>'rOkay supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);
											$CI->make->sDivRow();
												$CI->make->sDivCol();
													$CI->make->H(4,"Discounts",array('style'=>'margin-top:0px;margin-bottom:0px;'));
													$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(6);
													$CI->make->input('Discount # 1','discount1',$item->disc_percent1 > 0 ? $item->disc_percent1 : $item->disc_amount1,'',array('class'=>'disc1 supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													$CI->make->discountTypeDrop('Type','disc_type1',$item->disc_percent1 > 0 ? 1 : 0,'Select Discount Type',array('class'=>'disc_type1_drop supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(6);
													$CI->make->input('Discount # 2','discount2',$item->disc_percent2 > 0 ? $item->disc_percent2 : $item->disc_amount2,'',array('class'=>'disc2 supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													$CI->make->discountTypeDrop('Type','disc_type2',$item->disc_percent2 > 0 ? 1 : 0,'Select Discount Type',array('class'=>'disc_type2_drop supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(6);
													$CI->make->input('Discount # 3','discount3',$item->disc_percent3 > 0 ? $item->disc_percent3 : $item->disc_amount3,'',array('class'=>'disc3 supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													$CI->make->discountTypeDrop('Type','disc_type3',$item->disc_percent3 > 0 ? 1 : 0,'Select Discount Type',array('class'=>'disc_type3_drop supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eDivCol();	
									$CI->make->eDivRow();
									
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px" class="style-one"/>');
											$CI->make->hidden('saving_type','single', array('class'=>'c_saving_type'));
										$CI->make->eDivCol();	
									$CI->make->eDivRow();
									
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->sDivRow();
												$CI->make->sDivCol(2);
													$CI->make->input('Net Cost','net_cost',iSetObj($item,'net_cost'),'',array('class'=>'rOkay supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													$CI->make->input('Average Net Cost','avg_net_cost',iSetObj($item,'avg_net_cost'),'',array('class'=>'rOkay supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													$CI->make->input('Cost Multiplier','cost_multiplier','1','',array('class'=>'rOkay', 'readonly'=>'readonly', 'old_val'=>''));
						
											$CI->make->eDivRow();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
									
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eDivCol();
			$CI->make->eDiv();
			
	return $CI->make->code();
}
// Movements Approval - Mhae (start)
function movements_approval($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
	
	$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'movement-file-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Approve all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id_movement'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						    $CI->make->append('<br>');
							$CI->make->A(fa('fa-check-square-o').' Check All','',array('class'=>'btn btn-success','id'=>'btn_check_movement'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							//array('text'=>$check_all, 'params'=>array('style'=>'text-align:center'));
							$th = array(
								
								'Branch' => array('text-align'=>'center'),
								'Created By' => array('text-align'=>'center'),	
								'Transaction Date' => array('text-align'=>'center'),	
								'Stock Location' => array('text-align'=>'center'),		
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								// 'Action' => array('colspan'=>'3','style'=>'text-align:center')
								
								);
							$rows = array();
							$tag = $test ='';
							$rows = array();
							$tag ='';
							$no_con ='';
							$stock_location = '';
							foreach ($list as $val) {
								$tag = '';
								$a = $b = "";	
								
								if(($val->status) == 0){
										$tag .= " <span class='label label-info'>PENDING</span>";
								}else if($val->status == 1){
										$tag .= " <span class='label label-success'>APPROVED</span>";
								}else{
										$tag .=" <span class='label label-warning'>REJECTED</span>";
								}
									$no_con = " <span class='label label-danger'>No Connection</span>";
									
								if($val->stock_location == 1){
									$stock_location = 'Selling Area';
								}else if($val->stock_location == 2){
									$stock_location = 'Stock Room';
								}else{
									$stock_location = 'B.O. Room';
								}
								
								$a = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'_id'=>$val->id,
													'branch_id'=>$val->branch_id,
													//'supplier_id'=>$val->supplier_id,
													'title'=>'approve this',
													'return'=>'false'));
								$b = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'_id'=>$val->id,
													'branch_id'=>$val->branch_id,
												///	'supplier_id'=>$val->supplier_id,
													'title'=>'reject this',
													'return'=>'false'));
								$c = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'_id'=>$val->id,
													'branch_id'=>$val->branch_id,
												//	'barcode'=>$val->barcode,
													'title'=>'view purchase orders',
													'return'=>'false'));					
								$rows[] = array(
									$CI->main_model->get_branch_code($val->branch_id),
									$CI->inv_inquiries_model->get_user_name($val->created_by),
									date('Y-M-d H:i:s', strtotime($val->transaction_date)),
									$stock_location,
									($val->branch_no_con != null ? $no_con: $tag),
									(array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									($val->branch_no_con != null ? '' : ($val->status != '0' ?  '' : (array('text'=>$a, 'params'=>array('style'=>'text-align:center'))))),	
									($val->branch_no_con != null ? '' : ($val->status != '0' ?  '' :(array('text'=>$b, 'params'=>array('style'=>'text-align:center'))))),	
									($val->branch_no_con != null ? '' : ($val->status != '0' ?  '' : $CI->make->checkbox_($val->id,array('class'=>'check_id','id'=>$val->id.'_'.$val->branch_id))))
								
								//($val->branch_no_con != null ? (array("text"=>"<span class='label label-danger'>No Connection</span>", 'params'=>array('style'=>'text-align:center'))) : array('text'=>$b, 'params'=>array('style'=>'text-align:center'))),	
								//	($val->branch_no_con != null ? '' : array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
								//	($val->branch_no_con != null ? '' : $CI->make->checkbox_($val->id,array('class'=>'check_id_stocks','id'=>$val->id)))
										
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
function build_movement_details_list_form($item=array()){
	$CI =& get_instance();
		$branch = $stock_location = $transaction_date = $movement_type_id = '';
		foreach($item as $val){
			$branch = $val->branch_id;
			$stock_location = $val->stock_location;
			$transaction_date = $val->transaction_date;
			$movement_type_id = $val->movement_type_id;
		}
$CI->make->sForm("",array('id'=>'movement_entry_pop_form'));
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('info');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(3);
							$CI->make->branchesDrop('Branch','branch_id',$branch,null,array('class'=>'rOkay branch_dropdown', 'readonly'=>'readonly'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->stockLocationDrop('Stock Location','stock_location',$stock_location,null,array('class'=>'rOkay stock_location_dropdown',  'readonly'=>'readonly'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->datefield('Date','transaction_date',$transaction_date,'',array('class'=>'rOkay',  'readonly'=>'readonly'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->movementTypeDrop('Movement Type','movement_type_id',$movement_type_id,null,array('class'=>'rOkay movement_type_dropdown', 'readonly'=>'readonly'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('warning');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										$CI->make->th('Item',array('style'=>''));
										$CI->make->th('Qty',array('style'=>''));
										$CI->make->th('UOM',array('style'=>''));
										$CI->make->th('Unit Cost',array('style'=>''));
										$CI->make->th('Total',array('style'=>''));
									$CI->make->eRow();
									$created_by = $posted_by = $date_created = $date_posted = '';
									foreach($item as $val){
										$created_by = $CI->inv_inquiries_model->get_user_name($val->created_by);
										$posted_by = $val->posted_by;
										$date_created = $val->date_created;
										$date_posted = $val->date_posted;
										
										$CI->make->sRow();
												$CI->make->td("[ ".$val->barcode." ] ".$val->description);	
												$CI->make->td($val->qty);	
												$CI->make->td($val->uom);	
												$CI->make->td($val->unit_cost);	
												$CI->make->td($val->qty * $val->unit_cost);	
										$CI->make->eRow();
									}
								$CI->make->eTable();
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('info');
				$CI->make->sDivRow();
					$CI->make->append('<br/>');	
					$CI->make->sDivCol(3);
						$CI->make->input('Created By','created_by',$created_by,'',array('class'=>'rOkay', 'readonly'=>'readonly', 'old_val'=>''));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						$CI->make->input('Date Created','date_created',date('Y-M-d H:i:s', strtotime($date_created)),'',array('class'=>'rOkay', 'readonly'=>'readonly', 'old_val'=>''));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						$CI->make->input('Posted By','posted_by',($posted_by != null ? $CI->inv_inquiries_model->get_user_name($posted_by) : 'NOT YET POSTED'),'',array('class'=>'rOkay', 'readonly'=>'readonly'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						$CI->make->input('Date Posted','date_posted',($date_posted != null ? date('Y-M-d', strtotime($date_posted)): 'NOT YET POSTED'),'',array('class'=>'rOkay', 'readonly'=>'readonly', 'old_val'=>''));
					$CI->make->eDivCol();	
				$CI->make->eDivRow();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->sDivRow();
$CI->make->eForm();
return $CI->make->code();
}
// Movements Approval - Mhae (end)
// Purchase Orders Approval - Mhae (start)
function purchase_orders_approval($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
	
	$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'purchase-orders-file-spinner'));
	$CI->make->sDivCol();
							$CI->make->sBox('success',array('div-form'));
								$CI->make->sBoxBody(array());
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array());
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
						$CI->make->eDiv();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Approve all checked items','',array('class'=>'btn btn-primary','id'=>'btn_id_purchase_order'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						    $CI->make->append('<br>');
							$CI->make->A(fa('fa-check-square-o').' Check All','',array('class'=>'btn btn-success','id'=>'btn_check_purchase_order'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							//array('text'=>$check_all, 'params'=>array('style'=>'text-align:center'));
							$th = array(
								
								'Reference' => array('text-align'=>'center'),
								'Branch' => array('text-align'=>'center'),
								'Supplier' => array('text-align'=>'center'),		
								'Stock Location' => array('text-align'=>'center'),		
								'Order Date' => array('text-align'=>'center'),		
								'Delivery Date' => array('text-align'=>'center'),
								'Total Amount' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
								// 'Action' => array('colspan'=>'3','style'=>'text-align:center')
								
								);
							$rows = array();
							$tag = $test ='';
							$rows = array();
							$tag ='';
							$no_con ='';
							$stock_location = '';
							foreach ($list as $val) {
								$tag = '';
								$a = $b = "";	
								
								if(($val->status) == 0){
										$tag .= " <span class='label label-info'>PENDING</span>";
								}else if($val->status == 1){
										$tag .= " <span class='label label-success'>APPROVED</span>";
								}else{
										$tag .=" <span class='label label-warning'>REJECTED</span>";
								}
									$no_con = " <span class='label label-danger'>No Connection</span>";
									
								if($val->into_stock_location == 1){
									$stock_location = 'Selling Area';
								}else if($val->into_stock_location == 2){
									$stock_location = 'Stock Room';
								}else{
									$stock_location = 'B.O. Room';
								}
								
								$a = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'_id'=>$val->order_no,
													//'supplier_id'=>$val->supplier_id,
													'title'=>'approve this',
													'return'=>'false'));
								$b = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'_id'=>$val->order_no,
												///	'supplier_id'=>$val->supplier_id,
													'title'=>'reject this',
													'return'=>'false'));
								$c = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'_id'=>$val->order_no,
												//	'barcode'=>$val->barcode,
													'title'=>'view purchase orders',
													'return'=>'false'));
								$d = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-pencil fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'_id'=>$val->order_no,
												//	'barcode'=>$val->barcode,
													'title'=>'edit purchase orders',
													'return'=>'false'));
													
								$rows[] = array(
									$val->reference,
									$CI->main_model->get_branch_code($val->branch_id),
									$CI->main_model->get_supplier_name($val->supplier_id),
									$stock_location,
									date('Y-M-d H:i:s', strtotime($val->ord_date)),
									date('Y-M-d', strtotime($val->delivery_date)),
									$val->total_amt,
									($val->branch_no_con != null ? $no_con: $tag),
									(array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									($val->branch_no_con != null ? '' : ($val->status != '0' ?  '' : (array('text'=>$d, 'params'=>array('style'=>'text-align:center'))))),	
									($val->branch_no_con != null ? '' : ($val->status != '0' ?  '' : (array('text'=>$a, 'params'=>array('style'=>'text-align:center'))))),	
									($val->branch_no_con != null ? '' : ($val->status != '0' ?  '' :(array('text'=>$b, 'params'=>array('style'=>'text-align:center'))))),	
									($val->branch_no_con != null ? '' : ($val->status != '0' ?  '' : $CI->make->checkbox_($val->order_no,array('class'=>'check_id','id'=>$val->order_no))))
								
								//($val->branch_no_con != null ? (array("text"=>"<span class='label label-danger'>No Connection</span>", 'params'=>array('style'=>'text-align:center'))) : array('text'=>$b, 'params'=>array('style'=>'text-align:center'))),	
								//	($val->branch_no_con != null ? '' : array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
								//	($val->branch_no_con != null ? '' : $CI->make->checkbox_($val->id,array('class'=>'check_id_stocks','id'=>$val->id)))
										
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
// Purchase Orders Approval - Mhae (end)
// Stock Inquiry - Mhae (start)
function build_stock_inq_form($items=array())
{
$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("inv_inquiries/stock_result",array('id'=>'stock_search_form'));
							$CI->make->sDivCol(3,'left',0,array('style'=>'margin-left:50px;margin-bottom:10px;'));
								$CI->make->stockCategoriesDrop('Category','category_id',null,'Select a category',array('class'=>'rOkay combobox reqForm'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Start Date','start_date',date('m/d/Y'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('End Date','end_date',date('m/d/Y'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
						$CI->make->sDivCol(2,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
							$CI->make->A(fa('fa-search').' Search','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:right'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();
						
		$CI->make->sBox('info',array('id'=>'stock_lists','style'=>'min-height:350px;'));
			$CI->make->sBoxBody(array('id'=>'sboxbody_id'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(12);
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										$CI->make->th('Stock Code');
										$CI->make->th('Description',array('style'=>'width: 33%;'));
										$CI->make->th('Category');
										$CI->make->th('Tax Type',array('style'=>'width: 19%;'));
									$CI->make->eRow();
								$CI->make->eTable();	
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
						// $CI->make->sDivCol(12, 'left', 0, array('style'=>''));
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'list-stocks-tbl', 'border'=>'0px'));
									foreach($items as $val){
										$CI->make->sRow();
											$CI->make->td($val->stock_code);	
											$CI->make->td($val->description, array('style'=>'width: 50%; text-align: center;'));	
											$CI->make->td($CI->inv_inquiries_model->category_short_desc($val->category_id), array('style'=>'text-align: center;'));	
											$CI->make->td($CI->inv_inquiries_model->tax_type_id_to_name($val->tax_type_id), array('style'=>'width: 30%; text-align: center;'));		
										$CI->make->eRow();
									}
								$CI->make->eTable();
							$CI->make->eDiv();
						$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();
		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
	
}
// Stock Inquiry - Mhae (end)
function build_stock_list_display($items = array()){
	
	$CI =& get_instance();

				$CI->make->sBoxBody(array('id'=>'sboxbody_id'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(12);
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										$CI->make->th('Stock Code');
										$CI->make->th('Description',array('style'=>'width: 33%'));
										$CI->make->th('Category');
										$CI->make->th('Tax Type',array('style'=>'width: 19%;'));
									$CI->make->eRow();
								$CI->make->eTable();	
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
						// $CI->make->sDivCol(12, 'left', 0, array('style'=>''));
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'list-stocks-tbl', 'border'=>'0px'));
									foreach($items as $val){
										$CI->make->sRow();
											$CI->make->td($val->stock_code);	
											$CI->make->td($val->description, array('style'=>'width: 50%; text-align: center;'));	
											$CI->make->td($CI->inv_inquiries_model->category_short_desc($val->category_id), array('style'=>'text-align: center;'));	
											$CI->make->td($CI->inv_inquiries_model->tax_type_id_to_name($val->tax_type_id), array('style'=>'width: 30%; text-align: center;'));		
										$CI->make->eRow();
									}
								$CI->make->eTable();
							$CI->make->eDiv();
						$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();

	return $CI->make->code();
}

?>