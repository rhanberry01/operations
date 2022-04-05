<script>
$(document).ready(function(){
	<?php if($use_js == 'supplierFormContainerJs'): ?>
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
			var selected = $('#supplier_idx').val();
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
			var item_id = $('#supplier_idx').val();
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
	<?php elseif($use_js == 'supplierDetailsJs'): ?>
		$('#save-btn').click(function(){
			$("#supplier_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										// alert(data);
										rMsg(data.msg,'success');
									}
			});

			// setTimeout(function(){
				// window.location.reload();
			// },1500);

			return false;
		});

		$('#fname, #mname, #lname, #suffix, #phone, #email, #street_no, #street_address, #city, #region, #zip')
		.keyboard({
			alwaysOpen: false,
			usePreview: false
		})
		.addNavigation({
			position   : [0,0],
			toggleMode : false,
			focusClass : 'hasFocus'
		});
	<?php elseif($use_js == 'customersJs'): ?>
		$('#new-customer-btn').click(function(){
			// alert('New Customer Button');
			window.location = baseUrl+'customers/cashier_customers';
			return false;
		});

		$('#look-up-btn').click(function(){
			// alert('Look up');
			var this_url =  baseUrl+'customers/customers_list';
			$.post(this_url, {},function(data){
				$('.customer_content_div').html(data);
				// $('#telno').attr({'value' : ''}).val('');

				$('.edit-line').click(function(){
					var line_id = $(this).attr('ref');
					var phone = $(this).attr('phoneref');
					var thisurl = baseUrl+'customers/load_customer_details';
					// alert('edit to : '+line_id);

					$.post(thisurl, {'telno' : phone}, function(data1){
						$('.customer_content_div').html(data1);
					});

					return false;
				});

			});
			return false;
		});

		$('#exit-btn').click(function(){
			window.location = baseUrl+'cashier';
			return false;
		});

		$('#pin')
		.keyboard({
			alwaysOpen: false,
			usePreview: false
		})
		.addNavigation({
			position   : [0,0],
			toggleMode : false,
			focusClass : 'hasFocus'
		});

		$('#telno').focus(function(){
			$('#telno').attr({'value' : ''}).val('');
			return false;
		});

		$('#telno-login').click(function(){
			var telno = $('#telno').val();
			var this_url =  baseUrl+'customers/validate_phone_number';
			// alert('asdfg---'+telno);

			$.post(this_url, {'telno' : telno}, function(data){
				// alert(data);
				var parts = data.split('||');
				// alert('eto:'+parts[1]);
				if(parts[0] == 'empty'){
					rMsg('Text field is empty!','error');
					// setTimeout(function(){
						// window.location.reload();
					// },1500);
				}else if(parts[0] == 'none'){
					rMsg('Customer does not exist.','error');
					// setTimeout(function(){
						// window.location.reload();
					// },1500);
				}else if(parts[0] == 'success'){
					rMsg('Loading customer details...','success');

					setTimeout(function(){
						var this_url2 =  baseUrl+'customers/load_customer_details';
						$.post(this_url2, {'telno' : parts[1]},function(data){
							$('.customer_content_div').html(data);
							// $('#telno').attr({'value' : ''}).val('');
							return false;
						});
					},1500);

				}
			});

			return false;
		});

		function loadCustomerDetails(){
			var this_url =  baseUrl+'customers/customer_load';

			$.post(this_url, {},function(data){
				$('.customer_content_div').html(data);
				$('#telno').focus();
				return false;
			});
		}

		loadCustomerDetails();

	<?php elseif($use_js == 'purchaseOrderHeaderJS'): ?>
		loader('#details_link');
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var po_id = $('#po_id').val();

			if(po_id == ""){
				//alert('waaaa');
				disEnbleTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			}
			else{
				//alert('we');
				disEnbleTabs('.load-tab',true);
			}
			//alert(po_id);
			$(tabPane).rLoad({url:baseUrl+loadUrl+po_id});
		}
		function disEnbleTabs(id,enable){
			if(enable){
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			}
			else{
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}

	<?php elseif($use_js == 'poHeaderDetailsLoadJs'): ?>
	//alert('zxczxc');
		$('#save-poheader').click(function(){
			$("#po_header_details_form").rOkay({
				btn_load		: 	$('#save-poheader'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										if(typeof data.msg != 'undefined' ){
											$('#po_id').val(data.id);
											// $('#details').rLoad({url:baseUrl+'branches/details_load/'+sel+'/'+res_id});
											disEnbleTabs('.load-tab',true);
											rMsg(data.msg,'success');
											$('#recipe_link').click();
										}
									}
			});
			$('.input_form').val('').removeAttr('selected');
			$('input.combobox.this_item[type="text"]').focus();
			return false;
		});
		function disEnbleTabs(id,enable){
			if(enable){
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			}
			else{
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}

	<?php elseif($use_js == 'poItemsJs'): ?>
		$('#item').change(function(){
			set_item_details($(this).val());
		});

		function set_item_details(id){
			$.post(baseUrl+'purchasing/get_item_details/'+id,function(data){
				$('#item-id').val(data.item_id);
				$('#item-uom').val(data.uom);

				if(id != ''){
					$('#unit_price').val(data.unit_cost);
					// $('#qoh').val(data.qoh);
					$('#select-uom').find('option').remove();
					$.each(data.opts,function(key,val){
						$('#select-uom').append($("<option/>", {
					        value: val,
					        text: key
					    }));
					});

				}else{
					$('#select-uom').empty();
					$('#unit_price').val(0).attr({'value' : 0});
					$('#qoh').val(0).attr({'value' : 0});
				}
			},'json');
		}

		$('#add-item-btn').click(function(){
			$("#add_item_form").rOkay({
				btn_load		: 	$('#add-item-btn'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//if(typeof data.msg != 'undefined' ){
											//$('#po_id').val(data.id);
											// $('#details').rLoad({url:baseUrl+'branches/details_load/'+sel+'/'+res_id});
											//disEnbleTabs('.load-tab',true);
											rMsg(data.msg,'success');
											showItemsAdded(data.order_no);
											$('.forms').val('');
											// $('#quantity_ordered').val('');
											// $('#unit_price').val('');
											// $('#delivery_date').val('');
											$('#discount_percent').val('0');
											$('#discount_percent2').val('0');
											$('#discount_percent3').val('0');
											$('#qoh').val('0');
											// $('#client_code').val('');
										//}
									}
			});
			$('.input_form').val('').removeAttr('selected');
			$('input.combobox.this_item[type="text"]').focus();
			return false;
		});

		showItemsAdded($('#order_no').val());

		function showItemsAdded(order_no){
			alert('This Order No:'+order_no);
			$.post(baseUrl+'purchasing/get_items_added/'+order_no,function(data){
				alert(data.code);
				$('#load-table-items').html(data.code);

				$('.del-item').click(function(){
					ref = $(this).attr('ref');
					$.post(baseUrl+'purchasing/delete_item/'+ref,function(data){
						rMsg(data.msg,'warning');
						showItemsAdded(order_no);
					// });
					},'json');

				});

			// });
			},'json');
		}

		$('#discount_percent').blur(function(){
			if($(this).val() == 0 || $(this).val() == ''){
				$('#discount_percent2').val(0);
				$('#discount_percent3').val(0);
			}
		});

		$('#discount_percent2').blur(function(){
			if($(this).val() != 0){
				if($('#discount_percent').val() == 0 || $('#discount_percent').val() == ""){
					rMsg('Discount1 required.','warning');
					$(this).val(0);
				}

			}else{
				$('#discount_percent3').val(0);
			}
		});

		$('#discount_percent3').blur(function(){
			if($(this).val() != 0){

				if($('#discount_percent').val() == 0 || $('#discount_percent').val() == "" || $('#discount_percent2').val() == 0 || $('#discount_percent2').val() == ""){
					rMsg('Discount2 required.','warning');
					$(this).val(0);
				}

			}
		});

		setTimeout(function(){
			if ($('input.combobox.this_item[type="text"]').length) {
				$('input.combobox.this_item[type="text"]').focus();
			}
		},350);

	<?php elseif($use_js == 'poItemsJs_OLD'): ?>
		// alert($('#order_no').val());
		$('#item').change(function(){
			set_item_details($(this).val());
		});

		function set_item_details(id){
			$.post(baseUrl+'purchasing/get_item_details/'+id,function(data){
				$('#item-id').val(data.item_id);
				$('#item-uom').val(data.uom);

				if(id != ''){
					$('#unit_price').val(data.standard_cost);
					$('#qoh').val(data.qoh);
					$('#select-uom').find('option').remove();
					$.each(data.opts,function(key,val){
						$('#select-uom').append($("<option/>", {
					        value: val,
					        text: key
					    }));
					});

				}else{
					$('#select-uom').empty();
					$('#unit_price').val(0).attr({'value' : 0});
					$('#qoh').val(0).attr({'value' : 0});
				}
			},'json');
		}

		$('#add-item-btn').click(function(){
			$("#add_item_form").rOkay({
				btn_load		: 	$('#add-item-btn'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//if(typeof data.msg != 'undefined' ){
											//$('#po_id').val(data.id);
											// $('#details').rLoad({url:baseUrl+'branches/details_load/'+sel+'/'+res_id});
											//disEnbleTabs('.load-tab',true);
											rMsg(data.msg,'success');
											showItemsAdded(data.order_no);
											$('.forms').val('');
											// $('#quantity_ordered').val('');
											// $('#unit_price').val('');
											// $('#delivery_date').val('');
											$('#discount_percent').val('0');
											$('#discount_percent2').val('0');
											$('#discount_percent3').val('0');
											$('#qoh').val('0');
											// $('#client_code').val('');
										//}
									}
			});
			$('.input_form').val('').removeAttr('selected');
			$('input.combobox.this_item[type="text"]').focus();
			return false;
		});

		showItemsAdded($('#order_no').val());

		function showItemsAdded(order_no){
			$.post(baseUrl+'purchasing/get_items_added/'+order_no,function(data){

				$('#load-table-items').html(data.code);

				$('.del-item').click(function(){
					ref = $(this).attr('ref');
					$.post(baseUrl+'purchasing/delete_item/'+ref,function(data){
						rMsg(data.msg,'warning');
						showItemsAdded(order_no);
					// });
					},'json');

				});

			// });
			},'json');
		}

		$('#discount_percent').blur(function(){
			if($(this).val() == 0 || $(this).val() == ''){
				$('#discount_percent2').val(0);
				$('#discount_percent3').val(0);
			}
		});

		$('#discount_percent2').blur(function(){
			if($(this).val() != 0){
				if($('#discount_percent').val() == 0 || $('#discount_percent').val() == ""){
					rMsg('Discount1 required.','warning');
					$(this).val(0);
				}

			}else{
				$('#discount_percent3').val(0);
			}
		});

		$('#discount_percent3').blur(function(){
			if($(this).val() != 0){

				if($('#discount_percent').val() == 0 || $('#discount_percent').val() == "" || $('#discount_percent2').val() == 0 || $('#discount_percent2').val() == ""){
					rMsg('Discount2 required.','warning');
					$(this).val(0);
				}

			}
		});

		setTimeout(function(){
			if ($('input.combobox.this_item[type="text"]').length) {
				$('input.combobox.this_item[type="text"]').focus();
			}
		},350);

	<?php elseif($use_js == "purchOrderSearchJs") :?>
		$('input.daterangepicker').daterangepicker({separator:' to '});

		startLoad();

		function startLoad(){
			$.post(baseUrl+'purchasing/po_inquiry_results',function(data){

				$('#div-results').html(data);

				$('.close_po').click(function(){
					ref = $(this).attr('ref');
					$.post(baseUrl+'purchasing/purchase_order_close/'+ref,function(data){

						//alert(data);
						window.location = baseUrl+'purchasing/purch_outstanding';


					// });
					});
				});
			// });
			});
		}

		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#purch_order_search_form').rOkay(
			{
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
										// $('.data-table').bDestroy();
										$('#div-results').html(data);
										$('.close_po').click(function(){
											ref = $(this).attr('ref');
											$.post(baseUrl+'purchasing/purchase_order_close/'+ref,function(data){

												//alert(data);
												window.location = baseUrl+'purchasing/purch_outstanding';


											// });
											});
										});
									}
			});
		});

	/////////////Receive
	<?php elseif($use_js == 'purchaseOrderReceiveJS'): ?>
		loader('#details_link');
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var po_id = $('#po_id').val();

			if(po_id == ""){
				//alert('waaaa');
				disEnbleTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			}
			else{
				//alert('we');
				disEnbleTabs('.load-tab',true);
			}
			//alert(po_id);
			$(tabPane).rLoad({url:baseUrl+loadUrl+po_id});
		}
		function disEnbleTabs(id,enable){
			if(enable){
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			}
			else{
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}

		showItemsAdded($('#order_no').val());


		function showItemsAdded(order_no){
			$.post(baseUrl+'purchasing/get_items_received/'+order_no,function(data){

				$('#load-table-items').html(data.code);

				$('.t_delivery').blur(function(){

					val = Number($(this).val());
					ref = $(this).attr('ref');

					outstanding = $('#hid_outstanding_'+ref).val();

					if(val > outstanding){
						rMsg('Exceeded the outstanding','warning');
						$(this).val(outstanding);
					}else if(val < 0){
						rMsg('Cannot accept negative value','warning');
						$(this).val(outstanding);
					}
				});

				// $('#receive-items').click(function(){
				// 	date_delivered = $('#date_delivered').val();
				// 	into_stock_location = $('#into_stock_location').val();
				// 	form_mod_id = $('#form_mod_id').val();
				// 	str = 'date_delivered='+date_delivered+'&into_stock_location='+into_stock_location+'&form_mod_id='+form_mod_id;
				// 	$("#receive_form").rOkay({
				// 		btn_load		: 	$('#receive-items'),
				// 		bnt_load_remove	: 	true,
				// 		asJson			: 	false,
				// 		addData			:   str,
				// 		onComplete		:	function(data){
				// 									//alert(data);
				// 									// rMsg(data.msg,'success');
				// 									// showItemsAdded(data.order_no);
				// 									// $('.forms').val('');
				// 									window.location = baseUrl+'purchasing/purch_outstanding';

				// 							}
				// 	});

				// 	return false;
				// });


			// });
			},'json');
		}

		$('#receive-items').click(function(){
			date_delivered = $('#date_delivered').val();
			into_stock_location = $('#into_stock_location').val();
			form_mod_id = $('#form_mod_id').val();
			str = 'date_delivered='+date_delivered+'&into_stock_location='+into_stock_location+'&form_mod_id='+form_mod_id;
			$("#invoice_header_details_form").rOkay({
			// $("#invoice_header_details_form").rOkay({
				passTo			:   'purchasing/save_receive',
				btn_load		: 	$('#receive-items'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				addData			:   str,
				onComplete		:	function(data){
											//alert(data);
											// rMsg(data.msg,'success');
											// showItemsAdded(data.order_no);
											// $('.forms').val('');
											window.location = baseUrl+'purchasing/purch_outstanding';

									}
			});

			return false;
		});

		$('#receive-and-invoice').click(function(){
			//alert('we');
			// date_delivered = $('#date_delivered').val();
			// into_stock_location = $('#into_stock_location').val();
			// form_mod_id = $('#form_mod_id').val();
			// str = 'date_delivered='+date_delivered+'&into_stock_location='+into_stock_location+'&form_mod_id='+form_mod_id;
			if($('#inv_reference').val() == ''){
				rMsg('Invoice Reference No. must not be empty.','error');
				$('#inv_reference').focus();
			}else{


				$("#invoice_header_details_form").rOkay({
					passTo			:   'purchasing/save_receive_and_invoice',
					btn_load		: 	$('#receive-and-invoice'),
					bnt_load_remove	: 	true,
					asJson			: 	false,
					onComplete		:	function(data){
												//alert(data);
												// rMsg(data.msg,'success');
												// showItemsAdded(data.order_no);
												// $('.forms').val('');
												window.location = baseUrl+'purchasing/purch_outstanding';

										}
				});

			}

			return false;
		});
	<?php elseif($use_js == 'poItemsReceiveJs'): ?>
		showItemsAdded($('#order_no').val());


		function showItemsAdded(order_no){
			$.post(baseUrl+'purchasing/get_items_received/'+order_no,function(data){

				$('#load-table-items').html(data.code);

				$('.t_delivery').blur(function(){

					val = Number($(this).val());
					ref = $(this).attr('ref');

					outstanding = $('#hid_outstanding_'+ref).val();

					if(val > outstanding){
						rMsg('Exceeded the outstanding','warning');
						$(this).val(outstanding);
					}else if(val < 0){
						rMsg('Cannot accept negative value','warning');
						$(this).val(outstanding);
					}
				});

				$('#receive-items').click(function(){
					date_delivered = $('#date_delivered').val();
					into_stock_location = $('#into_stock_location').val();
					form_mod_id = $('#form_mod_id').val();
					str = 'date_delivered='+date_delivered+'&into_stock_location='+into_stock_location+'&form_mod_id='+form_mod_id;
					$("#receive_form").rOkay({
						btn_load		: 	$('#receive-items'),
						bnt_load_remove	: 	true,
						asJson			: 	false,
						addData			:   str,
						onComplete		:	function(data){
													//alert(data);
													// rMsg(data.msg,'success');
													// showItemsAdded(data.order_no);
													// $('.forms').val('');
													window.location = baseUrl+'purchasing/purch_outstanding';

											}
					});

					return false;
				});


			// });
			},'json');
		}

	///////////////////Inquiry////////////////////////
	//////////////////////////////////////////////////
	<?php elseif($use_js == "purchOrderInquirySearchJs") :?>
		$('input.daterangepicker').daterangepicker({separator:' to '});

		startLoad();

		function startLoad(){
			$.post(baseUrl+'purchasing/po_inquiry_detail_results',function(data){

				$('#div-results').html(data);

				$('.close_po').click(function(){
					ref = $(this).attr('ref');
					$.post(baseUrl+'purchasing/purchase_order_close/'+ref,function(data){

						//alert(data);
						window.location = baseUrl+'purchasing/purch_outstanding';


					// });
					});
				});
			// });
			});
		}

		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#purch_order_search_form').rOkay(
			{
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
										// $('.data-table').bDestroy();
										$('#div-results').html(data);
										$('.close_po').click(function(){
											ref = $(this).attr('ref');
											$.post(baseUrl+'purchasing/purchase_order_close/'+ref,function(data){

												//alert(data);
												window.location = baseUrl+'purchasing/purch_outstanding';


											// });
											});
										});
									}
			});
		});
	<?php elseif($use_js == 'purchOrderInquiryResultJs'): ?>
		$('.dwn-btn').on('click',function(event)
		{
			event.preventDefault();

			var $target = $(this).attr('href');
			var $icon   = $(this).attr('icon');

			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_INFO,
				title: 'RESOURCE PERSONS',
	            message: function(dialog) {
	            	var $message = $('<div></div>');
	            	var pageToLoad = dialog.getData('pageToLoad');
	            	$message.load(pageToLoad);

	            	return $message;
	            },
	            data: {
	            	'pageToLoad': baseUrl+'purchasing/po_resource_person'
	            },
	            buttons: [
	            	{
	            		icon: $icon,
	            		label: ' Download',
	            		cssClass: 'btn-lg btn-success',
	            		action: function(thisDialog)
	            		{
	            			var $button = this;
	            			$('#frm-reso-p').attr('action',$target);
	            			$('#frm-reso-p').submit();
	            			thisDialog.close();
	            		}
	            	},
	            	{
	            		label: 'Cancel',
	            		cssClass: 'btn-lg',
	            		action: function (thisDialog)
	            		{
	            			thisDialog.close();
	            		}
	            	}
	            ]
	        });
		});
	<?php elseif($use_js == 'purchaseOrderHeaderInquiryJS'): ?>
		loader('#details_link');
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var po_id = $('#po_id').val();

			if(po_id == ""){
				//alert('waaaa');
				disEnbleTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			}
			else{
				//alert('we');
				disEnbleTabs('.load-tab',true);
			}
			//alert(po_id);
			$(tabPane).rLoad({url:baseUrl+loadUrl+po_id});
		}
		function disEnbleTabs(id,enable){
			if(enable){
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			}
			else{
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}

	<?php elseif($use_js == 'poItemsInquiryJs'): ?>

		showItemsAdded($('#order_no').val());

		function showItemsAdded(order_no){
			$.post(baseUrl+'purchasing/get_po_items_inquiry/'+order_no,function(data){

				$('#load-table-items').html(data.code);

			// });
			},'json');
		}

	/////////////////////supp invoice
	<?php elseif($use_js == 'suppInvoiceJS'): ?>
		loader('#details_link');

		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});

		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			//var po_id = $('#po_id').val();
			// alert(btn);
			// if(po_id == ""){
			// 	//alert('waaaa');
			// 	disEnbleTabs('.load-tab',false);
			// 	$('.tab-pane').removeClass('active');
			// 	$('.tab_link').parent().removeClass('active');
			// 	$('#details').addClass('active');
			// 	$('#details_link').parent().addClass('active');
			// }
			// else{
			// 	//alert('we');
			// 	disEnbleTabs('.load-tab',true);
			// }
			//alert(po_id);
			$(tabPane).rLoad({url:baseUrl+loadUrl});
		}

		$('#added_link').click(function(){
			$('#added').rLoad({url:baseUrl+'purchasing/view_suppinv_added/'});
		});

		$('#invoice-btn').on('click',function(event)
		{
			event.preventDefault();
			$('#supp_inv_form').rOkay(
			{
				btn_load		: 	$('#invoice-btn'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				checkCart		:   'suppinv_sess',
				onComplete		:	function(data){
										window.location = baseUrl+'purchasing/supplier_invoices';
										// $('.data-table').bDestroy();
										//alert(data);
									}
			});
		});

	<?php elseif($use_js == 'suppItemsJS'): ?>

		$('.toinvoice').blur(function(){
			val = $(this).val();
			ref = $(this).attr('ref');

			to_inv = Number($('#hid_tinvoice_'+ref).val());
			//alert(to_inv);
			if(val > to_inv){
				rMsg('Excceded the Qty yet to invoice','warning');
				$(this).val(to_inv);
			}else if(val < 0){
				rMsg('Cannot accept negative value','warning');
				$(this).val(to_inv);
			}
		});

		$('.add-item').click(function(event){
			ref = $(this).attr('ref');
			poref = $(this).attr('po-ref');
			linetotal = $(this).attr('line-total');
			val = $('#toinv-'+ref).val();
			inv = $('.hid-inv-'+ref).val();
			//alert(inv);
			var formData = 'ref='+ref+'&val='+val+'&poref='+poref+'&inv='+inv+'&linetotal='+linetotal;

			$.post(baseUrl+'purchasing/supp_invoice_session',formData,function(data){

				// $('#div-results').html(data);
				//alert(data);
				rMsg('Added to Invoice Sheet.','success');
				$('#deliv-row-'+ref).hide();
				$('#added').rLoad({url:baseUrl+'purchasing/view_suppinv_added/'});

			// });
			});


			//$('#totalspan').text('aaaa');

			event.preventDefault();
		});

	<?php elseif($use_js == 'suppAddedJS'): ?>

		$('.edit-item').click(function(event){
			ref = $(this).attr('ref');
			var formData = 'ref='+ref;
			$.post(baseUrl+'purchasing/remove_invoice_session',formData,function(data){

				rMsg('Remove from Invoice Sheet.','success');
				$('#deliv-row-'+ref).show();
				$('#added-row-'+ref).hide();

			// });
			});


		});

	///////////////////////supp payment///////////////////////
	<?php elseif($use_js == 'suppPaymentHeaderJS'): ?>
		$('input.daterangepicker').daterangepicker({separator:' to '});

		loader('#details_link');
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var so_id = $('#so_id').val();

			// if(so_id == ""){
			// 	disEnbleTabs('.load-tab',false);
			// 	$('.tab-pane').removeClass('active');
			// 	$('.tab_link').parent().removeClass('active');
			// 	$('#details').addClass('active');
			// 	$('#details_link').parent().addClass('active');
			// }
			// else{
			// 	disEnbleTabs('.load-tab',true);
			// }
			$(tabPane).rLoad({url:baseUrl+loadUrl+so_id});
		}

		$('#btn-search').click(function(event){
			event.preventDefault();
			$('#supp_alloc_search_form').rOkay(
			{
				btn_load		: 	$('#btn-search'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
										// $('.data-table').bDestroy();
										$('#div-results-view').html(data);
										// $('.close_po').click(function(){
										// 	ref = $(this).attr('ref');
										// 	$.post(baseUrl+'purchasing/purchase_order_close/'+ref,function(data){

										// 		//alert(data);
										// 		window.location = baseUrl+'purchasing/purch_outstanding';


										// 	// });
										// 	});
										// });
									}
			});
		});

		$("#show_settled").click(function(){

			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);

		});

	<?php elseif($use_js == 'spHeaderDetailsLoadJs'): ?>
		// $('#div-results').html('waaaaaaaaaaa');

		$('#save-payment').on('click',function(event)
		{
			event.preventDefault();
			$('#supp_payment_form').rOkay(
			{
				btn_load		: 	$('#save-payment'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
										window.location.reload();
										// $('.data-table').bDestroy();
										//alert(data);
									}
			});
		});

		function load_supp_allocation(){
			$.post(baseUrl+'purchasing/supp_allocation_results',function(data){

				$('#div-results').html(data);

				// $('.close_po').click(function(){
				// 	ref = $(this).attr('ref');
				// 	$.post(baseUrl+'purchasing/purchase_order_close/'+ref,function(data){

				// 		//alert(data);
				// 		window.location = baseUrl+'purchasing/purch_outstanding';


				// 	// });
				// 	});
				// });
			// });
			});
		}

	<?php elseif($use_js == 'allocationJS'): ?>

		$('.allocate').blur(function(){

			input = Number($(this).val());
			ref = $(this).attr('ref');
			balance = Number($('#hid_bal_'+ref).val());

			left_text = Number($('#hid_left_alloc_changing').val());
			left_allocated = Number($('#hid_left_alloc').val());

			if(balance > left_text){
				t_val = 0;
				$('.allocate').each(function(){
					val = $(this).val();

					t_val = Number(t_val) + Number(val);
				});

				if(t_val > left_allocated){
					rMsg('Not enough allocation amount to allocate','warning');
					$(this).val('0.00');
				}
			}else{
				if(input > balance){
					rMsg('Allocation exceeds the balance to be paid','warning');
					$(this).val('0.00');
				}
			}

			compute();

		});

		function compute(){
			t_val = 0;
			$('.allocate').each(function(){
				val = $(this).val();

				t_val = Number(t_val) + Number(val);
			});

			current_alloc = $('#hid_allocated').val();
			left_allocated = $('#hid_left_alloc').val();

			allocated = Number(t_val) + Number(current_alloc);

			left_alloc = Number(left_allocated) - Number(t_val);
			//delivery_total.toFixed(2).number_format();
			$('#span_allocated').text(allocated.toFixed(2).number_format());
			$('#span_left_allocated').text(left_alloc.toFixed(2).number_format());
			$('#hid_left_alloc_changing').val(left_alloc);
		}

		$('#process-alloc').on('click',function(event)
		{
			//alert('wwwwwwww');
			event.preventDefault();
			$('#allocation_form').rOkay(
			{
				btn_load		: 	$('#process-alloc'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
										// window.location.reload();
										//alert(data)
										// $('.data-table').bDestroy();
										//alert(data);
										window.location = baseUrl+'purchasing/supplier_payments_inq';
									}
			});
		});

	<?php elseif($use_js == "creditnoteInquirySearchJs") :?>
		$('input.daterangepicker').daterangepicker({separator:' to '});

		// startLoad();

		// function startLoad(){
		// 	$.post(baseUrl+'purchasing/po_inquiry_detail_results',function(data){

		// 		$('#div-results').html(data);

		// 		$('.close_po').click(function(){
		// 			ref = $(this).attr('ref');
		// 			$.post(baseUrl+'purchasing/purchase_order_close/'+ref,function(data){

		// 				//alert(data);
		// 				window.location = baseUrl+'purchasing/purch_outstanding';


		// 			// });
		// 			});
		// 		});
		// 	// });
		// 	});
		// }

		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#credit_note_search_form').rOkay(
			{
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
										// $('.data-table').bDestroy();
										$('#div-results').html(data);
										// $('.close_po').click(function(){
										// 	ref = $(this).attr('ref');
										// 	$.post(baseUrl+'purchasing/purchase_order_close/'+ref,function(data){

										// 		//alert(data);
										// 		window.location = baseUrl+'purchasing/purch_outstanding';


										// 	// });
										// 	});
										// });
									}
			});
		});

	<?php elseif($use_js == 'creditNoteJS'): ?>
		loader('#details_link');

		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});

		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			//var po_id = $('#po_id').val();
			// alert(btn);
			// if(po_id == ""){
			// 	//alert('waaaa');
			// 	disEnbleTabs('.load-tab',false);
			// 	$('.tab-pane').removeClass('active');
			// 	$('.tab_link').parent().removeClass('active');
			// 	$('#details').addClass('active');
			// 	$('#details_link').parent().addClass('active');
			// }
			// else{
			// 	//alert('we');
			// 	disEnbleTabs('.load-tab',true);
			// }
			//alert(po_id);
			$(tabPane).rLoad({url:baseUrl+loadUrl});
		}

		$('#added_link').click(function(){
			$('#added').rLoad({url:baseUrl+'purchasing/view_return_added/'});
		});

	<?php elseif($use_js == 'creditItemsJS'): ?>
		$('.edit-item').click(function(event){
			ref = $(this).attr('ref');
			var formData = 'ref='+ref;
			$.post(baseUrl+'purchasing/remove_creditnote_session',formData,function(data){

				rMsg('Remove from Return Sheet.','success');
				$('#forreturn-row-'+ref).show();
				$('#added-row-'+ref).hide();

			// });
			});


		});


	<?php elseif($use_js == 'creditnoteHeadJS'): ?>
		$('.return-item').click(function(event){

			ref = $(this).attr('ref');
			deliv_id = $(this).attr('delivery_id');
			inv_transno = $(this).attr('invoice_transno');
			item_id = $(this).attr('item_id');
			val = $('#toreturn-'+ref).val();
			// inv = $('.hid-inv-'+ref).val();
			// //alert(inv);
			var formData = 'ref='+ref+'&val='+val+'&inv_transno='+inv_transno+'&deliv_id='+deliv_id+'&item_id='+item_id;
			//alert(formData);
			$.post(baseUrl+'purchasing/credit_note_session',formData,function(data){

				// $('#div-results').html(data);
				//alert(data);
				rMsg('Added to Return Sheet.','success');
				$('#forreturn-row-'+ref).hide();
				$('#added').rLoad({url:baseUrl+'purchasing/view_return_added/'});

			// });
			});


			//$('#totalspan').text('aaaa');

			event.preventDefault();
		});

		$('.t_return').blur(function(){
			val = $(this).val();
			invoiced = Number($(this).attr('invoiced'));

			// to_inv = Number($('#hid_tinvoice_'+ref).val());
			//alert(to_inv);
			if(val > invoiced){
				rMsg('Excceded the Qty invoiced','warning');
				$(this).val(invoiced);
			}else if(val < 0){
				rMsg('Cannot accept negative value','warning');
				$(this).val(invoiced);
			}
		});

		$('#btn-credit-note').on('click',function(event)
		{
			event.preventDefault();
			// alert('asfdsaf');
			$('#credit_note_form').rOkay(
			{
				btn_load		: 	$('#btn-credit-note'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				checkCart		:   'return_sess',
				onComplete		:	function(data){
										window.location = baseUrl+'purchasing/supp_creditnote_inquiry';
										// $('.data-table').bDestroy();
										//alert(data);
									}
			});
		});


		// $('#supplier_id').change(function(){
		// 	sup_id = $(this).val();

		// 	$.post(baseUrl+'purchasing/load_invoice_drop/'+sup_id,function(data){

		// 		$('#invoices').html(data.code);

		// 		$('#supp_invoice').change(function(){
		// 			alert('aw');
		// 		})


		// 	},'json');
		// })


	<?php endif; ?>
});
</script>