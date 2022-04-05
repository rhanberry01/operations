<?php
function salesOrderForm($list=null,$access=array(),$navs=array()){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							 // $CI->make->A(fa('fa-download').' New Sales Order Entry',base_url().'receiving/form',array('class'=>'btn btn-primary'));
							 $CI->make->A(fa('fa-download').' New Sales Order Entry',base_url().'sales/newSOForm',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Order #'=>'',
									'Customer'=>'',
									'Branch'=>'',
									'Cust Order #'=>'',
									'Order Date'=>'',
									' '=>'',
									' '=>array('width'=>'12%','align'=>'right'));
							$rows = array();
							foreach($list as $res){
								$links = "";
								$rows[] = array(
											  sql2Date($res->reg_date),
											  $res->trans_ref,
											  $res->supplier_name,
											  $res->reference,
											  $res->username,
											  $links
									);
							}
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function soFormPage($list=array()){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol(3);
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sForm("receiving/add_item",array('id'=>'add_item_form'));
						$CI->make->input('Item','item-search',null,'Search Item',array('search-url'=>'mods/search_items','class'=>'rOkay'),'',fa('fa-search'));
						$CI->make->hidden('item-id',null);
						$CI->make->hidden('item-uom',null);
						$CI->make->hidden('item-ppack',null);
						$CI->make->hidden('item-pcase',null);
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->decimal('Quantity','qty',null,null,array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								// $CI->make->select('&nbsp;','select-uom',array(),null,array('class'=>'rOkay'));
								$CI->make->stockUOMDrop('UOM','uom',iSetObj($list,'debtor'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->input('Price','cost',null,null,array());
						$CI->make->input('Discount','discount',null,null,array());
						$CI->make->input('Client Code','client_code',null,null,array());
						// $CI->make->locationsDrop('Receiving Location','loc_id',null,null,array('shownames'=>true));
						$CI->make->button(fa('fa-plus').' Add Item',array('class'=>'btn-block','id'=>'add-item-btn'),'primary');
					$CI->make->eForm();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		#FORM
		$CI->make->sDivCol(9);
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sForm("receiving/save",array('id'=>'receive_form'));
						$CI->make->sDivRow();
							// $CI->make->sDivCol(2);
							// 	$CI->make->input('Reference','reference',null,'Supplier reference',array());
							// $CI->make->eDivCol();
							$CI->make->sDivCol(6);
								// $CI->make->suppliersDrop('Supplier','suppliers',null,null,array());
								$CI->make->debtorMasterDrop('Supplier','debtor',iSetObj($list,'debtor'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
							// 	$CI->make->input('Remarks','memo',null,'Notes',array());
								$CI->make->debtorBranchDrop('Branch','branch',iSetObj($list,'branch'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(2,'right');
								$CI->make->button(fa('fa-download').' Place Order',array('id'=>'save-btn','style'=>'margin-top:25px'),'primary');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->date('Order Date','order_date',null,'Order Date',array());
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->date('Required Delivery Date','required_delivery_date',null,'Delivery Date',array());
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input('Contact Phone #','del_location',null,'Contact No.',array());
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input('Customer Reference','del_location',null,'Cust. Ref.',array());
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Comments','comments',null,null,array());
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->shipperDrop('Shipping Company','branch',iSetObj($list,'shipper'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input('Shipping Charge','shipping_charge',null,null,array());
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
									$CI->make->sRow();
										$CI->make->th('ITEM<br>CODE');
										$CI->make->th('ITEM');
										$CI->make->th('QTY');
										$CI->make->th('UNIT');
										$CI->make->th('PRICE');
										$CI->make->th('QTY ON HAND',array('style'=>'width:60px;'));
										$CI->make->th('DSC%',array('style'=>'width:60px;'));
										$CI->make->th('CLIENT CODE',array('style'=>'width:60px;'));
										$CI->make->th('&nbsp;',array('style'=>'width:40px;'));
									$CI->make->eRow();
								$CI->make->eTable();
								$CI->make->eDiv();
							$CI->make->eDivCol();
						$CI->make->eDivRow();
							// $CI->make->button(
							// fa('fa-save').' Save Adjustments'
							// , array('class'=>'btn-block','id'=>'save-trans','style'=>'margin-top:10px','disabled'=>'disabled')
							// , 'primary');
					$CI->make->eForm();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();


	$CI->make->eDivRow();

	return $CI->make->code();
}

// View Finished Sales
function checkSalesForm($user_branch){

	$CI =& get_instance();
	
	$CI->make->sBox('primary');
				$CI->make->sBoxBody();

	
	$CI->make->sDivRow();
				// $CI->make->sDivCol(3);
				// 	$CI->make->BranchesDrop('Branches','branch',null,'',array('style'=>' margin-left:13px;width:97.3%','class'=>'rOkay '));
				// $CI->make->eDivCol();
				$CI->make->sDivCol(2);
					$CI->make->datefield('Date From:','from_date',date('m/d/Y'),'',array('style' => 'width:100%','class'=>'rOkay' ));
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
					$CI->make->datefield('Date To:','t_date',date('m/d/Y'),'',array('style' => 'width:100%','class'=>'rOkay' ));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->input('ProductID','barcode','','',array('class'=>'barcodetracker','style'=>'position:initial; width:260px'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(5);
					$CI->make->hidden('user_branch',$user_branch);
					$CI->make->A(fa('fa-search').'Search','#',array('id'=>'search' ,'style'=>' margin-top: 24px;margin-right:0px;','class'=>'btn btn-flat btn-md btn-success'));
					$CI->make->A(fa('fa-download').'Export To Excel','#',array('id'=>'print_excel_btn' ,'style'=>' margin-top: 24px;margin-left: 25px;','class'=>'btn btn-flat btn-md btn-success'));
				$CI->make->eDivCol();
	$CI->make->eDivRow();

	$CI->make->sDivRow();
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
	$CI->make->eDivRow();

	$CI->make->sDivRow();
				$CI->make->sDivCol();
				$CI->make->eDivCol();
	$CI->make->eDivRow();



	$CI->make->sDiv(array('id'=>'finishedsales_data'));
					$CI->make->hidden('ref');
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
											$CI->make->th("lineID",array('style'=>''));
											$CI->make->th("Transaction No",array('style'=>''));	
											$CI->make->th("Barcode",array('style'=>''));
											$CI->make->th('Description.',array('style'=>''));
											$CI->make->th('UOM',array('style'=>''));
											$CI->make->th('Qty',array('style'=>''));
											$CI->make->th('Packing',array('style'=>''));
											$CI->make->th('TotalQty',array('style'=>''));
											$CI->make->th('AverageUnitCost',array('style'=>''));
											$CI->make->th('LandedCost',array('style'=>''));
											$CI->make->th('Price',array('style'=>''));
											$CI->make->th('Extended',array('style'=>''));
											$CI->make->th('PriceModeCode',array('style'=>''));
											$CI->make->th('UserID',array('style'=>''));
											$CI->make->th('Price Override',array('style'=>''));
											$CI->make->th('TerminalNo',array('style'=>''));
											$CI->make->th('LogDate',array('style'=>''));
										$CI->make->eRow();
									$CI->make->eTable();
								$CI->make->eDiv();
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eDiv();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	$CI->make->eBoxBody();

	return $CI->make->code();

}

function finishedsales_data_result($item=array(),$user_branch=null){
	$CI =& get_instance();
	$CI->make->sForm('',array('id'=>'search_form99'));
	$CI->make->sDivCol(12,'center',0,array('style'=>'margin-left:10px;'));
			$CI->make->sBoxBody();
			$CI->make->sDivCol();
				$CI->make->eDivCol();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:300px;overflow-y:scroll;'));
						
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									
											$CI->make->th("lineID",array('style'=>''));
											$CI->make->th("ProductCode",array('style'=>''));
											$CI->make->th("Transaction No",array('style'=>''));
											$CI->make->th("Barcode",array('style'=>''));
											$CI->make->th('Description.',array('style'=>''));
											$CI->make->th('UOM',array('style'=>''));
											$CI->make->th('Qty',array('style'=>''));
											$CI->make->th('Packing',array('style'=>''));
											$CI->make->th('TotalQty',array('style'=>''));
											$CI->make->th('AverageUnitCost',array('style'=>''));
											$CI->make->th('LandedCost',array('style'=>''));
											$CI->make->th('Price',array('style'=>''));
											$CI->make->th('Extended',array('style'=>''));
											$CI->make->th('PriceModeCode',array('style'=>''));
											$CI->make->th('UserID',array('style'=>''));
											$CI->make->th('Price Override',array('style'=>''));
											$CI->make->th('TerminalNo',array('style'=>''));
											$CI->make->th('LogDate',array('style'=>''));$CI->make->th('Return',array('style'=>''));$CI->make->th('Voided',array('style'=>''));


								$CI->make->eRow();
								foreach($item as $val){

									$CI->make->sRow();
										$CI->make->td($val->lineID, array('style'=>'width:-20px;'));
										$CI->make->td($val->ProductCode, array('style'=>'width:-20px;'));					
										$CI->make->td($val->TransactionNo, array('style'=>'width:-20px;')); 
										$CI->make->td($val->Barcode, array('style'=>'width:-20px;'));
										$CI->make->td($val->Description, array('style'=>'width:-20px;'));
										$CI->make->td($val->UOM, array('style'=>'width:-20px;'));
										$CI->make->td($val->Qty, array('style'=>'width:-20px;'));
										$CI->make->td($val->Packing, array('style'=>'width:-20px;'));
										$CI->make->td($val->TotalQty, array('style'=>'width:-20px;'));
										$CI->make->td($val->AverageUnitCost, array('style'=>'width:-20px;'));
										$CI->make->td($val->LandedCost, array('style'=>'width:-20px;'));
										$CI->make->td($val->Price, array('style'=>'width:-20px;'));
										$CI->make->td($val->Extended, array('style'=>'width:-20px;'));
										$CI->make->td($val->PriceModeCode, array('style'=>'width:-20px;'));
                                        $userc = $CI->sales_model->get_cashier_user($user_branch,$val->UserID); 
										$CI->make->td($userc, array('style'=>'width:-20px;'));
										$CI->make->td($val->PriceOverride, array('style'=>'width:-20px;'));
										$CI->make->td($val->TerminalNo, array('style'=>'width:-20px;'));
										$CI->make->td($val->LogDate, array('style'=>'width:-20px;'));
										$CI->make->td($val->return, array('style'=>'width:-20px;'));
										$CI->make->td($val->voided, array('style'=>'width:-20px;'));
									$CI->make->eRow();
								}
							$CI->make->eTable();
						$CI->make->eDiv();
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		
	$CI->make->eDivCol();
	$CI->make->eForm();
	

	return $CI->make->code();
}
// View Finished Sales


//-----------SALES PERSONS-----APM-----START
function salesPersonsForm($sales_persons=null){
	$CI =& get_instance();

	$CI->make->sForm("core/sales/sales_persons_db",array('id'=>'sales_persons_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->hidden('sales_person_id',iSetObj($sales_persons,'sales_person_id'));
					$CI->make->input('Name','name',iSetObj($sales_persons,'name'),'Name of Sales Person',array('class'=>'rOkay'));
					$CI->make->input('Phone Number','phone',iSetObj($sales_persons,'phone'),'Phone number',array()); //orig
					$CI->make->input('Fax Number','fax',iSetObj($sales_persons,'fax'),'Fax Number',array());
					$CI->make->input('Email Address','email',iSetObj($sales_persons,'email'),'Email Address',array());
					$CI->make->input('Commission','provision_1',(isset($sales_persons->provision_1) ? $sales_persons->provision_1 : '0'),'Commission Percentage',array('class'=>'rOkay numbers-only'),'','%');
					$CI->make->input('Break Pt','break_pt',(isset($sales_persons->break_pt) ? $sales_persons->break_pt : '0'),'Break Point',array('class'=>'rOkay numbers-only'));
					$CI->make->input('Commission 2','provision_2',(isset($sales_persons->provision_2) ? $sales_persons->provision_2 : '0'),'Commission 2 Percentage',array('class'=>'rOkay numbers-only'),'','%');
					$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($sales_persons,'inactive'),'',array());
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
//-----------SALES PERSONS-----APM-----END
//-----------CREDIT STATUS-----APM-----START
function creditStatusForm($credit_status=null){
	$CI =& get_instance();

	$CI->make->sForm("core/sales/credit_status_db",array('id'=>'credit_status_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->hidden('credit_status_id',iSetObj($credit_status,'credit_status_id'));
					$CI->make->input('Status Code','status_code',iSetObj($credit_status,'status_code'),'Type Code',array('class'=>'rOkay reqForm'));
					$CI->make->input('Description','description',iSetObj($credit_status,'description'),'Type Description',array('class'=>'rOkay reqForm')); //orig
					$CI->make->inactiveDrop('Dissallow invoicing?','disallow_invoice',iSetObj($credit_status,'disallow_invoice'),'',array());
					$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($credit_status,'inactive'),'',array());
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
//-----------CREDIT STATUS-----APM-----END
//***********JED**********************
function salesTypeForm($sales_type=null){
	$CI =& get_instance();

	$CI->make->sForm("core/sales/sales_type_db",array('id'=>'sales_type_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->hidden('id',iSetObj($sales_type,'id'));
					$CI->make->input('Sales Type Name','sales_type',iSetObj($sales_type,'sales_type'),'Name of Sales Type',array('class'=>'rOkay'));
					$CI->make->checkbox('Tax Included','tax_included',(iSetObj($sales_type,'tax_included') == 0 ? 0 : 1),array('class'=>''),(iSetObj($sales_type,'tax_included') == 0 ? 0 : 1));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
//****************JED END**************************
//**********SO ENTRY*****Allyn*****start
function salesOrderHeaderPage($so_id=null){
	$CI =& get_instance();
	$CI->make->hidden('_main_so_id',$so_id);
	// $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			// $CI->make->sDivCol(12,'right');
				// $CI->make->A(fa('fa-reply').' Go Back To list',base_url().'sales_order_form',array('class'=>'btn btn-primary'));
			// $CI->make->eDivCol();
		// $CI->make->eDivRow();
	// $CI->make->sDivRow();
	// sDivCol($length="12",$align="left",$offset=0,$params=array(),$return=false)
		$CI->make->sDivCol(12,'left',0,array('id'=>'div-so-steps'));
			$CI->make->H(3,'Sales Order');
			$CI->make->append('<section id="frm-so-header" data-mode="async" data-url="'.base_url().'sales/details_load'.($so_id ? '/'.$so_id : '').'" style="overflow-x:hidden;overflow-y:scroll;"></section>');
			// $CI->make->append('<section data-mode="async" data-url="'.base_url().'sales/link/1'.'" style="overflow-x:hidden;overflow-y:scroll;"></section>');
			$CI->make->H(3,'Sales Order Details');
			$CI->make->append('<section id="frm-so-items" data-mode="async" data-url="'.base_url().'sales/so_items_load'.($so_id ? '/'.$so_id : '').'" style="overflow-y:scroll;"></section>');

			$CI->make->H(3,'Delivery');
			$CI->make->append('<section id="frm-so-dispatch" data-mode="async" data-url="#" style="overflow-y:scroll;"></section>');
			// $CI->make->sSection(array('data-mode'=>'async','data-url'=>'sales/details_load'));
			// $CI->make->eSection();
			// $CI->make->sTab();
			// 		$tabs = array(
			// 			fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'sales/details_load/','id'=>'details_link'),
			// 			fa('fa-book')." Items"=>array('href'=>'#so_items','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'sales/so_items_load/','id'=>'so_items_link'),
			// 		);
			// 		$CI->make->hidden('so_id',$so_id);
			// 		$CI->make->tabHead($tabs,null,array());
			// 		$CI->make->sTabBody();
			// 			$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
			// 			$CI->make->eTabPane();
			// 			$CI->make->sTabPane(array('id'=>'so_items','class'=>'tab-pane'));
			// 			$CI->make->eTabPane();
			// 		$CI->make->eTabBody();
			// 	$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function salesOrderHeaderPage_($so_id=null){
	$CI =& get_instance();
	// $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			// $CI->make->sDivCol(12,'right');
				// $CI->make->A(fa('fa-reply').' Go Back To list',base_url().'sales_order_form',array('class'=>'btn btn-primary'));
			// $CI->make->eDivCol();
		// $CI->make->eDivRow();
	// $CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'sales/details_load/','id'=>'details_link'),
						fa('fa-book')." Items"=>array('href'=>'#so_items','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'sales/so_items_load/','id'=>'so_items_link'),
					);
					$CI->make->hidden('so_id',$so_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'so_items','class'=>'tab-pane'));
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function soHeaderDetailsLoad($so=null,$so_id=null,$reference){
	$CI =& get_instance();

		$CI->make->sForm("sales/so_header_details_db",array('id'=>'so_header_details_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					$CI->make->hidden('form_mod_id',$so_id);
					$CI->make->customersDrop('Customer','debtor_id',iSetObj($so,'debtor_id'), '', array('class'=>'rOkay'));
					$CI->make->customerBranchesDrop('Branch','debtor_branch_id',iSetObj($so,'debtor_branch_id'), 'select', array('class'=>''));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					if (iSetObj($so,'reference')) {
						$CI->make->input('Reference','reference',$so->reference,'Type Reference',array('class'=>'rOkay','readOnly'=>'readOnly'));
					} else {
						$CI->make->input('Reference','reference',$reference,'Type Reference',array('class'=>'rOkay'));
					}
					$CI->make->salesTypesDrop('Price List','sales_type',iSetObj($so,'sales_type'), '', array('class'=>'rOkay'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->datefield('Order Date','order_date',(iSetObj($so,'order_date') ? sql2Date(iSetObj($so,'order_date')) : date('m/d/Y')),'',array());
					$CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();


			$CI->make->sDivRow(array('style'=>'margin:0;'));
				$CI->make->sBox('success');
					$CI->make->sBoxHead();
						$CI->make->boxTitle('Order Delivery Details');
					$CI->make->eBoxHead();
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								// $CI->make->input('Deliver from Location','from_loc',iSetObj($so,'from_loc'),'Type Location Here',array('class'=>'rOkay'));
								$CI->make->inventoryLocationsDrop('Deliver from Location','from_loc',iSetObj($so,'from_loc'), '', array('class'=>'rOkay'));
								$CI->make->datefield('Required Delivery Date','delivery_date',(iSetObj($so,'delivery_date') ? sql2Date(iSetObj($so,'delivery_date')) : date('m/d/Y')),'',array());
								$CI->make->input('Deliver To','deliver_to',iSetObj($so,'deliver_to'),'Type Name',array('class'=>''));
								// $CI->make->input('Address','delivery_address',iSetObj($so,'delivery_address'),'',array('class'=>'rOkay'));
								$CI->make->textarea('Address','delivery_address',iSetObj($so,'delivery_address'),'Type Address',array('class'=>'rOkay','style'=>'resize:vertical;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->input('Customer Reference','customer_ref',iSetObj($so,'customer_ref'),'Type Reference',array('class'=>''));
								// $CI->make->input('Comments','remarks',iSetObj($so,'remarks'),'',array('class'=>''));
								$CI->make->textarea('Comments','remarks',iSetObj($so,'remarks'),'Type Comments',array('class'=>'rOkay','style'=>'resize:vertical;'));
								// $CI->make->input('Shipping Charge','shipping_cost',(isset($so->shipping_cost) ? $so->shipping_cost : '0'),'Type Cost',array('class'=>'rOkay numbers-only', 'style'=>'width: 30%;'),'','');
								$CI->make->shippingCompDrop('Shipping Company','shipper_id',1,null,array('class'=>'rOkay'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivRow();

			// $CI->make->sDivRow();
				// $CI->make->sDivCol(4,'left',4);
					// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
function soItemsLoad($so_id=null,$det=null,$mod=null){
	$CI =& get_instance();

			$CI->make->sDivRow();
				$CI->make->sDivCol(3);

					$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sForm("sales/so_items_db",array('id'=>'so_items_form'));

								$CI->make->hidden('so_id',$so_id);
								// $CI->make->hidden('order_no',$order_no);
								$CI->make->hidden('item-id',null, array('class'=>'input_form'));
								$CI->make->hidden('item-uom',null, array('class'=>'input_form'));
								$CI->make->hidden('item-price',null, array('class'=>'input_form'));

								$CI->make->itemWithBarcodeListDrop('Item ','item',null,'Select Item',array('class'=>'combobox input_form this_item'));

								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->input('Quantity on Hand','qoh','0',null,array('class'=>'forms','readonly'=>true));
									$CI->make->eDivCol();
								$CI->make->eDivRow();

								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										$CI->make->decimal('Quantity','qty_delivered',null,null,2,array('class'=>'rOkay input_form this_qty'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										$CI->make->select('Unit','select-uom',array(),null,array('class'=>'rOkay input_form','id'=>'select-uom'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();

								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										$CI->make->input('Price','unit_price','0.00',null,array('class'=>'rOkay numbers-only input_form'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										$CI->make->input('Discount','discount_percentage','0.00',null,array('class'=>'rOkay numbers-only input_form'),'','%');
									$CI->make->eDivCol();
									$CI->make->sDivCol();
										$CI->make->input('Client code','client_code','',null,array('class'=>'input_form','maxlength'=>20),'');
									$CI->make->eDivCol();
									$CI->make->sDivCol();
										$CI->make->stockCategoriesWord('Stock Category','stock_category','',null,array('class'=>'rOkay input_form'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();

								$CI->make->button(fa('fa-plus').' Add Item',array('class'=>'btn-block','id'=>'add-item-btn'),'primary');
								$CI->make->button('Add Hardware item',array('class'=>'btn-block','id'=>'add-non-stock-item-btn'),'default');

						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();

				$CI->make->sDivCol(9);
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-striped','id'=>'details-tbl'));
									$CI->make->sRow();
										// $CI->make->th('ITEM');
										// $CI->make->th('QTY',array('style'=>'width:60px;'));
										// $CI->make->th('QTY DELIVERED',array('style'=>'width:60px;'));
										// $CI->make->th('SUBTOTAL',array('style'=>'width:60px;'));
										// $CI->make->th('&nbsp;',array('style'=>'width:40px;'));
										$CI->make->th('CATEGORY',array());
										$CI->make->th('ITEM');
										$CI->make->th('QTY',array());
										$CI->make->th('PRICE',array());
										$CI->make->th('DISCOUNT(%)',array());
										$CI->make->th('SUBTOTAL',array());
										$CI->make->th('&nbsp;',array());
									$CI->make->eRow();
									$total = 0;
									if(count($det) > 0){
										foreach ($det as $res) {
											$CI->make->sRow(array('id'=>'row-'.$res->id));
									            // $CI->make->td("[ ".$res->item_code." ] ".$res->name);
										        $CI->make->td($res->stock_category);
									            $CI->make->td($res->name);
									            $CI->make->td(num($res->qty));
										        $CI->make->td(num($res->unit_price));
										        $CI->make->td($res->discount_percentage);
									            // $CI->make->td(num($res->unit_price * $res->qty));
									            $CI->make->td(num($res->line_total));
									            $a = $CI->make->A(fa('fa-trash-o fa-fw fa-lg'),'#',array('id'=>'del-'.$res->id,'class'=>'dels','ref'=>$res->id,'return'=>true));
									            $CI->make->td($a);
									        $CI->make->eRow();
											$total += $res->unit_price * $res->qty;
										}
									}
								$CI->make->eTable();
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eForm();
	return $CI->make->code();
}
//**********SO ENTRY*****Allyn*****end
//**********Direct Invoice ENTRY*****Allyn*****start
function directInvoiceHeaderPage($so_id=null){
	$CI =& get_instance();
		$CI->make->sDivCol();
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'sales/di_details_load/','id'=>'details_link'),
						fa('fa-book')." Items"=>array('href'=>'#so_items','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'sales/di_items_load/','id'=>'so_items_link'),
					);
					$CI->make->hidden('so_id',$so_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'so_items','class'=>'tab-pane'));
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function diHeaderDetailsLoad($so=null,$so_id=null){
	$CI =& get_instance();

	$next_reference_no = $CI->sales_model->get_next_type_no(SALES_ORDER);

		$CI->make->sForm("sales/so_header_details_db",array('id'=>'so_header_details_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					$CI->make->hidden('form_mod_id',$so_id);
					$CI->make->customersDrop('Customer','debtor_id',iSetObj($so,'debtor_id'), '', array('class'=>'rOkay'));
					$CI->make->customerBranchesDrop('Branch','debtor_branch_id',iSetObj($so,'debtor_branch_id'), 'select', array('class'=>'rOkay'));
					$CI->make->input('Reference','customer_ref',$next_reference_no,'',array('class'=>''));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->salesTypesDrop('Price List','sales_type',iSetObj($so,'sales_type'), '', array('class'=>'rOkay'));
					$CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->datefield('Order Date','order_date',(iSetObj($so,'order_date') ? sql2Date(iSetObj($so,'order_date')) : date('m/d/Y')),'',array());
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();


			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sBox('success');
					$CI->make->sBoxHead();
						$CI->make->boxTitle('Delivery Details');
					$CI->make->eBoxHead();
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Deliver from Location','from_loc',iSetObj($so,'from_loc'),'Type Location Here',array('class'=>'rOkay'));
								$CI->make->datefield('Due Date','delivery_date',(iSetObj($so,'delivery_date') ? sql2Date(iSetObj($so,'delivery_date')) : date('m/d/Y')),'',array());
								$CI->make->input('Deliver To','deliver_to',iSetObj($so,'deliver_to'),'',array('class'=>''));
								$CI->make->input('Address','delivery_address',iSetObj($so,'delivery_address'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->input('Customer Reference','customer_ref',iSetObj($so,'customer_ref'),'',array('class'=>''));
								$CI->make->input('Comments','remarks',iSetObj($so,'remarks'),'',array('class'=>''));
								$CI->make->input('Shipping Charge','shipping_cost',(isset($so->shipping_cost) ? $so->shipping_cost : '0'),'Type Cost',array('class'=>'rOkay numbers-only','readOnly'=>'readOnly', 'style'=>'width: 30%;'),'','');
								$CI->make->shippingCompDrop('Shipping Company','shipper_id',iSetObj($so,'shipper_id'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivRow();

			// $CI->make->sDivRow();
				// $CI->make->sDivCol(4,'left',4);
					// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
function diItemsLoad($so_id=null,$det=null,$mod=null){
	$CI =& get_instance();

			$CI->make->sDivRow();
				$CI->make->sDivCol(3);

					$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sForm("sales/so_items_db",array('id'=>'so_items_form'));

								$CI->make->hidden('so_id',$so_id);
								// $CI->make->hidden('order_no',$order_no);
								$CI->make->hidden('item-id',null, array('class'=>'input_form'));
								$CI->make->hidden('item-uom',null, array('class'=>'input_form'));

								$CI->make->itemListDrop('Item ','item',null,'Select Item',array('class'=>'combobox input_form'));

								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										$CI->make->input('Quantity','qty_delivered',null,null,array('class'=>'rOkay input_form'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										$CI->make->select('Unit','select-uom',array(),null,array('class'=>'rOkay input_form','id'=>'select-uom'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();

								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										$CI->make->input('Price','unit_price',null,null,array('class'=>'rOkay input_form'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										$CI->make->input('Discount','discount_percentage',null,null,array('class'=>'rOkay numbers-only input_form'),'','%');
									$CI->make->eDivCol();
								$CI->make->eDivRow();


								$CI->make->button(fa('fa-plus').' Add Item',array('class'=>'btn-block','id'=>'add-item-btn'),'primary');

						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();

				$CI->make->sDivCol(9);
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-striped','id'=>'details-tbl'));
									$CI->make->sRow();
										// $CI->make->th('ITEM');
										// $CI->make->th('QTY',array('style'=>'width:60px;'));
										// $CI->make->th('QTY DELIVERED',array('style'=>'width:60px;'));
										// $CI->make->th('SUBTOTAL',array('style'=>'width:60px;'));
										// $CI->make->th('&nbsp;',array('style'=>'width:40px;'));
										$CI->make->th('ITEM');
										$CI->make->th('QTY',array());
										$CI->make->th('PRICE',array());
										$CI->make->th('DISCOUNT(%)',array());
										$CI->make->th('SUBTOTAL',array());
										$CI->make->th('&nbsp;',array());
									$CI->make->eRow();
									$total = 0;
									if(count($det) > 0){
										foreach ($det as $res) {
											$CI->make->sRow(array('id'=>'row-'.$res->id));
									            // $CI->make->td("[ ".$res->item_code." ] ".$res->name);
									            $CI->make->td($res->name);
									            $CI->make->td(num($res->qty));
										        $CI->make->td(num($res->unit_price));
										        $CI->make->td($res->discount_percentage);
									            // $CI->make->td(num($res->unit_price * $res->qty));
									            $CI->make->td(num($res->line_total));
									            $a = $CI->make->A(fa('fa-trash-o fa-fw fa-lg'),'#',array('id'=>'del-'.$res->id,'class'=>'dels','ref'=>$res->id,'return'=>true));
									            $CI->make->td($a);
									        $CI->make->eRow();
											$total += $res->unit_price * $res->qty;
										}
									}
								$CI->make->eTable();
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eForm();
	return $CI->make->code();
}
//**********Direct Invoice ENTRY*****Allyn*****end
//**********CUSTOMER PAYMENT ENTRY*****Allyn*****start
function custPaymentHeaderPage($so_id=null){
	$CI =& get_instance();
		$CI->make->sDivCol();
			$CI->make->sTab(array('style'=>'min-height:'));
					$tabs = array(
						fa('fa-info-circle')." Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'sales/cust_payment_details_load/','id'=>'details_link'),
						// fa('fa-book')." Items"=>array('href'=>'#so_items','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'sales/so_items_load/','id'=>'so_items_link'),
					);
					$CI->make->hidden('so_id',$so_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						// $CI->make->sTabPane(array('id'=>'so_items','class'=>'tab-pane'));
						// $CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function cpHeaderDetailsLoad($so=null,$so_id=null,$next_ref){
	$CI =& get_instance();
		$CI->make->sForm("sales/process_customer_payment",array('id'=>'so_header_details_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(6);
					$CI->make->hidden('form_mod_id',$so_id);

					$CI->make->customersDrop('From Customer','debtor_id',iSetObj($so,'debtor_id'), '', array('class'=>'rOkay'));
					$CI->make->customerBranchesDrop('Branch','debtor_branch_id',iSetObj($so,'debtor_branch_id'), 'select', array('class'=>'rOkay'));
					$CI->make->bankAccountsDrop('Into Bank Account','into_bank_acct','', '', array('class'=>'rOkay'));
					$CI->make->input('Reference','reference',$next_ref,'Type Reference',array('class'=>'','maxlength'=>'20'));
					$CI->make->textarea('Memo','memo','','Type Memo',array('maxlength'=>'255','class'=>''));
					// $CI->make->input('Amount of Discount','amount_discount','0','',array('style'=>'', 'class'=>'rOkay numbers-only'));
				$CI->make->eDivCol();

				$CI->make->sDivCol(6);
					// $CI->make->input('Customer Prompt Payment Discount','discount_percentage','0 %',null,array('class'=>'', 'disabled'=>'', 'style'=>'width: 30%;'));
					$CI->make->input('Amount','amount','0','',array('style'=>'', 'class'=>'rOkay numbers-only'));
					$CI->make->datefield('Date of Deposit / Collection Date','order_date', date('m/d/Y'),'',array());
					$CI->make->bankPaymentTypeDrop('Type','bank_payment_type','', '', array('class'=>'rOkay'));
					// $CI->make->sDiv(array('id'=>'div-chk-dep'));
					$CI->make->sDiv(array('id'=>'div-chk-dep','style'=>'display:none;'));
						$CI->make->input('Bank','bnk_chk_dep','','',array('class'=>'rOkay','maxlength'=>'50'));
						$CI->make->input('Branch','bch_chk_dep','','',array('class'=>'rOkay','maxlength'=>'50'));
						$CI->make->input('Cheque Number','chk_no_chk_dep','','',array('class'=>'rOkay','maxlength'=>'50'));
						$CI->make->datefield('Cheque Date','chk_dte_chk_dep', date('m/d/Y'),'',array('class'=>'rOkay'));
					$CI->make->eDiv();
				$CI->make->eDivCol();

				// $CI->make->sDivCol(4);
					// $CI->make->input('Memo','memo','','',array('class'=>'rOkay'));
					// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader', 'style'=>'float: right;'),'primary');
				// $CI->make->eDivCol();
			$CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
//**********CUSTOMER PAYMENT ENTRY*****Allyn*****end
/* Sales Order Inquiry */
/* Author: Caleb */
function build_sales_order_inquiry($status=null)
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("sales/so_inquiry_results/".$status,array('id'=>'sales_order_search_form'));
						// $CI->make->sDivCol(3);
							// $CI->make->select('Reference','type_no',array(),$value=null,array('class'=>'selectize'));
				// 			$CI->make->append('<div class="control-group">
				// 	<label for="select-beast">Beast:</label>
				// 	<select id="select-beast" class="demo-default" placeholder="Select a person...">
				// 		<option value="">Select a person...</option>
				// 		<option value="4">Thomas Edison</option>
				// 		<option value="1">Nikola</option>
				// 		<option value="3">Nikola Tesla</option>
				// 		<option value="5">Arnold Schwarzenegger</option>
				// 	</select>
				// </div>');
						// $CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->customersDrop('Customer','debtor_id','','Select a customer',array('class'=>'combobox rOkay'));
						$CI->make->eDivCol();
						// $CI->make->sDivCol(3,'left',0,array('id'=>'cust-branch-div'));
							// $CI->make->customerBranchesDrop('Customer Branch','debtor_branch_id','','Select customer branch',array('class'=>''));
						// $CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Date range','daterange',date('m/d/Y',strtotime('-1 month')).' to '.date('m/d/Y'),'',array('class'=>'rOkay daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->userDrop('Created By','person_id','','Select User',array('class'=>'combobox'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(1,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
							$CI->make->A(fa('fa-search').' Search for sales orders','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:right'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Sales Order Inquiry",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
}

function build_so_display($list,$status=null)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Order #' => array('width'=>'10%'),
					'Branch Name' => array('width'=>'20%'),
					'Order Date' => array('width'=>'10%'),
					'Required By' => array('width'=>'10%'),
					'Order Total' => array('width'=>'12%'),
					'Has Underpriced' => array('width'=>'6%'),
					'Status' => array('width'=>'8%'),
					'Created By' => array('width'=>'15%'),
					' ' => array('width'=>'9%'),
					);
				$rows = array();
				foreach ($list as $val) {
					// filter rows based on status
					if (!strcasecmp($val->status,$status)) {}
					elseif (!strcasecmp($status, 'approved')) {
						if (!$val->status && $val->underpriced_count)
							continue;
					} else {
						continue;
					}
					// opt
					$opt = array();

					// Status
					$status_text = array('text'=>ucfirst($val->status),'params'=>array('style'=>'text-align:center;font-size:inherit;'));
					$style = "label ";
					if ((!$val->status || !strcasecmp($val->status, 'pending'))) {
						$status_text['text'] = 'Pending';
						$style .= "label-default";

						if (!strcasecmp($status, 'approved') || !strcasecmp($status, 'on delivery') ) {
							if (!$val->underpriced_count) {
								$opt[] = 'delivery';
							}
						} else {
							$opt[] = 'edit';
							$opt[] = 'remove';

							if ($val->underpriced_count) {
								$opt[] = 'approval';
							}
						}

					} elseif (!strcasecmp($val->status, 'approved')) {
						$style .= "label-info";
						$opt[] = 'delivery';
						$opt[] = 'complete';
					} elseif (!strcasecmp($val->status, 'on delivery')) {
						$style .= "label-success";
						$opt[] = 'delivery';
						$opt[] = 'complete';
					}

					$status_text['text'] = '<span class="'.$style.'" style="font-size:95%;">'.$status_text['text'].'</span>';

					// Options
					$link = "";
					if (in_array('edit', $opt))
						$link = $CI->make->A(
								fa('fa-pencil fa-2x fa-fw'),
								base_url().'sales/sales_order_form/'.$val->order_no,
								array('return'=>'true',
									'title'=>'Edit this sales order')
							);

					if (in_array('approval', $opt))
						$link .= $CI->make->A(
								fa('fa-thumbs-o-up fa-2x fa-fw'),
								'#',
								array(
									'ref' => $val->type_no,
									'return'=>'true',
									'title'=>'Approve this sales order',
									'class'=>'lnk-approve-so')
							);

					if (in_array('remove', $opt))
						$link .= $CI->make->A(
								fa('fa-thumbs-o-down fa-2x fa-fw'),
								'#',
								array(
									'ref' => $val->type_no,
									'return'=>'true',
									'title'=>'Cancel this sales order',
									'class'=>'lnk-decline-so')
							);

					if (in_array('delivery', $opt)) {
						$link .= $CI->make->A(
								fa('fa-truck fa-2x fa-fw'),
								base_url().'sales/order_dispatch/'.$val->order_no,
								array(
									'ref' => $val->order_no,
									'return'=>'true',
									'title'=>'Dispatch sales order delivery',
									'class'=>'lnk-deliver-so')
							);
						$link .= $CI->make->A(
								fa('fa-flag-checkered fa-2x fa-fw'),
								'#',
								array(
									'ref' => $val->type_no,
									'return'=>'true',
									'title'=>'Complete this sales order',
									'class'=>'lnk-complete-so')
							);
					}
					$rows[] = array(
							$val->reference,
							$val->branch_name,
							// $val->delivery_address,
							$val->order_date,
							$val->delivery_date,
							array('text'=>number_format($val->order_total,2),'params'=>array('style'=>'text-align:right')),
							($val->underpriced_count ? 'YES' : 'NO' ),
							$status_text,
							$val->fname." ".$val->lname,
							array('text'=>$link,'params'=>array('style'=>'text-align:center'))
						);
				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}
function build_order_dispatch($next_ref,$order_info,$so_items)
{
	$CI =& get_instance();

	$CI->make->sForm('sales/process_sales_delivery',array('id'=>'delivery_form'));
	$CI->make->sDivRow();
		$CI->make->sDivCol(9);
			$CI->make->sBox('info');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(3);
							$CI->make->input('Delivery Reference','delivery_ref',$next_ref,null,array('style'=>'font-size:15px;','maxlength'=>'50'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->hidden('debtor_id',$order_info->debtor_id);
							$CI->make->input('Customer','customer',$order_info->debtor_name,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(5);
							$CI->make->hidden('debtor_branch_id',$order_info->debtor_branch_id);
							$CI->make->input('Branch Name','branch_name',$order_info->branch_name,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol(3);
							$CI->make->append(
								'<label for="so_ref">For Sales Order</label>
								<a class="form-control" href="#" style="font-size:15px;color:#428bca;background-color:#FAFAFA;margin-bottom:10px;">'.$order_info->reference.'</a>'
							);
							$CI->make->hidden('order_reference',$order_info->reference);
							$CI->make->hidden('order_no',$order_info->order_no);
							$CI->make->hidden('order_trans_type',$order_info->trans_type);
							$CI->make->hidden('order_type_no',$order_info->type_no);
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->input('Sales Type','sales_type',$order_info->sales_type_name,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->input(
								'Invoice required by',
								'invoice_due_date',
								date('m/d/Y',strtotime($order_info->delivery_date)),
								null,
								array('class'=>'pick-date','style'=>'position:initial;'),
								null,
								fa('fa fa-calendar'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol(3);
							$CI->make->inventoryLocationsDrop('Deliver From','from_loc',$order_info->from_loc,'',array());
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->shippingCompDrop('Shipper','shipper_id',$order_info->shipper_id,null,array());
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->input(
								'Delivery Date',
								'delivery_date',
								date('m/d/Y'),
								null,
								array('class'=>'pick-date','style'=>'position:initial;'),
								null,
								fa('fa fa-calendar'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->input('Delivery Address','delivery_address',$order_info->delivery_address,null,array('maxlength'=>255));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->sBox('info');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->input('PR Reference','pr_ref','','Type PR #',array('maxlength'=>'15'));
							$CI->make->input('SI Reference','si_ref','','Type SI #',array('maxlength'=>'15'));
							$CI->make->input('BIR DR Reference','bir_dr_ref','','Type BIR DR #',array('maxlength'=>'15'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('',array('class'=>'table-responsive','style'=>'border-top-color:#7E15FD'));
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					$CI->make->sRow(array(),false);
						$CI->make->th('Item',array('style'=>'width:28%;text-align:center;'));
						$CI->make->th('Ordered',array('style'=>'width:11%;text-align:center;'));
						$CI->make->th('Unit',array('style'=>'width:8%;text-align:center;'));
						$CI->make->th('Delivered',array('style'=>'width:11%;text-align:center;'));
						$CI->make->th('This Delivery',array('style'=>'width:12%;text-align:center;'));
						$CI->make->th('Discount',array('style'=>'width:7%;text-align:center;'));
						$CI->make->th('Price',array('style'=>'width:10%;text-align:center;'));
						$CI->make->th('Total',array('style'=>'width:13%;text-align:center;'));
					$CI->make->eRow();
					foreach ($so_items as $val) {
						$less_discount = ((100 - $val->discount_percentage) / 100);
						$outstanding = $val->order_qty - $val->delivered_qty;
						$init_total = $outstanding * $val->unit_price * $less_discount;
						$link = $CI->make->A('['.$val->item_code.']','#',array('return'=>true));
						$CI->make->sRow();
							$CI->make->td($link.' '.$val->item_name,array('style'=>'padding-top:15px;'));
							$CI->make->td('<span id="ordered-ref['.$val->id.']" value="'.$val->order_qty.'">'.num($val->order_qty).'</span>',
								array('style'=>'text-align:right;padding-top:15px;'));
							$CI->make->td($val->uom_name,array('style'=>'padding-top:15px;'));
							$CI->make->td('<span id="delivered-ref['.$val->id.']" value="'.$val->delivered_qty.'">'.num($val->delivered_qty).'</span>',array('style'=>'text-align:right;padding-top:15px;'));
							if (!$outstanding)
								$CI->make->td(num($outstanding),array('style'=>'text-align:right;padding-top:15px;'));
							else {
								$textbox = $CI->make->decimal('','delivery['.$val->stock_category.']['.$val->stock_id.']',num($outstanding),'',2,
									array('style'=>'text-align:right;padding:4px 8px;margin-bottom:-15px;','class'=>'deliver-qty','ref'=>$val->id,'return'=>true));
								$CI->make->td($textbox);
							}
							$CI->make->td('<span id="disc-ref['.$val->id.']" value="'.$less_discount.'">'.$val->discount_percentage.'%</span>',
								array('style'=>'text-align:right;padding-top:15px;'));
							$CI->make->td('<span id="price-ref['.$val->id.']" value="'.$val->unit_price.'">'.num($val->unit_price).'</span>',
								array('style'=>'text-align:right;padding-top:15px;'));
							$CI->make->td('<span id="total-ref['.$val->id.']" class="total-ref" value="'.$init_total.'">'.num($init_total).'</span>',
								array('style'=>'text-align:right;padding-top:15px;'));
						$CI->make->eRow();
					}
					$CI->make->sRow();
						$CI->make->td('Shipping Cost',array('colspan'=>7,'style'=>'text-align:right;padding-top:15px;'));
						$cost_textbox = $CI->make->decimal('','deliv_shipping_cost',num(0),'',2,array('style'=>'text-align:right;padding:4px 8px;margin-bottom:-15px;','return'=>true));
						$CI->make->td($cost_textbox);
					$CI->make->eRow();
					$CI->make->sRow();
						$CI->make->td('Total Delivery Cost',array('colspan'=>7,'style'=>'text-align:right;padding-top:10px;font-size:24px;'));
						$CI->make->td('<span id="delivery_cost"></span>',array('style'=>'text-align:right;padding-top:10px;font-size:21px;'));
					$CI->make->eRow();
				$CI->make->eTable();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol(9);
			$CI->make->sBox('warning');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->textarea('Remarks','remarks','','',array('maxlength'=>'255','style'=>'resize:vertical;'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		$CI->make->sDivCol(3,'center');
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
						$CI->make->button(fa('fa fa-truck')." Process dispatch",array('class'=>'btn-lg','id'=>'btn-process-dispatch'),'primary');
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	$CI->make->eForm();


	return $CI->make->code();
}
function build_invoice_deliveries()
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("sales/invoice_deliveries_results",array('id'=>'delivery_search_form'));
						$CI->make->sDivCol(3);
							$CI->make->customersDrop('Customer','debtor_id','','Select a customer',array('class'=>'combobox'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Date range','daterange',date('m/d/Y',strtotime('-1 month')).' to '.date('m/d/Y'),'',array('class'=>'rOkay daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(1,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
							$CI->make->A(fa('fa-search').' Search for deliveries','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:right'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Sales Deliveries",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function build_invoice_display($results)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Delivery #' => array('width'=>'10%'),
					'Customer Name' => array('width'=>'16%'),
					'Branch' => array('width'=>'24%'),
					'Deliver To' => array('width'=>'15%'),
					'Delivery Date' => array('width'=>'9%'),
					'Invoice Due Date' => array('width'=>'9%'),
					'Total Cost' => array(),
					' ' => array('width'=>'7%')
					);

				$rows = array();
				foreach($results as $val) {
					$link = "";
					$link = $CI->make->checkbox(null,'check_'.$val->delivery_no,null,array(
						'debtor'=>$val->debtor_id,
						'branch'=>$val->debtor_branch_id,
						'del_no'=>$val->delivery_no,
						'class'=>'invoice-check','return'=>true),false);
					$rows[] = array(
							$val->delivery_ref,
							$val->customer_name,
							$val->customer_branch,
							$val->deliver_to,
							$val->delivery_date,
							$val->invoice_due_date,
							array('text'=>num($val->total_delivery_cost),'params'=>array('style'=>'text-align:right')),
							array('text'=>$link,'params'=>array('style'=>'text-align:center'))
						);
				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->sDivRow();
			$CI->make->sDivCol(12,'right');
				$CI->make->A(fa('fa-newspaper-o').' Create delivery invoice','#',array('class'=>'btn btn-primary','id'=>'btn-create-invoice'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}
function build_customer_invoice($dr_no,$next_ref,$delivery_info,$delivery_items,$delivery_refs)
{
	$CI =& get_instance();

	$CI->make->sForm('sales/process_sales_invoice',array('id'=>'invoice-form'));
	$CI->make->sDivRow();
		$CI->make->sDivCol(9);
			$CI->make->sBox('info');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(4);
							$CI->make->input('Reference #','delivery_ref',$next_ref,null,array('style'=>'font-size:15px;'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(8);
							$CI->make->input('For Delivery Reference/s','_input_delivery_no',implode(', ',$delivery_refs),null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->hidden('delivery_no',implode(', ',$dr_no));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						// $CI->make->sDivCol(3);
						// 	$CI->make->append(
						// 		'<label for="so_ref">For Sales Order</label>
						// 		<a class="form-control" href="#" style="font-size:15px;color:#428bca;background-color:#FAFAFA;margin-bottom:10px;">'.$order_info->type_no.'</a>'
						// 	);
						// 	$CI->make->hidden('order_no',$order_info->order_no);
						// 	$CI->make->hidden('order_type_no',$order_info->type_no);
						// $CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->input('Customer','customer_info',$delivery_info[0]->customer_name,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->hidden('debtor_id',$delivery_info[0]->debtor_id);
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->input('Branch Name','branch_name',$delivery_info[0]->customer_branch,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->hidden('debtor_branch_id',$delivery_info[0]->debtor_branch_id);
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->input('Sales Type','sales_type',$delivery_info[0]->sales_type_name,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->input('Delivery Address','address',$delivery_info[0]->address,null,array('maxlength'=>255));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->sBox('info');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->input('Date','trans_date',date('m/d/Y'),null,array('class'=>'pick-date'),null,fa('fa fa-calendar'));
							$CI->make->input('Due Date','due_date',date('m/d/Y',strtotime('+10 days')),null,array('class'=>'pick-date'),null,fa('fa fa-calendar'));
							$CI->make->input('PR #','pr_ref','',null,array('maxlength'=>'20'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('default',array('class'=>'table-responsive'));
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					$CI->make->sRow(array(),false);
						$CI->make->th('Delivery Ref',array('style'=>'width:10%;text-align:center;'));
						$CI->make->th('Item',array('style'=>'width:30%;text-align:center;'));
						$CI->make->th('Ordered',array('style'=>'width:11%;text-align:center;'));
						$CI->make->th('Unit',array('style'=>'width:8%;text-align:center;'));
						$CI->make->th('Delivered',array('style'=>'width:11%;text-align:center;'));
						$CI->make->th('Discount',array('style'=>'width:7%;text-align:center;'));
						$CI->make->th('Price',array('style'=>'width:10%;text-align:center;'));
						$CI->make->th('Total',array('style'=>'width:13%;text-align:center;'));
					$CI->make->eRow();
					foreach ($delivery_items as $val) {
						$less_discount = ((100 - $val->discount_percentage) / 100);
						$init_total = $val->delivered_qty * $val->unit_price * $less_discount;
						$link = $CI->make->A('['.$val->item_code.']','#',array('return'=>true));
						$CI->make->sRow();
							$CI->make->td($val->delivery_ref,array('style'=>'padding-top:15px;'));
							$CI->make->td($link.' '.$val->item_name,array('style'=>'padding-top:15px;'));
							$CI->make->td('<span id="ordered-ref['.$val->stock_id.']" value="'.$val->order_qty.'">'.num($val->order_qty).'</span>',
								array('style'=>'text-align:right;padding-top:15px;'));
							$CI->make->td($val->uom_name,array('style'=>'padding-top:15px;'));
							$CI->make->td('<span id="delivered-ref['.$val->stock_id.']" value="'.$val->delivered_qty.'">'.num($val->delivered_qty).'</span>',array('style'=>'text-align:right;padding-top:15px;'));
							$CI->make->td('<span id="disc-ref['.$val->stock_id.']" value="'.$less_discount.'">'.$val->discount_percentage.'%</span>',
								array('style'=>'text-align:right;padding-top:15px;'));
							$CI->make->td('<span id="price-ref['.$val->stock_id.']" value="'.$val->unit_price.'">'.num($val->unit_price).'</span>',
								array('style'=>'text-align:right;padding-top:15px;'));
							$CI->make->td('<span id="total-ref['.$val->stock_id.']" class="total-ref" value="'.$init_total.'">'.num($init_total).'</span>',
								array('style'=>'text-align:right;padding-top:15px;'));
						$CI->make->eRow();
					}
					$total_ship = $total_cost = 0;
					foreach ($delivery_info as $key => $val)
					{
						$total_ship += ($val->shipping_cost) ? $val->shipping_cost : 0;
						$total_cost += ($val->total_delivery_cost) ? $val->total_delivery_cost : 0;
					}
					$CI->make->sRow();
						$CI->make->td('Shipping Cost',array('colspan'=>7,'style'=>'text-align:right;padding-top:15px;'));
						$cost_textbox = $CI->make->decimal('','total_ship',num($total_ship),'',2,
							array('style'=>'text-align:right;padding:4px 8px;margin-bottom:-15px;background-color:#FAFAFA;','readOnly'=>'true','return'=>true));
						$CI->make->td($cost_textbox);
					$CI->make->eRow();
					$CI->make->sRow();
						$CI->make->td('Total Invoice Cost',array('colspan'=>7,'style'=>'text-align:right;padding-top:10px;font-size:24px;'));
						$CI->make->td('<span id="delivery_cost">'.num($total_cost).'</span>',array('style'=>'text-align:right;padding-top:10px;font-size:21px;'));
						$CI->make->hidden('total_cost',$total_cost);
					$CI->make->eRow();
				$CI->make->eTable();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol(9);
			$CI->make->sBox('warning');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->textarea('Remarks','remarks','','',array('maxlength'=>'255','style'=>'resize:vertical;'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		$CI->make->sDivCol(3,'center');
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->button(fa('fa fa-newspaper-o')." Process Invoice",array('class'=>'btn-lg','id'=>'btn-process-invoice'),'primary');
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	$CI->make->eForm();


	return $CI->make->code();
}
function build_customer_payments($payments=null)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol(12,'right',0,array('style'=>'margin-bottom:12px;'));
			$CI->make->A(
				fa('fa-money fa-lg fa-fw')." Create new Customer Payment",
				'cust_payment_form',
				array(
					'class'=>'btn btn-primary')
			);
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(4);
							$CI->make->debtorMasterDrop('Customer','debtor_id',null,'Select customer',array('class'=>'combobox'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('info');
				$CI->make->sBoxBody();
					// $CI->make->sDivRow();
						$CI->make->sDiv(array('id'=>'div-results'));
							$code = build_customer_payment_display($payments);
							$CI->make->append($code);
						$CI->make->eDiv();
					// $CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();



	return $CI->make->code();
}
function build_customer_payment_display($payments)
{
	$CI =& get_instance();

	$th = array(
		'Transaction' => array('width'=>'10%'),
		'Reference' => array('width'=>'10%'),
		'Customer Name' => array('width'=>'18%'),
		'Branch' => array('width'=>'18%'),
		'Date' => array('width'=>'10%'),
		'Amount' => array('width'=>'13%'),
		'Outstanding Bal' => array('width'=>'13%'),
		' ' => array('width'=>'8%')
		);

	$rows = array();
	foreach($payments as $val) {
		$link = $CI->make->A(
					fa('fa fa-check-square-o fa-lg fa-fw'),
					base_url().'sales/allocate_customer_payment/'.$val->id,
					array('return'=>'true',
						'title'=>'Allocate outstanding balance',
						)
				);
		$rows[] = array(
				$val->trans_name,
				$val->reference,
				$val->customer_name,
				$val->customer_branch,
				date('Y-m-d',strtotime($val->created_on)),
				array('text'=>num($val->t_amount),'params'=>array('style'=>'text-align:right')),
				// array('text'=>num($val->t_amount - ($val->allocated_amount ?: 0)),'params'=>array('style'=>'text-align:right')),
				array('text'=>$link,'params'=>array('style'=>'text-align:center')),
			);
	}
	$CI->make->listLayout($th,$rows);

	return $CI->make->code();
}
function build_customer_payment_allocation($type_no,$payments,$invoices)
{
	$CI =& get_instance();

	$payment = $payments[0];

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sForm('sales/process_payment_allocation',array('id'=>'allocation_form'));
			$CI->make->hidden('trans_type',$payment->trans_type);
			$CI->make->hidden('type_no',$payment->type_no);
			$CI->make->sBox('solid');
				$CI->make->sBoxHead();
					$CI->make->boxTitle('Allocation of Customer Payment # '.$payment->reference);
				$CI->make->eBoxHead();
				$CI->make->sBoxBody();
					$outstanding_payment = $payment->t_amount - $payment->allocated_amount;
					$CI->make->span($payment->customer_name.'<br/>',array('style'=>'font-size:19px;font-weight:bolder;'));
					// $CI->make->span('Branch : '.$payment->customer_branch.'<br/>',array('style'=>'font-size:14.5px;font-weight:lighter;'));
					$CI->make->span('Transaction Date : '.date('Y F d',strtotime($payment->trans_date)).'<br/>',array('style'=>'font-size:14.5px;font-weight:lighter;'));
					$CI->make->span('Created on : '.date('Y F d',strtotime($payment->created_on)).'<br/>',array('style'=>'font-size:14.5px;font-weight:lighter;'));
					$CI->make->span('Payment Amount : '.num($payment->t_amount).'<br/>',array('style'=>'font-size:14.5px;font-weight:lighter;'));
					$CI->make->span('Allocated Amount : '.num($payment->allocated_amount).'<br/>',array('style'=>'font-size:14.5px;font-weight:lighter;'));
					$CI->make->hidden('oustanding_payment',$outstanding_payment);
					$CI->make->append('<br/>');

					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
						$CI->make->sRow();
							$CI->make->th('Transaction Type',array('style'=>'width:15%;text-align:center;'));
							$CI->make->th('Reference',array('style'=>'width:11%;text-align:center;'));
							$CI->make->th('Date',array('style'=>'width:9%;text-align:center;'));
							$CI->make->th('Due Date',array('style'=>'width:9%;text-align:center;'));
							$CI->make->th('Amount',array('style'=>'width:13%;text-align:center;'));
							$CI->make->th('Other Allocations',array('style'=>'width:13%;text-align:center;'));
							$CI->make->th('Outstanding',array('style'=>'width:13%;text-align:center;'));
							$CI->make->th('This Allocation',array('style'=>'width:17%;text-align:center;'));
						$CI->make->eRow();

						$out_pay_check = $outstanding_payment;
						foreach ($invoices as $val) {
							$outstanding = $val->t_amount - $val->allocated_amount;
							$display_amount = ($outstanding > $out_pay_check ? $out_pay_check : $outstanding);
							$check = $CI->make->A(fa('fa-check fa-lg'),'#',array(
								'ref'        => $val->type_no,
								'ref_amount' => $display_amount,
								'class'      => 'alloc-all',
								'return'     => true,
								'title'      => 'Allocate all'));

							$CI->make->sRow();
								$CI->make->td($val->trans_name,array('style'=>'padding-top:15px;'));
								$CI->make->td($val->type_no,array('style'=>'text-align:right;padding-top:15px;'));
								$CI->make->td($val->trans_date,array('style'=>'text-align:center;padding-top:15px;'));
								$CI->make->td($val->due_date,array('style'=>'text-align:center;padding-top:15px;'));
								$CI->make->td(num($val->t_amount),array('style'=>'text-align:right;padding-top:15px;'));
								$CI->make->td(num($val->allocated_amount),array('style'=>'text-align:right;padding-top:15px;'));
								$CI->make->td(num($outstanding).$check,array('style'=>'text-align:right;padding-top:15px;'));

								$textbox = $CI->make->decimal('','alloc-'.$val->type_no.'',num($display_amount),'',2,
									array('style'=>'text-align:right;padding:4px 8px;margin-bottom:-15px;',
										'class'=>'alloc-qty',
										'ref'=>$val->type_no,
										'ref_amount'=>$display_amount,
										'return'=>true));
								$CI->make->td($textbox);
							$CI->make->eRow();
							$out_pay_check -= $display_amount;
						}


					$CI->make->eTable();
					$CI->make->append('<hr/>');
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->span('Total<br/>',array('style'=>'font-size:17px;font-weight:lighter;'));
							$CI->make->span('0.00',array('style'=>'font-size:32px;font-weight:bolder;','id'=>'spn-total-alloc'));
							$CI->make->append('<hr/>');
							$CI->make->button(fa('fa fa-check-square-o')." Process this allocation",array('class'=>'btn-lg','id'=>'btn-process'),'primary');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
			$CI->make->eForm();
		$CI->make->eDivCol();
	$CI->make->eDivRow();


	return $CI->make->code();
}

/////////////////////////////////////JED////////////////////////////////
///////////////////////////////////////////////////////////////////////
function creditNoteHeaderPage($cn_id){
	$CI =& get_instance();
	// $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			// $CI->make->sDivCol(12,'right');
				// $CI->make->A(fa('fa-reply').' Go Back To list',base_url().'sales_order_form',array('class'=>'btn btn-primary'));
			// $CI->make->eDivCol();
		// $CI->make->eDivRow();
	// $CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'sales/cn_details_load/','id'=>'details_link'),
						fa('fa-book')." Credit Note Items"=>array('href'=>'#cn_items','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'sales/cn_items_load/','id'=>'cn_items_link'),
					);
					$CI->make->hidden('cn_id',$cn_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'cn_items','class'=>'tab-pane'));
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function cnHeaderDetailsLoad($cn=null,$cn_id=null,$reference){
	$CI =& get_instance();

		$CI->make->sForm("sales/cn_header_details_db",array('id'=>'cn_header_details_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-cnheader'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					$CI->make->hidden('form_mod_id',$cn_id);
					// $CI->make->salesInvoiceDrop('Sales Invoice','sales_invoice',iSetObj($cn,'src_type_no'), 'select', array('class'=>'rOkay'));
					$CI->make->customersDrop('Customer','debtor_id',iSetObj($cn,'debtor_id'), '', array('class'=>'rOkay'));
					$CI->make->customerBranchesDrop('Branch','debtor_branch_id',iSetObj($cn,'debtor_branch_id'), 'select', array('class'=>'rOkay'));
					$CI->make->inventoryLocationsDrop('Deliver from Location','loc_code',iSetObj($cn,'loc_code'), '', array('class'=>'rOkay'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					if (iSetObj($cn,'reference')) {
						$CI->make->input('Reference','reference',$cn->reference,'Type Reference',array('class'=>'rOkay','readonly'=>true));
					} else {
						$CI->make->input('Reference','reference',$reference,'Type Reference',array('class'=>'rOkay'));
					}
					$CI->make->salesTypesDrop('Price List','sales_type',iSetObj($cn,'sales_type'), '', array('class'=>'rOkay'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->datefield('Date','trans_date',(iSetObj($cn,'trans_date') ? sql2Date(iSetObj($cn,'trans_date')) : date('m/d/Y')),'',array());
					$CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();

			$CI->make->sDivRow(array('style'=>'margin:0;'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(8);
						$CI->make->textarea('Memo','remarks',iSetObj($cn,'remarks'),'Type Comments',array('class'=>'rOkay','style'=>'resize:vertical;'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}

function cnItemsLoad($cn_id=null,$det=null){
	$CI =& get_instance();

			$CI->make->sDivRow();
				$CI->make->sDivCol(3);
					$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sForm("sales/cn_items_db",array('id'=>'cn_items_form'));
								$CI->make->hidden('_cn_id',$cn_id);
								// $CI->make->hidden('order_no',$order_no);
								$CI->make->hidden('item-id',null, array('class'=>'input_form'));
								$CI->make->hidden('item-uom',null, array('class'=>'input_form'));
								$CI->make->hidden('item-price',null, array('class'=>'input_form'));

								$CI->make->itemWithBarcodeListDrop('Item ','item',null,'Select Item',array('class'=>'combobox input_form this_item'));

								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->input('Quantity on Hand','qoh','0',null,array('class'=>'forms','readonly'=>true));
									$CI->make->eDivCol();
								$CI->make->eDivRow();

								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										$CI->make->decimal('Quantity','qty_delivered',null,null,2,array('class'=>'rOkay input_form this_qty'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										$CI->make->select('Unit','select-uom',array(),null,array('class'=>'rOkay input_form','id'=>'select-uom'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();

								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										$CI->make->input('Price','unit_price','0.00',null,array('class'=>'rOkay numbers-only input_form'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										$CI->make->input('Discount','discount_percentage','0.00',null,array('class'=>'rOkay numbers-only input_form'),'','%');
									$CI->make->eDivCol();
									$CI->make->sDivCol();
										$CI->make->stockCategoriesWord('Stock Category','stock_category','',null,array('class'=>'rOkay input_form'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();

								$CI->make->button(fa('fa-plus').' Add Item',array('class'=>'btn-block','id'=>'add-item-btn'),'primary');
								$CI->make->button('Add Hardware item',array('class'=>'btn-block','id'=>'add-non-stock-item-btn'),'default');

						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();

				$CI->make->sDivCol(9);
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-striped','id'=>'details-tbl'));
									$CI->make->sRow();
										// $CI->make->th('ITEM');
										// $CI->make->th('QTY',array('style'=>'width:60px;'));
										// $CI->make->th('QTY DELIVERED',array('style'=>'width:60px;'));
										// $CI->make->th('SUBTOTAL',array('style'=>'width:60px;'));
										// $CI->make->th('&nbsp;',array('style'=>'width:40px;'));
										$CI->make->th('CATEGORY',array());
										$CI->make->th('ITEM');
										$CI->make->th('QTY',array());
										$CI->make->th('PRICE',array());
										$CI->make->th('DISCOUNT(%)',array());
										$CI->make->th('SUBTOTAL',array());
										$CI->make->th('&nbsp;',array());
									$CI->make->eRow();
									$total = 0;
									if(count($det) > 0){
										foreach ($det as $res) {
											$CI->make->sRow(array('id'=>'row-'.$res->id));
									            // $CI->make->td("[ ".$res->item_code." ] ".$res->name);
										        $CI->make->td($res->stock_category);
									            $CI->make->td($res->item_name);
									            $CI->make->td(num($res->qty));
										        $CI->make->td(num($res->unit_price));
										        $CI->make->td($res->discount_percentage);
									            // $CI->make->td(num($res->unit_price * $res->qty));
									            $CI->make->td(num($res->line_total));
									            $a = $CI->make->A(fa('fa-trash-o fa-fw fa-lg'),'#',array('id'=>'del-'.$res->id,'class'=>'dels','ref'=>$res->id,'return'=>true));
									            $CI->make->td($a);
									        $CI->make->eRow();
											$total += $res->unit_price * $res->qty;
										}
									}
								$CI->make->eTable();
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eForm();
	return $CI->make->code();
}
function build_invoice_inquiries()
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("sales/invoice_inquiries_results",array('id'=>'invoice_search_form'));
						$CI->make->sDivCol(3);
							$CI->make->customersDrop('Customer','debtor_id','','Select a customer',array('class'=>'combobox'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Date range','daterange',date('m/d/Y',strtotime('-1 month')).' to '.date('m/d/Y'),'',array('class'=>'rOkay daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(1,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
							$CI->make->A(fa('fa-search').' Search','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:right'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		// $CI->make->sBox('',array());
		// 	$CI->make->sBoxBody();
		// 		$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
		// 			//$CI->make->sForm("sales/invoice_inquiries_results",array('id'=>'invoice_search_form'));
		// 				$CI->make->sDivCol(3);
		// 					$CI->make->checkbox("Show Delivery details","dr_detail",null,array('class'=>'cbox','chk'=>'0'),false);
		// 				$CI->make->eDivCol();
		// 				$CI->make->sDivCol(3);
		// 					$CI->make->checkbox("Show Deliver To","deliver_to",null,array('class'=>'cbox','chk'=>'0'),false);
		// 				$CI->make->eDivCol();
		// 				// $CI->make->sDivCol(1,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
		// 				// 	$CI->make->A(fa('fa-search').' Search','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:right'));
		// 				// $CI->make->eDivCol();
		// 			//$CI->make->eForm();
		// 		$CI->make->eDivRow();
		// 	$CI->make->eBoxBody();
		// $CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Invoice Inquiries",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function build_sales_invoice_display($results)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Reference #' => array('width'=>'12%'),
					'Customer Name' => array('width'=>'22%'),
					'Branch' => array('width'=>'21%'),
					'Date' => array('width'=>'9%'),
					'Invoice Due Date' => array('width'=>'9%'),
					'Total Cost' => array(),
					' ' => array('width'=>'12%')
					);

				$rows = array();
				foreach($results as $val) {
					$link = "";

					$link2 = $CI->make->A(fa('fa-file-text-o fa-2x fa-fw'),base_url().'sales/print_sales_invoices/'.$val->trans_type.'/'.$val->type_no.'/'.$val->id.'/wbd',array('return'=>'true','title'=>'print w/ VAT breakdown','target'=>"_blank"));
					$link1 = $CI->make->A(fa('fa-file-o fa-2x fa-fw'),base_url().'sales/print_sales_invoices/'.$val->trans_type.'/'.$val->type_no.'/'.$val->id.'/nbd',array('return'=>'true','title'=>'print w/o VAT breakdown','target'=>"_blank"));
					// $link = $CI->make->checkbox(null,'check_'.$val->delivery_no,null,array(
					// 	'debtor'=>$val->debtor_id,
					// 	'branch'=>$val->debtor_branch_id,
					// 	'del_no'=>$val->delivery_no,
					// 	'class'=>'invoice-check','return'=>true),false);

					$where = array('debtor_id'=>$val->debtor_id);
				    $debtor_name = $CI->sales_model->get_details($where,'debtor_master');

				    $where = array('debtor_branch_id'=>$val->debtor_branch_id);
				    $branch_name = $CI->sales_model->get_details($where,'debtor_branches');


					$rows[] = array(
							$val->reference,
							$debtor_name[0]->name,
							$branch_name[0]->branch_name,
							sql2Date($val->trans_date),
							sql2Date($val->due_date),
							array('text'=>num($val->t_amount),'params'=>array('style'=>'text-align:right')),
							array('text'=>$link1." ".$link2,'params'=>array('style'=>'text-align:center'))
						);
				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		// $CI->make->sDivRow();
		// 	$CI->make->sDivCol(12,'right');
		// 		$CI->make->A(fa('fa-newspaper-o').' Create delivery invoice','#',array('class'=>'btn btn-primary','id'=>'btn-create-invoice'));
		// 	$CI->make->eDivCol();
		// $CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}
function build_delivery_inquiry()
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sDivCol(3);
						$CI->make->select(
							'Delivery Reference',
							'delivery_ref',
							null,
							null,
							array(
								'class'=>'selectpicker with-ajax',
								'data-live-search'=>"true"
							)
						);
					$CI->make->eDivCol();
					$CI->make->sForm("sales/delivery_inquiry_results",array('id'=>'delivery_search_form'));
						$CI->make->sDivCol(3);
							$CI->make->customersDrop('Customer','debtor_id','','Select a customer',array('class'=>'combobox'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input(
								'Date range',
								'daterange',
								date('m/d/Y',strtotime('-1 month')).' to '.date('m/d/Y'),
								'',
								array(
									'class'=>'rOkay daterangepicker',
									'style'=>'position:initial;'
									),
								null,
								fa('fa-calendar')
							);
						$CI->make->eDivCol();
						$CI->make->sDivCol(1,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
							$CI->make->A(fa('fa-search').' Search','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:right'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Invoice Inquiries",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();


	return $CI->make->code();
}
function build_delivery_display($results)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Sales Order' => array('width'=>'13%'),
					'Delivery Reference' => array('width'=>'13%'),
					'Customer Branch' => array('width'=>'26%'),
					'Total Cost' => array('width'=>'10%'),
					'Date' => array('width'=>'10%'),
					'Invoice Due Date' => array('width'=>'10%'),
					' ' => array('width'=>'7%')
					);

				$rows = array();
				foreach($results as $val) {
					$link = $CI->make->A(
						fa('fa-history fa-lg fa-fw'),'delivery_returns/'.$val->reference,
						array(
							'return'=>true,
							'title'=>'Return dispatched items'
						)
					);
					$link .= $CI->make->A(
						fa('fa-check fa-lg fa-fw'),'complete_delivery/'.$val->reference,
						array(
							'return'=>true,
							'title'=>'Complete this delivery'
						)
					);
					$rows[] = array(
						$val->so_reference,
						$val->reference,
						$val->customer_branch,
						array('text'=>num($val->t_amount),'params'=>array('style'=>'text-align:right')),
						$val->trans_date,
						$val->invoice_due_date,
						array('text'=>$link,'params'=>array('style'=>'text-align:center'))
					);
				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}
function build_delivery_return($reference,$delivery_info,$delivery_items)
{
	$CI =& get_instance();

	$CI->make->sForm('sales/process_delivery_return',array('id'=>'return_form'));
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('info');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(2);
								$CI->make->input('Delivery Return Reference','delivery_ret_ref',$reference,null,array('style'=>'font-size:15px;','maxlength'=>'50'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(2);
								$CI->make->inventoryLocationsDrop('Receiving location','to_loc',$delivery_info->loc_code,'',array());
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(2);
								$CI->make->hidden('delivery_no',$delivery_info->id);
								$CI->make->hidden('delivery_trans_type',$delivery_info->trans_type);
								$CI->make->hidden('delivery_type_no',$delivery_info->type_no);
								$CI->make->input('Delivery Reference','delivery_ref',$delivery_info->reference,null,array('style'=>'background-color:#FAFAFA;','maxlength'=>'50','readOnly'=>'readOnly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->hidden('debtor_id',$delivery_info->debtor_id);
								$CI->make->input('Customer','customer',$delivery_info->customer_name,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->hidden('debtor_branch_id',$delivery_info->debtor_branch_id);
								$CI->make->input('Branch Name','branch_name',$delivery_info->customer_branch,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input('PR Reference','pr_ref',$delivery_info->pr_ref,'',array('maxlength'=>'15','disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(2);
								$CI->make->append(
									'<label for="so_ref">For Sales Order</label>
									<a class="form-control" href="#" style="font-size:15px;color:#428bca;background-color:#FAFAFA;margin-bottom:10px;">'.$delivery_info->so_reference.'</a>'
								);
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input('Sales Type','sales_type',$delivery_info->sales_type_name,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input(
									'Invoice required by',
									'invoice_due_date',
									date('m/d/Y',strtotime($delivery_info->invoice_due_date)),
									null,
									array('class'=>'pick-date','style'=>'position:initial;background-color:#FAFAFA;','disabled'=>'disabled'),
									null,
									fa('fa fa-calendar'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(2,'left',1);
								$CI->make->input('SI Reference','si_ref',$delivery_info->si_ref,'',array('maxlength'=>'15','disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(2);
								$CI->make->inventoryLocationsDrop('Deliver from','from_loc',$delivery_info->loc_code,'',array('readOnly'=>'readOnly','style'=>'background-color:#FAFAFA;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->shippingCompDrop('Shipper','shipper_id',$delivery_info->shipper_id,null,array('disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input(
									'Delivery Date',
									'delivery_date',
									date('m/d/Y'),
									null,
									array('class'=>'pick-date','disabled'=>'disabled','style'=>'position:initial;background-color:#FAFAFA;'),
									null,
									fa('fa fa-calendar'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(2,'left',1);
								$CI->make->input('BIR DR Reference','bir_dr_ref',$delivery_info->dr_ref,'',array('maxlength'=>'15','disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			// $CI->make->sDivCol(3);
			// 	$CI->make->sBox('info');
			// 		$CI->make->sBoxBody();
			// 			$CI->make->sDivRow();
			// 				$CI->make->sDivCol();
			// 					$CI->make->input('PR Reference','pr_ref',$delivery_info->pr_ref,'',array('maxlength'=>'15','disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
			// 					$CI->make->input('SI Reference','si_ref',$delivery_info->si_ref,'',array('maxlength'=>'15','disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
			// 					$CI->make->input('BIR DR Reference','bir_dr_ref',$delivery_info->dr_ref,'',array('maxlength'=>'15','disabled'=>'disabled','style'=>'background-color:#FAFAFA;'));
			// 				$CI->make->eDivCol();
			// 			$CI->make->eDivRow();
			// 		$CI->make->eBoxBody();
			// 	$CI->make->eBox();
			// $CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('',array('class'=>'table-responsive','style'=>'border-top-color:#7E15FD'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
						$CI->make->sRow(array(),false);
							$CI->make->th('Item',array('style'=>'width:25%;text-align:center;'));
							$CI->make->th('Ordered',array('style'=>'width:9%;text-align:center;'));
							$CI->make->th('Unit',array('style'=>'width:7%;text-align:center;'));
							$CI->make->th('Delivered',array('style'=>'width:9%;text-align:center;'));
							$CI->make->th('Return Qty',array('style'=>'width:12%;text-align:center;'));
							$CI->make->th('Discount',array('style'=>'width:7%;text-align:center;'));
							$CI->make->th('Price',array('style'=>'width:10%;text-align:center;'));
							$CI->make->th('Total',array('style'=>'width:13%;text-align:center;'));
						$CI->make->eRow();
						foreach ($delivery_items as $val) {
							$less_discount = ((100 - $val->discount_percentage) / 100);
							$link = $CI->make->A('['.$val->item_code.']','#',array('return'=>true));
							$CI->make->sRow();
								$CI->make->td($link.' '.$val->item_name,array('style'=>'padding-top:15px;'));
								$CI->make->td('<span id="ordered-ref['.$val->details_id.']" value="'.$val->order_qty.'">'.num($val->order_qty).'</span>',
									array('style'=>'text-align:right;padding-top:15px;'));
								$CI->make->td($val->uom_name,array('style'=>'padding-top:15px;'));
								$CI->make->td('<span id="delivered-ref['.$val->details_id.']" value="'.$val->delivered_qty.'">'.num($val->delivered_qty).'</span>',array('style'=>'text-align:right;padding-top:15px;'));
								$textbox = $CI->make->decimal('','delivery['.$val->stock_category.']['.$val->details_id.']',num(0),'',2,
									array('style'=>'text-align:right;padding:4px 8px;margin-bottom:-15px;','class'=>'return-qty','ref'=>$val->details_id,'return'=>true));
								$CI->make->td($textbox);
								$CI->make->td('<span id="disc-ref['.$val->details_id.']" value="'.$less_discount.'">'.$val->discount_percentage.'%</span>',
									array('style'=>'text-align:right;padding-top:15px;'));
								$CI->make->td('<span id="price-ref['.$val->details_id.']" value="'.$val->unit_price.'">'.num($val->unit_price).'</span>',
									array('style'=>'text-align:right;padding-top:15px;'));
								$CI->make->td('<span id="total-ref['.$val->details_id.']" class="total-ref" value="0">'.num(0).'</span>',
									array('style'=>'text-align:right;padding-top:15px;'));
							$CI->make->eRow();
						}
						$CI->make->sRow();
							$CI->make->td('Shipping Cost',array('colspan'=>7,'style'=>'text-align:right;padding-top:15px;'));
							$cost_textbox = $CI->make->decimal(
												'',
												'deliv_shipping_cost',
												num($delivery_info->t_shipping_cost),
												'',
												2,
												array('style'=>'text-align:right;padding:4px 8px;margin-bottom:-15px;',
													'return'=>true,
													'x_value'=>$delivery_info->t_shipping_cost
												)
											);
							$CI->make->td($cost_textbox);
						$CI->make->eRow();
						$CI->make->sRow();
							$CI->make->td('Total Delivery Return',array('colspan'=>7,'style'=>'text-align:right;padding-top:10px;font-size:24px;'));
							$CI->make->td('<span id="delivery_cost">'.num($delivery_info->t_amount).'</span>',array('style'=>'text-align:right;padding-top:10px;font-size:21px;'));
						$CI->make->eRow();
					$CI->make->eTable();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->sDivRow();
			$CI->make->sDivCol(9);
				$CI->make->sBox('warning');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->textarea('Remarks','remarks',$delivery_info->remarks,'',array('maxlength'=>'255','style'=>'resize:vertical;'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			$CI->make->sDivCol(3,'center');
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						$CI->make->button(fa('fa fa-history')." Process return",array('class'=>'btn-lg','id'=>'btn-process-return'),'primary');
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();


	return $CI->make->code();
}
//----------SALES MAINTENANCE FUNCTIONS----------START
//----------CUSTOMER MASTER----------START
function customer_master_form($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Customer',base_url().'sales/manage_customer_master',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Code' => array('width'=>'10%'),
									'Name' => array('width'=>'30%'),
									'Address' => array('width'=>'30%'),
									'Is Inactive' => array('width'=>'20%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'sales/manage_customer_master/'.$val->cust_id,array("return"=>true));
								$rows[] = array(
											  $val->cust_code,
											  $val->description,
											  $val->house_no.' '.$val->street.', '.$val->brgy.', '.$val->city,
											  ($val->inactive == 1 ? 'Yes' : 'No'),
											  $links
									);

							}
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
				$CI->make->eBoxBody();
			$CI->make->eBox();
					
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	
	return $CI->make->code();
}
function manage_customer_master_form($details=null){
	 $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'sales/customer_master',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
				// $CI->make->hidden('asset_id',iSetObj($item,'asset_id'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
					);
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

							$CI->make->sForm("sales/customer_details_db",array('id'=>'cust_details_form'));
								$CI->make->hidden('cust_id',iSetObj($details,'cust_id'));
								$CI->make->hidden('mode',((iSetObj($details,'cust_id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
										$CI->make->input('Customer Code','cust_code',iSetObj($details,'cust_code'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(8);
										$CI->make->input('Description','description',iSetObj($details,'description'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(3);
										$CI->make->sDivRow();
											$CI->make->sDivCol(4);
												$CI->make->input('House #','house_no',iSetObj($details,'house_no'),null,array('class'=>'rOkay formInputMini reqForm'));
											$CI->make->eDivCol();
											$CI->make->sDivCol(8);
												$CI->make->input('Street','street',iSetObj($details,'street'),null,array('class'=>'rOkay reqForm'));
											$CI->make->eDivCol();
										$CI->make->eDivRow();
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
										$CI->make->input('Barangay','brgy',iSetObj($details,'brgy'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
										$CI->make->input('City','city',iSetObj($details,'city'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
										$CI->make->datefield('Birthday','birthday',iSetObj($details,'birthday'),'Select Date',array('class'=>'reqForm'),"<i class='fa fa-fw fa-calendar'></i>"); //-----Date field
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
										$CI->make->input('Telephone #','tel_no',iSetObj($details,'tel_no'),null,array('class'=>'rOkay reqForm'),"<i class='fa fa-fw fa-phone'></i>");
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Mobile #','mobile_no',iSetObj($details,'mobile_no'),null,array('class'=>'rOkay reqForm'),"<i class='fa fa-fw fa-mobile'></i>");
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Email Address','email_address',iSetObj($details,'email_address'),null,array('class'=>'rOkay reqForm'),"<i class='fa fa-fw fa-envelope'></i>");
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
										// $CI->make->input('Referred By','referred_by',iSetObj($details,'mobile_no'),'Type Name',array('class'=>'rOkay'),"<i class='fa fa-fw fa-user'></i>");
										$CI->make->salesPersonsDrop('Sales Person','sales_person_id',iSetObj($details,'sales_person_id'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Facebook Account','fb_account',iSetObj($details,'fb_account'),null,array('class'=>'reqForm'),"<i class='fa fa-fw fa-facebook-official'></i>");
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->customerTypeDrop('Customer Type','cust_type_id',iSetObj($details,'cust_type_id'),'',array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									// $CI->make->sDivCol(3);
										// $CI->make->input('Credit Limit','credit_limit',iSetObj($details,'credit_limit'),null,array('class'=>'rOkay numbers-only'));
									// $CI->make->eDivCol();
									// $CI->make->sDivCol(3);
										// $CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($details,'inactive'),null,array('class'=>''));
									// $CI->make->eDivCol();
								$CI->make->eDivRow();
								
								/*
								# TEMPORARILY DISABLED
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
										$CI->make->sDivRow();
											$CI->make->sDivCol(6);
												$CI->make->input('Discount Percent #1','disc_percent1',iSetObj($details,'disc_percent1'),'',array('class'=>' numbers-only'),"%");
											$CI->make->eDivCol();
											$CI->make->sDivCol(6, 'left', 0, array('style'=>'margin-left: -15px;'));
												$CI->make->input('Discount Amount #1','disc_amount1',iSetObj($details,'disc_amount1'),'',array('class'=>' numbers-only'),"Php");
											$CI->make->eDivCol();
										$CI->make->eDivRow();
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->sDivRow();
											$CI->make->sDivCol(6);
												$CI->make->input('Discount Percent #2','disc_percent2',iSetObj($details,'disc_percent1'),'',array('class'=>' numbers-only'),"%");
											$CI->make->eDivCol();
											$CI->make->sDivCol(6, 'left', 0, array('style'=>'margin-left: -15px;'));
												$CI->make->input('Discount Amount #2','disc_amount2',iSetObj($details,'disc_amount1'),'',array('class'=>' numbers-only'),"Php");
											$CI->make->eDivCol();
										$CI->make->eDivRow();
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->sDivRow();
											$CI->make->sDivCol(6);
												$CI->make->input('Discount Percent #3','disc_percent3',iSetObj($details,'disc_percent1'),'',array('class'=>' numbers-only'),"%");
											$CI->make->eDivCol();
											$CI->make->sDivCol(6, 'left', 0, array('style'=>'margin-left: -15px;'));
												$CI->make->input('Discount Amount #3','disc_amount3',iSetObj($details,'disc_amount1'),'',array('class'=>' numbers-only'),"Php");
											$CI->make->eDivCol();
										$CI->make->eDivRow();
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								*/
								
								$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
									$CI->make->sDivCol(4);
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(4, 'right');
										$CI->make->button(fa('fa-save').' Save Customer Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(4);
									$CI->make->eDivCol();
								$CI->make->eDivRow();

							$CI->make->eForm();

						$CI->make->eTabPane();
						
					$CI->make->eTabBody();
				$CI->make->eTab();
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();
}
//----------CUSTOMER MASTER----------END

//----------CUSTOMER CARD TYPES----------START-rhan
function CustomerCardTypesForm($cct=null){
	 $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'sales/customer_card_types',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
					);
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

							$CI->make->sForm("sales/customer_card_types_details_db",array('id'=>'customer_card_types_form'));
								$CI->make->hidden('id',iSetObj($cct,'id'));
								$CI->make->hidden('mode',((iSetObj($cct,'id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									//-----1st Row
									$CI->make->sDivCol(3);
										$CI->make->input('Name','name',iSetObj($cct,'name'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									//-----2nd Row
									$CI->make->sDivCol(3);
										$CI->make->input('Description','description',iSetObj($cct,'description'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									//-----3rd Row
									$CI->make->sDivCol(3);
										$CI->make->input('Amount','min_purchased_amt',iSetObj($cct,'min_purchased_amt'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									//-----4th Row
									$CI->make->sDivCol(3);
									$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($cct,'inactive'),null,array('class'=>'reqForm'));
									$CI->make->eDivCol();
									
								$CI->make->eDivRow();
									
									$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										$CI->make->sDivCol(4);
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4, 'right');
											$CI->make->button(fa('fa-save').' Save Customer Card Types Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);
										$CI->make->eDivCol();
									$CI->make->eDivRow();

							$CI->make->eForm();
						$CI->make->eTabPane();	
					$CI->make->eTabBody();
				$CI->make->eTab();
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();
}
	
function CustomerCardTypesPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Customer Card Types',base_url().'sales/manage_customer_card_types',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Name' => array('width'=>'30%'),
									'Description' => array('width'=>'30%'),
									'Amount' => array('width'=>'40%'),
									'Status' => array('width'=>'20%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'sales/manage_customer_card_types/'.$val->id,array("return"=>true));
								$rows[] = array(
											  $val->name,
											  $val->description,
											  $val->min_purchased_amt,
											  ($val->inactive == 1 ? 'Inactive' : 'Active'),
											  $links
									);
							}
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}

//----------CUSTOMER CARD TYPES----------END-rhan

//----------CUSTOMER CARD ---------START -rhan

function customer_cards_page($list=array()){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Customer Cards',base_url().'sales/manage_customer_cards',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Customer Name' => array('width'=>'15%'),
									'Card Type' => array('width'=>'10%'),
									'Card no.'=>array('width'=>'15%'),
									'Display Name'=>array('width'=>'15%'),
									'Issuance Date'=>array('width'=>'10%'),
									'Expiry Date'=>array('width'=>'10%'),
									'Avaialble points'=>array('width'=>'10%'),
									'Is Inactive'=>array('width'=>'5%'),
									' '=>array('width'=>'5%','align'=>'right'));
							$rows = array();
							foreach($list as $v){
								$customer_name = $CI->sales_model->customer_name($v->cust_id);
								$card_type = $CI->sales_model->card_type_desc($v->card_type);
								
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'sales/manage_customer_cards/'.$v->id,array("return"=>true));
								$rows[] = array(
											  $customer_name,
											  $card_type,
											  $v->card_no,
											  $v->card_display_name,
											  $v->issuance_date,
											  $v->expiry_date,
											  $v->available_points,
											  ($v->inactive == 1 ? 'Yes' : 'No'),
											  $links
									);

							}
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function manage_customer_cards_form($item=null){
    $CI =& get_instance();
        $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
            $CI->make->sDivCol();
                $CI->make->A(fa('fa-reply').' GO BACK',base_url().'sales/customer_cards',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
                $CI->make->hidden('asset_id',iSetObj($item,'asset_id'));
            $CI->make->eDivCol();
        $CI->make->eDivRow();
        $CI->make->sDivRow();
            $CI->make->sDivCol();
                $CI->make->sTab();
                    $tabs = array(
                        fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),                   
                    );
                    $CI->make->tabHead($tabs,null,array());
                    $CI->make->sTabBody(array());
                        $CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

                        $CI->make->sForm("sales/customer_card_details_db",array('id'=>'customer_details_card_form'));
		
						$CI->make->hidden('id',iSetObj($item,'id'));
						$CI->make->hidden('mode',((iSetObj($item,'id')) ? 'edit' : 'add'));
					
					
                        $CI->make->sDivRow();
						
                        //////left side
	                    	$CI->make->sDivCol(6);
	                    		$CI->make->customer_drop('Customers','cust_id',iSetObj($item,'cust_id'),null,array('class'=>'reqForm'));
	                    		$CI->make->customer_card_type_Drop('Card Type','card_type',iSetObj($item,'card_type'),null,array('class'=>'reqForm'));
	                    		$CI->make->input('Card no.','card_no',iSetObj($item,'card_no'),null,array('class'=>'rOkay reqForm'));
	                    		$CI->make->input('Card Display Name','card_display_name',iSetObj($item,'card_display_name'),null,array('class'=>'rOkay reqForm'));								
	                    	$CI->make->eDivCol();
	                    
						////////////right side
	                    	$CI->make->sDivCol(6);
								$CI->make->sDivRow();
	                    	$CI->make->sDivCol(6);
								$CI->make->datefield('Issuance Date','issuance_date',iSetObj($item, 'issuance_date'),'Select Date',array('class'=>'rOkay reqForm'),$icon1="<i class='fa fa-fw fa-calendar'></i>"); //-----Date field
	                    	$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->datefield('Expiry Date','expiry_date',iSetObj($item, 'expiry_date'),'Select Date',array('class'=>'rOkay reqForm'),$icon1="<i class='fa fa-fw fa-calendar'></i>"); //-----Date field
	                    	$CI->make->eDivCol();
								$CI->make->eDivRow();
								
	                    		$CI->make->input('Available Points.','available_points',iSetObj($item,'available_points'),null,array('class'=>'rOkay numbers-only reqForm'));
								$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'reqForm'));								
	                    	$CI->make->eDivCol();
                        $CI->make->eDivRow();

                        $CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
							$CI->make->sDivCol(4, 'right');
								$CI->make->button(fa('fa-save').' Save Customer Card Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
					    $CI->make->eDivRow();

					    $CI->make->eForm();

                        $CI->make->eTabPane();

                    $CI->make->eTabBody();
                $CI->make->eTab();
            $CI->make->eDivCol();
        $CI->make->eDivRow();

    return $CI->make->code();
}



//----------CUSTOMER CARD ---------END -rhan
//----------SALES PERSON MASTER-----MHAE-----START
function sales_person_master_form($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Sales Person',base_url().'sales/manage_sales_person_master',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Name' => array('width'=>'30%'),
									'Contact #' => array('width'=>'30%'),
									'Email' => array('width'=>'30%'),
									'Is Inactive' => array('width'=>'20%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'sales/manage_sales_person_master/'.$val->id,array("return"=>true));
								$rows[] = array(
											  $val->name,
											  $val->phone,
											  $val->email_address,
											  ($val->inactive == 1 ? 'Yes' : 'No'),
											  $links
									);

							}
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
				$CI->make->eBoxBody();
			$CI->make->eBox();
					
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	
	return $CI->make->code();
}
function manage_sales_person_master_form($details=null){
	 $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'sales/sales_person_master',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
				// $CI->make->hidden('asset_id',iSetObj($item,'asset_id'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
					);
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

							$CI->make->sForm("sales/sales_person_details_db",array('id'=>'sales_person_details_form'));
								$CI->make->hidden('id',iSetObj($details,'id'));
								$CI->make->hidden('mode',((iSetObj($details,'id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									$CI->make->sDivCol(3);
										$CI->make->input('Name','name',iSetObj($details,'name'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
										$CI->make->input('Contact #','phone',iSetObj($details,'phone'),null,array('class'=>'rOkay reqForm'),"<i class='fa fa-fw fa-mobile'></i>");
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
										$CI->make->input('Email Address','email_address',iSetObj($details,'email_address'),null,array('class'=>'rOkay reqForm'),"<i class='fa fa-fw fa-envelope'></i>");
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
										$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($details,'inactive'),null,array('class'=>'reqForm'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
									$CI->make->sDivCol(4);
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(4, 'right');
										$CI->make->button(fa('fa-save').' Save Customer Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(4);
									$CI->make->eDivCol();
								$CI->make->eDivRow();

							$CI->make->eForm();

						$CI->make->eTabPane();
						
					$CI->make->eTabBody();
				$CI->make->eTab();
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();
}
//----------SALES PERSON MASTER----MHAE------END


//----------SALES MAINTENANCE FUNCTIONS----------END


//----------------Dan----------------------//
function ProductHistory($items = array()){
	$CI =& get_instance();	
		$CI->make->sBox('primary');
		$CI->make->sForm('',array('id'=>'view_data_item'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(3);
					$CI->make->input('Description','Description','','Input Description',array('class'=>'rOkay reqForm'));//Edit
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->input('Barcode','Barcode','','Input Barcode',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
					$CI->make->datefield('From Date','fdate',date('m/d/Y'),'',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
					$CI->make->datefield('To Date','tdate',date('m/d/Y',strtotime("+1 days")),'',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
					$CI->make->A(fa('fa-search').'Search','#',array('id'=>'ProductHistoryButtonView', 'style'=>' margin-top: 24px;margin-right: 25px;','class'=>'btn btn-flat btn-md btn-primary'));
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eBox();

		$CI->make->sBox('primary');
			$CI->make->sBoxBody();
					$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDiv(array('id'=>'view_data_data'));	
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->sDiv(array('class'=>'table-responsive'));
												$CI->make->sTable(array('class'=>'table table-hover','id'=>'smart-tbl'));
													$CI->make->sRow(array('style'=>'background-color: #EEEEEE; font-size: 13px;'));
														$CI->make->th('Barcode',array('style'=>''));
														$CI->make->th('Transaction ID',array('style'=>''));
														$CI->make->th('Transaction #',array('style'=>''));
														$CI->make->th('Date Posted',array('style'=>''));
														$CI->make->th('Status',array('style'=>''));
														$CI->make->th('Beginning Qty',array('style'=>''));
														$CI->make->th('Beginning Stock',array('style'=>''));
														$CI->make->th('Qty In',array('style'=>''));
														$CI->make->th('Qty Out',array('style'=>''));
														$CI->make->th('Stock/s In',array('style'=>''));
														$CI->make->th('Stock/s Out',array('style'=>''));
														$CI->make->th('Unitcost',array('style'=>''));
														$CI->make->th('Name',array('style'=>''));
													$CI->make->eRow();
													foreach($items as $v){
														$CI->make->sRow(array('style'=>'font-size: 13px;'));
														// $CI->make->td($v->Barcode);
														$CI->make->eRow();
													}
												$CI->make->eTable();
											$CI->make->eDiv();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eDiv();
							$CI->make->eDivCol();
					$CI->make->eDivRow();													
			$CI->make->eBoxBody();
			$CI->make->eForm();
		$CI->make->eBox();
	return $CI->make->code();
}

function ProductHistorySearch($items = array()){
$CI =& get_instance();	
	$CI->make->sDiv(array('id'=>'view_data_data'));	
		$CI->make->sDivRow();
			$CI->make->sDivCol(2);
				$CI->make->input('Product ID','','','Product ID',array('class'=>'rOkay reqForm','disabled'=>'disabled','value'=>$items[0]->PID)); #ProductID
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->input('Description','','','Description',array('class'=>'rOkay reqForm','disabled'=>'disabled','value'=>$items[0]->Description));
			$CI->make->eDivCol();
			$CI->make->sDivCol(2);
				$CI->make->input('Current Selling Area','','','Current Selling Area',array('class'=>'rOkay reqForm','disabled'=>'disabled','value'=>$items[0]->SellingArea));
			$CI->make->eDivCol();
			$CI->make->sDivCol(2);
				$CI->make->input('Current Cost of Sale','','','Current Cost of Sale',array('class'=>'rOkay reqForm','disabled'=>'disabled','value'=>$items[0]->CostOfSales));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->A(
				fa('fa-eye fa-lg fa-fw').' View Price Change History',
				'',
				array('class'=>'btn btn-success btn-flat action_btns ProductHistoryViewData',
				'data-toggle'=>'modal',
				'data-target'=>'#myModal',
				'ref_desc'=>'',
				'id'=>$items[0]->PID,
				'style'=>'cursor: pointer; margin-top: 24px;margin-right: 25px;'));
			$CI->make->eDivCol();
			$CI->make->sDivCol();
				$CI->make->sDiv(array('class'=>'table-responsive text-center'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'view_data_data-tbl'));
						$CI->make->sRow(array('style'=>'background-color: #EEEEEE; font-size: 13px;'));
							$CI->make->th('Barcode',array('style'=>''));
							$CI->make->th('Transaction ID',array('style'=>''));
							$CI->make->th('Transaction #',array('style'=>''));
							$CI->make->th('Date Posted',array('style'=>''));
							$CI->make->th('Status',array('style'=>''));
							$CI->make->th('Beginning Qty',array('style'=>''));
							$CI->make->th('Beginning Stock',array('style'=>''));
							$CI->make->th('Qty In',array('style'=>''));
							$CI->make->th('Qty Out',array('style'=>''));
							$CI->make->th('Stock/s In',array('style'=>''));
							$CI->make->th('Stock/s Out',array('style'=>''));
							$CI->make->th('Unitcost',array('style'=>''));
							$CI->make->th('Name',array('style'=>''));
						$CI->make->eRow();
						if($items){
							foreach($items as $v){
								$CI->make->sRow(array('style'=>'font-size: 13px;'));
									$CI->make->td($v->Barcode);
									$CI->make->td($v->TransactionID);	
									$CI->make->td($v->TransactionNo);
									$CI->make->td($v->DatePosted);
									$CI->make->td($v->Description2);	
									$CI->make->td($v->BeginningSellingArea);	
									$CI->make->td($v->BeginningStockRoom == NULL ? '0' : $v->BeginningStockRoom);	
									$CI->make->td($v->SellingAreaIn == NULL ? '0' : $v->SellingAreaIn);	
									$CI->make->td($v->SellingAreaOut == NULL ? '0' : $v->SellingAreaOut);	
									$CI->make->td($v->StockRoomIn == NULL ? '0' : $v->StockRoomIn);	
									$CI->make->td($v->StockRoomOut == NULL ? '0' : $v->StockRoomOut);	
									$CI->make->td($v->UnitCost == NULL ? '0' : $v->UnitCost);	
									$CI->make->td($v->Name == NULL ? 'N/A' : $v->Name);	
								$CI->make->eRow();
							}
						}
					$CI->make->eTable();
				$CI->make->eDiv();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eDiv();

	$CI->make->sDiv(array('id'=>'myModal','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
	$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
		$CI->make->sDiv(array('class'=>'modal-content'));

			$CI->make->sDiv(array('class'=>'modal-header'));
				$close = "<span aria-hidden='true'>&times;</span>";
				$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
				$CI->make->H(4,'Price Change History',array('style'=>'','class'=>'modal-title'));
			$CI->make->eDiv();
			
			$CI->make->sDiv(array('class'=>'modal-body'));	
						
				$CI->make->sDiv(array('id'=>'price_change_history'));
					$CI->make->sDivCol();										
						$CI->make->sDivRow();
							
						$CI->make->eDivRow();
					$CI->make->eDivCol();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();
	$CI->make->eDiv();
$CI->make->eDiv();

return $CI->make->code();
}

?>