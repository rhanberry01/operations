<?php
function upd_approval_header_page($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-book')." UPDATE STOCK GENERAL & COST DETAILS"=>array('href'=>'#update','class'=>'tab_link load-tab','load'=>'inv_inquiries/approval_update_inquiry/','id'=>'update_link'),
						fa('fa-usd')."BILLER CODE APPROVAL"=>array('href'=>'#biller_code','class'=>'tab_link load-tab','load'=>'upd_inquiries/approval_supplier_biller_code/','id'=>'biller_code_link'),
						fa('fa-book')." UPDATE STOCK BARCODE & PRICES"=>array('href'=>'#barcode_price','class'=>'tab_link load-tab','load'=>'inv_inquiries/barcode_prices_approval/','id'=>'barcode_price_link'),

					);
					//$CI->make->hidden('po_id',$po_id);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'update','class'=>'tab-pane active'));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'biller_code','class'=>'tab-pane '));
						$CI->make->eTabPane();
						$CI->make->sTabPane(array('id'=>'barcode_price','class'=>'tab-pane '));
						$CI->make->eTabPane();
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
//mahe start supplier stocks approval form
function for_approval_list_form_supplier_biller_code($list)
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol(12);
				$CI->make->sDivRow(array('style'=>'margin:0px 0px; margin-bottom: 10px;'));
				//-----PRELOADER-----START
					$CI->make->sDiv(array('id'=>'b-spinner'));
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
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								'Supplier Code' => array('text-align'=>'center'),
								'Supplier Name' => array('text-align'=>'center'),		
								'Biller Code' => array('text-align'=>'center'),		
								'Status' => array('text-align'=>'center'),
								'&nbsp;' => array('text-align'=>'center'),
								'&nbsp;&nbsp;' => array('text-align'=>'center'),
								
								);
							$rows = array();
							$tag ='';
							foreach ($list as $val) {
								$tag = '';
								$a = $b = "";	
								
								if(($val->status) == 0 ){
										$tag .= " <span class='label label-info'>PENDING</span>";
									}else if($val->status == 1){
										$tag .= " <span class='label label-success'>APPROVED</span>";
									}else{
										$tag .=" <span class='label label-warning'>REJECTED</span>";
								    }
									
								$a = $CI->make->A(
													fa('fa-check fa-lg fa-fw'),
												'',
												array('class'=>'action_btns approve_link',
													'ref_desc'=>'approve me',
													'_id'=>$val->id,
													'supplier_id'=>$val->supplier_id,
													'title'=>'approve this',
													'return'=>'false'));
								$b = $CI->make->A(
												'&nbsp;&nbsp;'.fa('fa-close fa-lg fa-fw'),
												'',
												array('class'=>'action_btns reject_link',
													'ref_desc'=>'reject me',
													'_id'=>$val->id,
													'supplier_id'=>$val->supplier_id,
													'title'=>'reject this',
													'return'=>'false'));
								$data = " From  <span style='font-weight: bold; color:#FF0000;'>".$val->biller_code_old."</span> To <span style='font-weight: bold; color:#00CC00; text-decoration: underline; '> ".$val->biller_code_new."</span></br>" ;
								
								if($val->branch_no_con){
								$branch_no_con_ = explode(':', $val->branch_no_con);
								$branch_no_con = explode('|', $branch_no_con_[1]);
								$branch_ = count($branch_no_con);
								$counter = 0;
								$data_ = '';
								while($counter != $branch_){
									
									$data_ .= " <span class='label label-danger'>".$branch_no_con[$counter]."</span>";
									$counter++;
								}
								}
								$rows[] = array(
									$val->short_name,
									$val->supp_name,
									$data,
									($val->branch_no_con != null ?   (array("text"=>"No Connection :</br>".$data_, 'params'=>array('style'=>'text-align:center'))) : $tag),	
									($val->status != '0' ?  '' : (array('text'=>$a, 'params'=>array('style'=>'text-align:center')))),	
									($val->status != '0' ?  '' :(array('text'=>$b, 'params'=>array('style'=>'text-align:center'))))
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
?>