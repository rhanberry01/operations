<?php


function line_void_form($list=array()){
	
	$CI =& get_instance();
	
	
echo "
	<style>

	td:hover {
    color: #fff;
    background: #f44;
		}
		
	a:focus {
    background: #f44;
		}
	
	</style>
	<div  style ='height:500px; overflow: scroll;'> <table class='table-responsive table table-bordered table-striped ' style='margin-top:10px;  '>
		<th>Barcode</th>
		<th>Item Name</th>
		<th>Item Price</th>
		<th>Qyt</th>
		<th> </th>";
	foreach($list as $val){
		echo'<tr>';
		echo '<td>'.$val->Barcode.'</td>';
		echo '<td>'.$val->Description.'</td>';
		echo '<td>'.$val->Extended.'</td>';
		echo '<td>'.$val->Qty.'</td>';
		$links = $CI->make->A(fa('fa-trash-o fa-lg fa-fw'),base_url().'cashier/delete_products/'.$val->id,array("return"=>true));
		echo '<td>'.$links.'</td>';
		echo '</tr>'; 		
	
	}
	
	
	echo "</table></div>";
	
		
}

function cashier_Page_form($list=array(), $dis_type){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();	
	    	$CI->make->sDivRow();
				$CI->make->sDivCol(4,'center');						
					$CI->make->sBox('primary');					
						/*$CI->make->sDiv(array('id'=>'tender_type_id'));
							$CI->make->sBox('default',array('class'=>'loads-div select-payment-div box-solid bg-dark-green'));
								$CI->make->sBoxHead(array('class'=>'bg-dark-green'));
									$CI->make->boxTitle('&nbsp;');
								$CI->make->eBoxHead();
								$CI->make->sBoxBody(array('class'=>'bg-dark-green'));
										$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->sRow();
											$CI->make->th('Cash',array('style'=>'color: #ef9610;font-weight: bold;','tabindex'=>1));
										$CI->make->eRow();
									$CI->make->sRow();
											$CI->make->th('Debit',array('style'=>'color: #ef9610;font-weight: bold;','tabindex'=>2));
										$CI->make->eRow();
									$CI->make->sRow();
											$CI->make->th('Credit',array('style'=>'color: #ef9610;font-weight: bold;','tabindex'=>3));
										$CI->make->eRow();
									$CI->make->sRow();
											$CI->make->th('GC',array('style'=>'color: #ef9610;font-weight: bold;','tabindex'=>4));
										$CI->make->eRow();
									
										$CI->make->eTable();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDiv();							
						*/		
						$CI->make->sDiv(array('id'=>'price_inq_div'));	
								$CI->make->sBoxBody();
										$CI->make->sDivRow();
											$CI->make->sDivCol(12, 'center');										
												$CI->make->input('', 'price_inq_barcode', '', 'Scan Barcode', '', fa('fa-search'));
											$CI->make->eDivCol();									
										$CI->make->eDivRow();
										$CI->make->sDivRow();
											$CI->make->sDivCol(12, 'left');						
												$CI->make->li('Press F5 to go back', array('style'=>'margin-top: 5px; padding-right: 30px;'));
											$CI->make->eDivCol();									
										$CI->make->eDivRow();
										$CI->make->sDivCol();
										$CI->make->eDivCol();
												
								$CI->make->eBoxBody();
							
						$CI->make->eDiv();		
						$CI->make->sDiv(array('id'=>'look_up_div'));	
								$CI->make->sBoxBody();
										$CI->make->sDivRow();
											$CI->make->sDivCol(12, 'center');										
												$CI->make->input('', 'price_inq_description', '', 'Description', '', fa('fa-search'));
											$CI->make->eDivCol();									
										$CI->make->eDivRow();
										$CI->make->sDivRow();
											$CI->make->sDivCol(12, 'left');						
												$CI->make->li('Press F5 to go back', array('style'=>'margin-top: 5px; padding-right: 30px;'));
											$CI->make->eDivCol();									
										$CI->make->eDivRow();
										$CI->make->sDivCol();
										$CI->make->eDivCol();
												
								$CI->make->eBoxBody();	
						$CI->make->eDiv();
						
						$CI->make->sDiv(array('id'=>'search_div'));	
							//$CI->make->sBox('primary');					
								$CI->make->sBoxBody();
										$CI->make->sDivRow();
											$CI->make->sDivCol(12, 'center');										
												$CI->make->input('', 'search_item', '', 'Scan Barcode', array(''), fa('fa-cart-plus'));
											$CI->make->eDivCol();									
										$CI->make->eDivRow();
										$CI->make->sDivCol();
										$CI->make->eDivCol();
												
										$CI->make->sDivRow();
											$CI->make->sDivCol(6);											
												$CI->make->A(fa('fa-bed').' Discounts &nbsp;&nbsp;&nbsp;*Alt -',base_url(),array('id'=>'add_discount', 'class'=>'btn  btn-primary'));
											$CI->make->eDivCol();
											
											$CI->make->sDivCol(1);
											$CI->make->eDivCol();
											
											$CI->make->sDivCol(2);
												$CI->make->A(fa('fa-chevron-down').' Void All &nbsp;*Alt F9',base_url(),array('id'=>'void_all_scanned', 'class'=>'btn btn-primary'));
											$CI->make->eDivCol();
										$CI->make->eDivRow();
									
										$CI->make->sDivRow();
											$CI->make->sDivCol(5);
												$CI->make->A(fa('fa-binoculars').' Price Inquiry&nbsp; *F4','',array('id'=>'price_inq', 'class'=>'btn btn-success ', 'style'=>'margin-top: 10px;'));
											$CI->make->eDivCol();
											
											$CI->make->sDivCol(2);
											$CI->make->eDivCol();
											
											$CI->make->sDivCol(2);
												/*$CI->make->A(fa('fa-pencil fa-lg fa-fw'), 'inventory/view_stock_barcode_details_pop/'.$val->id.'/'.$val->barcode, array(
										'class'=>'edit_me_btn',
										// 'rata-title'=>'View Stock Barcode Details #'.$val->id,
										'rata-pass'=>'inventory/view_stock_barcode_details_pop',
										'ref'=>$val->id,
										'id'=>'view-stock-barcode-'.$val->id,
										'return'=>'false'))*/
												
												//$CI->make->hidden('uom_id',iSetObj($x,'uom_id'));
												$CI->make->A(fa('fa-folder-o').'Look Up &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*F7 &nbsp;','',array('id'=>'look_up_id', 'class'=>'btn btn-success', 'style'=>'margin-top: 10px;'));
												//$CI->make->A(fa('fa-folder-o').'Look Up &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*F7 &nbsp;','cashier/line_void_scanned_items',array('id'=>'line_void', 'class'=>'btn btn-success', 'style'=>'margin-top: 10px;','rata-pass'=>'cashier/line_void_scanned_items'));
											$CI->make->eDivCol();
											
										$CI->make->eDivRow();
											
										$CI->make->sDivRow();
											$CI->make->sDivCol(3);
											$CI->make->eDivCol();
											
											$CI->make->sDivCol(4,'center');
												$CI->make->A(fa('fa-money').'Tender Types *Alt P','',array('id'=>'choose_tender_type','class'=>'btn btn-warning', 'style'=>'margin-top: 10px; padding-right: 25px;'));
											$CI->make->eDivCol();
											
										$CI->make->eDivRow();
											
										$CI->make->sDivRow();
											$CI->make->sDivCol(3);
											$CI->make->eDivCol();
											
											$CI->make->sDivCol(4,'center');
												$CI->make->A(fa('fa-arrow-circle-right').' Settle Transaction',base_url().'cashier/manage_cashier',array('class'=>'btn btn-danger', 'style'=>'margin-top: 10px; padding-right: 30px;'));
											$CI->make->eDivCol();
											
										$CI->make->eDivRow();
											
								$CI->make->eBoxBody();
								//$CI->make->eForm();
							//$CI->make->eBox();
							
						$CI->make->eDiv();
						
					$CI->make->eBox();	
					$CI->make->sDiv(array('id'=>'total_amount_div'));	
						
						$CI->make->sBox('danger');
							$CI->make->sBoxBody();
									$CI->make->sDivRow();
										$CI->make->sDivCol(12, 'center');	
											$amount = 0;
											foreach($list as $tot_amount){
												$amount += $tot_amount->Extended;
											}		
											$CI->make->H(3, 'Total: '.number_format($amount, 2), array('style'=>'margin:10px; align: left; font-size: 50px;font-family: "Times New Roman", Times, serif;font-color:#aa0000;'));
										$CI->make->eDivCol();									
									$CI->make->eDivRow();
									
									$CI->make->sDivRow();
										$CI->make->sDivCol(6, 'left');	
											$amount = 0;
											foreach($list as $tot_amount){
												$amount += $tot_amount->Extended;
											}			
											$CI->make->H(3, 'Payment Type: '.'sample', array('style'=>'font-size: 15px;font-family: "Times New Roman", Times, serif;'));
										$CI->make->eDivCol();	
										$CI->make->sDivCol(6, 'right');	
											$CI->make->H(3, 'Discount: '.$dis_type, array('style'=>'font-size: 15px;font-family: "Times New Roman", Times, serif;'));
										$CI->make->eDivCol();									
									$CI->make->eDivRow();
									
									
							$CI->make->eBoxBody();
						$CI->make->eBox();
						
					$CI->make->eDiv();		
					
				$CI->make->eDivCol();
				
				$CI->make->sDivCol(8,'left');
					$CI->make->sDiv(array('id'=>'file-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('success',array('div-form'));
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
					$CI->make->sBox('success');
						$CI->make->sDiv(array('id'=>'list_purchased', 'style'=>'height: 500px; margin-right: 0; margin-left: 0; width: 100%; overflow-y:scroll;'));					
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
									$CI->make->sRow();
										$CI->make->th('');
										$CI->make->th('Barcode');
										$CI->make->th('Description',array('style'=>''));
										$CI->make->th('UOM',array('style'=>''));
										$CI->make->th('Qty',array('style'=>''));
										$CI->make->th('Price',array('style'=>''));
									$CI->make->eRow();
									$num = 0;
									foreach($list as $val){
										$CI->make->sRow();
										$num = $num+1;
											$CI->make->td($val->id,array('style'=>'color:transparent;','tabindex'=>$num));
											$CI->make->td($val->Barcode);
											$CI->make->td($val->Description,array('style'=>''));
											$CI->make->td($val->UOM,array('style'=>''));
											$CI->make->td($val->Qty,array('style'=>''));
											$CI->make->td(num($val->Extended),array('style'=>''));
										$CI->make->eRow();
									}
									/*$CI->make->sRow();
										$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
									$CI->make->eRow();*/
								$CI->make->eTable();
								/*$CI->make->sBoxBody();
									$th = array(
											'Barcode' => array('width'=>'30%'),
											'Item Name' => array('width'=>'40%'),
											'Item Price' => array('width'=>'20%'),
											//'Quantity' => array('width'=>'20%'),
											' '=>array('width'=>'10%','align'=>'right'));
									$rows = array();
									foreach($list as $val){
										$links = "";
										$rows[] = array(
													  $val->Barcode,
													  $val->Description,
													  $val->Extended,
													  $links
											);

									}
									$CI->make->listLayout($th,$rows);
								$CI->make->eBoxBody();*/		
						$CI->make->eDiv();						
						$CI->make->sDiv(array('id'=>'price_inq_list'));	
								$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
									$CI->make->sRow();
										$CI->make->th('Barcode');
										$CI->make->th('Description',array('style'=>''));
										$CI->make->th('UOM',array('style'=>''));
										$CI->make->th('Qty',array('style'=>''));
										$CI->make->th('Price',array('style'=>''));
										$CI->make->th('Wholesale Price',array('style'=>''));
									$CI->make->eRow();
									/*foreach($list as $val){
										$CI->make->sRow();
											$CI->make->th($val->barcode);
											$CI->make->th($val->description,array('style'=>''));
											$CI->make->th($val->uom,array('style'=>''));
											$CI->make->th($val->qty,array('style'=>''));
											$CI->make->th(num($val->retail_price),array('style'=>''));
											$CI->make->th(num($val->wholesale_price),array('style'=>''));
										$CI->make->eRow();
									}*/
									/*$CI->make->sRow();
										$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
									$CI->make->eRow();*/
								$CI->make->eTable();
						$CI->make->eDiv();	
					$CI->make->eBox();							
				$CI->make->eDivCol();
				
			$CI->make->eDivRow();	
				
			
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}

function view_for_line_void_form($list=null){
	$CI =& get_instance();
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
						$CI->make->sRow();
							$CI->make->th('Barcode');
							$CI->make->th('Description',array('style'=>''));
							$CI->make->th('UOM',array('style'=>''));
							$CI->make->th('Qty',array('style'=>''));
							$CI->make->th('Price',array('style'=>''));
							$CI->make->th(' ',array('width'=>'10%'));
						$CI->make->eRow();
						foreach($list as $val){
								$link = $CI->make->A(
									fa('fa-trash-o fa-lg fa-fw'),'',
									array('class'=>'delete_this_line', 'return'=>'true', 'ref'=>$val->id,
										'title'=>'Delete '.$val->Description)
								);
								$CI->make->sRow();
									$CI->make->th($val->Barcode);
									$CI->make->th($val->Description,array('style'=>''));
									$CI->make->th($val->UOM,array('style'=>''));
									$CI->make->th($val->Qty,array('style'=>''));
									$CI->make->th(num($val->Extended),array('style'=>''));
									$CI->make->th($link,array('style'=>''));
								$CI->make->eRow();
							}
						/*$CI->make->sRow();
							$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
						$CI->make->eRow();*/
					$CI->make->eTable();
	return $CI->make->code();
}
function amount_purchase_form($list=array(), $discount){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('danger');
				$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12, 'center');	
								$amount = 0;
								foreach($list as $tot_amount){
									$amount += $tot_amount->Extended;
								}			
								$CI->make->H(3, 'Total: '.number_format($amount, 2), array('style'=>'margin:10px; align: left; font-size: 50px;font-family: "Times New Roman", Times, serif;font-color:#aa0000;'));
							$CI->make->eDivCol();									
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(6, 'left');	
								$amount = 0;
								foreach($list as $tot_amount){
									$amount += $tot_amount->Extended;
								}			
								$CI->make->H(3, 'Payment Type: '.'sample', array('style'=>'font-size: 15px;font-family: "Times New Roman", Times, serif;'));
							$CI->make->eDivCol();	
							$CI->make->sDivCol(6, 'right');	
								$CI->make->H(3, 'Discount: '.$discount, array('style'=>'font-size: 15px;font-family: "Times New Roman", Times, serif;'));
							$CI->make->eDivCol();									
						$CI->make->eDivRow();
						
						
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}

function list_purchases_form($list=array()){
	$CI =& get_instance();
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
						$CI->make->sRow();
							$CI->make->th('');
							$CI->make->th('Barcode');
							$CI->make->th('Description',array('style'=>''));
							$CI->make->th('UOM',array('style'=>''));
							$CI->make->th('Qty',array('style'=>''));
							$CI->make->th('Price',array('style'=>''));
						$CI->make->eRow();
						$num = 0;
						foreach($list as $val){
							$CI->make->sRow();
							$num = $num+1;
								$CI->make->td($val->id,array('style'=>'color:transparent;','tabindex'=>$num));
								$CI->make->td($val->Barcode);
								$CI->make->td($val->Description,array('style'=>''));
								$CI->make->td($val->UOM,array('style'=>''));
								$CI->make->td($val->Qty,array('style'=>''));
								$CI->make->td(num($val->Extended),array('style'=>''));
							$CI->make->eRow();
						}
						/*$CI->make->sRow();
							$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
						$CI->make->eRow();*/
					$CI->make->eTable();
	return $CI->make->code();
}

function price_inq_form($list=array()){
	$CI =& get_instance();
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					$CI->make->sRow();
						$CI->make->th('Barcode');
						$CI->make->th('Description',array('style'=>''));
						$CI->make->th('UOM',array('style'=>''));
						$CI->make->th('Qty',array('style'=>''));
						$CI->make->th('Price',array('style'=>''));
						$CI->make->th('Wholesale Price',array('style'=>''));
					$CI->make->eRow();
					foreach($list as $val){
						$CI->make->sRow();
							$CI->make->th($val->barcode);
							$CI->make->th($val->description,array('style'=>''));
							$CI->make->th($val->uom,array('style'=>''));
							$CI->make->th($val->qty,array('style'=>''));
							$CI->make->th(num($val->retail_price),array('style'=>''));
							$CI->make->th(num($val->wholesale_price),array('style'=>''));
						$CI->make->eRow();
					}
					/*$CI->make->sRow();
						$CI->make->th('No Items Found.', array('colspan'=>'12','style'=>'text-align:center;'));
					$CI->make->eRow();*/
				$CI->make->eTable();
				/*$CI->make->sBoxBody();
					$th = array(
							'Barcode' => array(''),
							'Description' => array(''),
							'UOM' => array(''),
							'Qty' => array(''),
							'Retail Price' => array(''),
							'Wholesale Price' => array(''),
							' '=>array('width'=>'10%','align'=>'right'));
					$rows = array();
					foreach($list as $val){
						$links = "";
						$rows[] = array(
									  $val->barcode,
									  $val->description,
									  $val->uom,
									  $val->qty,
									  $val->retail_price,
									  $val->wholesale_price,	
									  $links
						);

					}
					$CI->make->listLayout($th,$rows);
				$CI->make->eBoxBody();*/
	return $CI->make->code();
}
function look_up_form($list=array()){
	$CI =& get_instance();
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					$CI->make->sRow();
						$CI->make->th('Barcode');
						$CI->make->th('Description',array('style'=>''));
						$CI->make->th('UOM',array('style'=>''));
						$CI->make->th('Qty',array('style'=>''));
						$CI->make->th('Retail Price',array('style'=>''));
						$CI->make->th('Wholesale Price',array('style'=>''));
					$CI->make->eRow();
					foreach($list as $val){
						$CI->make->sRow();
							$CI->make->th($val->barcode);
							$CI->make->th($val->description,array('style'=>''));
							$CI->make->th($val->uom,array('style'=>''));
							$CI->make->th($val->qty,array('style'=>''));
							$CI->make->th(num($val->retail_price),array('style'=>''));
							$CI->make->th(num($val->wholesale_price),array('style'=>''));
						$CI->make->eRow();
					} 
				$CI->make->eTable();
	return $CI->make->code();
}


function Settle_Page_Form($list=array()){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();	
	    	$CI->make->sDivRow();
				$CI->make->sDivCol(4,'left');				
	//$CI->make->sDiv(array('id'=>'tender_type_id'));
	
	$CI->make->sDiv(array('id'=>'tender_types_div', 'margin-right: 0; margin-left: 0;'));
	$CI->make->sBox('default',array('class'=>'loads-div select-payment-div box-solid bg-dark-green'));
		$CI->make->sBoxHead(array('class'=>'bg-dark-green'));
			$CI->make->boxTitle('&nbsp;');
		$CI->make->eBoxHead();
		$CI->make->sBoxBody(array('class'=>'bg-dark-green'));
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));				
				$num = 0;
				foreach($list as $val){
					$CI->make->sRow();
					$num += 1;
						$CI->make->td($val->name,array('style'=>'color: #ef9610;font-weight: bold;align:left','tabindex'=>$num));
						$CI->make->td('',array('style'=>'color: #ef9610;font-weight: bold;align:left'));
					$CI->make->eRow();
				}
				$CI->make->sRow();
					$CI->make->td(' ',array('style'=>'color: #ef9610;font-weight: bold;'));
					$CI->make->td(' ',array('style'=>'color: #ef9610;font-weight: bold;'));
				$CI->make->eRow();
				$CI->make->eTable();
		$CI->make->eBoxBody();
	$CI->make->eBox();
	$CI->make->eDiv();							
					
				$CI->make->eDivRow();
			$CI->make->eDivCol();	
	    $CI->make->eDivRow();
	$CI->make->eDivCol(4,'center');	
	return $CI->make->code();
}


/*
function choose_discount($list=array()){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
	
	    	$CI->make->sDivRow();
				$CI->make->sDivCol(4,'center');
					$CI->make->sBox('primary');
					
						$CI->make->sForm('#',array('id'=>'product_details_form'));
						$CI->make->sBoxBody();
								$CI->make->sDivRow();
									$CI->make->sDivCol(12, 'center');										
										$CI->make->input('', 'search_item', '', 'Scan Barcode', array(''), fa('fa-cart-plus'));
									$CI->make->eDivCol();									
								$CI->make->eDivRow();
								$CI->make->sDivCol();
								$CI->make->eDivCol();
								
						$CI->make->eBoxBody();
						$CI->make->eForm();
					$CI->make->eBox();
				$CI->make->eDivCol();
				
			$CI->make->eDivRow();	
				
			
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}

function settlePage(){
	$CI =& get_instance();
			$CI->make->sDivRow();
				$CI->make->sDivCol(7,'left',0,array('class'=>'settle-right'));

					$CI->make->sBox('default',array('class'=>'loads-div select-payment-div box-solid bg-dark-green'));
						$CI->make->sBoxHead(array('class'=>'bg-dark-green'));
							$CI->make->boxTitle('&nbsp;');
						$CI->make->eBoxHead();
						$CI->make->sBoxBody(array('class'=>'bg-dark-green'));
								$buttons = array("cash"	=> fa('fa-money fa-lg fa-fw')."<br> CASH",
												 "credit-card"	=> fa('fa-credit-card fa-lg fa-fw')."<br> CREDIT CARD",
												 "debit-card"	=> fa('fa-credit-card fa-lg fa-fw')."<br> DEBIT CARD",
												 "gift-cheque"	=> fa('fa-gift fa-lg fa-fw')."<br> GIFT CHEQUE",
												 "check"	=> fa('fa-check-square-o fa-lg fa-fw')."<br> CHECK",
												 "evouch"	=> fa('fa-eur fa-lg fa-fw')."<br> E-VOUCHER",
												 "suki"	=> fa('fa-users fa-lg fa-fw')."<br> SUKICARD"
												 );
								$CI->make->sDivRow();
										$CI->make->H(3,'SELECT PAYMENT METHOD',array('class'=>'text-center receipt','style'=>'margin-top:0;margin-bottom:25px;padding:0;color:#fff'));
										
										foreach ($buttons as $id => $text) {
											$CI->make->sDivCol(6,'left',0,array("style"=>'margin-bottom:10px;'));
												$CI->make->button($text,array('id'=>$id.'-btn','class'=>'btn-block settle-btn-green double'));
											$CI->make->eDivCol();
										}
								$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();
					$CI->make->sBox('default',array('class'=>'loads-div cash-payment-div box-solid'));
						$CI->make->sBoxHead(array('class'=>'bg-green'));
							$CI->make->boxTitle(' CASH PAYMENT');
						$CI->make->eBoxHead();
						$CI->make->sBoxBody(array('class'=>'bg-red-white'));
							$CI->make->sDivRow();
								$CI->make->sDivCol(3);
									$CI->make->sDiv(array('class'=>'shorcut-btns'));
										$buttons = array(
													 "5"	=> 'PHP 5',
													 "10"	=> 'PHP 10',
													 "20"	=> 'PHP 20',
													 "50"	=> 'PHP 50',
													 "100"	=> 'PHP 100',
													 "200"	=> 'PHP 200',
													 "500"	=> 'PHP 500',
													 "1000"	=> 'PHP 1000'
													 );
										$CI->make->sDivRow(array('style'=>'margin-top:10px;margin-left:10px;'));
											foreach ($buttons as $id => $text) {
													$CI->make->sDivCol(12,'left',0);
														$CI->make->button($text,array('val'=>$id,'class'=>'amounts-btn btn-block settle-btn-red-gray'));
													$CI->make->eDivCol();
											}
										$CI->make->eDivRow();
									$CI->make->eDiv();
								$CI->make->eDivCol();
								$CI->make->sDivCol(9);
									$CI->make->append(onScrNumDotPad('cash-input','cash-enter-btn'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
						$CI->make->sBoxFoot();
							$CI->make->sDivRow();
								$CI->make->sDivCol(4,'left');
									$CI->make->button('Exact Amount',array('id'=>'cash-exact-btn','amount'=>num($ord['balance']),'class'=>'btn-block settle-btn double'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4,'left');
									$CI->make->button('Next Amount',array('id'=>'cash-next-btn','amount'=>num(round($ord['balance'])),'class'=>'btn-block settle-btn-red-gray double'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4,'left');
									$CI->make->button(fa('fa-reply fa-lg fa-fw').' Change Method',array('id'=>'cancel-cash-btn','class'=>'btn-block settle-btn-red double'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxFoot();
					$CI->make->eBox();

					$CI->make->sBox('default',array('class'=>'loads-div debit-payment-div box-solid'));
						$CI->make->sBoxHead(array('class'=>'bg-green'));
							$CI->make->boxTitle(' DEBIT PAYMENT');
						$CI->make->eBoxHead();
						$CI->make->sBoxBody(array('style'=>'background-color:#F4EDE0;'));
							$CI->make->sDivRow(array('style'=>'margin:auto 0;'));
								$CI->make->sDivCol(6);
									$CI->make->input('Card #','debit-card-num','','',array('maxlength'=>'30',
										'style'=>
											'width:100%;
											height:100%;
											font-size:34px;
											font-weight:bold;
											text-align:right;
											border:none;
											border-radius:5px !important;
											box-shadow:none;
											',
										)
									);
									$CI->make->input('Amount','debit-amt',number_format($ord['balance'],2),'',array('maxlength'=>'10',
										'style'=>
											'width:100%;
											height:100%;
											font-size:34px;
											font-weight:bold;
											text-align:right;
											border:none;
											border-radius:5px !important;
											box-shadow:none;
											',
										)
									);
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->append(onScrNumOnlyTarget(
										'tbl-debit-target',
										'#debit-card-num',
										'debit-enter-btn',
										'cancel-debit-btn',
										'Change method'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();

					$CI->make->sBox('default',array('class'=>'loads-div credit-payment-div box-solid'));
						$CI->make->sBoxHead(array('class'=>'bg-green'));
							$CI->make->boxTitle(' CREDIT PAYMENT');
						$CI->make->eBoxHead();
						$CI->make->sBoxBody(array('style'=>'background-color:#F4EDE0;'));
							$CI->make->sDivRow(array('style'=>'margin:auto 0;'));
								$buttons = array(
									"Master Card"	=> fa('fa-cc-mastercard fa-2x')."<br/>Master Card",
									"VISA"	=> fa('fa-cc-visa fa-2x')."<br/>VISA",
									"AmEx"	=> fa('fa-cc-amex fa-2x')."<br/>American Express",
									"Discover"	=> fa('fa-cc-discover fa-2x')."<br/>Discover",
								);
								foreach ($buttons as $id => $text) {
									$CI->make->sDivCol(3,'left',0,array('style'=>'padding:0;margin:0'));
										$CI->make->button($text,array('value'=>$id,'class'=>'credit-type-btn double settle-btn-teal btn-block'));
									$CI->make->eDivCol();
								}
							$CI->make->eDivRow();
							$CI->make->sDivRow(array('style'=>'margin:auto 0;padding:10px 0 8px;'));
								$CI->make->sDivCol(6,'left');
									$CI->make->hidden('credit-type-hidden','Master Card');
									$CI->make->input('Card #','credit-card-num','','',array('maxlength'=>'30',
										'style'=>
											'width:100%;
											height:100%;
											font-size:34px;
											font-weight:bold;
											text-align:right;
											border:none;
											border-radius:5px !important;
											box-shadow:none;
											',
										)
									);
									$CI->make->input('Approval Code','credit-app-code','','',array('maxlength'=>'15',
										'style'=>
											'width:100%;
											height:100%;
											font-size:34px;
											font-weight:bold;
											text-align:right;
											border:none;
											border-radius:5px !important;
											box-shadow:none;
											',
										)
									);
									$CI->make->input('Amount','credit-amt',number_format($ord['balance'],2),'',array('maxlength'=>'10',
										'style'=>
											'width:100%;
											height:100%;
											font-size:34px;
											font-weight:bold;
											text-align:right;
											border:none;
											border-radius:5px !important;
											box-shadow:none;
											',
										)
									);
								$CI->make->eDivCol();
								$CI->make->sDivCol(6,'left');
									$CI->make->append(onScrNumOnlyTarget(
										'tbl-credit-target',
										'#credit-card-num',
										'credit-enter-btn',
										'cancel-credit-btn',
										'Change method'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();

					$CI->make->sBox('default',array('class'=>'loads-div gc-payment-div box-solid'));
						$CI->make->sBoxHead(array('class'=>'bg-green'));
							$CI->make->boxTitle(' GIFT CHEQUE');
						$CI->make->eBoxHead();
						$CI->make->sBoxBody(array('style'=>'background-color:#F4EDE0;'));
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->hidden('hid-gc-id');
									$CI->make->input('Gift Cheque code','gc-code','','',array(
										'style'=>
											'width:100%;
											height:100%;
											font-size:34px;
											font-weight:bold;
											text-align:right;
											border:none;
											border-radius:5px !important;
											box-shadow:none;
											',
										)
									);
									$CI->make->input('Amount','gc-amount','','',array('readonly'=>'readonly',
										'style'=>
											'width:100%;
											height:100%;
											font-size:34px;
											font-weight:bold;
											text-align:right;
											border:none;
											border-radius:5px !important;
											box-shadow:none;
											',
										)
									);
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->append(onScrNumOnlyTarget(
										'tbl-gc-target',
										'#gc-code',
										'gc-enter-btn',
										'cancel-gc-btn',
										'Change method',false));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();

					$CI->make->sBox('default',array('class'=>'loads-div after-payment-div box-solid'));
						$CI->make->sBoxHead(array('class'=>'bg-dark-green'));
							$CI->make->boxTitle('&nbsp;');
						$CI->make->eBoxHead();
						$CI->make->sBoxBody(array('class'=>'bg-dark-green'));
							$CI->make->sDiv(array('class'=>'body'));
								$CI->make->H(3,'AMOUNT TENDERED: PHP '.strong('<span id="amount-tendered-txt"></span>'),array('class'=>'text-center receipt','style'=>'margin-top:0;margin-bottom:25px;padding:0;color:#fff'));
								$CI->make->H(3,'CHANGE DUE: PHP '.strong('<span id="change-due-txt"></span>'),array('class'=>'text-center receipt','style'=>'margin-top:0;margin-bottom:25px;padding:0;color:#fff'));
							$CI->make->eDiv();
							$CI->make->sDivRow();
								$CI->make->sDivCol(4,'left');
									$CI->make->button(fa('fa-plus fa-lg fa-fw').' Additonal Payment',array('id'=>'add-payment-btn','class'=>'btn-block settle-btn-teal double'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4,'left');
									$CI->make->button(fa('fa-print fa-lg fa-fw').' Print Receipt',array('id'=>'print-btn','class'=>'btn-block settle-btn-orange double','ref'=>$ord['sales_id']));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4,'left');
									$CI->make->button(fa('fa-check fa-lg fa-fw').' Finished',array('id'=>'finished-btn','class'=>'btn-block settle-btn-green double'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();

					$CI->make->sBox('default',array('class'=>'loads-div transactions-payment-div box-solid'));
						$CI->make->sBoxHead(array('class'=>'bg-dark-green'));
							$CI->make->boxTitle('Transactions');
						$CI->make->eBoxHead();
						$CI->make->sBoxBody(array('class'=>'bg-red-white'));
							$CI->make->sDiv(array('class'=>'body'));

							$CI->make->eDiv();
							$CI->make->sDivRow();
								$CI->make->sDivCol(12,'left');
									$CI->make->button(fa('fa-times fa-lg fa-fw').' Close',array('id'=>'trsansactions-close-btn','class'=>'btn-block settle-btn-orange double'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eDiv();
	return $CI->make->code();
}
*/
?>