<script>
$(document).ready(function(){
	<?php if($use_js == 'dashboardJs'): ?>
		 "use strict";
		 
	<?php elseif($use_js == 'branchStockSearchJs'): ?>
		$('#btn-search').on('click',function(event)
		{
			$('#branch_stock_search_form').rOkay(
			{
				btn_load		: 	$('#btn-search'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				div_load		: 	$('#div-results'),
				div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
				onComplete		:	function(data){
										$('#div-results').empty();
										$('#div-results').html(data);
									}
			});
		});
	
	<?php elseif($use_js == 'poDashboardJs'): ?>		
		$('#critical_stocks').on('click',function(event){
			window.location	= baseUrl+'po/po_dashboard_container/critical_stocks';
	
		});
		$('#out_of_stock').on('click',function(event){
			window.location	= baseUrl+'po/po_dashboard_container/out_of_stock';
	
		});
		$('#pending_po').on('click',function(event){
			window.location	= baseUrl+'po/po_dashboard_container/pending_po';
	
		});
		$('#unserved_po').on('click',function(event){
			window.location	= baseUrl+'po/po_dashboard_container/unserved_po';
	
		});
		$('#decreasing_offtake').on('click',function(event){
			window.location	= baseUrl+'po/po_dashboard_container/decreasing_offtake';
	
		});
		$('#overstocked_items').on('click',function(event){
			// alert('clicked overstocked');
			window.location	= baseUrl+'po/po_dashboard_container/overstocked_items';
	
		});
	<?php elseif($use_js == 'poDashboardInquiryJs'): ?>
		$('#back-btn').on('click',function(event)
		{
			event.preventDefault();
			window.location = baseUrl + 'po/dashboard';
		});
		
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
			link = '#details_link';
			tab = '#details';
			
		}

		loader(link);
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			$(tabPane).rLoad({url:baseUrl+loadUrl});
		}
		
		$(tab).addClass('active');
		$(link).parent().addClass('active');
	<?php elseif($use_js == 'outOfStockJs'): ?>		
		$('#out_of_stock_spinner').hide();	
	
	<?php elseif($use_js == 'criticalStocksJs'): ?>		
		$('#critical_stocks_spinner').hide();	
		
	<?php elseif($use_js == 'pendingPOJs'): ?>		
		$('#pending_po_spinner').hide();	

		$('.modify_po_link').click(function(){
			var order_no = $(this).attr('ref');
			window.location = baseUrl + 'po/edit_po_entry/'+order_no;
			return false;
		});
		
		$('.cancel_po_link').click(function(event){
			event.preventDefault();
			// alert('cancel po');
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_DANGER,
				title: '<h4>Cancel Purchase Order</h4>',
				message: "<h4>Are you sure you want to <span style='color: red;'>CANCEL</span> this P.O. # "+$('.cancel_po_link').attr('po_ref')+"?</h4>",
				buttons: [
					{
						icon: 'fa fa-remove',
						label: ' CANCEL THIS P.O.',
						cssClass: 'btn btn-danger',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
							
							var order_no = $('.cancel_po_link').attr('order_no');
						//	alert(order_no);
							$.post(baseUrl + 'po/cancel_po', {'order_no' : order_no}, function(data){
								if(data == 'success'){
									rMsg('Purchase Order was successfully cancelled!', 'warning');
									setTimeout(function(){
										thisDialog.close();
										window.location.reload();
									},1500);
								}
							});
						}
					},
					{
						icon: 'fa',
						label: ' CLOSE WINDOW',
						cssClass: 'btn',
						action: function (thisDialog)
						{
							thisDialog.close();
						}
					}
				]
			});
			
		});
		
		$('.view_link').click(function(){
			var _id = $(this).attr('order_id');
			bootbox.dialog({
				title: "Details for PO #"+_id,
				message: baseUrl+'po/pending_po_popup/'+_id,
				className: "bootbox-wide",
				buttons: {
				   success: {
					   label: "Close",
					   className: "btn-success",
					   callback: function () {
							//window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';	
					   }
				   }
				}
			});
			return false;
		});
		
		$('#btn_check_cancel_ppo').click(function(){
				$('.check_id_cancel_ppo').attr('checked','checked');				 
			});
			
		$('#btn_id_cancel_ppo').click(function(){
			$('.check_id_cancel_ppo').hide();
				var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
	
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_DANGER,
				title: '<h4>Cancel Purchase Order</h4>',
				message: "<h4>Are you sure you want to <span style='color: red;'>CANCEL</span> selected PO#?</h4>",
				buttons: [
					{
						icon: 'fa fa-remove',
						label: ' CANCEL THIS P.O.',
						cssClass: 'btn btn-danger',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
						//	alert(ids);
							$.post(baseUrl + 'po/checked_cancel_po', {'ids' : ids}, function(data){
								if(data == 'success'){
									rMsg('Purchase Order was successfully cancelled!', 'warning');
									setTimeout(function(){
										thisDialog.close();
										window.location.reload();
									},1500);
								}
							});
						}
					},
					{
						icon: 'fa',
						label: ' CLOSE WINDOW',
						cssClass: 'btn',
						action: function (thisDialog)
						{
							thisDialog.close();
						}
					}
				]
			});
				
			
		});
	<?php elseif($use_js == 'unservedPOJs'): ?>	
		$('#unserved_po_spinner').hide();	
		
		$('.view_link').click(function(){
			var _id = $(this).attr('order_id');
			bootbox.dialog({
				title: "Details for PO #"+_id,
				message: baseUrl+'po/pending_po_popup/'+_id,
				className: "bootbox-wide",
				buttons: {
				   success: {
					   label: "Close",
					   className: "btn-success",
					   callback: function () {
							//window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';	
					   }
				   }
				}
			});
			return false;
		});
		
		// $('.new_po_link').attr('disabled','disabled');
		// $('.new_po_link').removeAttr('disabled');
		$('.new_po_link').click(function(){
			var this_btn = $(this);
			var ref = $(this).attr('order_no');
			// alert(this_btn);
			// var formData = $('#extend_delivery_date_form').serialize();

			this_btn.attr('disabled','disabled');
			// this_btn.html("<i class='fa fa-2x fa-circle-o-notch fa-spin'></i>LOADING..."); //change the label to loading...
			// this_btn.html("<i class='fa fa-spinner fa-spin fa-fw'></i>LOADING..."); //change the label to loading... //mabilis na loading
			this_btn.html("<i class='fa fa-refresh fa-spin fa-fw'></i>LOADING..."); //change the label to loading... mabagal na loading
			this_btn.addClass('btn-default');
			this_btn.removeClass('btn-info');
			
			$.post(baseUrl+'po/generate_new_po', {'order_no' : ref}, function(data){
				//alert(data);
				this_btn.removeAttr('disabled');
				this_btn.html('<i class="fa fa-refresh fa-fw"></i>Generate New PO'); //change the label back to original entry types
				this_btn.addClass('btn-info');
				this_btn.removeClass('btn-default');
				
				if(data=='success'){
					rMsg('Create another P.O.!', 'success');
					setTimeout(function(){
						window.location = baseUrl+'po/generate_new_po_entry/'+ref;
					},1500);
				}
			});
			return false;
		});
		
		$('.extend_date_link').click(function(){
			// alert('Extend delivery date!');
			var ref = $(this).attr('order_no');
			bootbox.dialog({
				title: "Extend Delivery Date for PO #"+ref,
				message: baseUrl+'po/extend_delivery_date_popup/'+ref,
				className: "bootbox-wide",
				buttons: {
				   update: {
					   label: "Extend",
					   className: "btn-success",
					   callback: function () {
							//window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';
							var formData = $('#extend_delivery_date_form').serialize();
							// alert(formData);
							$.post(baseUrl+'po/extend_delivery_date_to_db', formData, function(data){
								// alert(data);
								//-----ORIGINAL-----START
								// if(data=='success'){
									// rMsg('Email Sent to Supplier!', 'success');
									// setTimeout(function(){
										// window.location.reload();
									// },1500);
								// }else{
									// rMsg('Email Not Sent!', 'warning');
									// setTimeout(function(){
										// window.location.reload();
									// },1500);
								// }
								//-----ORIGINAL-----END
								
								//-----TEMPORARY
								rMsg('Email Sent to Supplier!', 'success');
								setTimeout(function(){
									window.location.reload();
								},1500);
								
							});
					   }
				   },
				   cancel: {
					   label: "Close",
					   className: "btn-default",
					   callback: function () {
							//window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';	
					   }
				   }
				}
			});
			
			// window.location = baseUrl+'po/send_test_mail'; //SENDER NG EMAIL
			return false;
		});
		
	<?php elseif($use_js == 'decreasingOfftakeJs'): ?>	
		$('#decreasing_offtake_spinner').hide();	
		
	<?php elseif($use_js == 'overstockedItemsJs'): ?>	
		$('#overstocked_items_spinner').hide();	
		
	<?php elseif($use_js == 'poEntryJS'): ?>		
		$('#suggest_po_btn').attr('disabled','disabled'); //disable button onload
		$('#save_po_btn').attr('disabled','disabled'); //disable button onload
		
		$('#supplier_id').change(function(){
			var supplier_id = $(this).val();
			// alert('Supplier ID : '+supplier_id);
			var det_url = baseUrl + 'po/get_supplier_master_details';
			// alert('Supplier ID : '+supplier_id);
			$.post(det_url, {'supplier_id' : supplier_id}, function(data){
				// alert(data);
				var vals = data.split('||');
				// if(vals[0] != '' && vals[1] != '')
				// {
					// $('#delivery_date').attr('value', vals[0]).val(vals[0]);
					// $('#supplier_selling_days').attr('value', vals[1]).val(vals[1]);
				// }else{
					// var new_date = new Date("YYYY-MM-DD");
					// $('#delivery_date').attr('value', new_date).val(new_date);
					// $('#supplier_selling_days').attr('value', '').val('');
				// }
				$('#delivery_date').attr('value', vals[0]).val(vals[0]);
				if(vals[1] != '')
				{
					$('#supplier_selling_days').attr('value', vals[1]).val(vals[1]);
				}else{
					$('#supplier_selling_days').attr('value', '').val('');
				}
			});
			return false;
		});
		
		$('#branch_id, #supplier_id').change(function(){
			var branch_id = $('#branch_id').val();
			var supplier_id = $('#supplier_id').val();
			// alert('Branch ID : '+branch_id+' Supplier ID: '+supplier_id);
			if(branch_id != '' && supplier_id != '')
			{
				$('#suggest_po_btn').removeAttr('disabled');
				$('#save_po_btn').removeAttr('disabled');
			}else
			{
				$('#suggest_po_btn').attr('disabled','disabled');
				$('#save_po_btn').attr('disabled','disabled'); //disable button onload
			}
			return false;
		});
		
		function load_uom_hidden_qty(uom){
			var converter_url = baseUrl + 'po/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
				if(data != '')
					$('#uom_qty').attr('value', data).val(data);
				else
					$('#uom_qty').attr('value', 0).val(0);
			});
		}
		
		var uom = $('#uom').val();
		load_uom_hidden_qty(uom);
		
		$('#uom').change(function(){
			var uom = $(this).val();
			load_uom_hidden_qty(uom);
			return false;
		});
		
		function clear_item_adder(){
			$('#stock_id').attr('value', '').val('');
			$('#hidden_stock_id').attr('value', '').val('');
			// $('#quantity_ordered').attr('value', '').val('');
			$('#uom').attr('value', '').val('');
			$('#uom_qty').attr('value', '').val('');
			$('#unit_cost').attr('value', '').val('');
			$('#discount1').attr('value', '').val('');
			// $('#disc_type1').attr('value', '').val('');
			$('#discount2').attr('value', '').val('');
			// $('#disc_type2').attr('value', '').val('');
			$('#discount3').attr('value', '').val('');
			// $('#disc_type3').attr('value', '').val('');
		}
		
		$('#stock_id').change(function(){
			var branch_id = $('#branch_id').val();
			var stock_id = $(this).val();
			// alert(stock_id+' '+branch_id);
			if(stock_id != ''){
				if(branch_id != ''){
					var val_url = baseUrl + 'po/get_supplier_stock_details';
					$.post(val_url, {'stock_id' : stock_id, 'branch_id' : branch_id}, function(data){
						var vals = data.split('||');

						$('#hidden_stock_id').attr('value', vals[0]).val(vals[0]);
						// $('#quantity_ordered').attr('value', data).val(data);
						$('#stock_desc').attr('stock_desc', vals[11]).val(vals[11]);
						
						$('#uom').attr('value', vals[2]).val(vals[2]);
						$('#uom_qty').attr('value', vals[4]).val(vals[4]);
						
						$('#unit_cost').attr('value', vals[3]).val(vals[3]);
						$('#hidden_unit_cost').attr('value', vals[3]).val(vals[3]);
						
						$('#discount1').attr('value', vals[5]).val(vals[5]);
						// $('#disc_type1').attr('value', vals[0]).val(vals[0]);
						$('#discount2').attr('value', vals[6]).val(vals[6]);
						// $('#disc_type2').attr('value', vals[0]).val(vals[0]);
						$('#discount3').attr('value', vals[7]).val(vals[7]);
						// $('#disc_type3').attr('value', vals[0]).val(vals[0]);
						
						if(vals[5] > 0)
							$('#disc_type1').attr('value', 'percent').val('percent');
						else if(vals[8] > 0)
							$('#disc_type1').attr('value', 'amount').val('amount');
						
						if(vals[6] > 0)
							$('#disc_type2').attr('value', 'percent').val('percent');
						else if(vals[9] > 0)
							$('#disc_type2').attr('value', 'amount').val('amount');	
						
						if(vals[7] > 0)
							$('#disc_type3').attr('value', 'percent').val('percent');
						else if(vals[10] > 0)
							$('#disc_type3').attr('value', 'amount').val('amount');	
				
					});
				}else{
					rMsg('Select a branch first!','warning');
					$('.branch_dropdown ').focus();
				}
			}else{
				clear_item_adder();
				$('.supp_stock_drop').focus();
			}
			return false;
		});
		
		//----------Discount Computation----------START
		function recompute_supplier_stock_total(){
			var quantity_ordered = $('#quantity_ordered').val();
			var unit_cost = $('#unit_cost').val();
			
			if(unit_cost == '' || unit_cost == 0){
				rMsg('Unit Cost should not be empty!','warning');
			}else{
				if(quantity_ordered == '' || quantity_ordered == 0){
					rMsg('Quantity Ordered should not be empty!','warning');
					$('#quantity_ordered').focus();
				}else{
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
					
					var disc_unit_cost = (((((unit_cost*(1-(discount1_perc/100))) - discount1_amt)
							*(1-(discount2_perc/100))) - discount2_amt)
							*(1-(discount3_perc/100))) - discount3_amt;
					
					var total_unit_cost = disc_unit_cost*quantity_ordered;
					$('#hidden_disc_unit_cost').attr('value', disc_unit_cost).val(disc_unit_cost);
					$('#total').attr({'value':total_unit_cost}).val(total_unit_cost);	
				}
			}
		}
		
		$('.branch_dropdown').change(function(){
			var branch_id = $('#branch_id').val();
			var val_url = baseUrl + 'po/get_branch_address';
			$.post(val_url, {'branch_id' : branch_id}, function(data){
				// alert(data);
				$('#delivery_address').attr({'value':data}).val(data);
			});
			return false;
		});
		
		$('#branch_id, #supplier_id, #stock_id').change(function(){
			var stock_id = $('#stock_id').val();
			var branch_id = $('#branch_id').val();
			var supplier_id = $('#supplier_id').val();
			
			var val_url = baseUrl + 'po/get_supplier_stock_unit_cost';
			$.post(val_url, {'stock_id' : stock_id, 'branch_id' : branch_id, 'supplier_id' : supplier_id}, function(data){
				// alert(data);
				$('#unit_cost, #total').attr({'value':data}).val(data);
				recompute_supplier_stock_total();
			});
			return false;
		});
		
		$('#unit_cost, #quantity_ordered, #discount1, #discount2, #discount3, #disc_type1, #disc_type2, #disc_type3').blur(function(){
			recompute_supplier_stock_total();
			return false;
		});
		
		function load_purch_order_items(){
			var form_mode = $('#form_mode').val();
			if(form_mode == 'add'){
				var ref = $('#hidden_user').val();
			}else{
				var ref = $('#hidden_po_order_no').val();
			}
			var dtr_url = '<?php echo base_url(); ?>po/load_purch_order_items';
			$.post(dtr_url, {'ref' : ref, 'mode' : form_mode}, function(data){
				$('#line_item_contents').html(data);
				return false;
			});
		}
		
		load_purch_order_items();
		
		function clear_item_adder_form(){
			// $('#stock_id').attr({'value' : ''}).val('');
			$('.supp_stock_drop').attr({'value' : ''}).val('');
			$('#hidden_stock_id').attr({'value' : ''}).val('');
			$('#stock_desc').attr({'value' : ''}).val('');
			$('#quantity_ordered').attr({'value' : ''}).val('');
			$('#uom').attr({'value' : ''}).val('');
			$('#uom_qty').attr({'value' : ''}).val('');
			$('#unit_cost').attr({'value' : ''}).val('');
			$('#hidden_unit_cost').attr({'value' : ''}).val('');
			$('#discount1').attr({'value' : ''}).val('');
			$('#discount2').attr({'value' : ''}).val('');
			$('#discount3').attr({'value' : ''}).val('');
			$('#disc_type1').attr({'value' : 'percent'}).val('percent');
			$('#disc_type2').attr({'value' : 'percent'}).val('percent');
			$('#disc_type3').attr({'value' : 'percent'}).val('percent');
			$('#hidden_disc_unit_cost').attr({'value' : ''}).val('');
			$('#total').attr({'value' : ''}).val('');
			$('#total_amount').attr({'value' : ''}).val('');
		}
		
		$('#add_btn').click(function(){
			var stock_id = $('#stock_id').val();
			// alert('Stock id : '+stock_id);
			if(stock_id != ''){
				var formData = $('#po_entry_form').serialize();
				// alert(formData);
				var post_url = '<?php echo base_url(); ?>po/add_to_purch_orders_temp';
				$.post(post_url, formData, function(data){
					rMsg(data.msg+' [ '+data.desc+' ] ','success');
					clear_item_adder_form();
					load_purch_order_items();
					$('.supp_stock_drop').focus();
					return false;
				}, 'json');
			}else{
				rMsg('Select Item First!','warning');
				$('.supp_stock_drop').focus();
			}
			return false;
		});
		
		//----------GENERATE SUGGESTED STOCKS----------START
		function load_suggested_purch_order_items(){
			var branch_id = $('#branch_id').val();
			var selling_days = $('#supplier_selling_days').val();
			// if(form_mode == 'add'){
				// var ref = $('#hidden_user').val();
			// }else{
				// var ref = $('#hidden_po_order_no').val();
			// }
			var dtr_url = '<?php echo base_url(); ?>po/load_suggested_purch_order_items';
			$.post(dtr_url, {'branch_id' : branch_id, 'selling_days' : selling_days}, function(data){
				// alert(data);
				$('#line_item_contents').html(data);
				return false;
			});
		}
		$('#suggest_po_btn').click(function(){
			// alert('Clicked suggest PO!');
			// var stock_id = $('#stock_id').val();
			// // alert('Stock id : '+stock_id);
			// if(stock_id != ''){
				// var formData = $('#po_entry_form').serialize();
				// // alert(formData);
				// var post_url = '<?php echo base_url(); ?>po/generate_suggested_supplier_stocks';
				// $.post(post_url, formData, function(data){
					// rMsg(data.msg+' [ '+data.desc+' ] ','success');
					// clear_item_adder_form();
					load_suggested_purch_order_items();
					// $('.supp_stock_drop').focus();
					// return false;
				// }, 'json');
			// }else{
				// rMsg('Select Item First!','warning');
				// $('.supp_stock_drop').focus();
			// }
			return false;
		});
		//----------GENERATE SUGGESTED STOCKS----------END
		
		$('#save_po_btn').click(function(){
			var post_url = baseUrl + 'po/add_to_main_po_tbl';
			var formData = $('#po_entry_form').serialize();
			// alert(formData);
			$.post(post_url, formData, function(data){
				// alert(data);
				// console.log(data);
				rMsg(data.msg,data.status);
				setTimeout(function(){
					window.location.reload();
				},1500);
			}, 'json');
			return false;
		});
		$('#back-btn').click(function(){
			//alert('qwerty');
			var post_url = baseUrl + 'po/remove_puchase_details_line_item';
			$.post(post_url, function(data){
	
				if(data=='success'){
					setTimeout(function(){
						window.location = baseUrl+'po/dashboard';
					},1500);
				}
			});
			return false;
		});
		//----------Discount Computation----------END
	<?php elseif($use_js == 'editPoEntryJS'): ?>		
		function load_uom_hidden_qty(uom){
			var converter_url = baseUrl + 'po/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
				if(data != '')
					$('#uom_qty').attr('value', data).val(data);
				else
					$('#uom_qty').attr('value', 0).val(0);
			});
		}
		
		var uom = $('#uom').val();
		load_uom_hidden_qty(uom);
		
		$('#uom').change(function(){
			var uom = $(this).val();
			load_uom_hidden_qty(uom);
			return false;
		});
		
		function clear_item_adder(){
			$('#stock_id').attr('value', '').val('');
			$('#hidden_stock_id').attr('value', '').val('');
			// $('#quantity_ordered').attr('value', '').val('');
			$('#uom').attr('value', '').val('');
			$('#uom_qty').attr('value', '').val('');
			$('#unit_cost').attr('value', '').val('');
			$('#discount1').attr('value', '').val('');
			// $('#disc_type1').attr('value', '').val('');
			$('#discount2').attr('value', '').val('');
			// $('#disc_type2').attr('value', '').val('');
			$('#discount3').attr('value', '').val('');
			// $('#disc_type3').attr('value', '').val('');
		}
		
		$('#stock_id').change(function(){
			var branch_id = $('#branch_id').val();
			var stock_id = $(this).val();
			// alert(stock_id+' '+branch_id);
			if(stock_id != ''){
				if(branch_id != ''){
					var val_url = baseUrl + 'po/get_supplier_stock_details';
					$.post(val_url, {'stock_id' : stock_id, 'branch_id' : branch_id}, function(data){
						var vals = data.split('||');

						$('#hidden_stock_id').attr('value', vals[0]).val(vals[0]);
						// $('#quantity_ordered').attr('value', data).val(data);
						$('#stock_desc').attr('stock_desc', vals[11]).val(vals[11]);
						
						$('#uom').attr('value', vals[2]).val(vals[2]);
						$('#uom_qty').attr('value', vals[4]).val(vals[4]);
						
						$('#unit_cost').attr('value', vals[3]).val(vals[3]);
						$('#hidden_unit_cost').attr('value', vals[3]).val(vals[3]);
						
						$('#discount1').attr('value', vals[5]).val(vals[5]);
						// $('#disc_type1').attr('value', vals[0]).val(vals[0]);
						$('#discount2').attr('value', vals[6]).val(vals[6]);
						// $('#disc_type2').attr('value', vals[0]).val(vals[0]);
						$('#discount3').attr('value', vals[7]).val(vals[7]);
						// $('#disc_type3').attr('value', vals[0]).val(vals[0]);
						
						if(vals[5] > 0)
							$('#disc_type1').attr('value', 'percent').val('percent');
						else if(vals[8] > 0)
							$('#disc_type1').attr('value', 'amount').val('amount');
						
						if(vals[6] > 0)
							$('#disc_type2').attr('value', 'percent').val('percent');
						else if(vals[9] > 0)
							$('#disc_type2').attr('value', 'amount').val('amount');	
						
						if(vals[7] > 0)
							$('#disc_type3').attr('value', 'percent').val('percent');
						else if(vals[10] > 0)
							$('#disc_type3').attr('value', 'amount').val('amount');	
				
					});
				}else{
					rMsg('Select a branch first!','warning');
					$('.branch_dropdown ').focus();
				}
			}else{
				clear_item_adder();
				$('#stock_id').focus();
			}
			return false;
		});
		
		//----------Discount Computation----------START
		function recompute_supplier_stock_total(){
			var quantity_ordered = $('#quantity_ordered').val();
			var unit_cost = $('#unit_cost').val();
			
			if(unit_cost == '' || unit_cost == 0){
				rMsg('Unit Cost should not be empty!','warning');
			}else{
				if(quantity_ordered == '' || quantity_ordered == 0){
					rMsg('Quantity Ordered should not be empty!','warning');
					$('#quantity_ordered').focus();
				}else{
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
					
					var disc_unit_cost = (((((unit_cost*(1-(discount1_perc/100))) - discount1_amt)
							*(1-(discount2_perc/100))) - discount2_amt)
							*(1-(discount3_perc/100))) - discount3_amt;
					
					var total_unit_cost = disc_unit_cost*quantity_ordered;
					$('#hidden_disc_unit_cost').attr('value', disc_unit_cost).val(disc_unit_cost);
					$('#total').attr({'value':total_unit_cost}).val(total_unit_cost);	
				}
			}
		}
		
		$('.branch_dropdown').change(function(){
			var branch_id = $('#branch_id').val();
			var val_url = baseUrl + 'po/get_branch_address';
			$.post(val_url, {'branch_id' : branch_id}, function(data){
				// alert(data);
				$('#delivery_address').attr({'value':data}).val(data);
			});
			return false;
		});
		
		$('#branch_id, #supplier_id, #stock_id').change(function(){
			var stock_id = $('#stock_id').val();
			var branch_id = $('#branch_id').val();
			var supplier_id = $('#supplier_id').val();
			
			var val_url = baseUrl + 'po/get_supplier_stock_unit_cost';
			$.post(val_url, {'stock_id' : stock_id, 'branch_id' : branch_id, 'supplier_id' : supplier_id}, function(data){
				// alert(data);
				$('#unit_cost, #total').attr({'value':data}).val(data);
				recompute_supplier_stock_total();
			});
			return false;
		});
		
		$('#unit_cost, #quantity_ordered, #discount1, #discount2, #discount3, #disc_type1, #disc_type2, #disc_type3').blur(function(){
			recompute_supplier_stock_total();
			return false;
		});
		
		function load_edit_purch_order_items(){
			var form_mode = $('#form_mode').val();
			var ref = $('#hidden_po_order_no').val();
			var dtr_url = '<?php echo base_url(); ?>po/load_edit_purch_order_items';
			$.post(dtr_url, {'ref' : ref}, function(data){
				$('#line_item_contents').html(data);
				return false;
			});
		}
		
		load_edit_purch_order_items();
		
		function clear_item_adder_form(){
			// $('#stock_id').attr({'value' : ''}).val('');
			$('.supp_stock_drop').attr({'value' : ''}).val('');
			$('#hidden_stock_id').attr({'value' : ''}).val('');
			$('#stock_desc').attr({'value' : ''}).val('');
			$('#quantity_ordered').attr({'value' : ''}).val('');
			$('#uom').attr({'value' : ''}).val('');
			$('#uom_qty').attr({'value' : ''}).val('');
			$('#unit_cost').attr({'value' : ''}).val('');
			$('#hidden_unit_cost').attr({'value' : ''}).val('');
			$('#discount1').attr({'value' : ''}).val('');
			$('#discount2').attr({'value' : ''}).val('');
			$('#discount3').attr({'value' : ''}).val('');
			$('#disc_type1').attr({'value' : 'percent'}).val('percent');
			$('#disc_type2').attr({'value' : 'percent'}).val('percent');
			$('#disc_type3').attr({'value' : 'percent'}).val('percent');
			$('#hidden_disc_unit_cost').attr({'value' : ''}).val('');
			$('#total').attr({'value' : ''}).val('');
			$('#total_amount').attr({'value' : ''}).val('');
		}
		
		$('#edit_po_add_btn').click(function(){
			var formData = $('#po_entry_form').serialize();
			var hidden_order_no = $('#hidden_po_order_no').val();
			// alert(hidden_order_no);
			var post_url = '<?php echo base_url(); ?>po/add_to_purch_order_details';
			$.post(post_url, formData, function(data){
				rMsg(data.msg+' [ '+data.desc+' ] ','success');
				clear_item_adder_form();
				load_edit_purch_order_items();
				return false;
			}, 'json');
			
			return false;
		});
		var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save_edit_po_btn').click(function(){
			var post_url = baseUrl + 'po/update_main_po_tbl';
			var formData = $('#po_entry_form').serialize();
			// alert(formData);
			$.post(post_url, formData, function(data){
				// alert(data);
				//console.log(data);
				var input_name = '';
				var passed_form = '';
				var type_desc = 'Modify Purchase Orders';
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
					var formData = 'pk_id='+data.id+'&'+'order_no='+data.id+'|=|'+passed_form;
					//alert(formData);
					$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
				
					});
				}
				rMsg(data.msg,data.status);
				setTimeout(function(){
					window.location.reload();
				},1500);
			}, 'json');
			return false;
		});
		//----------Discount Computation----------END
	<?php elseif($use_js == 'reloadPoItemsJS'): ?>
		$('.del_this_item, .upd_del_this_item').tooltip({
			'show': true,
				'placement': 'left',
				// 'title': "Please remember to..."
		});
		
		function load_purch_order_items(){
			var form_mode = $('#form_mode').val();
			if(form_mode == 'add'){
				var ref = $('#hidden_user').val();
			}else{
				var ref = $('#hidden_po_order_no').val();
			}
			// alert('2) '+form_mode+'---'+ref);
			var dtr_url = '<?php echo base_url(); ?>po/load_purch_order_items';
			$.post(dtr_url, {'ref' : ref, 'mode' : form_mode}, function(data){
				// alert(data);
				$('#line_item_contents').html(data);
				return false;
			});
		}
		
		$('.del_this_item').click(function(){
			var line_id = $(this).attr('ref');
			var post_url = baseUrl + 'po/remove_po_details_line_item';
			$.post(post_url, {'line_id' : line_id}, function(data){
				rMsg('Line Item Removed!','warning');
				setTimeout(function(){
					load_purch_order_items();
				},1500);
			});
			return false;
		});
		
	<?php elseif($use_js == 'reloadEditPoItemsJS'): ?>
		$('.del_this_item, .upd_del_this_item').tooltip({
			'show': true,
				'placement': 'left',
				// 'title': "Please remember to..."
		});
		
		function load_edit_purch_order_items(){
			var form_mode = $('#form_mode').val();
			var ref = $('#hidden_po_order_no').val();
			var dtr_url = '<?php echo base_url(); ?>po/load_edit_purch_order_items';
			$.post(dtr_url, {'ref' : ref}, function(data){
				// alert(data);
				$('#line_item_contents').html(data);
				return false;
			});
		}
		
		// $('.del_this_item').click(function(){
			// var line_id = $(this).attr('ref');
			// var post_url = baseUrl + 'po/remove_from_main_po_details_line_item';
			// $.post(post_url, {'line_id' : line_id}, function(data){
				// rMsg('Line Item Removed!','warning');
				// setTimeout(function(){
					// load_edit_purch_order_items();
				// },1500);
			// });
			// return false;
		// });
		
		$('.del_this_item').click(function(event){
			event.preventDefault();
			var line_id = $(this).attr('ref');
			var line_desc = $(this).attr('ref_desc');
			
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_WARNING,
				title: '<h4>P.O. Line Item Removal</h4>',
				message: "<h4><span style='color: orange;'>Warning:</span> Item will be <span style='color: red;'>PERMANENTLY DELETED FROM THIS P.O.</span> once you hit the <span style='color: green;'>YES</span> button.</h4></br><h4>Are you sure you want to remove this line item : <u>" + line_desc + "</u> ?</h4>",
				buttons: [
					{
						icon: 'fa fa-check',
						label: ' Yes',
						cssClass: 'btn btn-success',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
							$.post(baseUrl + 'po/remove_from_main_po_details_line_item', {'line_id' : line_id}, function(data){
								rMsg('Line Item Removed!','warning');
								setTimeout(function(){
									load_edit_purch_order_items();
									thisDialog.close();
								},1500);
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
		<?php elseif($use_js == 'genPOEntryJS'): ?>		
			$('#file-spinner-add').hide();	
		function load_uom_hidden_qty(uom){
			var converter_url = baseUrl + 'po/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
				if(data != '')
					$('#uom_qty').attr('value', data).val(data);
				else
					$('#uom_qty').attr('value', 0).val(0);
			});
		}
		
		var uom = $('#uom').val();
		load_uom_hidden_qty(uom);
		
		$('#uom').change(function(){
			var uom = $(this).val();
			load_uom_hidden_qty(uom);
			return false;
		});
		
		function clear_item_adder(){
			$('#stock_id').attr('value', '').val('');
			$('#hidden_stock_id').attr('value', '').val('');
			// $('#quantity_ordered').attr('value', '').val('');
			$('#uom').attr('value', '').val('');
			$('#uom_qty').attr('value', '').val('');
			$('#unit_cost').attr('value', '').val('');
			$('#discount1').attr('value', '').val('');
			// $('#disc_type1').attr('value', '').val('');
			$('#discount2').attr('value', '').val('');
			// $('#disc_type2').attr('value', '').val('');
			$('#discount3').attr('value', '').val('');
			// $('#disc_type3').attr('value', '').val('');
		}
		
		$('#stock_id').change(function(){
			var branch_id = $('#branch_id').val();
			var stock_id = $(this).val();
			// alert(stock_id+' '+branch_id);
			if(stock_id != ''){
				if(branch_id != ''){
					var val_url = baseUrl + 'po/get_supplier_stock_details';
					$.post(val_url, {'stock_id' : stock_id, 'branch_id' : branch_id}, function(data){
						var vals = data.split('||');

						$('#hidden_stock_id').attr('value', vals[0]).val(vals[0]);
						// $('#quantity_ordered').attr('value', data).val(data);
						$('#stock_desc').attr('stock_desc', vals[11]).val(vals[11]);
						
						$('#uom').attr('value', vals[2]).val(vals[2]);
						$('#uom_qty').attr('value', vals[4]).val(vals[4]);
						
						$('#unit_cost').attr('value', vals[3]).val(vals[3]);
						$('#hidden_unit_cost').attr('value', vals[3]).val(vals[3]);
						
						$('#discount1').attr('value', vals[5]).val(vals[5]);
						// $('#disc_type1').attr('value', vals[0]).val(vals[0]);
						$('#discount2').attr('value', vals[6]).val(vals[6]);
						// $('#disc_type2').attr('value', vals[0]).val(vals[0]);
						$('#discount3').attr('value', vals[7]).val(vals[7]);
						// $('#disc_type3').attr('value', vals[0]).val(vals[0]);
						
						if(vals[5] > 0)
							$('#disc_type1').attr('value', 'percent').val('percent');
						else if(vals[8] > 0)
							$('#disc_type1').attr('value', 'amount').val('amount');
						
						if(vals[6] > 0)
							$('#disc_type2').attr('value', 'percent').val('percent');
						else if(vals[9] > 0)
							$('#disc_type2').attr('value', 'amount').val('amount');	
						
						if(vals[7] > 0)
							$('#disc_type3').attr('value', 'percent').val('percent');
						else if(vals[10] > 0)
							$('#disc_type3').attr('value', 'amount').val('amount');	
				
					});
				}else{
					rMsg('Select a branch first!','warning');
					$('.branch_dropdown ').focus();
				}
			}else{
				clear_item_adder();
				$('.supp_stock_drop').focus();
			}
			return false;
		});
		
		//----------Discount Computation----------START
		function recompute_supplier_stock_total(){
			var quantity_ordered = $('#quantity_ordered').val();
			var unit_cost = $('#unit_cost').val();
			
			if(unit_cost == '' || unit_cost == 0){
				rMsg('Unit Cost should not be empty!','warning');
			}else{
				if(quantity_ordered == '' || quantity_ordered == 0){
					rMsg('Quantity Ordered should not be empty!','warning');
					$('#quantity_ordered').focus();
				}else{
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
					
					var disc_unit_cost = (((((unit_cost*(1-(discount1_perc/100))) - discount1_amt)
							*(1-(discount2_perc/100))) - discount2_amt)
							*(1-(discount3_perc/100))) - discount3_amt;
					
					var total_unit_cost = disc_unit_cost*quantity_ordered;
					$('#hidden_disc_unit_cost').attr('value', disc_unit_cost).val(disc_unit_cost);
					$('#total').attr({'value':total_unit_cost}).val(total_unit_cost);	
				}
			}
		}
		
		$('.branch_dropdown').change(function(){
			var branch_id = $('#branch_id').val();
			var val_url = baseUrl + 'po/get_branch_address';
			$.post(val_url, {'branch_id' : branch_id}, function(data){
				// alert(data);
				$('#delivery_address').attr({'value':data}).val(data);
			});
			return false;
		});
		
		$('#branch_id, #supplier_id, #stock_id').change(function(){
			var stock_id = $('#stock_id').val();
			var branch_id = $('#branch_id').val();
			var supplier_id = $('#supplier_id').val();
			
			var val_url = baseUrl + 'po/get_supplier_stock_unit_cost';
			$.post(val_url, {'stock_id' : stock_id, 'branch_id' : branch_id, 'supplier_id' : supplier_id}, function(data){
				// alert(data);
				$('#unit_cost, #total').attr({'value':data}).val(data);
				recompute_supplier_stock_total();
			});
			return false;
		});
		
		$('#unit_cost, #quantity_ordered, #discount1, #discount2, #discount3, #disc_type1, #disc_type2, #disc_type3').blur(function(){
			recompute_supplier_stock_total();
			return false;
		});
		
		function load_purch_order_items(){
			var form_mode = $('#form_mode').val();
			if(form_mode == 'add'){
				var ref = $('#hidden_user').val();
			}else{
				var ref = $('#hidden_po_order_no').val();
			}
			var dtr_url = '<?php echo base_url(); ?>po/load_purch_order_items';
			$.post(dtr_url, {'ref' : ref, 'mode' : form_mode}, function(data){
				$('#line_item_contents').html(data);
				return false;
			});
		}
		
		load_purch_order_items();
		
		function clear_item_adder_form(){
			// $('#stock_id').attr({'value' : ''}).val('');
			$('.supp_stock_drop').attr({'value' : ''}).val('');
			$('#hidden_stock_id').attr({'value' : ''}).val('');
			$('#stock_desc').attr({'value' : ''}).val('');
			$('#quantity_ordered').attr({'value' : ''}).val('');
			$('#uom').attr({'value' : ''}).val('');
			$('#uom_qty').attr({'value' : ''}).val('');
			$('#unit_cost').attr({'value' : ''}).val('');
			$('#hidden_unit_cost').attr({'value' : ''}).val('');
			$('#discount1').attr({'value' : ''}).val('');
			$('#discount2').attr({'value' : ''}).val('');
			$('#discount3').attr({'value' : ''}).val('');
			$('#disc_type1').attr({'value' : 'percent'}).val('percent');
			$('#disc_type2').attr({'value' : 'percent'}).val('percent');
			$('#disc_type3').attr({'value' : 'percent'}).val('percent');
			$('#hidden_disc_unit_cost').attr({'value' : ''}).val('');
			$('#total').attr({'value' : ''}).val('');
			$('#total_amount').attr({'value' : ''}).val('');
		}
		
		$('#add_btn').click(function(){
			var stock_id = $('#stock_id').val();
			// alert('Stock id : '+stock_id);
			if(stock_id != ''){
				var formData = $('#po_entry_form').serialize();
				// alert(formData);
				var post_url = '<?php echo base_url(); ?>po/add_to_purch_orders_temp';
				$.post(post_url, formData, function(data){
					rMsg(data.msg+' [ '+data.desc+' ] ','success');
					clear_item_adder_form();
					load_purch_order_items();
					$('.supp_stock_drop').focus();
					return false;
				}, 'json');
			}else{
				rMsg('Select Item First!','warning');
				$('.supp_stock_drop').focus();
			}
			return false;
		});
		
		$('#save_po_btn').click(function(){
			$('#file-spinner-add').show();	
			var post_url = baseUrl + 'po/add_to_gen_main_po_tbl';
			var formData = $('#po_entry_form').serialize();
			// alert(formData);
			$.post(post_url, formData, function(data){
	
				 //alert(data);
				// console.log(data);
				if(data=='success'){
					$('#file-spinner-add').hide();	
					rMsg('Email sent to Supplier', 'success');
					setTimeout(function(){
						window.location = baseUrl+'po/dashboard';
					},1500);
				}
			});
			return false;
		});
		$('#back-btn').click(function(){
			//alert('qwerty');
			var post_url = baseUrl + 'po/remove_puchase_details_line_item';
			$.post(post_url, function(data){
	
				if(data=='success'){
					setTimeout(function(){
						window.location = baseUrl+'po/dashboard';
					},1500);
				}
			});
			return false;
		});
	<?php endif; ?>
});
</script>