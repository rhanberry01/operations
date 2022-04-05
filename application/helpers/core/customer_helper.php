<?php



function customerMasterPage($list=array()){

	$CI =& get_instance();

		$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Customer', base_url().'customer/manage_customer_master',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
						$CI->make->sDivRow();
					
					
							$CI->make->sDivCol();
							$th = array(
									'Code' => array('width'=>'15%'),
									'Customer' => array('width'=>'30%'),
									'Address'=>'',
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							 foreach($list as $v){
								$links = "";
								$address = $v->street." ".$v->brgy.", ".$v->city;
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'customer/manage_customer_master/'.$v->cust_id ,array("return"=>true));
								$rows[] = array(
											  $v->cust_code,
											  $v->description,
											  $address,
											  $links
									);

							}
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
		
	return $CI->make->code();
	
	
	
}


//-----------Branch Details-----start-----allyn
function customerPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New Customer',base_url().'customer/manage_customers',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
					
						$CI->make->sDivCol();
							$th = array(
									'Customer Code' => array('width'=>'15%'),
									'Customer Name' => array('width'=>'30%'),
									'Address'=>'',
									'Email'=>'',
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $v){
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'customer/manage_customers'.$v->debtor_id,array("return"=>true));
								$rows[] = array(
											  $v->debtor_code,
											  $v->name,
											  $v->address,
											  $v->email,
											  $links
									);

							}
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	return $CI->make->code();
}


function customer_master_form($item=null){


	$CI =& get_instance();
	
        $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
            $CI->make->sDivCol();
                $CI->make->A(fa('fa-reply').' GO BACK',base_url().'customer/customer_master',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
                $CI->make->hidden('cust_id',iSetObj($item,'cust_id'));
            $CI->make->eDivCol();
        $CI->make->eDivRow();
        $CI->make->sDivRow();
            $CI->make->sDivCol();
                $CI->make->sTab();
				
                    $tabs = array(
                        fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
                        // fa('fa-money')." GL Entries"=>array('href'=>'#accounting','class'=>'tab_link load-tab','load'=>'asset/gl_entries','id'=>'accounting_link'),
                        // fa('fa-book')." History" => array('href'=>'#history','class'=>'tab_link load-tab','load'=>'asset/histoy_load','id'=>'history_link'),
                    );
					
                    $CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
                        $CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
					$CI->make->eTabPane();
                        $CI->make->sForm("customer/customer_master_details_db",array('id'=>'customer_details_form'));
						// if (!empty($supplier_id)){
						$CI->make->hidden('cust_id',iSetObj($item,'cust_id'));
						$CI->make->hidden('mode',((iSetObj($item,'cust_id')) ? 'edit' : 'add'));
						// }

                        $CI->make->sDivRow();
                        	////left side
	                    	$CI->make->sDivCol(6);
	                    		$CI->make->input('Customer Code','cust_code',iSetObj($item,'cust_code'),null,array('class'=>'rOkay'));
	                    		$CI->make->input('Customer Description','desc',iSetObj($item,'description'),null,array('class'=>'rOkay'));
	                    		$CI->make->textarea('Street','street',iSetObj($item,'street'),null,array('class'=>''));
	                    		$CI->make->input('Email','email',iSetObj($item,'email_address'),null,array('class'=>''));
	                    		$CI->make->input('Barangay.','barangay',iSetObj($item,'brgy'),null,array('class'=>''));
	                    		$CI->make->input("City",'city',iSetObj($item,'city'),null,array('class'=>''));
								$CI->make->input("Telephone",'tel',iSetObj($item,'tel_no'),null,array('class'=>''));
	                    	$CI->make->eDivCol();

	                    	////////////right side
	                    	$CI->make->sDivCol(6);
	                    		$CI->make->input('Mobile #','mobile',iSetObj($item,'mobile_no'),null,array('class'=>''));
								$CI->make->input("Referred By",'referred_by',iSetObj($item,'referred_by'),null,array('class'=>''));
								$CI->make->datefield('Birthday','bday',iSetObj($item,'birthday'),'Select Date',array('class'=>'rOkay'),$icon1="<i class='fa fa-fw fa-calendar'></i>");
								//$CI->make->decimal('Credit Limit','credit_limit',iSetObj($item,'credit_limit'),null,2,array('class'=>''));
	                    		// $CI->make->decimal('Credit Limit','credit_limit',(isset($item->credit_limit) ? $item->credit_limit : '0'),null,array('class'=>''));
	                    		// $CI->make->paymentTermsDrop('Payment Term','payment_term',iSetObj($item,'payment_term'),null,array('class'=>''));
	                    	    // $CI->make->creditStatusDrop('Credit Status','credit_status',iSetObj($item,'credit_status'),null,array('class'=>''));
								$CI->make->sDivRow();
									
									$CI->make->sDivCol(4);
									$CI->make->decimal('Discount %1','ds1',iSetObj($item,'disc_percent_1'),null,2,array('class'=>''),null,'%');
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
									$CI->make->decimal('Discount %2','ds2',iSetObj($item,'disc_percent_2'),null,2,array('class'=>''),null,'%');
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
									$CI->make->decimal('Discount %3','ds3',iSetObj($item,'disc_percent_3'),null,2,array('class'=>''),null,'%');
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(4);
									$CI->make->decimal('Disc Amt #1','amt1',iSetObj($item,'disc_amount_1'),null,array('class'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
									$CI->make->decimal('Disc Amt #2','amt2',iSetObj($item,'disc_amount_2'),null,array('class'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
									$CI->make->decimal('Disc Amt #3','amt3',iSetObj($item,'disc_amount_3'),null,array('class'=>''));
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(6);
									$CI->make->decimal('Credit Limit','credit_limit',iSetObj($item,'credit_limit'),null,2,array('class'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
									$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($item,'inactive'),null,array('class'=>''));
									$CI->make->eDivCol();
								
								$CI->make->eDivRow();
							$CI->make->eDivCol();
							
                        $CI->make->eDivRow();


                        $CI->make->sDivRow(array('style'=>'margin:10px; align:center;'));
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
							$CI->make->sDivCol(4, 'right');
								$CI->make->button(fa('fa-save').' Save Customer Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
					    $CI->make->eDivRow();

					    $CI->make->eForm();

                        // $CI->make->eTabPane();

                        // $CI->make->sTabPane(array('id'=>'accounting','class'=>'tab-pane'));
                        // $CI->make->eTabPane();

                        // $CI->make->sTabPane(array('id'=>'history','class'=>'tab-pane bg-white-gray','style'=>'margin:-10px;'));
                        // $CI->make->eTabPane();
                    $CI->make->eTabBody();
                $CI->make->eTab();
            $CI->make->eDivCol();
        $CI->make->eDivRow();

    return $CI->make->code();
}



function manage_customer_form($item=null){


    $CI =& get_instance();
        $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
            $CI->make->sDivCol();
                $CI->make->A(fa('fa-reply').' GO BACK',base_url().'customer/customers',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
                $CI->make->hidden('asset_id',iSetObj($item,'asset_id'));
            $CI->make->eDivCol();
        $CI->make->eDivRow();
        $CI->make->sDivRow();
            $CI->make->sDivCol();
                $CI->make->sTab();
                    $tabs = array(
                        fa('fa-info-circle')." General Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
                        // fa('fa-money')." GL Entries"=>array('href'=>'#accounting','class'=>'tab_link load-tab','load'=>'asset/gl_entries','id'=>'accounting_link'),
                        // fa('fa-book')." History" => array('href'=>'#history','class'=>'tab_link load-tab','load'=>'asset/histoy_load','id'=>'history_link'),
                    );
                    $CI->make->tabHead($tabs,null,array());
                    $CI->make->sTabBody(array());
                        $CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

                        $CI->make->sForm("customer/customer_details_db",array('id'=>'customer_details_form'));
						//if (!empty($supplier_id)) {
							$CI->make->hidden('debtor_id',iSetObj($item,'debtor_id'));
						//}

                        $CI->make->sDivRow();
                        	////left side
	                    	$CI->make->sDivCol(6);
	                    		$CI->make->input('Customer Code','debtor_code',iSetObj($item,'debtor_code'),null,array('class'=>'rOkay'));
	                    		$CI->make->input('Customer Name','name',iSetObj($item,'name'),null,array('class'=>'rOkay'));
	                    		$CI->make->textarea('Address','address',iSetObj($item,'address'),null,array('class'=>''));
	                    		$CI->make->input('Email','email',iSetObj($item,'email'),null,array('class'=>''));
	                    		$CI->make->input('GSTNo/TIN No.','tax_no',iSetObj($item,'tax_no'),null,array('class'=>''));
	                    		$CI->make->currenciesDrop("Customer's Currency",'currency',iSetObj($item,'currency'),null,array('class'=>''));
	                    	$CI->make->eDivCol();

	                    	////////////right side
	                    	$CI->make->sDivCol(6);
	                    		$CI->make->salesTypeDrop('Sales Type','sales_type',iSetObj($item,'sales_type'),null,array('class'=>''));
	                    		$CI->make->decimal('Discount Percent','discount',iSetObj($item,'discount'),null,2,array('class'=>''),null,'%');
	                    		$CI->make->decimal('Prompt Payment Discount Percent','payment_discount',iSetObj($item,'payment_discount'),null,2,array('class'=>''),null,'%');
	                    		$CI->make->decimal('Credit Limit','credit_limit',iSetObj($item,'credit_limit'),null,2,array('class'=>''));
	                    		// $CI->make->decimal('Credit Limit','credit_limit',(isset($item->credit_limit) ? $item->credit_limit : '0'),null,array('class'=>''));
	                    		$CI->make->paymentTermsDrop('Payment Term','payment_term',iSetObj($item,'payment_term'),null,array('class'=>''));
	                    		$CI->make->creditStatusDrop('Credit Status','credit_status',iSetObj($item,'credit_status'),null,array('class'=>''));
	                    		$CI->make->input('Business Style','business_style',iSetObj($item,'business_style'),null,array('class'=>''));
	                    	$CI->make->eDivCol();
                        $CI->make->eDivRow();


                        $CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
							$CI->make->sDivCol(4, 'right');
								$CI->make->button(fa('fa-save').' Save Customer Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
					    $CI->make->eDivRow();

					    $CI->make->eForm();

                        $CI->make->eTabPane();

                        // $CI->make->sTabPane(array('id'=>'accounting','class'=>'tab-pane'));
                        // $CI->make->eTabPane();

                        // $CI->make->sTabPane(array('id'=>'history','class'=>'tab-pane bg-white-gray','style'=>'margin:-10px;'));
                        // $CI->make->eTabPane();
                    $CI->make->eTabBody();
                $CI->make->eTab();
            $CI->make->eDivCol();
        $CI->make->eDivRow();

    return $CI->make->code();
}


function build_customer_branches_display($list)
{
	$CI =& get_instance();

	$CI->make->sBox('success');
		$CI->make->sBoxBody();
			$CI->make->sDivRow();
				$CI->make->sDivCol(12,'right');
					$CI->make->A(fa('fa-plus').' New Customer Branch',base_url().'customer/customer_branches/new',array('class'=>'btn btn-primary'));
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			$CI->make->sDivRow();
				$CI->make->sDivCol();
					$th = array(
						'Customer Code' => array('width'=>'15%'),
						'Customer Name' => array('width'=>'30%'),
						'Address' => array(),
						'Email' => array(),
						' '=>array('width'=>'10%')
						);
					$rows = array();
					foreach ($list as $val) {
						$link = "";
						$link .= $CI->make->A(
							fa('fa-pencil fa-lg fa-fw'),
							base_url().'general_ledger/customer_branches/'.$val->debtor_branch_id,
							array('return'=>'true',
								'title'=>'Edit '.$val->branch_name));

						$rows[] = array(
							$val->debtor_code,
							$val->name,
							$val->address,
							$val->email,
							$link
							//array('text'=>$link,'params'=>array('style'=>'text-align:center'))
						);
					}
					$CI->make->listLayout($th,$rows);
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eBoxBody();
	$CI->make->eBox();

	return $CI->make->code();
}
function customerBranchPage($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							//$CI->make->A(fa('fa-plus').' Add New Customer',base_url().'customer/manage_customers',array('class'=>'btn btn-primary'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol();
							$th = array(
									'Customer Code' => array('width'=>'15%'),
									'Customer Name' => array('width'=>'30%'),
									'Address'=>'',
									'Email'=>'',
									' '=>array('width'=>'10%','align'=>'right'));
							$rows = array();
							foreach($list as $v){
								$links = "";
								$links .= $CI->make->A(fa('fa-edit fa-lg fa-fw'),base_url().'customer/manage_customers_branch/'.$v->debtor_id,array("return"=>true));
								$rows[] = array(
											  $v->debtor_code,
											  $v->name,
											  $v->address,
											  $v->email,
											  $links
									);

							}
							$CI->make->listLayout($th,$rows);
						$CI->make->eDivCol();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();

	return $CI->make->code();
}
function manage_customerBranches_form($item=null,$debtor_id=null){
    $CI =& get_instance();
        $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
            $CI->make->sDivCol();
                $CI->make->A(fa('fa-reply').' GO BACK',base_url().'customer/customer_branches',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
            $CI->make->eDivCol();
        $CI->make->eDivRow();
        $CI->make->sDivRow();
            $CI->make->sDivCol();
                $CI->make->sTab();
                    $tabs = array(
                        fa('fa-info-circle')." Branches"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
                        // fa('fa-money')." GL Entries"=>array('href'=>'#accounting','class'=>'tab_link load-tab','load'=>'asset/gl_entries','id'=>'accounting_link'),
                        // fa('fa-book')." History" => array('href'=>'#history','class'=>'tab_link load-tab','load'=>'asset/histoy_load','id'=>'history_link'),
                    );
                    $CI->make->tabHead($tabs,null,array());
                    $CI->make->sTabBody(array());
                        $CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

                        //$CI->make->sForm("customer/customer_branches_db",array('id'=>'customer_branches_form'));
						//if (!empty($supplier_id)) {
							$CI->make->hidden('debtor_id',$debtor_id);
							$CI->make->hidden('debtor_branch_id',iSetObj($item,'debtor_branch_id'));
						//}
						$CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
							$CI->make->sDivCol(6);
								$where = array('debtor_id'=>$debtor_id);
                                $deb = $CI->customer_model->get_details($where,'debtor_master');
                                if($deb)
									$CI->make->H(3,$deb[0]->name."'s Branches");
                                else
									$CI->make->H(3,'');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4, 'right');
							$CI->make->eDivCol();
							$CI->make->sDivCol(2);
								$CI->make->button(fa('fa-plus').' Add Branch',array('id'=>'add-branch-btn','class'=>'btn-block'),'primary');
							$CI->make->eDivCol();
					    $CI->make->eDivRow();

                        $CI->make->sDivRow();
                        	$CI->make->sDivCol(1, 'center');
							$CI->make->eDivCol();
							$CI->make->sDivCol(10, 'center');
							if($item != null){
								$CI->make->sTable(array('class'=>'table'));
					                $CI->make->sRow();
					                    $CI->make->th('Branch Name',array('style'=>'text-align:center;'));
					                    $CI->make->th('Contact Person',array('style'=>'text-align:center;'));
					                    $CI->make->th('Sales Person',array('style'=>'text-align:center;'));
					                    $CI->make->th('Area',array('style'=>'text-align:center;'));
					                    $CI->make->th('Phone No.',array('style'=>'text-align:center;'));
					                    $CI->make->th('Fax No.',array('style'=>'text-align:center;'));
					                    $CI->make->th('Email',array('style'=>'text-align:center;'));
					                    $CI->make->th('Tax Group',array('style'=>'text-align:center;'));
					                    $CI->make->th('Currency',array('style'=>'text-align:center;'));
					                    $CI->make->th('');
					                    //$CI->make->th('Account Parent');
					                $CI->make->eRow();

					                foreach ($item as $val) {
					                	$CI->make->sRow(array('class'=>'item-row','id'=>''));
		                                     $CI->make->td($val->branch_name,array('style'=>'text-align:center;'));
		                                     $CI->make->td($val->contact_person,array('style'=>'text-align:center;'));

		                                     $where = array('sales_person_id'=>$val->sales_person_id);
		                                     $sales_person = $CI->customer_model->get_details($where,'sales_persons');
		                                     if($sales_person)
		                                     	$CI->make->td($sales_person[0]->name);
		                                     else
		                                     	$CI->make->td('');

		                                     $CI->make->td($val->area);
		                                     $CI->make->td($val->phone);
		                                     $CI->make->td($val->fax);
		                                     $CI->make->td($val->email);

		                                     $where = array('tax_type_id'=>$val->tax_grp);
		                                     $tax = $CI->customer_model->get_details($where,'tax_types');
		                                     if($tax)
		                                     	$CI->make->td($tax[0]->type_name);
		                                     else
		                                     	$CI->make->td('');

		                                     $where = array('id'=>$val->currency);
		                                     $curr = $CI->customer_model->get_details($where,'currencies');
		                                     if($curr)
		                                     	$CI->make->td($curr[0]->currency_abrev);
		                                     else
		                                     	$CI->make->td('');

		                                     $button = $CI->make->A(fa('fa-pencil'),base_url().'customer/add_branch/'.$val->debtor_id.'/'.$val->debtor_branch_id,array("return"=>true));
		                                     $CI->make->td($button);
		                                $CI->make->eRow();
					                }


					            $CI->make->eTable();
					        }else{
					        	$CI->make->append('<br>');
					        	$CI->make->span('No Branches Found.',array('style'=>'text-align:center;font-weight:bold;'));
					        	$CI->make->append('<br><br>');
					        }

							$CI->make->eDivCol();
							$CI->make->sDivCol(1, 'center');
							$CI->make->eDivCol();

					    $CI->make->eDivRow();

					    //$CI->make->eForm();

                        $CI->make->eTabPane();

                        // $CI->make->sTabPane(array('id'=>'accounting','class'=>'tab-pane'));
                        // $CI->make->eTabPane();

                        // $CI->make->sTabPane(array('id'=>'history','class'=>'tab-pane bg-white-gray','style'=>'margin:-10px;'));
                        // $CI->make->eTabPane();
                    $CI->make->eTabBody();
                $CI->make->eTab();
            $CI->make->eDivCol();
        $CI->make->eDivRow();

    return $CI->make->code();
}
function add_branches_form($item=null,$debtor_id=null){
    $CI =& get_instance();
        $CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
            $CI->make->sDivCol();
                $CI->make->A(fa('fa-reply').' GO BACK',base_url().'customer/manage_customers_branch/'.$debtor_id,array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
            $CI->make->eDivCol();
        $CI->make->eDivRow();
        $CI->make->sDivRow();
            $CI->make->sDivCol();
                $CI->make->sTab();
                    $tabs = array(
                        fa('fa-info-circle')." Branch Details"=>array('href'=>'#details','class'=>'tab_link','load'=>'#','id'=>'details_link'),
                        // fa('fa-money')." GL Entries"=>array('href'=>'#accounting','class'=>'tab_link load-tab','load'=>'asset/gl_entries','id'=>'accounting_link'),
                        // fa('fa-book')." History" => array('href'=>'#history','class'=>'tab_link load-tab','load'=>'asset/histoy_load','id'=>'history_link'),
                    );
                    $CI->make->tabHead($tabs,null,array());
                    $CI->make->sTabBody(array());
                        $CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));

                        $CI->make->sForm("customer/branch_details_db",array('id'=>'branch_details_form'));
						//if (!empty($supplier_id)) {
							$CI->make->hidden('debtor_id',$debtor_id);
							$CI->make->hidden('debtor_branch_id',iSetObj($item,'debtor_branch_id'));
							$CI->make->hidden('mode',((iSetObj($item,'debtor_branch_id')) ? 'edit' : 'add'));
						//}
						$CI->make->sDivRow();
				            $CI->make->sDivCol();
				                //$depAmount = iSetObj($item,'amount',0) - iSetObj($item,'deducted',0);
				                $CI->make->H(3,"Basic Information");
				            $CI->make->eDivCol();
				        $CI->make->eDivRow();

                        $CI->make->sDivRow();
                        	////left side
	                    	$CI->make->sDivCol(4);
	                    		$CI->make->input('Branch Name','branch_name',iSetObj($item,'branch_name'),null,array('class'=>'rOkay reqForm'));
	                    		$CI->make->input('Fax Number','fax',iSetObj($item,'fax'),null,array('class'=>'reqForm'));
	                    		$CI->make->textarea('Mailing Address','branch_address',iSetObj($item,'branch_address'),null,array('class'=>'textarea-vert-only reqForm'));
	                    		// $CI->make->input('GSTNo/TIN No.','tax_no',iSetObj($item,'tax_no'),null,array('class'=>''));
	                    		// $CI->make->currenciesDrop("Customer's Currency",'currency',iSetObj($item,'currency'),null,array('class'=>''));
	                    	$CI->make->eDivCol();

	                    	////////////center
	                    	$CI->make->sDivCol(4);
	                    		$CI->make->input('Contact Person','contact_person',iSetObj($item,'contact_person'),null,array('class'=>'rOkay reqForm'));
	                    		$CI->make->input('Phone Number','phone',iSetObj($item,'phone'),null,array('class'=>'reqForm'));
	                    		$CI->make->textarea('Billing Address','branch_post_address',iSetObj($item,'branch_post_address'),null,array('class'=>'textarea-vert-only reqForm'));
	                    		// $CI->make->input('Prompt Payment Discount Percent','payment_discount',iSetObj($item,'payment_discount'),null,array('class'=>''),null,'%');
	                    		// $CI->make->input('Credit Limit','credit_limit',iSetObj($item,'credit_limit'),null,array('class'=>''));
	                    		// // $CI->make->decimal('Credit Limit','credit_limit',(isset($item->credit_limit) ? $item->credit_limit : '0'),null,array('class'=>''));
	                    		// $CI->make->paymentTermsDrop('Payment Term','payment_term',iSetObj($item,'payment_term'),null,array('class'=>''));
	                    		// $CI->make->creditStatusDrop('Credit Status','credit_status',iSetObj($item,'credit_status'),null,array('class'=>''));
	                    	$CI->make->eDivCol();
	                    	////////////right side
	                    	$CI->make->sDivCol(4);
	                    		$CI->make->input('Email','email',iSetObj($item,'email'),null,array('class'=>'reqForm'));
	                    		$CI->make->inactiveDrop('Is Inactive?','inactive',iSetObj($item,'inactive'),'',array('class'=>'reqForm', 'style'=>'width: 85px;'));
	                    		// $CI->make->input('Discount Percent','discount',iSetObj($item,'discount'),null,array('class'=>''),null,'%');
	                    		// $CI->make->input('Prompt Payment Discount Percent','payment_discount',iSetObj($item,'payment_discount'),null,array('class'=>''),null,'%');
	                    		// $CI->make->input('Credit Limit','credit_limit',iSetObj($item,'credit_limit'),null,array('class'=>''));
	                    		// // $CI->make->decimal('Credit Limit','credit_limit',(isset($item->credit_limit) ? $item->credit_limit : '0'),null,array('class'=>''));
	                    		// $CI->make->paymentTermsDrop('Payment Term','payment_term',iSetObj($item,'payment_term'),null,array('class'=>''));
	                    		// $CI->make->creditStatusDrop('Credit Status','credit_status',iSetObj($item,'credit_status'),null,array('class'=>''));
	                    	$CI->make->eDivCol();
                        $CI->make->eDivRow();

                        $CI->make->sDivRow();
				            $CI->make->sDivCol();
				                //$depAmount = iSetObj($item,'amount',0) - iSetObj($item,'deducted',0);
				                $CI->make->H(3,"Sales Information");
				            $CI->make->eDivCol();
				        $CI->make->eDivRow();

				        $CI->make->sDivRow();
                        	////left side
	                    	$CI->make->sDivCol(4);
	                    		$CI->make->salesPersonDrop('Sales Person','sales_person_id',iSetObj($item,'sales_person_id'),'Select Person',array('class'=>'reqForm'));
	                    		$CI->make->shippingCompDrop('Default Shipping Company','default_shipper',iSetObj($item,'default_shipper'),null,array('class'=>'reqForm'));

	                    	$CI->make->eDivCol();

	                    	////////////center
	                    	$CI->make->sDivCol(4);
	                    		$CI->make->input('Sales Area','area',iSetObj($item,'area'),null,array('class'=>''));
	                    		$CI->make->taxGroupDrop('Tax Group','tax_grp',iSetObj($item,'tax_grp'),'Select Tax Type',array('class'=>'reqForm'));
	                    	$CI->make->eDivCol();
	                    	////////////right side
	                    	$CI->make->sDivCol(4);
	                    		// $CI->make->input('Default Inventory Location','inv_location',iSetObj($item,'inv_location'),null,array('class'=>''));
	                    		$CI->make->inventoryLocationsDrop('Default Inventory Location','Default Inventory Location',iSetObj($item,'Default Inventory Location'),null,array('class'=>'reqForm'));
	                    		$CI->make->currenciesDrop('Branch Currency','currency',iSetObj($item,'currency'),'Select Currency',array('class'=>'reqForm'));
	                    	$CI->make->eDivCol();
                        $CI->make->eDivRow();

                        $CI->make->sDivRow(array('style'=>'margin:10px; align: center;'));
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
							$CI->make->sDivCol(4, 'right');
								$CI->make->button(fa('fa-save').' Save Branch Details',array('id'=>'save-branch-btn','class'=>'btn-block'),'primary');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
					    $CI->make->eDivRow();

					    $CI->make->eForm();

                        $CI->make->eTabPane();

                        // $CI->make->sTabPane(array('id'=>'accounting','class'=>'tab-pane'));
                        // $CI->make->eTabPane();

                        // $CI->make->sTabPane(array('id'=>'history','class'=>'tab-pane bg-white-gray','style'=>'margin:-10px;'));
                        // $CI->make->eTabPane();
                    $CI->make->eTabBody();
                $CI->make->eTab();
            $CI->make->eDivCol();
        $CI->make->eDivRow();

    return $CI->make->code();
}

//-----------Branch References-----end-----allyn


?>