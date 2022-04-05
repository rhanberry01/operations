<?php

function neg_item_list($items = array()){

$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sBox('success	');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol(12,'left');
							$CI->make->A('Search By :');
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol(3);
										$CI->make->prod_cat_Drop('Product Category','category','','Select Category.',array('class'=>'rOkay combobox','id'=>'category'));
							$CI->make->eDivCol();

							$CI->make->sDivCol(6);
										$CI->make->supplier_Drop('Supplier','supplier','','Select Supplier.',array('class'=>'rOkay combobox','id'=>'supplier'));
							$CI->make->eDivCol();
						$CI->make->sDivCol(3);
									$CI->make->button('Search',array('id'=>'btn_search', 'style'=>' margin-top: 20px;margin-right: 25px;','class'=>'btn-block'),'primary');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->eDivRow();
					$CI->make->sDivRow();													
					$CI->make->sDivCol();
						$CI->make->sDiv(array('id'=>'asset_list_data'));	
								$CI->make->sBox('warning');
									$CI->make->sBoxBody();
											$CI->make->sDivRow();
												$CI->make->sDivCol();
													$CI->make->sDiv(array('class'=>'table-responsive'));
														$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
															$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
																$CI->make->th('Vendor Code',array('style'=>''));
																$CI->make->th('Vendor Name',array('style'=>''));
																$CI->make->th('Product Category',array('style'=>''));
																$CI->make->th('Product Code',array('style'=>''));
																$CI->make->th('Description',array('style'=>''));
																$CI->make->th('Quantity',array('style'=>''));
																$CI->make->th('Actions',array('style'=>'','colspan'=>'2'));
															$CI->make->eRow();
															
														$CI->make->eTable();
													$CI->make->eDiv();
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eBoxBody();
									$CI->make->eBox();
								$CI->make->eDivCol();
						$CI->make->eDiv();	
					$CI->make->eDivCol();
					$CI->make->eDivRow();


		$CI->make->eDivRow();


	return $CI->make->code();
}

function negative_inventory_reload($items = array()){

$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sBox('warning');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										$CI->make->th('Vendor Code',array('style'=>''));
										$CI->make->th('Vendor Name',array('style'=>''));
										$CI->make->th('Product Category',array('style'=>''));
										$CI->make->th('Product Code',array('style'=>''));
										$CI->make->th('Description',array('style'=>''));
										$CI->make->th('Quantity',array('style'=>''));
										$CI->make->th('Actions',array('style'=>'','colspan'=>'2'));
									$CI->make->eRow();
								foreach($items as $v){

									$adjusment = $CI->make->A(
											fa('fa-edit fa-lg fa-fw'),
											'',
											array('class'=>'btn btn-success action_btns update_link',
											'ref_desc'=>'',
											'id'=>$v->ProductID,
											'title'=>'Adjustments',
											'style'=>'cursor: pointer;',
											'return'=>'false'));


									// $check = false;
									// $checkbox =$CI->make->checkbox('','chk[]',$v->ProductID,array('return'=>true,'id'=>$v->ProductID,'class'=>'check'),$check);

									$CI->make->sRow();
											$CI->make->td($v->vendorcode);	
											$CI->make->td($v->vendor);	
											$CI->make->td($v->category);	
											$CI->make->td($v->ProductCode);	
											$CI->make->td($v->Description);
											$CI->make->td($v->SellingArea);	
											$CI->make->td($adjusment);	
											// $CI->make->td($checkbox);	
									$CI->make->eRow();
						}

	return $CI->make->code();
}

function item_adjustment_modal($item_details = array(),$id=null,$next_trans=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sForm("",array('id'=>'ajustment_form'));
		$CI->make->sDivCol();
		$CI->make->sDiv(array('id'=>'modal_list', 'style'=>'height: 480px; overflow-x: none; '));
			$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol(12);
									$CI->make->sDivCol(4);
										$CI->make->datefield('Adjustment Date','date_adjustment',date('Y-m-d'),'',array('class'=>'rOkay','required'=>'required','id'=>'date_adjustment'));
									$CI->make->eDivCol();
								$CI->make->eDivCol();
								$CI->make->sDivCol(12);
									$CI->make->sDivCol(4);
										$CI->make->input('Transaction No:','trans_num',$next_trans,'',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'trans_num'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Movements','movement','Inventory Gained (SA)','',array('class'=>'','disabled'=>'disabled','required'=>'required','id'=>'movement'));
									$CI->make->eDivCol();
								$CI->make->eDivCol();
								$CI->make->sDivCol(12);
									foreach($item_details as $v){
									$CI->make->sDivCol(4);
										$CI->make->input('Vendor','v_code',$v->vendorcode.'-'.$v->vendor,'',array('class'=>'','disabled'=>'disabled','required'=>'required','id'=>'v_code'));
										$CI->make->hidden('product_id',$v->ProductID,array('id'=>'product_id'));
										$CI->make->hidden('vendor_code',$v->vendorcode,array('id'=>'vendor_code'));
										$CI->make->hidden('vendor_name',$v->vendor,array('id'=>'vendor_name'));
										$CI->make->hidden('cost',$v->CostOfSales,array('id'=>'cost'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Product Code','p_code',$v->ProductCode,'',array('class'=>'','disabled'=>'disabled','required'=>'required','id'=>'p_code'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Description','p_desc',$v->Description,'',array('class'=>'','disabled'=>'disabled','required'=>'required','id'=>'p_desc'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Quantity','qty','','Quantity',array('id'=>'qty','required'=>'required','id'=>'qty'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->hidden('uom_qty',array('id'=>'uom_qty'));
										$CI->make->unit_Drop('UNITS','unit','','Select Units.',array('class'=>'rOkay combobox','id'=>'unit','required'=>'required'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(2);
										$CI->make->input('Unit Cost','unit_cost','','Unit Cost',array('id'=>'unit_cost','class'=>'rOkay','disabled'=>'disabled'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(2);
										$CI->make->input('Total Cost','total','','Total Cost',array('id'=>'total','class'=>'rOkay','disabled'=>'disabled'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(12);
										$CI->make->textarea('Remarks','remarks','','Remarks', array('id'=>'remarks','style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
									$CI->make->eDivCol();
									}
								$CI->make->eDivCol();
								$CI->make->sDivCol(12,'right');
									$CI->make->button(fa('fa-save').' Update Adjustment',array('id'=>'update_adjustment', 'style'=>' margin-top: 25px;'),'success');
								$CI->make->sDivCol(4,'center');
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
			$CI->make->eBox();
			$CI->make->eDiv();
		$CI->make->eDivCol();
	$CI->make->eForm();
	$CI->make->eDivRow();
	
	return $CI->make->code();
	
}

function adjustment_inquiry($items = array(),$branch_name = null){
$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sBox('success	');
			$CI->make->sBoxBody();
					$CI->make->sDivRow();													
					$CI->make->sDivCol();
						$CI->make->sDiv(array('id'=>'adjustment'));	
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
										$CI->make->sTable(array('class'=>'table table-hover','id'=>'adjustment-tbl'));
											$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
												$CI->make->th('Branch',array('style'=>''));
												$CI->make->th('Date Created',array('style'=>''));
												$CI->make->th('TransNo',array('style'=>''));
												$CI->make->th('MoveMent Type',array('style'=>''));
												$CI->make->th('Created By',array('style'=>''));
												$CI->make->th('Date Posted',array('style'=>''));
												$CI->make->th('Approved By',array('style'=>''));
												$CI->make->th('Posted By',array('style'=>''));
												$CI->make->th('Status',array('style'=>''));
												$CI->make->th('Extended',array('style'=>''));
												$CI->make->th('Action',array('style'=>'','colspan'=>'2'));
												// $CI->make->th('Checkbox',array('style'=>''));
											$CI->make->eRow();
											$CI->make->eRow();
											foreach($items as $v){

												$adjusment = 
													$CI->make->A(
														fa('fa-eye fa-lg fa-fw').'',
														'',
														array('class'=>'btn btn-success action_btns btn_view',
														'ref_desc'=>'',
														'id'=>$v->a_id,
														'style'=>'cursor: pointer;',
														'return'=>'false'));

												$adjusment_del = 
													$CI->make->A(
														fa('fa-trash fa-lg fa-fw').'',
														'',
														array('class'=>'btn btn-danger action_btns btn_del',
														'ref_desc'=>'',
														'id'=>$v->a_id,
														'style'=>'cursor: pointer;',
														'return'=>'false'));
												
												
												// $check = false;
												// $checkbox =$CI->make->checkbox('','chk[]',$v->a_id,array('return'=>true,'id'=>$v->a_id,'class'=>'check'),$check);
		

												$username = $CI->asset->get_username($v->a_created_by);
												$CI->make->sRow();
														$CI->make->td($branch_name);	
														$CI->make->td($v->a_date_created);	
														$CI->make->td($v->a_trans_no);	
														$CI->make->td('Inventory Gained (SA)');	
														$CI->make->td($username);
														$CI->make->td();	
														$CI->make->td();	
														$CI->make->td();	
														$CI->make->td('Open');	
														$CI->make->td(number_format($v->price_pcs,2));	
														$CI->make->td();	
														$CI->make->td($adjusment_del);
														// $CI->make->td($checkbox);	
												$CI->make->eRow();
											}
										$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eDiv();	
					$CI->make->eDivCol();
					$CI->make->eDivRow();
		$CI->make->eDivRow();
	return $CI->make->code();
}
?>