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
				var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
		var url = baseUrl + 'inv_inquiries/get_all_checked'; 
			$.post(url, {'ids' : ids }, function(data){				
				var msg  = data.split('||');	
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
		
	
	<?php elseif($use_js == 'updateInquiryJs'): ?>
		
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
			link = '#update_link';
			tab = '#update';
			
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
	

	 <?php elseif($use_js == 'SupplierBillerCodeJS'): ?>
		$('#b-spinner').hide();	
		
		$('.action_btns').tooltip({
			'show': true,
			'placement': 'left',
		});
		
		
		$('.approve_link').click(function(){
			
			var _id = $(this).attr('_id');
				var serch_url = baseUrl + 'upd_inquiries/check_biller_code'; 
				$.post(serch_url, {'_id' : _id}, function(data){
				var res = data.split('|');
				if(res[0]){
					id = res[1];
					supp_id = res[2];
					code = res[3];
					supp_name  = res[4]
					var delay=300; //1 seconds
					setTimeout(function(){
						BootstrapDialog.show({
							type: BootstrapDialog.TYPE_DANGER,
				            title: 'CHECK SUPPLIER BILLER CODE',
					           message: "<center><h2>"+code+"</h2><br><input type='text' class='form-control' name='code' id='code' style='text-align:center; width:300px'></center>",
							   onshow: function(dialog) {
							   setTimeout(function (){
								$('#code').focus();	
							   }, 500);
							},
				            buttons: [{
				                id: 'pwd',
			               		hotkey: 13, 
				                label: 'Continue',
			           			cssClass: 'btn-danger',
				                action: function(dialogRef1) {
								if($("#code").val() == code){
									var url = baseUrl + 'upd_inquiries/approve_add_supplier_biller_code'; 
									$.post(url, {'id': id, 'supp_id' : supp_id, 'code' : code, 'supp_name' : supp_name}, function(data){
										if(data == 'success'){
											rMsg('Successfully Approved.','success');
											setTimeout(function(){
											dialogRef1.close();	
											window.location = baseUrl+'upd_inquiries/update_inquiry_container/biller_code';
											},1000);
										}
										
									}); 
									 
								}else{
									rMsg('Incorrect Biller Code.','error');
									$("#code").val('');
									$('#code').focus();	
								}	
				              }
				          }]
				       });	
					}, delay); 
				}
				else{
					rMsg('no record','error');
				}
			});
		});		
		
		$('.reject_link').click(function(){
			var _id = $(this).attr('_id');
			 BootstrapDialog.show({
				type: BootstrapDialog.TYPE_DANGER,
				title: 'Reject Supplier Biller Code',
				  message:  "Remarks:<input type='text' class='form-control' name='remarks' id='remarks'><br/>",
				onshow: function(dialog) {
					setTimeout(function (){
					$('#remarks').focus();
					}, 500);

				},
				buttons: [{
					id: 'pwd',
					label: 'Continue',
					cssClass: 'btn-danger',
					hotkey: 13, // Keycode of keyup event of key 'A' is 65.
					action: function(dialogRef2) {
						remarks = $("#remarks").val()
						var reject_url = baseUrl + 'upd_inquiries/reject_add_supplier_biller_code';
						$.post(reject_url, {'_id' : _id, 'remarks' : remarks}, function(data){
							if(data == 'success'){
								rMsg('Successfully Rejected.','success');
									setTimeout(function(){
									dialogRef2.close();	
									window.location = baseUrl+'upd_inquiries/update_inquiry_container/biller_code';
									},1000);
							}

						});

					}
				}]
			});
			
		});		
		
		
	<?php endif; ?>
});
</script>