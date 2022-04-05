<script>
$(document).ready(function(){
	<?php if($use_js == 'receivingEntryJS'): ?>
		$("[data-toggle='offcanvas']").click(); //hide main menu sa side
		
		//INITIAL LOAD
		$('#po_reference').focus();
		//-----HIDE POST BUTTONS ONLOAD
		$('.main_btns').hide();
		
		// $('#po_reference').blur(function(){
		$('#po_reference').keyup(function(){
			// alert($(this).val());
			var po_reference = $(this).val();
			if(po_reference == ''){
				rMsg('Please provide a P.O. Number','error');
				$('#supplier_name').attr({'value' : ''}).val('');
				$('#delivery_date').attr({'value' : ''}).val('');
				$('#stock_location').attr({'value' : ''}).val('');
				
				$('.main_btns').hide();
				$('#po_reference').focus();
			}else{
				var checker_url = baseUrl + 'receiving/get_purch_order_info';
				$.post(checker_url, {'po_reference' : po_reference}, function(data){
					// alert(data);
					if(data == 'warning'){
						rMsg('Invalid P.O. number', 'warning');
						$('#po_reference').focus();
						$('#order_no').attr({'value' : ''}).val('');
						$('#supplier_name').attr({'value' : ''}).val('');
						$('#delivery_date').attr({'value' : ''}).val('');
						$('#stock_location').attr({'value' : ''}).val('');
						
						$('#invoice_no').attr({'value' : ''}).val('');
						$('#invoice_amt').attr({'value' : ''}).val('');
						$('#receiving_notes').attr({'value' : ''}).val('');
						
						$('.main_btns').hide();
					}else{
						var res = data.split("||");
						$('#order_no').attr({'value' : res[0]}).val(res[0]);
						$('#supplier_name').attr({'value' : res[2]}).val(res[2]);
						$('#delivery_date').attr({'value' : res[3]}).val(res[3]);
						$('#stock_location').attr({'value' : res[4]}).val(res[4]);
						if(res[5] != ''){
							$('#invoice_no').attr({'value' : res[5]}).val(res[5]);
						}else{
							$('#invoice_no').attr({'value' : ''}).val('');
						}
						if(res[6] != ''){
							$('#invoice_amt').attr({'value' : res[6]}).val(res[6]);
						}else{
							$('#invoice_amt').attr({'value' : ''}).val('');
						}
						if(res[7] != ''){
							$('#receiving_notes').attr({'value' : res[7]}).val(res[7]);
						}else{
							$('#receiving_notes').attr({'value' : ''}).val('');
						}
						
						//-----SHOW POST BUTTONS IF PO REFERENCE IS VALID
						$('.main_btns').show();
						load_receiving_items();
					}
				});
			}
			return false;
		});
		
		function reloadBarcodeUOM(){
			var barcode = $('#barcode').val();
			loader_url = baseUrl + 'receiving/get_barcode_uom';
			$.post(loader_url, {'barcode' : barcode}, function(data){
				$('#uom').attr({'value' : data}).val(data);
			});
		}
		$('#barcode').keyup(function(){
			reloadBarcodeUOM();
			return false;
		});
		
		$('#add_btn').tooltip({
			'show': true,
				'placement': 'left',
				// 'title': "Please remember to..."
		});
		
		$('#add_btn').click(function(){
			// alert('Add button');
			var barcode = $('#barcode').val();
			var qty = $('#qty').val();
			var uom = $('#uom').val();
			
			if(barcode == ''){
				rMsg('BARCODE should not be empty!', 'error');
				$('#barcode').focus();
			}
			
			// if(barcode != '' && qty != '' || qty > 0){
			if(barcode != ''){
				var order_no = $('#order_no').val();
				var po_reference = $('#po_reference').val();
				var checker_url = baseUrl + 'receiving/validate_receiving_item';
				$.post(checker_url, {'order_no' : order_no, 'po_reference' : po_reference, 'barcode' : barcode, 'qty' : qty, 'uom' : uom}, function(data){
					// alert(data);
					if(data == 'warning'){
						rMsg('Item Not Found in P.O.', 'warning');
					}else{
						var qty_entered = $('#qty').val();
						var qty_ordered = data;
						// alert('Qty Ordered : '+qty_ordered);
						// alert('Entered : '+parseFloat(qty_entered)+'<~~~>'+parseFloat(qty_ordered));
						if(parseFloat(qty_entered) > parseFloat(qty_ordered)){
							rMsg('Entered Quantity is greater than the Ordered Quantity!', 'error');
							$('#qty').focus();
						}else{
							// rMsg('Wala lang!', 'success');
							var formData = $('#receiving_entry_form').serialize();
							// alert(formData);
							$.post(baseUrl+'receiving/save_to_receiving_temp_db', formData, function(data2){
								// alert(data2);
								if(data2.status == 'success'){
									rMsg('Item Received!', 'success');
									$('#hidden_receiving_id').attr({'value' : data2.id}).val(data2.id);
									clear_line_item_adder();
									load_receiving_items();
								}else if(data2.status == 'error'){
									rMsg('Entered Quantity is GREATER THAN the Ordered Quantity!', 'error');
									$('#hidden_receiving_id').attr({'value' : data2.id}).val(data2.id);
									clear_line_item_adder();
									load_receiving_items();
								}
								
							// }); //uncomment this for testing purposes only
							}, 'json');
						}
					}
				});
			}
			return false;
		});
		
		function load_receiving_items(){
			// var ref = "";
			var order_no = $('#order_no').val();
			var po_reference = $('#po_reference').val();
			
			var loader_url = baseUrl + 'receiving/load_receiving_items';
			$.post(loader_url, {'order_no' : order_no, 'po_reference' : po_reference}, function(data){
				$('#line_item_contents').html(data);
				return false;
			});
		}
		
		function clear_line_item_adder(){
			$('#barcode').attr({'value' : ''}).val('');
			$('#qty').attr({'value' : ''}).val('');
			$('#uom').attr({'value' : ''}).val('');
			$('#barcode').focus();
		}
		
		$('.post_receiving_btn').click(function(event){
			// alert('You have clicked the POST RECEIVING button.');
			event.preventDefault();
			
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_DANGER,
				title: '<h4>Post Receiving</h4>',
				// message: "<img src='../../../wow intensifies.gif' alt='Smiley face' height='150' width='150' style='align: center;'></br><h4>Are you sure you want to POST this receiving transaction?</h4>",
				// message: "<img src='../../../genius.jpg' alt='Smiley face' height='150' width='150' style='margin-left: auto; margin-right: auto;'></br><h4>Are you sure you want to POST this receiving transaction?</h4>",
				// message: "<h4><span style='color: orange;'>Warning:</span> This Receiving Transaction will be <span style='color: red;'>POSTED</span> TO THE <span style='color: red;'>BRANCH</span> AND <span style='color: red;'>MAIN SERVERS</span> once you hit the <img src='../../yes_btn.jpg'> button. </br></br> Are you sure you want to <span style='color: red;'>POST</span> this Receiving Transaction?</h4>",
				// message: "<h4><span style='color: orange;'>Warning:</span> This Receiving Transaction will be <span style='color: red;'>POSTED</span> TO THE <span style='color: red;'>BRANCH</span> AND <span style='color: red;'>MAIN SERVERS</span> once you hit the <span style='color: green;'>YES</span> button. </br></br> Are you sure you want to <span style='color: red;'>POST</span> this Receiving Transaction?</h4>",
				message: "<h4>Are you sure you want to <span style='color: red;'>POST</span> this Receiving Transaction?</h4>",
				buttons: [
					{
						icon: 'fa fa-remove',
						label: ' NO',
						cssClass: 'btn btn-danger',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
							var formData = $('#receiving_entry_form').serialize();
							$.post(baseUrl + 'receiving/save_to_receiving_temp_db', formData, function(data){
								// alert(data);
								if(data.status == 'success'){
									setTimeout(function(){
										thisDialog.close();
									},1500);
								}else if(data.status == 'error'){
									rMsg('Entered Quantity is GREATER THAN the Ordered Quantity!', 'error');
									$('#hidden_receiving_id').attr({'value' : data.id}).val(data.id);
									clear_line_item_adder();
									load_receiving_items();
								}
								
							// }); //uncomment this for testing purposes only
							}, 'json');
						}
					},
					{
						icon: 'fa fa-check',
						label: ' YES',
						cssClass: 'btn btn-success',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
							var formData = $('#receiving_entry_form').serialize();
							$.post(baseUrl + 'receiving/post_receiving_to_db', formData, function(data){
								 // alert(data);
								if(data == 'success'){
									rMsg('Successfully POSTED Transaction', 'success');
									
									setTimeout(function(){
										window.location = baseUrl + 'receiving/saved_receiving';
									},1500);
								}
								
								// if(data.status == 'success'){
									// setTimeout(function(){
										// thisDialog.close();
									// },1500);
								// }else if(data.status == 'error'){
									// rMsg('Entered Quantity is GREATER THAN the Ordered Quantity!', 'error');
									// $('#hidden_receiving_id').attr({'value' : data.id}).val(data.id);
									// clear_line_item_adder();
									// load_receiving_items();
								// }
								
							}); //uncomment this for testing purposes only
							// }, 'json');
						}
					},
					{
						icon: 'fa fa-close',
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
		
	<?php elseif($use_js == 'reloadReceivingItemsJS'): ?>
		$('.del_btn').tooltip({
			'show': true,
				'placement': 'left',
				// 'title': "Please remember to..."
		});
		
		$('.del_btn').click(function(event){
			event.preventDefault();
			var line_id = $(this).attr('ref');
			var line_desc = $(this).attr('ref_desc');
			
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_WARNING,
				title: '<h4>Receiving Line Item Removal</h4>',
				message: "<h4><span style='color: orange;'>Warning:</span> Item will be <span style='color: red;'>PERMANENTLY DELETED FROM THE RECEIVING LINE</span> once you hit the <span style='color: green;'>YES</span> button.</h4></br><h4>Are you sure you want to remove this line item : <u>" + line_desc + "</u> ?</h4>",
				buttons: [
					{
						icon: 'fa fa-check',
						label: ' Yes',
						cssClass: 'btn btn-success',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
							$.post(baseUrl + 'receiving/remove_from_receiving_details_temp', {'line_id' : line_id}, function(data){
								rMsg('Line Item Removed!','warning');
								setTimeout(function(){
									load_receiving_items();
									thisDialog.close();
									$('#barcode').focus();
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
		
		function load_receiving_items(){
			// var ref = "";
			var order_no = $('#order_no').val();
			var po_reference = $('#po_reference').val();
			
			var loader_url = baseUrl + 'receiving/load_receiving_items';
			$.post(loader_url, {'order_no' : order_no, 'po_reference' : po_reference}, function(data){
				$('#line_item_contents').html(data);
				return false;
			});
		}
		
	<?php elseif($use_js == 'savedReceivingJs'): ?>
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
		//alert(link);
		loader(link);
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			$(tabPane).rLoad({url:baseUrl+loadUrl});
		}
		
		$(tab).addClass('active');
		$(link).parent().addClass('active');
		
	<?php elseif($use_js == 'postedReceivingJs'): ?>
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
		//alert(link);
		loader(link);
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			$(tabPane).rLoad({url:baseUrl+loadUrl});
		}
		
		$(tab).addClass('active');
		$(link).parent().addClass('active');

	<?php elseif($use_js == 'savedReceivingListJs'): ?>
		$('.edit_btn').tooltip({
			'show': true,
				'placement': 'left',
				// 'title': "Please remember to..."
		});
	<?php elseif($use_js == 'postedReceivingListJs'): ?>
		$('.view_btn').tooltip({
			'show': true,
				'placement': 'left',
				// 'title': "Please remember to..."
		});
		
		$('.view_btn').click(function(){
				var rec_header_id = $(this).attr('ref');
				var rec_branch_id = $(this).attr('branch_id');

				bootbox.dialog({
					message: baseUrl+'receiving/posted_receiving_popup/'+rec_header_id+'/'+rec_branch_id,
					className: "bootbox-wide",
					title: "View Posted Receiving Details",
					onEscape: true,
					buttons: {
						cancel: {
							label : "Close",
							className: "btn-info",
							callback: function(){

							}
						}
					}
				});
				return false;
			});
	<?php elseif($use_js == 'editReceivingEntryJS'): ?>
		$("[data-toggle='offcanvas']").click(); //hide main menu sa side
		
		//INITIAL LOAD
		$('#barcode').focus();
		//-----SHOW POST BUTTONS ONLOAD
		$('.main_btns').show();
		load_edit_receiving_items();
		
		//----------PASTE MO ULI DITO----------START
		//----------PASTE MO ULI DITO----------END
		function reloadBarcodeUOM(){
			var barcode = $('#barcode').val();
			loader_url = baseUrl + 'receiving/get_barcode_uom';
			$.post(loader_url, {'barcode' : barcode}, function(data){
				$('#uom').attr({'value' : data}).val(data);
			});
		}
		$('#barcode').keyup(function(){
			reloadBarcodeUOM();
			return false;
		});
		
		$('#add_btn').tooltip({
			'show': true,
				'placement': 'left',
				// 'title': "Please remember to..."
		});
		
		$('#add_btn').click(function(){
			// alert('Add button');
			var barcode = $('#barcode').val();
			var qty = $('#qty').val();
			var uom = $('#uom').val();
			
			if(barcode == ''){
				rMsg('BARCODE should not be empty!', 'error');
				$('#barcode').focus();
			}

			if(barcode != ''){
				var order_no = $('#order_no').val();
				var po_reference = $('#po_reference').val();
				var checker_url = baseUrl + 'receiving/validate_receiving_item';
				$.post(checker_url, {'order_no' : order_no, 'po_reference' : po_reference, 'barcode' : barcode, 'qty' : qty, 'uom' : uom}, function(data){
					// alert(data);
					if(data == 'warning'){
						rMsg('Item Not Found in P.O.', 'warning');
					}else{
						var qty_entered = $('#qty').val();
						var qty_ordered = data;
						// alert('Qty Ordered : '+qty_ordered);
						if(parseFloat(qty_entered) > parseFloat(qty_ordered)){
							rMsg('Entered Quantity is greater than the Ordered Quantity!', 'error');
							$('#qty').focus();
						}else{
							// rMsg('Wala lang!', 'success');
							var formData = $('#receiving_entry_form').serialize();
							// alert(formData);
							$.post(baseUrl+'receiving/save_to_receiving_temp_db', formData, function(data2){
								// alert(data2);
								if(data2.status == 'success'){
									rMsg('Item Scanned!', 'success');
									$('#hidden_receiving_id').attr({'value' : data2.id}).val(data2.id);
									clear_line_item_adder();
									load_edit_receiving_items();
								}else if(data2.status == 'error'){
									rMsg('Entered Quantity is GREATER THAN the Ordered Quantity!', 'error');
									$('#hidden_receiving_id').attr({'value' : data2.id}).val(data2.id);
									clear_line_item_adder();
									load_edit_receiving_items();
								}
								
							// }); //uncomment this for testing purposes only
							}, 'json');
						}
					}
				});
			}
			return false;
		});
		
		function load_edit_receiving_items(){
			// var ref = "";
			var order_no = $('#order_no').val();
			var po_reference = $('#po_reference').val();
			
			var loader_url = baseUrl + 'receiving/load_edit_receiving_items';
			$.post(loader_url, {'order_no' : order_no, 'po_reference' : po_reference}, function(data){
				$('#line_item_contents').html(data);
				return false;
			});
		}
		
		function clear_line_item_adder(){
			$('#barcode').attr({'value' : ''}).val('');
			$('#qty').attr({'value' : ''}).val('');
			$('#uom').attr({'value' : ''}).val('');
			$('#barcode').focus();
		}
		
		$('.post_receiving_btn').click(function(event){
			// alert('You have clicked the POST RECEIVING button.');
			event.preventDefault();
			
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_DANGER,
				title: '<h4>Post Receiving</h4>',
				// message: "<img src='../../../wow intensifies.gif' alt='Smiley face' height='150' width='150' style='align: center;'></br><h4>Are you sure you want to POST this receiving transaction?</h4>",
				// message: "<img src='../../../genius.jpg' alt='Smiley face' height='150' width='150' style='margin-left: auto; margin-right: auto;'></br><h4>Are you sure you want to POST this receiving transaction?</h4>",
				// message: "<h4><span style='color: orange;'>Warning:</span> This Receiving Transaction will be <span style='color: red;'>POSTED</span> TO THE <span style='color: red;'>BRANCH</span> AND <span style='color: red;'>MAIN SERVERS</span> once you hit the <img src='../../yes_btn.jpg'> button. </br></br> Are you sure you want to <span style='color: red;'>POST</span> this Receiving Transaction?</h4>",
				// message: "<h4><span style='color: orange;'>Warning:</span> This Receiving Transaction will be <span style='color: red;'>POSTED</span> TO THE <span style='color: red;'>BRANCH</span> AND <span style='color: red;'>MAIN SERVERS</span> once you hit the <span style='color: green;'>YES</span> button. </br></br> Are you sure you want to <span style='color: red;'>POST</span> this Receiving Transaction?</h4>",
				message: "<h4>Are you sure you want to <span style='color: red;'>POST</span> this Receiving Transaction?</h4>",
				buttons: [
					{
						icon: 'fa fa-remove',
						label: ' NO',
						cssClass: 'btn btn-danger',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
							var formData = $('#receiving_entry_form').serialize();
							$.post(baseUrl + 'receiving/save_to_receiving_temp_db', formData, function(data){
								// alert(data);
								if(data.status == 'success'){
									setTimeout(function(){
										thisDialog.close();
									},1500);
								}else if(data.status == 'error'){
									rMsg('Entered Quantity is GREATER THAN the Ordered Quantity!', 'error');
									$('#hidden_receiving_id').attr({'value' : data.id}).val(data.id);
									clear_line_item_adder();
									load_edit_receiving_items();
								}
								
							// }); //uncomment this for testing purposes only
							}, 'json');
						}
					},
					{
						icon: 'fa fa-check',
						label: ' YES',
						cssClass: 'btn btn-success',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
							var formData = $('#receiving_entry_form').serialize();
							$.post(baseUrl + 'receiving/post_receiving_to_db', formData, function(data){
								// alert(data);
								if(data == 'success'){
									rMsg('Successfully POSTED Transaction', 'success');
									
									setTimeout(function(){
										window.location = baseUrl + 'receiving/saved_receiving';
									},1500);
								}
								
								// if(data.status == 'success'){
									// setTimeout(function(){
										// thisDialog.close();
									// },1500);
								// }else if(data.status == 'error'){
									// rMsg('Entered Quantity is GREATER THAN the Ordered Quantity!', 'error');
									// $('#hidden_receiving_id').attr({'value' : data.id}).val(data.id);
									// clear_line_item_adder();
									// load_edit_receiving_items();
								// }
								
							}); //uncomment this for testing purposes only
							// }, 'json');
						}
					},
					{
						icon: 'fa fa-close',
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
		
	<?php elseif($use_js == 'reloadEditReceivingItemsJS'): ?>
		$('.del_btn').tooltip({
			'show': true,
				'placement': 'left',
				// 'title': "Please remember to..."
		});
		
		$('.del_btn').click(function(event){
			event.preventDefault();
			var line_id = $(this).attr('ref');
			var line_desc = $(this).attr('ref_desc');
			
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_WARNING,
				title: '<h4>Receiving Line Item Removal</h4>',
				message: "<h4><span style='color: orange;'>Warning:</span> Item will be <span style='color: red;'>PERMANENTLY DELETED FROM THE RECEIVING LINE</span> once you hit the <span style='color: green;'>YES</span> button.</h4></br><h4>Are you sure you want to remove this line item : <u>" + line_desc + "</u> ?</h4>",
				buttons: [
					{
						icon: 'fa fa-check',
						label: ' Yes',
						cssClass: 'btn btn-success',
						action: function(thisDialog){
							var $button = this;
							$button.disable();
							$button.spin();
							$.post(baseUrl + 'receiving/remove_from_receiving_details_temp', {'line_id' : line_id}, function(data){
								rMsg('Line Item Removed!','warning');
								setTimeout(function(){
									load_edit_receiving_items();
									thisDialog.close();
									$('#barcode').focus();
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
		
		function load_edit_receiving_items(){
			// var ref = "";
			var order_no = $('#order_no').val();
			var po_reference = $('#po_reference').val();
			
			var loader_url = baseUrl + 'receiving/load_receiving_items';
			$.post(loader_url, {'order_no' : order_no, 'po_reference' : po_reference}, function(data){
				$('#line_item_contents').html(data);
				return false;
			});
		}
			
	<?php endif; ?>
});
</script>