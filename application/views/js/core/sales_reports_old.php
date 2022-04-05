<script>
$(document).ready(function(){
	<?php if($use_js == 'itemsSalesJs'): ?>
		$('input.daterangepicker').daterangepicker({separator:' to '});
		var _s_options = {
	        ajax: {
	            url: 'search_inventory',
	            type: 'POST',
	            dataType: 'json',
	            data: {
	                q: '{{{q}}}'
	            }
	        },
	        locale: {
	            emptyTitle: 'Select to search items'
	        },
	        log: 3,
	        preprocessData: function (data) {
	            var i, l = data.length, array = [];
	            if (l) {
	                for(i = 0; i < l; i++){
	                    array.push($.extend(true, data[i], {
	                        text: data[i].Text,
	                        value: data[i].Id,
	                        data: {
	                            subtext: data[i].Subtext
	                        }
	                    }));
	                }
	            }
	            return array;
	        },
	    };
		$('#_s_item_field').selectpicker().filter('.with-ajax').ajaxSelectPicker(_s_options);
		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#item_sales_form').rOkay(
			{
				btn_load		: 	$('#btn-search'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				div_load		: 	$('#div-results'),
				div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
				onComplete		:	function(data) {
										$('#div-results').empty();
										$('#div-results').html(data);
									}
			});
		});
	<?php elseif($use_js == 'customerBalancesSearchJs'): ?>
		// $('#debtor_id').on('change',function(event)
		// {
		// 	var debtor_id = $(this).val();
		// 	$('#div-results').empty();
		// 	$('#div-results').html('<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>');
		// 	rMsg('Processing data. Please wait for a while.','warning');
		// 	$.post(baseUrl+'sales/reports/customer_balances_result',{'debtor_id':debtor_id},function(data)
		// 	{
		// 		$('#div-results').empty();
		// 		$('#div-results').html(data);
		// 	});
		// });
		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();

			$('#div-results').empty();
			$('#div-results').html('<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>');
			rMsg('Processing data. This may take a while.','warning');

			$('#as_pdf').val('0');

			$('#frm-cust-bal').rOkay({
				btn_load		: 	$('#btn-search'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				div_load		: 	$('#div-results'),
				div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
				onComplete		:	function(data) {
										$('#div-results').empty();
										$('#div-results').html(data);
									}
			});
		});
	<?php elseif($use_js == 'customerBalancesResultsJs'): ?>

	<?php endif; ?>
});
</script>