<script>
	$(document).ready(function(){
		
		//////////############## functions Start ####################///////////
			
		function enable_button(my_btn, my_btn_text, old_icon, new_icon, old_class, new_class)
		{
			my_btn.removeAttr('disabled');
			my_btn.html("<i class='fa "+new_icon+" fa-lg'></i> "+my_btn_text);
			my_btn.addClass(new_class);
			my_btn.removeClass(old_class+' '+old_icon);
		}
		
		function disable_button(my_btn, btn_class)
		{
			my_btn.attr({'disabled' : 'disabled'});
			my_btn.addClass('btn-danger');
			my_btn.removeClass(btn_class);
			// my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
		}
		

		
		function clear_line_asset_form(){
			$('.asset_type_drop_c').attr({'value' : ''}).val('');
			$('.asset_no_drop_c').attr({'value' : ''}).val('');
			$('#asset_type').val('');
			$('#asset_no').val('');
			$('#description').val('');
			$('#quantity').val('');
			
		}
		
		function load_asset_request_list(){
			
			var ref = $('#hidden_user').val();
			var post_url = '<?php echo base_url(); ?>asset/load_asset_request_list';
			$.post(post_url, {'ref' : ref}, function(data){
				$('#asset_request_item_contents').html(data);
				return false;
			});
		}
		
		function reload_asset_type(){
			var asset_type =  $('#asset_type').val();
			//alert(branch_id);
			var dtr_url = '<?php echo base_url(); ?>asset/reload_asset_type_drop';
			$.post(dtr_url, {'asset_type' : asset_type}, function(data){
				//$('#counter-div').hide();
				//$('#reload-counter-div').show();
				$('#asset-div').html(data);
				//alert(data);
				return false;
			});
		}
		
		function delete_req_list_temp(ref){
			var dtr_url = '<?php echo base_url(); ?>asset/delete_asset_req_temp';
			$.post(dtr_url, {'ref' : ref}, function(data){
			});
		}
		function load_transfer_items(){
			var ref = $('#hidden_user').val();
			var transid = $('#hidden_trans_id').val();
				
			var dtr_url = '<?php echo base_url(); ?>asset/load_transfer_items';
			$.post(dtr_url, {'ref' : ref,'transid':transid}, function(data){
			//alert(data);
				$('#line_item_contents').html(data);
					return false;
				});
			}
		
		function checkAssetOut(){
			var asset_no = $('#asset_no').val();
			var trans_id = $('#trans_id').val();
			loader_url = baseUrl + 'asset/check_details_temp';
			$.post(loader_url, {'asset_no' : asset_no, 'trans_id':trans_id}, function(data){	
				if(data != ''){
					rMsg(data, 'warning');				
					$('#asset_no').attr({'value' : ''}).val('');
					$('#asset_no').focus();	
				}else{
					loader_url = baseUrl + 'asset/get_asset_no_id_out';
					$.post(loader_url, {'asset_no' : asset_no, 'trans_id':trans_id}, function(data){
					 if(data != ''){
							rMsg('Successfully Added.', 'success');
					 }else{
							rMsg('Items not include.', 'warning');				
					 }
						$('#asset_no').attr({'value' : ''}).val('');
						$('#asset_no').focus();	
					});
				}
			});
		}
		function load_transfer_items_in(){
			var ref = $('#hidden_user').val();
			var hidden_trans_id = $('#hidden_trans_id').val();
				
			var dtr_url = '<?php echo base_url(); ?>asset/load_transfer_items_in';
			$.post(dtr_url, {'ref' : ref,'hidden_trans_id':hidden_trans_id}, function(data){
			//alert(data);
				$('#line_item_contents').html(data);
					return false;
				});
			}
		
		function checkAssetIn(){
			var asset_no = $('#asset_no').val();
			var trans_id = $('#hidden_trans_id').val();
			
			loader_url = baseUrl + 'asset/check_details_temp';
			$.post(loader_url, {'asset_no' : asset_no, 'trans_id':trans_id}, function(data){	
				if(data != ''){
					rMsg(data, 'warning');				
					$('#asset_no').attr({'value' : ''}).val('');
					$('#asset_no').focus();	
				}else{
					loader_url = baseUrl + 'asset/get_asset_no_id_in';
					$.post(loader_url, {'asset_no' : asset_no, 'trans_id':trans_id}, function(data){
						 if(data != ''){
								rMsg('Successfully Added.', 'success');
						 }else{
								rMsg('Items not include.', 'warning');
						 }
							$('#asset_no').attr({'value' : ''}).val('');
							$('#asset_no').focus();	
					});
				}
			});
		}
		
		
		
		
		//////////############## functions End ####################///////////
		
		<?php if($use_js == 'assetJS'): ?>
		
		
		//alert($('#count').val());
		
	
		
		$('#save-btn').click(function(){
			
			uploader = $('#uploader').val();
			
			$.post(baseUrl+'asset/asset_file_upload/', {'uploader':uploader}, function(data){
				
			});
		});
		
		<?php elseif($use_js == 'DisposalInqTabJS'):?>
			$('.tab_link').click(function(){
				var id = $(this).attr('id');
				loader('#'+id);
			});
			var data = $('#tab_id').val();
		
			$('.tab_link').parent().removeClass('active');
			var link;
			var tab;
			if(data){
				 link  = '#'+data+'_link';
				 tab  = '#'+data;
			}else{
				link = '#asset_disposal_list_link';
				tab = '#assetdisposalList';
				
			}
			//alert(link);
			loader(link);
			function loader(btn){
				var loadUrl = $(btn).attr('load');
				var tabPane = $(btn).attr('href');
				$(tabPane).rLoad({url:baseUrl+loadUrl});
			}
			
			$(tab).addClass('active');
			$(link).parent().addClass('active');	








		<?php elseif($use_js == 'transassetInqTabJS'):?>
			$('.tab_link').click(function(){
				var id = $(this).attr('id');
				loader('#'+id);
			});
			var data = $('#tab_id').val();
		
			$('.tab_link').parent().removeClass('active');
			var link;
			var tab;
			if(data){
				 link  = '#'+data+'_link';
				 tab  = '#'+data;
			}else{
				link = '#asset_trans_list_link';
				tab = '#assetTransList';
				
			}
			//alert(link);
			loader(link);
			function loader(btn){
				var loadUrl = $(btn).attr('load');
				var tabPane = $(btn).attr('href');
				$(tabPane).rLoad({url:baseUrl+loadUrl});
			}
			
			$(tab).addClass('active');
			$(link).parent().addClass('active');
			
		<?php elseif($use_js == 'disposalInqJS'):?>

		$('#file-spinner').hide();

		$('.reject_link').click(function(){
			alert('--');

		});


		$('.confirmed_link').click(function(){
				
				var btn = $(this);
			
				var id = $(this).attr('id');
				var asset_no = $(this).attr('asset_no');
				var asset_id = $(this).attr('asset_id');
				var disposal_date = $(this).attr('disposal_date');
				

				//alert(id + '--' + asset_id + '--' + disposal_date);
				
				var post_url = baseUrl+'asset/process_asset_disposal';
				$.post(post_url, {'id':id,'asset_no':asset_no,'asset_id':asset_id,'disposal_date':disposal_date}, function(data){
					
					//alert(data);
					 rMsg('success','success');
					 setTimeout(function(){
					  window.location = baseUrl+'asset/asset_disposal_inquiry';
					},1500);
					
				});
				
				return false;
				
			});
			





		<?php elseif($use_js == 'transassetInqJS'):?>
		
			$('#file-spinner').hide();
			 
			$('.confirmed_link').click(function(){
				
				//$('#file-spinner').show();
				var btn = $(this);
				disable_button(btn, 'btn-primary');
				$('.history_link').hide();
				
				var id = $(this).attr('id');
				var asset_id = $(this).attr('asset_id');
				var asset_no = $(this).attr('asset_no');
				var description = $(this).attr('description');
				var branch = $(this).attr('branch');
				var asset_type = $(this).attr('asset_type');
				var to_department = $(this).attr('to_department');
				var to_branch = $(this).attr('to_branch');
				var to_unit = $(this).attr('to_unit');
				var from_branch = $(this).attr('from_branch');
				var date_in = $(this).attr('date_in');


				//alert(id +'--'+asset_id+'--'+asset_no+'--'+description+'--'+branch+'--'+asset_type+'--'+to_department+'--'+to_branch+'--'+to_unit+'--'+from_branch+'--'+date_in);
				
			
			var post_url = baseUrl+'asset/confirmed_in';
				$.post(post_url, {'id':id,'asset_no':asset_no,'description':description,'branch':branch,'asset_type':asset_type,'asset_id':asset_id,'to_department':to_department,'to_branch':to_branch,'from_branch':from_branch,'date_in':date_in,'to_unit':to_unit}, function(data){
					data = data.replace(/\s/g, '');
					if(data == 'success'){
						rMsg('Asset Confirmed IN.','success');
						 window.location = baseUrl+'asset/asset_transfer_inquiry';
						
					}
					
					
				});
				
				return false;
				
			});
			
			
			$('.transfer_header_link').click(function(){
			var id = $(this).attr('id');
				bootbox.dialog({
					className: "bootbox-fwide",
					message: baseUrl+'asset/asset_transfer_details_view/'+id,
					title: "Asset Transfer Details",
					buttons: {
						cancel: {
							label: "Close",
							className: "btn-default",
							callback: function() {
								
							}
						}
					}
				});
				return false;
				
			});
			
		<?php elseif($use_js == 'reloadAssetTypeJs'):?>

			$('.asset_no_drop_c').change(function(){
			    var test = $(this).attr('ref');
				var count = $('#count').val();
					// alert(count);
				if(count >= 1){
				 for(i = 1; i <=count ; i++){
					if(i != test){
						//alert($('#asset_no_'+i).val());
						if($('#asset_no_'+i).val() == $('#asset_no_'+test).val()){
							rMsg('Asset Double Entry','warning');
							$('#asset_no_'+test).clear();
							
						} 
						
					}
				 }
					//$('#count').val();
				}
			// var test = $(this).attr('ref');
				// if($('#asset_no_'+test).val() != ''){
			// asset.push($('#asset_no_'+test).val());
				// }else{
					// asset.pop();
				// }
			// alert($('#asset_no_'+test).val());
			// alert(asset);
			});
		
		$('#asset_no').change(function(){
		//	alert();
			$('#quantity').val(1);
			var asset_id = $('#asset_no').val();
			
			var post_url = baseUrl+'asset/get_asset_descripiton';
			$.post(post_url, {'asset_id':asset_id}, function(data){		 	
				$('#description').val(data);
			});			
		});
		
	<?php elseif($use_js == 'reloadAssetItemsJS'):?>
		
			$('.btn_delete').click(function(){
				var ref = $(this).attr('ref');
				delete_req_list_temp(ref);
				load_asset_request_list();
			});

		
		
	<?php elseif($use_js == 'assignAssetJS'): ?>
		$("[data-toggle='offcanvas']").click(); //hide main menu sa side
	//alert('lllll');
		function reload_asset_branch_h(counter){
			var branch =  $('#branch_code_'+counter).val();
			//alert(branch_id);
			var dtr_url = '<?php echo base_url(); ?>asset/reload_asset_branch_drop';
			$.post(dtr_url, {'branch' : branch,'counter' : counter}, function(data){
				//$('#counter-div').hide();
				//$('#reload-counter-div').show();
				$('#asset-div'+counter).html(data);
				//alert(data);
				return false;
			});
		}

	
		
		$('.asset_no_drop_c').change(function(){
			var test = $(this).attr('ref');
			//alert('kkkkkk');
			//alert(test);
			
		});
		
		
		
		
		$('.branch_drop').change(function(){
			var test = $(this).attr('ref');
			var branch_code = $('.branch_drop').val();
			
			reload_asset_branch_h(test);
		//	alert('eklavu : '+test+branch_code);
			
			return false;
		});
		
		
			
	
		$('#btn-process').click(function(){
			var btn = $(this);
			disable_button(btn, 'btn-primary');
			$("#assign_asset_form").rOkay({
				btn_load		: 	$('#save-btn-process'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
				
				
				//alert(data);
				if(data == 1){
					rMsg(' Asset Request has been Assigned','success');
					 setTimeout(function(){
						 window.location = baseUrl+'asset/request_asset_inquiry';
					 },1500);
				}else{
					rMsg('Please assign atleast one requested assets','error');
					enable_button(btn, 'PROCESS', 'fa-circle-o-notch', 'fa-circle-o-notch', 'btn-block',' btn-block')
				}
					

				}
				
			});
			return false;
				
				
				
		});
		
		$('#back-btn').click(function(){
			window.location = baseUrl+'asset/request_asset_inquiry';
		});
		
	
	<?php elseif($use_js == 'ReqassetInqTabJS'): ?>
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		var data = $('#tab_id').val();
	
		$('.tab_link').parent().removeClass('active');
		var link;
		var tab;
		if(data){
			 link  = '#'+data+'_link';
			 tab  = '#'+data;
		}else{
			link = '#asset_list_link';
			tab = '#assetList';
			
		}
		//alert(link);
		loader(link);
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			$(tabPane).rLoad({url:baseUrl+loadUrl});
		}
		
		$(tab).addClass('active');
		$(link).parent().addClass('active');
		
	<?php elseif($use_js == 'ReqassetInqJS'): ?>
	
		$('.assign_link').click(function(){
			var header_id = $(this).attr('id');
			window.location = baseUrl+'asset/assign_asset/'+header_id;
			
		});
		
		$('.approve_link').click(function(){
			var btn = $(this);
			disable_button(btn, 'btn-primary');
			var header_id = $(this).attr('id');
			
			var post_url = baseUrl+'asset/update_request_status';
			$.post(post_url, {'header_id':header_id}, function(data){	
				
				rMsg(' Asset Request has Approved','success');
				setTimeout(function(){
					window.location.reload();
				},1500);
			});
			
		});
		
		$('.admin_approve_link').click(function(){
			var btn = $(this);
			disable_button(btn, 'btn-primary');
			var header_id = $(this).attr('id');
			
			var post_url = baseUrl+'asset/update_request_status_admin';
			$.post(post_url, {'header_id':header_id}, function(data){	
				
				rMsg(' Asset Request has Approved','success');
				setTimeout(function(){
					window.location.reload();
				},1500);
			});
			
		});
		
		$('.view_link').click(function(){
			var id = $(this).attr('id');
			//alert(id);
			
			bootbox.dialog({
				className: "bootbox-fwide",
				message: baseUrl+'asset/request_asset_view/'+id,
				title: "Asset Request",
				buttons: {
					cancel: {
						label: "Close",
						className: "btn-default",
						callback: function() {
							
						}
					}
				}
			});
			return false;
			
		});
	
		
	
	<?php elseif($use_js == 'ReqassetJS'): ?>
	
		$('#asset_type').change(function(){
			
			reload_asset_type()	;
			
		});
		
		
			
		$('#save_po_btn').click(function(){
			//alert('sss');
			var btn = $(this)
			disable_button(btn,'btn-primary');
			var branch_code = $('#branch_code').val();
			var department_code = $('#department_code').val();
			var unit_code = $('#unit_code').val();
			var date_needed = $('#date_needed').val();
			var remarks = $('#remarks').val();
		
			//alert(branch_code+' '+department_code+' '+);
			if(branch_code != '' && department_code != '' &&  date_needed != ''){
			
				
				var post_url = baseUrl+'asset/insert_request_asset_details';
				$.post(post_url, {'branch_code':branch_code,'department_code':department_code,'unit_code':unit_code,'date_needed':date_needed,'remarks':remarks}, function(data){

					if(data == 'err_msg'){
						rMsg("Asset Line Request cannot be null",'warning');
						enable_button(btn,'Save Request Asset Details', 'fa-save', 'fa-save', 'btn-danger', 'btn-primary')
						
					}else{
						rMsg('Request Asset has been added','success');
							setTimeout(function(){
								enable_button(btn,'Save Request Asset Details', 'fa-save', 'fa-save', 'btn-danger', 'btn-primary')
								window.location.reload();
								},1500);
					}
				
				});
			
				return false;
			
			}else{
			
				rMsg("Required Fields cannot be null",'warning');
				enable_button(btn,'Save Request Asset Details', 'fa-save', 'fa-save', 'btn-danger', 'btn-primary')
				return false;
			}
				
				return false;
		
		});
		
		$('.btn_delete').click(function(){
			var ref = $(this).attr('ref');
			delete_req_list_temp(ref);
			load_asset_request_list();
		});
		
		
		$('#add-btn').click(function(){
			
			// var formData = $('#asset_request_form').serialize();
			// alert(formData);
			
			var asset_type = $('#asset_type').val();
			var asset_no = $('#asset_no').val();
			var description = $('#description').val();
			var quantity = $('#quantity').val();
			
			if(asset_type != '' && quantity != 0  && description != ''){
			
				if(asset_no != ''){
					quantity = '1';
				}
					
				var post_url = baseUrl+'asset/insert_request_asset_temp';
				$.post(post_url, {'asset_type':asset_type,'asset_no':asset_no,'description':description,'quantity':quantity}, function(data){
					
					rMsg('Item has been added','success');
					//clear_item_adder_form();
					load_asset_request_list();
					clear_line_asset_form();
					//load_purch_order_items();
					//$('.supp_stock_drop').focus();
					// return false;
				});
				return false;
				}else{
				rMsg("Required Fields cannot be null",'warning');
				$('#asset_type').focus();
				//alert($('#asset_type').val());
			}
			
			return false;
		});
		
		
		<?php elseif($use_js == 'newassetTabJS'): ?>
			$('.tab_link').click(function(){
				var id = $(this).attr('id');
				loader('#'+id);
			});
			var data = $('#tab_id').val();
		
			$('.tab_link').parent().removeClass('active');
			var link;
			var tab;
			if(data){
				 link  = '#'+data+'_link';
				 tab  = '#'+data;
			}else{
				link = '#asset_link';
				tab = '#asset';
				
			}
			//alert(link);
			loader(link);
			function loader(btn){
				var loadUrl = $(btn).attr('load');
				var tabPane = $(btn).attr('href');
				$(tabPane).rLoad({url:baseUrl+loadUrl});
			}
			
			$(tab).addClass('active');
			$(link).parent().addClass('active');
	

	// ______________________________________________________ new lester _________________________________________

		<?php elseif($use_js == 'loadAssetJs'): ?>

			$('.history_link').click(function(){	
				var id = $(this).attr('id');	
				// var asset_no = $(this).attr('asset_no');	
				bootbox.dialog({
					className: "bootbox-wide",
					message: baseUrl+'asset/asset_history_view/'+id,
					title: "Asset History",
					buttons: {
						cancel: {
							label: "Close",
							className: "btn-default",
							callback: function() {
								
							}
						},
						print:{
							label:"Export To Excel",
							className: "btn-success",
							callback: function() {
		   						
		   						window.location = baseUrl+'asset/print_asset_history/'+id;
							}
						}
					}
				});
				return false;
		});

	// ______________________________________________________ new lester _________________________________________
	

		<?php elseif($use_js == 'newassetJS'): ?>
				
		$('#ui_asset_no').keyup(function(){

			if($('#ui_asset_no').val() != ''){
				$('#branch_code').attr('value','disabled');
				$('#asset_type').attr('disabled','disabled');
				$('#division_code').attr('disabled','disabled');
				$('#unit_code').attr('disabled','disabled');
				
			}else{
				$('#branch_code').removeAttr('disabled','disabled');
				$('#asset_type').removeAttr('disabled','disabled');
				$('#division_code').removeAttr('disabled','disabled');
				$('#unit_code').removeAttr('disabled','disabled');
				
			}

		});

	// ______________________________________________________ new lester _________________________________________
		
		
		$('#btn_search').click(function(){
		
		 
		 var c_branch = $('#c_branch').val();
		 var asset_no = $('#asset_no').val();
		 var assined_p = $('#assined_p').val();

			var dtr_url = '<?php echo base_url(); ?>asset/asset_list_reload';
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			$.ajax({
				type:"POST",
				url: dtr_url,
				data: {c_branch:c_branch,asset_no:asset_no,assined_p:assined_p},
				cache:false,
				beforeSend:function(){

					$("#details-tbl").find('tr td').remove();
					$("#details-tbl").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');
					
				},
				success:function(data){

					$('#asset_list_data').html(data);
				}
			});	
		});	

		$('#print_excel_btn').click(function(){
			var c_branch = $('#c_branch').val();
			var asset_no = $('#asset_no').val();
			var assined_p = $('#assined_p').val();
			
			var this_url =  baseUrl+'asset/print_asset_list/'+c_branch+'/'+asset_no+'/'+assined_p;
		   	
		   	window.location = this_url;
			return false;
		});

	// ______________________________________________________ new lester _________________________________________


		$('#save-btn').click(function(){
			
			$("#asset_form_upload").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
					
				//alert(data);	

					if(data == 0){
						rMsg('Duplicate Entry','warning')
						setTimeout(function(){
							 window.location.reload();
						},1500);
					}else{
						rMsg('New asset has been added','success')
						setTimeout(function(){
							 window.location.reload();
						},1500);
					}
					
				}
				
			});
			return false;
			
		});
		
		
		$('#branch_code').change(function(){
			
			if($('#branch_code').val() != ''){
				$('#ui_asset_no').attr('disabled','disabled');
				$('#ui_asset_no').val('');
			}else{
				$('#ui_asset_no').removeAttr('disabled','disabled');
			}

			if($('#asset_type').val() != '' && $('#division_code').val() != '' && $('#department_code').val() != '' || $('#unit_code').val() != ''){
				
				
				var branch_code = $('#branch_code').val();
				var asset_type = $('#asset_type').val();
				var division_code = $('#division_code').val();
				var department_code = $('#department_code').val();
				var unit_code = $('#unit_code').val();
				
				$.post(baseUrl+'asset/check_asset_numbers/', {'asset_type':asset_type,'branch_code':branch_code,'division_code':division_code,'department_code':department_code,'unit_code':unit_code}, function(data){
					
					$('#next_asset_no').val(data);
					
				});	

				
			}
			
		});
		
		$('#asset_type').change(function(){

			if($('#asset_type').val() != ''){
				$('#ui_asset_no').attr('disabled','disabled');
				$('#ui_asset_no').val('');
			}else{
				$('#ui_asset_no').removeAttr('disabled','disabled');
			}


			
			if($('#branch_code').val() != '' && $('#division_code').val() != '' && $('#department_code').val() != '' || $('#unit_code').val() != ''){
				
				var branch_code = $('#branch_code').val();
				var asset_type = $('#asset_type').val();
				var division_code = $('#division_code').val();
				var department_code = $('#department_code').val();
				var unit_code = $('#unit_code').val();
				
				$.post(baseUrl+'asset/check_asset_numbers/', {'asset_type':asset_type,'branch_code':branch_code,'division_code':division_code,'department_code':department_code,'unit_code':unit_code}, function(data){
					
					$('#next_asset_no').val(data);
					
					
				});	
				
			}
			
		});
		
		$('#division_code').change(function(){
			
			if($('#division_code').val() != ''){
				$('#ui_asset_no').attr('disabled','disabled');
				$('#ui_asset_no').val('');
			}else{
				$('#ui_asset_no').removeAttr('disabled','disabled');
			}


			if($('#branch_code').val() != '' && $('#asset_type').val() != '' && $('#department_code').val() != '' || $('#unit_code').val() != ''){
				
				var branch_code = $('#branch_code').val();
				var asset_type = $('#asset_type').val();
				var division_code = $('#division_code').val();
				var department_code = $('#department_code').val();
				var unit_code = $('#unit_code').val();
				
				$.post(baseUrl+'asset/check_asset_numbers/', {'asset_type':asset_type,'branch_code':branch_code,'division_code':division_code,'department_code':department_code,'unit_code':unit_code}, function(data){
					
					$('#next_asset_no').val(data);
					
					
				});	
				
			}
			
		});
		
		$('#department_code').change(function(){
				
			if($('#department_code').val() != ''){
				$('#ui_asset_no').attr('disabled','disabled');
				$('#ui_asset_no').val('');
			}else{
				$('#ui_asset_no').removeAttr('disabled','disabled');
			}


			if($('#branch_code').val() != '' && $('#asset_type').val() != '' && $('#department_code').val() != '' || $('#unit_code').val() != ''){
				
				var branch_code = $('#branch_code').val();
				var asset_type = $('#asset_type').val();
				var division_code = $('#division_code').val();
				var department_code = $('#department_code').val();
				var unit_code = $('#unit_code').val();
				
				$.post(baseUrl+'asset/check_asset_numbers/', {'asset_type':asset_type,'branch_code':branch_code,'division_code':division_code,'department_code':department_code,'unit_code':unit_code}, function(data){
					
					$('#next_asset_no').val(data);
					
					
				});	
				
			}
			
		});
		
		$('#unit_code').change(function(){
			if($('#unit_code').val() != ''){
				$('#ui_asset_no').attr('disabled','disabled');
				$('#ui_asset_no').val('');
			}else{
				$('#ui_asset_no').removeAttr('disabled','disabled');
			}

			if($('#branch_code').val() != '' && $('#asset_type').val() != '' && $('#department_code').val() != '' && $('#division_code').val() != ''){
				
				var branch_code = $('#branch_code').val();
				var asset_type = $('#asset_type').val();
				var division_code = $('#division_code').val();
				var department_code = $('#department_code').val();
				var unit_code = $('#unit_code').val();
				
				$.post(baseUrl+'asset/check_asset_numbers/', {'asset_type':asset_type,'branch_code':branch_code,'division_code':division_code,'department_code':department_code,'unit_code':unit_code}, function(data){
					
					$('#next_asset_no').val(data);
					
					
				});	
				
			}
			
			
		});
		
		$('.del_link').click(function(){
			var id = $(this).attr('id');
			var asset_no = $(this).attr('asset_no');
			//alert(id);
				BootstrapDialog.show({
				type: BootstrapDialog.TYPE_WARNING,
				title: '<h4>Delete</h4>',
				message: "<h4><span style='color: orange;'>Are You sure you want to delete this asset #. </span><span style='color: red;'>"+ asset_no +"</span><span style='color: orange;'> ?</span></h4>",
				buttons: [
					{
						icon: 'fa fa-check',
						label: ' Yes',
						cssClass: 'btn btn-success',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
							loader_url = baseUrl + 'asset/delete_asset';
								$.post(loader_url, {'id':id}, function(data){
									if(data == 'success'){
										rMsg('Asset # has successfully deleted.', 'success');	
										setTimeout(function(){
												window.location.reload();
										},1000);
									}else{
										rMsg('Asset # cannot be delete.', 'warning');	
										setTimeout(function(){
												window.location.reload();
										},1000);
									}
								
										
								}); 

						}
					},
					{
						icon: 'fa fa-close',
						label: 'No',
						cssClass: 'btn',
						action: function (thisDialog)
						{
							thisDialog.close();
						}
					}
				]
			});

		});
		
		
		<?php elseif($use_js == 'customerJS'): ?>
		
		$('#save-btn').click(function(){
			$("#customer_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					
					if(data.status == 'warning'){
						rMsg(data.msg, 'warning');
						$('#cust_code').focus();
						}else{
						rMsg(data.msg, 'success')
					}
				}
			});
			
			// setTimeout(function(){
			// 	window.location.reload();
			// },1500);
			
			return false;
		});
		
		<?php elseif($use_js == 'customerBranchJS'): ?>
		$('#add-branch-btn').click(function(){
			debtor_id = $('#debtor_id').val();
			debtor_branch_id = $('#debtor_branch_id').val();
			// alert(debtor_id);
			window.location = baseUrl+'customer/add_branch/'+debtor_id+'/'+debtor_branch_id;
			return false;
		});
		
		<?php elseif($use_js == 'customerBranchAddJS'): ?>
		var inputs = $('.reqForm').each(function(){
			// alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-branch-btn').click(function(){
			//alert('aw');
			$("#branch_details_form").rOkay({
				btn_load		: 	$('#save-branch-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					//alert(data);
					rMsg(data.msg,'success');
					var form_mode = $('#mode').val();
					if(form_mode == 'edit'){
						//alert('edit');
						var input_name = '';
						var passed_form = '';
						var type_desc = 'Edit Customer Branch';
						var sales_person_details = '';
						inputs.each(function(){
							input_name = $(this).attr('id');
							if($(this).data('original') != this.value){
								//alert('Updated '+input_name+'--'+'OLD : '+$(this).data('original')+'---NEW : '+this.value);
								if (passed_form == ''){
									passed_form += input_name+'=OLD:'+$(this).data('original')+'|-|NEW:'+this.value;
									//alert(passed_form);
									}else{
									passed_form += '|--|'+input_name+'=OLD:'+$(this).data('original')+'|-|NEW:'+this.value;
								}
								if(sales_person_details != ''){
									sales_person_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
									}else{
									sales_person_details += input_name+':'+$(this).data('original')+'|'+this.value;
								}
							}
							
						});
						
						if(passed_form != ''){
							var formData = 'pk_id='+data.id+'&'+'debtor_branch_id='+data.id+'|=|'+passed_form;
							//alert(formData);
							$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
								
							});
						}
					}
				}
			});
			
			// setTimeout(function(){
			// 	window.location.reload();
			// },1500);
			
			return false;
		});
		
		<?php elseif($use_js == 'transliploadJS'): ?> 
			$('.translip_link').click(function(){
				var id = $(this).attr('id');
				window.open(baseUrl + 'asset/translip?id='+id,'Sales Reports',"height=700,width=400");
			});



		<?php elseif($use_js == 'TransSlipJS'): ?> 
		
			function load_transfer_slips(datefrom,dateto,transferno){				
				var dtr_url = '<?php echo base_url(); ?>asset/load_transfer_slips';
				$.post(dtr_url, {'datefrom' : datefrom,'dateto':dateto,'transferno':transferno}, function(data){
				//alert(data);
					$('#line_transslip').html(data);
						return false;
					});
			}
		
		
		
			$('#btn_search').click(function(){
				var datefrom = $('#date_from').val();
				var dateto = $('#date_to').val();
				var transferno = $('#transfer_no').val();
				load_transfer_slips(datefrom,dateto,transferno);				
			});
		
		
		
		
		
		
		<?php elseif($use_js == 'AssetOutJS'): ?> //####### ASSET OUT
		
			$("[data-toggle='offcanvas']").click(); //hide main menu sa side
		
			$('#asset_no').focus();
			var count1 = $('#count_details').val();
			var count2 = $('#count_temp_details').val();
			
			if(count1 == count2){
				$('#process_out_btn').removeAttr('disabled','disabled');
			}
		
		
			function check_temp_d(trans_id){		
			var dtr_url = '<?php echo base_url(); ?>asset/check_temp_data';
			$.post(dtr_url, {'trans_id' : trans_id}, function(data){
				
				res = data.split('~');
				
					
					res1 = res[0].replace(/\s+/g, '');
					res2 = res[1].replace(/\s+/g, '');

						if(res1 == res2 ){
							$('#process_out_btn').removeAttr('disabled','disabled');
						}else{
							return false;
						}
				});
			}
		
		
			$('#asset_no').change(function(){	
			
				 var asset_no =  $('#asset_no').val();
				 var trans_id =  $('#hidden_trans_id').val();
				 
				// alert(asset_no+'------'+trans_id);
				 
				 
				// loader_url = baseUrl + 'asset/check_details_temp';
				
					/* $.post(loader_url, {'asset_no':asset_no,'trans_id':trans_id}, function(data){				
						
						
						if(data != ''){
							rMsg('Item not Include.', 'warning');	
							load_transfer_items();
							$('#asset_no').attr({'value' : ''}).val('');
							$('#asset_no').focus();	
						}else{*/

							loader_url = baseUrl + 'asset/get_asset_no_id_out';
							
							$.post(loader_url, {'asset_no' : asset_no, 'trans_id':trans_id}, function(data){
								

								//alert(data);

								 if(data == 1){
									//alert(data+'111111');
											
										load_transfer_items();
										check_temp_d(trans_id);
										$('#asset_no').attr({'value' : ''}).val('');
										$('#asset_no').focus();
									rMsg('Successfully Added.', 'success');

								 }else{
									//alert(data+'22222');
									rMsg('Items already out or not included.', 'warning');
									$('#asset_no').attr({'value' : ''}).val('');
									$('#asset_no').focus();			
								 }
								
							});
								
					//	}
						
						//window.location = baseUrl + 'asset/asset_transfer/';
					// return false;					 
						
			    //  });
				
			
			});
		
				 
			
				 
			$('#process_out_btn').click(function(){
				
				var trans_id = $('#hidden_trans_id').val();
				var branch_code = $('#from_branch_code').val();
				var dept_code = $('#department_code').val();
				var unit_code = $('#unit_code').val();
				
						bootbox.dialog({
							message: baseUrl+'asset/oic_access/'+trans_id+'/'+branch_code+'/'+dept_code+'/'+unit_code,
							className: "bootbox-wide_",
							title: name,
							onEscape: true
							// buttons: {
								// cancel: {
									// label : "Close",
									// className: "btn-info",
									// callback: function(){

									// }
								// }
							// }
						});

					return false;
				});
				 
				 
				 
				 
				 
			//$('#process_out_btn').click(function(){
				 
				// var btn =  $(this);
				// disable_button(btn,'btn-primary');
				// var trans_id = $('#hidden_trans_id').val();
				// var branch_code = $('#from_branch_code').val();
				// var dept_code = $('#department_code').val();
				// var unit_code = $('#unit_code').val();
				// loader_url = baseUrl + 'asset/process_out';
				
				// $.post(loader_url, {'trans_id':trans_id, 'branch_code':branch_code, 'dept_code':dept_code ,'unit_code':unit_code}, function(data){
					// //alert(data);
					// rMsg(data, 'success');	
					// setTimeout(function(){
						// window.location = baseUrl+'asset/asset_transfer';
					// },500);
							
				// });
		//	});
			
			
			
			
			$('#cancel_btn').click(function(){
				var trans_id = $('#trans_id').val();
			
				loader_url = baseUrl + 'asset/del_transfer_temp';
				$.post(loader_url, {'trans_id':trans_id}, function(data){
					setTimeout(function(){
							window.location = baseUrl+'asset/asset_transfer';
				},500);
						
				}); 
			});
				

		
		
		<?php elseif($use_js == 'PopJS'): ?>
			
			//$('#save-btn').click(function(){
			$('#username').focus();
				
		$("#password").keyup(function(event){
			
				if(event.keyCode == 13){
					
					var user = $('#username').val();
					var pass = $('#password').val();
					var trans_id = $('#trans_id').val();
					var branch_code = $('#branch_code').val();
					var dept_code = $('#dept_code').val();
					var unit_code = $('#unit_code').val();

					loader_url = baseUrl + 'asset/check_users';
						$.post(loader_url, {'user':user,'pass':pass}, function(data){	
							data = data.replace(/\s+/g, '');;
							if(data != 'error'){
								rMsg('success', 'success');	
								 loader_url_process_out = baseUrl + 'asset/process_out';
								$.post(loader_url_process_out, {'trans_id':trans_id, 'branch_code':branch_code, 'dept_code':dept_code ,'unit_code':unit_code,'id':data}, function(data){
									rMsg(data, 'success');	
									setTimeout(function(){
										window.location = baseUrl+'asset/asset_transfer';
									},500);
											
								});
							}else{
								rMsg('invalid user', 'warning');	
							}		
						}); 
				}
			
		});		
		
				
		//	});
		
		
		
		
		<?php elseif($use_js == 'transAssetTabJS'): ?>
			$('.tab_link').click(function(){
				var id = $(this).attr('id');
				loader('#'+id);
			});
			var data = $('#tab_id').val();
		
			$('.tab_link').parent().removeClass('active');
			var link;
			var tab;
			if(data){
				 link  = '#'+data+'_link';
				 tab  = '#'+data;
			}else{
				link = '#asset_transfer_link';
				tab = '#assetTransfer';
				
			}
			//alert(link);
			loader(link);
			function loader(btn){
				var loadUrl = $(btn).attr('load');
				var tabPane = $(btn).attr('href');
				$(tabPane).rLoad({url:baseUrl+loadUrl});
			}
		
			$(tab).addClass('active');
			$(link).parent().addClass('active');
			
		<?php elseif($use_js == 'transAssetJS'): ?>
		
		
			var time = new Date().getTime();
			 $(document.body).bind("mousemove keypress", function(e) {
				 time = new Date().getTime();
			 });

			 function refresh() {
				 if(new Date().getTime() - time >= 50000) 
					 window.location.reload(true);
				 else 
					 setTimeout(refresh, 9000);
			 }

			 setTimeout(refresh, 9000);
		
		
		
		
			$("[data-toggle='offcanvas']").click(); //hide main menu sa side
			
			 $('.out_link').click(function(){
				var id  = $(this).attr('id');
				//alert(id);
				window.location = baseUrl + 'asset/asset_transfer_out2/'+id;
				return false;
			 });
			
			// $('.out_link').click(function(){
				// var id = $(this).attr('id');
				// window.location = baseUrl + 'asset/asset_transfer_out/'+id;
				// return false;
			// });
			
			
			$('.in_link').click(function(){
				var id = $(this).attr('id');
				window.location = baseUrl + 'asset/asset_transfer_in/'+id;
				return false;
			});
			
			
			
			$('.translip_link').click(function(){
				
				//window.location = baseUrl + 'asset/asset_transfer_in/'+id;
				var id = $(this).attr('id');
				if (confirm('This slip will only be printed once and can only be reprinted by ADMIN. Are You Sure you want to print this transfer slip?')){
					window.open(baseUrl + 'asset/translip?id='+id,'Sales Reports',"height=700,width=400");
				}else{
				   alert("You are not redirected.");
				}
								
			});
			
		$('.transfer_header_link').click(function(){
			var id = $(this).attr('id');
				bootbox.dialog({
					className: "bootbox-fwide",
					message: baseUrl+'asset/asset_transfer_details_view/'+id,
					title: "Asset Transfer Details",
					buttons: {
						cancel: {
							label: "Close",
							className: "btn-default",
							callback: function() {
								
							}
						}
					}
				});
				return false;
				
			});
			
		
		
		<?php elseif($use_js == 'transAssetOutReloadJS'): ?>
			load_transfer_items();
		

		
		<?php elseif($use_js == 'transAssetOutJS'): ?>
		$('#buttons').hide();
		$('#asset_no').change(function(){	
			checkAssetOut();
			load_transfer_items();
			$('#line_item_contents_div').hide();
			$('#buttons').show();
			
		});
		$('#asset_no').on('keyup keypress', function(e) {
			  var code = e.keyCode || e.which;
			  if (code == 13) { 
				e.preventDefault();
				return false;
			  }
		});
		
		$('#process_btn').click(function(){
			$('#buttons').hide();
			$('#line_item_contents').hide();
			var trans_id = $('#trans_id').val();
			var branch_code = $('#from_branch_code').val();
			var dept_code = $('#department_code').val();
			var unit_code = $('#unit_code').val();
			loader_url = baseUrl + 'asset/process_out';
			$.post(loader_url, {'trans_id':trans_id, 'branch_code':branch_code, 'dept_code':dept_code ,'unit_code':unit_code}, function(data){
					//var msg  = data.split('||');	
					//alert(msg[1]);
						//if(data = "success"){
							rMsg(data, 'success');	
							//setTimeout(function(){
								window.location = baseUrl+'asset/asset_transfer';
							//},1000);
						//}else{
						//	rMsg('Asset successfully transfer', 'success');	
							//setTimeout(function(){
						//		window.location = baseUrl+'asset/asset_transfer';
							//},100);
						//}
			});
		});
		
		$('#cancel_btn').click(function(){
			var trans_id = $('#trans_id').val();
		
			loader_url = baseUrl + 'asset/del_transfer_temp';
			$.post(loader_url, {'trans_id':trans_id}, function(data){
				//alert(data);
				
							rMsg(data, 'success');	
							//setTimeout(function(){
								window.location = baseUrl+'asset/asset_transfer';
						//	},100);
					
			}); 
		});

	
		
		
	<?php elseif($use_js == 'assetRepairJS'): ?>
			$('#file-spinner').hide();

		$('#repair_type').change(function(){
			//if()
				
				if($('#repair_type').val() == 'Ordinary'){
					$(life_years).attr('disabled','disabled');
				}else{
					$(life_years).removeAttr('disabled','disabled');
				}			
				// $.post(post_url, {'header_id':header_id}, function(data){	
				
				// rMsg(' Asset Request has Approved','success');
				// setTimeout(function(){
					// window.location.reload();
				// },1500);
			// });
				
	
		});
		$('#btn-repair').click(function(){
			
			$('#file-spinner').show();
			$('#btn-repair').hide();
			var type = $('#repair_type').val();
			var remarks = $('#remarks').val();
			var amount = $('#amount').val();
			var life_years = $('#life_years').val();
			var asset_id = $('#asset_no').val();
		//	var acquisition_cost = $('#acquisition_cost').val();
		//	var old_life_span = $('#old_life_span').val();
			
			if($('#repair_type').val() == 'Ordinary' && $('#remarks').val() != '' ){
				if($('#amount').val() != ''){
				
					var post_url = baseUrl+'asset/insert_repair_asset';
					$.post(post_url, {'asset_id':asset_id,'type':type,'remarks':remarks,'amount':amount,'life_years':life_years}, function(data){
						rMsg('data has been recorded','success');
						  setTimeout(function(){
							  window.location = baseUrl+'asset/new_asset_list';
						  },1500);
					});
					//return false;
				}else{
					rMsg('Required Fields','error');
					setTimeout(function(){
						  window.location = baseUrl+'asset/repair_asset_form';
					  },1500);
				}
				
			}else{
			
				if($('#amount').val() != '' && $('#life_years').val() != '' && $('#remarks').val() != '' ){
				
					///alert('hi');
					 var post_url = baseUrl+'asset/insert_repair_asset_capitalizable';
						$.post(post_url, {'asset_id':asset_id,'type':type,'remarks':remarks,'amount':amount,'life_years':life_years}, function(data){
							//alert(data);
							 rMsg('data has been recorded','success');
							  setTimeout(function(){
								  window.location = baseUrl+'asset/new_asset_list';
							  },1500);
							return false;
						});
					
				}else{
					rMsg('Required Fields','error');
					setTimeout(function(){
						  window.location = baseUrl+'asset/repair_asset_form';
					  },1500);
				}
			}		
				return false;	
		}); 
		
		<?php elseif($use_js == 'AssetDispose'): ?>
		
		$('#btn-dispose').click(function(){
		
			$("#process_asset_disposal").rOkay({
				btn_load		: 	$('#btn-dispose'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
					
					//alert(data);
					 rMsg('Asset has been disposed','success');
					  setTimeout(function(){
						  window.location = baseUrl+'asset/new_asset_list';
					  },1500);
					return false;
									
				}
					
			});
			return false;

		});
			
		<?php elseif($use_js == 'transAssetInReloadJS'): ?>
			load_transfer_items_in();
			
		
		
		<?php elseif($use_js == 'transAssetInJS'): ?>
		
			$('#asset_no').focus();
			
			
			function check_temp_c(trans_id){
				
			var dtr_url = '<?php echo base_url(); ?>asset/check_temp_data';
			$.post(dtr_url, {'trans_id' : trans_id}, function(data){
				//var res;
				res = data.split('~');
				res1 = res[0].replace(/\s+/g, '');
				res2 = res[1].replace(/\s+/g, '');
				if(res1 == res2){
					$('#process_in_btn').removeAttr('disabled','disabled');
				}
					return false;
				});
			}
			
			
			
			$("[data-toggle='offcanvas']").click(); //hide main menu sa side
			
			var count1 = $('#count_details').val();
			var count2 = $('#count_temp_details').val();
			
			if(count1 == count2){
				$('#process_in_btn').removeAttr('disabled','disabled');
			}

		
		$('#buttons_').hide();
		
		$('#asset_no').change(function(){	
			var asset_no = $('#asset_no').val();
			var trans_id = $('#hidden_trans_id').val();
			
			//loader_url = baseUrl + 'asset/check_details_temp';
			//$.post(loader_url, {'asset_no' : asset_no, 'trans_id':trans_id}, function(data){	
				


				// if(data != ''){
				// 	rMsg(data, 'warning');				
				// 	$('#asset_no').attr({'value' : ''}).val('');
				// 	$('#asset_no').focus();	
				// }else{
					loader_url = baseUrl + 'asset/get_asset_no_id_in';
					$.post(loader_url, {'asset_no' : asset_no, 'trans_id':trans_id}, function(data){
						 if(data == 1 ){
						 		load_transfer_items_in();
								check_temp_c(trans_id);
								$('#asset_no').attr({'value' : ''}).val('');
								$('#asset_no').focus();	
								rMsg('Successfully Added.', 'success');

						 }else{
								rMsg('Items already in or not included.', 'warning');
									$('#asset_no').attr({'value' : ''}).val('');
									$('#asset_no').focus();
						 }
							
							
					});
			//	}



			});
			// checkAssetIn();
			// load_transfer_items_in();
			// $('#line_item_contents_div_').hide();
			// $('#buttons_').show();
			
		//});
		$('#asset_no').on('keyup keypress', function(e) {
			  var code = e.keyCode || e.which;
			  if (code == 13) { 
				e.preventDefault();
				return false;
			  }
		});
		$('#process_in_btn').click(function(){
			//$('#buttons_').hide();
			var btn = $(this);
			disable_button(btn,'btn-primary');
			var trans_id = $('#hidden_trans_id').val();
			var branch_code = $('#to_branch_code').val();
			var dept_code = $('#department_code').val();
			var unit_code = $('#unit_code').val();
			loader_url = baseUrl + 'asset/process_in';
			$.post(loader_url, {'trans_id':trans_id, 'branch_code':branch_code, 'dept_code':dept_code ,'unit_code':unit_code}, function(data){
					rMsg(data, 'success');	
					setTimeout(function(){
						window.location = baseUrl+'asset/asset_transfer';
					},500);
			}); 
		});
		
		$('#cancel_btn').click(function(){
			var trans_id = $('#trans_id').val();
		
			loader_url = baseUrl + 'asset/del_transfer_temp';
			$.post(loader_url, {'trans_id':trans_id}, function(data){
				setTimeout(function(){
								window.location = baseUrl+'asset/asset_transfer';
				},100);
					
			}); 
		});
		
	
		
		<?php endif; ?>
	});
</script>