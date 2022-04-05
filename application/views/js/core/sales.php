<script>
$(document).ready(function(){
	<?php if($use_js == 'salesPersonsFormContainerIIIJs'): ?>
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
			var selected = $('#gc_idx').val();
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
			var item_id = $('#gc_idx').val();
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
		
	
	<?php elseif($use_js == 'DataTrackJS'): ?>

		$('#file-spinner').hide();	

		$('#trackD').click(function(){
			$('#file-spinner').show();
			 var barcode = $('#barcode').val();
			 var branch = $('#branch').val();
			 var description = $('#description').val();
		  if(branch){
		  			
					if(barcode == '' && description =='' ){
						rMsg('Occurence should not be empty!');
						$('#Barcode').focus();
					}else{
					var display_url = baseUrl + 'sales/GetDataCenter';
					 $.post(display_url,{'barcode':barcode,'branch':branch,'description':description}, function(data){
					 		$('#file-spinner').hide();	
							$('#div-results12').html(data);
						 });
					}
					 return false;	

			 }else{
			 	
			 	var res  = confirm("You have not selected a branch. This will take time to load. Are you sure you want to continue ?");

			 	if( res == true ){

                	if(barcode == '' && description =='' ){
						rMsg('Occurence should not be empty!');
						$('#Barcode').focus();
						 $('#file-spinner').hide();	
					}else{
					var display_url = baseUrl + 'sales/GetDataCenter';
					 $.post(display_url,{'barcode':barcode,'branch':branch,'description':description}, function(data){
					 		$('#file-spinner').hide();	
							$('#div-results12').html(data);
						 });
					}
					 return false;	
                  
               }else{
                 $('#file-spinner').hide();	
                  return false;
               }
			 		

			 }			 
		});



	<?php elseif($use_js == 'SMARTPOS'): ?>


		$('#exportsmartpos').click(function(){		
		
			var this_url = '<?php echo base_url() ?>sales/Smart_exportAll';
			var datarange = $('#daterange').val;
			if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						formData = $('#smart').serialize();
						window.location = this_url+'?'+formData;

					   }
	   		return false;	
		
			});


	<?php elseif($use_js == 'SPECIALFRESH'): ?>


		$('#exportsmartpos').click(function(){		
		
			var this_url = '<?php echo base_url() ?>sales/Special_exportAll';
			var datarange = $('#daterange').val;
			var br = $('#br').val;
			if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						formData = $('#smart').serialize();
						window.location = this_url+'?'+formData;

					   }
	   		return false;	
		
	});




	<?php elseif($use_js == 'updCsalesJs'): ?>

			$('.upd_link').click(function(){
					var id  = $(this).attr('id');

					var display_url = baseUrl + 'sales/update_cost_fsales';
					 var this_btn = $(this);
					 disable_button(this_btn, 'btn-primary');
					 $.post(display_url,{'id':id}, function(data){
					 //alert(data);
					  enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
					 rMsg('Sales cost has been updated');
					 		window.location.reload();
				//	$('#updater').show();
				 });

			});





	<?php elseif($use_js == 'CsalesJs'): ?>


		$('.upd_link').click(function(){
					var id  = $(this).attr('id');
  					var this_btn = $(this);
					var display_url = baseUrl + 'sales/update_cost_fsales';
					disable_button(this_btn, 'btn-primary');

					 $.post(display_url,{'id':id}, function(data){
					 //	alert(data);
					  enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
					 		rMsg('Sales cost has been updated');
					 		window.location.reload();
				//	$('#updater').show();
				 });

			});


		//$('#updater').hide();

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
			// my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
		}


	$('#searchUpER').click(function(){
		 var branch = $('#branch').val();
		 var ProductID = $('#ProductID').val();
		 var LineID = $('#LineID').val();

		
		if(ProductID == '' || branch == '' || LineID == ''  ){
				rMsg('Occurence should not be empty!');
				$('#ProductID').focus();
			}
			else{
				
			 var this_btn = $(this);	
			 disable_button(this_btn, 'btn-primary');

			var display_url = baseUrl + 'sales/get_fsales_data_ER';
			 $.post(display_url,{'branch':branch,'ProductID':ProductID,'LineID':LineID}, function(data){
					enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
					$('#finishedsales_data_er').html(data);
					
				//	$('#updater').show();
				 });
			}
			 return false;


	});

// View Finished Sales

	$('#search').click(function(){

	 var from  = $('#from_date').val();
	 var to = $('#t_date').val();
	 var barcode = $('#barcode').val();
				
			 var this_btn = $(this);	
			 disable_button(this_btn, 'btn-primary');

			var display_url = baseUrl + 'sales/load_finished_sales_data';
			 $.post(display_url,{'from':from,'to':to,'barcode':barcode}, function(data){
					 enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
					$('#finishedsales_data').html(data);
				 });
			 return false;

			});

	$('#print_excel_btn').click(function(e){
		e.preventDefault();
		var user_branch = $('#user_branch').val();
		var from_date = $('#from_date').val();
		var t_date = $('#t_date').val();
		var barcode = $('#barcode').val();
		var this_url =  baseUrl+'sales/print_check_sales?user_branch='+user_branch+'&from_date='+from_date+'&t_date='+t_date+'&barcode='+barcode;
				window.location = this_url;
			});
// View Finished Sales

		//**********######QTY UPDATER########************//

		$('#updateqty').click(function(){
			 var branch = $('#branchqty').val();
			 var ProductID = $('#ProductIDqty').val();
			 var LineID = $('#LineIDqty').val();	
			 var Qty = $('#Qty').val();	
			 var Packing = $('#Packing').val();	
			 var TotalQty = $('#TotalQty').val();


			if(branch == '' ||  ProductID =='' || LineID == '' || Qty == '' || Packing == '' || TotalQty == ''){

				rMsg('Occurence should not be empty!');

			}else{



			var this_btn = $(this);	
			 disable_button(this_btn, 'btn-primary');


					var display_url = baseUrl + 'sales/update_qty_fsales';
					 $.post(display_url,
					 	{
					 		'branch':branch,
					 		'ProductID':ProductID,
					 		'LineID':LineID,
					 		'Qty':Qty,
					 		'Packing':Packing,
					 		'TotalQty':TotalQty,

						}, function(data){
								alert(data);
						enable_button(this_btn, 'Update Qty', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
					 });

				

			}

		


		});


//**********######COST UPDATER########************//

		$('#updatecost').click(function(){
			//alert('dd');
				 var branch = $('#branchcost').val();
				 var ProductID = $('#ProductIDcost').val();
				 var From = $('#dfrom').val();
				 var To = $('#dto').val();

				// alert(From);
				// alert(To);
				
				if(ProductID == '' || branch == '' || From == '' || To == ''  ){
						rMsg('Occurence should not be empty!');
						$('#ProductID').focus();
					}
					else{
						
					 var this_btn = $(this);	
					 disable_button(this_btn, 'btn-primary');

					var display_url = baseUrl + 'sales/add_view_upcost';
					 $.post(display_url,{'branch':branch,
								 		 'ProductID':ProductID,
								 		 'From':From,
								 		 'To':To}, function(data){
							enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
							$('#finishedsales_data_er').html(data);
						//	$('#updater').show();
						 });
					}
					 return false;


		});


		$('#updatecost_').click(function(){
			 var branch = $('#branchcost').val();
			 var ProductID = $('#ProductIDcost').val();
			 var From = $('#dfrom').val();
			 var To = $('#dto').val();


			 if(branch == '' ||  ProductID =='' || From == '' || To == '' ){

				rMsg('Occurence should not be empty!');

			}else{


			 var this_btn = $(this);	
			 disable_button(this_btn, 'btn-primary');

					var display_url = baseUrl + 'sales/update_cost_fsales';
					 $.post(display_url,
					 	{
					 		'branch':branch,
					 		'ProductID':ProductID,
					 		'From':From,
					 		'To':To
						}, function(data){
								alert(data);
						enable_button(this_btn, 'Update Cost ', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');	 
				 });
				
			}

		});



	<?php elseif($use_js == 'CustomerJS'): ?>

			 $('#smart').click(function(){

					var this_url = '<?php echo base_url() ?>sales/Category_smart_exportAll';
					var datarange = $('#daterange').val;

					if(daterange == ''){
						rMsg('Occurence should not be empty!','warning');
						$('#daterange').focus();
					}
					else{
								formData = $('#search_form5').serialize();
								window.location = this_url+'?'+formData;

							   }
			   		return false;		

			 });



	<?php elseif($use_js == 'OverstockJs'): ?>
	$("[data-toggle='offcanvas']").click();
			function branch_reload(){
			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/overstock_branch_drop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#VendorJs').html(data);
				return false;
			});
		}

			
			$('#branch').change(function(){

				branch_reload();


			});
	<?php elseif($use_js == 'OverstockA'): ?>
		$("[data-toggle='offcanvas']").click();
		// 	function branch_reload(){
		// 	var branch = $('#branch').val();
		// 	var dtr_url = '<?php echo base_url(); ?>sales/overstock_branch_drop';
		// 	$.post(dtr_url,{'branch' : branch},function(data){
		// 		//alert(branch+'connected..'+data);
		// 		$('#VendorJs').html(data);
		// 		return false;
		// 	});
		// }

			
		// 	$('#branch').change(function(){

		// 		branch_reload();


		// 	});
			///////////////dapat happy
			
	<?php elseif($use_js == 'OverstockBranchJs'): ?>
		// 	function vendor_reload(){
		// 	var description = $('#description').val();
		// 	var dtr_url = '<?php echo base_url(); ?>sales/overstockvendor';
		// 	$.post(dtr_url,{'description' : description},function(data){
		// 		//alert(branch+'connected..'+data);
		// 		//$('#VendorJs').html(data);
		// 		return false;
		// 	});
		// }


		// 	$('#description').change(function(){

		// 		vendor_reload();



		// 	});
	<?php elseif($use_js == 'SingleJs'): ?>

			function single_reload(){
			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/Single_branch_drop';
			$.post(dtr_url,{'branch' : branch},function(data){
				// alert(branch);


				$('#SingleJs').html(data);
				return false;
			});
		}


			$('#branch').change(function(){
					
					single_reload();

				var dtr_url = '<?php echo base_url(); ?>sales/delete_vendor_list';
				$.post(dtr_url,{},function(data){

				});

			});


		

		$('#print').click(function(){		
		
			var this_url = '<?php echo base_url() ?>sales/generate_svendor_excel';
			var datarange = $('#daterange').val;
			var vendor = $('#description').val;

		 if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						 var this_btn = $(this);	
				 		 

						formData = $('#search_form').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

					 }
	   		return false;	
			
			});	


		$('#printAll').click(function(){		
		

		var this_url = '<?php echo base_url() ?>sales/generate_svendor_excel_all';
			var datarange = $('#daterange').val;
			var vendor = $('#description').val;
			
		 if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						 var this_btn = $(this);	
				 		 

						formData = $('#search_form').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

					 }
	   		return false;
			
			});	


			
			
	<?php elseif($use_js == 'SingleBranchJs'): ?>

		$('#addv').click(function(){
			//alert($('#description').val());

			vendorcode = $('#description').val();

			var display_url = baseUrl + 'sales/reloadvendorlist';
			 $.post(display_url,{'vendorcode':vendorcode}, function(data){
					$('#vendorReload').html(data);
				 });


		});	



	
	<?php elseif($use_js == 'SingleVResultJs'): ?>

	<?php elseif($use_js == 'AllVendorJs'): ?>
		// 	function allvendor_reload(){

		// 	var branch = $('#branch').val();
		// 	var dtr_url = '<?php echo base_url(); ?>sales/AllVendor_branch_drop';
		// 	$.post(dtr_url,{'branch' : branch},function(data){
		// 		//alert(branch+'connected..'+data);
		// 		$('#AllVendorJs').html(data);
		// 		return false;
		// 	});
		// }


		// 	$('#branch').change(function(){
					
		// 			allvendor_reload();


		// 	});

		// 	$("[data-toggle='offcanvas']").click();



	<?php elseif($use_js == 'AllVendorBranchJs'): ?>
	

	<?php elseif($use_js == 'OfftakeSingleJS'): ?>

			function single_reload(){
			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/OfftakeSingle_branch_drop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#OfftakeSingleJs').html(data);
				return false;
			});
		}


			$('#branch').change(function(){
					
					single_reload();


			});
				$("[data-toggle='offcanvas']").click();

	<?php elseif($use_js == 'FreshSectionTrackerJS'): ?>
		$('#file-spinner_g').hide();

		$('#btn_update').click(function(){
			 var this_btn = $(this);	
			 disable_button(this_btn, 'btn-primary');
			var count_res = $('#hidden_count').val();
			 $('#file-spinner_g').show()
			for(i = 0; i <= count_res;i++){

				if($('#hidden_srp_'+i).val() != $('#Srp_'+i).val()){
					console.log('srp updated'+$('#hidden_srp_'+i).val()+' != '+$('#Srp_'+i).val());
					var post_url = baseUrl+'sales/update_srp_branch';
					$.post(post_url, {'srp':$('#Srp_'+i).val() ,'Markup':$('#Markup_'+i).val() ,
									  'branch': $('#hidden_branch_'+i).val(),
									  'barcode': $('#hidden_barcode_'+i).val(),
									  'main_branch': $('#hidden_main_'+i).val(),
									  'productid': $('#hidden_productid_'+i).val(),
									  'uom': $('#hidden_uom_'+i).val(),
									  'old_srp': $('#hidden_srp_'+i).val(),
									  'old_markup': $('#hidden_markup_'+i).val(),
									 }, function(data){
						console.log(data);	
					});

				}else{
					console.log('srp not updated');
				}

				if($('#hidden_markup_'+i).val() != $('#Markup_'+i).val()){
					//console.log('Markup updated'+$('#hidden_markup_'+i).val()+' != '+$('#Markup_'+i).val());
					var post_url = baseUrl+'sales/update_markup_branch';
					$.post(post_url, {'srp':$('#Srp_'+i).val() ,
									  'Markup':$('#Markup_'+i).val() , 
									  'branch': $('#hidden_branch_'+i).val(),
									  'barcode': $('#hidden_barcode_'+i).val(),
									  'main_branch': $('#hidden_main_'+i).val(),
									  'productid': $('#hidden_productid_'+i).val(),
									  'uom': $('#hidden_uom_'+i).val(),
									  'old_srp': $('#hidden_srp_'+i).val(),
									  'old_markup': $('#hidden_markup_'+i).val()
									 }, function(data){
						console.log(data);	
					});
				}else{
					console.log('Markup not updated');

				}

			}
			enable_button(this_btn, 'Update', 'fa-danger', 'fa-danger', 'btn-danger', 'btn-danger');
			setTimeout(function(){
				$('#file-spinner_g').hide();
			   //window.location.reload();
			}, 1000);


		});


		$('#track').click(function(){
			var barcode = $('#barcode').val();
			if(barcode == '' ){
				rMsg('Occurence should not be empty!');
				$('#barcode').focus();
			}
			else{
				
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');

				var display_url = baseUrl + 'sales/FreshSectionTracker_results';
				 var formData = $('#search_form13').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results13').html(data);
					enable_button(this_btn, 'Track', 'fa-danger', 'fa-danger', 'btn-danger', 'btn-danger');
				 });
			}
			//$("[data-toggle='offcanvas']").click();
		});


		$('.srp').keyup(function(){

			var srp_id = $(this).attr('id');
			var srp_data = srp_id.split('_');

			num = srp_data[1];
			var srp  = $(this).val();
			var qty = 1;
			var cost  = $('#hidden_CostofSales_'+num).val();
			var new_markup = ((srp - cost * qty) / srp) * 100;
			console.log(cost);
			$('#Markup_'+num).val(new_markup.toFixed(2));
		});


	<?php elseif($use_js == 'TrackJS'): ?>
			
		$('#track').click(function(){
			var barcode = $('#barcode').val();
			if(barcode == '' ){
				rMsg('Occurence should not be empty!');
				$('#barcode').focus();
			}
			else{
				
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');

				var display_url = baseUrl + 'sales/BarcodeTracker_results';
				 var formData = $('#search_form12').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results12').html(data);
					enable_button(this_btn, 'Track', 'fa-danger', 'fa-danger', 'btn-danger', 'btn-danger');
				 });
			}
			 return false;
		});
			//$("[data-toggle='offcanvas']").click();


	<?php elseif($use_js == 'OfftakeSingleBranchJs'): ?>

	<?php elseif($use_js == 'OfftakeAllVendorJs'): ?>
			$("[data-toggle='offcanvas']").click();


	<?php elseif($use_js == "InventoryJS") :?>
	$("[data-toggle='offcanvas']").click();
			$("#chckbox").click(function(){
			var id = $(this).attr('id');
			var loosedesc = $('#qwe').val();
			var display_url = baseUrl + 'sales/inventory_results';
			var display_url1 = baseUrl + 'sales/looseinventory_results';
			var formData = $('#search_form99').serialize();
			if($(this).is(':checked'))
				$.post(display_url, formData, function(data){
				$('#div-results99').html(data);
				});			
			else
				$.post(display_url1, formData, function(data){
				$('#div-results99').html(data);
				});	
			});
			$("[data-toggle='offcanvas']").click();
	<?php elseif($use_js == "DeptInventJS") :?>
			$("#chckbox").click(function(){
			var id = $(this).attr('id');
			var loosedesc = $('#qwe').val();
			var display_url2 = baseUrl + 'sales/dept_results';
			var display_url3 = baseUrl + 'sales/deptloose_results';
			var formData = $('#search_form99').serialize();
			if($(this).is(':checked'))
				$.post(display_url2, formData, function(data){
				$('#div-results99').html(data);
				});			
			else
				$.post(display_url3, formData, function(data){
				$('#div-results99').html(data);
				});	
			});
			$("[data-toggle='offcanvas']").click();
	<?php elseif($use_js == "BrandInventJS") :?>
			$("#chckbox").click(function(){
			var id = $(this).attr('id');
			var loosedesc = $('#qwe').val();
			var display_url4 = baseUrl + 'sales/brand_results';
			var display_url5 = baseUrl + 'sales/brand_looseresults';
			var formData = $('#search_form99').serialize();
			if($(this).is(':checked'))
				$.post(display_url4, formData, function(data){
				$('#div-results99').html(data);
				});			
			else
				$.post(display_url5, formData, function(data){
				$('#div-results99').html(data);
				});	
			});
			$("[data-toggle='offcanvas']").click();
		<?php elseif($use_js == "ClassInventJS") :?>
			$("#chckbox").click(function(){
			var id = $(this).attr('id');
			var loosedesc = $('#qwe').val();
			var display_url6 = baseUrl + 'sales/country_results';
			var display_url7 = baseUrl + 'sales/classloose_results';
			var formData = $('#search_form99').serialize();
			if($(this).is(':checked'))
				$.post(display_url6, formData, function(data){
				$('#div-results99').html(data);
				});			
			else
				$.post(display_url7, formData, function(data){
				$('#div-results99').html(data);
				});	
			});
			$("[data-toggle='offcanvas']").click();
			<?php elseif($use_js == "CountryInventJS") :?>
			$("#chckbox").click(function(){
			var id = $(this).attr('id');
			var loosedesc = $('#qwe').val();
			var display_url10 = baseUrl + 'sales/country_results';
			var display_url11 = baseUrl + 'sales/country_loose';
			var formData = $('#search_form99').serialize();
			if($(this).is(':checked'))
				$.post(display_url10, formData, function(data){
				$('#div-results99').html(data);
				});			
			else
				$.post(display_url11, formData, function(data){
				$('#div-results99').html(data);
				});	
			});
			$('#countryshow').click(function(){		
			
			var this_url = '<?php echo base_url() ?>sales/country_show';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			// alert('yahooooo');
			});
		$('#countryloose').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/country_loose1';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});
		
		<?php elseif($use_js == "CategoInventJS") :?>
			$("#chckbox").click(function(){
			var id = $(this).attr('id');
			var loosedesc = $('#qwe').val();
			var display_url8 = baseUrl + 'sales/category_ILresults';
			var display_url9 = baseUrl + 'sales/category_ILooseresults';
			var formData = $('#search_form99').serialize();
			if($(this).is(':checked'))
				$.post(display_url8, formData, function(data){
				$('#div-results99').html(data);
				});			
			else
				$.post(display_url9, formData, function(data){
				$('#div-results99').html(data);
				});	
			});
	
		

	<?php elseif($use_js == 'OfftakeAllVendorBranchJs'): ?>
	<?php elseif($use_js == 'PLBranchJS'): ?>
	<?php elseif($use_js == 'InventoryListBranchJS'): ?>
		

		function plclass_reload(){

			var branch = $('#123').val();
			var dtr_url = '<?php echo base_url(); ?>sales/Categdrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#ClassJs').html(data);
				return false;
			});
		}

		function plyear_reload(){
				

			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/Yeardrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#YearJs').html(data);
				return false;
			});
		}

		function plcat_reload(){
				

			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/Categdrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#CatJs').html(data);
				return false;
			});
		}

		function plCountry_reload(){
				

			var branch = $('#brand').val();
			var dtr_url = '<?php echo base_url(); ?>sales/Countrydrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#CountryJs').html(data);
				return false;
			});
		}


		function plBrand_reload(){
				

			var branch = $('#brand').val();
			var dtr_url = '<?php echo base_url(); ?>sales/Branddrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#BrandJs').html(data);
				return false;
			});
		}


		function plDepart_reload(){
				

			var branch = $('#depart').val();
			var dtr_url = '<?php echo base_url(); ?>sales/Departmentdrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#DepartmentJs').html(data);
				return false;
			});
		}


		function plvendor_reload(){
				

			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/Productbranchdrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#ProductBranchJs').html(data);
				return false;
			});
		}


		function branchvendor_reload(){
				

			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/Inventorybranchdrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#ProductBranchJs').html(data);
				return false;
			});
		}


			$('#group').change(function(){
					
				if($('#group').val()=='vend'){

						$('#BrandJs').hide();
						$('#ProductBranchJs').show();
						$('#DepartmentJs').hide();
						$('#ClassJs').hide();
						$('#YearJs').hide();
						$('#CountryJs').hide();
						$('#CatJs').hide();	
						plvendor_reload();

				}

		});

		$('#branch').change(function(){

				branchvendor_reload();

		});


			$('#group').change(function(){
					
				if($('#group').val()=='dept'){

						$('#CatJs').hide();	
						$('#ClassJs').hide();
						$('#YearJs').hide();
						$('#CountryJs').hide();
						$('#ProductBranchJs').hide();
						$('#BrandJs').hide();
						$('#DepartmentJs').show();
						plDepart_reload();
				}	
		
		});
			
			$('#group').change(function(){
					
				if($('#group').val()=='brnd'){

						$('#CatJs').hide();
						$('#ClassJs').hide();
						$('#YearJs').hide();
						$('#CountryJs').hide();
						$('#ProductBranchJs').hide();
						$('#DepartmentJs').hide();
						$('#BrandJs').show();
						plBrand_reload();

				}

		});
			$('#group').change(function(){
					
				if($('#group').val()=='class'){

						
						$('#CatJs').hide();
						$('#ClassJs').show();
						$('#YearJs').hide();
						$('#CountryJs').hide();
						$('#DepartmentJs').hide();
						$('#BrandJs').hide();
						$('#ProductBranchJs').hide();						
						plclass_reload();

				}

		});
			$('#group').change(function(){
					
				if($('#group').val()=='year'){

						$('#CatJs').hide();
						$('#ClassJs').hide();
						$('#YearJs').show();
						$('#CountryJs').hide();
						$('#DepartmentJs').hide();
						$('#BrandJs').hide();
						$('#ProductBranchJs').hide();						
						plyear_reload();
				}	
		});
			$('#group').change(function(){
					
				if($('#group').val()=='cntry'){

						$('#CatJs').hide();	
						$('#ClassJs').hide();
						$('#YearJs').hide();
						$('#CountryJs').show();
						$('#DepartmentJs').hide();
						$('#BrandJs').hide();
						$('#ProductBranchJs').hide();						
						plCountry_reload()

				}	
		});
				$('#group').change(function(){
						

				if($('#group').val()=='categ'){

						$('#ClassJs').hide();
						$('#YearJs').hide();
						$('#CountryJs').hide();
						$('#DepartmentJs').hide();
						$('#BrandJs').hide();
						$('#ProductBranchJs').hide();
						$('#CatJs').show();						
						plcat_reload();

				}	
		});
				//////////////////////////////////////////////////////////////////////////////////////////////////replace
			
			

		<?php elseif($use_js == 'ProductListing'): ?>


		function productvendor_reload(){

		var branch = $('#group').val();
		var dtr_url = '<?php echo base_url(); ?>sales/ProductListingbranchdrop';
		$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
			$('#ProductListingBranchJs').html(data);
			return false;
			});
		}

		function plbranch_reload(){
		var branch = $('#productbranch').val();
		var dtr_url = '<?php echo base_url(); ?>sales/InventoryListingbranchdrop';
		$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
			$('#ProductListingBranchJs').html(data);
			return false;
			});
		}

		function productDepart_reload(){

			var branch = $('#pldept').val();
			var dtr_url = '<?php echo base_url(); ?>sales/ProductListingDepartmentdrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#ProductDepartmentJs').html(data);
				return false;
			});
		}
		function productbrand_reload(){

			var branch = $('#pldept').val();
			var dtr_url = '<?php echo base_url(); ?>sales/ProductListingbranddrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#ProductBrandJs').html(data);
				return false;
			});
		}
		function productclass_reload(){

			var branch = $('#pldept').val();
			var dtr_url = '<?php echo base_url(); ?>sales/ProductListingclassdrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#ProductClassJs').html(data);
				return false;
			});
		}
		function productyear_reload(){

			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/ProductListingYeardrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#ProductYearJs').html(data);
				return false;
			});
		}
		function productcountry_reload(){

			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/ProductListingCountrydrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#ProductCountryJs').html(data);
				return false;
			});
		}
		function productcategory_reload(){

			var branch = $('#branch').val();
			var dtr_url = '<?php echo base_url(); ?>sales/ProductListingCategdrop';
			$.post(dtr_url,{'branch' : branch},function(data){
				//alert(branch+'connected..'+data);
				$('#ProductCategoryJs').html(data);
				return false;
			});
		}
		$('#group').change(function(){
				if($('#group').val()=='categ'){

						$('#ProductCategoryJs').show();	
						$('#ProductListingBranchJs').hide();
						$('#ProductBrandJs').hide();
						$('#ProductDepartmentJs').hide();
						$('#ProductClassJs').hide();
						$('#ProductYearJs').hide();
						$('#ProductCountryJs').hide();
						productcategory_reload();

				}	
		});

		$('#productbranch').change(function(){

			plbranch_reload();

		})

		$('#group').change(function(){
				if($('#group').val()=='year'){

						$('#ProductYearJs').show();
						$('#ProductListingBranchJs').hide();
						$('#ProductBrandJs').hide();
						$('#ProductDepartmentJs').hide();
						$('#ProductClassJs').hide();
						$('#ProductCountryJs').hide();
						$('#ProductCategoryJs').hide();	
						productyear_reload();

				}	
		});
		$('#group').change(function(){
				if($('#group').val()=='cntry'){

						$('#ProductYearJs').hide();
						$('#ProductCountryJs').show();
						$('#ProductListingBranchJs').hide();
						$('#ProductBrandJs').hide();
						$('#ProductDepartmentJs').hide();
						$('#ProductClassJs').hide();
						$('#ProductCategoryJs').hide();	
						productcountry_reload();

				}	
		});
		$('#group').change(function(){
				if($('#group').val()=='dept'){

						$('#ProductCategoryJs').hide();	
						$('#ProductListingBranchJs').hide();
						$('#ProductBrandJs').hide();
						$('#ProductDepartmentJs').show();
						$('#ProductClassJs').hide();
						$('#ProductYearJs').hide();
						$('#ProductCountryJs').hide();
						productDepart_reload();

				}	
		});
			$('#group').change(function(){
				if($('#group').val()=='vend'){

						$('#ProductBrandJs').hide();
						$('#ProductListingBranchJs').show();
						$('#ProductDepartmentJs').hide();
						$('#ProductClassJs').hide();
						$('#ProductYearJs').hide();
						$('#ProductCountryJs').hide();
						$('#ProductCategoryJs').hide();	
						productvendor_reload();

				}

		});
			$('#group').change(function(){
				if($('#group').val()=='brnd'){

						$('#ProductCategoryJs').hide();	
						$('#ProductListingBranchJs').hide();
						$('#ProductDepartmentJs').hide();
						$('#ProductClassJs').hide();
						$('#ProductBrandJs').show();
						$('#ProductYearJs').hide();
						$('#ProductCountryJs').hide();
						productbrand_reload();

				}

		});
			$('#group').change(function(){
				if($('#group').val()=='class'){

						$('#ProductCategoryJs').hide();	
						$('#ProductListingBranchJs').hide();
						$('#ProductDepartmentJs').hide();
						$('#ProductBrandJs').hide();
						$('#ProductClassJs').show();
						$('#ProductYearJs').hide();
						$('#ProductCountryJs').hide();
						productclass_reload();

				}

		});
			$('#active').click(function(){
				if($(this).is(':checked')){
					$('#inactive').prop('checked',false);
					$('#AI').prop('checked',false);
				}
			});
			$('#inactive').click(function(){
				if($(this).is(':checked')){
					$('#active').prop('checked',false);
					$('#AI').prop('checked',false);
				}
			});
			$('#AI').click(function(){
				if($(this).is(':checked')){
					$('#inactive').prop('checked',false);
					$('#active').prop('checked',false);
				}
			});
			// $('#group').change(function(){
			// 	alert($('#group').val());
			// });
			
//==============================CHECKBOXING===================================================//
		<?php elseif($use_js == 'VendaJS'): ?>
		$("#active").click(function(){
			var id = $(this).attr('id');
			var description = $('#venda').val();
			var display_url = baseUrl + 'sales/ProductListing_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url, formData, function(data){
				$('#div-results11').html(data);
				});
			else
				$(this).attr('value',0);		
				});

		$("#cost").click(function(){
			var id = $(this).attr('id');
			var costdescription = $('#venda').val();
			var display_url = baseUrl + 'sales/ProductListingcost_results';
			var display_url1 = baseUrl + 'sales/ProductListing_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url, formData, function(data){
				$('#div-results11').html(data);
				});			
			else
				$.post(display_url1, formData, function(data){
				$('#div-results11').html(data);
				});	
				});
	
		$("#inactive").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				
				var description = $('#venda').val();
				var display_url = baseUrl + 'sales/ProductListinginac_results';
				var formData = $('#search_form11').serialize();
				$.post(display_url, formData, function(data){
				$('#div-results11').html(data);		
				});
				});

		$("#AI").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var description = $('#venda').val();
				var display_url = baseUrl + 'sales/ProductListingActinac_results';
				var formData = $('#search_form11').serialize();
				$.post(display_url, formData, function(data){
				$('#div-results11').html(data);	 
				});
				});
			
///////////////////////////////////////////////////////sablay!@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		<?php elseif($use_js == 'DeptJS'): ?>
		$("#active").click(function(){
			var id1 = $(this).attr('id');
			var department = $('#pldept').val();
			var display_url2 = baseUrl + 'sales/Productdepartment_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
			 	$.post(display_url2, formData, function(data){
				$('#div-results11').html(data);
				});
			else
				$(this).attr('value',0);
				});

		$("#cost").click(function(){
			var id1 = $(this).attr('id');
			var department = $('#pldept').val();
			var display_url2 = baseUrl + 'sales/ProductListingdepartcost_results';
			var display_url3 = baseUrl + 'sales/Productdepartment_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url2, formData, function(data){
				$('#div-results11').html(data);
				});
			else
				$.post(display_url3, formData, function(data){
				$('#div-results11').html(data);
				});
				});
	
		$("#inactive").click(function(){
			var id1 = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var department = $('#pldept').val();
				var display_url2 = baseUrl + 'sales/Productdepartmentinactive_results';
				var formData = $('#search_form11').serialize();
				$.post(display_url2, formData, function(data){
				$('#div-results11').html(data);
				});
				});

		$("#AI").click(function(){
			var id1 = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var department = $('#pldept').val();
				var display_url2 = baseUrl + 'sales/ProductdepartmentActinactive_results';
				var formData = $('#search_form11').serialize();
				$.post(display_url2, formData, function(data){
				$('#div-results11').html(data);
				});
				});
			
		//==============================BRAND===============================================================//
		<?php elseif($use_js == 'BrandJS'): ?>
		$("#active").click(function(){
			var id = $(this).attr('id');
			var brand = $('#brands').val();
			var display_url4 = baseUrl + 'sales/Productbrand_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url4, formData, function(data){
				$('#div-results11').html(data);
				});
			else
				$(this).attr('value',0);
			});
		$("#cost").click(function(){
			var id = $(this).attr('id');
			var brand = $('#brands').val();
			var display_url4 = baseUrl + 'sales/ProductListingbrandcost_results';
			var display_url5 = baseUrl + 'sales/Productbrand_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url4, formData, function(data){
				$('#div-results11').html(data);
			});	
			else
				$.post(display_url5, formData, function(data){
				$('#div-results11').html(data);
				});
			});
		$("#inactive").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var brand = $('#brands').val();
				var display_url4 = baseUrl + 'sales/BrandInactive_results';
				var formData = $('#search_form11').serialize();
				$.post(display_url4, formData, function(data){
				$('#div-results11').html(data);
				});
			});
		$("#AI").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var brand = $('#brands').val();
				var display_url4 = baseUrl + 'sales/BrandActiveInactive_results';
				var formData = $('#search_form11').serialize();
				$.post(display_url4, formData, function(data){
				$('#div-results11').html(data);
				});
			});
			
// 			////////////////////////////////////////////////////////////////////////classes
		<?php elseif($use_js == 'ClassJS'): ?>
		$("#active").click(function(){
			var id = $(this).attr('id');
			var class1 = $('#clss').val();
			var display_url6 = baseUrl + 'sales/Productclass_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url6, formData, function(data){
				$('#div-results11').html(data);
				});
			else
				$(this).attr('value',0);
				});

		$("#cost").click(function(){
			var id = $(this).attr('id');
			var class1 = $('#clss').val();
			var display_url6 = baseUrl + 'sales/Productclasscost_results';
			var display_url7 = baseUrl + 'sales/Productclass_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url6, formData, function(data){
				$('#div-results11').html(data);	
				});
			else
				$.post(display_url7, formData, function(data){
				$('#div-results11').html(data);
				});
			});
		$("#inactive").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var class1 = $('#clss').val();
				var display_url6 = baseUrl + 'sales/Productclass_inactive';
				var formData = $('#search_form11').serialize();
				$.post(display_url6, formData, function(data){
				$('#div-results11').html(data);
				});
			});
		$("#AI").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var class1 = $('#clss').val();
				var display_url6 = baseUrl + 'sales/class_Actinactive1';
				var formData = $('#search_form11').serialize();
				$.post(display_url6, formData, function(data){
				$('#div-results11').html(data);
				});
			});
				
		//====================================================================================================

		<?php elseif($use_js == 'YearsJS'):?>
			$("#active").click(function(){
			var id = $(this).attr('id');
			var year = $('#year').val();
			var display_url6 = baseUrl + 'sales/Productyear_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url6, formData, function(data){
				$('#div-results11').html(data);
				});
			else
				$(this).attr('value',0);
				});

		$("#cost").click(function(){
			var id = $(this).attr('id');
			var class1 = $('#clss').val();
			var display_url6 = baseUrl + 'sales/Productclasscost_results';
			var display_url7 = baseUrl + 'sales/Productclass_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url6, formData, function(data){
				$('#div-results11').html(data);	
				});
			else
				$.post(display_url7, formData, function(data){
				$('#div-results11').html(data);
				});
			});
		$("#inactive").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var class1 = $('#clss').val();
				var display_url6 = baseUrl + 'sales/Productinactiveyear_results';
				var formData = $('#search_form11').serialize();
				$.post(display_url6, formData, function(data){
				$('#div-results11').html(data);
				});
			});
		$("#AI").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var class1 = $('#clss').val();
				var display_url6 = baseUrl + 'sales/ProductActinactiveyear_results';
				var formData = $('#search_form11').serialize();
				$.post(display_url6, formData, function(data){
				$('#div-results11').html(data);
				});
			});
					
// ///////////////////////////////////////////////////class end
	<?php elseif($use_js == 'CountryJs'): ?>
		$("#active").click(function(){
			var id = $(this).attr('id');
			var country = $('#country').val();
			var display_url8 = baseUrl + 'sales/Productcountry_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url8, formData, function(data){
				$('#div-results11').html(data);
				});
			else
				$(this).attr('value',0);
				});

		$("#cost").click(function(){
			var id = $(this).attr('id');
			var class1 = $('#country').val();
			var display_url8 = baseUrl + 'sales/Productcountrycost_results';
			var display_url9 = baseUrl + 'sales/Productcountry_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url8, formData, function(data){
				$('#div-results11').html(data);	
				});
			else
				$.post(display_url9, formData, function(data){
				$('#div-results11').html(data);
				});
			});

		$("#inactive").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var country = $('#country').val();
				var display_url8 = baseUrl + 'sales/Country_inactive';
				var formData = $('#search_form11').serialize();
				$.post(display_url8, formData, function(data){
				$('#div-results11').html(data);	
				});
			});
		$("#AI").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var country = $('#country').val();
				var display_url8 = baseUrl + 'sales/Country_active_inactive';
				var formData = $('#search_form11').serialize();
				$.post(display_url8, formData, function(data){
				$('#div-results11').html(data);
				});
			});	
			
// 		///////////////////////////////////////////////////class edn
// 		$("#active").click(function(){
// 			var id = $(this).attr('id');
// 			var department = $('#year').val();
// 			var display_url = baseUrl + 'sales/Productyear_results';
// 			var formData = $('#search_form11').serialize();
// 			if($(this).is(':checked'))
// 				$.post(display_url, formData, function(data){
// 				$('#div-results11').html(data);	
// 				});
// 			else
// 				$(this).attr('value',1);
// 				});

// 		$("#inactive").click(function(){
// 			var id = $(this).attr('id');
// 			if($(this).is(':checked'))
// 				$(this).attr('value',1);
// 			else
// 				$(this).attr('value',0);
// 				var description = $('#year').val();
// 				var display_url = baseUrl + 'sales/Productyear_results';
// 				var formData = $('#search_form11').serialize();
// 				$.post(display_url, formData, function(data){
// 				$('#div-results11').html(data);	
// 				});
// 				});

// 		$("#AI").click(function(){
// 			var id = $(this).attr('id');
// 			if($(this).is(':checked'))
// 				$(this).attr('value',1);
// 			else
// 				$(this).attr('value',0);
// 				var description = $('#year').val();
// 				var display_url = baseUrl + 'sales/Productyear_results';
// 				var formData = $('#search_form11').serialize();
// 				$.post(display_url, formData, function(data){
// 				$('#div-results11').html(data);
// 				});
// 				});
// ///////////////////////////////////////////////////categ
	<?php elseif($use_js == 'CategoryJS'): ?>
		$("#active").click(function(){
			var id = $(this).attr('id');
			var category = $('#category').val();
			var display_url10 = baseUrl + 'sales/Productcateg_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url10, formData, function(data){
				$('#div-results11').html(data);
				});
			else
				$(this).attr('value',0);
			});
		$("#cost").click(function(){
			var id = $(this).attr('id');
			var category = $('#category').val();
			var display_url10 = baseUrl + 'sales/Productcategcost_results';
			var display_url11 = baseUrl + 'sales/Productcateg_results';
			var formData = $('#search_form11').serialize();
			if($(this).is(':checked'))
				$.post(display_url10, formData, function(data){
				$('#div-results11').html(data);	
				});
			else
				$.post(display_url11, formData, function(data){
				$('#div-results11').html(data);
				});
			});
		$("#inactive").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var category = $('#category').val();
				var display_url10 = baseUrl + 'sales/Categinactive_results';
				var formData = $('#search_form11').serialize();
				$.post(display_url10, formData, function(data){
				$('#div-results11').html(data);
				});
			});
		$("#AI").click(function(){
			var id = $(this).attr('id');
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);
				var category = $('#category').val();
				var display_url10 = baseUrl + 'sales/Categactinc';
				var formData = $('#search_form11').serialize();
				$.post(display_url10, formData, function(data){
				$('#div-results11').html(data);
				});
			});
			
//============================================================================CHECKBOXING=========================================================================================//

	<?php elseif($use_js == 'salesPersonsDetailsJs'): ?>
		$('#save-btn').click(function(){
			$("#gift_cards_details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										// alert(data);
										rMsg(data.msg,'success');
									}
			});

			setTimeout(function(){
				window.location.reload();
			},1500);

			return false;
		});

		$('#card_no, #amount')
		.keyboard({
			alwaysOpen: false,
			usePreview: false
		})
		.addNavigation({
			position   : [0,0],
			toggleMode : false,
			focusClass : 'hasFocus'
		});

	<?php elseif($use_js == 'giftCardsJs'): ?>
		$('#new-gift-card-btn').click(function(){
			// alert('New Customer Button');
			window.location = baseUrl+'gift_cards/cashier_gift_cards';
			return false;
		});

		$('#look-up-btn').click(function(){
			// alert('Look up button');

			var this_url =  baseUrl+'gift_cards/gift_cards_list';
			$.post(this_url, {},function(data){
				$('.gc_content_div').html(data);
				// $('#cardno').attr({'value' : ''}).val('');

				$('.edit-line').click(function(){
					var line_id = $(this).attr('ref');
					var cardno = $(this).attr('cardnoref');
					var thisurl = baseUrl+'gift_cards/load_gift_cards_details';
					// alert('edit to : '+line_id);

					$.post(thisurl, {'cardno' : cardno}, function(data1){
						$('.gc_content_div').html(data1);
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

		$('#cardno').focus(function(){
			$('#cardno').attr({'value' : ''}).val('');
			return false;
		});

		$('#cardno-login').click(function(){
			var cardno = $('#cardno').val();
			var this_url =  baseUrl+'gift_cards/validate_card_number';
			// alert('asdfg---'+cardno);

			$.post(this_url, {'cardno' : cardno}, function(data){
				// alert(data);
				var parts = data.split('||');
				// alert('eto:'+parts[1]);
				if(parts[0] == 'empty'){
					rMsg('Text field is empty!','error');
					// setTimeout(function(){
						// window.location.reload();
					// },1500);
				}else if(parts[0] == 'none'){
					rMsg('Gift Card does not exist.','error');
					// setTimeout(function(){
						// window.location.reload();
					// },1500);
				}else if(parts[0] == 'success'){
					rMsg('Loading Gift Card Details...','success');

					setTimeout(function(){
						var this_url2 =  baseUrl+'gift_cards/load_gift_cards_details';
						$.post(this_url2, {'cardno' : parts[1]},function(data){
							$('.gc_content_div').html(data);
							// $('#cardno').attr({'value' : ''}).val('');
							return false;
						});
					},1500);

				}
			});

			return false;
		});

		function loadGiftCardDetails(){
			var this_url =  baseUrl+'gift_cards/gift_cards_load';

			$.post(this_url, {},function(data){
				$('.gc_content_div').html(data);
				$('#cardno').focus();
				return false;
			});
		}

		loadGiftCardDetails();

	<?php elseif($use_js == 'salesTypeJS'): ?>
		$("#tax_included").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				$(this).attr('value',1);
			else
				$(this).attr('value',0);

		});
	<?php elseif($use_js == 'directInvoiceHeaderJS'): ?>
		loader('#details_link');
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var so_id = $('#so_id').val();

			if(so_id == ""){
				disEnbleTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			}
			else{
				disEnbleTabs('.load-tab',true);
			}
			$(tabPane).rLoad({url:baseUrl+loadUrl+so_id});
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
	<?php elseif($use_js == 'custPaymentHeaderJS'): ?>
		loader('#details_link');
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var so_id = $('#so_id').val();

			if(so_id == ""){
				disEnbleTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			}
			else{
				disEnbleTabs('.load-tab',true);
			}
			$(tabPane).rLoad({url:baseUrl+loadUrl+so_id});
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
	<?php elseif($use_js == 'salesOrderHeaderJS'): ?>
		var so_id = $('#_main_so_id').val();

		$("#div-so-steps").steps({
		    headerTag: "h3",
		    bodyTag: "section",
		    transitionEffect: "slide",
		    enableAllSteps: true,
		    saveState:true,
		    onStepChanging: function (event, currentIndex, newIndex)
		    {
		    	if (currentIndex > newIndex)
		    		return true;

		    	switch (newIndex) {
		    		case 1 :
		    			if (!so_id) {
		    				rMsg('Please provide Sales Order information','error');
		    				return false;
		    			}
		    			return true;
		    			break;
		    		case 2 :
		    			rMsg('Please wait','warning');
		    			window.location = baseUrl+'sales/order_dispatch/'+so_id;
		    			return true;
		    			break;
		    		default :
		    			return true;
		    	}
			}
		});
	<?php elseif($use_js == 'cpHeaderDetailsLoadJs'): ?>
		$('#save-soheader').click(function(event){
			event.preventDefault();
			// alert('boom');
			$("#so_header_details_form").rOkay({
				btn_load		: 	$('#save-soheader'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										// alert(data);

											// $('#so_id').val(data.id);

											// disEnbleTabs('.load-tab',true);
											// rMsg(data.msg,'success');

									}
			});
			location.reload();
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
		$('#debtor_id').on('change',function()
		{
			var debtor_id = $(this).val();
			var passUrl = baseUrl + 'sales/get_customer_branches/' + debtor_id;
			if(debtor_id == ''){
				// alert('no cust');
				//$('#debtor_branch_id').selectedIndex(1);
				$('#debtor_branch_id').empty();
			}else{
				$('#debtor_branch_id').empty();
				$.post(passUrl,'',function(data)
				{
					// alert(data);
					str = '<option value="">Select customer branch</option>';
					$.each(data,function(key,value)
					{
						str = str + "<option value='" + value.id + "' badd='" + value.address + "'>" + value.name + "</option>";
					});
					$('#debtor_branch_id').append(str);
				},'json');
			}
		});
		$('#debtor_id').change();
		$('#bank_payment_type').on('change',function(event)
		{
			if ($(this).val() == 'Check') {
				$('div#div-chk-dep').show('fast');
			} else {
				$('div#div-chk-dep').hide('fast');
			}
		});
	<?php elseif($use_js == 'soHeaderDetailsLoadJs'): ?>
	//alert('zxczxc');
		$('#save-soheader').click(function(event){
			event.preventDefault();
			$("#so_header_details_form").rOkay({
				btn_load		: 	$('#save-soheader'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
					// alert(data);
											// alert(data.id);
											// $('#_main_so_id').attr('value',data.id);
											$('#_main_so_id').val(data.id);

											window.location = baseUrl+'sales/sales_order_form/'+data.id;
											// alert($('#_main_so_id').val());
											// disEnbleTabs('.load-tab',true);
											//rMsg(data.msg,'success');
											// $('#so_items_link').click();
									}
			});
		});
		$('#debtor_id').on('change',function()
		{
			var debtor_id = $(this).val();
			var passUrl = baseUrl + 'sales/get_customer_branches/' + debtor_id;
			// if(debtor_id == ''){
				// alert('no cust');
				//$('#debtor_branch_id').selectedIndex(1);
			$('#debtor_branch_id').empty();
			// }else{
			if (debtor_id != ''){
				$.post(passUrl,'',function(data)
				{
					// alert(data)
					str = '<option value="">Select customer branch</option>';
					$.each(data,function(key,value)
					{
						str = str + "<option value='" + value.id + "' badd='" + value.address + "'>" + value.name + "</option>";
					});
					$('#debtor_branch_id').append(str);
				},'json');
			}
		});
		$('#debtor_branch_id').on('change',function()
		{
			var badd = $('option:selected', this).attr('badd');
			$('#delivery_address').val(typeof badd !== typeof undefined && badd !== false ? badd : '');
		});
		$('#debtor_id').change();
	<?php elseif($use_js == 'diHeaderDetailsLoadJs'): ?>

		$('#save-soheader').click(function(){
			$("#so_header_details_form").rOkay({
				btn_load		: 	$('#save-soheader'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										//alert(data);

											$('#_main_so_id').val(data.id);

											disEnbleTabs('.load-tab',true);
											rMsg(data.msg,'success');
									}
			});
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
		$('#debtor_id').on('change',function()
		{
			var debtor_id = $(this).val();
			var passUrl = baseUrl + 'sales/get_customer_branches/' + debtor_id;
			if(debtor_id == ''){
				// alert('no cust');
				//$('#debtor_branch_id').selectedIndex(1);
				$('#debtor_branch_id').empty();
			}else{
				$('#debtor_branch_id').empty();
				$.post(passUrl,'',function(data)
				{
					// alert(data);
					str = '<option value="">Select customer branch</option>';
					$.each(data,function(key,value)
					{
						str = str + "<option value='" + value.id + "' badd='" + value.address + "'>" + value.name + "</option>";
					});
					$('#debtor_branch_id').append(str);
				},'json');
			}
		});
		$('#debtor_id').change();
	<?php elseif($use_js == 'diItemsLoadJs'): ?>

		$('#item').change(function(){
			set_item_details($(this).val());
		});

		function set_item_details(id){
			$.post(baseUrl+'sales/get_di_item_details/'+id,function(data){
				$('#item-id').val(data.item_id);
				$('#item-uom').val(data.uom);
				$('#select-uom').find('option').remove();
				$.each(data.opts,function(key,val){
					$('#select-uom').append($("<option/>", {
				        value: val,
				        text: key
				    }));
				});
				// $('#item-ppack').val(data.ppack);
				// $('#item-pcase').val(data.pcase);
			// });
			},'json');
		}

		$('#add-item-btn').click(function(){
			$("#so_items_form").rOkay({
				btn_load		: 	$('#add-item-btn'),
				asJson			: 	true,
				onComplete		:	function(data){
										// alert(data);
										if(data.act == 'add'){
											$('#details-tbl').append(data.row);
											rMsg(data.msg,'success');
										}
										else{
											var i = $('#row-'+data.id);
											$('#row-'+data.id).remove();
											$('#details-tbl').append(data.row);
											rMsg(data.msg,'success');
										}
										remove_row(data.id);
									}
			});
			$('.input_form').val('').removeAttr('selected');;
			return false;
		});

		$('.dels').each(function(){
			var id = $(this).attr('ref');
			remove_row(id);
		});

		function remove_row(id){
			$('#del-'+id).click(function(){
				$.post(baseUrl+'sales/remove_di_item','so_item_id='+id,function(data){
					$('#row-'+id).remove();
					rMsg(data.msg,'warning');
				},'json');
				return false;
			});
		}
	<?php elseif($use_js == 'soItemsLoadJs'): ?>
		// $("input[class='this_item']").focus();
		// alert($("input[class='this_item']").length);
		// $('#item').focus();
		$('#item').change(function(){
			set_item_details($(this).val());
		});

		function set_item_details(id){
			$.post(baseUrl+'sales/get_item_details/'+id,function(data){
				$('#item-id').val(data.item_id);
				$('#item-uom').val(data.uom);
				//alert('Stock ID:'+id);
				if(id!=''){
					//alert('asd'+id);
					$('#item-price').val(data.price).attr({'value' : data.price});
					$('#unit_price').val(data.price).attr({'value' : data.price});
					$('#qoh').val(data.qoh);
					$('#select-uom').find('option').remove();
					$.each(data.opts,function(key,val){
						$('#select-uom').append($("<option/>", {
							value: val,
							text: key
						}));
					});
				} else{
					//alert('def'+id);
					$('#select-uom').empty();
					$('#item-price').val(0).attr({'value' : 0});
					$('#unit_price').val(0).attr({'value' : 0});
					$('#qoh').val(0).attr({'value' : 0});
				}
			},'json');
		}

		$('#add-item-btn').click(function(){
			$("#so_items_form").rOkay({
				btn_load		: 	$('#add-item-btn'),
				asJson			: 	true,
				onComplete		:	function(data){
										if(data.act == 'add'){
											$('#details-tbl').append(data.row);
											rMsg(data.msg,'success');

											if (typeof data.underpriced_msg != 'undefined')
												rMsg(data.underpriced_msg,'warning');
										}
										else{
											var i = $('#row-'+data.id);
											$('#row-'+data.id).remove();
											$('#details-tbl').append(data.row);
											rMsg(data.msg,'success');
										}
										remove_row(data.id);
									}
			});
			$('.input_form').val('').removeAttr('selected');
			$('input.combobox.this_item[type="text"]').focus();
			return false;
		});

		$('#add-non-stock-item-btn').click(function(event)
		{
			event.preventDefault();

			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_INFO,
				title: 'ADD HARDWARE ITEM',
	            message: function(dialog) {
	            	var $message = $('<div></div>');
	            	var pageToLoad = dialog.getData('pageToLoad');
	            	$message.load(pageToLoad);

	            	return $message;
	            },
	            data: {
	            	'pageToLoad': baseUrl+'sales/show_add_non_stock_item/' + $('#so_id').val()
	            },
	            buttons: [
	            	{
	            		icon: 'fa fa-plus',
	            		label: ' Add item',
	            		cssClass: 'btn-lg btn-success',
	            		action: function(thisDialog)
	            		{
	            			var $button = this;
	            			$('#frm-non-stock').rOkay({
								btn_load		: 	$button,
								bnt_load_remove	: 	true,
								asJson			: 	true,
								div_load		: 	$('#div-results'),
								div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
								onComplete		:	function(data){
														// $('.data-table').bDestroy();

														if (data.error == 1) {
															rMsg(data.msg,'warning');
															return true;
														}

														if(data.act == 'add'){
															$('#details-tbl').append(data.row);
															rMsg(data.msg,'success');

															if (typeof data.underpriced_msg != 'undefined')
																rMsg(data.underpriced_msg,'warning');
														}
														else{
															var i = $('#row-'+data.id);
															$('#row-'+data.id).remove();
															$('#details-tbl').append(data.row);
															rMsg(data.msg,'success');
														}
														remove_row(data.id);
														thisDialog.close();
													}
					        });
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

		$('.dels').each(function(){
			var id = $(this).attr('ref');
			remove_row(id);
		});
		function remove_row(id){
			$('#del-'+id).click(function(){
				$.post(baseUrl+'sales/remove_so_item','so_item_id='+id,function(data){
					$('#row-'+id).remove();
					rMsg(data.msg,'warning');
				},'json');
				return false;
			});
		}
		setTimeout(function(){
			if ($('input.combobox.this_item[type="text"]').length) {
				$('input.combobox.this_item[type="text"]').focus();
			}
		},350);
	<?php elseif($use_js == "nonStockLoadJs") :?>
		var hardware_opts = {
	        ajax: {
	            url: baseUrl+'sales/search_non_stock_items',
	            type: 'POST',
	            dataType: 'json',
	            data: {
	                q: '{{{q}}}'
	            }
	        },
	        locale: {
	            emptyTitle: 'Select to search hardware items'
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
	    $('#hd_item_code').selectpicker().filter('.with-ajax').ajaxSelectPicker(hardware_opts);
	    $('#hd_item_code').on('change',function(event)
		{

			$('input#item_code').val('');
			$('input#item_name').val('');
			$('#description').val('');
			$('select#item_tax_type').val('');
			$('select#uom_id').val('');
			$('input#qoh').val('');
			$('select#loc_code').val('');

			$('input#item_code').removeAttr('readOnly');
			$('input#name').removeAttr('readOnly');
			$('#description').removeAttr('readOnly');
			$('select#item_tax_type').removeAttr('readOnly');
			$('select#uom_id').removeAttr('readOnly');
			$('input#qoh').removeAttr('readOnly');
			$('select#loc_code').removeAttr('readOnly');

			$.post(baseUrl+'sales/result_non_stock_items',{'item_id':$(this).val()},function(data){
				$('input#item_code').val(data.item_code);
				$('input#name').val(data.name);
				$('#description').val(data.description);
				$('select#item_tax_type').val(data.item_tax_type);
				$('select#uom_id').val(data.uom_id);
				$('input#qoh').val(data.qoh);
				$('select#loc_code').val('');

				if (typeof data.item_code != 'undefined' && data.item_code.length > 0) {
					$('input#item_code').attr('readOnly','readOnly');
					$('input#name').attr('readOnly','readOnly');
					$('#description').attr('readOnly','readOnly');
					$('select#item_tax_type').attr('readOnly','readOnly');
					$('select#uom_id').attr('readOnly','readOnly');
					$('input#qoh').attr('readOnly','readOnly');
					$('select#loc_code').attr('readOnly','readOnly');
				}
			},'json');
				// });
		});
	<?php elseif($use_js == "salesOrderSearchJs") :?>
		$("[data-toggle='offcanvas']").click();
		$('input.daterangepicker').daterangepicker({separator:' to '});

		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#sales_order_search_form').rOkay(
			{
				btn_load		: 	$('#btn-search'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				div_load			: 	$('#div-results'),
				div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
				onComplete		:	function(data){
										// $('.data-table').bDestroy();
										$('#div-results').empty();
										$('#div-results').html(data);
										// if ($('.data-table').length)
										// 	$('.data-table').each(function()
										// 		{
										// 			$(this).dataTable({
										// 		        "bPaginate": true,
										// 		        "bLengthChange": true,
										// 		        "bFilter": true,
										// 		        "bSort": true,
										// 		        "bInfo": true,
										// 		        "bAutoWidth": false,
										// 		        "aaSorting":[]
										// 		    });
										// 		});
										// if (typeof data.result != 'null') {
										// 	if (data.result == 'error') {
										// 		rMsg(data.msg,'error');
										// 		return false;
										// 	}


										// }
									}
			});
		});

		// $('#type_no').selectize({

		// });
		// $('#debtor_id').on('change',function(event)
		// {
		// 	var m_debtor_id = $(this).val();
		// 	var form_data = 'debtor_id='+m_debtor_id;
		// 	$('#div-form').prop('disabled',true);
		// 	$.post(baseUrl + 'sales/get_customer_branches2',form_data,function(data)
		// 	{
		// 		$('#cust-branch-div').empty().html(data);
		// 		$('#debtor_branch_id').combobox();
		// 		$('#div-form').removeAttr('disabled');
		// 	});
		// });
		// $('#debtor_id').trigger('change');
	<?php elseif($use_js == "salesOrderResultsJs") :?>
		$('a.lnk-approve-so').click(function(event)
		{
			event.preventDefault();
			var ref = $(this).attr('ref');

			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_INFO,
				title: 'SALES ORDER APPROVAL',
	            message: 'Are you sure you want to approve Sales Order # ' + ref + '?',
	            buttons: [
	            	{
	            		icon: 'fa fa-check',
	            		label: ' Yes',
	            		cssClass: 'btn-lg btn-success',
	            		action: function()
	            		{
	            			var $button = this;

	            			$button.disable();
	            			$button.spin();
	            			$.post(baseUrl + 'sales/approve_sales_order', 'ref='+ref, function(data)
	            			{
	            				location.reload();
	            			});
	            		}
	            	},
	            	{
	            		label: 'No',
	            		cssClass: 'btn-lg',
	            		action: function (thisDialog)
	            		{
	            			thisDialog.close();
	            		}
	            	}
	            ]
	        });
		});
		$('a.lnk-decline-so').click(function(event)
		{
			event.preventDefault();
			var ref = $(this).attr('ref');

			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_WARNING,
				title: 'SET SALES ORDER AS INACTIVE # ' + ref,
	            message: 'Proceeding  will make Sales Order # ' + ref + ' inactive. Do you want to proceed?',
	            buttons: [
	            	{
	            		icon: 'fa fa-check',
	            		label: ' Yes',
	            		cssClass: 'btn-lg btn-warning',
	            		action: function()
	            		{
	            			var $button = this;

	            			$button.disable();
	            			$button.spin();
	            			$.post(baseUrl + 'sales/reject_sales_order', 'ref='+ref, function(data)
	            			{
	            				location.reload();
	            			});
	            		}
	            	},
	            	{
	            		label: 'No',
	            		cssClass: 'btn-lg',
	            		action: function (thisDialog)
	            		{
	            			thisDialog.close();
	            		}
	            	}
	            ]
	        });
		});
		$('a.lnk-complete-so').click(function(event)
		{
			event.preventDefault();
			var ref = $(this).attr('ref');

			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_SUCCESS,
				title: 'COMPLETE SALES ORDER # ' + ref,
	            message: 'Proceeding  will complete Sales Order # ' + ref + '. Do you want to proceed?',
	            buttons: [
	            	{
	            		icon: 'fa fa-check',
	            		label: ' Yes',
	            		cssClass: 'btn-lg btn-success',
	            		action: function()
	            		{
	            			var $button = this;

	            			$button.disable();
	            			$button.spin();
	            			$.post(baseUrl + 'sales/complete_sales_order', 'ref='+ref, function(data)
	            			{
	            				location.reload();
	            			});
	            		}
	            	},
	            	{
	            		label: 'No',
	            		cssClass: 'btn-lg',
	            		action: function (thisDialog)
	            		{
	            			thisDialog.close();
	            		}
	            	}
	            ]
	        });
		});
	<?php elseif($use_js == "salesDeliveryJs") :?>
		$('#btn-process-dispatch').on('click',function(event)
		{
			event.preventDefault();

			var total_amount = computeDeliveryTotal();

			if (!total_amount) {
				rMsg('Please set at least one item to be delivered','warning');
				return false;
			}

			$("#delivery_form").rOkay({
				btn_load		: 	$('#btn-process-dispatch'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										// alert(data);
										rMsg(data.msg,'success');
									}
			});

			window.location = baseUrl + 'sales/invoice_deliveries';
		});
		$('.deliver-qty').on('blur',function()
		{
			var pattern = /^\d*\.?\d*$/g;

			var string_r = $(this).val();
			var this_ref = $(this).attr('ref');
			var new_val = parseFloat(string_r.replace(pattern,string_r));
			new_val = isNaN(new_val) ? 0 : new_val;

			var ordered = $('[id="ordered-ref['+this_ref+']"]').attr('value');
			ordered = parseFloat(ordered.replace(pattern,ordered));
			ordered = isNaN(ordered) ? 0 : ordered;

			var delivered = $('[id="delivered-ref['+this_ref+']"]').attr('value');
			delivered = parseFloat(delivered.replace(pattern,delivered));
			delivered = isNaN(delivered) ? 0 : delivered;

			if (delivered + new_val > ordered) {
				$(this).val(ordered - delivered);
				$(this).focus();
				rMsg('Quantity exceeds order count','error');
				return false;
			}

			var price = $('[id="price-ref['+this_ref+']"]').attr('value');
			price = parseFloat(price.replace(pattern,price));
			price = isNaN(price) ? 0 : price;

			var disc_perc = $('[id="disc-ref['+this_ref+']"]').attr('value');
			disc_perc = parseFloat(disc_perc.replace(pattern,disc_perc));
			disc_perc = isNaN(disc_perc) ? 0 : disc_perc;



			total = new_val * price * disc_perc;

			display = total.toFixed(2).number_format();
			$('[id="total-ref['+this_ref+']"]').html(display);

			total = String(total);
			total.replace(pattern,total);
			$('[id="total-ref['+this_ref+']"]').attr('value',total);
			computeDeliveryTotal();
		});
		$('#deliv_shipping_cost').on('blur',function(event)
		{
			computeDeliveryTotal();
		});
		function computeDeliveryTotal()
		{
			var pattern = /^\d*\.?\d*$/g;
			var delivery_total = 0;
			$('.total-ref').each(function()
			{
				line_total = $(this).attr('value');
				line_total = parseFloat(line_total.replace(pattern,line_total));
				delivery_total = delivery_total + (isNaN(line_total) ? 0 : line_total);
			});
			var ship_cost = $('#deliv_shipping_cost').val();
			ship_cost = parseFloat(ship_cost.replace(pattern,ship_cost));
			delivery_total = delivery_total + (isNaN(ship_cost) ? 0 : ship_cost);

			display = delivery_total.toFixed(2).number_format();
			$('#delivery_cost').html(display);
			return delivery_total;
		}
		computeDeliveryTotal();
	<?php elseif($use_js == "deliveryInvoiceJs") :?>
		$('input.daterangepicker').daterangepicker({separator:' to '});
		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#delivery_search_form').rOkay({
				btn_load		: 	$('#btn-search'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				div_load		: 	$('#div-results'),
				div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
				onComplete		:	function(data){
										$('#div-results').empty();
										$('#div-results').html(data);
									}

			});
		});
		$('#btn-search').click();
	<?php elseif($use_js == "deliveryDisplayJs") :?>
		$('#btn-create-invoice').on('click',function(event)
		{
			event.preventDefault();
			var arr = [];
			var prev_debt = '';
			var prev_bran = '';
			var err = false;

			$('input[type=checkbox].invoice-check:checked').each(function(){
				var this_debtor = $(this).attr('debtor');
				var this_branch = $(this).attr('branch');

				if (prev_debt != '' && this_debtor != prev_debt) {
					rMsg('Invoice should be issued to a single customer branch only','error');
					err = true;
					return;
				}

				if (prev_bran != '' && this_branch != prev_bran) {
					rMsg('Invoice should be issued to a single customer branch only','error');
					err = true;
					return;
				}

				prev_debt = this_debtor;
				prev_bran = this_branch;
				arr.push($(this).attr('del_no'));
			});

			if (err)
				return false;

			if (!arr.length) {
				rMsg('Please select at least one delivery to be invoiced','error');
				return false;
			}

			var url = 'sales/customer_invoice';
			$.redirectPost(url,{dr_no:arr,debtor:prev_debt,branch:prev_bran});
		});
	<?php elseif($use_js == "customerInvoiceJs") :?>
		$('#btn-process-invoice').on('click',function(event)
		{
			event.preventDefault();
			$('#invoice-form').rOkay(
			{
				btn_load		: 	$('#btn-process-invoice'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data) {
										// alert(data);
										// $('#div-results').empty();
										// $('#div-results').html(data);
									}
			});

			window.location = baseUrl + 'sales/invoice_deliveries';
		});
	<?php elseif($use_js == "customerPaymentJs") :?>
		$('#debtor_id').on('change',function()
		{
			$('#div-results').empty();
			$('#div-results').html('<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>');
			var formData = {'debtor_id':$(this).val()};
			$.post(baseUrl + 'sales/display_customer_payments', formData, function(data)
			{
				$('#div-results').empty();
				$('#div-results').html(data);
			});
		});
	<?php elseif($use_js == "customerPaymentDisplayJs") :?>
	<?php elseif($use_js == "customerPaymentAllocationJs") :?>
		var pattern = /^\d*\.?\d*$/g;
		$('#btn-process').on('click',function(event)
		{
			event.preventDefault();

			var oustanding_amount = $('#oustanding_payment').val();
			oustanding_amount = parseFloat(oustanding_amount.replace(pattern,oustanding_amount));
			oustanding_amount = isNaN(oustanding_amount) ? 0 : oustanding_amount;

			var alloc_amount = computeAllocationTotal();

			if (alloc_amount > oustanding_amount) {
				rMsg('Total allocations exceed remaining payment amount','warning');
				return false;
			}

			hasError = false;
			$("#allocation_form").rOkay({
				btn_load		: 	$('#btn-process'),
				btn_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										if (data.error || typeof data.error != 'undefined') {
											rMsg(data.msg,'error');
											hasError = true;
										}
									}
			});

			if (!hasError)
				window.location = baseUrl + 'sales/customer_payments';
		});
		$('.alloc-qty').on('blur',function()
		{
			var string_r = $(this).val();
			var this_ref = $(this).attr('ref');
			var new_val = parseFloat(string_r.replace(pattern,string_r));

			var outstanding = $(this).attr('ref_amount')
			outstanding = parseFloat(outstanding.replace(pattern,outstanding));
			outstanding = isNaN(outstanding) ? 0 : outstanding;

			if (new_val > outstanding) {
				$(this).val(outstanding.toFixed(2).number_format());
				rMsg('Allocation exceeds amount to be paid','warning');
				return false;
			}
			computeAllocationTotal();
		});
		$('.alloc-all').on('click',function(event)
		{
			event.preventDefault();
			var _this_ref = $(this).attr('ref');
			var _this_amount = $(this).attr('ref_amount');
			var amount = parseFloat(_this_amount.replace(pattern,_this_amount));

			var oustanding_amount = $('#oustanding_payment').val();
			oustanding_amount = parseFloat(oustanding_amount.replace(pattern,oustanding_amount));
			oustanding_amount = isNaN(oustanding_amount) ? 0 : oustanding_amount;

			var alloc_amount = computeAllocationTotal();

			var _amount_left = oustanding_amount - alloc_amount;
			var disp_amount = (amount > _amount_left ? amount : _amount_left).toFixed(2).number_format();

			$('#alloc-'+_this_ref).val(disp_amount);
		});
		function computeAllocationTotal()
		{
			var pattern = /^\d*\.?\d*$/g;
			var alloc_total = 0;
			$('.alloc-qty').each(function()
			{
				line_total = $(this).val();
				line_total = parseFloat(line_total.replace(pattern,line_total));
				console.log(line_total);
				alloc_total = alloc_total + (isNaN(line_total) ? 0 : line_total);
			});

			display = alloc_total.toFixed(2).number_format();
			$('#spn-total-alloc').html(display);
			return alloc_total;
		}
		computeAllocationTotal();
	///////////////////////////////JED/////////////////////////////////
	////////////////////////////////////////////////////////////////////
	<?php elseif($use_js == "creditNoteHeaderJS") :?>
		loader('#details_link');
		$('.tab_link').click(function(){
			var id = $(this).attr('id');
			loader('#'+id);
		});
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var cn_id = $('#cn_id').val();

			if(cn_id == ""){
				//alert('we');
				disEnbleTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			}
			else{
				//alert('wwww');
				disEnbleTabs('.load-tab',true);
			}
			$(tabPane).rLoad({url:baseUrl+loadUrl+cn_id});
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

	<?php elseif($use_js == 'cnHeaderDetailsLoadJs'): ?>
		$('#save-cnheader').click(function(event){
			event.preventDefault();
			$("#cn_header_details_form").rOkay({
				btn_load		: 	$('#save-cnheader'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
											$('#cn_id').val(data.id);
											disEnbleTabs('.load-tab',true);
											// disEnbleTabs('',true);
											rMsg(data.msg,'success');
											// $('#so_items_link').click();
									}
			});
		});
		$('#debtor_id').on('change',function()
		{
			var debtor_id = $(this).val();
			var passUrl = baseUrl + 'sales/get_customer_branches/' + debtor_id;
			if(debtor_id == ''){
				$('#debtor_branch_id').empty();
			}else{
				$('#debtor_branch_id').empty();
				$.post(passUrl,'',function(data)
				{
					str = '<option value="">Select customer branch</option>';
					$.each(data,function(key,value)
					{
						str = str + "<option value='" + value.id + "' badd='" + value.address + "'>" + value.name + "</option>";
					});
					$('#debtor_branch_id').append(str);
				},'json');
			}
		});
		$('#debtor_id').change();

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
	<?php elseif($use_js == 'cnItemsLoadJs'): ?>
		$('#item').change(function(){
			set_item_details($(this).val());
		});

		function set_item_details(id){
			$.post(baseUrl+'sales/get_item_details/'+id,function(data){
				$('#item-id').val(data.item_id);
				$('#item-uom').val(data.uom);
				//alert('Stock ID:'+id);
				if(id!=''){
					//alert('asd'+id);
					$('#item-price').val(data. ).attr({'value' : data.price});
					$('#unit_price').val(data.price).attr({'value' : data.price});
					$('#qoh').val(data.qoh);
					$('#select-uom').find('option').remove();
					$.each(data.opts,function(key,val){
						$('#select-uom').append($("<option/>", {
							value: val,
							text: key
						}));
					});
				} else{
					//alert('def'+id);
					$('#select-uom').empty();
					$('#item-price').val(0).attr({'value' : 0});
					$('#unit_price').val(0).attr({'value' : 0});
					$('#qoh').val(0).attr({'value' : 0});
				}
			},'json');
		}

		$('#add-item-btn').click(function(){
			$("#cn_items_form").rOkay({
				btn_load		: 	$('#add-item-btn'),
				asJson			: 	true,
				onComplete		:	function(data){
										if(data.act == 'add'){
											$('#details-tbl').append(data.row);
											rMsg(data.msg,'success');

											if (typeof data.underpriced_msg != 'undefined')
												rMsg(data.underpriced_msg,'warning');
										}
										else{
											var i = $('#row-'+data.id);
											$('#row-'+data.id).remove();
											$('#details-tbl').append(data.row);
											rMsg(data.msg,'success');
										}
										remove_row(data.id);
									}
			});
			$('.input_form').val('').removeAttr('selected');
			$('input.combobox.this_item[type="text"]').focus();
			return false;
		});

		$('#add-non-stock-item-btn').click(function(event)
		{
			event.preventDefault();
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_INFO,
				title: 'ADD HARDWARE ITEM',
	            message: function(dialog) {
	            	var $message = $('<div></div>');
	            	var pageToLoad = dialog.getData('pageToLoad');
	            	$message.load(pageToLoad);

	            	return $message;
	            },
	            data: {
	            	'pageToLoad': baseUrl+'sales/show_add_non_stock_cn_item/' + $('#_cn_id').val()
	            },
	            buttons: [
	            	{
	            		icon: 'fa fa-plus',
	            		label: ' Add item',
	            		cssClass: 'btn-lg btn-success',
	            		action: function(thisDialog)
	            		{
	            			var $button = this;
	            			$('#frm-non-stock').rOkay({
								btn_load		: 	$button,
								bnt_load_remove	: 	true,
								asJson			: 	false,
								div_load		: 	$('#div-results'),
								div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
								onComplete		:	function(data){
														if(data.act == 'add'){
															$('#details-tbl').append(data.row);
															rMsg(data.msg,'success');
														}
														else{
															var i = $('#row-'+data.id);
															$('#row-'+data.id).remove();
															$('#details-tbl').append(data.row);
															rMsg(data.msg,'success');
														}
														remove_row(data.id);
														thisDialog.close();
													}
					        });
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

		$('.dels').each(function(){
			var id = $(this).attr('ref');
			remove_row(id);
		});
		function remove_row(id){
			$('#del-'+id).click(function(event){
				event.preventDefault();
				$.post(baseUrl+'sales/remove_cn_item','cn_item_id='+id,function(data){
					$('#row-'+id).remove();
					rMsg(data.msg,'warning');
				},'json');
			});
		}
		setTimeout(function(){
			if ($('input.combobox.this_item[type="text"]').length) {
				$('input.combobox.this_item[type="text"]').focus();
			}
		},350);

	<?php elseif($use_js == "salesInvoiceJs") :?>
		$('input.daterangepicker').daterangepicker({separator:' to '});
		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#invoice_search_form').rOkay({
				btn_load		: 	$('#btn-search'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				div_load		: 	$('#div-results'),
				div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
				onComplete		:	function(data){
										$('#div-results').empty();
										$('#div-results').html(data);
									}

			});
		});
		$('#btn-search').click();

		$('.cbox').click(function(){
			id = $(this).attr('id');

			if($(this).is(':checked'))
				$(this).attr('chk',1);
			else
				$(this).attr('chk',0);

			chk = $(this).attr('chk');
			formData = 'id='+id+'&chk='+chk;
			$.post(baseUrl+'sales/session_checkbox',formData,function(data){
					// $('#row-'+id).remove();
					// rMsg(data.msg,'warning');
					//alert(data);
			});


		});


	<?php elseif($use_js == "salesDeliveryInquiryJs") :?>
		$('input.daterangepicker').daterangepicker({separator:' to '});
		var _dr_options = {
	        ajax: {
	            url: 'search_sales_delivery',
	            type: 'POST',
	            dataType: 'json',
	            data: {
	                q: '{{{q}}}'
	            }
	        },
	        locale: {
	            emptyTitle: 'Select to search deliveries'
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
		$('#delivery_ref').selectpicker().filter('.with-ajax').ajaxSelectPicker(_dr_options);
		$('#delivery_ref').on('change',function(event)
		{
			$.post('delivery_inquiry_results',{'delivery_id':$(this).val()},function(data){
				$('#div-results').empty();
				$('#div-results').html(data);
			});
		});
		$('#btn-search').on('click',function(event)
		{
			event.preventDefault();
			$('#delivery_search_form').rOkay(
			{
				btn_load		: 	$('#btn-search'),
				bnt_load_remove	: 	true,
				asJson			: 	false,
				div_load		: 	$('#div-results'),
				div_load_html	:	'<div class="box-body"><div class="row"><div class="col-md-12 text-center"><i class="fa fa-2x fa-circle-o-notch fa-spin"></i></div></div></div>',
				onComplete		:	function(data){
										$('#div-results').empty();
										$('#div-results').html(data);
									}
			});
		});
		$('#btn-search').trigger('click');
	<?php elseif($use_js == "deliveryReturnJs") :?>
		$('#btn-process-return').on('click',function(event)
		{
			event.preventDefault();

			var total_amount = computeReturnTotal();

			if (!total_amount) {
				rMsg('Please set at least one item to be returned','warning');
				return false;
			}

			$("#return_form").rOkay({
				btn_load		: 	$('#btn-process-return'),
				btn_load_remove	: 	true,
				asJson			: 	false,
				onComplete		:	function(data){
										// alert(data);
										// rMsg(data.msg,'success');
									}
			});

			window.location = baseUrl + 'sales/pending_deliveries';
		});
		$('.return-qty').on('blur',function()
		{
			var pattern = /^\d*\.?\d*$/g;

			var string_r = $(this).val();
			var this_ref = $(this).attr('ref');
			var new_val = parseFloat(string_r.replace(pattern,string_r));
			new_val = isNaN(new_val) ? 0 : new_val;

			var delivered = $('[id="delivered-ref['+this_ref+']"]').attr('value');
			delivered = parseFloat(delivered.replace(pattern,delivered));
			delivered = isNaN(delivered) ? 0 : delivered;

			if (new_val > delivered) {
				$(this).val(delivered);
				$(this).focus();
				rMsg('Quantity exceeds delivery count','warning');
				return false;
			}

			var price = $('[id="price-ref['+this_ref+']"]').attr('value');
			price = parseFloat(price.replace(pattern,price));
			price = isNaN(price) ? 0 : price;

			var disc_perc = $('[id="disc-ref['+this_ref+']"]').attr('value');
			disc_perc = parseFloat(disc_perc.replace(pattern,disc_perc));
			disc_perc = isNaN(disc_perc) ? 0 : disc_perc;

			total = new_val * price * disc_perc;

			display = total.toFixed(2).number_format();
			$('[id="total-ref['+this_ref+']"]').html(display);

			total = String(total);
			total.replace(pattern,total);
			$('[id="total-ref['+this_ref+']"]').attr('value',total);
			computeReturnTotal();
		});
		$('#deliv_shipping_cost').on('blur',function(event)
		{
			var pattern = /^\d*\.?\d*$/g;

			var string_r = $(this).val();
			var this_ref = $(this).attr('x_value');
			var new_val = parseFloat(string_r.replace(pattern,string_r));
			new_val = isNaN(new_val) ? 0 : new_val;
			var old_val = parseFloat(this_ref.replace(pattern,this_ref));
			old_val = isNaN(old_val) ? 0 : old_val;

			if (new_val > old_val) {
				$(this).val(old_val);
				$(this).focus();
				rMsg('Shipping cost exceeds original cost','warning');
				return false;
			}

			computeReturnTotal();
		});
		function computeReturnTotal()
		{
			var pattern = /^\d*\.?\d*$/g;
			var delivery_total = 0;
			$('.total-ref').each(function()
			{
				line_total = $(this).attr('value');
				line_total = parseFloat(line_total.replace(pattern,line_total));
				delivery_total = delivery_total + (isNaN(line_total) ? 0 : line_total);
			});
			var ship_cost = $('#deliv_shipping_cost').val();
			ship_cost = parseFloat(ship_cost.replace(pattern,ship_cost));
			delivery_total = delivery_total + (isNaN(ship_cost) ? 0 : ship_cost);

			display = delivery_total.toFixed(2).number_format();
			$('#delivery_cost').html(display);
			return delivery_total;
		}
		computeReturnTotal();
	
		
		//----------------Dan----------------------//

		<?php elseif($use_js == 'ProductHistory'): ?>
			
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
	
			$('#ProductHistoryButtonView').click(function(){
				var btn = $(this)
				disable_button(btn,'btn-primary');
				var description = $('#Description').val();
				var barcode = $('#Barcode').val();
				var fdate = $('#fdate').val();
				var tdate = $('#tdate').val();
				console.log(fdate,tdate);
				var dtr_url = '<?php echo base_url(); ?>sales/ProductHistorySearch';
				disable_button(btn, 'btn-primary');
				$.post(dtr_url, {'description' : description,'barcode':barcode, 'fdate':fdate, 'tdate':tdate}, function(data){
					$('#view_data_data').html(data);
						enable_button(btn, 'Search', 'fa-search', 'fa-search', 'btn-primary','btn-primary','btn-primary')
						return false;
					});
	
			});

			$('.ProductHistoryViewData').unbind('click').click(function(){
			
			var img = "<img src='<?php echo base_url(); ?>/img/ajax-loader2.gif' style='height:100px;'>";
			var id = $(this).attr('id');
			var url = '<?php echo base_url(); ?>sales/ProductHistoryViewDataButton/'+id;
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
	
			<?php endif; ?>

		//----------------Dan----------------------//
});		
// ===================================================PRINT =========================================================================
		
		$('#categoryshow').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Category_show';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#printproductlisting').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/productlisting_excel_active';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});

		$('#printproductlistinginac').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/productlisting_excel_inactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#printActInac').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/productlisting_excel_Actinact';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#PrintCost').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Product_Cost';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});

		$('#deptactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Depart_activeyahoo';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#deptinactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Depart_inactiveyahoo';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#deptActinactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Depart_Actinactiveyahoo';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#brandactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Brand_active';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#brandinactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Brand_inactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#brandactiveinactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Brand_Activeinactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#brandcost').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Brand_cost';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#classactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Class_active';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#classinactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Class_inactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#classactinactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Class_Actinactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#classcost').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Class_Cost';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#categoryactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Category_active';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#categoryInactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Category_inactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#categoryActinactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Category_actinactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#categorycost').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Category_cost';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#countryactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Countryactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#countryinactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Countryinactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#countryActinactive').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/CountryActinactive';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#countryycost').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Countrycost';



						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#printinvetorylevel').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/inventorylevel_excel';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#printinvetorylevelloose').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/inventorylevelloose_excel';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});
		$('#deptshow').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/dept_show';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#deptloose').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/dept_loose';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});
		$('#brandshow').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/brand_show';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
		$('#brandloose').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/brand_loose';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});

		$('#classloose').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/class_loose';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});


		$('#classshow').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/class_show';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});
		$('#countryshow').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/country_show';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});


		$('#countryloose').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/country_loose1';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});

			$('#categoryshow').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Category_show';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});
		
		$('#categoryloose').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/Category_loose';


						formData = $('#search_form99').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			// alert('yahooo');
			
			});
	/*	$('#printproductlisting').click(function(){		
			//
			var this_url = '<?php echo base_url() ?>sales/productlisting_excel_inactive';

	
		


						formData = $('#search_form11').serialize();
						window.location = this_url+'?'+formData;

				 		$.post(formData, function(){
						
						 });
						

	   		return false;	
			
			
			});
	*/
	
		



		$('#print1').click(function(){		
		
			var this_url = '<?php echo base_url() ?>sales/generate_avendor_excel';
			var datarange = $('#daterange').val;

			if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						formData = $('#search_form1').serialize();
						window.location = this_url+'?'+formData;
					   }
	   		return false;	
			
			});

		$('#print2').click(function(){		
	
		var this_url = '<?php echo base_url() ?>sales/generate_offtakeSvendor_excel';
		var datarange = $('#daterange').val;

		if(daterange == ''){
			rMsg('Occurence should not be empty!','warning');
			$('#daterange').focus();
		}
		else{
					formData = $('#search_form2').serialize();
					window.location = this_url+'?'+formData;
				   }
   		return false;	
		
		});
		$('#print3').click(function(){		
		
			var this_url = '<?php echo base_url() ?>sales/generate_offtakeAllvendor_excel';
			var datarange = $('#daterange').val;

			if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						formData = $('#search_form3').serialize();
						window.location = this_url+'?'+formData;
					   }
	   		return false;	
			
			});
		$('#print4').click(function(){		
		
			var this_url = '<?php echo base_url() ?>sales/generate_Overstockvendor_excel';
			var datarange = $('#daterange').val;

			if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						formData = $('#search_form4').serialize();
						window.location = this_url+'?'+formData;

					   }
	   		return false;	
			
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
			// my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
		}
		$('#printoverstock').click(function(){		
			
			var this_btn = $(this);
			var this_url = '<?php echo base_url() ?>sales/generate_AllOverstockvendor_excel';
			var datarange = $('#daterange').val;

			if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						formData = $('#search_formalloverstock').serialize();
						window.location = this_url+'?'+formData;
						
						 
					   }
	   		return false;	
			
			});

		$('#print5').click(function(){		
		
			var this_url = '<?php echo base_url() ?>sales/Category_excel';
			var datarange = $('#daterange').val;

			if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						formData = $('#search_form5').serialize();
						window.location = this_url+'?'+formData;

					   }
	   		return false;	
			
			});


		$('#print6').click(function(){		
		
			var this_url = '<?php echo base_url() ?>sales/Category_exportAll';
			var datarange = $('#daterange').val;

			if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						formData = $('#search_form5').serialize();
						window.location = this_url+'?'+formData;

					   }
	   		return false;	
			
			});
		
		$('#printshare').click(function(){		
		
			var this_url = '<?php echo base_url() ?>sales/Category_share';
			var datarange = $('#daterange').val;

			if(daterange == ''){
				rMsg('Occurence should not be empty!','warning');
				$('#daterange').focus();
			}
			else{
						formData = $('#search_form5').serialize();
						window.location = this_url+'?'+formData;

					   }
	   		return false;	
			
			});



		// $('#print6').click(function(){		
		
		// 	var this_url = '<?php echo base_url() ?>sales/Overstock-All';
		// 	var datarange = $('#daterange').val;

		// 	if(daterange == ''){
		// 		rMsg('Occurence should not be empty!','warning');
		// 		$('#daterange').focus();
		// 	}
		// 	else{
		// 				formData = $('#search_form5').serialize();
		// 				window.location = this_url+'?'+formData;
		// 			   }
	 //   		return false;	
			
		// 	});
			
				
		$('input.daterangepicker').daterangepicker({separator:' to '});
		
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
			// my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
		}
		

		$('#process').click(function(){
				// alert($('#description').val());
			var branch = $('#branch').val();
			var description = $('#description').val();
			var daterange = $('#daterange').val();
			if(daterange == ''){
				rMsg('Occurence should not be empty!');
				$('#daterange	').focus();
				
			}else{
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');
				
				var display_url = baseUrl + 'sales/singlevendor_results';
				 var formData = $('#search_form').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results2').html(data);
					 enable_button(this_btn, 'View', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			}
			 return false;
		});

	$('input.daterangepicker').daterangepicker({separator:' to '});
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
			// my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
		}
		$('#process1').click(function(){
			var branch = $('#branch').val();
			var daterange = $('#daterange').val();
			if(daterange == ''){
				rMsg('Occurence should not be empty!');
				$('#daterange').focus();
				
			}else{
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');
				
				var display_url = baseUrl + 'sales/allvendor_results';
				 var formData = $('#search_form1').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results3').html(data);
					 enable_button(this_btn, 'View', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			}
			 return false;
		});

		//>>>>

		$('input.daterangepicker').daterangepicker({separator:' to '});
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
			// my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
		}
		$('#process2').click(function(){
			var description = $('#description').val();
			var daterange = $('#daterange').val();
			if(description == '' && daterange == ''){
				rMsg('Occurence should not be empty!');
				$('#description').focus();
				
			}else{
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');
				
				var display_url = baseUrl + 'sales/OfftakeSvendor_results';
				 var formData = $('#search_form2').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results4').html(data);
					 enable_button(this_btn, 'View', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			}
			 return false;
		});
		$('input.daterangepicker').daterangepicker({separator:' to '});
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
			// my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
		}
		$('#process3').click(function(){
			var daterange = $('#daterange').val();
			if(daterange == ''){
				rMsg('Occurence should not be empty!');
				$('#daterange').focus();
				
			}else{
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');
				
				var display_url = baseUrl + 'sales/Offtakeallvendor_results';
				 var formData = $('#search_form3').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results5').html(data);
					 enable_button(this_btn, 'View', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			}
			 return false;
		});
		$('input.daterangepicker').daterangepicker({separator:' to '});
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
			// my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
		}
		$('#process4').click(function(){
			var description = $('#description').val();
			var daterange = $('#daterange').val();
			if(description == '' && daterange == ''){
				rMsg('Occurence should not be empty!');
				$('#description').focus();
				
			}else{
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');
				
				var display_url = baseUrl + 'sales/Overstock_results';
				 var formData = $('#search_form4').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results6').html(data);
					 enable_button(this_btn, 'View', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			}
			 return false;
		});

		$('#processoverstock').click(function(){
			

			var daterange = $('#daterange').val();
			if(daterange == ''){
				rMsg('Occurence should not be empty!');
				$('#daterange').focus();
				
			}else{
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');
				
				var display_url = baseUrl + 'sales/AllOverstock_results';
				 var formData = $('#search_formalloverstock').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-overstockall').html(data);
					 enable_button(this_btn, 'View', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			}
			 return false;
		});
		$('#process5').click(function(){
			var daterange = $('#daterange').val();
			if(daterange == ''){
				rMsg('Occurence should not be empty!');
				$('#daterange').focus();
				
			}else{
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');
				
				var display_url = baseUrl + 'sales/AllOverstock_results';
				 var formData = $('#search_form4').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results6').html(data);
					 enable_button(this_btn, 'View', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			}
			 return false;
		});
		
	
		$('input.daterangepicker').daterangepicker({separator:' to '});
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
			// my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i>"+five_spaces+"LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
			my_btn.html("<i class='fa fa-refresh fa-spin fa-lg'></i> LOADING. PLEASE WAIT."); //change the label to loading... mabagal na loading
		}
		$('#process6').click(function(){
			var description = $('#description').val();
			var daterange = $('#daterange').val();
			if(description == '' && daterange == ''){
				rMsg('Occurence should not be empty!');
				$('#Venda').focus();
				
			}else{
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');
				
				var display_url = baseUrl + 'sales/Category_results';
				 var formData = $('#search_form5').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results7').html(data);
					 enable_button(this_btn, 'View', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			}
			 return false;
		});

		$('#process11').click(function(){
			var description = $('#description').val();
			if(description == '' ){
				rMsg('Occurence should not be empty!');
				
			}else{
				 var this_btn = $(this);	
				 disable_button(this_btn, 'btn-primary');
				
				var display_url = baseUrl + 'sales/ProductListing_results';
				 var formData = $('#search_form11').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results11').html(data);
					 enable_button(this_btn, 'View', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			}
			 return false;
		});	


		// 	$('#search19').click(function(){
		// 	var description = $('#qwe').val();
		// 	if(description == '' ){
		// 		rMsg('Occurence should not be empty!');
		// 	}else{
		// 		 var this_btn = $(this);	
		// 		 disable_button(this_btn, 'btn-primary');
				
		// 		var display_url = baseUrl + 'sales/inventory_results';
		// 		 var formData = $('#search_form99').serialize();
		// 		//alert(formData);
		// 		 $.post(display_url, formData, function(data){
		// 			$('#div-results99').html(data);
		// 			 enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
		// 		 });
		// 	}
		// 	 return false;
		// });	
		//========================================================PRODUCT=====================================================================
		$('#venda').change(function(){
			var description = $('#venda').val();
			var display_url = baseUrl + 'sales/ProductListing_results';
			var formData = $('#search_form11').serialize();
			$.post(display_url, formData, function(data){
				$('#div-results11').html(data);
				enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
			});
			return false;
			/*alert($('#venda').val());*/
		});
		$('#pldept').change(function(){
			var description = $('#pldept').val();
			var display_url = baseUrl + 'sales/Productdepartment_results';
			var formData = $('#search_form11').serialize();
			$.post(display_url, formData, function(data){
				$('#div-results11').html(data);
				/*enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');*/
			});
			return false;
			/*alert($('#venda').val());*/
		});
		$('#brands').change(function(){
			var description = $('#brands').val();
			var display_url = baseUrl + 'sales/Productbrand_results';
			var formData = $('#search_form11').serialize();
			$.post(display_url, formData, function(data){
				$('#div-results11').html(data);
				enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
			});
			return false;
			/*alert($('#venda').val());*/
		});

		/////////////////////////////////HALO
		$('#clss').change(function(){
			var description = $('#clss').val();
			var display_url = baseUrl + 'sales/Productclass_results';
			var formData = $('#search_form11').serialize();
			$.post(display_url, formData, function(data){
				$('#div-results11').html(data);
				enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
			});
			return false;
			/*alert($('#venda').val());*/
		});
		$('#year').change(function(){
			var description = $('#yeeer').val();
			var display_url = baseUrl + 'sales/Productyear_results';
			var formData = $('#search_form11').serialize();
			$.post(display_url, formData, function(data){
				$('#div-results11').html(data);
				enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
			});
			return false;
			// alert($('#year').val());
		});
		$('#country').change(function(){
			var description = $('#country').val();
			var display_url = baseUrl + 'sales/Productcountry_results';
			var formData = $('#search_form11').serialize();
			$.post(display_url, formData, function(data){
				$('#div-results11').html(data);
				enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
			});
			return false;
			// alert($('#year').val());
		});
		$('#category').change(function(){
			var description = $('#category').val();
			var display_url = baseUrl + 'sales/Productcateg_results';
			var formData = $('#search_form11').serialize();
			$.post(display_url, formData, function(data){
				$('#div-results11').html(data);
				enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
			});
			return false;
			// alert($('#year').val());
		});
		//=========================================================END========================================================================

		//////////////////////////////////////////////////////////////////////////////////inventory/////////////////////////////////////////
			$('#qwe').change(function(){
				var description = $('#qwe').val();
				var display_url = baseUrl + 'sales/inventory_results';
				 var formData = $('#search_form99').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results99').html(data);
					 enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			
			 return false;
			});

			// $('#sample').click(function(){
			// 	alert($('#year').val());	
			// });

			$('#depart').change(function(){
				var description = $('#depart').val();
				var display_url = baseUrl + 'sales/dept_results';
				 var formData = $('#search_form99').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results99').html(data);
					 enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			
			 return false;
			});

			$('#brand').change(function(){
				var description = $('#brand').val();
				var display_url = baseUrl + 'sales/brand_results';
				 var formData = $('#search_form99').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results99').html(data);
					 enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			
			 return false;
			});

			$('#Country').change(function(){

				
				//	alert($('#category').val());
	
				var description = $('#Country').val();
				var display_url = baseUrl + 'sales/class_results';
				 var formData = $('#search_form99').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results99').html(data);
					 enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			
			 return false;
			});


			$('#yearn').change(function(){

				
				//	alert($('#yearn').val());
	
				var description = $('#yearn').val();
				var display_url = baseUrl + 'sales/class_results';
				 var formData = $('#search_form99').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results99').html(data);
					 enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			
			 return false;
			});

			$('#country').change(function(){
				// alert($('#country').val());	
				var description = $('#country').val();
				var display_url = baseUrl + 'sales/country_results';
				 var formData = $('#search_form99').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results99').html(data);
					 enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			
			 return false;
			});

					$('#category').change(function(){
				//alert($('#category').val());	
				var description = $('#category').val();
				var display_url = baseUrl + 'sales/class_results';
				 var formData = $('#search_form99').serialize();
				//alert(formData);
				 $.post(display_url, formData, function(data){
					$('#div-results99').html(data);
					 enable_button(this_btn, 'SEARCH', 'fa-refresh', 'fa-search', 'btn-danger', 'btn-primary');
				 });
			
			 return false;
			});




					////////////////////////////////////////////////////////////////////////////////////////////a

	
			// $("#chckbox").click(function(){
			// var id = $(this).attr('id');
			// var description = $('#qwe').val();
			// var display_url = baseUrl + 'sales/inventory_results';
			// var formData = $('#search_form99').serialize();
			// if($(this).is(':checked'))
			// 	 $.post(display_url, formData, function(data){
			// 		$('#div-results99').html(data);
			// 	 });
			// else
			// 	$(this).attr('value',0);	

			// });
			
			
		
		// 	$("#chckbox").click(function(){
		// 	var id = $(this).attr('id');
		// 	if($(this).is(':checked'))
		// 		$(this).attr('value',0);


		// 	else
		// 		$(this).attr('value',1);
		// 		var description = $('#depart').val();
		// 		var display_url = baseUrl + 'sales/dept_results';
		// 		 var formData = $('#search_form99').serialize();
		// 		//alert(formData);
		// 		 $.post(display_url, formData, function(data){
		// 			$('#div-results99').html(data);
					
		// 		 });
			
		
		// 	});

		// $("#chckbox").click(function(){
		// 	var id = $(this).attr('id');
		// 	if($(this).is(':checked'))
		// 		$(this).attr('value',0);


		// 	else
		// 		$(this).attr('value',1);
		// 		var description = $('#brand').val();
		// 		var display_url = baseUrl + 'sales/brand_results';
		// 		 var formData = $('#search_form99').serialize();
		// 		//alert(formData);
		// 		 $.post(display_url, formData, function(data){
		// 			$('#div-results99').html(data);
					 
		// 		 });
			
		
		// 	});

///////////////////////////////inven

			
		// alert($('#group').val());
		//=============================================PRODUCTLISTING============================================================

		// function uncheck (){
		// 	var check1 = document.getElementById("srp");
		// 	var check2 = document.getElementById("active");
		// 	if(check1.checked == true && check2.checked == true)
		// 	{
		// 		if(check1 == 1){
		// 			check2.checked = false;
		// 			checkRefresh();
		// 		}
		// 		else if(check2 == 1)
		// 		{
		// 			check1.checked = false;
		// 			checkRefresh();
		// 		}
		// 	}
		// }
</script>

