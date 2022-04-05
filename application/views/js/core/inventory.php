<script>
	$(document).ready(function(){
		<?php if($use_js == 'formContainerJs'): ?>
		$('form').on('submit',function(event)
		{
			event.preventDefault();
			$('#save-list-form').trigger('click');
		});
		<?php elseif($use_js == 'inventoryFormContainerJs'): ?>
		$('.tab_link').click(function(event)
		{
			event.preventDefault();
			var id = $(this).attr('id');
			loader('#'+id);
		});
		loader('#details_link');
		function loader(btn)
		{
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var selected = $('#idx').val();
			// alert('hidden value:'+selected);
			if (selected && selected != 'new') {
				/* selected = 'add'; */
				enableTabs('.load-tab',true);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
				} else {
				enableTabs('.load-tab',false);
			}
			var item_id = $('#idx').val();
			$(tabPane).rLoad({url:baseUrl+loadUrl+'/'+item_id});
		}
		function enableTabs(id,enable)
		{
			// alert('val '+enable);
			if (enable) {
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
				} else {
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
		<?php elseif($use_js == 'inventoryFormJs'): ?>
		$('#save-btn').click(function()
		{
			$("#item_main_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					if (typeof data.result != "undefined") {
						rMsg(data.msg,data.result);
						if (data.result == "success")
						setTimeout(function()
						{
							window.location = baseUrl + 'inventory/items_maintenance';
						},800);
					}
				}
			});
			return false;
		});
		$('#back-btn').on('click',function(event)
		{
			event.preventDefault();
			window.location = baseUrl + 'inventory/items_maintenance';
		});
		<?php elseif($use_js == 'inventoryPricingFormJs'): ?>
		$('#save-price-btn').click(function()
		{
			// alert('price details btn');
			$("#item_pricing_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					
					if (typeof data.result != "undefined") {
						rMsg(data.msg,data.result);
						if (data.result == "success")
						setTimeout(function()
						{
							window.location = baseUrl + 'inventory/items_maintenance';
						},800);
					}
				}
			});
			return false;
		});
		$('#back-price-btn').on('click',function(event)
		{
			event.preventDefault();
			window.location = baseUrl + 'inventory/items_maintenance';
		});
		<?php elseif($use_js == "itemMovementSearchJs") :?>
		$('input.daterangepicker').daterangepicker({separator:' to '});
		
		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#item_movement_search_form').rOkay(
			{
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
					$('#div-results').html(data);
					
					$('.trx_no').rPopView({
						wide : true,
						asJson : true,
						onComplete: function(data){
							$('[data-bb-handler=cancel]').click();
						}
					});
				}
			});
		});
		<?php elseif($use_js == "salesOrderResultsJs") :?>
		$('a.lnk-approve-so').click(function(event)
		{
			event.preventDefault();
			var ref = $(this).attr('ref');
			
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_INFO,
				title: 'Sales Order Approval',
	            message: 'Are you sure you want to approve Sales Order # ' + ref + '?',
	            buttons: [
				{
					icon: 'fa fa-check',
					label: ' Yes',
					cssClass: 'btn-lg btn-success',
					action: function()
					{
						var $button = this;
						
						$button.disable();
						$button.spin();
						$.post(baseUrl + 'sales/approve_sales_order', 'ref='+ref, function(data)
						{
							location.reload();
						});
					}
				}, 
				{
					label: 'No',
					cssClass: 'btn-lg',
					action: function (thisDialog)
					{
						thisDialog.close();
					}
				}
	            ]
			});
			
		});
		$('a.lnk-decline-so').click(function(event)
		{
			event.preventDefault();
			var ref = $(this).attr('ref');
			
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_WARNING,
				title: 'Set Sales Order as inactive',
	            message: 'Proceeding  will make Sales Order # ' + ref + ' inactive. Do you want to proceed?',
	            buttons: [
				{
					icon: 'fa fa-check',
					label: ' Yes',
					cssClass: 'btn-lg btn-success',
					action: function()
					{
						var $button = this;
						
						$button.disable();
						$button.spin();
						$.post(baseUrl + 'sales/reject_sales_order', 'ref='+ref, function(data)
						{
							location.reload();
						});
					}
				},
				{
					label: 'No',
					cssClass: 'btn-lg',
					action: function (thisDialog)
					{
						thisDialog.close();
					}
				}
	            ]
			});
		});
		<?php elseif($use_js == 'inventoryAdjustmentJS'): ?>
		
		$('#save-invadjustment').click(function(){
			$("#inventory_adjustment_form").rOkay({
				btn_load		: 	$('#save-invadjustment'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					//alert(data);
					
					$('#so_id').val(data.id);
					
					disEnbleTabs('.load-tab',true);
					rMsg(data.msg,'success');
					
				}
			});
			
			setTimeout(function(){
				window.location.reload();
			},1500);
			
			return false;
		});
		
		$('#item_id').change(function(){
			var from_loc = $('#from_loc').val();
			// alert('From Loc:'+from_loc);
			set_item_details($(this).val(), from_loc);
		});
		
		function set_item_details(id, from_loc){
			// alert('init:'+id+'--'+from_loc);
			if(id != ''){
				$.post(baseUrl+'inventory/get_inv_item_details/'+id+'/'+from_loc,function(data){
					$('#item-id').val(data.item_id);
					$('#item-uom').val(data.uom);
					// $('#item-location').val(data.from_loc);
					
					// alert('asd--'+data.qoh);
					// if(data.qoh != 'null' || data.qoh != ''){
					// var d_qoh = data.qoh;
					// }else{
					// var d_qoh = 0;
					// }
					var d_qoh = (data.qoh == null) ? 0 : data.qoh;
					// alert(d_qoh);
					
					$('#item-price').val(data.price).attr({'value' : data.price});
					$('#unit_price').val(data.price).attr({'value' : data.price});
					$('#qoh').val(d_qoh).attr({'value' : d_qoh});
					
					$('#select-uom').find('option').remove();
					$.each(data.opts,function(key,val){
						$('#select-uom').append($("<option/>", {
							value: val,
							text: key
						}));
					});
					
					
				},'json');
				}else{
				// alert('def'+id);
				$('#select-uom').empty();
				$('#item-price').val(0).attr({'value' : 0});
				$('#unit_price').val(0).attr({'value' : 0});
				$('#qoh').val(0).attr({'value' : 0});
			}
		}
		
		loader('#details_link');
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var so_id = $('#so_id').val();
			
			if(so_id == ""){
				disEnbleTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			}
			else{
				disEnbleTabs('.load-tab',true);
			}
			$(tabPane).rLoad({url:baseUrl+loadUrl+so_id});
		}
		function disEnbleTabs(id,enable){
			if(enable){
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			}
			else{
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
		<?php elseif($use_js == 'inventoryAdjustmentHeaderJS'): ?>
		loader('#details_link');
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var po_id = $('#po_id').val();
			
			if(po_id == ""){
				//alert('waaaa');
				disEnbleTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			}
			else{
				//alert('we');
				disEnbleTabs('.load-tab',true);
			}
			//alert(po_id);
			$(tabPane).rLoad({url:baseUrl+loadUrl+po_id});
		}
		function disEnbleTabs(id,enable){
			if(enable){
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			}
			else{
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
		<?php elseif($use_js == 'invAdjustmentHeaderDetailsLoadJs'): ?>
		//alert('zxczxc');
		$('#save-iaheader').click(function(){
			$("#inv_adj_header_details_form").rOkay({
				btn_load		: 	$('#save-iaheader'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					if(typeof data.msg != 'undefined' ){
						$('#trx_id').val(data.id);
						// $('#details').rLoad({url:baseUrl+'branches/details_load/'+sel+'/'+res_id});
						disEnbleTabs('.load-tab',true);
						rMsg(data.msg,'success');
						$('#adj_items_link').click();
					}
				}
			});
			$('.input_form').val('').removeAttr('selected');
			$('input.combobox.this_item[type="text"]').focus();
			return false;
		});
		function disEnbleTabs(id,enable){
			if(enable){
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			}
			else{
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
		
		/////////////////////JED///////////////////////////////////////
		<?php elseif($use_js == "itemHardwareSearchJs") :?>
		$('input.daterangepicker').daterangepicker({separator:' to '});
		
		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#hware_movement_search_form').rOkay(
			{
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
					$('#div-results').html(data);
					
					$('.trx_no').rPopView({
						wide : true,
						asJson : true,
						onComplete: function(data){
							$('[data-bb-handler=cancel]').click();
						}
					});
					// if ($('.data-table').length)
					// 	$('.data-table').each(function()
					// 		{
					// 			$(this).dataTable({
					// 		        "bPaginate": true,
					// 		        "bLengthChange": true,
					// 		        "bFilter": true,
					// 		        "bSort": true,
					// 		        "bInfo": true,
					// 		        "bAutoWidth": false,
					// 		        "aaSorting":[]
					// 		    });
					// 		});
					// if (typeof data.result != 'null') {
					// 	if (data.result == 'error') {
					// 		rMsg(data.msg,'error');
					// 		return false;
					// 	}
					
					
					// }
				}
			});
		});
		
		<?php elseif($use_js == 'MulAdjJS'): ?>
		
		// loader('#details_link');
		
		// $('.tab_link').click(function(){
		// 	var id = $(this).attr('id');
		// 	loader('#'+id);
		// });
		
		// function loader(btn){
		// 	var loadUrl = $(btn).attr('load');
		// 	var tabPane = $(btn).attr('href');
		// 	//var po_id = $('#po_id').val();
		// 	// alert(btn);
		// 	// if(po_id == ""){
		// 	// 	//alert('waaaa');
		// 	// 	disEnbleTabs('.load-tab',false);
		// 	// 	$('.tab-pane').removeClass('active');
		// 	// 	$('.tab_link').parent().removeClass('active');
		// 	// 	$('#details').addClass('active');
		// 	// 	$('#details_link').parent().addClass('active');
		// 	// }
		// 	// else{
		// 	// 	//alert('we');
		// 	// 	disEnbleTabs('.load-tab',true);
		// 	// }
		// 	//alert(po_id);
		// 	$(tabPane).rLoad({url:baseUrl+loadUrl});
		// }
		
		$('#save-alladj').click(function()
		{
			//alert('afasdf');
			$("#multiple_adjustment_form").rOkay({
				btn_load		: 	$('#save-alladj'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				checkCart		:   'adj_session',
				onComplete		:	function(data){
					// alert(data);
					window.location = baseUrl+'inventory/multiple_adjustment_form';
				}
			});
			return false;
		});
		
		$('#recipe_link').click(function(){
			$('#recipe').rLoad({url:baseUrl+'inventory/multiAdj_items_load/'});
		});
		
		
		<?php elseif($use_js == 'inventoryUomJS'): ?>
		var mode = $('#mode').val();
		
		$('#unit_code').focus();
		
		//-----Unit Code
		if(mode == 'add'){
			$('#unit_code').focus();
			}else{
			$('#unit_code').attr('readonly', 'readonly');
		}
		
		$('.toUpper').blur(function(){
			$(this).val($(this).val().toUpperCase());
		});
		var inputs = $('.reqForm').each(function(){
			// alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		//working
		$('#save-btn').click(function(){
			var this_mode = $('#mode').val();
			
			$("#uom_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					// alert(data);
					
					if(data.status == 'warning'){
						rMsg(data.msg, 'warning');
						$('#unit_code').focus();
						}else{
						rMsg(data.msg, 'success');
						var form_mode = $('#mode').val();
						if(form_mode == 'edit'){
							//alert('edit');
							var input_name = '';
							var passed_form = '';
							var type_desc = 'Edit Unit of Measurement';
							var uom_details = '';
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
									if(uom_details != ''){
										uom_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
										}else{
										uom_details += input_name+':'+$(this).data('original')+'|'+this.value;
									}
								}
								
							});
							
							if(passed_form != ''){
								var formData = 'pk_id='+data.id+'&'+'uom_id='+data.id+'|=|'+passed_form;
								//alert(formData);
								$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
									
								});
							}
						}
					}
				}
			});
			
			if(mode == 'add'){
				setTimeout(function(){
					window.location = baseUrl+'inventory/uoms';
				},1500);
			}
			
			// setTimeout(function(){
			// window.location.reload();
			// },1500);
			
			return false;
		});
		
		//Uncomment all script within this block to show confirmbox sample, also uncomment del-btn in helper page
		//-----start
		$('.del-btn').click(function(){
			// bootbox.alert('sgdgsdh');
			var this_code = $('#unit_code').val();
			
			bootbox.dialog({
				message: baseUrl+'inventory/confirm_uom/'+this_code,
				title: "Test Confirm Box",
				buttons: {
					update: {
						label: "Update",
						className: "btn-primary",
						callback: function() {
							if(this_code != ''){
								rMsg('Updating the content...['+this_code+']','success');
								}else{
								rMsg('Unit Code is empty','warning');
							}	
						}
					},
					cancel: {
						label: "Close",
						className: "btn-default",
						callback: function() {
							rMsg('Closing the confirm box...','error');
							setTimeout(function(){
								window.location = baseUrl+'inventory/uoms';
							},1500);
						}
					}
				}
			});
			return false;
		});
		//-----end
		
		
		
		<?php elseif($use_js == 'multipleAdjustmentJS'): ?>
		
		$('#item_id').change(function(){
			var from_loc = $('#from_loc').val();
			//alert('From Loc:'+from_loc);
			set_item_details($(this).val(), from_loc);
		});
		
		function set_item_details(id, from_loc){
			if(id != ''){
				$.post(baseUrl+'inventory/get_inv_item_details/'+id+'/'+from_loc,function(data){
					$('#item-id').val(data.item_id);
					$('#item-uom').val(data.uom);
					// $('#item-location').val(data.from_loc);
					
					// alert('asd--'+data.qoh);
					// if(data.qoh != 'null' || data.qoh != ''){
					// var d_qoh = data.qoh;
					// }else{
					// var d_qoh = 0;
					// }
					
					var d_qoh = (data.qoh == null) ? 0 : data.qoh;
					// alert(d_qoh);
					
					$('#item-price').val(data.price).attr({'value' : data.price});
					$('#unit_price').val(data.price).attr({'value' : data.price});
					$('#qoh').val(d_qoh).attr({'value' : d_qoh});
					
					$('#select-uom').find('option').remove();
					$.each(data.opts,function(key,val){
						$('#select-uom').append($("<option/>", {
							value: val,
							text: key
						}));
					});
					
					
				},'json');
				}else{
				// alert('def'+id);
				$('#select-uom').empty();
				$('#item-price').val(0).attr({'value' : 0});
				$('#unit_price').val(0).attr({'value' : 0});
				$('#qoh').val(0).attr({'value' : 0});
			}
		}
		
		$('#add-adj-btn').click(function()
		{
			$("#add_adj_form").rOkay({
				btn_load		: 	$('#add-adj-btn'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
					// alert(data);
					rMsg('Item has been added.','success');
					$('#recipe_link').click();
					
				}
			});
			return false;
		});
		
		$('.del-item').click(function(){
			// alert($(this).attr('ref'));
			ref = $(this).attr('ref');
			if(ref == ""){
				ref = 0;
			}
			var formData = 'ref='+ref;
			$.post(baseUrl+'inventory/remove_adj_session',formData,function(data){
				
				rMsg('Item has been removed.','success');
				$('#recipe_link').click();
				
				// });
			});
		});
		
		
		//<-----start category js
		
		<?php elseif($use_js == 'categoryJS'): ?>
		var inputs = $('.reqForm').each(function(){
			// alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		var mode = $('#mode').val();	
		$('#description').focus();		
		$('#save-btn').click(function(){
			
			$("#stock_category_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					// alert(data);
					// rMsg(data.msg,'success');
					
					if(data.status == 'warning'){
						rMsg(data.msg, 'warning');
						$('#description').focus();
						}else{
						rMsg(data.msg, 'success');
						var form_mode = $('#mode').val();
						if(form_mode == 'edit'){
							//alert('edit');
							var input_name = '';
							var passed_form = '';
							var type_desc = 'Edit Stock Category';
							var stock_category_details = '';
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
									if(stock_category_details != ''){
										stock_category_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
										}else{
										stock_category_details += input_name+':'+$(this).data('original')+'|'+this.value;
									}
								}
								
							});
							
							if(passed_form != ''){
								var formData = 'pk_id='+data.id+'&'+'stock_catedory_id='+data.id+'|=|'+passed_form;
								//alert(formData);
								$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
									
								});
							}
						}
					}
				}
			});
			
			return false;
			
		});
		
		<?php elseif($use_js == 'StockLocationJS'): ?>
		var inputs = $('.reqForm').each(function(){
			// alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-btn').click(function(){
			$("#stock_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					//alert(data);
					// rMsg(data.msg,'success');
					
					if(data.status == 'warning'){
						rMsg(data.msg, 'warning');
						$('#loc_code').focus();
						}else{
						rMsg(data.msg, 'success');
						var form_mode = $('#mode').val();
						if(form_mode == 'edit'){
							//alert('edit');
							var input_name = '';
							var passed_form = '';
							var type_desc = 'Edit Stock Location';
							var stock_location_details = '';
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
									if(stock_location_details != ''){
										stock_location_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
										}else{
										stock_location_details += input_name+':'+$(this).data('original')+'|'+this.value;
									}
								}
								
							});
							
							if(passed_form != ''){
								var formData = 'pk_id='+data.id+'&'+'stock_location_id='+data.id+'|=|'+passed_form;
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
		
		<?php elseif($use_js == 'posDiscountsJS'): ?>
		
		var mode = $('#mode').val();	
		$('#description').focus();		
		$('#save-btn').click(function(){
			
			$("#stock_category_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					// alert(data);
					// rMsg(data.msg,'success');
					
					if(data.status == 'warning'){
						rMsg(data.msg, 'warning');
						$('#description').focus();
						}else{
						rMsg(data.msg, 'success')
					}
				}
			});
			
			return false;
			
		});
		//---->add stock
		
		<?php elseif($use_js == 'addstockMasterJS'): ?>
		$('.tab_link').click(function(event)
		{
			event.preventDefault();
			var id = $(this).attr('id');
			loader('#'+id);
		});
		
		var selected = $('#idx').val();
		var data = decodeURI(selected).split('|');
		// alert(data[1]);
		if (data[1] == 'pricing_details_link') {
			loader('#pricing_details_link');			
			}else if(data[1] == 'barcode_details_link'){
			loader('#barcode_details_link');	
			}else{
			loader('#details_link');	
		}	 
		
		function loader(btn)
		{
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var selected = $('#idx').val();
			var data = decodeURI(selected).split('|');
			if (data[1] == 'pricing_details_link') {
				enableTabs('.load-tab',true);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#pricing').addClass('active');
				$('#pricing_details_link').parent().addClass('active');
				}else if(data[1] == 'barcode_details_link'){
				enableTabs('.load-tab',true);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#barcode').addClass('active');
				$('#barcode_details_link').parent().addClass('active');
				}else if(selected && selected != 'new'){
				enableTabs('.load-tab',true);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			}
			else{
				enableTabs('.load-tab',false);
			}
			var item_id = $('#idx').val();
			$(tabPane).rLoad({url:baseUrl+loadUrl+'/'+item_id});
		}
		function enableTabs(id,enable)
		{
			// alert('val '+enable);
			if (enable) {
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
				} else {
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
		
		//---->end	
		
		
		
		
		<?php elseif($use_js == 'stockMasterJS'): ?>
		$('.tab_link').click(function(event)
		{
			event.preventDefault();
			var id = $(this).attr('id');
			loader('#'+id);
		});
		
		
		
		
		loader('#details_link');
		function loader(btn)
		{
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var selected = $('#idx').val();
			// alert('hidden value:'+selected);
			if (selected && selected != 'new') {
				/* selected = 'add'; */
				enableTabs('.load-tab',true);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
				} else {
				enableTabs('.load-tab',false);
			}
			var item_id = $('#idx').val();
			$(tabPane).rLoad({url:baseUrl+loadUrl+'/'+item_id});
		}
		function enableTabs(id,enable)
		{
			// alert('val '+enable);
			if (enable) {
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
				} else {
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
		<?php elseif($use_js == 'addstockMasterFormJS'): ?>
		// $('#report_qty').prop('disabled', true);
		$('#report_qty').attr('readonly', 'readonly');
		
		if ($('#mode').val() == 'edit' ){
			if($('#other_cards').val() == '1'){
				$('.card_type_rows').show();
				}else{
				$('.card_type_rows').hide();
			}
			
			}else{
			$('.card_type_rows').hide();
		}
		$('.toUpper').blur(function(){
			$(this).val($(this).val().toUpperCase());
		});
		
		$('#add_card_link').click(function(){
			//	alert($('#mode').val());
			// $('.card_type_rows').slideUp();
			$('.card_type_rows').toggle();
			return false;
		});
		
		$('#report_uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
				// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
				$('#report_qty').attr('value', data).val(data);
			});
			return false;
		});
		
		var inputs = $('.reqForm').each(function(){
			// alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		
		// var cos = $('.reqForms').each(function(){
		// alert($(this).data('original')+'<~~~>'+this.value);
		// $(this).data('original', this.value);
		// })
		
		$('#inactive-stock-btn').click(function(){
			
			var stock_id = $('#stock_id').val()
			var stock_code = $('#stock_code').val()
			var stock_deletion_url = baseUrl + 'inventory/stock_deletion';
			$.post(stock_deletion_url, {'stock_id' : stock_id,'stock_code':stock_code}, function(data){
				rMsg(data, 'success');	
				setTimeout(function(){
					window.location = baseUrl+'inventory/stock_master';		
				},1500);
			});
			
		});
		
		
		$('#save-stock-btn').click(function(){
			// alert('Clicked----');
			$("#stock_main_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					// alert('UPPER DATA CONTENT : '+data);
					//console.log(data);
					
					if(data.status == 'warning'){
						rMsg(data.msg, 'warning');
						$('#stock_code').focus();
						}else{
						// alert('ETO KA : '+data.id);
						var stock_id = data.id;
						var form_mode = $('#mode').val();
						var passed_form = '';
						var input_name = '';
						var cost_of_sales_form = '';
						var stock_logs_details = '';
						
						rMsg(data.msg, 'success');
						setTimeout(function()
						{
							// window.location = baseUrl + 'inventory/stock_master'; //-----original script
							window.location = baseUrl + 'inventory/stock_master/'+stock_id+'|'+'pricing_details_link';
						},1500);
						
					}
				}
			});
			return false;
		});
		$('#stock-back-btn').on('click',function(event)
		{
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master';
		});
		
		
		<?php elseif($use_js == 'stockMasterFormJS'): ?>
		// $('#report_qty').prop('disabled', true);
		$('#report_qty').attr('readonly', 'readonly');
		
		if ($('#mode').val() == 'edit' ){
			if($('#other_cards').val() == '1'){
				$('.card_type_rows').show();
				}else{
				$('.card_type_rows').hide();
			}
			
			}else{
			$('.card_type_rows').hide();
		}
		$('.toUpper').blur(function(){
			$(this).val($(this).val().toUpperCase());
		});
		
		$('#add_card_link').click(function(){
			//	alert($('#mode').val());
			// $('.card_type_rows').slideUp();
			$('.card_type_rows').toggle();
			return false;
		});
		
		$('#report_uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
				// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
				$('#report_qty').attr('value', data).val(data);
			});
			return false;
		});
		
		var inputs = $('.reqForm').each(function(){
			// alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		
		// var cos = $('.reqForms').each(function(){
		// alert($(this).data('original')+'<~~~>'+this.value);
		// $(this).data('original', this.value);
		// })
		
		$('#inactive-stock-btn').click(function(){
			
			var stock_id = $('#stock_id').val()
			var stock_code = $('#stock_code').val()
			var stock_deletion_url = baseUrl + 'inventory/stock_deletion';
			$.post(stock_deletion_url, {'stock_id' : stock_id,'stock_code':stock_code}, function(data){
				rMsg(data, 'success');	
				setTimeout(function(){
					window.location = baseUrl+'inventory/stock_master';		
				},1500);
			});
			
		});
		
		
		$('#save-stock-btn').click(function(){
			// alert('Clicked----');
			$("#stock_main_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					// alert('UPPER DATA CONTENT : '+data);
					console.log(data);
					if(data.status == 'warning'){
						rMsg(data.msg, 'warning');
						$('#stock_code').focus();
						}else{
						// alert('ETO KA : '+data.id);
						var stock_id = data.id;
						var form_mode = $('#mode').val();
						var passed_form = '';
						var input_name = '';
						var cost_of_sales_form = '';
						var stock_logs_details = '';
						
						if(form_mode == 'edit'){
							// rMsg('this is ADD', 'success');
							// }else{
							// rMsg('this is EDIT', 'success');
							
							inputs.each(function(){
								input_name = $(this).attr('id');
								
								if($(this).data('original') != this.value){
									//alert('Updated '+input_name+'--'+'OLD : '+$(this).data('original')+'---NEW : '+this.value);
									passed_form += input_name+'=OLD:'+$(this).data('original')+'|-|NEW:'+this.value+'|--|';
									
									if(stock_logs_details != ''){
										stock_logs_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
										}else{
										stock_logs_details += input_name+':'+$(this).data('original')+'|'+this.value;
									}
								}
								
							});
							var data_for_stock_logs = 'stock_id:'+stock_id+'::'+stock_logs_details;
							//alert(data_for_stock_logs);
							
							$.post(baseUrl+'inventory/stock_master_write_to_stock_logs/', {'data_for_stock_logs' : data_for_stock_logs, 'type_desc' : 'Update Stock Master Details'}, function(stock_master_logs){
								//alert(stock_master_logs);
							});
							
							
							// cos.each(function(){
							// input_name = $(this).attr('id');
							// input_ = $(this).attr('name');
							
							// if($(this).data('original') != this.value){
							// //alert('Updated '+input_name+'--'+'OLD : '+$(this).data('original')+'---NEW : '+this.value);
							// cost_of_sales_form += input_+'=OLD:'+$(this).data('original')+'|-|NEW:'+this.value+'|--|';
							// }
							
							// });
							// var cost_of_sales_data = 'cost_of_sales'+cost_of_sales_form;
							// alert(cost_of_sales_data);
							// var formData = 'pk_id='+stock_id+'&'+passed_form; //OLD
							
							var formData = 'pk_id='+stock_id+'|=|'+passed_form;
							// alert(formData);
							$.post(baseUrl+'inventory/write_to_db_audit_trail/', {'form_vals' : formData, 'stock_id' : stock_id, 'type_desc' : 'Updated Stock Master Details'}, function(data2){
								
							});
						}
						
						rMsg(data.msg, 'success');
						setTimeout(function()
						{
							// window.location = baseUrl + 'inventory/stock_master'; //-----original script
							window.location = baseUrl + 'inventory/stock_master/';
						},1500);
						
					}
				}
			});
			return false;
		});
		$('#stock-back-btn').on('click',function(event)
		{
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master';
		});
		
		
		//#################BARCODE
		<?php elseif($use_js == 'addstockBarcodeFormJs'): ?>
		// alert('Stock Barcode Details...');
		// alert('try');
		$('#init-contents').show();
		$('#file-spinner').hide();
		$('#stock-barcode-contents').hide();
		$('#pricing_def').show();
		$('#new_pricing_def').hide();
		
		//======================
		$('#con_barcode').blur(function(){
			var con_barcode = $(this).val();
			var barcode = $('#barcodes').val();	 
			
			if(barcode != con_barcode){
				rMsg('Barcode does not match!','error');
				$('#con_barcode').focus();
			}
			
			return false;
		});
		//======================
		
		$('.copy_link').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('.copy_link').click(function(){
			var counter1 = $('.countme_1').val();
			alert('This Counter 1 : '+counter1);
			// // var counter2 = $('.countme_2').val();
			// // alert(counter1+'~~~'+counter2);
			// if(counter1 == '' || counter2 == ''){
			// rMsg('All Price Fields Are Empty','warning');
			// }else{
			// $('.even_num').attr({'value':counter2}).val(counter2);
			// $('.odd_num').attr({'value':counter1}).val(counter1);
			// // rMsg('Has Content','success');
			// }
			return false;
		});
		
		
		$('#copier_link, #clear_link').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#copier_link').click(function(){
			// alert('You have clicked the copier link!');
			var counter1 = $('.countme_1').val();
			// alert('This Counter 1 : '+counter1);
			if(counter1 == ''){
				rMsg('First Price Field Is Empty','warning');
				$('.first_row').focus();
			}
			else{
				$('.first_row').attr({'value':counter1}).val(counter1);
				$('.following_row').attr({'value':counter1}).val(counter1);
			}
			return false;
		});
		
		$('#clear_link').click(function(){
			$('.branch_type_price').attr({'value' : ''}).val('');
			return false;
		});
		
		$('#qty').attr('readonly', 'readonly');
		$('#uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
				// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
				$('#qty').attr('value', data).val(data);
			});
			return false;
		});
		
		$(".num_with_decimal").on("keypress keyup blur",function (event) {
			$(this).val($(this).val().replace(/[^0-9\.]/g,''));
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
		
		$('.price_link').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#save-all-branch-btn').click(function(){
			$('#for_markup_branch').val('All');
			rMsg('Save to all branch', 'success')
		});
		
		$('.price_link').click(function(){
			// var hidden_branch_id = $(this).attr('ref_br_id');
			
			// bootbox.dialog({
			// message: baseUrl+'inventory/load_srp_popup/'+hidden_branch_id,
			// title: "Regular SRP",
			// buttons: {
			// update: {
			// label: "Update",
			// className: "btn-info",
			// callback: function() {
			// if(hidden_branch_id != ''){
			// rMsg('Updating the content...['+hidden_branch_id+']','success');
			// }else{
			// rMsg('Unit Code is empty','warning');
			// }	
			// }
			// },
			// update_all: {
			// label: "Update All Branches",
			// className: "btn-primary",
			// callback: function() {
			// if(hidden_branch_id != ''){
			// rMsg('Updating all the content...['+hidden_branch_id+']','success');
			// }else{
			// rMsg('Unit Code is empty','warning');
			// }	
			// }
			// },
			// cancel: {
			// label: "Close",
			// className: "btn-default",
			// callback: function() {
			// // rMsg('Closing the confirm box...','error');
			// // setTimeout(function(){
			// // window.location = baseUrl+'inventory/uoms';
			// // },1500);
			// }
			// }
			// }
			// });
			// return false;
		});
		
		
		
		function load_stock_barcodes_list(){
			var ref = $('#hidden_stock_id').val();
			// alert('ref : '+ref);
			var dtr_url = '<?php echo base_url() ?>inventory/add_load_stock_barcodes';
			$('#file-spinner').show();
			$('#init-contents').hide();
			$('#stock-barcode-contents').hide();
			
			$.post(dtr_url, {'ref' : ref}, function(data){
				$('#file-spinner').hide();
				$('#init-contents').hide();
				$('#stock-barcode-contents').show();
				$('#stock-barcode-contents').html(data);
				return false;
			});
		}
		
		load_stock_barcodes_list();
		
		$('#save-barcode-btn').click(function()
		{
			// alert($("#stock_barcode_form").serialize());
			// var complete_form_data = $("#stock_barcode_form").serialize();
			// complete_form_data = complete_form_data+'&'
			// alert('price barcode details btn');
			$("#stock_barcode_form").rOkay({
				btn_load		: 	$('#save-barcode-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					// console.log(data);
					//alert(data);
					//alert(data.result);
					// console.log($('#srs_nova_retail_price_old').val());
					if (typeof data.result != "undefined") {
						rMsg(data.msg,data.result);
						if (data.result == "error" || data.result == "warning")
						$('#barcode').focus();
						
						if (data.result == "success"){
							
							var form_mode = $('#barcode_mode').val();
							var p_stock_id = $('#stock_id').val();
							var p_barcode = $('#barcode').val();
							var p_branch_code = $('#for_markup_branch').val();
							var p_sales_type = $('#hidden_sales_type').val();
							var passed_form = '';
							var old_val = '';
							var data_update = '';
							var sample = [];
							var input_name = '';
							
							//rMsg(data.msg, 'success');
							//	setTimeout(function()
							//{
							// window.location = baseUrl + 'inventory/stock_master'; //-----original script
							//window.location = baseUrl + 'inventory/stock_master/';
							load_stock_barcodes_list();
							//},1000);
						}
						
					}
				}
			});
			return false;
		});
		$('#back-barcode-btn').on('click',function(event)
		{
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master';
		});	
		
		<?php elseif($use_js == 'addreloadBarcodeDetailsJs'): ?>
		// alert('load barcodes alert...');
		
		// $('.edit_me_btn').tooltip('show'); //-----DISPLAYS TOOLTIP UPON LOAD OF PAGE
		//-----DISPLAYS TOOLTIP ON HOVER
		$('.edit_me_btn, .add_stock_barcode').tooltip({
			'show': true,
			'placement': 'left',
			// 'title': "Please remember to..."
		});
		
		$('.add_stock_barcode').click(function(){
			$('#mode').attr({'value' : 'add'}).val('add'); //-----Change MAIN MODE of form from EDIT to ADD
			$('.form_mode').attr({'value' : 'add'}).val('add'); //-----Change MAIN MODE of form from ADD to EDIT
			$('#barcode_mode').attr({'value' : 'add'}).val('add'); //-----Change mode of form from EDIT to ADD
			var inactive = 0;
			// alert('Current Page Mode after clicking the ADD btn : '+$('.form_mode').val());
			// alert('Current Page Barcode Mode after clicking the ADD btn : '+$('#barcode_mode').val());
			$('#save-all-branch-btn').attr('disabled','disabled');
			$('#barcodes').focus();
			$('#barcode, .uom_dropdown, #con_barcode, .sales_type_dropdown').removeAttr('readonly');
			$('#computed_srp').attr({'value' : ''}).val('');
			$('#prevailing_unit_price').attr({'value' : ''}).val('');
			$('#landed_cost_markup').attr({'value' : ''}).val('');
			$('#prevailing_unit_price').attr("readonly",true);
			$('#landed_cost_markup').attr("readonly",true);
			$('#cost_of_sales_markup').attr("readonly",true);
			$('#cost_of_sales_markup').attr({'value' : ''}).val('');
			$('#barcode').attr({'value' : ''}).val('');
			$('#con_barcode').attr({'value' : ''}).val('');
			$('#hidden_barcode').attr({'value' : ''}).val('');
			$('.barcode_short_desc').attr({'value' : ''}).val('');
			$('.barcode_desc').attr({'value' : ''}).val('');
			$('#qty').attr({'value' : ''}).val('');
			$('.uom_dropdown').attr({'value' : ''}).val('');
			$('#hidden_sales_type').attr({'value' : ''}).val('');
			// $('.barcode_inactive_dropdown').attr({'value' : inactive}).val(inactive);
			
			$('#short_desc').attr({'old_val' : ''});
			// $('#description').attr({'old_val' : ''});
			$('.barcode_desc').attr({'old_val' : ''});
			
			$('#pricing_def').show();
			$('#new_pricing_def').hide();
			$('#new_pricing_def').html('');
			
			//old val 
			$('#computed_srp').attr({'old_val' : ''}).val('');
			$('#prevailing_unit_price').attr({'old_val' : ''}).val('');
			$('#landed_cost_markup').attr({'old_val' : ''}).val('');
			$('#cost_of_sales_markup').attr({'old_val' : ''}).val('');
			
			return false;
		});	
		
		function load_new_pricing(){
			var barcode = $('#barcodes').val();
			var sales_type = $('#sales_type_id').val();
			// alert(barcode+'---Sales Type : '+sales_type);
			var id = $('#ids').val();
			var this_url = baseUrl+'inventory/add_load_stock_barcode_prices';
			$.post(this_url, {'barcode' : barcode}, function(data){
				$('#pricing_def').hide();
				$('#new_pricing_def').show();
				$('#new_pricing_def').html(data);
				$('#'+id).css("background-color", " #f8f6ba");	
				return false;
			});
		}
		
		function load_stock_barcodes_list(){
			var ref = $('#hidden_stock_id').val();
			// alert('ref : '+ref);
			var dtr_url = '<?php echo base_url() ?>inventory/add_load_stock_barcodes';
			$('#file-spinner').show();
			$('#init-contents').hide();
			$('#stock-barcode-contents').hide();
			
			$.post(dtr_url, {'ref' : ref}, function(data){
				$('#file-spinner').hide();
				$('#init-contents').hide();
				$('#stock-barcode-contents').show();
				$('#stock-barcode-contents').html(data);
				
				return false;
			});
			
		}
		
		$('.edit_me_btn').click(function(){
			// $('[data-toggle="tooltip"]').tooltip(); 
			// $(this)
			$('#mode').attr({'value' : 'edit'}).val('edit'); //-----Change MAIN MODE of form from ADD to EDIT
			$('.form_mode').attr({'value' : 'edit'}).val('edit'); //-----Change MAIN MODE of form from ADD to EDIT
			$('#barcode_mode').attr({'value' : 'edit'}).val('edit'); //-----Change mode of form from ADD to EDIT
			var ref_short_desc = $(this).attr('ref_short_desc');
			var ref_desc = $(this).attr('ref_desc');
			var ref = $(this).attr('ref');
			$('#short_desc_old').val(ref_short_desc); 
			$('#desc_old').val(ref_desc); 
			$('#ids').val(ref);
			var barcode = $(this).attr('ref_barcode');
			var uom = $(this).attr('ref_uom');
			var qty = $(this).attr('ref_qty');
			var sales_type_id = $(this).attr('ref_sales_type_id');
			var inactive = $(this).attr('ref_status');    
			//alert(barcode);
			$('#hidden_uomss').attr({'value' : uom}).val(uom);
			$('#barcodes').attr({'value' : barcode}).val(barcode);
			$('#hidden_sales_type').attr({'value' : sales_type_id}).val(sales_type_id);
			$('#con_barcode').attr({'value' : barcode}).val(barcode);
			$('#hidden_barcode').attr({'value' : barcode}).val(barcode);
			$('.barcode_short_desc').attr({'value' : ref_short_desc}).val(ref_short_desc);
			$('.barcode_desc').attr({'value' : ref_desc}).val(ref_desc);
			$('#qty').attr({'value' : qty}).val(qty);
			$('.sales_type_dropdown').attr({'value' : sales_type_id}).val(sales_type_id);
			$('.uom_dropdown').attr({'value' : uom}).val(uom);
			// $('.barcode_inactive_dropdown').attr({'value' : inactive}).val(inactive);
			
			$('#computed_srp').attr({'value' : ''}).val('');
			$('#prevailing_unit_price').attr({'value' : ''}).val('');
			$('#landed_cost_markup').attr({'value' : ''}).val('');
			$('#cost_of_sales_markup').attr({'value' : ''}).val('');
			
			//old val 
			$('#computed_srp').attr({'old_val' : ''}).val('');
			$('#prevailing_unit_price').attr({'old_val' : ''}).val('');
			$('#landed_cost_markup').attr({'old_val' : ''}).val('');
			$('#cost_of_sales_markup').attr({'old_val' : ''}).val('');
			
			$('#prevailing_unit_price').attr("readonly",true);
			$('#landed_cost_markup').attr("readonly",true);
			$('#cost_of_sales_markup').attr("readonly",true);
			
			// alert('Short Desc : '+ref_short_desc+' Desc : '+ref_desc);
			// alert('Short Desc 2 : '+$('#short_desc').val()+' Desc 2 : '+$('#description').val());
			
			$('#short_desc').attr({'old_val' : ref_short_desc});
			$('.barcode_desc').attr({'old_val' : ref_desc});
			
			$('#barcode, .uom_dropdown, #con_barcode, .sales_type_dropdown').attr('readonly', 'readonly');
			$('#save-all-branch-btn').attr('disabled','disabled');
			load_stock_barcodes_list();
			load_new_pricing();
			return false;
		});
		
		//-----FOR POP-UP VIEW
		// $('.edit_me_btn').rPopView({
		// wide: true,
		// asJson: true,
		// onComplete: function(data){
		// $('[data-bb-handler=cancel]').click();
		// }
		// });	
		
		
		<?php elseif($use_js == 'stockBarcodeFormJs'): ?>
		// alert('Stock Barcode Details...');
		// alert('try');
		$('#init-contents').show();
		$('#file-spinner').hide();
		$('#stock-barcode-contents').hide();
		$('#pricing_def').show();
		$('#new_pricing_def').hide();
		
		//======================
		$('#con_barcode').blur(function(){
			var con_barcode = $(this).val();
			var barcode = $('#barcode').val();
			
			if(barcode != con_barcode){
				rMsg('Barcode does not match!','error');
				$('#con_barcode').focus();
			}
			
			return false;
		});
		//======================
		
		$('.copy_link').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('.copy_link').click(function(){
			var counter1 = $('.countme_1').val();
			//alert('This Counter 1 : '+counter1);
			// // var counter2 = $('.countme_2').val();
			// // alert(counter1+'~~~'+counter2);
			// if(counter1 == '' || counter2 == ''){
			// rMsg('All Price Fields Are Empty','warning');
			// }else{
			// $('.even_num').attr({'value':counter2}).val(counter2);
			// $('.odd_num').attr({'value':counter1}).val(counter1);
			// // rMsg('Has Content','success');
			// }
			return false;
		});
		
		
		$('#copier_link, #clear_link').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#copier_link').click(function(){
			// alert('You have clicked the copier link!');
			var counter1 = $('.countme_1').val();
			// alert('This Counter 1 : '+counter1);
			if(counter1 == ''){
				rMsg('First Price Field Is Empty','warning');
				$('.first_row').focus();
			}
			else{
				$('.first_row').attr({'value':counter1}).val(counter1);
				$('.following_row').attr({'value':counter1}).val(counter1);
			}
			return false;
		});
		
		$('#clear_link').click(function(){
			$('.branch_type_price').attr({'value' : ''}).val('');
			return false;
		});
		
		$('#qty').attr('readonly', 'readonly');
		$('#uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
				// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
				$('#qty').attr('value', data).val(data);
			});
			return false;
		});
		
		$(".num_with_decimal").on("keypress keyup blur",function (event) {
			$(this).val($(this).val().replace(/[^0-9\.]/g,''));
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
		
		$('.price_link').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#save-all-branch-btn').click(function(){
			$('#for_markup_branch').val('All');
			rMsg('Save to all branch', 'success')
		});
		
		$('.price_link').click(function(){
			// var hidden_branch_id = $(this).attr('ref_br_id');
			
			// bootbox.dialog({
			// message: baseUrl+'inventory/load_srp_popup/'+hidden_branch_id,
			// title: "Regular SRP",
			// buttons: {
			// update: {
			// label: "Update",
			// className: "btn-info",
			// callback: function() {
			// if(hidden_branch_id != ''){
			// rMsg('Updating the content...['+hidden_branch_id+']','success');
			// }else{
			// rMsg('Unit Code is empty','warning');
			// }	
			// }
			// },
			// update_all: {
			// label: "Update All Branches",
			// className: "btn-primary",
			// callback: function() {
			// if(hidden_branch_id != ''){
			// rMsg('Updating all the content...['+hidden_branch_id+']','success');
			// }else{
			// rMsg('Unit Code is empty','warning');
			// }	
			// }
			// },
			// cancel: {
			// label: "Close",
			// className: "btn-default",
			// callback: function() {
			// // rMsg('Closing the confirm box...','error');
			// // setTimeout(function(){
			// // window.location = baseUrl+'inventory/uoms';
			// // },1500);
			// }
			// }
			// }
			// });
			// return false;
		});
		
		
		
		function load_stock_barcodes_list(){
			var ref = $('#hidden_stock_id').val();
			// alert('ref : '+ref);
			var dtr_url = '<?php echo base_url() ?>inventory/load_stock_barcodes';
			$('#file-spinner').show();
			$('#init-contents').hide();
			$('#stock-barcode-contents').hide();
			
			$.post(dtr_url, {'ref' : ref}, function(data){
				$('#file-spinner').hide();
				$('#init-contents').hide();
				$('#stock-barcode-contents').show();
				$('#stock-barcode-contents').html(data);
				return false;
			});
		}
		
		load_stock_barcodes_list();
		
		$('#save-barcode-btn').click(function()
		{
			// alert($("#stock_barcode_form").serialize());
			// var complete_form_data = $("#stock_barcode_form").serialize();
			// complete_form_data = complete_form_data+'&'
			// alert('price barcode details btn');
			$("#stock_barcode_form").rOkay({
				btn_load		: 	$('#save-barcode-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					// console.log(data);
					//	alert(data.result);
					//	alert(data);
					// console.log($('#srs_nova_retail_price_old').val());
					if (typeof data.result != "undefined") {
						rMsg(data.msg,data.result);
						if (data.result == "error" || data.result == "warning")
						$('#barcode').focus();
						
						if (data.result == "success"){
							var form_mode = $('#barcode_mode').val();
							var p_stock_id = $('#stock_id').val();
							var p_barcode = $('#barcode').val();
							var p_branch_code = $('#for_markup_branch').val();
							var p_sales_type = $('#hidden_sales_type').val();
							var passed_form = '';
							var old_val = '';
							var data_update = '';
							var sample = [];
							var input_name = '';
							//alert('Barcode Form Mode : '+form_mode);
							
							if(form_mode == 'edit'){
								passed_form = 'stock_id='+p_stock_id+'&barcode='+p_barcode+'|=|';
								
								$('.required_form').each(function(){
									input_name = $(this).attr('name');
									old_val = $(this).attr('old_val');
									
									if(this.value != old_val){
										// alert('OLD : '+old_val+'---NEW : '+this.value);
										// passed_form += '&'+input_name+'=OLD:'+old_val+'|-|NEW:'+this.value+'|--|';
										passed_form += input_name+'=OLD:'+old_val+'|-|NEW:'+this.value+'|--|';
										//	data_update = 'stock_id||'+p_stock_id+'||'+'barcode'+'||'+p_barcode+'||'+'sale_type_id'+'||'+p_sales_type+'||'+input_name+'||'+old_val+'|'+this.value;
										//	sample = [['stock_id',p_stock_id],['barcode',p_barcode],['sale_type_id',p_sales_type],['affected_values',old_val+'|'+this.value]];
										//----wait lang----*****--------
										
										if(p_branch_code != ''){
											sample = p_branch_code+'*';
											}else{
											sample ='';
										}
										//	alert(sample);
										$.post(baseUrl+'inventory/write_to_db_barcode_prices_approval/',{
											'stock_id':p_stock_id,
											'branch':p_branch_code,
											'barcode':p_barcode,
											'sale_type_id':p_sales_type,
											'affected_values':sample+input_name+'||'+old_val+'|'+this.value
											}, function(data){
											//alert(data+'hh');
										});
										//-----------------*****---------------
										//	alert(p_branch_code);
									}
								});
								
								// alert('Passed Form : '+passed_form);
								$.post(baseUrl+'inventory/write_to_db_audit_trail/', {'form_vals' : passed_form, 'stock_id' : p_stock_id, 'type_desc' : 'Updated Stock Barcode Details'}, function(data2){
									
								});
								}else if(form_mode == 'add'){
								var a_stock_id = data.stock_id;
								var a_barcode = data.barcode;
								
								passed_form = 'stock_id='+p_stock_id+'&barcode='+p_barcode+'&'+$("#stock_barcode_form").serialize();
								
								$.post(baseUrl+'inventory/write_to_db_audit_trail/', {'form_vals' : passed_form, 'stock_id' : a_stock_id, 'type_desc' : 'Added Stock Barcode Details'}, function(data2){
									
								});
								
							}
							
							load_stock_barcodes_list();
						}
						
					}
				}
			});
			return false;
		});
		$('#back-barcode-btn').on('click',function(event)
		{
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master';
		});
		<?php elseif($use_js == 'srpPopJS'): ?>
		
		// alert('SRP Pop Goes Here...');
		function get_main_branch_id(branch_code){
			// alert('[main] Old Branch:'+branch_code);
			var con_url = baseUrl + 'inventory/get_branch_id_from_code';
			$.post(con_url, {'branch_code' : branch_code}, function(data){
				// alert('[main] NEW '+data);
				// alert('[main] Passed branch id : '+branch_code);
				$('.cc_hidden_branch_id').attr('value', data).val(data);
				$('.br_dropdown').attr('value', branch_code).val(branch_code);
			});
		}
		
		var this_branch_code = $('.br_dropdown').val();
		// alert(this_branch_code+'<~~~>'+$('.cc_hidden_branch_id').val());
		get_main_branch_id(this_branch_code);
		
		$('.br_dropdown').change(function(){
			// alert('load meeee');
			var branch_code = $(this).val();
			// alert(' Labas ng Add button :'+branch_code);
			
			get_main_branch_id(branch_code);
			
			return false;
		});
		
		$('#srp_qty').attr('readonly', 'readonly');
		$('#srp_uom').change(function(){
			var uom = $(this).val();
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
				$('#srp_qty').attr('value', data).val(data);
				
				// compute_landed_cost_markup();
				// compute_cost_of_sales_markup();
				// display_computed_srp();
			});
			return false;
		});
		
		$(".num_with_decimal").on("keypress keyup blur",function (event) {
			$(this).val($(this).val().replace(/[^0-9\.]/g,''));
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
		
		// $('#prevailing_unit_price').change(function(){
		// var prev_unit_price = $(this).val();
		// // alert(prev_unit_price);
		// $('#landed_cost_markup').attr({'value':prev_unit_price}).val(prev_unit_price);
		// return false;
		// });
		
		function compute_landed_cost_markup(){
			var prev_unit_price = $('#prevailing_unit_price').val();
			
			if(prev_unit_price > 0){
				var avg_net_cost = $('#hidden_avg_net_cost').val();
				var qty = $('#srp_qty').val();
				// alert(qty);
				// var times_to = 100;
				
				var pre_comp = (prev_unit_price-(avg_net_cost*qty))/prev_unit_price;
				var final_comp = pre_comp*100;
				
				$('#landed_cost_markup').attr({'value':final_comp.toFixed(4)}).val(final_comp.toFixed(4));
				}else{
				$('#landed_cost_markup').attr({'value':0}).val(0);
			}
			
		}
		compute_landed_cost_markup();
		
		function compute_cost_of_sales_markup(){
			var prev_unit_price1 = $('#prevailing_unit_price').val();
			
			if(prev_unit_price1 > 0){
				var cost_of_sales = $('#hidden_cost_of_sales').val();
				// alert(cost_of_sales);
				var qty1 = $('#srp_qty').val();
				// var times_to = 100;
				
				var pre_comp1 = (prev_unit_price1-(cost_of_sales*qty1))/prev_unit_price1;
				var final_comp1 = pre_comp1*100;
				
				$('#cost_of_sales_markup').attr({'value':final_comp1.toFixed(4)}).val(final_comp1.toFixed(4));
				}else{
				$('#cost_of_sales_markup').attr({'value':0}).val(0);
			}
			
		}
		compute_cost_of_sales_markup();
		
		function display_computed_srp(){
			
			var cost_of_salesA = $('#hidden_cost_of_sales').val();
			var landed_cost_markup = $('#landed_cost_markup').val();
			var qtyA = $('#srp_qty').val();
			
			var computed_srp = cost_of_salesA/((100-landed_cost_markup)/100);
			var tot_com_srp = computed_srp*qtyA;
			if(tot_com_srp > 0){
				$('#computed_srp').attr({'value':tot_com_srp.toFixed(4)}).val(tot_com_srp.toFixed(4));
				}else{
				$('#computed_srp').attr({'value':0}).val(0);
			}
		}
		
		display_computed_srp();
		
		<?php elseif($use_js == 'marginalMarkdownPopJS'): ?>
		
		$('#markup1').blur(function(){
			var landed_latest_cost = $('#hidden_latest_landed_cost').val();
			var markup1 =  $('#markup1').val();
			var markup_val = ((markup1 / 100) * landed_latest_cost);
			var unit_price = (parseFloat(markup_val) + parseFloat(landed_latest_cost));
			$('#unit_price1').val(unit_price);
		});
		
		$('#markup2').blur(function(){
			var landed_latest_cost = $('#hidden_latest_landed_cost').val();
			var markup2 =  $('#markup2').val();
			if( parseFloat($('#markup1').val()) > parseFloat($('#markup2').val())){
				rMsg('markup 2 - should be lower than markup 1', 'error');
				$('#markup2').val('');
				$('#unit_price2').val('');
				}else{
				var markup_val = ((markup2 / 100) * landed_latest_cost);
				var unit_price = (parseFloat(markup_val) + parseFloat(landed_latest_cost));
				$('#unit_price2').val(unit_price);
			}	 
			
		});
		
		$('#markup3').blur(function(){
			var landed_latest_cost = $('#hidden_latest_landed_cost').val();
			var markup3 =  $('#markup3').val();
			if( parseFloat($('#markup2').val()) > parseFloat($('#markup3').val())){
				rMsg('markup 3 - should be lower than markup 2', 'error');
				$('#markup3').val('');
				$('#unit_price3').val('');
				}else{
				var markup_val = ((markup3 / 100) * landed_latest_cost);
				var unit_price = (parseFloat(markup_val) + parseFloat(landed_latest_cost));
				$('#unit_price3').val(unit_price);
			}
		});
		
		
		$('.branch_row').hide();
		$('#branch_id').attr({'readonly' : 'readonly'});
		
		function get_main_branch_id(branch_code){
			var con_url = baseUrl + 'inventory/get_branch_id_from_code';
			$.post(con_url, {'branch_code' : branch_code}, function(data){
				
				$('.cc_hidden_branch_id').attr('value', data).val(data);
				$('.br_dropdown').attr('value', branch_code).val(branch_code);
			});
		}
		
		
		function enableFields(){
			var status = $('.inactive_dropdown').val();
			
			if(status==1){
				$('.branch_row').hide();
				$('#branch_id').attr({'readonly' : 'readonly'});
				
				$('#qty1').attr('disabled','disabled');
				$('#qty2').attr('disabled','disabled');
				$('#qty3').attr('disabled','disabled');
				
				$('#markup1').attr('disabled','disabled');
				$('#markup2').attr('disabled','disabled');
				$('#markup3').attr('disabled','disabled');
				
				$('#unit_price1').attr('disabled','disabled');
				$('#unit_price2').attr('disabled','disabled');
				$('#unit_price3').attr('disabled','disabled');		
				
				}else if(status==''){
				
				$('.branch_row').show();
				$('#branch_id').removeAttr('readonly');
				
				$('#qty1').removeAttr('disabled');
				$('#qty2').removeAttr('disabled');
				$('#qty3').removeAttr('disabled');
				
				$('#markup1').removeAttr('disabled');
				$('#markup2').removeAttr('disabled');
				$('#markup3').removeAttr('disabled');
				
				$('#unit_price1').removeAttr('disabled');
				$('#unit_price2').removeAttr('disabled');
				$('#unit_price3').removeAttr('disabled');
				$('#branch_id').removeAttr('readonly');
			}
		}
		
		$('.inactive_dropdown').change(function(){
			enableFields();
			return false;
		});
		
		
		
		<?php elseif($use_js == 'schedMarkdownPopJS'): ?>
		function get_main_branch_id(branch_code){
			var con_url = baseUrl + 'inventory/get_branch_id_from_code';
			$.post(con_url, {'branch_code' : branch_code}, function(data){
				
				$('.cc_hidden_branch_id').attr('value', data).val(data);
				$('.br_dropdown').attr('value', branch_code).val(branch_code);
			});
		}
		
		enableMarkdownFields();
		
		$('.br_dropdown').change(function(){
			// alert('load meeee');
			var branch_code = $(this).val();
			// alert(' Labas ng Add button :'+branch_code);
			
			get_main_branch_id(branch_code);
			
			return false;
		});
		
		function enableMarkdownFields(){
			var status = $('.inactive_dropdown').val();
			// alert('Inactive Status : '+status);
			if(status==1){
				$('#discounted_price, .branch_dropdown, #start_date, #end_date, #start_time, #end_time, #markdown').attr({'readonly' : 'readonly'});
				$('.branch_row').hide();
				$('#branch_id').attr({'readonly' : 'readonly'});
				}else if(status==''){
				$('#discounted_price, .branch_dropdown, #start_date, #end_date, #start_time, #end_time, #markdown').removeAttr('readonly');
				$('.branch_row').show();
				$('#branch_id').removeAttr('readonly');
			}
		}
		enableMarkdownFields();
		
		$('.inactive_dropdown').change(function(){
			enableMarkdownFields();
			return false;
		});
		
		
		$('#markdown').keyup(function(){
			var disc = $(this).val();
			var disc_per = disc/100;
			var disc_price = $('#discounted_price').val();
			var hidden_disc_price = $('#hidden_discounted_price').val();
			var ans = disc_price*disc_per;
			var tot = disc_price-ans;
			// alert(prev_unit_price);
			if(disc==0 || disc=='')
			$('#discounted_price').attr({'value':hidden_disc_price}).val(hidden_disc_price);
			else
			$('#discounted_price').attr({'value':tot}).val(tot);
			return false;
		});
		<?php elseif($use_js == 'reloadBarcodePriceDetailsJs'): ?>
		$('.price_link, .sched_markdown_link, .marginal_markdown_link').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$(".num_with_decimal").on("keypress keyup blur",function (event) {
			$(this).val($(this).val().replace(/[^0-9\.]/g,''));
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
		
		
		$('.price_link').click(function(){
			
			
			var prev_unit_price = $(this).attr('ref_price');
			var uom = $(this).attr('ref_uom');
			var qty = $(this).attr('ref_qty');
			var stock_id = $(this).attr('ref_stock_id');
			var branch_id = $(this).attr('ref_br_id');
			var computed_srp = $(this).attr('computed_srp');
			var prevailing_unit_price = $(this).attr('prevailing_unit_price');
			var landed_cost_markup = $(this).attr('landed_cost_markup');
			var cost_of_sales_markup = $(this).attr('cost_of_sales_markup');
			var hidden_branch_code = $(this).attr('ref_br_code');
			var hidden_branch_id = $(this).attr('ref_br_id');
			var desc = $(this).attr('ref_desc');
			var barcode = $(this).attr('ref_barcode');
			var sales_type_id = $(this).attr('ref_sales_type_id');
			var pk_id = $(this).attr('ref_pk_id');
			var avg_net_cost = $(this).attr('ref_avg_net_cost');
			var cost_of_sales = $(this).attr('ref_cost_of_sales');
			 
			
			$('#for_markup_branch').val(hidden_branch_code);
			$('#landed_cost_markup').attr("readonly",false);
			$('#prevailing_unit_price').attr("readonly",false);
			$('#cost_of_sales_markup').attr("readonly",false);
			$('#save-all-branch-btn').removeAttr('disabled');
			
			if(cost_of_sales_markup != 0  || prevailing_unit_price != 0 || landed_cost_markup != 0 || cost_of_sales_markup != 0){
				
				// $('#computed_srp').val(computed_srp);
				// $('#prevailing_unit_price').val(prevailing_unit_price);
				// $('#landed_cost_markup').val(landed_cost_markup);
				// $('#cost_of_sales_markup').val(cost_of_sales_markup);
				
				
				$('#computed_srp').attr({'value' : computed_srp}).val(computed_srp);
				$('#prevailing_unit_price').attr({'value' : prevailing_unit_price}).val(prevailing_unit_price);
				$('#landed_cost_markup').attr({'value' : landed_cost_markup}).val(landed_cost_markup);
				$('#cost_of_sales_markup').attr({'value' : cost_of_sales_markup}).val(cost_of_sales_markup);
				$('#hidden_avg_net_cost').attr({'value' : avg_net_cost}).val(avg_net_cost);
				$('#hidden_srp_qty').attr({'value' : qty}).val(qty);
				
				$('#computed_srp').attr({'old_val' : computed_srp});
				$('#prevailing_unit_price').attr({'old_val' : prevailing_unit_price});
				$('#landed_cost_markup').attr({'old_val' : landed_cost_markup});
				$('#cost_of_sales_markup').attr({'old_val' : cost_of_sales_markup});
				
				}else{
				
				var pre_comp = (prev_unit_price-(avg_net_cost*qty))/prev_unit_price;
				var landed_cost_markup = pre_comp*100;
				
				var pre_comp1 = (prev_unit_price-(cost_of_sales*qty))/prev_unit_price;
				var cost_of_sales_markup = pre_comp1*100;
				
				var computed_srp = cost_of_sales/((100-landed_cost_markup)/100);
				var tot_com_srp = computed_srp*qty;
				
				// $('#landed_cost_markup').val(landed_cost_markup);
				// $('#cost_of_sales_markup').val(cost_of_sales_markup);
				// $('#prevailing_unit_price').val(prev_unit_price);
				// $('#computed_srp').val(tot_com_srp);
				
				$('#landed_cost_markup').attr({'value' : landed_cost_markup}).val(landed_cost_markup);
				$('#cost_of_sales_markup').attr({'value' : cost_of_sales_markup}).val(cost_of_sales_markup);
				$('#prevailing_unit_price').attr({'value' : prevailing_unit_price}).val(prev_unit_price);
				$('#computed_srp').attr({'value' : tot_com_srp}).val(tot_com_srp);
				$('#hidden_srp_qty').attr({'value' : qty}).val(qty);
				$('#hidden_avg_net_cost').attr({'value' : avg_net_cost}).val(avg_net_cost);
				
				$('#computed_srp').attr({'old_val' : tot_com_srp});
				$('#prevailing_unit_price').attr({'old_val' : prev_unit_price});
				$('#landed_cost_markup').attr({'old_val' : landed_cost_markup});
				$('#cost_of_sales_markup').attr({'old_val' : cost_of_sales_markup});
				
			}
			
			$('#landed_cost_markup').blur(function(){
				//====================================================
				
				var whole = $('#landed_cost_markup').val();
				decimal = Math.round(whole);
				if(decimal > 9999){
					rMsg("Only 4 decimal numbers are allowed.",'error');
					$('#landed_cost_markup').focus();
				}
				
				//====================================================	  
				var new_landed_cost_markup  = $('#landed_cost_markup').val();
				var new_computed_srp = cost_of_sales/((100-new_landed_cost_markup)/100);
			    var new_tot_com_srp = new_computed_srp*qty;	
				
				// $('#computed_srp').val(new_tot_com_srp);
				// $('#prevailing_unit_price').val(new_tot_com_srp);
				
				$('#computed_srp').attr({'value' : new_tot_com_srp}).val(new_tot_com_srp);
				$('#prevailing_unit_price').attr({'value' : new_tot_com_srp}).val(new_tot_com_srp);
				
				//====================================================	  
				var computed_srp = $('#computed_srp').val(); 
				num1 = Math.round(computed_srp*10000)/10000;
				$('#computed_srp').val(num1);
				
				var prev_unit_price_ = $('#prevailing_unit_price').val(); 
				num2 = Math.round(prev_unit_price_*10000)/10000;
				$('#prevailing_unit_price').val(num2);
				//====================================================	  
			});
			
			
			$('#cost_of_sales_markup').blur(function(){
				//====================================================
				var whole = $('#landed_cost_markup').val();
				decimal = Math.round(whole);
				if(decimal > 9999){
					rMsg("Only 4 decimal numbers are allowed.",'error');
					$('#cost_of_sales_markup').focus();
				}
				//====================================================	  
				var new_cost_of_sales  = $('#cost_of_sales_markup').val()
				var new_computed_srp = cost_of_sales/((100-new_cost_of_sales)/100);
				var new_tot_com_srp = new_computed_srp*qty;	
				
				// $('#computed_srp').val(new_tot_com_srp);
				// $('#prevailing_unit_price').val(new_tot_com_srp);
				
				$('#computed_srp').attr({'value' : new_tot_com_srp}).val(new_tot_com_srp);
				$('#prevailing_unit_price').attr({'value' : new_tot_com_srp}).val(new_tot_com_srp);
				
				var computed_srp = $('#computed_srp').val(); 
				num1 = Math.round(computed_srp*10000)/10000;
				$('#computed_srp').val(num1);
				
				var prev_unit_price_ = $('#prevailing_unit_price').val(); 
				num2 = Math.round(prev_unit_price_*10000)/10000;
				$('#prevailing_unit_price').val(num2);
			});
			
			
			//====================================================
			function compute_landed_cost_markup(){
				var prev_unit_price = $('#prevailing_unit_price').val();
				if(prev_unit_price > 0){
					var avg_net_cost = $('#hidden_avg_net_cost').val();
					var qty = $('#hidden_srp_qty').val();
					// alert(avg_net_cost);
				//	var qty = $('#srp_qty').val();
					// var times_to = 100;
				   // alert(qty);
					
					var pre_comp = (prev_unit_price-(avg_net_cost*qty))/prev_unit_price;
					var final_comp = pre_comp*100;
					
					$('#landed_cost_markup').attr({'value':final_comp.toFixed(4)}).val(final_comp.toFixed(4));
					}else{
					$('#landed_cost_markup').attr({'value':0}).val(0);
				}
				
			}
			
		//	$('#prevailing_unit_price').blur(function(){
			$('#prevailing_unit_price').change(function(){
				
				compute_landed_cost_markup();
				var whole = $('#prevailing_unit_price').val();
				decimal = Math.round(whole);
				if(decimal > 9999){
					rMsg("Only 4 decimal numbers are allowed.",'error');
					$('#prevailing_unit_price').focus();
				}
			});
			
			
			if($('#computed_srp').val() != ''){
				
				var num = $('#computed_srp').val(); 
				num1 = Math.round(num*10000)/10000;
				$('#computed_srp').val(num1);
			}
			
			if($('#prevailing_unit_price').val() != ''){
				
				var num = $('#prevailing_unit_price').val(); 
				num1 = Math.round(num*10000)/10000;
				$('#prevailing_unit_price').val(num1);
			}
			
			if($('#landed_cost_markup').val() != ''){
				
				var num = $('#landed_cost_markup').val(); 
				num1 = Math.round(num*10000)/10000;
				$('#landed_cost_markup').val(num1);
			}
			
			if($('#cost_of_sales_markup').val() != ''){
				
				var num = $('#cost_of_sales_markup').val(); 
				num1 = Math.round(num*10000)/10000;
				$('#cost_of_sales_markup').val(num1);
			}
			//===================================================
			//function landed_cost_markup
			
			
			
			// // alert('Hidden Avg Net Cost : '+hidden_avg_net_cost);
			
			// // alert('Primary ID of barcode prices : '+pk_id);
			
			// // if(hidden_avg_net_cost != '' && hidden_cost_of_sales != ''){
			// // alert('Passed here...');
			
			// bootbox.dialog({
			// message: baseUrl+'inventory/load_srp_popup/'+barcode+'/'+sales_type_id+'/'+uom+'/'+qty+'/'+stock_id+'/'+branch_id+'/'+price+'/'+hidden_avg_net_cost+'/'+hidden_cost_of_sales+'/'+pk_id,
			// title: "Regular SRP for <span style='color: #5bc0de;'> ["+barcode+"] "+desc+"</span>",
			// onEscape: true, //-----added to close dialog box upon clicking the ESC button
			// buttons: {
			// update: {
			// label: "Update",
			// className: "btn-info",
			// callback: function() {
			// $('#saving_type').attr({'value':'single'}).val('single');
			
			// var inputsZ = $('.aaa').each(function(){
			// // alert($(this).data('original')+'<~~~>'+this.value);
			// $(this).data('original', this.value);
			// // alert('Echos:'+$(this).data('original', this.value));
			// });
			// // alert('COMPLETE FORM DATA: '+$("#srp_pop_form").serialize());
			
			// $("#srp_pop_form").rOkay({
			// // btn_load		: 	$('#save_supp_stock_btn'),
			// // btn_load_remove	: 	true,
			// asJson			: 	true,
			// onComplete		:	function(data){
			// // alert('whole data [single]: '+data.items[0]);
			// // alert('items [single]:'+data.items['barcode']);
			// var pk_id = data.pk_id;
			// var stock_id = data.stock_id;
			// var passed_form1 = '';
			
			// //-----TEMPORARILY DISABLED-----START
			// // inputsZ.each(function(){
			// // if($(this).data('original') != this.value){
			// // // alert('Yehes!');
			
			// // alert('OLD : '+$(this).data('original')+'---NEW : '+this.value);
			// // passed_form1 += 'OLD:'+$(this).data('original')+'|-|NEW:'+this.value+'|--|';
			// // }else{
			// // // alert('Asa ka! Not gonna happen!');
			// // alert('OLD : '+$(this).data('original')+'---NEW : '+this.value);
			// // }
			
			// // });
			
			// // var formDataB = 'pk_id='+pk_id+'&'+'passed_stock_id='+stock_id+'&'+passed_form1;
			// // // alert('Form Data [SINGLE]'+formDataB);
			// // $.post(baseUrl+'inventory/write_to_db_audit_trail/', {'form_vals' : formDataB, 'type_desc' : 'Updated SRP Details'}, function(data2){
			
			// // });
			// //-----TEMPORARILY DISABLED-----END
			
			// rMsg(data.msg,data.result);
			// // setTimeout(function()
			// // {
			// // // window.location = baseUrl + 'inventory/stock_master'; //-----original script
			// // window.location = baseUrl + 'inventory/stock_master/'+stock_id;
			// // },1500);
			
			// }
			// });
			// return false;
			// }
			// },
			// update_all: {
			// label: "Update All Branches",
			// className: "btn-primary",
			// callback: function() {
			// $('#saving_type').attr({'value':'all'}).val('all');
			
			// var inputsY = $('.aaa').each(function(){
			// // alert($(this).data('original')+'<===>'+this.value);
			// $(this).data('original', this.value);
			// // alert('Echos:'+$(this).data('original', this.value));
			// });
			// // alert('COMPLETE FORM DATA: '+$("#srp_pop_form").serialize());
			
			// $("#srp_pop_form").rOkay({
			// // btn_load		: 	$('#save_supp_stock_btn'),
			// // btn_load_remove	: 	true,
			// asJson			: 	true,
			// onComplete		:	function(data){
			// // alert('whole data [all]: '+data.items[0]);
			// // alert('items [all]:'+data.items['barcode']);
			// var pk_id = data.pk_id;
			// var stock_id = data.stock_id;
			// var passed_formA = '';
			
			// //-----TEMPORARILY DISABLED-----START
			// // inputsY.each(function(){
			// // if($(this).data('original') != this.value){
			// // // alert('OLD : '+$(this).data('original')+'---NEW : '+this.value);
			// // passed_formA += 'OLD:'+$(this).data('original')+'|-|NEW:'+this.value+'|--|';
			// // }
			
			// // });
			
			// // var formDataA = 'pk_id='+pk_id+'&'+'stock_id='+stock_id+'&'+passed_formA;
			// // $.post(baseUrl+'inventory/write_to_db_audit_trail/', {'form_vals' : formDataA, 'type_desc' : 'Updated SRP Details'}, function(data3){
			
			// // });
			// //-----TEMPORARILY DISABLED-----END
			
			// rMsg(data.msg,data.result);
			// // setTimeout(function()
			// // {
			// // // window.location = baseUrl + 'inventory/stock_master'; //-----original script
			// // window.location = baseUrl + 'inventory/stock_master/'+stock_id;
			// // },1500);
			// }
			// });
			// return false;
			// }
			// },
			// cancel: {
			// label: "Close",
			// className: "btn-default",
			// callback: function() {
			// // rMsg('Closing the confirm box...','error');
			// // setTimeout(function(){
			// // window.location = baseUrl+'inventory/uoms';
			// // },1500);
			// }
			// }
			// }
			// });
			// // }else{
			// // rMsg('Set Average Net Cost in Supplier Stock OR Set Cost of Sales in Stock Master Details!','warning');
			// // }
			
			// return false;
		});
		
		$('.marginal_markdown_link').click(function(){
			
			var hidden_branch_id = $(this).attr('ref_br_id');
			var desc = $(this).attr('ref_desc');
			var stock_id = $(this).attr('ref_stock_id');
			var barcode = $(this).attr('ref_barcode');
			var sales_type_id = $(this).attr('ref_sales_type_id');
			var price = $(this).attr('ref_price');
			var latest_landed_cost = $(this).attr('landed_cost');
			
			setTimeout(function(){
				$('#hidden_latest_landed_cost').val(latest_landed_cost);
			},1500);
			
			bootbox.dialog({
				message: baseUrl+'inventory/load_marginal_markdown_popup/'+hidden_branch_id+'/'+stock_id+'/'+barcode+'/'+sales_type_id+'/'+price+'/'+latest_landed_cost,
				title: "Marginal Markdown for <span style='color: #5bc0de;'> ["+barcode+"] "+desc+"</span>",
				className: "bootbox-wide",
				onEscape: true, 
				buttons: {
					update: {
						label: "Update",
						className: "btn-info",
						callback: function() {
							
							$('#saving_type').attr({'value':'single'}).val('single');
							$("#marginal_markdown_pop_form").rOkay({
								asJson			: 	true,
								onComplete		:	function(data){												
									rMsg(data.result);
								}
							});
							return false;
						}
					},
					update_all: {
						label: "Update All Branches",
						className: "btn-primary",
						callback: function() {
							$('#saving_type').attr({'value':'all'}).val('all');					
							$("#marginal_markdown_pop_form").rOkay({
								asJson			: 	true,
								onComplete		:	function(data){
									rMsg(data.result);
									console.log(data.result);
								}
							});
							return false;
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
		
		$('.sched_markdown_link').click(function(){
			var hidden_branch_id = $(this).attr('ref_br_id');
			var desc = $(this).attr('ref_desc');
			var stock_id = $(this).attr('ref_stock_id');
			var barcode = $(this).attr('ref_barcode');
			var sales_type_id = $(this).attr('ref_sales_type_id');
			var price = $(this).attr('ref_price');
			bootbox.dialog({
				message: baseUrl+'inventory/load_sched_markdown_popup/'+hidden_branch_id+'/'+stock_id+'/'+barcode+'/'+sales_type_id+'/'+price,
				className: "bootbox-wide",
				title: "Scheduled Price Markdown for <span style='color: #5bc0de;'> ["+barcode+"] "+desc+"</span>",
				onEscape: true, //-----added to close dialog box upon clicking the ESC button
				buttons: {
					update: {
						label: "Update",
						className: "btn-info",
						callback: function() {
							$('#saving_type').attr({'value':'single'}).val('single');
							// // if(hidden_branch_id != ''){
							// // rMsg('Updating the content...['+hidden_branch_id+']','success');
							// // }else{
							// // rMsg('Unit Code is empty','warning');
							// // }	
							// var converter_url = baseUrl + 'inventory/single_sched_markdown_db';
							// $.post(converter_url, {'test_var' : 'HoHey'}, function(data){
							// alert(data);
							// });
							$("#sched_markdown_pop_form").rOkay({
								// btn_load		: 	$('#save_supp_stock_btn'),
								// btn_load_remove	: 	true,
								asJson			: 	true,
								onComplete		:	function(data){
									// alert(data);
									// if (typeof data.result != "undefined") {
									rMsg(data.msg,data.result);
									// if (data.result == "success")
									// load_supplier_stock_list();
									// }
								}
							});
							return false;
						}
					},
					update_all: {
						label: "Update All Branches",
						className: "btn-primary",
						callback: function() {
							$('#saving_type').attr({'value':'all'}).val('all');
							// // if(hidden_branch_id != ''){
							// // rMsg('Updating all the content...['+hidden_branch_id+']','success');
							// // }else{
							// // rMsg('Unit Code is empty','warning');
							// // }
							// var converter_url = baseUrl + 'inventory/all_sched_markdown_db';
							// $.post(converter_url, {'test_var' : 'HeyHo'}, function(data){
							// alert(data);
							// });						
							$("#sched_markdown_pop_form").rOkay({
								// btn_load		: 	$('#save_supp_stock_btn'),
								// btn_load_remove	: 	true,
								asJson			: 	true,
								onComplete		:	function(data){
									// alert(data);
									// if (typeof data.result != "undefined") {
									rMsg(data.msg,data.result);
									// if (data.result == "success")
									// load_supplier_stock_list();
									// }
								}
							});
							return false;
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
		
		<?php elseif($use_js == 'reloadBarcodeDetailsJs'): ?>
		// alert('load barcodes alert...');
		
		// $('.edit_me_btn').tooltip('show'); //-----DISPLAYS TOOLTIP UPON LOAD OF PAGE
		//-----DISPLAYS TOOLTIP ON HOVER
		$('.edit_me_btn, .add_stock_barcode').tooltip({
			'show': true,
			'placement': 'left',
			// 'title': "Please remember to..."
		});
		
		$('.add_stock_barcode').click(function(){
			$('#mode').attr({'value' : 'add'}).val('add'); //-----Change MAIN MODE of form from EDIT to ADD
			$('.form_mode').attr({'value' : 'add'}).val('add'); //-----Change MAIN MODE of form from ADD to EDIT
			$('#barcode_mode').attr({'value' : 'add'}).val('add'); //-----Change mode of form from EDIT to ADD
			var inactive = 0;
			// alert('Current Page Mode after clicking the ADD btn : '+$('.form_mode').val());
			// alert('Current Page Barcode Mode after clicking the ADD btn : '+$('#barcode_mode').val());
			$('#save-all-branch-btn').attr('disabled','disabled');
			$('#barcode').focus();
			$('#barcode, .uom_dropdown, #con_barcode, .sales_type_dropdown').removeAttr('readonly');
			$('#computed_srp').attr({'value' : ''}).val('');
			$('#prevailing_unit_price').attr({'value' : ''}).val('');
			$('#landed_cost_markup').attr({'value' : ''}).val('');
			$('#prevailing_unit_price').attr("readonly",true);
			$('#landed_cost_markup').attr("readonly",true);
			$('#cost_of_sales_markup').attr("readonly",true);
			$('#cost_of_sales_markup').attr({'value' : ''}).val('');
			$('#barcode').attr({'value' : ''}).val('');
			$('#con_barcode').attr({'value' : ''}).val('');
			$('#hidden_barcode').attr({'value' : ''}).val('');
			$('.barcode_short_desc').attr({'value' : ''}).val('');
			$('.barcode_desc').attr({'value' : ''}).val('');
			$('#qty').attr({'value' : ''}).val('');
			$('.uom_dropdown').attr({'value' : ''}).val('');
			$('#hidden_sales_type').attr({'value' : ''}).val('');
			$('#hidden_avg_net_cost').attr({'value' : ''}).val('');
			$('#hidden_srp_qty').attr({'value' : ''}).val('');
			// $('.barcode_inactive_dropdown').attr({'value' : inactive}).val(inactive);
			
			$('#short_desc').attr({'old_val' : ''});
			// $('#description').attr({'old_val' : ''});
			$('.barcode_desc').attr({'old_val' : ''});
			
			$('#pricing_def').show();
			$('#new_pricing_def').hide();
			$('#new_pricing_def').html('');
			
			//old val 
			$('#computed_srp').attr({'old_val' : ''}).val('');
			$('#prevailing_unit_price').attr({'old_val' : ''}).val('');
			$('#landed_cost_markup').attr({'old_val' : ''}).val('');
			$('#cost_of_sales_markup').attr({'old_val' : ''}).val('');
			
			return false;
		});	
		
		function load_new_pricing(){
			var barcode = $('#barcode').val();
			var sales_type = $('#sales_type_id').val();
			// alert(barcode+'---Sales Type : '+sales_type);
			var id = $('#ids').val();
			var this_url = baseUrl+'inventory/load_stock_barcode_prices';
			$.post(this_url, {'barcode' : barcode}, function(data){
				$('#pricing_def').hide();
				$('#new_pricing_def').show();
				$('#new_pricing_def').html(data);
				$('#'+id).css("background-color", " #f8f6ba");	
				return false;
			});
		}
		
		function load_stock_barcodes_list(){
			var ref = $('#hidden_stock_id').val();
			// alert('ref : '+ref);
			var dtr_url = '<?php echo base_url() ?>inventory/load_stock_barcodes';
			$('#file-spinner').show();
			$('#init-contents').hide();
			$('#stock-barcode-contents').hide();
			
			$.post(dtr_url, {'ref' : ref}, function(data){
				$('#file-spinner').hide();
				$('#init-contents').hide();
				$('#stock-barcode-contents').show();
				$('#stock-barcode-contents').html(data);
				
				return false;
			});
			
		}
		
		$('.edit_me_btn').click(function(){
			// $('[data-toggle="tooltip"]').tooltip(); 
			// $(this)
			$('#mode').attr({'value' : 'edit'}).val('edit'); //-----Change MAIN MODE of form from ADD to EDIT
			$('.form_mode').attr({'value' : 'edit'}).val('edit'); //-----Change MAIN MODE of form from ADD to EDIT
			$('#barcode_mode').attr({'value' : 'edit'}).val('edit'); //-----Change mode of form from ADD to EDIT
			var ref_short_desc = $(this).attr('ref_short_desc');
			var ref_desc = $(this).attr('ref_desc');
			var ref = $(this).attr('ref');
			$('#short_desc_old').val(ref_short_desc); 
			$('#desc_old').val(ref_desc); 
			$('#ids').val(ref);
			var barcode = $(this).attr('ref_barcode');
			var uom = $(this).attr('ref_uom');
			var qty = $(this).attr('ref_qty');
			var sales_type_id = $(this).attr('ref_sales_type_id');
			var inactive = $(this).attr('ref_status');    
			$('#barcode').attr({'value' : barcode}).val(barcode);
			$('#hidden_sales_type').attr({'value' : sales_type_id}).val(sales_type_id);
			$('#con_barcode').attr({'value' : barcode}).val(barcode);
			$('#hidden_barcode').attr({'value' : barcode}).val(barcode);
			$('.barcode_short_desc').attr({'value' : ref_short_desc}).val(ref_short_desc);
			$('.barcode_desc').attr({'value' : ref_desc}).val(ref_desc);
			$('#qty').attr({'value' : qty}).val(qty);
			$('.sales_type_dropdown').attr({'value' : sales_type_id}).val(sales_type_id);
			$('.uom_dropdown').attr({'value' : uom}).val(uom);
			// $('.barcode_inactive_dropdown').attr({'value' : inactive}).val(inactive);
			
			$('#computed_srp').attr({'value' : ''}).val('');
			$('#prevailing_unit_price').attr({'value' : ''}).val('');
			$('#landed_cost_markup').attr({'value' : ''}).val('');
			$('#cost_of_sales_markup').attr({'value' : ''}).val('');
			$('#hidden_avg_net_cost').attr({'value' : ''}).val('');
			$('#hidden_srp_qty').attr({'value' : ''}).val('');
			
			//old val 
			$('#computed_srp').attr({'old_val' : ''}).val('');
			$('#prevailing_unit_price').attr({'old_val' : ''}).val('');
			$('#landed_cost_markup').attr({'old_val' : ''}).val('');
			$('#cost_of_sales_markup').attr({'old_val' : ''}).val('');
			
			$('#prevailing_unit_price').attr("readonly",true);
			$('#landed_cost_markup').attr("readonly",true);
			$('#cost_of_sales_markup').attr("readonly",true);
			
			// alert('Short Desc : '+ref_short_desc+' Desc : '+ref_desc);
			// alert('Short Desc 2 : '+$('#short_desc').val()+' Desc 2 : '+$('#description').val());
			
			$('#short_desc').attr({'old_val' : ref_short_desc});
			$('.barcode_desc').attr({'old_val' : ref_desc});
			
			$('#barcode, .uom_dropdown, #con_barcode, .sales_type_dropdown').attr('readonly', 'readonly');
			$('#save-all-branch-btn').attr('disabled','disabled');
			load_stock_barcodes_list();
			load_new_pricing();
			return false;
		});
		
		//-----FOR POP-UP VIEW
		// $('.edit_me_btn').rPopView({
		// wide: true,
		// asJson: true,
		// onComplete: function(data){
		// $('[data-bb-handler=cancel]').click();
		// }
		// });
		
		<?php elseif($use_js == 'supplierStockFormJs'): ?>
		$('#adder_form_div').show();
		
		//----------Btns
		$('.adder_form_btns').show();
		$('.edit_form_btns').hide();
		//----------Btns
		
		$('#init-contents').show();
		$('#file-spinner').hide();
		$('#stock-barcode-contents').hide();
		
		$('.toUpper').blur(function(){
			$(this).val($(this).val().toUpperCase());
		});
		
		$('#qty, #con_qty').attr('readonly', 'readonly');
		
		//======================
		$('#con_unit_cost').blur(function(){
			var con_unit_cost = $(this).val();
			var unit_cost = $('#unit_cost').val();
			
			var p_con_unit_cost = parseFloat(con_unit_cost);
			var p_unit_cost = parseFloat(unit_cost);
			
			if(p_unit_cost != p_con_unit_cost){
				// alert(p_unit_cost+'<===>'+p_con_unit_cost);
				rMsg('Unit Cost does not match!','error');
			$('#con_unit_cost').focus();
			}
			return false;
			});
			
			$('#con_uom').change(function(){
			// $('#con_uom').blur(function(){
			var con_uom = $(this).val();
			var uom = $('#uom').val();
			
			// alert(uom+'<===>'+con_uom);
			if( uom != con_uom ){
			// if( con_uom != ''){
			rMsg('UOM does not match!','error');
			$('#con_uom').focus();
			// }
			// else{
			// $('#con_uom').focus();
			// }
			}
			return false;
			});
			//======================
			
			function get_main_supp_stock_uom(uom){
			// alert('MAIN --- Old UOM:'+uom);
			var convert_url2 = baseUrl + 'inventory/get_supp_stock_uom';
			$.post(convert_url2, {'uom' : uom}, function(data){
			// alert('MAIN --- Old UOM:'+data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_hidden_stock_uom').attr('value', uom).val(uom);
			$('.uom_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_main_supp_con_stock_uom(uom){
			// alert('MAIN --- Old UOM:'+uom);
			var convert_url2 = baseUrl + 'inventory/get_supp_stock_uom';
			$.post(convert_url2, {'uom' : uom}, function(data){
			// alert('MAIN --- Old UOM:'+data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_con_hidden_stock_uom').attr('value', uom).val(uom);
			$('.con_uom_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_main_branch_id(branch_code){
			// alert('[main] Old Branch:'+branch_code);
			var con_url = baseUrl + 'inventory/get_branch_id_from_code';
			$.post(con_url, {'branch_code' : branch_code}, function(data){
			// alert('[main] NEW '+data);
			// alert('[main] Passed branch id : '+branch_code);
			$('.c_hidden_branch_id').attr('value', data).val(data);
			$('.branch_dropdown').attr('value', branch_code).val(branch_code);
			});
			}
			
			$('#uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
			// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
			$('#qty').attr('value', data).val(data);
			get_main_supp_stock_uom(uom);
			});
			return false;
			});
			
			$('#con_uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
			$('#con_qty').attr('value', data).val(data);
			get_main_supp_con_stock_uom(uom);
			});
			return false;
			});
			
			$('#branch_id').change(function(){
			var branch_code = $(this).val();
			// alert(' Labas ng Add button :'+branch_code);
			
			get_main_branch_id(branch_code);
			
			return false;
			});
			
			function load_supplier_stock_list(){
			var ref = $('#hidden_stock_id').val();
			// alert('ref : '+ref);
			var dtr_url = '<?php echo base_url() ?>inventory/load_supplier_stocks';
			$('#file-spinner').show();
			$('#init-contents').hide();
			$('#stock-barcode-contents').hide();
			
			$.post(dtr_url, {'ref' : ref}, function(data){
			$('#file-spinner').hide();
			$('#init-contents').hide();
			$('#stock-barcode-contents').show();
			$('#stock-barcode-contents').html(data);
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
			return false;
			});
			}
			
			load_supplier_stock_list();
			
			var mode = $('#mode').val();
			
			var inputs = $('.supp_req_form').each(function(){
			// alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
			});
			
			$('#save_supp_stock_btn').click(function()
			{
			// alert('SINGLE BRANCH');
			$('#saving_type').attr({'value':'single'}).val('single');
			// alert('Save Supp Stock - ADD');
			$("#supplier_stock_form").rOkay({
			btn_load		: 	$('#save_supp_stock_btn'),
			btn_load_remove	: 	true,
			asJson			: 	true,
			onComplete		:	function(data){
			// alert(data);
			if (typeof data.result != "undefined") {
			rMsg(data.msg,data.result);
			// if (data.result == "error" || data.result == "warning")
			// $('#supp_stock_code').focus();
			if (data.result == "success"){
			var stock_id = data.stock_id;
			var supp_stock_code = data.supp_stock_code;
			var branch = data.branch;
			// var form_mode = $('#mode').val();
			var form_mode = data.form_mode;
			var passed_form = '';
			var input_name = '';
			var input_names = '';
			var supplier_details_stock_logs = '';
			var old_val = '';
			var supplier_id =  $('#hidden_supp_stock_id').val();
			if(form_mode == 'edit'){
			
			passed_form = 'stock_id='+stock_id+'&supp_stock_code='+supp_stock_code+'&affected_branch='+branch+'|=|';
			
			
			$('.supp_req_form').each(function(){
			
			input_names = $(this).attr('name');
			
			switch(input_names){
			case 'hidden_stock_uom':
			input_name = 'uom';
			break;
			case 'discount1':
			input_name = 'disc_amount1';
			break;
			case 'discount2':
			input_name = 'disc_amount2';
			break;
			case 'discount3':
			input_name = 'disc_amount3';
			break;
			case 'disc_type1':
			input_name = 'disc_percent1';
			break;
			case 'disc_type2':
			input_name = 'disc_percent2';
			break;
			case 'disc_type3':
			input_name = 'disc_percent3';
			break;
			
			default:
			input_name = $(this).attr('id');
			}
			
			
			old_val = $(this).attr('old_val');
			
			
			if(this.value != old_val){
			// alert('OLD : '+old_val+'---NEW : '+this.value);
			// passed_form += '&'+input_name+'=OLD:'+old_val+'|-|NEW:'+this.value+'|--|';
			passed_form += input_name+'=OLD:'+old_val+'|-|NEW:'+this.value+'|--|';
			//supplier_details_stock_logs += input_name+'|'+old_val+'|'+this.value;
			//	alert(passed_form);
			if(supplier_details_stock_logs != ''){
			supplier_details_stock_logs += '||'+input_name+':'+old_val+'|'+this.value;
			}else{
			supplier_details_stock_logs += input_name+':'+old_val+'|'+this.value;
			}
			
			}
			
			
			});
			var data_for_supplier_stock_logs = 'supplier_id:'+supplier_id+':stock_id:'+stock_id+'::'+supplier_details_stock_logs;
			
			//	alert(data_for_supplier_stock_logs);
			$.post(baseUrl+'inventory/suplier_master_write_to_stock_logs/', {'data_for_stock_logs' : data_for_supplier_stock_logs, 'type_desc' : 'Update Supplier Stock Details','branch':branch}, function(stock_master_logs){
			//alert(stock_master_logs);
			//	alert(stock_master_logs);	
			});
			
			
			
			$.post(baseUrl+'inventory/write_to_db_audit_trail/', {'form_vals' : passed_form, 'stock_id' : stock_id, 'type_desc' : 'Updated Supplier Stock'}, function(data2){
			
			});
			}else{
			inputs.each(function(){
			input_name = $(this).attr('id');
			
			if($(this).data('original') != this.value){
			// alert('OLD : '+$(this).data('original')+'---NEW : '+this.value);
			passed_form += input_name+'=OLD:'+$(this).data('original')+'|-|NEW:'+this.value+'|--|';
			
			}
			
			});
			
			
			
			var formData = 'stock_id='+stock_id+'&supp_stock_code='+supp_stock_code+'&affected_branch='+branch+'|=|'+passed_form;
			$.post(baseUrl+'inventory/write_to_db_audit_trail/', {'form_vals' : formData, 'stock_id' : stock_id, 'type_desc' : 'Added Supplier Stock'}, function(data2){
			
			});
			}
			
			load_supplier_stock_list();
			}
			}
			}
			});
			return false;
			});
			
			$('#save_all_supp_stock_btn').click(function()
			{
			// alert('ALL BRANCHES');
			$('#saving_type').attr({'value':'all'}).val('all');
			
			$("#supplier_stock_form").rOkay({
			btn_load		: 	$('#save_all_supp_stock_btn'),
			btn_load_remove	: 	true,
			asJson			: 	true,
			onComplete		:	function(data){
			//alert(data);
			if (typeof data.result != "undefined") {
			rMsg(data.msg,data.result);
			console.log(data.msg,data.result);
			//alert(data);
			// if (data.result == "error" || data.result == "warning")
			// $('#supp_stock_code').focus();
			if (data.result == "success"){
			
			var stock_id = data.stock_id;
			var supp_stock_code = data.supp_stock_code;
			//var branch = data.branch;
			var branch = 'All';
			// var form_mode = $('#mode').val();
			var form_mode = data.form_mode;
			var passed_form = '';
			var input_name = '';
			var input_names = '';
			var supplier_details_stock_logs = '';
			var old_val = '';
			var supplier_id =  $('#hidden_supp_stock_id').val();
			//alert($('#default').val());
			if(form_mode == 'edit'){
			
			passed_form = 'stock_id='+stock_id+'&supp_stock_code='+supp_stock_code+'&affected_branch='+branch+'|=|';
			
			$('.supp_req_form').each(function(){
			input_names = $(this).attr('name');
			
			switch(input_names){
			case 'hidden_stock_uom':
			input_name = 'uom';
			break;
			case 'discount1':
			input_name = 'disc_amount1';
			break;
			case 'discount2':
			input_name = 'disc_amount2';
			break;
			case 'discount3':
			input_name = 'disc_amount3';
			break;
			case 'disc_type1':
			input_name = 'disc_percent1';
			break;
			case 'disc_type2':
			input_name = 'disc_percent2';
			break;
			case 'disc_type3':
			input_name = 'disc_percent3';
			break;
			
			default:
			input_name = $(this).attr('id');
			}
			
			old_val = $(this).attr('old_val');
			
			
			if(this.value != old_val){
			// alert('OLD : '+old_val+'---NEW : '+this.value);
			// passed_form += '&'+input_name+'=OLD:'+old_val+'|-|NEW:'+this.value+'|--|';
			passed_form += input_name+'=OLD:'+old_val+'|-|NEW:'+this.value+'|--|';
			//supplier_details_stock_logs += input_name+'|'+old_val+'|'+this.value;
			
			if(supplier_details_stock_logs != ''){
			supplier_details_stock_logs += '||'+input_name+':'+old_val+'|'+this.value;
			}else{
			supplier_details_stock_logs += input_name+':'+old_val+'|'+this.value;
			}
			
			}
			
			
			});
			//var data_for_supplier_stock_logs = 'stock_id:'+stock_id+'::'+supplier_details_stock_logs;
			var data_for_supplier_stock_logs = 'supplier_id:'+supplier_id+':stock_id:'+stock_id+'::'+supplier_details_stock_logs;
			
			//alert(data_for_supplier_stock_logs);
			$.post(baseUrl+'inventory/suplier_master_write_to_stock_logs/', {'data_for_stock_logs' : data_for_supplier_stock_logs, 'type_desc' : 'Update All Supplier Stock Details','branch':branch}, function(stock_master_logs){
			//alert(stock_master_logs);
			//alert(stock_master_logs);	
			});
			
			
			
			$.post(baseUrl+'inventory/write_to_db_audit_trail/', {'form_vals' : passed_form, 'stock_id' : stock_id, 'type_desc' : 'Updated Supplier Stock'}, function(data2){
			
			});
			}else{
			inputs.each(function(){
			input_name = $(this).attr('id');
			
			if($(this).data('original') != this.value){
			// alert('OLD : '+$(this).data('original')+'---NEW : '+this.value);
			passed_form += input_name+'=OLD:'+$(this).data('original')+'|-|NEW:'+this.value+'|--|';
			
			}
			
			});
			
			
			
			var formData = 'stock_id='+stock_id+'&supp_stock_code='+supp_stock_code+'&affected_branch='+branch+'|=|'+passed_form;
			$.post(baseUrl+'inventory/write_to_db_audit_trail/', {'form_vals' : formData, 'stock_id' : stock_id, 'type_desc' : 'Added Supplier Stock'}, function(data2){
			
			});
			}
			
			load_supplier_stock_list();
			}
			}
			
			}
			});
			return false;
			});
			
			// // $('#save_supp_stock_btn').click(function()
			// // {
			// // // alert('Save Supp Stock - EDIT');
			// // $("#supplier_stock_form").rOkay({
			// // btn_load		: 	$('#save_supp_stock_btn'),
			// // btn_load_remove	: 	true,
			// // asJson			: 	true,
			// // onComplete		:	function(data){
			// // // alert(data);
			// // if (typeof data.result != "undefined") {
			// // rMsg(data.msg,data.result);
			// // // if (data.result == "error" || data.result == "warning")
			// // // $('#supp_stock_code').focus();
			// // if (data.result == "success")
			// // load_supplier_stock_list();
			// // }
			// // }
			// // });
			// // return false;
			// // });
			
			$('#supp_stock_back_btn').on('click',function(event)
			{
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master';
			});
			
			// // $('#unit_cost, #discount1, #discount2, #discount3, #disc_type1, #disc_type2, #disc_type3').blur(function(){
			$('.uom_dropdown').change(function(){
			// alert('Pfft of UOM!');
			var qty = ($('#qty').val() == '' ? 0 : $('#qty').val());
			// if(qty == ''){
			// rMsg('Please select UOM first','error');
			// }else{
			var unit_cost = ($('#unit_cost').val() == '' ? 0 : $('#unit_cost').val());
			var discount1_val = $('#discount1').val();
			var discount2_val = $('#discount2').val();
			var discount3_val = $('#discount3').val();
			
			var disc_type1_val = $('#disc_type1').val();
			var disc_type2_val = $('#disc_type2').val();
			var disc_type3_val = $('#disc_type3').val();
			
			var discount1_perc = 0;
			var discount1_amt = 0;
			
			var discount2_perc = 0;
			var discount2_amt = 0;
			
			var discount3_perc = 0;
			var discount3_amt = 0;
			
			if (disc_type1_val == 'percent')
			discount1_perc = discount1_val;
			else //if (disc_type1_val == 'amount')
			discount1_amt = discount1_val;
			
			if (disc_type2_val == 'percent')
			discount2_perc = discount2_val;
			else //if (disc_type1_val == 'amount')
			discount2_amt = discount2_val;
			
			if (disc_type3_val == 'percent')
			discount3_perc = discount3_val;
			else //if (disc_type1_val == 'amount')
			discount3_amt = discount3_val;
			
			// alert('Average Cost on change '+unit_cost+' / '+qty+' : '+(unit_cost/qty)+0);
			
			var avg_cost = (unit_cost/qty)+0;
			var total_net_cost = (((((unit_cost*(1-(discount1_perc/100))) - discount1_amt)
			*(1-(discount2_perc/100))) - discount2_amt)
			*(1-(discount3_perc/100))) - discount3_amt;
			
			var avg_net_cost = total_net_cost/qty;
			
			$('#avg_cost').attr({'value' : avg_cost}).val(avg_cost);
			$('#net_cost').attr({'value' : total_net_cost}).val(total_net_cost);
			$('#avg_net_cost').attr({'value' : avg_net_cost}).val(avg_net_cost);
			// }
			return false;
			});
			
			$('#unit_cost, #discount1, #discount2, #discount3, #disc_type1, #disc_type2, #disc_type3').blur(function(){
			// alert('Pfft!');
			var qty = $('#qty').val();
			if(qty == ''){
			rMsg('Please select UOM first','error');
			}else{
			var unit_cost = $('#unit_cost').val();
			var discount1_val = $('#discount1').val();
			var discount2_val = $('#discount2').val();
			var discount3_val = $('#discount3').val();
			
			var disc_type1_val = $('#disc_type1').val();
			var disc_type2_val = $('#disc_type2').val();
			var disc_type3_val = $('#disc_type3').val();
			
			var discount1_perc = 0;
			var discount1_amt = 0;
			
			var discount2_perc = 0;
			var discount2_amt = 0;
			
			var discount3_perc = 0;
			var discount3_amt = 0;
			
			if (disc_type1_val == 'percent')
			discount1_perc = discount1_val;
			else //if (disc_type1_val == 'amount')
			discount1_amt = discount1_val;
			
			if (disc_type2_val == 'percent')
			discount2_perc = discount2_val;
			else //if (disc_type1_val == 'amount')
			discount2_amt = discount2_val;
			
			if (disc_type3_val == 'percent')
			discount3_perc = discount3_val;
			else //if (disc_type1_val == 'amount')
			discount3_amt = discount3_val;
			
			var avg_cost = (unit_cost/qty)+0;
			var total_net_cost = (((((unit_cost*(1-(discount1_perc/100))) - discount1_amt)
			*(1-(discount2_perc/100))) - discount2_amt)
			*(1-(discount3_perc/100))) - discount3_amt;
			
			var avg_net_cost = total_net_cost/qty;
			
			$('#avg_cost').attr({'value' : avg_cost}).val(avg_cost);
			$('#net_cost').attr({'value' : total_net_cost}).val(total_net_cost);
			$('#avg_net_cost').attr({'value' : avg_net_cost}).val(avg_net_cost);
			}
			//==========================================  
			var net_num = $('#net_cost').val(); 	
			num1 = Math.round(net_num*10000)/10000;
			$('#net_cost').val(num1);
			
			var avg_net_num = $('#avg_net_cost').val(); 	
			num2 = Math.round(avg_net_num*10000)/10000;
			$('#avg_net_cost').val(num2);
			
			var avg_num = $('#avg_cost').val(); 	
			num3 = Math.round(avg_num*10000)/10000;
			$('#avg_cost').val(num3);
			//============================================
			return false;
			});
			//--################################# add supplier
			
			<?php elseif($use_js == 'addsupplierStockFormJs'): ?>
			
			$('#adder_form_div').show();
			
			//----------Btns
			$('.adder_form_btns').show();
			$('.edit_form_btns').hide();
			//----------Btns
			
			$('#init-contents').show();
			$('#file-spinner').hide();
			$('#stock-barcode-contents').hide();
			
			$('.toUpper').blur(function(){
			$(this).val($(this).val().toUpperCase());
			});
			
			$('#qty, #con_qty').attr('readonly', 'readonly');
			
			//======================
			$('#con_unit_cost').blur(function(){
			var con_unit_cost = $(this).val();
			var unit_cost = $('#unit_cost').val();
			
			var p_con_unit_cost = parseFloat(con_unit_cost);
			var p_unit_cost = parseFloat(unit_cost);
			
			if(p_unit_cost != p_con_unit_cost){
			// alert(p_unit_cost+'<===>'+p_con_unit_cost);
			rMsg('Unit Cost does not match!','error');
			$('#con_unit_cost').focus();
			}
			return false;
			});
			
			$('#con_uom').change(function(){
			// $('#con_uom').blur(function(){
			var con_uom = $(this).val();
			var uom = $('#uom').val();
			
			// alert(uom+'<===>'+con_uom);
			if( uom != con_uom ){
			// if( con_uom != ''){
			rMsg('UOM does not match!','error');
			$('#con_uom').focus();
			// }
			// else{
			// $('#con_uom').focus();
			// }
			}
			return false;
			});
			//======================
			
			function get_main_supp_stock_uom(uom){
			// alert('MAIN --- Old UOM:'+uom);
			var convert_url2 = baseUrl + 'inventory/get_supp_stock_uom';
			$.post(convert_url2, {'uom' : uom}, function(data){
			// alert('MAIN --- Old UOM:'+data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_hidden_stock_uom').attr('value', uom).val(uom);
			$('.uom_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_main_supp_con_stock_uom(uom){
			// alert('MAIN --- Old UOM:'+uom);
			var convert_url2 = baseUrl + 'inventory/get_supp_stock_uom';
			$.post(convert_url2, {'uom' : uom}, function(data){
			// alert('MAIN --- Old UOM:'+data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_con_hidden_stock_uom').attr('value', uom).val(uom);
			$('.con_uom_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_main_branch_id(branch_code){
			// alert('[main] Old Branch:'+branch_code);
			var con_url = baseUrl + 'inventory/get_branch_id_from_code';
			$.post(con_url, {'branch_code' : branch_code}, function(data){
			// alert('[main] NEW '+data);
			// alert('[main] Passed branch id : '+branch_code);
			$('.c_hidden_branch_id').attr('value', data).val(data);
			$('.branch_dropdown').attr('value', branch_code).val(branch_code);
			});
			}
			
			$('#uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
			// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
			$('#qty').attr('value', data).val(data);
			get_main_supp_stock_uom(uom);
			});
			return false;
			});
			
			$('#con_uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
			$('#con_qty').attr('value', data).val(data);
			get_main_supp_con_stock_uom(uom);
			});
			return false;
			});
			
			$('#branch_id').change(function(){
			var branch_code = $(this).val();
			// alert(' Labas ng Add button :'+branch_code);
			
			get_main_branch_id(branch_code);
			
			return false;
			});
			
			function load_supplier_stock_list(){
			var ref = $('#hidden_stock_id').val();
			// alert('ref : '+ref);
			$data = decodeURI(ref).split('|');
			var dtr_url = '<?php echo base_url() ?>inventory/load_supplier_stocks_add';
			$('#file-spinner').show();
			$('#init-contents').hide();
			$('#stock-barcode-contents').hide();
			
			$.post(dtr_url, {'ref' : $data[0]}, function(data){
			$('#file-spinner').hide();
			$('#init-contents').hide();
			$('#stock-barcode-contents').show();
			$('#stock-barcode-contents').html(data);
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
			return false;
			});
			}
			
			load_supplier_stock_list();
			
			var mode = $('#mode').val();
			
			var inputs = $('.supp_req_form').each(function(){
			// alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
			});
			
			$('#save_supp_stock_btn').click(function()
			{
			$('#saving_type').attr({'value':'single'}).val('single');
			// alert('Save Supp Stock - ADD');
			$("#supplier_stock_form").rOkay({
			btn_load		: 	$('#save_supp_stock_btn'),
			btn_load_remove	: 	true,
			asJson			: 	true,
			onComplete		:	function(data){
			// alert(data);
			if (typeof data.result != "undefined") {
			rMsg(data.msg,data.result);
			// if (data.result == "error" || data.result == "warning")
			// $('#supp_stock_code').focus();
			if (data.result == "success"){
			var stock_id = data.stock_id;
			var supp_stock_code = data.supp_stock_code;
			var branch = data.branch;
			// var form_mode = $('#mode').val();
			var form_mode = data.form_mode;
			var passed_form = '';
			var input_name = '';
			var input_names = '';
			var supplier_details_stock_logs = '';
			var old_val = '';
			var supplier_id =  $('#hidden_supp_stock_id').val();												
			load_supplier_stock_list();
			}
			}
			}
			});
			return false;
			});
			
			$('#save_all_supp_stock_btn').click(function()
			{
			// alert('ALL BRANCHES');
			$('#saving_type').attr({'value':'all'}).val('all');
			
			$("#supplier_stock_form").rOkay({
			btn_load		: 	$('#save_all_supp_stock_btn'),
			btn_load_remove	: 	true,
			asJson			: 	true,
			onComplete		:	function(data){
			//alert(data);
			if (typeof data.result != "undefined") {
			rMsg(data.msg,data.result);
			//console.log(data.msg,data.result);
			//alert(data);
			// if (data.result == "error" || data.result == "warning")
			// $('#supp_stock_code').focus();
			if (data.result == "success"){
			
			var stock_id = data.stock_id;
			var supp_stock_code = data.supp_stock_code;
			//var branch = data.branch;
			var branch = 'All';
			// var form_mode = $('#mode').val();
			var form_mode = data.form_mode;
			var passed_form = '';
			var input_name = '';
			var input_names = '';
			var supplier_details_stock_logs = '';
			var old_val = '';
			var supplier_id =  $('#hidden_supp_stock_id').val();	
			console.log('ddd');
			load_supplier_stock_list();
			}
			}
			
			}
			});
			return false;
			});
			
			$('#supp_stock_back_btn').on('click',function(event)
			{
			var ref = $('#hidden_stock_id').val();
			$data = decodeURI(ref).split('|');
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master/'+$data[0]+'|details_link';
			});
			
			$('#supp_stock_next_btn').on('click',function(event)
			{
			var ref = $('#hidden_stock_id').val();
			$data = decodeURI(ref).split('|');
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master/'+$data[0]+'|barcode_details_link';
			});
			
			// // $('#unit_cost, #discount1, #discount2, #discount3, #disc_type1, #disc_type2, #disc_type3').blur(function(){
			$('.uom_dropdown').change(function(){
			// alert('Pfft of UOM!');
			var qty = ($('#qty').val() == '' ? 0 : $('#qty').val());
			// if(qty == ''){
			// rMsg('Please select UOM first','error');
			// }else{
			var unit_cost = ($('#unit_cost').val() == '' ? 0 : $('#unit_cost').val());
			var discount1_val = $('#discount1').val();
			var discount2_val = $('#discount2').val();
			var discount3_val = $('#discount3').val();
			
			var disc_type1_val = $('#disc_type1').val();
			var disc_type2_val = $('#disc_type2').val();
			var disc_type3_val = $('#disc_type3').val();
			
			var discount1_perc = 0;
			var discount1_amt = 0;
			
			var discount2_perc = 0;
			var discount2_amt = 0;
			
			var discount3_perc = 0;
			var discount3_amt = 0;
			
			if (disc_type1_val == 'percent')
			discount1_perc = discount1_val;
			else //if (disc_type1_val == 'amount')
			discount1_amt = discount1_val;
			
			if (disc_type2_val == 'percent')
			discount2_perc = discount2_val;
			else //if (disc_type1_val == 'amount')
			discount2_amt = discount2_val;
			
			if (disc_type3_val == 'percent')
			discount3_perc = discount3_val;
			else //if (disc_type1_val == 'amount')
			discount3_amt = discount3_val;
			
			// alert('Average Cost on change '+unit_cost+' / '+qty+' : '+(unit_cost/qty)+0);
			
			var avg_cost = (unit_cost/qty)+0;
			var total_net_cost = (((((unit_cost*(1-(discount1_perc/100))) - discount1_amt)
			*(1-(discount2_perc/100))) - discount2_amt)
			*(1-(discount3_perc/100))) - discount3_amt;
			
			var avg_net_cost = total_net_cost/qty;
			
			$('#avg_cost').attr({'value' : avg_cost}).val(avg_cost);
			$('#net_cost').attr({'value' : total_net_cost}).val(total_net_cost);
			$('#avg_net_cost').attr({'value' : avg_net_cost}).val(avg_net_cost);
			// }
			return false;
			});
			
			$('#unit_cost, #discount1, #discount2, #discount3, #disc_type1, #disc_type2, #disc_type3').blur(function(){
			// alert('Pfft!');
			var qty = $('#qty').val();
			if(qty == ''){
			rMsg('Please select UOM first','error');
			}else{
			var unit_cost = $('#unit_cost').val();
			var discount1_val = $('#discount1').val();
			var discount2_val = $('#discount2').val();
			var discount3_val = $('#discount3').val();
			
			var disc_type1_val = $('#disc_type1').val();
			var disc_type2_val = $('#disc_type2').val();
			var disc_type3_val = $('#disc_type3').val();
			
			var discount1_perc = 0;
			var discount1_amt = 0;
			
			var discount2_perc = 0;
			var discount2_amt = 0;
			
			var discount3_perc = 0;
			var discount3_amt = 0;
			
			if (disc_type1_val == 'percent')
			discount1_perc = discount1_val;
			else //if (disc_type1_val == 'amount')
			discount1_amt = discount1_val;
			
			if (disc_type2_val == 'percent')
			discount2_perc = discount2_val;
			else //if (disc_type1_val == 'amount')
			discount2_amt = discount2_val;
			
			if (disc_type3_val == 'percent')
			discount3_perc = discount3_val;
			else //if (disc_type1_val == 'amount')
			discount3_amt = discount3_val;
			
			var avg_cost = (unit_cost/qty)+0;
			var total_net_cost = (((((unit_cost*(1-(discount1_perc/100))) - discount1_amt)
			*(1-(discount2_perc/100))) - discount2_amt)
			*(1-(discount3_perc/100))) - discount3_amt;
			
			var avg_net_cost = total_net_cost/qty;
			
			$('#avg_cost').attr({'value' : avg_cost}).val(avg_cost);
			$('#net_cost').attr({'value' : total_net_cost}).val(total_net_cost);
			$('#avg_net_cost').attr({'value' : avg_net_cost}).val(avg_net_cost);
			}
			//==========================================  
			var net_num = $('#net_cost').val(); 	
			num1 = Math.round(net_num*10000)/10000;
			$('#net_cost').val(num1);
			
			var avg_net_num = $('#avg_net_cost').val(); 	
			num2 = Math.round(avg_net_num*10000)/10000;
			$('#avg_net_cost').val(num2);
			
			var avg_num = $('#avg_cost').val(); 	
			num3 = Math.round(avg_num*10000)/10000;
			$('#avg_cost').val(num3);
			//============================================
			return false;
			});
			
			<?php elseif($use_js == 'addreloadSupplierStockDetailsJs'): ?>
			//---------------INITIAL LOAD--------------//
			$('#adder_form_div').show();
			
			$('.edit_supplier_stock, .add_supplier_stock').tooltip({
			'show': true,
			'placement': 'left',
			// 'title': "Please remember to..."
			});
			
			$('#qty').attr('readonly', 'readonly');
			//==========================================
			if($('#net_cost').val() != ''){
			
			var num = $('#net_cost').val(); 
			
			num1 = Math.round(num*10000)/10000;
			$('#net_cost').val(num1);
			}
			if($('#avg_net_cost').val() != ''){	  
			var num = $('#avg_net_cost').val(); 
			
			num1 = Math.round(num*10000)/10000;
			$('#avg_net_cost').val(num1);
			}
			if($('#avg_cost').val() != ''){	  
			var num = $('#avg_cost').val(); 
			
			num1 = Math.round(num*10000)/10000;
			$('#avg_cost').val(num1);
			}
			//============================================
			function reload_qty(uom){
			$('#qty').attr('readonly', 'readonly');
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
			// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
			$('#qty').attr('value', data).val(data);
			get_supp_stock_uom(uom); //reloads value of dropdown and hidden
			});
			}
			
			function get_branch_code(branch_id){
			// alert('Old Branch:'+branch_id);
			var con_url = baseUrl + 'inventory/get_branch_code';
			$.post(con_url, {'branch_id' : branch_id}, function(data){
			// alert('Passed branch id : '+branch_id);
			// alert('NEW Branch DATA : '+data);
			$('.c_hidden_branch_id').attr('value', branch_id).val(branch_id);
			$('.branch_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_supp_name(supp_id){
			// alert('Old Supplier:'+supp_id);
			var convert_url = baseUrl + 'inventory/get_supp_name';
			$.post(convert_url, {'supp_id' : supp_id}, function(data){
			// alert(data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_hidden_supplier_id').attr('value', supp_id).val(supp_id);
			$('.supp_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_supp_stock_uom(uom){
			// alert('Old UOM:'+uom);
			var convert_url2 = baseUrl + 'inventory/get_supp_stock_uom';
			$.post(convert_url2, {'uom' : uom}, function(data){
			// alert('New UOM'+data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_hidden_stock_uom').attr('value', uom).val(uom);
			$('.uom_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_supp_con_stock_uom(uom){
			// alert('Old UOM:'+uom);
			var convert_url2 = baseUrl + 'inventory/get_supp_stock_uom';
			$.post(convert_url2, {'uom' : uom}, function(data){
			// alert('New UOM'+data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_con_hidden_stock_uom').attr('value', uom).val(uom);
			$('.con_uom_dropdown').attr('value', data).val(data);
			});
			}
			
			function load_supplier_stock_list(){
			var ref = $('#hidden_stock_id').val();
			var id = $('#ids').val();
			// alert('ref : '+ref);
			$data = decodeURI(ref).split('|');
			var dtr_url = '<?php echo base_url() ?>inventory/load_supplier_stocks_add';
			$('#file-spinner').show();
			$('#init-contents').hide();
			$('#stock-barcode-contents').hide();
			
			$.post(dtr_url, {'ref' :$data[0]}, function(data){
			$('#file-spinner').hide();
			$('#init-contents').hide();
			$('#stock-barcode-contents').show();
			$('#stock-barcode-contents').html(data);
			$('#'+id).css("background-color", " #f8f6ba");	
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
			return false;
			});
			}
			
			//---------------ADD-RELATED FUNCTIONS--------------//
			$('.add_supplier_stock').click(function(){
			// alert('Add of Supplier Stock Details');
			
			$('#adder_form_div').show();
			
			//----------Btns
			$('.adder_form_btns').show();
			// $('.edit_form_btns').hide();
			//----------Btns
			
			$('#qty, #con_qty').attr('readonly', 'readonly');
			
			$('#uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
			// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
			$('#qty').attr('value', data).val(data);
			});
			return false;
			});
			
			$('.supp_mode').attr({'value':'add'}).val('add');
			
			//----------RESET VALUES FOR NEW SUPPLIER STOCK----------START
			$('.c_hidden_supplier_stock_id').attr({'value' : ''}).val('');
			$('#supp_stock_code').attr({'value' : ''}).val('');
			$('#qty').attr({'value' : ''}).val('');
			$('#con_qty').attr({'value' : ''}).val('');
			$('.supp_desc_text').attr({'value' : ''}).val('');
			$('#unit_cost').attr({'value' : ''}).val('');
			$('#con_unit_cost').attr({'value' : ''}).val('');
			$('#avg_cost').attr({'value' : ''}).val('');
			
			$('.disc1').attr({'value' : ''}).val('');
			$('.disc_type1_drop').attr({'value' : ''}).val('');
			$('.disc2').attr({'value' : ''}).val('');
			$('.disc_type2_drop').attr({'value' : ''}).val('');
			$('.disc3').attr({'value' : ''}).val('');
			$('.disc_type3_drop').attr({'value' : ''}).val('');
			
			$('#net_cost').attr({'value' : ''}).val('');
			$('#avg_net_cost').attr({'value' : ''}).val('');
			
			$('.supp_dropdown').attr({'value' : ''}).val('');
			$('.supp_dropdown').focus();
			$('.branch_dropdown').attr({'value' : ''}).val('');
			$('.uom_dropdown').attr({'value' : ''}).val('');
			$('.con_uom_dropdown').attr({'value' : ''}).val('');
			
			$('.c_hidden_branch_id').attr('old_val', '');
			$('.c_hidden_supplier_id').attr('old_val', '');
			$('.c_hidden_supplier_id').attr('old_val', '');
			$('#supp_stock_code').attr('old_val', '');
			$('#qty').attr('old_val', '');
			$('.supp_desc_text').attr('old_val', '');
			$('#unit_cost').attr('old_val', '');
			$('#avg_cost').attr('old_val', '');
			$('.disc1').attr('old_val', '');
			$('.disc_type1_drop').attr('old_val', '');
			$('.disc2').attr('old_val', '');
			$('.disc_type2_drop').attr('old_val', '');
			$('.disc3').attr('old_val', '');
			$('.disc_type3_drop').attr('old_val', '');
			$('#net_cost').attr('old_val', '');
			$('#avg_net_cost').attr('old_val', '');
			//----------RESET VALUES FOR NEW SUPPLIER STOCK----------END
			
			//----------For adding functions
			$('#supp_stock_back_btn').on('click',function(event)
			{
			var ref = $('#hidden_stock_id').val();
			$data = decodeURI(ref).split('|');
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master/'+$data[0]+'|details_link';
			});
			
			$('#supp_stock_next_btn').on('click',function(event)
			{
			var ref = $('#hidden_stock_id').val();
			$data = decodeURI(ref).split('|');
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master/'+$data[0]+'|barcode_details_link';
			});
			
			return false;
			});	
			//---------------ADD-RELATED FUNCTIONS--------------//
			$('.edit_supplier_stock').click(function(){
			// alert('edit to');
			
			$('.supp_mode').attr({'value':'edit'}).val('edit');
			//----------Btns
			$('.adder_form_btns').show();
			// $('.edit_form_btns').hide();
			//----------Btns
			
			$('.supp_mode').attr({'value':'edit'}).val('edit');
			var ref = $(this).attr('ref');
			$('#ids').val(ref);
			var supp_stock_code = $(this).attr('ref_supp_stock_code');
			var supp_id = $(this).attr('ref_supp_id');
			var ref_desc = $(this).attr('ref_desc');
			var supp_id = $(this).attr('ref_supp_id');
			var branch_id = $(this).attr('ref_branch_id');
			var uom = $(this).attr('ref_uom');
			var qty = $(this).attr('ref_qty');
			var unit_cost = $(this).attr('ref_unit_cost');
			var disc_percent1 = $(this).attr('ref_disc_percent1');
			var disc_percent2 = $(this).attr('ref_disc_percent2');
			var disc_percent3 = $(this).attr('ref_disc_percent3');
			var disc_amount1 = $(this).attr('ref_disc_amount1');
			var disc_amount2 = $(this).attr('ref_disc_amount2');
			var disc_amount3 = $(this).attr('ref_disc_amount3');
			var avg_cost = $(this).attr('ref_avg_cost');
			var net_cost = $(this).attr('ref_net_cost');
			var is_default = $(this).attr('def');
			var avg_net_cost = $(this).attr('ref_avg_net_cost');
			var inactive = $(this).attr('ref_status');
			//alert('Default val : '+is_default);
			var disc_type1 = $('.disc_type1_drop').val();
			var disc_type2 = $('.disc_type2_drop').val();
			var disc_type3 = $('.disc_type3_drop').val();
			
			get_branch_code(branch_id); //reloads value of dropdown and hidden
			get_supp_name(supp_id); //reloads value of dropdown and hidden
			get_supp_stock_uom(uom); //reloads value of dropdown and hidden
			get_supp_con_stock_uom(uom); //reloads value of dropdown and hidden
			
			$('.c_hidden_branch_id').attr('old_val', branch_id);
			$('.c_hidden_supplier_id').attr('old_val', supp_id);
			$('.c_hidden_stock_uom').attr('old_val', uom);
			$('#default_stock').attr('old_val', is_default);
			
			$('.c_hidden_supplier_stock_id').attr({'value' : ref}).val(ref);
			$('#supp_stock_code').attr({'value' : supp_stock_code}).val(supp_stock_code);
			$('#default_stock').attr({'value' : is_default}).val(is_default);
			$('#supp_stock_code').attr({'old_val' : supp_stock_code});
			$('#hidden_supp_stock_id').attr({'value' : supp_id}).val(supp_id);
			$('#qty').attr({'value' : qty}).val(qty);
			$('#qty').attr({'old_val' : qty});
			$('#con_qty').attr({'value' : qty}).val(qty);
			$('.supp_desc_text').attr({'value' : ref_desc}).val(ref_desc);
			$('.supp_desc_text').attr({'old_val' : ref_desc});
			$('#unit_cost').attr({'value' : unit_cost}).val(unit_cost);
			$('#unit_cost').attr({'old_val' : unit_cost});
			$('#con_unit_cost').attr({'value' : unit_cost}).val(unit_cost);
			$('#avg_cost').attr({'value' : avg_cost}).val(avg_cost);
			$('#avg_cost').attr({'old_val' : avg_cost});
			
			if(disc_percent1 == 0){
			$('.disc1').attr({'value' : disc_amount1}).val(disc_amount1);
			$('.disc1').attr({'old_val' : disc_amount1});
			$('.disc_type1_drop').attr({'value' : 'amount'}).val('amount');
			$('.disc_type1_drop').attr({'old_val' : 'amount'});
			// $('.disc_type1_drop').text('amount');
			}else if(disc_amount1 == 0){
			$('.disc1').attr({'value' : disc_percent1}).val(disc_percent1);
			$('.disc1').attr({'old_val' : disc_percent1});
			$('.disc_type1_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type1_drop').attr({'old_val' : 'percent'});
			// $('.disc_type1_drop').text('percent');
			}else{
			$('.disc1').attr({'value' : 0}).val(0);
			$('.disc1').attr({'old_val' : 0});
			$('.disc_type1_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type1_drop').attr({'old_val' : 'percent'});
			}
			
			if(disc_percent2 == 0){
			$('.disc2').attr({'value' : disc_amount2}).val(disc_amount2);
			$('.disc2').attr({'old_val' : disc_amount2});
			$('.disc_type2_drop').attr({'value' : 'amount'}).val('amount');
			$('.disc_type2_drop').attr({'old_val' : 'amount'});
			// $('.disc_type2_drop').text('amount');
			}else if(disc_amount2 == 0){
			$('.disc2').attr({'value' : disc_percent2}).val(disc_percent2);
			$('.disc2').attr({'old_val' : disc_percent2});
			$('.disc_type2_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type2_drop').attr({'old_val' : 'percent'});
			// $('.disc_type2_drop').text('percent');
			}else{
			$('.disc2').attr({'value' : 0}).val(0);
			$('.disc2').attr({'old_val' : 0});
			$('.disc_type2_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type2_drop').attr({'old_val' : 'percent'});
			}
			
			if(disc_percent3 == 0){
			$('.disc3').attr({'value' : disc_amount3}).val(disc_amount3);
			$('.disc3').attr({'old_val' : disc_amount3});
			$('.disc_type3_drop').attr({'value' : 'amount'}).val('amount');
			$('.disc_type3_drop').attr({'old_val' : 'amount'});
			// $('.disc_type3_drop').text('amount');
			}else if(disc_amount3 == 0){
			$('.disc3').attr({'value' : disc_percent3}).val(disc_percent3);
			$('.disc3').attr({'old_val' : disc_percent3});
			$('.disc_type3_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type3_drop').attr({'old_val' : 'percent'});
			// $('.disc_type3_drop').text('percent');
			}else{
			$('.disc3').attr({'value' : 0}).val(0);
			$('.disc3').attr({'old_val' : 0});
			$('.disc_type3_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type3_drop').attr({'old_val' : 'percent'});
			}
			
			// $('.uom_dropdown').attr({'value' : uom}).val(uom);
			
			$('#net_cost').attr({'value' : net_cost}).val(net_cost);
			$('#net_cost').attr({'old_val' : net_cost});
			$('#avg_net_cost').attr({'value' : avg_net_cost}).val(avg_net_cost);
			$('#avg_net_cost').attr({'old_val' : avg_net_cost});
			
			$('.is_def_class').attr({'value' : is_default}).val(is_default);
			$('.is_def_class').attr({'old_val' : is_default});
			
			load_supplier_stock_list(); //-----reload supplier stock list
			
			return false;
			});
			
			
			
			
			
			
			
			
			
			
			
			
			
			//#####################################################################
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<?php elseif($use_js == 'reloadSupplierStockDetailsJs'): ?>
			//---------------INITIAL LOAD--------------//
			$('#adder_form_div').show();
			
			$('.edit_supplier_stock, .add_supplier_stock').tooltip({
			'show': true,
			'placement': 'left',
			// 'title': "Please remember to..."
			});
			
			$('#qty').attr('readonly', 'readonly');
			//==========================================
			if($('#net_cost').val() != ''){
			
			var num = $('#net_cost').val(); 
			
			num1 = Math.round(num*10000)/10000;
			$('#net_cost').val(num1);
			}
			if($('#avg_net_cost').val() != ''){	  
			var num = $('#avg_net_cost').val(); 
			
			num1 = Math.round(num*10000)/10000;
			$('#avg_net_cost').val(num1);
			}
			if($('#avg_cost').val() != ''){	  
			var num = $('#avg_cost').val(); 
			
			num1 = Math.round(num*10000)/10000;
			$('#avg_cost').val(num1);
			}
			//============================================
			function reload_qty(uom){
			$('#qty').attr('readonly', 'readonly');
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
			// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
			$('#qty').attr('value', data).val(data);
			get_supp_stock_uom(uom); //reloads value of dropdown and hidden
			});
			}
			
			function get_branch_code(branch_id){
			// alert('Old Branch:'+branch_id);
			var con_url = baseUrl + 'inventory/get_branch_code';
			$.post(con_url, {'branch_id' : branch_id}, function(data){
			// alert('Passed branch id : '+branch_id);
			// alert('NEW Branch DATA : '+data);
			$('.c_hidden_branch_id').attr('value', branch_id).val(branch_id);
			$('.branch_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_supp_name(supp_id){
			// alert('Old Supplier:'+supp_id);
			var convert_url = baseUrl + 'inventory/get_supp_name';
			$.post(convert_url, {'supp_id' : supp_id}, function(data){
			// alert(data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_hidden_supplier_id').attr('value', supp_id).val(supp_id);
			$('.supp_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_supp_stock_uom(uom){
			// alert('Old UOM:'+uom);
			var convert_url2 = baseUrl + 'inventory/get_supp_stock_uom';
			$.post(convert_url2, {'uom' : uom}, function(data){
			// alert('New UOM'+data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_hidden_stock_uom').attr('value', uom).val(uom);
			$('.uom_dropdown').attr('value', data).val(data);
			});
			}
			
			function get_supp_con_stock_uom(uom){
			// alert('Old UOM:'+uom);
			var convert_url2 = baseUrl + 'inventory/get_supp_stock_uom';
			$.post(convert_url2, {'uom' : uom}, function(data){
			// alert('New UOM'+data);
			// alert('New Branch : '+$('.branch_dropdown').val()); //checker of new value
			$('.c_con_hidden_stock_uom').attr('value', uom).val(uom);
			$('.con_uom_dropdown').attr('value', data).val(data);
			});
			}
			
			function load_supplier_stock_list(){
			var ref = $('#hidden_stock_id').val();
			var id = $('#ids').val();
			// alert('ref : '+ref);
			var dtr_url = '<?php echo base_url() ?>inventory/load_supplier_stocks';
			$('#file-spinner').show();
			$('#init-contents').hide();
			$('#stock-barcode-contents').hide();
			
			$.post(dtr_url, {'ref' : ref}, function(data){
			$('#file-spinner').hide();
			$('#init-contents').hide();
			$('#stock-barcode-contents').show();
			$('#stock-barcode-contents').html(data);
			$('#'+id).css("background-color", " #f8f6ba");	
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
			return false;
			});
			}
			
			//---------------ADD-RELATED FUNCTIONS--------------//
			$('.add_supplier_stock').click(function(){
			// alert('Add of Supplier Stock Details');
			
			$('#adder_form_div').show();
			
			//----------Btns
			$('.adder_form_btns').show();
			// $('.edit_form_btns').hide();
			//----------Btns
			
			$('#qty, #con_qty').attr('readonly', 'readonly');
			
			$('#uom').change(function(){
			var uom = $(this).val();
			// alert('UOM Val : '+uom);
			var converter_url = baseUrl + 'inventory/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
			// alert('New Uom Qty : '+$('#report_qty').val()); //checker of new value
			$('#qty').attr('value', data).val(data);
			});
			return false;
			});
			
			$('.supp_mode').attr({'value':'add'}).val('add');
			
			//----------RESET VALUES FOR NEW SUPPLIER STOCK----------START
			$('.c_hidden_supplier_stock_id').attr({'value' : ''}).val('');
			$('#supp_stock_code').attr({'value' : ''}).val('');
			$('#qty').attr({'value' : ''}).val('');
			$('#con_qty').attr({'value' : ''}).val('');
			$('.supp_desc_text').attr({'value' : ''}).val('');
			$('#unit_cost').attr({'value' : ''}).val('');
			$('#con_unit_cost').attr({'value' : ''}).val('');
			$('#avg_cost').attr({'value' : ''}).val('');
			
			$('.disc1').attr({'value' : ''}).val('');
			$('.disc_type1_drop').attr({'value' : ''}).val('');
			$('.disc2').attr({'value' : ''}).val('');
			$('.disc_type2_drop').attr({'value' : ''}).val('');
			$('.disc3').attr({'value' : ''}).val('');
			$('.disc_type3_drop').attr({'value' : ''}).val('');
			
			$('#net_cost').attr({'value' : ''}).val('');
			$('#avg_net_cost').attr({'value' : ''}).val('');
			
			$('.supp_dropdown').attr({'value' : ''}).val('');
			$('.supp_dropdown').focus();
			$('.branch_dropdown').attr({'value' : ''}).val('');
			$('.uom_dropdown').attr({'value' : ''}).val('');
			$('.con_uom_dropdown').attr({'value' : ''}).val('');
			
			$('.c_hidden_branch_id').attr('old_val', '');
			$('.c_hidden_supplier_id').attr('old_val', '');
			$('.c_hidden_supplier_id').attr('old_val', '');
			$('#supp_stock_code').attr('old_val', '');
			$('#qty').attr('old_val', '');
			$('.supp_desc_text').attr('old_val', '');
			$('#unit_cost').attr('old_val', '');
			$('#avg_cost').attr('old_val', '');
			$('.disc1').attr('old_val', '');
			$('.disc_type1_drop').attr('old_val', '');
			$('.disc2').attr('old_val', '');
			$('.disc_type2_drop').attr('old_val', '');
			$('.disc3').attr('old_val', '');
			$('.disc_type3_drop').attr('old_val', '');
			$('#net_cost').attr('old_val', '');
			$('#avg_net_cost').attr('old_val', '');
			//----------RESET VALUES FOR NEW SUPPLIER STOCK----------END
			
			//----------For adding functions
			$('.supp_stock_back_btn').on('click',function(event)
			{
			event.preventDefault();
			window.location = baseUrl + 'inventory/stock_master';
			return false;
			});
			
			return false;
			});	
			//---------------ADD-RELATED FUNCTIONS--------------//
			$('.edit_supplier_stock').click(function(){
			// alert('edit to');
			
			$('.supp_mode').attr({'value':'edit'}).val('edit');
			//----------Btns
			$('.adder_form_btns').show();
			// $('.edit_form_btns').hide();
			//----------Btns
			
			$('.supp_mode').attr({'value':'edit'}).val('edit');
			var ref = $(this).attr('ref');
			$('#ids').val(ref);
			var supp_stock_code = $(this).attr('ref_supp_stock_code');
			var supp_id = $(this).attr('ref_supp_id');
			var ref_desc = $(this).attr('ref_desc');
			var supp_id = $(this).attr('ref_supp_id');
			var branch_id = $(this).attr('ref_branch_id');
			var uom = $(this).attr('ref_uom');
			var qty = $(this).attr('ref_qty');
			var unit_cost = $(this).attr('ref_unit_cost');
			var disc_percent1 = $(this).attr('ref_disc_percent1');
			var disc_percent2 = $(this).attr('ref_disc_percent2');
			var disc_percent3 = $(this).attr('ref_disc_percent3');
			var disc_amount1 = $(this).attr('ref_disc_amount1');
			var disc_amount2 = $(this).attr('ref_disc_amount2');
			var disc_amount3 = $(this).attr('ref_disc_amount3');
			var avg_cost = $(this).attr('ref_avg_cost');
			var net_cost = $(this).attr('ref_net_cost');
			var is_default = $(this).attr('def');
			var avg_net_cost = $(this).attr('ref_avg_net_cost');
			var inactive = $(this).attr('ref_status');
			//alert('Default val : '+is_default);
			var disc_type1 = $('.disc_type1_drop').val();
			var disc_type2 = $('.disc_type2_drop').val();
			var disc_type3 = $('.disc_type3_drop').val();
			
			get_branch_code(branch_id); //reloads value of dropdown and hidden
			get_supp_name(supp_id); //reloads value of dropdown and hidden
			get_supp_stock_uom(uom); //reloads value of dropdown and hidden
			get_supp_con_stock_uom(uom); //reloads value of dropdown and hidden
			
			$('.c_hidden_branch_id').attr('old_val', branch_id);
			$('.c_hidden_supplier_id').attr('old_val', supp_id);
			$('.c_hidden_stock_uom').attr('old_val', uom);
			$('#default_stock').attr('old_val', is_default);
			
			$('.c_hidden_supplier_stock_id').attr({'value' : ref}).val(ref);
			$('#supp_stock_code').attr({'value' : supp_stock_code}).val(supp_stock_code);
			$('#default_stock').attr({'value' : is_default}).val(is_default);
			$('#supp_stock_code').attr({'old_val' : supp_stock_code});
			$('#hidden_supp_stock_id').attr({'value' : supp_id}).val(supp_id);
			$('#qty').attr({'value' : qty}).val(qty);
			$('#qty').attr({'old_val' : qty});
			$('#con_qty').attr({'value' : qty}).val(qty);
			$('.supp_desc_text').attr({'value' : ref_desc}).val(ref_desc);
			$('.supp_desc_text').attr({'old_val' : ref_desc});
			$('#unit_cost').attr({'value' : unit_cost}).val(unit_cost);
			$('#unit_cost').attr({'old_val' : unit_cost});
			$('#con_unit_cost').attr({'value' : unit_cost}).val(unit_cost);
			$('#avg_cost').attr({'value' : avg_cost}).val(avg_cost);
			$('#avg_cost').attr({'old_val' : avg_cost});
			
			if(disc_percent1 == 0){
			$('.disc1').attr({'value' : disc_amount1}).val(disc_amount1);
			$('.disc1').attr({'old_val' : disc_amount1});
			$('.disc_type1_drop').attr({'value' : 'amount'}).val('amount');
			$('.disc_type1_drop').attr({'old_val' : 'amount'});
			// $('.disc_type1_drop').text('amount');
			}else if(disc_amount1 == 0){
			$('.disc1').attr({'value' : disc_percent1}).val(disc_percent1);
			$('.disc1').attr({'old_val' : disc_percent1});
			$('.disc_type1_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type1_drop').attr({'old_val' : 'percent'});
			// $('.disc_type1_drop').text('percent');
			}else{
			$('.disc1').attr({'value' : 0}).val(0);
			$('.disc1').attr({'old_val' : 0});
			$('.disc_type1_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type1_drop').attr({'old_val' : 'percent'});
			}
			
			if(disc_percent2 == 0){
			$('.disc2').attr({'value' : disc_amount2}).val(disc_amount2);
			$('.disc2').attr({'old_val' : disc_amount2});
			$('.disc_type2_drop').attr({'value' : 'amount'}).val('amount');
			$('.disc_type2_drop').attr({'old_val' : 'amount'});
			// $('.disc_type2_drop').text('amount');
			}else if(disc_amount2 == 0){
			$('.disc2').attr({'value' : disc_percent2}).val(disc_percent2);
			$('.disc2').attr({'old_val' : disc_percent2});
			$('.disc_type2_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type2_drop').attr({'old_val' : 'percent'});
			// $('.disc_type2_drop').text('percent');
			}else{
			$('.disc2').attr({'value' : 0}).val(0);
			$('.disc2').attr({'old_val' : 0});
			$('.disc_type2_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type2_drop').attr({'old_val' : 'percent'});
			}
			
			if(disc_percent3 == 0){
			$('.disc3').attr({'value' : disc_amount3}).val(disc_amount3);
			$('.disc3').attr({'old_val' : disc_amount3});
			$('.disc_type3_drop').attr({'value' : 'amount'}).val('amount');
			$('.disc_type3_drop').attr({'old_val' : 'amount'});
			// $('.disc_type3_drop').text('amount');
			}else if(disc_amount3 == 0){
			$('.disc3').attr({'value' : disc_percent3}).val(disc_percent3);
			$('.disc3').attr({'old_val' : disc_percent3});
			$('.disc_type3_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type3_drop').attr({'old_val' : 'percent'});
			// $('.disc_type3_drop').text('percent');
			}else{
			$('.disc3').attr({'value' : 0}).val(0);
			$('.disc3').attr({'old_val' : 0});
			$('.disc_type3_drop').attr({'value' : 'percent'}).val('percent');
			$('.disc_type3_drop').attr({'old_val' : 'percent'});
			}
			
			// $('.uom_dropdown').attr({'value' : uom}).val(uom);
			
			$('#net_cost').attr({'value' : net_cost}).val(net_cost);
			$('#net_cost').attr({'old_val' : net_cost});
			$('#avg_net_cost').attr({'value' : avg_net_cost}).val(avg_net_cost);
			$('#avg_net_cost').attr({'old_val' : avg_net_cost});
			
			$('.is_def_class').attr({'value' : is_default}).val(is_default);
			$('.is_def_class').attr({'old_val' : is_default});
			
			load_supplier_stock_list(); //-----reload supplier stock list
			
			return false;
			});
			
			<?php elseif($use_js == 'dashboardJs'): ?>
			$(function() {
			"use strict";
			
			// AREA CHART
			var area = new Morris.Area({
			element: 'revenue-chart',
			resize: true,
			data: [
			{y: '2011 Q1', item1: 2666, item2: 2666},
			{y: '2011 Q2', item1: 2778, item2: 2294},
			{y: '2011 Q3', item1: 4912, item2: 1969},
			{y: '2011 Q4', item1: 3767, item2: 3597},
			{y: '2012 Q1', item1: 6810, item2: 1914},
			{y: '2012 Q2', item1: 5670, item2: 4293},
			{y: '2012 Q3', item1: 4820, item2: 3795},
			{y: '2012 Q4', item1: 15073, item2: 5967},
			{y: '2013 Q1', item1: 10687, item2: 4460},
			{y: '2013 Q2', item1: 8432, item2: 5713}
			],
			xkey: 'y',
			ykeys: ['item1', 'item2'],
			labels: ['Item 1', 'Item 2'],
			lineColors: ['#a0d0e0', '#3c8dbc'],
			hideHover: 'auto'
			});
			
			// LINE CHART
			var line = new Morris.Line({
			element: 'line-chart',
			resize: true,
			// data: [
			//     {y: '2011 Q1', item1: 2666},
			//     {y: '2011 Q2', item1: 2778},
			//     {y: '2011 Q3', item1: 4912},
			//     {y: '2011 Q4', item1: 3767},
			//     {y: '2012 Q1', item1: 6810},
			//     {y: '2012 Q2', item1: 5670},
			//     {y: '2012 Q3', item1: 4820},
			//     {y: '2012 Q4', item1: 15073},
			//     {y: '2013 Q1', item1: 10687},
			//     {y: '2013 Q2', item1: 8432},
			// ],
			
			data : [{y: '01 2014', item1:3144},{y: '02 2014', item1:3056},{y: '03 2014', item1:3043},{y: '04 2014', item1:3318},{y: '05 2014', item1:3059},{y: '06 2014', item1:2092},{y: '07 2014', item1:2236},],
			
			// data : [{y: '01 2014', item1:3144},{y: '02 2014', item1:3056},{y: '03 2014', item1:3043},{y: '04 2014', item1:3318},{y: '05 2014', item1:3059},{y: '06 2014', item1:2092},{y: '07 2014', item1:2236},],
			// data : [{y: '2014 Jan', item1:3144},{y: '2014 Feb', item1:3056},{y: '2014 Mar', item1:3043},{y: '2014 Apr', item1:3318},{y: '2014 May', item1:3059},{y: '2014 Jun', item1:2092},{y: '2014 Jul', item1:2236},],
			// data : [{y: '2014 01', item1:3144},{y: '2014 02', item1:3056},{y: '2014 03', item1:3043},{y: '2014 04', item1:3318},{y: '2014 05', item1:3059},{y: '2014 06', item1:2092},{y: '2014 07', item1:2236},],
			xkey: 'y',
			ykeys: ['item1'],
			labels: ['Ticket Requests'],
			lineColors: ['#3c8dbc'],
			hideHover: 'auto'
			});
			
			//DONUT CHART
			var donut = new Morris.Donut({
			element: 'sales-chart',
			resize: true,
			colors: [
			"#f65a54",
			"#f59d54",
			"#3eb562",
			"#329393",
			"#e0462e",
			"#e07f2e",
			"#22a64a",
			"#1c8686",
			"#ff8c7a",
			"#ffb67a",
			"#61cb81",
			"#54afaf",
			"#b32a14",
			"#b35c14",
			"#0f8532",
			"#0c6c6c",
			"#ffb1a5",
			"#ffcea5",
			"#92e1aa",
			"#87d1d1",
			],
			data: [
			{"label": "Download Sales", "value": 12},
			{"label": "In-Store Sales", "value": 30},
			{label: "Mail-Order Sales", value: 20},
			{label: "Mail-Order Sales2", value: 10},
			{label: "Mail-Order Sales23", value: 10},
			{label: "Mail-Order Sales24", value: 10},
			{label: "Mail-Order Sales25", value: 10},
			{label: "Mail-Order Sales26", value: 10}
			],
			hideHover: 'auto'
			});
			// var donut = new Morris.Donut({
			// element: 'sales-chart',
			// });
			
			//BAR CHART
			var bar = new Morris.Bar({
			element: 'bar-chart',
			resize: true,
			data: [
			{y: '2006', a: 100, b: 90},
			{y: '2007', a: 75, b: 65},
			{y: '2008', a: 50, b: 40},
			{y: '2009', a: 75, b: 65},
			{y: '2010', a: 50, b: 40},
			{y: '2011', a: 75, b: 65},
			{y: '2012', a: 100, b: 90}
			],
			barColors: ['#00a65a', '#f56954'],
			xkey: 'y',
			ykeys: ['a', 'b'],
			labels: ['CPU', 'DISK'],
			hideHover: 'auto'
			});
            });
			$('#details').on('click',function(event){
			window.location	= baseUrl+'inv_inquiries/approval_inquiry_container/allnew';
			
			});
			$('#price').on('click',function(event){
			window.location	= baseUrl+'inv_inquiries/approval_inquiry_container/price';
			
			});
			$('#markdown').on('click',function(event){
			window.location	= baseUrl+'inv_inquiries/approval_inquiry_container/markdown';
			
			});
			$('#stock_deletion').on('click',function(event){
			window.location	= baseUrl+'inv_inquiries/approval_inquiry_container/stock_deletion';
			
			});
			$('#update').on('click',function(event){
			window.location	= baseUrl+'upd_inquiries/update_inquiry_container/update';
			
			});
			$('#supplier_stock').on('click',function(event){
			window.location	= baseUrl+'inv_inquiries/approval_inquiry_container/supplier_stock';
			
			});
			$('#marginal').on('click',function(event){
			window.location	= baseUrl+'inv_inquiries/approval_inquiry_container/marginal';
			
			});
			$('#biller_code').on('click',function(event){
			window.location	= baseUrl+'upd_inquiries/update_inquiry_container/biller_code';
			
			});
			$('#stock_barcode_price_approval').on('click',function(event){
			window.location	= baseUrl+'upd_inquiries/update_inquiry_container/barcode_price';
			
			});
			<?php elseif($use_js == 'MovementSearchJs'): ?>
			$('#div-results').hide();	
			$('#btn-search').on('click',function(event)
			{	
			$('#movements_search_form').rOkay(
			{
			//btn_load		: 	$('#btn-search'),
			bnt_load_remove	: 	true,
			asJson			: 	false,
			div_load		: 	$('#div-results'),
			div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
			onComplete		:	function(data){
			//alert(data);
			$('#div-results').empty();
			$('#div-results').html(data);
			$('#movement_lists').hide();
			$('#div-results').show();
			}
			});
			});
			
			$('#btn-movement-back').click(function(){
			window.location	= baseUrl+'inventory/stock_master';
			return false;
			});
			
			<?php endif; ?>
			});
			</script>			