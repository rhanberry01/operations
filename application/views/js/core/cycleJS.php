<script>
	$(document).ready(function(){

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
			my_btn.addClass('btn-success');
			my_btn.removeClass(btn_class);
			my_btn.html("<i class='fa fa-save'></i> Save"); 
		}

		function refresh_button(my_btn, btn_class)
		{
			my_btn.attr({'disabled' : 'disabled'});
			my_btn.addClass('btn-success');
			my_btn.removeClass(btn_class);
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); 
		}
		
		$('#bcode').change(function(){
			var branch_code = $('#branch_code').val();
			var bcode = $('#bcode').val();
			var prod_url =  '<?php echo base_url(); ?>cycle/get_prod_details/'+bcode+'/'+branch_code;
			var btn = $('#btn_save');
			
			$.ajax({
				type:"GET",
				data:{bcode:bcode,branch_code:branch_code},
				url: prod_url,
				cache:false,
				beforeSend:function(){
					refresh_button(btn, 'btn-success');
				},
				success: function(result){
					var obj =$.parseJSON(result);

					if (obj.length <= 0) {
						rMsg('No Record Found','error');
						$('#uom').val('');
						$('#cost').val('');
						$('#desc').val('');
						disable_button(btn, 'btn-success');

					}else{

						$('#uom').val(obj[0].uom);
						$('#cost').val(obj[0].srp);
						$('#desc').val(obj[0].Description);
						enable_button(btn, 'Save', 'fa-save', 'fa-save', 'btn-success','btn-success','btn-success')
					}
				}
			});

		});

		$('#btn_save').click(function(){
			var uom = $('#uom	').val();
			var cost = $('#cost').val();
			var branch_code = $('#branch_code').val();
			var bcode = $('#bcode').val();
			var date = new Date().toISOString();
			var post_url =  '<?php echo base_url(); ?>cycle/new_cycle_count';
			var btn = $('#btn_save');

			if (bcode == '') {
				rMsg('Oops. Barcode is empty','error');
				disable_button(btn, 'btn-success');
			 	setTimeout(function(){ location.reload(); }, 1000);
			}else{
				$.post(post_url, {uom:uom,cost:cost,branch_code:branch_code,bcode:bcode,date:date}, function(data){
					var obj = $.parseJSON(data);
					if (obj.status == 200) {
						
						rMsg(obj.message,'success');
					 	setTimeout(function(){ location.reload(); }, 1000);
					}else{
						rMsg('Failed. Please Try Again','error');
					}
				});	
			}
		});

		$('.certify').click(function(){
			var id=$(this).attr('id');
			var data = id.split("_");
			var num = data[1];
			var row = $('#row_id_'+num).val();
			
			BootstrapDialog.show({
				className: "bootbox",
				message:"<h4>Are you sure you want to Certify this Item?</h4>",
				title: "Certify Item Cycle Counts",
				buttons: {
					update: {
						label: "Approve",
						cssClass: "btn btn-primary",
						action: function (thisDialog)
						{
							loader_url = baseUrl+'cycle/certify_item/'+row;
							$.post(loader_url, {'id':row}, function(data){
								var obj = $.parseJSON(data);
								if (obj.status == 200) {
									
									rMsg(obj.message,'success');
								 	setTimeout(function(){ location.reload(); }, 1000);

								}else{

									rMsg(obj.message,'error');
								}
							}); 
						}
					},
					cancel: {
						label: "Close",
						className: "btn-default",
						action: function (thisDialog)
						{
							thisDialog.close();
						}
					}
				}
			});

			return false;
		});

	});

	<?php if($use_js == 'CycleCount'): ?>

	$(document).ready(function(){
		$('#delete_data').hide();
	});


	$(":checkbox").click(function(){
		$('#delete_data').hide();
		
		var num_count = $(".check").each(function(){
	 	  return $(this).val();
		}).length;

		var alldata = new Array();
		var data = [];

		for(var i =1; i<= num_count;i++){

			if($('#chk_'+i).val()>0){

				 data = [$('#chk_'+i).val()];
				 alldata.push(data);
			}
		}
		alert(alldata)

		// $(":checkbox").each(function () {
            // var ischecked = $(this).is(":checked");
            // data = $(this).val();
            // if (ischecked) {
            	// $(this).prop("checked","checked");

      //       	$('#delete_data').click(function(){
      //       		$.post(check_url,{data:data}, function( result ) {
						// rMsg('Successfully Delete','success');
					 // 	setTimeout(function(){ location.reload(); }, 1000);
	     //            });
      //       	});
                
        //     }
        // });
	});
	
	<?php endif; ?>
</script>
