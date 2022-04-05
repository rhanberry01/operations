<script>
	$(document).ready(function(){
		
		Array.prototype.associate = function (keys) {
		  var result = {};

		  this.forEach(function (el, i) {
		    result[keys[i]] = el;
		  });

		  return result;
		};

		$('#btn_search').click(function(){
		 
		 var category = $('#category').val();
		 var supplier = $('#supplier').val();

			var dtr_url = '<?php echo base_url(); ?>operation/negative_inventory_reload';
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			$.ajax({
				type:"POST",
				url: dtr_url,
				data: {category:category,supplier:supplier},
				cache:false,
				beforeSend:function(){

					$("#details-tbl").find('tr td').remove();
					$("#details-tbl").empty();
					$("#details-tbl").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');
					
				},
				success:function(data){
					if (data) {
						$('#asset_list_data').html(data);
					}else{
						$('#asset_list_data').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
					}

				}
			});	
		});	

		$('#printinventory').click(function(){
			var category = $('#category').val(); 
			var supplier = $('#supplier').val(); 
			
				var this_url = '<?php echo base_url() ?>operation/negative_inventory_excel';
				var formData = $('#neg_item_list').serialize();
				window.location = this_url+'?'+formData;
		});

		$('.update_link').click(function(){	

			var product_id = $(this).attr('product_id');	
			var id = $(this).attr('id');	
			bootbox.dialog({
				className: "bootbox-wide",
				message: baseUrl+'operation/item_adjusment/'+id,
				title: "Item Adjustment",
				modal:'hide'

			});
			dialog.init(function(){
			    setTimeout(function(){
			        dialog.find('.bootbox-body').html('');
			    }, 3000);
			})

			return false;
		});
		
		$('.allunits , .qty').change(function(){

			var id = $(this).attr('id');
			var val =id.split("_");
			var ref = val[1];
			var qty = $('#qty_'+ref).val();
			var cost = $('#cost_'+ref).val();
			var unit = $('#unit_'+ref).val();
			var url = '<?php echo base_url(); ?>operation/uom_details/'+unit;
			
			$.ajax({
				type:"GET",
				data:{unit:unit},
				url:url,
				cache:false,
				success:function(result){

					var obj =$.parseJSON(result);
					for (var i = 0; i < obj.length; i++) {
						
						$('#uom_qty_'+ref).val(obj[i].Qty);
						
						if (cost =='') {
							var computed = (qty*obj[i].Qty)*1;
							$('#unit_cost_'+ref).val(computed);
						}else{
							var computed = (qty*obj[i].Qty)*cost;
							$('#unit_cost_'+ref).val(computed.toFixed(4));
						}
						
						var total = 0;
						var k= 0;
						$('.allunitcost').each(function(){
					 	  k++;
					 	  u_cost = $(this).val();
					 	  total+=parseFloat(u_cost) ||0;
						});
		 				$('#total').val(total.toFixed(4));

					}
					
				},error:function(){

					rMsg('Contact IS Department','error');
					setTimeout(function(){ location.reload(); }, 20000);
				}
			});

		});


		$('#add_item_adjustment').click(function(){

			var formData = $('form[id="add_form"]').serialize();
			var total = $('#total').val();
			var trans_num = $('#trans_num').val();
			var remarks = $('#remarks').val();
			var date_adjustment = $('#date_adjustment').val();
			
			var num_count = $(".allunits").each(function(){
		 	  return $(this).val();
			}).length;

			var alldata = new Array();
			var data = [];

			for(var i =1; i<= num_count;i++){

				if($('#qty_'+i).val()!='' && $('#unit_'+i).val()!='' && $('#unit_cost_'+i).val()!='' && $('#uom_qty_'+i).val()!=''){

					 data = [$('#qty_'+i).val(),
					 		 $('#cost_'+i).val(),
					 		 $('#uom_qty_'+i).val(),
					 		 $('#unit_'+i).val(),
					 		 $('#unit_cost_'+i).val(),
					 		 $('#prod_id_'+i).val()];
					 alldata.push(data);
				}
			}

			var stock_url = baseUrl+'operation/add_stock_move';
			var post_url = baseUrl+'operation/add_adjustment_header';
			$.post(post_url, {trans_num:trans_num,date_adjustment:date_adjustment}, function(data){
				
				if (data != 'false' && data != '') {
					
					$.post(stock_url, {trans_num:trans_num,date_adjustment:date_adjustment,total:total,remarks:remarks,alldata:alldata}, function(data){
						
						setTimeout(function(){ location.reload(); }, 50000);
					});
						rMsg('Inventory Adjustment has been added','success');
				}else{

					rMsg('Oops. Somethings wrong','error');
				}
			});	

		});

		$('#update_adjustment').click(function(){

			var trans_num = $('#trans_num').val();
			var date_adjustment = $('#date_adjustment').val();
			var product_id = $('#product_id').val();
			var qty = $('#qty').val();
			var uom_qty = $('#uom_qty').val();
			var unit = $('#unit').val();
			var cost = $('#cost').val();
			var unit_cost = $('#unit_cost').val();
			var total = $('#total').val();
			var remarks = $('#remarks').val();
			
			var url = '<?php echo base_url(); ?>operation/add_stock_moves';
			$.ajax({
				type:"POST",
				data:{trans_num:trans_num,date_adjustment:date_adjustment,product_id:product_id,qty:qty,uom_qty:uom_qty,unit:unit,unit_cost:unit_cost,total:total,cost:cost,remarks:remarks},
				url:url,
				cache:false,
				success:function(data){
					if (data != 'false' && data != '') {
						rMsg('Successfully ADD','success');
						setTimeout(function(){ location.reload(); }, 50000);
					}else{
						
						rMsg('Data not Successfully save','error');
						setTimeout(function(){ location.reload(); }, 50000);
					}

				},error:function(){

						rMsg('Contact IS Department','error');
						setTimeout(function(){ location.reload(); }, 50000);
					
				}
			});
		});

		$('.btn_del').click(function(){
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>operation/delete_adjustment/'+id;
			var page_url = '<?php echo base_url(); ?>operation/adjustment_inquiry';
			$.ajax({
				type:'GET',
				url:url,
				cache:false,
				success:function(){

					rMsg('Data deleted','success');
					window.location = page_url;			
				}
			});
		});

		
		$(".bot_app").hide();

		$(".check").change(function() {
			if ($(".check:checked").length>0) {
				$(".check_all").prop("checked", true);
				$(".bot_app").show();
			}
			else {
				$(".check_all").prop("checked",false);
				$(".bot_app").hide();
			}
		});

		$(".check_all").click(function(){
			$(".check").prop("checked", true);
			$(".bot_app").show();
		});

		$('.history_link').click(function(){	
			var id = $(this).attr('id');	
			bootbox.dialog({
				className: "bootbox-wide",
				message: baseUrl+'operation/adjustment_history_view/'+id,
				title: "Adjustment Details",
				buttons: {
					cancel: {
						label: "Close",
						className: "btn-default",
						callback: function() {
						}
					}
				}
			});
			$(this).dialog('close').empty();
			return false;
		});




		<?php if($use_js == 'usersJs'): ?>
		var mode = $('#mode').val();
		$('#code').focus();
		
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
											$('#code').focus();
										}else{
											rMsg(data.msg, 'success');
										}
									}
			});

	
			return false;
		});	

		<?php elseif($use_js == 'NoDisplay'): ?>

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
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); 
		}
		

		$('#btn_search').click(function(){
			var btn = $(this)
			disable_button(btn,'btn-primary');
			var date = $('#date_').val();
			var dtr_url = '<?php echo base_url(); ?>operation/load_no_display';
			disable_button(btn, 'btn-primary');
			$.post(dtr_url, {'date' : date}, function(data){
				$('#adjustment').html(data);
					enable_button(btn, 'Search', 'fa-search', 'fa-search', 'btn-primary','btn-primary','btn-primary')
					return false;
				});

		});


		$('#print_excel_btn').click(function(){
			var date = $('#date_').val();
			var find = '/';
			var re = new RegExp(find, 'g');
			date = date.replace(re, '-');
			var this_url =  baseUrl+'operation/print_posible_no_display/'+date;
		   	window.location = this_url;
			return false;
		});


		<?php elseif($use_js == 'SmartTrans'): ?>
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
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); 
		}

		$('#btn_search_smart').click(function(){
			var btn = $(this)
			disable_button(btn,'btn-primary');
			var branch = $('#bcode').val();
			var or_num = $('#or_num').val();
			var dtr_url = '<?php echo base_url(); ?>operation/smart_trans_search';
			disable_button(btn, 'btn-primary');
			$.post(dtr_url, {'branch' : branch,'or_num' : or_num}, function(data){
				$('#smart_data').html(data);
					enable_button(btn, 'Search', 'fa-search', 'fa-search', 'btn-primary','btn-primary','btn-primary')
					return false;
				});

		});

		$('#print_excel_btn_smart').click(function(){
			var branch = $('#bcode').val(); 
			var or_num = $('#or_num').val(); 
			
				var this_url = '<?php echo base_url() ?>operation/print_smart_trans';
				var formData = $('#smart_item').serialize();
				window.location = this_url+'?'+formData;
		});

		<?php endif; ?>

	});
</script>