<?php
function build_movement_adder_form($movement_id=null){
	$CI =& get_instance();
	$user = $CI->session->userdata('user');
	
		$CI->make->sForm("",array('id'=>'add_movement_form'));
		
		$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
			$CI->make->sDivCol(12,'right', 0, array());
					$CI->make->hidden('hidden_user',$user['id']);
					$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save_movement_btn', 'style'=>' margin-right: 10px; margin-left: 10px;'),'primary');
					$CI->make->A(fa('fa-reply').' Go Back',base_url().'inventory/dashboard',array('class'=>'btn'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('success');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(3);
								$CI->make->branchesDrop('Branch','branch_id',null,null,array('class'=>'rOkay branch_dropdown'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->stockLocationDrop('Stock Location','stock_location',null,null,array('class'=>'rOkay stock_location_dropdown'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Date','transaction_date',date('m/d/Y'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->movementTypeDrop('Movement Type','movement_type_id',null,null,array('class'=>'rOkay movement_type_dropdown'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol(5);
			//-----BARCODE ADDER START
				$CI->make->sBox('warning');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->input('Barcode','barcode','',null,array('class'=>'rOkay formInput'));
							$CI->make->eDivCol();
							$CI->make->sDivCol();
								$CI->make->input('Description','stock_desc','',null,array('class'=>'rOkay formInput', 'readonly'=>'readonly'));
								$CI->make->hidden('stock_id','');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->stockUOMCodeDrop('UOM','uom','','Select UOM',array('class'=>'rOkay reqForm'));
								$CI->make->hidden('uom_qty','');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Quantity','qty','','Quantity per UOM',array('class'=>'rOkay reqForm','maxchars'=>'20'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->input('Unit Cost','unit_cost','',null,array('class'=>'formInput', 'readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(8);
								$CI->make->input('TOTAL','total','',null,array('class'=>'formInput', 'readonly'=>'readonly'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								// $CI->make->button(fa('fa-plus').' ADD STOCK',array('id'=>'save-poheader', 'style'=>' margin-top: 25px;'),'primary');
								$CI->make->hidden('total_amount','');
								$CI->make->button(fa('fa-plus').'',array('id'=>'add_btn', 'style'=>' margin-top: 25px;'),'primary');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			//-----BARCODE ADDER END
			$CI->make->sDivCol(7);
			//-----BARCODE LIST START
				// $CI->make->sDiv(array('id'=>'stock_contents', 'style'=>'height: 200px; width: 100%; overflow-x: none; overflow-y: scroll;'));
				$CI->make->sDiv(array('id'=>'stock_contents'));
				$CI->make->eDiv();
			//-----BARCODE LIST END
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sBox('info');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->textarea('Remarks','remarks','','', array('style'=>'resize:vertical;','maxchars'=>'255'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();
		
		$CI->make->eForm();
	return $CI->make->code();
}
function build_movement_details_list_form($item=array(), $stock_id=null){
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
									'title'=>'Delete this item?',
									'style'=>'cursor: pointer;',
									'return'=>'false'));
									$CI->make->sRow();
											$CI->make->td("[ ".$val->barcode." ] ".$val->description);	
											$CI->make->td($val->qty);	
											$CI->make->td($val->uom);	
											$CI->make->td($val->unit_cost);	
											$CI->make->td($val->qty * $val->unit_cost);	
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

?>