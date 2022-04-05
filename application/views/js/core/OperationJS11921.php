<script>
	$(document).ready(function(){

		$('.left-side').addClass("collapse-left");
        $(".right-side").addClass("strech");

		
		Array.prototype.associate = function (keys) {
		  var result = {};

		  this.forEach(function (el, i) {
		    result[keys[i]] = el;
		  });

		  return result;
		};

		
		
		$('#btn_search').click(function(){
		 
		 var category = $('#category').val();
		 var supplier = $('#supplier').val();

			var dtr_url = '<?php echo base_url(); ?>operation/negative_inventory_reload';
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			$.ajax({
				type:"POST",
				url: dtr_url,
				data: {category:category,supplier:supplier},
				cache:false,
				beforeSend:function(){

					$("#details-tbl").find('tr td').remove();
					$("#details-tbl").empty();
					$("#details-tbl").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');
					
				},
				success:function(data){
					if (data) {
						$('.left-side').toggleClass("collapse-left");
        				$(".right-side").toggleClass("strech");

						$('#asset_list_data').html(data);
					}else{
						$('#asset_list_data').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
					}

				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
			});	
		});	

		$('#printinventory').click(function(e){
			e.preventDefault();

			var category = $('#category').val(); 
			//alert(category);
			var supplier = $('#supplier').val(); 
			
				//var this_url = '<?php echo base_url() ?>operation/negative_inventory_excel';
				//var formData = $('#neg_item_list').serialize();

				var this_url =  baseUrl+'operation/negative_inventory_excel?category='+category+'&supplier='+supplier;
		   		window.location = this_url;
				//window.location = this_url+'?'+formData;
		});

		$('.update_link').click(function(){	

			var product_id = $(this).attr('product_id');	
			var id = $(this).attr('id');	
			bootbox.dialog({
				className: "bootbox-wide",
				message: baseUrl+'operation/item_adjusment/'+id,
				title: "Item Adjustment",
				modal:'hide'

			});
			dialog.init(function(){
			    setTimeout(function(){
			        dialog.find('.bootbox-body').html('');
			    }, 3000);
			})

			return false;
		});
		
	$('.qty').change(function(){

			var id = $(this).attr('id');
			var val =id.split("_");
			var ref = val[1];
			var neg_qty = $('#neg_qty_'+ref).val();
			var qty = $('#qty_'+ref).val();
			var ad_qty = $('#ad_qty_'+ref).val();
			var cost = $('#cost_'+ref).val();
			var prod_code = $('#prod_code_'+ref).val();
			var prod_url =  '<?php echo base_url(); ?>operation/get_prod_uom/'+prod_code;
			var k = 0;
			var total = 0;

			if (cost == '') {
				cost = 0;
			}else{
				cost = $('#cost_'+ref).val();
			}

			if(qty !==''){
				var total_ad =parseFloat(-qty) + parseFloat(neg_qty) ;
				var subtotal =parseFloat(neg_qty) * parseFloat(cost) ;
				$('#ad_qty_'+ref).val(Math.abs(total_ad));
				$('#unit_cost_'+ref).val(Math.abs(subtotal));

			}else{
				$('#ad_qty_'+ref).val(Math.abs(total_ad));
				$('#unit_cost_'+ref).val(Math.abs(subtotal));
			}

			$('.adjustment_qty').each(function(){
		 	  k++;
		 	  u_cost = $(this).val();
		 	  total+=parseFloat(u_cost) ||0;
			});
			$('#total').val(total.toFixed(4));

			$.ajax({
				type:"GET",
				url: prod_url,
				cache:false,
				success: function(result){
					//alert(result);
					var obj =$.parseJSON(result);
					//alert(obj[0].uom);
					//alert(obj[0].qty);
					$('#unit_'+ref).val(obj[0].uom);
					$('#uom_qty_'+ref).val(obj[0].qty);

					// alert("Ad Qty: "+$('#ad_qty_'+ref).val());
				 // alert("Unit: "+$('#unit_'+ref).val()); 
				 //  alert("Unit Cost: "+$('#unit_cost_'+ref).val());
				 //  alert("UOM Qty: "+$('#uom_qty_'+ref).val());
					
				}
			});

				

		});



		$('#add_item_adjustment').click(function(){


			
			var total = $('#total').val();
			var trans_num = $('#trans_num').val();
			var remarks = $('#remarks').val();
			var date_adjustment = $('#date_adjustment').val();
			
			var num_count = $(".qty_edit").each(function(){
		 	  return $(this).val();
			}).length;

			var alldata = new Array();
			var data = [];

			for(var i =1; i<= num_count;i++){

				if($('#ad_qty_'+i).val()!='' && $('#unit_'+i).val()!='' && $('#unit_cost_'+i).val()!='' && $('#uom_qty_'+i).val()!=''){

					 data = [$('#ad_qty_'+i).val(),
					 		 $('#cost_'+i).val(),
					 		 $('#uom_qty_'+i).val(),
					 		 $('#unit_'+i).val(),
					 		 $('#unit_cost_'+i).val(),
					 		 $('#prod_id_'+i).val()];
					 alldata.push(data);
				}
			}

			var post_url = baseUrl+'operation/add_adjustment_header';

			if(alldata.length > 0){
				//alert(alldata);
				$.post(post_url, {trans_num:trans_num,date_adjustment:date_adjustment,total:total,remarks:remarks,alldata:alldata}, function(data){
					//alert(data);
					setTimeout(function(){ location.reload(); }, 100000);
				});
					rMsg('Inventory Adjustment has been added','success');		

			}else{
				rMsg('Oops. Empty Record Try again','error');	
			}

			
		
		});

		$('#update_adjustment').click(function(){

			var trans_num = $('#trans_num').val();
			var date_adjustment = $('#date_adjustment').val();
			var product_id = $('#product_id').val();
			var qty = $('#qty').val();
			var uom_qty = $('#uom_qty').val();
			var unit = $('#unit').val();
			var cost = $('#cost').val();
			var unit_cost = $('#unit_cost').val();
			var total = $('#total').val();
			var remarks = $('#remarks').val();
			
			var url = '<?php echo base_url(); ?>operation/add_stock_moves';
			$.ajax({
				type:"POST",
				data:{trans_num:trans_num,date_adjustment:date_adjustment,product_id:product_id,qty:qty,uom_qty:uom_qty,unit:unit,unit_cost:unit_cost,total:total,cost:cost,remarks:remarks},
				url:url,
				cache:false,
				success:function(data){
					if (data != 'false' && data != '') {
						rMsg('Successfully ADD','success');
						setTimeout(function(){ location.reload(); }, 50000);
					}else{
						
						rMsg('Data not Successfully ','error');
						setTimeout(function(){ location.reload(); }, 50000);
					}

				},error:function(){

						rMsg('Contact IS Department','error');
						setTimeout(function(){ location.reload(); }, 50000);
					
				}
			});
		});

		//delete all -Van
		$('#btn_delete_all').unbind('click').click(function(e){
			e.preventDefault();
	
			var items = $('#tblprod').html();
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var dtr_url2 = '<?php echo base_url(); ?>operation/delete_all_cc'; 

			items = $.trim(items);
			if(items != ""){
			
				$.ajax({
				type:"POST",
				url: dtr_url2,
				data: {},
				cache:false,
				beforeSend:function(){
					return confirm("Are you sure yo want to delete all?");					
				},
				success:function(data){

					$('#myModaldel').modal('hide');
					$.alert('&nbsp;', {
						title: 'Items Successfully Deleted',
						type: 'success',
						position: ['top-right'],
					});
					$('.left-side').toggleClass("collapse-left");
       				$(".right-side").toggleClass("strech");
					//$("#delcc_form")[0].reset();
					show_cc();
				},
				error:function(){
					$.alert('Item not successfully deleted!', {
						type: 'danger',
						position: ['top-right', [-0.42, 0]],
					});
				},
				
				});
			
			}else{
				//rMsg('Oops. Empty Record Try again','error');	
			}
			
		});

		$('.btn_del').click(function(){
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>operation/delete_adjustment/'+id;
			var page_url = '<?php echo base_url(); ?>operation/adjustment_inquiry';
			$.ajax({
				type:'GET',
				url:url,
				cache:false,
				success:function(){

					rMsg('Data deleted','success');
					window.location = page_url;			
				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
			});
		});
		

		$('.history_link').click(function(){	
			var id = $(this).attr('id');	
			bootbox.dialog({
				className: "bootbox-wide",
				message: baseUrl+'operation/adjustment_history_view/'+id,
				title: "Adjustment Details",
				buttons: {
					cancel: {
						label: "Close",
						className: "btn-default",
						callback: function() {
						}
					}
				}
			});
			$(this).dialog('close').empty();
			return false;
		});


		<?php if($use_js == 'usersJs'): ?>
		$('.left-side').toggleClass("collapse-left");
        $(".right-side").toggleClass("strech");

		var mode = $('#mode').val();
		$('#code').focus();
		
		$('#save-btn').click(function(){
			$("#users_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//alert(data);
										// rMsg(data.msg,'success');
										if(data.status == 'warning'){
											rMsg(data.msg, 'warning');
											$('#code').focus();
										}else{
											rMsg(data.msg, 'success');
										}
									}
			});

	
			return false;
			});	

		
		<?php elseif($use_js == 'Dashboard'): ?>
	
			$('.left-side').addClass("collapse-left");
     	   $(".right-side").addClass("strech");


			<?php elseif($use_js == 'Recount'): ?>


			 $("#r_txtrecprod").on("keyup", function() {
			    var value = $(this).val().toLowerCase();
			    $("#r_tblautoprod tr").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
			  });


			$('#r_btn-export').unbind('click').click(function(){

	//$('#print_excel_btn').click(function(){
			//var date = $('#r_date_').val();
			var date = $('#date_adjustment').val();
			//alert(date);
			var find = '/';
			var re = new RegExp(find, 'g');
			date = date.replace(re, '-');
			var this_url =  baseUrl+'operation/print_recount/'+date;
		   	window.location = this_url;
			return false;
		//});


			//var id = $('#infoid').val();
			// var dtr_url2 = '<?php echo base_url(); ?>operation/r_action'; 
			// $.ajax({
			// 	type:'POST',
			// 	url:dtr_url2,
			// 	cache:false,
			// 	success:function(data){

			// 			$('#r_myModalviewdl').modal('show');
				
			// 	},
			// 	error:function(){
			// 		//alert(data);
			// 		rMsg('Oops. Somethings wrong. Contact IS Department','error');
			// 	}
			// });
		});

			$('#pass').unbind('keyup');
			$("#pass").keyup(function(event){
				    if(event.keyCode == 13){
				        $("#confirm-certify").click();
				    }
				});

			$('#r_confirm-certify').unbind('click').click(function(){
			var user = $('#user').val();
			var pass = $('#pass').val();
			var id_cc = $('#prodid_cc').val();
			var ref = $('#prod_ref').val();
			var cert = $('#needtocertify_'+ref).val();

			//alert(cert + " : "+ref)

			var dtr_url2 = '<?php echo base_url(); ?>operation/certify'; 
			$.ajax({
				type:'POST',
				url:dtr_url2,
				data: {user:user,pass:pass},
				cache:false,
				success:function(data){

					var myObj = JSON.parse(data);
					//alert(myObj.msg);
					if(myObj.msg == "error")
					{
						 $.alert('&nbsp;', {
							title: 'Error Login!',
							type: 'danger',
							position: ['top-right'],
							});
							 $('#needtocertify_'+ref).val("1");
							$('#user').val("");
							$('#pass').val("");	

					}
					else 
					{		
						 $.alert('&nbsp', {
							title: 'Item Certified',
							type: 'success',
							position: ['top-right'],
							});
							$('#needtocertify_'+ref).val("0");
							$('span#warning_'+ref).empty();		

							$('#user').val("");
							$('#pass').val("");
							$('#r_myModalcert').modal('hide');					
					}				
					
				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
			});
		});


				$("#r_auto_form").unbind('submit').submit(function(e) {
			// e.preventDefault();
			e.preventDefault();

			var err;
			var total2 = 0;
			var total = $('#total').val();
			var trans_num = $('#trans_num').val();
			var remarks = $('#remarks').val();
			var date_adjustment = $('#date_adjustment').val();
			//var infoid = $('#infoid').val();
			//alert(infoid);
			var num_count = $(".qty_edit").each(function(){
		 	  return $(this).val();
			}).length;
			//alert("Num:"+num_count);
			var alldata = new Array(); //IGSA
			var alldata2 = new Array(); //IGNSA
			var data = [];
			var data2 = [];
			var totalcert = 0;
			var adqty = 0;
			var unit = 0;
			var unitcost = 0;
			var uom = 0;
			var cert = 0;
			var needtocert = 0;
			var desc = "<br>";
			var movcode="";
			//alert(trans_num);

			for(var i =1; i<= num_count;i++){
				adqty = $('#ad_qty2_'+i).val();
				unit = $('#unit_'+i).val();
				unitcost = $('#unit_cost2_'+i).val();
				uomqty = $('#uom_qty2_'+i).val();
				des =$('#prod_desc_'+i).val();
				cert =$('#needtocertify_'+i).val();
				movcode =$('#movcode_'+i).val();
				//alert(uomqty);
				if(cert == 1)
				{
					desc = desc + des + "<br>";
					needtocert = 1;
				}
				//alert(cert);
				if($('#rcqty_'+i).val()!='')
				{
					if($('#ad_qty2_'+i).val()!='' && $('#unit_'+i).val()!='' && $('#unit_cost2_'+i).val()!='' && $('#uom_qty2_'+i).val()!=''){
						//alert()
						totalcert = $('#ad_qty2_'+i).val() * $('#unit_cost2_'+i).val();
						
						if(totalcert < 1000)
						{
							if(movcode == "IGSA")
							{
								data = [$('#ad_qty2_'+i).val(),
						 		 $('#cost_'+i).val(),
						 		 $('#uom_qty2_'+i).val(),
						 		 $('#unit_'+i).val(),
						 		 $('#unit_cost2_'+i).val(),
						 		 $('#prod_id_'+i).val(),
						 		// $('#movcode_'+i).val(),
						 		 totalcert];
						 		 total2 = total2 + $('#ad_qty2_'+i).val()
						 		 
						 	alldata.push(data);
						 	}
						 	else
						 	{
						 		data2 = [$('#ad_qty2_'+i).val(),
						 		 $('#cost_'+i).val(),
						 		 $('#uom_qty2_'+i).val(),
						 		 $('#unit_'+i).val(),
						 		 $('#unit_cost2_'+i).val(),
						 		 $('#prod_id_'+i).val(),
						 		 //$('#movcode_'+i).val(),
						 		 totalcert];
						 		 total2 = total2 + $('#ad_qty2_'+i).val()
						 		 
						 		alldata2.push(data2);
						 	}
						}
						else
						{

							if(cert == 0)
							{
								if(movcode == "IGSA")
								{
									data = [$('#ad_qty2_'+i).val(),
							 		 $('#cost_'+i).val(),
							 		 $('#uom_qty2_'+i).val(),
							 		 $('#unit_'+i).val(),
							 		 $('#unit_cost2_'+i).val(),
							 		 $('#prod_id_'+i).val(),
							 		 totalcert];
							 		 total2 = total2 + $('#ad_qty2_'+i).val()
							 		 
							 		alldata.push(data);
						 		}
						 		else
						 		{
						 			data2 = [$('#ad_qty2_'+i).val(),
							 		 $('#cost_'+i).val(),
							 		 $('#uom_qty2_'+i).val(),
							 		 $('#unit_'+i).val(),
							 		 $('#unit_cost2_'+i).val(),
							 		 $('#prod_id_'+i).val(),
							 		// $('#movcode_'+i).val(),
							 		 totalcert];
							 		 total2 = total2 + $('#ad_qty2_'+i).val()
							 		 
							 		alldata2.push(data2);
						 		}	
							}
							else
							{
							}
						}
						
					
					}
				}
			}

			if(needtocert >= 1)
			{
				$.alert(desc, {
				title: 'Please certify item to proceed!',
				type: 'danger',
				position: ['top-right'],
				});

			}
			else
			{	
				//alert(total2);
				//alert(alldata);
				//alert(alldata2);
				//var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
				//alert(alldata.length);
				var post_url = baseUrl+'operation/add_adjustment_headerrecount/';
				var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
				if(alldata.length > 0 || alldata2.length > 0){
					//alert(trans_num)
					$.post(post_url, 
						{trans_num:trans_num,date_adjustment:date_adjustment,total:total2,remarks:remarks,alldata:alldata,alldata2:alldata2}, 
						function(data){
							var myObj = JSON.parse(data);
							//alert(myObj.msg);
							if(myObj.msg == "duplicate")
							{
								 $.alert('&nbsp;', {
									title: 'Adjustment Header already saved for today!',
									type: 'warning',
									position: ['top-right'],
									});
							}
							if(myObj.msg == "success")
							{
								 $.alert('&nbsp'+img, {
									title: 'Inventory Adjustment has been saved!',
									type: 'success',
									position: ['top-right'],
									});
							
									show_recount();
							}
							if(myObj.msg == "error")
							{
								 $.alert('&nbsp;', {
									title: 'Error Saving!',
									type: 'danger',
									position: ['top-right'],
									});
							
								//	show_cc();
							}
						setTimeout(function(){ location.reload(); }, 1500);
					});

				}else{
					$.alert('&nbsp;', {
							title: 'Oops. Empty Record Try again',
							type: 'danger',
							position: ['top-right'],
						});
				
				}
			}
		});

		
			$('.rcqty').unbind('input').on('input',function(e){
			e.preventDefault();

			
			
			var id = $(this).attr('id');
			var val =id.split("_");
			var ref = val[1];
			var pid = $('#prod_id_'+ref).val();
			var neg_qty = $('#neg_qty_'+ref).val();
			var qty = $('#rcqty_'+ref).val();
			var ad_qty = $('#ad_qty2_'+ref).val();
			var qtyuom = $('#qtyuom_'+ref).val();
			var cost = $('#cost_'+ref).val();
			var prod_code = $('#prod_code_'+ref).val();
			var desc = $('#prod_desc_'+ref).val();
			//alert(qty+'*'+qtyuom+'='+qty*qtyuom);
			var holder1 = qty*qtyuom;
			var bagoadjqty = holder1 - neg_qty;
			var movcode="";
			if(bagoadjqty > 0)
			{
				movcode = "IGSA";
			}
			else
			{
				movcode = "IGNSA";
			}
			$('#movcode_'+ref).val(movcode);
			$('#mc_'+ref).val(movcode);
			//alert(bagoadjqty);
			//alert(prod_code);
			var prod_url =  '<?php echo base_url(); ?>operation/get_prod_uom2/'+prod_code;
			var k = 0;
			var total = 0;
			var need = $('#needtocertify_'+ref).val();


			if (cost == '') {
				cost = 0;
			}else{
				cost = $('#cost_'+ref).val();
			}


			if(qty !==''){
				var total_ad =parseFloat(-qty) + parseFloat(neg_qty) ;
				//var subtotal =parseFloat(neg_qty) * parseFloat(cost) ;
				//var bago =parseFloat(qtyuom) * parseFloat(qty);
				var subtotal =parseFloat(bagoadjqty) * parseFloat(cost);
				$('#ad_qty2_'+ref).val(Math.abs(bagoadjqty));
				$('#unit_cost2_'+ref).val(Math.abs(subtotal));

			}else{
				$('#ad_qty2_'+ref).val(Math.abs(bagoadjqty));
				$('#unit_cost2_'+ref).val(Math.abs(subtotal));
				$('#needtocertify_'+ref).val("0");
			}
			//alert(subtotal);
			$('.adjustment_qty').each(function(){
		 	  k++;
		 	  u_cost = $(this).val();
		 	  total+=parseFloat(u_cost) ||0;
			});
			$('#total').val(total.toFixed(4));

			var tot = $('#ad_qty2_'+ref).val() * $('#unit_cost2_'+ref).val();
			//alert(tot);
			$.ajax({
				type:"GET",
				url: prod_url,
				cache:false,
				success: function(result){	
					var obj =$.parseJSON(result);
					$('#unit_'+ref).val(obj[0].uom);
					$('#uom_qty2_'+ref).val(obj[0].qty);
				}
			});
			$('#total_'+ref).val(tot);
			if(tot >= 1000)
			{		
				//comment as requested 8/29/18 remove certify of item
				//$('span#warning_'+ref).html("<a id='r_certprod' style='cursor:pointer' data-id='"+pid+"' data-id2='"+ref+"' data-id3='"+desc+"' ><i class='fa fa-warning' style='font-size:30px;color:red' title='Please certify to add item' data-toggle='tooltip' data-placement='top'></i>Click here to certify</a>");
				$('#needtocertify_'+ref).val("0");
				//alert($('.needtocertify.val()'));
				
			}
			else
			{
				$('span#warning_'+ref).empty();
				$('#needtocertify_'+ref).val("0");
			}
			//alert($('#needtocertify_'+ref).val());
			//alert(tot+":"+$('#needtocertify_'+ref).val());
		});
			
	

		$('#recount_list').on('click', '#r_certprod', function () {
			$('#r_myModalcert').modal('show');
			var id = $(this).data('id');
			var id2 = $(this).data('id2');
			var desc = $(this).data('id3');
			$('#prod_ref').val(id2);
			$('#prod_idcc').val(id);
			$('span#certifyprod').text(desc);
		//
		});


		function show_recount(){
			$(".left-side").toggleClass( "collapse-left" );
			$(".right-side").toggleClass("stretch");
			var dtr_url3 = '<?php echo base_url(); ?>operation/r_show_cc';
			
			$.ajax({
				type:"POST",
				url: dtr_url3,
				cache:false,
				success:function(data){					
						$('#asset_list_recount').html(data);					
				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
        });
		}
			

				$("#r_delcc_form").unbind('submit').submit(function(e) {
			 e.preventDefault();
			
			var prod = $('#del_id').val();
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var dtr_url2 = '<?php echo base_url(); ?>operation/r_delete_cc'; 

			if(prod.length > 0){
			
				$.ajax({
				type:"POST",
				url: dtr_url2,
				data: {prod:prod},
				cache:false,
				beforeSend:function(){

					$.alert('&nbsp;'+img, {
							title: '',
							type: 'success',
							position: ['top-right'],
							});

							//$("#addcc_form")[0].reset();
							
					
				},
				success:function(data){

					$('#r_myModaldel').modal('hide');
					$.alert('&nbsp;', {
						title: 'Item Successfully Deleted',
						type: 'success',
						position: ['top-right'],
					});
					
				//	$( ".left-side" ).toggleClass( "collapse-left" );
				//	$(".right-side").toggleClass("stretch");
					//setTimeout(function(){ location.reload(); }, 200);
				//	$('.left-side').toggleClass("collapse-left");
       			//	$(".right-side").toggleClass("strech");
					//$("#delcc_form")[0].reset();
					show_recount();

				},
				error:function(){
					$.alert('Item not successfully deleted!', {
						type: 'danger',
						position: ['top-right', [-0.42, 0]],
					});
				},
				
				});
			
			}else{
				//rMsg('Oops. Empty Record Try again','error');	
			}
			
		});	

		$('#recount_list').on('click', '#btn_del_recount', function () {
			$('#r_myModaldel').modal('show');
			var id = $(this).data('id');
			var desc = $(this).data('desc');
			$('#desc').text(desc);
			$('#del_id').val(id);
		});


					$('.r_addproduct').unbind('click').click(function(e){
			//alert("W");
	//$("#addcc_form").unbind('submit').submit(function(e) {
			 e.preventDefault();
			
			var prod  = $(this).data("id");
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var dtr_url2 = '<?php echo base_url(); ?>operation/r_add_cc'; 
			//alert(prod);
			if(prod){

				$.ajax({
				type:"POST",
				url: dtr_url2,
				data: {prod:prod},

				cache:false,
				beforeSend:function(){

					$.alert('&nbsp;'+img, {
							title: '',
							type: 'success',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							
					
				},
				success:function(data){
					var myObj = JSON.parse(data);

					if(myObj.msg == "success")
					{
						//alert('woop');
						 $.alert('&nbsp;', {
							title: 'Item Successfully Added',
							type: 'success',
							position: ['top-right'],
							});
						 	$("#autocomplete").focus();
							show_recount();
							//$("#addcc_form")[0].reset();
							//alert('test');
							//setTimeout(function(){ location.reload(); }, 1000);
							//show_recount();
							//$("#autocomplete").focus();
							//$("#autocomplete").val("");
						//show_recount();

							//$(".left-side").toggleClass("collapse-left");
       						//$(".right-side").toggleClass("strech");
       						//alert('added');

					}
					else if (myObj.msg == "duplicate")
					{
						$.alert('&nbsp;', {
							title: 'Item Already in List',
							type: 'warning',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							$("#autocomplete").focus();
							show_recount();
					}
					else
					{
						$.alert('&nbsp;', {
							title: 'Error Saving',
							type: 'danger',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							$("#autocomplete").focus();
							show_recount();
					}
				
				},
				error:function(){
					$.alert('Item not successfully added!', {
						type: 'danger',
						position: ['top-right', [-0.42, 0]],
					});
				},
				
				});
			
			}else{
					$.alert('&nbsp;', {
							title: 'Oops. Empty Record Try again',
							type: 'danger',
							position: ['top-right'],
							});
							$("#addcc_form")[0].reset();
							$("#autocomplete").focus();
							show_recount();
				//rMsg('Oops. Empty Record Try again','error');	
			}
			
		});


			$("#r_autocomplete").focus();

			$('#r_autocomplete').unbind('input').on('input',function(e){
			e.preventDefault();
			
				var prod = $('#r_autocomplete').val();
				var dtr_url2 = '<?php echo base_url(); ?>operation/r_get_item';
				var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
				
				$.ajax({
				type:"POST",
				url: dtr_url2,
				data: {prod:prod},
				cache:false,
				beforeSend:function(){

					$("#r_details-tbl").find('tr td').remove();
					$("#r_details-tbl").empty();
					$("#r_details-tbl").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');
					
				},
				success:function(data){
					if (data) {
						$('.left-side').toggleClass("collapse-left");
        				$(".right-side").toggleClass("strech");
						$('#r_asset_list_datasearch').html(data);
					}else{
						$('#r_asset_list_datasearch').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
					}

				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}				
			});
				
		});	

	// 		$('.r_addproduct').unbind('click').click(function(e){
	// 		//alert("W");
	// //$("#addcc_form").unbind('submit').submit(function(e) {
	// 		 e.preventDefault();
			
	// 		var prod  = $(this).data("id");
	// 		var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
	// 		var dtr_url2 = '<?php echo base_url(); ?>operation/r_add_cc'; 
	// 		//alert(prod);
	// 		if(prod){

	// 			$.ajax({
	// 			type:"POST",
	// 			url: dtr_url2,
	// 			data: {prod:prod},

	// 			cache:false,
	// 			beforeSend:function(){

	// 				$.alert('&nbsp;'+img, {
	// 						title: '',
	// 						type: 'success',
	// 						position: ['top-right'],
	// 						});
	// 						//$("#addcc_form")[0].reset();
							
					
	// 			},
	// 			success:function(data){
	// 				var myObj = JSON.parse(data);

	// 				if(myObj.msg == "success")
	// 				{
	// 					show_recount();
	// 					 $.alert('&nbsp;', {
	// 						title: 'Item Successfully Added',
	// 						type: 'success',
	// 						position: ['top-right'],
	// 						});
	// 						//$("#addcc_form")[0].reset();
	// 					//	$('.left-side').toggleClass("collapse-left");
 //       					//	$(".right-side").toggleClass("strech");

	// 						$("#autocomplete").focus();
	// 						$("#autocomplete").val("");
	// 						show_cc();
	// 				}
	// 				else if (myObj.msg == "duplicate")
	// 				{
	// 					$.alert('&nbsp;', {
	// 						title: 'Item Already in List',
	// 						type: 'warning',
	// 						position: ['top-right'],
	// 						});
	// 						//$("#addcc_form")[0].reset();
	// 						$("#autocomplete").focus();
	// 						show_cc();
	// 				}
	// 				else
	// 				{
	// 					$.alert('&nbsp;', {
	// 						title: 'Error Saving',
	// 						type: 'danger',
	// 						position: ['top-right'],
	// 						});
	// 						//$("#addcc_form")[0].reset();
	// 						$("#autocomplete").focus();
	// 						show_cc();
	// 				}
				
	// 			},
	// 			error:function(){
	// 				$.alert('Item not successfully added!', {
	// 					type: 'danger',
	// 					position: ['top-right', [-0.42, 0]],
	// 				});
	// 			},
				
	// 			});
			
	// 		}else{
	// 				$.alert('&nbsp;', {
	// 						title: 'Oops. Empty Record Try again',
	// 						type: 'danger',
	// 						position: ['top-right'],
	// 						});
	// 						$("#addcc_form")[0].reset();
	// 						$("#autocomplete").focus();
	// 						show_cc();
	// 			//rMsg('Oops. Empty Record Try again','error');	
	// 		}
			
	// 	});




		<?php elseif($use_js == 'CycleCount'): ?>
	
			
			$('#week0').click(function() {
				if(this.checked) {
					$('#week1').prop("checked",false);
				    $('#week2').prop("checked",false);
				    $('#week3').prop("checked",false);
				    $('#week4').prop("checked",false);
				} 
			});
			$('#week1').click(function() {
				if(this.checked) {
				    $('#week0').prop("checked",false);
				} 
			});
			$('#week2').click(function() {
				if(this.checked) {
				    $('#week0').prop("checked",false);
				} 
			});
			$('#week3').click(function() {
				if(this.checked) {
					$('#week0').prop("checked",false);
				} 
			});
		   
		   $('#week4').click(function() {
				if(this.checked) {
					$('#week0').prop("checked",false);
				} 
			});

		   $('#editweek0').click(function() {
				if(this.checked) {
					$('#editweek1').prop("checked",false);
				    $('#editweek2').prop("checked",false);
				    $('#editweek3').prop("checked",false);
				    $('#editweek4').prop("checked",false);
				} 
			});
		   $('#editweek1').click(function() {
				if(this.checked) {
				    $('#editweek0').prop("checked",false);
				} 
			});
			$('#editweek2').click(function() {
				if(this.checked) {
				    $('#editweek0').prop("checked",false);
				} 
			});
			$('#editweek3').click(function() {
				if(this.checked) {
					$('#editweek0').prop("checked",false);
				} 
			});
		   
		   $('#editweek4').click(function() {
				if(this.checked) {
					$('#editweek0').prop("checked",false);
				} 
			});
			 $("#txtautoprod").on("keyup", function() {
			    var value = $(this).val().toLowerCase();
			    $("#tblautoprod tr").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
			  });

			  $("#txtcatprod").on("keyup", function() {
			    var value = $(this).val().toLowerCase();
			    $("#tbodyprod tr").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
			  });



			  $("#txtcatsearch").on("keyup", function() {
			    var value = $(this).val().toLowerCase();
			    $("#tblcategory tr").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
			  });

			  $("#txtprodsearch").on("keyup", function() {
			    var value = $(this).val().toLowerCase();
			    $("#tblprod tr").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
			  });


			$("#autocomplete").focus();


			$("#addtocat_form").unbind('submit').submit(function(e) {
				e.preventDefault();

				var cat = $('#cc_cat').val();
			
				var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
				
				var post_url = baseUrl+'operation/addtocat';

				$.ajax({
					type:'POST',
					url:post_url,
					data: {cat:cat},
					cache:false,
					beforeSend:function(){

					$.alert('&nbsp;'+img, {
							title: '',
							type: 'success',
							position: ['top-right'],
							});
					},
					success:function(data){
						var myObj = JSON.parse(data);
						if(myObj.msg == "duplicate")
						{
							 $.alert('&nbsp;', {
								title: 'Duplicate Entry!',
								type: 'warning',
								position: ['top-right'],
								});

						}
						if(myObj.msg == "success")
						{
							 $.alert('&nbsp;', {
								title: 'Category Updated!',
								type: 'success',
								position: ['top-right'],
								});
							
							 $('#myModalcat2').modal('hide');
							 //show_cc();
							setTimeout(function(){ location.reload(); }, 1500);
						}
						if(myObj.msg == "error")
						{
							 $.alert('&nbsp;', {
								title: 'Error Saving!',
								type: 'danger',
								position: ['top-right'],
								});
						}	
					},
					error:function(){
						 $.alert('&nbsp;', {
								title: 'Error Saving!',
								type: 'danger',
								position: ['top-right'],
								});
					}
				});

				// $.post(post_url, 
				// 	{cat:cat}, 
				// 	function(data){
				// 		var myObj = JSON.parse(data);
						
						
				// 	//setTimeout(function(){ location.reload(); }, 3000);
				// 	});
			});

			$('#up-cat').unbind('click').click(function(e){
				e.preventDefault();
				
				var id = $('#catid').val();
				var cat = $('#editcatname').val();
				var days = $(".EditCheckbox:checked").map(function () { return this.value }).get().join();
				var weeks = $(".EditCheckbox2:checked").map(function () { return this.value }).get().join();
				//alert(days+":"+weeks);
				var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
				var post_url = baseUrl+'operation/upcat';

				$.ajax({
					type:'POST',
					url:post_url,
					data: {id:id,cat:cat,days:days,weeks:weeks}, 
					cache:false,
					beforeSend:function(){

					$.alert('&nbsp;'+img, {
							title: '',
							type: 'success',
							position: ['top-right'],
							});
					},
					success:function(data){
						var myObj = JSON.parse(data);
						if(myObj.msg == "duplicate")
						{
							 $.alert('&nbsp;', {
								title: 'Duplicate Entry!',
								type: 'warning',
								position: ['top-right'],
								});

						}
						if(myObj.msg == "success")
						{
							 $.alert('&nbsp;', {
								title: 'Category Updated!',
								type: 'success',
								position: ['top-right'],
								});
							
							 $('#myModalcat2').modal('hide');
							 //show_cc();
							setTimeout(function(){ location.reload(); }, 1500);
						}
						if(myObj.msg == "error")
						{
							 $.alert('&nbsp;', {
								title: 'Error Saving!',
								type: 'danger',
								position: ['top-right'],
								});
						}	
					},
					error:function(){
						 $.alert('&nbsp;', {
								title: 'Error Saving!',
								type: 'danger',
								position: ['top-right'],
								});
					}
				});


				//alert(cat);
				// $.post(post_url, 
				// 	{id:id,cat:cat,days:days,weeks:weeks}, 
				// 	function(data){
				// 		var myObj = JSON.parse(data);
				// 		//alert(myObj.msg);
				// 		if(myObj.msg == "duplicate")
				// 		{
				// 			 $.alert('&nbsp;', {
				// 				title: 'Duplicate Entry!',
				// 				type: 'warning',
				// 				position: ['top-right'],
				// 				});

				// 		}
				// 		if(myObj.msg == "success")
				// 		{
				// 			 $.alert('&nbsp;'+img, {
				// 				title: 'Category Updated!',
				// 				type: 'success',
				// 				position: ['top-right'],
				// 				});
				// 				$('.left-side').toggleClass("collapse-left");
    //    				 			$(".right-side").toggleClass("strech");
				// 			 show_cc();
				// 			setTimeout(function(){ location.reload(); }, 1500);
				// 		}
				// 		if(myObj.msg == "error")
				// 		{
				// 			 $.alert('&nbsp;', {
				// 				title: 'Error Saving!',
				// 				type: 'danger',
				// 				position: ['top-right'],
				// 				});
				// 		}
				// 	//setTimeout(function(){ location.reload(); }, 3000);
				// 	});
			});

			$("#savecat_form").unbind('submit').submit(function(e) {
				e.preventDefault();

				var cat = $('#cat').val();
				var days = $(".Checkbox:checked").map(function () { return this.value }).get().join();
				var weeks = $(".Checkbox2:checked").map(function () { return this.value }).get().join();
				//alert(days+":"+weeks);
				var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
				var post_url = baseUrl+'operation/savecat';


				$.post(post_url, 
					{cat:cat,days:days,weeks:weeks}, 
					function(data){
						var myObj = JSON.parse(data);
						//alert(myObj.msg);
						if(myObj.msg == "duplicate")
						{
							 $.alert('&nbsp;', {
								title: 'Duplicate Entry!',
								type: 'warning',
								position: ['top-right'],
								});

						}
						if(myObj.msg == "success")
						{
							 $.alert('&nbsp;'+img, {
								title: 'Category Saved!',
								type: 'success',
								position: ['top-right'],
								});
							 $("#savecat_form")[0].reset();
							 $('#myModalcat').modal('hide');
							 //show_cc();
							setTimeout(function(){ location.reload(); }, 1500);
						}
						if(myObj.msg == "error")
						{
							 $.alert('&nbsp;', {
								title: 'Error Saving!',
								type: 'danger',
								position: ['top-right'],
								});
						}
					//setTimeout(function(){ location.reload(); }, 3000);
					});
			});

				//$('#save_auto_btncc').unbind('click').click(function(e){
		$("#auto_form").unbind('submit').submit(function(e) {
			e.preventDefault();

			var stop = false;

			var i = 0;
			var conso_igsa_data = new Array(); //IGSA
			var conso_ignsa_data = new Array(); //IGNSA
			var igsa_data = [];
			var igsna_data = [];
			var qty_total = 0;

			var trans_num = $('#trans_num').val();
			var remarks = $('#remarks').val();
			var date_adjustment = $('#date_adjustment').val();
			var infoid = $('#infoid').val();

			$(".ccqty").each(function(){

				i++;

				if( $('#ccqty_'+i).val()){
						
					variance = $('#ccqty_'+i).val();
					uom_desc = $('#unit_'+i).val();
					uom_qty = $('#uom_qty2_'+i).val();
					totalcost = $('#unit_cost2_'+i).val();
					item_description =$('#prod_desc_'+i).val();
					movement_code =$('#movcode_'+i).val();
					product_id = $('#prod_id_'+i).val()
					barcode = $('#bcode_'+i).val();
					actual_count = $('#actual_'+i).val();
					freeze_val = $('#sysinv_'+i).val();
					costofsale = $('#cos_'+i).val();
					damaged = $('#damaged_'+i).val();

					if(variance == "NaN")
					stop = true;
					//console.log(uom_desc+'<-uom_desc'+uom_qty+'<-'+uomqty+'<-uomqty'+des+'des'+movcode+'movcode');

					if($('#ccqty_'+i).val() != '')
					{
							if( variance !=''  && totalcost !='' ){

								if(movement_code == "IGSA"){
									igsa_data = [variance,
							 		 uom_qty,
							 		 uom_desc,
							 		 totalcost,
							 		 product_id,
							 		 movement_code,
							 		 barcode,
									 actual_count,
									 freeze_val,
									 costofsale,
									 damaged];
							 		 
							 		conso_igsa_data.push(igsa_data);
						 		}else{

						 			igsna_data = [variance,
							 		 uom_qty,
							 		 uom_desc,
							 		 totalcost,
							 		 product_id,
							 		 movement_code,
							 		 barcode,
									 actual_count,
									 freeze_val,
									 costofsale,
									 damaged];
							 		 
							 		conso_ignsa_data.push(igsna_data);
						 		}

							}

						}
					
					}
		  
				});

				if(stop)
				{
					showAlert('Oops! Invalid Actual Count','danger');				}
				else
				{
				showAlert('Data Gathering... Please wait.','warning');
				var post_url = baseUrl+'operation/add_adjustment_headercc/'+infoid;
				var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
				if(conso_igsa_data.length > 0 || conso_ignsa_data.length > 0){

					console.log(conso_igsa_data); 

					$.post(post_url,{trans_num:trans_num,date_adjustment:date_adjustment,remarks:remarks,conso_igsa_data:conso_igsa_data,conso_ignsa_data:conso_ignsa_data}, function(data){
					
							var myObj = JSON.parse(data);

							console.log(myObj.msg);

							if(myObj.msg == "duplicate")
							{
								 $.alert('&nbsp;', {
									title: 'Adjustment Header already saved for today!',
									type: 'warning',
									position: ['top-right'],
									});
							}

							if(myObj.msg == "success")
							{
								removeAlerts();
								showAlert("Inventory Adjustment has been saved!","success");							
								show_cc();
							}

							if(myObj.msg == "error")
							{
								 $.alert('&nbsp;', {
									title: 'Error Saving!',
									type: 'danger',
									position: ['top-right'],
									});
							
							}

						setTimeout(function(){ location.reload(); }, 2500);
					});

				}else{

					$.alert('&nbsp;', {
						title: 'Oops. Empty Record Try again',
						type: 'danger',
						position: ['top-right'],
					});

				}
				}
		});

		
		$("#auto_form_").unbind('submit').submit(function(e) {
			// e.preventDefault();
			e.preventDefault();

			var err;
			var total2 = 0;
			var total = $('#total').val();
			var trans_num = $('#trans_num').val();
			var remarks = $('#remarks').val();
			var date_adjustment = $('#date_adjustment').val();
			var infoid = $('#infoid').val();
			//alert(infoid);
			var num_count = $(".qty_edit").each(function(){
		 	  return $(this).val();
			}).length;
			//alert("Num:"+num_count);
			var alldata = new Array(); //IGSA
			var alldata2 = new Array(); //IGNSA
			var data = [];
			var data2 = [];
			var totalcert = 0;
			var adqty = 0;
			var unit = 0;
			var unitcost = 0;
			var uom = 0;
			var cert = 0;
			var needtocert = 0;
			var desc = "<br>";
			var movcode="";
			//alert(trans_num);

			for(var i =1; i<= num_count;i++){

				adqty = $('#ad_qty2_'+i).val();
				unit = $('#unit_'+i).val();
				unitcost = $('#unit_cost2_'+i).val();
				uomqty = $('#uom_qty2_'+i).val();
				des =$('#prod_desc_'+i).val();
				cert =$('#needtocertify_'+i).val();
				movcode =$('#movcode_'+i).val();
				//alert(uomqty);
				if(cert == 1)
				{
					desc = desc + des + "<br>";
					needtocert = 1;
				}

				if($('#ccqty_'+i).val()!='')
				{
					if($('#ad_qty2_'+i).val()!='' && $('#unit_'+i).val()!='' && $('#unit_cost2_'+i).val()!='' && $('#uom_qty2_'+i).val()!=''){

						totalcert = $('#ad_qty2_'+i).val() * $('#unit_cost2_'+i).val();
						
						if(totalcert < 1000)
						{
							if(movcode == "IGSA")
							{
								data = [$('#ad_qty2_'+i).val(),
						 		 $('#cost_'+i).val(),
						 		 $('#uom_qty2_'+i).val(),
						 		 $('#unit_'+i).val(),
						 		 $('#unit_cost2_'+i).val(),
						 		 $('#prod_id_'+i).val(),
						 		 $('#movcode_'+i).val(),
						 		 $('#bcode_'+i).val(),
						 		 totalcert];
						 		 total2 = total2 + $('#ad_qty2_'+i).val()
						 		 
						 	alldata.push(data);
						 	}
						 	else
						 	{
						 		data2 = [$('#ad_qty2_'+i).val(),
						 		 $('#cost_'+i).val(),
						 		 $('#uom_qty2_'+i).val(),
						 		 $('#unit_'+i).val(),
						 		 $('#unit_cost2_'+i).val(),
						 		 $('#prod_id_'+i).val(),
						 		 $('#movcode_'+i).val(),
						 		 $('#bcode_'+i).val(),
						 		 totalcert];
						 		 total2 = total2 + $('#ad_qty2_'+i).val()
						 		 
						 		alldata2.push(data2);
						 	}
						}
						else
						{

							if(cert == 0)
							{
								if(movcode == "IGSA")
								{
									data = [$('#ad_qty2_'+i).val(),
							 		 $('#cost_'+i).val(),
							 		 $('#uom_qty2_'+i).val(),
							 		 $('#unit_'+i).val(),
							 		 $('#unit_cost2_'+i).val(),
							 		 $('#prod_id_'+i).val(),
							 		 $('#movcode_'+i).val(),
							 		 $('#bcode_'+i).val(),
							 		 totalcert];
							 		 total2 = total2 + $('#ad_qty2_'+i).val()
							 		 
							 		alldata.push(data);
						 		}
						 		else
						 		{
						 			data2 = [$('#ad_qty2_'+i).val(),
							 		 $('#cost_'+i).val(),
							 		 $('#uom_qty2_'+i).val(),
							 		 $('#unit_'+i).val(),
							 		 $('#unit_cost2_'+i).val(),
							 		 $('#prod_id_'+i).val(),
							 		 $('#movcode_'+i).val(),
							 		 $('#bcode_'+i).val(),
							 		 totalcert];
							 		 total2 = total2 + $('#ad_qty2_'+i).val();
							 		 
							 		alldata2.push(data2);
						 		}	
							}
							else
							{
							}
						}
						
					
					}
				}
			}

			if(needtocert >= 1)
			{
				$.alert(desc, {
				title: 'Please certify item to proceed!',
				type: 'danger',
				position: ['top-right'],
				});

			}
			else
			{	
				
				//alert(alldata);
				//alert(alldata2);
				var post_url = baseUrl+'operation/add_adjustment_headercc/'+infoid;
				var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
				if(alldata.length > 0 || alldata2.length > 0){

					$.post(post_url, 
						{trans_num:trans_num,date_adjustment:date_adjustment,total:total2,remarks:remarks,alldata:alldata,alldata2:alldata2}, 
						function(data){
							var myObj = JSON.parse(data);
							//alert(myObj.msg);
							if(myObj.msg == "duplicate")
							{
								 $.alert('&nbsp;', {
									title: 'Adjustment Header already saved for today!',
									type: 'warning',
									position: ['top-right'],
									});
							}
							if(myObj.msg == "success")
							{
								 $.alert('&nbsp'+img, {
									title: 'Inventory Adjustment has been saved!',
									type: 'success',
									position: ['top-right'],
									});
							
									show_cc();
							}
							if(myObj.msg == "error")
							{
								 $.alert('&nbsp;', {
									title: 'Error Saving!',
									type: 'danger',
									position: ['top-right'],
									});
							
								//	show_cc();
							}
						setTimeout(function(){ location.reload(); }, 2500);
					});

				}else{
					$.alert('&nbsp;', {
							title: 'Oops. Empty Record Try again',
							type: 'danger',
							position: ['top-right'],
						});
				
				}
			}
		});

			$('#pass').unbind('keyup');
			$("#pass").keyup(function(event){
			    if(event.keyCode == 13){
			        $("#confirm-certify").click();
			    }
			});

			//variance computation - Van
			$('.actual-count').unbind('input').on('input',function(e){
				e.preventDefault();
				var actual_count = $(this).val();
				var system_inventory = $(this).prev().val();
				var variance = actual_count - system_inventory;
				$(this).parent().next().find('.ccqty').val(variance);
				calculateTotalCostAdjustment($(this).parent().next().find('.ccqty'));
			});
		
			$(document).on('change','.actual-count',function(){
				var actual_count = $(this).val();
				if(actual_count == "")
				{
					$(this).parent().next().find('.ccqty').val("");
					$(this).parent().next().next().find('.allunitcost').val("");
				}
			});

			function calculateTotalCostAdjustment(variance){
				var id = $(variance).attr('id');
				var val =id.split("_");
				var ref = val[1];
				var pid = $('#prod_id_'+ref).val();
				var qty = $('#ccqty_'+ref).val();
				var qtyuom = $('#qtyuom_'+ref).val();
				var cost = $('#cost_'+ref).val();
				var prod_code = $('#prod_code_'+ref).val();
				var desc = $('#prod_desc_'+ref).val();
				var bcode = $('#bcode_'+ref).val();
				var qty_variance  = qty*qtyuom;
				var cost_variance  =  (qty*qtyuom) * cost;
				var movement_code = '';
				var prod_url =  '<?php echo base_url(); ?>operation/get_prod_uom2/'+bcode;
				var k = 0;
				var total = 0;

				movement_code = qty_variance > 0 ? 'IGSA' : 'IGNSA'; 
				
				$('#movcode_'+ref).val(movement_code);
				$('#mc_'+ref).val(movement_code);

				cost = cost == '' ? 0 : $('#cost_'+ref).val();

				if(qty !==''){

					var total_ad = parseFloat(-qty_variance);
					var subtotal = parseFloat(qty_variance) * parseFloat(cost);
					$('#ad_qty2_'+ref).val(Math.abs(qty_variance));
					$('#unit_cost2_'+ref).val(Math.abs(subtotal));

				}else{

					$('#ad_qty2_'+ref).val(Math.abs(qty_variance));
					$('#unit_cost2_'+ref).val(Math.abs(subtotal));
					$('#needtocertify_'+ref).val("0");

				}

				$('.ccqty').each(function(){
			 	  k++;
			 	  u_cost = $(this).val();
			 	  total+=parseFloat(u_cost) ||0;
				});

				$('#total').val(total.toFixed(4));

				$.ajax({
				type:"GET",
				url: prod_url,
				cache:false,
				success: function(result){	
					var obj =$.parseJSON(result);
					$('#unit_'+ref).val(obj[0].uom);
					$('#uom_qty2_'+ref).val(obj[0].qty);
					}
				});

				console.log($('#movcode_'+ref).val());
				console.log($('#mc_'+ref).val());
			}

			/* commented the event for variance
			$('.ccqty').unbind('input').on('input',function(e){
			e.preventDefault();

				var id = $(this).attr('id');
				var val =id.split("_");
				var ref = val[1];
				var pid = $('#prod_id_'+ref).val();
				var qty = $('#ccqty_'+ref).val();
				var qtyuom = $('#qtyuom_'+ref).val();
				var cost = $('#cost_'+ref).val();
				var prod_code = $('#prod_code_'+ref).val();
				var desc = $('#prod_desc_'+ref).val();
				var bcode = $('#bcode_'+ref).val();
				var qty_variance  = qty*qtyuom;
				var cost_variance  =  (qty*qtyuom) * cost;
				var movement_code = '';
				var prod_url =  '<?php echo base_url(); ?>operation/get_prod_uom2/'+bcode;
				var k = 0;
				var total = 0;

				movement_code = qty_variance > 0 ? 'IGSA' : 'IGNSA'; 
				
				$('#movcode_'+ref).val(movement_code);
				$('#mc_'+ref).val(movement_code);

				cost = cost == '' ? 0 : $('#cost_'+ref).val();

				if(qty !==''){

					var total_ad = parseFloat(-qty_variance);
					var subtotal = parseFloat(qty_variance) * parseFloat(cost);
					$('#ad_qty2_'+ref).val(Math.abs(qty_variance));
					$('#unit_cost2_'+ref).val(Math.abs(subtotal));

				}else{

					$('#ad_qty2_'+ref).val(Math.abs(qty_variance));
					$('#unit_cost2_'+ref).val(Math.abs(subtotal));
					$('#needtocertify_'+ref).val("0");

				}

				$('.ccqty').each(function(){
			 	  k++;
			 	  u_cost = $(this).val();
			 	  total+=parseFloat(u_cost) ||0;
				});

				$('#total').val(total.toFixed(4));

				$.ajax({
				type:"GET",
				url: prod_url,
				cache:false,
				success: function(result){	
					var obj =$.parseJSON(result);
					$('#unit_'+ref).val(obj[0].uom);
					$('#uom_qty2_'+ref).val(obj[0].qty);
					}
				});

				console.log($('#movcode_'+ref).val());
				console.log($('#mc_'+ref).val());

			});
			*/

			$('.ccqty_').unbind('input').on('input',function(e){
			e.preventDefault();

			//alert('Test');
			
			var id = $(this).attr('id');
			var val =id.split("_");
			var ref = val[1];
			var pid = $('#prod_id_'+ref).val();
			var neg_qty = $('#neg_qty_'+ref).val();
			var qty = $('#ccqty_'+ref).val();
			var ad_qty = $('#ad_qty2_'+ref).val();
			var qtyuom = $('#qtyuom_'+ref).val();
			var cost = $('#cost_'+ref).val();
			var prod_code = $('#prod_code_'+ref).val();
			var desc = $('#prod_desc_'+ref).val();
			var bcode = $('#bcode_'+ref).val();
			//alert(bcode);
			//alert(qty+'*'+qtyuom+'='+qty*qtyuom);
			var holder1 = qty*qtyuom;
			var bagoadjqty = holder1 - neg_qty;
			var movcode="";

			if(bagoadjqty > 0)
			{
				movcode = "IGSA";
			}
			else
			{
				movcode = "IGNSA";
			}

			$('#movcode_'+ref).val(movcode);
			//alert(movcode);
			$('#mc_'+ref).val(movcode);
			//alert(bagoadjqty);
			//alert(prod_code);
			var prod_url =  '<?php echo base_url(); ?>operation/get_prod_uom2/'+bcode;
			var k = 0;
			var total = 0;
			

			if (cost == '') {
				cost = 0;
			}else{
				cost = $('#cost_'+ref).val();
			}


			if(qty !==''){
				var total_ad =parseFloat(-qty) + parseFloat(neg_qty);
				var subtotal =parseFloat(bagoadjqty) * parseFloat(cost);
				$('#ad_qty2_'+ref).val(Math.abs(bagoadjqty));
				$('#unit_cost2_'+ref).val(Math.abs(subtotal));

			}else{
				$('#ad_qty2_'+ref).val(Math.abs(bagoadjqty));
				$('#unit_cost2_'+ref).val(Math.abs(subtotal));
				$('#needtocertify_'+ref).val("0");
			}
			//alert(subtotal);
			$('.adjustment_qty').each(function(){
		 	  k++;
		 	  u_cost = $(this).val();
		 	  total+=parseFloat(u_cost) ||0;
			});

			$('#total').val(total.toFixed(4));

			var tot = $('#ad_qty2_'+ref).val() * $('#unit_cost2_'+ref).val();
			//alert(tot);
			$.ajax({
				type:"GET",
				url: prod_url,
				cache:false,
				success: function(result){	
					var obj =$.parseJSON(result);
					// alert(obj[0].uom);
					// alert(obj[0].qty);
					$('#unit_'+ref).val(obj[0].uom);
					$('#uom_qty2_'+ref).val(obj[0].qty);
				}
			});


			$('#total_'+ref).val(tot);
			if(tot >= 1000)
			{		
				//comment as requested 8/29/18 remove certify of item
				//$('span#warning_'+ref).html("<a id='certprod' style='cursor:pointer' data-id='"+pid+"' data-id2='"+ref+"' data-id3='"+desc+"' ><i class='fa fa-warning' style='font-size:30px;color:red' title='Please certify to add item' data-toggle='tooltip' data-placement='top'></i><br> Click here to certify</a>");
				$('#needtocertify_'+ref).val("0");
				//alert($('.needtocertify.val()'));
				
			}
			else
			{
				$('span#warning_'+ref).empty();
				$('#needtocertify_'+ref).val("0");
			}
			//alert(tot+":"+$('#needtocertify_'+ref).val());
		});



		function show_cat(){
			var dtr_url3 = '<?php echo base_url(); ?>operation/show_cat';
			
			$.ajax({
				type:"POST",
				url: dtr_url3,
				cache:false,
				success:function(data){					
						$('#asset_list_category').html(data);					
				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
        });
		}

		function show_cc(){
			var dtr_url3 = '<?php echo base_url(); ?>operation/show_cc';
			
			$.ajax({
				type:"POST",
				url: dtr_url3,
				cache:false,
				success:function(data){					
						$('#asset_list_dataprolist').html(data);					
				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
        });
		}
		
		function show_auto(){
			var dtr_url3 = '<?php echo base_url(); ?>operation/show_auto_cc';
			
			$.ajax({
				type:"POST",
				url: dtr_url3,
				cache:false,
				success:function(data){					
						$('#asset_list_data4').html(data);					
				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
        });
		}


		$('#btn-export').unbind('click').click(function(){

			// //var date = $('#date_adjustment').val();
			// alert(date);
			// var find = '/';
			// var re = new RegExp(find, 'g');
			// date = date.replace(re, '-');

			var id = $('#infoid').val();
			//alert(id);
			var this_url =  baseUrl+'operation/print_cc_auto/'+id;
		   	window.location = this_url;
			return false;

			// var id = $('#infoid').val();
			// alert(id);
			// var dtr_url2 = '<?php echo base_url(); ?>operation/action/'+id; 
			// $.ajax({
			// 	type:'POST',
			// 	url:dtr_url2,
			// 	cache:false,
			// 	success:function(data){

			// 			$('#myModalviewdl').modal('show');
				
			// 	},
			// 	error:function(){
			// 		rMsg('Oops. Somethings wrong. Contact IS Department','error');

			// 	}
			// });
		});

		$('#dlfile').unbind('click').click(function(){

			$('#myModalviewdl').modal('hide');
		});
			
		$(document).on("click", '.btn_view_postedcc', function(event) {
			
			var savedate = $(this).data('id');
     		$("#auto_title").html("Cycle Count Item List - POSTED ("+savedate+")");
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>operation/view_auto_posted/'+id;
			//var url2 = '<?php echo base_url(); ?>operation/checkauto/'+id;
			
		//	$('#myModal').modal('show')
			
			$.ajax({
				type:'GET',
				url:url,
				cache:false,
				beforeSend:function(){

					$("#cc_list2").find('tr td').remove();
					$("#cc_list2").empty();
					$("#cc_list2").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');
					
				},
				success:function(data){
					//alert(data);
					if (data) {
						$('#asset_list_postedcc').html(data);
					}else{
						$('#asset_list_postedcc').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
					}

				

				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
			});
		});

		//COPY
		$(document).on("click", '.btn_view_auto', function(event) { 
			
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>operation/view_auto_cc/'+id;
			var url2 = '<?php echo base_url(); ?>operation/checkauto/'+id;
			$('#myModal').modal('show');
			
			$.ajax({
				type:'GET',
				url:url,
				cache:false,
				beforeSend:function(){

					$("#cc_list").find('tr td').remove();
					$("#cc_list").empty();
					$("#cc_list").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');

				},
				success:function(data){
					//alert(data);
					if (data) {
						$('#asset_list_data5').html(data);
					}else{
						$('#asset_list_data5').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
					}

					$.ajax({
						type:'GET',
						url:url2,
						cache:false,
						success:function(data){
							var myObj = JSON.parse(data);
							//alert(myObj.msg);
							if(myObj.msg != null)
							{
								//$('#add_item_adjustment').attr("disabled", "disabled");
							}
					
						},
						error:function(){
							rMsg('Oops. Somethings wrong. Contact IS Department','error');
						}
					});

				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
			});
		});

		$('.btn_view_cat').unbind('click').click(function(){
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>operation/view_cat_product/'+id;
			
			$('.left-side').toggleClass("collapse-left");
        	$(".right-side").toggleClass("strech");
			
			$('#myModalviewcat').modal('show')
			
			$.ajax({
				type:'GET',
				url:url,
				cache:false,
				success:function(data){
					if (data) {
						$('#asset_list_dataviewcat').html(data);
					}else{
						$('#asset_list_dataviewcat').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
					}
				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
			});
		});

		$('.btn_edit_cat').unbind('click').click(function(){
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>operation/edit_cat_product/'+id;
			
			$('#myModaleditcat').modal('show');
			var day  = $(this).data("day");
			var name  = $(this).data("name");
			var sched  = $(this).data("sched");
			//alert(id);
			$('#editcatname').val(name);
			$('#catid').val(id);

			if (day.indexOf("Monday") >= 0)
			{
				$('#editdays1').prop("checked",true);
			}
			else
			{
				$('#editdays1').prop("checked",false);
			}

			if (day.indexOf("Tuesday") >= 0)
			{
				$('#editdays2').prop("checked",true);
			}
			else 
			{			
				$('#editdays2').prop("checked",false);
			}

			if (day.indexOf("Wednesday") >= 0)
			{
				$('#editdays3').prop("checked",true);
			}
			else 
			{			
				$('#editdays3').prop("checked",false);
			}

			if (day.indexOf("Thursday") >= 0)
			{
				$('#editdays4').prop("checked",true);
			}
			else 
			{			
				$('#editdays4').prop("checked",false);
			}
			if (day.indexOf("Friday") >= 0)
			{
				$('#editdays5').prop("checked",true);
			}
			else 
			{			
				$('#editdays5').prop("checked",false);
			}
			if (day.indexOf("Saturday") >= 0)
			{
				$('#editdays6').prop("checked",true);
			}
			else 
			{			
				$('#editdays6').prop("checked",false);
			}
			if (day.indexOf("Sunday") >= 0)
			{
				$('#editdays7').prop("checked",true);
			}
			else 
			{			
				$('#editdays7').prop("checked",false);
			}
			//weeks
			if (sched.indexOf("Weekly") >= 0)
			{
				$('#editweek1').prop("checked",true);
			}
			else 
			{			
				$('#editweek1').prop("checked",false);
			}		

			if (sched.indexOf("2nd Week") >= 0)
			{
				$('#editweek2').prop("checked",true);
			}
			else 
			{			
				$('#editweek2').prop("checked",false);
			}

			if (sched.indexOf("3rd Week") >= 0)
			{
				$('#editweek3').prop("checked",true);
			}
			else 
			{			
				$('#editweek3').prop("checked",false);
			}

			if (sched.indexOf("4th Week") >= 0)
			{
				$('#editweek4').prop("checked",true);
			}
			else 
			{			
				$('#editweek4').prop("checked",false);
			}
			

		});




		$('#auto-btn').unbind('click').click(function(){
			
			var dtr_url2 = '<?php echo base_url(); ?>operation/add_auto'; 
			$.ajax({
				type:'POST',
				url:dtr_url2,
				cache:false,
				success:function(data){
					$.alert('', {
						title: 'Auto Success',
						type: 'success',
						position: ['top-right'],
					});
					show_auto();					
					
				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
			});
		});

		$('#confirm-certify').unbind('click').click(function(){
			var user = $('#user').val();
			var pass = $('#pass').val();
			var id_cc = $('#prodid_cc').val();
			var ref = $('#prod_ref').val();
			var cert = $('#needtocertify_'+ref).val();

			//alert(cert + " : "+ref)

			var dtr_url2 = '<?php echo base_url(); ?>operation/certify'; 
			$.ajax({
				type:'POST',
				url:dtr_url2,
				data: {user:user,pass:pass},
				cache:false,
				success:function(data){

					var myObj = JSON.parse(data);
					//alert(myObj.msg);
					if(myObj.msg == "error")
					{
						 $.alert('&nbsp;', {
							title: 'Error Login!',
							type: 'danger',
							position: ['top-right'],
							});
							 $('#needtocertify_'+ref).val("1");
							$('#user').val("");
							$('#pass').val("");	

					}
					else 
					{		
						 $.alert('&nbsp', {
							title: 'Item Certified',
							type: 'success',
							position: ['top-right'],
							});
							$('#needtocertify_'+ref).val("0");
							$('span#warning_'+ref).empty();		

							$('#user').val("");
							$('#pass').val("");
							$('#myModalcert').modal('hide');					
					}				
					
				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}
			});
		});
	
		$('#del_cc').on('click', '#btn_del_cc3', function () {
			$('#myModaldel').modal('show');
			var id = $(this).data('id');
			
			$('#del_id').val(id);
		});

		$('#del_cc2').on('click', '#btn_del_cc2', function () {
			$('#myModaldel').modal('show');
			var id = $(this).data('id');
			var desc = $(this).data('desc');
			$('#desc').text(desc);
			$('#del_id').val(id);
		});



		$('#tblcategory').on('click', '#btn_del_cat', function () {
			$('#myModaldelcat').modal('show');
			var id = $(this).data('id');
			var desc = $(this).data('desc');
			$('#catdesc').text(desc);
			$('#catdel_id').val(id);
		});


		$('#cc_list').on('click', '#certprod', function () {
			$('#myModalcert').modal('show');
			var id = $(this).data('id');
			var id2 = $(this).data('id2');
			var desc = $(this).data('id3');
			$('#prod_ref').val(id2);
			$('#prod_idcc').val(id);
			$('span#certifyprod').text(desc);
		//
		});

		$('#tblcatprod').on('click', '#btn_del_catprod', function () {
			$('#myModalviewcat').modal('hide');
			$('#myModaldelcatprod').modal('show');
			var id = $(this).data('id');
			var desc = $(this).data('desc');
			var cid = $('#catid').val();
			//alert(cid);
			$('#catproddesc').text(desc);
			$('#catprod_id').val(id);
			$('#catprod_idcat').val(cid);
		});


		$("#delcc_form").unbind('submit').submit(function(e) {
			 e.preventDefault();
			
			var prod = $('#del_id').val();
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var dtr_url2 = '<?php echo base_url(); ?>operation/delete_cc'; 

			if(prod.length > 0){
			
				$.ajax({
				type:"POST",
				url: dtr_url2,
				data: {prod:prod},
				cache:false,
				beforeSend:function(){

					$.alert('&nbsp;'+img, {
							title: '',
							type: 'success',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							
					
				},
				success:function(data){

					$('#myModaldel').modal('hide');
					$.alert('&nbsp;', {
						title: 'Item Successfully Deleted',
						type: 'success',
						position: ['top-right'],
					});
					$('.left-side').toggleClass("collapse-left");
       				$(".right-side").toggleClass("strech");
					//$("#delcc_form")[0].reset();
					show_cc();
				},
				error:function(){
					$.alert('Item not successfully deleted!', {
						type: 'danger',
						position: ['top-right', [-0.42, 0]],
					});
				},
				
				});
			
			}else{
				//rMsg('Oops. Empty Record Try again','error');	
			}
			
		});

		$("#delcatprod_form").unbind('submit').submit(function(e) {
			 e.preventDefault();
			
			var bar = $('#catprod_id').val();
			var cat = $('#catprod_idcat').val();

			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var dtr_url2 = '<?php echo base_url(); ?>operation/delete_catprod'; 

			if(cat.length > 0){
			
				$.ajax({
				type:"POST",
				url: dtr_url2,
				data: {cat:cat,bar:bar},
				cache:false,
				beforeSend:function(){

					$.alert('&nbsp;'+img, {
							title: '',
							type: 'success',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							
					
				},
				success:function(data){
					setTimeout(function(){ location.reload(); }, 1000);
					//$('#myModaldelcatprod').modal('show');
					//$('#myModaldelcat').modal('hide');
					//$('#myModalviewcat').modal('show');
					$.alert('&nbsp;', {
						title: 'Product Successfully Deleted from Category',
						type: 'success',
						position: ['top-right'],
					});
					//$("#delcc_form")[0].reset();
					
				},
				error:function(){
					$.alert('Category not successfully deleted!', {
						type: 'danger',
						position: ['top-right', [-0.42, 0]],
					});
				},
				
				});
			
			}else{
				//rMsg('Oops. Empty Record Try again','error');	
			}
			
		});


		$("#delcat_form").unbind('submit').submit(function(e) {
			 e.preventDefault();
			
			var cat = $('#catdel_id').val();
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var dtr_url2 = '<?php echo base_url(); ?>operation/delete_cat'; 

			if(cat.length > 0){
			
				$.ajax({
				type:"POST",
				url: dtr_url2,
				data: {cat:cat},
				cache:false,
				beforeSend:function(){

					$.alert('&nbsp;'+img, {
							title: '',
							type: 'success',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							
					
				},
				success:function(data){

					$('#myModaldelcat').modal('hide');
					$.alert('&nbsp;', {
						title: 'Category Successfully Deleted',
						type: 'success',
						position: ['top-right'],
					});
					//$("#delcc_form")[0].reset();
					setTimeout(function(){ location.reload(); }, 1000);
				},
				error:function(){
					$.alert('Category not successfully deleted!', {
						type: 'danger',
						position: ['top-right', [-0.42, 0]],
					});
				},
				
				});
			
			}else{
				//rMsg('Oops. Empty Record Try again','error');	
			}
			
		});

		//btn add all -Van
		$('#btn_add_all').unbind('click').click(function(e){
			e.preventDefault();
			$('.addproduct').each(function(){
				$(this).trigger('click');
			});
		});
			
		//btn_add_product
		$('.addproduct').unbind('click').click(function(e){
			//alert("W");
	//$("#addcc_form").unbind('submit').submit(function(e) {
			 e.preventDefault();
			
			var prod  = $(this).data("id");
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var dtr_url2 = '<?php echo base_url(); ?>operation/add_cc'; 
			//alert(prod);
			if(prod){

				$.ajax({
				type:"POST",
				url: dtr_url2,
				data: {prod:prod},

				cache:false,
				beforeSend:function(){

					$.alert('&nbsp;'+img, {
							title: '',
							type: 'success',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							
					
				},
				success:function(data){
					var myObj = JSON.parse(data);

					if(myObj.msg == "success")
					{
						 $.alert('&nbsp;', {
							title: 'Item Successfully Added',
							type: 'success',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							$('.left-side').toggleClass("collapse-left");
       						$(".right-side").toggleClass("strech");

							$("#autocomplete").focus();
							$("#autocomplete").val("");
							show_cc();
					}
					else if (myObj.msg == "duplicate")
					{
						$.alert('&nbsp;', {
							title: 'Item Already in List',
							type: 'warning',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							$("#autocomplete").focus();
							show_cc();
					}
					else
					{
						$.alert('&nbsp;', {
							title: 'Error Saving',
							type: 'danger',
							position: ['top-right'],
							});
							//$("#addcc_form")[0].reset();
							$("#autocomplete").focus();
							show_cc();
					}
				
				},
				error:function(){
					$.alert('Item not successfully added!', {
						type: 'danger',
						position: ['top-right', [-0.42, 0]],
					});
				},
				
				});
			
			}else{
					$.alert('&nbsp;', {
							title: 'Oops. Empty Record Try again',
							type: 'danger',
							position: ['top-right'],
							});
							$("#addcc_form")[0].reset();
							$("#autocomplete").focus();
							show_cc();
				//rMsg('Oops. Empty Record Try again','error');	
			}
			
		});

			//search barcode -Paul
		$('#autocomplete').unbind('input').on('input',function(e){
			e.preventDefault();
				
				var supplier_code = $('#select_supplier').val();
				var prod = $('#autocomplete').val();
				var dtr_url2 = '<?php echo base_url(); ?>operation/get_item';
				var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
				
				$.ajax({
				type:"POST",
				url: dtr_url2,
				data: {prod:prod,supplier_code:supplier_code},
				cache:false,
				beforeSend:function(){

					$("#details-tbl").find('tr td').remove();
					$("#details-tbl").empty();
					$("#details-tbl").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');
					
				},
				success:function(data){
					if (data) {
						$('.left-side').toggleClass("collapse-left");
        				$(".right-side").toggleClass("strech");
						$('#asset_list_datasearch').html(data);
					}else{
						$('#asset_list_datasearch').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
					}

				},
				error:function(){
					rMsg('Oops. Somethings wrong. Contact IS Department','error');
				}				
			});
				
		});	
	
		$('#select_supplier').unbind('change').on('change',function(e){			
			e.preventDefault();
			var supplier_code = $(this).val();
			
			var prod = $('#autocomplete').val();
			var dtr_url2 = '<?php echo base_url(); ?>operation/get_item';
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			
			$.ajax({
			type:"POST",
			url: dtr_url2,
			data: {prod:prod,supplier_code:supplier_code},
			cache:false,
			beforeSend:function(){
				$("#details-tbl").find('tr td').remove();
				$("#details-tbl").empty();
				$("#details-tbl").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');			
			},
			success:function(data){
				if (data) {
					$('.left-side').toggleClass("collapse-left");
        					$(".right-side").toggleClass("strech");
					$('#asset_list_datasearch').html(data);
				}else{
					$('#asset_list_datasearch').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
				}
			},
			error:function(){
				rMsg('Oops. Somethings wrong. Contact IS Department','error');
			}				
			});

  			$('#autocomplete').removeAttr("disabled");

		});

		// $(":checkbox").click(function(){
		// 	$(":checkbox").each(function () {                                                    
		// 		var check_url = '<?php echo base_url(); ?>operation/certify';
	 //            var ischecked = $(this).is(":checked");
	 //            var data = $(this).val();
	 //            if (ischecked) {
	 //            	$(this).prop("checked","checked");
	 //            	$(this).attr("disabled","true");
	 //                $.post(check_url,{data:data}, function( result ) {
		// 				$.alert('Updated!', {
		// 					type: 'success',
		// 					position: ['top-right'],
		// 				});
	 //                });
	 //            }
	 //        });
		// });

		<?php elseif($use_js == 'NoDisplay'): ?>


				$('#chk_nodisplay').on('click', '.check', function(){

			var id = $(this).attr('id');
			var val =id.split("_");
			var ref = val[1];
			
	
		//$(".check").change(function(){
			var num_count = $(".check").each(function(){
		 	  return $(this).val();
			}).length;
			var check_url = '<?php echo base_url(); ?>operation/update_status';
			var desc = " "; 
			var err=0;
			var i = ref;
			//for(var i =0; i< num_count;i++){
				 var ischecked = $('#chk_'+i).is(":checked");
				 var data = $('#chk_'+i).val();
				
				 var remarks = $('#remarks_'+i).val();
				 	if(ischecked) {
				 		//alert(remarks);
				 	
				 	if(jQuery.trim(remarks).length > 0)
				 	{
				 		$('#chk_'+i).prop("checked","checked");
	            		$('#chk_'+i).attr("disabled","true");
	            		$('#remarks_'+i).attr("disabled","true");
		                $.post(check_url,{data:data,remarks:remarks}, function( result ) {
							rMsg('Successfully UPDATE','success');
		                });
				 	}
				 	else
				 	{
				 		$('#chk_'+i).prop('checked', false); // Checks it
				 		var desc = desc + "<br>" +$('#desc_'+i).val();
				 		rMsg('Remarks required for '+desc,'danger');
				 		err=1;
				 	}
				 }
			//}
			// if(err >= 1)
			// {
			// 	rMsg('Remarks required for '+desc,'warning');
			// }
			// else
			// {
			// 	rMsg('Successfully UPDATE','success');
			// }
			// $(":checkbox").each(function () {
			// 	var check_url = '<?php echo base_url(); ?>operation/update_status';
			// 	var remarks = $('#remarks_'+i).val();
	  //           var ischecked = $(this).is(":checked");
	  //           var data = $(this).val();
	  //           if (ischecked) {
	   
	  //           	$(this).prop("checked","checked");
	  //           	$(this).attr("disabled","true");
	  //               $.post(check_url,{data:data,remarks:remarks}, function( result ) {
			// 			rMsg('Successfully UPDATE','success');
	  //               });
	  //           }
	  //           i++;
	  //       });
		});

		$('#chk_nodisplay2').on('click', '.check2', function(){

			var id = $(this).attr('id');
			var val =id.split("_");
			var ref = val[1];
			
	
		//$(".check").change(function(){
			var num_count = $(".check2").each(function(){
		 	  return $(this).val();
			}).length;
			var check_url = '<?php echo base_url(); ?>operation/update_status';
			var desc = " "; 
			var err=0;
			var i = ref;
			//for(var i =0; i< num_count;i++){
				 var ischecked = $('#chk_'+i).is(":checked");
				 var data = $('#chk_'+i).val();
				
				 var remarks = $('#remarks_'+i).val();
				 	if(ischecked) {
				 		//alert(remarks);
				 	
				 	if(jQuery.trim(remarks).length > 0)
				 	{
				 		$('#chk_'+i).prop("checked","checked");
	            		$('#chk_'+i).attr("disabled","true");
	            		$('#remarks_'+i).attr("disabled","true");
		                $.post(check_url,{data:data,remarks:remarks}, function( result ) {
							rMsg('Successfully UPDATE','success');
		                });
				 	}
				 	else
				 	{
				 		$('#chk_'+i).prop('checked', false); // Checks it
				 		var desc = desc + "<br>" +$('#desc_'+i).val();
				 		rMsg('Remarks required for '+desc,'danger');
				 		err=1;
				 	}
				 }
			//}
			// if(err >= 1)
			// {
			// 	rMsg('Remarks required for '+desc,'warning');
			// }
			// else
			// {
			// 	rMsg('Successfully UPDATE','success');
			// }
			// $(":checkbox").each(function () {
			// 	var check_url = '<?php echo base_url(); ?>operation/update_status';
			// 	var remarks = $('#remarks_'+i).val();
	  //           var ischecked = $(this).is(":checked");
	  //           var data = $(this).val();
	  //           if (ischecked) {
	   
	  //           	$(this).prop("checked","checked");
	  //           	$(this).attr("disabled","true");
	  //               $.post(check_url,{data:data,remarks:remarks}, function( result ) {
			// 			rMsg('Successfully UPDATE','success');
	  //               });
	  //           }
	  //           i++;
	  //       });
		});
			

		$(".check").change(function() {
			if ($(".check:checked").length>0) {
				$(".check_all").prop("checked", true);
			}
			else {
				$(".check_all").prop("checked",false);
			}
		});

		$(".check_all").click(function(){
			$(".check").prop("checked", true);
		});

		function enable_button(my_btn, my_btn_text, old_icon, new_icon, old_class, new_class)
		{
			my_btn.removeAttr('disabled');
			my_btn.html("<i class='fa "+new_icon+" fa-lg'></i> "+my_btn_text);
			my_btn.addClass(new_class);
			my_btn.removeClass(old_class+' '+old_icon);
		}
		
		function disable_button(my_btn, btn_class)
		{
			my_btn.attr({'disabled' : 'disabled'});
			my_btn.addClass('btn-danger');
			my_btn.removeClass(btn_class);
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); 
		}
	

		//$('#btn_search').click(function(){
		$('#btn_search').unbind('click').click(function(e){
			 e.preventDefault();
			 var cat = $('#category').val();
			var btn = $(this)
			disable_button(btn,'btn-primary');
			var date = $('#date_').val();
			var cat = $('#category').val();
			//alert(date+":"+cat);
			var dtr_url = '<?php echo base_url(); ?>operation/load_no_display';
			disable_button(btn, 'btn-primary');
			$.post(dtr_url, {'date' : date, 'cat' : cat}, function(data){
				$('#adjustment').html(data);
					enable_button(btn, 'Search', 'fa-search', 'fa-search', 'btn-primary','btn-primary','btn-primary')
					return false;
				});

			//$('.left-side').addClass("collapse-left");
    	   	 //$(".right-side").addClass("strech");


		});


		$('#print_excel_btn').click(function(){
			var date = $('#date_').val();
			var find = '/';
			var re = new RegExp(find, 'g');
			date = date.replace(re, '-');
			var this_url =  baseUrl+'operation/print_posible_no_display/'+date;
		   	window.location = this_url;
			return false;
		});


	<?php elseif($use_js == 'SmartTrans'): ?>
			
		function enable_button(my_btn, my_btn_text, old_icon, new_icon, old_class, new_class)
		{
			my_btn.removeAttr('disabled');
			my_btn.html("<i class='fa "+new_icon+" fa-lg'></i> "+my_btn_text);
			my_btn.addClass(new_class);
			my_btn.removeClass(old_class+' '+old_icon);
		}
		
		function disable_button(my_btn, btn_class)
		{
			my_btn.attr({'disabled' : 'disabled'});
			my_btn.addClass('btn-danger');
			my_btn.removeClass(btn_class);
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); 
		}

		$('#btn_search_smart').click(function(){
			var btn = $(this)
			disable_button(btn,'btn-primary');
			var branch = $('#bcode').val();
			var or_num = $('#or_num').val();
			var cell_num = $('#cell_num').val();
			var postype = $('#postype').val();
			var dtr_url = '<?php echo base_url(); ?>operation/smart_trans_search';
			disable_button(btn, 'btn-primary');
			$.post(dtr_url, {'branch' : branch,'or_num':or_num,'cell_num':cell_num,'postype':postype}, function(data){
				$('#smart_data').html(data);
					enable_button(btn, 'Search', 'fa-search', 'fa-search', 'btn-primary','btn-primary','btn-primary')
					return false;
				});

		});



		//----------------Dan----------------------//

		<?php elseif($use_js == 'ViewData'): ?>
			
			function enable_button(my_btn, my_btn_text, old_icon, new_icon, old_class, new_class)
			{
				my_btn.removeAttr('disabled');
				my_btn.html("<i class='fa "+new_icon+" fa-lg'></i> "+my_btn_text);
				my_btn.addClass(new_class);
				my_btn.removeClass(old_class+' '+old_icon);
			}
			
			function disable_button(my_btn, btn_class)
			{
				my_btn.attr({'disabled' : 'disabled'});
				my_btn.addClass('btn-danger');
				my_btn.removeClass(btn_class);
				my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); 
			}
	
			$('#btn_search_view_data').click(function(){
				var btn = $(this)
				disable_button(btn,'btn-primary');
				var description = $('#Description').val();
				var barcode = $('#Barcode').val();
				var fdate = $('#fdate').val();
				var tdate = $('#tdate').val();
				console.log(fdate,tdate);
				var dtr_url = '<?php echo base_url(); ?>operation/view_data_trans_search';
				disable_button(btn, 'btn-primary');
				$.post(dtr_url, {'description' : description,'barcode':barcode, 'fdate':fdate, 'tdate':tdate}, function(data){
					$('#view_data_data').html(data);
						enable_button(btn, 'Search', 'fa-search', 'fa-search', 'btn-primary','btn-primary','btn-primary')
						return false;
					});
	
			});
	


			$('.btn_view_data').unbind('click').click(function(){
			
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>operation/view_data_button/'+id;
			$('#myModal').modal('show')
				$.ajax({
					type:'GET',
					url:url,
					cache:false,
					beforeSend:function(){

						$("#cc_list").find('tr td').remove();
						$("#cc_list").empty();
						$("#cc_list").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');
						
					},
					success:function(data){
						if (data) {
							$('#price_change_history').html(data);
						}else{
							$('#price_change_history').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
						}
					},
				});
			});

			
			$('.btn_view_markup').unbind('click').click(function(){
			
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>operation/view_markup_button/'+id;
			$('#myModal_markup_srp').modal('show')
				$.ajax({
					type:'GET',
					url:url,
					cache:false,
					beforeSend:function(){

						$("#cc_list").find('tr td').remove();
						$("#cc_list").empty();
						$("#cc_list").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');
						
					},
					success:function(data){
						if (data) {
							$('#markup').html(data);
						}else{
							$('#markup').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
						}
					},
				});
			});

			$('.btn_view_srp_computation').unbind('click').click(function(){
			
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var costofsales = $('#costofsales').val();
			var barcode = $('#barcode').val();
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>operation/view_srp_computation/'+id+'/'+costofsales+'/'+barcode;
			$('#myModal_srp_computation').modal('show')
				$.ajax({
					type:'GET',
					url:url,
					cache:false,
					beforeSend:function(){

						$("#cc_list").find('tr td').remove();
						$("#cc_list").empty();
						$("#cc_list").append('<tr><td colspan="9" id="img_loading" align="center">'+img+'</td></tr>');
						
					},
					success:function(data){
						if (data) {
							$('#srp_computation').html(data);
						}else{
							$('#srp_computation').html("<table align='center'><tr><td colspan='9' ><h1>No Record Found</h1></td></tr></table>");
						}
					},
				});
			});

			$('#print_excel_btn').click(function(e){
				e.preventDefault();
				var user_branch = $('#user_branch').val();
				var description = $('#Description').val();
				var barcode = $('#Barcode').val();
				var fdate = $('#fdate').val();
				var tdate = $('#tdate').val();
				var this_url =  baseUrl+'operation/print_product_history?user_branch='+user_branch+'&description='+description+'&barcode='+barcode+'&fdate='+fdate+'&tdate='+tdate;
				window.location = this_url;
			});


			$(document).ready(function() {
			    $('.hover-tn').tooltip({
			        title: fetchData,
			        html: true,
			        placement: 'right'
			    });
			    var url = '<?php echo base_url(); ?>operation/view_tn/';
			    function fetchData()
			    {
			    var fetch_data = '';
			    var element = $(this);
			    var id = element.attr("id");
			    $.ajax({
				url:url,
				method:"POST",
				async: false,
				data:{id:id},
				success:function(data)
				{
				fetch_data = data;
				}
			    });   
			    return fetch_data;
			    }
			  });

			$(document).ready(function() {
			$('.hover-name').tooltip({
			title: fetchData,
			html: true,
			placement: 'right'
			});
			var url = '<?php echo base_url(); ?>operation/view_name/';
			function fetchData()
			{
			var fetch_data = '';
			var element = $(this);
			var id = element.attr("id");
			$.ajax({
				url:url,
				method:"POST",
				async: false,
				data:{id:id},
				success:function(data)
				{
				fetch_data = data;
				}
			});   
			return fetch_data;
			}
			});

		//----------------Dan----------------------//
		
		<?php elseif($use_js == 'PriceMatchReport'): ?>

			$(window).on('load', function() {
				$.ajax({
					url: '<?php echo base_url(); ?>operation/fetch_pricematch_branches',
					type: 'get',
					dataType: 'json',
					success: function(data) {
						$("#pricematch_branch").empty()
						let datas = ''
						for(let i = 0; i<data.length; i++)
			            {
			              datas += "<option value='"+data[i].brcode+"'>"+data[i].description+"</option>"
			            }
						$("#pricematch_branch").append(`
						<div class="form-group">
							<label for="branches_pricematch">Branch</label>
							<select class="form-control" id="branches_pricematch">
							    ${datas}
							  </select>
						</div>
						`)
					}
				})
			})

			$(document).on('click', '#print_excel_btn', function () {
				var fdate = $('#fdate').val();
				var tdate = $('#tdate').val();
				var branch = $('#branches_pricematch').val();
				
				$.ajax({
					url: '<?php echo base_url(); ?>operation/price_match_report_excel',
					type: 'post',
					dataType: 'json',
					data: {fdate: fdate, tdate: tdate, branch: branch},
					success: function(data) {
						if(data == "false") {
							$("#pricematch_info").empty()
							$("#pricematch_info").append(`
							<div class="alert alert-danger" style=" padding-right: 30px; margin-right: 15px;">
								<strong>Error!</strong> No items for price match.
							</div>
							`)
							return false
						}
						var $a = $("<a>");
						$a.attr("href",data.file);
						$("body").append($a);
						$a.attr("download",data.filename);
						$a[0].click();
						$a.remove();
						$("#pricematch_info").empty()
						$("#pricematch_info").append(`
						<div class="alert alert-success" style=" padding-right: 30px; margin-right: 15px;">
							<strong>Success!</strong> You successfully generated a report.
						</div>
						`)
					}
				})
			})

			function show_auto(){
				var dtr_url3 = '<?php echo base_url(); ?>operation/show_auto_cc';
				
				$.ajax({
					type:"POST",
					url: dtr_url3,
					cache:false,
					success:function(data){					
							$('#asset_list_data4').html(data);					
					},
					error:function(){
						rMsg('Oops. Somethings wrong. Contact IS Department','error');
					}
				});
			}
	

		<?php endif; ?>

	});

	//auto cc list filter -Van
	$('#autocc_status').on('change',function(){
		filterAutoCC();
	});

	$('#autocc_from').on('change',function(){
		filterAutoCC();
	});

	$('#autocc_to').on('change',function(){
		filterAutoCC();
	});

	function filterAutoCC(){
		var status = $('#autocc_status').find('option:selected').val();
		var from = $('#autocc_from').val();
		var to = $('#autocc_to').val();
		var url = '<?php echo base_url(); ?>operation/filterAutoCC';
		if(from == "" || to == "")
		{}
		else
		{
			$.ajax({
				url:url,
				type:'post',
				cache:false,
				data:{
					from:from,
					to:to,
					status:status
				},
				success:function(data){
					var html = data;
					if($.trim(data) == "")
					{html= "<tr><th class='text-center'>No record found.</th><tr>";}			
					$('#details-tbl3').html(html);
				}
			});
		}
	}

	//export variance report -Van
	$(document).on('click','.var-rep',function(){
		var id = $(this).attr('id');
		var this_url =  baseUrl+'operation/print_variance_report/'+id;
		window.location = this_url;
		return false;
	});

	/* Alert (status:danger,success,info,warning) - Van */
	function showAlert(message,status){
    		var exists = $('div').hasClass('van-alert-container');
    		if(exists)
    		{
        			$alert ="<div class='none van-alert "+ status +"'>" +
                			"   <span class='closebtn' onclick='removeElement(this.parentElement);'>&times;</span>"+message +
                			"</div>";
        			$('.van-alert-container').append($alert);
    		}
    		else
    		{
        			$alert = "<div class='van-alert-container' style='z-index:1051;'>"+
                			"   <div class='none van-alert "+ status +"'>" +
                			"     <span class='closebtn' onclick='removeElement(this.parentElement);'>&times;</span>"+ message +
                			"   </div>"+
                			" </div>";
        			$('body').append($alert);
    		}
    		$('.van-alert').fadeIn(function(){
        			//let fade = setTimeout(() => removeElement($(this)),30000);
    		});
	}

	function removeAlerts(){
    		$.each($('.van-alert'),function(){
        			removeElement($(this));
    		});
	}

	function removeElement(element){
    		$(element).fadeOut("slow",function(){
        			$(element).remove();
    		});
	}

	//modal hide/show main scrollbar -Van
	$('#myModal,#myModalpostedcc').on('hidden.bs.modal', function (e) {
  		$('html').css('overflow-y','auto');
	});
	$('#myModal,#myModalpostedcc').on('shown.bs.modal', function (e) {
  		$('html').css('overflow-y','hidden');
	});
</script>