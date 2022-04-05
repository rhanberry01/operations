<?php
function cycle_count_details($items = array()){

$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sBox('success');
		$CI->make->sForm('',array('id'=>'neg_item_list'));
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$user    = $CI->session->userdata('user');
				        $user_branch = $user['branch']; 
						$Branch = $CI->cycle->get_branch($user_branch);
						$CI->make->hidden('branch_code',$user_branch,array('class'=>'branch_code'));
						$CI->make->hidden('uom',$user_branch,array('class'=>'uom'));
						$CI->make->hidden('cost',$user_branch,array('class'=>'qty'));
					$CI->make->sDivCol(3);
						$CI->make->input('Barcode','bcode','','',array('class'=>'','required'=>'required'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						$CI->make->input('Description','desc','','',array('class'=>'','required'=>'required','readonly'=>'true'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
					$CI->make->A(fa('fa-save').'Save ','#',array('id'=>'btn_save', 'style'=>' margin-top: 24px;margin-right: 25px;','class'=>'btn btn-flat btn-md btn-primary'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(12,'left');
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBox();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
							$CI->make->sDivRow();													
								$CI->make->sDivCol();
									$CI->make->sDiv(array('id'=>'adjustment'));	
										$CI->make->sDivRow();
											$CI->make->sDivCol();
												$CI->make->sDiv(array('class'=>'table-responsive'));

													$th = array(
															'Barcode' =>array('align'=>'center'),
															'Description' =>array('align'=>'center'),
															'Unit'=> array('align'=>'center'),
															'Cost'=>array('align'=>'center'),
															'Status'=>'',
															);
													$rows = array();

														foreach($items as $v){
															$no=0;
															$checkbox = $CI->make->checkbox('','chk_'.$no,$v->id,array('return'=>true,'class'=>'check'));
															$description = $CI->cycle->product_desc($v->bcode,$v->branch_code);

															$rows[] = array(
																$v->bcode,
																$description,
																$v->uom,
																$v->cost,
																$checkbox
															);
															$no++;
														}
													$CI->make->listLayout($th,$rows);
												$CI->make->eDiv();
												$CI->make->sDivCol(12,'right');
													$CI->make->button(fa('fa-trash').' Delete',array('class'=>'delete_sku','id'=>'delete_data','style'=>'text-align:right;margin-left:50px;'),'danger');
												$CI->make->eDiv();
											$CI->make->eDivCol();
										$CI->make->eDivRow();
									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();													
					$CI->make->eBoxBody();
				$CI->make->eBox();

		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}

function cycle_reload($items = array()){

$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sDivRow();
		$CI->make->sForm("",array('id'=>'add_form'));
			$CI->make->sDiv();
				$CI->make->sRow();
				$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
					$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
						$CI->make->th('Branch',array('style'=>''));
						$CI->make->th('Barcode',array('style'=>''));
						$CI->make->th('Description',array('style'=>''));
						// $CI->make->th('Total Qty',array('style'=>''));
						$CI->make->th('Unit',array('style'=>''));
						$CI->make->th('Cost',array('style'=>''));
						$CI->make->th('Status',array('style'=>''));
					$CI->make->eRow();
				$CI->make->eTable();
					$no=0;
					foreach($items as $v){
						

						$Branch = $CI->cycle->get_branch($v->branch_code);
						$description = $CI->cycle->product_desc($v->bcode,$v->branch_code);

						$CI->make->sDivCol(12);
							$CI->make->sDivCol(2);
								$CI->make->hidden('row_id_'.$no,$v->id,array('id'=>'product_id'));
								$CI->make->input('','branch',$Branch,'',array('class'=>'','disabled'=>'disabled','required'=>'required','style'=>'border:none;background-color:transparent;padding:10px;margin-left:-33px;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(2);
								$CI->make->input('','bcode',$v->bcode,'',array('class'=>'','disabled'=>'disabled','required'=>'required','style'=>'border:none;background-color:transparent;padding:10px;margin-left:-60px;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->input('','desc',$description,'',array('class'=>'','disabled'=>'disabled','required'=>'required','style'=>'border:none;background-color:transparent;padding:10px;margin-left:-65px;'));
							$CI->make->eDivCol();
							// $CI->make->sDivCol(1);
							// 	$CI->make->input('','qty',$v->qty,'',array('class'=>'','disabled'=>'disabled','required'=>'required','style'=>'border:none;background-color:transparent;padding:10px;margin-left:-100px;'));
							// $CI->make->eDivCol();
							$CI->make->sDivCol(1);
								$CI->make->input('','uom',$v->uom,'',array('class'=>'','disabled'=>'disabled','required'=>'required','style'=>'border:none;background-color:transparent;padding:10px;margin-left:-5px;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(1);
								$CI->make->input('','cost',$v->cost,'',array('class'=>'','disabled'=>'disabled','required'=>'required','style'=>'border:none;background-color:transparent;padding:10px;margin-left:15px;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(1);
									if($v->status == 1){
										$certify = $CI->make->button(fa('fa-check').' Certified',array('class'=>'approved','style'=>'text-align:right;margin-left:50px;','disabled'=>'disabled'),'success');
									}else{
										$certify = $CI->make->button(fa('fa-edit').' Certify',array('class'=>'certify','id'=>'certify_'.$no,'style'=>'text-align:right;margin-left:50px;'),'success');
									}
							$CI->make->eDivCol();
						$CI->make->eDivCol();
						$no++;
					}
			$CI->make->eDiv();
		$CI->make->eForm();
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	return $CI->make->code();
}
?>