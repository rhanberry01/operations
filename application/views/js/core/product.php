<script>
$(document).ready(function(){
	<?php if($use_js == 'productJS'): ?>
		var mode = $('#mode').val();
		
		$('#product_code').focus();
		// alert(mode);
		//-----Product Code
		// if(mode == 'add'){
			// $('#product_code').focus();
		// }else{
			// $('#product_code').prop('disabled', true);
		// }
		
		$('#save-btn').click(function(){
			$("#product_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
										alert(data);
										// rMsg(data.msg,'success');

										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#product_code').focus();
										}else{
											rMsg(data.msg, 'success')
										}
									}
			});

			// setTimeout(function(){
				// window.location.reload();
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

	<?php endif; ?>
});
</script>