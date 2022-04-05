<?php
function build_dashboard($list=array(), $new_items = null, $new_barcodes=null, $barcodes_schedule=null, $barcode_price_stock_logs=null,  $supplier_stocks_logs=null, $supplier_biller_code_logs = null, $stock_deletion_approval = null, $stock_barcode_price_approval = null, $stock_marginal_markdown_approval= null){
	$CI =& get_instance();

	// $CI->make->sDivRow();
		// $CI->make->sDivCol();
			// $CI->make->sBox('success');
				// $CI->make->sBoxBody();
				
					// $CI->make->sDivRow();
						// $CI->make->sDivCol();
							// $CI->make->sDivRow();
								// $CI->make->sDivCol(3);
									// $CI->make->sDiv(array('class'=>'small-box bg-yellow'));
										// $CI->make->sDiv(array('class'=>'inner'));
											// $CI->make->H(3,"150",array());
											// $CI->make->P('New Orders',array());
										// $CI->make->eDiv();
										
										// $CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											// $CI->make->append('<i class="ion ion-bag"></i>');
										// $CI->make->eDiv();
										
										// // $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer'));
										// $CI->make->A('&nbsp;','#',array('class'=>'small-box-footer'));
										
									// $CI->make->eDiv();
								// $CI->make->eDivCol();
								
								// $CI->make->sDivCol(3);
									// $CI->make->sDiv(array('class'=>'small-box bg-green'));
										// $CI->make->sDiv(array('class'=>'inner'));
											// // $CI->make->H(3,"Detergent",array());
											// $CI->make->H(3,"Beverages",array());
											// $CI->make->P('Top Seller',array());
										// $CI->make->eDiv();
										
										// $CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											// $CI->make->append('<i class="ion ion-stats-bars"></i>');
										// $CI->make->eDiv();
										
										// // $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer'));
										// $CI->make->A('&nbsp;','#',array('class'=>'small-box-footer'));
										
									// $CI->make->eDiv();
								// $CI->make->eDivCol();
								
								// $CI->make->sDivCol(3);
									// $CI->make->sDiv(array('class'=>'small-box bg-aqua'));
										// $CI->make->sDiv(array('class'=>'inner'));
											// $CI->make->H(3,"870",array());
											// $CI->make->P('Customers per Day',array());
										// $CI->make->eDiv();
										
										// $CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											// $CI->make->append('<i class="ion ion-person-add"></i>');
										// $CI->make->eDiv();
										
										// // $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer'));
										// $CI->make->A('&nbsp;','#',array('class'=>'small-box-footer'));
										
									// $CI->make->eDiv();
								// $CI->make->eDivCol();
								
								// $CI->make->sDivCol(3);
									// $CI->make->sDiv(array('class'=>'small-box bg-red'));
										// $CI->make->sDiv(array('class'=>'inner'));
											// $CI->make->H(3,"Php 879, 000",array());
											// $CI->make->P('Highest Sales Per Day',array());
										// $CI->make->eDiv();
										
										// $CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											// $CI->make->append('<i class="ion ion-pricetags"></i>');
										// $CI->make->eDiv();
										
										// // $CI->make->A('More info <i class="fa fa-arrow-circle-right"></i>','#',array('class'=>'small-box-footer'));
										// $CI->make->A('&nbsp;','#',array('class'=>'small-box-footer'));
										
									// $CI->make->eDiv();
								// $CI->make->eDivCol();
								
							// $CI->make->eDivRow();
						// $CI->make->eDivCol();
					// $CI->make->eDivRow();
					
				// $CI->make->eBoxBody();
			// $CI->make->eBox();
					
		// $CI->make->eDivCol();
	// $CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
				
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDivRow();
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($new_items > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($new_items > 0 ? $new_items : '0'),array());
											$CI->make->P('Pending New Items',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-ios-box"></i>');
										$CI->make->eDiv();
										$CI->make->A(($new_items > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($new_items > 0 ? 'details' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($new_barcodes > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($new_barcodes > 0 ? $new_barcodes : '0'),array());
											$CI->make->P('Pending Barcode Items',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-pricetags"></i>');
										$CI->make->eDiv();
										$CI->make->A(($new_barcodes > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($new_barcodes > 0 ? 'price' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
	
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($barcodes_schedule > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($barcodes_schedule > 0 ? $barcodes_schedule : '0'),array());
											$CI->make->P('Pending Scheduled Markdown',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-ios-alarm"></i>');
										$CI->make->eDiv();
										$CI->make->A(($barcodes_schedule > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($barcodes_schedule > 0 ? 'markdown' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($supplier_stocks_logs > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($supplier_stocks_logs > 0 ? $supplier_stocks_logs : '0'),array());
											$CI->make->P('Pending Supplier Stocks',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-cube"></i>');
										$CI->make->eDiv();
										$CI->make->A(($supplier_stocks_logs > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($supplier_stocks_logs > 0 ? 'supplier_stock' : '')));
										
									$CI->make->eDiv();
							
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
								
			
								$CI->make->eDivCol();
									$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($barcode_price_stock_logs > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($barcode_price_stock_logs > 0 ? $barcode_price_stock_logs : '0'),array());
											$CI->make->P('Pending Stock General Update',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-document-text"></i>');
										$CI->make->eDiv();
										$CI->make->A(($barcode_price_stock_logs > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($barcode_price_stock_logs > 0 ? 'update' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($supplier_biller_code_logs > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($supplier_biller_code_logs > 0 ? $supplier_biller_code_logs : '0'),array());
											$CI->make->P('Pending Supplier Biller Code Update',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-ios-pricetags-outline"></i>');
										$CI->make->eDiv();
										$CI->make->A(($supplier_biller_code_logs > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($supplier_biller_code_logs > 0 ? 'biller_code' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
									$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($stock_barcode_price_approval > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($stock_barcode_price_approval > 0 ? $stock_barcode_price_approval : '0'),array());
											$CI->make->P('Pending Stock Price Update',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-cash"></i>');
										$CI->make->eDiv();
										$CI->make->A(($stock_barcode_price_approval > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($stock_barcode_price_approval > 0 ? 'stock_barcode_price_approval' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($stock_deletion_approval > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($stock_deletion_approval > 0 ? $stock_deletion_approval : '0'),array());
											$CI->make->P('Pending Stock Deletion',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-ios-minus"></i>');
										$CI->make->eDiv();
										$CI->make->A(($stock_deletion_approval > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($stock_deletion_approval > 0 ? 'stock_deletion' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
								/* $CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($new_barcodes > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($new_barcodes > 0 ? $new_barcodes : '0'),array());
											$CI->make->P('Pending Barcode Items',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-pricetag"></i>');
										$CI->make->eDiv();
										$CI->make->A(($new_barcodes > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($new_barcodes > 0 ? 'price' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
	
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($barcodes_schedule > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($barcodes_schedule > 0 ? $barcodes_schedule : '0'),array());
											$CI->make->P('Pending Scheduled Markdown',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-ios7-alarm-outline"></i>');
										$CI->make->eDiv();
										$CI->make->A(($barcodes_schedule > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($barcodes_schedule > 0 ? 'markdown' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>($barcode_price_stock_logs > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($barcode_price_stock_logs > 0 ? $barcode_price_stock_logs : '0'),array());
											$CI->make->P('Pending Price Update',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-pricetag"></i>');
										$CI->make->eDiv();
										$CI->make->A(($barcode_price_stock_logs > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($barcode_price_stock_logs > 0 ? 'update' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol() */;
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
									$CI->make->sDiv(array('class'=>($stock_marginal_markdown_approval > 0 ? 'small-box bg-red' : 'small-box bg-green')));
										$CI->make->sDiv(array('class'=>'inner'));
											$CI->make->H(3,($stock_marginal_markdown_approval > 0 ? $stock_marginal_markdown_approval : '0'),array());
											$CI->make->P('Pending Marginal Markdown',array());
										$CI->make->eDiv();
										
										$CI->make->sDiv(array('class'=>'icon', 'style'=>''));
											$CI->make->append('<i class="ion ion-ios-box"></i>');
										$CI->make->eDiv();
										$CI->make->A(($new_items > 0 ? 'More info <i class="fa fa-arrow-circle-right"></i>' : '&nbsp;' ),'#',array('class'=>'small-box-footer', 'id'=>($stock_marginal_markdown_approval > 0 ? 'marginal' : '')));
										
									$CI->make->eDiv();
			
								$CI->make->eDivCol();

	
								
					$CI->make->eDivRow();
					
				$CI->make->eBoxBody();
			$CI->make->eBox();
					
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	// $CI->make->sDivRow();
		// $CI->make->sDivCol();
			// $CI->make->sBox('warning');
				// $CI->make->sBoxBody();
					
					// $CI->make->sDivRow();
						// $CI->make->sDivCol();
							// $CI->make->sDivRow();
								// $CI->make->sDivCol(12);
									// $CI->make->sDiv(array('class'=>'nav-tabs-custom'));
										// $CI->make->sUl(array('class'=>'nav nav-tabs pull-right'),false);
											// $CI->make->sLi(array('class'=>'active'),false);
												// $CI->make->A('Area','#revenue-chart',array('class'=>'small-box-footer', 'data-toggle'=>'tab'));
											// $CI->make->eLi();
											// // $CI->make->sLi(array(),false);
												// // $CI->make->A('Donut','#sales-chart',array('class'=>'small-box-footer', 'data-toggle'=>'tab'));
											// // $CI->make->eLi();
											// $CI->make->sLi(array('class'=>'pull-left header'),false);
												// $CI->make->append('<i class="ion ion-pricetags"></i>Sales');
											// $CI->make->eLi();
										// $CI->make->eUl();
										// $CI->make->sDiv(array('class'=>'tab-content no-padding'));
											// $CI->make->sDiv(array('class'=>'chart tab-pane active', 'id'=>'revenue-chart', 'style'=>'position: relative; height: 300px;'));
											// $CI->make->eDiv();
											// // $CI->make->sDiv(array('class'=>'chart tab-pane', 'id'=>'sales-chart', 'style'=>'position: relative; height: 300px;'));
											// // $CI->make->eDiv();
										// $CI->make->eDiv();
									// $CI->make->eDiv();
								// $CI->make->eDivCol();
								
								// 
								// $CI->make->sDivCol(4);
									// $CI->make->sDiv(array('class'=>'box-body chart-responsive'));
										// $CI->make->sDiv(array('class'=>'chart', 'id'=>'sales-chart', 'style'=>'height: 300px; position: relative;'));
										
										// $CI->make->eDiv();
									// $CI->make->eDiv();
								// $CI->make->eDivCol();
								//
								
							// $CI->make->eDivRow();
						// $CI->make->eDivCol();
					// $CI->make->eDivRow();
					
				// $CI->make->eBoxBody();
			// $CI->make->eBox();
					
		// $CI->make->eDivCol();
	// $CI->make->eDivRow();
	
	
	return $CI->make->code();
}
function build_category_maintenace_form($category=null)
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/item_category_db",
		array('id'=>'category_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(5);
				$CI->make->hidden('stock_category_id',iSetObj($category,'stock_category_id'));
				$CI->make->input('Category Name','category_name',iSetObj($category,'category_name'),'Category Name',array('class'=>'rOkay'));
				$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($category,'inactive'),'',array('style'=>'width:85px'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function build_uom_maintenace_form($uom=null)
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/uom_db",
		array('id'=>'uom_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(5);
				$CI->make->hidden('uom_id',iSetObj($uom,'uom_id'));
				$CI->make->input('Abbreviation','name',iSetObj($uom,'name'),'Abbreviation',array('class'=>'rOkay','maxchars'=>'15','style'=>'width:120px'));
				$CI->make->input('Descriptive name','description',iSetObj($uom,'description'),'',array('class'=>''));
				$CI->make->number("Decimal places",'decimal_places',iSetObj($uom,'decimal_places'),'',array('style'=>'width:120px'));
				// $CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($uom,'inactive'),'',array('style'=>'width:85px'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function build_item_type_form($type=null)
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/item_type_db",
		array('id'=>'item_type_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(5);
				$CI->make->hidden('id',iSetObj($type,'id'));
				$CI->make->input('Item Type name','type_name',iSetObj($type,'type_name'),'Item Type',array('class'=>'rOkay','maxchars'=>'20'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function build_items_display($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' New Inventory Item',base_url().'inventory/items_maintenance/new',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								'Name' => array('width'=>'20%'),
								'Item Code' => array('width'=>'12%'),
								'Barcode' => array('width'=>'12%'),
								'Brand' => array(),
								'Category' => array(),
								'Item Type' => array(),
								' ' => array('width'=>'10%')
								);
							$rows = array();
							foreach ($list as $val) {
								// $link = "";
								$link = $CI->make->A(
									fa('fa-pencil fa-lg fa-fw'),
									base_url().'inventory/items_maintenance/'.$val->id,
									array('return'=>'true',
										'title'=>'Edit '.$val->name)
								);
								$rows[] = array(
									$val->name,
									$val->item_code,
									$val->barcode,
									$val->brand_name,
									$val->category_name,
									$val->item_type_name,
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
function build_item_container($id)
{
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->hidden('idx',$id);
		$CI->make->sDivCol();
			$CI->make->sTab();
				$tabs = array(
					fa('fa-info-circle')." Inventory Item Details" => array(
																'href'=>'#details',
																'class'=>'tab_link',
																'load'=>'inventory/item_main_form',
																'id'=>'details_link'),
					fa('fa-tag')." Pricing Details"=>array('href'=>'#pricing','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/item_pricing_form/','id'=>'pricing_details_link'),
					);
				$CI->make->tabHead($tabs,null,array());
				$CI->make->sTabBody();
					$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
					$CI->make->eTabPane();
					$CI->make->sTabPane(array('id'=>'pricing','class'=>'tab-pane'));
					$CI->make->eTabPane();
				$CI->make->eTabBody();
			$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function build_item_main_form($item)
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/item_db",array('id'=>'item_main_form'));
		$CI->make->hidden('id',iSetObj($item,'id'));
		$CI->make->sDivRow(array('style'=>'margin:0px'));
			$CI->make->sDivCol(8);
				$CI->make->H(4,"Item Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->input('Item Name','name',iSetObj($item,'name'),'Item Name',
							array('maxchars'=>'50','class'=>'rOkay','style'=>'font-weight:bolder;'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(6);
						$CI->make->input('Item Code','item_code',iSetObj($item,'item_code'),'Item Code',
							array('class'=>'rOkay','maxchars'=>'20'));
						$CI->make->input('Brand Name','brand_name',iSetObj($item,'brand_name'),'',
							array('maxchars'=>'15'));
						$CI->make->input('Grade','grade',iSetObj($item,'grade'),'',
							array('maxchars'=>'15'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(6);
						$CI->make->input('Barcode','barcode',iSetObj($item,'barcode'),'',
							array('maxchars'=>'20'));
						$CI->make->textarea('Description','description',iSetObj($item,'description'),'',
							array('style'=>'resize:vertical;','maxchars'=>'255'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(6);
						$CI->make->stockCategoriesDrop('Category','category_id',iSetObj($item,'category_id'),'Select a category',array('class'=>'combobox'));
						$CI->make->stockUOMDrop('UOM','uom_id',iSetObj($item,'uom_id'),'Select a UOM',array('class'=>'combobox'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(6);
						$CI->make->stockTypeDrop('Item Type','item_type',iSetObj($item,'item_type'),'Select an item type',array('class'=>'combobox'));
						$CI->make->taxTypeDrop('Tax Type','item_tax_type',iSetObj($item,'item_tax_type'),'Select a tax type',array('class'=>'combobox'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->H(4,"General Ledger Accounts",array('style'=>'margin-top:0px;margin-bottom:0px'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->accountDrop('Sales Account','sales_account',iSetObj($item,'sales_account'),
							'Select Item Sales account',array('class'=>'combobox'));
						$CI->make->accountDrop('COGS Account','cogs_account',iSetObj($item,'cogs_account'),
							'Select COGS account',array('class'=>'combobox'));
						$CI->make->accountDrop('Inventory Account','inventory_account',iSetObj($item,'inventory_account'),
							'Select Inventory account',array('class'=>'combobox'));
						$CI->make->accountDrop('Adjustment Account','adjustment_account',iSetObj($item,'adjustment_account'),
							'Select Adjustment account',array('class'=>'combobox'));
						$CI->make->accountDrop('Assembly Cost Account','assembly_cost_account',iSetObj($item,'assembly_cost_account'),
							'Select Assembly Cost account',array('class'=>'combobox'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();
	$CI->make->sDivRow(array('style'=>'margin:10px;'));
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-save').' Save item details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-reply').' Return to inventory items',array('id'=>'back-btn','class'=>'btn-block'),'default');
		$CI->make->eDivCol();
    $CI->make->eDivRow();

	return $CI->make->code();
}
function build_item_pricing_form($item)
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/item_pricing_db",array('id'=>'item_pricing_form'));
		$CI->make->hidden('id',iSetObj($item,'id'));
		$CI->make->sDivRow(array('style'=>'margin:0px'));
			$CI->make->sDivCol(8);
				$CI->make->H(4,"Pricing details for ".iSetObj($item,'brand_name'),array('style'=>'margin-top:0px;margin-bottom:0px'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');

				$CI->make->sDivRow();
					$CI->make->sDivCol(6);
							$CI->make->currencyAbbrevDrop('Currency Abbreviation','currency_abrev',iSetObj($item,'currency_abrev'),'',array('class'=>'combobox'));
							$CI->make->input('Standard Cost','standard_cost',(isset($item->standard_cost) ? $item->standard_cost : '0'),'',array('class'=>'rOkay numbers-only'));
							$CI->make->input('Sales Price','sales_price',(isset($item->sales_price) ? $item->sales_price : '0'),'',array('class'=>'rOkay numbers-only'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();
	$CI->make->sDivRow(array('style'=>'margin:10px;'));
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-save').' Save pricing details',array('id'=>'save-price-btn','class'=>'btn-block'),'primary');
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-reply').' Return to inventory items',array('id'=>'back-price-btn','class'=>'btn-block'),'default');
		$CI->make->eDivCol();
    $CI->make->eDivRow();

	return $CI->make->code();
}
// ======================================================================================= //
//          INQUIRIES
 // ======================================================================================= //
function build_item_movement_inquiry()
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("inventory/movement_inquiry_results",array('id'=>'item_movement_search_form'));
						$CI->make->sDivCol(3);
							// $CI->make->customersDrop('Customer','debtor_id','','Select a customer',array('class'=>'combobox rOkay'));
							$CI->make->itemListDrop('Item ','item_id',null,'Select Item',array('class'=>'combobox input_form'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3,'left',0,array('id'=>'cust-branch-div'));
							// $CI->make->customerBranchesDrop('Customer Branch','debtor_branch_id','','Select customer branch',array('class'=>''));
							$CI->make->inventoryLocationsDrop('From Location','loc_code',null, '', array('class'=>'rOkay'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Date range','daterange','','',array('class'=>'rOkay daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3,'left',0,array('style'=>'padding-top:2.3%;padding-bottom:2%;'));
							$CI->make->A(fa('fa-search').' Search for item movement','#',array('class'=>'btn btn-primary','id'=>'btn-search'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Item Movement",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
}

function build_so_display($list, $item_id, $loc_code, $date_from, $date_to)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Type'=>array('width'=>'20%'),
					'#' => array('width'=>'5%'),
					'Reference' => array('width'=>'11%'),
					'Date' => array('width'=>'11%'),
					'Detail' => array('width'=>'11%'),
					'Qty In' => array('width'=>'10%'),
					'Qty Out' => array('width'=>'10%'),
					'Qty On Hand' => array('width'=>'10%'),
					// 'BackOrder' => array('width'=>'11%'),
					);
				$rows = array();
				// $rows1 = array();
				$qoh_before = $qoh = $tot = $qty_in = $qty_out = $tot_qty_in = $tot_qty_out = $standard_cost = $sales_price = $tot_cost = $tot_cost1 = $backorder = $tot_backorder = $pending_qty = 0;
				$qoh_before = $CI->inventory_model->get_item_qoh_before($item_id, $loc_code, $date_from);
				$pending_qty = $CI->inventory_model->get_item_backorder_before($item_id, $loc_code, $date_from, $date_to);
				// echo "BackOrder: $backorder <br>";
				if($qoh_before->qoh != ''){
					$qohb = $qoh_before->qoh;
				}else{
					$qohb = 0;
				}

				if(!empty($pending_qty)){
					$backorder = $pending_qty->backorder;
				}else{
					$backorder = 0;
				}
				// $rows[] = array(
							// array('text'=>'Quantity on hand before '.$date_from,'params'=>array('colspan'=>'7') ) ,
							// $qohb,
							// '',
					// );
				$rows[] = array(
							'Qty on hand before '.$date_from,
							'',
							'',
							'',
							'',
							'',
							'',
							$qohb,
							// '',
					);
				$tot = $qoh_before->qoh;
				foreach ($list as $val) {
					$link = $link2 = "";
					// $link .= $CI->make->A(fa('fa-pencil fa-2x fa-fw'),base_url().'purchasing/supplier_setup/'.$val->supplier_id,array('return'=>'true','title'=>'Edit "'.$val->supp_name.'"')); //orig
					//---base_url().'inventory/view_inventory_adjustment/
					/*
					$this->make->A($img,'branches/branch_menu_item_form/'.$res->branch_id."/".$res->item_id."/".$res->menu_item_id,array(
                                            'class'=>'add-item pull-left',
                                            'rata-title'=>'Update Item '.$res->item_code." ".$res->item_name,
                                            'rata-pass'=>'branches/branch_menu_item_db',
                                            'rata-form'=>'menu_item_form',
                                            'ref'=>$res->item_id,
                                            'id'=>'add-item-'.$res->menu_item_id
                                        ));
					*/
					$link .= $CI->make->A($val->type_no,'inventory/view_inventory_adjustment/'.$val->counter.'/'.$val->trans_type.'/'.$val->type_no.'/'.$val->reference,array(
                                            'class'=>'trx_no',
                                            'rata-title'=>'View Item Movement #'.$val->counter,
                                            'rata-pass'=>'inventory/view_inventory_adjustment',
                                            // 'rata-form'=>'inv_adjustment_form',
                                            'ref'=>$val->counter,
                                            'id'=>'view-item-'.$val->counter,
											'return'=>'false'
                                        ));
					$link2 .= $CI->make->A($val->reference,'inventory/view_inventory_adjustment/'.$val->counter.'/'.$val->trans_type.'/'.$val->type_no.'/'.$val->reference,array(
                                            'class'=>'trx_no',
                                            'rata-title'=>'View Item Movement #'.$val->counter,
                                            'rata-pass'=>'inventory/view_inventory_adjustment',
                                            // 'rata-form'=>'inv_adjustment_form',
                                            'ref'=>$val->counter,
                                            'id'=>'view-item-'.$val->counter,
											'return'=>'false'
                                        ));
					$standard_cost = $val->standard_cost;
					$sales_price = $val->sales_price;
					// $qoh = $CI->inventory_model->get_item_qoh($item_id, $loc_code, $date_from, $date_to);
					$qoh = $CI->inventory_model->get_item_qoh($item_id, $loc_code);
					$tot += $val->qty;
					if($val->qty > 0){
						$qty_in = $val->qty;
						$tot_qty_in += $val->qty;
					}
					if($val->qty < 0){
						$qty_out = $val->qty;
						$tot_qty_out += $val->qty;
					}

					if($backorder > 0)
						$tot_backorder += $backorder;
					else
						$tot_backorder = 0;

					$tot_cost = $standard_cost*$tot;

					$rows[] = array(
							$val->trans_type_name ,
							$link,
							// array('text'=>$val->type_no, 'params'=>array("title"=>"Trx #".$val->type_no." for ".$val->trans_type_name." ", "style"=>"cursor:pointer")),//old
							$link2,
							$val->trans_date,
							'',
							($val->qty > 0 ? $qty_in : ''),
							($val->qty < 0 ? $qty_out : ''),
							$tot,
							// ''
					);
					// echo "err: ".$tot."=".$val->qty."+".$qohb."<br>";
				}
				// $rows[] = array(
						// array('text'=>'Quantity on hand after '.$date_to,'params'=>array('colspan'=>'5', 'style'=>'font-weight') ) ,
						// $tot_qty_in,
						// $tot_qty_out,
						// $tot,
						// '',
				// );
				$tot_cost1 = $standard_cost*$tot;
				$rows[] = array(
							'Qty on hand after '.$date_to,
							'',
							'',
							'',
							'',
							$tot_qty_in,
							$tot_qty_out,
							$tot,
							// ''
					);

				$rows[] = array(
							array('text'=>'Total Back Order as of '.$date_to, "params"=>array("style"=>"background-color: ".($backorder > 0 ? '#f9edbe' : '#cae8c6')."")),
							array('text'=>'', "params"=>array("style"=>"background-color: ".($backorder > 0 ? '#f9edbe' : '#cae8c6')."")),
							array('text'=>'', "params"=>array("style"=>"background-color: ".($backorder > 0 ? '#f9edbe' : '#cae8c6')."")),
							array('text'=>'', "params"=>array("style"=>"background-color: ".($backorder > 0 ? '#f9edbe' : '#cae8c6')."")),
							array('text'=>'', "params"=>array("style"=>"background-color: ".($backorder > 0 ? '#f9edbe' : '#cae8c6')."")),
							array('text'=>'', "params"=>array("style"=>"background-color: ".($backorder > 0 ? '#f9edbe' : '#cae8c6')."")),
							array('text'=>'', "params"=>array("style"=>"background-color: ".($backorder > 0 ? '#f9edbe' : '#cae8c6')."")),
							// ''
							array('text'=>(int)$backorder, "params"=>array("style"=>"color: ".($backorder > 0 ? 'red' : 'green')."; background-color: ".($backorder > 0 ? '#f9edbe' : '#cae8c6')."")),
					);
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}
//-----------INVENTORY LOCATIONS-----APM-----START
function inventoryLocationsForm($inv_locations=null){
	$CI =& get_instance();

	$CI->make->sForm("core/inventory/inventory_locations_db",array('id'=>'inventory_locations_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
				$CI->make->hidden('location_id',iSetObj($inv_locations,'location_id'));
				$CI->make->input('Location Code','loc_code',iSetObj($inv_locations,'loc_code'),'Location Code',array('class'=>'rOkay'));
				$CI->make->input('Location Name','location_name',iSetObj($inv_locations,'location_name'),'location_name',array()); //orig
				$CI->make->input('Contact Person','contact_person',iSetObj($inv_locations,'contact_person'),'Contact Person',array());
				$CI->make->textarea('Address','address',iSetObj($inv_locations,'address'),'Type Address',array('class'=>'rOkay'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
				$CI->make->input('Phone','phone',iSetObj($inv_locations,'phone'),'Type Phone Number',array());
				$CI->make->input('Fax Number','fax',iSetObj($inv_locations,'fax'),'Type Fax Number',array());
				$CI->make->input('Email Address','email',iSetObj($inv_locations,'email'),'Type Email Address',array());
				// $CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($inv_locations,'inactive'),'',array());
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
//-----------INVENTORY LOCATIONS-----APM-----END
//-----------INVENTORY ADJUSTMENTS-----APM-----START
///----------ORIGINAL FORM---------START
function inventoryAdjustmentFormLoad($trx_id='', $type_no='', $reference=''){
	$CI =& get_instance();
		$CI->make->sForm("inventory/inventory_adjustment_db",array('id'=>'inventory_adjustment_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-invadjustment'),'primary');
					// $CI->make->button(fa('fa-reply').' Clear Details',array('id'=>'clear-invadjustment','class'=>'btn-block'),'default');
				$CI->make->eDivCol();
			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					// $CI->make->itemListDrop('Item ','item_id',null,'Select Item',array('class'=>'combobox input_form'));
					$CI->make->inventoryLocationsDrop('Deliver from Location','from_loc','', '', array('class'=>'rOkay'));
					$CI->make->input('Reference','reference',$reference,'Type Reference',array('class'=>''));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					// $CI->make->salesTypesDrop('Price List','sales_type',iSetObj($so,'sales_type'), '', array('class'=>'rOkay'));
					// $CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
					$CI->make->datefield('Date','trans_date',date('m/d/Y'),'',array());
					$CI->make->itemMovementTypeDrop('Movement Type','movement_type','', '', array('class'=>'rOkay'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
					// $CI->make->datefield('Order Date','order_date',(iSetObj($so,'order_date') ? sql2Date(iSetObj($so,'order_date')) : date('m/d/Y')),'',array());
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();


			$CI->make->hidden('item-id',null, array('class'=>'input_form'));
			$CI->make->hidden('item-uom',null, array('class'=>'input_form'));
			$CI->make->hidden('item-price',null, array('class'=>'input_form'));
			$CI->make->hidden('item-location',null, array('class'=>'input_form'));

			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sBox('success');
					$CI->make->sBoxHead();
						$CI->make->boxTitle('Adjustment Details');
					$CI->make->eBoxHead();
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->itemListDrop('Item ','item_id',null,'Select Item',array('class'=>'combobox input_form'));
								$CI->make->input('Quantity','qty_delivered',null,null,array('class'=>'rOkay input_form'));
								$CI->make->select('Unit','select-uom',array(),null,array('class'=>'rOkay input_form','id'=>'select-uom'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->input('Price','unit_price','0.00',null,array('class'=>'rOkay numbers-only input_form'));
								$CI->make->input('Quantity on Hand','qoh','0',null,array('class'=>'rOkay input_form', 'disabled'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
///----------ORIGINAL FORM---------END
///----------REVISED FORM---------START
function inventoryAdjustmentHeaderPage($trx_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right');
				if($trx_id != null)
					$CI->make->A(fa('fa-reply').' Go Back',base_url().'inventory/item_movement_inquiry',array('class'=>'btn btn-primary'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Header Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'inventory/adjustment_details_load/','id'=>'details_link'),
						// fa('fa-book')." Items"=>array('href'=>'#recipe','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'purchasing/items_load/','id'=>'recipe_link'),
						fa('fa-book')." Items"=>array('href'=>'#adj_items','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/adjustment_items_load/','id'=>'adj_items_link'),
					);
					$CI->make->hidden('trx_id',$trx_id);
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
function iaHeaderDetailsLoad($ia=null, $type_no='', $reference=''){
	$CI =& get_instance();
		$CI->make->sForm("inventory/inv_adjustment_header_details_db",array('id'=>'inv_adj_header_details_form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-iaheader'),'primary');
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
///----------REVISED FORM---------END
///---------- FORM---------END
function viewInventoryAdjustmentForm($trx_details=null,$header=null){
	$CI =& get_instance();
		$CI->make->sForm('',array('id'=>'inv_adjustment_form'));
			// $CI->make->sDivRow();
				// $CI->make->sDivCol(12,'right');
					// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-invadjustment'),'primary');
					// // $CI->make->button(fa('fa-reply').' Clear Details',array('id'=>'clear-invadjustment','class'=>'btn-block'),'default');
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDivCol(3);
					$CI->make->inventoryLocationsDrop('Deliver from Location ','from_loc',iSetObj($header,'loc_code'), '', array('class'=>'rOkay', 'readonly'=>'readonly'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->input('Reference','reference',iSetObj($header,'reference'),'Type Reference',array('class'=>'', 'readonly'=>'readonly'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->datefield('Date','trans_date',iSetObj($header,'trans_date'),'',array('readonly'=>'readonly'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->itemMovementTypeDrop('Movement Type','movement_type',iSetObj($header,'movement_type'), '', array('class'=>'rOkay', 'readonly'=>'readonly'));
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();


			$CI->make->hidden('item-id',null, array('class'=>'input_form'));
			$CI->make->hidden('item-uom',null, array('class'=>'input_form'));
			$CI->make->hidden('item-price',null, array('class'=>'input_form'));
			$CI->make->hidden('item-location',null, array('class'=>'input_form'));

			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sBox('success');
					$CI->make->sBoxHead();
						$CI->make->boxTitle('Movement Details');
					$CI->make->eBoxHead();

					// $CI->make->sBoxBody();
						// $CI->make->sDivRow();
							// $CI->make->sDivCol(6);
								// $CI->make->itemListDrop('Item ','item_id',null,'Select Item',array('class'=>'combobox input_form'));
								// $CI->make->input('Quantity','qty_delivered',null,null,array('class'=>'rOkay input_form'));
								// $CI->make->select('Unit','select-uom',array(),null,array('class'=>'rOkay input_form','id'=>'select-uom'));
							// $CI->make->eDivCol();
							// $CI->make->sDivCol(6);
								// $CI->make->input('Price','unit_price','0.00',null,array('class'=>'rOkay numbers-only input_form'));
								// $CI->make->input('Quantity on Hand','qoh','0',null,array('class'=>'rOkay input_form', 'disabled'=>''));
							// $CI->make->eDivCol();
						// $CI->make->eDivRow();
					// $CI->make->eBoxBody();

					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
							if($header->trans_type != 15){
								$th = array(
									'Name'=>array('width'=>'20%'),
									'Trans Date' => array('width'=>'20%'),
									'Location' => array('width'=>'20%'),
									'Created By' => array('width'=>'20%'),
									'Qty' => array('width'=>'20%')
									);
								$rows = array();
								foreach ($trx_details as $val) {
								$item_details = $CI->inventory_model->get_inventory_item($val->item_id);
								$name = $item_details[0]->name;
									$rows[] = array(
											$name ,
											$val->trans_date,
											$val->loc_code,
											$CI->inventory_model->created_by($val->person_id),
											$val->qty
									);
									// echo "err: ".$tot."=".$val->qty."+".$qohb."<br>";
								}
							}else{
								$th = array(
									'Name'=>array('width'=>'20%'),
									'Trans Date' => array('width'=>'20%'),
									'Location' => array('width'=>'20%'),
									'Created By' => array('width'=>'20%'),
									'Qty' => array('width'=>'20%'),
									'Qty Ordered' => array('width'=>'20%'),
									);
								$rows = array();
								foreach ($trx_details as $val) {
								$item_details = $CI->inventory_model->get_inventory_item($val->item_id);
								$name = $item_details[0]->name;
									$rows[] = array(
											$name ,
											$val->trans_date,
											$val->loc_code,
											$CI->inventory_model->created_by($val->person_id),
											$val->qty,
											$val->quantity_ordered,
									);
									// echo "err: ".$tot."=".$val->qty."+".$qohb."<br>";
								}
							}
								$CI->make->listLayout($th,$rows);
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();

				$CI->make->eBox();
			$CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}
//-----------INVENTORY ADJUSTMENTS-----APM-----END
function viewHardwareMovementBox($details){
	$CI =& get_instance();
		if (!$details) {
			$CI->make->H(4,'Unable to load hardware movement information');
			return $CI->make->code();
		}

		$details = $details[0];

		$CI->make->sDivRow();
			$CI->make->sDivCol(3);
				$CI->make->input('Transaction type','trans_type',iSetObj($details,'trans_name'),'',array('class'=>'', 'readonly'=>'readonly'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->input('Reference','reference',iSetObj($details,'reference'),'Type Reference',array('class'=>'', 'readonly'=>'readonly'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();

		$CI->make->sDivRow();
			$CI->make->sDivCol(3);
				$CI->make->input('Processed by','person_id',
					ucwords($details->fname.' '.$details->lname),'Type Reference',array('class'=>'', 'readonly'=>'readonly'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->inventoryLocationsDrop('Location ','from_loc',iSetObj($details,'loc_code'), '', array('class'=>'rOkay', 'readonly'=>'readonly'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->datefield('Date','trans_date',iSetObj($details,'trans_date'),'',array('readonly'=>'readonly'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->itemMovementTypeDrop('Movement Type','movement_type',iSetObj($details,'movement_type'), '', array('class'=>'rOkay', 'readonly'=>'readonly'));
			$CI->make->eDivCol();
    	$CI->make->eDivRow();

    	$CI->make->sDivRow();
    		$CI->make->sDivCol();
    		$th = array(
    			'Qty'      => array('width' => '10%'),
    			'Date'     => array('width' => '8%'),
    			'Customer' => array('width' => '15%'),
    			'Branch'   => array('width' => '18%'),
    			'Shipping Amount' => array('width' => '10%'),
    			'Total Transaction Amount' => array('width' => '12%')
    			);
    		if ($details->qty > 0) {
	    		$rows[] = array(
	    			array(
	    				'text'   => '<span style="color:green;font-weight:bold;">'.fa('fa fa-plus').num($details->qty).'</span>',
	    				'params' => array('style'=>'text-align:right;background-color:#CBE8C6;')
	    				),
	    			array(
	    				'text'   => iSetObj($details,'dtrx_date',$details->trans_date),
	    				'params' => array('style'=>'background-color:#CBE8C6;')
	    				),
	    			array(
	    				'text'   => iSetObj($details,'debtor_name','-'),
	    				'params' => array('style'=>'background-color:#CBE8C6;')
	    				),
	    			array(
	    				'text'   => iSetObj($details,'branch_name','-'),
	    				'params' => array('style'=>'background-color:#CBE8C6;')
	    				),
	    			array(
	    				'text'    => $details->t_shipping_cost ? num($details->t_shipping_cost) : '-',
	    				'params' => array('style'=>'text-align:right;background-color:#CBE8C6;')
	    				),
	    			array(
	    				'text'    => $details->t_amount ? num($details->t_amount) : '-',
	    				'params' => array('style'=>'text-align:right;background-color:#CBE8C6;')
	    				),
	    			);
    		}
			else {
				$rows[] = array(
	    			array(
	    				'text'   => '<span style="color:red;font-weight:bold;">'.fa('fa fa-minus').num($details->qty).'</span>',
	    				'params' => array('style'=>'text-align:right;background-color:#FCD7D9;')
	    				),
	    			array(
	    				'text'   => iSetObj($details,'dtrx_date',$details->trans_date),
	    				'params' => array('style'=>'background-color:#FCD7D9;')
	    				),
	    			array(
	    				'text'   => iSetObj($details,'debtor_name','-'),
	    				'params' => array('style'=>'background-color:#FCD7D9;')
	    				),
	    			array(
	    				'text'   => iSetObj($details,'branch_name','-'),
	    				'params' => array('style'=>'background-color:#FCD7D9;')
	    				),
	    			array(
	    				'text'    => $details->t_shipping_cost ? num($details->t_shipping_cost) : '-',
	    				'params' => array('style'=>'text-align:right;background-color:#FCD7D9;')
	    				),
	    			array(
	    				'text'    => $details->t_amount ? num($details->t_amount) : '-',
	    				'params' => array('style'=>'text-align:right;background-color:#FCD7D9;')
	    				),
	    			);
			}
    		$CI->make->listLayout($th,$rows);
    		$CI->make->eDivCol();
    	$CI->make->eDivRow();


		// $CI->make->sDivRow(array('style'=>'margin:10px;'));
		// 	$CI->make->sBox('success');
		// 		$CI->make->sBoxHead();
		// 			$CI->make->boxTitle('Movement Details');
		// 		$CI->make->eBoxHead();

		// 		// $CI->make->eBoxBody();

		// 		$CI->make->sBoxBody();
		// 			$CI->make->sDivRow();
		// 				$CI->make->sDivCol();
		// 				if($header->trans_type != 15){
		// 					$th = array(
		// 						'Name'=>array('width'=>'20%'),
		// 						'Trans Date' => array('width'=>'20%'),
		// 						'Location' => array('width'=>'20%'),
		// 						'Created By' => array('width'=>'20%'),
		// 						'Qty' => array('width'=>'20%')
		// 						);
		// 					$rows = array();
		// 					foreach ($trx_details as $val) {
		// 					$item_details = $CI->inventory_model->get_inventory_item($val->item_id);
		// 					$name = $item_details[0]->name;
		// 						$rows[] = array(
		// 								$name ,
		// 								$val->trans_date,
		// 								$val->loc_code,
		// 								$CI->inventory_model->created_by($val->person_id),
		// 								$val->qty
		// 						);
		// 						// echo "err: ".$tot."=".$val->qty."+".$qohb."<br>";
		// 					}
		// 				}else{
		// 					$th = array(
		// 						'Name'=>array('width'=>'20%'),
		// 						'Trans Date' => array('width'=>'20%'),
		// 						'Location' => array('width'=>'20%'),
		// 						'Created By' => array('width'=>'20%'),
		// 						'Qty' => array('width'=>'20%'),
		// 						'Qty Ordered' => array('width'=>'20%'),
		// 						);
		// 					$rows = array();
		// 					foreach ($trx_details as $val) {
		// 					$item_details = $CI->inventory_model->get_inventory_item($val->item_id);
		// 					$name = $item_details[0]->name;
		// 						$rows[] = array(
		// 								$name ,
		// 								$val->trans_date,
		// 								$val->loc_code,
		// 								$CI->inventory_model->created_by($val->person_id),
		// 								$val->qty,
		// 								$val->quantity_ordered,
		// 						);
		// 						// echo "err: ".$tot."=".$val->qty."+".$qohb."<br>";
		// 					}
		// 				}
		// 					$CI->make->listLayout($th,$rows);
		// 				$CI->make->eDivCol();
		// 			$CI->make->eDivRow();
		// 		$CI->make->eBoxBody();

		// 	$CI->make->eBox();
		// $CI->make->eDivRow();

	return $CI->make->code();
}

////////////////////////////JEd////////////////////
function build_hware_movement_inquiry()
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("inventory/hware_inquiry_results",array('id'=>'hware_movement_search_form'));
						$CI->make->sDivCol(3);
							// $CI->make->customersDrop('Customer','debtor_id','','Select a customer',array('class'=>'combobox rOkay'));
							$CI->make->hardwareListDrop('Hardware ','item_id',null,'Select Item',array('class'=>'combobox input_form'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3,'left',0,array('id'=>'cust-branch-div'));
							// $CI->make->customerBranchesDrop('Customer Branch','debtor_branch_id','','Select customer branch',array('class'=>''));
							$CI->make->inventoryLocationsDrop('From Location','loc_code',null, '', array('class'=>'rOkay'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Date range','daterange','','',array('class'=>'rOkay daterangepicker','style'=>'position:initial;'),null,fa('fa-calendar'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3,'left',0,array('style'=>'padding-top:2.3%;padding-bottom:2%;'));
							$CI->make->A(fa('fa-search').' Search for hardware movement','#',array('class'=>'btn btn-primary','id'=>'btn-search'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters for Hardware Movement",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function build_hw_display($list, $item_id, $loc_code, $date_from, $date_to)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Type'=>array('width'=>'20%'),
					'#' => array('width'=>'5%'),
					'Reference' => array('width'=>'11%'),
					'Date' => array('width'=>'11%'),
					'Detail' => array('width'=>'11%'),
					'Qty In' => array('width'=>'10%'),
					'Qty Out' => array('width'=>'10%'),
					'Qty On Hand' => array('width'=>'10%'),
					// 'BackOrder' => array('width'=>'11%'),
					);
				$rows = array();
				// $rows1 = array();
				$qoh_before = $qoh = $tot = $qty_in = $qty_out = $tot_qty_in = $tot_qty_out = $standard_cost = $sales_price = $tot_cost = $tot_cost1 = $backorder = $tot_backorder = $pending_qty = 0;
				$qoh_before = $CI->inventory_model->get_hardware_item_qoh_before($item_id, $loc_code, $date_from);

				if($qoh_before->qoh != ''){
					$qohb = $qoh_before->qoh;
				}else{
					$qohb = 0;
				}

				if(!empty($pending_qty)){
					$backorder = $pending_qty->backorder;
				}else{
					$backorder = 0;
				}
				$rows[] = array(
							'Qty on hand before '.$date_from,
							'',
							'',
							'',
							'',
							'',
							'',
							$qohb,
							// '',
					);
				foreach ($list as $val) {
					$link = $link2 = "";
					$link .= $CI->make->A($val->type_no,'inventory/view_hardware_adjustment/'.$val->counter,array(
                                            'class'=>'trx_no',
                                            'rata-title'=>'Hardware Item Movement # '.$val->reference,
                                            'rata-pass'=>'inventory/view_hardware_adjustment',
                                            'ref'=>$val->counter,
                                            'id'=>'view-item-'.$val->counter,
											'return'=>'false'
                                        ));
					$link2 .= $CI->make->A($val->reference,'inventory/view_hardware_adjustment/'.$val->counter,array(
                                            'class'=>'trx_no',
                                            'rata-title'=>'Hardware Item Movement #'.$val->reference,
                                            'rata-pass'=>'inventory/view_hardware_adjustment',
                                            'ref'=>$val->counter,
                                            'id'=>'view-item-'.$val->counter,
											'return'=>'false'
                                        ));
					$qoh = $CI->inventory_model->get_item_qoh($item_id, $loc_code);
					$tot += $val->qty+$qohb;
					if($val->qty > 0){
						$qty_in = $val->qty;
						$tot_qty_in += $val->qty;
					}
					if($val->qty < 0){
						$qty_out = $val->qty;
						$tot_qty_out += $val->qty;
					}

					if($backorder > 0)
						$tot_backorder += $backorder;
					else
						$tot_backorder = 0;

					$tot_cost = $standard_cost*$tot;

					$rows[] = array(
							$val->trans_type_name ,
							$link,
							$link2,
							$val->trans_date,
							'',
							($val->qty > 0 ? $qty_in : ''),
							($val->qty < 0 ? $qty_out : ''),
							$tot,
					);
				}
				$tot_cost1 = $standard_cost*$tot;
				$rows[] = array(
							'Qty on hand after '.$date_to,
							'',
							'',
							'',
							'',
							$tot_qty_in,
							$tot_qty_out,
							$tot,
					);
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}
function MultipleAdjPage($type_no='', $reference=''){
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right');
					$CI->make->button(fa('fa-save').' Save All Adjustments',array('id'=>'save-alladj'),'primary');
					// $CI->make->button(fa('fa-reply').' Clear Details',array('id'=>'clear-invadjustment','class'=>'btn-block'),'default');
				$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sTab();
					$tabs = array(
						fa('fa-info-circle')." Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'inventory/multiple_adj_details/','id'=>'details_link'),
						fa('fa-book')." Adjustment Items"=>array('href'=>'#recipe','class'=>'load-tab','load'=>'inventory/multiAdj_items_load/','id'=>'recipe_link'),
					);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
							$CI->make->sForm("inventory/multiple_adjustment_db",array('id'=>'multiple_adjustment_form'));
								// $CI->make->sDivRow();
								// 	$CI->make->sDivCol(12,'right');
								// 		$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-invadjustment'),'primary');
								// 		// $CI->make->button(fa('fa-reply').' Clear Details',array('id'=>'clear-invadjustment','class'=>'btn-block'),'default');
								// 	$CI->make->eDivCol();
								// $CI->make->eDivRow();

								$CI->make->sDivRow(array('style'=>'margin:10px;'));
									$CI->make->sBox('info');
										$CI->make->sBoxBody();
											$CI->make->sDivRow();
												$CI->make->sDivCol(4);
													// $CI->make->itemListDrop('Item ','item_id',null,'Select Item',array('class'=>'combobox input_form'));
													$CI->make->inventoryLocationsDrop('Deliver from Location','from_loc','', '', array('class'=>'rOkay'));
													$CI->make->input('Reference','reference',$reference,'Type Reference',array('class'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(4);
													// $CI->make->salesTypesDrop('Price List','sales_type',iSetObj($so,'sales_type'), '', array('class'=>'rOkay'));
													// $CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
													$CI->make->datefield('Date','trans_date',date('m/d/Y'),'',array());
													$CI->make->itemMovementTypeDrop('Movement Type','movement_type','', '', array('class'=>'rOkay'));
												$CI->make->eDivCol();
												$CI->make->sDivCol(4);
													// $CI->make->datefield('Order Date','order_date',(iSetObj($so,'order_date') ? sql2Date(iSetObj($so,'order_date')) : date('m/d/Y')),'',array());
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eBoxBody();
									$CI->make->eBox();
						    	$CI->make->eDivRow();
							$CI->make->eForm();
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'recipe','class'=>'tab-pane'));
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function multipleAdjFormLoad($type_no='', $reference=''){
	$CI =& get_instance();
		$CI->make->sForm("inventory/multiple_adjustment_db",array('id'=>'multiple_adjustment_form'));
			// $CI->make->sDivRow();
			// 	$CI->make->sDivCol(12,'right');
			// 		$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-invadjustment'),'primary');
			// 		// $CI->make->button(fa('fa-reply').' Clear Details',array('id'=>'clear-invadjustment','class'=>'btn-block'),'default');
			// 	$CI->make->eDivCol();
			// $CI->make->eDivRow();

			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sBox('info');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								// $CI->make->itemListDrop('Item ','item_id',null,'Select Item',array('class'=>'combobox input_form'));
								$CI->make->inventoryLocationsDrop('Deliver from Location','from_loc','', '', array('class'=>'rOkay'));
								$CI->make->input('Reference','reference',$reference,'Type Reference',array('class'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								// $CI->make->salesTypesDrop('Price List','sales_type',iSetObj($so,'sales_type'), '', array('class'=>'rOkay'));
								// $CI->make->input('Customer Discount','cust_discount','0 %','',array('style'=>'width: 30%;', 'disabled'=>''));
								$CI->make->datefield('Date','trans_date',date('m/d/Y'),'',array());
								$CI->make->itemMovementTypeDrop('Movement Type','movement_type','', '', array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								// $CI->make->datefield('Order Date','order_date',(iSetObj($so,'order_date') ? sql2Date(iSetObj($so,'order_date')) : date('m/d/Y')),'',array());
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
	    	$CI->make->eDivRow();
		$CI->make->eForm();

	return $CI->make->code();
}
function adjItemsLoad($adj_session=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol(3);
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sForm("inventory/add_adj_session",array('id'=>'add_adj_form'));
						$CI->make->itemListDrop('Item ','item_id',null,'Select Item',array('class'=>'combobox input_form rOkay'));
						$CI->make->hidden('item-id',null, array('class'=>'input_form'));
						$CI->make->hidden('item-uom',null, array('class'=>'input_form'));
						$CI->make->hidden('item-price',null, array('class'=>'input_form'));
						$CI->make->hidden('item-location',null, array('class'=>'input_form'));
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
								$CI->make->input('Price','unit_price','0.00',null,array('class'=>'rOkay numbers-only input_form'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->input('QoH','qoh','0',null,array('class'=>'rOkay input_form', 'disabled'=>''));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						// $CI->make->locationsDrop('Receiving Location','loc_id',null,null,array('shownames'=>true));
						$CI->make->button(fa('fa-plus').' Add Adjustment',array('class'=>'btn-block','id'=>'add-adj-btn'),'primary');
					$CI->make->eForm();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		#FORM
		$CI->make->sDivCol(9);
			$CI->make->sDivRow(array('id'=>'load-table-items'));
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
											$CI->make->th('Quantity',array('style'=>'text-align:center;'));
											$CI->make->th('Unit',array('style'=>'text-align:center;'));
											$CI->make->th('Price',array('style'=>'text-align:center;'));
											$CI->make->th('',array('style'=>'text-align:center;'));
										$CI->make->eRow();

										if($adj_session == null){
											$CI->make->sRow();
											$CI->make->th('<br>No Items for Adjustment Found.<br>',array('colspan'=>'12','style'=>'text-align:center;'));
											$CI->make->eRow();
										}else{

											foreach($adj_session as $key => $val){
												$CI->make->sRow();
													$where = array('id'=>$val['item_id']);
				                                    $item_name = $CI->inventory_model->get_details($where,'stock_master');
				                                    if($item_name)
				                                     	$CI->make->td('['.$item_name[0]->item_code.'] '.$item_name[0]->name);
				                                    else
				                                     	$CI->make->td('');

													$CI->make->th(num($val['qty']),array('style'=>'text-align:center;'));
													$CI->make->th($val['uom'],array('style'=>'text-align:center;'));
													$CI->make->th(num($val['price']),array('style'=>'text-align:center;'));

													$button = $CI->make->A(fa('fa-trash'),'#',array("class"=>'del-item','ref'=>$key,'return'=>true));
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

			$CI->make->eDivRow();
		$CI->make->eDivCol();


	$CI->make->eDivRow();

	return $CI->make->code();
}
//-----Maintenance: UOM-----start
//------UOM Listing Maker
function uomListPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New UOM',base_url().'inventory/manage_uoms',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Unit Code' => array('width'=>'20%'),
									'Description' => array('width'=>'40%'),
									'Quantity' => array('width'=>'10%'),
									'Is Inactive' => array('width'=>'20%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'inventory/manage_uoms/'.$val->id,array("return"=>true));
								$rows[] = array(
											  $val->unit_code,
											  $val->description,
											  $val->qty,
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
function manage_uom_form($item=null){
    $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'inventory/uoms',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
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

							$CI->make->sForm("inventory/uom_details_db",array('id'=>'uom_details_form'));
								$CI->make->hidden('id',iSetObj($item,'id'));
								$CI->make->hidden('mode',((iSetObj($item,'unit_code')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									//-----1st Col
									$CI->make->sDivCol(3);
									$CI->make->input('Unit Code','unit_code',iSetObj($item,'unit_code'),null,array('class'=>'rOkay toUpper'));
									$CI->make->eDivCol();

									//-----2nd Col
									$CI->make->sDivCol(3);
									$CI->make->input('Description','description',iSetObj($item,'description'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									
									//-----3rd Col
									$CI->make->sDivCol(3);
									$CI->make->input('Quantity','qty',iSetObj($item,'qty'),null,array('class'=>'rOkay reqForm reqForm'));
									$CI->make->eDivCol();
									
									//-----3rd Col
									$CI->make->sDivCol(3);
									$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'reqForm'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();

								$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
									$CI->make->sDivCol(4);
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(4, 'right');
										$CI->make->button(fa('fa-save').' Save UOM Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
										$CI->make->button(fa('fa-save').' Show Confirm Box',array('class'=>'del-btn btn btn-block'),''); //-----UNCOMMENT TO SHOW SAMPLE OF CONFIRMBOX
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

function confirm_a_form($unit_code=null){
	 $CI =& get_instance();
	
	$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
		$CI->make->sDivCol(12);
			$CI->make->span('Has content? -> '.$unit_code);
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	return $CI->make->code();
}
//-----Maintenance: UOM-----end


//<-------- Start Stock Category Maintenance ----------->//

//<------Start Stock category Page List ------>//
function Stock_Category_Page($list=array()){
$CI =& get_instance();
$subcat_desc = "";
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Category',base_url().'inventory/manage_stock_category/',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Stock Category Name' => array('width'=>'40%'),
									'Short Description' => array('width'=>'20%'),
									'Sub Category' => array('width'=>'20%'),
									'Is Inactive' => array('width'=>'20%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
		
								$subcat_desc = $CI->inventory_model->subcat_name($val->subcat_id);
								
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'inventory/manage_stock_category/'.$val->id,array("return"=>true));
								$rows[] = array(
											  $val->description,
											  $val->short_desc,
											  $subcat_desc,
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
//<------Start Stock category Form ------>//
function manage_stock_category_form($item=''){
$CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'inventory/stock_category',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
				// $CI->make->hidden('asset_id',iSetObj($item,'asset_id'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
					$tabs = array(
						//fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link')
					);
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

							$CI->make->sForm("inventory/stock_category_details_db",array('id'=>'stock_category_form'));
								$CI->make->hidden('id',iSetObj($item,'id'));
								$CI->make->hidden('mode',((iSetObj($item,'id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									//-----1st Row
									$CI->make->sDivCol(4);
									$CI->make->input('Stock Category Name','description',iSetObj($item,'description'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();

									//-----2nd Row
									$CI->make->sDivCol(3);
										$CI->make->input('Short Description','short_desc',iSetObj($item,'short_desc'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();
									
									//-----3rd Row
									$CI->make->sDivCol(3);
									$CI->make->stock_categories_drop('Sub Catgory','subcat_id',iSetObj($item,'subcat_id'),'Select Sub Category',array('class'=>'reqForm'));
									$CI->make->eDivCol();
									
									//-----4rt Row
									$CI->make->sDivCol(2);
											$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'reqForm'));
										$CI->make->eDivCol();
									$CI->make->eDivRow();
									

									$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										$CI->make->sDivCol(4);
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4, 'right');
											$CI->make->button(fa('fa-save').' Save Stock Category',array('id'=>'save-btn','class'=>'btn-block'),'primary');
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
//<-------- End Stock Category Maintenance ------------>//

//------Stock Location ----START
function stockLocationsForm($stc_locations=null){
	 $CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'inventory/stock_locations',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
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

							$CI->make->sForm("inventory/stock_details_db",array('id'=>'stock_details_form'));
								$CI->make->hidden('id',iSetObj($stc_locations,'id'));
								$CI->make->hidden('mode',((iSetObj($stc_locations,'id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									//-----1st Row
									$CI->make->sDivCol(4);
										$CI->make->input('Location Code','loc_code',iSetObj($stc_locations,'loc_code'),null,array('class'=>'rOkay reqForm'));
										$CI->make->textarea('Address','address',iSetObj($stc_locations,'address'),'Type Address',array('class'=>'rOkay reqForm'));
										////----sample pre-made forms
									// $CI->make->textarea('Address','address','',null,array('class'=>''));
										// $CI->make->input('Email','email','',null,array('class'=>''));
										// $CI->make->input('GSTNo/TIN No.','tax_no','',null,array('class'=>''));
										// $CI->make->currenciesDrop("Customer's Currency",'currency','',null,array('class'=>''));
									$CI->make->eDivCol();

									//-----2nd Row
									$CI->make->sDivCol(4);
									$CI->make->input('Location Name','loc_name',iSetObj($stc_locations,'loc_name'),null,array('class'=>'rOkay reqForm'));
									$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($stc_locations,'inactive'),null,array('class'=>'reqForm'));
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
											$CI->make->button(fa('fa-save').' Save Stock Location Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
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
function stockLocationPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Stock Location',base_url().'inventory/manage_stock_locations',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Location Code' => array('width'=>'30%'),
									'Location Name' => array('width'=>'30%'),
									'Address' => array('width'=>'40%'),
									'Is Inactive' => array('width'=>'20%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'inventory/manage_stock_locations/'.$val->id,array("return"=>true));
								$rows[] = array(
											  $val->loc_code,
											  $val->loc_name,
											  $val->address,
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
//------Stock Location ----END

//-----STOCKS MASTER-----CSR-----START
function discounts_Page($list=array()){
$CI =& get_instance();
$subcat_desc = "";
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Discount',base_url().'inventory/manage_discount/',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Short Description' => array('width'=>'40%'),
									'Description' => array('width'=>'20%'),
									'Percentage' => array('width'=>'20%'),
									'amount' => array('width'=>'20%'),
									'Is Inactive' => array('width'=>'20%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
		
								$subcat_desc = $CI->inventory_model->subcat_name($val->subcat_id);
								
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'inventory/manage_stock_category/'.$val->id,array("return"=>true));
								$rows[] = array(
											  $val->description,
											  $val->short_desc,
											  $subcat_desc,
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
function manage_discount_form($item=''){
$CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'inventory/stock_category',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
				// $CI->make->hidden('asset_id',iSetObj($item,'asset_id'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
					$tabs = array(
						//fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link')
					);
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

							$CI->make->sForm("inventory/stock_category_details_db",array('id'=>'stock_category_form'));
								$CI->make->hidden('id',iSetObj($item,'id'));
								$CI->make->hidden('mode',((iSetObj($item,'id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									//-----1st Row
									$CI->make->sDivCol(4);
									$CI->make->input('Stock Category Name','description',iSetObj($item,'description'),null,array('class'=>'rOkay'));
									$CI->make->eDivCol();

									//-----2nd Row
									$CI->make->sDivCol(3);
										$CI->make->input('Short Description','short_desc',iSetObj($item,'short_desc'),null,array('class'=>'rOkay'));
									$CI->make->eDivCol();
									
									//-----3rd Row
									$CI->make->sDivCol(3);
									$CI->make->stock_categories_drop('Sub Catgory','subcat_id',iSetObj($item,'subcat_id'),'Select Sub Category',array('class'=>''));
									$CI->make->eDivCol();
									
									//-----4rt Row
									$CI->make->sDivCol(2);
											$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>''));
										$CI->make->eDivCol();
									$CI->make->eDivRow();
									

									$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
										$CI->make->sDivCol(4);
										$CI->make->eDivCol();
										
										$CI->make->sDivCol(4, 'right');
											$CI->make->button(fa('fa-save').' Save Stock Category',array('id'=>'save-btn','class'=>'btn-block'),'primary');
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
//-----STOCKS MASTER-----CSR-----END

//-----STOCKS MASTER-----APM-----START
//-----------Product Listing Maker-----start-----allyn
function stockPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Item',base_url().'inventory/manage_stock',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Stock Code' => array('width'=>'20%'),
									'Description' => array('width'=>'30%'),
									'Category' => array('width'=>'20%'),
									'Tax Type' => array('width'=>'10%'),
									'Is Inactive' => array('width'=>'10%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'inventory/manage_stock/'.$val->stock_id,array("return"=>true));
								$rows[] = array(
											  $val->stock_code,
											  $val->description,
											  $val->category,
											  $val->tax_type_id,
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
function build_stock_display($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' New Stock Item',base_url().'inventory/stock_master/new',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								'Stock Code' => array('width'=>'12%'),
								'Description' => array('width'=>'20%'),
								// 'Barcode' => array('width'=>'12%'),
								// 'Brand' => array(),
								'Category' => array(),
								'Tax Type' => array(),
								' ' => array('width'=>'10%')
								);
							$rows = array();
							
							foreach ($list as $val) {
								// $link = "";
								$new_desc = "";
								$link = $CI->make->A(
									fa('fa-pencil fa-lg fa-fw'),
									base_url().'inventory/stock_master/'.$val->stock_id,
									array('return'=>'true',
										'title'=>'Edit '.$val->description)
								);
								
								if(date('Y-m-d', strtotime($val->date_added)) <= date('Y-m-d', strtotime("+1 week"))){
									$new_desc .= $val->description." <span class='label label-success'>NEW ITEM</span>";
								}else{
									$new_desc .= $val->description;
								}
								
								$rows[] = array(
									$val->stock_code,
									array('text'=>$new_desc, 'params'=>array()),
									// $val->barcode,
									// $val->brand_name,
									$CI->inventory_model->category_short_desc($val->category_id),
									$CI->inventory_model->tax_type_id_to_name($val->tax_type_id),
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



//---> add stock
 
function add_build_stock_container($id)
{
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-top: -10px;'));
		$CI->make->hidden('idx',$id);
		$CI->make->sDivCol();
			$CI->make->sTab();
				$tabs = array(
					fa('fa-cubes')." General Details" => array(
																'href'=>'#details',
																'class'=>'tab_link',
																'load'=>'inventory/add_stock_main_form',
																'id'=>'details_link'),
					// fa('fa-tag')." Pricing Details"=>array('href'=>'#pricing','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/item_pricing_form/','id'=>'pricing_details_link'),
					fa('fa-tags')." Cost Details"=>array('href'=>'#pricing','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/add_supplier_stock_form/','id'=>'pricing_details_link'),
					fa('fa-barcode')." Barcode / Price Details"=>array('href'=>'#barcode','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/add_stock_barcode_form/','id'=>'barcode_details_link'),
					//fa('fa-mail-forward')." Movements"=>array('href'=>'#pricing','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/movements_inq/','id'=>'movements_list_link'),
					);
				$CI->make->tabHead($tabs,null,array());
				$CI->make->sTabBody();
					$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
					$CI->make->eTabPane();
					$CI->make->sTabPane(array('id'=>'pricing','class'=>'tab-pane'));
					$CI->make->eTabPane();
					$CI->make->sTabPane(array('id'=>'barcode','class'=>'tab-pane'));
					$CI->make->eTabPane();
				$CI->make->eTabBody();
			$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}

//---> end
function build_stock_container($id)
{
	$CI =& get_instance();
	$CI->make->sDivRow(array('style'=>'margin-top: -10px;'));
		$CI->make->hidden('idx',$id);
		$CI->make->sDivCol();
			$CI->make->sTab();
				$tabs = array(
					fa('fa-cubes')." General Details" => array(
																'href'=>'#details',
																'class'=>'tab_link',
																'load'=>'inventory/stock_main_form',
																'id'=>'details_link'),
					// fa('fa-tag')." Pricing Details"=>array('href'=>'#pricing','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/item_pricing_form/','id'=>'pricing_details_link'),
					fa('fa-tags')." Cost Details"=>array('href'=>'#pricing','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/supplier_stock_form/','id'=>'pricing_details_link'),
					fa('fa-barcode')." Barcode / Price Details"=>array('href'=>'#pricing','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/stock_barcode_form/','id'=>'barcode_details_link'),
					fa('fa-mail-forward')." Movements"=>array('href'=>'#pricing','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'inventory/movements_inq/','id'=>'movements_list_link'),
					);
				$CI->make->tabHead($tabs,null,array());
				$CI->make->sTabBody();
					$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
					$CI->make->eTabPane();
					$CI->make->sTabPane(array('id'=>'pricing','class'=>'tab-pane'));
					$CI->make->eTabPane();
				$CI->make->eTabBody();
			$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
/*
function build_stock_main_form($item)
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/stock_db",array('id'=>'stock_main_form'));
		$CI->make->hidden('stock_id',iSetObj($item,'stock_id'));
		$CI->make->hidden('mode',((iSetObj($item,'stock_id')) ? 'edit' : 'add'));
		$CI->make->sDivRow(array('style'=>'margin:0px'));
			$CI->make->sDivCol(8);
				$CI->make->H(4,"General Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->input('Stock Description','description',iSetObj($item,'description'),'Stock Name or Description',array('maxchars'=>'50','class'=>'rOkay toUpper','style'=>'font-weight:bolder;'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(6);
						$CI->make->input('Stock Code','stock_code',iSetObj($item,'stock_code'),'Stock Code',array('class'=>'rOkay toUpper','maxchars'=>'20'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(6);
						$CI->make->stockCategoriesDrop('Category','category_id',iSetObj($item,'category_id'),'Select a category',array('class'=>'rOkay combobox'));
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
						$CI->make->yesOrNoNumValDrop('Is Saleable?','is_saleable',iSetObj($item,'is_saleable'),'Select an Option',array('class'=>'combobox'), 1);
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(4);
						$CI->make->input('Standard Cost','standard_cost',iSetObj($item,'standard_cost'),'Standard Cost',array('class'=>'rOkay numbers-only','maxchars'=>'20'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->input('Last Cost','last_cost',iSetObj($item,'last_cost'),'Last Cost',array('class'=>'rOkay numbers-only','maxchars'=>'20'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>''));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
			
			$CI->make->sDivCol(4);
				$CI->make->H(4,"General Ledger Accounts",array('style'=>'margin-top:0px;margin-bottom:0px'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->accountDrop('Sales Account','sales_account',iSetObj($item,'sales_account'),
							'Select Item Sales account',array('class'=>'combobox'));
						$CI->make->accountDrop('COGS Account','cogs_account',iSetObj($item,'cogs_account'),
							'Select COGS account',array('class'=>'combobox'));
						$CI->make->accountDrop('Inventory Account','inventory_account',iSetObj($item,'inventory_account'),
							'Select Inventory account',array('class'=>'combobox'));
						$CI->make->accountDrop('Adjustment Account','adjustment_account',iSetObj($item,'adjustment_account'),
							'Select Adjustment account',array('class'=>'combobox'));
						$CI->make->accountDrop('Assembly Cost Account','assembly_cost_account',iSetObj($item,'assembly_cost_account'),
							'Select Assembly Cost account',array('class'=>'combobox'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();
	$CI->make->sDivRow(array('style'=>'margin:10px;'));
		$CI->make->sDivCol(6);
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-save').' Save stock details',array('id'=>'save-stock-btn','class'=>'btn-block'),'primary');
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-reply').' Return to stock master',array('id'=>'stock-back-btn','class'=>'btn-block'),'default');
		$CI->make->eDivCol();
    $CI->make->eDivRow();

	return $CI->make->code();
}
*/

//--->add stock

function add_build_stock_main_form($item=array(),$active=null)
{
	$CI =& get_instance();
	$CI->make->hidden('active_tabpane',$active);
	
	$stock_cos = array();
	// echo var_dump($item)."<br>";
	if(!empty($item))
		$stock_cos = $CI->inventory_model->get_stock_cost_of_sales_temp($item->stock_id); //-----ORIGINAL
	else
		$stock_cos = array();
	
	$CI->make->sForm("inventory/add_stock_db",array('id'=>'stock_main_form'));
		$CI->make->hidden('stock_id',iSetObj($item,'stock_id'));
		$CI->make->hidden('mode',((iSetObj($item,'stock_id')) ? 'edit' : 'add'));
		$CI->make->sDivRow(array('style'=>'margin:0px'));
			$CI->make->sDivCol(5);
				$CI->make->H(4,"General Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
				$CI->make->sDivRow();
					$CI->make->sDivCol(6);
					if(!empty($item)){
						$CI->make->input('Stock Code','stock_code',iSetObj($item,'stock_code'),'Stock Code',array('class'=>'rOkay toUpper reqForm','maxchars'=>'20','readonly'=>'readonly'));
					}else{
						$CI->make->input('Stock Code','stock_code',iSetObj($item,'stock_code'),'Stock Code',array('class'=>'rOkay toUpper reqForm','maxchars'=>'20'));
					}
					$CI->make->eDivCol();
					$CI->make->sDivCol(6);
						$CI->make->stockCategoriesDrop('Category','category_id',iSetObj($item,'category_id'),'Select a category',array('class'=>'rOkay combobox reqForm'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->input('Stock Description','description',iSetObj($item,'description'),'Stock Name or Description',array('maxchars'=>'50','class'=>'rOkay toUpper reqForm','style'=>'font-weight:bolder;'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(4);
						$CI->make->stockUOMCodeDrop('Report UOM','report_uom',iSetObj($item,'report_uom'),'Select UOM',array('class'=>'rOkay combobox reqForm'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->input('Report Quantity','report_qty',iSetObj($item,'report_qty'),'Quantity per UOM',array('class'=>'rOkay reqForm','maxchars'=>'20'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->stockTaxTypeDrop('Tax Type','tax_type_id',iSetObj($item,'tax_type_id'),'Select Tax Type',array('class'=>'combobox reqForm'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(4);
						$CI->make->mbFlagDrop('Buy or Make','mb_flag',iSetObj($item,'mb_flag'),'Select an Option',array('class'=>'combobox reqForm'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->yesOrNoNumValDrop('Is Consigned?','is_consigned',iSetObj($item,'is_consigned'),'Select an Option',array('class'=>'combobox reqForm'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
				//		$CI->make->yesOrNoNumValDrop('Is Saleable?','is_saleable',iSetObj($item,'is_saleable'),'Select an Option',array('class'=>'combobox reqForm'), 1);
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(3);
					//	$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>' reqForm'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						// $CI->make->input('Standard','standard_cost',iSetObj($item,'standard_cost'),'Standard Cost',array('class'=>'numbers-only','maxchars'=>'20', 'readonly'=>'readonly'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						// $CI->make->input('Last Cost','last_cost',iSetObj($item,'last_cost'),'Last Cost',array('class'=>'numbers-only','maxchars'=>'20', 'readonly'=>'readonly'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						// $CI->make->input('Cost of Sales','cost_of_sales',iSetObj($item,'cost_of_sales'),'Cost of Sales',array('class'=>'numbers-only','maxchars'=>'20')); //-----TEMPORARILY REMOVED ROKAY
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
			
			//-----LOOP FOR DISCOUNTS
			// $CI->make->sDivCol(4, 'left', 0, array('style'=>'height: 400px; overflow-x: none; overflow-y: scroll;'));
			$CI->make->sDivCol(3);
				$CI->make->H(4,"Discount Details",array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
				$CI->make->sDivRow();
					// $CI->make->sDivCol();
					$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 180px; overflow-x: none; overflow-y: scroll;'));
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
										// $CI->make->yesOrNoNumValDrop(ucwords($this_vals->description).' <---> Stock ID : '.iSetObj($item,'stock_id').' <~~~> POS Stock Discount : '.$this_vals->id,$this_vals->short_desc.'_disc',$disc_stat,'',array('class'=>'formInputSmall'), 0);
										$CI->make->yesOrNoNumValDrop(ucwords($this_vals->description),$this_vals->short_desc.'_disc',$disc_stat,'',array('class'=>'formInputSmall reqForm'), 0);
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
										// $CI->make->yesOrNoNumValDrop(ucwords($this_vals->description),$this_vals->short_desc.'_disc','','',array('class'=>'formInputSmall'), 0);
										$CI->make->yesOrNoNumValDrop(ucwords($this_vals->description),$this_vals->short_desc.'_disc','','',array('class'=>'formInputSmall reqForm'), 0);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
				$add_card_link = $CI->make->A(
						'Add Cards',
							base_url().'inventory/stock_master/',
							array('id'=>'add_card_link','return'=>'true')
						);
				$CI->make->H(4,"Allowed Card Types",array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
				// $CI->make->sDivRow();
					// $CI->make->sDivCol(12,'right');
						// $CI->make->H(5,$add_card_link,array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
					// $CI->make->eDivCol();
				// $CI->make->eDivRow();
				$CI->make->sDivRow();
					// $CI->make->sDivCol();
						$itm_array = $crd_vals = $db_prices = $new_items = array();
						$is_enabled = '';
						$crd_array = $CI->inventory_model->get_customer_card_types_wo_sukicard();
						$crd_array_sukicard = $CI->inventory_model->get_customer_card_types_w_sukicard();
	
					$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 180px; overflow-x: none; overflow-y: scroll;'));
						if(!empty($item)){
							
							foreach($crd_array_sukicard as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
								$is_enabled = $CI->inventory_model->is_card_type_enabled_temp(iSetObj($item,'stock_id'), $crd_vals->id);
									$CI->make->sDivRow(array('class'=>''));
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',iSetObj($crd_vals,'id'));
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd',$is_enabled,'',array('class'=>'formInputSmall reqForm card_types'), 1);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'right');
								$CI->make->H(5,$add_card_link,array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
							//-----EDIT MODE
							foreach($crd_array as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
								$is_enabled = $CI->inventory_model->is_card_type_enabled_temp(iSetObj($item,'stock_id'), $crd_vals->id);
								$CI->make->sDivRow(array('class'=>'card_type_rows'));
									$CI->make->sDivCol();
										$CI->make->hidden('other_cards',$is_enabled);
										$CI->make->hidden('sales_type_id',$crd_vals->id);
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd',$is_enabled,'',array('class'=>'formInputSmall reqForm card_types'), 0);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}else{
								
							//$CI->make->sDivCol(12, 'left', 0, array('style'=>''));
							foreach($crd_array_sukicard as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
									$CI->make->sDivRow(array('class'=>''));
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',iSetObj($crd_vals,'id'));
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd','','',array('class'=>'formInputSmall reqForm'),1);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						//	$CI->make->eDivCol();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'right');
								$CI->make->H(5,$add_card_link,array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
							
							//-----ADD MODE								
							foreach($crd_array as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
									$CI->make->sDivRow(array('class'=>'card_type_rows'));
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',iSetObj($crd_vals,'id'));
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd','','',array('class'=>'formInputSmall reqForm'),0);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			$CI->make->eDivCol();
			
			$CI->make->sDivCol(4);
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
				// $CI->make->H(4,"Cost of Sales",array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
				// $CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									$CI->make->th('Branch', array('style'=>'width: 20%;'));
									//-----LOOP PRICE TYPES COLUMNS-----START
									$CI->make->th('Cost of Sales', array('style'=>'width: 20%;'));
									//-----LOOP PRICE TYPES COLUMNS-----END
								$CI->make->eRow();
							$CI->make->eTable();
						$CI->make->eDiv();
					$CI->make->eDivCol();
					$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 180px; overflow-x: none; overflow-y: scroll;'));
						$cost_of_sales_amt = $branch_array = $itm_array = $crd_vals = $db_prices = $new_items = array();
						$is_enabled = '';
						$this_priceA = 0;
						$branch_array = $CI->inventory_model->get_active_branches();
						$crd_array = $CI->inventory_model->get_customer_card_types();
						
						foreach($stock_cos as $cost_vals){
							$cost_of_sales_amt[$cost_vals->stock_id][$cost_vals->branch_id] = $cost_vals->cost_of_sales;
							// echo $cost_vals->stock_id."~~".$cost_vals->branch_id."~~".$cost_vals->cost_of_sales."<br>";
						}
						
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));	
							
							foreach($branch_array as $branch_vals){
								$this_priceA = $inpA = "";
								
								if(!empty($item)){
									if(isset($cost_of_sales_amt[$item->stock_id][$branch_vals->id]))
										 $this_priceA = $cost_of_sales_amt[$item->stock_id][$branch_vals->id];
								}
								 
								
								$CI->make->sRow();
									$CI->make->th($branch_vals->code, array('style'=>'width: 20%;'));
									$inpA = "<input type='text' p_barcode='' p_sales_type='' p_branch_id='' name='".$branch_vals->code."_cost_of_sales' id='".$branch_vals->code."_cost_of_sales' value='0' class='formInputMini branch_type_price num_with_decimal ' ".($this_priceA != '' ? 'readonly=readonly' : '')." style='".($this_priceA != '' ? 'background-color: #eeeeee;' : 'background-color: #ffffff')."'>";
									$CI->make->td($inpA, array('style'=>'width: 20%;'));
								$CI->make->eRow();
							}
							
							$CI->make->eTable();
						$CI->make->eDiv();
						// if(!empty($item)){
							// //-----EDIT MODE
							// foreach($crd_array as $crd_vals){
								// $inputs = $labels = "";
								// $labels = $crd_vals->description;
								// $is_enabled = $CI->inventory_model->is_card_type_enabled(iSetObj($item,'stock_id'), $crd_vals->id);
								// $CI->make->sDivRow();
									// $CI->make->sDivCol();
										// $CI->make->hidden('sales_type_id',$crd_vals->id);
										// $CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd',$is_enabled,'',array('class'=>'formInputSmall'), 0);
									// $CI->make->eDivCol();
								// $CI->make->eDivRow();
							// }
						// }else{
							// //-----ADD MODE
							// foreach($crd_array as $crd_vals){
								// $inputs = $labels = "";
								// $labels = $crd_vals->description;
								// $CI->make->sDivRow();
									// $CI->make->sDivCol();
										// $CI->make->hidden('sales_type_id',iSetObj($crd_vals,'id'));
										// $CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd','','',array('class'=>'formInputSmall'), 0);
									// $CI->make->eDivCol();
								// $CI->make->eDivRow();
							// }
						// }
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
				// $CI->make->H(4,"General Ledger Accounts",array('style'=>'margin-top:0px;margin-bottom:0px'));
				// $CI->make->append('<hr style="margin-top:5px;margin-bottom:10px" class="style-one"/>');
				// $CI->make->sDivRow();
					// // $CI->make->sDivCol();
					// $CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 180px; overflow-x: none; overflow-y: scroll;'));
						// $CI->make->accountDrop('Sales Account','sales_account',iSetObj($item,'sales_account'),
							// 'Select Item Sales account',array('class'=>'combobox'));
						// $CI->make->accountDrop('COGS Account','cogs_account',iSetObj($item,'cogs_account'),
							// 'Select COGS account',array('class'=>'combobox'));
						// $CI->make->accountDrop('Inventory Account','inventory_account',iSetObj($item,'inventory_account'),
							// 'Select Inventory account',array('class'=>'combobox'));
						// $CI->make->accountDrop('Adjustment Account','adjustment_account',iSetObj($item,'adjustment_account'),
							// 'Select Adjustment account',array('class'=>'combobox'));
						// $CI->make->accountDrop('Assembly Cost Account','assembly_cost_account',iSetObj($item,'assembly_cost_account'),
							// 'Select Assembly Cost account',array('class'=>'combobox'));
					// $CI->make->eDivCol();
				// $CI->make->eDivRow();
			// $CI->make->eDivCol();
	
		$CI->make->eDivRow();
	$CI->make->eForm();
	$CI->make->sDivRow(array('style'=>'margin:10px;'));
		$CI->make->sDivCol(6);
			$CI->make->sDivCol(6);
			$CI->make->eDivCol();
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-share').' NEXT',array('id'=>'save-stock-btn','class'=>'btn-block'),'primary');
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-reply').' Return to Stock Master',array('id'=>'stock-back-btn','class'=>'btn-block'),'default');
		$CI->make->eDivCol();
    $CI->make->eDivRow();

	return $CI->make->code();
}


//end


//-----=====##BARCODE

function add_build_stock_barcode_form($item=array(), $ref='')
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/add_stock_barcode_db",array('id'=>'stock_barcode_form'));
		$CI->make->hidden('id',iSetObj($item,'stock_id'));
		// $CI->make->hidden('hidden_stock_id',iSetObj($item,'id')); //-----orig
		$CI->make->hidden('hidden_stock_id',($ref != '' ? $ref : ''));
		// $CI->make->hidden('mode',((iSetObj($item,'id')) ? 'edit' : 'add'));
		$CI->make->hidden('mode','add', array('class'=>'form_mode'));
		
		$CI->make->sDivRow();
			//----STOCK LIST-----START
			$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'file-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('warning',array('div-form'));
								$CI->make->sBoxBody(array('style'=>'height: 240px;'));
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array("style"=>'margin-top:70px; margin-bottom:5px;'));
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('id'=>'init-contents', 'style'=>''));
						// $CI->make->sDivCol(12,'center',0,array("style"=>'padding-left: 0px; padding-right: 0px;')); //-----orig
						$CI->make->sDivCol(12,'center',0,array("style"=>''));
							$CI->make->sBox('warning',array('div-form'));
								$CI->make->sBoxBody(array('style'=>''));
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->sDiv(array('class'=>'table-responsive'));
												$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
													$CI->make->sRow();
														$CI->make->th('Barcode');
														$CI->make->th('Description',array('style'=>''));
														$CI->make->th('Report UOM',array('style'=>''));
														$CI->make->th('Report Qty',array('style'=>''));
														$CI->make->th('Retail Price',array('style'=>''));
														$CI->make->th('Wholesale Price',array('style'=>''));
													$CI->make->eRow();
													$CI->make->sRow();
														$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
													$CI->make->eRow();
												$CI->make->eTable();
											$CI->make->eDiv();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('id'=>'stock-barcode-contents', 'style'=>'height: 200px; width: 100%; overflow-x: none; overflow-y: scroll;'));
					$CI->make->eDiv();
				//-----PRELOADER-----END
				$CI->make->eDivRow();	
			$CI->make->eDivCol();
			//----STOCK LIST-----END
			
			//-----ADDER FORM-----START
			$CI->make->sDivCol(12);
				$CI->make->sBox('danger');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(8);
								$CI->make->H(4,"Stock Barcode Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
								
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->hidden('ids','');
										$CI->make->input('Stock','stock_id','[ '.iSetObj($item,'stock_code').' ] '.iSetObj($item,'description'),'Type Barcode',array('class'=>'rOkay', 'readonly'=>''));
										$CI->make->hidden('stock_id',iSetObj($item,'stock_id'));
										$CI->make->hidden('barcode_stock_id',iSetObj($item,'stock_id'));
										$CI->make->hidden('hidden_barcode','');
										$CI->make->hidden('hidden_uomss','');
										$CI->make->hidden('barcode_mode','add');
										$CI->make->hidden('short_desc_old','');
										$CI->make->hidden('desc_old','');
										$CI->make->hidden('hidden_sales_type','');
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// $CI->make->input('Barcode','barcode',iSetObj($item,'barcode'),'Type Barcode',array('class'=>'rOkay')); #OLD
										$CI->make->input('Barcode','barcodes','','Type Barcode',array('class'=>'rOkay'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										// $CI->make->input('Confirm Barcode','con_barcode',iSetObj($item,'barcode'),'Type Barcode',array('class'=>'rOkay')); #OLD
										$CI->make->input('Confirm Barcode','con_barcode','','Type Barcode',array('class'=>'rOkay'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
										// $CI->make->input('Short Description','short_desc',iSetObj($item,'short_desc'),'Type Short Description',array('class'=>'rOkay barcode_short_desc'));  #OLD
										$CI->make->input('Short Description','short_desc','','Type Short Description',array('class'=>'rOkay barcode_short_desc required_form', 'old_val'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(8);
										// $CI->make->input('Description','description',iSetObj($item,'description'),'Type Description',array('class'=>'rOkay barcode_desc'));  #OLD
										$CI->make->input('Description','description','','Type Description',array('class'=>'rOkay barcode_desc required_form', 'old_val'=>''));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// $CI->make->stockUOMCodeDrop('UOM','uom',iSetObj($item,'uom'),'Select UOM',array('class'=>'rOkay combobox uom_dropdown'));  #OLD
										$CI->make->stockUOMCodeDrop('UOM','uom','','Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										// $CI->make->input('Quantity','qty',iSetObj($item,'qty'),'Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));  #OLD
										$CI->make->input('Quantity','qty','','Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// // $CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'barcode_inactive_dropdown'));  #OLD
										// $CI->make->inactiveDrop('Is Inactive','inactive','',null,array('class'=>'barcode_inactive_dropdown')); //TEMPORARILY DISABLED [07062015 0141PM]
										$CI->make->activeSalesTypeDrop('Sales Type','sales_type_id','',null,array('class'=>'sales_type_dropdown')); //-----Displays TEXT value while form value is equal to ID
										// $CI->make->activeSalesTypeTextDrop('Sales Type','sales_type_id','',null,array('class'=>'sales_type_dropdown')); //-----Both Text and form value are equal to desc
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								
							$CI->make->eDivCol();
							
							$CI->make->sDivCol(4);
								$CI->make->sDiv(array('id'=>'pricing_def'));
									//-----LOAD PRICING LOOP HERE-----START
										$CI->make->sDivRow();
											$CI->make->sDivCol(6,'left');
												$CI->make->H(4,"Pricing Details",array('style'=>'margin-top:0px;margin-bottom:0px;'));
											$CI->make->eDivCol();
											$CI->make->sDivCol(6,'right');
												// $copy_link;
												// $CI->make->A(fa('fa-copy fa-lg fa-fw'),'',array('class'=>'copy_link', 'title'=>'Click to copy value(s) of first row to all remaining rows'));
												// $CI->make->A(fa('fa-copy fa-lg fa-fw'),base_url().'inventory/stock_master/',array('id'=>'copier_link', 'title'=>'Click to copy value(s) of first row to all remaining rows'));
												$CI->make->A(fa('fa-copy fa-lg fa-fw'),base_url().'inventory/stock_master/',array('id'=>'copier_link', 'title'=>'Click to copy'));
												$CI->make->A('&nbsp;&nbsp;&nbsp;'.fa('fa-refresh fa-lg fa-fw'),base_url().'inventory/stock_master/',array('id'=>'clear_link', 'title'=>'Click to clear price fields'));
											$CI->make->eDivCol();
										$CI->make->eDivRow();
										$CI->make->sDivRow();
											$CI->make->sDivCol();
												$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
											$CI->make->eDivCol();
										$CI->make->eDivRow();
											
										//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----START
										$CI->make->sDivRow(array('style'=>'margin-bottom: 15px;'));
											$CI->make->sDivCol();
												$CI->make->sDiv(array('class'=>'table-responsive'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
														$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
															$CI->make->th('Branch', array('style'=>'width: 35%;'));
															// //-----LOOP PRICE TYPES COLUMNS-----START
																// $itm_array = $this_vals = $db_prices = array();
																// $itm_array = $CI->inventory_model->get_sales_types();
																// foreach($itm_array as $this_vals){
																	// $CI->make->th(ucwords($this_vals->sales_type),array('style'=>'width: 20%;'));
																	// // $CI->make->th('&nbsp;', array('style'=>'width: 25%;')); //---temporarily disabled pag ADD palang ng price
																// }
															// //-----LOOP PRICE TYPES COLUMNS-----END
														$CI->make->eRow();
													$CI->make->eTable();
												$CI->make->eDiv();
											$CI->make->eDivCol();
											
											//-----ADD
											$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
												$CI->make->sDiv(array('class'=>'table-responsive'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
															$br_array = $st_array = array();
															$st_array = $CI->inventory_model->get_sales_types();
															$br_array = $CI->inventory_model->get_active_branches();
															$counter = 1;
															foreach($br_array as $br_vals){
																$CI->make->sRow();
																	$CI->make->td($br_vals->code, array('style'=>'width: 35%;'));
																	$CI->make->hidden('branch_id',$br_vals->id);
																// foreach($st_array as $st_vals){ //-----TEMP
																	$copy_link = $price_link = $inp = "";
																	$inp = "<input type='text' name='".$br_vals->code."_price' id='".$br_vals->code."_price' class='formInputMini branch_type_price num_with_decimal countme_$counter ".($counter == 1 ? 'first_row' : 'following_row')."'>";
																	$CI->make->hidden($br_vals->code.'_price_old','');
																	$CI->make->td($inp, array('style'=>'width: 20%;'));
																	$counter++;
																// } //-----TEMP
																$CI->make->eRow();
															}
													$CI->make->eTable();
												$CI->make->eDiv();
											$CI->make->eDivCol();
									
										$CI->make->eDivRow();
										//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----END
									//-----LOAD PRICING LOOP HERE-----END
								$CI->make->eDiv();
								$CI->make->sDiv(array('id'=>'new_pricing_def', 'style'=>'display: none;'));
								$CI->make->eDiv();
							$CI->make->eDivCol();
							
								//$CI->make->sDivCol();
								//-----LOAD BUTTONS FOR SAVING/CANCELLING STOCK BARCODE DETAILS TRX
								$CI->make->hidden('for_markup_branch','');
								
								// $CI->make->sDivRow();
									// $CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
									// $CI->make->sDivCol(3);
										// $CI->make->input('Computed SRP','computed_srp','','',array('class'=>'num_with_decimal  required_form', 'readonly'=>'readonly','old_val'=>''));
									// $CI->make->eDivCol();
									// $CI->make->sDivCol(3);
										// $CI->make->input('Prevailing Unit Price','prevailing_unit_price','','',array('class'=>'num_with_decimal  required_form ','readonly'=>'readonly','old_val'=>''));
									// $CI->make->eDivCol();
									// $CI->make->sDivCol(2);
										// $CI->make->input('Landed Cost Markup','landed_cost_markup','','',array('class'=>'num_with_decimal  required_form','readonly'=>'readonly','old_val'=>''));
									// $CI->make->eDivCol();
									// $CI->make->sDivCol(2);
										// $CI->make->input('Cost of Sales Markup','cost_of_sales_markup','','',array('class'=>'num_with_decimal  required_form','readonly'=>'readonly','old_val'=>''));
									// $CI->make->eDivCol();
									// $CI->make->sDivCol(2);
										// $CI->make->A('Save To All Branch','',array('id'=>'save-all-branch-btn','class'=>'btn btn-primary','style'=>'margin-top: 25px;','disabled'=>'disabled'));
									// $CI->make->eDivCol();
								// $CI->make->eDivRow();
									// $CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
							// $CI->make->eDivCol();
							
							
							$CI->make->sDivCol();
								//-----LOAD BUTTONS FOR SAVING/CANCELLING STOCK BARCODE DETAILS TRX
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->button(fa('fa-save').' Save',array('id'=>'save-barcode-btn','class'=>'btn-block', 'style'=>'margin-top: 20px;'),'primary');
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->button(fa('fa-reply').' Return to Main',array('id'=>'back-barcode-btn','class'=>'btn-block', 'style'=>'margin-top: 20px;'),'default');
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
							
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			//-----ADDER FORM-----END

		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}



function add_build_stock_barcode_price_list($barcode=null){
$CI =& get_instance();	
	$barcode_prices = array();
	$this_stock_id = "";
	$barcode_prices = $CI->inventory_model->get_stock_barcode_prices_temp($barcode); //-----ORIGINAL
	// echo $CI->inventory_model->db->last_query()."<br>";
	// $barcode_prices = $CI->inventory_model->get_complete_stock_barcode_prices($barcode);
	// echo var_dump($barcode_prices);
	
	//-----LOAD PRICING LOOP HERE-----START
		// $itm_array = $this_vals = $db_prices = array();
		// $itm_array = $CI->inventory_model->get_sales_types();
		$CI->make->H(4,"Pricing Details",array('style'=>'margin-top:0px;margin-bottom:0px;'));
		$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');

	//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----START
	$CI->make->sDivRow(array('style'=>'margin-bottom: 15px;'));
		$CI->make->sDivCol();
			$CI->make->sDiv(array('class'=>'table-responsive'));
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
						$CI->make->th('Branch', array('style'=>'width: 20%;'));
						// //-----LOOP PRICE TYPES COLUMNS-----START
							// $itm_array = $this_vals = $db_prices = array();
							// $itm_array = $CI->inventory_model->get_sales_types();
							// foreach($itm_array as $this_vals){
								// $CI->make->th(ucwords($this_vals->sales_type),array('style'=>'width: 20%; text-align: right;'));
								// $CI->make->th('&nbsp;', array('style'=>'width: 20%;'));
							// }
						// //-----LOOP PRICE TYPES COLUMNS-----END
					$CI->make->eRow();
				$CI->make->eTable();
			$CI->make->eDiv();
		$CI->make->eDivCol();
		
			//-----EDIT
			$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
				$CI->make->sDiv(array('class'=>'table-responsive'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
							$this_price = $this_computed_srp =  $this_prevailing_unit_price = $this_landed_cost_markup = $this_cost_of_sales_markup =  0;
							$pk_id = $cur_avg_net_cost = $cur_cos_mup = '';
							$bp_prices = $br_array = $st_array = $bp_computed_srp = $bp_prevailing_unit_price = $bp_landed_cost_markup = $bp_cost_of_sales_markup = array();
							$st_array = $CI->inventory_model->get_sales_types();
							$br_array = $CI->inventory_model->get_active_branches();
							
							foreach($barcode_prices as $bp_vals){
								$bp_prices[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->price;
								$bp_computed_srp[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->computed_srp;
								$bp_prevailing_unit_price[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->prevailing_unit_price;
								$bp_landed_cost_markup[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->landed_cost_markup;
								$bp_cost_of_sales_markup[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->cost_of_sales_markup;
							}
							
							foreach($br_array as $br_vals){
								$CI->make->sRow();
									$CI->make->th($br_vals->code, array('style'=>'width: 20%;'));
									$CI->make->hidden('hidden_branch_id',$br_vals->id, array('class'=>'hidden_branch_id_'+$br_vals->id));
								// foreach($st_array as $st_vals){ //-----TEMP
									$this_array = array();
									$st_cost_of_sales = "";
									$pk_id = $this_price = $price_link = $inp = "";
									
									//prices
									if(isset($bp_prices[$br_vals->id][$bp_vals->sales_type_id]))
										$this_price = $bp_prices[$br_vals->id][$bp_vals->sales_type_id];
									
									//computed_srp
									if(isset($bp_computed_srp[$br_vals->id][$bp_vals->sales_type_id]))
										$this_computed_srp = $bp_computed_srp[$br_vals->id][$bp_vals->sales_type_id];
									
									//prevailing_unit_price 
									if(isset($bp_prevailing_unit_price[$br_vals->id][$bp_vals->sales_type_id]))
										$this_prevailing_unit_price = $bp_prevailing_unit_price[$br_vals->id][$bp_vals->sales_type_id];
									
									//landed_cost_markup	
									if(isset($bp_landed_cost_markup[$br_vals->id][$bp_vals->sales_type_id]))
									    $this_landed_cost_markup = $bp_landed_cost_markup[$br_vals->id][$bp_vals->sales_type_id];
								
									//cost_of_sales_markup
									if(isset($bp_cost_of_sales_markup[$br_vals->id][$bp_vals->sales_type_id]))
									    $this_cost_of_sales_markup = $bp_cost_of_sales_markup[$br_vals->id][$bp_vals->sales_type_id];
									
									// $pk_id = $CI->inventory_model->get_stock_barcode_prices_pk_id($bp_vals->barcode, $br_vals->id, $st_vals->id);
									$this_array = $CI->inventory_model->get_stock_cost_details($bp_vals->stock_id, $br_vals->id);
									// echo $CI->inventory_model->db->last_query()."<br>";
									
									$st_cost_of_sales = $CI->inventory_model->get_branch_stock_cost_of_sales($bp_vals->stock_id, $br_vals->id);
									if(!empty($this_array)){
										$cur_avg_net_cost = $this_array[0]->avg_net_cost;
										$cur_net_cost = $this_array[0]->net_cost;
									}else{
										$cur_avg_net_cost = '';
										$cur_net_cost = '';
									}
									
									if($st_cost_of_sales != ''){
										$cur_cost_of_sales = $st_cost_of_sales;
									}else{
										$cur_cost_of_sales = '';
									}
									
									$price_link .= $CI->make->A(
													fa('fa-tag fa-lg fa-fw'),
													'',
													array('class'=>'price_link',
														'ref_br_id'=>$br_vals->id,
														'ref_br_code'=>$CI->inventory_model->get_branch_code($br_vals->id),
														'ref_desc'=>$bp_vals->description,
														'computed_srp'=>$this_computed_srp,
														'prevailing_unit_price'=>$this_prevailing_unit_price,
														'landed_cost_markup'=>$this_landed_cost_markup,
														'cost_of_sales_markup'=>$this_cost_of_sales_markup,
														'ref_stock_id'=>$bp_vals->stock_id,
														'ref_barcode'=>$bp_vals->barcode,
														'ref_sales_type_id'=>$bp_vals->sales_type_id,
														'ref_uom'=>$bp_vals->uom,
														'ref_qty'=>$bp_vals->qty,
														'ref_price'=>$this_price,
														'ref_avg_net_cost'=>$cur_avg_net_cost,
														'ref_cost_of_sales'=>$cur_cost_of_sales,
														'return'=>'false'));
														
									$price_link .= $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-calendar fa-lg fa-fw'),
													base_url().'inventory/stock_master/',
													array('class'=>'sched_markdown_link',
														'ref_br_id'=>$br_vals->id,
														'ref_desc'=>$bp_vals->description,
														'ref_stock_id'=>$bp_vals->stock_id,
														'ref_barcode'=>$bp_vals->barcode,
														// 'ref_sales_type_id'=>$st_vals->id,
														'ref_sales_type_id'=>$bp_vals->sales_type_id,
														'ref_uom'=>$bp_vals->uom,
														'ref_qty'=>$bp_vals->qty,
														'ref_price'=>$this_price,
														// 'title'=>'Scheduled Price Markdown for '.strtoupper($br_vals->code).' ( '.strtoupper($st_vals->sales_type).' )',
														'title'=>'Scheduled Price Markdown for '.strtoupper($br_vals->code).' ',
														'return'=>'false'));
														
								$price_link .= $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-line-chart fa-lg fa-fw'),
													base_url().'inventory/stock_master/',
													array('class'=>'marginal_markdown_link',
														'ref_br_id'=>$br_vals->id,
														'ref_desc'=>$bp_vals->description,
														'ref_stock_id'=>$bp_vals->stock_id,
														'ref_barcode'=>$bp_vals->barcode,
														'ref_sales_type_id'=>$bp_vals->sales_type_id,
														'ref_uom'=>$bp_vals->uom,
														'ref_qty'=>$bp_vals->qty,
														'ref_price'=>$this_price,
														'landed_cost'=>$cur_net_cost,
														'title'=>'Marginal Price Setup for '.strtoupper($br_vals->code).' ',
														'return'=>'false'));					
									
									// $inp = "<input type='text' p_barcode='' p_sales_type='' p_branch_id='' name='".$br_vals->code."_".$st_vals->sales_type."_price' id='".$br_vals->code."_".$st_vals->sales_type."_price' value='".$this_price."' class='formInputMini branch_type_price num_with_decimal ".$st_vals->sales_type."_tbox '>"; //-----TEMP
									$inp = "<input type='text' p_barcode='' p_sales_type='' p_branch_id='' name='".$br_vals->code."_price' id='".$br_vals->code."_price' old_val='".$this_price."' value='".$this_price."' class='formInputMini branch_type_price num_with_decimal required_form'>";
									$CI->make->td($inp, array('style'=>'width: 20%;'));
								//	$CI->make->td($price_link, array( 'style'=>'width: 20%;'));
								// } //-----TEMP
								$CI->make->eRow();
							}
					$CI->make->eTable();
				$CI->make->eDiv();
			$CI->make->eDivCol();

	$CI->make->eDivRow();
	//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----END
//-----LOAD PRICING LOOP HERE-----END
return $CI->make->code();
}

function add_build_stock_barcodes_list($item=array(), $stock_id=null, $barcode_prices=array()){
	$CI =& get_instance();
	$add_link = "";
	$barcode_prices = array();
	
	// $add_link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), base_url().'inventory/stock_master/'.$stock_id, array(
										// 'class'=>'add_stock_barcode',
										// 'title'=>'Add New Stock Barcode',
										// 'return'=>'false'));
	$add_link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), '', array(
										'class'=>'add_stock_barcode',
										'title'=>'Add New Stock Barcode',
										'style'=>'cursor: pointer;',
										'return'=>'false'));
										
		$CI->make->sDivCol(12,'center',0,array("style"=>''));
			$CI->make->sBox('info',array('div-form'));
				$CI->make->sBoxBody(array('style'=>''));
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										$CI->make->th('Barcode');
										$CI->make->th('Description',array('style'=>''));
										$CI->make->th('UOM',array('style'=>''));
										$CI->make->th('Qty',array('style'=>''));
										// $CI->make->th('Retail Price',array('style'=>''));
										// $CI->make->th('Wholesale Price',array('style'=>''));
										$CI->make->th($add_link,array('style'=>''));
									$CI->make->eRow();
									$barcode_details = array();
									// echo var_dump($item);
									foreach($item as $val){
										$links = "";
										$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'), '', array(
										'class'=>'edit_me_btn',
										'ref'=>$val->id,
										'ref_barcode'=>$val->barcode,
										'ref_short_desc'=>$val->short_desc,
										'ref_desc'=>$val->description,
										'ref_uom'=>$val->uom,
										'ref_qty'=>$val->qty,
										'ref_sales_type_id'=>$val->sales_type_id,
										'ref_status'=>$val->inactive,
										'title'=>'Edit Stock Barcode Details',
										'style'=>'cursor: pointer;',
										// 'id'=>'view-stock-barcode-'.$val->id,
										'return'=>'false'));
										$CI->make->sRow(array('id'=>$val->id));
											$CI->make->th($val->barcode);
											$CI->make->th($val->description,array('style'=>''));
											$CI->make->th($val->uom,array('style'=>''));
											$CI->make->th($val->qty,array('style'=>''));
											// $CI->make->th(num($val->retail_price),array('style'=>''));
											// $CI->make->th(num($val->wholesale_price),array('style'=>''));
											$CI->make->th($links); //-----TEMPORARILY DISABLED
											// $CI->make->th(''); //-----BLANK MUNA
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


//-----=====##





function build_stock_main_form($item=array())
{
	$CI =& get_instance();
	$stock_cos = array();
	// echo var_dump($item)."<br>";
	if(!empty($item))
		$stock_cos = $CI->inventory_model->get_stock_cost_of_sales($item->stock_id); //-----ORIGINAL
	else
		$stock_cos = array();
	
	$CI->make->sForm("inventory/stock_db",array('id'=>'stock_main_form'));
		$CI->make->hidden('stock_id',iSetObj($item,'stock_id'));
		$CI->make->hidden('mode',((iSetObj($item,'stock_id')) ? 'edit' : 'add'));
		$CI->make->sDivRow(array('style'=>'margin:0px'));
			$CI->make->sDivCol(5);
				$CI->make->H(4,"General Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
				$CI->make->sDivRow();
					$CI->make->sDivCol(6);
					if(!empty($item)){
						$CI->make->input('Stock Code','stock_code',iSetObj($item,'stock_code'),'Stock Code',array('class'=>'rOkay toUpper reqForm','maxchars'=>'20','readonly'=>'readonly'));
					}else{
						$CI->make->input('Stock Code','stock_code',iSetObj($item,'stock_code'),'Stock Code',array('class'=>'rOkay toUpper reqForm','maxchars'=>'20'));
					}
					$CI->make->eDivCol();
					$CI->make->sDivCol(6);
						$CI->make->stockCategoriesDrop('Category','category_id',iSetObj($item,'category_id'),'Select a category',array('class'=>'rOkay combobox reqForm'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->input('Stock Description','description',iSetObj($item,'description'),'Stock Name or Description',array('maxchars'=>'50','class'=>'rOkay toUpper reqForm','style'=>'font-weight:bolder;'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(4);
						$CI->make->stockUOMCodeDrop('Report UOM','report_uom',iSetObj($item,'report_uom'),'Select UOM',array('class'=>'rOkay combobox reqForm'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->input('Report Quantity','report_qty',iSetObj($item,'report_qty'),'Quantity per UOM',array('class'=>'rOkay reqForm','maxchars'=>'20'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->stockTaxTypeDrop('Tax Type','tax_type_id',iSetObj($item,'tax_type_id'),'Select Tax Type',array('class'=>'combobox reqForm'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(4);
						$CI->make->mbFlagDrop('Buy or Make','mb_flag',iSetObj($item,'mb_flag'),'Select an Option',array('class'=>'combobox reqForm'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->yesOrNoNumValDrop('Is Consigned?','is_consigned',iSetObj($item,'is_consigned'),'Select an Option',array('class'=>'combobox reqForm'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
				//		$CI->make->yesOrNoNumValDrop('Is Saleable?','is_saleable',iSetObj($item,'is_saleable'),'Select an Option',array('class'=>'combobox reqForm'), 1);
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->sDivRow();
					$CI->make->sDivCol(3);
					//	$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>' reqForm'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						// $CI->make->input('Standard','standard_cost',iSetObj($item,'standard_cost'),'Standard Cost',array('class'=>'numbers-only','maxchars'=>'20', 'readonly'=>'readonly'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						// $CI->make->input('Last Cost','last_cost',iSetObj($item,'last_cost'),'Last Cost',array('class'=>'numbers-only','maxchars'=>'20', 'readonly'=>'readonly'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						// $CI->make->input('Cost of Sales','cost_of_sales',iSetObj($item,'cost_of_sales'),'Cost of Sales',array('class'=>'numbers-only','maxchars'=>'20')); //-----TEMPORARILY REMOVED ROKAY
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
			
			//-----LOOP FOR DISCOUNTS
			// $CI->make->sDivCol(4, 'left', 0, array('style'=>'height: 400px; overflow-x: none; overflow-y: scroll;'));
			$CI->make->sDivCol(3);
				$CI->make->H(4,"Discount Details",array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
				$CI->make->sDivRow();
					// $CI->make->sDivCol();
					$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 180px; overflow-x: none; overflow-y: scroll;'));
						$itm_array = $this_vals = $db_prices = $new_items = array();
						$disc_stat = '';
						$itm_array = $CI->inventory_model->get_pos_discount_types();
						if(!empty($item)){
							//-----EDIT MODE
							foreach($itm_array as $this_vals){
								$inputs = $labels = "";
								$labels = $this_vals->description;
								$disc_stat = $CI->inventory_model->is_discount_type_enabled(iSetObj($item,'stock_id'), $this_vals->id);
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',$this_vals->id);
										// $CI->make->yesOrNoNumValDrop(ucwords($this_vals->description).' <---> Stock ID : '.iSetObj($item,'stock_id').' <~~~> POS Stock Discount : '.$this_vals->id,$this_vals->short_desc.'_disc',$disc_stat,'',array('class'=>'formInputSmall'), 0);
										$CI->make->yesOrNoNumValDrop(ucwords($this_vals->description),$this_vals->short_desc.'_disc',$disc_stat,'',array('class'=>'formInputSmall reqForm'), 0);
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
										// $CI->make->yesOrNoNumValDrop(ucwords($this_vals->description),$this_vals->short_desc.'_disc','','',array('class'=>'formInputSmall'), 0);
										$CI->make->yesOrNoNumValDrop(ucwords($this_vals->description),$this_vals->short_desc.'_disc','','',array('class'=>'formInputSmall reqForm'), 0);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
				$add_card_link = $CI->make->A(
						'Add Cards',
							base_url().'inventory/stock_master/',
							array('id'=>'add_card_link','return'=>'true')
						);
				$CI->make->H(4,"Allowed Card Types",array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
				$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
				// $CI->make->sDivRow();
					// $CI->make->sDivCol(12,'right');
						// $CI->make->H(5,$add_card_link,array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
					// $CI->make->eDivCol();
				// $CI->make->eDivRow();
				$CI->make->sDivRow();
					// $CI->make->sDivCol();
						$itm_array = $crd_vals = $db_prices = $new_items = array();
						$is_enabled = '';
						$crd_array = $CI->inventory_model->get_customer_card_types_wo_sukicard();
						$crd_array_sukicard = $CI->inventory_model->get_customer_card_types_w_sukicard();
	
					$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 180px; overflow-x: none; overflow-y: scroll;'));
						if(!empty($item)){
							
							foreach($crd_array_sukicard as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
								$is_enabled = $CI->inventory_model->is_card_type_enabled(iSetObj($item,'stock_id'), $crd_vals->id);
									$CI->make->sDivRow(array('class'=>''));
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',iSetObj($crd_vals,'id'));
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd',$is_enabled,'',array('class'=>'formInputSmall reqForm card_types'), 1);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'right');
								$CI->make->H(5,$add_card_link,array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
							//-----EDIT MODE
							foreach($crd_array as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
								$is_enabled = $CI->inventory_model->is_card_type_enabled(iSetObj($item,'stock_id'), $crd_vals->id);
								$CI->make->sDivRow(array('class'=>'card_type_rows'));
									$CI->make->sDivCol();
										$CI->make->hidden('other_cards',$is_enabled);
										$CI->make->hidden('sales_type_id',$crd_vals->id);
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd',$is_enabled,'',array('class'=>'formInputSmall reqForm card_types'), 0);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}else{
								
							//$CI->make->sDivCol(12, 'left', 0, array('style'=>''));
							foreach($crd_array_sukicard as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
									$CI->make->sDivRow(array('class'=>''));
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',iSetObj($crd_vals,'id'));
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd','','',array('class'=>'formInputSmall reqForm'),1);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						//	$CI->make->eDivCol();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'right');
								$CI->make->H(5,$add_card_link,array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
							
							//-----ADD MODE								
							foreach($crd_array as $crd_vals){
								$inputs = $labels = "";
								$labels = $crd_vals->description;
									$CI->make->sDivRow(array('class'=>'card_type_rows'));
									$CI->make->sDivCol();
										$CI->make->hidden('sales_type_id',iSetObj($crd_vals,'id'));
										$CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd','','',array('class'=>'formInputSmall reqForm'),0);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							}
						}
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			$CI->make->eDivCol();
			
			$CI->make->sDivCol(4);
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
				// $CI->make->H(4,"Cost of Sales",array('style'=>'margin-top:0px;margin-bottom:0px; text-align: left;'));
				// $CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									$CI->make->th('Branch', array('style'=>'width: 20%;'));
									//-----LOOP PRICE TYPES COLUMNS-----START
									$CI->make->th('Cost of Sales', array('style'=>'width: 20%;'));
									//-----LOOP PRICE TYPES COLUMNS-----END
								$CI->make->eRow();
							$CI->make->eTable();
						$CI->make->eDiv();
					$CI->make->eDivCol();
					$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 180px; overflow-x: none; overflow-y: scroll;'));
						$cost_of_sales_amt = $branch_array = $itm_array = $crd_vals = $db_prices = $new_items = array();
						$is_enabled = '';
						$this_priceA = 0;
						$branch_array = $CI->inventory_model->get_active_branches();
						$crd_array = $CI->inventory_model->get_customer_card_types();
						
						foreach($stock_cos as $cost_vals){
							$cost_of_sales_amt[$cost_vals->stock_id][$cost_vals->branch_id] = $cost_vals->cost_of_sales;
							// echo $cost_vals->stock_id."~~".$cost_vals->branch_id."~~".$cost_vals->cost_of_sales."<br>";
						}
						
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));	
							
							foreach($branch_array as $branch_vals){
								$this_priceA = $inpA = "";
								
								if(!empty($item)){
									if(isset($cost_of_sales_amt[$item->stock_id][$branch_vals->id]))
										 $this_priceA = $cost_of_sales_amt[$item->stock_id][$branch_vals->id];
								}
								 
								
								$CI->make->sRow();
									$CI->make->th($branch_vals->code, array('style'=>'width: 20%;'));
									$inpA = "<input type='text' p_barcode='' p_sales_type='' p_branch_id='' name='".$branch_vals->code."_cost_of_sales' id='".$branch_vals->code."_cost_of_sales' value='".$this_priceA."' class='formInputMini branch_type_price num_with_decimal ' ".($this_priceA != '' ? 'readonly=readonly' : '')." style='".($this_priceA != '' ? 'background-color: #eeeeee;' : 'background-color: #ffffff')."'>";
									$CI->make->td($inpA, array('style'=>'width: 20%;'));
								$CI->make->eRow();
							}
							
							$CI->make->eTable();
						$CI->make->eDiv();
						// if(!empty($item)){
							// //-----EDIT MODE
							// foreach($crd_array as $crd_vals){
								// $inputs = $labels = "";
								// $labels = $crd_vals->description;
								// $is_enabled = $CI->inventory_model->is_card_type_enabled(iSetObj($item,'stock_id'), $crd_vals->id);
								// $CI->make->sDivRow();
									// $CI->make->sDivCol();
										// $CI->make->hidden('sales_type_id',$crd_vals->id);
										// $CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd',$is_enabled,'',array('class'=>'formInputSmall'), 0);
									// $CI->make->eDivCol();
								// $CI->make->eDivRow();
							// }
						// }else{
							// //-----ADD MODE
							// foreach($crd_array as $crd_vals){
								// $inputs = $labels = "";
								// $labels = $crd_vals->description;
								// $CI->make->sDivRow();
									// $CI->make->sDivCol();
										// $CI->make->hidden('sales_type_id',iSetObj($crd_vals,'id'));
										// $CI->make->yesOrNoNumValDrop(ucwords($crd_vals->description),$crd_vals->name.'_crd','','',array('class'=>'formInputSmall'), 0);
									// $CI->make->eDivCol();
								// $CI->make->eDivRow();
							// }
						// }
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
				// $CI->make->H(4,"General Ledger Accounts",array('style'=>'margin-top:0px;margin-bottom:0px'));
				// $CI->make->append('<hr style="margin-top:5px;margin-bottom:10px" class="style-one"/>');
				// $CI->make->sDivRow();
					// // $CI->make->sDivCol();
					// $CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 180px; overflow-x: none; overflow-y: scroll;'));
						// $CI->make->accountDrop('Sales Account','sales_account',iSetObj($item,'sales_account'),
							// 'Select Item Sales account',array('class'=>'combobox'));
						// $CI->make->accountDrop('COGS Account','cogs_account',iSetObj($item,'cogs_account'),
							// 'Select COGS account',array('class'=>'combobox'));
						// $CI->make->accountDrop('Inventory Account','inventory_account',iSetObj($item,'inventory_account'),
							// 'Select Inventory account',array('class'=>'combobox'));
						// $CI->make->accountDrop('Adjustment Account','adjustment_account',iSetObj($item,'adjustment_account'),
							// 'Select Adjustment account',array('class'=>'combobox'));
						// $CI->make->accountDrop('Assembly Cost Account','assembly_cost_account',iSetObj($item,'assembly_cost_account'),
							// 'Select Assembly Cost account',array('class'=>'combobox'));
					// $CI->make->eDivCol();
				// $CI->make->eDivRow();
			// $CI->make->eDivCol();
	
		$CI->make->eDivRow();
	$CI->make->eForm();
	$CI->make->sDivRow(array('style'=>'margin:10px;'));
		$CI->make->sDivCol(6);
			$CI->make->sDivCol(6);
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
				if(!empty($item)){
				$CI->make->button(fa('fa-trash-o').'Delete Stock',array('id'=>'inactive-stock-btn','class'=>'btn-block'),'danger');
				}
			$CI->make->eDivCol();
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-save').' Save stock details',array('id'=>'save-stock-btn','class'=>'btn-block'),'primary');
		$CI->make->eDivCol();
		$CI->make->sDivCol(3);
			$CI->make->button(fa('fa-reply').' Return to Stock Master',array('id'=>'stock-back-btn','class'=>'btn-block'),'default');
		$CI->make->eDivCol();
    $CI->make->eDivRow();

	return $CI->make->code();
}
//-----------Product Listing Maker-----end-----allyn
//-----------Barcode Form Maker-----start-----allyn
/*
#ORIGINAL FUNCTION FOR ALL SALES TYPE - 07 07 2015 09 09 AM
function build_stock_barcode_form($item=array(), $ref='')
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/stock_barcode_db",array('id'=>'stock_barcode_form'));
		$CI->make->hidden('id',iSetObj($item,'stock_id'));
		// $CI->make->hidden('hidden_stock_id',iSetObj($item,'id')); //-----orig
		$CI->make->hidden('hidden_stock_id',($ref != '' ? $ref : ''));
		// $CI->make->hidden('mode',((iSetObj($item,'id')) ? 'edit' : 'add'));
		$CI->make->hidden('mode','add', array('class'=>'form_mode'));
		
		$CI->make->sDivRow();
			//----STOCK LIST-----START
			$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'file-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('warning',array('div-form'));
								$CI->make->sBoxBody(array('style'=>'height: 240px;'));
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array("style"=>'margin-top:70px; margin-bottom:5px;'));
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('id'=>'init-contents', 'style'=>''));
						// $CI->make->sDivCol(12,'center',0,array("style"=>'padding-left: 0px; padding-right: 0px;')); //-----orig
						$CI->make->sDivCol(12,'center',0,array("style"=>''));
							$CI->make->sBox('warning',array('div-form'));
								$CI->make->sBoxBody(array('style'=>''));
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->sDiv(array('class'=>'table-responsive'));
												$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
													$CI->make->sRow();
														$CI->make->th('Barcode');
														$CI->make->th('Description',array('style'=>''));
														$CI->make->th('Report UOM',array('style'=>''));
														$CI->make->th('Report Qty',array('style'=>''));
														$CI->make->th('Retail Price',array('style'=>''));
														$CI->make->th('Wholesale Price',array('style'=>''));
													$CI->make->eRow();
													$CI->make->sRow();
														$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
													$CI->make->eRow();
												$CI->make->eTable();
											$CI->make->eDiv();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('id'=>'stock-barcode-contents', 'style'=>'height: 130px; width: 100%; overflow-x: none; overflow-y: scroll;'));
					$CI->make->eDiv();
				//-----PRELOADER-----END
				$CI->make->eDivRow();	
			$CI->make->eDivCol();
			//----STOCK LIST-----END
			
			//-----ADDER FORM-----START
			$CI->make->sDivCol(12);
				$CI->make->sBox('danger');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(6);
								$CI->make->H(4,"Stock Barcode Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
								
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->hidden('ids','');
										$CI->make->input('Stock','stock_id','[ '.iSetObj($item,'stock_code').' ] '.iSetObj($item,'description'),'Type Barcode',array('class'=>'rOkay', 'readonly'=>''));
										$CI->make->hidden('stock_id',iSetObj($item,'stock_id'));
										$CI->make->hidden('barcode_stock_id',iSetObj($item,'stock_id'));
										$CI->make->hidden('hidden_barcode','');
										$CI->make->hidden('barcode_mode','add');
										$CI->make->hidden('short_desc_old','');
										$CI->make->hidden('desc_old','');
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// $CI->make->input('Barcode','barcode',iSetObj($item,'barcode'),'Type Barcode',array('class'=>'rOkay')); #OLD
										$CI->make->input('Barcode','barcode','','Type Barcode',array('class'=>'rOkay'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										// $CI->make->input('Confirm Barcode','con_barcode',iSetObj($item,'barcode'),'Type Barcode',array('class'=>'rOkay')); #OLD
										$CI->make->input('Confirm Barcode','con_barcode','','Type Barcode',array('class'=>'rOkay'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
										// $CI->make->input('Short Description','short_desc',iSetObj($item,'short_desc'),'Type Short Description',array('class'=>'rOkay barcode_short_desc'));  #OLD
										$CI->make->input('Short Description','short_desc','','Type Short Description',array('class'=>'rOkay barcode_short_desc required_form', 'old_val'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(8);
										// $CI->make->input('Description','description',iSetObj($item,'description'),'Type Description',array('class'=>'rOkay barcode_desc'));  #OLD
										$CI->make->input('Description','description','','Type Description',array('class'=>'rOkay barcode_desc required_form', 'old_val'=>''));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// $CI->make->stockUOMCodeDrop('UOM','uom',iSetObj($item,'uom'),'Select UOM',array('class'=>'rOkay combobox uom_dropdown'));  #OLD
										$CI->make->stockUOMCodeDrop('UOM','uom','','Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										// $CI->make->input('Quantity','qty',iSetObj($item,'qty'),'Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));  #OLD
										$CI->make->input('Quantity','qty','','Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// // $CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'barcode_inactive_dropdown'));  #OLD
										// $CI->make->inactiveDrop('Is Inactive','inactive','',null,array('class'=>'barcode_inactive_dropdown')); //TEMPORARILY DISABLED [07062015 0141PM]
										// $CI->make->activeSalesTypeDrop('Sales Type','sales_type_id','',null,array('class'=>'sales_type_dropdown')); //-----Displays TEXT value while form value is equal to ID
										$CI->make->activeSalesTypeTextDrop('Sales Type','sales_type_id','',null,array('class'=>'sales_type_dropdown')); //-----Both Text and form value are equal to desc
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								
							$CI->make->eDivCol();
							
							$CI->make->sDivCol(6);
								$CI->make->sDiv(array('id'=>'pricing_def'));
									//-----LOAD PRICING LOOP HERE-----START
										$CI->make->sDivRow();
											$CI->make->sDivCol(6,'left');
												$CI->make->H(4,"Pricing Details [ADD MODE]",array('style'=>'margin-top:0px;margin-bottom:0px;'));
											$CI->make->eDivCol();
											$CI->make->sDivCol(6,'right');
												// $copy_link;
												$CI->make->A(fa('fa-copy fa-lg fa-fw'),base_url().'inventory/items_maintenance/new',array('class'=>'copy_link', 'title'=>'Click to copy value(s) of first row to all remaining rows'));
											$CI->make->eDivCol();
										$CI->make->eDivRow();
										$CI->make->sDivRow();
											$CI->make->sDivCol();
												$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
											$CI->make->eDivCol();
										$CI->make->eDivRow();
											
										//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----START
										$CI->make->sDivRow(array('style'=>'margin-bottom: 15px;'));
											$CI->make->sDivCol();
												$CI->make->sDiv(array('class'=>'table-responsive'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
														$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
															$CI->make->th('Branch', array('style'=>'width: 35%;'));
															//-----LOOP PRICE TYPES COLUMNS-----START
																$itm_array = $this_vals = $db_prices = array();
																$itm_array = $CI->inventory_model->get_sales_types();
																foreach($itm_array as $this_vals){
																	$CI->make->th(ucwords($this_vals->sales_type),array('style'=>'width: 20%;'));
																	// $CI->make->th('&nbsp;', array('style'=>'width: 25%;')); //---temporarily disabled pag ADD palang ng price
																}
															//-----LOOP PRICE TYPES COLUMNS-----END
														$CI->make->eRow();
													$CI->make->eTable();
												$CI->make->eDiv();
											$CI->make->eDivCol();
											
											//-----ADD
											$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
												$CI->make->sDiv(array('class'=>'table-responsive'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
															$br_array = $st_array = array();
															$st_array = $CI->inventory_model->get_sales_types();
															$br_array = $CI->inventory_model->get_active_branches();
															// $price_link = "";
															$counter = 1;
															foreach($br_array as $br_vals){
																$CI->make->sRow();
																	$CI->make->td($br_vals->code, array('style'=>'width: 35%;'));
																	$CI->make->hidden('branch_id',$br_vals->id);
																foreach($st_array as $st_vals){
																	$copy_link = $price_link = $inp = "";
																	$inp = "<input type='text' name='".$br_vals->code."_".$st_vals->sales_type."_price' id='".$br_vals->code."_".$st_vals->sales_type."_price' class='formInputMini branch_type_price num_with_decimal countme_$counter ".($counter % 2 == 0 ? 'even_num' : 'odd_num')."'>";
																	$CI->make->hidden($br_vals->code.'_'.$st_vals->sales_type.'_price_old','');
																	$price_link = $CI->make->A(
																		fa('fa-tag fa-lg fa-fw'),
																		base_url().'inventory/stock_master/',
																		array('class'=>'price_link',
																			'ref_br_id'=>$br_vals->id,
																			'title'=>strtoupper($st_vals->sales_type).' SRP for '.strtoupper($br_vals->code),
																			'return'=>'false'));
																	$copy_link = $CI->make->A(
																		fa('fa-copy fa-lg fa-fw'),
																		base_url().'inventory/stock_master/',
																		array('class'=>'copy_link',
																			'ref_br_id'=>$br_vals->id,
																			'title'=>strtoupper($st_vals->sales_type).' SRP for '.strtoupper($br_vals->code),
																			'return'=>'false'));
																	$CI->make->td($inp, array('style'=>'width: 20%;'));
																	// $CI->make->td($copy_link, array( 'style'=>'width: 25%;')); //---temporarily disabled pag ADD palang ng price
																	// $CI->make->td($price_link, array( 'style'=>'width: 25%;')); //---temporarily disabled pag ADD palang ng price
																	$counter++;
																}
																$CI->make->eRow();
															}
													$CI->make->eTable();
												$CI->make->eDiv();
											$CI->make->eDivCol();
									
										$CI->make->eDivRow();
										//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----END
									//-----LOAD PRICING LOOP HERE-----END
								$CI->make->eDiv();
								$CI->make->sDiv(array('id'=>'new_pricing_def', 'style'=>'display: none;'));
								$CI->make->eDiv();
							$CI->make->eDivCol();
							
							$CI->make->sDivCol();
								//-----LOAD BUTTONS FOR SAVING/CANCELLING STOCK BARCODE DETAILS TRX
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
										// $CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'barcode_inactive_dropdown'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->button(fa('fa-save').' Save',array('id'=>'save-barcode-btn','class'=>'btn-block', 'style'=>'margin-top: 20px;'),'primary');
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->button(fa('fa-reply').' Return to Main',array('id'=>'back-barcode-btn','class'=>'btn-block', 'style'=>'margin-top: 20px;'),'default');
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
							
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			//-----ADDER FORM-----END

		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
*/
function build_stock_barcode_form($item=array(), $ref='')
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/stock_barcode_db",array('id'=>'stock_barcode_form'));
		$CI->make->hidden('id',iSetObj($item,'stock_id'));
		// $CI->make->hidden('hidden_stock_id',iSetObj($item,'id')); //-----orig
		$CI->make->hidden('hidden_stock_id',($ref != '' ? $ref : ''));
		// $CI->make->hidden('mode',((iSetObj($item,'id')) ? 'edit' : 'add'));
		$CI->make->hidden('mode','add', array('class'=>'form_mode'));
		
		$CI->make->sDivRow();
			//----STOCK LIST-----START
			$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'file-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('warning',array('div-form'));
								$CI->make->sBoxBody(array('style'=>'height: 240px;'));
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array("style"=>'margin-top:70px; margin-bottom:5px;'));
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('id'=>'init-contents', 'style'=>''));
						// $CI->make->sDivCol(12,'center',0,array("style"=>'padding-left: 0px; padding-right: 0px;')); //-----orig
						$CI->make->sDivCol(12,'center',0,array("style"=>''));
							$CI->make->sBox('warning',array('div-form'));
								$CI->make->sBoxBody(array('style'=>''));
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->sDiv(array('class'=>'table-responsive'));
												$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
													$CI->make->sRow();
														$CI->make->th('Barcode');
														$CI->make->th('Description',array('style'=>''));
														$CI->make->th('Report UOM',array('style'=>''));
														$CI->make->th('Report Qty',array('style'=>''));
														$CI->make->th('Retail Price',array('style'=>''));
														$CI->make->th('Wholesale Price',array('style'=>''));
													$CI->make->eRow();
													$CI->make->sRow();
														$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
													$CI->make->eRow();
												$CI->make->eTable();
											$CI->make->eDiv();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('id'=>'stock-barcode-contents', 'style'=>'height: 200px; width: 100%; overflow-x: none; overflow-y: scroll;'));
					$CI->make->eDiv();
				//-----PRELOADER-----END
				$CI->make->eDivRow();	
			$CI->make->eDivCol();
			//----STOCK LIST-----END
			
			//-----ADDER FORM-----START
			$CI->make->sDivCol(12);
				$CI->make->sBox('danger');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(8);
								$CI->make->H(4,"Stock Barcode Details",array('style'=>'margin-top:0px;margin-bottom:0px'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
								
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->hidden('ids','');
										$CI->make->input('Stock','stock_id','[ '.iSetObj($item,'stock_code').' ] '.iSetObj($item,'description'),'Type Barcode',array('class'=>'rOkay', 'readonly'=>''));
										$CI->make->hidden('stock_id',iSetObj($item,'stock_id'));
										$CI->make->hidden('barcode_stock_id',iSetObj($item,'stock_id'));
										$CI->make->hidden('hidden_barcode','');
										$CI->make->hidden('barcode_mode','add');
										$CI->make->hidden('short_desc_old','');
										$CI->make->hidden('desc_old','');
										$CI->make->hidden('hidden_sales_type','');
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// $CI->make->input('Barcode','barcode',iSetObj($item,'barcode'),'Type Barcode',array('class'=>'rOkay')); #OLD
										$CI->make->input('Barcode','barcode','','Type Barcode',array('class'=>'rOkay'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										// $CI->make->input('Confirm Barcode','con_barcode',iSetObj($item,'barcode'),'Type Barcode',array('class'=>'rOkay')); #OLD
										$CI->make->input('Confirm Barcode','con_barcode','','Type Barcode',array('class'=>'rOkay'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
										// $CI->make->input('Short Description','short_desc',iSetObj($item,'short_desc'),'Type Short Description',array('class'=>'rOkay barcode_short_desc'));  #OLD
										$CI->make->input('Short Description','short_desc','','Type Short Description',array('class'=>'rOkay barcode_short_desc required_form', 'old_val'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(8);
										// $CI->make->input('Description','description',iSetObj($item,'description'),'Type Description',array('class'=>'rOkay barcode_desc'));  #OLD
										$CI->make->input('Description','description','','Type Description',array('class'=>'rOkay barcode_desc required_form', 'old_val'=>''));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// $CI->make->stockUOMCodeDrop('UOM','uom',iSetObj($item,'uom'),'Select UOM',array('class'=>'rOkay combobox uom_dropdown'));  #OLD
										$CI->make->stockUOMCodeDrop('UOM','uom','','Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										// $CI->make->input('Quantity','qty',iSetObj($item,'qty'),'Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));  #OLD
										$CI->make->input('Quantity','qty','','Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// // $CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>'barcode_inactive_dropdown'));  #OLD
										// $CI->make->inactiveDrop('Is Inactive','inactive','',null,array('class'=>'barcode_inactive_dropdown')); //TEMPORARILY DISABLED [07062015 0141PM]
										$CI->make->activeSalesTypeDrop('Sales Type','sales_type_id','',null,array('class'=>'sales_type_dropdown')); //-----Displays TEXT value while form value is equal to ID
										// $CI->make->activeSalesTypeTextDrop('Sales Type','sales_type_id','',null,array('class'=>'sales_type_dropdown')); //-----Both Text and form value are equal to desc
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
								
							$CI->make->eDivCol();
							
							$CI->make->sDivCol(4);
								$CI->make->sDiv(array('id'=>'pricing_def'));
									//-----LOAD PRICING LOOP HERE-----START
										$CI->make->sDivRow();
											$CI->make->sDivCol(6,'left');
												$CI->make->H(4,"Pricing Details",array('style'=>'margin-top:0px;margin-bottom:0px;'));
											$CI->make->eDivCol();
											$CI->make->sDivCol(6,'right');
												// $copy_link;
												// $CI->make->A(fa('fa-copy fa-lg fa-fw'),'',array('class'=>'copy_link', 'title'=>'Click to copy value(s) of first row to all remaining rows'));
												// $CI->make->A(fa('fa-copy fa-lg fa-fw'),base_url().'inventory/stock_master/',array('id'=>'copier_link', 'title'=>'Click to copy value(s) of first row to all remaining rows'));
												$CI->make->A(fa('fa-copy fa-lg fa-fw'),base_url().'inventory/stock_master/',array('id'=>'copier_link', 'title'=>'Click to copy'));
												$CI->make->A('&nbsp;&nbsp;&nbsp;'.fa('fa-refresh fa-lg fa-fw'),base_url().'inventory/stock_master/',array('id'=>'clear_link', 'title'=>'Click to clear price fields'));
											$CI->make->eDivCol();
										$CI->make->eDivRow();
										$CI->make->sDivRow();
											$CI->make->sDivCol();
												$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
											$CI->make->eDivCol();
										$CI->make->eDivRow();
											
										//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----START
										$CI->make->sDivRow(array('style'=>'margin-bottom: 15px;'));
											$CI->make->sDivCol();
												$CI->make->sDiv(array('class'=>'table-responsive'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
														$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
															$CI->make->th('Branch', array('style'=>'width: 35%;'));
															// //-----LOOP PRICE TYPES COLUMNS-----START
																// $itm_array = $this_vals = $db_prices = array();
																// $itm_array = $CI->inventory_model->get_sales_types();
																// foreach($itm_array as $this_vals){
																	// $CI->make->th(ucwords($this_vals->sales_type),array('style'=>'width: 20%;'));
																	// // $CI->make->th('&nbsp;', array('style'=>'width: 25%;')); //---temporarily disabled pag ADD palang ng price
																// }
															// //-----LOOP PRICE TYPES COLUMNS-----END
														$CI->make->eRow();
													$CI->make->eTable();
												$CI->make->eDiv();
											$CI->make->eDivCol();
											
											//-----ADD
											$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
												$CI->make->sDiv(array('class'=>'table-responsive'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
															$br_array = $st_array = array();
															$st_array = $CI->inventory_model->get_sales_types();
															$br_array = $CI->inventory_model->get_active_branches();
															$counter = 1;
															foreach($br_array as $br_vals){
																$CI->make->sRow();
																	$CI->make->td($br_vals->code, array('style'=>'width: 35%;'));
																	$CI->make->hidden('branch_id',$br_vals->id);
																// foreach($st_array as $st_vals){ //-----TEMP
																	$copy_link = $price_link = $inp = "";
																	// $inp = "<input type='text' name='".$br_vals->code."_".$st_vals->sales_type."_price' id='".$br_vals->code."_".$st_vals->sales_type."_price' class='formInputMini branch_type_price num_with_decimal countme_$counter ".($counter % 2 == 0 ? 'even_num' : 'odd_num')."'>"; //-----TEMP
																	// $CI->make->hidden($br_vals->code.'_'.$st_vals->sales_type.'_price_old',''); //-----TEMP
																	$inp = "<input type='text' name='".$br_vals->code."_price' id='".$br_vals->code."_price' class='formInputMini branch_type_price num_with_decimal countme_$counter ".($counter == 1 ? 'first_row' : 'following_row')."'>"; //-----NOTE: THIS IS EDITING IN PRICE
																	$CI->make->hidden($br_vals->code.'_price_old','');
																	// $price_link = $CI->make->A(
																		// fa('fa-tag fa-lg fa-fw'),
																		// base_url().'inventory/stock_master/',
																		// array('class'=>'price_link',
																			// 'ref_br_id'=>$br_vals->id,
																			// 'title'=>strtoupper($st_vals->sales_type).' SRP for '.strtoupper($br_vals->code),
																			// 'return'=>'false')); //-----TEMP
																	// $copy_link = $CI->make->A(
																		// fa('fa-copy fa-lg fa-fw'),
																		// base_url().'inventory/stock_master/',
																		// array('class'=>'copy_link',
																			// 'ref_br_id'=>$br_vals->id,
																			// 'title'=>'SRP for '.strtoupper($br_vals->code),
																			// 'return'=>'false')); //-----TEMP
																	$CI->make->td($inp, array('style'=>'width: 20%;'));
																	$counter++;
																// } //-----TEMP
																$CI->make->eRow();
															}
													$CI->make->eTable();
												$CI->make->eDiv();
											$CI->make->eDivCol();
									
										$CI->make->eDivRow();
										//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----END
									//-----LOAD PRICING LOOP HERE-----END
								$CI->make->eDiv();
								$CI->make->sDiv(array('id'=>'new_pricing_def', 'style'=>'display: none;'));
								$CI->make->eDiv();
							$CI->make->eDivCol();
							
								$CI->make->sDivCol();
								//-----LOAD BUTTONS FOR SAVING/CANCELLING STOCK BARCODE DETAILS TRX
								$CI->make->hidden('for_markup_branch','');
								$CI->make->hidden('hidden_avg_net_cost','');
								$CI->make->hidden('hidden_srp_qty','');
								$CI->make->sDivRow();
									$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
									$CI->make->sDivCol(3);
										$CI->make->input('Computed SRP','computed_srp','','',array('class'=>'num_with_decimal  required_form', 'readonly'=>'readonly','old_val'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
										$CI->make->input('Prevailing Unit Price','prevailing_unit_price','','',array('class'=>'num_with_decimal  required_form ','readonly'=>'readonly','old_val'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(2);
										$CI->make->input('Landed Cost Markup','landed_cost_markup','','',array('class'=>'num_with_decimal  required_form','readonly'=>'readonly','old_val'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(2);
										//-----TEMPORARILY HIDDEN-----as per Enjo 09102015
										// $CI->make->input('Cost of Sales Markup','cost_of_sales_markup','','',array('class'=>'num_with_decimal  required_form','readonly'=>'readonly','old_val'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(2);
										$CI->make->A('Save To All Branch','',array('id'=>'save-all-branch-btn','class'=>'btn btn-primary','style'=>'margin-top: 25px;','disabled'=>'disabled'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
									$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px;" class="style-one"/>');
							$CI->make->eDivCol();
							
							
							$CI->make->sDivCol();
								//-----LOAD BUTTONS FOR SAVING/CANCELLING STOCK BARCODE DETAILS TRX
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->button(fa('fa-save').' Save',array('id'=>'save-barcode-btn','class'=>'btn-block', 'style'=>'margin-top: 20px;'),'primary');
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->button(fa('fa-reply').' Return to Main',array('id'=>'back-barcode-btn','class'=>'btn-block', 'style'=>'margin-top: 20px;'),'default');
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
							
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			//-----ADDER FORM-----END

		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function build_stock_barcode_price_list($barcode=null){
$CI =& get_instance();	
	$barcode_prices = array();
	$this_stock_id = "";
	$barcode_prices = $CI->inventory_model->get_stock_barcode_prices($barcode); //-----ORIGINAL
	// echo $CI->inventory_model->db->last_query()."<br>";
	// $barcode_prices = $CI->inventory_model->get_complete_stock_barcode_prices($barcode);
	// echo var_dump($barcode_prices);
	
	//-----LOAD PRICING LOOP HERE-----START
		// $itm_array = $this_vals = $db_prices = array();
		// $itm_array = $CI->inventory_model->get_sales_types();
		$CI->make->H(4,"Pricing Details",array('style'=>'margin-top:0px;margin-bottom:0px;'));
		$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
	//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----START
	$CI->make->sDivRow(array('style'=>'margin-bottom: 15px;'));
		$CI->make->sDivCol();
			$CI->make->sDiv(array('class'=>'table-responsive'));
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
						$CI->make->th('Branch', array('style'=>'width: 20%;'));
						// //-----LOOP PRICE TYPES COLUMNS-----START
							// $itm_array = $this_vals = $db_prices = array();
							// $itm_array = $CI->inventory_model->get_sales_types();
							// foreach($itm_array as $this_vals){
								// $CI->make->th(ucwords($this_vals->sales_type),array('style'=>'width: 20%; text-align: right;'));
								// $CI->make->th('&nbsp;', array('style'=>'width: 20%;'));
							// }
						// //-----LOOP PRICE TYPES COLUMNS-----END
					$CI->make->eRow();
				$CI->make->eTable();
			$CI->make->eDiv();
		$CI->make->eDivCol();
		
			//-----EDIT
			$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
				$CI->make->sDiv(array('class'=>'table-responsive'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
							$this_price = $this_computed_srp =  $this_prevailing_unit_price = $this_landed_cost_markup = $this_cost_of_sales_markup =  0;
							$pk_id = $cur_avg_net_cost = $cur_cos_mup = '';
							$bp_prices = $br_array = $st_array = $bp_computed_srp = $bp_prevailing_unit_price = $bp_landed_cost_markup = $bp_cost_of_sales_markup = array();
							$st_array = $CI->inventory_model->get_sales_types();
							$br_array = $CI->inventory_model->get_active_branches();
							
							foreach($barcode_prices as $bp_vals){
								$bp_prices[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->price;
								$bp_computed_srp[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->computed_srp;
								$bp_prevailing_unit_price[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->prevailing_unit_price;
								$bp_landed_cost_markup[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->landed_cost_markup;
								$bp_cost_of_sales_markup[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->cost_of_sales_markup;
							}
							
							foreach($br_array as $br_vals){
								$CI->make->sRow();
									$CI->make->th($br_vals->code, array('style'=>'width: 20%;'));
									$CI->make->hidden('hidden_branch_id',$br_vals->id, array('class'=>'hidden_branch_id_'+$br_vals->id));
								// foreach($st_array as $st_vals){ //-----TEMP
									$this_array = array();
									$st_cost_of_sales = "";
									$pk_id = $this_price = $price_link = $inp = "";
									
									//prices
									if(isset($bp_prices[$br_vals->id][$bp_vals->sales_type_id]))
										$this_price = $bp_prices[$br_vals->id][$bp_vals->sales_type_id];
									
									//computed_srp
									if(isset($bp_computed_srp[$br_vals->id][$bp_vals->sales_type_id]))
										$this_computed_srp = $bp_computed_srp[$br_vals->id][$bp_vals->sales_type_id];
									
									//prevailing_unit_price 
									if(isset($bp_prevailing_unit_price[$br_vals->id][$bp_vals->sales_type_id]))
										$this_prevailing_unit_price = $bp_prevailing_unit_price[$br_vals->id][$bp_vals->sales_type_id];
									
									//landed_cost_markup	
									if(isset($bp_landed_cost_markup[$br_vals->id][$bp_vals->sales_type_id]))
									    $this_landed_cost_markup = $bp_landed_cost_markup[$br_vals->id][$bp_vals->sales_type_id];
								
									//cost_of_sales_markup
									if(isset($bp_cost_of_sales_markup[$br_vals->id][$bp_vals->sales_type_id]))
									    $this_cost_of_sales_markup = $bp_cost_of_sales_markup[$br_vals->id][$bp_vals->sales_type_id];
									
									// $pk_id = $CI->inventory_model->get_stock_barcode_prices_pk_id($bp_vals->barcode, $br_vals->id, $st_vals->id);
									$this_array = $CI->inventory_model->get_stock_cost_details($bp_vals->stock_id, $br_vals->id);
									// echo $CI->inventory_model->db->last_query()."<br>";
									
									$st_cost_of_sales = $CI->inventory_model->get_branch_stock_cost_of_sales($bp_vals->stock_id, $br_vals->id);
									if(!empty($this_array)){
										$cur_avg_net_cost = $this_array[0]->avg_net_cost;
										$cur_net_cost = $this_array[0]->net_cost;
									}else{
										$cur_avg_net_cost = '';
										$cur_net_cost = '';
									}
									
									if($st_cost_of_sales != ''){
										$cur_cost_of_sales = $st_cost_of_sales;
									}else{
										$cur_cost_of_sales = '';
									}
									
									$price_link .= $CI->make->A(
													fa('fa-tag fa-lg fa-fw'),
													'',
													array('class'=>'price_link',
														'ref_br_id'=>$br_vals->id,
														'ref_br_code'=>$CI->inventory_model->get_branch_code($br_vals->id),
														'ref_desc'=>$bp_vals->description,
														'computed_srp'=>$this_computed_srp,
														'prevailing_unit_price'=>$this_prevailing_unit_price,
														'landed_cost_markup'=>$this_landed_cost_markup,
														'cost_of_sales_markup'=>$this_cost_of_sales_markup,
														'ref_stock_id'=>$bp_vals->stock_id,
														'ref_barcode'=>$bp_vals->barcode,
														'ref_sales_type_id'=>$bp_vals->sales_type_id,
														'ref_uom'=>$bp_vals->uom,
														'ref_qty'=>$bp_vals->qty,
														'ref_price'=>$this_price,
														'ref_avg_net_cost'=>$cur_avg_net_cost,
														'ref_cost_of_sales'=>$cur_cost_of_sales,
														'return'=>'false'));
														
									$price_link .= $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-calendar fa-lg fa-fw'),
													base_url().'inventory/stock_master/',
													array('class'=>'sched_markdown_link',
														'ref_br_id'=>$br_vals->id,
														'ref_desc'=>$bp_vals->description,
														'ref_stock_id'=>$bp_vals->stock_id,
														'ref_barcode'=>$bp_vals->barcode,
														// 'ref_sales_type_id'=>$st_vals->id,
														'ref_sales_type_id'=>$bp_vals->sales_type_id,
														'ref_uom'=>$bp_vals->uom,
														'ref_qty'=>$bp_vals->qty,
														'ref_price'=>$this_price,
														// 'title'=>'Scheduled Price Markdown for '.strtoupper($br_vals->code).' ( '.strtoupper($st_vals->sales_type).' )',
														'title'=>'Scheduled Price Markdown for '.strtoupper($br_vals->code).' ',
														'return'=>'false'));
														
								$price_link .= $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-line-chart fa-lg fa-fw'),
													base_url().'inventory/stock_master/',
													array('class'=>'marginal_markdown_link',
														'ref_br_id'=>$br_vals->id,
														'ref_desc'=>$bp_vals->description,
														'ref_stock_id'=>$bp_vals->stock_id,
														'ref_barcode'=>$bp_vals->barcode,
														'ref_sales_type_id'=>$bp_vals->sales_type_id,
														'ref_uom'=>$bp_vals->uom,
														'ref_qty'=>$bp_vals->qty,
														'ref_price'=>$this_price,
														'landed_cost'=>$cur_net_cost,
														'title'=>'Marginal Price Setup for '.strtoupper($br_vals->code).' ',
														'return'=>'false'));					
									
									// $inp = "<input type='text' p_barcode='' p_sales_type='' p_branch_id='' name='".$br_vals->code."_".$st_vals->sales_type."_price' id='".$br_vals->code."_".$st_vals->sales_type."_price' value='".$this_price."' class='formInputMini branch_type_price num_with_decimal ".$st_vals->sales_type."_tbox '>"; //-----TEMP
									$inp = "<input type='text' p_barcode='' p_sales_type='' p_branch_id='' name='".$br_vals->code."_price' id='".$br_vals->code."_price' old_val='".$this_price."' value='".$this_price."' class='formInputMini branch_type_price num_with_decimal required_form' readonly>";
									$CI->make->td($inp, array('style'=>'width: 20%;'));
									$CI->make->td($price_link, array( 'style'=>'width: 20%;'));
								// } //-----TEMP
								$CI->make->eRow();
							}
					$CI->make->eTable();
				$CI->make->eDiv();
			$CI->make->eDivCol();

	$CI->make->eDivRow();
	//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----END
//-----LOAD PRICING LOOP HERE-----END
return $CI->make->code();
}
//-#ORIGINAL WORKING FUNCTION - 07062015 02 12 PM
/*
function build_stock_barcode_price_list($barcode=null){
$CI =& get_instance();	
	$barcode_prices = array();
	$this_stock_id = "";
	$barcode_prices = $CI->inventory_model->get_stock_barcode_prices($barcode); //-----ORIGINAL
	// $barcode_prices = $CI->inventory_model->get_complete_stock_barcode_prices($barcode);
	// echo var_dump($barcode_prices);
	
	//-----LOAD PRICING LOOP HERE-----START
		// $itm_array = $this_vals = $db_prices = array();
		// $itm_array = $CI->inventory_model->get_sales_types();
		$CI->make->H(4,"Pricing Details",array('style'=>'margin-top:0px;margin-bottom:0px;'));
		$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');

	//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----START
	$CI->make->sDivRow(array('style'=>'margin-bottom: 15px;'));
		$CI->make->sDivCol();
			$CI->make->sDiv(array('class'=>'table-responsive'));
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
						$CI->make->th('Branch', array('style'=>'width: 20%;'));
						//-----LOOP PRICE TYPES COLUMNS-----START
							$itm_array = $this_vals = $db_prices = array();
							$itm_array = $CI->inventory_model->get_sales_types();
							foreach($itm_array as $this_vals){
								$CI->make->th(ucwords($this_vals->sales_type),array('style'=>'width: 20%; text-align: right;'));
								$CI->make->th('&nbsp;', array('style'=>'width: 20%;'));
							}
						//-----LOOP PRICE TYPES COLUMNS-----END
					$CI->make->eRow();
				$CI->make->eTable();
			$CI->make->eDiv();
		$CI->make->eDivCol();
		
			//-----EDIT
			$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
				$CI->make->sDiv(array('class'=>'table-responsive'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
							$this_price = 0;
							$pk_id = $cur_avg_net_cost = $cur_cos_mup = '';
							$bp_prices = $br_array = $st_array = array();
							$st_array = $CI->inventory_model->get_sales_types();
							$br_array = $CI->inventory_model->get_active_branches();
							

							foreach($barcode_prices as $bp_vals){
								$bp_prices[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->price;
							}
							
							foreach($br_array as $br_vals){
								$CI->make->sRow();
									$CI->make->th($br_vals->code, array('style'=>'width: 20%;'));
									$CI->make->hidden('hidden_branch_id',$br_vals->id, array('class'=>'hidden_branch_id_'+$br_vals->id));
								foreach($st_array as $st_vals){
									$this_array = array();
									$st_cost_of_sales = "";
									$pk_id = $this_price = $price_link = $inp = "";
									// $CI->make->hidden('hidden_sales_type_id',$st_vals->id, array('class'=>'hidden_sales_type_id_'+$st_vals->id));
									// $this_price = $CI->inventory_model->price_per_sales_type_and_branch('4810012002', $st_vals->id, $br_vals->id);
									if(isset($bp_prices[$br_vals->id][$st_vals->id]))
									 $this_price = $bp_prices[$br_vals->id][$st_vals->id];
									
									$pk_id = $CI->inventory_model->get_stock_barcode_prices_pk_id($bp_vals->barcode, $br_vals->id, $st_vals->id);
									$this_array = $CI->inventory_model->get_stock_cost_details($bp_vals->stock_id, $br_vals->id);
									// echo $CI->inventory_model->db->last_query()."<br>";
									$st_cost_of_sales = $CI->inventory_model->get_branch_stock_cost_of_sales($bp_vals->stock_id, $br_vals->id);
									if(!empty($this_array)){
										$cur_avg_net_cost = $this_array[0]->avg_net_cost;
									}else{
										$cur_avg_net_cost = '';
									}
									
									if($st_cost_of_sales != ''){
										$cur_cost_of_sales = $st_cost_of_sales;
									}else{
										$cur_cost_of_sales = '';
									}
									
									$price_link = $CI->make->A(
													fa('fa-tag fa-lg fa-fw'),
													base_url().'inventory/stock_master/',
													array('class'=>'price_link',
														'ref_pk_id'=>$pk_id,
														'ref_br_id'=>$br_vals->id,
														'ref_desc'=>$bp_vals->description,
														'ref_stock_id'=>$bp_vals->stock_id,
														'ref_barcode'=>$bp_vals->barcode,
														'ref_sales_type_id'=>$st_vals->id,
														'ref_uom'=>$bp_vals->uom,
														'ref_qty'=>$bp_vals->qty,
														'ref_price'=>$this_price,
														'ref_avg_net_cost'=>$cur_avg_net_cost,
														'ref_cost_of_sales'=>$cur_cost_of_sales,
														'title'=>strtoupper($st_vals->sales_type).' SRP for '.strtoupper($br_vals->code),
														'return'=>'false'));
									$price_link .= $CI->make->A(
													'&nbsp;&nbsp;'.fa('fa-calendar fa-lg fa-fw'),
													base_url().'inventory/stock_master/',
													array('class'=>'sched_markdown_link',
														'ref_br_id'=>$br_vals->id,
														'ref_desc'=>$bp_vals->description,
														'ref_stock_id'=>$bp_vals->stock_id,
														'ref_barcode'=>$bp_vals->barcode,
														'ref_sales_type_id'=>$st_vals->id,
														'ref_uom'=>$bp_vals->uom,
														'ref_qty'=>$bp_vals->qty,
														'ref_price'=>$this_price,
														'title'=>'Scheduled Price Markdown for '.strtoupper($br_vals->code).' ( '.strtoupper($st_vals->sales_type).' )',
														'return'=>'false'));
									
									$inp = "<input type='text' p_barcode='' p_sales_type='' p_branch_id='' name='".$br_vals->code."_".$st_vals->sales_type."_price' id='".$br_vals->code."_".$st_vals->sales_type."_price' value='".$this_price."' class='formInputMini branch_type_price num_with_decimal'>";
									$CI->make->td($inp, array('style'=>'width: 20%;'));
									$CI->make->td($price_link, array( 'style'=>'width: 20%;'));
								}
								$CI->make->eRow();
							}
					$CI->make->eTable();
				$CI->make->eDiv();
			$CI->make->eDivCol();

	$CI->make->eDivRow();
	//-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----END
//-----LOAD PRICING LOOP HERE-----END
return $CI->make->code();
}
*/
function build_stock_barcodes_list($item=array(), $stock_id=null, $barcode_prices=array()){
	$CI =& get_instance();
	$add_link = "";
	$barcode_prices = array();
	// $add_link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), base_url().'inventory/stock_master/'.$stock_id, array(
										// 'class'=>'add_stock_barcode',
										// 'title'=>'Add New Stock Barcode',
										// 'return'=>'false'));
	$add_link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), '', array(
										'class'=>'add_stock_barcode',
										'title'=>'Add New Stock Barcode',
										'style'=>'cursor: pointer;',
										'return'=>'false'));
										
		$CI->make->sDivCol(12,'center',0,array("style"=>''));
			$CI->make->sBox('info',array('div-form'));
				$CI->make->sBoxBody(array('style'=>''));
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										$CI->make->th('Barcode');
										$CI->make->th('Description',array('style'=>''));
										$CI->make->th('UOM',array('style'=>''));
										$CI->make->th('Qty',array('style'=>''));
										// $CI->make->th('Retail Price',array('style'=>''));
										// $CI->make->th('Wholesale Price',array('style'=>''));
										$CI->make->th($add_link,array('style'=>''));
									$CI->make->eRow();
									$barcode_details = array();
									// echo var_dump($item);
									foreach($item as $val){
										$links = "";
										// echo var_dump($val)."<br>";
										// echo var_dump($barcode_details);
										/*
										//----Use this block for rPopView
										$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'), 'inventory/view_stock_barcode_details_pop/'.$val->id.'/'.$val->barcode, array(
										'class'=>'edit_me_btn',
										'rata-title'=>'View Stock Barcode Details',
										'rata-pass'=>'inventory/view_stock_barcode_details_pop',
										'ref'=>$val->id,
										'id'=>'view-stock-barcode-'.$val->id,
										'return'=>'false'));
										*/
										$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'), '', array(
										'class'=>'edit_me_btn',
										'ref'=>$val->id,
										'ref_barcode'=>$val->barcode,
										'ref_short_desc'=>$val->short_desc,
										'ref_desc'=>$val->description,
										'ref_uom'=>$val->uom,
										'ref_qty'=>$val->qty,
										'ref_sales_type_id'=>$val->sales_type_id,
										'ref_status'=>$val->inactive,
										'title'=>'Edit Stock Barcode Details',
										'style'=>'cursor: pointer;',
										// 'id'=>'view-stock-barcode-'.$val->id,
										'return'=>'false'));
										$CI->make->sRow(array('id'=>$val->id));
											$CI->make->th($val->barcode);
											$CI->make->th($val->description,array('style'=>''));
											$CI->make->th($val->uom,array('style'=>''));
											$CI->make->th($val->qty,array('style'=>''));
											// $CI->make->th(num($val->retail_price),array('style'=>''));
											// $CI->make->th(num($val->wholesale_price),array('style'=>''));
											$CI->make->th($links); //-----TEMPORARILY DISABLED
											// $CI->make->th(''); //-----BLANK MUNA
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
//rhan barcode prices view

function build_stock_barcode_price_list_view($barcode=null){
	
	$CI =& get_instance();	
	$barcode_prices = array();
	$this_stock_id = "";
	$barcode_prices = $CI->inventory_model->get_stock_barcode_prices_temp($barcode); //-----ORIGINAL
	$CI->make->sDivRow(array('style'=>'margin-bottom: 15px;'));
		$CI->make->sDivCol();
			$CI->make->sDiv(array('class'=>'table-responsive'));
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
						$CI->make->th('Branch', array('style'=>'width: 20%;'));
					$CI->make->eRow();
				$CI->make->eTable();
			$CI->make->eDiv();
		$CI->make->eDivCol();
		
			$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
				$CI->make->sDiv(array('class'=>'table-responsive'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
							$this_price =  0;
							$pk_id = $cur_avg_net_cost = $cur_cos_mup = '';
							$bp_prices = $br_array = $st_array = $bp_computed_srp = $bp_prevailing_unit_price = $bp_landed_cost_markup = $bp_cost_of_sales_markup = array();
							$st_array = $CI->inventory_model->get_sales_types();
							$br_array = $CI->inventory_model->get_active_branches();
							
							foreach($barcode_prices as $bp_vals){
								$bp_prices[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->price;
							}
							
							foreach($br_array as $br_vals){
								$CI->make->sRow();
									$CI->make->th($br_vals->code, array('style'=>'width: 20%;'));
									$CI->make->hidden('hidden_branch_id',$br_vals->id, array('class'=>'hidden_branch_id_'+$br_vals->id));
								// foreach($st_array as $st_vals){ //-----TEMP
									$this_array = array();
									$st_cost_of_sales = "";
									$pk_id = $this_price = $price_link = $inp = "";
									
									//prices
									if(isset($bp_prices[$br_vals->id][$bp_vals->sales_type_id]))
										$this_price = $bp_prices[$br_vals->id][$bp_vals->sales_type_id];
									
								
									
									$st_cost_of_sales = $CI->inventory_model->get_branch_stock_cost_of_sales($bp_vals->stock_id, $br_vals->id);
									if(!empty($this_array)){
										$cur_avg_net_cost = $this_array[0]->avg_net_cost;
									}else{
										$cur_avg_net_cost = '';
									}
									
									if($st_cost_of_sales != ''){
										$cur_cost_of_sales = $st_cost_of_sales;
									}else{
										$cur_cost_of_sales = '';
									}
								
									$inp = "<input type='text' p_barcode='' p_sales_type='' p_branch_id='' name='".$br_vals->code."_price' id='".$br_vals->code."_price' old_val='".$this_price."' value='".$this_price."' class='formInputMini branch_type_price num_with_decimal required_form'>";
									$CI->make->td($inp, array('style'=>'width: 20%;'));
									$CI->make->td($price_link, array( 'style'=>'width: 20%;'));
							
								$CI->make->eRow();
							}
					$CI->make->eTable();
				$CI->make->eDiv();
			$CI->make->eDivCol();

	$CI->make->eDivRow();
return $CI->make->code();
	
// $CI =& get_instance();	
	// $barcode_prices = array();
	// $this_stock_id = "";
	// $barcode_prices = $CI->inventory_model->get_stock_barcode_prices_temp($barcode); //-----ORIGINAL

	// //-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----START
	// $CI->make->sDivRow(array('style'=>'margin-bottom: 15px;'));
		// $CI->make->sDivCol();
			// $CI->make->sDiv(array('class'=>'table-responsive'));
				// $CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					// $CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
						// $CI->make->th('Branch', array('style'=>'width: 20%;'));
						// //-----LOOP PRICE TYPES COLUMNS-----START
							// $itm_array = $this_vals = $db_prices = array();
							// $itm_array = $CI->inventory_model->get_sales_types();
							// foreach($itm_array as $this_vals){
								// $CI->make->th(ucwords($this_vals->sales_type),array('style'=>'width: 20%; text-align: right;'));
								// $CI->make->th('&nbsp;', array('style'=>'width: 20%;'));
							// }
						// //-----LOOP PRICE TYPES COLUMNS-----END
					// $CI->make->eRow();
				// $CI->make->eTable();
			// $CI->make->eDiv();
		// $CI->make->eDivCol();
		
		// // if(!empty($item)){
			// // echo "<br>Barcode Price Edit <~~~> ".$barcode."<br>";
			// //-----EDIT
			// $CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
				// $CI->make->sDiv(array('class'=>'table-responsive'));
					// $CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
							// $this_price = 0;
							// $pk_id = $cur_avg_net_cost = $cur_cos_mup = '';
							// $bp_prices = $br_array = $st_array = array();
							// $st_array = $CI->inventory_model->get_sales_types();
							// $br_array = $CI->inventory_model->get_active_branches();
							

							// foreach($barcode_prices as $bp_vals){
								// $bp_prices[$bp_vals->branch_id][$bp_vals->sales_type_id] = $bp_vals->price;
							// }
							
							// foreach($br_array as $br_vals){
								// $CI->make->sRow();
									// $CI->make->th($br_vals->code, array('style'=>'width: 20%;'));
									// $CI->make->hidden('hidden_branch_id',$br_vals->id, array('class'=>'hidden_branch_id_'+$br_vals->id));
								// foreach($st_array as $st_vals){
									// $this_array = array();
									// $st_cost_of_sales = "";
									// $pk_id = $this_price = $price_link = $inp = "";
									// // $CI->make->hidden('hidden_sales_type_id',$st_vals->id, array('class'=>'hidden_sales_type_id_'+$st_vals->id));
									// // $this_price = $CI->inventory_model->price_per_sales_type_and_branch('4810012002', $st_vals->id, $br_vals->id);
									// if(isset($bp_prices[$br_vals->id][$st_vals->id]))
									 // $this_price = $bp_prices[$br_vals->id][$st_vals->id];
									
									// $pk_id = $CI->inventory_model->get_stock_barcode_prices_pk_id($bp_vals->barcode, $br_vals->id, $st_vals->id);
									// $this_array = $CI->inventory_model->get_stock_cost_details($bp_vals->stock_id, $br_vals->id);
									// // echo $CI->inventory_model->db->last_query()."<br>";
									// $st_cost_of_sales = $CI->inventory_model->get_branch_stock_cost_of_sales($bp_vals->stock_id, $br_vals->id);
									// if(!empty($this_array)){
										// $cur_avg_net_cost = $this_array[0]->avg_net_cost;
									// }else{
										// $cur_avg_net_cost = '';
									// }
									
									// if($st_cost_of_sales != ''){
										// $cur_cost_of_sales = $st_cost_of_sales;
									// }else{
										// $cur_cost_of_sales = '';
									// }
									
									// $price_link = $CI->make->A(
													// fa('fa-tag fa-lg fa-fw'),
													// '',
													// array('class'=>'',
														// 'return'=>'false'));
							
									
									// $inp = "<input type='text' p_barcode='' p_sales_type='' p_branch_id='' name='".$br_vals->code."_".$st_vals->sales_type."_price' id='".$br_vals->code."_".$st_vals->sales_type."_price' value='".$this_price."' class='formInputMini branch_type_price num_with_decimal' readonly>";
									// $CI->make->td($price_link, array( 'style'=>'width: 20%;'));
									// $CI->make->td($inp, array('style'=>'width: 20%;'));
								// }
								// $CI->make->eRow();
							// }
					// $CI->make->eTable();
				// $CI->make->eDiv();
			// $CI->make->eDivCol();
		// // }else{
			// // echo "Barcode Price Add<br>";
			// // //-----ADD
			// // $CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
				// // $CI->make->sDiv(array('class'=>'table-responsive'));
					// // $CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
							// // $br_array = $st_array = array();
							// // $st_array = $CI->inventory_model->get_sales_types();
							// // $br_array = $CI->inventory_model->get_active_branches();
							// // foreach($br_array as $br_vals){
								// // $CI->make->sRow();
									// // $CI->make->th($br_vals->code, array('style'=>'width: 40%;'));
									// // $CI->make->hidden('branch_id',$br_vals->id);
								// // foreach($st_array as $st_vals){
									// // $inp = "";
									// // $inp = "<input type='text' name='".$br_vals->code."_".$st_vals->sales_type."_price' id='".$br_vals->code."_".$st_vals->sales_type."_price' class='formInputMini branch_type_price'>";
									// // $CI->make->td($inp, array('style'=>'width: 20%;'));
								// // }
								// // $CI->make->eRow();
							// // }
					// // $CI->make->eTable();
				// // $CI->make->eDiv();
			// // $CI->make->eDivCol();
		// // }

	// $CI->make->eDivRow();
	// //-----BRANCHES TABLE WITH DIFF. PRICE TYPES-----END
// //-----LOAD PRICING LOOP HERE-----END
// return $CI->make->code();
}



//end




function viewStockBarcodeDetailsPopForm($trx_details=null,$header=null){
	$CI =& get_instance();
		$CI->make->sForm('',array('id'=>'inv_adjustment_form'));
			
			//-----UNCOMMENT TO LOAD SAMPLE POP-UP FORM
			/*
			$CI->make->sDivRow();
				$CI->make->sDivCol(3);
					$CI->make->inventoryLocationsDrop('Deliver from Location ','from_loc',iSetObj($header,'loc_code'), '', array('class'=>'rOkay', 'readonly'=>'readonly'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->input('Reference','reference',iSetObj($header,'reference'),'Type Reference',array('class'=>'', 'readonly'=>'readonly'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->datefield('Date','trans_date',iSetObj($header,'trans_date'),'',array('readonly'=>'readonly'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->itemMovementTypeDrop('Movement Type','movement_type',iSetObj($header,'movement_type'), '', array('class'=>'rOkay', 'readonly'=>'readonly'));
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			*/
			//-----UNCOMMENT TO LOAD SAMPLE POP-UP FORM
			
			$CI->make->hidden('item-id',null, array('class'=>'input_form'));
			$CI->make->hidden('item-uom',null, array('class'=>'input_form'));
			$CI->make->hidden('item-price',null, array('class'=>'input_form'));
			$CI->make->hidden('item-location',null, array('class'=>'input_form'));

			$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->sBox('success');
					//-----Uncomment this block to use boxTitle
					/*
					$CI->make->sBoxHead();
						$CI->make->boxTitle('General Details');
					$CI->make->eBoxHead();
					*/
					//-----Uncomment this block to use boxTitle

					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
							
								//----------START
								$th = array(
									'Barcode'=>array('width'=>'20%'),
									'Description' => array('width'=>'20%'),
									'UOM' => array('width'=>'20%'),
									'Qty' => array('width'=>'10%'),
									'Retail Price' => array('width'=>'15%'),
									'Wholesale Price' => array('width'=>'15%')
									);
								$rows = array();
								foreach ($trx_details as $val) {
									// $item_details = $CI->inventory_model->get_inventory_item($val->item_id);
									// $name = $item_details[0]->name;
									$rows[] = array(
											$val->barcode,
											$val->description,
											$val->uom,
											$val->qty,
											num($val->retail_price),
											num($val->wholesale_price)
									);
								}
								//----------END
							
								$CI->make->listLayout($th,$rows);
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								// $CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>''));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->button(fa('fa-save').' Try',array('id'=>'save-test-btn','class'=>'btn-block', 'style'=>'margin-top: 20px;'),'primary');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								// $CI->make->button(fa('fa-reply').' Return to Main',array('id'=>'back-barcode-btn','class'=>'btn-block', 'style'=>'margin-top: 20px;'),'default');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();

				$CI->make->eBox();
			$CI->make->eDivRow();

		$CI->make->eForm();
	return $CI->make->code();
}


//-> add supplier

function add_build_supplier_stock_form($item=array(), $ref='')
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/add_supplier_stock_db",array('id'=>'supplier_stock_form'));

		$CI->make->hidden('id','');
		$CI->make->hidden('is_default','');
		$CI->make->hidden('hidden_supp_stock_id','');
		$CI->make->hidden('hidden_stock_id',($ref != '' ? $ref : ''));
		// $CI->make->hidden('hidden_supplier_stock_id',0); //-----temporarily disabled

		$CI->make->sDivRow();
			$CI->make->sDivCol();
				//-----LIST-----START
					$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
						//-----PRELOADER-----START
							$CI->make->sDiv(array('id'=>'file-spinner'));
								$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom: 5px;'));
									$CI->make->sBox('info',array('div-form'));
										$CI->make->sBoxBody(array('style'=>'height: 400px;'));
											$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
												$CI->make->sDivCol(12,'center',0,array("style"=>'margin-top:70px; margin-bottom:5px;'));
													$thumb = base_url().'img/ajax-loader.gif';
													$CI->make->img($thumb,false,array("border"=>"0"));	
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eBoxBody();
									$CI->make->eBox();
								$CI->make->eDivCol();
							$CI->make->eDiv();
							
							$CI->make->sDiv(array('id'=>'init-contents', 'style'=>''));
								$CI->make->sDivCol(12,'center',0,array("style"=>''));
									$CI->make->sBox('info',array('div-form'));
										$CI->make->sBoxBody(array('style'=>''));
											$CI->make->sDivRow();
												$CI->make->sDivCol();
													$CI->make->sDiv(array('class'=>'table-responsive'));
														$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
															$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
																$CI->make->th('Branch',array('style'=>'width: 20%;'));
																$CI->make->th('Vendor Code',array('style'=>'width: 20%;'));
																$CI->make->th('Description',array('style'=>'width: 20%;'));
																$CI->make->th('Cost',array('style'=>'width: 10%;'));
																$CI->make->th('Avg. Cost',array('style'=>'width: 10%; text-align: center;'));
																$CI->make->th('Avg. Net Cost',array('style'=>'width: 15%; text-align: center;'));
																$CI->make->th('',array('style'=>'width: 5%; text-align: center;'));
															$CI->make->eRow();
															$CI->make->sRow();
																$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
															$CI->make->eRow();
														$CI->make->eTable();
													$CI->make->eDiv();
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eBoxBody();
									$CI->make->eBox();
								$CI->make->eDivCol();
							$CI->make->eDiv();
						
						// $CI->make->sDiv(array('id'=>'stock-barcode-contents', 'style'=>'height: 150px; width: 100%; overflow-x: none; overflow-y: scroll;'));
						$CI->make->sDiv(array('id'=>'stock-barcode-contents', 'style'=>''));
						$CI->make->eDiv();
						//-----PRELOADER-----END
					$CI->make->eDivRow();	
				//-----LIST-----END
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			//-----ADDER FORM-----START
			// echo var_dump($item);
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
														$CI->make->H(4,"Supplier Details for <span style='color: #5bc0de;'>[".$item->stock_code."] ".$item->sm_desc."</span> ",array('id'=>'add_supp_div', 'style'=>'margin-top:0px;margin-bottom:0px;'));
														// $CI->make->H(4,"Edit Supplier Details",array('id'=>'edit_supp_div', 'style'=>'margin-top:0px;margin-bottom:0px;'));
														$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
														$CI->make->hidden('supp_stock_mode','');
													$CI->make->eDiv();
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol();
													$CI->make->hidden('ids','');
													$CI->make->supplierMasterDrop('Supplier','supp_id',null,'Select Supplier',array('class'=>'rOkay combobox supp_dropdown'));
													$CI->make->hidden('hidden_supplier_id','', array('class'=>'c_hidden_supplier_id supp_req_form', 'old_val'=>''));
													$CI->make->input('Supplier Stock Code','supp_stock_code','','Type Supplier Stock Code',array('class'=>'rOkay toUpper supp_req_form', 'old_val'=>''));
													$CI->make->input('Description','description','','Type Supplier Stock Description',array('class'=>'rOkay supp_desc_text toUpper supp_req_form', 'old_val'=>''));
													$CI->make->branchesCodeDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
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
												$CI->make->sDivCol(6);
													// $CI->make->stockUOMCodeDrop('UOM','uom',iSetObj($item,'uom'),'Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
													$CI->make->stockUOMCodeDrop('UOM','uom','','Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
													$CI->make->hidden('hidden_stock_uom','', array('class'=>'c_hidden_stock_uom supp_req_form', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													// $CI->make->input('Quantity','qty',iSetObj($item,'qty'),'Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
													$CI->make->input('Quantity','qty','','Quantity per UOM',array('class'=>'rOkay supp_req_form','maxchars'=>'20', 'old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(6);
													// $CI->make->stockUOMCodeDrop('UOM','uom',iSetObj($item,'uom'),'Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
													$CI->make->stockUOMCodeDrop('Confirm UOM','con_uom','','Select UOM',array('class'=>'rOkay combobox con_uom_dropdown'));
													$CI->make->hidden('con_hidden_stock_uom','', array('class'=>'c_con_hidden_stock_uom'));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													// $CI->make->input('Quantity','qty',iSetObj($item,'qty'),'Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
													$CI->make->input('Confirm Quantity','con_qty','','Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(6);
													$CI->make->input('Unit Cost','unit_cost','','',array('class'=>'rOkay num_with_decimal supp_req_form', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													$CI->make->input('Confirm Unit Cost','con_unit_cost','','',array('class'=>'rOkay num_with_decimal'));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(6);
													$CI->make->input('Average Cost','avg_cost','','',array('class'=>'rOkay supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													//$CI->make->input('Unit Cost','unit_cost','','',array('class'=>'rOkay'));
													$CI->make->yesOrNoNumValDrop('Is Default','is_default','','',array('class'=>'rOkay supp_req_form is_def_class','old_val'=>''),1);
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
													$CI->make->input('Latest Landed Cost','net_cost','','',array('class'=>'rOkay supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													$CI->make->input('Cost Per Piece','avg_net_cost','','',array('class'=>'rOkay supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
												//	$CI->make->input('Cost Multiplier','cost_multiplier','1','',array('class'=>'rOkay', 'readonly'=>'readonly', 'old_val'=>''));
													$CI->make->button(fa('fa-reply').' Back',array('id'=>'supp_stock_back_btn','class'=>'supp_stock_back_btn btn-block', 'style'=>'margin-top: 20px;'),'default');
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													// $CI->make->button(fa('fa-save').' Save',array('id'=>'save_supp_stock_btn','class'=>'btn-block edit_form_btns', 'style'=>'margin-top: 20px;'),'primary');
													$CI->make->button(fa('fa-save').' Save',array('id'=>'save_supp_stock_btn','class'=>'btn-block adder_form_btns', 'style'=>'margin-top: 20px;'),'primary');
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													$CI->make->button(fa('fa-save').' Save to ALL',array('id'=>'save_all_supp_stock_btn','class'=>'btn-block adder_form_btns', 'style'=>'margin-top: 20px;'),'primary');
													// $CI->make->button(fa('fa-save').' Save to ALL',array('id'=>'save_all_supp_stock_btn','class'=>'btn-block edit_form_btns', 'style'=>'margin-top: 20px;'),'primary');
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													$CI->make->button(fa('fa-share').' Next',array('id'=>'supp_stock_next_btn','class'=>'supp_stock_back_btn btn-block', 'style'=>'margin-top: 20px;'),'default');
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
									
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eDivCol();
			$CI->make->eDiv();
			//-----ADDER FORM-----END
		$CI->make->eDivRow();

	$CI->make->eForm();

	return $CI->make->code();
}



function add_build_supplier_stocks_list($item=array(), $stock_id=null){
	$CI =& get_instance();
	$supp_name = $branch_code = $add_link = "";
	
	
	//echo var_dump($item);
	// $add_link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), base_url().'inventory/stock_master/'.$stock_id, array(
										// 'class'=>'add_stock_barcode',
										// 'title'=>'Add New Stock Barcode',
										// 'return'=>'false'));
	$add_link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), '', array(
										'class'=>'add_supplier_stock',
										'title'=>'Add New Supplier Stock',
										'style'=>'cursor: pointer;',
										'return'=>'false'));
										
		$CI->make->sDivCol(12,'center',0,array("style"=>''));
			$CI->make->sBox('info',array('div-form'));
				$CI->make->sBoxBody(array('style'=>''));
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										$CI->make->th('',array('style'=>'width: 10%;'));
										$CI->make->th('Branch',array('style'=>'width: 10%;'));
										$CI->make->th('Supplier',array('style'=>'width: 15%;'));
										$CI->make->th('Vendor Code',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->th('Description',array('style'=>'width: 25%; text-align: center;'));
										$CI->make->th('Cost',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->th('Avg. Cost',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->th('Avg. Net Cost',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->th($add_link,array('style'=>'width: 5%; text-align: center;'));
									$CI->make->eRow();
								$CI->make->eTable();	
							$CI->make->eDiv();
						$CI->make->eDivCol();
						
						$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
						// $CI->make->sDivCol(12, 'left', 0, array('style'=>''));
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									$barcode_details = array();
									$con_avg_net_cost = 0;
									// echo var_dump($item); 
									foreach($item as $val){
										$links = "";
										// echo var_dump($val)."<hr><br>";
										$branch_code = $CI->inventory_model->get_branch_code_from_id($val->branch_id);
										$supp_name = $CI->inventory_model->get_supp_name_from_id($val->supp_id);
										// echo $CI->inventory_model->db->last_query()."<br>";
										
										// echo var_dump($barcode_details);
										/*
										//----Use this block for rPopView
										$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'), 'inventory/view_stock_barcode_details_pop/'.$val->id.'/'.$val->barcode, array(
										'class'=>'edit_me_btn',
										'rata-title'=>'View Stock Barcode Details',
										'rata-pass'=>'inventory/view_stock_barcode_details_pop',
										'ref'=>$val->id,
										'id'=>'view-stock-barcode-'.$val->id,
										'return'=>'false'));
										*/
										$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'), '', array(
										'class'=>'edit_supplier_stock',
										'ref'=>$val->id,
										'ref_supp_stock_code'=>$val->supp_stock_code,
										'def'=>$val->is_default,
										'ref_desc'=>$val->description,
										'ref_supp_id'=>$val->supp_id,
										'ref_branch_id'=>$val->branch_id,
										'ref_uom'=>$val->uom,
										'ref_qty'=>$val->qty,
										'ref_unit_cost'=>$val->unit_cost,
										'ref_disc_percent1'=>$val->disc_percent1,
										'ref_disc_percent2'=>$val->disc_percent2,
										'ref_disc_percent3'=>$val->disc_percent3,
										'ref_disc_amount1'=>$val->disc_amount1,
										'ref_disc_amount2'=>$val->disc_amount2,
										'ref_disc_amount3'=>$val->disc_amount3,
										'ref_avg_cost'=>$val->avg_cost,
										'ref_net_cost'=>$val->net_cost,
										'ref_avg_net_cost'=>$val->avg_net_cost,
										'ref_status'=>$val->inactive,
										'title'=>'Edit Supplier Stock Details',
										'style'=>'cursor: pointer;',
										// 'id'=>'view-stock-barcode-'.$val->id,
										'return'=>'false'));
										$con_avg_cost = floor(($val->avg_cost*100))/100;
										$con_avg_net_cost = floor(($val->avg_net_cost*100))/100;
										$default_stat = array('','Default');
										$CI->make->sRow(array('id'=>$val->id));
											//-----ORIGINAL
											$CI->make->th("<span class='label label-success';>".$default_stat[$val->is_default].'</span>', array('style'=>'width: 10%;'));
											$CI->make->th($CI->inventory_model->get_branch_code($val->branch_id), array('style'=>'width: 10%;'));
											$CI->make->th($supp_name,array('style'=>'width: 15%; text-align:center;'));
											$CI->make->th($val->supp_stock_code,array('style'=>'width: 10%; text-align:center;'));
											$CI->make->th($val->description,array('style'=>'width: 25%; text-align:center;'));
											$CI->make->th($val->unit_cost,array('style'=>'width: 10%; text-align:center;'));
											$CI->make->th(number_format($con_avg_cost, 2),array('style'=>'width: 10%; text-align:center;')); //avg cost
											$CI->make->th($con_avg_net_cost,array('style'=>'width: 10%; text-align:center;')); //avg net cost
											$CI->make->th($links,array('style'=>'width: 5%; text-align: center;')); //-----TEMPORARILY DISABLED
											// $CI->make->th(''); //-----BLANK MUNA
											//-----ORIGINAL
											
											// $CI->make->th($CI->inventory_model->get_branch_code($val->branch_id), array('style'=>'width: 15%;'));
											// $CI->make->th($val->supp_stock_code,array('style'=>'width: 16%;'));
											// $CI->make->th($val->description,array('style'=>'width: 35.5%;'));
											// $CI->make->th($val->unit_cost,array('style'=>'width: 10%;'));
											// $CI->make->th(number_format($con_avg_cost, 2),array('style'=>'width: 10%;')); //avg cost
											// $CI->make->th($con_avg_net_cost,array('style'=>'width: width: 13.5%; padding-right: 30px;')); //avg net cost
											// $CI->make->th($links,array('style'=>'width: ;')); //-----TEMPORARILY DISABLED
											// // $CI->make->th(''); //-----BLANK MUNA
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





//->end




//-----------Barcode Form Maker-----end-----allyn
//-----------Supplier Stock Form Maker-----start-----allyn
function build_supplier_stock_form($item=array(), $ref='')
{
	$CI =& get_instance();
	$CI->make->sForm("inventory/supplier_stock_db",array('id'=>'supplier_stock_form'));
		/*
		$CI->make->hidden('id',iSetObj($item,'stock_id'));
		$CI->make->hidden('hidden_supp_stock_id',iSetObj($item,'id'));
		$CI->make->hidden('hidden_stock_id',iSetObj($item,'stock_id'));
		$CI->make->hidden('hidden_supplier_stock_id',($ref != '' ? $ref : ''));
		*/
		
		// echo "Ref : ".$ref."<br>";
		
		$CI->make->hidden('id','');
		$CI->make->hidden('is_default','');
		$CI->make->hidden('hidden_supp_stock_id','');
		$CI->make->hidden('hidden_stock_id',($ref != '' ? $ref : ''));
		// $CI->make->hidden('hidden_supplier_stock_id',0); //-----temporarily disabled

		$CI->make->sDivRow();
			$CI->make->sDivCol();
				//-----LIST-----START
					$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
						//-----PRELOADER-----START
							$CI->make->sDiv(array('id'=>'file-spinner'));
								$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom: 5px;'));
									$CI->make->sBox('info',array('div-form'));
										$CI->make->sBoxBody(array('style'=>'height: 400px;'));
											$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
												$CI->make->sDivCol(12,'center',0,array("style"=>'margin-top:70px; margin-bottom:5px;'));
													$thumb = base_url().'img/ajax-loader.gif';
													$CI->make->img($thumb,false,array("border"=>"0"));	
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eBoxBody();
									$CI->make->eBox();
								$CI->make->eDivCol();
							$CI->make->eDiv();
							
							$CI->make->sDiv(array('id'=>'init-contents', 'style'=>''));
								$CI->make->sDivCol(12,'center',0,array("style"=>''));
									$CI->make->sBox('info',array('div-form'));
										$CI->make->sBoxBody(array('style'=>''));
											$CI->make->sDivRow();
												$CI->make->sDivCol();
													$CI->make->sDiv(array('class'=>'table-responsive'));
														$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
															$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
																$CI->make->th('Branch',array('style'=>'width: 20%;'));
																$CI->make->th('Vendor Code',array('style'=>'width: 20%;'));
																$CI->make->th('Description',array('style'=>'width: 20%;'));
																$CI->make->th('Cost',array('style'=>'width: 10%;'));
																$CI->make->th('Avg. Cost',array('style'=>'width: 10%; text-align: center;'));
																$CI->make->th('Avg. Net Cost',array('style'=>'width: 15%; text-align: center;'));
																$CI->make->th('',array('style'=>'width: 5%; text-align: center;'));
															$CI->make->eRow();
															$CI->make->sRow();
																$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
															$CI->make->eRow();
														$CI->make->eTable();
													$CI->make->eDiv();
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eBoxBody();
									$CI->make->eBox();
								$CI->make->eDivCol();
							$CI->make->eDiv();
						
						// $CI->make->sDiv(array('id'=>'stock-barcode-contents', 'style'=>'height: 150px; width: 100%; overflow-x: none; overflow-y: scroll;'));
						$CI->make->sDiv(array('id'=>'stock-barcode-contents', 'style'=>''));
						$CI->make->eDiv();
						//-----PRELOADER-----END
					$CI->make->eDivRow();	
				//-----LIST-----END
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			//-----ADDER FORM-----START
			// echo var_dump($item);
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
														$CI->make->H(4,"Supplier Details for <span style='color: #5bc0de;'>[".$item->stock_code."] ".$item->sm_desc."</span> ",array('id'=>'add_supp_div', 'style'=>'margin-top:0px;margin-bottom:0px;'));
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
													$CI->make->hidden('ids','');
													$CI->make->supplierMasterDrop('Supplier','supp_id',null,'Select Supplier',array('class'=>'rOkay combobox supp_dropdown'));
													$CI->make->hidden('hidden_supplier_id','', array('class'=>'c_hidden_supplier_id supp_req_form', 'old_val'=>''));
													$CI->make->input('Supplier Stock Code','supp_stock_code','','Type Supplier Stock Code',array('class'=>'rOkay toUpper supp_req_form', 'old_val'=>''));
													$CI->make->input('Description','description','','Type Supplier Stock Description',array('class'=>'rOkay supp_desc_text toUpper supp_req_form', 'old_val'=>''));
													// $CI->make->branchesDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
													// $CI->make->branchesDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
													$CI->make->branchesCodeDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
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
												$CI->make->sDivCol(6);
													// $CI->make->stockUOMCodeDrop('UOM','uom',iSetObj($item,'uom'),'Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
													$CI->make->stockUOMCodeDrop('UOM','uom','','Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
													$CI->make->hidden('hidden_stock_uom','', array('class'=>'c_hidden_stock_uom supp_req_form', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													// $CI->make->input('Quantity','qty',iSetObj($item,'qty'),'Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
													$CI->make->input('Quantity','qty','','Quantity per UOM',array('class'=>'rOkay supp_req_form','maxchars'=>'20', 'old_val'=>''));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(6);
													// $CI->make->stockUOMCodeDrop('UOM','uom',iSetObj($item,'uom'),'Select UOM',array('class'=>'rOkay combobox uom_dropdown'));
													$CI->make->stockUOMCodeDrop('Confirm UOM','con_uom','','Select UOM',array('class'=>'rOkay combobox con_uom_dropdown'));
													$CI->make->hidden('con_hidden_stock_uom','', array('class'=>'c_con_hidden_stock_uom'));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													// $CI->make->input('Quantity','qty',iSetObj($item,'qty'),'Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
													$CI->make->input('Confirm Quantity','con_qty','','Quantity per UOM',array('class'=>'rOkay','maxchars'=>'20'));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(6);
													$CI->make->input('Unit Cost','unit_cost','','',array('class'=>'rOkay num_with_decimal supp_req_form', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													$CI->make->input('Confirm Unit Cost','con_unit_cost','','',array('class'=>'rOkay num_with_decimal'));
												$CI->make->eDivCol();
											$CI->make->eDivRow();
											$CI->make->sDivRow();
												$CI->make->sDivCol(6);
													$CI->make->input('Average Cost','avg_cost','','',array('class'=>'rOkay supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(6);
													//$CI->make->input('Unit Cost','unit_cost','','',array('class'=>'rOkay'));
													$CI->make->yesOrNoNumValDrop('Is Default','is_default','','',array('class'=>'rOkay supp_req_form is_def_class','old_val'=>''),1);
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
													$CI->make->input('Latest Landed Cost','net_cost','','',array('class'=>'rOkay supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													$CI->make->input('Cost Per Piece','avg_net_cost','','',array('class'=>'rOkay supp_req_form', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
												//	$CI->make->input('Cost Multiplier','cost_multiplier','1','',array('class'=>'rOkay', 'readonly'=>'readonly', 'old_val'=>''));
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													$CI->make->button(fa('fa-save').' Save',array('id'=>'save_supp_stock_btn','class'=>'btn-block adder_form_btns', 'style'=>'margin-top: 20px;'),'primary');
													// $CI->make->button(fa('fa-save').' Save',array('id'=>'save_supp_stock_btn','class'=>'btn-block edit_form_btns', 'style'=>'margin-top: 20px;'),'primary');
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													$CI->make->button(fa('fa-save').' Save to ALL',array('id'=>'save_all_supp_stock_btn','class'=>'btn-block adder_form_btns', 'style'=>'margin-top: 20px;'),'primary');
													// $CI->make->button(fa('fa-save').' Save to ALL',array('id'=>'save_all_supp_stock_btn','class'=>'btn-block edit_form_btns', 'style'=>'margin-top: 20px;'),'primary');
												$CI->make->eDivCol();
												$CI->make->sDivCol(2);
													$CI->make->button(fa('fa-reply').' Back',array('id'=>'supp_stock_back_btn','class'=>'supp_stock_back_btn btn-block', 'style'=>'margin-top: 20px;'),'default');
												$CI->make->eDivCol();
											$CI->make->eDivRow();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
									
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eDivCol();
			$CI->make->eDiv();
			//-----ADDER FORM-----END
		$CI->make->eDivRow();

	$CI->make->eForm();

	return $CI->make->code();
}
function build_supplier_stocks_list($item=array(), $stock_id=null){
	$CI =& get_instance();
	$supp_name = $branch_code = $add_link = "";
	// $add_link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), base_url().'inventory/stock_master/'.$stock_id, array(
										// 'class'=>'add_stock_barcode',
										// 'title'=>'Add New Stock Barcode',
										// 'return'=>'false'));
	$add_link .= $CI->make->A(fa('fa-plus-square fa-lg fa-fw'), '', array(
										'class'=>'add_supplier_stock',
										'title'=>'Add New Supplier Stock',
										'style'=>'cursor: pointer;',
										'return'=>'false'));
										
		$CI->make->sDivCol(12,'center',0,array("style"=>''));
			$CI->make->sBox('info',array('div-form'));
				$CI->make->sBoxBody(array('style'=>''));
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										$CI->make->th('',array('style'=>'width: 10%;'));
										$CI->make->th('Branch',array('style'=>'width: 10%;'));
										$CI->make->th('Supplier',array('style'=>'width: 15%;'));
										$CI->make->th('Vendor Code',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->th('Description',array('style'=>'width: 25%; text-align: center;'));
										$CI->make->th('Cost',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->th('Avg. Cost',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->th('Avg. Net Cost',array('style'=>'width: 10%; text-align: center;'));
										$CI->make->th($add_link,array('style'=>'width: 5%; text-align: center;'));
									$CI->make->eRow();
								$CI->make->eTable();	
							$CI->make->eDiv();
						$CI->make->eDivCol();
						
						$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
						// $CI->make->sDivCol(12, 'left', 0, array('style'=>''));
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									$barcode_details = array();
									$con_avg_net_cost = 0;
									// echo var_dump($item); 
									foreach($item as $val){
										$links = "";
										// echo var_dump($val)."<hr><br>";
										$branch_code = $CI->inventory_model->get_branch_code_from_id($val->branch_id);
										$supp_name = $CI->inventory_model->get_supp_name_from_id($val->supp_id);
										// echo $CI->inventory_model->db->last_query()."<br>";
										
										// echo var_dump($barcode_details);
										/*
										//----Use this block for rPopView
										$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'), 'inventory/view_stock_barcode_details_pop/'.$val->id.'/'.$val->barcode, array(
										'class'=>'edit_me_btn',
										'rata-title'=>'View Stock Barcode Details',
										'rata-pass'=>'inventory/view_stock_barcode_details_pop',
										'ref'=>$val->id,
										'id'=>'view-stock-barcode-'.$val->id,
										'return'=>'false'));
										*/
										$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'), '', array(
										'class'=>'edit_supplier_stock',
										'ref'=>$val->id,
										'ref_supp_stock_code'=>$val->supp_stock_code,
										'def'=>$val->is_default,
										'ref_desc'=>$val->description,
										'ref_supp_id'=>$val->supp_id,
										'ref_branch_id'=>$val->branch_id,
										'ref_uom'=>$val->uom,
										'ref_qty'=>$val->qty,
										'ref_unit_cost'=>$val->unit_cost,
										'ref_disc_percent1'=>$val->disc_percent1,
										'ref_disc_percent2'=>$val->disc_percent2,
										'ref_disc_percent3'=>$val->disc_percent3,
										'ref_disc_amount1'=>$val->disc_amount1,
										'ref_disc_amount2'=>$val->disc_amount2,
										'ref_disc_amount3'=>$val->disc_amount3,
										'ref_avg_cost'=>$val->avg_cost,
										'ref_net_cost'=>$val->net_cost,
										'ref_avg_net_cost'=>$val->avg_net_cost,
										'ref_status'=>$val->inactive,
										'title'=>'Edit Supplier Stock Details',
										'style'=>'cursor: pointer;',
										// 'id'=>'view-stock-barcode-'.$val->id,
										'return'=>'false'));
										$con_avg_cost = floor(($val->avg_cost*100))/100;
										$con_avg_net_cost = floor(($val->avg_net_cost*100))/100;
										$default_stat = array('','Default');
										$CI->make->sRow(array('id'=>$val->id));
											//-----ORIGINAL
											$CI->make->th("<span class='label label-success';>".$default_stat[$val->is_default].'</span>', array('style'=>'width: 10%;'));
											$CI->make->th($CI->inventory_model->get_branch_code($val->branch_id), array('style'=>'width: 10%;'));
											$CI->make->th($supp_name,array('style'=>'width: 15%; text-align:center;'));
											$CI->make->th($val->supp_stock_code,array('style'=>'width: 10%; text-align:center;'));
											$CI->make->th($val->description,array('style'=>'width: 25%; text-align:center;'));
											$CI->make->th($val->unit_cost,array('style'=>'width: 10%; text-align:center;'));
											$CI->make->th(number_format($con_avg_cost, 2),array('style'=>'width: 10%; text-align:center;')); //avg cost
											$CI->make->th($con_avg_net_cost,array('style'=>'width: 10%; text-align:center;')); //avg net cost
											$CI->make->th($links,array('style'=>'width: 5%; text-align: center;')); //-----TEMPORARILY DISABLED
											// $CI->make->th(''); //-----BLANK MUNA
											//-----ORIGINAL
											
											// $CI->make->th($CI->inventory_model->get_branch_code($val->branch_id), array('style'=>'width: 15%;'));
											// $CI->make->th($val->supp_stock_code,array('style'=>'width: 16%;'));
											// $CI->make->th($val->description,array('style'=>'width: 35.5%;'));
											// $CI->make->th($val->unit_cost,array('style'=>'width: 10%;'));
											// $CI->make->th(number_format($con_avg_cost, 2),array('style'=>'width: 10%;')); //avg cost
											// $CI->make->th($con_avg_net_cost,array('style'=>'width: width: 13.5%; padding-right: 30px;')); //avg net cost
											// $CI->make->th($links,array('style'=>'width: ;')); //-----TEMPORARILY DISABLED
											// // $CI->make->th(''); //-----BLANK MUNA
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
//-----------Supplier Stock Form Maker-----end-----allyn
// // function srp_popup_form($uom=null, $qty=null, $stock_id=null, $branch_id=null, $price=0, $h_avg_net_cost=null, $h_cost_of_sales=null, $pk_id=null){
function srp_popup_form($branch_id=null, $srp_det=array()){
	$CI =& get_instance();
	$this_array = array();
	$this_array = $CI->inventory_model->get_stock_cost_details($srp_det['stock_id'], $branch_id);
	$passed_br_code = $CI->inventory_model->get_branch_code_from_id($branch_id);
	// echo $CI->inventory_model->db->last_query();
	// echo var_dump($this_array);
	
		$CI->make->sForm("inventory/srp_db",array('id'=>'srp_pop_form'));
			// echo "Passed Branch ID : ".$branch_id."<br>";
			// $CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
				// $CI->make->sDivCol(12);
					// $CI->make->span('Branch Code -> '.$CI->inventory_model->get_branch_code($branch_id));
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();
			
			$CI->make->sDivRow(array('style'=>'margin:2px;'));
				$CI->make->sDivCol(12,'center',0,array("style"=>''));
					$CI->make->sBox('success',array('div-form'));
						$CI->make->sBoxBody(array('style'=>''));
							$CI->make->hidden('saving_type','single', array('class'=>'c_saving_type'));
							$CI->make->sDivRow();
								$CI->make->sDivCol(6, 'left', 0, array('class'=>'branch_row'));
									// $CI->make->branchesCodeDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown br_dropdown'));
									$CI->make->branchesCodeDrop('Branch','branch_id',$passed_br_code,null,array('class'=>'rOkay aaa combobox branch_dropdown br_dropdown'));
									// $CI->make->hidden('cc_hidden_branch_id','', array('class'=>'cc_hidden_branch_id'));
									$CI->make->hidden('cc_hidden_branch_id',$branch_id, array('class'=>'cc_hidden_branch_id aaa'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								// $CI->make->sDivCol();
									// $CI->make->span('Branch Code -> '.$CI->inventory_model->get_branch_code($branch_id));
								// $CI->make->eDivCol();
								
								$CI->make->sDivCol(6);
									$CI->make->stockUOMCodeDrop('UOM','srp_uom',$srp_det['uom'],'Select UOM',array('class'=>'rOkay aaa combobox srp_uom_dropdown'));
									// $CI->make->hidden('hidden_stock_uom','', array('class'=>'c_hidden_stock_uom'));
									$CI->make->hidden('hidden_pk_id',$srp_det['pk_id'], array('class'=>'c_hidden_stock_uom'));
									$CI->make->hidden('hidden_stock_id',$srp_det['stock_id'], array('class'=>'c_hidden_stock_id'));
									$CI->make->hidden('hidden_barcode',$srp_det['barcode'], array('class'=>'c_hidden_barcode'));
									$CI->make->hidden('hidden_sales_type_id',$srp_det['sales_type_id'], array('class'=>'c_hidden_sales_type_id aaa'));
									$CI->make->hidden('hidden_stock_uom',$srp_det['uom'], array('class'=>'c_hidden_stock_uom'));
									// $CI->make->hidden('hidden_avg_net_cost',$this_array[0]->avg_net_cost, array('class'=>'c_avg_net_cost'));
									$CI->make->hidden('hidden_avg_net_cost',$srp_det['hidden_avg_net_cost'], array('class'=>'c_avg_net_cost aaa'));
									$CI->make->hidden('hidden_cost_of_sales',$srp_det['hidden_cost_of_sales'], array('class'=>'c_cost_of_sales aaa'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->input('Quantity','srp_qty',$srp_det['qty'],'Quantity per UOM',array('class'=>'rOkay aaa srp_uom_qty','maxchars'=>'20'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->input('Computed SRP','computed_srp','','',array('class'=>'rOkay aaa num_with_decimal', 'readonly'=>'readonly'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->input('Prevailing Unit Price','prevailing_unit_price',$srp_det['price'],'',array('class'=>'rOkay aaa num_with_decimal'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->H(4,"Mark Up",array('style'=>'margin-top:0px;margin-bottom:0px;'));
									$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->input('Landed Cost Markup','landed_cost_markup','','',array('class'=>'rOkay aaa num_with_decimal'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->input('Cost of Sales Markup','cost_of_sales_markup','','',array('class'=>'rOkay aaa num_with_decimal'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			
		$CI->make->eForm();
	
	return $CI->make->code();
}


function marginal_markdown_popup_form($latest_landed_cost,$items=array(),$branch_id=null){
	$CI =& get_instance();
$CI->make->sForm("inventory/marginal_markdown_db",array('id'=>'marginal_markdown_pop_form'));
	$branch_name = $CI->inventory_model->get_branch_name($branch_id);
$CI->make->H(4,"[".strtoupper($branch_name)."] Latest Landed  Cost : ".$latest_landed_cost,array('style'=>'margin-top:0px;margin-bottom:4px;'));
	
	$CI->make->sDivRow();
		$CI->make->sDivCol(12,'center',0,array("style"=>''));
			$CI->make->sBox('success',array('div-form'));
				$CI->make->sDivCol(5,'center',0,array("style"=>''));
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->inactiveDrop('Is Inactive','inactive',1,'',array('class'=>'inactive_dropdown','id'=>'inactive','style'=>'margin-top:5px;margin-bottom:4px;'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6, 'left', 0, array('class'=>'branch_row'));
								//	$CI->make->branchesCodeDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown br_dropdown'));
									$CI->make->hidden('saving_type','single');
									$CI->make->hidden('cc_hidden_branch_id','', array('class'=>'cc_hidden_branch_id'));
									$CI->make->hidden('hidden_latest_landed_cost');
									$CI->make->hidden('hidden_marginal_stock_id',$items['stock_id']);
									$CI->make->hidden('hidden_marginal_barcode',$items['barcode']);
									$CI->make->hidden('hidden_marginal_branch_id',$branch_id);
									$CI->make->hidden('hidden_marginal_sales_type_id',$items['sales_type_id']);
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
							$CI->make->sDivRow();
								$CI->make->sDivCol(4);
									$CI->make->input('Qty','qty1','2','',array('class'=>'rOkay num_with_decimal','disabled'=>'disabled'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
									$CI->make->input('Markup','markup1','',null,array('class'=>'rOkay num_without_decimal formInputMini','disabled'=>'disabled'),"%");
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
									$CI->make->input('Unit Price','unit_price1','','',array('class'=>'rOkay num_with_decimal','disabled'=>'disabled'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
							$CI->make->sDivRow();
								$CI->make->sDivCol(4);
									$CI->make->input('','qty2','3','',array('class'=>' num_with_decimal','disabled'=>'disabled'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
									$CI->make->input('','markup2','',null,array('class'=>'num_without_decimal formInputMini','disabled'=>'disabled'),"%");
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
									$CI->make->input('','unit_price2','','',array('class'=>'num_with_decimal','disabled'=>'disabled'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
							$CI->make->sDivRow();
								$CI->make->sDivCol(4);
									$CI->make->input('','qty3','4','',array('class'=>'num_with_decimal','disabled'=>'disabled'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
									$CI->make->input('','markup3','',null,array('class'=>'num_without_decimal formInputMini','disabled'=>'disabled'),"%");
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
									$CI->make->input('','unit_price3','','',array('class'=>'num_with_decimal','disabled'=>'disabled'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
				$CI->make->eDivCol();
				
				
				
				$CI->make->sDivCol(7,'center',0,array("style"=>''));
					$CI->make->sBox('primary',array('div-form'));
						$CI->make->sBoxBody();
								$CI->make->sDivCol();
								$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
										$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
											$CI->make->th('Barcode',array('style'=>'width: 10%;'));
											$CI->make->th('Sales Type',array('style'=>'width: 5%; text-align: center;'));
											$CI->make->th('Qty',array('style'=>'width: 5%; text-align: center;'));
											$CI->make->th('Markup',array('style'=>'width: 10%; text-align: center;'));
											$CI->make->th('Unit Price',array('style'=>'width: 5%; text-align: center;'));
										$CI->make->eRow();
									$CI->make->eTable();	
								$CI->make->eDiv();
							$CI->make->eDivCol();
							$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
								$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$br_array = $st_array = array();
										$br_array = $CI->inventory_model->get_marginal_markdown($items['stock_id'],$items['barcode'],$branch_id,$items['sales_type_id']);
										foreach($br_array as $br_vals){
										$sales_type_name = $CI->inventory_model->get_sales_type($br_vals->sales_type_id);
											$CI->make->sRow();
												$CI->make->td($br_vals->barcode, array('style'=>'width: 10%;'));	
												$CI->make->td($sales_type_name, array('style'=>'width: 5%; text-align: center;'));	
												$CI->make->td($br_vals->qty, array('style'=>'width: 5%;  text-align: center;'));	
												$CI->make->td($br_vals->markup, array('style'=>'width: 10%;  text-align: center;'));
												$CI->make->td($br_vals->unit_price, array('style'=>'width: 5%;  text-align: center;'));
											$CI->make->eRow();
											}
									$CI->make->eTable();
								$CI->make->eDiv();
							$CI->make->eDivCol();
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
							
							
							
							
							
							
							
					$CI->make->eBox();
						
				$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eDivCol();
			$CI->make->eBox();
		$CI->make->eDivCol();
	
$CI->make->eForm();
	
	return $CI->make->code();
}

//end marginal

function sched_markdown_popup_form($branch_id=null, $sb_det=array()){
	$CI =& get_instance();
		// echo var_dump($sb_det);
		$CI->make->sForm("inventory/sched_markdown_db",array('id'=>'sched_markdown_pop_form'));
			
			// echo "Passed Branch ID : ".$branch_id."<br>";
			// $CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
				// $CI->make->sDivCol(12);
					// $CI->make->span('Branch Code -> '.$CI->inventory_model->get_branch_code($branch_id));
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();
			
			$CI->make->sDivRow(array('style'=>'margin:2px;'));
				$CI->make->sDivCol(5,'center',0,array("style"=>''));
					$CI->make->sBox('success',array('div-form'));
						$CI->make->sBoxBody(array('style'=>''));
							$CI->make->hidden('saving_type','single', array('class'=>'c_saving_type'));
							$CI->make->hidden('hidden_stock_id',$sb_det['stock_id'], array('class'=>'c_hidden_stock_id'));
							$CI->make->hidden('hidden_barcode',$sb_det['barcode'], array('class'=>'c_hidden_barcode'));
							$CI->make->hidden('hidden_sales_type_id',$sb_det['sales_type_id'], array('class'=>'c_hidden_sales_type_id'));
							$CI->make->hidden('hidden_original_price',$sb_det['price'], array('class'=>'c_hidden_original_price'));
							$CI->make->hidden('hidden_discounted_price',$sb_det['price'], array('class'=>'c_hidden_discounted_price'));
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->inactiveDrop('Is Inactive','inactive',1,'',array('class'=>'inactive_dropdown'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6, 'left', 0, array('class'=>'branch_row'));
									$CI->make->branchesCodeDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown br_dropdown'));
									$CI->make->hidden('cc_hidden_branch_id','', array('class'=>'cc_hidden_branch_id'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->datefield('Date From','start_date',date('m/d/Y'),'',array('class'=>'rOkay'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->datefield('To','end_date',date('m/d/Y'),'',array('class'=>'rOkay'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->timefield('Time On','start_time',null,'Start Time', array('class'=>'rOkay'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->timefield('Time Off','end_time',null,'End Time', array('class'=>'rOkay'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->input('Markdown','markdown','',null,array('class'=>'num_without_decimal formInputMini'),"%");
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->input('Discounted Price','discounted_price',$sb_det['price'],'',array('class'=>'rOkay num_with_decimal'));
									
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
				
				$CI->make->sDivCol(7,'center',0,array("style"=>''));
					$CI->make->sBox('primary',array('div-form'));
						$CI->make->sBoxBody();
								$CI->make->sDivCol();
								$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
										$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
											$CI->make->th('Start Date',array('style'=>'width: 10%;'));
											$CI->make->th('End Date',array('style'=>'width: 10%; text-align: center;'));
											$CI->make->th('Start Time',array('style'=>'width: 5%; text-align: center;'));
											$CI->make->th('End Time',array('style'=>'width: 5%; text-align: center;'));
											$CI->make->th('Branch',array('style'=>'width: 10%; text-align: center;'));
											$CI->make->th('Original Price',array('style'=>'width: 5%; text-align: center;'));
											$CI->make->th('Discounted Price',array('style'=>'width: 5%; text-align: center;'));
										$CI->make->eRow();
									$CI->make->eTable();	
								$CI->make->eDiv();
							$CI->make->eDivCol();
							$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
								$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$br_array = $st_array = array();
										$br_array = $CI->inventory_model->get_scheduled_markdown($sb_det['barcode'], $sb_det['sales_type_id']);
										foreach($br_array as $br_vals){
											$CI->make->sRow();
												$CI->make->td(date('M-d-Y',strtotime($br_vals->start_date)), array('style'=>'width: 10%;'));	
												$CI->make->td(date('M-d-Y',strtotime($br_vals->end_date)), array('style'=>'width: 10%; text-align: center;'));
												$CI->make->td(date('h:i A', strtotime($br_vals->start_time)), array('style'=>'width: 5%; text-align: center;'));	
												$CI->make->td(date('h:i A', strtotime($br_vals->end_time)), array('style'=>'width: 5%;  text-align: center;'));	
												$CI->make->td($CI->inventory_model->get_branch_name($br_vals->branch_id), array('style'=>'width: 10%;  text-align: center;'));
												$CI->make->td($br_vals->original_price, array('style'=>'width: 5%;  text-align: center;'));
												$CI->make->td($br_vals->discounted_price, array('style'=>'width: 5%;  text-align: center;'));
											$CI->make->eRow();
											}
									$CI->make->eTable();
								$CI->make->eDiv();
							$CI->make->eDivCol();
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
				//------------------ADO
			$CI->make->eDivRow();
			
		$CI->make->eForm();
	
	return $CI->make->code();
}
//-----STOCKS MASTER-----APM-----END
//-----Movement Types Maintenance-----START
function build_movement_types_maintenance_list($list=array()){
$CI =& get_instance();
$subcat_desc = "";
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Movement Type',base_url().'inventory/manage_movement_type/',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Code' => array('width'=>'20%'),
									'Description' => array('width'=>'30%'),
									'Is Adjustment' => array('width'=>'20%'),
									'Is Positive' => array('width'=>'20%'),
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $val){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'inventory/manage_movement_type/'.$val->movement_type_id,array("return"=>true));
								$rows[] = array(
											  $val->movement_type_id,
											  $val->description,
											  ($val->is_adjustment == 1 ? 'Yes' : 'No'),
											  ($val->is_positive == 1 ? 'Yes' : 'No'),
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
function build_movement_types_maintenance_form($item=''){
$CI =& get_instance();
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'inventory/movement_types',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
					$tabs = array(
						//fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link')
					);
					$CI->make->tabHead($tabs,null,array());
					
					$CI->make->sTabBody(array());
						$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

							$CI->make->sForm("inventory/movement_type_db",array('id'=>'movement_type_form'));
								$CI->make->hidden('id',iSetObj($item,'movement_type_id'));
								$CI->make->hidden('movement_type_id',iSetObj($item,'movement_type_id'));
								$CI->make->hidden('mode',((iSetObj($item,'movement_type_id')) ? 'edit' : 'add'));

								$CI->make->sDivRow();
									//-----1st Row
									$CI->make->sDivCol(4);
									$CI->make->input('Description','description',iSetObj($item,'description'),null,array('class'=>'rOkay reqForm'));
									$CI->make->eDivCol();

									//-----2nd Row
									// $CI->make->sDivCol(3);
										// $CI->make->input('Next ID','next_id',iSetObj($item,'next_id'),null,array('class'=>'rOkay'));
									// $CI->make->eDivCol();
									
									//-----3rd Row
									$CI->make->sDivCol(4);
										$CI->make->yesOrNoNumValDrop('Is Adjustment ? ','is_adjustment',iSetObj($item,'is_adjustment'),'',array('class'=>'reqForm'));
									$CI->make->eDivCol();
									
									//-----4rt Row
									$CI->make->sDivCol(4);
										$CI->make->yesOrNoNumValDrop('Is Positive ? ','is_positive',iSetObj($item,'is_positive'),'',array('class'=>'reqForm'));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
									

								$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
									$CI->make->sDivCol(4);
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(4, 'right');
										$CI->make->button(fa('fa-save').' Save Management Type',array('id'=>'save-btn','class'=>'btn-block'),'primary');
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
function build_movements_inq_form($ref = null, $items=array())
{
$CI =& get_instance();
	
	$branch_result = array();
	$br_sa_qty = $br_sr_qty = $br_bo_qty = 0;
	
	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		
		$CI->make->sDivCol(4);
			$CI->make->sBox('warning',array('div-form'));
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										// $CI->make->th('QOH');
										$CI->make->th('Branch', array('style'=>'width: 40%; text-align: left;'));
										$CI->make->th('Selling Area', array('style'=>'width: 20%; text-align: center;'));
										$CI->make->th('Stock Room', array('style'=>'width: 20%; text-align: center;'));
										$CI->make->th('B.O. Room', array('style'=>'width: 20%; text-align: center;'));
									$CI->make->eRow();
								$CI->make->eTable();	
							$CI->make->eDiv();
							$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 400px; overflow-x: none; overflow-y: scroll;'));
								$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
											$branch_result = $CI->inventory_model->get_all_branch_details();
											foreach($branch_result as $br_val){
												// $br_sa_qty = $br_sr_qty = $br_bo_qty = 0;
												// echo $br_val->code."<---<br>";
												$br_sa_qty = $CI->inventory_model->get_branch_stocks_current_count($ref, $br_val->id, 1);
												$br_sr_qty = $CI->inventory_model->get_branch_stocks_current_count($ref, $br_val->id, 2);
												$br_bo_qty = $CI->inventory_model->get_branch_stocks_current_count($ref, $br_val->id, 3);
												$CI->make->sRow();
													$CI->make->td($br_val->code, array('style'=>'width: 40%; text-align: left;'));
													$CI->make->td($br_sa_qty, array('style'=>'width: 20%; text-align: center;'));
													$CI->make->td($br_sr_qty, array('style'=>'width: 20%; text-align: center;'));
													$CI->make->td($br_bo_qty, array('style'=>'width: 20%; text-align: center;'));
												$CI->make->eRow();
											}
									$CI->make->eTable();	
								$CI->make->eDiv();
							$CI->make->eDivCol();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		$CI->make->sDivCol(8);
			$CI->make->sDivRow();
				$CI->make->sDivCol();
					$CI->make->sBox('success',array('div-form'));
						$CI->make->sBoxBody();
							$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
								$CI->make->sForm("inventory/movements_result",array('id'=>'movements_search_form'));
									// $CI->make->sDivCol(3,'right',0,array('style'=>'margin-left:250px;margin-bottom:10px;'));
									$CI->make->sDivCol(3,'center',0,array('style'=>'margin-bottom:10px;'));
										$CI->make->hidden('stock_id',$ref, array('class'=>'rOkay input_form'));
										$CI->make->datefield('Start Date','start_date',date('m/d/Y'),'',array('class'=>'rOkay'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
										$CI->make->datefield('End Date','end_date',date('m/d/Y'),'',array('class'=>'rOkay'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6,'left',0,array('style'=>'margin-top:25px;margin-bottom:7px;'));
										$CI->make->A(fa('fa-search').' Search','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:center;'));
										$CI->make->A(fa('fa-reply').' Back to Main List','#',array('class'=>'btn btn-default','id'=>'btn-movement-back','style'=>'text-align:center; margin-left: 30px;'));
									$CI->make->eDivCol();
								$CI->make->eForm();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			$CI->make->sDivRow();
				$CI->make->sDivCol();
					$CI->make->sBox('info',array('id'=>'movement_lists','style'=>'min-height:350px;'));
						$CI->make->sBoxBody(array('id'=>'sboxbody_id'));
							$CI->make->sDivRow();
								$CI->make->sDivCol(12);
									$CI->make->sDiv(array('class'=>'table-responsive'));
										$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
											$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
												$CI->make->th('TRX #');
												$CI->make->th('Branch',array());
												$CI->make->th('Barcode',array('style'=>'width: 7%;text-align: center;'));
												$CI->make->th('Description',array('style'=>' text-align: center;'));
												$CI->make->th('Movement Type',array('style'=>'width: 14%;'));
												$CI->make->th('Stock Location',array());
												$CI->make->th('Transaction Date',array());
												$CI->make->th('UOM',array());
												$CI->make->th('Qty in Pcs',array('style'=>'width: 4.5%;text-align: center;'));
												$CI->make->th('Unit Cost',array('style'=>'text-align: center;'));
												// $CI->make->th('Standard Cost');
												$CI->make->th('User');
											$CI->make->eRow();
										$CI->make->eTable();	
									$CI->make->eDiv();
								$CI->make->eDivCol();
								$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
									// $CI->make->sDivCol(12, 'left', 0, array('style'=>''));
										$CI->make->sDiv(array('class'=>'table-responsive'));
											$CI->make->sTable(array('class'=>'table table-hover','id'=>'list-movements-tbl', 'border'=>'0px'));
												$movement_type = $branch_code = $stock_location = $stock_id = '';
												foreach($items as $val){
													// $movement_type = $CI->inventory_model->get_movement_types_desc($val->movement_type_id); //-----OLD
													$movement_type = $CI->inventory_model->get_stock_moves_types_desc($val->type);
													$branch_code = $CI->inventory_model->get_branch_code($val->branch_id);
													$stock_id = $val->stock_id;
													if($val->stock_location == 1){
														$stock_location = 'Selling Area';
													}else if($val->stock_location == 2){
														$stock_location = 'Stock Room';
													}else{
														$stock_location = 'B.O. Room';
													}
													$CI->make->sRow();
														$CI->make->td($val->trans_no);	//-----OLD : $CI->make->td($val->movement_id);	
														$CI->make->td($branch_code, array('style'=>'width: 10%; text-align: center;'));	
														$CI->make->td($val->barcode,array('style'=>'width: 8%;'));	
														$CI->make->td($CI->inventory_model->get_barcode_description($val->barcode), array('style'=>'width: 8%;text-align: center;'));	
														$CI->make->td($movement_type, array('style'=>'width: 14%; text-align: center;'));	
														$CI->make->td($stock_location, array('style'=>'width: 10%; text-align: center;'));	
														$CI->make->td(date('Y-M-d', strtotime($val->trans_date)), array('style'=>'width: 15%; text-align: center;'));	
														// $CI->make->td($val->uom, array('style'=>'width: 8%; text-align: center;'));	//-----OLD
														$CI->make->td($val->stock_uom, array('style'=>'width: 8%; text-align: center;'));	
														$CI->make->td($val->qty_pcs, array('style'=>'text-align: center;'));	
														$CI->make->td($val->unit_cost, array('style'=>'text-align: center;'));	
														// $CI->make->td($val->standard_cost, array('style'=>'width: 8%;'));	
														$CI->make->td($CI->inventory_model->created_by($val->user_id), array('style'=>'text-align: center;'));	
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
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	// $CI->make->sDivRow(array('style'=>'margin:5px;'));
		// $CI->make->sBox('info',array('id'=>'movement_lists','style'=>'min-height:350px;'));
			// $CI->make->sBoxBody(array('id'=>'sboxbody_id'));
				// $CI->make->sDivRow();
					// $CI->make->sDivCol(12);
							// $CI->make->sDiv(array('class'=>'table-responsive'));
								// $CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									// $CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										// $CI->make->th('TRX #');
										// $CI->make->th('Branch',array());
										// $CI->make->th('Barcode',array('style'=>'width: 7%;text-align: center;'));
										// $CI->make->th('Description',array('style'=>' text-align: center;'));
										// $CI->make->th('Movement Type',array('style'=>'width: 14%;'));
										// $CI->make->th('Stock Location',array());
										// $CI->make->th('Transaction Date',array());
										// $CI->make->th('UOM',array());
										// $CI->make->th('Qty in Pcs',array('style'=>'width: 4.5%;text-align: center;'));
										// $CI->make->th('Unit Cost',array('style'=>'text-align: center;'));
										// // $CI->make->th('Standard Cost');
										// $CI->make->th('User');
									// $CI->make->eRow();
								// $CI->make->eTable();	
							// $CI->make->eDiv();
						// $CI->make->eDivCol();
					// $CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
						// // $CI->make->sDivCol(12, 'left', 0, array('style'=>''));
							// $CI->make->sDiv(array('class'=>'table-responsive'));
								// $CI->make->sTable(array('class'=>'table table-hover','id'=>'list-movements-tbl', 'border'=>'0px'));
									// $movement_type = $branch_code = $stock_location = $stock_id = '';
									// foreach($items as $val){
										// // $movement_type = $CI->inventory_model->get_movement_types_desc($val->movement_type_id); //-----OLD
										// $movement_type = $CI->inventory_model->get_stock_moves_types_desc($val->type);
										// $branch_code = $CI->inventory_model->get_branch_code($val->branch_id);
										// $stock_id = $val->stock_id;
										// if($val->stock_location == 1){
											// $stock_location = 'Selling Area';
										// }else if($val->stock_location == 2){
											// $stock_location = 'Stock Room';
										// }else{
											// $stock_location = 'B.O. Room';
										// }
										// $CI->make->sRow();
											// $CI->make->td($val->trans_no);	//-----OLD : $CI->make->td($val->movement_id);	
											// $CI->make->td($branch_code, array('style'=>'width: 10%; text-align: center;'));	
											// $CI->make->td($val->barcode,array('style'=>'width: 8%;'));	
											// $CI->make->td($CI->inventory_model->get_barcode_description($val->barcode), array('style'=>'width: 8%;text-align: center;'));	
											// $CI->make->td($movement_type, array('style'=>'width: 14%; text-align: center;'));	
											// $CI->make->td($stock_location, array('style'=>'width: 10%; text-align: center;'));	
											// $CI->make->td(date('Y-M-d', strtotime($val->trans_date)), array('style'=>'width: 15%; text-align: center;'));	
											// // $CI->make->td($val->uom, array('style'=>'width: 8%; text-align: center;'));	//-----OLD
											// $CI->make->td($val->stock_uom, array('style'=>'width: 8%; text-align: center;'));	
											// $CI->make->td($val->qty_pcs, array('style'=>'text-align: center;'));	
											// $CI->make->td($val->unit_cost, array('style'=>'text-align: center;'));	
											// // $CI->make->td($val->standard_cost, array('style'=>'width: 8%;'));	
											// $CI->make->td($CI->inventory_model->created_by($val->user_id), array('style'=>'text-align: center;'));	
										// $CI->make->eRow();
									// }
								// $CI->make->eTable();
							// $CI->make->eDiv();
						// $CI->make->eDivCol();
				// $CI->make->eDivRow();
			// $CI->make->eBoxBody();
		// $CI->make->eBox();
		// $CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			// $CI->make->sBoxBody();
			// $CI->make->eBoxBody();
		// $CI->make->eBox();
	// $CI->make->eDivRow();

	return $CI->make->code();
	
}
function build_movement_display($items = array()){
	
	$CI =& get_instance();

			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol(12);
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
									$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
										//-----OLD-----start
										// $CI->make->th('TRX #');
										// $CI->make->th('Movement Type',array('style'=>'width: 14%;'));
										// $CI->make->th('Branch',array());
										// $CI->make->th('Stock Location',array());
										// $CI->make->th('Date Posted',array());
										// $CI->make->th('Barcode',array('style'=>'width: 7%;text-align: center;'));
										// $CI->make->th('Description',array('style'=>' text-align: center;'));
										// $CI->make->th('UOM',array());
										// $CI->make->th('qty',array('style'=>'width: 4.5%;text-align: center;'));
										// $CI->make->th('Unit Cost',array('style'=>'text-align: center;'));
										// $CI->make->th('Avg Unit Cost');
										//-----OLD-----end
										$CI->make->th('TRX #');
										$CI->make->th('Branch',array());
										$CI->make->th('Barcode',array('style'=>'width: 7%;text-align: center;'));
										$CI->make->th('Description',array('style'=>' text-align: center;'));
										$CI->make->th('Movement Type',array('style'=>'width: 14%;'));
										$CI->make->th('Stock Location',array());
										$CI->make->th('Transaction Date',array());
										$CI->make->th('UOM',array());
										$CI->make->th('Qty in Pcs',array('style'=>'width: 4.5%;text-align: center;'));
										$CI->make->th('Unit Cost',array('style'=>'text-align: center;'));
										// $CI->make->th('Standard Cost');
										$CI->make->th('User');
									$CI->make->eRow();
								$CI->make->eTable();	
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->sDivCol(12, 'left', 0, array('style'=>'height: 200px; overflow-x: none; overflow-y: scroll;'));
						// $CI->make->sDivCol(12, 'left', 0, array('style'=>''));
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'list-movements-tbl', 'border'=>'0px'));
									$movement_type = $branch_code = $stock_location = $stock_id = '';
									foreach($items as $val){
										//-----OLD-----start
										// $movement_type = $CI->inventory_model->get_movement_types_desc($val->movement_type_id);
										// $branch_code = $CI->inventory_model->get_branch_code($val->branch_id);
										// $stock_id = $val->stock_id;
										// if($val->stock_location == 1){
											// $stock_location = 'Selling Area';
										// }else if($val->stock_location == 2){
											// $stock_location = 'Stock Room';
										// }else{
											// $stock_location = 'B.O. Room';
										// }
										// $CI->make->sRow();
											// $CI->make->td($val->movement_id);	
											// $CI->make->td($movement_type, array('style'=>'width: 14%; text-align: center;'));	
											// $CI->make->td($branch_code, array('style'=>'width: 10%; text-align: center;'));	
											// $CI->make->td($stock_location, array('style'=>'width: 10%; text-align: center;'));	
											// $CI->make->td(date('Y-M-d', strtotime($val->date_posted)), array('style'=>'width: 15%; text-align: center;'));	
											// $CI->make->td($val->barcode,array('style'=>'width: 8%;'));	
											// $CI->make->td($val->description, array('style'=>'width: 8%;text-align: center;'));	
											// $CI->make->td($val->uom, array('style'=>'width: 8%; text-align: center;'));	
											// $CI->make->td($val->qty, array('style'=>'width: 8%;'));	
											// $CI->make->td($val->unit_cost, array('style'=>'width: 8%;'));	
											// $CI->make->td($val->avg_unit_cost, array('style'=>'width: 8%;'));	
										// $CI->make->eRow();
										//-----OLD-----end
										// $movement_type = $CI->inventory_model->get_movement_types_desc($val->movement_type_id); //-----OLD
										$movement_type = $CI->inventory_model->get_stock_moves_types_desc($val->type);
										$branch_code = $CI->inventory_model->get_branch_code($val->branch_id);
										$stock_id = $val->stock_id;
										if($val->stock_location == 1){
											$stock_location = 'Selling Area';
										}else if($val->stock_location == 2){
											$stock_location = 'Stock Room';
										}else{
											$stock_location = 'B.O. Room';
										}
										$CI->make->sRow();
											$CI->make->td($val->trans_no);	//-----OLD : $CI->make->td($val->movement_id);	
											$CI->make->td($branch_code, array('style'=>'width: 10%; text-align: center;'));	
											$CI->make->td($val->barcode,array('style'=>'width: 8%;'));	
											$CI->make->td($CI->inventory_model->get_barcode_description($val->barcode), array('style'=>'width: 8%;text-align: center;'));	
											$CI->make->td($movement_type, array('style'=>'width: 14%; text-align: center;'));	
											$CI->make->td($stock_location, array('style'=>'width: 10%; text-align: center;'));	
											$CI->make->td(date('Y-M-d', strtotime($val->trans_date)), array('style'=>'width: 15%; text-align: center;'));	
											// $CI->make->td($val->uom, array('style'=>'width: 8%; text-align: center;'));	//-----OLD
											$CI->make->td($val->stock_uom, array('style'=>'width: 8%; text-align: center;'));	
											$CI->make->td($val->qty_pcs, array('style'=>'text-align: center;'));	
											$CI->make->td($val->unit_cost, array('style'=>'text-align: center;'));	
											// $CI->make->td($val->standard_cost, array('style'=>'width: 8%;'));	
											$CI->make->td($CI->inventory_model->created_by($val->user_id), array('style'=>'text-align: center;'));	
										$CI->make->eRow();
									}
								$CI->make->eTable();
							$CI->make->eDiv();
						$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();

	return $CI->make->code();
}
//-----Movement Types Maintenance-----END
