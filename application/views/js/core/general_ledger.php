<script>
$(document).ready(function(){
	<?php if($use_js == 'classFormContainerJs'): ?>
		$('form').on('submit',function(event)
		{
			event.preventDefault();
			$('#save-list-form').trigger('click');
		});
	<?php elseif($use_js == 'typeFormContainerJs'): ?>
		$('.tab_link').click(function(event)
		{
			event.preventDefault();
			var id = $(this).attr('id');
			loader('#'+id);
		});
		loader('#details_link');
		function loader(btn)
		{
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var selected = $('#account_type_idx').val();
			if (selected == '') {
				selected = 'add';
				disableTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			} else {
				disableTabs('.load-tab',true);
			}
			var item_id = $('#account_type_idx').val();
			$(tabPane).rLoad({url:baseUrl+loadUrl+'/'+item_id});
		}
		function disableTabs(id,enable)
		{
			if (enable) {
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			} else {
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
	<?php elseif($use_js == 'typeFormJs'): ?>
		$('#save-btn').click(function()
		{
			$("#account_type_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										if (typeof data.result != "undefined") {
											rMsg(data.msg,data.result);
											if (data.result == 'success')
												setTimeout(function()
												{
													window.location = baseUrl + 'general_ledger/account_types';
												},800);
										}
									}
			});
			return false;
		});
		$('#back-btn').on('click',function(event)
		{
			event.preventDefault();
			window.location = baseUrl + 'general_ledger/account_types';
		});
	<?php elseif($use_js == 'accountFormContainerJs'): ?>
		$('.tab_link').click(function(event)
		{
			event.preventDefault();
			var id = $(this).attr('id');
			loader('#'+id);
		});
		loader('#details_link');
		function loader(btn)
		{
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var selected = $('#account_idx').val();
			if (selected == '') {
				selected = 'add';
				disableTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			} else {
				disableTabs('.load-tab',true);
			}
			var item_id = $('#account_idx').val();
			$(tabPane).rLoad({url:baseUrl+loadUrl+'/'+item_id});
		}
		function disableTabs(id,enable)
		{
			if (enable) {
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			} else {
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
	<?php elseif($use_js == 'accountFormJs'): ?>
		$('#save-btn').click(function()
		{
			$("#account_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										if (typeof data.result != "undefined") {
											rMsg(data.msg,data.result);
											if (data.result == "success")
												setTimeout(function()
												{
													window.location = baseUrl + 'general_ledger/accounts';
												},800);
										}
									}
			});
			return false;
		});
		$('#back-btn').on('click',function(event)
		{
			event.preventDefault();
			window.location = baseUrl + 'general_ledger/accounts';
		});
	<?php endif; ?>
});
</script>