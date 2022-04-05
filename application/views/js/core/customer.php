<script>
$(document).ready(function(){



	<?php if($use_js == 'customerJS'): ?>
	
		$('#save-btn').click(function(){
			$("#customer_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//alert(data);
										//rMsg(data.msg,'success');
										//window.location = baseUrl+'customer;
										
										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#cust_code').focus();
										}else{
											rMsg(data.msg, 'success')
										}
									}
			});

			// setTimeout(function(){
			// 	window.location.reload();
			// },1500);

			return false;
		});

	<?php elseif($use_js == 'customerBranchJS'): ?>
		$('#add-branch-btn').click(function(){
			debtor_id = $('#debtor_id').val();
			debtor_branch_id = $('#debtor_branch_id').val();
			// alert(debtor_id);
			window.location = baseUrl+'customer/add_branch/'+debtor_id+'/'+debtor_branch_id;
			return false;
		});

	<?php elseif($use_js == 'customerBranchAddJS'): ?>
		var inputs = $('.reqForm').each(function(){
			 // alert($(this).data('original')+'<~~~>'+this.value);
			$(this).data('original', this.value);
		});
		$('#save-branch-btn').click(function(){
			//alert('aw');
			$("#branch_details_form").rOkay({
				btn_load		: 	$('#save-branch-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//alert(data);
										rMsg(data.msg,'success');
										var form_mode = $('#mode').val();
										if(form_mode == 'edit'){
											//alert('edit');
											var input_name = '';
											var passed_form = '';
											var type_desc = 'Edit Customer Branch';
											var sales_person_details = '';
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
													if(sales_person_details != ''){
														sales_person_details += '||'+input_name+':'+$(this).data('original')+'|'+this.value;
													}else{
														sales_person_details += input_name+':'+$(this).data('original')+'|'+this.value;
													}
												}
												
											});
							
											if(passed_form != ''){
												var formData = 'pk_id='+data.id+'&'+'debtor_branch_id='+data.id+'|=|'+passed_form;
												//alert(formData);
												$.post(baseUrl+'sales/write_to_audit_trail/', {'form_vals' : formData, 'type_desc' : type_desc}, function(data){
											
												});
											}
										}
									}
			});

			// setTimeout(function(){
			// 	window.location.reload();
			// },1500);

			return false;
		});


	<?php endif; ?>
});
</script>