<?php
// ======================================================================================= //
//  					TRANSACTIONS																															
// ======================================================================================= //
//----------RECEIVING ENTRY----------START
// function build_receiving_entry_form($po_id=null){
function build_receiving_entry_form($receiving_id=null){
	$CI =& get_instance();
	$user = $CI->session->userdata('user');
	
	$CI->make->sForm("",array('id'=>'receiving_entry_form'));
	
		$CI->make->sDivRow(array('style'=>'margin-top:-5px;'));
			$CI->make->sDivCol(12,'right', 0, array());
					$CI->make->hidden('hidden_user',$user['id']);
					$CI->make->hidden('form_mode', ($receiving_id == '' ? 'add' : 'edit'));
					// $CI->make->hidden('hidden_po_order_no', ($po_id == '' ? '' : $po_id));
					
					// $CI->make->button(fa('fa-save').' POST RECEIVING',array('class'=>'post_receiving_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'),'primary');
					// // $CI->make->button(fa('fa-trash').' POST RECEIVING',array('class'=>'post_receiving_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'),'primary');
					// $CI->make->button(fa('fa-reply').' GO BACK',array('class'=>'back_btn def_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'),'');
					
					$CI->make->A(fa('fa-save').' POST RECEIVING', '',array('class'=>'btn btn-primary post_receiving_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
					$CI->make->A(fa('fa-reply').' GO BACK',base_url().'inventory/dashboard',array('class'=>'btn back_btn def_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
					
					//-----HIDDEN VALUES FOR RELOADED RECEIVING ITEMS:
					$CI->make->hidden('hidden_receiving_id','');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		//-----HEADER PART A-----START
		$CI->make->sDivRow();
			$CI->make->sDivCol(12, 'center', 0, array());
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								// $CI->make->branchesMasterDrop('Branch','branch_id',null,'Select Branch',array('class'=>'rOkay branch_dropdown'));
								$CI->make->input('P.O. #','po_reference',null,null,array('class'=>'rOkay forms'));
								$CI->make->hidden('order_no','');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								// $CI->make->branchesMasterDrop('Branch','branch_id',null,'Select Branch',array('class'=>'rOkay branch_dropdown'));
								$CI->make->input('Invoice #','invoice_no',null,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->input('Invoice Amount','invoice_amt',null,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								// $CI->make->branchesMasterDrop('Branch','branch_id',null,'Select Branch',array('class'=>'rOkay branch_dropdown'));
								$CI->make->input('Supplier','supplier_name',null,null,array('class'=>'rOkay forms', 'readonly'=>'readonly', 'style'=>'color: red;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->datefield('Delivery Date','delivery_date',date('m/d/Y'),'',array('class'=>'rOkay', 'readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->stockLocationDrop('Stock Location','stock_location',null,null,array('class'=>'rOkay stock_location_dropdown', 'readonly'=>'readonly', 'style'=>'color: red;'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(12);
								$CI->make->input('Notes','receiving_notes',null,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		//-----HEADER PART A-----END
		
		//-----ADDER FORM-----START
		$CI->make->sDivRow();
			$CI->make->sDivCol(12, 'center', 0, array('style'=>'margin-bottom: -25px;'));	
				$CI->make->sBox('success',array('div-form'));
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
										$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
											$CI->make->th('Item',array('style'=>'width: 50%;'));
											$CI->make->th('Qty',array('style'=>'width: 20%; text-align: center;'));
											$CI->make->th('UOM',array('style'=>'width: 20%; text-align: center;'));
											$CI->make->th('&nbsp;',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->eRow();
										$barcode_inp = $qty_input = $uom_input = $link = "";
										$barcode_inp = "<input type='text' name='barcode' id='barcode' class='formInputXMed rOkay'>";
										$qty_input = "<input type='text' name='qty' id='qty' class='formInputMini rOkay'>";
										$uom_input = "<input type='text' name='uom' id='uom' class='formInputMini rOkay' readonly='readonly' style='background-color: #eeeeee;'>";
										// $link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), '', array(
										// 'class'=>'add_this_item',
										// // 'ref'=>$val->line_id,
										// // 'ref_desc'=>$val->description,
										// 'title'=>'Add this item',
										// 'style'=>'cursor: pointer;',
										// 'return'=>'false'));
										$link .= "<button name='add_btn' id='add_btn' class='btn btn-success' title='Add this item?' style='cursor:pointer;'>".fa('fa-plus')."</button>";
										$CI->make->sRow();
											$CI->make->td($barcode_inp,array('style'=>'width: 50%;'));
											$CI->make->td($qty_input,array('style'=>'width: 20%; text-align: center;'));
											$CI->make->td($uom_input,array('style'=>'width: 20%; text-align: center;', 'class'=>'uom_label'));
											$CI->make->td($link,array('style'=>'width: 10%; text-align: center;'));
											// $CI->make->td($CI->make->button(fa('fa-save').' Save Stock Category',array('id'=>'add-btn','class'=>'btn-block'),'primary'),array('style'=>'width: 10%; text-align: center;'));
										$CI->make->eRow();
									$CI->make->eTable();	
								$CI->make->eDiv();
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();	
		$CI->make->eDivRow();
		//-----ADDER FORM-----END
		
		//----------LOADER DIV----------START
		$CI->make->sDiv(array('id'=>'line_item_contents'));
		
		$CI->make->eDiv();
		//----------LOADER DIV----------END
		
		//----------BUTTONS----------START
		$CI->make->sDivRow(array('style'=>'margin-top: 15px;'));
			$CI->make->sDivCol(12,'right', 0, array());
				$CI->make->A(fa('fa-save').' POST RECEIVING', '',array('class'=>'btn btn-primary post_receiving_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'inventory/dashboard',array('class'=>'btn back_btn def_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		//----------BUTTONS----------END
		
	$CI->make->eForm();
	
	return $CI->make->code();
}
function build_receiving_details_list_form($items=array()){
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>''));
		$CI->make->sDivCol();
			$CI->make->sBox('danger',array('div-form'));
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									// $CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										// $CI->make->th('Item',array('style'=>'width: 50%;'));
										// $CI->make->th('Qty',array('style'=>'width: 20%; text-align: center;'));
										// $CI->make->th('UOM',array('style'=>'width: 20%; text-align: center;'));
										// $CI->make->th('&nbsp;',array('style'=>'width: 10%; text-align: center;'));
									// $CI->make->eRow();
									$counter = 0;
									foreach($items as $val){
										$del_link = "";
										$new_desc = "";
										// $link .= $CI->make->A(fa('fa-trash fa-lg fa-fw'), '', array(
																			// 'class'=>'del_this_item',
																			// // 'ref'=>$val->line_id,
																			// // 'ref_desc'=>$val->description,
																			// 'title'=>'Delete this item?',
																			// 'style'=>'cursor: pointer;',
																			// 'return'=>'false'));
										$del_link .= "<button name='del_btn' id='del_btn' class='btn btn-danger del_btn' ref='".$val->line_id."' ref_desc='".$val->description."' title='Delete this item?' style='cursor:pointer;' return=false>".fa('fa-remove')."</button>";
										
										if($val->last_scanned == 1){
											$new_desc = "[".$val->barcode."] ".$val->description."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='label label-success' style='font-size: small;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LAST SCANNED ITEM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
										}else{
											$new_desc = "[".$val->barcode."] ".$val->description." ";
										}
										
										$CI->make->sRow(array("style"=>"background-color: #f8f6ba;"));
											// $CI->make->td("[".$val->barcode."] ".$val->description." ",array('style'=>'width: 50%;'));	
											$CI->make->td($new_desc,array('style'=>'width: 50%;'));	
											$CI->make->td($val->qty_received,array('style'=>'width: 20%; text-align: center;'));	
											$CI->make->td($val->uom,array('style'=>'width: 20%; text-align: center;'));	
											$CI->make->td($del_link,array('style'=>'width: 10%; text-align: center;'));
										$CI->make->eRow();
										$counter++;
									}
									
								$CI->make->eTable();	
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();	
	$CI->make->eDivRow();
	
	return $CI->make->code();
}
//----------RECEIVING ENTRY----------START
// ======================================================================================= //
//  					INQUIRIES																															
// ======================================================================================= //
//----------SAVED RECEIVING LIST----------START
function build_saved_receiving($tab_id=null){
	$CI =& get_instance();
	
	$CI->make->sDivRow();
		// $CI->make->sDivCol(12, 'right', 0, array('style'=>'margin-bottom: -55px;'));
		$CI->make->sDivCol(12, 'right', 0, array('style'=>''));
			$CI->make->A(fa('fa-reply').' RECEIVE NEW TRANSACTION', base_url().'receiving/receiving_entry/',array('class'=>'btn btn-primary def_btns', 'style'=>'cursor: pointer; margin-right: 10px; margin-left: 10px;'));
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$tab_id);
			
			$CI->make->sTab();
				$tabs = array(
					fa('fa-bookmark-o')=>array('href'=>'#details','class'=>'tab_link','load'=>'receiving/saved_receiving_list/','id'=>'details_link'),
				);
			$CI->make->eTab();
			$CI->make->tabHead($tabs,null,array());
			$CI->make->sTabBody();
				$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
				$CI->make->eTabPane();
			$CI->make->eTabBody();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	return $CI->make->code();
}
function build_saved_receiving_list($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
				
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								"Supplier" => array("style"=>"text-align: left;"),
								"P.O. #" => array("style"=>"text-align: center;"),
								"Invoice #" => array("style"=>"text-align: center;"),
								"Date" => array("style"=>"text-align: center;"),
								" " => array("style"=>"text-align: center;")
							);
							
							$rows = array();
							// echo "===>".var_dump($list);
							foreach($list as $val){
								$link = $CI->make->A(
									fa('fa-pencil-square-o fa-lg fa-fw'),
									base_url().'receiving/edit_receiving_entry/'.$val->id,
									array('return'=>'true',
										'class'=>'edit_btn',
										'title'=>'Edit this saved receiving')
								);
								
								$rows[] = array(
									$val->supplier_name,
									$val->po_reference,
									$val->invoice_no,
									date('Y-m-d', strtotime($val->delivery_date)),
									array('text'=>$link,'params'=>array('style'=>'text-align:center'))
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
function build_edit_receiving_entry_form($receiving_id=null, $items=array()){
	$CI =& get_instance();
	$user = $CI->session->userdata('user');
	
	$CI->make->sForm("",array('id'=>'receiving_entry_form'));
	
		$CI->make->sDivRow(array('style'=>'margin-top:-5px;'));
			$CI->make->sDivCol(12,'right', 0, array());
					$CI->make->hidden('hidden_user',$user['id']);
					$CI->make->hidden('form_mode', ($receiving_id == '' ? 'add' : 'edit'));

					$CI->make->A(fa('fa-save').' POST RECEIVING', '',array('class'=>'btn btn-primary post_receiving_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
					$CI->make->A(fa('fa-reply').' GO BACK',base_url().'receiving/saved_receiving/',array('class'=>'btn back_btn def_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
					
					//-----HIDDEN VALUES FOR RELOADED RECEIVING ITEMS:
					$CI->make->hidden('hidden_receiving_id',($receiving_id != '' ? $receiving_id : ''));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		//-----HEADER PART A-----START
		$CI->make->sDivRow();
			$CI->make->sDivCol(12, 'center', 0, array());
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								// $CI->make->branchesMasterDrop('Branch','branch_id',null,'Select Branch',array('class'=>'rOkay branch_dropdown'));
								$CI->make->input('P.O. #','po_reference',$items->po_reference,null,array('class'=>'rOkay forms', 'readonly'=>'readonly'));
								$CI->make->hidden('order_no',$items->purch_order_no);
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								// $CI->make->branchesMasterDrop('Branch','branch_id',null,'Select Branch',array('class'=>'rOkay branch_dropdown'));
								$CI->make->input('Invoice #','invoice_no',$items->invoice_no,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->input('Invoice Amount','invoice_amt',$items->invoice_amt,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								// $CI->make->branchesMasterDrop('Branch','branch_id',null,'Select Branch',array('class'=>'rOkay branch_dropdown'));
								$CI->make->input('Supplier','supplier_name',$items->supplier_name,null,array('class'=>'rOkay forms', 'readonly'=>'readonly', 'style'=>'color: red;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->datefield('Delivery Date','delivery_date',date('m/d/Y', strtotime($items->delivery_date)),'',array('class'=>'rOkay', 'readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->stockLocationDrop('Stock Location','stock_location',$items->stock_location,null,array('class'=>'rOkay stock_location_dropdown', 'readonly'=>'readonly', 'style'=>'color: red;'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(12);
								$CI->make->input('Notes','receiving_notes',$items->receiving_notes,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		//-----HEADER PART A-----END
		
		//-----ADDER FORM-----START
		$CI->make->sDivRow();
			$CI->make->sDivCol(12, 'center', 0, array('style'=>'margin-bottom: -25px;'));	
				$CI->make->sBox('success',array('div-form'));
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
										$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
											$CI->make->th('Item',array('style'=>'width: 50%;'));
											$CI->make->th('Qty',array('style'=>'width: 20%; text-align: center;'));
											$CI->make->th('UOM',array('style'=>'width: 20%; text-align: center;'));
											$CI->make->th('&nbsp;',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->eRow();
										$barcode_inp = $qty_input = $uom_input = $link = "";
										$barcode_inp = "<input type='text' name='barcode' id='barcode' class='formInputXMed rOkay'>";
										$qty_input = "<input type='text' name='qty' id='qty' class='formInputMini rOkay'>";
										// $uom_input = "<input type='text' name='uom' id='uom' class='formInputMini rOkay' readonly='readonly' style='background-color: #eeeeee;'>";
										$uom_input = "<input type='text' name='uom' id='uom' class='formInputMini rOkay' style='background-color: #eeeeee;'>";
										
										// $link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), '', array(
										// 'class'=>'add_this_item',
										// // 'ref'=>$val->line_id,
										// // 'ref_desc'=>$val->description,
										// 'title'=>'Add this item',
										// 'style'=>'cursor: pointer;',
										// 'return'=>'false'));
										
										$link .= "<button name='add_btn' id='add_btn' class='btn btn-success' title='Add this item?' style='cursor:pointer;'>".fa('fa-plus')."</button>";
										$CI->make->sRow();
											$CI->make->td($barcode_inp,array('style'=>'width: 50%;'));
											$CI->make->td($qty_input,array('style'=>'width: 20%; text-align: center;'));
											$CI->make->td($uom_input,array('style'=>'width: 20%; text-align: center;', 'class'=>'uom_label'));
											$CI->make->td($link,array('style'=>'width: 10%; text-align: center;'));
											// $CI->make->td($CI->make->button(fa('fa-save').' Save Stock Category',array('id'=>'add-btn','class'=>'btn-block'),'primary'),array('style'=>'width: 10%; text-align: center;'));
										$CI->make->eRow();
									$CI->make->eTable();	
								$CI->make->eDiv();
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();	
		$CI->make->eDivRow();
		//-----ADDER FORM-----END
		
		//----------LOADER DIV----------START
		$CI->make->sDiv(array('id'=>'line_item_contents'));
		
		$CI->make->eDiv();
		//----------LOADER DIV----------END
		
		//----------BUTTONS----------START
		$CI->make->sDivRow(array('style'=>'margin-top: -10px;'));
			$CI->make->sDivCol(12,'right', 0, array());
				$CI->make->A(fa('fa-save').' POST RECEIVING', '',array('class'=>'btn btn-primary post_receiving_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'receiving/saved_receiving/',array('class'=>'btn back_btn def_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		//----------BUTTONS----------END
		
	$CI->make->eForm();
	
	return $CI->make->code();
}
//----------SAVED RECEIVING LIST----------END
//----------POSTED RECEIVING LIST----------START
function build_posted_receiving($tab_id=null){
	$CI =& get_instance();
	
	// $CI->make->sDivRow();
		// $CI->make->sDivCol(12, 'right', 0, array('style'=>''));
			// $CI->make->A(fa('fa-reply').' RECEIVE NEW TRANSACTION', base_url().'receiving/receiving_entry/',array('class'=>'btn btn-primary def_btns', 'style'=>'cursor: pointer; margin-right: 10px; margin-left: 10px;'));
		// $CI->make->eDivCol();
	// $CI->make->eDivRow();
	
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$tab_id);
			
			$CI->make->sTab();
				$tabs = array(
					fa('fa-floppy-o')=>array('href'=>'#details','class'=>'tab_link','load'=>'receiving/posted_receiving_list/','id'=>'details_link'),
				);
			$CI->make->eTab();
			$CI->make->tabHead($tabs,null,array());
			$CI->make->sTabBody();
				$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
				$CI->make->eTabPane();
			$CI->make->eTabBody();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	return $CI->make->code();
}
function build_posted_receiving_list($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
				
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								"Supplier" => array("style"=>"text-align: left;"),
								"P.O. #" => array("style"=>"text-align: center;"),
								"Invoice #" => array("style"=>"text-align: center;"),
								"Date" => array("style"=>"text-align: center;"),
								" " => array("style"=>"text-align: center;")
							);
							
							$rows = array();
							// echo "===>".var_dump($list);
							foreach($list as $val){
								$link = $CI->make->A(
									fa('fa-eye fa-lg fa-fw'),
									'',
									// base_url().'receiving/edit_receiving_entry/'.$val->id,
									array('return'=>'true',
										'class'=>'view_btn',
										'ref'=>$val->id,
										'branch_id'=>$val->branch_id,
										'title'=>'View posted receiving details')
								);
								
								$rows[] = array(
									$CI->receiving_model->get_supplier_name($val->supplier_id),
									$val->reference,
									$val->source_invoice_no,
									date('Y-m-d', strtotime($val->delivery_date)),
									array('text'=>$link,'params'=>array('style'=>'text-align:center'))
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
//----------POSTED RECEIVING LIST----------END
//----------POSTED RECEIVING POP-UP VIEW----------APM----------START
function build_posted_receiving_popup_form($rec_id=null, $items=array(), $sub_items=array()){
	$CI =& get_instance();
	
	// echo $rec_id."<br>";
	// echo var_dump($items)."<br>";
	
	$CI->make->sForm("",array('id'=>'posted_receiving_pop_form'));
		//-----HEADER-----START
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->H(4,"P.O. Header",array('style'=>'margin-top:0px;margin-bottom:0px;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->H(5,"Press <span style='color: red;'>ESC</span> or hit the <span style='color: red;'>Close</span> button to close this window.",array('style'=>'margin-top:0px;margin-bottom:0px; text-align: right;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->branchesMasterDrop('Branch','branch_id',$items->branch_id,'Select Branch',array('class'=>'rOkay combobox branch_dropdown','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->supplierMasterDrop('Supplier','supplier_id',$items->supplier_id,'Select Supplier',array('class'=>'rOkay combobox','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Order Date','ord_date',date('m/d/Y', strtotime($items->datetime_created)),'',array('class'=>'rOkay','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->stockLocationDrop('Stock Location','stock_location',$items->stock_location,null,array('class'=>'rOkay stock_location_dropdown','disabled'=>'disabled'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Delivery Date','delivery_date',date('m/d/Y', strtotime($items->delivery_date)),'',array('class'=>'rOkay','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input('Reference #','reference',$items->reference,'',array('class'=>'','disabled'=>'disabled')); //-----Address ng Branch selected
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->textarea('Remarks','comments',$items->receiving_comments,'', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255','disabled'=>'disabled'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		//-----HEADER-----END
		
		//-----LINE ITEMS-----START
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('warning');
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
										$CI->make->th('&nbsp;',array('style'=>''));
									$CI->make->eRow();
									foreach($sub_items as $sub_vals){
										$CI->make->sRow();
										$CI->make->td("[ ".$sub_vals->stock_id." ] ".$sub_vals->description);	
										$CI->make->td($sub_vals->qty_received);	
										$CI->make->td($sub_vals->receiving_uom);	
										$CI->make->td($sub_vals->extended/($sub_vals->qty_received * $sub_vals->receiving_qty));	
										$CI->make->td($sub_vals->extended);	
										$CI->make->td('',array('style'=>''));
									$CI->make->eRow();
									}
								$CI->make->eTable();
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		//-----LINE ITEMS-----END
		
		$CI->make->sDivRow(array('style'=>'margin-top:0px;margin-bottom:0px;'));
			$CI->make->sDivCol();
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->input('Created By','created_by',$CI->receiving_model->get_user_name($items->created_by),'',array('class'=>'','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Date Created','date_created',date('m/d/Y', strtotime($items->datetime_created)),'',array('class'=>'rOkay','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input('Posted By','posted_by',($items->posted_by == '' ? 'NOT YET POSTED' : $CI->receiving_model->get_user_name($items->posted_by)),'',array('class'=>'','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Date Posted','date_posted',($items->datetime_posted == '0000-00-00' ? 'NOT YET POSTED' : date('m/d/Y', strtotime($items->datetime_posted))),'',array('class'=>'rOkay','disabled'=>'disabled'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();
	
	return $CI->make->code();
}
//----------POSTED RECEIVING POP-UP VIEW----------APM----------END