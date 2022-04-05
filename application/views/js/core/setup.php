<script>
$(document).ready(function(){
	<?php if($use_js == 'detailsJs'): ?>
		$(".timepicker").timepicker({
            showInputs: false
        });

		$("#sil").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else	
				$(this).attr('value',0);

		});
		$("#scl").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else	
				$(this).attr('value',0);
		});
		$("#spl").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else	
				$(this).attr('value',0);
		});

		$('#save-btn').click(function(event){
			event.preventDefault();
			// $("#details_form").rOkay({
			// 	btn_load		: 	$('#save-btn'),
			// 	bnt_load_remove	: 	true,
			// 	asJson			: 	false,
			// 	onComplete		:	function(data){
			// 							alert(data);
			// 							rMsg(data.msg,'success');
			// 						}
			// });


			var formData = $('#details_form').serialize();
			//var dtype = 'json';
			//alert(formData);
			$.post(baseUrl+'setup/details_db',formData,function(data)
			{
				// alert(data);
				rMsg(data.msg,'success');
			},'json');
			//});
			// alert(formData);

		// 	$.ajax({
		//         url: baseUrl+'setup/details_db',
		//         type: 'POST',
		//         data:  formData,
		//         dataType:  dtype,
		//         mimeType:"multipart/form-data",
		//         contentType: false,
		//         cache: false,
		//         processData:false,
		//         success: function(data, textStatus, jqXHR){
		// 			// alert(data);
		// //          	settings.onComplete.call(this,data);
		// 				rMsg(data.msg,'success');
		//         },
		//         error: function(jqXHR, textStatus, errorThrown){
		// 			console.log(jqXHR);
		// 			console.log(textStatus);
		// 			console.log(errorThrown);
		//         }         
		//     });
			return false;
		});
	
	// ______________________________________________________ new lester _________________________________________

	<?php elseif($use_js == 'usersJs'): ?>

		$('#save-branch').click(function(){
			
			$("#branch_form").rOkay({
				btn_load		: 	$('#branch_form'),
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
						rMsg('New Branch has been added','success')
						setTimeout(function(){
							 window.location.reload();
						},1500);
					}
					
				}
				
			});
			return false;
		});

	// ______________________________________________________ new lester _________________________________________
		

		// $('#target').click(function(e){
	 //    	$('#complogo').trigger('click');
	 //    }).css('cursor', 'pointer');
	<?php elseif($use_js == 'referencesJs'): ?>
		// alert('asd');
		$('.save_btn').click(function(){
			var type_id = $(this).attr('ref');
			var name = $(this).attr('label');
			var next_ref = $('#type-'+type_id).val();
			var formData = 'type_id='+type_id+'&next_ref='+next_ref+'&name='+name;

			// alert(formData);

			$.post(baseUrl+'settings/references_db', formData, function(data){
				rMsg(data.msg,'success');
			}, 'json');

			// $.post(baseUrl+'settings/references_db', formData, function(data){
				// alert(data);
				// // rMsg(data.msg,'success');
			// });

			return false;
		});
	<?php elseif($use_js == 'currencySetupJs'): ?>
		var mode = $('#mode').val();
		
		$('#abbrev').focus();
		// alert(mode);
		//-----Product Code
		// if(mode == 'add'){
			// $('#product_code').focus();
		// }else{
			// $('#product_code').prop('disabled', true);
		// }
		var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-btn').click(function(){
			$("#currency_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										// alert(data);
										// rMsg(data.msg,'success');

										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#abbrev').focus();
										}else{
											rMsg(data.msg, 'success');
											var form_mode = $('#mode').val();
												if(form_mode == 'edit'){
												//alert('edit');
												var input_name = '';
												var passed_form = '';
												var type_desc = 'Edit Currency';
												var currency_details = '';
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
														if(currency_details != ''){
															currency_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
														}else{
															currency_details += input_name+':'+$(this).data('original')+'|'+this.value;
														}
													}
													
												});
								
												if(passed_form != ''){
													var formData = 'pk_id='+data.id+'&'+'curr_id='+data.id+'|=|'+passed_form;
													//alert(formData);
													$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												
													});
												}
											}
										}
									}
			});

			// setTimeout(function(){
				// window.location.reload();
			// },1500);

			return false;
		});
		
		
		<?php elseif($use_js == 'branchSetupJs'): ?>
		var mode = $('#mode').val();
		
		$('#code').focus();
		$("#has_sa").attr('value',1);
		$("#has_bo").attr('value',1);
		
		$("#has_sa").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else	
				$(this).attr('value',0);

		});
		
		$("#has_sr").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else	
				$(this).attr('value',0);

		});
		
		$("#has_bo").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else	
				$(this).attr('value',0);

		});
		$('#add').click(function(){
			BootstrapDialog.show({
							type: BootstrapDialog.TYPE_DANGER,
				            title: 'NOTE',
					           message: "<center><h3>Configure first the database.php file before adding a new branch in the system.</center>",
							   onshow: function(dialog) {
							   setTimeout(function (){
								$('#pwd').focus();	
							   }, 500);
							},
				            buttons: [{
				                id: 'pwd',
			               		hotkey: 13, 
				                label: 'Continue',
			           			cssClass: 'btn-danger',
				                action: function(dialogRef1) {
										window.location = baseUrl+'admin/manage_branches';
								}
				          }]
				       });	
		});
		var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-btn').click(function(){
			$("#branch_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//alert(data);
										// rMsg(data.msg,'success');

										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#code').focus();
										}else{
											rMsg(data.msg, 'success');
												var form_mode = $('#mode').val();
												if(form_mode == 'edit'){
												//alert('edit');
												var input_name = '';
												var passed_form = '';
												var type_desc = 'Edit Branch';
												var branch_details = '';
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
														if(branch_details != ''){
															branch_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
														}else{
															branch_details += input_name+':'+$(this).data('original')+'|'+this.value;
														}
													}
													
												});
								
												if(passed_form != ''){
													var formData = 'pk_id='+data.id+'&'+'branch_id='+data.id+'|=|'+passed_form;
													//alert(formData);
													$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												
													});
												}
											}
										}
									}
			});

			// setTimeout(function(){
				// window.location.reload();
			// },1500);

			return false;
		});	
		
		<?php elseif($use_js == 'payment_typesSetupJs'): ?>
		var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		var name = $('#name').val();
		
		$('#name').focus();
		// alert(mode);
		//-----Product Code
		// if(mode == 'add'){
			// $('#product_code').focus();
		// }else{
			// $('#product_code').prop('disabled', true);
		// }
		
		$('#save-btn').click(function(){
			$("#payment_types_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										// alert(data);
										// rMsg(data.msg,'success');

										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#name').focus();
										}else{
											rMsg(data.msg, 'success');
												var form_mode = $('#mode').val();
												if(form_mode == 'edit'){
												//alert('edit');
												var input_name = '';
												var passed_form = '';
												var type_desc = 'Edit Payment Type';
												var payment_type_details = '';
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
														if(payment_type_details != ''){
															payment_type_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
														}else{
															payment_type_details += input_name+':'+$(this).data('original')+'|'+this.value;
														}
													}
													
												});
								
												if(passed_form != ''){
													var formData = 'pk_id='+data.id+'&'+'payment_types_id='+data.id+'|=|'+passed_form;
													//alert(formData);
													$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												
													});
												}
											}
										}
									}
			});

			// setTimeout(function(){
				// window.location.reload();
			// },1500);

			return false;
		});
		
	<?php elseif($use_js == 'Payment_typesJS'): ?>
		var mode = $('#mode').val();
		
		$('#code').focus();
		$('#amount').keypress(function (evt){
		var charCode = (evt.which) 
		? evt.which : event.keyCode
			if (charCode != 46 && charCode > 31
				&& (charCode < 48 || charCode > 57)){
					return false;
					
					return true;
			}
			if(charCode == 9){
				return false;
			
			}
		});
		$('#amount').blur(function(){
			var whole = $('#amount').val().split(".",1);
			for(var i=0;i<whole.length;i++){
				var a = whole[i].length;
			}
			if(a > 5){
				rMsg("Only 5 digits are allowed.",'error')
				$('#amount').focus();
			}
		});
		var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-btn').click(function(){
			$("#payment_types_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										 //alert(data);
										// rMsg(data.msg,'success');

										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#code').focus();
										}else{
											rMsg(data.msg, 'success');
											var form_mode = $('#mode').val();
												if(form_mode == 'edit'){
												//alert('edit');
												var input_name = '';
												var passed_form = '';
												var type_desc = 'Edit Payment Type Code';
												var payment_type_code_details = '';
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
														if(payment_type_code_details != ''){
															payment_type_code_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
														}else{
															payment_type_code_details += input_name+':'+$(this).data('original')+'|'+this.value;
														}
													}
													
												});
								
												if(passed_form != ''){
													var formData = 'pk_id='+data.id+'&'+'id='+data.id+'|=|'+passed_form;
													//alert(formData);
													$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												
													});
												}
											}
										}
									}
			});

			// setTimeout(function(){
				// window.location.reload();
			// },1500);

			return false;
		});
		
		
		<?php elseif($use_js == 'AcquiringBanksSetupJs'): ?>
		var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-btn').click(function(){
			$("#acquiring_banks_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//alert(data);
										//rMsg(data.msg,'success');
										//window.location = baseUrl+'customer;
										
										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#acquiring_bank').focus();
										}else{
											rMsg(data.msg, 'success');
												var form_mode = $('#mode').val();
												if(form_mode == 'edit'){
												//alert('edit');
												var input_name = '';
												var passed_form = '';
												var type_desc = 'Edit Acquiring Bank';
												var acquiring_bank_details = '';
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
														if(acquiring_bank_details != ''){
															acquiring_bank_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
														}else{
															acquiring_bank_details += input_name+':'+$(this).data('original')+'|'+this.value;
														}
													}
													
												});
								
												if(passed_form != ''){
													var formData = 'pk_id='+data.id+'&'+'acquiring_bank_id='+data.id+'|=|'+passed_form;
													//alert(formData);
													$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												
													});
												}
											}
										}
									}
			});

			// setTimeout(function(){
			// 	window.location.reload();
			// },1500);

			return false;
		});
		
	<?php elseif($use_js == 'suppGroupAdderPopJS'): ?>
		$('.c_supp_group_name').focus();
		// $('.c_supp_group_name').attr({'value':'We are all mad here...'}).val('We are all mad here...');
		
	<?php elseif($use_js == 'deymJs'): ?>
		// alert('deym');
		
		//=====RESTRICT SUBMISSION OF FORM UPON CLICKING ENTER=====//
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
		});
		//===============================================//
		
		function loadme(){
			$.post(baseUrl+'admin/load_me/',function(data){
				$('#smg_div').html(data);
				
				$('#group_id').change(function(){
					var thisval = $(this).val();
					// alert('My val : '+thisval);
				});
				
				return false;    
			});
		}

		$('#click-btn').click(function(){
			//----------
			// BootstrapDialog.show({
				// type: BootstrapDialog.TYPE_DANGER,
				// title: 'Purchasable Total Amount:',
				// message: "<input type='text' class='form-control' name='limit_amount' id='limit_amount' placeholder='Total Amount'>",
				// onshow: function(dialog) {
					// // setTimeout(function (){
					// // $('#limit_amount').focus();	
					// // }, 500);
				// },
				// buttons: [{
					// id: 'pwd',
					// label: 'Continue',
					// cssClass: 'btn-danger',
					// action: function(dialogRef1) {			
						// limit_amount = $("#limit_amount").val();		              	
						// document.getElementById("discount_limit").value = limit_amount;	
						// setTimeout(function (){
							// $('#search_item').focus();	
						// }, 500);
					// dialogRef1.close();
					// }
				// }]
			// });
			//----------
			bootbox.dialog({
				title: "Add Supplier Group <!--span style='color: #5bc0de;'> Tss</span>",
				message: baseUrl+'admin/load_supplier_master_group_adder/',
				onEscape: true, //-----added to close dialog box upon clicking the ESC button
				buttons: {
					save: {
						label : "Save",
						className : "btn-success",
						callback : function(){
							
							$("#supp_master_group_adder_form").rOkay({
								// btn_load		: 	$('#save_supp_stock_btn'),
								// btn_load_remove	: 	true,
								asJson			: 	true,
								onComplete		:	function(data){
														// // alert('reloader:'+data);
														rMsg(data.msg,data.result);
														// walkmydog();
														// // set_group_content();
														// // window.location.reload();
														loadme();
													}
							});
						}
					},
					cancel: {
						label: "Close",
						className: "btn-default",
						callback: function() {
						// rMsg('Closing the confirm box...','error');
							// setTimeout(function(){
								// window.location = baseUrl+'inventory/uoms';
							// },1500);
						}
					}
				}
			});
			return false;
		});
	<?php elseif($use_js == 'supplierMasterJs'): ?>
		function reload_po_schedule_drop(){
			var po_sched = $('#po_schedule').val();
			// alert('PO Sched : '+po_sched);
			if(po_sched == 'weekly'){
				$('#selling_days').attr({'value' : 14}).val(14);
				$('#po_selling_days').attr({'value' : 14}).val(14);
			}else if(po_sched == 'two_weeks'){
				$('#selling_days').attr({'value' : 21}).val(21);
				$('#po_selling_days').attr({'value' : 21}).val(21);
			}else{
				$('#selling_days').attr({'value' : 37}).val(37);
				$('#po_selling_days').attr({'value' : 37}).val(37);
			}
		}
		
		var mode = $('#mode').val();
		// alert('Form Mode : '+mode);
		
		if(mode=='edit'){
			var main_group_id = $('#hidden_main_group_id').val();
			// alert('Loaded group id : '+main_group_id);
			add_loadme(main_group_id);
		}else{
			loadme();
			reload_po_schedule_drop();
		}
		
		$('#po_schedule').change(function(){
			reload_po_schedule_drop();
		});
		
		$('#con_biller_code').blur(function(){
			var con_biller_code = $(this).val();
			var biller_code = $('#biller_code').val();
			
			if(biller_code != con_biller_code){
				rMsg('Biller Code does not match!', 'error');
				$('#con_biller_code').focus();
			}
			return false;
		});
		
		// $('#biller_code').blur(function(){
			// var biller_code = $(this).val();
			// var con_biller_code = $('#con_biller_code').val();
			
			// if(biller_code != con_biller_code){
				// rMsg('Biller Code does not match!', 'error');
				// // $('#biller_code').focus();
			// }
			// return false;
		// });
		
		$('.sup_master_group_ddb').change(function(){
			var my_val = $('.sup_master_group_ddb').val();
			// alert('~~'+my_val);
			if(my_val == 'Add New'){
				// alert('Add New Group Type');
				$('.add_group').slideDown('fast');
			}else{
				// alert('nothing to do');
				$('.add_group').slideUp('fast');
			}
			return false;
		});
		
		function set_group_content(){
			$.post(baseUrl+'admin/get_supp_group/',function(data){
				alert(data);
				$('.sup_master_group_ddb').find('option').remove();
				$.each(data.opts,function(key,val){
					alert(key+'---'+val);
					$('.sup_master_group_ddb').append($("<option/>", {
						value: val,
						text: key
					}));
				});
			},'json');
			// });
		}
		
		// function walkmydog() {
			// //when the user starts entering
			// var dom = document.getElementById('group_id');
			// if(dom == null)
			// {
				// alert('sorry, group_id DOM cannot be found');
				// return false;    
			// }

			// if(dom.value.length == 0) {
				// alert("nothing");
			// }
		// }
		
		function add_loadme(group_id){
			// alert('add---hello world');
			$.post(baseUrl+'admin/load_me/',{'post_group_id':group_id},function(data){
				$('#smg_div').html(data);
				
				$('#group_id').change(function(){
					var thisval = $(this).val();
					// alert('My val : '+thisval);
				});
				return false;    
			});
		}
		
		function loadme(){
			// alert('hello world');
			$.post(baseUrl+'admin/load_me/',function(data){
				$('#smg_div').html(data);
				
				$('#group_id').change(function(){
					var thisval = $(this).val();
					// alert('My val : '+thisval);
				});
				return false;    
			});
		}
		
		if($('#is_consignor').is(':checked'))
			$('.con_percent').removeAttr('readonly');
		else
			$('.con_percent').attr({'readonly' : 'readonly'});

		$(".num_without_decimal").on("keypress keyup blur",function (event) {    
		   $(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
		
		$("#is_consignor, #is_cwo").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
		});
		
		$('.consignor_checker').click(function(){
			if($(this).is(':checked')){
				$('.con_percent').removeAttr('readonly');
				// $('.con_percent').addClass('rOkay');
				$('.con_percent').focus();
			}else{
				$('.con_percent').attr({'readonly' : 'readonly'});
				// $('.con_percent').removeAttr('rOkay');
				// alert('remove rOkay class please');
			}
		});
		
		$('.cwo_checker').click(function(){
			if($(this).is(':checked')){
				$("#email_payment").focus();
				// $('.hl_email').tooltip({
					// 'title' : 'This is a required field',
					// 'show': true,
					// 'placement': 'right'
				// });
			}
		});
		
		var inputs = $('.reqForm').each(function(){
			// alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		
		$('#code').focus();	
		$('#save-btn').click(function(){
			var is_consignor = $('#is_consignor').val();
			var is_cwo = $('#is_cwo').val();
			
			// alert('Consignor : '+is_consignor+' CWO : '+is_cwo);
			// alert($("#supplier_details_form").serialize());
			
			
			$("#supplier_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										 // alert(data.id);
										// rMsg(data.msg,'success');
											
										if(data.status == 'warning'){
											if(data.checker_mode == 'cwo'){
												rMsg(data.msg, 'warning');
												$('#email').focus();
											}else{
												rMsg(data.msg, 'warning');
												$('#code').focus();
											}
										}else{
											// rMsg(data.msg, 'success');
											//write_to_audit_trail($("#supplier_details_form").serialize());
											rMsg(data.msg, 'success');		
											if(mode == 'add'){
												var formData = 'pk_id='+data.id+'&'+'supplier_id='+data.id+'&'+$("#supplier_details_form").serialize();
												var type_desc = 'Add New Supplier';
												$.post(baseUrl+'admin/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												// alert(data);
												});
											}else{
											//	alert('edit');
												var input_name = '';
												var passed_form = '';
												var type_desc = 'Edit Supplier';
												var supplier_details = '';
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
														if(supplier_details != ''){
															supplier_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
														}else{
															supplier_details += input_name+':'+$(this).data('original')+'|'+this.value;
														}
													}
													
												});
								
												if(passed_form != ''){
													var formData = 'pk_id='+data.id+'&'+'supplier_id='+data.id+'|=|'+passed_form;
													//alert(formData);
													$.post(baseUrl+'admin/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												
												});
											}
										}
									}
								}
			});
			return false;
		});

		<?php elseif($use_js == 'discount_typesSetupJs'): ?>
		var mode = $('#mode').val();
		$('#amount').keypress(function (evt){
		var charCode = (evt.which) 
		? evt.which : event.keyCode
			if (charCode != 46 && charCode > 31
				&& (charCode < 48 || charCode > 57)){
					return false;
					
					return true;
			}
			if(charCode == 9){
				return false;
			
			}
		});
		$('#amount').blur(function(){
			var whole = $('#amount').val().split(".",1);
			for(var i=0;i<whole.length;i++){
				var a = whole[i].length;
			}
			if(a > 5){
				rMsg("Only 5 digits are allowed.",'error')
				$('#amount').focus();
			}
		});
		$('#short_desc').focus();
		var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-btn').click(function(){
			$("#discount_types_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//alert(data);
										// rMsg(data.msg,'success');

										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#short_desc').focus();
										}else{
											rMsg(data.msg, 'success');
												var form_mode = $('#mode').val();
												if(form_mode == 'edit'){
												//alert('edit');
												var input_name = '';
												var passed_form = '';
												var type_desc = 'Edit Discount Type';
												var discount_type_details = '';
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
														if(discount_type_details != ''){
															discount_type_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
														}else{
															discount_type_details += input_name+':'+$(this).data('original')+'|'+this.value;
														}
													}
													
												});
								
												if(passed_form != ''){
													var formData = 'pk_id='+data.id+'&'+'discount_type_id='+data.id+'|=|'+passed_form;
													//alert(formData);
													$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												
													});
												}
											}
										}
									}
			});

			// setTimeout(function(){
				// window.location.reload();
			// },1500);

			return false;
		});	
		<?php elseif($use_js == 'main_uploaderJs'): ?>
		$('#file-spinner').hide();	
		$('#upload-btn').click(function(){
				$('#file-spinner').show();	
			
					var url = baseUrl+'main_uploader/send_to_main_server/';
						$.post(url, function(data){		
							if(data == 'success'){
								$('#file-spinner').hide();	
								rMsg('Successfully Uploaded to the Main Server.', 'success');
								//alert('success');
						}else{
								$('#file-spinner').hide();	
								rMsg('No Connection to the Main Server.', 'error');
							}
						});
			
			// $("#payment_types_details_form").rOkay({
				// btn_load		: 	$('#upload-btn'),
				// btn_load_remove	: 	true,
				// asJson			: 	false,
				// onComplete		:	function(data){
										// alert(data);
										// // rMsg(data.msg,'success');

										// if(data.status == 'warning'){
											// rMsg(data.msg, 'warning');
											// $('#code').focus();
										// }else{
											// rMsg(data.msg, 'success')
										// }
									// }
			// });

			// setTimeout(function(){
				// window.location.reload();
			// },1500);

			return false;
		});
		
	<?php elseif($use_js == 'usersJs'): ?>
	var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-btn').click(function(){
			$("#users_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//alert(data);
										// rMsg(data.msg,'success');

										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#short_desc').focus();
										}else{
											rMsg(data.msg, 'success');
												var form_mode = $('#mode').val();
												if(form_mode == 'edit'){
												//alert('edit');
												var input_name = '';
												var passed_form = '';
												var type_desc = 'Edit User';
												var discount_type_details = '';
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
														if(discount_type_details != ''){
															discount_type_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
														}else{
															discount_type_details += input_name+':'+$(this).data('original')+'|'+this.value;
														}
													}
													
												});
								
												if(passed_form != ''){
													var formData = 'pk_id='+data.id+'&'+'discount_type_id='+data.id+'|=|'+passed_form;
													//alert(formData);
													$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												
													});
												}
											}
										}
									}
			});

			// setTimeout(function(){
				// window.location.reload();
			// },1500);

			return false;
		});	
		
	<?php elseif($use_js == 'branchCounterJs'): ?>
	$('.branch_dropdown').change(function(){
			var branch_id = $('#branch_id').val();
			var val_url = baseUrl + 'admin/get_branch_tin';
			$.post(val_url, {'branch_id' : branch_id}, function(data){
				// alert(data);
				$('#tin').attr({'value':data}).val(data);
			});
			return false;
		});
	var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-btn').click(function(){
			$("#branch_counter_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//alert(data);
										// rMsg(data.msg,'success');

										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#short_desc').focus();
										}else{
											rMsg(data.msg, 'success');
												var form_mode = $('#mode').val();
												if(form_mode == 'edit'){
												//alert('edit');
												var input_name = '';
												var passed_form = '';
												var type_desc = 'Edit Branch Counter';
												var discount_type_details = '';
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
														if(discount_type_details != ''){
															discount_type_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
														}else{
															discount_type_details += input_name+':'+$(this).data('original')+'|'+this.value;
														}
													}
													
												});
								
												if(passed_form != ''){
													var formData = 'pk_id='+data.id+'&'+'discount_type_id='+data.id+'|=|'+passed_form;
													//alert(formData);
													$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
												
													});
												}
											}
										}
									}
			});

			// setTimeout(function(){
				// window.location.reload();
			// },1500);

			return false;
		});	
	<?php endif; ?>
});
</script>