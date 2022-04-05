<script>
$(document).ready(function(){
	<?php if($use_js == 'salesReportsJs'): ?>
		$('#date_div').hide();
		$('#month_div').hide();
		$('#year_div').hide();
	$('.occurrenceDrop').change(function(){
		var id = $('#occurence_id').val();
		
		if(id == 0){
			$('#date_div').show();
			$('#month_div').hide();
			$('#year_div').hide();
		}else if(id == 1){
			$('#month_div').show();
			$('#year_div').show();
			$('#date_div').hide();
		}else if(id == 2){
			$('#year_div').show();
			$('#month_div').hide();
			$('#date_div').hide();
		}
	});
	$('#btn-print').click(function(){
		var branch_id = $('#branch_id').val();
		var occurrence_id = $('#occurence_id').val();

		// window.open(baseUrl + 'sales_reports/reports/'+branch_id+'/'+occurrence_id,'Sales Reports',"height=700,width=900");
		window.open(baseUrl + 'sales_reports/e_sales/'+branch_id+'/'+occurrence_id,'Sales Reports',"height=700,width=900");
		return false;
	});
	
	<?php endif; ?>
});
</script>