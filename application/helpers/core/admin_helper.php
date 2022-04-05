<?php
function rolesForm($roles=null,$access=array(),$navs=array()){
	$CI =& get_instance();
	$CI->make->sForm("admin/roles_db",array('id'=>'roles_form'));
		$CI->make->hidden('role_id',iSetObj($roles,'id'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(4);
				$CI->make->input('Name','role',iSetObj($roles,'role'),'Role Name',array('class'=>'rOkay'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(8);
				$CI->make->input('Description','description',iSetObj($roles,'description'),'Role Description',array());
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
    	$CI->make->sDivRow(array('style'=>'margin-lef:10px;margin-right:10px;'));
			$CI->make->sDivCol();
			foreach ($navs as $id => $nav) {
				if($nav['exclude'] == 0){
					$CI->make->sBox('info',array('class'=>'box-solid'));
	                    $CI->make->sBoxHead();
	                    	$check = false;
	                    	if(in_array($id, $access))
		                    	$check = true;

		                    $checkbox = $CI->make->checkbox($nav['title'],'roles[]',$id,array('return'=>true,'id'=>$id,'class'=>'check'),$check);
		                    $CI->make->boxTitle($checkbox);
	                    $CI->make->eBoxHead();
	                    if(is_array($nav['path'])){
		                    $CI->make->sBoxBody();
								$CI->make->append(underRoles($nav['path'],$access,$id));
		                    $CI->make->eBoxBody();
	                	}
	                $CI->make->eBox();
				}
			}
			$CI->make->eDivCol();
		$CI->make->eDivRow();



	$CI->make->eForm();
	return $CI->make->code();
}
function underRoles($nav=array(),$access=array(),$main=null){
	$CI =& get_instance();

	foreach ($nav as $id => $nv) {
		$CI->make->sDivRow(array('style'=>'margin-left:10px;'));
			$CI->make->sDivCol();
				$check = false;
            	if(in_array($id, $access))
                	$check = true;
				$CI->make->checkbox($nv['title'],'roles[]',$id,array('class'=>$main." check",'parent'=>$main,'id'=>$id),$check);
				if(is_array($nv['path'])){
					$CI->make->append(underRoles($nv['path'],$access,$main." ".$id." "));
				}
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	}

	return $CI->make->code();
}
function uomsForm($uoms=null){
	$CI =& get_instance();

	$CI->make->sForm("core/user/users_db",array('id'=>'users_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->input('Code','name',iSetObj($uoms,'name'),'Name',array('class'=>'rOkay',iSetObj($uoms,'uom_id')?'disabled':''=>''));
					if(!iSetObj($uoms,'id'))
					$CI->make->input('Description','description',iSetObj($uoms,'description'),'Description',array('type'=>'text','class'=>'rOkay',iSetObj($uoms,'id')?'disabled':''=>''));
					$CI->make->input('Decimal Places','decimal_places',iSetObj($uoms,'decimal_places'),'Decimal Places',array('class'=>''));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function itemTaxTypesForm($itemtaxtypes=null){
	$CI =& get_instance();

	$CI->make->sForm("core/user/users_db",array('id'=>'users_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->input('Tax Code','stocktaxtypecode',iSetObj($itemtaxtypes,'stock_tax_type_code'),'Stock Tax Type Code',array('class'=>'rOkay',iSetObj($itemtaxtypes,'stock_tax_type_id')));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function itemCategoriesForm($itemcategories=null){
	$CI =& get_instance();

	$CI->make->sForm("core/admin/item_categories_db",array('id'=>'item_categories_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->hidden('stock_category_id',iSetObj($itemcategories,'stock_category_id'));
					$CI->make->input('Category Name','category_name',iSetObj($itemcategories,'category_name'),'Stock Category');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function items_form($items=null){
	$CI =& get_instance();

	$CI->make->sForm("core/user/users_db",array('id'=>'item_categories_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(3);
					$CI->make->input('Item Code','item_code',iSetObj($items,'item_code'),'Item Code',array('class'=>'rOkay',iSetObj($items,'id')));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
					$CI->make->input('Barcode','barcode',iSetObj($items,'barcode'),'Barcode',array('class'=>'rOkay',iSetObj($items,'id')));
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
					$CI->make->input('Description','description',iSetObj($items,'description'),'Description',array('type'=>'text','class'=>'rOkay'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(3);
					$CI->make->stockCategoriesDrop('Category','item_category_id',iSetObj($items,'item_category_id'),'',array('class'=>'rOkay'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
					$CI->make->itemTaxTypeDrop('Item Tax Type','item_tax_type_id',iSetObj($items,'item_tax_type_id'),'',array('class'=>'rOkay'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
					$CI->make->shipperDrop('Shipping Company','shipper',iSetObj($items,'shipper'),'',array('class'=>'rOkay'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		// $CI->make->sDivRow(array('style'=>'margin:10px;'));
		// 	$CI->make->sDivCol(6);
		// 	$CI->make->eDivCol();
		// $CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function paymentTermsForm($payment_terms=null){
	$CI =& get_instance();

	$CI->make->sForm("core/admin/payment_terms_db",array('id'=>'payment_terms_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->hidden('payment_id',iSetObj($payment_terms,'payment_id'));
					$CI->make->input('Term Description','term_name',iSetObj($payment_terms,'term_name'),'Term Description',array('class'=>'rOkay',iSetObj($payment_terms,'uom_id')?'disabled':''=>''));
					$CI->make->checkbox('Due After A Given No. Of Days', 'days_before_due', (iSetObj($payment_terms,'days_before_due') == 0 ? 0 : 1), array(), (iSetObj($payment_terms,'days_before_due') == 0 ? 0 : 1));
					$CI->make->input('Days (Or Day In Following Month)','day_in_following_month',iSetObj($payment_terms,'day_in_following_month'),'No. of Days',array('class'=>'rOkay',iSetObj($payment_terms,'uom_id')?'disabled':''=>'', 'style'=>'width: 50%;'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function fiscalYearsForm($fiscal_years=null){
	$CI =& get_instance();

	$CI->make->sForm("core/admin/fiscal_years_db",array('id'=>'fiscal_years_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
				$CI->make->hidden('fiscal_year_id',iSetObj($fiscal_years,'fiscal_year_id'));
				// $CI->make->input('Term Description','term_name',iSetObj($fiscal_years,'term_name'),'Term Description',array('class'=>'rOkay',iSetObj($fiscal_years,'uom_id')?'disabled':''=>''));
				// $CI->make->checkbox('Due After A Given No. Of Days', 'days_before_due', (iSetObj($fiscal_years,'days_before_due') == 0 ? 0 : 1), array(), (iSetObj($fiscal_years,'days_before_due') == 0 ? 0 : 1));
				// $CI->make->input('Days (Or Day In Following Month)','day_in_following_month',iSetObj($fiscal_years,'day_in_following_month'),'No. of Days',array('class'=>'rOkay',iSetObj($fiscal_years,'uom_id')?'disabled':''=>'', 'style'=>'width: 50%;'));
				$CI->make->datefield('Beginning Date','begin_date',(iSetObj($fiscal_years,'begin_date') ? sql2Date(iSetObj($fiscal_years,'begin_date')) : date('m/d/Y')),'',array());
				$CI->make->datefield('Ending Date','end_date',(iSetObj($fiscal_years,'end_date') ? sql2Date(iSetObj($fiscal_years,'end_date')) : date('m/d/Y')),'',array());
				$CI->make->inactiveDrop('Is Closed?','is_closed',iSetObj($fiscal_years,'is_closed'));
				$CI->make->inactiveDrop('Is Inactive?','inactive',iSetObj($fiscal_years,'inactive'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
// function currenciesForm($currencies=null){
	// $CI =& get_instance();

	// $CI->make->sForm("core/admin/currencies_db",array('id'=>'currencies_form'));
		// $CI->make->sDivRow(array('style'=>'margin:10px;'));
			// $CI->make->sDivCol(6);
					// $CI->make->hidden('id',iSetObj($currencies,'id'));
					// $CI->make->input('Currency Abbreviation','currency_abrev',iSetObj($currencies,'currency_abrev'),'Abbreviation',array('class'=>'rOkay', 'style'=>'width: 50%;'));
					// $CI->make->input('Currency','currency',iSetObj($currencies,'currency'),'Currency name',array('class'=>'rOkay')); //orig
					 // $CI->make->decimal('Currency','currency',iSetObj($currencies,'currency'),'Currency name', 2,array('class'=>'rOkay'));
					// $CI->make->input('Currency Symbol','currency_symbol',iSetObj($currencies,'currency_symbol'),'Symbol',array('class'=>'rOkay', 'style'=>'width: 50%;'));
					// $CI->make->input('Hundredths Name','hundreds_name',iSetObj($currencies,'hundreds_name'),'Hundredths Name',array('class'=>'rOkay'));
					// $CI->make->input('Country','country',iSetObj($currencies,'country'),'Country',array('class'=>'rOkay'));
			// $CI->make->eDivCol();
		// $CI->make->eDivRow();
	// $CI->make->eForm();

	// return $CI->make->code();
// }
function currencyPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Currency',base_url().'admin/manage_currencies',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Abbreviation' => array('width'=>'10%'),
									'Currency' => array('width'=>'20%'),
									'Symbol' => array('width'=>'10%'),
									'Hundredths Name' => array('width'=>'20%'),
									'Is Inactive' => array('width'=>'20%'),
									' '=>array('width'=>'20%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/manage_currencies/'.$val->id,array("return"=>true));
								$rows[] = array(
											  $val->abbrev,
											  $val->currency,
											  $val->symbol,
											  $val->hundredths_name,
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

function manage_currency_form($item=null){
	 // $CI =& get_instance();
	 
		// $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			// $CI->make->sDivCol();
				// $CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/currency_list',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');

				 // $CI->make->eDivCol();
		 // $CI->make->eDivRow();

		 
	// $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
		// $CI->make->sDivCol(4);
			 // $CI->make->button(fa('fa-save').' Save Currency Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
		// $CI->make->eDivCol();
	 // $CI->make->eDivRow();
	 
	 // return $CI->make->code();
	
	
    $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/currency_list',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
				// $CI->make->hidden('asset_id',iSetObj($item,'asset_id'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
				
					$tabs = array(
						fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
						////-----UNCOMMENT TO LOAD SAMPLE TABS
						// fa('fa-money')." GL Entries"=>array('href'=>'#accounting','class'=>'tab_link load-tab','load'=>'asset/gl_entries','id'=>'accounting_link'),
						// fa('fa-book')." History" => array('href'=>'#history','class'=>'tab_link load-tab','load'=>'asset/histoy_load','id'=>'history_link'),
					);
					
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

							$CI->make->sForm("admin/currency_details_db",array('id'=>'currency_details_form'));
								$CI->make->hidden('id',iSetObj($item,'id'));
								$CI->make->hidden('mode', ((iSetObj($item,'id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									//-----1st Col
									$CI->make->sDivCol(2);
									$CI->make->input('Abbreviation','abbrev',iSetObj($item,'abbrev'),null,array('class'=>'rOkay reqForm'));
										
									$CI->make->eDivCol();

									//-----2nd Col
									$CI->make->sDivCol(2);
									$CI->make->input('Currency','currency',iSetObj($item,'currency'),null,array('class'=>'rOkay reqForm'));
									
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(2);
									$CI->make->input('Symbol','symbol',iSetObj($item,'symbol'),null,array('class'=>'rOkay reqForm'));
									
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(2);
									$CI->make->input('Hundredths','hundredths_name',iSetObj($item,'hundredths_name'),null,array('class'=>'rOkay reqForm'));
									
									$CI->make->eDivCol();
									
									//-----3rd Col
									$CI->make->sDivCol(4);
											$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'reqForm'));
										////----sample pre-made forms
											// $CI->make->decimal('Discount Percent','discount','',null,2,array('class'=>''),null,'%');
											// $CI->make->decimal('Prompt Payment Discount Percent','payment_discount','',null,2,array('class'=>''),null,'%');
											// $CI->make->decimal('Credit Limit','credit_limit','',null,2,array('class'=>''));
											// $CI->make->paymentTermsDrop('Payment Term','payment_term','',null,array('class'=>''));
											// $CI->make->creditStatusDrop('Credit Status','credit_status','',null,array('class'=>''));
											// $CI->make->input('Business Style','business_style','',null,array('class'=>''));
										$CI->make->eDivCol();
									$CI->make->eDivRow();
									
									//-----Unblock this to show sample of product dropdown
									// $CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										// $CI->make->sDivCol(4);
										// $CI->make->eDivCol();
										
										// $CI->make->sDivCol(4, 'right');
											// $CI->make->productsDrop('Products','product_drop','',null,array('class'=>''));
										// $CI->make->eDivCol();
										
										// $CI->make->sDivCol(4);
										// $CI->make->eDivCol();
									// $CI->make->eDivRow();

									$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										$CI->make->sDivCol(2);
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(6, 'right');
											$CI->make->button(fa('fa-save').' Save Currency Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);
										$CI->make->eDivCol();
									$CI->make->eDivRow();

							$CI->make->eForm();

						$CI->make->eTabPane();
					
					////-----UNCOMMENT TO LOAD SAMPLE TABS
						// $CI->make->sTabPane(array('id'=>'accounting','class'=>'tab-pane'));
						// $CI->make->eTabPane();

						// $CI->make->sTabPane(array('id'=>'history','class'=>'tab-pane bg-white-gray','style'=>'margin:-10px;'));
						// $CI->make->eTabPane();
						
					$CI->make->eTabBody();
				$CI->make->eTab();
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();
}

//***********************JED**************************
function TaxTypesForm($taxtypes=null){
	$CI =& get_instance();

	$CI->make->sForm("core/admin/tax_type_db",array('id'=>'tax_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->hidden('id',iSetObj($taxtypes,'id'));
					$CI->make->input('Description','tax_type_name',iSetObj($taxtypes,'tax_type_name'),'Tax Type',array('class'=>'rOkay',iSetObj($taxtypes,'tax_type_name')));
					$CI->make->decimal('Default Rate','default_rate',(isset($taxtypes->default_rate) ? $taxtypes->default_rate : '0'),null,2,array('class'=>'rOkay',iSetObj($taxtypes,'default_rate')),null,'%');
					$CI->make->inactiveDrop('Inactive','inactive',iSetObj($taxtypes,'inactive'),null,array('class'=>'',));
					
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function shippingForm($ships=null){
	$CI =& get_instance();

	$CI->make->sForm("core/admin/ship_company_db",array('id'=>'shipping_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->hidden('ship_company_id',iSetObj($ships,'ship_company_id'));
					$CI->make->input('Name','company_name',iSetObj($ships,'company_name'),'Name',array('class'=>'rOkay',iSetObj($ships,'company_name')));
					$CI->make->input('Contact Person','contact_person',iSetObj($ships,'contact_person'),'Contact Person',array('class'=>'rOkay',iSetObj($ships,'contact_person')));
					$CI->make->input('Phone Number','phone_no',iSetObj($ships,'phone_no'),'Phone Number',array('class'=>'rOkay',iSetObj($ships,'phone_no')));
					$CI->make->input('Address','address',iSetObj($ships,'address'),'Address',array('class'=>'rOkay',iSetObj($ships,'address')));
					$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($ships,'inactive'),'',array('style'=>'width: 85px;'));
					//$CI->make->decimal('Default % Rate','default_rate',iSetObj($taxtypes,'default_rate'),'Default Rate',2,array('class'=>'rOkay',iSetObj($taxtypes,'default_rate')));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function makeSetupForm($det=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			//$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sForm("",array('id'=>'setup_form'));
						$CI->make->sDivRow(array('style'=>'margin:10px;'));
							$CI->make->sDivCol(12, 'right');

									$CI->make->button(fa('fa-save fa-fw').' Save',array('id'=>'save-btn'),'primary');

							$CI->make->eDivCol();
						$CI->make->eDivRow();

						$CI->make->sDivRow(array('style'=>'margin:10px;'));
							// $CI->make->sDivCol(3, 'center');
							// $CI->make->eDivCol();
							// $CI->make->sDivCol(6, 'center');

							// 	$CI->make->sTable(array('class'=>'table table-striped','id'=>'details-tbl'));
							// 		$CI->make->sRow();
							// 			$CI->make->th('Form');
							// 			$CI->make->th('Next Reference',array());
							// 		$CI->make->eRow();
							// 		$total = 0;
							// 		if(count($det) > 0){
							// 			foreach ($det as $res) {
							// 				$CI->make->sRow(array('id'=>'row-'.$res->type_id));
							// 		            $CI->make->td($res->name,array('style'=>'text-align:left;'));
							// 		            $CI->make->input('','id_'.$res->type_id,$res->next_ref,'',array('class'=>'rOkay'),'','',true);
							// 		            //$CI->make->td();
							// 		        $CI->make->eRow();
							// 				//$total += $price * $res->qty;
							// 			}
							// 		}
							// 	$CI->make->eTable();



							// $CI->make->eDivCol();
							// $CI->make->sDivCol(3, 'center');
							// $CI->make->eDivCol();

						$CI->make->sDivRow(array('style'=>'margin:0px;'));
								$CI->make->sDivCol(4, 'center');
								$CI->make->eDivCol();
								$CI->make->sDivCol(2, 'left');
									$CI->make->span('Form',array('style'=>''));
								$CI->make->eDivCol();
								$CI->make->sDivCol(2, 'left');
									$CI->make->span('Next Ref');

								$CI->make->eDivCol();
								$CI->make->sDivCol(4, 'center');
								$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->append('<br>');

						foreach ($det as $res){
							$CI->make->sDivRow(array('style'=>'margin:0px;'));
								$CI->make->sDivCol(4, 'center');
								$CI->make->eDivCol();
								$CI->make->sDivCol(2, 'left');
									$CI->make->span($res->name);
								$CI->make->eDivCol();
								$CI->make->sDivCol(2, 'left');
									$CI->make->input('','refs['.$res->trans_type.']',$res->next_ref,'',array('class'=>'rOkay','style'=>'width:150px;margin-top:-10px;'));

								$CI->make->eDivCol();
								$CI->make->sDivCol(4, 'center');
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						}


						$CI->make->eDivRow();

						// $CI->make->sDivRow(array('style'=>'margin:10px;'));
						// 	$CI->make->sDivCol(6);
						// 		$CI->make->currenciesDrop('Currency','currency',iSetObj($det,'currency'),'',array());
						// 	$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eBoxBody();
			//$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function TaxGroupsForm($taxgs=null){
	$CI =& get_instance();

	$CI->make->sForm("core/admin/tax_groups_db",array('id'=>'taxg_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->hidden('tax_group_id',iSetObj($taxgs,'tax_group_id'));
					$CI->make->input('Group Name','group_name',iSetObj($taxgs,'group_name'),'Group Name',array('class'=>'rOkay',iSetObj($taxgs,'group_name')));
					$CI->make->yesOrNoDrop('Tax Shipping','tax_shipping',iSetObj($taxgs,'tax_shipping'));
					$CI->make->taxTypeDrop('Tax Type','tax_type_id',iSetObj($taxgs,'tax_type_id'),'Select Type');
					$CI->make->decimal('Rate','tax_rate',(isset($taxgs->tax_rate) ? $taxgs->tax_rate : '0'),null,2,array('class'=>'rOkay',iSetObj($taxgs,'tax_rate')),null,'%');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}


//********************START Joshua***************************
function branchPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Branch','',array('class'=>'btn btn-primary', 'id'=>'add'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
					
						$th = array(
									'Branch Code' => array('width'=>'10%'),
									'Branch Name' => array('width'=>'15%'),
									'Address' => array('width'=>'20%'),
									'Telephone No.' => array('width'=>'10%'),
									'Mobile No.' => array('width'=>'10%'),
									'Date Opened.' => array('width'=>'10%'),
									'Is Inactive' => array('width'=>'10%'),
									' '=>array('width'=>'5%','align'=>'right'));
				
							$rows = array();
							
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/manage_branches/'.$val->id,array("return"=>true));
								$rows[] = array(
							
											  $val->code,
											  $val->name,
											  $val->address,
											  $val->tel_no,
											  $val->mobile_no,
											  $val->date_opened,
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

function manage_branch_form($item=null){

    $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/branch_list',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
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

							$CI->make->sForm("admin/branches_details_db",array('id'=>'branch_details_form'));
								$CI->make->hidden('id',iSetObj($item,'id'));
								$CI->make->hidden('mode', ((iSetObj($item,'id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
															
									//-----1st Col
									$CI->make->sDivCol(6);
									$CI->make->input('Branch Code','code',iSetObj($item,'code'),null,array('class'=>'rOkay reqForm'));
									$CI->make->input('Branch Name','name',iSetObj($item,'name'),null,array('class'=>'rOkay reqForm'));
									$CI->make->input('Address.','address',iSetObj($item,'address'),null,array('class'=>'rOkay reqForm'));
									$CI->make->input('Tin no.','tin',iSetObj($item,'tin'),null,array('class'=>'rOkay'));
									$CI->make->input('Telephone no.','tel_no',iSetObj($item,'tel_no'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									
									//-----2nd Col
									$CI->make->sDivCol(6);
										$CI->make->input('Mobile no.','mobile_no',iSetObj($item,'mobile_no'),null,array('class'=>'rOkay reqForm'));		
											$CI->make->datefield('Date Opened','date_opened',iSetObj($item, 'date_opened'),'Select Date',array('class'=>'rOkay reqForm'),$icon1="<i class='fa fa-fw fa-calendar'></i>");
											$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'reqForm'));
											$CI->make->input('Database','database',iSetObj($item,'branch_database'),null,array('class'=>'rOkay reqForm'));
												$CI->make->input('Ip Address','ip',iSetObj($item,'branch_ip'),null,array('class'=>'rOkay reqForm'));
										$CI->make->eDivCol();
										$CI->make->eDivRow();
										
										$CI->make->sDivRow();
											$CI->make->sDivCol(4);
												$CI->make->checkbox('Selling Area','has_sa',(iSetObj($item,'has_sa') == 0 ? 0 : 1),array('class'=>'reqForm','value'=>'1'),1);
											$CI->make->eDivCol();
											$CI->make->sDivCol(4);
												$CI->make->checkbox('Stock Room','has_sr',(iSetObj($item,'has_sr') == 0 ? 0 : 1),array('class'=>'reqForm'),'');
											$CI->make->eDivCol();
											$CI->make->sDivCol(4);
												$CI->make->checkbox('BO Room','has_bo',(iSetObj($item,'has_bo') == 0 ? 0 : 1),array('class'=>'reqForm','value'=>'1'),1);
											$CI->make->eDivCol();
										$CI->make->eDivRow();
								
									$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										$CI->make->sDivCol(4);
										$CI->make->eDivCol();
										
								
										
										$CI->make->sDivCol(4, 'center');
											$CI->make->button(fa('fa-save').' Save Branch Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
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
//********************END Joshua***************************

//********************START Joshua*************************
function payment_typePage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Payment Types',base_url().'admin/manage_payment_types',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$th = array(
									'Name' => array('width'=>'15%'),
									'Is Cash' => array('width'=>'9%'),
									'Has Change' => array('width'=>'11%'),
									 'Charge to Card' => array('width'=>'13%'),
									'Has Validation' => array('width'=>'13%'),
									'Has Account No.' => array('width'=>'15%'),
									'Is Swipeable' => array('width'=>'11%'),
									// 'Database.' => array('width'=>'10%'),
									// 'IP' => array('width'=>'10%'),
									'Is Inactive' => array('width'=>'11%'),
									' '=>array('width'=>'11%','align'=>'right'));
									
									
									
									
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/manage_payment_types/'.$val->id,array("return"=>true));
								$rows[] = array(
							
											  
											  $val->name,
											  ($val->is_cash == 1 ? 'Yes' : 'No'),
											  ($val->has_change == 1 ? 'Yes' : 'No'),
											  ($val->charge_to_card == 1 ? 'Yes' : 'No'),
											  ($val->has_validation == 1 ? 'Yes' : 'No'),
											  ($val->has_account_no == 1 ? 'Yes' : 'No'),
											  ($val->is_swipeable == 1 ? 'Yes' : 'No'),
											 
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

function manage_payment_types_form($item=null){
	 // $CI =& get_instance();
	 
		// $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			// $CI->make->sDivCol();
				// $CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/currency_list',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');

				 // $CI->make->eDivCol();
		 // $CI->make->eDivRow();

		 
	// $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
		// $CI->make->sDivCol(4);
			 // $CI->make->button(fa('fa-save').' Save Currency Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
		// $CI->make->eDivCol();
	 // $CI->make->eDivRow();
	 
	 // return $CI->make->code();
	
	
    $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/payment_types_list',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
				// $CI->make->hidden('asset_id',iSetObj($item,'asset_id'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
				
					$tabs = array(
						fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
						////-----UNCOMMENT TO LOAD SAMPLE TABS
						// fa('fa-money')." GL Entries"=>array('href'=>'#accounting','class'=>'tab_link load-tab','load'=>'asset/gl_entries','id'=>'accounting_link'),
						// fa('fa-book')." History" => array('href'=>'#history','class'=>'tab_link load-tab','load'=>'asset/histoy_load','id'=>'history_link'),
					);
					
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

							$CI->make->sForm("admin/payment_types_details_db",array('id'=>'payment_types_details_form'));
								$CI->make->hidden('id',iSetObj($item,'id'));
								$CI->make->hidden('mode', ((iSetObj($item,'id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									
								

									//-----1st Col
									$CI->make->sDivCol(5);
									
									$CI->make->input('Name','name',iSetObj($item,'name'),null,array('class'=>'rOkay reqForm'));
									$CI->make->inactiveDrop('Is Cash.','is_cash',iSetObj($item,'is_cash'),null,array('class'=>'reqForm'));
									$CI->make->inactiveDrop('Has Change','has_change',iSetObj($item,'has_change'),null,array('class'=>'reqForm'));
									$CI->make->inactiveDrop('Charge to Card','charge_to_card',iSetObj($item,'charge_to_card'),null,array('class'=>'reqForm'));
									$CI->make->eDivCol();

									
									//-----2rd Col
									$CI->make->sDivCol(5);
										$CI->make->inactiveDrop('Has Validation','has_validation',iSetObj($item,'has_validation'),null,array('class'=>'reqForm'));		
										$CI->make->inactiveDrop('Has Account No.','has_account_no',iSetObj($item,'has_account_no'),null,array('class'=>'reqForm'));
										$CI->make->inactiveDrop('Is Swipeable','is_swipeable',iSetObj($item,'is_swipeable'),null,array('class'=>'reqForm'));
										$CI->make->inactiveDrop('Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'reqForm'));
										////----sample pre-made forms
											// $CI->make->decimal('Discount Percent','discount','',null,2,array('class'=>''),null,'%');
											// $CI->make->decimal('Prompt Payment Discount Percent','payment_discount','',null,2,array('class'=>''),null,'%');
											// $CI->make->decimal('Credit Limit','credit_limit','',null,2,array('class'=>''));
											// $CI->make->paymentTermsDrop('Payment Term','payment_term','',null,array('class'=>''));
											// $CI->make->creditStatusDrop('Credit Status','credit_status','',null,array('class'=>''));
											// $CI->make->input('Business Style','business_style','',null,array('class'=>''));
										$CI->make->eDivCol();
										$CI->make->eDivRow();
									
						
									
									//-----Unblock this to show sample of product dropdown
									// $CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										// $CI->make->sDivCol(4);
										// $CI->make->eDivCol();
										
										// $CI->make->sDivCol(4, 'right');
											// $CI->make->productsDrop('Products','product_drop','',null,array('class'=>''));
										// $CI->make->eDivCol();
										
										// $CI->make->sDivCol(4);
										// $CI->make->eDivCol();
									// $CI->make->eDivRow();

									$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										$CI->make->sDivCol(1);
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(10, 'center');
											$CI->make->button(fa('fa-save').' Save Payment Types Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);
										$CI->make->eDivCol();
									$CI->make->eDivRow();

							$CI->make->eForm();

						$CI->make->eTabPane();
					
					////-----UNCOMMENT TO LOAD SAMPLE TABS
						// $CI->make->sTabPane(array('id'=>'accounting','class'=>'tab-pane'));
						// $CI->make->eTabPane();

						// $CI->make->sTabPane(array('id'=>'history','class'=>'tab-pane bg-white-gray','style'=>'margin:-10px;'));
						// $CI->make->eTabPane();
						
					$CI->make->eTabBody();
				$CI->make->eTab();
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();
}

//********************END Joshua***************************
//----------ACQUIRING BANKS------MHAE------START
function AcquiringBanksPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Acquiring Banks',base_url().'admin/manage_acquiring_banks',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$th = array(
									'Bank Name' => array('width'=>'20%'),
									'GL Bank Account' => array('width'=>'20%'),
									'GL Debit Account' => array('width'=>'20%'),
									'Is Inactive' => array('width'=>'10%'),
									' '=>array('width'=>'11%','align'=>'right'));
									
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/manage_acquiring_banks/'.$val->id,array("return"=>true));
								$rows[] = array(
											  $val->acquiring_bank,
											  $val->gl_bank_account,
											  $val->gl_bank_debit_account,
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

function manage_acquiring_banks_form($item=null){
    $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/acquiring_banks_list',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link')
					);
					
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
							$CI->make->sForm("admin/acquiring_bank_details_db",array('id'=>'acquiring_banks_details_form'));
								$CI->make->hidden('id',iSetObj($item,'id'));
								$CI->make->hidden('mode', ((iSetObj($item,'id')) ? 'edit' : 'add'));

									$CI->make->sDivRow();
										$CI->make->sDivCol(6);
											$CI->make->input('Bank Name','acquiring_bank',iSetObj($item,'acquiring_bank'),null,array('class'=>'rOkay reqForm'));
										$CI->make->eDivCol();	
										$CI->make->sDivCol(6);
											$CI->make->input('GL Debit Account','gl_bank_debit_account',iSetObj($item,'gl_bank_debit_account'),null,array('class'=>'rOkay reqForm'));
										$CI->make->eDivCol();	
									$CI->make->eDivRow();
									$CI->make->sDivRow();
										$CI->make->sDivCol(4);
											$CI->make->input('GL Bank Account','gl_bank_account',iSetObj($item,'gl_bank_account'),null,array('class'=>'rOkay reqForm'));
										$CI->make->eDivCol();
										$CI->make->sDivCol(4);
											$CI->make->input('GL Fee Account','gl_mfee_account',iSetObj($item,'gl_mfee_account'),null,array('class'=>'rOkay reqForm'));
										$CI->make->eDivCol();
										$CI->make->sDivCol(4);
											$CI->make->input('W. Tax Account','gl_wtax_account',iSetObj($item,'gl_wtax_account'),null,array('class'=>'rOkay reqForm'));
										$CI->make->eDivCol();
									$CI->make->eDivRow();
										$CI->make->sDivRow();
										$CI->make->sDivCol(4);
											$CI->make->input('DC Merchant Fee %','dc_merchant_fee_percent',iSetObj($item,'dc_merchant_fee_percent'),null,array('class'=>'rOkay reqForm'));
										$CI->make->eDivCol();
										$CI->make->sDivCol(4);
											$CI->make->input('CC Merchant Fee %','cc_merchant_fee_percent',iSetObj($item,'cc_merchant_fee_percent'),null,array('class'=>'rOkay reqForm'));
										$CI->make->eDivCol();
										$CI->make->sDivCol(4);
											$CI->make->input('CC Withholding Tax %','cc_withholding_tax_percent',iSetObj($item,'cc_withholding_tax_percent'),null,array('class'=>'rOkay reqForm'));
										$CI->make->eDivCol();
									$CI->make->eDivRow();
									
									$CI->make->sDivRow();
										$CI->make->sDivCol(4);
											$CI->make->inactiveDrop('Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'reqForm'));
										$CI->make->eDivCol();	
										$CI->make->sDivCol(4);
											$CI->make->append('<br>');
											$CI->make->button(fa('fa-save').' Save',array('id'=>'save-btn','class'=>'btn-block'),'primary');
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

//----------ACQUIRING BANKS------MHAE------END


//----------PAYMENT TYPE CODE----------RHAN-----START

function payment_type_codes_page($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Payment Type Codes',base_url().'admin/manage_payment_type_code',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$th = array(
									'Payment Type' => array('width'=>'15%'),
									'Code' => array('width'=>'9%'),
									'Confirmation Code' => array('width'=>'11%'),
									 'Amount' => array('width'=>'13%'),
									 'For Branch' => array('width'=>'13%'),
									'Is Redeemed' => array('width'=>'11%'),
									' '=>array('width'=>'11%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/manage_payment_type_code/'.$val->id,array("return"=>true));
								$desc = $CI->admin_model->payment_types_name($val->payment_type_id);
								$rows[] = array(
									
											  
											   $desc,
											   $val->code,
											   $val->confirmation_code,
											   $val->amount,
											   strtoupper($CI->admin_model->get_branch_code_from_id($val->branch_id)),
											  ($val->is_redeemed == 1 ? 'Yes' : 'No'),
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

function manage_payment_type_code_form($item=null){

  $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/payment_type_code_list',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
			
							$CI->make->sForm("admin/payment_type_code_details_db",array('id'=>'payment_types_details_form'));
								$CI->make->hidden('id',iSetObj($item,'id'));
								$CI->make->hidden('mode', ((iSetObj($item,'id')) ? 'edit' : 'add'));

							//-----1st Row
								$CI->make->sDivRow();

									$CI->make->sDivCol(4);
									$CI->make->paymentCardTypeDrop('Payment Types','payment_type_id',iSetObj($item,'payment_type_id'),null,array('class'=>'rOkay reqForm'));								
									$CI->make->eDivCol();	//-----1st Col
									
									$CI->make->sDivCol(4);
									$CI->make->input('Code','code',iSetObj($item,'code'),null,array('class'=>'rOkay'));								
									$CI->make->eDivCol();	//-----2nd Col
									
									$CI->make->sDivCol(4);
									$CI->make->input('Confirmation Code','confirmation_code',iSetObj($item,'confirmation_code'),null,array('class'=>'rOkay reqForm'));								
									$CI->make->eDivCol();	//-----3rd Col
						
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
									$CI->make->input('Amount','amount',iSetObj($item,'amount'),null,array('class'=>'rOkay reqForm'));								 
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(4);
									$CI->make->branchesDrop('Branch','branch_id',iSetObj($item,'branch_id'),null,array('class'=>'rOkay branch_dropdown reqForm'));
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(4); //-----4rt Col
									$CI->make->inactiveDrop('Inactive','is_redeemed',iSetObj($item,'is_redeemed'),null,array('class'=>'reqForm'));						 
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();

									$CI->make->sDivCol(4);					
									$CI->make->eDivCol();	//-----1st Col
									
									$CI->make->sDivCol(4);
									$CI->make->button(fa('fa-save').' Save Payment Type Code Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');							
									$CI->make->eDivCol();	//-----2nd Col
									
									$CI->make->sDivCol(4);				
									$CI->make->eDivCol();	//-----3rd Col

								$CI->make->eDivRow();
						
							$CI->make->eForm();
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();


}
//----------PAYMENT TYPE CODE----------RHAN-----END

//----------Suppliers----------RHAN-----START

function supplier_master_page($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Supplier',base_url().'admin/supplier_master_form',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$th = array(
								//	'Suppliers Code ' => array(),
									'Suppliers' => array(),
									'Supplier Group' => array(),
									'Is Inactive' => array(),
									' '=>array());
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/supplier_master_form/'.$val->supplier_id,array("return"=>true));					
								$rows[] = array(
										//	   $val->supplier_code,
											   $val->supp_name,
											   ($val->group_id == 0 ? 'NOT APPLICABLE' : $CI->admin_model->get_supp_group_name_from_id($val->group_id)),
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


function supplier_master_form($item=null){

  $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-top: -10px; margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/supplier_master',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
				
						$CI->make->sForm("admin/suppliers_details_db",array('id'=>'supplier_details_form'));
							$CI->make->hidden('supplier_id',iSetObj($item,'supplier_id'));
							$CI->make->hidden('hidden_main_group_id',iSetObj($item,'group_id'));
							$CI->make->hidden('mode', ((iSetObj($item,'supplier_id')) ? 'edit' : 'add'));

							$CI->make->sDivRow();		
								$CI->make->sDivCol(8);	
									$CI->make->H(4,"General Settings",array('style'=>'margin-top:0px;margin-bottom:0px'));
									$CI->make->append('<hr class="style-two" style="margin-top: 10px;"/>');
									//-----1st Row
									$CI->make->sDivRow();
										$CI->make->sDivCol();
										
											//$num = $CI->admin_model->get_next_supplier_id();
											//$num_padded = sprintf("%010d", $num);
										
											// $CI->make->input('Supplier Code','supplier_code',($item->supplier_code != '' ? $item->supplier_code : $num_padded),null,array('class'=>'rOkay')); //-----ORIGINAL																			
											// $CI->make->input('Supplier Code','supplier_code',(!empty(iSetObj($item,'supplier_code')) ? iSetObj($item,'supplier_code') : $num_padded),null,array('class'=>'rOkay'));																			
											// echo $num_padded."<br>";
											// $CI->make->hidden('supplier_code',(!empty(iSetObj($item,'supplier_code')) ? iSetObj($item,'supplier_code') : $num_padded));
											// if($item->supplier_code != ''){
											//if(!empty($item)){
											//	$CI->make->hidden('supplier_code',iSetObj($item,'supplier_code'));
											//}else{
											//	$CI->make->hidden('supplier_code',$num_padded);
											//}
										$CI->make->eDivCol();	//-----1st Col
										
										$CI->make->sDivCol();							
										$CI->make->input('Short Name','short_name',iSetObj($item,'short_name'),null,array('class'=>'rOkay reqForm'));																			
										$CI->make->input('Supplier Name','supp_name',iSetObj($item,'supp_name'),null,array('class'=>'rOkay reqForm'));																			
										$CI->make->eDivCol();	//-----2nd Col
									$CI->make->eDivRow();
											
									//-----2nd Row
									$CI->make->sDivRow();

											$CI->make->sDivCol(4);
												$CI->make->textarea('Address','address',iSetObj($item,'address'),null,array('class'=>'reqForm'));																			
											$CI->make->eDivCol();	
											
											$CI->make->sDivCol(8);							
												$CI->make->sDivRow();
													$CI->make->sDivCol(6);							
													$CI->make->input('Contact Person','contact_person',iSetObj($item,'contact_person'),null,array('class'=>'reqForm'),"<i class='fa fa-fw fa-user'></i>");
													$CI->make->input('Contact Numbers','contact_nos',iSetObj($item,'contact_nos'),null,array('class'=>'rOkay reqForm'),"<i class='fa fa-fw fa-phone'></i>");																			
													$CI->make->eDivCol();	
													$CI->make->sDivCol(6);							
													// $CI->make->input('Email Address','email',iSetObj($item,'email'),null,array('class'=>'hl_email'),"<i class='fa fa-fw fa-envelope'></i>");
													$CI->make->input('Fax no.','fax_no',iSetObj($item,'fax_no'),null,array('class'=>'reqForm'),"<i class='fa fa-fw fa-fax'></i>");																			
													$CI->make->input('TIN','tin',iSetObj($item,'tin'),null,array('class'=>'reqForm'),"<i class='fa fa-fw fa-dot-circle-o'></i>");																			
													$CI->make->eDivCol();												
												$CI->make->eDivRow();
											$CI->make->eDivCol();																		
									 $CI->make->eDivRow();
										 
									//-----3rd Row
									$CI->make->sDivRow();
										$CI->make->sDivCol(4);
											$CI->make->hidden('biller_code_old',iSetObj($item,'biller_code'));
											$CI->make->input('Biller Code','biller_code',iSetObj($item,'biller_code'),null,array('class'=>'rOkay reqForm'),"<i class='fa fa-fw fa-bank'></i>");																			
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);
											// $CI->make->currenciesDrop("Supplier's Currency",'curr_code',iSetObj($item,'curr_code'),'',array());
											$CI->make->input('Confirm Biller Code','con_biller_code',iSetObj($item,'biller_code'),null,array('class'=>'rOkay'),"<i class='fa fa-fw fa-bank'></i>");											
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);
											$CI->make->masterTaxTypeDrop('Tax Group','tax_group_id',iSetObj($item,'tax_group_id'),'',array());																			
										$CI->make->eDivCol();									
									 $CI->make->eDivRow();
										 
									//-----4rt Row
									$CI->make->sDivRow();
										$CI->make->sDivCol(4);
											$CI->make->paymentTermsDrop('Payment Terms','payment_terms',iSetObj($item,'payment_terms'),'',array('class'=>'reqForm'));																	
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);
											$CI->make->drInvoiceDrop('D.R./Invoice','dr_inv',iSetObj($item,'dr_inv'),'',array('class'=>'reqForm'));																			
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);
											$CI->make->purchasersDrop('Purchaser','purchaser_id',iSetObj($item,'purchaser_id'),'',array('class'=>'rOkay combobox reqForm'));																			
										$CI->make->eDivCol();
										
										// $CI->make->sDivCol(4);
											// $CI->make->inactiveDrop('Inactive','inactive',iSetObj($item,'inactive'));																			
										// $CI->make->eDivCol();	
									 $CI->make->eDivRow();
										 
									//-----5th Row
									$CI->make->sDivRow();
										
										$CI->make->sDivCol(8);
											$CI->make->sDivRow();
												$CI->make->sDivCol(4);
													$CI->make->checkbox('Is Consignor?', 'is_consignor', (iSetObj($item,'is_consignor') == 0 ? 0 : 1), array('class'=>'consignor_checker reqForm'), (iSetObj($item,'is_consignor') == 0 ? 0 : 1));																	
												$CI->make->eDivCol();
												$CI->make->sDivCol(4);
													$CI->make->input('Consignment %','consignment_percent',iSetObj($item,'consignment_percent'),null,array('class'=>'num_without_decimal con_percent formInputMini reqForm'),"%");																		
												$CI->make->eDivCol();
												$CI->make->sDivCol(4);
													$CI->make->checkbox('Is CWO?', 'is_cwo', (iSetObj($item,'is_cwo') == 0 ? 0 : 1), array('class'=>'cwo_checker reqForm'), (iSetObj($item,'is_cwo') == 0 ? 0 : 1));															
												$CI->make->eDivCol();	
											$CI->make->eDivRow();
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);	
											$CI->make->sDivRow(array('id'=>'smg_div'));

											$CI->make->eDivRow();
										$CI->make->eDivCol();
										
									 $CI->make->eDivRow();
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(4);
									$CI->make->H(4,"Auto P.O. Settings",array('style'=>'margin-top:0px;margin-bottom:0px'));
									$CI->make->append('<hr class="style-two" style="margin-top: 10px;"/>');
									
									$CI->make->sDivRow();
										// $CI->make->sDivCol();		
											// $CI->make->purchasersDrop('Purchaser','purchaser','','',array());	
										// $CI->make->eDivCol();	//-----1st Col
										$CI->make->sDivCol();		
											$CI->make->input('Delivery Lead Time','delivery_lead_time',iSetObj($item,'delivery_lead_time'),null,array('class'=>'rOkay num_without_decimal formInputMini reqForm', 'maxlength'=>6));
										$CI->make->eDivCol();
										$CI->make->sDivCol();		
											$CI->make->input('Email Address for P.O.','email_po',iSetObj($item,'email_po'),null,array('class'=>'rOkay hl_email reqForm'),"<i class='fa fa-fw fa-envelope'></i>");
										$CI->make->eDivCol();
										$CI->make->sDivCol();		
											$CI->make->input('Email Address for Payment','email_payment',iSetObj($item,'email_payment'),null,array('class'=>'rOkay hl_email reqForm'),"<i class='fa fa-fw fa-envelope'></i>");
										$CI->make->eDivCol();
										$CI->make->sDivCol();		
											$CI->make->sDivRow();
												$CI->make->sDivCol(7);
													// $CI->make->poScheduleDrop('P.O. Schedule','po_schedule',iSetObj($item,'po_schedule'),'',array());
													$CI->make->poScheduleDrop('P.O. Schedule','po_schedule',iSetObj($item,'po_schedule'),'',array('class'=>'rOkay reqForm'));
												$CI->make->eDivCol();
												$CI->make->sDivCol(5);
													$CI->make->input('Selling Days','selling_days',iSetObj($item,'selling_days'),null,array('class'=>'rOkay reqForm'), '', 'days');
													$CI->make->hidden('po_selling_days','');
												$CI->make->eDivCol();
											 $CI->make->eDivRow();
										$CI->make->eDivCol();
										
										$CI->make->sDivCol();		
											$CI->make->button(fa('fa-save').' Save Supplier Information',array('id'=>'save-btn','class'=>'btn-block'),'primary');				
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eDivCol();
								
								/*
								# TEMPORARILY HIDE
								$CI->make->sDivCol(4);
									$CI->make->H(4,"General Ledger Accounts",array('style'=>'margin-top:0px;margin-bottom:0px'));
									$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->accountDrop('Payment Discount Account','payment_discount_account',iSetObj($item,'payment_discount_account'),
												'Select Item Payment discount Account',array('class'=>'combobox'));
											$CI->make->accountDrop('Payable Account','payable_account',iSetObj($item,'payable_account'),
												'Select Payable Account',array('class'=>'combobox'));
											$CI->make->accountDrop('Purchase Account','purchase_account',iSetObj($item,'purchase_account'),
												'Select Purchase Account',array('class'=>'combobox'));
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eDivCol();
								*/
								
							$CI->make->eDivRow();
							
							/*
							$CI->make->sDivRow();
								$CI->make->sDivCol(4);					
								$CI->make->eDivCol();	//-----1st Col
								
								$CI->make->sDivCol(4);				
								$CI->make->eDivCol();	//-----3rd Col								
								
								$CI->make->sDivCol(4);
								$CI->make->button(fa('fa-save').' Save Supplier Information',array('id'=>'save-btn','class'=>'btn-block'),'primary');							
								$CI->make->eDivCol();	//-----2nd Col
							$CI->make->eDivRow();
							*/
							
						$CI->make->eForm();
						
					$CI->make->eBoxBody();
				$CI->make->eBox();
					
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();

}
//-----APM
function load_supplier_group_ddb(){
	$CI =& get_instance();
	$supp_group = array();
	
	$where = array('inactive'=>0);
	$supp_group = $CI->admin_model->get_all_active_supp_group($where,'supplier_master_group');
	
	$CI->make->sDivRow();
		$CI->make->sDivCol(9);
			// $CI->make->supplierMasterGroupDrop('Supplier Master Group','group_id','','&nbsp;',array('class'=>'combobox sup_master_group_ddb'));			
			$options = array();
			$options['NOT APPLICABLE'] = "0";
			 $ctr = 1;
                $selected = "";
			foreach ($supp_group as $res) {
                    // if($ctr == 1)
                        // $selected = $res->id;
				$selected = '';
                    $options[$res->name] = $res->id;
                    $ctr++;
                }	
			$CI->make->select('Supplier Master Group','group_id',$options,$selected,array('class'=>'combobox sup_master_group_ddb'));
			// $CI->make->select('Supplier Master Group','group_id',$options,$selected,array('class'=>' sup_master_group_ddb'));
			$CI->make->hidden('hidden_group_id','', array('class'=>'c_hidden_group_id'));
		$CI->make->eDivCol();
		$CI->make->sDivCol(2, 'left', 0, array('style'=>'margin-left: -20px; margin-top: 25px;'));
			$CI->make->button(fa('fa-plus'),array('id'=>'click-btn','class'=>'btn'),'primary');	
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	 return $CI->make->code();
}
function load_supplier_group_ddb_add($passed_group_id=null){
	$CI =& get_instance();
	$supp_group = array();
	// echo "Passed group id :".$passed_group_id."<br>"; #CHECKER
	$where = array('inactive'=>0);
	$supp_group = $CI->admin_model->get_all_active_supp_group($where,'supplier_master_group');
	
	$CI->make->sDivRow();
		$CI->make->sDivCol(9);
			// $CI->make->supplierMasterGroupDrop('Supplier Master Group','group_id','','&nbsp;',array('class'=>'combobox sup_master_group_ddb'));			
			$options = array();
			$options['NOT APPLICABLE'] = "0";
			 $ctr = 1;
                $selected = "";
			foreach ($supp_group as $res) {
                    // // if($ctr == 1)
                        // // $selected = $res->id;
				// $selected = '';
				if($passed_group_id != '')
					$selected = $passed_group_id;
                    $options[$res->name] = $res->id;
                    $ctr++;
                }	
			$CI->make->select('Supplier Master Group','group_id',$options,$selected,array('class'=>'combobox sup_master_group_ddb'));
			$CI->make->hidden('hidden_group_id','', array('class'=>'c_hidden_group_id'));
		$CI->make->eDivCol();
		$CI->make->sDivCol(2, 'left', 0, array('style'=>'margin-left: -20px; margin-top: 25px;'));
			$CI->make->button(fa('fa-plus'),array('id'=>'click-btn','class'=>'btn'),'primary');	
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	 return $CI->make->code();
}
function supplier_master_group_adder_form(){
	$CI =& get_instance();
		// echo var_dump($sb_det);
		$CI->make->sForm("admin/add_to_supplier_group_db",array('id'=>'supp_master_group_adder_form'));
			
			$CI->make->sDivRow(array('style'=>'margin:2px;'));
				$CI->make->sDivCol(12,'center',0,array("style"=>''));
					$CI->make->sBox('success',array('div-form'));
						$CI->make->sBoxBody(array('style'=>''));
	
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->input('Supplier Group Name','supp_group_name','',null,array('class'=>'rOkay c_supp_group_name'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			
		$CI->make->eForm();
	
	return $CI->make->code();
}
//-----APM
//----------Suppliers----------RHAN-----END


function discount_typePage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Discount Types',base_url().'admin/manage_discount_types',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$th = array(
									'Short Description' => array('width'=>'20%'),
									'Description' => array('width'=>'20%'),
									'Type' => array('width'=>'20%'),
									'Amount' => array('width'=>'20%'),
									
									'Is Inactive' => array('width'=>'20%'),
									' '=>array('width'=>'11%','align'=>'right'));
									
									
									
									
							$rows = array();
							// echo var_dump($list);
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/manage_discount_types/'.$val->id,array("return"=>true));
								$rows[] = array(
							
											  
											  $val->short_desc,
											  $val->description,
											  ($val->percentage == 0 ? 'Amount' : 'Percentage'),
											  ($val->percentage == 0 ? $val->amount : $val->percentage),											  
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

function manage_discount_types_form($item=null){
    $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/discount_types_list',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
				// $CI->make->hidden('asset_id',iSetObj($item,'asset_id'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
				
					$tabs = array(
						fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
						////-----UNCOMMENT TO LOAD SAMPLE TABS
						// fa('fa-money')." GL Entries"=>array('href'=>'#accounting','class'=>'tab_link load-tab','load'=>'asset/gl_entries','id'=>'accounting_link'),
						// fa('fa-book')." History" => array('href'=>'#history','class'=>'tab_link load-tab','load'=>'asset/histoy_load','id'=>'history_link'),
					);
					
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

							$CI->make->sForm("admin/discount_types_details_db",array('id'=>'discount_types_details_form'));
								$CI->make->hidden('id',iSetObj($item,'id'));
								$CI->make->hidden('mode', ((iSetObj($item,'id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									
									$amount = 0;
									$type = "";
									if(!empty($item)){
										if($item->percentage == 0){
											$amount = $item->amount;
											$type = 'amount';
										}else{
											$amount = $item->percentage;
											$type = 'percent';
										}
									}
									
									//-----1st Col
									$CI->make->sDivCol(5);
									
									$CI->make->input('Short Description','short_desc',iSetObj($item,'short_desc'),null,array('class'=>'rOkay reqForm'));
									$CI->make->input('Description.','description',iSetObj($item,'description'),null,array('class'=>'rOkay reqForm'));
									$CI->make->discountTypeDrop('Type','type',$type,'Select Discount Type',array('class'=>'rOkay reqForm'));
									$CI->make->input('Amount','amount',$amount,null,array('class'=>'rOkay reqForm'));
									$CI->make->inactiveDrop('Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'reqForm'));
									$CI->make->eDivCol();

									$CI->make->eDivRow();
									
						
									
									//-----Unblock this to show sample of product dropdown
									// $CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										// $CI->make->sDivCol(4);
										// $CI->make->eDivCol();
										
										// $CI->make->sDivCol(4, 'right');
											// $CI->make->productsDrop('Products','product_drop','',null,array('class'=>''));
										// $CI->make->eDivCol();
										
										// $CI->make->sDivCol(4);
										// $CI->make->eDivCol();
									// $CI->make->eDivRow();

									$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										$CI->make->sDivCol(1);
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(10, 'center');
											$CI->make->button(fa('fa-save').' Save Discount Types Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4);
										$CI->make->eDivCol();
									$CI->make->eDivRow();

							$CI->make->eForm();

						$CI->make->eTabPane();
					
					////-----UNCOMMENT TO LOAD SAMPLE TABS
						// $CI->make->sTabPane(array('id'=>'accounting','class'=>'tab-pane'));
						// $CI->make->eTabPane();

						// $CI->make->sTabPane(array('id'=>'history','class'=>'tab-pane bg-white-gray','style'=>'margin:-10px;'));
						// $CI->make->eTabPane();
						
					$CI->make->eTabBody();
				$CI->make->eTab();
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();
}

//********************END Joshua***************************
function users_page($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New User',base_url().'admin/user_form',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$th = array(
								//	'Suppliers Code ' => array(),
									'Employee ID' => array(),
									'Employee Name' => array(),
									'Role' => array(),
									' '=>array());
							$rows = array();
							foreach($list as $val){
								$role = $CI->admin_model->get_role($val->role);
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/user_form/'.$val->id,array("return"=>true));					
								$rows[] = array(
											   $val->id,
											   $val->fname.' '.$val->mname.' '.$val->lname,
											   $role,
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
function user_form($user=null){

  $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-top: -10px; margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/users',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
				
						$CI->make->sForm("user_details_db",array('id'=>'users_form'));
							/* GENERAL DETAILS */
							$CI->make->sDivRow(array('style'=>'margin:10px;'));
								$CI->make->sDivCol(3);
									$CI->make->hidden('id',iSetObj($user,'id'));
									$CI->make->hidden('mode', ((iSetObj($user,'id')) ? 'edit' : 'add'));
									$CI->make->input('First Name','fname',iSetObj($user,'fname'),'First Name',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('Middle Name','mname',iSetObj($user,'mname'),'Middle Name',array('calss'=>'reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('Last Name','lname',iSetObj($user,'lname'),'Last Name',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('Suffix','suffix',iSetObj($user,'suffix'),'Suffix',array('class'=>'reqForm'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();

							$CI->make->sDivRow(array('style'=>'margin:10px;'));	
								$CI->make->sDivCol(6);
										$CI->make->input('Username','uname',iSetObj($user,'username'),'Username',array('class'=>'rOkay',iSetObj($user,'id')?'disabled':''=>''));
										if(!iSetObj($user,'id'))
										$CI->make->input('Password','password',iSetObj($user,'password'),'Password',array('type'=>'password','class'=>'rOkay',iSetObj($user,'id')?'disabled':''=>''));
										$CI->make->input('Email','email',iSetObj($user,'email'),'Email',array('class'=>'reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
										$CI->make->input('Employee ID','emp_id',iSetObj($user,'emp_id'),'',array('class'=>'rOkay formInputMini',iSetObj($user,'emp_id')?'disabled':''=>''));
										$CI->make->roleDrop('Role','role',iSetObj($user,'role'),'Role',array('class'=>'reqForm'));
										$CI->make->genderDrop('Gender','gender',iSetObj($user,'gender'),array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow(array('style'=>'margin-left:400px;'));
								$CI->make->sDivCol(5,'center');
									$CI->make->button(fa('fa-save').' Save User Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							/* GENERAL DETAILS END */
						$CI->make->eForm();
						
					$CI->make->eBoxBody();
				$CI->make->eBox();
					
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();

}

//-------BRANCH COUNTERS------[START]//
function branch_counters_page($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Branch Counter',base_url().'admin/branch_counters_form',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$th = array(
									'Branch' => array(),
									'Counter #' => array(),
									'TIN' => array(),
									'Permit #' => array(),
									'Serial #' => array(),
									'MIN' => array(),
									'Is Inactive' => array(),
									' '=>array());
							$rows = array();
							foreach($list as $val){
								$branch = $CI->admin_model->get_branch_code_from_id($val->branch_id);
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/branch_counters_form/'.$val->id,array("return"=>true));					
								$rows[] = array(
											   $branch,
											   $val->counter_no,
											   $val->tin,
											   $val->permit_no,
											   $val->serial_no,
											   $val->min,
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
function branch_counter_form($br_counter=null){

  $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-top: -10px; margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/branch_counters',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
				
						$CI->make->sForm("admin/branch_counter_details_db",array('id'=>'branch_counter_form'));
							/* GENERAL DETAILS */
							$CI->make->sDivRow(array('style'=>'margin:10px;'));
								$CI->make->sDivCol(3);
									$CI->make->hidden('id',iSetObj($br_counter,'id'));
									$CI->make->hidden('mode', ((iSetObj($br_counter,'id')) ? 'edit' : 'add'));
									$CI->make->branchesMasterDrop('Branch','branch_id',iSetObj($br_counter,'branch_id'),'Select Branch',array('class'=>'rOkay reqForm branch_dropdown'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('Counter #','counter_no',iSetObj($br_counter,'counter_no'),'Counter #',array('calss'=>'reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('Serial #','serial_no',iSetObj($br_counter,'serial_no'),'Serial #',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('Permit #','permit_no',iSetObj($br_counter,'permit_no'),'Permit #',array('calss'=>'reqForm'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();

							$CI->make->sDivRow(array('style'=>'margin:10px; margin-left:200px;'));	
								$CI->make->sDivCol(3);
									$CI->make->input('TIN','tin',iSetObj($br_counter,'tin'),'TIN',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('MIN','min',iSetObj($br_counter,'min'),'MIN',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->inactiveDrop('Inactive','inactive',iSetObj($br_counter,'inactive'),null,array('class'=>'reqForm'));
								$CI->make->eDivCol();
								
							$CI->make->eDivRow();
							$CI->make->sDivRow(array('style'=>'margin-left:400px;'));
								$CI->make->sDivCol(5,'center');
									$CI->make->button(fa('fa-save').' Save Branch Counter',array('id'=>'save-btn','class'=>'btn-block'),'primary');
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							/* GENERAL DETAILS END */
						$CI->make->eForm();
						
					$CI->make->eBoxBody();
				$CI->make->eBox();
					
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();

}
//-------BRANCH COUNTERS------[END]//

	// ______________________________________________________ new lester _________________________________________

function branch_page($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Branch',base_url().'admin/branch_form',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$th = array(
								//	'Suppliers Code ' => array(),
									'Branch Code' => array(),
									'Description' => array(),
									'Aria Database' => array(),
									);
							$rows = array();
							foreach($list as $val){
								$links = "";
								// $links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'admin/branch_form/'.$val->branch_code,array("return"=>true));					
								$rows[] = array(
											   $val->branch_code,
											   $val->description,
											   $val->aria_db
											   // $links
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


function branch_form($user=null){

  $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-top: -10px; margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'admin/branch',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
				
						$CI->make->sForm("admin/save_branch",array('id'=>'branch_form'));
							/* GENERAL DETAILS */
							$CI->make->sDivRow(array('style'=>'margin:10px;','id'=>'branch_div'));
								$CI->make->sDivCol(4);
									$CI->make->hidden('branch_code',iSetObj($user,'branch_code'));
									$CI->make->hidden('mode', ((iSetObj($user,'branch_code')) ? 'edit' : 'add'));
									$CI->make->input('Branch Code','b_code',iSetObj($user,'branch_code'),'Branch Code',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
									$CI->make->input('Description','desc',iSetObj($user,'description'),'Description',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
									$CI->make->input('Aria Database','aria_db',iSetObj($user,'aria_db'),'Aria Database',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
							$CI->make->sDivRow(array('style'=>'margin-left:400px;'));
								$CI->make->sDivCol(5,'center');
									$CI->make->button(fa('fa-save').' Save New Branch',array('id'=>'save-branch','class'=>'btn-block'),'primary');
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							/* GENERAL DETAILS END */
						$CI->make->eForm();
						
					$CI->make->eBoxBody();
				$CI->make->eBox();
					
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();

}
	// ______________________________________________________ new lester _________________________________________

?>