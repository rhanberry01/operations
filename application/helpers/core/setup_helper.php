<?php
//-----------Branch Details-----start-----allyn
function makeDetailsForm($det=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			//$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sForm("",array('id'=>'details_form'));
						$CI->make->sDivRow(array('style'=>'margin:10px;'));
							$CI->make->sDivCol(12, 'right');

									$CI->make->button(fa('fa-save fa-fw').' Save',array('id'=>'save-btn'),'primary');

							$CI->make->eDivCol();
						$CI->make->eDivRow();

						$CI->make->sDivRow(array('style'=>'margin:10px;'));
							$CI->make->sDivCol(6);
								$CI->make->hidden('company_id','1');
								//$CI->make->hidden('tax_id',iSetObj($det,'tax_id'));
								$CI->make->input('Name (to appear on reports)','company_name',iSetObj($det,'company_name'),'Type Name',array('class'=>'rOkay'));
								$CI->make->input('Tax Authority Reference','tax_ref',iSetObj($det,'tax_ref'),'Type Here',array('class'=>''));
								// $CI->make->input('TIN','tin',iSetObj($det,'tin'),'TIN',array('class'=>'rOkay'));
								// $CI->make->input('BIR #','bir',iSetObj($det,'bir'),'BIR',array());
								$CI->make->currenciesDrop('Home Currency','currency',iSetObj($det,'currency'),'',array());
								$CI->make->textarea('Address','address',iSetObj($det,'address'),'Type Address',array('class'=>''));
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// $CI->make->sDiv(array('class'=>'bootstrap-timepicker'));
											$CI->make->input('Email Address','email',iSetObj($det,'email'),'',array('class'=>''));
										// $CI->make->eDiv();
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										// $CI->make->sDiv(array('class'=>'bootstrap-timepicker'));
											$CI->make->input('Domicile','domicile',iSetObj($det,'domicile'),'',array('class'=>''));
										// $CI->make->eDiv();
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
							$CI->make->sDivCol(6);
								$CI->make->input('Official Company Number','official_no',iSetObj($det,'official_no'),'Type Contact Number',array());
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// $CI->make->sDiv(array('class'=>'bootstrap-timepicker'));
											$CI->make->input('Tax Periods','tax_prd',iSetObj($det,'tax_prd'),'',array('class'=>''));
										// $CI->make->eDiv();
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										// $CI->make->sDiv(array('class'=>'bootstrap-timepicker'));
											$CI->make->input('Tax Last Period','tax_last_prd',iSetObj($det,'tax_last_prd'),'',array('class'=>''));
										// $CI->make->eDiv();
									$CI->make->eDivCol();
								$CI->make->eDivRow();


								$CI->make->fiscalYearDrop('Fiscal Year','fiscal_year',iSetObj($det,'fiscal_year'),'',array());
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										// $CI->make->sDiv(array('class'=>'bootstrap-timepicker'));
											$CI->make->input('Telephone Number','phone',iSetObj($det,'phone'),'',array('class'=>''));
										// $CI->make->eDiv();
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										// $CI->make->sDiv(array('class'=>'bootstrap-timepicker'));
											$CI->make->input('Facsimile Number','facsimile_no',iSetObj($det,'facsimile_no'),'',array('class'=>''));
										// $CI->make->eDiv();
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								$CI->make->sDivRow();
									$CI->make->sDivCol(6);
										$CI->make->input('Use Dimensions','dimension',iSetObj($det,'dimension'),'',array('class'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
										$CI->make->input('Base for auto price calculations','price_calc',iSetObj($det,'price_calc'),'',array());
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								$CI->make->sDivRow();
									$CI->make->sDivCol(4);
										$CI->make->checkbox('Search Item List','sil',(iSetObj($det,'sil') == 0 ? 0 : 1),array('class'=>''),(iSetObj($det,'sil') == 0 ? 0 : 1));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->checkbox('Search Customer List','scl',(iSetObj($det,'scl') == 0 ? 0 : 1),array(),(iSetObj($det,'scl') == 0 ? 0 : 1));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->checkbox('Search Supplier List','spl',(iSetObj($det,'spl') == 0 ? 0 : 1),array('class'=>''),(iSetObj($det,'spl') == 0 ? 0 : 1));
									$CI->make->eDivCol();
								$CI->make->eDivRow();
								
							$CI->make->eDivCol();
						$CI->make->eDivRow();

						// $CI->make->sDivRow(array('style'=>'margin:10px;'));
						// 	$CI->make->sDivCol(6);
						// 		$CI->make->currenciesDrop('Currency','currency',iSetObj($det,'currency'),'',array());
						// 	$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eBoxBody();
			//$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}
//-----------Branch References-----end-----allyn
?>