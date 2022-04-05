<?php
function sales_reports($res=array())
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('info',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("po/brach_stock_inquiry_results/",array('id'=>'branch_stock_search_form'));
						$CI->make->sDivCol(2,'left',0,array('id'=>'cust-branch-div'));
							$CI->make->branchesDrop('Branch','branch_id',null,null,array('class'=>'rOkay combobox branch_dropdown'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(2);
								$CI->make->occurrenceValDrop('Occurrence','occurence_id','','',array('class'=>'combobox occurrenceDrop'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(2,'',0,array('id'=>'month_div'));
								$CI->make->monthsDrop('Month','month',date('m'),'',array('class'=>'combobox'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(2,'',0,array('id'=>'year_div'));
								$CI->make->yearsDrop('Year','year',date('Y'),'',array('class'=>'combobox'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(2,'',0,array('id'=>'date_div'));
									$CI->make->datefield('Date','date','','Select Date',array('class'=>'rOkay'),$icon1="<i class='fa fa-fw fa-calendar'></i>");
						$CI->make->eDivCol();
						$CI->make->sDivCol(1,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
							$CI->make->A(fa('fa-print').' Print','#',array('class'=>'btn btn-primary','id'=>'btn-print','style'=>'text-align:right'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();

	return $CI->make->code();
	
	
}