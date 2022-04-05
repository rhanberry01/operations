<script>
$(document).ready(function(){
	<?php if($use_js == 'invApprovalJs'): ?>
		$('#file-spinner').hide();	
		
		$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#btn_check').click(function(){
			 $('.check_id').attr('checked','checked');				 
		});
		
		$('#btn_id').click(function(){
			$('#file-spinner').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id').hide();	
				var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
		var url = baseUrl + 'inv_inquiries/add_get_all_checked'; 
			$.post(url, {'ids' : ids }, function(data){				
				var msg  = data.split('||');	
					console.log(data);
				$('#file-spinner').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/details';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/details';		
						},2000);
					}
					
				});
				
			
		});
		
		$('.view_link').click(function(){
        // window.location = baseUrl+'inv_inquiries/approval_inquiry_container';	
			var stock_id = $(this).attr('stock_id');
				 bootbox.dialog({
                 title: "Add Stock Details",
                message: baseUrl+'inv_inquiries/stock_main_form_load/'+stock_id,
                buttons: {
                   success: {
							
                       label: "Close",
                       className: "btn-success",
                       callback: function () {
                          	window.location = baseUrl+'inv_inquiries/approval_inquiry_container/details';	
                       }
                   }
                }
            });

			return false;
		});
		
		$('.approve_link').click(function(){
			$('#file-spinner').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id').hide();	
			var stock_id = $(this).attr('stock_id');
			//alert(stock_id);
			var url = baseUrl + 'inv_inquiries/stock_barcode_approval'; 
			$.post(url, {'stock_id' : stock_id }, function(data){
			var msg  = data.split('||');
			console.log(data);
			console.log(msg[1]);
			$('#file-spinner').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/details';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/details';		
						},2000);
					}
	
				});
				
	
			
			return false;
		});		
		
		$('.reject_link').click(function(){
			var stock_id = $(this).attr('stock_id');
			
			var reject_url = baseUrl + 'inv_inquiries/reject_add_stock_master';
			$.post(reject_url, {'stock_id' : stock_id}, function(data){
				if(data == 'success'){
					rMsg('Add stock master has been rejected','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/details';		
						},1000);
				}

			});
	
			return false;
		});
		
	<?php elseif($use_js == 'AddinvApprovalJs'): ?>
		$('#file-spinner-add').hide();	
		
		$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#btn_checks').click(function(){
			 $('.check_ids').attr('checked','checked');				 
		});
		
		$('#btn_ids').click(function(){
			//alert('dd');
			$('#file-spinner-add').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_ids').hide();	
				var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
			
		var url = baseUrl + 'inv_inquiries/add_get_all_checked'; 
			$.post(url, {'ids' : ids }, function(data){				
				var msg  = data.split('||');	
					console.log(data);
					//alert(data);
				$('#file-spinner-add').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/allnew';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/allnew';		
						},2000);
					}
					
				});
				
			
		});
		
		$('.view_link').click(function(){
			var stock_id = $(this).attr('stock_id');
				 bootbox.dialog({
                 title: "Add Stock Details",
                message: baseUrl+'inv_inquiries/stock_main_form_load/'+stock_id,
                buttons: {
                   success: {
							
                       label: "Close",
                       className: "btn-success",
                       callback: function () {
                          	window.location = baseUrl+'inv_inquiries/approval_inquiry_container/allnew';	
                       }
                   }
                }
            });

			return false;
		});
		
		$('.approve_link').click(function(){
			$('#file-spinner-add').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_ids').hide();	
			var stock_id = $(this).attr('stock_id');
			//alert(stock_id);
			var url = baseUrl + 'inv_inquiries/add_stock_barcode_approval'; 
			$.post(url, {'stock_id' : stock_id }, function(data){
			var msg  = data.split('||');
			console.log(data);
			console.log(msg[1]);
			$('#file-spinner-add').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/allnew';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/allnew';		
						},2000);
					}
	
				});
				
	
			
			return false;
		});		
		
		$('.reject_link').click(function(){
			var stock_id = $(this).attr('stock_id');
			
			var reject_url = baseUrl + 'inv_inquiries/reject_add_stock_master';
			$.post(reject_url, {'stock_id' : stock_id}, function(data){
				if(data == 'success'){
					rMsg('Add stock master has been rejected','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/details';		
						},1000);
				}

			});
	
			return false;
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
	<?php elseif($use_js == 'approvalInquiryJs'): ?>
		
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
			link = '#allnew_link';
			tab = '#allnew';
			
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
	
	<?php elseif($use_js == 'approvalInquiryMovementsJs'): ?>
		
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
			link = '#movements_link';
			tab = '#movements';
			
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
		
	<?php elseif($use_js == 'updateBarcodePricesJs'): ?>	
		$('#barcode_spinners').hide();	
		
		$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#btn_check_bpupdate').click(function(){
			
			$('.check_id_bpupdate').attr('checked','checked');	
			
		});	
		
		$('#btn_id_bpupdate').click(function(){
				
			$('#barcode_spinners').show();	
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_bpupdate').hide();	
				var ids =[] ;
					$( ":checkbox" )
					.map(function() {
						ids.push(this.checked+'/'+this.id);	
					}).get().join();
					
			var url = baseUrl+'inv_inquiries/get_all_checked_for_barcode_prices_update'; 
				$.post(url, {'ids' : ids }, function(data){
					console.log(data);
					rMsg('barcode price has been updated','success');
					 setTimeout(function(){
						window.location = baseUrl+'upd_inquiries/update_inquiry_container/barcode_price';		
					 },2000);
				});
				
			});
		
		$('.approve_link').click(function(){
			$('#barcode_spinners').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_bpupdate').hide();	
			var _id = $(this).attr('_id');
			var url = baseUrl + 'inv_inquiries/barcode_prices_update_approval'; 
			$.post(url, {'_id' : _id }, function(data){
				console.log(data);
				rMsg('barcode price has been updated','success');
				setTimeout(function(){
					window.location = baseUrl+'upd_inquiries/update_inquiry_container/barcode_price';		
				},2000);
			});
			return false;
		});	
		
	    $('.reject_link').click(function(){
			var _id = $(this).attr('_id');
			var reject_url = baseUrl + 'inv_inquiries/reject_barcode_prices_update';
			$.post(reject_url, {'_id' : _id}, function(data){
				if(data == 'success'){
					rMsg('barcode price update has been rejected','success');
						setTimeout(function(){
							window.location = baseUrl+'upd_inquiries/update_inquiry_container/barcode_price';		
						},1000);
				}

			});
	
			return false;
		});
		
		
	
	<?php elseif($use_js == 'updateJs'): ?>
		$('#spinners_').hide();	
		
		$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		
		$('#btn_check_update').click(function(){
			
			$('.check_id_update').attr('checked','checked');	
			
		});	
		
		$('#btn_id_update').click(function(){
			
		$('#spinners_').show();	
		$('.approve_link').hide();	
		$('.reject_link').hide();	
		$('.check_id_update').hide();	
			var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
				
		var url = baseUrl+'inv_inquiries/get_all_checked_update'; 
			$.post(url, {'ids' : ids }, function(data){
				rMsg('price update has been updated','success');
				setTimeout(function(){
					window.location = baseUrl+'upd_inquiries/update_inquiry_container/update';		
				},2000);
			});
				
			
		});
			
		
		
		$('.approve_link').click(function(){
			$('#spinners_').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_update').hide();	
			var _id = $(this).attr('_id');
			var url = baseUrl + 'inv_inquiries/update_approval'; 
			$.post(url, {'_id' : _id }, function(data){
				console.log(data);
				rMsg('price update has been updated','success');
				setTimeout(function(){
					window.location = baseUrl+'upd_inquiries/update_inquiry_container/update';		
				},2000);
			});
			
			return false;
		});	
		
		
		$('.reject_link').click(function(){
			var _id = $(this).attr('_id');
			//alert(_id);
			var reject_url = baseUrl + 'inv_inquiries/reject_prices_update';
			$.post(reject_url, {'_id' : _id}, function(data){
				if(data == 'success'){
					rMsg('price update has been rejected','success');
						setTimeout(function(){
							window.location = baseUrl+'upd_inquiries/update_inquiry_container/update';		
						},1000);
				}

			});
	
			return false;
		});
		
	<?php elseif($use_js == 'marginaldownJs'): ?>	
		$('#spinner_marginal').hide();	
		
		$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#btn_check_marginal').click(function(){
			
			$('.check_id_marginal').attr('checked','checked');	
			
		});	
		
		$('#btn_id_marginal').click(function(){
			$('#spinner_marginal').show();	
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_marginal').hide();
			var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
				
			
			var url = baseUrl+'inv_inquiries/get_all_checked_marginal'; 
			$.post(url, {'ids' : ids }, function(data){
				console.log(data);
				
			var msg  = data.split('||');	
				$('#-spinner').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/marginal';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/marginal';		
						},2000);
					}
				
			});		
				
		});
		
		$('.approve_link').click(function(){
			$('#spinner_marginal').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_marginal').hide();
			var _id = $(this).attr('_id');
			var url = baseUrl + 'inv_inquiries/schedule_marginal_approval'; 
			$.post(url, {'_id' : _id }, function(data){
				console.log(data);
				if(data == 'success'){
					$('#spinner_marginal').hide();	
					rMsg('Add marginal markdown has been approved','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/marginal';		
						},1000);
					}else if (data == 'no_con') {
						$('#spinner_marginal').hide();	
						//alert('error');
						rMsg('unable to approve : no connection','warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/marginal';		
						},1000);
					}else{
						$('#spinner_marginal').hide();	
						rMsg('error has been occurred','danger');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/marginal';		
						},1000);
					}
	
					});
			
			return false;
		});	
		
		$('.reject_link').click(function(){
			var view_id = $(this).attr('view_id');
			//alert(view_id);
			var reject_url = baseUrl + 'inv_inquiries/reject_marginal_markdown';
			$.post(reject_url, {'_id' : view_id}, function(data){
				if(data == 'success'){
					rMsg('Add marginal markdown has been rejected','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/marginal';		
						},1000);
				}

			});
	
			return false;
		});
		
		
		
		
    <?php elseif($use_js == 'scheduleMdownJs'): ?>
		$('#spinner_').hide();	
		$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#btn_check_markdown').click(function(){
			
			$('.check_id_markdown').attr('checked','checked');	
			
		});		
		
		$('#btn_id_markdown').click(function(){
			$('#spinner_').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_markdown').hide();
			var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
				
			
			var url = baseUrl+'inv_inquiries/get_all_checked_markdown'; 
			$.post(url, {'ids' : ids }, function(data){
				console.log(data);
				
			var msg  = data.split('||');	
				$('#-spinner').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';		
						},2000);
					}
				
			});		
				
		});
		
		$('.view_link').click(function(){
			var _id = $(this).attr('view_id');
			bootbox.dialog({
			title: "Schedule Markdown",
			message: baseUrl+'inv_inquiries/schedule_markdown_view/'+_id,
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
		
		$('.approve_link').click(function(){
			$('#spinner_').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_markdown').hide();
			var _id = $(this).attr('_id');
			var url = baseUrl + 'inv_inquiries/schedule_markdown_approval'; 
			$.post(url, {'_id' : _id }, function(data){
				console.log(data);
				if(data == 'success'){
					$('#spinner_').hide();	
					rMsg('Add schedule markdown has been approved','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';		
						},1000);
					}else if (data == 'no_con') {
						$('#spinner_').hide();	
						//alert('error');
						rMsg('unable to approve : no connection','warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';		
						},1000);
					}else{
						$('#spinner_').hide();	
						rMsg('error has been occurred','danger');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';		
						},1000);
					}
	
					});
			
			return false;
		});		
		
		$('.reject_link').click(function(){
			var view_id = $(this).attr('view_id');
			//alert(view_id);
			var reject_url = baseUrl + 'inv_inquiries/reject_schedule_markdown';
			$.post(reject_url, {'_id' : view_id}, function(data){
				if(data == 'success'){
					rMsg('Add schedule markdown has been rejected','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/markdown';		
						},1000);
				}

			});
	
			return false;
		});
	
			
    <?php elseif($use_js == 'StockBarcodePricesJS'): ?>
		$('#-spinner').hide();	
		$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		
		$('.view_link').click(function(){
			var barcode = $(this).attr('barcode');
			bootbox.dialog({
			title: "Branch Prices",
			className: "bootbox-ywide",
			message: baseUrl+'inv_inquiries/barcode_prices_view/'+barcode,
			buttons: {
			   success: {
				   label: "Close",
				   className: "btn-success",
				   callback: function () {
						window.location = baseUrl+'inv_inquiries/approval_inquiry_container/price';	
				   }
			   }
			}
		});
			return false;
		});
		
		
		
		$('#btn_id_prices').click(function(){ 
	
		$('#-spinner').show();
		$('.approve_link').hide();	
		$('.reject_link').hide();	
		$('.check_id_price').hide();	
			var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
		var url = baseUrl+'inv_inquiries/get_all_checked_prices'; 
			$.post(url, {'ids' : ids }, function(data){			
					//alert(data)
				var msg  = data.split('||');	
				$('#-spinner').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/price';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/price';		
						},2000);
					}
				});
		});	
		
		$('#btn_check_price').click(function(){
			 $('.check_id_price').attr('checked','checked');				 
		//	alert('alert');
		});		
		
		$('.approve_link').click(function(){
			$('#-spinner').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_price').hide();	
			var stock_id = $(this).attr('stock_id');
			var barcode = $(this).attr('barcode');
			var url = baseUrl + 'inv_inquiries/stock_barcode_prices_approval'; 
			$.post(url, {'stock_id' : stock_id ,'barcode' : barcode}, function(data){
				
				console.log(data);
				var msg  = data.split('||');
					if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/price';		
						},1000);
					}
					else if (msg[0] == 'no_con') {
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/price';		
						},1000);
					}else{
						rMsg('error has been occurred','danger');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/price';		
						},1000);
					}
				
				
					 });
			
			return false;
		});		
		
		$('.reject_link').click(function(){
			var _id = $(this).attr('barcode');
			
			var reject_url = baseUrl + 'inv_inquiries/reject_stock_barcode_price';
			$.post(reject_url, {'_id' : _id}, function(data){
				if(data == 'success'){
					rMsg('barcode price has been rejected','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/price';		
						},1000);
				}

			});
	
			return false;
		});
	//StockDeletionJS
	 <?php elseif($use_js == 'StockDeletionJS'): ?>		
		 $('#s-spinner-stock-del').hide();
		 
		 $('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		 });
		 
	$('#btn_check_del_stocks').click(function(){
			 $('.check_del_id_update').attr('checked','checked');				 
		});
			
	$('#btn_id_del_stocks').click(function(){
			$('#s-spinner-stock-del').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_del_id_update').hide();	
				var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
		var url = baseUrl + 'inv_inquiries/get_all_checked_stock_deletion'; 
			$.post(url, {'ids' : ids }, function(data){	
					rMsg('stock deletion has been approved','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/stock_deletion';		
						},2000);
		
				});
				
			
		});
			
	 
		 $('.approve_link').click(function(){
			$('#s-spinner-stock-del').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_del_id_update').hide();	
			var stock_id = $(this).attr('stock_id');
			var id = $(this).attr('_id');
			var stock_code = $(this).attr('stock_code');
			var url = baseUrl + 'inv_inquiries/approved_stock_deletion'; 
			$.post(url, {'stock_id' : stock_id ,'id' : id}, function(data){
					rMsg('stock deletion has been approved','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/stock_deletion';		
						},2000);
			});
			
		 });
			 

		$('.reject_link').click(function(){
			
			var _id = $(this).attr('_id');	
			var reject_url = baseUrl + 'inv_inquiries/reject_stock_deletion';
			$.post(reject_url, {'_id' : _id}, function(data){
				if(data == 'success'){
					rMsg('stock deletion has been rejected','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/stock_deletion';		
						},1000);
				}

			});
	
		});		
	 
	 
	//end	
	 <?php elseif($use_js == 'SupplierStocksJS'): ?>
		$('#s-spinner').hide();	
		
		$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		$('#btn_check_stocks').click(function(){
			 $('.check_id_stocks').attr('checked','checked');				 
		});
		
		$('#btn_id_stocks').click(function(){
			$('#s-spinner').show();	
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_stocks').hide();
				var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
		var url = baseUrl + 'inv_inquiries/get_all_checked_supplier_stocks'; 
			$.post(url, {'ids' : ids }, function(data){		
				var msg  = data.split('||');	
				$('#s-spinner').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/supplier_stock';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/supplier_stock';		
						},2000);
					}
					
				});
				
			
		});
		
		$('.view_link').click(function(){
        // window.location = baseUrl+'inv_inquiries/approval_inquiry_container';	
			var _id = $(this).attr('_id');
				 bootbox.dialog({
                 title: "View Supplier Stocks",
				 className: "bootbox-wide",
                 message: baseUrl+'inv_inquiries/suuplier_stock_main_form_load/'+_id,
				 onEscape: true,
				 onshow: function(dialog) {
						setTimeout(function (){
						$('#close').focus();	
						}, 500);
					},
                 buttons: {
                   success: {
					   id:'close',
                       label: "Close",
                       className: "btn-success",
					   hotkey: 27,
                       callback: function () {
                          	window.location = baseUrl+'inv_inquiries/approval_inquiry_container/supplier_stock';	
                       }
                   }
                }
            });

			return false;
		});
		
		$('.approve_link').click(function(){
			$('#s-spinner').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id_stocks').hide();
			var _id = $(this).attr('_id');
			//alert(stock_id);
			var url = baseUrl + 'inv_inquiries/stock_supplier_stocks_approval'; 
			$.post(url, {'_id' : _id }, function(data){
			var msg  = data.split('||');
			console.log(data);
			console.log(msg[1]);
			$('#file-spinner').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/supplier_stock';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/supplier_stock';		
						},2000);
					}
	
				});
				
	
			
			return false;
		});		
		
		$('.reject_link').click(function(){
			var _id = $(this).attr('_id');
			
			var reject_url = baseUrl + 'inv_inquiries/reject_add_supplier_stocks';
			$.post(reject_url, {'_id' : _id}, function(data){
				if(data == 'success'){
					rMsg('Add stock master has been rejected','success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container/supplier_stock';		
						},1000);
				}

			});
	
			return false;
		});		
		<?php elseif($use_js == 'MovementsApprovalJS'): ?>
			$('#movement-file-spinner').hide();	
			$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
			});
		
			$('#btn_check_movement').click(function(){
				$('.check_id').attr('checked','checked');				 
			});
			
			
			$('.reject_link').click(function(){
			var _id = $(this).attr('_id');
			var branch_id = $(this).attr('branch_id');
				var delay=300; //1 seconds
					setTimeout(function(){
						BootstrapDialog.show({
							type: BootstrapDialog.TYPE_DANGER,
				            title: 'Remarks',
					           message: "<center><textarea rows='4' cols='80' id='remarks' name='remarks'/></center>",
							   onshow: function(dialog) {
							   setTimeout(function (){
								$('#remarks').focus();	
							   }, 500);
							},
				            buttons: [{
				                id: 'pwd',
				                label: 'Continue',
			           			cssClass: 'btn-danger',
				                action: function(dialogRef1) {
								if($("#remarks").val() != ''){
									var remarks = $("#remarks").val();
									var reject_url = baseUrl + 'inv_inquiries/reject_added_movements';
									$.post(reject_url, {'_id' : _id, 'branch_id':branch_id, 'remarks' : remarks}, function(data){
										if(data == 'success'){
											rMsg('Added stock movements has been rejected.','success');
												setTimeout(function(){
													window.location = baseUrl+'inv_inquiries/approval_inquiry_container_movements';		
												},1000);
										}

									});
									 
								}else{
									rMsg('Please enter your remarks.','error');
									$('#remarks').focus();	
								}	
				              }
				          }]
				       });	
					}, delay); 

			return false;
		});
		
		$('.approve_link').click(function(){
			$('#movement-file-spinner').show();
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id').hide();
			var _id = $(this).attr('_id');
			var branch_id = $(this).attr('branch_id');
			//alert(stock_id);
			var url = baseUrl + 'inv_inquiries/approve_added_movements'; 
			$.post(url, {'_id' : _id, 'branch_id' : branch_id }, function(data){
			var msg  = data.split('||');
			alert(data);
			//console.log(msg[1]);
			$('#movement-file-spinner').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container_movements';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container_movements';		
						},2000);
					}else{
					rMsg(data,'error');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container_movements';		
						},2000);
					};
	
				});
				
	
			
			return false;
		});
		
		$('#btn_id_movement').click(function(){
			$('#movement-file-spinner').show();	
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.check_id').hide();
				var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
		var url = baseUrl + 'inv_inquiries/get_all_checked_added_movements'; 
			$.post(url, {'ids' : ids }, function(data){		
				var msg  = data.split('||');	
				$('#movement-file-spinner').hide();	
				//alert(data);
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container_movements';		
						},2000);
					}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container_movements';		
						},2000);
					}else{
						rMsg(data,'error');
						setTimeout(function(){
							window.location = baseUrl+'inv_inquiries/approval_inquiry_container_movements';		
						},2000);
					}
					
				});
				
			
		});
		
		$('.view_link').click(function(){
        // window.location = baseUrl+'inv_inquiries/approval_inquiry_container';	
			var _id = $(this).attr('_id');
			var branch_id = $(this).attr('branch_id');
			 bootbox.dialog({
                 message: baseUrl+'inv_inquiries/movements_details_main_form_load/'+_id+'/'+branch_id,
				 className: "bootbox-hwide",
                 title: "View Movements",
				 onEscape:  function () {
                          	window.location = baseUrl+'inv_inquiries/approval_inquiry_container_movements';
                       },
                 buttons: {
                   success: {
                       label: "Close",
                       className: "btn-success",
                       callback: function () {
                          	window.location = baseUrl+'inv_inquiries/approval_inquiry_container_movements';
                       }
                   }
                }
            });

			return false;
		});
	<?php elseif($use_js == 'StockSearchJs'): ?>
			$('#div-results').hide();	
	
		$('#btn-search').on('click',function(event)
		{	
			$('#stock_search_form').rOkay(
			{
				btn_load		: 	$('#btn-search'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				div_load		: 	$('#div-results'),
				div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
				onComplete		:	function(data){
										//alert(data);
										$('#div-results').empty();
										$('#div-results').html(data);
										$('#stock_lists').hide();
										$('#div-results').show();
									}
			});
		});
		
	<?php endif; ?>
});
</script>