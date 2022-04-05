<?php
function suppliers_display($list = array())
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Supplier',base_url().'purchasing/supplier_setup',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								// 'Code'=>'',
								'Supplier Name'=>'',
								// 'Address'=>'',
								// 'Email'=>'',
								// 'Phone'=>'',
								// 'Is Tax Exempted?'=>'',
								'Is Inactive?'=>'',
								''=>array('width'=>'7%','align'=>'right')
							);
							$rows = array();
							foreach ($list as $val) {
								$link = "";
								// $link .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'purchasing/supplier_setup/'.$val->supplier_id,array('return'=>'true','title'=>'Edit "'.$val->supp_name.'", "'.$val->supp_name.'"'));
								$link .= $CI->make->A(fa('fa-pencil fa-2x fa-fw'),base_url().'purchasing/supplier_setup/'.$val->supplier_id,array('return'=>'true','title'=>'Edit "'.$val->supp_name.'"'));
								$rows[] = array(
									// // $val->code,
									$val->supp_name,
									// // $val->street_no.' '.$val->street_address.', '.$val->city.', '.$val->region.' '.$val->zip,
									// $val->street_no.' '.$val->street_address.', '.$val->city.', '.$val->region.' '.$val->zip,
									// $val->email,
									// $val->phone,
									// ($val->tax_exempt == 0 ? 'No' : 'Yes'),
									($val->inactive == 0 ? 'No' : 'Yes'),
									$link
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
function suppliers_form_container($supplier_id)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->hidden('supplier_idx',$supplier_id);
		$CI->make->sDivCol(12);
			$CI->make->sTab();
				$tabs = array(
					fa('fa-info-circle')." General Details" => array('href'=>'#details','class'=>'tab_link','load'=>'purchasing/supplier_load','id'=>'details_link'),
				);
				$CI->make->tabHead($tabs,null,array());
				$CI->make->sTabBody();
					$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
					$CI->make->eTabPane();
				$CI->make->eTabBody();
			$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function suppliers_details_form($det, $supplier_id)
{
	$CI =& get_instance();

	$CI->make->sForm("purchasing/supplier_details_db",array('id'=>'supplier_details_form'));
		if (!empty($supplier_id)) {
			$CI->make->hidden('supplier_id',$supplier_id);
		}

		$CI->make->sDivRow(array('style'=>'margin:10px; padding-top:10px;'));
		// $CI->make->sDivRow(array("style"=>"height: 400px; margin-right: 0; margin-left: 0; width: 70%; overflow-x:scroll; overflow-y:scroll;"));
			$CI->make->sDivCol(4);
				// $CI->make->hidden('tax_id',iSetObj($det,'tax_id'));
				$CI->make->input('Supplier Code','supplier_code',iSetObj($det,'supplier_code'),'Type Supplier Code',array('style'=>'width: 50%;'));
				$CI->make->input('Supplier Name','supp_name',iSetObj($det,'supp_name'),'Type Supplier Name',array());
				$CI->make->input('Address','address',iSetObj($det,'address'),'Type Address',array('class'=>''));
				$CI->make->input('Contact Person','contact_person',iSetObj($det,'contact_person'),'Type Suffix',array());
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->input('Email Address','email',iSetObj($det,'email'),'Type Email Address',array('class'=>'rOkay'));
				$CI->make->input('Telephone No.','telno',iSetObj($det,'telno'),'Type Telephone No.',array('class'=>'rOkay'));
				$CI->make->input('Fax No.','faxno',iSetObj($det,'faxno'),'Type Fax No.',array('class'=>'rOkay'));
				$CI->make->input('Bank Account','bank_account',iSetObj($det,'bank_account'),'Type Bank Account',array('class'=>'rOkay'));
				$CI->make->inactiveDrop('Is Inactive?','inactive',iSetObj($det,'inactive'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->currenciesDrop("Supplier's Currency",'curr_code',iSetObj($det,'curr_code'),'',array());
				$CI->make->taxTypeDrop('Tax Group','tax_group_id',iSetObj($det,'tax_group_id'),'',array());
				$CI->make->paymentTermsDrop('Payment Term','payment_terms',iSetObj($det,'payment_terms'),'',array());
				$CI->make->drInvoiceDrop('D.R./Invoice','dr_inv',iSetObj($det,'dr_inv'),'',array());
				// $CI->make->input('Region','region',iSetObj($det,'region'),'Type Region',array('class'=>'rOkay'));
				// $CI->make->input('Zip Code','zip',iSetObj($det,'zip'),'Type Zip Code',array('class'=>'rOkay'));
				// $CI->make->inactiveDrop('Tax Exempted?','tax_exempt',iSetObj($det,'tax_exempt'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();

		// $CI->make->append('<br/>');

		$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
			$CI->make->sDivCol(4);
			$CI->make->eDivCol();
			$CI->make->sDivCol(4, 'right');
				$CI->make->button(fa('fa-save').' Save Supplier Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
			$CI->make->eDivCol();
	    $CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function customersPage(){
	$CI =& get_instance();
		$CI->make->sDiv(array('id'=>'supplier'));

			$CI->make->sDivRow();
				/*GIFT CARDS CASHIER*/
				$CI->make->sDivCol(12,'left',0,array('class'=>'customer-btns'));

					$buttons = array("new-customer"	=> fa('fa-user fa-lg fa-fw')."<br> NEW CUSTOMER",
									 "look-up"	=> fa('fa-search fa-lg fa-fw')."<br> LOOK-UP",
									 "disable-card"	=> fa('fa-file-text-o fa-lg fa-fw')."<br> ORDERS",
									 );
					$CI->make->sDivRow();
					foreach ($buttons as $id => $text) {
							$CI->make->sDivCol(3,'left',0,array("style"=>'margin-bottom:10px;'));
								$CI->make->button($text,array('id'=>$id.'-btn','class'=>'btn-block customer-btn-red double'));
							$CI->make->eDivCol();
					}
						$CI->make->sDivCol(3,'left',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->button(fa('fa-sign-out fa-lg fa-fw')."<br> EXIT",array('id'=>'exit-btn','class'=>'btn-block customer-btn-red-gray double'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			//-----NUMPAD AND CUSTOMER DETAILS-----start
			$CI->make->sDivRow();
				$CI->make->sDivCol(3,'left',0,array('id'=>'loginPin','class'=>'customer-left'));
					$CI->make->append(onScrNumPad('telno','telno-login'));
				$CI->make->eDivCol();

				$CI->make->sDivCol(8);
					$CI->make->sDiv(array('class'=>'customer-center'));
						//-----CUSTOMER DETAILS-----START
							$CI->make->sDiv(array('class'=>'customer_content_div'));

							$CI->make->eDiv();
						//-----CUSTOMER DETAILS-----END
					$CI->make->eDiv();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			//-----NUMPAD AND CUSTOMER DETAILS-----end

			//-----KEYBOARD-----start
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'left',0,array('class'=>'customer-btns'));
					$CI->make->sDiv(array('id'=>'wrap'));
					$CI->make->eDiv();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			//-----KEYBOARD-----end

		$CI->make->eDiv();
	return $CI->make->code();
}
function customersList($list = array())
{
	$CI =& get_instance();

	$CI->make->sForm("customers/customer_details_db",array('id'=>'customer_details_form'));
		if (!empty($supplier_id)) {
			$CI->make->hidden('supplier_id',$supplier_id);
		}

		// $CI->make->sDivRow(array('style'=>'margin:10px; padding-top:10px;'));
		$CI->make->sDivRow();
			$CI->make->sDivCol(12);
				$CI->make->sDiv(array('class'=>'table-responsive','style'=>'margin-top:23px'));
					$CI->make->sTable(array('class'=>'table table-striped','id'=>'details-tbl'));
						$CI->make->sRow();
	    					$CI->make->th('Name');
	    					$CI->make->th('Address');
	    					$CI->make->th('Email');
	    					$CI->make->th('Phone');
	    					$CI->make->th('Is Tax Exempted');
	    					$CI->make->th('Is Inactive');
	    					$CI->make->th();
	    				$CI->make->eRow();
						foreach ($list as $val) {
    						$CI->make->sRow(array('id'=>'row-'.$val->supplier_id));
    							$CI->make->td($val->lname.', '.$val->fname.' '.$val->mname);
    							$CI->make->td($val->street_no.' '.$val->street_address.' '.$val->city.' '.$val->region.' '.$val->zip);
    							$CI->make->td($val->email);
    							$CI->make->td($val->phone);
    							$CI->make->td(($val->tax_exempt ? 'Yes' : 'No'));
    							$CI->make->td(($val->inactive ? 'Yes' : 'No'));
    							$a = $CI->make->A(fa('fa-pencil fa-fw fa-lg'),base_url().'customers/cust_setup/'.$val->supplier_id,array('class'=>'edit-line', 'ref'=>$val->supplier_id, 'phoneref'=>$val->phone, 'return'=>true));
            					$CI->make->td($a);
								// $a = $CI->make->A(fa('fa-pencil fa-fw fa-lg'),'#',array('id'=>'edit-item-'.$val->supplier_id, 'class'=>'edit-line', 'ref'=>$val->supplier_id, 'return'=>true));
            					// $CI->make->td($a);
    						$CI->make->eRow();
    					}
					$CI->make->eTable();
				$CI->make->eDiv();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
//*************APM******************************
function purchaseHeaderPage($po_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right');
				if($po_id != null)
					$CI->make->A(fa('fa-reply').' Go Back',base_url().'purchasing/purch_outstanding',array('class'=>'btn btn-primary'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'purchasing/details_load/','id'=>'details_link'),
						fa('fa-book')." Items"=>array('href'=>'#recipe','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'purchasing/items_load/','id'=>'recipe_link'),
					);
					$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'recipe','class'=>'tab-pane'));
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function poHeaderDetailsLoad($po=null,$po_id=null, $type_no=null){
	$CI =& get_instance();
		$CI->make->sForm("purchasing/po_header_details_db",array('id'=>'po_header_details_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-poheader'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					$CI->make->hidden('form_mod_id',$po_id);
					// $CI->make->suppliersDrop('Supplier','supplier_id',iSetObj($po,'supplier_id'),'Select Supplier',array('class'=>'rOkay combobox'));
					$CI->make->supplierMasterDrop('Supplier','supplier_id',iSetObj($po,'supplier_id'),'Select Supplier',array('class'=>'rOkay combobox'));
					if($po_id == null)
						$CI->make->input('Reference','reference',$type_no,'',array('style'=>'','class'=>'rOkay'));
					else
						$CI->make->input('Reference','reference',$po->reference,'',array('style'=>'','class'=>'rOkay'));

				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->datefield('Order Date','ord_date',(iSetObj($po,'ord_date') ? sql2Date(iSetObj($po,'ord_date')) : date('m/d/Y')),'',array('class'=>'rOkay'));
					$CI->make->input("Supplier's Reference",'requisition_no',iSetObj($po,'requisition_no'),'',array('class'=>'rOkay'));
					// $CI->make->salesTypesDrop('Price List','type',iSetObj($po,'type'));
					// $CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					// $CI->make->inventoryLocationsDrop("Receive Into",'into_stock_location',iSetObj($po,'into_stock_location'),'',array('style'=>'','class'=>'rOkay'));
					$CI->make->branchesDrop('Receive Into','branch_id',iSetObj($po,'branch_id'),'Select Branch',array('class'=>'rOkay combobox'));
					$CI->make->textarea('Deliver To','delivery_address',iSetObj($po,'delivery_address'),'Type Address',array('class'=>'rOkay'));
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();


			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(12);
						$CI->make->textarea('Memo','comments',iSetObj($po,'comments'),'Type Memo',array('class'=>''));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivRow();

			// $CI->make->sDivRow();
				// $CI->make->sDivCol(4,'left',4);
					// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
//*************JED******************************
function purchaseHeaderPage_OLD($po_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right');
				if($po_id != null)
					$CI->make->A(fa('fa-reply').' Go Back',base_url().'purchasing/purch_outstanding',array('class'=>'btn btn-primary'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'purchasing/details_load/','id'=>'details_link'),
						fa('fa-book')." Items"=>array('href'=>'#recipe','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'purchasing/items_load/','id'=>'recipe_link'),
					);
					$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'recipe','class'=>'tab-pane'));
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function poHeaderDetailsLoad_OLD($po=null,$po_id=null, $type_no=null){
	$CI =& get_instance();
		$CI->make->sForm("purchasing/po_header_details_db",array('id'=>'po_header_details_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-poheader'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					$CI->make->hidden('form_mod_id',$po_id);
					$CI->make->suppliersDrop('Supplier','supplier_id',iSetObj($po,'supplier_id'),'Select Supplier',array('class'=>'rOkay combobox'));
					if($po_id == null)
						$CI->make->input('Reference','reference',$type_no,'',array('style'=>'','class'=>'rOkay'));
					else
						$CI->make->input('Reference','reference',$po->reference,'',array('style'=>'','class'=>'rOkay'));

				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->datefield('Order Date','ord_date',(iSetObj($po,'ord_date') ? sql2Date(iSetObj($po,'ord_date')) : date('m/d/Y')),'',array('class'=>'rOkay'));
					$CI->make->input("Supplier's Reference",'requisition_no',iSetObj($po,'requisition_no'),'',array('class'=>'rOkay'));
					// $CI->make->salesTypesDrop('Price List','type',iSetObj($po,'type'));
					// $CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->inventoryLocationsDrop("Receive Into",'into_stock_location',iSetObj($po,'into_stock_location'),'',array('style'=>'','class'=>'rOkay'));
					$CI->make->textarea('Deliver To','delivery_address',iSetObj($po,'delivery_address'),'Type Address',array('class'=>'rOkay'));
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();


			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(12);
						$CI->make->textarea('Memo','comments',iSetObj($po,'comments'),'Type Memo',array('class'=>''));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivRow();

			// $CI->make->sDivRow();
				// $CI->make->sDivCol(4,'left',4);
					// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
function poItemsLoad($po_items=null,$order_no=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol(3);
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sForm("purchasing/add_item",array('id'=>'add_item_form'));
						// $CI->make->itemWithBarcodeListDrop('Item','item',null,'Select Item',array('class'=>'combobox forms this_item'));
						$CI->make->supplierStocksDrop('Stock','item',null,'Select Item',array('class'=>'combobox forms this_item'));
						$CI->make->hidden('order_no',$order_no);
						$CI->make->hidden('item-id',null);
						$CI->make->hidden('item-uom',null);
						// $CI->make->hidden('item-ppack',null);
						// $CI->make->hidden('item-pcase',null);
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Quantity','quantity_ordered',null,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->select('Unit','select-uom',array(),null,array('class'=>'rOkay forms','id'=>'select-uom'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Price','unit_price','0',null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							// $CI->make->sDivCol(6);
								// $CI->make->input('QOH','qoh','0',null,array('class'=>'forms','readonly'=>true));
							// $CI->make->eDivCol();
						$CI->make->eDivRow();

						$CI->make->datefield('Required Delivery Date','delivery_date',null,'',array('class'=>'rOkay forms'));
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								$CI->make->input('Discount1 %','discount_percent','0',null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Discount2 %','discount_percent2','0',null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Discount3 %','discount_percent3','0',null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->input('Client Code','client_code',null,null,array('class'=>'rOkay forms'));
						// $CI->make->locationsDrop('Receiving Location','loc_id',null,null,array('shownames'=>true));
						$CI->make->button(fa('fa-plus').' Add Item',array('class'=>'btn-block','id'=>'add-item-btn'),'primary');
					$CI->make->eForm();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		#FORM
		$CI->make->sDivCol(9);
			// $CI->make->sBox('primary');
			// 	$CI->make->sBoxBody();
					//$CI->make->sForm("receiving/save",array('id'=>'receive_form'));
						$CI->make->sDivRow(array('id'=>'load-table-items'));
							// $CI->make->sDivCol();
							// 	$CI->make->sDiv(array('class'=>'table-responsive'));
							// 	$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
							// 		$CI->make->sRow();
							// 			$CI->make->th('Item');
							// 			$CI->make->th('Quantity',array('style'=>''));
							// 			$CI->make->th('Unit',array('style'=>''));
							// 			$CI->make->th('Required Delivery Date',array('style'=>''));
							// 			$CI->make->th('Price',array('style'=>''));
							// 			$CI->make->th('Discount 1',array('style'=>''));
							// 			$CI->make->th('Discount 2',array('style'=>''));
							// 			$CI->make->th('Discount 3',array('style'=>''));
							// 			$CI->make->th('Client Code',array('style'=>''));
							// 			$CI->make->th('',array('style'=>''));
							// 		$CI->make->eRow();
							// 	$CI->make->eTable();
							// 	$CI->make->eDiv();
							// $CI->make->eDivCol();
						$CI->make->eDivRow();
							// $CI->make->button(
							// fa('fa-save').' Save Adjustments'
							// , array('class'=>'btn-block','id'=>'save-trans','style'=>'margin-top:10px','disabled'=>'disabled')
							// , 'primary');
					//$CI->make->eForm();
			// 	$CI->make->eBoxBody();
			// $CI->make->eBox();
		$CI->make->eDivCol();


	$CI->make->eDivRow();

	return $CI->make->code();
}
function poItemsLoad_OLD($po_items=null,$order_no=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol(3);
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sForm("purchasing/add_item",array('id'=>'add_item_form'));
						$CI->make->itemWithBarcodeListDrop('Item','item',null,'Select Item',array('class'=>'combobox forms this_item'));
						$CI->make->hidden('order_no',$order_no);
						$CI->make->hidden('item-id',null);
						$CI->make->hidden('item-uom',null);
						// $CI->make->hidden('item-ppack',null);
						// $CI->make->hidden('item-pcase',null);
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Quantity','quantity_ordered',null,null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->select('Unit','select-uom',array(),null,array('class'=>'rOkay forms','id'=>'select-uom'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->input('Price','unit_price','0',null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->input('QOH','qoh','0',null,array('class'=>'forms','readonly'=>true));
							$CI->make->eDivCol();
						$CI->make->eDivRow();

						$CI->make->datefield('Required Delivery Date','delivery_date',null,'',array('class'=>'rOkay forms'));
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								$CI->make->input('Discount1 %','discount_percent','0',null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Discount2 %','discount_percent2','0',null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Discount3 %','discount_percent3','0',null,array('class'=>'rOkay forms'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->input('Client Code','client_code',null,null,array('class'=>'rOkay forms'));
						// $CI->make->locationsDrop('Receiving Location','loc_id',null,null,array('shownames'=>true));
						$CI->make->button(fa('fa-plus').' Add Item',array('class'=>'btn-block','id'=>'add-item-btn'),'primary');
					$CI->make->eForm();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		#FORM
		$CI->make->sDivCol(9);
			// $CI->make->sBox('primary');
			// 	$CI->make->sBoxBody();
					//$CI->make->sForm("receiving/save",array('id'=>'receive_form'));
						$CI->make->sDivRow(array('id'=>'load-table-items'));
							// $CI->make->sDivCol();
							// 	$CI->make->sDiv(array('class'=>'table-responsive'));
							// 	$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
							// 		$CI->make->sRow();
							// 			$CI->make->th('Item');
							// 			$CI->make->th('Quantity',array('style'=>''));
							// 			$CI->make->th('Unit',array('style'=>''));
							// 			$CI->make->th('Required Delivery Date',array('style'=>''));
							// 			$CI->make->th('Price',array('style'=>''));
							// 			$CI->make->th('Discount 1',array('style'=>''));
							// 			$CI->make->th('Discount 2',array('style'=>''));
							// 			$CI->make->th('Discount 3',array('style'=>''));
							// 			$CI->make->th('Client Code',array('style'=>''));
							// 			$CI->make->th('',array('style'=>''));
							// 		$CI->make->eRow();
							// 	$CI->make->eTable();
							// 	$CI->make->eDiv();
							// $CI->make->eDivCol();
						$CI->make->eDivRow();
							// $CI->make->button(
							// fa('fa-save').' Save Adjustments'
							// , array('class'=>'btn-block','id'=>'save-trans','style'=>'margin-top:10px','disabled'=>'disabled')
							// , 'primary');
					//$CI->make->eForm();
			// 	$CI->make->eBoxBody();
			// $CI->make->eBox();
		$CI->make->eDivCol();


	$CI->make->eDivRow();

	return $CI->make->code();
}

function tableItems($po_items=null){
	$CI =& get_instance();
		//$CI->make->sDivRow();
			$CI->make->sDivCol(12);
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						//$CI->make->sForm("receiving/save",array('id'=>'receive_form'));
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow();
											$CI->make->th('Item');
											$CI->make->th('Quantity',array('style'=>''));
											$CI->make->th('Unit',array('style'=>''));
											$CI->make->th('Required Delivery Date',array('style'=>''));
											$CI->make->th('Price',array('style'=>''));
											$CI->make->th('Discount 1',array('style'=>''));
											$CI->make->th('Discount 2',array('style'=>''));
											$CI->make->th('Discount 3',array('style'=>''));
											$CI->make->th('Client Code',array('style'=>''));
											$CI->make->th('Line Total',array('style'=>''));
											$CI->make->th('',array('style'=>''));
										$CI->make->eRow();

										if($po_items == null){
											$CI->make->sRow();
											$CI->make->th('<br>No Items Found.<br>',array('colspan'=>'12','style'=>'text-align:center;'));
											$CI->make->eRow();
										}else{

											foreach($po_items as $val){
												$CI->make->sRow();
													$where = array('stock_id'=>$val->stock_id);
				                                    // $item_name = $CI->purchasing_model->get_details($where,'stock_master');
				                                    $item_name = $CI->purchasing_model->get_details($where,'supplier_stocks');
				                                    if($item_name){
				                                     	// $CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
				                                     	$CI->make->td('['.$item_name[0]->supp_stock_code.'] '.$item_name[0]->description);
				                                    }else{
				                                     	$CI->make->td('');
													}

													$CI->make->th(num($val->quantity_ordered),array('style'=>'text-align:center;'));
													$CI->make->th($val->uom,array('style'=>'text-align:center;'));
													$CI->make->th(sql2Date($val->delivery_date),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->unit_price),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent2),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent3),array('style'=>'text-align:center;'));
													$CI->make->th($val->client_code,array('style'=>'text-align:center;'));
													$CI->make->th(num($val->line_total),array('style'=>'text-align:center;'));
													$button = $CI->make->A(fa('fa-trash'),'#',array("class"=>'del-item','ref'=>$val->po_detail_item,'return'=>true));
		                                     		$CI->make->td($button);
												$CI->make->eRow();
											}

										}


									$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		//$CI->make->eDivRow();
	return $CI->make->code();
}
function tableItems_OLD($po_items=null){
	$CI =& get_instance();
		//$CI->make->sDivRow();
			$CI->make->sDivCol(12);
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						//$CI->make->sForm("receiving/save",array('id'=>'receive_form'));
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow();
											$CI->make->th('Item');
											$CI->make->th('Quantity',array('style'=>''));
											$CI->make->th('Unit',array('style'=>''));
											$CI->make->th('Required Delivery Date',array('style'=>''));
											$CI->make->th('Price',array('style'=>''));
											$CI->make->th('Discount 1',array('style'=>''));
											$CI->make->th('Discount 2',array('style'=>''));
											$CI->make->th('Discount 3',array('style'=>''));
											$CI->make->th('Client Code',array('style'=>''));
											$CI->make->th('Line Total',array('style'=>''));
											$CI->make->th('',array('style'=>''));
										$CI->make->eRow();

										if($po_items == null){
											$CI->make->sRow();
											$CI->make->th('<br>No Items Found.<br>',array('colspan'=>'12','style'=>'text-align:center;'));
											$CI->make->eRow();
										}else{

											foreach($po_items as $val){
												$CI->make->sRow();
													$where = array('id'=>$val->item_code);
				                                    $item_name = $CI->purchasing_model->get_details($where,'stock_master');
				                                    if($item_name)
				                                     	$CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
				                                    else
				                                     	$CI->make->td('');

													$CI->make->th(num($val->quantity_ordered),array('style'=>'text-align:center;'));
													$CI->make->th($val->stk_units,array('style'=>'text-align:center;'));
													$CI->make->th(sql2Date($val->delivery_date),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->unit_price),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent2),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent3),array('style'=>'text-align:center;'));
													$CI->make->th($val->client_code,array('style'=>'text-align:center;'));
													$CI->make->th(num($val->line_total),array('style'=>'text-align:center;'));
													$button = $CI->make->A(fa('fa-trash'),'#',array("class"=>'del-item','ref'=>$val->po_detail_item,'return'=>true));
		                                     		$CI->make->td($button);
												$CI->make->eRow();
											}

										}


									$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							// 	if($po_items == null){
							// 	$CI->make->sDivRow();
							// 		$CI->make->sDivCol(12);
							// 			$CI->make->append('<br>');
							//         		$CI->make->span('No Items Found.',array('style'=>'text-align:center;font-weight:bold;border:solid red 1px;'));
							//         	$CI->make->append('<br><br>');
					  //       		$CI->make->eDivCol();
							// 	$CI->make->eDivRow();
							// }
								// $CI->make->button(
								// fa('fa-save').' Save Adjustments'
								// , array('class'=>'btn-block','id'=>'save-trans','style'=>'margin-top:10px','disabled'=>'disabled')
								// , 'primary');
						//$CI->make->eForm();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		//$CI->make->eDivRow();
	return $CI->make->code();
}

function build_purch_order_inquiry()
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("purchasing/po_inquiry_results",array('id'=>'purch_order_search_form'));
						$CI->make->sDivCol(3);
							$CI->make->suppliersDrop('Supplier','supplier_id','','Select Supplier',array('class'=>'rOkay combobox'));
						$CI->make->eDivCol();
						// $CI->make->sDivCol(3,'left',0,array('id'=>'cust-branch-div'));
						// 	// $CI->make->customerBranchesDrop('Customer Branch','debtor_branch_id','','Select customer branch',array('class'=>''));
						// $CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Date range','daterange','','',array('class'=>'rOkay daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3,'left',0,array('style'=>'padding-top:2.3%;padding-bottom:2%;'));
							$CI->make->A(fa('fa-search').' Search for purchase orders','#',array('class'=>'btn btn-primary','id'=>'btn-search'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Outstanding Purchase Orders",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
}

function build_po_display($list)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Supplier Name' => array('width'=>'25%'),
					'Reference' => array('width'=>'10%'),
					'Order Date' => array('width'=>'10%'),
					"Supplier's Reference" => array('width'=>'10%'),
					"Receive Into" => array('width'=>'10%'),
					"Deliver To" => array('width'=>'20%'),
					' ' => array('width'=>'20%'),
					);
				$rows = array();
				foreach ($list as $val) {

					if($val->t_ordered != $val->t_received || !isset($val->t_ordered)){

						$link = $CI->make->A(
								fa('fa-pencil fa-2x fa-fw'),
								base_url().'purchasing/purchase_order_form/'.$val->order_id,
								array('return'=>'true',
									'title'=>'Edit this purchase order')
						);
						$link2 = $CI->make->A(
								fa('fa-mail-forward fa-2x fa-fw'),
								base_url().'purchasing/purchase_order_receive/'.$val->order_id,
								array('return'=>'true',
									'title'=>'Receive')
						);
						$link3 = $CI->make->A(
								fa('fa-times-circle fa-2x fa-fw'),
								'#',
								array('return'=>'true',
									'title'=>'Close',
									'class'=>'close_po',
									'ref'=>$val->order_id)
						);


						$where = array('supplier_id'=>$val->supplier_id);
	                    $supp_name = $CI->purchasing_model->get_details($where,'suppliers');
	                    if($supp_name)
	                     	$supplier_name = $supp_name[0]->supp_name;
	                    else
	                     	$supplier_name = '';

						$rows[] = array(
								$supplier_name,
								$val->reference,
								// array('text'=>number_format($val->order_total,2),'params'=>array('style'=>'text-align:right')),
								sql2Date($val->ord_date),
								$val->requisition_no,
								$val->into_stock_location,
								$val->delivery_address,
								array('text'=>$link."".$link2."".$link3,'params'=>array('style'=>'text-align:center'))
						);
					}
				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}

////////// Receive
function purchaseReceivePage($po=null,$po_id=null,$po_items=null,$type_no=null){
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right');
				$CI->make->A(fa('fa-reply').' Go Back',base_url().'purchasing/purch_outstanding',array('class'=>'btn btn-primary'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	// $CI->make->sDivRow();
	// 	$CI->make->sDivCol();
	// 		$CI->make->sTab();
	// 				$tabs = array(
	// 					fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'purchasing/details_load_receive/','id'=>'details_link'),
	// 					fa('fa-book')." Items"=>array('href'=>'#recipe','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'purchasing/items_load_receive/','id'=>'recipe_link'),
	// 				);
	// 				$CI->make->hidden('po_id',$po_id);
	// 				$CI->make->tabHead($tabs,null,array());
	// 				$CI->make->sTabBody();
	// 					$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
	// 					$CI->make->eTabPane();
	// 					$CI->make->sTabPane(array('id'=>'recipe','class'=>'tab-pane'));
	// 					$CI->make->eTabPane();
	// 				$CI->make->eTabBody();
	// 			$CI->make->eTab();
	// 	$CI->make->eDivCol();
	// $CI->make->eDivRow();

	//NEW
	$CI->make->sForm("",array('id'=>'invoice_header_details_form'));
	$CI->make->sDivRow();
		$CI->make->sDivCol(12);
			$CI->make->sBox('info');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(3);
							$CI->make->hidden('form_mod_id',$po_id);
							$CI->make->suppliersDrop('Supplier','supplier_id',iSetObj($po,'supplier_id'),'Select Supplier',array('class'=>'rOkay','readonly'=>'true'));
							$CI->make->input('For Purchase Order','reference',iSetObj($po,'reference'),'',array('style'=>'','class'=>'rOkay','readonly'=>'true'));
							$CI->make->datefield('Date Items Received','date_delivered',date('m/d/Y'),'',array('class'=>'rOkay'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->datefield('Order Date','ord_date',(iSetObj($po,'ord_date') ? sql2Date(iSetObj($po,'ord_date')) : date('m/d/Y')),'',array('class'=>'rOkay','readonly'=>'true'));
							$CI->make->input("Supplier's Reference",'requisition_no',iSetObj($po,'requisition_no'),'',array('class'=>'rOkay','readonly'=>'true'));
							$CI->make->taxTypeDrop('Tax Type','tax_type',null,null,array('class'=>'rOkay'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->inventoryLocationsDrop("Receive Into",'into_stock_location',iSetObj($po,'into_stock_location'),'',array('style'=>'','class'=>'rOkay'));
							$CI->make->textarea('Deliver To','delivery_address',iSetObj($po,'delivery_address'),'Type Address',array('class'=>'rOkay'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Invoice Reference No.','inv_reference','','',array('style'=>'','class'=>''));
							$CI->make->datefield('Invoice Date','due_date',date('m/d/Y'),'',array('class'=>'rOkay'));
							$CI->make->input("Terms",'terms',null,'CASH',array('class'=>'','readonly'=>'true'));
						$CI->make->eDivCol();
			    	$CI->make->eDivRow();
			  //   	$CI->make->sDivRow(array('style'=>'margin:10px;'));
					// 	$CI->make->sDivRow();
					// 		$CI->make->sDivCol(12);
					// 			$CI->make->textarea('Memo','comments',iSetObj($po,'comments'),'Type Memo',array('class'=>'','readonly'=>'true'));
					// 		$CI->make->eDivCol();
					// 	$CI->make->eDivRow();
					// $CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();


		// $CI->make->sDivCol(3);
		// 	$CI->make->sBox('info');
		// 		$CI->make->sBoxBody();
		// 			$CI->make->sDivRow();
		// 				$CI->make->sDivCol();
		// 					$CI->make->input('PR Reference','pr_ref','','Type PR #',array('maxlength'=>'15'));
		// 					$CI->make->input('SI Reference','si_ref','','Type SI #',array('maxlength'=>'15'));
		// 					$CI->make->input('BIR DR Reference','bir_dr_ref','','Type BIR DR #',array('maxlength'=>'15'));
		// 				$CI->make->eDivCol();
		// 			$CI->make->eDivRow();
		// 		$CI->make->eBoxBody();
		// 	$CI->make->eBox();
		// $CI->make->eDivCol();
	$CI->make->eDivRow();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('',array('class'=>'table-responsive','style'=>'border-top-color:#7E15FD'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(12);
						$CI->make->hidden('order_no',$po_id);
							$CI->make->sDivRow(array('id'=>'load-table-items'));

							$CI->make->eDivRow();
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	$CI->make->eForm();

	$CI->make->sDivRow();
		$CI->make->sDivCol(9);
			$CI->make->sBox('warning');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->textarea('Memo','comments',iSetObj($po,'comments'),'',array('maxlength'=>'255','style'=>'resize:vertical;','readonly'=>true));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		$CI->make->sDivCol(3,'center');
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$CI->make->button("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receive &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",array('class'=>'btn-lg','id'=>'receive-items'),'primary');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->append('<br>');

					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->button("Receive and Invoice",array('class'=>'btn-lg','id'=>'receive-and-invoice'),'primary');
						$CI->make->eDivCol();
					$CI->make->eDivRow();


				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function poHeaderDetailsLoadReceive($po=null,$po_id=null){
	$CI =& get_instance();
		$CI->make->sForm("purchasing/po_header_details_db",array('id'=>'po_header_details_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Update Details',array('id'=>'save-poheader'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					$CI->make->hidden('form_mod_id',$po_id);
					$CI->make->suppliersDrop('Supplier','supplier_id',iSetObj($po,'supplier_id'),'Select Supplier',array('class'=>'rOkay','readonly'=>'true'));
					$CI->make->input('For Purchase Order','reference',iSetObj($po,'reference'),'',array('style'=>'','class'=>'rOkay','readonly'=>'true'));
					$CI->make->datefield('Date Items Received','date_delivered',date('m/d/Y'),'',array('class'=>'rOkay'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->datefield('Order Date','ord_date',(iSetObj($po,'ord_date') ? sql2Date(iSetObj($po,'ord_date')) : date('m/d/Y')),'',array('class'=>'rOkay','readonly'=>'true'));
					$CI->make->input("Supplier's Reference",'requisition_no',iSetObj($po,'requisition_no'),'',array('class'=>'rOkay','readonly'=>'true'));
					// $CI->make->salesTypesDrop('Price List','type',iSetObj($po,'type'));
					// $CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->inventoryLocationsDrop("Receive Into",'into_stock_location',iSetObj($po,'into_stock_location'),'',array('style'=>'','class'=>'rOkay'));
					$CI->make->textarea('Deliver To','delivery_address',iSetObj($po,'delivery_address'),'Type Address',array('class'=>'rOkay'));
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();


			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(12);
						$CI->make->textarea('Memo','comments',iSetObj($po,'comments'),'Type Memo',array('class'=>'','readonly'=>'true'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivRow();

			// $CI->make->sDivRow();
				// $CI->make->sDivCol(4,'left',4);
					// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
function poItemsLoadReceive($po_items=null,$order_no=null){
	$CI =& get_instance();
	$CI->make->sDivRow();


		$CI->make->sDivCol(12);
			$CI->make->hidden('order_no',$order_no);
				$CI->make->sDivRow(array('id'=>'load-table-items'));

				$CI->make->eDivRow();
		$CI->make->eDivCol();


	$CI->make->eDivRow();

	return $CI->make->code();
}
function tableItemsReceived($po_items=null){
	$CI =& get_instance();
		//$CI->make->sDivRow();
			// $CI->make->sDivCol(12,'right');
			// 	$CI->make->button(fa('fa-save').' Receive Items',array('id'=>'receive-items'),'primary');
			// $CI->make->eDivCol();
			// $CI->make->append('<br><br><br>');
			$CI->make->sDivCol(12);
				// $CI->make->sBox('primary');
				// 	$CI->make->sBoxBody();
						//$CI->make->sForm("",array('id'=>'receive_form'));
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow();
											$CI->make->th('Item');
											$CI->make->th('Ordered',array('style'=>''));
											$CI->make->th('Unit',array('style'=>''));
											$CI->make->th('Received',array('style'=>''));
											$CI->make->th('Outstanding',array('style'=>''));
											$CI->make->th('This Delivery',array('style'=>''));
											$CI->make->th('Price',array('style'=>''));
											$CI->make->th('Discount1 %',array('style'=>''));
											$CI->make->th('Discount2 %',array('style'=>''));
											$CI->make->th('Discount3 %',array('style'=>''));
											$CI->make->th('Client Code',array('style'=>''));
											$CI->make->th('Total',array('style'=>''));
											//$CI->make->th('',array('style'=>''));
										$CI->make->eRow();

										if($po_items == null){
											$CI->make->sRow();
											$CI->make->th('<br>No Items Found.<br>',array('colspan'=>'12','style'=>'text-align:center;'));
											$CI->make->eRow();
										}else{

											foreach($po_items as $val){
												$CI->make->sRow();
													$where = array('id'=>$val->item_code);
				                                    $item_name = $CI->purchasing_model->get_details($where,'stock_master');
				                                    if($item_name)
				                                     	$CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
				                                    else
				                                     	$CI->make->td('');

													$CI->make->th(num($val->quantity_ordered),array('style'=>'text-align:center;'));
													$CI->make->th($val->stk_units,array('style'=>'text-align:center;'));
													$CI->make->th(num($val->quantity_received),array('style'=>'text-align:center;'));
													$outstanding = $val->quantity_ordered - $val->quantity_received;
													$hid_outstanding = $CI->make->hidden('hid_outstanding_'.$val->po_detail_item,$outstanding,array('return'=>true));
													$CI->make->th(num($outstanding)."".$hid_outstanding,array('style'=>'text-align:center;'));
													if($outstanding != 0){
														$tbox = $CI->make->input('','delivery['.$val->po_detail_item.']',$outstanding,null,array('class'=>'t_delivery','return'=>'true','ref'=>$val->po_detail_item,'style'=>'width:80px;text-align:right;height:21px;'));
														$CI->make->th($tbox,array('style'=>'text-align:center;'));
													}else{
														$CI->make->th(num($outstanding),array('style'=>'text-align:center;'));
													}
													$price = $outstanding * $val->unit_price;
													$CI->make->th(num($val->unit_price),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent2),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent3),array('style'=>'text-align:center;'));
													$CI->make->th($val->client_code,array('style'=>'text-align:center;'));
													$CI->make->th(num($val->line_total),array('style'=>'text-align:center;'));
													// $button = $CI->make->A(fa('fa-trash'),'#',array("class"=>'del-item','ref'=>$val->po_detail_item,'return'=>true));
		           //                           		$CI->make->td($button);
												$CI->make->eRow();
											}

										}


									$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							// 	if($po_items == null){
							// 	$CI->make->sDivRow();
							// 		$CI->make->sDivCol(12);
							// 			$CI->make->append('<br>');
							//         		$CI->make->span('No Items Found.',array('style'=>'text-align:center;font-weight:bold;border:solid red 1px;'));
							//         	$CI->make->append('<br><br>');
					  //       		$CI->make->eDivCol();
							// 	$CI->make->eDivRow();
							// }
								// $CI->make->button(
								// fa('fa-save').' Save Adjustments'
								// , array('class'=>'btn-block','id'=>'save-trans','style'=>'margin-top:10px','disabled'=>'disabled')
								// , 'primary');
						//$CI->make->eForm();
					//$CI->make->eBoxBody();
				//$CI->make->eBox();
			$CI->make->eDivCol();
		//$CI->make->eDivRow();
	return $CI->make->code();
}

/////////////////Inquiry///////////////////////////
////////////////////////////////////////////////////
function build_po_inquiry()
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("purchasing/po_inquiry_detail_results",array('id'=>'purch_order_search_form'));
						$CI->make->sDivCol(3);
							$CI->make->suppliersDrop('Supplier','supplier_id','','Select Supplier',array('class'=>'rOkay combobox'));
						$CI->make->eDivCol();
						// $CI->make->sDivCol(3,'left',0,array('id'=>'cust-branch-div'));
						// 	// $CI->make->customerBranchesDrop('Customer Branch','debtor_branch_id','','Select customer branch',array('class'=>''));
						// $CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Date range','daterange','','',array('class'=>'daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->userDrop('Created By','person_id','','Select User',array('class'=>'combobox'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3,'left',0,array('style'=>'padding-top:2.3%;padding-bottom:2%;'));
							$CI->make->A(fa('fa-search').' Search for purchase orders','#',array('class'=>'btn btn-primary','id'=>'btn-search'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Outstanding Purchase Orders",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function build_po_inq_display($list)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Supplier Name' => array('width'=>'22%'),
					'Reference' => array('width'=>'5%'),
					'Order Date' => array('width'=>'7%'),
					"Supplier's Reference" => array('width'=>'10%'),
					"Receive Into" => array('width'=>'10%'),
					"Deliver To" => array('width'=>'20%'),
					"Created By" => array('width'=>'14%'),
					' ' => array(),
					);
				$rows = array();
				foreach ($list as $val) {

					//if($val->t_ordered != $val->t_received || !isset($val->t_ordered)){

						$link = $CI->make->A(
								fa('fa-eye fa-lg fa-fw'),
								base_url().'purchasing/po_inquiry_form/'.$val->order_no,
								array('return'=>'true',
									'title'=>'View this purchase order')
						);
						$link .= $CI->make->A(
								fa('fa-file-pdf-o fa-lg fa-fw'),
								base_url().'purchasing/po_print_pdf/'.$val->order_no,
								array('return'=>'true',
									'title'=>'Download PDF copy',
									'class'=>'dwn-btn',
									'icon'=>'fa fa-file-pdf-o fa-lg fa-fw')
						);
						$link .= $CI->make->A(
								fa('fa-file-excel-o fa-lg fa-fw'),
								base_url().'purchasing/po_print_excel/'.$val->order_no,
								array('return'=>'true',
									'title'=>'Download excel copy',
									'class'=>'dwn-btn',
									'icon'=>'fa fa-file-excel-o fa-lg fa-fw')
						);
						// $link2 = $CI->make->A(
						// 		fa('fa-mail-forward fa-lg fa-fw'),
						// 		base_url().'purchasing/purchase_order_receive/'.$val->order_no,
						// 		array('return'=>'true',
						// 			'title'=>'Receive')
						// );
						// $link3 = $CI->make->A(
						// 		fa('fa-times-circle fa-lg fa-fw'),
						// 		'#',
						// 		array('return'=>'true',
						// 			'title'=>'Close',
						// 			'class'=>'close_po',
						// 			'ref'=>$val->order_no)
						// );


						$where = array('supplier_id'=>$val->supplier_id);
	                    $supp_name = $CI->purchasing_model->get_details($where,'suppliers');
	                    if($supp_name)
	                     	$supplier_name = $supp_name[0]->supp_name;
	                    else
	                     	$supplier_name = '';

	                    $where = array('id'=>$val->person_id);
	                    $user = $CI->purchasing_model->get_details($where,'users');
	                    $user_name = $user[0]->fname." ".$user[0]->lname;

						$rows[] = array(
								$supplier_name,
								$val->reference,
								// array('text'=>number_format($val->order_total,2),'params'=>array('style'=>'text-align:right')),
								sql2Date($val->ord_date),
								$val->requisition_no,
								$val->into_stock_location,
								$val->delivery_address,
								$user_name,
								// array('text'=>$link."".$link2."".$link3,'params'=>array('style'=>'text-align:center'))
								array('text'=>$link,'params'=>array('style'=>'text-align:center'))
						);
					//}
				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}
function purchaseHeaderPageInquiry($po_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right');
					$CI->make->A(fa('fa-reply').' Go Back',base_url().'purchasing/purch_order_inquiry',array('class'=>'btn btn-primary'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'purchasing/details_load_inq/','id'=>'details_link'),
						fa('fa-book')." Items"=>array('href'=>'#recipe','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'purchasing/items_load_inquiry/','id'=>'recipe_link'),
					);
					$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'recipe','class'=>'tab-pane'));
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function poHeaderDetailsInquiry($po=null,$po_id=null, $type_no=null){
	$CI =& get_instance();
		$CI->make->sForm("purchasing/po_header_details_db",array('id'=>'po_header_details_form'));
			$CI->make->sDivRow();
				// $CI->make->sDivCol(12,'right');
				// 	$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-poheader'),'primary');
				// $CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					$CI->make->hidden('form_mod_id',$po_id);
					$CI->make->suppliersDrop('Supplier','supplier_id',iSetObj($po,'supplier_id'),'Select Supplier',array('class'=>'rOkay','readonly'=>'true'));
					if($po_id == null)
						$CI->make->input('Reference','reference',$type_no,'',array('style'=>'','class'=>'rOkay','readonly'=>'true'));
					else
						$CI->make->input('Reference','reference',$po->reference,'',array('style'=>'','class'=>'rOkay','readonly'=>'true'));

				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->datefield('Order Date','ord_date',(iSetObj($po,'ord_date') ? sql2Date(iSetObj($po,'ord_date')) : date('m/d/Y')),'',array('class'=>'rOkay','readonly'=>'true'));
					$CI->make->input("Supplier's Reference",'requisition_no',iSetObj($po,'requisition_no'),'',array('class'=>'rOkay','readonly'=>'true'));
					// $CI->make->salesTypesDrop('Price List','type',iSetObj($po,'type'));
					// $CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->inventoryLocationsDrop("Receive Into",'into_stock_location',iSetObj($po,'into_stock_location'),'',array('style'=>'','class'=>'rOkay','readonly'=>'true'));
					$CI->make->textarea('Deliver To','delivery_address',iSetObj($po,'delivery_address'),'Type Address',array('class'=>'rOkay','readonly'=>'true'));
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();


			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(12);
						$CI->make->textarea('Memo','comments',iSetObj($po,'comments'),'Type Memo',array('class'=>'','readonly'=>'true'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivRow();

			// $CI->make->sDivRow();
				// $CI->make->sDivCol(4,'left',4);
					// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
function poItemsLoadInquiry($po_items=null,$order_no=null){
	$CI =& get_instance();
	$CI->make->sDivRow();


		$CI->make->sDivCol(12);
			$CI->make->hidden('order_no',$order_no);
				$CI->make->sDivRow(array('id'=>'load-table-items'));

				$CI->make->eDivRow();
		$CI->make->eDivCol();


	$CI->make->eDivRow();

	return $CI->make->code();
}

function tableItems_inquiry($po_items=null,$delivery=null){
	$CI =& get_instance();
		//$CI->make->sDivRow();
			$CI->make->sDivCol(12);
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						//$CI->make->sForm("receiving/save",array('id'=>'receive_form'));
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow();
											$CI->make->th('Item');
											$CI->make->th('Quantity',array('style'=>''));
											$CI->make->th('Unit',array('style'=>''));
											$CI->make->th('Required Delivery Date',array('style'=>''));
											$CI->make->th('Price',array('style'=>''));
											$CI->make->th('Discount 1',array('style'=>''));
											$CI->make->th('Discount 2',array('style'=>''));
											$CI->make->th('Discount 3',array('style'=>''));
											$CI->make->th('Client Code',array('style'=>''));
											$CI->make->th('Line Total',array('style'=>''));
											//$CI->make->th('',array('style'=>''));
										$CI->make->eRow();

										if($po_items == null){
											$CI->make->sRow();
											$CI->make->th('<br>No Items Found.<br>',array('colspan'=>'12','style'=>'text-align:center;'));
											$CI->make->eRow();
										}else{
											$gtotal = 0;
											foreach($po_items as $val){
												$CI->make->sRow();
													$where = array('id'=>$val->item_code);
				                                    $item_name = $CI->purchasing_model->get_details($where,'stock_master');
				                                    if($item_name)
				                                     	$CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
				                                    else
				                                     	$CI->make->td('');

													$CI->make->th(num($val->quantity_ordered),array('style'=>'text-align:center;'));
													$CI->make->th($val->stk_units,array('style'=>'text-align:center;'));
													$CI->make->th(sql2Date($val->delivery_date),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->unit_price),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent2),array('style'=>'text-align:center;'));
													$CI->make->th(num($val->discount_percent3),array('style'=>'text-align:center;'));
													$CI->make->th($val->client_code,array('style'=>'text-align:center;'));
													$CI->make->th(num($val->line_total),array('style'=>'text-align:center;'));
													// $button = $CI->make->A(fa('fa-trash'),'#',array("class"=>'del-item','ref'=>$val->po_detail_item,'return'=>true));
		           //                           		$CI->make->td($button);
													$gtotal += $val->line_total;
												$CI->make->eRow();
											}
										}


									$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							if($delivery != null){
								$CI->make->sDivRow();
									$CI->make->sDivCol(12);
										$CI->make->append('<br><br>');
							        		$CI->make->H(4,"Received Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
							        	$CI->make->append('<br>');
					        		$CI->make->eDivCol();
								$CI->make->eDivRow();
								$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow();
											$CI->make->th('Item');
											$CI->make->th('Quantity',array('style'=>''));
											$CI->make->th('Unit',array('style'=>''));
											$CI->make->th('Date Received',array('style'=>''));
											$CI->make->th('Price',array('style'=>''));
											$CI->make->th('Discount 1',array('style'=>''));
											$CI->make->th('Discount 2',array('style'=>''));
											$CI->make->th('Discount 3',array('style'=>''));
											$CI->make->th('Line Total',array('style'=>''));
											//$CI->make->th('',array('style'=>''));
										$CI->make->eRow();



										foreach($delivery as $val){
											$CI->make->sRow();
												$where = array('id'=>$val->item_id);
			                                    $item_name = $CI->purchasing_model->get_details($where,'stock_master');
			                                    if($item_name)
			                                     	$CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
			                                    else
			                                     	$CI->make->td('');

												$CI->make->th(num($val->qty_received),array('style'=>'text-align:center;'));
												$CI->make->th($val->stk_units,array('style'=>'text-align:center;'));
												$CI->make->th(sql2Date($val->date_delivered),array('style'=>'text-align:center;'));
												$CI->make->th(num($val->unit_price),array('style'=>'text-align:center;'));
												$CI->make->th(num($val->discount_percent),array('style'=>'text-align:center;'));
												$CI->make->th(num($val->discount_percent2),array('style'=>'text-align:center;'));
												$CI->make->th(num($val->discount_percent3),array('style'=>'text-align:center;'));
												$CI->make->th(num($val->line_total),array('style'=>'text-align:center;'));
												//$button = $CI->make->A(fa('fa-trash'),'#',array("class"=>'del-item','ref'=>$val->po_detail_item,'return'=>true));
	                                     		//$CI->make->td($button);
											$CI->make->eRow();
										}




									$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
								$CI->make->eDivRow();

							}
								// $CI->make->button(
								// fa('fa-save').' Save Adjustments'
								// , array('class'=>'btn-block','id'=>'save-trans','style'=>'margin-top:10px','disabled'=>'disabled')
								// , 'primary');
						//$CI->make->eForm();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		//$CI->make->eDivRow();
	return $CI->make->code();
}

////////////////////supp invoice////////////////////////////
////////////////////supp invoice////////////////////////////
function suppInvoiceForm($rec=null){
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save fa-fw').' Enter Invoice',array('id'=>'invoice-btn'),'primary');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sForm("purchasing/supp_invoice_db",array('id'=>'supp_inv_form'));
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'','load'=>'purchasing/supp_header_load/','id'=>'details_link'),
						fa('fa-book')." Items Received"=>array('href'=>'#received','class'=>'tab_link load-tab','load'=>'purchasing/supp_invoice_item/','id'=>'received_link'),
						fa('fa-book')." Invoice Sheet"=>array('href'=>'#added','class'=>'load-tab','load'=>'#','id'=>'added_link')
					);
					//$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'received','class'=>'tab-pane'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'added','class'=>'tab-pane'));
							// $CI->make->sDivRow();
							// 	$CI->make->sDivCol(12,'center');
						 //        		$CI->make->H(4,"No Items for Invoice Found.",array('style'=>'margin-top:0px;margin-bottom:0px'));
						 //        	$CI->make->append('<br>');
				   //      		$CI->make->eDivCol();
							// $CI->make->eDivRow();
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
				$CI->make->eForm();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}

function suppInvHead($type_no=null){
	$CI =& get_instance();
		//$CI->make->sForm("purchasing/po_header_details_db",array('id'=>'po_header_details_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					//$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-poheader'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					// $CI->make->hidden('form_mod_id',$po_id);
					$CI->make->suppliersDrop('Supplier','supplier_id',null,'Select Supplier',array('class'=>'rOkay combobox'));
					$CI->make->input('Reference No.','reference',$type_no,'',array('style'=>'','class'=>'rOkay'));
					$CI->make->input("Supplier's Reference",'supp_reference',null,'',array('class'=>'rOkay'));


				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->datefield('Date','trans_date',date('m/d/Y'),'',array('class'=>'rOkay'));
					$CI->make->datefield('Due Date','due_date',date('m/d/Y'),'',array('class'=>'rOkay'));
					$CI->make->input("Terms",'terms',null,'CASH',array('class'=>'','readonly'=>'true'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					$CI->make->taxTypeDrop('Tax Type','tax_type',null,null,array('class'=>'rOkay'));
					//$CI->make->input("Tax Group",'terms',null,'CASH',array('class'=>'rOkay','readonly'=>'true'));
					// $CI->make->textarea('Deliver To','delivery_address',iSetObj($po,'delivery_address'),'Type Address',array('class'=>'rOkay'));
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();


			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(12);
						$CI->make->textarea('Memo','comments',null,'Type Memo',array('class'=>''));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivRow();

			// $CI->make->sDivRow();
				// $CI->make->sDivCol(4,'left',4);
					// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader'),'primary');
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();

		//$CI->make->eForm();
	return $CI->make->code();
}
function tableItems_suppinvoice($delivery=null,$supp_sess=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
			$CI->make->sDivCol(12);
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						//$CI->make->sForm("receiving/save",array('id'=>'receive_form'));
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));

									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							if($delivery != null){
								$CI->make->sDivRow();
									$CI->make->sDivCol(12);
							        		$CI->make->H(4,"Received Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
							        	$CI->make->append('<br>');
					        		$CI->make->eDivCol();
								$CI->make->eDivRow();
								$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow();
											$CI->make->th('Item');
											$CI->make->th('Received On',array('style'=>''));
											$CI->make->th('Quantity Received',array('style'=>''));
											$CI->make->th('Quantity Invoiced',array('style'=>''));
											$CI->make->th('Qty Yet To Invoice',array('style'=>''));
											$CI->make->th('Order Price',array('style'=>''));
											$CI->make->th('Discount1 %',array('style'=>''));
											$CI->make->th('Discount2 %',array('style'=>''));
											$CI->make->th('Discount3 %',array('style'=>''));
											$CI->make->th('Total',array('style'=>''));
											$CI->make->th('',array('style'=>''));
										$CI->make->eRow();


										$gtotal = 0;
										foreach($delivery as $val){

											if($val->qty_received != $val->qty_invoice){

												$checker = array_key_exists($val->delivery_id, $supp_sess);
												if($checker){
													$CI->make->sRow(array('id'=>'deliv-row-'.$val->delivery_id,'style'=>'display:none;'));
												}else{
													$CI->make->sRow(array('id'=>'deliv-row-'.$val->delivery_id));
												}


														// $CI->make->sRow(array('id'=>'deliv-row-'.$val->delivery_id));
														$where = array('id'=>$val->item_id);
					                                    $item_name = $CI->purchasing_model->get_details($where,'stock_master');
					                                    if($item_name)
					                                     	$CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
					                                    else
					                                     	$CI->make->td('');

														$CI->make->th(sql2Date($val->date_delivered),array('style'=>'text-align:center;'));
														$CI->make->th(num($val->qty_received),array('style'=>'text-align:center;'));
														$CI->make->hidden('hinvoice',$val->qty_invoice,array('class'=>'hid-inv-'.$val->delivery_id));
														$CI->make->th(num($val->qty_invoice),array('style'=>'text-align:center;'));
														//$CI->make->th($val->stk_units,array('style'=>'text-align:center;'));

														$toinvoice = $val->qty_received - $val->qty_invoice;
														$hid_tinoice = $CI->make->hidden('hid_tinvoice_'.$val->delivery_id,$toinvoice,array());
														$tbox = $CI->make->input('','toinvoice',$toinvoice,null,array('class'=>'toinvoice','id'=>'toinv-'.$val->delivery_id,'return'=>'true','ref'=>$val->delivery_id,'style'=>'width:80px;text-align:right;height:21px;'));
														$CI->make->th($tbox."".$hid_tinoice,array('style'=>'text-align:center;'));

														// $tbox = $CI->make->input('','unit_price',$val->unit_price,null,array('class'=>'unit_price','return'=>'true','ref'=>$val->delivery_id,'style'=>'width:80px;text-align:right;height:21px;'));
														// $CI->make->th($tbox,array('style'=>'text-align:center;'));

														$CI->make->th(num($val->unit_price),array('style'=>'text-align:center;'));
														$CI->make->th(num($val->discount_percent),array('style'=>'text-align:center;'));
														$CI->make->th(num($val->discount_percent2),array('style'=>'text-align:center;'));
														$CI->make->th(num($val->discount_percent3),array('style'=>'text-align:center;'));

														/////compute for the line total
														$line_total = $toinvoice * $val->unit_price;
										                $vals = $val->unit_price;
										                if($val->discount_percent != 0){
										                    $disc1 = $val->discount_percent / 100;
										                    $disc1_val = $val->unit_price * $disc1;

										                    $vals = $val->unit_price - $disc1_val;

										                    if($val->discount_percent2 != 0){
										                        $disc2 = $val->discount_percent2 / 100;
										                        $vals2 = $vals * $disc2;
										                        $vals = $vals - $vals2;

										                        if($val->discount_percent3 != 0){
										                            $disc3 = $val->discount_percent3 / 100;
										                            $vals3 = $vals * $disc3;
										                            $vals = $vals - $vals3;
										                        }

										                    }

										                    $line_total = $vals * $toinvoice;
										                }

														$CI->make->th(num($line_total),array('style'=>'text-align:center;'));
														$button = $CI->make->A(fa('fa-check fa-lg'),'#',array("class"=>'add-item','ref'=>$val->delivery_id,'return'=>true,'po-ref'=>$val->po_detail_item,'line-total'=>$line_total));
			                                     		$CI->make->td($button);

			                                     		$gtotal += $line_total;
													$CI->make->eRow();

											}

										}

										// $CI->make->sRow();
										// 	$CI->make->th('<b>TOTAL</b>',array('style'=>'text-align:right;','colspan'=>'9'));
										// 	$span = $CI->make->span(num($gtotal),array('return'=>true,'id'=>'totalspan'));
										// 	$CI->make->th($span,array('style'=>'text-align:right;','colspan'=>'1','id'=>'totalth'));
										// 	$CI->make->th('',array('style'=>'text-align:right;','colspan'=>'1'));
										// $CI->make->eRow();


									$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
								$CI->make->eDivRow();

							}
								// $CI->make->button(
								// fa('fa-save').' Save Adjustments'
								// , array('class'=>'btn-block','id'=>'save-trans','style'=>'margin-top:10px','disabled'=>'disabled')
								// , 'primary');
						//$CI->make->eForm();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function tableItems_addedinvoice($supp_sess=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
			$CI->make->sDivCol(12);
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						//$CI->make->sForm("receiving/save",array('id'=>'receive_form'));
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));

									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							if($supp_sess != null){
								$CI->make->sDivRow();
									$CI->make->sDivCol(12);
							        		$CI->make->H(4,"Added Items For Invoice",array('style'=>'margin-top:0px;margin-bottom:0px'));
							        	$CI->make->append('<br>');
					        		$CI->make->eDivCol();
								$CI->make->eDivRow();
								$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow();
											$CI->make->th('Item');
											$CI->make->th('Received On',array('style'=>''));
											$CI->make->th('Quantity Received',array('style'=>''));
											$CI->make->th('Quantity Invoiced',array('style'=>''));
											$CI->make->th('Qty Yet To Invoice',array('style'=>''));
											$CI->make->th('Order Price',array('style'=>''));
											$CI->make->th('Discount1 %',array('style'=>''));
											$CI->make->th('Discount2 %',array('style'=>''));
											$CI->make->th('Discount3 %',array('style'=>''));
											$CI->make->th('Total',array('style'=>''));
											$CI->make->th('',array('style'=>''));
										$CI->make->eRow();


										$gtotal = 0;
										foreach($supp_sess as $key => $val){
											//$CI->make->th($key."--".$val['val']);
											$CI->make->sRow(array('id'=>'added-row-'.$val['ref']));
												$where = array('delivery_details.delivery_id'=>$val['ref']);
												$detail = $CI->purchasing_model->get_delivery_items($where);
												$det = $detail[0];


												$where = array('id'=>$det->item_id);
			                                    $item_name = $CI->purchasing_model->get_details($where,'stock_master');
			                                    if($item_name)
			                                     	$CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
			                                    else
			                                     	$CI->make->td('');

												$CI->make->th(sql2Date($det->date_delivered),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->qty_received),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->qty_invoice),array('style'=>'text-align:center;'));
												// //$CI->make->th($val->stk_units,array('style'=>'text-align:center;'));

												// $toinvoice = $val->qty_received - $val->qty_invoice;
												// $tbox = $CI->make->input('','toinvoice',$toinvoice,null,array('class'=>'toinvoice','id'=>'toinv-'.$val->delivery_id,'return'=>'true','ref'=>$val->delivery_id,'style'=>'width:80px;text-align:right;height:21px;'));
												$CI->make->th(num($val['val']),array('style'=>'text-align:center;'));

												// // $tbox = $CI->make->input('','unit_price',$val->unit_price,null,array('class'=>'unit_price','return'=>'true','ref'=>$val->delivery_id,'style'=>'width:80px;text-align:right;height:21px;'));
												// // $CI->make->th($tbox,array('style'=>'text-align:center;'));

												$CI->make->th(num($det->unit_price),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->discount_percent),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->discount_percent2),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->discount_percent3),array('style'=>'text-align:center;'));

												/////compute for the line total
												$line_total = $val['val'] * $det->unit_price;
								                $vals = $det->unit_price;
								                if($det->discount_percent != 0){
								                    $disc1 = $det->discount_percent / 100;
								                    $disc1_val = $det->unit_price * $disc1;

								                    $vals = $det->unit_price - $disc1_val;

								                    if($det->discount_percent2 != 0){
								                        $disc2 = $det->discount_percent2 / 100;
								                        $vals2 = $vals * $disc2;
								                        $vals = $vals - $vals2;

								                        if($det->discount_percent3 != 0){
								                            $disc3 = $det->discount_percent3 / 100;
								                            $vals3 = $vals * $disc3;
								                            $vals = $vals - $vals3;
								                        }

								                    }

								                    $line_total = $vals * $val['val'];
								                }


								                //$CI->make->hidden('hline_total',$line_total,array('class'=>'hid_linetotal'));
												$CI->make->th(num($line_total),array('style'=>'text-align:center;'));
												$button = $CI->make->A(fa('fa-times fa-lg'),'#',array("class"=>'edit-item','ref'=>$val['ref'],'return'=>true));
	                                     		$CI->make->td($button);

	                                     		$gtotal += $line_total;
											$CI->make->eRow();
										}

										$CI->make->sRow();
											$CI->make->hidden('hline_total',$gtotal,array('class'=>'hid_linetotal'));
											$CI->make->th('<b>TOTAL</b>',array('style'=>'text-align:right;','colspan'=>'9'));
											$span = $CI->make->span(num($gtotal),array('return'=>true,'id'=>'totalspan'));
											$CI->make->th($span,array('style'=>'text-align:right;','colspan'=>'1','id'=>'totalth'));
											$CI->make->th('',array('style'=>'text-align:right;','colspan'=>'1'));
										$CI->make->eRow();


									$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
								$CI->make->eDivRow();

							}else{
								$CI->make->sDivRow();
									$CI->make->sDivCol(12,'center');
							        		$CI->make->H(4,"No Items for Invoice Found.",array('style'=>'margin-top:0px;margin-bottom:0px'));
							        	$CI->make->append('<br>');
					        		$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
								// $CI->make->button(
								// fa('fa-save').' Save Adjustments'
								// , array('class'=>'btn-block','id'=>'save-trans','style'=>'margin-top:10px','disabled'=>'disabled')
								// , 'primary');
						//$CI->make->eForm();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}

//////////////////////supp payment/////////////////////////
//////////////////////supp payment/////////////////////////
function suppPaymentHeaderPage($so_id=null){
	$CI =& get_instance();
		$CI->make->sDivCol();
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Payment Details"=>array('href'=>'#details','class'=>'','load'=>'purchasing/supp_payment_details_load/','id'=>'details_link'),
						//fa('fa-book')." Supplier Allocation"=>array('href'=>'#supp_alloc','class'=>'load-tab','load'=>'sales/so_items_load/','id'=>'so_items_link'),
					);
					$CI->make->hidden('so_id',$so_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'supp_alloc','class'=>'tab-pane'));

						$CI->make->sForm("purchasing/supp_allocation_results",array('id'=>'supp_alloc_search_form'));
							$CI->make->sDivRow(array('style'=>'margin:5px;'));
								$CI->make->sBox('success',array('div-form'));
									$CI->make->sBoxBody();
										$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
											$CI->make->sForm("purchasing/po_inquiry_results",array('id'=>'purch_order_search_form'));
												$CI->make->sDivCol(4);
													$CI->make->suppliersDrop('Supplier','supplier_id','','Select Supplier',array('class'=>'rOkay combobox'));
												$CI->make->eDivCol();
												// $CI->make->sDivCol(3,'left',0,array('id'=>'cust-branch-div'));
												// 	// $CI->make->customerBranchesDrop('Customer Branch','debtor_branch_id','','Select customer branch',array('class'=>''));
												// $CI->make->eDivCol();
												$CI->make->sDivCol(3);
													$CI->make->input('Date range','daterange','','',array('class'=>'daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
												$CI->make->eDivCol();
												// $CI->make->sDivCol(2,'left',0,array('style'=>'padding-top:22px;'));
												// 	$CI->make->checkbox('Show Settled Items','show_settled','',array('class'=>'','style'=>'','value'=>'0'));
												// $CI->make->eDivCol();
												$CI->make->sDivCol(3,'left',0,array('style'=>'padding-top:2.3%;padding-bottom:2%;'));
													$CI->make->A(fa('fa-search').' Search for Supplier Allocation','#',array('class'=>'btn btn-primary','id'=>'btn-search'));
												$CI->make->eDivCol();
											$CI->make->eForm();
										$CI->make->eDivRow();
									$CI->make->eBoxBody();
								$CI->make->eBox();

								$CI->make->sBox('info',array('id'=>'div-results-view','style'=>'min-height:350px;'));
									$CI->make->sBoxBody();
										$CI->make->H('2',"Please select search parameters for Supplier Allocation",array('style'=>'text-align:center;color:#808080;'));
									$CI->make->eBoxBody();
								$CI->make->eBox();
							$CI->make->eDivRow();
						$CI->make->eForm();


						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function spHeaderDetailsLoad($type_no=null){
	$CI =& get_instance();
		$CI->make->sForm("purchasing/supp_payment_db",array('id'=>'supp_payment_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Enter Payment',array('id'=>'save-payment'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					//$CI->make->hidden('form_mod_id',$so_id);
					$CI->make->bankAccountsDrop('From Bank Account','into_bank_acct','', '', array('class'=>'rOkay'));
					// $CI->make->customerBranchesDrop('Branch','debtor_branch_id',iSetObj($so,'debtor_branch_id'), 'select', array('class'=>'rOkay'));
					$CI->make->input('Amount','amount','0','',array('style'=>'', 'class'=>'rOkay numbers-only'));
					$CI->make->input('Amount of Discount','amount_discount','0','',array('style'=>'', 'class'=>'rOkay numbers-only'));
					$CI->make->input('EWT (1%)','ewt','0','',array('style'=>'', 'class'=>'rOkay numbers-only'));
				$CI->make->eDivCol();

				$CI->make->sDivCol(4);
					$CI->make->suppliersDrop('Payment To','supplier_id',null, 'Select Supplier', array('class'=>'rOkay combobox'));
					$CI->make->bankPaymentTypeDrop('Type','bank_payment_type','', '', array('class'=>'rOkay'));
					$CI->make->input("Supplier's Reference",'supp_ref','',null,array('class'=>'rOkay'));
					$CI->make->datefield('Date Paid / Collection Date','order_date', date('m/d/Y'),'',array('class'=>'rOkay'));
					// $CI->make->bankAccountsDrop('Into Bank Account','into_bank_acct','', '', array('class'=>'rOkay'));
				$CI->make->eDivCol();

				$CI->make->sDivCol(4);
					$CI->make->input('Reference','reference',$type_no,'Type Reference',array('class'=>'rOkay'));
					// // $CI->make->input('Memo','memo','','',array('class'=>'rOkay'));
					$CI->make->textarea('Memo','memo','','Type Memo',array('class'=>'rOkay'));
					// // $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-soheader', 'style'=>'float: right;'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			// $CI->make->sDivRow(array('style'=>'margin:10px;'));
			// 	$CI->make->boxTitle('Supplier Allocations');
			// 	$CI->make->sBox('success',array('id'=>'div-results','style'=>'min-height:150px;'));
			// 		$CI->make->sBoxHead();
			// 		$CI->make->eBoxHead();
			// 		$CI->make->sBoxBody();

			// 		$CI->make->eBoxBody();
			// 	$CI->make->eBox();
			// $CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
function build_suppalloc_display($list=null)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Transaction Type' => array('width'=>'15%'),
					'Supplier Name' => array('width'=>'30%'),
					'Reference #' => array('width'=>'10%'),
					'Date' => array('width'=>'10%'),
					"Initial Amount" => array('width'=>'15%'),
					"Left to Allocate" => array('width'=>'15%'),
					' ' => array('width'=>'10%'),
					);
				$rows = array();
				foreach ($list as $val) {



						$where = array('supplier_id'=>$val->supplier_id);
	                    $supp_name = $CI->purchasing_model->get_details($where,'suppliers');
	                    if($supp_name)
	                     	$supplier_name = $supp_name[0]->supp_name;
	                    else
	                     	$supplier_name = '';

	                    $totals = $val->amount+$val->amount_discount;
	                    $alloc_amt = 0;
	                    if($val->alloc_amt){
	                    	$alloc_amt = $val->alloc_amt;
	                    }

						$link = $CI->make->A(
								fa('fa-check-square-o fa-2x fa-fw'),
								base_url().'purchasing/allocation_form/'.$val->supp_payment_id.'/'.$val->supplier_id.'/'.$val->date.'/'.$totals.'/'.$val->order_no.'/'.$val->trans_type,
								array('return'=>'true',
									'title'=>'Allocate')
						);

						if($val->trans_type == 13){
							$type_name = 'Supplier Credit Note';
						}else{
							$type_name = 'Supplier Payment';
						}

						$rows[] = array(
								$type_name,
								$supplier_name,
								$val->reference,
								// array('text'=>number_format($val->order_total,2),'params'=>array('style'=>'text-align:right')),
								sql2Date($val->date),
								$totals,
								$totals - $alloc_amt,
								array('text'=>$link,'params'=>array('style'=>'text-align:center'))
						);

				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}
function allocForm($datas=null,$payment_id=null,$date=null, $totals=null, $supplier_id=null, $trans_no=null, $trans_type=null, $datas2=null){
	$CI =& get_instance();
			$CI->make->sDivRow();
				$CI->make->sDivCol(10,'right');
					$CI->make->A(fa('fa-reply').' Cancel',base_url().'purchasing/supplier_payments_inq',array('class'=>'btn btn-primary'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(2,'left');
					$CI->make->button(fa('fa-save').' Process',array('id'=>'process-alloc'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			$CI->make->append('<br>');

		$CI->make->sForm("purchasing/allocation_db",array('id'=>'allocation_form'));
			$CI->make->sBox('success',array('id'=>'div-results','style'=>'min-height:150px;'));
			// 		$CI->make->sBoxHead();
			// 		$CI->make->eBoxHead();
			$CI->make->sBoxBody();

			// 		$CI->make->eBoxBody();
			// 	$CI->make->eBox();
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'center');
					$CI->make->H(4,'Allocation of Supplier Payment # '.$payment_id);

					$where = array('supplier_id'=>$supplier_id);
                    $supp_name = $CI->purchasing_model->get_details($where,'suppliers');
                    if($supp_name)
                     	$supplier_name = $supp_name[0]->supp_name;
                    else
                     	$supplier_name = '';

					$CI->make->H(4,$supplier_name);
					$CI->make->hidden('date_alloc',$date,null,array());
					$CI->make->hidden('trans_no',$trans_no,null,array());
					$CI->make->hidden('trans_type',$trans_type,null,array());
					$CI->make->H(5,'Date : '.sql2Date($date));
					$CI->make->H(5,'Total : '.$totals);
					$CI->make->sDivRow();
						$CI->make->sDivCol(4,'center');
						$CI->make->eDivCol();
						$CI->make->sDivCol(4,'center');
							$CI->make->input("Supplier's Receipt",'supp_receipt','',null,array('class'=>''));
						$CI->make->eDivCol();
						$CI->make->sDivCol(4,'center');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eDivCol();

			$CI->make->eDivRow();
			$CI->make->sDivRow();
				$CI->make->sDivCol(1);
				$CI->make->eDivCol();
				$CI->make->sDivCol(10);
					$CI->make->sDiv(array('class'=>'table-responsive'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
						$CI->make->sRow();
							$CI->make->th('Transaction Type',array('style'=>'text-align:center;'));
							$CI->make->th('Reference #',array('style'=>'text-align:center;'));
							$CI->make->th('Date',array('style'=>'text-align:center;'));
							$CI->make->th('Due Date',array('style'=>'text-align:center;'));
							$CI->make->th('Amount',array('style'=>'text-align:center;'));
							$CI->make->th('This Allocation',array('style'=>'text-align:center;width:10%'));
							$CI->make->th('Balance',array('style'=>'text-align:center;'));
							//$CI->make->th('',array('style'=>'text-align:center;'));
						$CI->make->eRow();

						//$t_alloc = 0;
						foreach($datas as $val){
							$balance = $val->ov_amount - ($val->alloc_amt + $val->ov_gst);
							if($val->ov_gst != 0){
								$tpaid = $val->ov_amount - ($val->alloc_amt + $val->ov_gst);
							}else{
								$tpaid = $val->ov_amount;
							}
							if($balance != 0){
								$CI->make->sRow();
								$CI->make->th('Supplier Invoice',array('style'=>'text-align:center;'));
								$CI->make->th($val->reference,array('style'=>'text-align:center;'));
								$CI->make->th(sql2Date($val->trans_date),array('style'=>'text-align:center;'));
								$CI->make->th(sql2Date($val->due_date),array('style'=>'text-align:center;'));
								$CI->make->th(num($tpaid),array('style'=>'text-align:center;'));

								$tbox = $CI->make->input('','allocate['.$val->trans_no.']','0.00',null,array('class'=>'allocate numbers-only','return'=>'true','ref'=>$val->trans_no,'style'=>'width:100px;text-align:right;height:21px;'));
								$CI->make->th($tbox,array('style'=>''));

								$hid_bal = $CI->make->hidden('hid_bal_'.$val->trans_no,$balance,array('return'=>true));
								$CI->make->th(num($balance)."".$hid_bal,array('style'=>'text-align:center;'));

								$CI->make->eRow();
							}
							// if($val->trans_no_from == $trans_no)
							// 	$t_alloc += $val->alloc_amt;
						}

						$t_alloc = 0;
						foreach($datas2 as $val){
							// $balance = $val->ov_amount - $val->alloc_amt;
							// //if($balance != 0){
							// 	$CI->make->sRow();
							// 	$CI->make->th('Supplier Invoice',array('style'=>'text-align:center;'));
							// 	$CI->make->th($val->type_no,array('style'=>'text-align:center;'));
							// 	$CI->make->th(sql2Date($val->trans_date),array('style'=>'text-align:center;'));
							// 	$CI->make->th(sql2Date($val->due_date),array('style'=>'text-align:center;'));
							// 	$CI->make->th(num($val->ov_amount),array('style'=>'text-align:center;'));

							// 	$tbox = $CI->make->input('','allocate['.$val->trans_no.']','0.00',null,array('class'=>'allocate numbers-only','return'=>'true','ref'=>$val->trans_no,'style'=>'width:100px;text-align:right;height:21px;'));
							// 	$CI->make->th($tbox,array('style'=>''));

							// 	$CI->make->th(num($balance),array('style'=>'text-align:center;'));

							// 	$CI->make->eRow();
							// //}
							if($val->trans_no_from == $trans_no)
								$t_alloc += $val->alloc_amt;
						}

						$t_left_alloc = $totals - $t_alloc;
						$CI->make->sRow();
							$CI->make->th('<b>Total Allocated</b>',array('style'=>'text-align:right;','colspan'=>'5'));
							$hid_allocated = $CI->make->hidden('hid_allocated',"".$t_alloc."",null,array('return'=>true));
							$span = $CI->make->span(num($t_alloc),array('return'=>true,'id'=>'span_allocated'));
							$CI->make->th($span."".$hid_allocated,array('style'=>'text-align:right;','colspan'=>'1','id'=>'totalth'));
							$CI->make->th('',array('style'=>'text-align:right;','colspan'=>'1'));
						$CI->make->eRow();
						$CI->make->sRow();
							$CI->make->th('<b>Left to Allocate</b>',array('style'=>'text-align:right;','colspan'=>'5'));
							$hid_left_alloc = $CI->make->hidden('hid_left_alloc',$t_left_alloc,array('return'=>true));
							$hid_left_alloc_changing = $CI->make->hidden('hid_left_alloc_changing',$t_left_alloc,array('return'=>true));
							// $hid_left_alloc =  $CI->make->input('hid_allocated','hid_allocated',$t_left_alloc,null,array('return'=>true));
							$span = $CI->make->span(num($t_left_alloc),array('return'=>true,'id'=>'span_left_allocated'));
							$CI->make->th($span."".$hid_left_alloc."".$hid_left_alloc_changing,array('style'=>'text-align:right;','colspan'=>'1','id'=>'totalth'));
							$CI->make->th('',array('style'=>'text-align:right;','colspan'=>'1'));
						$CI->make->eRow();


					$CI->make->eTable();
					$CI->make->eDiv();
				$CI->make->eDivCol();
				$CI->make->sDivCol(1);
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eForm();
	return $CI->make->code();
}

function build_creditnote_inquiry()
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("purchasing/cn_inquiry_detail_results",array('id'=>'credit_note_search_form'));
						$CI->make->sDivCol(3);
							$CI->make->suppliersDrop('Supplier','supplier_id','','Select Supplier',array('class'=>'rOkay combobox'));
						$CI->make->eDivCol();
						// $CI->make->sDivCol(3,'left',0,array('id'=>'cust-branch-div'));
						// 	// $CI->make->customerBranchesDrop('Customer Branch','debtor_branch_id','','Select customer branch',array('class'=>''));
						// $CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Date range','daterange','','',array('class'=>'daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3,'left',0,array('style'=>'padding-top:2.3%;padding-bottom:2%;'));
							$CI->make->A(fa('fa-search').' Search','#',array('class'=>'btn btn-primary','id'=>'btn-search'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Supplier Credit Note",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function build_creditnote_inq_display($list)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Reference' => array('width'=>'5%'),
					'Supplier Name' => array('width'=>'25%'),
					'Transaction Date' => array('width'=>'10%'),
					'Due Date' => array('width'=>'10%'),
					"Amount" => array('width'=>'10%'),
					' ' => array('width'=>'10%'),
					);
				$rows = array();
				foreach ($list as $val) {

					//if($val->t_ordered != $val->t_received || !isset($val->t_ordered)){

						$link = $CI->make->A(
								fa('fa-eye fa-2x fa-history'),
								base_url().'purchasing/supplier_credit_note/'.$val->trans_no.'/'.$val->supplier_id.'/'.$val->reference,
								array('return'=>'true',
									'title'=>'Open')
						);
						// $link2 = $CI->make->A(
						// 		fa('fa-mail-forward fa-lg fa-fw'),
						// 		base_url().'purchasing/purchase_order_receive/'.$val->order_no,
						// 		array('return'=>'true',
						// 			'title'=>'Receive')
						// );
						// $link3 = $CI->make->A(
						// 		fa('fa-times-circle fa-lg fa-fw'),
						// 		'#',
						// 		array('return'=>'true',
						// 			'title'=>'Close',
						// 			'class'=>'close_po',
						// 			'ref'=>$val->order_no)
						// );


						$where = array('supplier_id'=>$val->supplier_id);
	                    $supp_name = $CI->purchasing_model->get_details($where,'suppliers');
	                    if($supp_name)
	                     	$supplier_name = $supp_name[0]->supp_name;
	                    else
	                     	$supplier_name = '';

	                    // $where = array('id'=>$val->person_id);
	                    // $user = $CI->purchasing_model->get_details($where,'users');
	                    // $user_name = $user[0]->fname." ".$user[0]->lname;

	                    $adder = $val->ov_amount - ($val->ov_gst + $val->alloc);

	                    if($adder > 0){
							$rows[] = array(
									$val->reference,
									$supplier_name,
									// array('text'=>number_format($val->order_total,2),'params'=>array('style'=>'text-align:right')),
									sql2Date($val->trans_date),
									sql2Date($val->due_date),
									Num($val->ov_amount - ($val->ov_gst + $val->alloc)),
									// array('text'=>$link."".$link2."".$link3,'params'=>array('style'=>'text-align:center'))
									array('text'=>$link,'params'=>array('style'=>'text-align:center'))
							);
						}
					//}
				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}

function suppcreditNoteForm($supp_id=null,$trans_no=null){
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			// $CI->make->sDivCol(12,'right');
			// 		$CI->make->button(fa('fa-save fa-fw').' Enter Invoice',array('id'=>'invoice-btn'),'primary');
			// $CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sForm("purchasing/credit_note_db",array('id'=>'creditnote_form'));
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'','load'=>'purchasing/creditnote_header_load/'.$supp_id.'/'.$trans_no,'id'=>'details_link'),
						//fa('fa-book')." Items to Return"=>array('href'=>'#received','class'=>'tab_link load-tab','load'=>'purchasing/supp_invoice_item/','id'=>'received_link'),
						fa('fa-book')." Return Sheet"=>array('href'=>'#added','class'=>'load-tab','load'=>'#','id'=>'added_link')
					);
					//$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

						$CI->make->eTabPane();
						// $CI->make->sTabPane(array('id'=>'received','class'=>'tab-pane'));
						// $CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'added','class'=>'tab-pane'));
							// $CI->make->sDivRow();
							// 	$CI->make->sDivCol(12,'center');
						 //        		$CI->make->H(4,"No Items for Invoice Found.",array('style'=>'margin-top:0px;margin-bottom:0px'));
						 //        	$CI->make->append('<br>');
				   //      		$CI->make->eDivCol();
							// $CI->make->eDivRow();
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
				$CI->make->eForm();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function creditNoteHead($type_no=null,$supp_id=null,$res=null,$sess=null){
	$CI =& get_instance();
		$CI->make->sForm("purchasing/credit_note_db",array('id'=>'credit_note_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					//$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-poheader'),'primary');
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			$CI->make->sBox('info');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(4);
							$CI->make->hidden('supp_id',$supp_id);

							$where = array('supplier_id'=>$supp_id);
		                    $supp_name = $CI->purchasing_model->get_details($where,'suppliers');
		                    if($supp_name)
		                     	$supplier_name = $supp_name[0]->supp_name;
		                    else
		                     	$supplier_name = '';

							$CI->make->input('Supplier Name','supname',$supplier_name,'',array('style'=>'','class'=>'rOkay','readonly'=>true));
							$CI->make->input('Reference No.','reference',$type_no,'',array('style'=>'','class'=>'rOkay'));
							$CI->make->input("Supplier's Reference",'supp_reference',null,'',array('class'=>'rOkay'));


						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->datefield('Return Date','return_date',date('m/d/Y'),'',array('class'=>'rOkay'));
							$CI->make->datefield('Due Date','due_date',date('m/d/Y'),'',array('class'=>'rOkay'));
							$CI->make->input("Terms",'terms',null,'CASH',array('class'=>'','readonly'=>'true'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
							$CI->make->taxTypeDrop('Tax Type','tax_type',null,null,array('class'=>'rOkay'));
							$CI->make->sDiv(array('id'=>'invoices'));

							$CI->make->eDiv();
							//$CI->make->input("Tax Group",'terms',null,'CASH',array('class'=>'rOkay','readonly'=>'true'));
							// $CI->make->textarea('Deliver To','delivery_address',iSetObj($po,'delivery_address'),'Type Address',array('class'=>'rOkay'));
						$CI->make->eDivCol();
			    	$CI->make->eDivRow();

				$CI->make->eBoxBody();
			$CI->make->eBox();

			$CI->make->sBox('primary');
				$CI->make->sBoxBody();

					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow();
									$CI->make->th('Item');
									$CI->make->th('Received On',array('style'=>'text-align:center;'));
									$CI->make->th('Qty Received',array('style'=>'text-align:center;'));
									$CI->make->th('Qty Invoiced',array('style'=>'text-align:center;'));
									$CI->make->th('Qty to Credit',array('style'=>'text-align:center;'));
									$CI->make->th('Price',array('style'=>'text-align:center;'));
									$CI->make->th('Discount1 %',array('style'=>'text-align:center;'));
									$CI->make->th('Discount2 %',array('style'=>'text-align:center;'));
									$CI->make->th('Discount3 %',array('style'=>'text-align:center;'));
									$CI->make->th('Total',array('style'=>'text-align:center;'));
									$CI->make->th('',array('style'=>''));
								$CI->make->eRow();

								foreach($res as $val){
									$checker = array_key_exists($val->id, $sess);
									if($checker){
										$CI->make->sRow(array('id'=>'forreturn-row-'.$val->id,'style'=>'display:none;'));
									}else{
										//$CI->make->sRow(array('id'=>'deliv-row-'.$val->delivery_id));
										$CI->make->sRow(array('id'=>'forreturn-row-'.$val->id));
									}



										$where = array('id'=>$val->item_id);
	                                    $item_name = $CI->purchasing_model->get_details($where,'stock_master');
	                                    if($item_name)
	                                     	$CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
	                                    else
	                                     	$CI->make->td('');

										$CI->make->th(sql2Date($val->date_delivered),array('style'=>'text-align:center;'));
										$CI->make->th(num($val->qty_received),array('style'=>'text-align:center;'));
										$CI->make->th(num($val->qty_invoice - $val->qty_returned),array('style'=>'text-align:center;'));



										$tbox = $CI->make->decimal('','returns['.$val->id.']',$val->qty_invoice - $val->qty_returned,null,2,array('class'=>'t_return','id'=>'toreturn-'.$val->id,'invoiced'=>$val->qty_invoice,'return'=>'true','ref'=>$val->id,'style'=>'width:80px;text-align:right;height:21px;'));
										$CI->make->th($tbox,array('style'=>'text-align:center;'));


										// $CI->make->th(num($val->quantity_received),array('style'=>'text-align:center;'));
										// $outstanding = $val->quantity_ordered - $val->quantity_received;
										// $hid_outstanding = $CI->make->hidden('hid_outstanding_'.$val->po_detail_item,$outstanding,array('return'=>true));
										// $CI->make->th(num($outstanding)."".$hid_outstanding,array('style'=>'text-align:center;'));
										// if($outstanding != 0){
										// 	$tbox = $CI->make->input('','delivery['.$val->po_detail_item.']',$outstanding,null,array('class'=>'t_delivery','return'=>'true','ref'=>$val->po_detail_item,'style'=>'width:80px;text-align:right;height:21px;'));
										// 	$CI->make->th($tbox,array('style'=>'text-align:center;'));
										// }else{
										// 	$CI->make->th(num($outstanding),array('style'=>'text-align:center;'));
										// }
										// $price = $outstanding * $val->unit_price;
										$CI->make->th(num($val->unit_price),array('style'=>'text-align:center;'));
										$CI->make->th(num($val->discount_percent),array('style'=>'text-align:center;'));
										$CI->make->th(num($val->discount_percent2),array('style'=>'text-align:center;'));
										$CI->make->th(num($val->discount_percent3),array('style'=>'text-align:center;'));
										// $CI->make->th($val->client_code,array('style'=>'text-align:center;'));
										$CI->make->th(num($val->line_total - $val->line_total_returned),array('style'=>'text-align:center;'));
										$button = $CI->make->A(fa('fa-check fa-lg'),'#',array("class"=>'return-item','ref'=>$val->id,'delivery_id'=>$val->delivery_id,'invoice_transno'=>$val->supp_invoice_transno,'item_id'=>$val->item_id,'return'=>true));
                                 		$CI->make->td($button);
									$CI->make->eRow();
								}

							$CI->make->eTable();
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();



			$CI->make->sDivRow();
				$CI->make->sDivCol(9);
					$CI->make->sBox('warning');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->textarea('Memo','comments',null,'Type Memo',array('class'=>''));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
				$CI->make->sDivCol(3,'center');
					$CI->make->sBox('success');
						$CI->make->sBoxBody();
								$CI->make->button(fa('fa fa-save')." Enter Credit Note",array('class'=>'btn-lg','id'=>'btn-credit-note'),'primary');
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			// $CI->make->sBox('warning');
			// 	$CI->make->sBoxBody();
			// 		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			// 			$CI->make->sDivRow();
			// 				$CI->make->sDivCol(12);
			// 					$CI->make->textarea('Memo','comments',null,'Type Memo',array('class'=>''));
			// 				$CI->make->eDivCol();
			// 			$CI->make->eDivRow();
			// 		$CI->make->eDivRow();
			// 	$CI->make->eBoxBody();
			// $CI->make->eBox();

		//$CI->make->eForm();
	return $CI->make->code();
}
function tableItems_addedreturn($return_sess=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
			$CI->make->sDivCol(12);
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						//$CI->make->sForm("receiving/save",array('id'=>'receive_form'));
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));

									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							if($return_sess != null){
								$CI->make->sDivRow();
									$CI->make->sDivCol(12);
							        		$CI->make->H(4,"Added Items For Credit Note",array('style'=>'margin-top:0px;margin-bottom:0px'));
							        	$CI->make->append('<br>');
					        		$CI->make->eDivCol();
								$CI->make->eDivRow();
								$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow();
											$CI->make->th('Item');
											$CI->make->th('Received On',array('style'=>'text-align:center;'));
											$CI->make->th('Qty Received',array('style'=>'text-align:center;'));
											$CI->make->th('Qty Invoiced',array('style'=>'text-align:center;'));
											$CI->make->th('Qty to Credit',array('style'=>'text-align:center;'));
											$CI->make->th('Price',array('style'=>'text-align:center;'));
											$CI->make->th('Discount1 %',array('style'=>'text-align:center;'));
											$CI->make->th('Discount2 %',array('style'=>'text-align:center;'));
											$CI->make->th('Discount3 %',array('style'=>'text-align:center;'));
											$CI->make->th('Total',array('style'=>'text-align:center;'));
											$CI->make->th('',array('style'=>''));
										$CI->make->eRow();


										$gtotal = 0;
										foreach($return_sess as $key => $val){
											//$CI->make->th($key."--".$val['val']);
											$CI->make->sRow(array('id'=>'added-row-'.$val['ref']));
												$where = array('supplier_invoice_items.id'=>$val['ref']);
												$detail = $CI->purchasing_model->get_items_creditnote($where);
												$det = $detail[0];


												$where = array('id'=>$det->item_id);
			                                    $item_name = $CI->purchasing_model->get_details($where,'stock_master');
			                                    if($item_name)
			                                     	$CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
			                                    else
			                                     	$CI->make->td('');

												$CI->make->th(sql2Date($det->date_delivered),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->qty_received),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->qty_invoice),array('style'=>'text-align:center;'));
												// //$CI->make->th($val->stk_units,array('style'=>'text-align:center;'));

												// $toinvoice = $val->qty_received - $val->qty_invoice;
												// $tbox = $CI->make->input('','toinvoice',$toinvoice,null,array('class'=>'toinvoice','id'=>'toinv-'.$val->delivery_id,'return'=>'true','ref'=>$val->delivery_id,'style'=>'width:80px;text-align:right;height:21px;'));
												$CI->make->th(num($val['val']),array('style'=>'text-align:center;'));

												// // $tbox = $CI->make->input('','unit_price',$val->unit_price,null,array('class'=>'unit_price','return'=>'true','ref'=>$val->delivery_id,'style'=>'width:80px;text-align:right;height:21px;'));
												// // $CI->make->th($tbox,array('style'=>'text-align:center;'));

												$CI->make->th(num($det->unit_price),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->discount_percent),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->discount_percent2),array('style'=>'text-align:center;'));
												$CI->make->th(num($det->discount_percent3),array('style'=>'text-align:center;'));

												/////compute for the line total
												$line_total = $val['val'] * $det->unit_price;
								                $vals = $det->unit_price;
								                if($det->discount_percent != 0){
								                    $disc1 = $det->discount_percent / 100;
								                    $disc1_val = $det->unit_price * $disc1;

								                    $vals = $det->unit_price - $disc1_val;

								                    if($det->discount_percent2 != 0){
								                        $disc2 = $det->discount_percent2 / 100;
								                        $vals2 = $vals * $disc2;
								                        $vals = $vals - $vals2;

								                        if($det->discount_percent3 != 0){
								                            $disc3 = $det->discount_percent3 / 100;
								                            $vals3 = $vals * $disc3;
								                            $vals = $vals - $vals3;
								                        }

								                    }

								                    $line_total = $vals * $val['val'];
								                }


								                //$CI->make->hidden('hline_total',$line_total,array('class'=>'hid_linetotal'));
												$CI->make->th(num($line_total),array('style'=>'text-align:center;'));
												$button = $CI->make->A(fa('fa-times fa-lg'),'#',array("class"=>'edit-item','ref'=>$val['ref'],'return'=>true));
	                                     		$CI->make->td($button);

	                                     		$gtotal += $line_total;
											$CI->make->eRow();
										}

										$CI->make->sRow();
											$CI->make->hidden('hline_total',$gtotal,array('class'=>'hid_linetotal'));
											$CI->make->th('<b>TOTAL</b>',array('style'=>'text-align:right;','colspan'=>'9'));
											$span = $CI->make->span(num($gtotal),array('return'=>true,'id'=>'totalspan'));
											$CI->make->th($span,array('style'=>'text-align:right;','colspan'=>'1','id'=>'totalth'));
											$CI->make->th('',array('style'=>'text-align:right;','colspan'=>'1'));
										$CI->make->eRow();


									$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
								$CI->make->eDivRow();

							}else{
								$CI->make->sDivRow();
									$CI->make->sDivCol(12,'center');
							        		$CI->make->H(4,"No Items for Credit Note was Found.",array('style'=>'margin-top:0px;margin-bottom:0px'));
							        	$CI->make->append('<br>');
					        		$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
								// $CI->make->button(
								// fa('fa-save').' Save Adjustments'
								// , array('class'=>'btn-block','id'=>'save-trans','style'=>'margin-top:10px','disabled'=>'disabled')
								// , 'primary');
						//$CI->make->eForm();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}


function build_payments_inquiry()
{
	$CI =& get_instance();

	$CI->make->sForm("purchasing/supp_allocation_results",array('id'=>'supp_alloc_search_form'));
		$CI->make->sDivRow(array('style'=>'margin:5px;'));
			$CI->make->sBox('success',array('div-form'));
				$CI->make->sBoxBody();
					$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
						//$CI->make->sForm("purchasing/po_inquiry_results",array('id'=>'purch_order_search_form'));
							$CI->make->sDivCol(4);
								$CI->make->suppliersDrop('Supplier','supplier_id','','Select Supplier',array('class'=>'rOkay combobox'));
							$CI->make->eDivCol();
							// $CI->make->sDivCol(3,'left',0,array('id'=>'cust-branch-div'));
							// 	// $CI->make->customerBranchesDrop('Customer Branch','debtor_branch_id','','Select customer branch',array('class'=>''));
							// $CI->make->eDivCol();
							// $CI->make->sDivCol(3);
							// 	$CI->make->input('Date range','daterange','','',array('class'=>'daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
							// $CI->make->eDivCol();
							// $CI->make->sDivCol(2,'left',0,array('style'=>'padding-top:22px;'));
							// 	$CI->make->checkbox('Show Settled Items','show_settled','',array('class'=>'','style'=>'','value'=>'0'));
							// $CI->make->eDivCol();
							$CI->make->sDivCol(3,'left',0,array('style'=>'padding-top:2.3%;padding-bottom:2%;'));
								$CI->make->A(fa('fa-search').' Search','#',array('class'=>'btn btn-primary','id'=>'btn-search'));
							$CI->make->eDivCol();
						//$CI->make->eForm();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();

			$CI->make->sBox('info',array('id'=>'div-results-view','style'=>'min-height:350px;'));
				$CI->make->sBoxBody();
					$CI->make->H('2',"Please select search parameters for Supplier Allocation",array('style'=>'text-align:center;color:#808080;'));
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
// function invoiceDrop($sup_id=null){
// 	$CI =& get_instance();
// 		$CI->make->supplierInvoiceDrop('Supplier Invoices','supp_invoice',null,null,array('class'=>'rOkay'),$sup_id);
// 	return $CI->make->code();
// }

?>