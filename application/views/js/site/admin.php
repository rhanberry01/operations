<script>
$(document).ready(function(){
	<?php if($use_js == 'rolesJs'): ?>
		$(".check").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				var ch = true;
			$('.'+id).prop('checked',ch);

			var parent = $(this).attr('parent');
			if (typeof parent !== 'undefined' && parent !== false) {
			   parentCheck(ch,parent);
			}

			// var classList = $(this).attr('class').split(/\s+/);
			// var chk = $(this);

			// $.each( classList, function(key, parent){
			// });
		});

		function parentCheck(ch,parent){
			if(parent != "check"){
				var par = $('#'+parent);
				if(!ch){
					var ctr = 0;
					$('.'+parent).each(function(){
						if($(this).is(':checked'))
							ctr ++;
					});
					if(ctr == 0)
						par.prop('checked',ch)
				}
				else
					par.prop('checked',ch);

				var parentParent = par.attr('parent');
				if (typeof parentParent !== 'undefined' && parentParent !== false) {
					parentCheck(ch,parentParent);
				}

			}
		}
	<?php elseif($use_js == 'paymentTermsJs'): ?>
		$("#days_before_due").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',1);
		});

	//////////**********JED*****************
	<?php elseif($use_js == 'formsJS'): ?>

		$('#save-btn').click(function(event){
			event.preventDefault();

			var formData = $('#setup_form').serialize();

			$.post(baseUrl+'admin/form_setup_db',formData,function(data)
			{
				// alert(data);
				rMsg(data.msg,'success');
			},'json');
			// });

			return false;
		});
	<?php elseif($use_js == 'dashboard'): ?>

		var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
		$("#details-tbl").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'<br>Reconnecting...</td></tr>');

		function checkConnection()
		{
		var url =  '<?php echo base_url(); ?>operation/check_connection';
		$.ajax({
				type:"GET",
				url: url,
				cache:false,
				success: function(data){
					var myObj = JSON.parse(data);
					//alert(myObj.msg);
					if(myObj.msg == "connected")
					{
						window.location.href = '<?php echo base_url(); ?>';
					}
				}
			});
		}
		setInterval( checkConnection, 3000 );	


	<?php endif; ?>
});
</script>