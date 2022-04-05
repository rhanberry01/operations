<script>
$(document).ready(function(){
	<?php if($use_js == 'zreadControllerJs'): ?>
		var day_checker = $('#day_checker').val();
		var xcounter = $('#xcounter').val();
		// alert('Day Checker:'+day_checker);
		// alert('X Counter:'+xcounter);
		if(day_checker == 0){
			// alert('AaA');
			if(xcounter > 0){
				// alert('BbB');
				$('.consolidate_btn').attr({'disabled' : 'disabled'});
			}else{
				// alert('CcC');
				$('.consolidate_btn').removeAttr('disabled');
			}
		}else{
			// alert('DdD');
			$('.consolidate_btn').attr({'disabled' : 'disabled'});
		}
		
		function enable_button(my_btn, my_btn_text, old_icon, new_icon, old_class, new_class)
		{
			var five_spaces = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			my_btn.removeAttr('disabled');
			my_btn.html('<i class="fa '+new_icon+' fa-lg"></i>'+five_spaces+' '+my_btn_text+' '+five_spaces+'<i class="fa '+new_icon+' fa-lg"></i>'); //change the label back to original entry types
			my_btn.addClass(new_class);
			my_btn.removeClass(old_class+' '+old_icon);
		}
		
		function disable_button(my_btn, btn_class)
		{
			var five_spaces = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			my_btn.attr({'disabled' : 'disabled'});
			my_btn.addClass('btn-danger');
			my_btn.removeClass(btn_class);
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."+five_spaces+"<i class='fa fa-refresh fa-spin fa-lg'></i>"); //change the label to loading... mabagal na loading
		}
		
		$('.consolidate_btn').click(function(){
			var this_btn = $(this);
			// alert('Consolidate button...');
			
			//-----DO THIS ON CLICK OF BUTTON
			disable_button(this_btn, 'btn-info'); //-----fn disable_button(parameter1=current_button, parameter2=class of current button to be removed)
			
			//-----GO TO CONTROLLER FUNCTION FOR SYNCING
			var sync_url = baseUrl+'pos/sync_to_stock_moves_branch'; //-----real url
			// var sync_url = ''; //-----testing purposes
			$.post(sync_url, {}, function(data){
				// alert(data);
				var res = data.split("||");
				if(res[1] == 'success'){
					// alert(res[2]);
					setTimeout(function(){
						rMsg('SYNCING COMPLETED!', 'success');
						// enable_button(this_btn, 'CONSOLIDATE TO BRANCH SERVER', 'fa-remove', 'fa-remove', 'btn-danger', 'btn-info'); //-----Turn red button to blue
						enable_button(this_btn, 'CONSOLIDATE TO BRANCH SERVER', 'fa-remove', 'fa-remove', '', 'btn-danger'); //-----Still red button but disabled
						this_btn.attr({'disabled' : 'disabled'});
					// },1500);
					},2500);
				}else{
					// alert(res[2]);
					rMsg('NOTHING TO CONSOLIDATE', res[1]);
					enable_button(this_btn, 'CONSOLIDATE TO BRANCH SERVER', 'fa-remove', 'fa-remove', '', 'btn-danger'); //-----Still red button but disabled
					this_btn.attr({'disabled' : 'disabled'});
				}
			});
			
			return false;
		});
		
	<?php endif; ?>
});
</script>