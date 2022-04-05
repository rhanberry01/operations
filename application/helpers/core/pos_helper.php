<?php
// ======================================================================================= //
//  					ZREAD CONTROLLER - for supervisor - Added 08/27/2015 by APM																															
// ======================================================================================= //
function build_zread_controller_header_form($items=array())
{
	$CI =& get_instance();
	$user = $CI->session->userdata('user');
	
	$CI->make->sForm("",array('id'=>'zread_controller_header_form'));
		$CI->make->hidden('hidden_user',$user['id']);
		
		$CI->make->sDivRow(array('style'=>'margin-top:-5px;'));
			$CI->make->sDivCol(12,'right', 0, array());
				$CI->make->sBox('success',array('div-form'));
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDiv(array('class'=>'table-responsive'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl', 'border'=>'0px'));
										$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
											$CI->make->th('COUNTER #',array('style'=>'width: 60%;'));
											$CI->make->th('Z-READ STATUS',array('style'=>'width: 40%; text-align: center;'));
										$CI->make->eRow();
										$zread_stat_desc = "";
										$xcounter = 0;
										foreach($items as $val){
											$stat_desc = "";
											
											if($val->zread_status == 0){
												// $xcounter += 1;
												$xcounter = $xcounter + 1;
												$stat_desc = "<span class='label label-danger' style='font-size: 15px;'><i class='fa fa-warning fa-lg'></i>".FIVES_SPACES."PENDING</span>";
											}else{
												// $xcounter += 0;
												$xcounter = $xcounter + 0;
												$stat_desc = "<span class='label label-success' style='font-size: 15px;'><i class='fa fa-check fa-lg'></i>".FIVES_SPACES."FINISHED</span>";
											}
											
											$CI->make->sRow(array('style'=>''));
												$CI->make->th($val->counter_no,array('style'=>'width: 60%; font-size: 18px;'));
												$CI->make->th($stat_desc,array('style'=>'width: 40%; text-align: center;'));
											$CI->make->eRow();
										}	
									$CI->make->eTable();
								$CI->make->eDiv();
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol(4);
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$checker = $CI->pos_model->check_current_day_branch_zread_controller(BRANCH_ID, date('Y-m-d'));
				$CI->make->hidden('day_checker',$checker);
				if($checker == 0){
					$CI->make->hidden('xcounter',$xcounter);
					if($xcounter > 0){
						$CI->make->A(fa('fa-remove fa-lg').' CONSOLIDATE TO BRANCH SERVER '.fa('fa-remove fa-lg'), '',array('class'=>'btn btn-block btn-danger consolidate_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
					}else{
						// $CI->make->A(fa('fa-star fa-spin fa-lg').' CONSOLIDATE TO BRANCH SERVER '.fa('fa-star fa-spin fa-lg'), '',array('class'=>'btn btn-block btn-info consolidate_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
						$CI->make->A(fa('fa-upload fa-lg').' CONSOLIDATE TO BRANCH SERVER '.fa('fa-upload fa-lg'), '',array('class'=>'btn btn-block btn-info consolidate_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
					}
				}else{
					$CI->make->A(fa('fa-remove fa-lg').' CONSOLIDATE TO BRANCH SERVER '.fa('fa-remove fa-lg'), '',array('class'=>'btn btn-block btn-danger consolidate_btn main_btns', 'style'=>'margin-bottom: 10px; margin-right: 10px; margin-left: 10px;'));
				}
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
	$CI->make->eForm();
	
	return $CI->make->code();
}