<?php
function build_account_classes_form($class=null)
{
	$CI =& get_instance();
	$CI->make->sForm("general_ledger/account_classes_db",
		array('id'=>'account_classes_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
				$CI->make->hidden('id',iSetObj($class,'id'));
			$CI->make->sDivCol(5);
				$CI->make->input('Account Class name','class_name',iSetObj($class,'class_name'),'Type Account Class here',array('class'=>'rOkay','maxchars'=>'60'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(5);
				$CI->make->append('<br/>');
				$CI->make->checkbox("Display on balance sheet","display_on_balance_sheet",null,array(),iSetObj($class,'display_on_balance_sheet') ? true : false);
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function build_account_types_display($list)
{
	$CI =& get_instance();

	$CI->make->sBox('success');
		$CI->make->sBoxBody();
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->A(fa('fa-plus').' New account type',base_url().'general_ledger/account_types/new',array('class'=>'btn btn-primary'));
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			$CI->make->sDivRow();
				$CI->make->sDivCol();
					$th = array(
						'Name' => array('width'=>'30%'),
						'Sub-type of' => array(),
						'Account Class' => array(),
						' '=>array('width'=>'10%')
						);
					$rows = array();
					foreach ($list as $val) {
						$link = "";
						$link .= $CI->make->A(
							fa('fa-pencil fa-lg fa-fw'),
							base_url().'general_ledger/account_types/'.$val->id,
							array('return'=>'true',
								'title'=>'Edit '.$val->type_name));

						$rows[] = array(
							$val->type_name,
							$val->parent_name,
							$val->class_name,
							array('text'=>$link,'params'=>array('style'=>'text-align:center'))
						);
					}
					$CI->make->listLayout($th,$rows);
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eBoxBody();
	$CI->make->eBox();

	return $CI->make->code();
}
function build_account_type_container($id)
{
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->hidden('account_type_idx',$id);
		$CI->make->sDivCol();
			$CI->make->sTab();
				$tabs = array(
					fa('fa-info-circle')." General Details" => array(
																'href'=>'#details',
																'class'=>'tab_link',
																'load'=>'general_ledger/account_type_form',
																'id'=>'details_link'),
					);
				$CI->make->tabHead($tabs,null,array());
				$CI->make->sTabBody();
					$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
					$CI->make->eTabPane();
				$CI->make->eTabBody();
			$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function build_account_type_form($account_type)
{
	$CI =& get_instance();
	$CI->make->sForm("general_ledger/account_type_db",
		array('id'=>'account_type_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
				$CI->make->hidden('id',iSetObj($account_type,'id'));
				$CI->make->input('Account Type name','type_name',iSetObj($account_type,'type_name'),'Account type name',array('class'=>'rOkay','maxchars'=>'50'));
				$CI->make->accountTypeDrop('Sub-type of','parent',iSetObj($account_type,'parent'),'');
				$CI->make->accountClassDrop('Account Class','class_id',iSetObj($account_type,'class_id'),'Select Account Class',array('class'=>'rOkay'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(3);
				$CI->make->button(fa('fa-save').' Save Account Type details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->button(fa('fa-reply').' Return to Account Types',array('id'=>'back-btn','class'=>'btn-block'),'default');
			$CI->make->eDivCol();
	    $CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
function build_accounts_display($list)
{
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('success');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' New GL Account',base_url().'general_ledger/accounts/new',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
								'Account Code' => array('width'=>'15%'),
								'Account Name' => array('width'=>'30%'),
								'Account Group' => array('width'=>'25%'),
								'Tax Type' => array('width'=>'20%'),
								' '=>array('width'=>'10%')
								);
							$rows = array();
							foreach ($list as $val) {
								$link = "";
								$link .= $CI->make->A(
									fa('fa-pencil fa-lg fa-fw'),
									base_url().'general_ledger/accounts/'.$val->account_code,
									array('return'=>'true',
										'title'=>'Edit '.$val->account_name));
								$rows[] = array(
									$val->account_code,
									$val->account_name,
									$val->account_type_name,
									$val->tax_type_name,
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
function build_account_container($id)
{
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->hidden('account_idx',$id);
		$CI->make->sDivCol();
			$CI->make->sTab();
				$tabs = array(
					fa('fa-info-circle')." Account Details" => array(
																'href'=>'#details',
																'class'=>'tab_link',
																'load'=>'general_ledger/account_form',
																'id'=>'details_link'),
					);
				$CI->make->tabHead($tabs,null,array());
				$CI->make->sTabBody();
					$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
					$CI->make->eTabPane();
				$CI->make->eTabBody();
			$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function build_account_form($account)
{
	$CI =& get_instance();
	$CI->make->sForm("general_ledger/account_db",
		array('id'=>'account_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
				if (iSetObj($account,'account_code'))
					$CI->make->input('Account Code','account_code',$account->account_code,'Account Code',array('maxchars'=>'15','readOnly'=>'readOnly'));
				else
					$CI->make->input('Account Code','account_code','','Account Code',array('maxchars'=>'15'));
				$CI->make->input('Account name','account_name',iSetObj($account,'account_name'),'Account name',array('class'=>'rOkay','maxchars'=>'50'));
				$CI->make->accountTypeDrop('Account type','account_type',iSetObj($account,'account_type'),'',array('class'=>'rOkay'));
				$CI->make->taxTypeDrop('Tax type','tax_type_id',iSetObj($account,'tax_type_id'),'Select tax type',array('class'=>'rOkay'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(3);
				$CI->make->button(fa('fa-save').' Save Account details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->button(fa('fa-reply').' Return to GL Accounts',array('id'=>'back-btn','class'=>'btn-block'),'default');
			$CI->make->eDivCol();
	    $CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}