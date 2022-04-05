<?php



function asset_transfer_in_form($id, $item=array(), $details=array(), $results=array() ,$details_temp=array()){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
					$CI->make->sBox('primary');
						$CI->make->sBoxBody();
						
							$CI->make->sDivRow();
							$CI->make->hidden('hidden_trans_id',$id);
								$CI->make->sDivCol(12,'left');
									$CI->make->H(5,"Asset Transfer Header",array('style'=>'margin-top:0px;margin-bottom:10px;'));
								$CI->make->eDivCol();
							
								$CI->make->sDivCol(3,'left');
									$CI->make->BranchAssetDrop('From Branch','from_branch_code',$item->from_branch,'Select Branch.',array('disabled'=>'disabled'));	
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3,'left');
									$CI->make->BranchAssetDrop('To Branch','to_branch_code',$item->to_branch,'Select Branch.',array('disabled'=>'disabled'));	
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3,'left');
									$CI->make->AssetDepartmentDrop('Department','department_code',$item->to_department,'Select Department.',array('disabled'=>'disabled'));
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3,'left');
									$CI->make->AssetUnitDrop('Unit','unit_code',$item->to_unit,'-',array('disabled'=>'disabled'));
								$CI->make->eDivCol();	
							$CI->make->eDivRow();
							
							$CI->make->sDivRow();
							
								$CI->make->sDivCol(3,'left');
									$CI->make->datefield('Date Needed','date_needed',date('m/d/Y', strtotime($item->date_needed)),'',array('disabled'=>'disabled'));
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3,'left');
									$CI->make->input('Created By','created_by',$CI->asset_model->get_username($item->assigned_by),'',array('disabled'=>'disabled'));
								$CI->make->eDivCol();	
								
								$CI->make->sDivCol(6,'left');
									$CI->make->textarea('Remarks','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255','disabled'=>'disabled'));
								$CI->make->eDivCol();
								
							$CI->make->eDivRow();
												
						$CI->make->eBoxBody();
					$CI->make->eBox();	
			$CI->make->eDivCol();
			
			 $CI->make->sDivRow();
				$CI->make->sDivCol();
					 $CI->make->sDivCol(3);
					 $CI->make->eDivCol();
					 $CI->make->sDivCol(6); 
						$CI->make->sBox('warning');
							$CI->make->sBoxBody();	
								
								   $CI->make->sDivCol(12,'center');
										$CI->make->H(5,"Asset Transfer Details",array('style'=>'margin-top:0px;margin-bottom:10px;'));
								   $CI->make->eDivCol();
								
								   $CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->th('Asset Type',array('style'=>''));
										$CI->make->th('Descripiton',array('style'=>''));
										$CI->make->th('&nbsp;&nbsp;',array('style'=>''));
											$CI->make->eRow();
											
											$count1 = count($details);
											$CI->make->hidden('count_details',$count1);
											foreach($details as $val){
													$in = " <span class='label label-info'>IN</span>";
												$CI->make->sRow();
												$asset_type = $CI->asset_model->get_asset_type($val->asset_type);
													$CI->make->td($asset_type);	
													$CI->make->td($val->description);	
													$CI->make->td($val->in == 1 ? $in:'');	
												$CI->make->eRow();
											}
								  $CI->make->eTable();						
							$CI->make->eBoxBody();
					    $CI->make->eBox();
					 $CI->make->eDivCol();
					 $CI->make->sDivCol(3);
					 $CI->make->eDivCol();
				$CI->make->eDivCol();
			 $CI->make->eDivRow();
			 	
			 $CI->make->sDivRow();
				$CI->make->sDivCol();
					$CI->make->sDivCol(4);
					$CI->make->eDivCol();
					$CI->make->sDivCol(4,'center');
						$CI->make->input('Asset #:','asset_no','','',array('class'=>''));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
					$CI->make->eDivCol();
				$CI->make->eDivCol();
			 $CI->make->eDivRow();
			 $CI->make->sDivRow();
			
				$CI->make->sDivCol(2);
				$CI->make->eDivCol();
				$CI->make->sDivCol(8,'center');
					$CI->make->sDiv(array('id'=>'line_item_contents'));	
					
						$CI->make->sDivCol();
							$CI->make->sBox('warning');
								$CI->make->sBoxBody();
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->sDiv(array('class'=>'table-responsive'));
												$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
													$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
														$CI->make->th('Asset Type',array('style'=>''));
														$CI->make->th('Asset #',array('style'=>''));
														$CI->make->th('Descripiton',array('style'=>''));
													$CI->make->eRow();
													$count2 = count($details_temp);
													$CI->make->hidden('count_temp_details',$count2);
													foreach($details_temp as $vals){
														$CI->make->sRow();
																$CI->make->td($CI->asset_model->get_asset_type($vals->type));	
																$CI->make->td($vals->asset_no);	
																$CI->make->td($vals->description);	
															$CI->make->eRow();
													}
												$CI->make->eTable();
											$CI->make->eDiv();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					
					$CI->make->eDiv();
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
				$CI->make->eDivCol();
				
			$CI->make->eDivRow();
			 
			 $CI->make->sDivRow();
			 
			 	$CI->make->sDivCol(4);
				$CI->make->eDivCol();
				$CI->make->sDivCol(4,'center');
						$CI->make->button(fa('fa-refresh').' Process',array('id'=>'process_in_btn', 'disabled'=>'disabled', 'style'=>' margin-top: 25px;'),'primary');
						$CI->make->button(fa('fa-arrow-left').'Back',array('id'=>'cancel_btn', 'style'=>' margin-top: 25px;margin-left: 25px;'),'danger');
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
			 
			 $CI->make->eDivRow();
				
		$CI->make->eDivRow();
	return $CI->make->code();
}





function asset_out_form($item,$details,$id,$details_temp){
//echo var_dump($details);
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
					$CI->make->sBox('primary');
						$CI->make->sBoxBody();
						
							$CI->make->sDivRow();
							$CI->make->hidden('hidden_trans_id',$id);
								$CI->make->sDivCol(12,'left');
									$CI->make->H(5,"Asset Transfer Header",array('style'=>'margin-top:0px;margin-bottom:10px;'));
								$CI->make->eDivCol();
							
								$CI->make->sDivCol(3,'left');
									$CI->make->BranchAssetDrop('From Branch','from_branch_code',$item->from_branch,'Select Branch.',array('disabled'=>'disabled'));	
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3,'left');
									$CI->make->BranchAssetDrop('To Branch','to_branch_code',$item->to_branch,'Select Branch.',array('disabled'=>'disabled'));	
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3,'left');
									$CI->make->AssetDepartmentDrop('Department','department_code',$item->to_department,'Select Department.',array('disabled'=>'disabled'));
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3,'left');
									$CI->make->AssetUnitDrop('Unit','unit_code',$item->to_unit,'-',array('disabled'=>'disabled'));
								$CI->make->eDivCol();	
							$CI->make->eDivRow();
							
							$CI->make->sDivRow();
							
								$CI->make->sDivCol(3,'left');
									$CI->make->datefield('Date Needed','date_needed',date('m/d/Y', strtotime($item->date_needed)),'',array('disabled'=>'disabled'));
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(3,'left');
									$CI->make->input('Created By','created_by',$CI->asset_model->get_username($item->assigned_by),'',array('disabled'=>'disabled'));
								$CI->make->eDivCol();	
								
								$CI->make->sDivCol(6,'left');
									$CI->make->textarea('Remarks','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255','disabled'=>'disabled'));
								$CI->make->eDivCol();
								
							$CI->make->eDivRow();
												
						$CI->make->eBoxBody();
					$CI->make->eBox();	
			$CI->make->eDivCol();
			
			 $CI->make->sDivRow();
				$CI->make->sDivCol();
					 $CI->make->sDivCol(3);
					 $CI->make->eDivCol();
					 $CI->make->sDivCol(6); 
						$CI->make->sBox('warning');
							$CI->make->sBoxBody();	
								
								   $CI->make->sDivCol(12,'center');
										$CI->make->H(5,"Asset Transfer Details",array('style'=>'margin-top:0px;margin-bottom:10px;'));
								   $CI->make->eDivCol();
								
								   $CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										$CI->make->th('Asset Type',array('style'=>''));
										$CI->make->th('Descripiton',array('style'=>''));
										$CI->make->th('&nbsp;&nbsp;',array('style'=>''));
											$CI->make->eRow();
											//echo count($details);
											//echo count($asset_temp);
											$count1 = count($details);
											$CI->make->hidden('count_details',$count1);
										
											foreach($details as $val){	
										
											$out = " <span class='label label-info'>OUT</span>";
												$CI->make->sRow();
												$asset_type = $CI->asset_model->get_asset_type($val->asset_type);
													$CI->make->td($asset_type);	
													$CI->make->td($val->description);	
													$CI->make->td($val->out == 1 ? $out:'');	
												$CI->make->eRow();
											}
								  $CI->make->eTable();						
							$CI->make->eBoxBody();
					    $CI->make->eBox();
					 $CI->make->eDivCol();
					 $CI->make->sDivCol(3);
					 $CI->make->eDivCol();
				$CI->make->eDivCol();
			 $CI->make->eDivRow();
			 	
			 $CI->make->sDivRow();
				$CI->make->sDivCol();
					$CI->make->sDivCol(4);
					$CI->make->eDivCol();
					$CI->make->sDivCol(4,'center');
						$CI->make->input('Asset #:','asset_no','','',array('class'=>''));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
					$CI->make->eDivCol();
				$CI->make->eDivCol();
			 $CI->make->eDivRow();
			 $CI->make->sDivRow();
			
				$CI->make->sDivCol(2);
				$CI->make->eDivCol();
				$CI->make->sDivCol(8,'center');
					$CI->make->sDiv(array('id'=>'line_item_contents'));	
					
					
					
						$CI->make->sDivCol();
							$CI->make->sBox('warning');
								$CI->make->sBoxBody();
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->sDiv(array('class'=>'table-responsive'));
												$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
													$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
														$CI->make->th('Asset Type',array('style'=>''));
														$CI->make->th('Asset #',array('style'=>''));
														$CI->make->th('Descripiton',array('style'=>''));
													$CI->make->eRow();
													$count2 = count($details_temp);
													$CI->make->hidden('count_temp_details',$count2);
													foreach($details_temp as $vals){
														$CI->make->sRow();
																$CI->make->td($CI->asset_model->get_asset_type($vals->type));	
																$CI->make->td($vals->asset_no);	
																$CI->make->td($vals->description);	
															$CI->make->eRow();
													}
												$CI->make->eTable();
											$CI->make->eDiv();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					
					$CI->make->eDiv();
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
				$CI->make->eDivCol();
				
			$CI->make->eDivRow();
			 
			 $CI->make->sDivRow();
			 
			 	$CI->make->sDivCol(4);
				$CI->make->eDivCol();
				$CI->make->sDivCol(4,'center');
						$CI->make->button(fa('fa-refresh').' Process',array('id'=>'process_out_btn', 'disabled'=>'disabled', 'style'=>' margin-top: 25px;'),'primary');
						$CI->make->button(fa('fa-arrow-left').' Back',array('id'=>'cancel_btn', 'style'=>' margin-top: 25px;margin-left: 25px;'),'danger');
						
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
			 
			 $CI->make->eDivRow();
				
		$CI->make->eDivRow();
	return $CI->make->code();
}




function repair_asset_form(){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sForm("",array('id'=>'assign_asset_form'));
				
			   $CI->make->sDiv(array('id'=>'file-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('primary',array('div-form'));
								$CI->make->sBoxBody(array('style'=>'height:80px;'));
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array("style"=>'margin-top:5px; margin-bottom:5px;'));
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
					$CI->make->eDivCol();	
				$CI->make->eDiv();
					
				$CI->make->sDivCol();
					$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol(12,'right');
									$CI->make->A(fa('fa-reply').' Go Back',base_url().'asset/new_asset_list',array('id'=>'back-btn','class'=>'btn'));
									$on_process_asset ='';
									$assigned_asset = $CI->asset_model->get_assigned_asset();
									$array_aa = array();
									foreach($assigned_asset as $aa){
										//echo $aa->asset_id;
										array_push($array_aa,$aa->asset_id);
									}
									$on_process_asset =  implode($array_aa,',');
									
										if($on_process_asset == null)
											$on_process_asset = 0;
									
										$CI->make->sDivRow();
											$CI->make->sDivCol(12,'left');
												
												//$CI->make->H(1,"Asset No.",array('style'=>'margin-top:0px;margin-bottom:10px ;'));
												// $asset_no = $CI->asset_model->get_asset_no_db($id);
												// $row = $CI->asset_model->get_asset_acquisition_life($id);
												// $CI->make->hidden('asset_id',$id);	
												// $CI->make->hidden('acquisition_cost',$row->acquisition_cost);	
												// $CI->make->hidden('old_life_span',$row->life_span);	
											
											$CI->make->eDivCol();
											
											$CI->make->sDivCol(3,'left');
												$CI->make->AssetNoDrop2('Asset No.','asset_no','','Select Asset No.',array('class'=>' combobox rOkay'),$on_process_asset);
											$CI->make->eDivCol();
											
											$CI->make->sDivCol(3,'left');
												$CI->make->RepairTypeDrop('Repair Type','repair_type','');
											$CI->make->eDivCol();
											$CI->make->sDivCol(3,'left');
												$CI->make->input('Amount','amount','','amount',array('class'=>' numbers-only'));
											$CI->make->eDivCol();
											$CI->make->sDivCol(3,'left');
												$CI->make->input('Additional life years','life_years','','Life Years',array('class'=>' numbers-only'));
											$CI->make->eDivCol();
										$CI->make->eDivRow();
										
										$CI->make->sDivRow();
											$CI->make->sDivCol(4,'left');
														$CI->make->textarea('Remarks*','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
											$CI->make->eDivCol();
											$CI->make->sDivCol(4,'left');
											$CI->make->eDivCol();
											$CI->make->sDivCol(4,'left');
											$CI->make->eDivCol();
										$CI->make->eDivRow();
										
										$CI->make->sDivRow();
											$CI->make->sDivCol(4,'left');
											$CI->make->eDivCol();
											$CI->make->sDivCol(4,'left');
												$CI->make->button(fa('fa-circle-o-notch').'Repair',array('id'=>'btn-repair','class'=>'btn-block'),'primary');
											$CI->make->eDivCol();
											$CI->make->sDivCol(4,'left');
											$CI->make->eDivCol();
										$CI->make->eDivRow();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
			$CI->make->eForm();
		$CI->make->eDivRow();
	return $CI->make->code();
}
	

function dispose_asset_form(){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sForm("asset/insert_disposal_request",array('id'=>'process_asset_disposal'));
				$CI->make->sDivCol();
					$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'right');
								//$CI->make->A(fa('fa-reply').' Go Back','',array('id'=>'back-btn','class'=>'btn'));
								$CI->make->sDivRow();
						$CI->make->eDivRow();
						
						$assigned_asset = $CI->asset_model->get_assigned_asset();
							$array_aa = array();
							foreach($assigned_asset as $aa){
								//echo $aa->asset_id;
								array_push($array_aa,$aa->asset_id);
							}
							$on_process_asset =  implode($array_aa,',');
								if($on_process_asset == null)
									$on_process_asset = 0;
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
								$CI->make->datefield('Disposal Date','disposal_date',date('m/d/Y'),'',array('class'=>'rOkay'));
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								//$CI->make->AssetNoDrop2('Asset Number','asset_id','','Select Asset No.',array('class'=>' combobox rOkay'));
								
								$CI->make->AssetNoDrop2('Asset No.','asset_id','','Select Asset No.',array('class'=>' combobox rOkay'),$on_process_asset);
								
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->textarea('Remarks*','remarks','','Remarks', array('class'=>'rOkay','style'=>'resize:vertical; height: 60px;','maxchars'=>'255','class'=>'rOkay'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
								$CI->make->button(fa('fa-sign-out').'Dispose',array('id'=>'btn-dispose','class'=>'btn-block'),'primary');
							$CI->make->eDivCol();
							$CI->make->sDivCol(4);
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
					$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivCol();
			$CI->make->eForm();
		$CI->make->eDivRow();
	return $CI->make->code();
}

function assign_asset_form($rheader = array(),$rdetails = array()){
	$CI =& get_instance();
		$CI->make->sDivRow();
					$CI->make->sForm("asset/process_assign_asset",array('id'=>'assign_asset_form'));
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'right');
								$CI->make->A(fa('fa-reply').' Go Back','',array('id'=>'back-btn','class'=>'btn'));
							$CI->make->sDivRow();
							//header
								$CI->make->sDivCol();
									$CI->make->H(5,"Request Asset Header",array('style'=>'margin-top:0px;margin-bottom:10px;  color:#3366FF ;'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
										
											$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
												$CI->make->th('Request No',array('style'=>'text-align:center'));
												$CI->make->th('To Branch',array('style'=>'text-align:center'));
												$CI->make->th('Department',array('style'=>'text-align:center'));
												$CI->make->th('Date Requested',array('style'=>'text-align:center'));
												$CI->make->th('Date Needed',array('style'=>'text-align:center'));
												$CI->make->th('Approved By Manager',array('style'=>'text-align:center'));
												$CI->make->th('Approved By Admin',array('style'=>'text-align:center'));
											$CI->make->eRow();
										
										foreach($rheader as $v){
											$CI->make->hidden('asset_request_id',$v->id);										
											$CI->make->hidden('to_branch',$v->to_branch);										
											$CI->make->hidden('to_department',$v->to_department);
											$CI->make->hidden('date_requested',$v->date_requested);
											$CI->make->hidden('date_needed',$v->date_needed);
											$CI->make->hidden('approved_by',$v->approve_by);
											$CI->make->hidden('requested_by',$v->user_id);
											$CI->make->hidden('manager',$v->manager_approval);
											
											$manager = $CI->asset_model->get_username($v->manager_approval);
											$admin = $CI->asset_model->get_username($v->approve_by);
											$department = $CI->asset_model->department_name($v->to_department);
											$branch = $CI->asset_model->get_branch_desc($v->to_branch);
												$CI->make->td($v->id,array('style'=>'text-align:center'));	
												$CI->make->td($branch,array('style'=>'text-align:center'));		
												$CI->make->td($department,array('style'=>'text-align:center'));		
												$CI->make->td(date('Y-m-d',strtotime($v->date_requested)),array('style'=>'text-align:center'));		
												$CI->make->td(date('Y-m-d',strtotime($v->date_needed)),array('style'=>'text-align:center'));		
												$CI->make->td($manager,array('style'=>'text-align:center'));		
												$CI->make->td($admin,array('style'=>'text-align:center'));		
											$CI->make->eRow();
										}
										
										$CI->make->eTable();
								$CI->make->append('<hr class="style-one" style="margin-top: 10px;"/>');
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							//details
							$CI->make->sDivRow();
								$CI->make->sDivCol(2);
								$CI->make->eDivCol();
								
								$quantity = 0;
								$branch_count = 0;
								$CI->make->sDivCol(8);
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
									$CI->make->H(3,"**ASSET REQUEST LIST**",array('style'=>'margin-top:0px;margin-bottom:10px;  color:#3366FF ; text-align:center;'));	
											$CI->make->sRow(array('style'=>'background-color: #EEEEEE; text-align:center'));
												$CI->make->th('Asset Type',array('style'=>'text-align:center'));
												$CI->make->th('Asset No',array('style'=>'text-align:center'));
												$CI->make->th('Descripiton',array('style'=>'text-align:center'));
												$CI->make->th('Qty',array('style'=>'text-align:center'));
											$CI->make->eRow();
									
										foreach($rdetails as $v){
											$asset_no = $CI->asset_model->get_asset_no_db($v->asset_id);
											$asset_type = $CI->asset_model->get_asset_type($v->asset_type);
												$CI->make->td($asset_type,array('style'=>'text-align:center'));	
												$CI->make->td($asset_no,array('style'=>'text-align:center'));		
												$CI->make->td($v->description,array('style'=>'text-align:center'));		
												$CI->make->td($v->quantity,array('style'=>'text-align:center'));		
											$CI->make->eRow();
											$quantity += $v->quantity;
										}
												$CI->make->td('Total : '.$quantity.'',array('style'=>'text-align:right','colspan'=>'4'));		
										
										$CI->make->eTable();
								$CI->make->eDivCol();
							
								$CI->make->sDivCol(2);
							
								$CI->make->eDivCol();
							$CI->make->	eDivRow();
							
							//assigning
							$CI->make->sDivRow();
								$CI->make->sDivCol(1);
								$CI->make->eDivCol();
								
								$CI->make->sDivCol(10);
								$CI->make->H(3,"**SELECT AND ASSIGN ASSET FROM**",array('style'=>'margin-top:0px;margin-bottom:10px;  color:#3366FF ; text-align:center;'));
									$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
											$CI->make->sRow(array('style'=>'background-color: #EEEEEE; text-align:center'));
												$CI->make->th('Asset Type',array('style'=>'text-align:center'));
												$CI->make->th('Branch',array('style'=>'text-align:center'));
												$CI->make->th('Asset No',array('style'=>'text-align:center'));
											$CI->make->eRow();
									$CI->make->eTable();
								$CI->make->append('<br>');
									
									$assigned_asset = $CI->asset_model->get_assigned_asset();
									$array_aa = array();
									foreach($assigned_asset as $aa){
										//echo $aa->asset_id;
										array_push($array_aa,$aa->asset_id);
									}
										$on_process_asset =  implode($array_aa,',');
											if($on_process_asset == null)
												$on_process_asset = 0;
										$counter = 0;
										foreach($rdetails as $v){
										
											$asset_id = ''; 
											$asset_type = $CI->asset_model->get_asset_type($v->asset_type);
											$CI->make->hidden('count',$v->quantity);
												for($i=1;$i<=$v->quantity;$i++){
													
													$counter++;
													if($v->asset_id != '' ){
														$asset_id = $v->asset_id;
													}
												
													$CI->make->	SDivRow();
														$CI->make->sDivCol(4);
															$CI->make->hidden('asset_type_c'.$counter,$v->asset_type);										
															$CI->make->input('','asset_type_'.$counter,$asset_type,'',array('disabled'=>'disabled'));
														$CI->make->eDivCol();
														$CI->make->sDivCol(4);
															$CI->make->BranchAssetDrop('','branch_code_'.$counter,'','',array('class'=>'branch_drop combobox rOkay','ref'=>$counter));
														$CI->make->eDivCol();
														$CI->make->sDivCol('','',4,array('id'=>'asset-div'.$counter));														
															// $CI->make->AssetNoDrop2('','asset_no_'.$counter,$asset_id,'Select Asset No.',array('class'=>' combobox rOkay'),$on_process_asset);
																// $CI->make->sDivCol('','left',0,array('id'=>'asset-div'));
														$CI->make->AssetNoDrop('','','','Select Asset No.',array('class'=>' combobox'));
													// $CI->make->eDivCol();
															
														$CI->make->eDivCol();
													$CI->make->	eDivRow();
												$CI->make->hidden('asset_description_'.$counter ,$v->description);										
												}
										}
										$CI->make->hidden('asset_request_count',$counter);										
								$CI->make->eDivCol();
							
								$CI->make->sDivCol(1);
								$CI->make->eDivCol();
							$CI->make->	eDivRow();
								$CI->make->sDivCol(4);
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
									$CI->make->textarea('Remarks','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
								$CI->make->eDivCol();
	
							$CI->make->	sDivRow();
							$CI->make->	eDivRow();
							
							$CI->make->	sDivRow();
								$CI->make->sDivCol(4);
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
								$CI->make->append('</br>');
									$CI->make->button(fa('fa-circle-o-notch').'PROCESS',array('id'=>'btn-process','class'=>'btn-block'),'primary');
									
								$CI->make->eDivCol();
								$CI->make->sDivCol(4);
								$CI->make->eDivCol();
							$CI->make->	eDivRow();
					$CI->make->eForm();
							
						 $CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->sDivRow();
		$CI->make->sDivCol();
	return $CI->make->code();
}








function reload_branch_asset_type($results,$counter)
{
	$CI =& get_instance();
		$CI->make->reloadedBranchAssetNoDrop('','asset_no_'.$counter,null,'Asset Number',array('class'=>'asset_no_drop_c combobox','ref'=>$counter), $results); //-----EMPTY

	return $CI->make->code();

}



function build_resigned_date_popup_form($trans_id,$branch_code,$dept_code,$unit_code){
	$CI =& get_instance();
	//$CI->make->sForm("employee/applicant_resigned_db",array('id'=>'form'));
		$CI->make->sDivRow(array('style'=>'margin-top:0px;margin-bottom:0px;'));
		$CI->make->sDivCol(12,'center');
			$CI->make->H(4,"OIC VERIFICATION",array('style'=>'margin-top:0px;margin-bottom:10px;'));
			$CI->make->append('<hr class="style-one" style="margin-top: 10px;"/>');
		$CI->make->eDivCol();
			$CI->make->sDivCol();
				//$CI->make->sBox('success');
					//$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->hidden('trans_id',$trans_id);
							$CI->make->hidden('branch_code',$branch_code);
							$CI->make->hidden('dept_code',$dept_code);
							$CI->make->hidden('unit_code',$unit_code);
								$CI->make->sDivCol(6);
									$CI->make->input('Username','username','','','');
								$CI->make->eDivCol();
								$CI->make->sDivCol(6);
									$CI->make->input('Password','password','','',array('type'=>'password'));
								$CI->make->eDivCol();
							//	$CI->make->sDivCol(4);
									//$CI->make->button(fa('fa-save').' Approve',array('id'=>'save-btn','class'=>'btn','style'=>' margin-top: 22px;'),'primary');
								//$CI->make->eDivCol();
						$CI->make->eDivRow();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	//$CI->make->eForm();
	return $CI->make->code();
}






function asser_list_tab($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-mail-forward')."  ASSET LIST"=>array('href'=>'#asset','class'=>'tab_link','load'=>'asset/new_asset_list_/','id'=>'asset_link')
					);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'asset','class'=>'tab-pane active'));
						$CI->make->eTabPane();
					
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function asset_list($list = array()){

	$CI =& get_instance();
	$CI->make->sDiv(array('id'=>'file-spinner'));
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();

						$CI->make->sDivCol(12,'left');
								$CI->make->A('Search By :');
							$CI->make->eDivCol();

							$CI->make->sDivCol(12,'right');
							//	$CI->make->A(fa('fa-plus').' Add New Asset',base_url().'asset/new_asset',array('class'=>'btn btn-primary'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();

						$CI->make->sDivRow();

							$CI->make->sDivCol(2);
										$CI->make->input('Curent Branch (Branch Code)','c_branch');
							$CI->make->eDivCol();

							$CI->make->sDivCol(2);
										$CI->make->input('Asset no.','asset_no');
							$CI->make->eDivCol();

							$CI->make->sDivCol(2);
										$CI->make->input('Assigned Person','assined_p');
							$CI->make->eDivCol();



							/*$CI->make->sDivCol(2);
										$CI->make->input('Date Acquired','date_acquired');
							$CI->make->eDivCol();*/

							$CI->make->sDivCol(2);
										$CI->make->button('Search',array('id'=>'btn_search', 'style'=>' margin-top: 20px;margin-right: 25px;','class'=>'btn-block'),'primary');
							$CI->make->eDivCol();
	// ______________________________________________________ new lester _________________________________________
							
							$CI->make->sDivCol(2);
										$CI->make->button(fa('fa-reply').' Export to Excel',array('id'=>'print_excel_btn', 'style'=>' margin-top: 20px;margin-right: 25px;','class'=>'btn-block'),'success');
							$CI->make->eDivCol();
	// ______________________________________________________ new lester _________________________________________

						$CI->make->eDivRow();


				
							$CI->make->sDivRow();													
								$CI->make->sDivCol();
									$CI->make->sDiv(array('id'=>'asset_list_data'));	
									
											$CI->make->sBox('warning');
												$CI->make->sBoxBody();
														$CI->make->sDivRow();
															$CI->make->sDivCol();
																$CI->make->sDiv(array('class'=>'table-responsive'));
																	$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
																		$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
																			$CI->make->th('Description.',array('style'=>''));
																			$CI->make->th('Asset No.',array('style'=>''));
																			$CI->make->th('Current Branch',array('style'=>''));
																			$CI->make->th('Assigned Person',array('style'=>''));
																			$CI->make->th('Date Acquired',array('style'=>''));
																			$CI->make->th('History',array('style'=>''));
																		$CI->make->eRow();
																		
																	$CI->make->eTable();
																$CI->make->eDiv();
															$CI->make->eDivCol();
														$CI->make->eDivRow();
													$CI->make->eBoxBody();
												$CI->make->eBox();
											$CI->make->eDivCol();
									$CI->make->eDiv();	
								$CI->make->eDivCol();
								$CI->make->eDivRow();


						$CI->make->eDivRow();


					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	return $CI->make->code();
	
}



function asset_list_reload_form($item = array()){

$CI =& get_instance();
	$CI->make->sDivCol();
		$CI->make->sBox('warning');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									$CI->make->th('Current Branch',array('style'=>''));
									$CI->make->th('Asset No',array('style'=>''));
									$CI->make->th('Description',array('style'=>''));
									$CI->make->th('Assigned Person',array('style'=>''));
									$CI->make->th('Date Acquired',array('style'=>''));
									$CI->make->th('Supplier',array('style'=>''));	
									$CI->make->th('Invoice',array('style'=>''));	
									$CI->make->th('Serial',array('style'=>''));		
									$CI->make->th('History',array('style'=>''));
									$CI->make->th('',array('style'=>''));
								$CI->make->eRow();
								foreach($item as $v){

									// $assigned_user = $CI->asset_model->get_hs_hr_user($v->assign_to);
									$no = $CI->asset_model->check_asset_in_history($v->id);
									$links = "";
									$history_links = $repair_links = "";
									$del_btn = $CI->make->A(
											fa('fa-trash-o fa-lg fa-fw').'Delete',
											'',
											array('class'=>'btn btn-success action_btns del_link',
											'ref_desc'=>'del',
											'id'=>$v->id,
										    'asset_no'=>$v->asset_no,
											'title'=>'Delete Asset',
											'style'=>'cursor: pointer;',
											'return'=>'false'));
											
									$repair_links .= $CI->make->A(
													fa('fa-wrench fa-lg fa-fw').'Repair',
													base_url().'asset/repair_asset_form/'.$v->id,
													array('class'=>'btn btn-danger',
														  'return'=>true));
									
									$history_links = $CI->make->A(
												fa('fa-history fa-fw')."History",
												'',
												array('class'=>'btn btn-info action_btns history_link',
												'id'=>$v->id,
												'style'=>'cursor: pointer;',
												'return'=>'false'));

									$assigned_person = '';
	// ______________________________________________________ new lester _________________________________________
									
									if ($v->assign_to == '-') {

										$assigned_person = 'No Assigned Person';

									}else{

										$assigned_person = $v->assign_to;
									}
									
									// if($assigned_user){

									// 	$assigned_person = $assigned_user;

									// }else{

									// 	$assigned_person = $v->assign_to;
									// }

									$CI->make->sRow();
											$CI->make->td($v->c_branch_code);	
											$CI->make->td($v->asset_no);	
											$CI->make->td($v->item_description);
											$CI->make->td($assigned_person);	
											$CI->make->td($v->date_acquired);
											$CI->make->td($v->supplier);
											$CI->make->td($v->invoice_no);	
											$CI->make->td($v->serial_no);
													
											$CI->make->td($history_links);
									$CI->make->eRow();			
									

	// ______________________________________________________ new lester _________________________________________



						}

	return $CI->make->code();
}



function asset_list__n($list = array()){

	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
						$CI->make->sDivCol(12,'right');
								$CI->make->A(fa('fa-plus').' Add New Asset',base_url().'asset/new_asset',array('class'=>'btn btn-primary'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
					
							$CI->make->sDivCol();
								$th = array(
										'Asset Number' => ' ',
										'Item Description' =>' ',
										'Date Acquired'=>' ',
										'Assigned To'=>' ',
										'Asset Remarks'=>' ',
										'Current Branch'=>' ',
										' '=>array('width'=>'5%','align'=>'right')
									//	'&nbsp;'=>array('width'=>'5%','align'=>'right'),
										//'&nbsp;&nbsp;'=>array('width'=>'5%')
										);
								$rows = array();
								foreach($list as $v){
									$no = $CI->asset_model->check_asset_in_history($v->id);
									$links = "";
									$history_links = $repair_links = "";
									$del_btn = $CI->make->A(
											fa('fa-trash-o fa-lg fa-fw').'Delete',
											'',
											array('class'=>'btn btn-success action_btns del_link',
											'ref_desc'=>'del',
											'id'=>$v->id,
										    'asset_no'=>$v->asset_no,
											'title'=>'Delete Asset',
											'style'=>'cursor: pointer;',
											'return'=>'false'));
											
									$repair_links .= $CI->make->A(
													fa('fa-wrench fa-lg fa-fw').'Repair',
													base_url().'asset/repair_asset_form/'.$v->id,
													array('class'=>'btn btn-danger',
														  'return'=>true));
									
									$history_links = $CI->make->A(
												fa('fa-history fa-fw')."History",
												'',
												array('class'=>'btn btn-info action_btns history_link',
												'id'=>$v->id,
												'style'=>'cursor: pointer;',
												'return'=>'false'));
												
									$rows[] = array(
												  $v->asset_no,
												  $v->item_description,
												  $v->date_acquired,
												  $v->assign_to,
												  $v->asset_remarks,
												  $v->c_branch_code,
												  $history_links	
												//  $repair_links,
												 // ($no == 1 ? $del_btn:'')
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

function asset_transfer_Slip($asset_transfer_header){
	$CI =& get_instance();	
		//echo var_dump($asset_transfer_header);
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
							$CI->make->sBoxBody();
									$CI->make->sDivRow();
										$CI->make->sDivCol(3);
											$CI->make->H(4,"View Transfer Slip",array('style'=>'margin-top:0px;margin-bottom:0px;'));
										$CI->make->eDivCol();
									$CI->make->eDivRow();

									$CI->make->sDivRow();
									$CI->make->sDivCol(3);
										$CI->make->input('Transfer #','transfer_no');
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
									$CI->make->datefield('FROM','date_from','','','');
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
									$CI->make->datefield('To','date_to','','','');
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
									$CI->make->button('Search',array('id'=>'btn_search', 'style'=>' margin-top: 20px;margin-right: 25px;','class'=>'btn-block'),'primary');
									$CI->make->eDivCol();
								
								$CI->make->eDivRow();
								$CI->make->sDivRow();													
								$CI->make->sDivCol();
									$CI->make->sDiv(array('id'=>'line_transslip'));	
									
											$CI->make->sBox('warning');
												$CI->make->sBoxBody();
														$CI->make->sDivRow();
															$CI->make->sDivCol();
																$CI->make->sDiv(array('class'=>'table-responsive'));
																	$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
																		$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
																			$CI->make->th('Asset Transfer #',array('style'=>''));
																			$CI->make->th('From Branch',array('style'=>''));
																			$CI->make->th('To Branch',array('style'=>''));
																			$CI->make->th('',array('style'=>''));
																		$CI->make->eRow();
																		
																	$CI->make->eTable();
																$CI->make->eDiv();
															$CI->make->eDivCol();
														$CI->make->eDivRow();
													$CI->make->eBoxBody();
												$CI->make->eBox();
											$CI->make->eDivCol();
									$CI->make->eDiv();	
								$CI->make->eDivCol();
								$CI->make->eDivRow();								
							$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		
		
		
		
		
	return $CI->make->code();
}



function transfer_slip_list($item=array(),$ref=null,$trans_id=null){
	$CI =& get_instance();
	
	$CI->make->sDivCol();
		$CI->make->sBox('warning');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									$CI->make->th('Asset Transfer #',array('style'=>''));
									$CI->make->th('From Branch',array('style'=>''));
									$CI->make->th('To Branch',array('style'=>''));
									$CI->make->th('Delivered By',array('style'=>''));
									$CI->make->th('Received By',array('style'=>''));
									$CI->make->th('',array('style'=>''));
								$CI->make->eRow();
								foreach($item as $val){
									$translip = $CI->make->A(
											fa('fa-print fa-fw')." Transfer Slip",
											'',
											array('class'=>'btn btn-warning action_btns translip_link',
											'ref_desc'=>'modify po',
											'id'=>$val->id,
											'title'=>'Transfer Out',
											'style'=>'cursor: pointer;',
											'return'=>'false'));
									
									
									$CI->make->sRow();
											$CI->make->td($val->id);	
											$CI->make->td($CI->asset_model->get_branch_desc($val->from_branch));	
											$CI->make->td($CI->asset_model->get_branch_desc($val->to_branch));	
											$delivered_desc='';
											$received_desc='';
											$delivered_by = $CI->asset_model->get_asset_p_assigned($val->delivered_by);
											
											if($delivered_by){
												$delivered_desc = $delivered_by->fname.' '.$delivered_by->lname;
											}
											
											$received_by = $CI->asset_model->get_asset_p_assigned($val->received_by);
											if($received_by){
												$received_desc = $received_by->fname.' '.$received_by->lname;
											}
											
											$CI->make->td($delivered_desc);	
											$CI->make->td($received_desc);	
											$CI->make->td($translip);	
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





function asset_transfer_view_form($rheader = array(),$rdetails = array(),$id = null){
	$CI =& get_instance();

	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									//$CI->make->H(5,"Asset Transfer # ".$id ,array('style'=>'margin-top:0px;margin-bottom:0px;'));
									$th = array(
											'Asset Transfer.' => ' ',
											'From Branch' =>' ',
											'To branch'=>' ',
											'Department'=>' ',
											'Approved By (Manager)'=>' ',
											'Approved By (Admin)'=>' ',
											'Delivered By'=>' ',
											'Received By'=>' ');
									$rows = array();
									foreach($rheader as $v){
										$manager = $CI->asset_model->get_username($v->approved_by_manager);
										$admin = $CI->asset_model->get_username($v->approved_by_admin);
										$department = $CI->asset_model->department_name($v->to_department);
										$received_by = $CI->asset_model->get_username($v->received_by);
										$f_branch = $CI->asset_model->get_branch_desc($v->from_branch);
										$t_branch = $CI->asset_model->get_branch_desc( $v->to_branch);
										$delivered_by = $CI->asset_model->get_username($v->delivered_by);
										if($v->status == 1){
											$username = " <span class='label label-info'>FOR APPROVAL</span>";
										}
										$rows[] = array(
													  $id,
													  $f_branch,
													  $t_branch,
													  $department,
													  $manager,
													  $admin,
													  $delivered_by,
													  $received_by
												);

									}
									$CI->make->listLayout($th,$rows);
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									//$CI->make->H(5,"Asset Transfer # ".$id ,array('style'=>'margin-top:0px;margin-bottom:0px;'));
									$th = array(
											'Asset Type #.' => ' ',
											'Asset #' =>' ',
											'Descripiton'=>' ',
											'OUT'=>' ',
											'IN'=>' ',
											'CONFIRMED IN BY'=>' ');
									$rows = array();
									$no = '';
									$yes = '';
									foreach($rdetails as $v){
										//$username = $CI->asset_model->get_username($v->approve_by);
										//$department = $CI->asset_model->department_name($v->to_department);
										// if($v->status == 1){
											// $username = " <span class='label label-info'>FOR APPROVAL</span>";
										// }
										$asset_no = $CI->asset_model->get_asset_no_db($v->asset_id);
										$asset_type = $CI->asset_model->get_asset_type($v->asset_type);
										//$no = $CI->make->A(fa('fa-minus fa-lg fa-fw'),'',array("return"=>true));
										
										//$yes = $CI->make->A(fa('fa-check fa-lg fa-fw'),'',array("return"=>true));
										$date_out = $v->date_out;
										$date_in = $v->date_in;
										
										$rows[] = array(
											  $asset_type,
											  $asset_no,
											  $v->description,
											  ($v->out != 0 ? $date_out: $no),
											  ($v->in != 0 ? $date_in : $no),
											  ($CI->asset_model->get_username($v->confirmed_in_by))
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

function asset_history_view_list($asset_history_details = array(),$id){
	
	$CI =& get_instance();
	$CI->make->sDivRow();
		$asset_no = $CI->asset_model->get_asset_no($id);
		$CI->make->sDivCol();
		$CI->make->sDiv(array('id'=>'', 'style'=>'height: 500px; overflow-x: none; overflow-y: scroll;'));
			$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol();
								$CI->make->H(2,$asset_no,array('style'=>'margin-top:0px;margin-bottom:0px;'));
									$th = array(
											'Branch' =>' ',
											'Department'=>' ',
											'Time'=>' ',
											'Nature of Movement Type'=>' ',
											'Remarks'=>' '
											);
									
									foreach($asset_history_details as $v){
									//	$username = $CI->asset_model->get_username($v->approve_by);
										$department = $CI->asset_model->department_name($v->department_code);
										$branch = $CI->asset_model->get_branch_desc($v->branch_code);
										$type = '';
										if($v->type == 'OUT'){
											$type = 'TRANSFER OUT';
										}elseif($v->type == 'IN'){
											$type = 'TRANSFER IN';
										}else{
											$type = '';
										}
										$rows[] = array(
										
													  $branch,
													  $department,
													  date("Y-m-d h:i:sa",strtotime($v->stamp)) ,
													  $type,
													  ''
											);

									}
									$CI->make->listLayout($th,$rows);
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
			$CI->make->eBox();
			$CI->make->eDiv();
		$CI->make->eDivCol();
	
	$CI->make->eDivRow();
	
	return $CI->make->code();
	
}


function request_asset_view_list($request_asset_header_list = array(),$request_asset_details = array()){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->H(5,"Request Asset Header",array('style'=>'margin-top:0px;margin-bottom:0px;'));
									$th = array(
											'Request No.' => ' ',
											'To Branch' =>' ',
											'Department'=>' ',
											'Date Requested'=>' ',
											'Date Needed'=>' ',
											'Approved By Manager'=>' ',
											'Approved By Admin'=>' '
											);
									$rows = array();
									foreach($request_asset_header_list as $v){
										$manager = $CI->asset_model->get_username($v->manager_approval);
										$admin = $CI->asset_model->get_username($v->approve_by);
										$department = $CI->asset_model->department_name($v->to_department);
										$branch = $CI->asset_model->get_branch_desc($v->to_branch);
										if($v->status == 1){
											$username = " <span class='label label-info'>FOR APPROVAL</span>";
										}
										$rows[] = array(
													  $v->id,
													  $branch,
													  $department,
													  date('Y-m-d',strtotime($v->date_requested)),
													  date('Y-m-d',strtotime($v->date_needed)),
													  $manager,
													  $admin
													 
											);

									}
									$CI->make->listLayout($th,$rows);
									$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
			
		$CI->make->sDivCol();
		$CI->make->sBox('warning');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->H(5,"",array('style'=>'margin-top:0px;margin-bottom:0px;'));
									$th = array(
											'Asset Remarks' => ' '
											);
									$rows = array();
									foreach($request_asset_header_list as $v){
											
										$rows[] = array(
											$v->remarks,
													 
											);

									}
									$CI->make->listLayout($th,$rows);
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();






		$CI->make->sDivCol();
			$CI->make->sBox('warning');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->H(5,"Request Asset Details",array('style'=>'margin-top:0px;margin-bottom:0px;'));
									$th = array(
											'Asset Type' => ' ',
											'Asset No' =>' ',
											'Descripiton'=>' ',
											'Qty'=>' ');
									$rows = array();
									foreach($request_asset_details as $v){
											$asset_no = $CI->asset_model->get_asset_no_db($v->asset_id);
											$asset_type = $CI->asset_model->get_asset_type($v->asset_type);
										$rows[] = array(
													  $asset_type,
													  $asset_no,
													  $v->description,
													  $v->quantity
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
function asser_transfer_header_list_tab($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-mail-forward')."  ASSET TRANSFER LIST"=>array('href'=>'#assetTransList','class'=>'tab_link','load'=>'asset/asset_transfer_inquiry_/','id'=>'asset_trans_list_link')
					);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'assetTransList','class'=>'tab-pane active'));
						$CI->make->eTabPane();
					
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}

function asser_disposal_list_tab($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-mail-forward')."  ASSET DISPOSAL LIST"=>array('href'=>'#assetdisposalList','class'=>'tab_link','load'=>'asset/asset_disposal_inquiry_/','id'=>'asset_disposal_list_link')
					);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'assetdisposalList','class'=>'tab-pane active'));
						$CI->make->eTabPane();
					
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}

function asset_disposal_header_list($list = array(),$is_manager = null){
	$CI =& get_instance();
	
			   $CI->make->sDiv(array('id'=>'file-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('primary',array('div-form'));
								$CI->make->sBoxBody(array('style'=>'height:80px;'));
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array("style"=>'margin-top:5px; margin-bottom:5px;'));
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
					$CI->make->eDivCol();	
				$CI->make->eDiv();
				
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'');
								//$CI->make->A(fa('fa-plus').' Add New Asset',base_url().'asset/new_asset',array('class'=>'btn btn-primary'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
						
							$CI->make->sDivCol(12,'');
								$th = array(
										'Asset Disposal #' =>array('align'=>'center'),
										'Asset No' =>array('align'=>'center'),
										'Disposal Date'=> array('align'=>'center'),
										'Remarks'=>array('align'=>'center'),
										'Requested By'=>array('align'=>'center'),
										'status'=>'',
										'&nbsp&nbsp'=>'',
										'&nbsp&nbsp&nbsp'=>''
										);
								$rows = array();
									
									
									
								foreach($list as $v){
									// $tag = '';
									// $view = $approve ="";
									// $username = $CI->asset_model->get_username($v->user_id);
									// if($v->status == 1){
											// $tag = " <span class='label label-warning'>FOR APPROVAL</span>";
									// }else if($v->status == 2){
											// $tag .= " <span class='label label-success'>APPROVED</span>";
									// }else{
											// $tag .=" <span class='label label-info'>ASSIGNED</span></br>";
									// }
									// $assign_btn = $CI->make->A(
													// fa('fa-pencil fa-fw')."Assign Asset",
												// '',
												// array('class'=>'btn btn-info action_btns assign_link',
													// 'ref_desc'=>'modify po',
													// 'id'=>$v->id,
													// 'title'=>'Assign Asset',
													// 'style'=>'cursor: pointer;',
													// 'return'=>'false'));
													
									// $header = $CI->make->A(
									// 				'#'.$v->asset_transfer_id,
									// 			'',
									// 			array('class'=>'btn  transfer_header_link',
									// 				'ref_desc'=>'modify po',
									// 				'id'=>$v->asset_transfer_id,
									// 				'title'=>'Assign Asset',
									// 				'style'=>'cursor: pointer;',
									// 				'return'=>'false'));

									
									// $view .= $CI->make->A(fa('fa-eye fa-lg fa-fw'),'',array("return"=>true,"class"=>'view_link',"id"=>$v->id));
									// $department = $CI->asset_model->department_name($v->to_department);
									// $status = '';
									// if($v->status == '1'){
										// $status = $approve_btn;
									// }elseif($v->status == '2'){
										// $status =  $assign_btn;
									// }else{
										// $status = '';
									// }
									//$asset_no = $CI->asset_model->get_asset_no_db($v->asset_id);
									//$asset_type = $CI->asset_model->get_asset_type($v->asset_type);
									
									$confirmed_in_links = $CI->make->A(
												fa('fa-check-square-o fa-fw')."Approved",
												'',
												array('class'=>'btn btn-success action_btns confirmed_link',
												'id'=>$v->id,
												'asset_id'=>$v->asset_id,
												'asset_no'=>$v->asset_no,
												'remarks'=>$v->remarks,
												'disposal_date'=>$v->disposal_date,
												'return'=>'false'));


									$reject_links = $CI->make->A(
												fa('fa-check-square-o fa-fw')."Reject",
												'',
												array('class'=>'btn btn-warning action_btns reject_link',
												'id'=>$v->id,
												'asset_id'=>$v->asset_id,
												'disposal_date'=>$v->disposal_date,
												'return'=>'false'));
									
									//$no = $CI->make->A(fa('fa-minus fa-lg fa-fw'),'',array("return"=>true));
									
									//$yes = $CI->make->A(fa('fa-check fa-lg fa-fw'),'',array("return"=>true));
										
									//$date_out = $v->date_out;
									//$date_in = $v->date_in;

									// $header,
									 // $CI->asset_model->get_asset_type( $v->asset_type),
									 //  $asset_no,
									 //  $v->description,
									 //  ($v->out != 0 ? $date_out : $no),
									 //  ($v->in != 0 ? $date_in : $no),

									$tag = '';
									//ECHO  $v->is_disposed;	
									if($v->is_disposed == 1){

										$tag .= "<font color='GREEN'>APPROVED</font>";

									}elseif($v->is_disposed == 2){

										$tag .= "<font color='RED'>REJECTED</font>";

									}elseif($v->is_disposed == 0){

										$tag .= "<font color='ORANGE'>PENDING</font>";

									}

									$user_name = $CI->asset_model->get_username($v->requested_by);
									$rows[] = array(

												$v->id,
												$v->asset_no,
												$v->disposal_date,
												$v->remarks,
												$user_name,												
												$tag,
								 	    		($v->is_disposed != 0 ? ''  : $confirmed_in_links),
								 	    		($v->is_disposed != 0 ? '' : $reject_links)
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





function asset_transfer_header_list($list = array(),$is_manager = null){
	$CI =& get_instance();
	
			   $CI->make->sDiv(array('id'=>'file-spinner'));
						$CI->make->sDivCol(12,'center',0,array("style"=>'margin-bottom:10px;'));
							$CI->make->sBox('primary',array('div-form'));
								$CI->make->sBoxBody(array('style'=>'height:80px;'));
									$CI->make->sDivRow(array('style'=>'margin:0px 0px;'));
										$CI->make->sDivCol(12,'center',0,array("style"=>'margin-top:5px; margin-bottom:5px;'));
											$thumb = base_url().'img/ajax-loader.gif';
											$CI->make->img($thumb,false,array("border"=>"0"));	
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
					$CI->make->eDivCol();	
				$CI->make->eDiv();
				
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'');
								//$CI->make->A(fa('fa-plus').' Add New Asset',base_url().'asset/new_asset',array('class'=>'btn btn-primary'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
						
							$CI->make->sDivCol(12,'');
								$th = array(
										'Asset Transfer #' =>array('align'=>'center'),
										'Asset Type' =>array('align'=>'center'),
										'Asset No'=> array('align'=>'center'),
										'Description'=>array('align'=>'center'),
										'Out'=>array('align'=>'center'),
										'In'=> array('align'=>'center'),
										'Acknowledge'=>array('width'=>'5%','align'=>'center')
										);
								$rows = array();
									
									
									
								foreach($list as $v){
									// $tag = '';
									// $view = $approve ="";
									// $username = $CI->asset_model->get_username($v->user_id);
									// if($v->status == 1){
											// $tag = " <span class='label label-warning'>FOR APPROVAL</span>";
									// }else if($v->status == 2){
											// $tag .= " <span class='label label-success'>APPROVED</span>";
									// }else{
											// $tag .=" <span class='label label-info'>ASSIGNED</span></br>";
									// }
									// $assign_btn = $CI->make->A(
													// fa('fa-pencil fa-fw')."Assign Asset",
												// '',
												// array('class'=>'btn btn-info action_btns assign_link',
													// 'ref_desc'=>'modify po',
													// 'id'=>$v->id,
													// 'title'=>'Assign Asset',
													// 'style'=>'cursor: pointer;',
													// 'return'=>'false'));
													
									$header = $CI->make->A(
													'#'.$v->asset_transfer_id,
												'',
												array('class'=>'btn  transfer_header_link',
													'ref_desc'=>'modify po',
													'id'=>$v->asset_transfer_id,
													'title'=>'Assign Asset',
													'style'=>'cursor: pointer;',
													'return'=>'false'));

									
									// $view .= $CI->make->A(fa('fa-eye fa-lg fa-fw'),'',array("return"=>true,"class"=>'view_link',"id"=>$v->id));
									// $department = $CI->asset_model->department_name($v->to_department);
									// $status = '';
									// if($v->status == '1'){
										// $status = $approve_btn;
									// }elseif($v->status == '2'){
										// $status =  $assign_btn;
									// }else{
										// $status = '';
									// }
									$asset_no = $CI->asset_model->get_asset_no_db($v->asset_id);
									$asset_type = $CI->asset_model->get_asset_type($v->asset_type);
									
									$confirmed_in_links = $CI->make->A(
												fa('fa-check-square-o fa-fw')."Confirmed IN",
												'',
												array('class'=>'btn btn-info action_btns confirmed_link',
												'id'=>$v->id,
												'to_department'=>$v->to_department,
												'asset_id'=>$v->asset_id,
												'asset_no'=>$asset_no,
												'description'=>$v->description,
												'asset_type'=>$v->asset_type,
												'branch'=>$v->to_branch,
												'to_branch'=>$v->to_branch,
												'to_unit'=>$v->to_unit,
												'from_branch'=>$v->from_branch,
												'date_in'=>$v->date_in,
												'return'=>'false'));
									
									$no = $CI->make->A(fa('fa-minus fa-lg fa-fw'),'',array("return"=>true));
									
									//$yes = $CI->make->A(fa('fa-check fa-lg fa-fw'),'',array("return"=>true));
										
									$date_out = $v->date_out;
									$date_in = $v->date_in;
									$rows[] = array(
												  $header,
												 $CI->asset_model->get_asset_type( $v->asset_type),
												  $asset_no,
												  $v->description,
												  ($v->out != 0 ? $date_out : $no),
												  ($v->in != 0 ? $date_in : $no),
											      ($v->in != 0 && $v->out != 0 && $v->confirmed_in != 1 ? $confirmed_in_links : '')
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
function asser_list_inquiry_tab($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-mail-forward')."  ASSET LIST INQUIRY"=>array('href'=>'#assetList','class'=>'tab_link','load'=>'asset/request_asset_inquiry_/','id'=>'asset_list_link')
					);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'assetList','class'=>'tab-pane active'));
						$CI->make->eTabPane();
					
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}

function request_asset_inquiry_list($list = array(),$is_manager = null,$emp_no=null,$department_id=null){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'right');
								//$CI->make->A(fa('fa-plus').' Add New Asset',base_url().'asset/new_asset',array('class'=>'btn btn-primary'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
						
							$CI->make->sDivCol();
								$th = array(
										'Request #' =>'',
										'Status' =>'',
										'Date Requested'=>'',
										'Date Needed'=>'',
										'To Branch'=>'',
										'Department'=>'',
										'Requested by'=>'',
										'&nbsp;'=>array('align'=>'center'),
										' '=>array('align'=>'center'));
								$rows = array();
									
									
									
								foreach($list as $v){
									$tag = '';
									$view = $approve ="";
									$username = $CI->asset_model->get_username($v->user_id);

									if($v->status == 1){
											$tag = " <span class='label label-danger'>FOR APPROVAL</span>";
									}else if($v->status == 2){
											$tag = " <span class='label label-warning'>PENDING(ADMIN APPROVAL)</span>";
									}else if($v->status == 3){
											$tag .= " <span class='label label-success'>READY FOR ASSIGNING</span>";
									}else{
											$tag .=" <span class='label label-info'>ASSIGNED AND APPROVED</span></br>";
									}



									$assign_btn = $CI->make->A(
													fa('fa-pencil fa-fw')."Assign Asset",
												'',
												array('class'=>'btn btn-info action_btns assign_link',
													'ref_desc'=>'modify po',
													'id'=>$v->id,
													'title'=>'Assign Asset',
													'style'=>'cursor: pointer;',
													'return'=>'false'));
													
									$approve_btn = $CI->make->A(
													fa('fa-check-square-o fa-fw')."Approve Request",
													'',
												array('class'=>'btn btn-danger action_btns approve_link',
													'ref_desc'=>'modify po',
													'id'=>$v->id,
													'title'=>'Assign Asset',
													'style'=>'cursor: pointer;',
													'return'=>'false'));

									$addminapproval = $CI->make->A(
													fa('fa-check-square-o fa-fw')."Approve Request",
												'',
												array('class'=>'btn btn-success action_btns admin_approve_link',
													'ref_desc'=>'modify po',
													'id'=>$v->id,
													'title'=>'Assign Asset',
													'style'=>'cursor: pointer;',
													'return'=>'false'));

									// $approve .= $CI->make->A(fa('fa-check-square-o fa-lg fa-fw'),'',array("return"=>true,
									 // "class"=>'approve_link',"id"=>$v->id));
									$view .= $CI->make->A(fa('fa-eye fa-lg fa-fw'),'',array("return"=>true,"class"=>'view_link',"id"=>$v->id));
									$department = $CI->asset_model->department_name($v->to_department);
									$branch = $CI->asset_model->get_branch_desc($v->to_branch);
									$r_department_id = $CI->asset_model->get_department_id($v->user_id);

									$status = '';
									if($v->status == '1'){	
										if($is_manager == '1'){

											if($department_id == $r_department_id){
												$status = $approve_btn;
											}
												if($emp_no == '1123' || $emp_no == '68'|| $emp_no == '70'|| $emp_no == '86'|| $emp_no == '85'|| $emp_no == '84'){
													$status =  $addminapproval;
												}

										}
									}elseif($v->status == '2'){
										if($emp_no == '68' || $emp_no == '1123'|| $emp_no == '70'|| $emp_no == '86'|| $emp_no == '85'|| $emp_no == '84')
										$status =  $addminapproval;
									}elseif($v->status == '3'){
										$status =  $assign_btn;
									}else{
										$status = '';
									}
									
									$rows[] = array(
												  $v->id,
												  $tag,
												  $v->date_requested,
												  $v->date_needed,
												  $branch,
												  $department,
												  $username,
												  $view ,
												  $status
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


function build_asset_request_list_form($item=array()){
	$CI =& get_instance();
	
	$CI->make->sDivCol(12,'center',0,array("style"=>''));
		$CI->make->sBox('warning');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
				
									$CI->make->th('Asset Type',array('style'=>''));
									$CI->make->th('Asset No.',array('style'=>''));
									$CI->make->th('Description',array('style'=>''));
									$CI->make->th('Quantity',array('style'=>''));
									$CI->make->th('&nbsp;',array('style'=>''));
								$CI->make->eRow();
								foreach($item as $val){
									$link = "";
									$link .= $CI->make->A(fa('fa-trash fa-lg fa-fw'), '', array(
									'class'=>'btn_delete',
									'ref'=>$val->id,
									'return'=>'false'));
									$CI->make->sRow();
										$asset_no = $CI->asset_model->get_asset_no_db($val->asset_id);
										$CI->make->td($val->asset_type);	
										$CI->make->td(($val->asset_id != '' ? $asset_no : ''));	
										$CI->make->td($val->description);	
										$CI->make->td($val->quantity);	
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


function request_asset_form($item){
	$CI =& get_instance();
		//$CI->make->sDivRow();
		$user = $CI->session->userdata('user');
			$CI->make->sForm("",array('id'=>'asset_request_form'));
				$CI->make->hidden('hidden_user',$user['id']);
				$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
				$CI->make->sDivCol(12,'right', 0, array());
							$CI->make->button(fa('fa-save').' Save Request Asset Details',array('id'=>'save_po_btn', 'style'=>' margin-right: 10px; margin-left: 10px;'),'primary');
							//$CI->make->A(fa('fa-reply').' Go Back','',array('id'=>'back-btn','class'=>'btn'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();	
				//header
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->H(4,"Request Asset Header",array('style'=>'margin-top:0px;margin-bottom:0px;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
						
							$CI->make->sDivCol(4,'left');
								$CI->make->BranchAssetDrop('To Branch','branch_code','','Select Branch.',array('class'=>'rOkay combobox'));
								
							$CI->make->eDivCol();
							
							$CI->make->sDivCol(8,'left');
								
									$CI->make->sDivCol(6,'left');
										$CI->make->AssetDepartmentDrop('Department','department_code','','Select Department.',array('class'=>'rOkay combobox'));
									$CI->make->eDivCol();
									
									$CI->make->sDivCol(6,'left');
											$CI->make->AssetUnitDrop('Unit','unit_code','','Select Unit.',array('class'=>'combobox'));
									$CI->make->eDivCol();
	
							$CI->make->eDivCol();
							
							
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'left');
								$CI->make->sDivCol(4,'left');
									$CI->make->datefield('Date Needed','date_needed',date('m/d/Y'),'',array('class'=>'rOkay'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(8,'left');
									$CI->make->textarea('Remarks','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
								$CI->make->eDivCol();
							$CI->make->eDivCol();
						$CI->make->eDivRow();
				
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
				
			$CI->make->sDivRow();
			
			//line item
			$CI->make->sDivCol(5);
				$CI->make->sBox('warning');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->H(4,"Add Line Asset",array('style'=>'margin-top:0px;margin-bottom:0px;'));
								$CI->make->append('<hr style="margin-top:5px;margin-bottom:10px"/>');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'left');
								$CI->make->AssetTypeDrop('Asset Type','asset_type','','Select Type.',array('class'=>' asset_type_drop_c  combobox'));
								$CI->make->sDivCol('','left',0,array('id'=>'asset-div'));
									$CI->make->AssetNoDrop('Asset Number','','','Select Asset No.',array('class'=>' combobox'));
								$CI->make->eDivCol();
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(6,'left');
								$CI->make->input('Descripiton','description','','Descripiton',array('class'=>''));														
							$CI->make->eDivCol();
							
							$CI->make->sDivCol(6,'left');
								$CI->make->input('Quantity','quantity','1','Quantity',array('class'=>' numbers-only'));													
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'left');
								$CI->make->button(fa('fa-plus').'ADD',array('id'=>'add-btn','class'=>'btn-block'),'primary');													
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
			
			
			$CI->make->sDivCol(7);
				$CI->make->sDiv(array('id'=>'asset_request_item_contents', 'style'=>'height: 350px; overflow-x: none; overflow-y: scroll;'));
				$CI->make->sDivCol(12,'center',0,array("style"=>''));
					$CI->make->sBox('warning');
						$CI->make->sBoxBody();
							$CI->make->sDivRow();
								$CI->make->sDivCol();
									$CI->make->sDiv(array('class'=>'table-responsive'));
										$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
											$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
							
												$CI->make->th('Asset Type',array('style'=>''));
												$CI->make->th('Asset No.',array('style'=>''));
												$CI->make->th('Description',array('style'=>''));
												$CI->make->th('Quantity',array('style'=>''));
												$CI->make->th('&nbsp;',array('style'=>''));
											$CI->make->eRow();
											foreach($item as $val){
												$link = "";
												$link .= $CI->make->A(fa('fa-trash fa-lg fa-fw'), '', array(
												'class'=>'btn_delete',
												'ref'=>$val->id,
												'return'=>'false'));
												$CI->make->sRow();
													$asset_no = $CI->asset_model->get_asset_no_db($val->asset_id);
													$CI->make->td($CI->asset_model->get_asset_type($val->asset_type));	
													$CI->make->td($val->asset_id != '' ? $asset_no : '');	
													$CI->make->td($val->description);	
													$CI->make->td($val->quantity);	
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
			$CI->make->eDiv();
		$CI->make->eDivCol();
				
			$CI->make->eDivRow();
			
			
			
			
			$CI->make->eForm();
		//$CI->make->eDivRow();
	return $CI->make->code();
}

//asset_reload
function reload_asset_type($results)
{
	$CI =& get_instance();
		$CI->make->reloadedAssetNoDrop('Asset Number','asset_no',null,'Asset Number',array('class'=>'asset_no_drop_c combobox'), $results); //-----EMPTY

	return $CI->make->code();

}


	function asset_request_list_form($ref = null,$item){
	$CI =& get_instance();
	
	$CI->make->sDivCol(12,'center',0,array("style"=>''));
		$CI->make->sBox('warning');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									$CI->make->th('Asset Type',array('style'=>''));
									$CI->make->th('Asset No',array('style'=>''));
									$CI->make->th('Descripiton',array('style'=>''));
									$CI->make->th('Quantity',array('style'=>''));
									$CI->make->th('&nbsp;',array('style'=>''));
								$CI->make->eRow();
								foreach($item as $val){
									$link = "";
									$link .= $CI->make->A(fa('fa-trash fa-lg fa-fw'), '', array(
									'class'=>($mode == 'add' ? 'del_this_item' : 'upd_del_this_item'),
									'ref'=>$val->id,
									'title'=>'Delete this item?',
									'style'=>'cursor: pointer;',
									'return'=>'false'));
									$CI->make->sRow();
										$CI->make->td($CI->asset_model->get_asset_type($val->asset_type));		
										$CI->make->td($val->asset_id);	
										$CI->make->td($val->descripiton);	
										$CI->make->td($val->quantity);	
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


function new_asset_form($item = null){
	$CI =& get_instance();
			$CI->make->sDivRow();
	//echo iSetObj($item,'branch').'----------';
				$CI->make->sDivCol();
					$CI->make->sForm("asset/asset_new_db",array('id'=>'asset_form_upload','enctype'=>'multipart/form-data'));
					
					$CI->make->sBox('primary');
							$CI->make->sBoxBody();
								$CI->make->hidden('asset_id',iSetObj($item,'id'));
								//$CI->make->sDivRow();
									// $CI->make->sDivCol(4,'center');
									// $CI->make->eDivCol();
									// $CI->make->sDivCol(4,'center');
									// $CI->make->AssetNoDrop('Asset Number','asset_no','','Select Asset No.',array('class'=>'rOkay combobox'));
									// $CI->make->eDivCol();
									// $CI->make->sDivCol(4,'center');
									// $CI->make->eDivCol();
								//$CI->make->eDivRow();
								//$CI->make->append('<hr class="style-two" style="margin-top: 10px;"/>');
								
								$CI->make->sDivRow();
								
									$CI->make->sDivCol(12,'left');
										$CI->make->A(fa('fa-reply').' GO BACK',base_url().'asset/new_asset_list',array('id'=>'back-form','class'=>'pull-right btn btn-info'),'success');
									$CI->make->eDivCol();
									
									 $CI->make->sDivCol(3,'left');
									 
										$CI->make->BranchAssetDrop('Branch','branch_code',iSetObj($item,'branch_code'),'Select Branch.',array('class'=>' combobox'));
										$CI->make->AssetTypeDrop('Asset Type','asset_type',iSetObj($item,'asset_type'),'Select Type.',array('class'=>' combobox'));
										$CI->make->AssetDivisionDrop('Division','division_code',iSetObj($item,'division_code'),'Select Division.',array('class'=>' combobox'));
										$CI->make->AssetDepartmentDrop('Department','department_code',iSetObj($item,'department_code'),'Select Department.',array('class'=>' combobox'));
										$CI->make->AssetUnitDrop('Unit','unit_code',iSetObj($item,'unit_code'),'Select Unit.',array('class'=>'combobox'));
									 $CI->make->eDivCol();
									 
									$CI->make->sDivCol(3,'left');
										$CI->make->datefield('Acquired Date','acquired_date',date('m/d/Y'),'',array('class'=>'rOkay'));
										$CI->make->input('Asset No.<font color=red> EX : (HO OSE 200  250 251 0002)	Asset Format is must</font>','ui_asset_no',iSetObj($item,'asset_no'),'Assign Manual Asset Number',array('class'=>''));
										$CI->make->input('Supplier','supplier',iSetObj($item,'supplier'),'Supplier',array('class'=>''));
										$CI->make->input('Invoice No','invoice',iSetObj($item,'invoice'),'Invoice No.',array('class'=>''));
										$CI->make->input('Asset Name','asset_name',iSetObj($item,'item_description'),'Asset Name',array('class'=>'rOkay'));
									$CI->make->eDivCol();
									
								$CI->make->sDivCol(6,'left');
									$CI->make->sDivCol(6,'left');
										$CI->make->input('Serial No','serial_no',iSetObj($item,'serial_no'),'Serial No',array('class'=>''));
										$CI->make->input('Acquisition Cost','acquisition_cost',iSetObj($item,'acquisition_cost'),'Acquisition Cost',array('class'=>'rOkay forms numbers-only'));
										//$CI->make->input('Assign To','assign_to',iSetObj($item,'assign_to'),'Assign To',array('class'=>''));
										$CI->make->srspsusers('Assign To','assign_to',iSetObj($item,'assign_to'),'Assigned Person.',array('class'=>'rOkay combobox'));
									//	$CI->make->input('Assign To','assign_to',iSetObj($item,'assign_to'),'Assign To',array('class'=>''));
										$CI->make->input('Life Span (YEARS)','life_span',iSetObj($item,'life_span'),'Life Span (YEARS)',array('class'=>'rOkay numbers-only'));
									$CI->make->eDivCol();
									

									$CI->make->sDivCol(6,'left');
										$CI->make->input('Remaining Life (MONTHS)','remaining',iSetObj($item,'remaining_life'),'Remaining Life (MONTHS)',array('class'=>'rOkay numbers-only'));
										$CI->make->textarea('Specification','specification',iSetObj($item,'specification'),'Specification', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
										$CI->make->textarea('Remarks','remarks',iSetObj($item,'asset_remarks'),'Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));																				
									$CI->make->eDivCol();
									
									$CI->make->sDivRow();
											$CI->make->sDivCol(12,'center');
												$CI->make->input('Next Asset Number.','next_asset_no','','',array('class'=>'','readonly'=>'readonly','style'=>' border:1; color:red; text-align:center; font-size:150%; height:100%; font-weight: 900; font-family:verdana;'));
											$CI->make->eDivCol();
										$CI->make->eDivRow();
										
								$CI->make->eDivCol();
								
									$CI->make->sDivRow();
											$CI->make->sDivCol(4,'center');
											$CI->make->eDivCol();
											$CI->make->sDivCol(4,'center');
												$CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
											$CI->make->eDivCol();
											$CI->make->sDivCol(4,'center');
											$CI->make->eDivCol();
									$CI->make->eDivRow();
									
									// $CI->make->sDivCol(3,'left');
										// $CI->make->datefield('Acquired Date','acquired_date',date('m/d/Y'),'',array('class'=>'rOkay'));
										// $CI->make->input('Asset No.','ui_asset_no',iSetObj($item,'asset_no'),'Asset No',array('class'=>''));
										// $CI->make->input('Supplier','supplier',iSetObj($item,'supplier'),'Supplier',array('class'=>''));
										// $CI->make->input('Invoice No','invoice',iSetObj($item,'invoice'),'Invoice No.',array('class'=>''));
										// $CI->make->input('Asset Name','asset_name',iSetObj($item,'item_description'),'Asset Name',array('class'=>'rOkay'));
									// $CI->make->eDivCol();
									
									// $CI->make->sDivCol(3,'left');
										// $CI->make->input('Serial No','serial_no',iSetObj($item,'serial_no'),'Serial No',array('class'=>''));
										// $CI->make->input('Acquisition Cost','acquisition_cost',iSetObj($item,'acquisition_cost'),'Acquisition Cost',array('class'=>'rOkay forms numbers-only'));
										// $CI->make->input('Assign To','assign_to',iSetObj($item,'assign_to'),'Assign To',array('class'=>''));
										// $CI->make->textarea('Specification','specification',iSetObj($item,'specification'),'Specification', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
										// $CI->make->textarea('Remarks','remarks',iSetObj($item,'asset_remarks'),'Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255'));
									// $CI->make->eDivCol();
									
									// $CI->make->sDivCol(6,'left');
										// $CI->make->sDivRow();
										
											// $CI->make->sDivCol(6,'left');
													// $CI->make->input('Life Span (YEARS)','life_span',iSetObj($item,'life_span'),'Life Span (YEARS)',array('class'=>'rOkay numbers-only'));
													// $CI->make->input('Remaining Life (MONTHS)','remaining',iSetObj($item,'remaining_life'),'Remaining Life (MONTHS)',array('class'=>'rOkay numbers-only'));
													// $CI->make->BranchAssetDrop('Branch','branch_code',iSetObj($item,'branch_code'),'Select Branch.',array('class'=>'rOkay combobox'));
													// $CI->make->AssetTypeDrop('Asset Type','asset_type',iSetObj($item,'asset_type'),'Select Type.',array('class'=>'rOkay combobox'));
											// $CI->make->eDivCol();
											
											// $CI->make->sDivCol(6,'left');
												// $CI->make->AssetDivisionDrop('Division','division_code',iSetObj($item,'division_code'),'Select Division.',array('class'=>'rOkay combobox'));
												// $CI->make->AssetDepartmentDrop('Department','department_code',iSetObj($item,'department_code'),'Select Department.',array('class'=>'rOkay combobox'));
												// $CI->make->AssetUnitDrop('Unit','unit_code',iSetObj($item,'unit_code'),'Select Unit.',array('class'=>'combobox'));
											// $CI->make->eDivCol();
										// $CI->make->eDivRow();
										
										// $CI->make->sDivRow();
											// $CI->make->sDivCol(12,'center');
												// $CI->make->append('<hr class="style-two" style="margin-top: 10px;"/>');
											// $CI->make->eDivCol();
										// $CI->make->eDivRow();
										
										// $CI->make->sDivRow();
											// $CI->make->sDivCol(12,'center');
											// $CI->make->button(fa('fa-save').' Save Details',array('id'=>'save-btn','class'=>'btn-block'),'primary');
										// $CI->make->eDivRow();
									// $CI->make->eDivCol();
									
								$CI->make->eDivRow();
								
							$CI->make->eBoxBody();
						$CI->make->eBox();
						
						// $CI->make->sBox('success',array());
							// $CI->make->sBoxBody();
							
							// $CI->make->eBoxBody();
						// $CI->make->eBox();
						
					$CI->make->eForm();
				$CI->make->eDivCol();
			$CI->make->eDivRow();
	return $CI->make->code();

}
function asset_file_uploader_form(){
	$CI =& get_instance();
			$CI->make->sDivRow();
				$CI->make->sDivCol();
					$CI->make->sBox('primary');
						$CI->make->sBoxBody();
							$CI->make->sForm(" ",array('id'=>'asset_form_upload','enctype'=>'multipart/form-data'));
								$CI->make->sDivRow();
									$CI->make->sDivCol(12,'right');
										//$CI->make->A(fa('fa-plus').'Download Asset Uploader Template',base_url().'template/Asset Upload Template.csv',array('class'=>'btn btn-primary'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(3,'right');
									$CI->make->eDivCol();
									$CI->make->sDivCol(3,'right');
										$CI->make->file('asset_file',array("id"=>"asset_file"));
									$CI->make->eDivCol();
									$CI->make->sDivCol(3,'left');
										$CI->make->button(fa('fa-save').'Upload File',array('id'=>'save-btn','class'=>'pull-btn-info'),'primary');
									$CI->make->eDivCol();
									$CI->make->sDivCol(3,'right');
										 $CI->make->hidden('uploader','hhhhhhh');
									$CI->make->eDivCol();
								$CI->make->eDivRow();
							$CI->make->eForm();
						$CI->make->eBoxBody();
					$CI->make->eBox();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
	
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
	//var_dump($item);
	
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
function asser_transfer_tab($_id=null){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->hidden('tab_id',$_id);
			$CI->make->sTab();
					$tabs = array(
						fa('fa-mail-forward')."  ASSET TRANSFER LIST"=>array('href'=>'#assetTransfer','class'=>'tab_link','load'=>'asset/asset_transfer_/','id'=>'asset_transfer_link')
					);
					$CI->make->tabHead($tabs,null,array());
					$CI->make->sTabBody();
						$CI->make->sTabPane(array('id'=>'assetTransfer','class'=>'tab-pane active'));
						$CI->make->eTabPane();
					
					$CI->make->eTabBody();
				$CI->make->eTab();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function asset_transfer($list = array(),$is_manager = null){
	$CI =& get_instance();
	//echo var_dump($list);
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
							$CI->make->sDivCol(12,'center');
								//$CI->make->A(fa('fa-plus').' Add New Asset',base_url().'asset/new_asset',array('class'=>'btn btn-primary'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
						$CI->make->sDivRow();
						
							$CI->make->sDivCol(12);
								$th = array(
										'Asset Transfer #' =>'',
										'From Branch' =>'',
										'To Branch'=>'',
										'To Department'=>'',
										'To Unit'=>'',
										'Assigned By'=>'',
										'Date Requested'=>'', 
										'&nbsp;' => array('text-align'=>'center'),
										'&nbsp;&nbsp;' => array('text-align'=>'center'));
								$rows = array();
									
									
									
								foreach($list as $v){
									$out_btn = $CI->make->A(
											fa('fa-share fa-fw')." Transfer Out",
											'',
											array('class'=>'btn btn-success action_btns out_link',
											'ref_desc'=>'modify po',
											'id'=>$v->id,
											'title'=>'Transfer Out',
											'style'=>'cursor: pointer;',
											'return'=>'false'));
											
									$translip = $CI->make->A(
											fa('fa-print fa-fw')." Transfer Slip",
											'',
											array('class'=>'btn btn-warning action_btns translip_link',
											'ref_desc'=>'modify po',
											'id'=>$v->id,
											'title'=>'Transfer Out',
											'style'=>'cursor: pointer;',
											'return'=>'false'));
											
									$in_btn = $CI->make->A(
											fa('fa-reply fa-fw')." Transfer In",
											'',
											array('class'=>'btn btn-info action_btns in_link',
											'ref_desc'=>'modify po',
											'id'=>$v->id,
											'title'=>'Transfer Out',
											'style'=>'cursor: pointer;',
											'return'=>'false'));
											
									$header = $CI->make->A(
													'#'.$v->id,
												'',
												array('class'=>'btn  transfer_header_link',
													'ref_desc'=>'modify po',
													'id'=>$v->id,
													'title'=>'Assign Asset',
													'style'=>'cursor: pointer;',
													'return'=>'false'));
									
									
									$cancel_btn = $CI->make->A(
											fa('fa-minus fa-fw')." Cancel",
											'',
											array('class'=>'btn btn-danger action_btns cancel_link',
											'ref_desc'=>'modify po',
											'id'=>$v->id,
											'title'=>'Transfer Out',
											'style'=>'cursor: pointer;',
											'return'=>'false'));
									$in = $CI->asset_model->get_asset_transfer_details_in($v->id);
									$out = $CI->asset_model->get_asset_transfer_details_out($v->id);
									$with_out = $CI->asset_model->get_asset_transfer_details_with_out($v->id);
								//	echo $with_out;
									$rows[] = array(
												  $header,
												  $CI->asset_model->get_branch_desc($v->from_branch),
												  $CI->asset_model->get_branch_desc($v->to_branch),
												  $CI->asset_model->department_name($v->to_department),
												  ($v->to_unit == '' ? '' : $CI->asset_model->unit_name($v->to_unit)),
												  $CI->asset_model->get_username($v->assigned_by),
												  $v->date_needed,
												 // ($out == 0 ? '':$out_btn),
												  ($out == 0 ? ($v->reprint == 1 ? '' : $translip) : $out_btn),
												  ($in == 0 ? '':($with_out >= 1 ? $in_btn:''))
												//  ($v->from_branch != BRANCH ? '' :($out == 0 ? '':$out_btn)), 
												 // ($v->to_branch != BRANCH ? '' :($in == 0 ? '':($with_out >= 1 ? $in_btn:'')))											  
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
function asset_transfer_out_form($id, $item=array(), $sub_item=array(), $results=array()){
	$CI =& get_instance();
		//$CI->make->sDivRow();
		$user = $CI->session->userdata('user');
			$CI->make->sForm("",array('id'=>'asset_request_form'));
				$CI->make->hidden('hidden_user',$user['id']);
				$CI->make->sDivRow(array('style'=>'margin-bottom:10px;'));
				$CI->make->sDivCol(12,'right', 0, array());
							//$CI->make->button(fa('fa-save').' Save Request Asset Details',array('id'=>'save_po_btn', 'style'=>' margin-right: 10px; margin-left: 10px;'),'primary');
							//$CI->make->A(fa('fa-reply').' Go Back','',array('id'=>'back-btn','class'=>'btn'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
		
				//header
				$CI->make->sBox('primary');
					$CI->make->sBoxBody();
						$CI->make->sDivRow();
						
							$CI->make->sDivCol(6,'left');
								$CI->make->sDivCol(3);
									$CI->make->input('Asset Transfer ID','trans_id',$item->id,'',array('class'=>'','disabled'=>'disabled'));
										$CI->make->hidden('hidden_trans_id',$item->id);
								$CI->make->eDivCol();
								$CI->make->sDivCol(4,'left');
									$CI->make->BranchAssetDrop('From Branch','from_branch_code',$item->from_branch,'Select Branch.',array('class'=>'rOkay combobox','disabled'=>'disabled'));	
								$CI->make->eDivCol();
								$CI->make->sDivCol(5,'left');
								$CI->make->BranchAssetDrop('To Branch','to_branch_code',$item->to_branch,'Select Branch.',array('class'=>'rOkay combobox','disabled'=>'disabled'));	
								$CI->make->eDivCol();
							$CI->make->eDivCol();
							
							$CI->make->sDivCol(6,'left');
								$CI->make->sDivCol(6,'left');
									$CI->make->AssetDepartmentDrop('Department','department_code',$item->to_department,'Select Department.',array('class'=>'rOkay combobox','disabled'=>'disabled'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(6,'left');
										$CI->make->AssetUnitDrop('Unit','unit_code',$item->to_unit,'Select Unit.',array('class'=>'combobox','disabled'=>'disabled'));
								$CI->make->eDivCol();
							$CI->make->eDivCol();
							
							
							$CI->make->sDivRow();
								$CI->make->sDivCol(12,'left');
									$CI->make->sDivCol(4);
										$CI->make->datefield('Date Needed','date_needed',date('m/d/Y', strtotime($item->date_needed)),'',array('class'=>'rOkay','disabled'=>'disabled'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(3);
										$CI->make->input('Created By','created_by',$CI->asset_model->get_username($item->assigned_by),'',array('class'=>'','disabled'=>'disabled'));
									$CI->make->eDivCol();
									$CI->make->sDivCol(5);
										$CI->make->textarea('Remarks','remarks','','Remarks', array('style'=>'resize:vertical; height: 60px;','maxchars'=>'255','disabled'=>'disabled'));
									$CI->make->eDivCol();
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eDivRow();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			
			$CI->make->sDivRow();
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
				
				$CI->make->sDivCol(4);
					$CI->make->sBox('warning');
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									$CI->make->th('Asset Type',array('style'=>''));
									$CI->make->th('Descripton',array('style'=>''));
								$CI->make->eRow();
								foreach($sub_item as $sub_vals){
								$CI->make->sRow();
									$CI->make->td( $CI->asset_model->get_asset_type($sub_vals->asset_type));	
									$CI->make->td($sub_vals->description);	
								$CI->make->eRow();
								}
							$CI->make->eTable();
						$CI->make->eDiv();
					$CI->make->eBox();
				
				$CI->make->eDivCol();
				
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
			$CI->make->eDivRow();
			
			$CI->make->sDivRow();
			
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
				$CI->make->sDivCol(4,'center');
					$CI->make->input('Asset #:','asset_no','','',array('class'=>''));
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
				
			$CI->make->eDivRow();
			
			$CI->make->sDivRow();
			
				$CI->make->sDivCol(2);
				$CI->make->eDivCol();
				$CI->make->sDivCol(8,'center');
					$CI->make->sDiv(array('id'=>'line_item_contents_div'));	
						$CI->make->sDivCol();
							$CI->make->sBox('warning');
								$CI->make->sBoxBody();
									$CI->make->sDivRow();
										$CI->make->sDivCol();
											$CI->make->sDiv(array('class'=>'table-responsive'));
												$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
													$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
														$CI->make->th('Asset Type',array('style'=>''));
														$CI->make->th('Asset #',array('style'=>''));
														$CI->make->th('Descripiton',array('style'=>''));
													$CI->make->eRow();
													foreach($results as $val){
														$CI->make->sRow();
																$CI->make->td($CI->asset_model->get_asset_type($val->type));	
																$CI->make->td($val->asset_no);	
																$CI->make->td($val->description);	
															$CI->make->eRow();
													}
												$CI->make->eTable();
											$CI->make->eDiv();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
						$CI->make->eDivCol();
					$CI->make->eDiv();
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
				$CI->make->eDivCol();
				
						
				
				
			// $CI->make->sDivRow();
				// $CI->make->sDivCol(4);
				// $CI->make->eDivCol();
				// $CI->make->sDivCol(4,'center');
				
						// if($results != null){
								// $CI->make->button(fa('fa-refresh').' Process',array('id'=>'process_btn', 'style'=>' margin-top: 25px;'),'primary');
								// $CI->make->button(fa('fa-minus').' Cancel',array('id'=>'cancel_btn', 'style'=>' margin-top: 25px;margin-left: 25px;'),'danger');
							// }
				// $CI->make->eDivCol();
				// $CI->make->sDivCol(4);
				// $CI->make->eDivCol();
			// $CI->make->eDivRow();
			
			// $CI->make->eDivRow();
			
			// $CI->make->sDivRow();
			
				$CI->make->sDivCol(2);
				$CI->make->eDivCol();
				$CI->make->sDivCol(8,'center');
					$CI->make->sDiv(array('id'=>'line_item_contents'));	
					$CI->make->eDiv();
				$CI->make->eDivCol();
				$CI->make->sDivCol(2);
				$CI->make->eDivCol();
				
			$CI->make->eDivRow();
			$CI->make->sDivRow();
			
			
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
				$CI->make->sDivCol(4,'center');
					$CI->make->sDiv(array('id'=>'buttons'));
						$CI->make->button(fa('fa-refresh').' Process',array('id'=>'process_btn', 'style'=>' margin-top: 25px;'),'primary');
						$CI->make->button(fa('fa-minus').' Cancel',array('id'=>'cancel_btn', 'style'=>' margin-top: 25px;margin-left: 25px;'),'danger');
					$CI->make->eDiv();
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
				$CI->make->eDivCol();
				
			$CI->make->eDivRow();
			

				

			$CI->make->eForm();
		//$CI->make->eDivRow();
	return $CI->make->code();
}
function build_list_form($item=array(),$ref=null,$trans_id=null){
	$CI =& get_instance();
	
	$CI->make->sDivCol();
		$CI->make->sBox('warning');
			$CI->make->sBoxBody();
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sDiv(array('class'=>'table-responsive'));
							$CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
								$CI->make->sRow(array('style'=>'background-color: #EEEEEE;'));
									$CI->make->th('Asset Type',array('style'=>''));
									$CI->make->th('Asset #',array('style'=>''));
									$CI->make->th('Descripiton',array('style'=>''));
								$CI->make->eRow();
								foreach($item as $val){
									$CI->make->sRow();
											$CI->make->td($CI->asset_model->get_asset_type($val->type));	
											$CI->make->td($val->asset_no);	
											$CI->make->td($val->description);	
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


//-----------Branch References-----end-----allyn


?>