<?php
//-----------Product Listing Maker-----start-----allyn
function productPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Product',base_url().'product/manage_products',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Product Code' => array('width'=>'30%'),
									'Product Name' => array('width'=>'40%'),
									'Is Inactive' => array('width'=>'20%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'product/manage_products/'.$val->product_id,array("return"=>true));
								$rows[] = array(
											  $val->product_code,
											  $val->product_name,
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
//-----------Product Listing Maker-----end-----allyn
//-----------Product Add / Edit form-----start-----allyn
function manage_product_form($item=null){
    $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'product/products',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
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

							$CI->make->sForm("product/product_details_db",array('id'=>'product_details_form'));
								$CI->make->hidden('product_id',iSetObj($item,'product_id'));

								$CI->make->sDivRow();
									//-----1st Row
									$CI->make->sDivCol(4);
										$CI->make->input('Product Code','product_code',iSetObj($item,'product_code'),null,array('class'=>'rOkay'));
										////----sample pre-made forms
									// $CI->make->textarea('Address','address','',null,array('class'=>''));
										// $CI->make->input('Email','email','',null,array('class'=>''));
										// $CI->make->input('GSTNo/TIN No.','tax_no','',null,array('class'=>''));
										// $CI->make->currenciesDrop("Customer's Currency",'currency','',null,array('class'=>''));
									$CI->make->eDivCol();

									//-----2nd Row
									$CI->make->sDivCol(4);
									$CI->make->input('Product Name','product_name',iSetObj($item,'product_name'),null,array('class'=>'rOkay'));
									////----sample pre-made forms
										// $CI->make->decimal('Discount Percent','discount','',null,2,array('class'=>''),null,'%');
										// $CI->make->decimal('Prompt Payment Discount Percent','payment_discount','',null,2,array('class'=>''),null,'%');
										// $CI->make->decimal('Credit Limit','credit_limit','',null,2,array('class'=>''));
										// $CI->make->paymentTermsDrop('Payment Term','payment_term','',null,array('class'=>''));
										// $CI->make->creditStatusDrop('Credit Status','credit_status','',null,array('class'=>''));
										// $CI->make->input('Business Style','business_style','',null,array('class'=>''));
									$CI->make->eDivCol();
									
									//-----3rd Row
									$CI->make->sDivCol(4);
											$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>''));
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
										$CI->make->sDivCol(4);
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4, 'right');
											$CI->make->button(fa('fa-save').' Save Product Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
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
//-----------Product Add / Edit form-----end-----allyn
?>