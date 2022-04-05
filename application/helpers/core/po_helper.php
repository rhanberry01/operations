<?php
function build_dashboard($out_of_stocks_count=null, $critical_stocks_count=null, $pending_po_count=null, $unserved_po_count=null, $offtake_count=null, $overstocked_count=null){
	$CI =& get_instance();
	
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
				
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDivRow();
							
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($out_of_stocks_count > 0 ? 'small-box bg-red' : 'small-box bg-green')));
									// $CI->make->sDiv(array('class'=>'small-box bg-green'));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($out_of_stocks_count > 0 ? $out_of_stocks_count : '0'),array());
											// $CI->make->H(3,0,array());
											$CI->make->P('Out of Stocks',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-arrow-graph-down-right"></i>');
										$CI->make->eDiv();
										$CI->make->A(($out_of_stocks_count > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($out_of_stocks_count > 0 ? 'out_of_stock' : '')));
										// $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer', 'id'=>''));
									$CI->make->eDiv();
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($critical_stocks_count > 0 ? 'small-box bg-red' : 'small-box bg-green')));
									// $CI->make->sDiv(array('class'=>'small-box bg-green'));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($critical_stocks_count > 0 ? $critical_stocks_count : '0'),array());
											// $CI->make->H(3,0,array());
											$CI->make->P('Critical Stocks',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-ios-pulse-strong"></i>');
										$CI->make->eDiv();
										$CI->make->A(($critical_stocks_count > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($critical_stocks_count > 0 ? 'critical_stocks' : '')));
										// $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer', 'id'=>''));
									$CI->make->eDiv();
								$CI->make->eDivCol();
	
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($pending_po_count > 0 ? 'small-box bg-red' : 'small-box bg-green')));
									// $CI->make->sDiv(array('class'=>'small-box bg-green'));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($pending_po_count > 0 ? $pending_po_count : '0'),array());
											// $CI->make->H(3,0,array());
											$CI->make->P('Pending P.O.',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-archive"></i>');
										$CI->make->eDiv();
										$CI->make->A(($pending_po_count > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($pending_po_count > 0 ? 'pending_po' : '')));
										// $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer', 'id'=>''));
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($unserved_po_count > 0 ? 'small-box bg-red' : 'small-box bg-green')));
									// $CI->make->sDiv(array('class'=>'small-box bg-green'));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($unserved_po_count > 0 ? $unserved_po_count : '0'),array());
											// $CI->make->H(3,0,array());
											$CI->make->P('Unserved P.O.',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-filing"></i>');
										$CI->make->eDiv();
										$CI->make->A(($unserved_po_count > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($unserved_po_count > 0 ? 'unserved_po' : '')));
										// $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer', 'id'=>''));
									$CI->make->eDiv();
								$CI->make->eDivCol();
								
							$CI->make->eDivRow();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					
				$CI->make->eBoxBody();
			$CI->make->eBox();
					
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
				
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDivRow();
							
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($offtake_count > 0 ? 'small-box bg-red' : 'small-box bg-green')));
									// $CI->make->sDiv(array('class'=>'small-box bg-green'));
										$CI->make->sDiv(array('class'=>'inner'));
											// $CI->make->H(3,($offtake_count > 0 ? $offtake_count : '0'),array());
											$CI->make->H(3,'&nbsp;',array());
											$CI->make->P('Decreasing Product Offtake',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-arrow-graph-down-right"></i>');
										$CI->make->eDiv();
										$CI->make->A(($offtake_count > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($offtake_count > 0 ? 'decreasing_offtake' : '')));
										// $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer', 'id'=>''));
									$CI->make->eDiv();
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3);
									// $CI->make->sDiv(array('class'=>($overstocked_count > 0 ? 'small-box bg-red' : 'small-box bg-green')));
									$CI->make->sDiv(array('class'=>'small-box bg-red'));
									// $CI->make->sDiv(array('class'=>'small-box bg-green'));
										$CI->make->sDiv(array('class'=>'inner'));
											// $CI->make->H(3,($overstocked_count > 0 ? $overstocked_count : '0'),array());
											$CI->make->H(3,'&nbsp;',array());
											$CI->make->P('Overstocked Items',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-alert-circled"></i>');
										$CI->make->eDiv();
										// $CI->make->A(($overstocked_count > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($overstocked_count > 0 ? 'overstocked_items' : '')));
										// $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer', 'id'=>''));
										$CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer', 'id'=>'overstocked_items'));
									$CI->make->eDiv();
								$CI->make->eDivCol();
	
								$CI->make->sDivCol(3);
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3);
								$CI->make->eDivCol();
								
							$CI->make->eDivRow();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					
				$CI->make->eBoxBody();
			$CI->make->eBox();
					
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	return $CI->make->code();
}	

function build_branch_stocks_display($items = array()){
	
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Stock Code' => array('style'=>'text-align:center'),
					'Description' => array('style'=>'text-align:center'),
					'Supplier Stock Code' => array('style'=>'text-align:center'),
					'Branch' => array('style'=>'text-align:center'),
					'Stock Location' => array('style'=>'text-align:center'),
					'Quantity' => array('style'=>'text-align:center'),
					'Cost of Sales' => array('style'=>'text-align:center')
					);
				$rows = array();
				foreach ($items as $val) {
			
					$rows[] = array(
							array('text'=>$val->stock_code,'params'=>array('style'=>'text-align:center')),
							array('text'=>$val->description,'params'=>array('style'=>'text-align:center')),
							array('text'=>$val->supp_stock_code,'params'=>array('style'=>'text-align:center')),
							array('text'=>$CI->po_model->get_branch_code($val->branch_id),'params'=>array('style'=>'text-align:center')),
							array('text'=>$CI->po_model->get_stock_location_desc($val->stock_loc_id),'params'=>array('style'=>'text-align:center')),
							array('text'=>$val->qty,'params'=>array('style'=>'text-align:center')),
							array('text'=>$val->cost_of_sales,'params'=>array('style'=>'text-align:center'))
						);
				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
	
}
function build_branch_stocks_inq_form()
{
$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("po/brach_stock_inquiry_results/",array('id'=>'branch_stock_search_form'));
						$CI->make->sDivCol(3,'left',0,array('id'=>'cust-branch-div'));
							$CI->make->branches_all_CodeDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->supplierMasterDrop('Supplier','supp_id',null,'Select Supplier',array('class'=>'rOkay combobox supp_dropdown'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->stockMasterDrop('Stock Items','stock_id',null,'Select Stock',array('class'=>'rOkay combobox supp_dropdown'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(1,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
							$CI->make->A(fa('fa-search').' Search Branch Stock','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:right'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Branch Stock Inquiry ",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
	
	
}
function po_dashboard_inquiry_page($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-top: -5px; margin-bottom:10px;'));
		$CI->make->sDivCol(4);
		$CI->make->eDivCol();
		$CI->make->sDivCol(4);
		$CI->make->eDivCol();
		$CI->make->sDivCol(4);
			$CI->make->button(fa('fa-reply').' Return to Purchasing Dashboard',array('id'=>'back-btn','class'=>'btn-block'),'default');
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-th-large')." OUT OF STOCK"=>array('href'=>'#out_of_stock','class'=>'tab_link','load'=>'po/out_of_stock_list/','id'=>'out_of_stock_link'),
						fa('fa-th-large')." CRITICAL STOCKS"=>array('href'=>'#critical_stocks','class'=>'tab_link','load'=>'po/critical_stocks_list/','id'=>'critical_stocks_link'),
						fa('fa-bar-chart')."PENDING PURCHASE ORDERS"=>array('href'=>'#pending_po','class'=>'tab_link load-tab','load'=>'po/pending_po_list/','id'=>'pending_po_link'),
						fa('fa-bar-chart')."UNSERVED PURCHASE ORDERS"=>array('href'=>'#unserved_po','class'=>'tab_link load-tab','load'=>'po/unserved_po_list/','id'=>'unserved_po_link'),
						fa('fa-th-large')."DECREASING PRODUCT OFFTAKE"=>array('href'=>'#decreasing_offtake','class'=>'tab_link load-tab','load'=>'po/decreasing_offtake_list/','id'=>'decreasing_offtake_link'),
						fa('fa-exclamation-triangle')."OVERSTOCKED ITEMS"=>array('href'=>'#overstocked_items','class'=>'tab_link load-tab','load'=>'po/overstocked_items_list/','id'=>'overstocked_items_link'),

					);
					//$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'out_of_stock','class'=>'tab-pane '));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'critical_stocks','class'=>'tab-pane '));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'pending_po','class'=>'tab-pane '));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'unserved_po','class'=>'tab-pane '));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'decreasing_offtake','class'=>'tab-pane '));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'overstocked_items','class'=>'tab-pane '));
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function build_out_of_stock_list_form($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'out_of_stock_spinner'));
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
						$CI->make->sDivCol();
							$th = array(
								'Branch' => array('text-align'=>'center'),		
								'Stock' => array('text-align'=>'center'),
								'Stock Location' => array('text-align'=>'center'),
								'Quantity' => array('text-align'=>'center'),
								'Critical Quantity' => array('text-align'=>'center'),
								);
							$rows = array();
							$tag = $loc_desc = '';
							foreach ($list as $val) {
								$tag = $loc_desc = '';
								$a = $b = $c = "";								
								$stock_desc = $CI->po_model->get_stock_desc($val->stock_id);
								$branch_name = $CI->po_model->get_branch_name($val->branch_id);
								if($val->stock_loc_id == 1){
									$loc_desc = "SELLING AREA";
								}else if($val->stock_loc_id == 2){
									$loc_desc = "STOCK ROOM";
								}else if($val->stock_loc_id == 3){
									$loc_desc = "B.O. ROOM";
								}
								$rows[] = array(
									$branch_name,
									$stock_desc,
									$loc_desc,
									$val->qty,
									CRITICAL_QTY,
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
function build_critical_stocks_list_form($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'critical_stocks_spinner'));
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
						$CI->make->sDivCol();
							$th = array(
								'Branch' => array('text-align'=>'center'),		
								'Stock' => array('text-align'=>'center'),
								'Quantity' => array('text-align'=>'center'),
								'Critical Quantity' => array('text-align'=>'center'),
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag = '';
								$a = $b = $c = "";								
								$stock_desc = $CI->po_model->get_stock_desc($val->stock_id);
								$branch_name = $CI->po_model->get_branch_name($val->branch_id);
								$rows[] = array(
									$branch_name,
									$stock_desc,
									$val->qty,
									// $val->critical_qty, //ORIGINAL
									CRITICAL_QTY,
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
function build_pending_po_list_form($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'pending_po_spinner'));
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
								$CI->make->A(fa('fa-plus').' Cancel all checked items','',array('class'=>'btn btn-danger','id'=>'btn_id_cancel_ppo'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(12,'right');
								$CI->make->append('<br>');
								$CI->make->A(fa('fa-check-square-o').' Check All','',array('class'=>'btn btn-success','id'=>'btn_check_cancel_ppo'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								'PO #' => array('text-align'=>'center'),
								'Branch' => array('text-align'=>'center'),		
								'Supplier' => array('text-align'=>'center'),
								'Order Date' => array('text-align'=>'center'),
								'Delivery Date' => array('text-align'=>'center'),
								// 'Total' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag = '';
								$a = $b = $c = $d = $e = "";								
								$a = $CI->make->A(
													fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'order_id'=>$val->order_no,
													'title'=>'view this',
													'return'=>'false'));
								
								$d = $CI->make->A(
													fa('fa-pencil fa-fw')." Modify PO",
												'',
												array('class'=>'btn btn-success action_btns modify_po_link',
													'ref_desc'=>'modify po',
													'ref'=>$val->order_no,
													'title'=>'Modify this PO',
													'style'=>'cursor: pointer;',
													'return'=>'false'));
								$e = $CI->make->A(
													fa('fa-remove fa-fw')." Cancel PO",
												'',
												array('class'=>'btn btn-danger action_btns cancel_po_link',
													'ref_desc'=>'cancel po',
													'order_no'=>$val->order_no,
													'ref'=>$val->order_no,
													'po_ref'=>$val->reference,
													'title'=>'Cancel this PO',
													'style'=>'cursor: pointer;',
													'return'=>'false'));
								
								$branch_name = $CI->po_model->get_branch_name($val->branch_id);
								$supp_name = $CI->po_model->get_supplier_name($val->supplier_id);
								$rows[] = array(
									$val->order_no,
									$branch_name,
									$supp_name,
									$val->ord_date,
									$val->delivery_date,
									// $val->total,
									$a,
									$d,
									$e,
									$CI->make->checkbox_($val->order_no,array('class'=>'check_id_cancel_ppo','id'=>$val->order_no))
									// ($val->branch_no_con != null ?   (array("text"=>"<span class='label label-danger'>No Connection</span>", 'params'=>array('style'=>'text-align:center'))) : array('text'=>$b, 'params'=>array('style'=>'text-align:center'))),	
									// ($val->branch_no_con != null ? '' : array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									// ($val->branch_no_con != null ? '' : $CI->make->checkbox_($val->id,array('class'=>'check_id_marginal','id'=>$val->id.':'.$val->branch_id)))
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
function build_pending_po_details_popup_form($header=array(), $details=array()){
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:2px;'));
		$CI->make->sDivCol(12,'center',0,array("style"=>''));
			$CI->make->sBox('success',array('div-form'));
				$CI->make->sBoxBody(array('style'=>''));
					$CI->make->sDivRow();
						$CI->make->sDivCol(3);
							$branch_code = $CI->po_model->get_po_branch_code($header[0]->branch_id);
							$CI->make->input('Branch','branch_id',$branch_code,null,array('readonly'=>'readonly'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(6);
							$supp_name = $CI->po_model->get_supplier_name($header[0]->supplier_id);
							$CI->make->input('Supplier','supplier_id',$supp_name,null,array('readonly'=>'readonly'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$purch_name = $CI->po_model->get_user_name($header[0]->created_by);
							$CI->make->input('Purchaser','created_by',$purch_name,null,array('readonly'=>'readonly'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol(4);
							$CI->make->input('Order Date','branch_id',$header[0]->ord_date,null,array('readonly'=>'readonly'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->input('Delivery Date','supplier_id',$header[0]->delivery_date,null,array('readonly'=>'readonly'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							// $CI->make->input('Total','person_id',$header[0]->total,null,array('readonly'=>'readonly'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();	
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	$CI->make->sDivRow(array('style'=>'margin:2px;'));
		$CI->make->sDivCol(12,'center',0,array("style"=>''));
			$CI->make->sBox('info',array('div-form'));
				$CI->make->sBoxBody(array('style'=>''));
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								// 'Barcode' => array('text-align'=>'center'),
								'Description ' => array('text-align'=>'center'),		
								'UOM' => array('text-align'=>'center'),		
								'Unit Price ' => array('text-align'=>'center'),		
								'Qty Ordered ' => array('text-align'=>'center'),		
								'Qty Received ' => array('text-align'=>'center'),		
								'Extended ' => array('text-align'=>'center'),		
								);
							$rows = array();
							$extended = $tot_extended = 0;
							foreach($details as $val){
								$extended = $val->unit_cost*$val->qty_ordered;
								$rows[] = array(
									// $val->barcode,
									$val->description,
									$val->uom,
									$val->unit_cost,
									$val->qty_ordered,
									$val->qty_received,
									$extended,
								);
								$tot_extended += $extended;
							}
							$rows[] = array(
								array('text'=>'<b>TOTAL</b>', "params"=>array("style"=>"background-color: ".($tot_extended > 0 ? '#f9edbe' : '#cae8c6')."")),
								array('text'=>'', "params"=>array("style"=>"background-color: ".($tot_extended > 0 ? '#f9edbe' : '#cae8c6')."")),
								array('text'=>'', "params"=>array("style"=>"background-color: ".($tot_extended > 0 ? '#f9edbe' : '#cae8c6')."")),
								array('text'=>'', "params"=>array("style"=>"background-color: ".($tot_extended > 0 ? '#f9edbe' : '#cae8c6')."")),
								array('text'=>'', "params"=>array("style"=>"background-color: ".($tot_extended > 0 ? '#f9edbe' : '#cae8c6')."")),
								// array('text'=>'', "params"=>array("style"=>"background-color: ".($tot_extended > 0 ? '#f9edbe' : '#cae8c6')."")),
								array('text'=>$tot_extended, "params"=>array("style"=>"background-color: ".($tot_extended > 0 ? '#f9edbe' : '#cae8c6')."")),
							);
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
					$CI->make->eDivRow();	
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	return $CI->make->code();
}
function build_unserved_po_list_form($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'unserved_po_spinner'));
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
						$CI->make->sDivCol();
							$th = array(
								'PO #' => array('text-align'=>'center'),
								'Branch' => array('text-align'=>'center'),		
								'Supplier' => array('text-align'=>'center'),
								'Order Date' => array('text-align'=>'center'),
								'Delivery Date' => array('text-align'=>'center'),
								// 'Total' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;&nbsp;' => array('text-align'=>'center'),
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag = '';
								$a = $b = $c = $d = $e = "";								
								$a = $CI->make->A(
													fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'action_btns view_link',
													'ref_desc'=>'view me',
													'order_id'=>$val->order_no,
													'title'=>'view this',
													'return'=>'false'));
								$d = $CI->make->A(
													fa('fa-refresh fa-fw')." Generate New PO",
												'',
												array('class'=>'btn btn-info action_btns new_po_link',
													'ref_desc'=>'generate new po',
													'order_no'=>$val->order_no,
													'title'=>'Generate New PO',
													'style'=>'cursor: pointer;',
													'return'=>'false'));
								$e = $CI->make->A(
													fa('fa-pencil fa-fw')." Extend Delivery Date",
												'',
												array('class'=>'btn btn-success action_btns extend_date_link',
													'ref_desc'=>'extend delivery date',
													'order_no'=>$val->order_no,
													'title'=>'Extend Delivery Date of this PO',
													'style'=>'cursor: pointer;',
													'return'=>'false'));
								
								$branch_name = $CI->po_model->get_branch_name($val->branch_id);
								$supp_name = $CI->po_model->get_supplier_name($val->supplier_id);
								$rows[] = array(
									$val->order_no,
									$branch_name,
									$supp_name,
									$val->ord_date,
									$val->delivery_date,
									// $val->total,
									$a,
									$d,
									$e,
									// ($val->branch_no_con != null ?   (array("text"=>"<span class='label label-danger'>No Connection</span>", 'params'=>array('style'=>'text-align:center'))) : array('text'=>$b, 'params'=>array('style'=>'text-align:center'))),	
									// ($val->branch_no_con != null ? '' : array('text'=>$c, 'params'=>array('style'=>'text-align:center'))),
									// ($val->branch_no_con != null ? '' : $CI->make->checkbox_($val->id,array('class'=>'check_id_marginal','id'=>$val->id.':'.$val->branch_id)))
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
function build_decreasing_offtake_list_form($list)
// function build_decreasing_offtake_list_form($old_list, $latest_list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'decreasing_offtake_spinner'));
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
						$CI->make->sDivCol();
							$th = array(
								'Stock' => array('text-align'=>'center'),
								'Previous Offtake' => array('text-align'=>'center'),		
								'Current Offtake' => array('text-align'=>'center'),		
								'%' => array('text-align'=>'center'),		
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								// $tag = '';
								// $a = $b = $c = $d = $e = "";								
								// $a = $CI->make->A(
													// fa('fa-eye fa-lg fa-fw'),
												// '',
												// array('class'=>'action_btns view_link',
													// 'ref_desc'=>'view me',
													// 'order_id'=>$val->order_no,
													// 'title'=>'view this',
													// 'return'=>'false'));
								// $d = $CI->make->A(
													// fa('fa-refresh fa-fw')." Generate New PO",
												// '',
												// array('class'=>'btn btn-info action_btns new_po_link',
													// 'ref_desc'=>'generate new po',
													// 'order_no'=>$val->order_no,
													// 'title'=>'Generate New PO',
													// 'style'=>'cursor: pointer;',
													// 'return'=>'false'));
								// $e = $CI->make->A(
													// fa('fa-pencil fa-fw')." Extend Delivery Date",
												// '',
												// array('class'=>'btn btn-success action_btns extend_date_link',
													// 'ref_desc'=>'extend delivery date',
													// 'order_no'=>$val->order_no,
													// 'title'=>'Extend Delivery Date of this PO',
													// 'style'=>'cursor: pointer;',
													// 'return'=>'false'));
								
								// $branch_name = $CI->po_model->get_branch_name($val->branch_id);
								// $supp_name = $CI->po_model->get_supplier_name($val->supplier_id);
								$rows[] = array(
									$val[0],
									$val[1],
									$val[2],
									$val[3]
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
function build_overstocked_item_list_form($list)
// function build_decreasing_offtake_list_form($old_list, $latest_list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
				$CI->make->sDiv(array('id'=>'overstocked_items_spinner'));
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
						$CI->make->sDivCol();
							$th = array(
								'Branch' => array('text-align'=>'center'),
								'Stock' => array('text-align'=>'center'),
								// 'Previous Offtake' => array('text-align'=>'center'),		
								'Current Offtake' => array('text-align'=>'center'),		
								// '%' => array('text-align'=>'center'),		
								'Quantity On Hand' => array('text-align'=>'center'),		
								'Forecasted Quantity' => array('text-align'=>'center'),		
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$rows[] = array(
									$val[2],
									$val[0],
									// $val[1],
									$val[1],
									// $val[3],
									$val[3],
									$val[4]
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
function build_extend_delivery_date_popup_form($id=null, $header=array(), $details=array()){
	$CI =& get_instance();
	
	$CI->make->sForm("",array('id'=>'extend_delivery_date_form'));
	
		$CI->make->sDivRow(array('style'=>'margin:2px;'));
			$CI->make->sDivCol(12,'center',0,array("style"=>''));
				$CI->make->sBox('success',array('div-form'));
					$CI->make->sBoxBody(array('style'=>''));
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->hidden('hidden_po_order_no',$id);
								$branch_code = $CI->po_model->get_po_branch_code($header[0]->branch_id);
								$CI->make->input('Branch','branch_id',$branch_code,null,array('readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
							$CI->make->hidden('hidden_supplier_id',$header[0]->supplier_id);
								$supp_name = $CI->po_model->get_supplier_name($header[0]->supplier_id);
								$CI->make->input('Supplier','supplier_id',$supp_name,null,array('readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$purch_name = $CI->po_model->get_user_name($header[0]->created_by);
								$CI->make->input('Purchaser','person_id',$purch_name,null,array('readonly'=>'readonly'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								$CI->make->input('Order Date','branch_id',$header[0]->ord_date,null,array('readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Delivery Date','delivery_date',$header[0]->delivery_date,null,array('readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->datefield('[ NEW ] Delivery Date','new_delivery_date',date('m/d/Y', strtotime($header[0]->delivery_date)),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();	
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	
	$CI->make->eForm();
	
	return $CI->make->code();
}
//----------PURCHASE ORDER ENTRY----------START
function build_po_entry_form($po_id=null){
	$CI =& get_instance();
	$user = $CI->session->userdata('user');
	
	$CI->make->sForm("",array('id'=>'po_entry_form'));
	
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right', 0, array());
					$CI->make->hidden('hidden_user',$user['id']);
					$CI->make->hidden('form_mode', ($po_id == '' ? 'add' : 'edit'));
					$CI->make->hidden('hidden_po_order_no', ($po_id == '' ? '' : $po_id));
					$CI->make->hidden('supplier_selling_days', 0);
					$CI->make->button(fa('fa-retweet').' Generate Suggested Qty',array('id'=>'suggest_po_btn', 'style'=>' margin-right: 10px; margin-left: 10px;'),'success');
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save_po_btn', 'style'=>' margin-right: 10px; margin-left: 10px;'),'primary');
					$CI->make->A(fa('fa-reply').' Go Back','',array('id'=>'back-btn','class'=>'btn'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		//-----HEADER PART A-----START
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->H(4,"P.O. Header",array('style'=>'margin-top:0px;margin-bottom:0px;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->branchesMasterDrop('Branch','branch_id',null,'Select Branch',array('class'=>'rOkay branch_dropdown'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->supplierMasterDrop('Supplier','supplier_id','','Select Supplier',array('class'=>'rOkay combobox'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Order Date','ord_date',date('m/d/Y'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->stockLocationDrop('Stock Location','stock_location',null,null,array('class'=>'rOkay stock_location_dropdown'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							// $CI->make->sDivCol(3);
								// $CI->make->input('Reference','reference',null,null,array('class'=>'rOkay'));
							// $CI->make->eDivCol();
							// $CI->make->sDivCol(3);
								// $CI->make->input('Supplier\'s Reference','reference',null,null,array('class'=>'rOkay'));
							// $CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Delivery Date','delivery_date',date('m/d/Y'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->textarea('Delivery Address','delivery_address','','', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255')); //-----Address ng Branch selected
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->textarea('Remarks','comments','','', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						// $CI->make->sDivRow();
							// $CI->make->sDivCol();
								// $CI->make->textarea('Remarks','comments','','', array('style'=>'resize:vertical; height: 50px;','maxchars'=>'255'));
							// $CI->make->eDivCol();
						// $CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		//-----HEADER PART A-----END
		
		$CI->make->sDivRow();
			//-----LINE ITEM ADDER-----START
			$CI->make->sDivCol(5);
				$CI->make->sBox('warning');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->H(4,"Add P.O. Line Item",array('style'=>'margin-top:0px;margin-bottom:0px;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->supplierStocksDrop('Stock','stock_id',null,'Select Item',array('class'=>'combobox supp_stock_drop forms this_item'));
								$CI->make->hidden('hidden_stock_id','');
								$CI->make->hidden('stock_desc','');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								$CI->make->input('Quantity','quantity_ordered',null,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->stockUOMCodeDrop('UOM','uom','','Select UOM',array('class'=>'rOkay reqForm'));
								$CI->make->hidden('uom_qty','');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Unit Cost','unit_cost','',null,array('class'=>'formInput', 'readonly'=>'readonly'));
								$CI->make->hidden('hidden_unit_cost','');
							$CI->make->eDivCol();
						$CI->make->eDivRow();	
						
						//-----STOCK DISCOUNTS-----START
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Discount # 1','discount1','','',array('class'=>'disc1 supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->discountTypeDrop('Type','disc_type1','','Select Discount Type',array('class'=>'disc_type1_drop supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Discount # 2','discount2','','',array('class'=>'disc2 supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->discountTypeDrop('Type','disc_type2','','Select Discount Type',array('class'=>'disc_type2_drop supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Discount # 3','discount3','','',array('class'=>'disc3 supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->discountTypeDrop('Type','disc_type3','','Select Discount Type',array('class'=>'disc_type3_drop supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();	
						//-----STOCK DISCOUNTS-----END
						
						$CI->make->sDivRow();	
							$CI->make->sDivCol(8);
								$CI->make->hidden('hidden_disc_unit_cost','');
								$CI->make->input('TOTAL','total','',null,array('class'=>'formInput', 'readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->hidden('total_amount','');
								$CI->make->button(fa('fa-plus').'',array('id'=>'add_btn', 'style'=>' margin-top: 25px;'),'primary');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			//-----LINE ITEM ADDER-----END
			
			//-----LINE ITEMS-----START
			$CI->make->sDivCol(7);
				$CI->make->sDiv(array('id'=>'line_item_contents'));
				$CI->make->eDiv();
			$CI->make->eDivCol();
			//-----LINE ITEMS-----END
		$CI->make->eDivRow();
		
		//-----HEADER PART B-----START
		// $CI->make->sBox('info');
			// $CI->make->sBoxBody();
				// $CI->make->sDivRow();
					// $CI->make->sDivCol();
						// $CI->make->textarea('Remarks','remarks','','', array('style'=>'resize:vertical;','maxchars'=>'255'));
					// $CI->make->eDivCol();
				// $CI->make->eDivRow();
			// $CI->make->eBoxBody();
		// $CI->make->eBox();
		//-----HEADER PART B-----END
		
	$CI->make->eForm();
	
	return $CI->make->code();
}
function build_purch_order_details_list_form($item=array(), $mode=null, $stock_id=null){
	$CI =& get_instance();
	
	$CI->make->sDivCol(12,'center',0,array("style"=>''));
		$CI->make->sBox('warning');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									$CI->make->hidden('list_form_mode',$mode);
									$CI->make->th('Item',array('style'=>''));
									$CI->make->th('Qty',array('style'=>''));
									$CI->make->th('UOM',array('style'=>''));
									$CI->make->th('Unit Cost',array('style'=>''));
									$CI->make->th('Total',array('style'=>''));
									$CI->make->th('&nbsp;',array('style'=>''));
								$CI->make->eRow();
								foreach($item as $val){
									$link = "";
									$link .= $CI->make->A(fa('fa-trash fa-lg fa-fw'), '', array(
									'class'=>($mode == 'add' ? 'del_this_item' : 'upd_del_this_item'),
									'ref'=>$val->line_id,
									'title'=>'Delete this item?',
									'style'=>'cursor: pointer;',
									'return'=>'false'));
									$CI->make->sRow();
										$CI->make->td("[ ".$val->stock_id." ] ".$val->description);	
										$CI->make->td($val->qty_ordered);	
										$CI->make->td($val->uom);	
										$CI->make->td($val->unit_cost);	
										$CI->make->td($val->qty_ordered * $val->unit_cost);	
										$CI->make->td($link,array('style'=>''));
									$CI->make->eRow();
								}
							$CI->make->eTable();
						$CI->make->eDiv();
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivCol();
	
	return $CI->make->code();
}
function build_suggested_purch_order_details_list_form($items){
	$CI =& get_instance();
	
	$CI->make->sDivCol(12,'center',0,array("style"=>''));
		$CI->make->sBox('warning');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									// $CI->make->hidden('list_form_mode',$mode);
									$CI->make->th('Item',array('style'=>''));
									$CI->make->th('Avg. Offtake',array('style'=>''));
									$CI->make->th('QoH',array('style'=>''));
									$CI->make->th('Suggested Qty',array('style'=>''));
									// $CI->make->th('Qty**',array('style'=>''));
									// $CI->make->th('UOM**',array('style'=>''));
									// $CI->make->th('Unit Cost',array('style'=>''));
									// $CI->make->th('Total',array('style'=>''));
									// $CI->make->th('&nbsp;',array('style'=>''));
								$CI->make->eRow();
								/* $a[] = array($this->po_model->get_stock_desc($st_val->stock_id), $latest_offtake,  $qoh, $suggested_qty); */
								foreach($items as $val){
									// $link = "";
									// $link .= $CI->make->A(fa('fa-trash fa-lg fa-fw'), '', array(
									// 'class'=>($mode == 'add' ? 'del_this_item' : 'upd_del_this_item'),
									// 'ref'=>$val->line_id,
									// 'title'=>'Delete this item?',
									// 'style'=>'cursor: pointer;',
									// 'return'=>'false'));
									// $CI->make->sRow();
										// $CI->make->td("[ ".$val->stock_id." ] ".$val->description);	
										// $CI->make->td($val->qty_ordered);	
										// $CI->make->td($val->uom);	
										// $CI->make->td($val->unit_cost);	
										// $CI->make->td($val->qty_ordered * $val->unit_cost);	
										// $CI->make->td($link,array('style'=>''));
									// $CI->make->eRow();
									$CI->make->sRow();
										$CI->make->td($val[0]);	
										$CI->make->td($val[1]);	
										$CI->make->td($val[2]);	
										$CI->make->td($val[3]);	
										// $CI->make->td($val->qty_ordered * $val->unit_cost);	
										// $CI->make->td($link,array('style'=>''));
									$CI->make->eRow();
								}
							$CI->make->eTable();
						$CI->make->eDiv();
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivCol();
	
	return $CI->make->code();
}
//----------PURCHASE ORDER ENTRY----------END
//----------EDIT PURCHASE ORDER----------START
function build_edit_po_entry_form($po_id=null, $item=array()){
	$CI =& get_instance();
	$user = $CI->session->userdata('user');

	$CI->make->sForm("",array('id'=>'po_entry_form'));
	
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right', 0, array());
					$CI->make->hidden('hidden_user',$user['id']);
					$CI->make->hidden('form_mode', 'edit');
					// $CI->make->hidden('hidden_po_order_no', ($po_id == '' ? '' : $po_id));
					$CI->make->hidden('hidden_po_order_no', $po_id);
					$CI->make->hidden('reference', $item->reference);
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save_edit_po_btn', 'style'=>' margin-right: 10px; margin-left: 10px;'),'primary');
					$CI->make->A(fa('fa-reply').' Go Back',base_url().'po/dashboard',array('class'=>'btn'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		//-----HEADER PART A-----START
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->H(4,"P.O. Header",array('style'=>'margin-top:0px;margin-bottom:0px;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->branchesMasterDrop('Branch','branch_id',$item->branch_id,'Select Branch',array('class'=>'rOkay combobox branch_dropdown reqForm'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->supplierMasterDrop('Supplier','supplier_id',$item->supplier_id,'Select Supplier',array('class'=>'rOkay combobox reqForm'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Order Date','ord_date',date('m/d/Y', strtotime($item->ord_date)),'',array('class'=>'rOkay reqForm'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->stockLocationDrop('Stock Location','stock_location',$item->into_stock_location,null,array('class'=>'rOkay stock_location_dropdown reqForm'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Delivery Date','delivery_date',date('m/d/Y', strtotime($item->delivery_date)),'',array('class'=>'rOkay reqForm'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->textarea('Delivery Address','delivery_address',$item->delivery_address,'', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255;', 'class'=>'reqForm')); //-----Address ng Branch selected
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->textarea('Remarks','comments',$item->comments,'', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255', 'class'=>'reqForm'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		//-----HEADER PART A-----END
		
		$CI->make->sDivRow();
			//-----LINE ITEM ADDER-----START
			$CI->make->sDivCol(5);
				$CI->make->sBox('warning');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->H(4,"Add P.O. Line Item",array('style'=>'margin-top:0px;margin-bottom:0px;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->supplierStocksDrop('Stock','stock_id',null,'Select Item',array('class'=>'combobox supp_stock_drop forms this_item'));
								$CI->make->hidden('hidden_stock_id','');
								$CI->make->hidden('stock_desc','');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								$CI->make->input('Quantity','quantity_ordered',null,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->stockUOMCodeDrop('UOM','uom','','Select UOM',array('class'=>'rOkay reqForm'));
								$CI->make->hidden('uom_qty','');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Unit Cost','unit_cost','',null,array('class'=>'formInput', 'readonly'=>'readonly'));
								$CI->make->hidden('hidden_unit_cost','');
							$CI->make->eDivCol();
						$CI->make->eDivRow();	
						
						//-----STOCK DISCOUNTS-----START
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Discount # 1','discount1','','',array('class'=>'disc1 supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->discountTypeDrop('Type','disc_type1','','Select Discount Type',array('class'=>'disc_type1_drop supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Discount # 2','discount2','','',array('class'=>'disc2 supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->discountTypeDrop('Type','disc_type2','','Select Discount Type',array('class'=>'disc_type2_drop supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Discount # 3','discount3','','',array('class'=>'disc3 supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->discountTypeDrop('Type','disc_type3','','Select Discount Type',array('class'=>'disc_type3_drop supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();	
						//-----STOCK DISCOUNTS-----END
						
						$CI->make->sDivRow();	
							$CI->make->sDivCol(8);
								$CI->make->hidden('hidden_disc_unit_cost','');
								$CI->make->input('TOTAL','total','',null,array('class'=>'formInput', 'readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->hidden('total_amount','');
								$CI->make->button(fa('fa-plus').'',array('id'=>'edit_po_add_btn', 'style'=>' margin-top: 25px;'),'primary');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			//-----LINE ITEM ADDER-----END
			
			//-----LINE ITEMS-----START
			$CI->make->sDivCol(7);
				$CI->make->sDiv(array('id'=>'line_item_contents'));
				$CI->make->eDiv();
			$CI->make->eDivCol();
			//-----LINE ITEMS-----END
		$CI->make->eDivRow();
		
	$CI->make->eForm();
	
	return $CI->make->code();
}
function build_purch_order_details_list_edit_form($item=array(), $stock_id=null){
	$CI =& get_instance();
	
	$CI->make->sDivCol(12,'center',0,array("style"=>''));
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
									$CI->make->th('&nbsp;',array('style'=>''));
								$CI->make->eRow();
								foreach($item as $val){
									$link = "";
									$link .= $CI->make->A(fa('fa-trash fa-lg fa-fw'), '', array(
									'class'=>'del_this_item',
									'ref'=>$val->line_id,
									'ref_desc'=>$val->description,
									'title'=>'Delete this item?',
									'style'=>'cursor: pointer;',
									'return'=>'false'));
									$CI->make->sRow();
											$CI->make->td("[ ".$val->stock_id." ] ".$val->description);	
											$CI->make->td($val->qty_ordered);	
											$CI->make->td($val->uom);	
											$CI->make->td($val->unit_cost);	
											$CI->make->td($val->qty_ordered * $val->unit_cost);	
											$CI->make->td($link,array('style'=>''));
										$CI->make->eRow();
								}
							$CI->make->eTable();
						$CI->make->eDiv();
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivCol();
	
	return $CI->make->code();
}
//----------EDIT PURCHASE ORDER----------END
//----------GENERATE NEW PURCHASE ORDER ENTRY----------START
function build_generate_new_po_entry_form($po_id=null, $item=array()){
	$CI =& get_instance();
	$user = $CI->session->userdata('user');

	$CI->make->sForm("",array('id'=>'po_entry_form'));
	
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
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
			$CI->make->sDivCol(12,'right', 0, array());
					$CI->make->hidden('hidden_user',$user['id']);
					$CI->make->hidden('form_mode', 'add');
					// $CI->make->hidden('hidden_po_order_no', ($po_id == '' ? '' : $po_id));
					$CI->make->hidden('hidden_po_order_no', $po_id);
					$CI->make->hidden('reference', $item->reference);
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save_po_btn', 'style'=>' margin-right: 10px; margin-left: 10px;'),'primary');
					$CI->make->A(fa('fa-reply').' Go Back','',array('id'=>'back-btn','class'=>'btn'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		//-----HEADER PART A-----START
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->H(4,"P.O. Header",array('style'=>'margin-top:0px;margin-bottom:0px;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->branchesMasterDrop('Branch','branch_id',$item->branch_id,'Select Branch',array('class'=>'rOkay combobox branch_dropdown reqForm'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->supplierMasterDrop('Supplier','supplier_id',$item->supplier_id,'Select Supplier',array('class'=>'rOkay combobox reqForm'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Order Date','ord_date',date('m/d/Y', strtotime($item->ord_date)),'',array('class'=>'rOkay reqForm'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->stockLocationDrop('Stock Location','stock_location',$item->into_stock_location,null,array('class'=>'rOkay stock_location_dropdown reqForm'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Delivery Date','delivery_date',date('m/d/Y', strtotime($item->delivery_date)),'',array('class'=>'rOkay reqForm'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->textarea('Delivery Address','delivery_address',$item->delivery_address,'', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255;', 'class'=>'reqForm')); //-----Address ng Branch selected
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->textarea('Remarks','comments',$item->comments,'', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255', 'class'=>'reqForm'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		//-----HEADER PART A-----END
		
		$CI->make->sDivRow();
			//-----LINE ITEM ADDER-----START
			$CI->make->sDivCol(5);
				$CI->make->sBox('warning');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->H(4,"Add P.O. Line Item",array('style'=>'margin-top:0px;margin-bottom:0px;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->supplierStocksDrop('Stock','stock_id',null,'Select Item',array('class'=>'combobox supp_stock_drop forms this_item'));
								$CI->make->hidden('hidden_stock_id','');
								$CI->make->hidden('stock_desc','');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								$CI->make->input('Quantity','quantity_ordered',null,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->stockUOMCodeDrop('UOM','uom','','Select UOM',array('class'=>'rOkay reqForm'));
								$CI->make->hidden('uom_qty','');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Unit Cost','unit_cost','',null,array('class'=>'formInput', 'readonly'=>'readonly'));
								$CI->make->hidden('hidden_unit_cost','');
							$CI->make->eDivCol();
						$CI->make->eDivRow();	
						
						//-----STOCK DISCOUNTS-----START
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Discount # 1','discount1','','',array('class'=>'disc1 supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->discountTypeDrop('Type','disc_type1','','Select Discount Type',array('class'=>'disc_type1_drop supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Discount # 2','discount2','','',array('class'=>'disc2 supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->discountTypeDrop('Type','disc_type2','','Select Discount Type',array('class'=>'disc_type2_drop supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Discount # 3','discount3','','',array('class'=>'disc3 supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->discountTypeDrop('Type','disc_type3','','Select Discount Type',array('class'=>'disc_type3_drop supp_req_form', 'old_val'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();	
						//-----STOCK DISCOUNTS-----END
						
						$CI->make->sDivRow();	
							$CI->make->sDivCol(8);
								$CI->make->hidden('hidden_disc_unit_cost','');
								$CI->make->input('TOTAL','total','',null,array('class'=>'formInput', 'readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->hidden('total_amount','');
								$CI->make->button(fa('fa-plus').'',array('id'=>'add_btn', 'style'=>' margin-top: 25px;'),'primary');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			//-----LINE ITEM ADDER-----END
			
			//-----LINE ITEMS-----START
			$CI->make->sDivCol(7);
				$CI->make->sDiv(array('id'=>'line_item_contents'));
				$CI->make->eDiv();
			$CI->make->eDivCol();
			//-----LINE ITEMS-----END
		$CI->make->eDivRow();
		
	$CI->make->eForm();
	
	return $CI->make->code();
}
function build_generate_purch_order_details_list_form($item=array(), $stock_id=null){
	$CI =& get_instance();
	
	$CI->make->sDivCol(12,'center',0,array("style"=>''));
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
									$CI->make->th('&nbsp;',array('style'=>''));
								$CI->make->eRow();
								foreach($item as $val){
									$link = "";
									$link .= $CI->make->A(fa('fa-trash fa-lg fa-fw'), '', array(
									'class'=>'del_this_item',
									'ref'=>$val->line_id,
									'ref_desc'=>$val->description,
									'title'=>'Delete this item?',
									'style'=>'cursor: pointer;',
									'return'=>'false'));
									$CI->make->sRow();
											$CI->make->td("[ ".$val->stock_id." ] ".$val->description);	
											$CI->make->td($val->qty_ordered);	
											$CI->make->td($val->uom);	
											$CI->make->td($val->unit_cost);	
											$CI->make->td($val->qty_ordered * $val->unit_cost);	
											$CI->make->td($link,array('style'=>''));
										$CI->make->eRow();
								}
							$CI->make->eTable();
						$CI->make->eDiv();
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivCol();
	
	return $CI->make->code();
}
//----------GENERATE NEW PURCHASE ORDER ENTRY----------END
