<?php
function data_center_main_uploader($res=array())
{
	$CI =& get_instance();
	
	$CI->make->sDivRow();
		$CI->make->sDiv(array('id'=>'file-spinner'));
			$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
					$CI->make->sBox('',array('div-form'));
						$CI->make->sBoxBody(array('style'=>'height: 40px;'));
							$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
								$CI->make->sDivCol(11,'center',0,array("style"=>'margin-top:10px; margin-bottom:10px;'));
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
					$CI->make->sDivRow(array('style'=>'margin-left:350px; margin-bottom:20px; margin-top:20px; align: center;'));
					$CI->make->sForm("",array('id'=>'form'));
						$CI->make->sDivCol(5, 'center');
							$CI->make->button(fa('fa-cloud-upload').' Upload',array('id'=>'upload-btn','class'=>'btn-block rOkay'),'primary');
						$CI->make->eDivCol();
					$CI->make->eForm();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	return $CI->make->code();
}