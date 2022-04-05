<script>
$(document).ready(function(){
	<?php if($use_js == 'loginJs'): ?>
		$('#login-btn').click(function(){
			$("#login-form").rOkay({
				btn_load		: 	$('#login-btn'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				async			:   true,
				onComplete		:	function(data){
										//alert(data);
										if(data.error_msg != null){
											rMsg(data.error_msg,'error');
											
										}else{
											// window.location = baseUrl; //-----ORIGINAL SETUP
											window.location = baseUrl;
										}
										// 	if(data){
										// 	$.alert(img, {
										// 		title: 'Welcome',
										// 		type: 'success',
										// 		position: ['top-right'],
										// 	});
										// 	setTimeout(function(){ 
										// 		window.location = baseUrl;
										// 	}, 2000);
										// }else{
										// 	// window.location = baseUrl; //-----ORIGINAL SETUP
										// 	 $.alert('&nbsp;', {
										// 		title: 'Error! Wrong Login!',
										// 		type: 'danger',
										// 		position: ['top-right'],
										// 	});
											
										// 		$("#login-form")[0].reset(); 
									 // }
								 }
			});
			return false;	
		});

	<?php endif; ?>
});
</script>