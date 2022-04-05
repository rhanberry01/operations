<?php
//-----Purchase Orders Approval - Mhae (start)
function approval_header_page($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-th-large')." PURCHASE ORDERS APPROVAL"=>array('href'=>'#details','class'=>'tab_link','load'=>'po_inquiries/purchase_orders_approval/','id'=>'details_link'),
					//	fa('fa-money')." BARCODE PRICES"=>array('href'=>'#price','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_stock_barcode_prices/','id'=>'price_link'),
					//	fa('fa-book')." SCHEDULE MARKDOWN"=>array('href'=>'#markdown','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_inquiry_schedule_markdown/','id'=>'markdown_link'),
					//	fa('fa-book')." UPDATE STOCK BARCODE/PRICES"=>array('href'=>'#update','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_update_inquiry/','id'=>'update_link'),
					//	fa('fa-truck')."SUPPLIER STOCKS"=>array('href'=>'#supplier_stock','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_supplier_stocks/','id'=>'supplier_stock_link'),
					//	fa('fa-minus-square-o')."STOCK FOR DELETION"=>array('href'=>'#stock_deletion','class'=>'tab_link load-tab','load'=>'inv_inquiries/stock_deletion_approval/','id'=>'stock_deletion_link'),
					//	fa('fa-bar-chart')."MARGINAL MARKDOWN"=>array('href'=>'#marginal','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_inquiry_marginal_markdown/','id'=>'marginal_link'),

					);
					//$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
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
function purchase_orders_approval($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
	
	$CI->make->sDivCol(12);
		$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
			//-----PRELOADER-----START
			$CI->make->sDiv(array('id'=>'purchase-orders-file-spinner'));
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
			//-----PRELOADER-----END
			
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
									'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
									'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
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
											$tag .=" <span class='label label-warning'>REJECTED</span></br>";
											$tag .=" <span class='label label-info'>".$val->approval_remarks."</span>";
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
														'title'=>'approve this',
														'return'=>'false'));
									$b = $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
													'',
													array('class'=>'action_btns reject_link',
														'ref_desc'=>'reject me',
														'_id'=>$val->order_no,
														'title'=>'reject this',
														'return'=>'false'));
									$c = $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-eye fa-lg fa-fw'),
													'',
													array('class'=>'action_btns view_link',
														'ref_desc'=>'view me',
														'_id'=>$val->order_no,
														'ref'=>$val->order_no,
														'title'=>'view purchase orders',
														'return'=>'false'));
									$d = $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-pencil fa-lg fa-fw'),
													'',
													array('class'=>'action_btns edit_link',
														'ref_desc'=>'Edit this transaction',
														'ref'=>$val->order_no,
														'title'=>'Edit Purchase Order',
														'return'=>'false'));
									$e = $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-print fa-lg fa-fw'),
													'',
													array('class'=>'action_btns print_link',
														'ref_desc'=>'Print this P.O.',
														'ref'=>$val->order_no,
														'title'=>'Print Purchase Order',
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
										(array('text'=>$e, 'params'=>array('style'=>'text-align:center'))),
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
//-----Purchase Orders Approval - Mhae (end)
//----------PO ENTRY POP-UP VIEW----------APM----------START
function build_po_entry_popup_form($po_id=null, $items=array(), $sub_items=array()){
	$CI =& get_instance();
	
	// echo $po_id."<br>";
	// echo var_dump($items)."<br>";
	
	$CI->make->sForm("",array('id'=>'po_entry_pop_form'));
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
								$CI->make->datefield('Order Date','ord_date',date('m/d/Y', strtotime($items->ord_date)),'',array('class'=>'rOkay','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->stockLocationDrop('Stock Location','stock_location',$items->into_stock_location,null,array('class'=>'rOkay stock_location_dropdown','disabled'=>'disabled'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Delivery Date','delivery_date',date('m/d/Y', strtotime($items->delivery_date)),'',array('class'=>'rOkay','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->textarea('Delivery Address','delivery_address',$items->delivery_address,'', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255','disabled'=>'disabled')); //-----Address ng Branch selected
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->textarea('Remarks','comments',$items->comments,'', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255','disabled'=>'disabled'));
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
										$CI->make->td($sub_vals->qty_ordered);	
										$CI->make->td($sub_vals->uom);	
										$CI->make->td($sub_vals->unit_cost);	
										$CI->make->td($sub_vals->qty_ordered * $sub_vals->unit_cost);	
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
								$CI->make->input('Created By','created_by',$CI->po_inquiries_model->get_user_name($items->created_by),'',array('class'=>'','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Date Created','date_created',date('m/d/Y', strtotime($items->date_created)),'',array('class'=>'rOkay','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input('Posted By','posted_by',($items->posted_by == '' ? 'NOT YET POSTED' : $CI->po_inquiries_model->get_user_name($items->posted_by)),'',array('class'=>'','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Date Posted','date_posted',($items->date_posted == '0000-00-00' ? 'NOT YET POSTED' : date('m/d/Y', strtotime($items->date_posted))),'',array('class'=>'rOkay','disabled'=>'disabled'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();
	
	return $CI->make->code();
}
//----------PO ENTRY POP-UP VIEW----------APM----------END
//----------Purchase Order Lists --MHAE----------------START
function po_lists_header_page($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-th-large')." PURCHASE ORDER LIST"=>array('href'=>'#details','class'=>'tab_link','load'=>'po_inquiries/po_lists/','id'=>'details_link'),
					//	fa('fa-money')." BARCODE PRICES"=>array('href'=>'#price','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_stock_barcode_prices/','id'=>'price_link'),
					//	fa('fa-book')." SCHEDULE MARKDOWN"=>array('href'=>'#markdown','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_inquiry_schedule_markdown/','id'=>'markdown_link'),
					//	fa('fa-book')." UPDATE STOCK BARCODE/PRICES"=>array('href'=>'#update','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_update_inquiry/','id'=>'update_link'),
					//	fa('fa-truck')."SUPPLIER STOCKS"=>array('href'=>'#supplier_stock','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_supplier_stocks/','id'=>'supplier_stock_link'),
					//	fa('fa-minus-square-o')."STOCK FOR DELETION"=>array('href'=>'#stock_deletion','class'=>'tab_link load-tab','load'=>'inv_inquiries/stock_deletion_approval/','id'=>'stock_deletion_link'),
					//	fa('fa-bar-chart')."MARGINAL MARKDOWN"=>array('href'=>'#marginal','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_inquiry_marginal_markdown/','id'=>'marginal_link'),

					);
					//$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
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

function purchase_order_lists($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
	
	$CI->make->sDivCol(12);
		$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
			$CI->make->sDivCol();
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								//array('text'=>$check_all, 'params'=>array('style'=>'text-align:center'));
								$th = array(
									
									'Branch' => array('text-align'=>'center'),
									'Supplier' => array('text-align'=>'center'),		
									'Stock Location' => array('text-align'=>'center'),		
									'Order Date' => array('text-align'=>'center'),		
									'Delivery Date' => array('text-align'=>'center'),
									'Total Amount' => array('text-align'=>'center'),
									'&nbsp;' => array('text-align'=>'center'),
									'&nbsp;&nbsp;' => array('text-align'=>'center'),
									'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
									'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center')
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
									$a = $b = $c = "";	
									
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
													'&nbsp;&nbsp;'.fa('fa-eye fa-lg fa-fw'),
													'',
													array('class'=>'action_btns view_link',
														'ref_desc'=>'view me',
														'_id'=>$val->order_no,
														'ref'=>$val->order_no,
														'title'=>'view purchase orders',
														'return'=>'false'));
									$b = $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-pencil fa-lg fa-fw'),
													'',
													array('class'=>'action_btns edit_link',
														'ref_desc'=>'Edit this transaction',
														'ref'=>$val->order_no,
														'title'=>'Edit Purchase Order',
														'return'=>'false'));
									$c = $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-print fa-lg fa-fw'),
													'',
													array('class'=>'action_btns print_link',
														'ref_desc'=>'Print this P.O.',
														'ref'=>$val->order_no,
														'title'=>'Print Purchase Order',
														'return'=>'false'));
														
									$rows[] = array(
										$CI->main_model->get_branch_code($val->branch_id),
										$CI->main_model->get_supplier_name($val->supplier_id),
										$stock_location,
										date('Y-M-d H:i:s', strtotime($val->ord_date)),
										date('Y-M-d', strtotime($val->delivery_date)),
										$val->total_amt,
										($val->branch_no_con != null ? $no_con: $tag),
										(array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
										(array('text'=>$a, 'params'=>array('style'=>'text-align:center'))),
										($val->branch_no_con != null ? '' : ($val->status != '0' ?  '' : (array('text'=>$b, 'params'=>array('style'=>'text-align:center')))))
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
//----------Purchase Order Lists --MHAE----------------END
?>