<?php
/**
 * Builds Item Sales report container
 * @return string    HTML string
 */
function build_item_sales_report()
{
	$CI =& get_instance();

	$CI->make->sDivRow(array('style'=>'margin:5px;'));
		$CI->make->sBox('success',array('div-form'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow(array('style'=>'margin:0px 0px'));
					$CI->make->sForm("sales_reports/item_sales_results",array('id'=>'item_sales_form'));
						$CI->make->sDivCol(3);
							$CI->make->select(
								'Search for items',
								'_s_item_field',
								null,
								null,
								array(
									'class'=>'selectpicker with-ajax',
									'data-live-search'=>"true"
								)
							);
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input(
								'Date range',
								'daterange',
								date('m/d/Y',strtotime('-1 month')).' to '.date('m/d/Y'),
								'',
								array(
									'class'=>'rOkay daterangepicker',
									'style'=>'position:initial;'
									),
								null,
								fa('fa-calendar')
							);
						$CI->make->eDivCol();
						$CI->make->sDivCol(1,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
							$CI->make->A(fa('fa-search').' Search','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:right'));
						$CI->make->eDivCol();
					$CI->make->eForm();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();
		$CI->make->eBox();

		$CI->make->sBox('info',array('id'=>'div-results','style'=>'min-height:350px;'));
			$CI->make->sBoxBody();
				$CI->make->H('2',"Please select search parameters",array('style'=>'text-align:center;color:#808080;'));
			$CI->make->eBoxBody();
		$CI->make->eBox();
	$CI->make->eDivRow();


	return $CI->make->code();
}
function build_delivery_display($results)
{
	$CI =& get_instance();

	$CI->make->sBoxBody();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$th = array(
					'Sales Order' => array('width'=>'13%'),
					'Delivery Reference' => array('width'=>'13%'),
					'Customer Branch' => array('width'=>'26%'),
					'Total Cost' => array('width'=>'10%'),
					'Date' => array('width'=>'10%'),
					'Invoice Due Date' => array('width'=>'10%'),
					' ' => array('width'=>'7%')
					);

				$rows = array();
				foreach($results as $val) {
					$link = $CI->make->A(
						fa('fa-history fa-lg fa-fw'),'delivery_returns/'.$val->reference,
						array(
							'return'=>true,
							'title'=>'Return dispatched items'
						)
					);
					$link .= $CI->make->A(
						fa('fa-check fa-lg fa-fw'),'complete_delivery/'.$val->reference,
						array(
							'return'=>true,
							'title'=>'Complete this delivery'
						)
					);
					$rows[] = array(
						$val->so_reference,
						$val->reference,
						$val->customer_branch,
						array('text'=>num($val->t_amount),'params'=>array('style'=>'text-align:right')),
						$val->trans_date,
						$val->invoice_due_date,
						array('text'=>$link,'params'=>array('style'=>'text-align:center'))
					);
				}
				$CI->make->listLayout($th,$rows);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eBoxBody();

	return $CI->make->code();
}
function build_customer_balances()
{
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sForm('sales/reports/customer_balances_result',array('id'=>'frm-cust-bal'));
							$CI->make->hidden('as_pdf','0');
							$CI->make->sDivCol(4);
								$CI->make->debtorMasterDrop('Customer','debtor_id',null,'Select customer',array('class'=>'combobox'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(3);
								$CI->make->datefield('Ending Date','ending_date',date('m/d/Y'),'',array('class'=>'rOkay'),null,"<i class='fa fa-fw fa-calendar'></i>");
							$CI->make->eDivCol();
							$CI->make->sDivCol(1,'left',0,array('style'=>'margin-top:25px;margin-bottom:10px;'));
								$CI->make->A(fa('fa-search').' Search','#',array('class'=>'btn btn-primary','id'=>'btn-search','style'=>'text-align:right'));
							$CI->make->eDivCol();

						$CI->make->eForm();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody(array('id'=>'div-results','class'=>'table-responsive'));
					// $CI->make->sDivRow();
						$CI->make->sDiv(array('style'=>'height:330px'));
							// $CI->make->sBoxBody();
								$CI->make->H('2',"Please select search parameters",array('style'=>'text-align:center;color:#808080;'));
							// $CI->make->eBoxBody();
						$CI->make->eDiv();
					// $CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function build_customer_balances_result($rows=array())
{
	$CI =& get_instance();

	$is_empty = true;

	$CI->make->sDivRow();
		$CI->make->sDivCol(2,'right',10,array('style'=>'margin-bottom:10px;'));
			$CI->make->A(fa('fa-file-pdf-o').' Generate PDF',base_url().'sales/reports/customer_balances_pdf',
				array('class'=>'btn btn-primary','target'=>'_blank','style'=>'text-align:right'));
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	$CI->make->sTable(array('class'=>'table table-bordered table-hover'));
		$CI->make->sTableBody();
			foreach ($rows as $val) {
				if (!$val['data'])
					continue;

				if (!$is_empty) {
					$CI->make->td('',array('colspan'=>7));
				}

				$is_empty = false;
				$debt_charge = $debt_cred = $debt_out = 0;

					$CI->make->sRow();
						$CI->make->th('['.$val['code'].'] '.$val['name'],
							array(
								'colspan' => '100%',
								'style'   => 'font-size:16px;height:40px;padding-top:12px;padding-bottom:12px;background-color:#cae8c6;'));
					$CI->make->eRow();
					$CI->make->sRow();
						$CI->make->td('Transaction Type',array('style'=>'background-color:#f5f5f5;width:20%;text-align:center;'));
						$CI->make->td('Reference',array('style'=>'background-color:#f5f5f5;text-align:center;'));
						$CI->make->td('Trans Date',array('style'=>'background-color:#f5f5f5;width:10%;text-align:center;'));
						$CI->make->td('Due Date',array('style'=>'background-color:#f5f5f5;width:10%;text-align:center;'));
						$CI->make->td('Charges',array('style'=>'background-color:#f5f5f5;width:14%;text-align:center;'));
						$CI->make->td('Credits',array('style'=>'background-color:#f5f5f5;width:14%;text-align:center;'));
						$CI->make->td('Outstanding',array('style'=>'background-color:#f5f5f5;width:14%;text-align:center;'));
					$CI->make->eRow();

				if (isset($val['data']['prev']))
					foreach ($val['data']['prev'] as $fiscal_end => $bal) {
						$CI->make->sRow();
							$CI->make->td(
								'Outstanding balances from the fiscal year ending on '.date('F j Y',strtotime($fiscal_end)),
								array('colspan'=>6,'style'=>'background-color:#f5f5f5;'));
							$CI->make->td(num($bal),array('style'=>'text-align:right;background-color:#f5f5f5;'));
						$CI->make->eRow();
						$debt_out += $bal;
					}

				if (isset($val['data']['curr']))
					foreach($val['data']['curr'] as $vv) {
						$CI->make->sRow();
							$CI->make->td($vv['trans_name'],array('style'=>'width:20%'));
							$CI->make->td($vv['trans_ref']);
							$CI->make->td($vv['trans_date'],array('style'=>'width:10%'));
							$CI->make->td($vv['due_date'],array('style'=>'width:10%'));

							if ($vv['trans_amount'] > 0) {
								$outstanding = $vv['trans_amount'] - $vv['allocated_amount'];

								$CI->make->td(num($vv['trans_amount']),array('style'=>'text-align:right;width:14%;'));
								$CI->make->td("",array('style'=>'text-align:right;width:14%;'));
								$CI->make->td(num($outstanding),array('style'=>'text-align:right;width:14%;'));

								$debt_charge += $vv['trans_amount'];
								$debt_out    += $outstanding;
							} else {
								$disp_amount = abs($vv['trans_amount']);
								$outstanding = $vv['trans_amount'] + $vv['allocated_amount'];

								$CI->make->td("",array('style'=>'text-align:right;width:14%;'));
								$CI->make->td(num($disp_amount),array('style'=>'text-align:right;width:14%;'));
								$CI->make->td(num($outstanding),array('style'=>'text-align:right;width:14%;'));

								$debt_cred += $disp_amount;
								$debt_out  += $outstanding;
							}
						$CI->make->eRow();
					}


				$CI->make->sRow();
					$CI->make->th('TOTAL',array('colspan'=>'4','style'=>'text-align:center;background-color:#DDEBE7;'));
					$CI->make->th(num($debt_charge),array('style'=>'text-align:right;background-color:#DDEBE7;'));
					$CI->make->th(num(abs($debt_cred)),array('style'=>'text-align:right;background-color:#DDEBE7;'));
					$CI->make->th(num($debt_out),array('style'=>'text-align:right;background-color:#DDEBE7;'));
				$CI->make->eRow();
			}


		$CI->make->eTableBody();
	$CI->make->eTable();

	if ($is_empty) {
		$CI->make->sDiv(array('style'=>'height:330px'));
			$CI->make->H('4','Selected customer has no pending transactions',array('style'=>'text-align:center;color:#808080;'));
			$CI->make->H('2',"Please select search parameters",array('style'=>'text-align:center;color:#808080;'));
			// $CI->make->sRow();
				// $CI->make->th('Selected customer has no pending transactions',array('colspan'=>'100%'));
			// $CI->make->eRow();
		$CI->make->eDiv();
	}


	return $CI->make->code();
}