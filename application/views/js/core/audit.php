<script>
$(document).ready(function(){
	<?php if($use_js == 'AuditTabJs'): ?>
		$("[data-toggle='offcanvas']").click(); //hide main menu sa side
		
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
			link = '#audit_link';
			tab = '#audit';
			
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
		
	<?php elseif($use_js == 'auditJs'): ?>
		
		$('.movement_view_link').click(function(){
        // window.location = baseUrl+'inv_inquiries/approval_inquiry_container';	
			var _id = $(this).attr('_id');
			var branch_id = $(this).attr('branch_id');
			 bootbox.dialog({
                 message: baseUrl+'inv_inquiries/movements_details_main_form_load/'+_id+'/'+branch_id,
				 className: "bootbox-hwide",
                 title: "View Movements",
				 onEscape:  function () {
                          	window.location = baseUrl+'audit';
                       },
                 buttons: {
                   success: {
                       label: "Close",
                       className: "btn-success",
                       callback: function () {
                          	window.location = baseUrl+'audit';
                       }
                   }
                }
            });

			return false;
		});
		
			$('.po_view_link').click(function(){
				var order_no = $(this).attr('_id');
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

	<?php endif; ?>
});
</script>