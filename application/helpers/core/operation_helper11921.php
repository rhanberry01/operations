<?php
error_reporting(E_ERROR | E_PARSE);
function recount_form($items = array(),$auto = array(),$cat = array(),$next_trans){
	$CI =& get_instance();
		$CI->make->sDivCol();
			$CI->make->sDivRow();
				//left search
			
			$CI->make->sDivCol(10,'',1);
			$CI->make->sDivRow();	

				//middle temporary
				$CI->make->sDivCol(12);
					$CI->make->sBox('primary',array('style'=>''));
						$CI->make->sBoxBody();				
							$CI->make->input('Search Product','barcode','','Enter Product Here...',array('class'=>'','id'=>'r_autocomplete','autocomplete'=>'off'));
							
								$CI->make->sDiv(array('id'=>'r_asset_list_datasearch'));			
									$CI->make->sDivCol();										
										$CI->make->sDivRow();
												$CI->make->sRow();
													$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:120px;overflow:auto'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'r_details-tbl'));
														$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
															//$CI->make->th('Product Code',array('style'=>''));
															$CI->make->th('Bar Code',array('style'=>''));
															$CI->make->th('Description',array('style'=>''));
															$CI->make->th('UOM',array('style'=>''));

														$CI->make->eRow();	
													$CI->make->eTable();		
													$CI->make->eDiv();
												$CI->make->eRow();
										$CI->make->eDivRow();									
									$CI->make->eDivCol();	
								$CI->make->eDiv();
							$CI->make->sDivRow();

						
							$CI->make->eDivRow();

							$CI->make->H(5,'Recount Product List',array('style'=>''));
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sForm("",array('id'=>'r_auto_form'));	
									
									$CI->make->sDiv(array('id'=>'asset_list_recount'));
									
														
											$CI->make->sDivCol();
												// foreach($items2 as $v2){
												// 	$ddid = $v2->Branch."".$v2->AutoID;
												// 	$dddate = $v2->DateTrans;
												// 	$iid = $v2->InfoId;
												// 	//$CI->make->hidden('infoid',$v2->InfoId);
												// 	$tno = $v2->TransNoIGSA;
												// 	$tno2 = $v2->TransNoIGNSA;

												// }	
												// $CI->make->p($ddid." - ".$dddate);
												//$CI->make->hidden('','r_date_',date('m/d/Y',strtotime("-1 days")));
												$CI->make->A(fa('fa-file-excel-o').' Export to Excel','',array('class'=>'btn btn-success btn-flat','id'=>'r_btn-export'));
												
												
												$CI->make->p('Transaction No: '.$next_trans);
												
												$CI->make->hidden('trans_num',$next_trans);	
												$CI->make->hidden('date_adjustment',date('Y-m-d'));	
												$CI->make->hidden('movement','Inventory Gained (SA)');	
												$CI->make->hidden('stat_type','Open / For Approval');	


												$CI->make->input('','r_txtrecprod','','Search Product',array('class'=>'','id'=>'r_txtrecprod'));
												$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:250px;overflow:auto'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'recount_list'));
														$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
															$CI->make->th('Item',array('style'=>'','align=center'));
															$CI->make->th('UoM',array('style'=>'','align=center'));
															$CI->make->th('Cost',array('style'=>'','align=center'));
															$CI->make->th('Quantity Inventory',array('style'=>'','align=center'));
															$CI->make->th('Qty',array('style'=>'','align=center'));
															$CI->make->th('Adjustment Qty',array('style'=>'','align=center'));
															$CI->make->th('Unit Cost',array('style'=>'','align=center'));
															$CI->make->th('Total Cost',array('style'=>'','align=center'));
															$CI->make->th('',array('style'=>'','align=center'));
														$CI->make->eRow();

												$CI->make->sTableBody(array('id'=>'r_tblautoprod'));
													$checkbox="";
													$no = 1;

													foreach($items as $v){
																if($v->CostOfSales == .0000)
																{
																	$cos2 = "0";
																}
																else
																{
																	$cos2 = $v->CostOfSales;
																}
																if($v->SellingArea == .0000)
																{
																	$sa = "0";
																}
																else
																{
																	$sa = $v->SellingArea;
																}

														$CI->make->hidden('movcode_'.$no,'',array('class'=>'movcode_'.$no));
														$CI->make->hidden('qtyuom_'.$no,$v->qty,array('class'=>'qtyuom_'.$no));
														$CI->make->hidden('prod_id_'.$no,$v->ProductID,array('class'=>'prod_id'));
														//$CI->make->hidden('prod_code_'.$no,$v->ProductCode,array('class'=>'prod_code'));
														$CI->make->hidden('prod_code_'.$no,$v->ProductCode,array('class'=>'prod_code','id'=>'prod_code_'.$no));
														$CI->make->hidden('prod_desc_'.$no,$v->Description,array('id'=>'prod_desc_'.$no));
														//$CI->make->hidden('cost_'.$no,$v->CostOfSales,array('class'=>'cost'));
														$CI->make->hidden('uom_qty2_'.$no,'',array('class'=>'uom','id'=>'uom_qty2_'.$no));
														$CI->make->hidden('cost_'.$no,$cos2,'',array('class'=>'cost','id'=>'cost_'.$no));
														$CI->make->hidden('unit_'.$no,'',array('class'=>'unit','id'=>'unit_'.$no));

														$CI->make->hidden('neg_qty_'.$no,$sa,array('class'=>'qty_edit'));
														$CI->make->hidden('tot_cert_'.$no,'',array('class'=>'totcert'));
														$CI->make->hidden('needtocertify_'.$no,'',array('id'=>'needtocertify_'.$no));
													
													//$role = "Security";
														// if($role == "Security")
														// {
														// 	if($v->isCertified == 1){
														// 		$checkbox = $CI->make->checkbox('','chk_'.$no,$v->Id,array('return'=>true,'class'=>'check','disabled'=>'true','checked'=>'true'));
																
														// 	}else{
														// 		$checkbox = $CI->make->checkbox('','chk_'.$no,$v->Id,array('return'=>true,'class'=>'check','disabled'=>'true',''));
														// 	}
														// }	
														$del =
														$CI->make->A(fa('fa-trash fa-lg fa-fw').'',
																	'',array('class'=>'btn-del',
																	'id'=>'btn_del_recount',
																	'ref_desc'=>'',
																	'data-id'=>$v->Barcode,
																	'data-desc'=>$v->Description,
																	'style'=>'cursor: pointer;color:red',
																	'return'=>'false'));
 
														
														$certot = $CI->make->p('',array('id'=>'tot'));

														$CI->make->sRow();
															$CI->make->td($v->Description);
															$CI->make->td($v->uom);
															$CI->make->td($v->CostOfSales);
															$CI->make->td($v->SellingArea);

															 $CI->make->td("<input type='text' id='rcqty_$no' class='rcqty' value=''>");
															 $CI->make->td("<input type='text' id='ad_qty2_$no' disabled class='adjustment_qty' placeholder='Adjustment Quantity'>"."<input type='hidden' id='mc_$no'>");
															$CI->make->td("<input type='text' id='unit_cost2_$no' disabled value='".$v->CostOfSales."' class = 'allunitcost'>");
															$CI->make->td("<input type='text' id='total_$no' disabled value='' class = 'allunitcost'>");
															 $CI->make->td($del." <span id='warning_$no'></span>");
														$CI->make->eRow();

													$no++;
													}


												$CI->make->eTableBody();

													$CI->make->eTable();
												$CI->make->eDiv();

												$CI->make->hidden('total','',array('disabled'=>'disabled'));
												$CI->make->textarea('Remarks','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
															
												$CI->make->button('Close',array('class'=>'btn btn-danger btn-flat pull-right','data-dismiss'=>'modal'),'button');	
												if($tno == null and $tno2 == null)
												{
													$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'r_save_auto_btn','class'=>'btn btn-primary btn-flat pull-right','style'=>'margin-right:10px'),'submit');
												}
												else
												{
													$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'save_auto_btn2','disabled'=>'disabled','class'=>'btn btn-primary btn-flat pull-right','style'=>'margin-right:10px'),'submit');
												}
								
											$CI->make->eDivCol();
												
									
									$CI->make->eDiv();
										$CI->make->eForm();
										
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
							
						$CI->make->eBoxBody();
					$CI->make->eBox();		
				$CI->make->eDivCol();
				
			$CI->make->eDivRow();

			$CI->make->eDivCol();
				//right auto cc
				
			$CI->make->eDivRow();
		$CI->make->eDivCol();
	


		$CI->make->sDiv(array('id'=>'r_myModaldel','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));
					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$label = "<i class='fa fa-warning' style='font-size:38px;color:red'></i>";
						$CI->make->h(4,$label.' Confirm Delete',array('style'=>''));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						$CI->make->sForm("",array('id'=>'r_delcc_form'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									$CI->make->sRow();
									//function hidden($nameID=null,$value=null,$params=array()){
										$CI->make->p('Are you sure you want to delete <span id="desc" style="color:red"></span> product on list?',array('style'=>''));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'del_id'));
										//$CI->make->hidden('del_id','',array('class'=>'','disabled'=>'disabled','required'=>'required'));
									$CI->make->eRow();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-check fa-lg fa-fw').'Delete',array('id'=>'r_confirmprod-delete','class'=>'btn btn-flat btn-primary'),'button');
						$CI->make->button(fa('fa-close fa-lg fa-fw').'Cancel',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
						$CI->make->eForm();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'myModaldel','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));
					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$label = "<i class='fa fa-warning' style='font-size:38px;color:red'></i>";
						$CI->make->h(4,$label.' Confirm Delete',array('style'=>''));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						$CI->make->sForm("",array('id'=>'delcc_form'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									$CI->make->sRow();
									//function hidden($nameID=null,$value=null,$params=array()){
										$CI->make->p('Are you sure you want to delete <span id="desc" style="color:red"></span> product on list?',array('style'=>''));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'del_id'));
										//$CI->make->hidden('del_id','',array('class'=>'','disabled'=>'disabled','required'=>'required'));
									$CI->make->eRow();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-check fa-lg fa-fw').'Delete',array('id'=>'confirmprod-delete','class'=>'btn btn-flat btn-primary'),'button');
						$CI->make->button(fa('fa-close fa-lg fa-fw').'Cancel',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
						$CI->make->eForm();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();


		$CI->make->sDiv(array('id'=>'myModal','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
				$CI->make->sDiv(array('class'=>'modal-content'));

					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$CI->make->H(4,'Cycle Count Item List',array('style'=>'','class'=>'modal-title'));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						$CI->make->sDiv(array('id'=>'asset_list_data5'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									
								$CI->make->eDivRow();
							$CI->make->eDivCol();
						$CI->make->eDiv();
					$CI->make->eDiv();
					
					// $CI->make->sDiv(array('class'=>'modal-footer'));
					// 	$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'add_item_adjustment','class'=>'btn btn-primary btn-flat'),'button');
					// 	$CI->make->button('Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					// $CI->make->eDiv();
					
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'r_myModalviewdl','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
				$CI->make->sDiv(array('class'=>'modal-content'));

					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$CI->make->H(4,'',array('style'=>'','class'=>'modal-title'));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));
						//$close = "<span aria-hidden='true' style='font-size:30px;color:red'><b>&times;</b></span>";
							//$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
							$dl = "<center><a href='../ReCount.xlsx' class='btn btn-success' id='dlfile' >Download File</a>&nbsp;&nbsp;<a class='btn btn-danger' data-dismiss='modal'>Cancel</a></center>";

							$CI->make->p($dl);

					$CI->make->eDiv();
						// $CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'save_auto_cc','class'=>'btn btn-primary btn-flat'),'button');
						// $CI->make->button(fa('fa-close').'Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
				
					// $CI->make->sDiv(array('class'=>'modal-footer'));
					// //	$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'add_item_adjustment','class'=>'btn btn-primary btn-flat'),'button');
					// 	//$CI->make->button(fa('fa-close').'Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					// $CI->make->eDiv();
					
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'r_myModalcert','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));

					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$label = "<i class='fa fa-lock' style='font-size:38px;color:black'></i>";
						$CI->make->h(4,$label.' Confirm Login to certify item <span id="certifyprod" style="color:red"></span>',array('style'=>''));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						//$CI->make->sForm("",array('id'=>'certify_form'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									$CI->make->sRow();
									//function hidden($nameID=null,$value=null,$params=array()){
										$CI->make->input('Username','user','','Username',array('class'=>'form-control','style'=>'padding:10px;','required'=>'true'));
										//pwdbox($nameID=null,$value=null,$placeholder=null,$params=array()){
										$CI->make->pwd('Password','pass','','Password',array('class'=>'form-control','style'=>'padding:10px;','required'=>'true'));
										//$CI->make->hidden('del_id','',array('class'=>'','disabled'=>'disabled','required'=>'required'));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'prod_idcc'));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'prod_ref'));
									$CI->make->eRow();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-check fa-lg fa-fw').'Submit',array('id'=>'r_confirm-certify','class'=>'btn btn-flat btn-primary'),'button');
						$CI->make->button(fa('fa-close fa-lg fa-fw').'Cancel',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
					//	$CI->make->eForm();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();

	return $CI->make->code();
}


function users_page($list=array()){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
							$CI->make->A(fa('fa-plus').' Add New User',base_url().'operation/user_form',array('class'=>'btn btn-primary btn-flat'));
						$CI->make->eDivCol();
                	$CI->make->eDivRow();
                	$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$th = array(
								//	'Suppliers Code ' => array(),
									'Employee Name' => array(),
									'Role' => array(),
									'Status' => array(),
									' '=>array());
							$rows = array();
							foreach($list as $val){
								$role = $CI->operation->get_role($val->role);
								$links = "";
								$links .= $CI->make->A(fa('fa-pencil fa-lg fa-fw'),base_url().'operation/user_form/'.$val->id,array("return"=>true));					
								$rows[] = array(
											  
											   $val->fname.' '.$val->mname.' '.$val->lname,
											   $role,
											   ($val->inactive != 1 ? " <span class='label label-success'>&nbsp Active &nbsp</span>" : "  <span class='label label-danger' '>Inactive</span>"),
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


function user_form($user=null){

  $CI =& get_instance();
  	//$user = $CI->session->userdata('user');
		$CI->make->sDivRow(array('style'=>'margin-top: -10px; margin-bottom:10px;'));
			$CI->make->sDivCol();
				$CI->make->A(fa('fa-reply').' GO BACK',base_url().'operation/users',array('id'=>'back-form','class'=>'pull-right btn btn-flat btn-info'),'success');
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
				
						$CI->make->sForm("operation/user_details_db",array('id'=>'users_form'));
							/* GENERAL DETAILS */
							$CI->make->sDivRow(array('style'=>'margin:10px;'));
								$CI->make->sDivCol(3);
									$CI->make->hidden('id',iSetObj($user,'id'));
									$CI->make->hidden('mode', ((iSetObj($user,'id')) ? 'edit' : 'add'));
									$CI->make->input('First Name','fname',iSetObj($user,'fname'),'First Name',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('Middle Name','mname',iSetObj($user,'mname'),'Middle Name',array('calss'=>'reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('Last Name','lname',iSetObj($user,'lname'),'Last Name',array('class'=>'rOkay reqForm'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(3);
									$CI->make->input('Suffix','suffix',iSetObj($user,'suffix'),'Suffix',array('class'=>'reqForm'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();

							$CI->make->sDivRow(array('style'=>'margin:10px;'));	
								$CI->make->sDivCol(6);
										$CI->make->input('Username','uname',iSetObj($user,'username'),'Username',array('class'=>'rOkay',iSetObj($user,'id')?'disabled':''=>''));
										//if(iSetObj($user,'id'))
										//$CI->make->input('Password','password',iSetObj($user,'password'),'Password',array('type'=>'password','class'=>'rOkay',iSetObj($user,'id')?'disabled':''=>''));
										$CI->make->input('Password','password',iSetObj($user,'password'),'Password',array('type'=>'password','class'=>'rOkay'));
										$CI->make->input('Email','email',iSetObj($user,'email'),'Email',array('class'=>'reqForm'));
									//$CI->make->sDivCol(3);
						
									//$CI->make->eDivCol();
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(6);
								 
										
										$CI->make->genderDrop('Gender','gender',iSetObj($user,'gender'),array('class'=>'rOkay reqForm'));
										$CI->make->roleDrop('Role','role',iSetObj($user,'role'),'Role',array('class'=>'reqForm'));
										//$CI->make->input('Status','status',iSetObj($user,'inactive'),'Status',array('class'=>'reqForm'));
										$stat = iSetObj($user,'inactive');
										$p = "<label>Status</label><select id='inactive' class='reqForm form-control' required name='inactive'>
											<option value=''>Select Status</option>";
											$sel0="";
											$sel1="";
											if($stat == '0')
											{
												$sel0 = "selected";
												$sel1 = "";
												//$p.= "<option value='".."'>".$c->CategoryName."</option>";
											}
											else
											{
												$sel0 = "";
												$sel1 = "selected";
											}
											$p2 = "<option value='0' ".$sel0.">Active</option>
											<option value='1' ".$sel1.">Inactive</option>
											</select>";
											//	$p. = "<option value='1' ".$sel1.">Inactive</option>";
											//$p. = "</select>";
											//$CI->make->input('Status','status',$stat,'Status',array('class'=>'reqForm'));
											if(iSetObj($user,'id'))
											$CI->make->p($p."".$p2);
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->sDiv(array('id'=>'save_button', 'style'=>''));
								$CI->make->sDivRow(array('style'=>'margin-left:450px;'));	
									$CI->make->sDivCol(5,'center');
										$CI->make->button(fa('fa-save').' Save User Details',array('id'=>'save-btn','class'=>'btn-block btn-flat'),'primary');
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDiv();
							/* GENERAL DETAILS END */
						$CI->make->eForm();
					$CI->make->eBoxBody();
				$CI->make->eBox();
					
			$CI->make->eDivCol();
		$CI->make->eDivRow();

    return $CI->make->code();

}



function neg_item_list($next_trans=null){

$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sBox('success');
	//	$CI->make->sForm('',array('id'=>'neg_item_list'));
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol(3);
							$user    = $CI->session->userdata('user');
					        $user_branch = $user['branch']; 
							$aria_db = $CI->asset->get_aria_db($user_branch);
							$next_trans = $CI->operation->get_next_trans($aria_db);
							$next_trans = $next_trans + 1;
							$CI->make->hidden('date_adjustment',date('Y-m-d'));	
							$CI->make->hidden('movement','Inventory Gained (SA)');	
							$CI->make->hidden('stat_type','Open / For Approval');	
							$CI->make->input('Transaction No:','trans_num',$next_trans,'',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'trans_num'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->prod_cat_Drop('Product Category','category','','Select Category.',array('class'=>'rOkay combobox','id'=>'category'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->supplier_Drop('Supplier','supplier','','Select Supplier.',array('class'=>'rOkay combobox','id'=>'supplier'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
						$CI->make->A(fa('fa-search').'Search','#',array('id'=>'btn_search', 'style'=>' margin-top: 24px;margin-right: 25px;','class'=>'btn btn-flat btn-md btn-primary'));
									$CI->make->A(fa('fa-download').'Export To Excel','#',array('id'=>'printinventory' ,'style'=>' margin-top: 24px;','class'=>'btn btn-success btn-flat btn-md'));
						$CI->make->eDivCol();
					$CI->make->sDivCol(12,'left');
						$CI->make->eDivCol();
						$CI->make->sDivCol(12,'right');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol(3);
							$CI->make->eDivCol();

							$CI->make->sDivCol(6);
							$CI->make->eDivCol();
						$CI->make->sDivCol(3);
									
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->eDivRow();
					$CI->make->sDivRow();													
					$CI->make->sDivCol();
						$CI->make->sDiv(array('id'=>'asset_list_data'));	
											$CI->make->sDivRow();
												$CI->make->sDivCol();
													$CI->make->sDiv(array('class'=>'table-responsive'));
														$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
															$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
																$CI->make->th('Vendor Code',array('style'=>''));
																$CI->make->th('Vendor Name',array('style'=>''));
																$CI->make->th('Product Category',array('style'=>''));
																$CI->make->th('Product Code',array('style'=>''));
																$CI->make->th('Description',array('style'=>''));
																$CI->make->th('Quantity',array('style'=>''));
															$CI->make->eRow();
														$CI->make->eTable();
													$CI->make->eDiv();
												$CI->make->eDivCol();
											$CI->make->eDivRow();
								$CI->make->eDivCol();
						$CI->make->eDiv();	
					$CI->make->eDivCol();
					$CI->make->eDivRow();


		$CI->make->eDivRow();
//	$CI->make->eForm();

	return $CI->make->code();
}

function cycle_count_form($items = array(),$auto = array(),$cat = array(),$user_id){
	$CI =& get_instance();
		$CI->make->sDivCol();
			$CI->make->sDivRow();
				//left search
				//
			if($user_id == 1 || $user_id == 177)
			{
			$CI->make->sDivCol(8);
			$CI->make->sDivRow();	

				//middle temporary
				$CI->make->sDivCol(12);
					$CI->make->sBox('primary',array('style'=>''));
						$CI->make->sBoxBody();	
							$CI->make->sDivCol(6);
								$CI->make->supplier_Drop('Supplier','select_supplier','','Select Supplier.',array('class'=>'rOkay combobox'));
							$CI->make->eDivCol();	
							$CI->make->sDivCol(6);
								$CI->make->input('Search Product','barcode','','Enter Product Here...',array('class'=>'','id'=>'autocomplete','autocomplete'=>'off','disabled'=>'disabled'));
							$CI->make->eDivCol();	

								$CI->make->sDiv(array('id'=>'asset_list_datasearch'));			
									$CI->make->sDivCol();										
										$CI->make->sDivRow();
												$CI->make->sRow();
													$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:150px;overflow:auto'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
														$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
															//$CI->make->th('Product Code',array('style'=>''));
															$CI->make->th('Bar Code',array('style'=>''));
															$CI->make->th('Description',array('style'=>''));
															$CI->make->th('UOM',array('style'=>''));
														$CI->make->eRow();														$CI->make->eTable();		
													$CI->make->eDiv();
												$CI->make->eRow();
										$CI->make->eDivRow();									
									$CI->make->eDivCol();	
								$CI->make->eDiv();
							// $CI->make->sDivRow();

							// // $CI->make->sForm("",array('id'=>'addcat_form'));
							// // 	// $CI->make->sDivCol(12);
							// // 	// 	$CI->make->sDivCol(6);
									
							// // 	// 	$CI->make->eDivCol();
							// // 	// 	$CI->make->sDivCol(6);
									
							// // 	// 	$CI->make->eDivCol();
									
							// // 	// $CI->make->eDivCol();
							// // $CI->make->eForm();		
							// $CI->make->eDivRow();

							$CI->make->H(5,'Cycle Count Product List',array('style'=>''));
							$CI->make->sDivRow();
								
								$CI->make->sDivCol();
									$CI->make->sDivCol(6);
									$CI->make->button(fa('fa-save').' Create Category',array('id'=>'savecat-btn','class'=>'btn-block btn-flat','style'=>'','data-toggle'=>'modal',
									'data-target'=>'#myModalcat'),'primary');
									$CI->make->eDivCol();
									$CI->make->sDivCol(6);
									$CI->make->button(fa('fa-save').' Add to Category',array('id'=>'savetocat-btn','class'=>'btn-block btn-flat','style'=>'','data-toggle'=>'modal',
									'data-target'=>'#myModalcat2'),'primary');
									$CI->make->eDivCol();
									$CI->make->sDiv(array('id'=>'asset_list_dataprolist'));
									
										$CI->make->sDivCol();										
										$CI->make->sDivRow();
												$CI->make->sRow();
													$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:150px;overflow:auto'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'del_cc2'));
														$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
															$CI->make->th('Bar Code',array('style'=>''));
															$CI->make->th('Description',array('style'=>''));
															$CI->make->th('UOM',array('style'=>''));
															$CI->make->sTd();
																$CI->make->button('Delete All',array('id'=>'btn_delete_all'));
															$CI->make->eTd();
														$CI->make->eRow();

														$CI->make->sTableBody(array('id'=>'tblprod'));

														foreach($items as $v){

															$adjusment_del = 
																$CI->make->A(fa('fa-trash fa-lg fa-fw').'',
																	'',array('class'=>'btn-del',
																	'id'=>'btn_del_cc2',
																	'ref_desc'=>'',
																	'data-id'=>$v->Barcode,
																	'data-desc'=>$v->Description,
																	'style'=>'cursor: pointer;',
																	'return'=>'false'));

															$CI->make->sRow();
																$CI->make->td($v->Barcode);
																$CI->make->td($v->Description);
																$CI->make->td($v->uom);
																$CI->make->td($adjusment_del);
															$CI->make->eRow();
														}
														$CI->make->eTableBody();
													$CI->make->eTable();		
													$CI->make->eDiv();
												$CI->make->eRow();
										$CI->make->eDivRow();									
										$CI->make->eDivCol();
										
									$CI->make->eDiv();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							
						$CI->make->eBoxBody();
					$CI->make->eBox();		
				$CI->make->eDivCol();

				//category list
				$CI->make->sDivCol(12);
					$CI->make->sBox('primary',array('style'=>''));
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
									$CI->make->sDivCol(12);
										$CI->make->sDiv(array('id'=>'asset_list_category'));
											$CI->make->sDivCol();										
												$CI->make->sDivRow();
													$CI->make->sRow();
														$CI->make->H(5,'Cycle Count Category List',array('style'=>''));
															$CI->make->sRow();
																$CI->make->input('','txtcatsearch','','Search Category',array('class'=>'','id'=>'txtcatsearch'));
																$CI->make->sDiv(array('class'=>'table-responsive'));
																	$CI->make->sTable(array('class'=>'table table-hover','id'=>''));
																		$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
																			$CI->make->th('Category',array('style'=>''));
																			$CI->make->th('Schedule',array('style'=>''));
																			$CI->make->th('Date Created',array('style'=>''));
																			$CI->make->th('Date Last Modified',array('style'=>''));
																			$CI->make->th('',array('style'=>'','colspan'=>'3'));
																		$CI->make->eRow();

																		$CI->make->sTableBody(array('id'=>'tblcategory'));
																			foreach($cat as $c){

																				$schedule = $c->Day. " - " .$c->Schedule;


																				$edit = 
																				$CI->make->A(
																				fa('fa-pencil fa-lg fa-fw').' Edit',
																				'',
																				array('class'=>'btn btn-success btn-flat action_btns btn_edit_cat',
																				'data-toggle'=>'modal',
																				'data-target'=>'#myModaleditcat',
																				'data-day'=> $c->Day,
																				'data-sched'=> $c->Schedule,
																				'data-name'=> $c->CategoryName,
																				'id'=>$c->CategoryID,
																				'style'=>'cursor: pointer;',
																				'return'=>'false'));
																				

																				$view = 
																				$CI->make->A(
																				fa('fa-eye fa-lg fa-fw').' View',
																				'',
																				array('class'=>'btn btn-success btn-flat action_btns btn_view_cat',
																				'data-toggle'=>'modal',
																				'data-target'=>'#myModalviewcat',
																				'ref_desc'=>'',
																				'id'=>$c->CategoryID,
																				'style'=>'cursor: pointer;',
																				'return'=>'false'));
																				
																				$adjusment_del = 
																				$CI->make->A(
																				fa('fa-trash fa-lg fa-fw').'Delete',
																				'',array('class'=>'btn btn-del btn-danger btn-flat',
																				'id'=>'btn_del_cat',
																				'ref_desc'=>'',
																				'data-id'=>$c->CategoryID,
																				'data-desc'=>$c->CategoryName,
																				'style'=>'cursor: pointer;',
																				'return'=>'false'));

																				$CI->make->sRow();
																					$CI->make->td($c->CategoryName);
																					$CI->make->td($schedule);
																					$CI->make->td($c->DateCreated);
																					$CI->make->td($c->DateLastModified);
																					$CI->make->td($view);
																					$CI->make->td($edit);
																					$CI->make->td($adjusment_del);
			
																					// $CI->make->td($v->Description);
																					// $CI->make->td($v->uom);
																					// $CI->make->td($adjusment_del);
																				$CI->make->eRow();

																			}
																		$CI->make->eTableBody();
																	$CI->make->eTable();
																$CI->make->eDiv();
															$CI->make->eRow();
													$CI->make->eRow();
												$CI->make->eDivRow();
											$CI->make->eDivCol();
										$CI->make->eDiv();
									$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
				

			$CI->make->eDivRow();

			$CI->make->eDivCol();
		}
				//right auto cc
				$CI->make->sDivCol(4);
					$CI->make->sBox('success');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
							$CI->make->sDivCol(12);
								$CI->make->sDiv(array('id'=>'asset_list_data4'));
									$CI->make->sDivCol();										
										$CI->make->sDivRow();
												$CI->make->sRow();
													$CI->make->H(5,'Cycle Count Auto List',array('style'=>''));
													$CI->make->sRow();
														$CI->make->select('Status','autocc_status',
															array('All'=>'0','Posted'=>'1','For Posting'=>'2'));
														$CI->make->sDiv(array('class'=>'table-responsive'));
														$CI->make->sDivCol(6);
															$CI->make->datefield('From','autocc_from');
														$CI->make->eDivCol();
														$CI->make->sDivCol(6);
															$CI->make->datefield('To','autocc_to');
														$CI->make->eDivCol();
														$CI->make->sTable(array('class'=>'table','id'=>'details-tbl3'));
															$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
																$CI->make->th('',array('style'=>''));
																//$CI->make->th('Date',array('style'=>''));
																$CI->make->th('',array('style'=>''));
																$CI->make->th('',array('style'=>''));
																// $CI->make->th('Description',array('style'=>''));
																// $CI->make->th('UOM',array('style'=>''));
															$CI->make->eRow();	
														foreach($auto as $v2){
															$status="";
															if($v2->TransNoIGSA == null and $v2->TransNoIGNSA == null)
															{
																$status = 'For Posting';
															}
															else
															{
																$status = 'Posted';
															}
																//$status= $v2-> (TransNo == null AND  ? "For Posting" : "Posted"; 

																$now = time(); // or your date as well
																$your_date = strtotime($v2->DateTrans);
																$datediff = $now - $your_date;

																$dayspast = round($datediff / (60 * 60 * 24));							
																$warn = ($dayspast >= 3 && $v2->SaveDate == NULL ? "bg-red" : "");
																$tno = ($v2->TransNoIGSA == NULL) ? "" : $v2->TransNoIGSA.",";
																$tno2 = $v2->TransNoIGNSA;
																// if($dayspast >= 3)
																// {
																// 	$warn = "bg-red";
																// }
																// else
																// {
																// 	$warn = "";
																// }
																$view_btn="";
																if($status == "Posted")
																{
																	$date_time = new DateTime($v2->SaveDate);

																	//now you can use format on that object:
																	$sd = $date_time->format("F j, Y h:i:sA");
																	//$sd = date_format($v2->SaveDate, "F j, Y H:i:s");
																	//echo date_format($date,"Y/m/d H:i:s");
																	$view_btn = 
																	$CI->make->A(
																	fa('fa-eye fa-lg fa-fw').' View',
																	'',
																	array('class'=>'btn btn-success btn-flat action_btns btn_view_postedcc',
																	'data-toggle'=>'modal',
																	'data-target'=>'#myModalpostedcc',
																	'ref_desc'=>'',
																	'id'=>$v2->InfoId,
																	'data-id'=>$sd,
																	'style'=>'cursor: pointer;',
																	'return'=>'false'));	

																	$view_btn2="Trans No/s: ".$tno."".$tno2.$view_btn2=$CI->make->A(
																	fa('fa-download fa-lg fa-fw').'Variance Report',
																	'',
																	array('class'=>'btn btn-primary btn-flat action_btns btn_view_auto',
																	'data-toggle'=>'modal',
																	'data-target'=>'#myModal',
																	'ref_desc'=>'',
																	'id'=>$v2->InfoId,
																	'style'=>'cursor: pointer;',
																	'return'=>'false'));
																}
																else
																{
																	//COPY
																	$view_btn = 
																	$CI->make->A(
																	fa('fa-eye fa-lg fa-fw').' View',
																	'',
																	array('class'=>'btn btn-success btn-flat action_btns btn_view_auto',
																	'data-toggle'=>'modal',
																	'data-target'=>'#myModal',
																	'ref_desc'=>'',
																	'id'=>$v2->InfoId,
																	'style'=>'cursor: pointer;',
																	'return'=>'false'));	


																	$view_btn2="";
																}
															$time = strtotime($v2->DateTrans);
															
															$d = date("Ymd" ,$time);
															$autoid = $v2->CategoryName."-".$d;
															
															$CI->make->sRow(array('class'=>$warn));
																$CI->make->td($autoid);
																$CI->make->td($status);
																//$CI->make->td($v2->DateTrans);
																$CI->make->td($view_btn." ".$view_btn2);

																// $CI->make->td($v->Description);
																// $CI->make->td($v->uom);
																// $CI->make->td($adjusment_del);
															$CI->make->eRow();
														}
														$CI->make->eTable();		
														$CI->make->eDiv();
													$CI->make->eRow();
												$CI->make->eRow();
										$CI->make->eDivRow();									
									$CI->make->eDivCol();	
								$CI->make->eDiv();
							$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eDivCol();
	
		$CI->make->sDiv(array('id'=>'myModalcat2','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));

					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$label = "<i class='fa fa-save' style='font-size:38px;color:black'></i>";
						$CI->make->h(4,' Add to Category',array('style'=>''));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						$CI->make->sForm("",array('id'=>'addtocat_form'));
							
							$p = "<select id='cc_cat' class='form-control' required>
							<option value=''>Select Category</option>";
							foreach($cat as $c)
							{
								$p.= "<option value='".$c->CategoryID."'>".$c->CategoryName."</option>";
							}
							$p.= "</select>";
							$CI->make->p($p);
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-check fa-lg fa-fw').'Submit',array('id'=>'addto-cat','class'=>'btn btn-flat btn-primary'),'submit');
						$CI->make->button(fa('fa-close fa-lg fa-fw').'Cancel',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
						$CI->make->eForm();
						
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'myModalcat','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));
					$CI->make->sForm("",array('id'=>'savecat_form'));
					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						//$label = "<i class='fa fa-save' style='font-size:38px;color:red'></i>";
						$CI->make->h(4,' Category Details',array('style'=>''));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
							$CI->make->sDivCol(12);										
								$CI->make->sDivRow();
									$CI->make->input('Category Name','cat','','Category Name',array('class'=>'form-control','style'=>'padding:10px;','required'=>'true'));
										$CI->make->sDiv(array('class'=>'col-md-6'));
											$CI->make->h(4,' Day',array('style'=>''));
											$CI->make->checkbox('Monday','days1','Monday',array('class'=>'Checkbox',));
											$CI->make->checkbox('Tuesday','days2','Tuesday',array('class'=>'Checkbox'));
											$CI->make->checkbox('Wednesday','days3','Wednesday',array('class'=>'Checkbox'));
											$CI->make->checkbox('Thursday','days4','Thursday',array('class'=>'Checkbox'));
											$CI->make->checkbox('Friday','days5','Friday',array('class'=>'Checkbox'));
											$CI->make->checkbox('Saturday','days6','Saturday',array('class'=>'Checkbox'));
											$CI->make->checkbox('Sunday','days7','Sunday',array('class'=>'Checkbox'));
										$CI->make->eDiv();
										$CI->make->sDiv(array('class'=>'col-md-6'));
											$CI->make->h(4,' Week',array('style'=>''));
											$CI->make->checkbox('Weekly','week0','Weekly',array('class'=>'Checkbox2'));
											$CI->make->checkbox('1st Week','week1','1st Week',array('class'=>'Checkbox2'));
											$CI->make->checkbox('2nd Week','week2','2nd Week',array('class'=>'Checkbox2'));
											$CI->make->checkbox('3rd Week','week3','3rd Week',array('class'=>'Checkbox2'));
											$CI->make->checkbox('4th Week','week4','4th Week',array('class'=>'Checkbox2'));
											//$CI->make->checkbox('5th Week','week5','5th Week',array('class'=>'Checkbox2'));
										$CI->make->eDiv();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-check fa-lg fa-fw').'Save',array('id'=>'save-cat','class'=>'btn btn-flat btn-primary'),'button');
						$CI->make->button(fa('fa-close fa-lg fa-fw').'Cancel',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
					$CI->make->eForm();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();


		$CI->make->sDiv(array('id'=>'myModaldelcatprod','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));
					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$label = "<i class='fa fa-warning' style='font-size:38px;color:red'></i>";
						$CI->make->h(4,$label.' Confirm Delete Category',array('style'=>''));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						$CI->make->sForm("",array('id'=>'delcatprod_form'));
					//	$CI->make->input('Category Name','cat','','Category Name',array('class'=>'form-control','id'=>'editcat','style'=>'padding:10px;','required'=>'true'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									$CI->make->sRow();
									//function hidden($nameID=null,$value=null,$params=array()){
										$CI->make->p('Are you sure you want to delete <span id="catproddesc" style="color:red"></span> from category?',array('style'=>''));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'catprod_id'));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'catprod_idcat'));
										
										//$CI->make->hidden('del_id','',array('class'=>'','disabled'=>'disabled','required'=>'required'));
									$CI->make->eRow();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-check fa-lg fa-fw').'Delete',array('id'=>'confirmcatprod-delete','class'=>'btn btn-flat btn-primary'),'button');
						$CI->make->button(fa('fa-close fa-lg fa-fw').'Cancel',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
						$CI->make->eForm();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'myModaldel','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));
					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$label = "<i class='fa fa-warning' style='font-size:38px;color:red'></i>";
						$CI->make->h(4,$label.' Confirm Delete',array('style'=>''));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						$CI->make->sForm("",array('id'=>'delcc_form'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									$CI->make->sRow();
									//function hidden($nameID=null,$value=null,$params=array()){
										$CI->make->p('Are you sure you want to delete <span id="desc" style="color:red"></span> product on list?',array('style'=>''));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'del_id'));
										//$CI->make->hidden('del_id','',array('class'=>'','disabled'=>'disabled','required'=>'required'));
									$CI->make->eRow();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-check fa-lg fa-fw').'Delete',array('id'=>'confirmprod-delete','class'=>'btn btn-flat btn-primary'),'button');
						$CI->make->button(fa('fa-close fa-lg fa-fw').'Cancel',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
						$CI->make->eForm();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();
		
		$CI->make->sDiv(array('id'=>'myModaldelcat','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));
					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$label = "<i class='fa fa-warning' style='font-size:38px;color:red'></i>";
						$CI->make->h(4,$label.' Confirm Delete Category',array('style'=>''));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						$CI->make->sForm("",array('id'=>'delcat_form'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									$CI->make->sRow();
									//function hidden($nameID=null,$value=null,$params=array()){
										$CI->make->p('Are you sure you want to delete <span id="catdesc" style="color:red"></span> category?',array('style'=>''));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'catdel_id'));
										//$CI->make->hidden('del_id','',array('class'=>'','disabled'=>'disabled','required'=>'required'));
									$CI->make->eRow();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-check fa-lg fa-fw').'Delete',array('id'=>'confirmcat-delete','class'=>'btn btn-flat btn-primary'),'button');
						$CI->make->button(fa('fa-close fa-lg fa-fw').'Cancel',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
						$CI->make->eForm();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();


										//COPY
		$CI->make->sDiv(array('id'=>'myModal','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
				$CI->make->sDiv(array('class'=>'modal-content'));

					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$CI->make->H(4,'Cycle Count Item List',array('style'=>'','class'=>'modal-title'));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						$CI->make->sDiv(array('id'=>'asset_list_data5'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									
								$CI->make->eDivRow();
							$CI->make->eDivCol();
						$CI->make->eDiv();
					$CI->make->eDiv();
					
					// $CI->make->sDiv(array('class'=>'modal-footer'));
					// 	$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'add_item_adjustment','class'=>'btn btn-primary btn-flat'),'button');
					// 	$CI->make->button('Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					// $CI->make->eDiv();
					
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'myModalpostedcc','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
				$CI->make->sDiv(array('class'=>'modal-content'));

					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$CI->make->H(4,'Cycle Count Item List',array('style'=>'','class'=>'modal-title','id'=>'auto_title'));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						$CI->make->sDiv(array('id'=>'asset_list_postedcc'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									
								$CI->make->eDivRow();
							$CI->make->eDivCol();
						$CI->make->eDiv();
					$CI->make->eDiv();
					
					// $CI->make->sDiv(array('class'=>'modal-footer'));
					// 	$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'add_item_adjustment','class'=>'btn btn-primary btn-flat'),'button');
					// 	$CI->make->button('Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					// $CI->make->eDiv();
					
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();



		$CI->make->sDiv(array('id'=>'myModalviewdl','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
				$CI->make->sDiv(array('class'=>'modal-content'));

					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$CI->make->H(4,'',array('style'=>'','class'=>'modal-title'));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));
						//$close = "<span aria-hidden='true' style='font-size:30px;color:red'><b>&times;</b></span>";
							//$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
							$dl = "<center><a href='../CycleCountAutoList.xlsx' class='btn btn-success' id='dlfile' >Download File</a>&nbsp;&nbsp;<a class='btn btn-danger' data-dismiss='modal'>Cancel</a></center>";

							$CI->make->p($dl);

					$CI->make->eDiv();
						// $CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'save_auto_cc','class'=>'btn btn-primary btn-flat'),'button');
						// $CI->make->button(fa('fa-close').'Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
				
					// $CI->make->sDiv(array('class'=>'modal-footer'));
					// //	$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'add_item_adjustment','class'=>'btn btn-primary btn-flat'),'button');
					// 	//$CI->make->button(fa('fa-close').'Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					// $CI->make->eDiv();
					
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'myModalcert','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));

					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$label = "<i class='fa fa-lock' style='font-size:38px;color:black'></i>";
						$CI->make->h(4,$label.' Confirm Login to certify item <span id="certifyprod" style="color:red"></span>',array('style'=>''));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));				
						//$CI->make->sForm("",array('id'=>'certify_form'));
							$CI->make->sDivCol();										
								$CI->make->sDivRow();
									$CI->make->sRow();
									//function hidden($nameID=null,$value=null,$params=array()){
										$CI->make->input('Username','user','','Username',array('class'=>'form-control','style'=>'padding:10px;','required'=>'true'));
										//pwdbox($nameID=null,$value=null,$placeholder=null,$params=array()){
										$CI->make->pwd('Password','pass','','Password',array('class'=>'form-control','style'=>'padding:10px;','required'=>'true'));
										//$CI->make->hidden('del_id','',array('class'=>'','disabled'=>'disabled','required'=>'required'));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'prod_idcc'));
										$CI->make->hidden('','',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'prod_ref'));
									$CI->make->eRow();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-check fa-lg fa-fw').'Submit',array('id'=>'confirm-certify','class'=>'btn btn-flat btn-primary'),'button');
						$CI->make->button(fa('fa-close fa-lg fa-fw').'Cancel',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
					//	$CI->make->eForm();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();


		$CI->make->sDiv(array('id'=>'myModalviewcat','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
				$CI->make->sDiv(array('class'=>'modal-content'));
					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$CI->make->H(4,'Category Product List',array('style'=>'','class'=>'modal-title'));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));
						//$close = "<span aria-hidden='true' style='font-size:30px;color:red'><b>&times;</b></span>";
							//$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
							$CI->make->sDiv(array('id'=>'asset_list_dataviewcat'));		
								

							$CI->make->eDiv();

					$CI->make->eDiv();
						// $CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'save_auto_cc','class'=>'btn btn-primary btn-flat'),'button');
						// $CI->make->button(fa('fa-close').'Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
				
					$CI->make->sDiv(array('class'=>'modal-footer'));
					//	$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'add_item_adjustment','class'=>'btn btn-primary btn-flat'),'button');
						$CI->make->button(fa('fa-close').'Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
					
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'myModaleditcat','class'=>'modal fade bs-example-modal-sm','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
			$CI->make->sDiv(array('class'=>'modal-dialog modal-sm','role'=>'document'));
				$CI->make->sDiv(array('class'=>'modal-content'));
					$CI->make->sDiv(array('class'=>'modal-header'));
						$close = "<span aria-hidden='true'>&times;</span>";
						$CI->make->button(close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
						$CI->make->H(4,'Edit Category Product List',array('style'=>'','class'=>'modal-title'));
					$CI->make->eDiv();
					
					$CI->make->sDiv(array('class'=>'modal-body'));
						//$close = "<span aria-hidden='true' style='font-size:30px;color:red'><b>&times;</b></span>";
							//$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
							$CI->make->input('Category Name','editcatname','','Category Name',array('class'=>'form-control','id'=>'editcatname','style'=>'padding:10px;','required'=>'true'));
								$CI->make->hidden('catid','');
								$CI->make->sDivRow();
										$CI->make->sDivCol(6);
											$CI->make->h(4,' Day',array('style'=>''));

											$CI->make->checkbox('Monday','editdays1','Monday',array('class'=>'EditCheckbox',));
											$CI->make->checkbox('Tuesday','editdays2','Tuesday',array('class'=>'EditCheckbox'));
											$CI->make->checkbox('Wednesday','editdays3','Wednesday',array('class'=>'EditCheckbox'));
											$CI->make->checkbox('Thursday','editdays4','Thursday',array('class'=>'EditCheckbox'));
											$CI->make->checkbox('Friday','editdays5','Friday',array('class'=>'EditCheckbox'));
											$CI->make->checkbox('Saturday','editdays6','Saturday',array('class'=>'EditCheckbox'));
											$CI->make->checkbox('Sunday','editdays7','Sunday',array('class'=>'EditCheckbox'));
										$CI->make->eDivCol();

										$CI->make->sDivCol(6);
										$CI->make->h(4,' Week',array('style'=>''));
											$CI->make->checkbox('Weekly','editweek0','Weekly',array('class'=>'EditCheckbox2'));
											$CI->make->checkbox('1st Week','editweek1','1st Week',array('class'=>'EditCheckbox2'));
											$CI->make->checkbox('2nd Week','editweek2','2nd Week',array('class'=>'EditCheckbox2'));
											$CI->make->checkbox('3rd Week','editweek3','3rd Week',array('class'=>'EditCheckbox2'));
											$CI->make->checkbox('4th Week','editweek4','4th Week',array('class'=>'EditCheckbox2'));
											//$CI->make->checkbox('5th Week','editweek5','5th Week',array('class'=>'EditCheckbox2'));
										$CI->make->eDivCol(6);
								$CI->make->eDivRow();

					$CI->make->eDiv();
				
					$CI->make->sDiv(array('class'=>'modal-footer'));
						$CI->make->button(fa('fa-save').'Update Category',array('id'=>'up-cat','class'=>'btn btn-primary btn-flat'),'button');
						$CI->make->button(fa('fa-close').'Close',array('class'=>'btn btn-danger btn-flat','data-dismiss'=>'modal'),'button');
					$CI->make->eDiv();
					
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();



		

		
		

	return $CI->make->code();
}

function cycle_count_auto_reload($auto = array()){
$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sDivRow();
			
				$CI->make->H(5,'Cycle Count Item List',array('style'=>''));
				$CI->make->sRow();
					$CI->make->sDiv(array('class'=>'table-responsive'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl3'));
							$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
								$CI->make->th('Auto ID',array('style'=>''));
								$CI->make->th('Date',array('style'=>''));
								$CI->make->th('',array('style'=>''));
								// $CI->make->th('Description',array('style'=>''));
								// $CI->make->th('UOM',array('style'=>''));
								// $CI->make->th('',array('style'=>''));
							$CI->make->eRow();	
							
						foreach($auto as $v2){								
								
							$view_btn = 
								$CI->make->A(
									fa('fa-eye fa-lg fa-fw').' View',
									'',
									array('class'=>'btn btn-success btn-flat action_btns btn_view_auto',
									'data-toggle'=>'modal',
									'data-target'=>'#myModal',
									'ref_desc'=>'',
									'id'=>$v2->InfoId,
									'style'=>'cursor: pointer;',
									'return'=>'false'));	
								
							$autoid = $v2->Branch."".$v2->AutoID;
							
							$CI->make->sRow();
								$CI->make->td($autoid);
								$CI->make->td($v2->DateTrans);
								$CI->make->td($view_btn);
							$CI->make->eRow();
						}
						$CI->make->eTable();			
					$CI->make->eDiv();
				$CI->make->eRow();
			
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	return $CI->make->code();
}


function cycle_count_reload($items = array()){
$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sDivRow();
				$CI->make->sRow();
					//$CI->make->input('','txtprodsearch','','Search Product',array('class'=>'','id'=>'txtprodsearch'));
					$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:150px;overflow:auto'));
						$CI->make->sTable(array('class'=>'table table-hover','id'=>'del_cc2'));
							$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
								$CI->make->th('Bar Code',array('style'=>''));
								$CI->make->th('Description',array('style'=>''));
								$CI->make->th('UOM',array('style'=>''));
								$CI->make->sTd();
									$CI->make->button('Delete All',array('id'=>'btn_delete_all'));
								$CI->make->eTd();
							$CI->make->eRow();
							$CI->make->sTableBody(array('id'=>'tblprod'));
							foreach($items as $v){

								$adjusment_del = 
									$CI->make->A(fa('fa-trash fa-lg fa-fw').'',
										'',array('class'=>'btn-del',
										'id'=>'btn_del_cc2',
										'ref_desc'=>'',
										'data-id'=>$v->Barcode,
										'data-desc'=>$v->Description,
										'style'=>'cursor: pointer;',
										'return'=>'false'));

								$CI->make->sRow();
									$CI->make->td($v->Barcode);
									$CI->make->td($v->Description);
									$CI->make->td($v->uom);
									$CI->make->td($adjusment_del);
								$CI->make->eRow();
							}
							$CI->make->eTableBody();
						$CI->make->eTable();
					$CI->make->eDiv();			
				$CI->make->eRow();		
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	return $CI->make->code();
}


function recount_reload($items = array(),$next_trans){
$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sDivRow();
				$CI->make->sRow();
					//$CI->make->input('','txtprodsearch','','Search Product',array('class'=>'','id'=>'txtprodsearch'));
					//$CI->make->sForm("",array('id'=>'r_auto_form'));				
											$CI->make->sDivCol();
												// foreach($items2 as $v2){
												// 	$ddid = $v2->Branch."".$v2->AutoID;
												// 	$dddate = $v2->DateTrans;
												// 	$iid = $v2->InfoId;
												// 	$CI->make->hidden('infoid',$v2->InfoId);
												// 	$tno = $v2->TransNoIGSA;
												// 	$tno2 = $v2->TransNoIGNSA;

												// }	
												$CI->make->p($ddid." - ".$dddate);
												$CI->make->A(fa('fa-file-excel-o').' Generate Export Link','',array('class'=>'btn btn-success btn-flat','id'=>'r_btn-export'));
												
												
												$CI->make->p('Transaction No: '.$next_trans);
												
												$CI->make->hidden('trans_num',$next_trans);	
												$CI->make->hidden('date_adjustment',date('Y-m-d'));	
												$CI->make->hidden('movement','Inventory Gained (SA)');	
												$CI->make->hidden('stat_type','Open / For Approval');	


												$CI->make->input('','r_txtrecprod','','Search Product',array('class'=>'','id'=>'r_txtrecprod'));
												$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:250px;overflow:auto'));
													$CI->make->sTable(array('class'=>'table table-hover','id'=>'recount_list'));
														$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
															$CI->make->th('Item',array('style'=>'','align=center'));
															$CI->make->th('UoM',array('style'=>'','align=center'));
															$CI->make->th('Cost',array('style'=>'','align=center'));
															$CI->make->th('Quantity Inventory',array('style'=>'','align=center'));
															$CI->make->th('Qty',array('style'=>'','align=center'));
															$CI->make->th('Adjustment Qty',array('style'=>'','align=center'));
															$CI->make->th('Unit Cost',array('style'=>'','align=center'));
															$CI->make->th('Total Cost',array('style'=>'','align=center'));
															$CI->make->th('',array('style'=>'','align=center'));
															$CI->make->th('',array('style'=>'','align=center'));
														$CI->make->eRow();

												$CI->make->sTableBody(array('id'=>'r_tblautoprod'));
													$checkbox="";
													$no = 1;

													foreach($items as $v){
														if($v->CostOfSales == .0000)
														{
															$cos2 = "0";
														}
														else
														{
															$cos2 = $v->CostOfSales;
														}
														$CI->make->hidden('movcode_'.$no,'',array('class'=>'movcode_'.$no));
														$CI->make->hidden('qtyuom_'.$no,$v->qty,array('class'=>'qtyuom_'.$no));
														$CI->make->hidden('prod_id_'.$no,$v->ProductID,array('class'=>'prod_id'));
														//$CI->make->hidden('prod_code_'.$no,$v->ProductCode,array('class'=>'prod_code'));
														$CI->make->hidden('prod_code_'.$no,$v->ProductCode,array('class'=>'prod_code','id'=>'prod_code_'.$no));
														$CI->make->hidden('prod_desc_'.$no,$v->Description,array('id'=>'prod_desc_'.$no));
														$CI->make->hidden('cost_'.$no,$cos2,array('class'=>'cost'));
														$CI->make->hidden('uom_qty2_'.$no,'',array('class'=>'uom','id'=>'uom_qty2_'.$no));

														$CI->make->hidden('unit_'.$no,'',array('class'=>'unit','id'=>'unit_'.$no));

														$CI->make->hidden('neg_qty_'.$no,$v->SellingArea,array('class'=>'qty_edit'));
														$CI->make->hidden('tot_cert_'.$no,'',array('class'=>'totcert'));
														$CI->make->hidden('needtocertify_'.$no,'',array('id'=>'needtocertify_'.$no));
													
													//$role = "Security";
														// if($role == "Security")
														// {
														// 	if($v->isCertified == 1){
														// 		$checkbox = $CI->make->checkbox('','chk_'.$no,$v->Id,array('return'=>true,'class'=>'check','disabled'=>'true','checked'=>'true'));
																
														// 	}else{
														// 		$checkbox = $CI->make->checkbox('','chk_'.$no,$v->Id,array('return'=>true,'class'=>'check','disabled'=>'true',''));
														// 	}
														// }	
														$del =
														$CI->make->A(fa('fa-trash fa-lg fa-fw').'',
																	'',array('class'=>'



',
																	'id'=>'btn_del_recount',
																	'ref_desc'=>'',
																	'data-id'=>$v->Barcode,
																	'data-desc'=>$v->Description,
																	'style'=>'cursor: pointer;color:red',
																	'return'=>'false'));
 
														
														$certot = $CI->make->p('',array('id'=>'tot'));

														$CI->make->sRow();
															$CI->make->td($v->Description);
															$CI->make->td($v->uom);
															$CI->make->td($v->CostOfSales);
															$CI->make->td($v->SellingArea);

															 $CI->make->td("<input type='text' id='rcqty_$no' class='rcqty' value=''>");
															 $CI->make->td("<input type='text' id='ad_qty2_$no' disabled class='adjustment_qty' placeholder='Adjustment Quantity'>"."<input type='hidden' id='mc_$no'>");
															$CI->make->td("<input type='text' id='unit_cost2_$no' disabled value='".$v->CostOfSales."' class = 'allunitcost'>");
															$CI->make->td("<input type='text' id='total_$no' disabled value='' class = 'allunitcost'>");
															 $CI->make->td($del);
															 $CI->make->td(" <span id='warning_$no'></span>");
														$CI->make->eRow();

													$no++;
													}


												$CI->make->eTableBody();

													$CI->make->eTable();
												$CI->make->eDiv();

												$CI->make->hidden('total','',array('disabled'=>'disabled'));
												$CI->make->textarea('Remarks','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
															
												$CI->make->button('Close',array('class'=>'btn btn-danger btn-flat pull-right','data-dismiss'=>'modal'),'button');	
												if($tno == null and $tno2 == null)
												{
													$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'save_auto_btn','class'=>'btn btn-primary btn-flat pull-right','style'=>'margin-right:10px'),'submit');
												}
												else
												{
													$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'save_auto_btn2','disabled'=>'disabled','class'=>'btn btn-primary btn-flat pull-right','style'=>'margin-right:10px'),'submit');
												}
								
											$CI->make->eDivCol();
												
										//$CI->make->eForm();
				$CI->make->eRow();		
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	return $CI->make->code();
}

function cc_category_reload($items = array()){
$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sDivRow();
				$CI->make->sRow();
					$CI->make->input('','txtcatsearch','','Search Category',array('class'=>'','id'=>'txtcatsearch'));
					$CI->make->sDiv(array('class'=>'table-responsive'));
						$CI->make->sTable(array('class'=>'table table-hover','id'=>''));
							$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
								$CI->make->th('Category',array('style'=>''));
								$CI->make->th('Schedule',array('style'=>''));
								$CI->make->th('Date Created',array('style'=>''));
								$CI->make->th('',array('style'=>'','colspan'=>'2'));
								$CI->make->eRow();
							$CI->make->sTableBody(array('id'=>'tblcategory'));
							foreach($items as $c){
								$schedule = $c->Day. " - " .$c->Schedule;
								$view = 
								$CI->make->A(
								fa('fa-eye fa-lg fa-fw').' View',
								'',
								array('class'=>'btn btn-success btn-flat action_btns btn_view_cat',
								'data-toggle'=>'modal',
								'data-target'=>'#myModal',
								'ref_desc'=>'',
								'id'=>$c->CategoryID,
								'style'=>'cursor: pointer;',
								'return'=>'false'));
																				
								$adjusment_del = 
								$CI->make->A(
								fa('fa-trash fa-lg fa-fw').'Delete',
								'',array('class'=>'btn btn-del btn-danger btn-flat',
								'id'=>'btn_del_cat',
								'ref_desc'=>'',
								'data-id'=>$c->CategoryID,
								'data-desc'=>$c->CategoryName,
								'style'=>'cursor: pointer;',
								'return'=>'false'));
								$CI->make->sRow();
									$CI->make->td($c->CategoryName);
									$CI->make->td($schedule);
									$CI->make->td($c->DateCreated);
									$CI->make->td($view);
									$CI->make->td($adjusment_del);
								$CI->make->eRow();
							}
							$CI->make->eTableBody();
						$CI->make->eTable();
					$CI->make->eDiv();		
				$CI->make->eRow();		
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	return $CI->make->code();
}


function negative_inventory_reload($items = array(),$next_trans=null){

$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sDivRow();
		$CI->make->sForm("",array('id'=>'add_form'));
			$CI->make->sDiv();
				$CI->make->sRow();
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
						$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
							$CI->make->th('Item',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('Cost',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('Negative Qty',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('Qty',array('style'=>''));
							$CI->make->th('Adjustment Qty',array('style'=>'margin:5px;'));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('Unit Cost',array('style'=>''));
							$CI->make->th('',array('style'=>''));
							$CI->make->th('',array('style'=>''));
						$CI->make->eRow();	
					$CI->make->eTable();
					$no = 1;
					foreach($items as $v){
						$check = false;
						//$cost = 
				
									if($v->CostOfSales == .0000)
									{
										$cos2 = "0";
									}
									else
									{
										$cos2 = $v->CostOfSales;
									}
										if($v->SellingArea == .0000)
									{
										$sa = "0";
									}
									else
									{
										$sa = $v->SellingArea;
									}

						$CI->make->sDivCol(12);
							$CI->make->hidden('prod_id_'.$no,$v->ProductID,array('class'=>'prod_id'));
							$CI->make->hidden('prod_code_'.$no,$v->ProductCode,array('class'=>'prod_code'));
							$CI->make->sDivCol(3);
								$CI->make->input('','prod_cat'.$no,$v->Description,'',array('class'=>'','disabled'=>'disabled','required'=>'required','style'=>'border:none;background-color:transparent;padding:10px;'));
							$CI->make->eDivCol();
						
							$CI->make->sDivCol(2);
								$CI->make->input('','cost'.$no,$cos2,'',array('class'=>'','disabled'=>'disabled','required'=>'required','style'=>'border:none;background-color:transparent;padding:10px;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(2);
								$CI->make->input('','neg_qty_'.$no,$sa,'Negative Qty',array('class'=>'qty_edit','disabled'=>'disabled','required'=>'required','style'=>'border:none;background-color:transparent;padding:10px;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(1);
								$CI->make->input('','qty_'.$no,'','Qty',array('class'=>'qty','style'=>'padding:10px;'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(2);
								$CI->make->hidden('cost_'.$no,$cos2,array('class'=>'cost'));
								$CI->make->hidden('uom_qty_'.$no,'',array('class'=>'uom','id'=>'uom_qty_'.$no));
								$CI->make->hidden('unit_'.$no,'',array('class'=>'unit'));
							// $CI->make->unit_Drop('','unit_'.$no,'','Select Units.',array('class'=>'allunits'));
								$CI->make->input('','ad_qty_'.$no,'','Adjustment Qty',array('class'=>'adjustment_qty','disabled'=>'disabled'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(2);
								$CI->make->input('','unit_cost_'.$no,$v->CostOfSales,'Unit Cost',array('class'=>'allunitcost','disabled'=>'disabled'));
							$CI->make->eDivCol();
							
						$CI->make->eDivCol();

						$no++;
					}
					$CI->make->sDivCol(12,'right');
						$CI->make->sDivCol(4);
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
						$CI->make->eDivCol();
						// $CI->make->sDivCol(4);
							$CI->make->hidden('TOTAL','total','','Total Cost',array('disabled'=>'disabled'));
						$CI->make->eDivCol();
					$CI->make->eDivCol();
					$CI->make->sDivCol(12);
						$CI->make->sDivCol(12);
							$CI->make->textarea('Remarks','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
						$CI->make->eDivCol();
					$CI->make->eDivCol();
					$CI->make->sDivCol(12,'right');
						$CI->make->button(fa('fa-edit').' Save Adjustment',array('id'=>'add_item_adjustment', 'style'=>' margin-top: 25px;'),'success');
					$CI->make->sDivCol(4,'center');
				$CI->make->eDivRow();
			$CI->make->eDiv();
		$CI->make->eForm();
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	return $CI->make->code();
}

function show_filtered_autocc($result = array()){
	$CI =& get_instance();
	if(count($result) > 0)
	{
		$CI->make->sTableBody();	
			foreach($result as $v2)
			{
				$status="";
				if($v2->TransNoIGSA == null and $v2->TransNoIGNSA == null)
				{
					$status = 'For Posting';
				}
				else
				{
					$status = 'Posted';
				} 
				$now = time(); // or your date as well
				$your_date = strtotime($v2->DateTrans);
				$datediff = $now - $your_date;

				$dayspast = round($datediff / (60 * 60 * 24));							
				$warn = ($dayspast >= 3 && $v2->SaveDate == NULL ? "bg-red" : "");
				$tno = ($v2->TransNoIGSA == NULL) ? "" : $v2->TransNoIGSA.",";
				$tno2 = $v2->TransNoIGNSA;
				$view_btn="";
				if($status == "Posted")
				{
					$date_time = new DateTime($v2->SaveDate);
					//now you can use format on that object:
					$sd = $date_time->format("F j, Y h:i:sA");
					$view_btn = 
						$CI->make->A(
						fa('fa-eye fa-lg fa-fw').' View',
						'',
						array('class'=>'btn btn-success btn-flat action_btns btn_view_postedcc',
						'data-toggle'=>'modal',
						'data-target'=>'#myModalpostedcc',
						'ref_desc'=>'',
						'id'=>$v2->InfoId,
						'data-id'=>$sd,
						'style'=>'cursor: pointer;',
						'return'=>'false'));	
					$view_btn2="Trans No/s: ".$tno."".$tno2.$view_btn2=$CI->make->A(
						fa('fa-download fa-lg fa-fw').'Variance Report',
						'',
						array('class'=>'btn btn-primary btn-flat action_btns var-rep',
						'data-toggle'=>'',
						'data-target'=>'',
						'ref_desc'=>'',
						'id'=>$v2->InfoId,
						'style'=>'cursor: pointer;',
						'return'=>'false'));
				}
				else
				{
					//COPY
					$view_btn = 
						$CI->make->A(
						fa('fa-eye fa-lg fa-fw').' View',
						'',
						array('class'=>'btn btn-success btn-flat action_btns btn_view_auto',
						'data-toggle'=>'modal',
						'data-target'=>'#myModal',
						'ref_desc'=>'',
						'id'=>$v2->InfoId,
						'style'=>'cursor: pointer;',
						'return'=>'false'));	
						$view_btn2="";
				}
				$time = strtotime($v2->DateTrans);				
				$d = date("Ymd" ,$time);
				$autoid = $v2->CategoryName."-".$d;					
				$CI->make->sRow(array('class'=>$warn));
					$CI->make->td($autoid);
					$CI->make->td($status);
					$CI->make->td($view_btn." ".$view_btn2);
				$CI->make->eRow();
			}
		$CI->make->eTableBody();
	}
	return $CI->make->code();
}

function show_search($items = array()){

$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sDivRow();
			
				$CI->make->sRow();
					$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:150px;overflow:auto'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
						$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
							//$CI->make->th('Product Code',array('style'=>''));
							$CI->make->th('Bar Code',array('style'=>''));
							$CI->make->th('Description',array('style'=>''));
							$CI->make->th('UOM',array('style'=>''));
							$CI->make->sTd();
								$CI->make->button('Check All',array('id'=>'btn_add_all'));
							$CI->make->eTd();
						$CI->make->eRow();	
					
					
					foreach($items as $v){
						$link = 
								$CI->make->A(
								fa('fa-check fa-lg fa-fw'),
								'',array('class'=>'addproduct',
								'id'=>'prod_'+$v->Barcode,
								'ref_desc'=>'',
								'data-id'=>$v->Barcode,
								'data-desc'=>$v->Description,
								'style'=>'cursor: pointer;',
								'return'=>'false'));

						$CI->make->sRow();
							//$CI->make->td($v->ProductCode);
							$CI->make->td($v->Barcode);
							$CI->make->td($v->Description);
							$CI->make->td($v->uom);
							$CI->make->td($link);
						$CI->make->eRow();
					}
					$CI->make->eTable();		
					$CI->make->eDiv();
				$CI->make->eRow();
			
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	return $CI->make->code();
}

function r_show_search($items = array()){

$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sDivRow();
			
				$CI->make->sRow();
					$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:150px;overflow:auto'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
						$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
							//$CI->make->th('Product Code',array('style'=>''));
							$CI->make->th('Bar Code',array('style'=>''));
							$CI->make->th('Description',array('style'=>''));
							$CI->make->th('UOM',array('style'=>''));
							$CI->make->th('');
						$CI->make->eRow();	
					
					
					foreach($items as $v){
						$link = 
								$CI->make->A(
								fa('fa-check fa-lg fa-fw'),
								'',array('class'=>'r_addproduct',
								'id'=>'prod_'+$v->Barcode,
								'ref_desc'=>'',
								'data-id'=>$v->Barcode,
								'data-desc'=>$v->Description,
								'style'=>'cursor: pointer;',
								'return'=>'false'));

						$CI->make->sRow();
							//$CI->make->td($v->ProductCode);
							$CI->make->td($v->Barcode);
							$CI->make->td($v->Description);
							$CI->make->td($v->uom);
							$CI->make->td($link);
						$CI->make->eRow();
					}
					$CI->make->eTable();		
					$CI->make->eDiv();
				$CI->make->eRow();
			
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	return $CI->make->code();
}



function show_cat_details($items = array(),$items2 = array()){

$CI =& get_instance();
	$CI->make->sDivCol(array('style'=>'margin-top:50px'));
		$CI->make->sDivRow();
			$CI->make->sForm("",array('id'=>''));
				$CI->make->sDivCol();
					foreach($items2 as $v2){
						$datecreate = $v2->DateCreated;
						$name = $v2->CategoryName;
						$CI->make->hidden('catid',$v2->CategoryID);	
					}
				$CI->make->p($name);
				$CI->make->sDivCol();
					$CI->make->input('','txtcatprod','','Search Product',array('class'=>'','id'=>'txtcatprod'));
					$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:250px;overflow:auto'));
						$CI->make->sTable(array('class'=>'table table-hover','id'=>'tblcatprod'));
							$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
								$CI->make->th('Bar Code',array('style'=>''));
								$CI->make->th('Description',array('style'=>''));
								$CI->make->th('UOM',array('style'=>''));
								$CI->make->th('',array('style'=>''));
							$CI->make->eRow();
							$CI->make->sTableBody(array('id'=>'tbodyprod'));
							foreach($items as $v){

								$adjusment_del = 
									$CI->make->A(fa('fa-trash fa-lg fa-fw').'',
										'',array('class'=>'


',
										'id'=>'btn_del_catprod',
										'ref_desc'=>'',
										'data-id'=>$v->Barcode,
										'data-desc'=>$v->Description,
										'style'=>'cursor: pointer;',
										'return'=>'false'));

								$CI->make->sRow();
									$CI->make->td($v->Barcode);
									$CI->make->td($v->Description);
									$CI->make->td($v->uom);
									$CI->make->td($adjusment_del);
								$CI->make->eRow();
							}
							$CI->make->eTableBody();
						$CI->make->eTable();
					$CI->make->eDiv();			
				$CI->make->eDivCol();
			$CI->make->eForm();
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	
	
	return $CI->make->code();
}


function show_trans_details($items = array(),$items2 = array(),$items3 = array(),$items4 = array()){

$CI =& get_instance();
	$CI->make->sDivCol(array('style'=>'margin-top:50px'));
		$CI->make->sDivRow();
			//$CI->make->sForm("",array('id'=>'auto_form'));				
				$CI->make->sDivCol();
					foreach($items2 as $v2){
						$ddid = $v2->Branch."".$v2->AutoID;
						$dddate = $v2->DateTrans;
						$iid = $v2->InfoId;
						$CI->make->hidden('infoid',$v2->InfoId);
						//$tno = $v2->TransNoIGSA;
						$tno = ($v2->TransNoIGSA == NULL) ? "" : $v2->TransNoIGSA.",";
						$tno2 = $v2->TransNoIGNSA;
					}	
				
					foreach($items4 as $val){
								$name = $val->fname." ".$val->mname." ".$val->lname;
							}
					$CI->make->A(fa('fa-file-excel-o').' Export to Excel','',array('class'=>'btn btn-success btn-flat','id'=>'btn-export'));

					$CI->make->p("Created By: ".$name);
					
					$CI->make->p('Transaction No/s: '.$tno."".$tno2);
					
					$CI->make->hidden('trans_num',$next_trans);	
					$CI->make->hidden('date_adjustment',date('Y-m-d'));	
					$CI->make->hidden('movement','Inventory Gained (SA)');	
					$CI->make->hidden('stat_type','Open / For Approval');	


					$CI->make->input('','txtcatprod','','Search Product',array('class'=>'','id'=>'txtautoprod'));
					$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:400px;overflow:auto'));
						$CI->make->sTable(array('class'=>'table table-hover','id'=>'cc_list2'));
							$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
								$CI->make->th('Product ID',array('style'=>'','align=center'));
								$CI->make->th('Barcode',array('style'=>'','align=center'));
								$CI->make->th('Item',array('style'=>'','align=center'));
								$CI->make->th('UoM',array('style'=>'','align=center'));
								$CI->make->th('Cost',array('style'=>'','align=center'));
								$CI->make->th('Actual Count',array('style'=>'','align=center'));
								$CI->make->th('Variance',array('style'=>'','align=center'));
								$CI->make->th('Total Cost Adjustment',array('style'=>'','align=center'));
								$CI->make->th('Movements',array('style'=>'','align=center'));
							$CI->make->eRow();

					$CI->make->sTableBody(array('id'=>'tblautoprod'));
						$checkbox="";
						$no = 1;
						$counter = 0;
						//var_dump($items);
						foreach($items as $v){

								if($v->CostOfSales == .0000)
									{
										$cos2 = 0;
									}
									else
									{
										$cos2 = $v->CostOfSales;
									}
										if($v->SellingArea == .0000)
									{
										$sa = 0;
									}
									else
									{
										$sa = $v->SellingArea;
									}


							

							
							// $CI->make->hidden('bcode_'.$no,$v->Barcode,array('class'=>'bcode_'.$no));
							// $CI->make->hidden('movcode_'.$no,'',array('class'=>'movcode_'.$no));
							// $CI->make->hidden('qtyuom_'.$no,$v->qty,array('class'=>'qtyuom_'.$no));
							// $CI->make->hidden('prod_id_'.$no,$v->ProductID,array('class'=>'prod_id'));
							// //$CI->make->hidden('prod_code_'.$no,$v->ProductCode,array('class'=>'prod_code'));
							// $CI->make->hidden('prod_code_'.$no,$v->ProductCode,array('class'=>'prod_code','id'=>'prod_code_'.$no));
							// $CI->make->hidden('prod_desc_'.$no,$v->Description,array('id'=>'prod_desc_'.$no));
							
							// $CI->make->hidden('cost_'.$no,$cos2,array('class'=>'cost','id'=>'cost_'.$no,'type'=>'number'));
							// $CI->make->hidden('uom_qty2_'.$no,'',array('class'=>'uom','id'=>'uom_qty2_'.$no));

							// $CI->make->hidden('unit_'.$no,'',array('class'=>'unit','id'=>'unit_'.$no));

							// $CI->make->hidden('neg_qty_'.$no,$sa,array('class'=>'qty_edit'));
							// $CI->make->hidden('tot_cert_'.$no,'',array('class'=>'totcert'));
							// $CI->make->hidden('needtocertify_'.$no,'',array('id'=>'needtocertify_'.$no));
						
						// $role = "Security";
						// 	if($role == "Security")
						// 	{
						// 		if($v->isCertified == 1){
						// 			$checkbox = $CI->make->checkbox('','chk_'.$no,$v->Id,array('return'=>true,'class'=>'check','disabled'=>'true','checked'=>'true'));
									
						// 		}else{
						// 			$checkbox = $CI->make->checkbox('','chk_'.$no,$v->Id,array('return'=>true,'class'=>'check','disabled'=>'true',''));
						// 		}
						// 	}		
						// 	$certot = $CI->make->p('',array('id'=>'tot'));

							$CI->make->sRow();
								$CI->make->td($v->ProductID);
								$CI->make->td($v->Barcode);
								$CI->make->td($v->Description);
								$CI->make->td($v->uom);
								$CI->make->td($v->CostOfSales);
								$CI->make->td($v->ActualCount);
								$CI->make->td($v->Variance);
								$CI->make->td($v->TotalCostAdjustment);
								foreach($items3 as $stockmove)
								{
									
									if($v->ProductID == $stockmove->stock_id)
									{
										if($stockmove->a_movement_code == "IGSA")
										{
											$stk_qty = abs($stockmove->qty); 
											$movecode = "Inventory Gain";
										}
										if($stockmove->a_movement_code == "IGNSA")
										{
											$stk_qty = abs($stockmove->qty); 
											$movecode = "Inventory Loss";
										}
										//$stk_qty = abs($stockmove->qty - $sa); 
										$stk_adj = $stockmove->qty;
										$stk_cost = $stk_adj * $v->CostOfSales;
										$stk_tot = $stk_cost * $stk_adj;
										$remarks = $stockmove->memo_;
										break;			
									}
									else
									{	
										$stk_qty = "";
										$stk_adj = "";
										$stk_cost = $v->CostOfSales;
										$stk_tot = "";
										$remarks = "";
									}
								}
								$CI->make->td(($stk_qty >0 ? $movecode : '' ) );
							$CI->make->eRow();

							$no++;
							$counter++;
						}


					$CI->make->eTableBody();

						$CI->make->eTable();

					$CI->make->eDiv();
					$CI->make->h('4',"Total Items: ".$counter);
					$CI->make->hidden('total','',array('disabled'=>'disabled'));
					$CI->make->textarea('Remarks','remarks',$remarks,'Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255','readonly'=>'TRUE'));
								
					$CI->make->button('Close',array('class'=>'btn btn-danger btn-flat pull-right','data-dismiss'=>'modal'),'button');	

				$CI->make->eDivCol();
					
			//$CI->make->eForm();
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	
	
	return $CI->make->code();
}


//COPY
function show_auto_details($items = array(),$role,$items2 = array(),$next_trans = NULL){

$CI =& get_instance();
	$CI->make->sDivCol(array('style'=>'margin-top:50px'));
		$CI->make->sDivRow();
			$CI->make->sForm("",array('id'=>'auto_form'));				
				$CI->make->sDivCol();
					foreach($items2 as $v2){
						$ddid = $v2->Branch."".$v2->AutoID;
						$dddate = $v2->DateTrans;
						$iid = $v2->InfoId;
						$CI->make->hidden('infoid',$v2->InfoId);
						$tno = $v2->TransNoIGSA;
						$tno2 = $v2->TransNoIGNSA;

					}	


					$CI->make->A(fa('fa-file-excel-o').' Export to Excel','',array('class'=>'btn btn-success btn-flat','id'=>'btn-export'));
					
					
					$CI->make->p('Transaction No: '.$next_trans);
					
					$CI->make->hidden('trans_num',$next_trans);	
					$CI->make->hidden('date_adjustment',date('Y-m-d'));	
					$CI->make->hidden('movement','Inventory Gained (SA)');	
					$CI->make->hidden('stat_type','Open / For Approval');	


					$CI->make->input('','txtcatprod','','Search Product',array('class'=>'','id'=>'txtautoprod'));
					$CI->make->sDiv(array('class'=>'table-responsive','style'=>'height:400px;overflow:auto'));
						$CI->make->sTable(array('class'=>'table table-hover','id'=>'cc_list'));
							$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
								$CI->make->th('Product ID',array('style'=>'','align=center'));
								$CI->make->th('Barcode',array('style'=>'','align=center'));
								$CI->make->th('Item',array('style'=>'','align=center'));
								$CI->make->th('UoM',array('style'=>'','align=center'));
								$CI->make->th('Cost',array('style'=>'','align=center'));
								$CI->make->th('Quantity Inventory',array('style'=>'display: none;','align=center'));
								$CI->make->th('Actual Count');
								$CI->make->th('Variance',array('style'=>'','align=center'));
								//$CI->make->th('Adjustment Qty',array('style'=>'','align=center'));
								$CI->make->th('Total Cost Adjustment',array('style'=>'','align=center'));
								//$CI->make->th('Total Cost',array('style'=>'','align=center'));
								$CI->make->th('',array('style'=>'','align=center'));
							$CI->make->eRow();

					$CI->make->sTableBody(array('id'=>'tblautoprod'));
						$checkbox="";
						$no = 1;
						$counter = 0;
						foreach($items as $v){
									if($v->CostOfSales == .0000)
									{
										$cos2 = "0";
									}
									else
									{
										$cos2 = $v->CostOfSales;
									}
										if($v->SellingArea == .0000)
									{
										$sa = "0";
									}
									else
									{
										$sa = $v->SellingArea;
									}

							$CI->make->hidden('bcode_'.$no,$v->Barcode,array('class'=>'bcode_'.$no));
							$CI->make->hidden('movcode_'.$no,'',array('class'=>'movcode_'.$no));
							$CI->make->hidden('qtyuom_'.$no,$v->qty,array('class'=>'qtyuom_'.$no));
							$CI->make->hidden('prod_id_'.$no,$v->ProductID,array('class'=>'prod_id'));
							//$CI->make->hidden('prod_code_'.$no,$v->ProductCode,array('class'=>'prod_code'));
							$CI->make->hidden('prod_code_'.$no,$v->ProductCode,array('class'=>'prod_code','id'=>'prod_code_'.$no));
							$CI->make->hidden('prod_desc_'.$no,$v->Description,array('id'=>'prod_desc_'.$no));
							
							$CI->make->hidden('cost_'.$no,$cos2,array('class'=>'cost','id'=>'cost_'.$no,'type'=>'number'));
							$CI->make->hidden('uom_qty2_'.$no,'',array('class'=>'uom','id'=>'uom_qty2_'.$no));

							$CI->make->hidden('unit_'.$no,'',array('class'=>'unit','id'=>'unit_'.$no));

							$CI->make->hidden('neg_qty_'.$no,$sa,array('class'=>'qty_edit'));
							$CI->make->hidden('tot_cert_'.$no,'',array('class'=>'totcert'));
							$CI->make->hidden('needtocertify_'.$no,'',array('id'=>'needtocertify_'.$no));
						
						$role = "Security";
							if($role == "Security")
							{
								if($v->isCertified == 1){
									$checkbox = $CI->make->checkbox('','chk_'.$no,$v->Id,array('return'=>true,'class'=>'check','disabled'=>'true','checked'=>'true'));
									
								}else{
									$checkbox = $CI->make->checkbox('','chk_'.$no,$v->Id,array('return'=>true,'class'=>'check','disabled'=>'true',''));
								}
							}		
							$certot = $CI->make->p('',array('id'=>'tot'));

							$CI->make->sRow();
								$CI->make->td($v->ProductID);								
								$CI->make->td($v->Barcode);
								$CI->make->td($v->Description);
								$CI->make->td($v->uom);
								$CI->make->td($v->CostOfSales);
								//$CI->make->td($v->SellingArea);
								$CI->make->td("<input type='hidden' id='damaged_$no' value='".$v->Damaged."'/><input type='hidden' id='cos_$no' value='".$v->CostOfSales."'/><input type='hidden' id='sysinv_$no' value='".$v->SellingArea."'/><input type='text' class='actual-count' id='actual_$no'/>");
								$CI->make->td("<input type='text' id='ccqty_$no' class='ccqty' value='' disabled='disabled'>"."<input type='hidden' id='mc_$no'>"."<input type='text' id='ad_qty2_$no' hidden value=''  class='adjustment_qty' placeholder='Adjustment Quantity'>");
								// $CI->make->td("<input type='text' id='ad_qty2_$no' hidden value=''  class='adjustment_qty' placeholder='Adjustment Quantity'>");
								$CI->make->td("<input type='text' id='unit_cost2_$no' disabled value='' class = 'allunitcost'>");
								//$CI->make->td("<input type='text' id='total_$no' disabled value='' class = 'allunitcost'>");
								 $CI->make->td($checkbox." <span id='warning_$no'></span>");
							$CI->make->eRow();

						$no++;
						$counter++;
						}


					$CI->make->eTableBody();

						$CI->make->eTable();

					$CI->make->eDiv();
					$CI->make->h('4',"Total Items: ".$counter);
					$CI->make->hidden('total','',array('disabled'=>'disabled'));
					$CI->make->textarea('Remarks','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
								
					//$CI->make->button('Close',array('class'=>'btn btn-danger btn-flat pull-right','data-dismiss'=>'modal'),'button');	
					if($tno == null and $tno2 == null)
					{
						$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'ccsave_auto_btn','class'=>'btn btn-primary btn-flat pull-right','style'=>'margin-right:10px'),'submit');
					}
					else
					{
						$CI->make->button(fa('fa-save').'Save Adjustments',array('id'=>'cc2save_auto_btn','disabled'=>'disabled','class'=>'btn btn-primary btn-flat pull-right','style'=>'margin-right:10px'),'submit');
					}
	
				$CI->make->eDivCol();
					
			$CI->make->eForm();
		$CI->make->eDivRow();
	$CI->make->eDivCol();
	
	
	return $CI->make->code();
}


function item_adjustment_modal($item_details = array(),$id=null,$next_trans=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sForm("",array('id'=>'ajustment_form'));
		$CI->make->sDivCol();
		$CI->make->sDiv(array('id'=>'modal_list', 'style'=>'height: 480px; overflow-x: none; '));
			$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol(12);
									$CI->make->sDivCol(4);
										$CI->make->datefield('Adjustment Date','date_adjustment',date('Y-m-d'),'',array('class'=>'rOkay','required'=>'required','id'=>'date_adjustment'));
									$CI->make->eDivCol();
								$CI->make->eDivCol();
								$CI->make->sDivCol(12);
									$CI->make->sDivCol(4);
										$CI->make->input('Transaction No:','trans_num',$next_trans,'',array('class'=>'rOkay','disabled'=>'disabled','required'=>'required','id'=>'trans_num'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Movements','movement','Inventory Gained (SA)','',array('class'=>'','disabled'=>'disabled','required'=>'required','id'=>'movement'));
									$CI->make->eDivCol();
								$CI->make->eDivCol();
								$CI->make->sDivCol(12);
									foreach($item_details as $v){
									$CI->make->sDivCol(4);
										$CI->make->input('Vendor','v_code',$v->vendorcode.'-'.$v->vendor,'',array('class'=>'','disabled'=>'disabled','required'=>'required','id'=>'v_code'));
										$CI->make->hidden('product_id',$v->ProductID,array('id'=>'product_id'));
										$CI->make->hidden('vendor_code',$v->vendorcode,array('id'=>'vendor_code'));
										$CI->make->hidden('vendor_name',$v->vendor,array('id'=>'vendor_name'));
										$CI->make->hidden('cost',$v->CostOfSales,array('id'=>'cost'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Product Code','p_code',$v->ProductCode,'',array('class'=>'','disabled'=>'disabled','required'=>'required','id'=>'p_code'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Description','p_desc',$v->Description,'',array('class'=>'','disabled'=>'disabled','required'=>'required','id'=>'p_desc'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->input('Quantity','qty','','Quantity',array('id'=>'qty','required'=>'required','id'=>'qty'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->hidden('uom_qty','');
										$CI->make->unit_Drop('UNITS','unit','','Select Units.',array('class'=>'rOkay combobox','id'=>'unit','required'=>'required'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(2);
										$CI->make->input('Unit Cost','unit_cost','','Unit Cost',array('id'=>'unit_cost','class'=>'rOkay','disabled'=>'disabled'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(2);
										$CI->make->input('Total Cost','total','','Total Cost',array('id'=>'total','class'=>'rOkay','disabled'=>'disabled'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(12);
										$CI->make->textarea('Remarks','remarks','','Remarks', array('id'=>'remarks','style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
									$CI->make->eDivCol();
									}
								$CI->make->eDivCol();
								$CI->make->sDivCol(12,'right');
									$CI->make->button(fa('fa-save').' Update Adjustment',array('id'=>'update_adjustment', 'style'=>' margin-top: 25px;'),'success');
								$CI->make->sDivCol(4,'center');
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
			$CI->make->eBox();
			$CI->make->eDiv();
		$CI->make->eDivCol();
	$CI->make->eForm();
	$CI->make->eDivRow();
	
	return $CI->make->code();
	
}

function adjustment_inquiry($items = array(),$branch_name = null){
$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sBox('success	');
			$CI->make->sBoxBody();
					$CI->make->sDivRow();													
					$CI->make->sDivCol();
						$CI->make->sDiv(array('id'=>'adjustment'));	
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
										$CI->make->sTable(array('class'=>'table table-hover','id'=>'adjustment-tbl'));
											$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
												$CI->make->th('Branch',array('style'=>''));
												$CI->make->th('Date Created',array('style'=>''));
												$CI->make->th('TransNo',array('style'=>''));
												$CI->make->th('MoveMent Type',array('style'=>''));
												$CI->make->th('Created By',array('style'=>''));
												$CI->make->th('Date Posted',array('style'=>''));
												$CI->make->th('Approved By',array('style'=>''));
												$CI->make->th('Posted By',array('style'=>''));
												$CI->make->th('Status',array('style'=>''));
												$CI->make->th('Extended',array('style'=>''));
												$CI->make->th('Action',array('colspan'=>'2'));
												// $CI->make->th($CI->make->checkbox('','chk_all','',array('return'=>true,'class'=>'check_all')));
												// $CI->make->th('',array('style'=>''));
											$CI->make->eRow();
											$CI->make->eRow();
											$no = 1;
											foreach($items as $v){

												$adjusment = 
													$CI->make->A(
														fa('fa-eye fa-lg fa-fw').'',
														'',
														array('class'=>'btn btn-success btn-flat action_btns btn_view',
														'ref_desc'=>'',
														'id'=>$v->trans_id,
														'style'=>'cursor: pointer;',
														'return'=>'false'));

												$adjusment_del = 
													$CI->make->A(
														fa('fa-trash fa-lg fa-fw').'',
														'',
														array('class'=>'btn btn-danger btn-flat action_btns btn_del',
														'ref_desc'=>'',
														'id'=>$v->a_trans_no,
														'style'=>'cursor: pointer;',
														'return'=>'false'));
												
												$history_links = $CI->make->A(
												fa('fa-eye fa-lg fa-fw'),
												'',
												array('class'=>'btn btn-info btn-flat action_btns history_link',
												'id'=>$v->a_trans_no,
												'style'=>'cursor: pointer;',
												'return'=>'false'));
		

												$username = $CI->asset->get_username($v->a_created_by);
												$CI->make->sRow();
														$CI->make->td($branch_name);	
														$CI->make->td($v->a_date_created);	
														$CI->make->td($v->a_trans_no);	
														$CI->make->td('Inventory Gained (SA)');	
														$CI->make->td($username);
														$CI->make->td();	
														$CI->make->td();	
														$CI->make->td();	
														$CI->make->td('Open');	
														$CI->make->td($v->total);	
														$CI->make->td($adjusment_del);
														$CI->make->td($history_links);
														// $CI->make->td($CI->make->checkbox('','chk_'.$no,$v->trans_id,array('return'=>true,'class'=>'check')));
												$CI->make->eRow('<br>');
												$no++;
											}
										$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDivCol();
								$CI->make->sDivCol();
									$CI->make->sDivRow(array('style'=>'margin:10px; align:right;'));
										$CI->make->button(fa('fa-save').' Approve Selected',array('class'=>'bot_app','style'=>'text-align:right'),'success');
									$CI->make->eDivRow();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eDiv();	
					$CI->make->eDivCol();
					$CI->make->eDivRow();	
		$CI->make->eDivRow();
	return $CI->make->code();
}

function no_display_result($items = array(),$user_branch){
$CI =& get_instance();	

	$CI->make->sDiv(array('id'=>'adjustment'));	
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sDiv(array('class'=>'table-responsive'));
						date_default_timezone_set('Asia/Manila');
						$now = date('Y-m-d');
						$yes = date('Y-m-d',strtotime("-1 days"));
						if($user_branch == 'TNOV'){
							$days = 'Past 1day Sales';
							$th = array(
								'Date' =>array('align'=>'center'),
								'Product Description' =>array('align'=>'center'),
								'Current Inventory'=> array('align'=>'center'),
								'Past 30 days Sales'=>array('align'=>'center'),
								 $days =>array('align'=>'center'),
								 'number of days with sales' =>array('align'=>'center'),
								'Status'=>'',
								);
						}else{
							$days = 'Past 2days Sales';
							$th = array(
								'Date' =>array('align'=>'center'),
								'Product Description' =>array('align'=>'center'),
								'Current Inventory'=> array('align'=>'center'),
								'Past 30 days Sales'=>array('align'=>'center'),
								 $days =>array('align'=>'center'),
								'Status'=>'',
								);
						}
						
						
						$rows = array();
						
						
						if($items){
							
							$no = 1;
							foreach($items as $v){
								$dischk =false;
								$dis="";
								if($v->date_ != $yes)
								{
									$dis="disabled";
									$dischk=true;
									if($v->status == 1){
										$checkbox = $CI->make->checkbox('','chk_'.$no,$v->id,array('return'=>true,'class'=>'check','disabled'=>$dischk,'checked'=>'true'));
										$dis="disabled";
									}else{
										$checkbox = $CI->make->checkbox('','chk_'.$no,$v->id,array('return'=>true,'class'=>'check','disabled'=>$dischk));
									}
								}
								else
								{
									if($v->status == 1)
									{
										$checkbox = $CI->make->checkbox('','chk_'.$no,$v->id,array('return'=>true,'class'=>'check','disabled'=>$dischk,'checked'=>'true'));
										$dis="disabled";
									}
									else
									{
										$checkbox = $CI->make->checkbox('','chk_'.$no,$v->id,array('return'=>true,'class'=>'check'));
									}
								}

								
								$CI->make->hidden('prod_id_'.$no,$v->id,array('class'=>'prod_id'));
								$CI->make->hidden('check_val'.$no,$v->status,array('class'=>'check_data'));

							if($user_branch == 'TNOV'){
									$rows[] = array(
										$v->date_,
										$v->descripiton,
										$v->currentinventory,
										$v->past30days,
										$v->past2days,
										$v->numberofdayswithsales,
										$checkbox ."  <input type='text' $dis id='remarks_".$no."' value='".$v->remarks."' class='form-control' placeholder='Remarks'><input type='hidden' value='".$v->descripiton."' id='desc_".$no."'>",
									);
							}else{
									$rows[] = array(
										$v->date_,
										$v->descripiton,
										$v->currentinventory,
										$v->past30days,
										$v->past2days,
										$checkbox ."  <input type='text' $dis id='remarks_".$no."' value='".$v->remarks."' class='form-control' placeholder='Remarks'><input type='hidden' value='".$v->descripiton."' id='desc_".$no."'>",
									);

							}	


								$no++;
							}
						}
					$CI->make->listLayout($th,$rows,array('id'=>'chk_nodisplay'));
				$CI->make->eDiv();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eDiv();
return $CI->make->code();

}

function dashboard($branch=NULL,$neg=NULL,$nodisp=NULL,$cc=NULL,$branchdesc=NULL,$results=NULL,$pricematch_report=NULL){

	$CI =& get_instance();	

		$CI->make->sDivCol();
			$CI->make->sDivRow();
				//left search
				date_default_timezone_set('Asia/Manila');
				$now = date('m-d-Y');
				$CI->make->H(2,("<center>San Roque Supermarket - $branchdesc </center>"),array());
				//$total = 50 - $neg;
				//$total2 = 50 - $nodisp;
				//$status1= $neg < 50 ? 'danger' : 'success';
				//$status2= $nodisp < 50 ? 'danger' : 'success';
				$status3 = $cc >= 1 ? 'danger' : 'success';

			$status2='primary';
				$CI->make->sDivCol(4);
					$CI->make->sDiv(array('class'=>'panel'));
						$CI->make->sDiv(array('class'=>'panel-heading'));
							$CI->make->h(2,"Negative Inventory",array('class'=>'announcement-text'));
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table ','id'=>'adjustment-tbl'));
									$CI->make->sRow(array('style'=>''));
										$CI->make->th('Date',array('style'=>'text-align:center'));
										$CI->make->th('Posted',array('style'=>'text-align:center'));
									$CI->make->eRow();
									
									foreach($neg as $ni)
									{
										$tr="success";
										if($ni->total < 50)
										{
											$tr="danger";
										}
										//$schedule = $c->Day. " - " .$c->Schedule;
										$CI->make->sRow(array('class'=>$tr,'data-href'=>'operation/cycle_count'));
											$CI->make->td($ni->tran_date,array('style'=>'text-align:center'));
											$CI->make->td($ni->total,array('style'=>'text-align:center'));
										$CI->make->eRow();
									}
								$CI->make->eTable();



							$CI->make->eDiv();
						$CI->make->eDiv();
						$CI->make->A("<div class='panel-footer announcement-bottom'>
						            	<div class='row'>
						            		<div class='col-xs-6'>
						                  		View
						               		</div>
						             		<div class='col-xs-6 text-right'>
						                  		<i class='fa fa-arrow-circle-right'></i>
						                 	</div>
						          		</div>
						             </div>",'operation/negative_inventory',array('style'=>'cursor: pointer;'));
					$CI->make->eDiv();
				$CI->make->eDivCol();


				//$status3='success';
				// LAWRENZE
				$CI->make->sDivCol(4);
					$CI->make->sDivRow();
						$CI->make->sDivCol(12);
							$CI->make->sDiv(array('class'=>'panel panel-'.$status3));
								$CI->make->sDiv(array('class'=>'panel-heading'));
									$CI->make->sDivRow();
										$CI->make->sDivCol(6,array('class'=>'jumbotron'));
											$CI->make->h(2,$cc);
										$CI->make->eDivCol();
										$CI->make->sDivCol(6,'','',array('class'=>'text-right'));
											$CI->make->p("Total list to be posted",array('class'=>'announcement-heading'));
											$CI->make->h(2,"Cycle Count",array('class'=>'announcement-text'));
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eDiv();
								$CI->make->A("<div class='panel-footer announcement-bottom'>
												<div class='row'>
													<div class='col-xs-6'>
														View
													</div>
													<div class='col-xs-6 text-right'>
														<i class='fa fa-arrow-circle-right'></i>
													</div>
												</div>
											</div>",'operation/cycle_count',array('style'=>'cursor: pointer;'));
							$CI->make->eDiv();
						$CI->make->eDivCol();
						// PRICE MATCH
						$CI->make->sDivCol(12);
							$CI->make->sDiv(array('class'=>'panel'));
								$CI->make->sDiv(array('class'=>'panel-heading'));
									$CI->make->h(2,"Price Match",array('class'=>'announcement-text'));
									$CI->make->sDiv(array('class'=>'table-responsive'));
										$CI->make->sTable(array('class'=>'table ','id'=>'pricematch-tbl'));
											$CI->make->sRow(array('style'=>''));
												$CI->make->th('Date Posted',array('style'=>'text-align:center'));
												$CI->make->th('Total Items',array('style'=>'text-align:center'));
											$CI->make->eRow();
											
											foreach($pricematch_report as $price_match)
											{
												$tr="danger";
												if($price_match->TotalItems <= 0)
												{
													$CI->make->sRow(array('class'=>$tr));
														$CI->make->td('No Price Match',array('style'=>'text-align:center', 'colspan'=>'2'));
													$CI->make->eRow();
												}
												//$schedule = $c->Day. " - " .$c->Schedule;
												$CI->make->sRow(array('class'=>$tr));
													$CI->make->td($price_match->dateposted_branch,array('style'=>'text-align:center'));
													$CI->make->td($price_match->TotalItems,array('style'=>'text-align:center'));
												$CI->make->eRow();
											}
										$CI->make->eTable();
									$CI->make->eDiv();
								$CI->make->eDiv();
								$CI->make->A("<div class='panel-footer announcement-bottom'>
												<div class='row'>
													<div class='col-xs-6'>
														View
													</div>
													<div class='col-xs-6 text-right'>
														<i class='fa fa-arrow-circle-right'></i>
													</div>
												</div>
											</div>",'operation/price_match_report',array('style'=>'cursor: pointer;'));
							$CI->make->eDiv();
						$CI->make->eDivCol();
						// ./ PRICE MATCH
					$CI->make->eDivRow();
				$CI->make->eDivCol();
				// ./LAWRENZE

				$status2='primary';
				$CI->make->sDivCol(4);
					$CI->make->sDiv(array('class'=>'panel'));
						$CI->make->sDiv(array('class'=>'panel-heading'));
							$CI->make->h(2,"No Display",array('class'=>'announcement-text'));
							$CI->make->sDiv(array('class'=>'table-responsive'));
								$CI->make->sTable(array('class'=>'table ','id'=>'adjustment-tbl'));
									$CI->make->sRow(array('style'=>''));
										$CI->make->th('Date',array('style'=>'text-align:center'));
										$CI->make->th('Posted',array('style'=>'text-align:center'));
									$CI->make->eRow();
									
									foreach($nodisp as $nd)
									{
										$tr="success";
										if($nd->counter < 50)
										{
											$tr="danger";
										}
										//$schedule = $c->Day. " - " .$c->Schedule;
										$CI->make->sRow(array('class'=>$tr,'data-href'=>'operation/cycle_count'));
											$CI->make->td($nd->date_,array('style'=>'text-align:center'));
											$CI->make->td($nd->counter,array('style'=>'text-align:center'));
										$CI->make->eRow();
									}
								$CI->make->eTable();



							$CI->make->eDiv();
						$CI->make->eDiv();
						$CI->make->A("<div class='panel-footer announcement-bottom'>
						            	<div class='row'>
						            		<div class='col-xs-6'>
						                  		View
						               		</div>
						             		<div class='col-xs-6 text-right'>
						                  		<i class='fa fa-arrow-circle-right'></i>
						                 	</div>
						          		</div>
						             </div>",'operation/no_display',array('style'=>'cursor: pointer;'));
					$CI->make->eDiv();
				$CI->make->eDivCol();


			$CI->make->eDivRow();

			$CI->make->sDivRow();
				$CI->make->sDiv(array('class'=>'col-md-8 col-md-offset-2'));
					$CI->make->sBox('primary');

						$date_format = 'l, F d Y';
						$today = strtotime('now');
					 	$tod = gmdate($date_format, $today);

					 	$tomorrow = strtotime('+1 day', $today);
					   	$tom = gmdate($date_format, $tomorrow);
					 	
		  
						$label = "<i class='fa fa-warning' style='font-size:38px;color:red'></i>";
						$CI->make->H(3,'<center>'.$label.' Reminders - Scheduled Auto Cycle for tomorrow - '.$tom.'</center>',array('style'=>''));

						$CI->make->sDiv(array('class'=>'table-responsive'));
						$CI->make->sTable(array('class'=>'table table-hover','id'=>'adjustment-tbl'));
							$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
								$CI->make->th('Category',array('style'=>'text-align:center'));
								$CI->make->th('Schedule',array('style'=>'text-align:center'));
							$CI->make->eRow();
							
							foreach($results as $c)
							{
								$schedule = $c->Day. " - " .$c->Schedule;
								$CI->make->sRow(array('class'=>'clickable-row','data-href'=>'operation/cycle_count'));
									$CI->make->td($c->CategoryName,array('style'=>'text-align:center'));
									$CI->make->td($schedule,array('style'=>'text-align:center'));
								$CI->make->eRow();
							}
						$CI->make->eTable();



						$CI->make->eDiv();

					$CI->make->eBox();
				$CI->make->eDiv();
			$CI->make->eDivRow();
		$CI->make->eDivCol();	
			

	return $CI->make->code();
}

function no_display($items = array(),$user_branch){
	$CI =& get_instance();	
		$CI->make->sBox('primary');
			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
					//$yes = date('m/d/Y',strtotime("-1 days"));
					$CI->make->datefield('Date','date_',date('m/d/Y',strtotime("-1 days")),'',array('class'=>'rOkay'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
						$CI->make->prod_cat_Drop('Product Category','category','','Select Category.',array('class'=>'rOkay combobox','id'=>'category'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
						$CI->make->A(fa('fa-search').'Search','#',array('id'=>'btn_search', 'style'=>' margin-top: 24px;margin-right: 25px;','class'=>'btn btn-flat btn-md btn-primary'));
					$CI->make->A(fa('fa-download').'Export To Excel','#',array('id'=>'print_excel_btn' ,'style'=>' margin-top: 24px;','class'=>'btn btn-success btn-flat btn-md'));
					
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
											date_default_timezone_set('Asia/Manila');
											$now = date('Y-m-d');
											$yes = date('Y-m-d',strtotime("-1 days"));
										if($user_branch == 'TNOV'){
											$days = 'Past 1day Sales';
											$th = array(
												'Date' =>array('align'=>'center'),
												'Product Description' =>array('align'=>'center'),
												'Current Inventory'=> array('align'=>'center'),
												'Past 30 days Sales'=>array('align'=>'center'),
												 $days =>array('align'=>'center'),
												 'number of days with sales' =>array('align'=>'center'),
												'Status'=>'',
												);
										}else{
											$days = 'Past 2days Sales';
											$th = array(
												'Date' =>array('align'=>'center'),
												'Product Description' =>array('align'=>'center'),
												'Current Inventory'=> array('align'=>'center'),
												'Past 30 days Sales'=>array('align'=>'center'),
												 $days =>array('align'=>'center'),
												'Status'=>'',
												);
										}
						
											$rows = array();
													$no=0;
												
												foreach($items as $v){
													$dischk =false;
													$dis="";
													if($v->date_ != $yes)
													{
														$dis="disabled";
														$dischk=true;
														if($v->status == 1){
															$checkbox = $CI->make->checkbox('','chk_'.$no,$v->id,array('return'=>true,'class'=>'check2','disabled'=>$dischk,'checked'=>'true'));
															$dis="disabled";
														}else{
															$checkbox = $CI->make->checkbox('','chk_'.$no,$v->id,array('return'=>true,'class'=>'check2','disabled'=>$dischk));
														}
													}
													else
													{
														if($v->status == 1){
															$checkbox = $CI->make->checkbox('','chk_'.$no,$v->id,array('return'=>true,'class'=>'check2','disabled'=>$dischk,'checked'=>'true'));
															$dis="disabled";
														}
														else
														{
															$checkbox = $CI->make->checkbox('','chk_'.$no,$v->id,array('return'=>true,'class'=>'check2'));
														}
													}

													//$no++;
													//function input($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$icon1=null,$icon2=null,$container=null){
													//$rem = $CI->make->input('','remarks_'.$no,'','Remarks','');
												if($user_branch == 'TNOV'){
															$rows[] = array(
																$v->date_,
																$v->descripiton,
																$v->currentinventory,
																$v->past30days,
																$v->past2days,
																$v->numberofdayswithsales,
																$checkbox ."  <input type='text' $dis id='remarks_".$no."' value='".$v->remarks."' class='form-control' placeholder='Remarks'><input type='hidden' value='".$v->descripiton."' id='desc_".$no."'>",
															);
													}else{
															$rows[] = array(
																$v->date_,
																$v->descripiton,
																$v->currentinventory,
																$v->past30days,
																$v->past2days,
																$checkbox ."  <input type='text' $dis id='remarks_".$no."' value='".$v->remarks."' class='form-control' placeholder='Remarks'><input type='hidden' value='".$v->descripiton."' id='desc_".$no."'>",
															);

													}	
													$no++;
												}
											$CI->make->listLayout($th,$rows,array('id'=>'chk_nodisplay2'));
										$CI->make->eDiv();
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();													
			$CI->make->eBoxBody();
		$CI->make->eBox();

	return $CI->make->code();
}

// LAWRENZE
function price_match_report($user_branch){
	$CI =& get_instance();	
		$CI->make->sBox('primary');
			$CI->make->sDivRow();
				$CI->make->sDivCol(3);
					$CI->make->sDiv(array('id'=>'pricematch_branch'));	
					
					$CI->make->eDiv();
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->datefield('From Date','fdate',date('m/d/Y'),'',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->datefield('To Date','tdate',date('m/d/Y',strtotime("+1 days")),'',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->hidden('user_branch',$user_branch);	
					$CI->make->A(fa('fa-download').'Generate Report','#',array('id'=>'print_excel_btn' ,'style'=>' margin-top: 24px;','class'=>'btn btn-success btn-flat btn-md'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(12);
					$CI->make->sDiv(array('id'=>'pricematch_info'));	
					
					$CI->make->eDiv();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eBox();

	return $CI->make->code();
}
// ./LAWRENZE

function adjustment_history_view($adjustment_history = array(),$ad_top_details = array(),$id){
	
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
		$CI->make->sDiv();
			$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								foreach($ad_top_details as $d){
									$username = $CI->asset->get_username($d->a_created_by);
									$username_post = $CI->asset->get_username($d->a_posted_by);
									$CI->make->sDivCol(4);
										$CI->make->H(5,'Transaction No:'.$d->a_trans_no,array('style'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->H(5,'Adjustment Type: Inventory Gained(SA)',array('style'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->H(5,'Movement Status: Open',array('style'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->H(5,'From Location: '.$d->a_from_location,array('style'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->H(5,'Date Created: '.$d->a_date_created,array('style'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->H(5,'Date Posted:'.$d->a_date_posted,array('style'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->H(5,'To Location: '.$d->a_from_location,array('style'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->H(5,'Created By: '.$username,array('style'=>''));
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->H(5,'Posted By: '.$username_post,array('style'=>''));
									$CI->make->eDivCol();
								}
								$CI->make->sDivCol();
									$CI->make->sTable(array('class
										'=>'table table-hover','id'=>'adjustment_details'));
											$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
												$CI->make->th('Trans Date',array('style'=>''));
												$CI->make->th('Product ID',array('style'=>''));
												$CI->make->th('Barcode',array('style'=>''));
												$CI->make->th('Description',array('style'=>''));
												$CI->make->th('Cost',array('style'=>''));
												$CI->make->th('UOM',array('style'=>''));
												$CI->make->th('Qty',array('style'=>''));
												$CI->make->th('Extended',array('style'=>''));
											$CI->make->eRow();
											$CI->make->eRow();
											$total = 0;
											$remarks = '';
											foreach($adjustment_history as $v){
												$CI->make->sRow();
												$remarks = $v->memo_;
												$product_desc = $CI->operation->product_desc($v->stock_id);
												$cost = $CI->operation->get_cost($v->stock_id);
														$CI->make->td($v->a_date_created);	
														$CI->make->td($v->stock_id);	
														$CI->make->td($v->barcode);	
														$CI->make->td($product_desc);	
														$CI->make->td($cost);	
														$CI->make->td($v->i_uom);	
														$CI->make->td($v->qty);	
														$CI->make->td($v->standard_cost);	
												$CI->make->eRow();

												$total+=$v->standard_cost;
											}
											$CI->make->sRow();
												$CI->make->td('TOTAL',array('colspan'=>'7','align'=>'right'));	
												$CI->make->td($total);	
											$CI->make->eRow();
											$CI->make->textarea('Remarks','remarks',$remarks,'Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
			$CI->make->eBox();
			$CI->make->eDiv();
		$CI->make->eDivCol();
	
	$CI->make->eDivRow();
	
	return $CI->make->code();
	
}
function smart($items = array()){
	$CI =& get_instance();	
		$CI->make->sBox('primary');
		$CI->make->sForm('',array('id'=>'smart_item'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(2);
					$CI->make->input('Terminal','bcode','','Terminal no',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
					$CI->make->input('OR No.','or_num','','OR No.',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->input('Cell#.','cell_num','','09***********',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(1);
					$CI->make->yesOrNoDrop('NEW POS','postype','',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->A(fa('fa-search').'Search','#',array('id'=>'btn_search_smart', 'style'=>' margin-top: 24px;margin-right: 25px;','class'=>'btn btn-flat btn-md btn-primary'));
					$CI->make->A(fa('fa-download').'Export To Excel','#',array('id'=>'print_excel_btn_smart' ,'style'=>' margin-top: 24px;','class'=>'btn btn-success btn-flat btn-md'));
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eBox();

		$CI->make->sBox('primary');
			$CI->make->sBoxBody();
					$CI->make->sDivRow();													
						$CI->make->sDivCol();
							$CI->make->sDiv(array('id'=>'smart_data'));	
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->sDiv(array('class'=>'table-responsive'));
											$CI->make->sTable(array('class'=>'table table-hover','id'=>'smart-tbl'));
												$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
													$CI->make->th('Transaction Date',array('style'=>''));
													$CI->make->th('PlanCode',array('style'=>''));
													$CI->make->th('Transaction Type',array('style'=>''));
													$CI->make->th('Transaction RRN',array('style'=>''));
													$CI->make->th('Branch Code',array('style'=>''));
													$CI->make->th('OR No.',array('style'=>''));
													$CI->make->th('Source Account',array('style'=>''));
													$CI->make->th('Amount Deduct',array('style'=>''));
													$CI->make->th('Target Sub-Account',array('style'=>''));
													$CI->make->th('Terminal ID',array('style'=>''));
													$CI->make->th('Address',array('style'=>''));
													$CI->make->th('Response Code',array('style'=>''));
													$CI->make->th('Response Description',array('style'=>''));
													$CI->make->th('okay',array('style'=>''));
												$CI->make->eRow();
												$CI->make->eRow();
												foreach($items as $v){
													$CI->make->sRow();
															$CI->make->td(date('Y-m-d',strtotime($v->date_added)));	
															$CI->make->td($v->planCode);	
															$CI->make->td($v->transactionType);
															$CI->make->td($v->transactionRRN);
															$CI->make->td($v->BranchCode);	
															$CI->make->td($v->ORNo);	
															$CI->make->td($v->sourceAccount);	
															$CI->make->td($v->amountDeduct);	
															$CI->make->td($v->targetSubsAccount);	
															$CI->make->td($v->terminalID);	
															$CI->make->td($v->address);	
															$CI->make->td($v->respcode);	
															$CI->make->td($v->respcodedesc);	
															$CI->make->td($v->isokay);	
													$CI->make->eRow();
												}
											$CI->make->eTable();
										$CI->make->eDiv();
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();													
			$CI->make->eBoxBody();
			$CI->make->eForm();
		$CI->make->eBox();

	return $CI->make->code();
}

function smart_result($items = array()){
$CI =& get_instance();	
	$CI->make->sDiv(array('id'=>'adjustment'));	
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sDiv(array('class'=>'table-responsive'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'adjustment-tbl'));
						$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
							$CI->make->th('Transaction Date',array('style'=>''));
							$CI->make->th('PlanCode',array('style'=>''));
							$CI->make->th('Transaction Type',array('style'=>''));
							$CI->make->th('Transaction RRN',array('style'=>''));
							$CI->make->th('Branch Code',array('style'=>''));
							$CI->make->th('OR No.',array('style'=>''));
							$CI->make->th('Source Account',array('style'=>''));
							$CI->make->th('Amount Deduct',array('style'=>''));
							$CI->make->th('Target Sub-Account',array('style'=>''));
							$CI->make->th('Terminal ID',array('style'=>''));
							$CI->make->th('Address',array('style'=>''));
							$CI->make->th('Response Code',array('style'=>''));
							$CI->make->th('Response Description',array('style'=>''));
							$CI->make->th('okay',array('style'=>''));
						$CI->make->eRow();
						$CI->make->eRow();
						if($items){
							foreach($items as $v){
								$CI->make->sRow();
									$CI->make->td(date('Y-m-d',strtotime($v->date_added)));	
									$CI->make->td($v->planCode);	
									$CI->make->td($v->transactionType);
									$CI->make->td($v->transactionRRN);
									$CI->make->td($v->BranchCode);	
									$CI->make->td($v->ORNo);	
									$CI->make->td($v->sourceAccount);	
									$CI->make->td($v->amountDeduct);	
									$CI->make->td($v->targetSubsAccount);	
									$CI->make->td($v->terminalID);	
									$CI->make->td($v->address);	
									$CI->make->td($v->respcode);	
									$CI->make->td($v->respcodedesc);	
									$CI->make->td($v->isokay);	
								$CI->make->eRow();
							}
						}
					$CI->make->eTable();
				$CI->make->eDiv();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eDiv();
return $CI->make->code();

}

//----------------Dan----------------------//
function view_data($items = array()){
	$CI =& get_instance();	
		$CI->make->sBox('primary');
		$CI->make->sForm('',array('id'=>'view_data_item'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(3);
					$CI->make->input('Description','Description','','Input Description',array('class'=>'rOkay reqForm'));//Edit
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
					$CI->make->input('Barcode','Barcode','','Input Barcode',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
					$CI->make->datefield('From Date','fdate',date('m/d/Y'),'',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
					$CI->make->datefield('To Date','tdate',date('m/d/Y',strtotime("+1 days")),'',array('class'=>'rOkay reqForm'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
					$CI->make->A(fa('fa-search').'Search','#',array('id'=>'btn_search_view_data', 'style'=>' margin-top: 24px;margin-right: 25px;','class'=>'btn btn-flat btn-md btn-primary'));
				$CI->make->eDivCol();
			$CI->make->eDivRow();
		$CI->make->eBox();

		$CI->make->sBox('primary');
			$CI->make->sBoxBody();
					$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDiv(array('id'=>'view_data_data'));	
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->sDiv(array('class'=>'table-responsive'));
												$CI->make->sTable(array('class'=>'table table-hover','id'=>'smart-tbl'));
													$CI->make->sRow(array('style'=>'background-color: #EEEEEE; font-size: 13px;'));
														$CI->make->th('Barcode',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Transaction ID',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Transaction #',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Date Posted',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Status',array('style'=>'','class'=>'text-center'));
														// $CI->make->th('Beginning Qty',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Selling Area Stock',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Selling Area In',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Selling Area Out',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Damage In',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Damage Out',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Unitcost',array('style'=>'','class'=>'text-center'));
														$CI->make->th('Posted by',array('style'=>'','class'=>'text-center'));
													$CI->make->eRow();
													foreach($items as $v){
														$CI->make->sRow(array('style'=>'font-size: 13px;'));
														// $CI->make->td($v->Barcode);
														$CI->make->eRow();
													}
												$CI->make->eTable();
											$CI->make->eDiv();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eDiv();
							$CI->make->eDivCol();
					$CI->make->eDivRow();													
			$CI->make->eBoxBody();
			$CI->make->eForm();
		$CI->make->eBox();
	return $CI->make->code();
}

function view_data_result($items = array() ,$user_branch){
$CI =& get_instance();	
	$CI->make->sDiv(array('id'=>'view_data_data'));	
		$CI->make->sDivRow();


			$CI->make->sDivCol(3);
				$CI->make->input('Product ID','','','Product ID',array('class'=>'rOkay reqForm','disabled'=>'disabled','value'=>$items[0]->PID == NULL ? '--' : $items[0]->PID));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->input('Description','','','Description',array('class'=>'rOkay reqForm','disabled'=>'disabled','value'=>$items[0]->Description == NULL ? '--' : $items[0]->Description));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->input('Current Selling Area','','','Current Selling Area',array('class'=>'rOkay reqForm','disabled'=>'disabled','value'=>$items[0]->SellingArea == NULL ? '--' : $items[0]->SellingArea));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->input('Current Cost of Sale','costofsales','','Current Cost of Sale',array('class'=>'rOkay reqForm','disabled'=>'disabled','value'=>$items[0]->CostOfSales == NULL ? '--' : $items[0]->CostOfSales));
			$CI->make->eDivCol();


			$CI->make->sDivCol(3);
				$CI->make->hidden('barcode',$items[0]->Barcode);
				$CI->make->A(
				fa('fa-eye fa-lg fa-fw').' View SRP Sample Computation',
				'',
				array('class'=>'btn btn-primary btn-flat  text-centeraction_btns btn_view_srp_computation',
				'data-toggle'=>'modal',
				'data-target'=>'#myModal_srp_computation',
				'ref_desc'=>'',
				'id'=>$items[0]->PID,
				'style'=>'cursor: pointer;margin-bottom: 20px;margin-right: 25px;'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->A(
				fa('fa-eye fa-lg fa-fw').' View Price Change History',
				'',
				array('class'=>'btn btn-primary btn-flat  text-centeraction_btns btn_view_data',
				'data-toggle'=>'modal',
				'data-target'=>'#myModal',
				'ref_desc'=>'',
				'id'=>$items[0]->PID,
				'style'=>'cursor: pointer;margin-bottom: 20px;margin-right: 25px;'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->A(
				fa('fa-eye fa-lg fa-fw').' View Markup / SRP',
				'',
				array('class'=>'btn btn-primary btn-flat  text-center action_btns btn_view_markup',
				'data-toggle'=>'modal',
				'data-target'=>'#myModal_markup_srp',
				'ref_desc'=>'',
				'id'=>$items[0]->PID,
				'style'=>'cursor: pointer;margin-bottom: 20px;margin-right: 25px;'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->hidden('user_branch',$user_branch);	
				$CI->make->A(
				fa('fa-download').'Export To Excel',
				'#',
				array('id'=>'print_excel_btn' ,
				'style'=>'cursor: pointer;margin-bottom: 20px;margin-right: 25px;',
				'class'=>'btn btn-success btn-flat btn-md '));
			$CI->make->eDivCol();
			

			$CI->make->sDivCol();
				$CI->make->sDiv(array('class'=>'table-responsive text-center'));
					$CI->make->sTable(array('class'=>'table table-hover','id'=>'view_data_data-tbl'));
						$CI->make->sRow(array('style'=>'background-color: #EEEEEE; font-size: 13px;'));
							$CI->make->th('Barcode',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Transaction ID',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Transaction #',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Date Posted',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Status',array('style'=>'','class'=>'text-center'));
							// $CI->make->th('Beginning Qty',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Selling Area Stock',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Selling Area In',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Selling Area Out',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Damage In',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Damage Out',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Unitcost',array('style'=>'','class'=>'text-center'));
							$CI->make->th('Posted by',array('style'=>'','class'=>'text-center'));
						$CI->make->eRow();
						if($items){
							foreach($items as $v){
								$CI->make->sRow(array('style'=>'font-size: 13px;'));
									$CI->make->td($v->Barcode);
									$CI->make->td($v->TransactionID);
									$CI->make->td($v->TransactionNo,array('class'=>'hover-tn','id'=>$v->TransactionNo,'style'=>'display: inline-block;'));	
									$CI->make->td($v->DatePosted);
									$CI->make->td($v->Description2);	
									// $CI->make->td($v->BeginningSellingArea);	
									$CI->make->td($v->BeginningStockRoom == NULL ? '0' : $v->BeginningStockRoom);	
									$CI->make->td($v->SellingAreaIn);	
									$CI->make->td($v->SellingAreaOut);	
									$CI->make->td($v->StockRoomIn == NULL ? '0' : $v->StockRoomIn);	
									$CI->make->td($v->StockRoomOut == NULL ? '0' : $v->StockRoomOut);	
									$CI->make->td($v->UnitCost == NULL ? '0' : $v->UnitCost);	
									$CI->make->td($v->Name == NULL ? 'N/A' : $v->Name);	
								$CI->make->eRow();
							}
						}
					$CI->make->eTable();
				$CI->make->eDiv();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eDiv();

	$CI->make->sDiv(array('id'=>'myModal','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
	$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
		$CI->make->sDiv(array('class'=>'modal-content'));

			$CI->make->sDiv(array('class'=>'modal-header'));
				$close = "<span aria-hidden='true'>&times;</span>";
				$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
				$CI->make->H(4,'Price Change History',array('style'=>'','class'=>'modal-title'));
			$CI->make->eDiv();
			
			$CI->make->sDiv(array('class'=>'modal-body'));	
						
				$CI->make->sDiv(array('id'=>'price_change_history'));
					$CI->make->sDivCol();										
						$CI->make->sDivRow();
							
						$CI->make->eDivRow();
					$CI->make->eDivCol();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();
	$CI->make->eDiv();
$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'myModal_markup_srp','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
	$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
		$CI->make->sDiv(array('class'=>'modal-content'));

			$CI->make->sDiv(array('class'=>'modal-header'));
				$close = "<span aria-hidden='true'>&times;</span>";
				$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
				$CI->make->H(4,'Markup and SRP',array('style'=>'','class'=>'modal-title'));
			$CI->make->eDiv();
			
			$CI->make->sDiv(array('class'=>'modal-body'));	
						
				$CI->make->sDiv(array('id'=>'markup'));
					$CI->make->sDivCol();										
						$CI->make->sDivRow();
							
						$CI->make->eDivRow();
					$CI->make->eDivCol();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();
	$CI->make->eDiv();
$CI->make->eDiv();

		$CI->make->sDiv(array('id'=>'myModal_srp_computation','class'=>'modal fade bs-example-modal-lg','data-backdrop'=>'static','tabindex'=>'-1','role'=>'dialog'));	
	$CI->make->sDiv(array('class'=>'modal-dialog modal-lg','role'=>'document','style'=>'width:1250px'));
		$CI->make->sDiv(array('class'=>'modal-content'));

			$CI->make->sDiv(array('class'=>'modal-header'));
				$close = "<span aria-hidden='true'>&times;</span>";
				$CI->make->button($close,array('class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'),'button');
				$CI->make->H(4,'SRP Computation',array('style'=>'','class'=>'modal-title'));
			$CI->make->eDiv();
			
			$CI->make->sDiv(array('class'=>'modal-body'));	
						
				$CI->make->sDiv(array('id'=>'srp_computation'));
					$CI->make->sDivCol();										
						$CI->make->sDivRow();
							
						$CI->make->eDivRow();
					$CI->make->eDivCol();
				$CI->make->eDiv();
			$CI->make->eDiv();
		$CI->make->eDiv();
	$CI->make->eDiv();
$CI->make->eDiv();				

return $CI->make->code();
}

function view_data_button($items = array()){
	$CI =& get_instance();	
		$CI->make->sBox('primary');
			$CI->make->sBoxBody();
					$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->sDiv(array('class'=>'table-responsive text-center'));
											$CI->make->sTable(array('class'=>'table table-hover','id'=>'smart-tbl'));
												$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
													$CI->make->th('Barcode',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Mode Code',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Date',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Posted By',array('style'=>'','class'=>'text-center'));
													$CI->make->th('From SRP',array('style'=>'','class'=>'text-center'));
													$CI->make->th('To SRP',array('style'=>'','class'=>'text-center'));
													$CI->make->th('UOM',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Markup',array('style'=>'','class'=>'text-center'));
												$CI->make->eRow();
												foreach($items as $v){
													$v->PostedBy = $v->PostedBy == 'd923' ? 3100 : $v->PostedBy;
													$v->PostedBy = $v->PostedBy == 'admin'? 1223 : $v->PostedBy;
													$CI->make->sRow();
														$CI->make->td($v->barcode);	
														$CI->make->td($v->PriceModecode);
														$CI->make->td($v->dateposted);	
														$CI->make->td($v->PostedBy,array('class'=>'hover-name','id'=>$v->PostedBy,'style'=>'display:inline-block;'));	
														$CI->make->td($v->fromsrp);
														$CI->make->td($v->tosrp);
														$CI->make->td($v->UOM);	
														$CI->make->td($v->markup);	
													$CI->make->eRow();
												}
											$CI->make->eTable();
										$CI->make->eDiv();
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDivRow();													
			$CI->make->eBoxBody();
			$CI->make->eForm();
		$CI->make->eBox();
	$CI->make->eDiv();
	return $CI->make->code();
}

function view_markup_button($markup_srp = array()){
	$CI =& get_instance();	
		$CI->make->sBox('primary');
			$CI->make->sBoxBody();
					$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDivRow();
									$CI->make->sDivCol();
										$CI->make->sDiv(array('class'=>'table-responsive text-center'));
											$CI->make->sTable(array('class'=>'table table-hover','id'=>'smart-tbl'));
												$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
													$CI->make->th('Product Code',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Barcode',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Description',array('style'=>'','class'=>'text-center'));
													$CI->make->th('UOM',array('style'=>'','class'=>'text-center'));
													$CI->make->th('QTY',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Markup',array('style'=>'','class'=>'text-center'));
													$CI->make->th('SRP',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Mode Code',array('style'=>'','class'=>'text-center'));
												$CI->make->eRow();
												foreach($markup_srp as $v){
													$CI->make->sRow();
														$CI->make->td($v->ProductCode);	
														$CI->make->td($v->Barcode);
														$CI->make->td($v->Description);	
														$CI->make->td($v->uom);	
														$CI->make->td($v->qty);
														$CI->make->td($v->markup);
														$CI->make->td($v->srp);	
														$CI->make->td($v->PriceModeCode);	
													$CI->make->eRow();
												}
											$CI->make->eTable();
										$CI->make->eDiv();
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDivRow();													
			$CI->make->eBoxBody();
			$CI->make->eForm();
		$CI->make->eBox();
	$CI->make->eDiv();
	return $CI->make->code();
}

function view_srp_computation($items = array(), $costofsales){
	$CI =& get_instance();	
		$CI->make->sBox('primary');
			$CI->make->sBoxBody();
					$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDivRow();
									$CI->make->sDivCol();
									$srp = $costofsales/((100 - $items[0]->markup)/100);
									$CI->make->sDivCol(4);
										$CI->make->p('SRP Formula:');
										$CI->make->p('SRP = Cost of Sales /(100-Markup/100)');
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->p('Actual Computation:');
										$CI->make->p(''.$costofsales.'/((100 - '.$items[0]->markup.')/100)');
									$CI->make->eDivCol();
									$CI->make->sDivCol(4);
										$CI->make->p('Should be SRP:');
										$CI->make->p($srp);
									$CI->make->eDivCol();

									$CI->make->sDivCol(12);
									$CI->make->eDivCol();
									$CI->make->sDivCol(12);
									$CI->make->eDivCol();
									
									$CI->make->sDiv(array('class'=>'table-responsive text-center'));
											$CI->make->sTable(array('class'=>'table table-hover','id'=>'smart-tbl'));
												$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
													$CI->make->th('Product Code',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Barcode',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Description',array('style'=>'','class'=>'text-center'));
													$CI->make->th('UOM',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Cost of Sales',array('style'=>'','class'=>'text-center'));
													$CI->make->th('Markup',array('style'=>'','class'=>'text-center'));
													// $CI->make->th('SRP',array('style'=>'','class'=>'text-center'));
												$CI->make->eRow();
												foreach($items as $v){
													$CI->make->sRow();
														$CI->make->td($v->ProductCode);	
														$CI->make->td($v->Barcode);
														$CI->make->td($v->Description);	
														$CI->make->td($v->uom);	
														$CI->make->td($costofsales);
														$CI->make->td($v->markup);
														// $CI->make->td($v->srp);	
													$CI->make->eRow();
												}
											$CI->make->eTable();
										$CI->make->eDiv();
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eDivCol();
					$CI->make->eDivRow();													
			$CI->make->eBoxBody();
			$CI->make->eForm();
		$CI->make->eBox();
	$CI->make->eDiv();
	return $CI->make->code();
}

function view_tn($view_tns = array()){
	foreach($view_tns as $v){
		if($v->ToDescription != ''){
			echo '
			 	<p><label>To : '.$v->ToDescription.'</label></p>
			 	<p><label>From : '.$v->FromDescription.'</label></p>
			';
		}else{
			echo '
				<p><label> To : No Data, Please Check another Data</label></p>
				<p><label> From : No Data, Please Check another Data</label></p>
			';
		}
	}
}

function view_name($view_name = array()){
	foreach($view_name as $v){
		if($v->name == 'DONOT USE'){
			echo 			 
			'
				<p><label> NAME : ADMINISTRATOR</label></p>
			';
		}elseif($v->name != 'DONOT USE'){
			
			echo
			'
				<br>
			 	<p><label>Name : '.$v->name.'</label></p>
			';
		}
	}
}
//----------------Dan End----------------------//
?>
