<script>
$(document).ready(function(){
	<?php if($use_js == 'addMovementJS'): ?>
		function load_uom_hidden_qty(uom){
			var converter_url = baseUrl + 'inv_transactions/get_uom_qty';
			$.post(converter_url, {'uom' : uom}, function(data){
				if(data != '')
					$('#uom_qty').attr('value', data).val(data);
				else
					$('#uom_qty').attr('value', 0).val(0);
			});
		}
		
		var uom = $('#uom').val();
		load_uom_hidden_qty(uom);
		
		$('#uom').change(function(){
			var uom = $(this).val();
			load_uom_hidden_qty(uom);
			return false;
		});
		
		$('#barcode').blur(function(){
			var branch_id = $('#branch_id').val();
			var barcode = $(this).val();
			var val_url = baseUrl + 'inv_transactions/get_barcode_details';
			$.post(val_url, {'barcode' : barcode, 'branch_id' : branch_id}, function(data){
				if(data == 'warning'){
					rMsg('Barcode does not exists!','warning');
					$('#barcode').focus();
				}else{
					var vals = data.split('||');
					load_uom_hidden_qty(vals[2]);
					$('#stock_id').attr('value', vals[0]).val(vals[0]);
					$('#stock_desc').attr('value', vals[1]).val(vals[1]);
					$('#uom').attr('value', vals[2]).val(vals[2]);
					$('#unit_cost').attr('value', vals[3]).val(vals[3]);
					$('#qty').focus();
				}
			});
			return false;
		});
		
		function reload_total(){
			var qty = $('#qty').val();
			var unit_cost = $('#unit_cost').val();
			var total = (qty * unit_cost)+0;
			$('#total').attr('value', total).val(total);
		}
		
		$('#qty, #unit_cost').blur(function(){
			reload_total();
			return false;
		});
		
		function load_movement_items(){
			var ref = $('#hidden_user').val();
			var dtr_url = '<?php echo base_url(); ?>inv_transactions/load_movement_items';
			$.post(dtr_url, {'ref' : ref}, function(data){
				$('#stock_contents').html(data);
				return false;
			});
		}
		
		load_movement_items();
		
		function clear_item_adder_form(){
			$('#barcode').attr({'value' : ''}).val('');
			$('#stock_desc').attr({'value' : ''}).val('');
			$('#stock_id').attr({'value' : ''}).val('');
			$('#uom').attr({'value' : ''}).val('');
			$('#uom_qty').attr({'value' : ''}).val('');
			$('#qty').attr({'value' : ''}).val('');
			$('#unit_cost').attr({'value' : ''}).val('');
			$('#total').attr({'value' : ''}).val('');
			$('#total_amount').attr({'value' : ''}).val('');
		}
		
		$('#add_btn').click(function(){
			var formData = $('#add_movement_form').serialize();
			
			var post_url = '<?php echo base_url(); ?>inv_transactions/add_to_movement_details_temp';
			// $.post(post_url, {'stock_id' : stock_id, 'branch_id' : branch_id, 'barcode' : barcode, 'desc' : desc, 'uom' : uom, 'qty' : qty, 'unit_cost' : unit_cost, 'total' : total}, function(data){
			$.post(post_url, formData, function(data){
				// console.log(data.msg+' '+data.id);
				// alert(data);
				rMsg(data.msg+' [ '+data.desc+' ] ','success');
				clear_item_adder_form();
				load_movement_items();
				return false;
			// });
			}, 'json');

			return false;
		});
		
		$('#save_movement_btn').click(function(){
			var post_url = baseUrl + 'inv_transactions/add_to_main_movements_tbl';
			var formData = $('#add_movement_form').serialize();
			$.post(post_url, formData, function(data){
				// alert(data);
				// if(data.stat == 'warning'){
				if(data == 'warning'){
					rMsg('Movement ID already exists!','warning');
				}else{
					rMsg('Successfully added item for MOVEMENT','success');
					setTimeout(function(){
						window.location.reload();
					},1500);
				}
			});
			return false;
		});
		// }, 'json');
		
	<?php elseif($use_js == 'reloadBarcodeDetailsJs'): ?>
		$('.del_this_item').tooltip({
			'show': true,
				'placement': 'left',
				// 'title': "Please remember to..."
		});
		
		function load_movement_items(){
			var ref = $('#hidden_user').val();
			var dtr_url = '<?php echo base_url(); ?>inv_transactions/load_movement_items';
			$.post(dtr_url, {'ref' : ref}, function(data){
				$('#stock_contents').html(data);
				return false;
			});
		}
		
		$('.del_this_item').click(function(){
			var line_id = $(this).attr('ref');
			var post_url = baseUrl + 'inv_transactions/remove_movement_details_line_item';
			$.post(post_url, {'line_id' : line_id}, function(data){
				rMsg('Line Item Removed!','warning');
				setTimeout(function(){
					load_movement_items();
				},1500);
			});
			return false;
		});
	<?php endif; ?>
});
</script>