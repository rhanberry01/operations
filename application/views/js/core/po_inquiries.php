<script>
$(document).ready(function(){
	<?php if($use_js == 'approvalInquiryJs'): ?>
		
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
		
	<?php elseif($use_js == 'PurchaseOrdersApprovalJS'): ?>
		$('#purchase-orders-file-spinner').hide();	
			$('.action_btns').tooltip({
				'show': true,
				'placement': 'left',
			});
		
			$('#btn_check_purchase_order').click(function(){
				$('.check_id').attr('checked','checked');				 
			});
			
			$('.print_link').click(function(){
				var order_no = $(this).attr('ref');
				// window.location = baseUrl + 'po/edit_po_entry/'+order_no;
				window.open(baseUrl + 'po_prints/po/'+order_no,'Purchase Order Printout',"height=600,width=800");
				return false;
			});
			
			$('.edit_link').click(function(){
				var order_no = $(this).attr('ref');
				window.location = baseUrl + 'po/edit_po_entry/'+order_no;
				return false;
			});
			
			$('.view_link').click(function(){
				var order_no = $(this).attr('ref');
				// var line_desc = $(this).attr('ref_desc');
				
				bootbox.dialog({
					message: baseUrl+'po_inquiries/po_entry_popup/'+order_no,
					className: "bootbox-wide",
					title: "View Purchase Order Details",
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

			$('.reject_link').click(function(){
				var _id = $(this).attr('_id');
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
									var reject_url = baseUrl + 'po_inquiries/reject_added_purchase_orders';
									$.post(reject_url, {'_id' : _id, 'remarks': remarks}, function(data){
										if(data == 'success'){
											rMsg('Purchase Orders has been rejected.','success');
												setTimeout(function(){
													window.location = baseUrl+'po_inquiries/approval_inquiry_container';		
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

			});
				
			$('.approve_link').click(function(){
				$('#purchase-orders-file-spinner').show();
				$('.approve_link').hide();	
				$('.reject_link').hide();	
				$('.edit_link').hide();	
				$('.check_id').hide();
				var _id = $(this).attr('_id');
				//alert(stock_id);
				var url = baseUrl + 'po_inquiries/approve_added_purchase_orders'; 
				$.post(url, {'_id' : _id }, function(data){
				var msg  = data.split('||');
				console.log(data);
				console.log(msg[1]);
				$('#purchase-orders-file-spinner').hide();	
					if(msg[0] == 'success'){
						rMsg(msg[1],'success');
							setTimeout(function(){
								window.location = baseUrl+'po_inquiries/approval_inquiry_container';		
							},2000);
						}else if(msg[0] == 'no_con'){
							rMsg(msg[1],'warning');
							setTimeout(function(){
								window.location = baseUrl+'po_inquiries/approval_inquiry_container';		
							},2000);
						}
		
					});

				return false;
			});
		$('#btn_id_purchase_order').click(function(){
			$('#purchase-orders-file-spinner').show();	
			$('.approve_link').hide();	
			$('.reject_link').hide();	
			$('.edit_link').hide();	
			$('.check_id').hide();
				var ids =[] ;
				$( ":checkbox" )
				.map(function() {
					ids.push(this.checked+'|'+this.id);	
				}).get().join();
		var url = baseUrl + 'po_inquiries/get_all_checked_added_purchased_order'; 
			$.post(url, {'ids' : ids }, function(data){		
				// alert(data);
				var msg  = data.split('||');	
				$('#purchase-orders-file-spinner').hide();	
				if(msg[0] == 'success'){
					rMsg(msg[1],'success');
						setTimeout(function(){
							window.location = baseUrl+'po_inquiries/approval_inquiry_container';		
						},2000);
				}else if(msg[0] == 'no_con'){
						rMsg(msg[1],'warning');
						setTimeout(function(){
							window.location = baseUrl+'po_inquiries/approval_inquiry_container';		
						},2000);
				}
					
			});
				
			
		});
	<?php endif; ?>
});
</script>