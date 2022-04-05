<script>
$(document).ready(function(){
	$("[data-toggle='offcanvas']").click(); //hide main menu sa side
	<?php if($use_js == 'barcodeJS'):?>		
		$('#search_item').focus();	
		$('#price_inq_div').hide();	
		$('#tender_type_id').hide();
		$('#look_up_div').hide();			
		$('#price_inq_list').hide();	
		$('#file-spinner').hide();	
		$('#search_item').change(function() {
	        var barcode = $(this).val();
			var add_url = baseUrl+'cashier/add_product/';
			$('#file-spinner').show();		
			$('#list_purchased').hide();	
			$.post(add_url, {'barcode' : barcode}, function(data){					
				var res = data.split('|');				
				if(res[0] == 'success'){
					rMsg(res[1],'success');
					$('#list_purchased').show();
					load_purchases();
					load_amount_purchases();
					$('#search_item').val('');	
					$('#search_item').focus();					
					$('#file-spinner').hide();	
				}
				else{
					rMsg('no record on database','warning');
					$('#list_purchased').show();
					load_purchases();
					load_amount_purchases();
					$('#search_item').val('');	
					$('#search_item').focus();					
					$('#file-spinner').hide();	
				}	
			});        	        		
	    });	
		
		
	// User navigates table using keyboard
		var currCell = $('td').first();
		$('tr').first().focus;
		$('#list_purchased').keydown(function (e) {
			var c = "";
			if (e.which == 38) { 
				// Up Arrow
				c = currCell.closest('tr').prev().find('td:eq(' + 
				  currCell.index() + ')');
			} else if (e.which == 40) { 
				// Down Arrow
				c = currCell.closest('tr').next().find('td:eq(' + 
				  currCell.index() + ')');
			}else if (e.which == 13) { 
				//alert(currCell.html());
			//var line_id = $(this).attr('ref');
			var line_id = currCell.html();
			 BootstrapDialog.show({
	            title: 'User Authentication',
	            message: "Username:<input type='text' class='form-control' name='username' id='username' placeholder='Username' autofocus><br/>Password:<input type='password' class='form-control' name='pass_word' id='pass_word' placeholder='Password'> <br/> Press 1- Contiue &nbsp;Press 2 - Close",
	            onshow: function(dialog) {
	            	
	            },
	            buttons: [{
	                id: 'pwd',
	                label: 'Continue',
           			cssClass: 'btn-success',
	                hotkey: 49, // Keycode of keyup event of key 'A' is 65.
	                action: function() {
	                	username = $("#username").val();
		                pass_word = $("#pass_word").val();
		                var check_pass = baseUrl+'cashier/check_pass/';
						$.post(check_pass, {'uname' : username, 'pass' : pass_word}, function(data){					
							var res = data.split('|');				
							if(res[0] == 'success'){
								//rMsg('User is authorized','success');
								var void_all_url = baseUrl+'cashier/void_line/';
								$.post(void_all_url, {'line_id' : line_id}, function(data){					
									var res = data.split('|');				
									if(res[0] == 'success'){
										rMsg('Line Voided','success');
										var delay=500; //1 seconds
										setTimeout(function(){
											window.location = baseUrl+'cashier/search_barcode/';
										}, delay); 
									}	
								});     
							}else{
								rMsg('Username and Password not recognized','error');
							}
						}); 
	                }
	            }, {
	                id: 'sc',
	                label: 'Close',
           			cssClass: 'btn-danger',
	                hotkey: 50, // Keycode of keyup event of key 'A' is 65.
	                action: function() {
	                	
	                	//discount_type(0,1);
						//rMsg('SC Discount is enabled','primary');
						var delay=300; //1 seconds
						setTimeout(function(){
							window.location = baseUrl+'cashier/search_barcode/';
						}, delay); 
	                    //alert('Finally, you loved Button A.');
	                }
	            // }
	            }]
	       });
			//alert('delete me! ->'+ref);
			return false;		
			}			
			// If we didn't hit a boundary, update the current cell
			if (c.length > 0) {
				currCell = c;
				currCell.focus();
			}
		});
		

		
		 $(document).keyup(function(e){
		   var charCode = (e.which) 
		   ? e.which : event.keyCode
		  	
	    //  if (e.keyCode == 27) {box.modal("hide");}   // esc
			
		  if (e.altKey && charCode == 68){ //line void
		 
		 bootbox.dialog({
                title: "Line Void.",
                message: 'line_void',
                // buttons: {
                   // success: {
							
                       // label: "Save",
                      //  className: "btn-success",
                       // callback: function () {
                           // var name = $('#name').val();
                           // var answer = $("input[name='awesomeness']:checked").val()
                            //Example.show("Hello " + name + ". You've chosen <b>" + answer + "</b>");
                      //  }
                   // }
                // }
            }
        );
				
		   
		  }
					
	    });	

				
	    	
		$('#price_inq_barcode').change(function() {
	        var barcode = $(this).val();
			var serch_url = baseUrl+'cashier/price_inq/';
			$('#file-spinner').show();			
			$('#price_inq_list').hide();	
			$.post(serch_url, {'barcode' : barcode}, function(data){
				if(data){
					//rMsg(barcode,'success');
					$('#price_inq_barcode').val('');	
					$('#price_inq_barcode').focus();	
					var delay=300; //0.5 seconds
					setTimeout(function(){			
						$('#price_inq_list').html(data);		
						$('#price_inq_list').show();					
						$('#file-spinner').hide();		
					}, delay); 
				}
			});        	        		
	    });
		$('#price_inq_description').change(function() {
	        var description = $(this).val();
			var serch_url = baseUrl+'cashier/look_up/';
			$('#file-spinner').show();			
			$('#price_inq_list').hide();	
			$.post(serch_url, {'description' : description}, function(data){
				if(data){
					//rMsg(barcode,'success');
					$(price_inq_description).val('');	
					$(price_inq_description).focus();	
					var delay=300; //0.5 seconds
					setTimeout(function(){			
						$('#price_inq_list').html(data);		
						$('#price_inq_list').show();					
						$('#file-spinner').hide();		
					}, delay); 
				}
			});        	        		
	    });	    	    
	   /* function check_password(uname, pass){				
			var check_pass = baseUrl+'cashier/check_pass/';
			$.post(check_pass, {'uname' : uname, 'pass' : pass}, function(data){					
				var res = data.split('|');				
				if(res[0] == 'success')
					return data;//rMsg('authorized','success');
				else
					return false;	
			});      
		}*/
	    function load_purchases(){
			var load_url = baseUrl+'cashier/load_purchases/';
	        var barcode = $('#search_item').val();	 
			$.post(load_url, {'barcode' : barcode}, function (data){				
				$('#list_purchased').html(data);
			});
		}
		
	    function void_all_scanned_items(){	
			var void_all_url = baseUrl+'cashier/void_all_scanned/';
			$.post(void_all_url, {}, function(data){					
				var res = data.split('|');				
				if(res[0] == 'success'){
					rMsg('Scanned Items Successfully Voided','success');
				}	
			});      
		}
	    function load_amount_purchases(){
			var load_url = baseUrl+'cashier/load_amount_purchases/';
			$.post(load_url, {}, function (data){				
				$('#total_amount_div').html(data);
			});
		}
	    function discount_type(pwd, sc){
			var load_url = baseUrl+'cashier/discount_type/';
			$.post(load_url, {'pwd' : pwd, 'sc': sc}, function (data){				
				$('#total_amount_div').html(data);
			});
		}
		
		function add_discount_function(){			
		    	 BootstrapDialog.show({
		            title: 'Select Discount Type',
		            message: 'Press 1 - Person With Disability <br/>Press 2 - Senior Citizen <br/> Press 3 - Cancel Discount  <br/> Press 4 - Close Popup Box ',
		            onshow: function(dialog) {
		            	
		            },
		            buttons: [{
		                id: 'pwd',
		                label: 'PWD Discount',
               			cssClass: 'btn-success',
		                hotkey: 49, // Keycode of keyup event of key 'A' is 65.
		                action: function() {
		                	discount_type(1,0);
							rMsg('PWD Discount is enabled','success');
							var delay=1000; //1 seconds
							setTimeout(function(){
								window.location = baseUrl+'cashier/search_barcode/';
							}, delay); 
		                }
		            }, {
		                id: 'sc',
		                label: 'SC Discount',
               			cssClass: 'btn-primary',
		                hotkey: 50, // Keycode of keyup event of key 'A' is 65.
		                action: function() {
		                	discount_type(0,1);
							rMsg('SC Discount is enabled','primary');
							var delay=1000; //1 seconds
							setTimeout(function(){
								window.location = baseUrl+'cashier/search_barcode/';
							}, delay); 
		                    //alert('Finally, you loved Button A.');
		                }
		             }, {
		                id: 'sc',
		                label: 'Cancel Discount',
               			cssClass: 'btn-warning',
		                hotkey: 51, // Keycode of keyup event of key 'A' is 65.
		                action: function() {
		                	discount_type(0,0);
							rMsg('Discount Cancelled','warning');
							var delay=1000; //1 seconds
							setTimeout(function(){
								window.location = baseUrl+'cashier/search_barcode/';
							}, delay); 
		                    //alert('Finally, you loved Button A.');
		                }
		            }, {
		                id: 'close',
		                label: 'Close',
               			cssClass: 'btn-danger',
		                hotkey: 52,
		                action: function() {
								window.location = baseUrl+'cashier/search_barcode/';
		                }
		            }]
		       });
		}
		function void_all_transaction_function(){
	    	 BootstrapDialog.show({
	            title: 'User Authentication',
		           message: "Username:<input type='text' class='form-control' name='username' id='username' placeholder='Username' autofocus><br/>Password:<input type='password' class='form-control' name='pass_word' id='pass_word' placeholder='Password'> <br/> Press 1- Contiue &nbsp;Press 2 - Close Popup Box",
	            onshow: function(dialog) {
	            	
	            },
	            buttons: [{
	                id: 'pwd',
	                label: 'Continue',
           			cssClass: 'btn-success',
	                hotkey: 49, // Keycode of keyup event of key 'A' is 65.
	                action: function() {
	                	username = $("#username").val();
		                pass_word = $("#pass_word").val();
		                var check_pass = baseUrl+'cashier/check_pass/';
						$.post(check_pass, {'uname' : username, 'pass' : pass_word}, function(data){					
							var res = data.split('|');				
							if(res[0] == 'success'){
								void_all_scanned_items();
			                	discount_type(0,0);
								var delay=1000; //1 seconds
								setTimeout(function(){
									window.location = baseUrl+'cashier/search_barcode/';
								}, delay); 
							}else{
							rMsg('Username and Password not recognized','error');
							}
						}); 
	                }
	            }, {
	                id: 'sc',
	                label: 'Cancel',
           			cssClass: 'btn-primary',
	                hotkey: 50, // Keycode of keyup event of key 'A' is 65.
	                action: function() {
	                	discount_type(0,0);
						//rMsg('SC Discount is enabled','primary');
						var delay=500; //1 seconds
						setTimeout(function(){
							window.location = baseUrl+'cashier/search_barcode/';
						}, delay); 
	                    //alert('Finally, you loved Button A.');
	                }
	             }]
	       });
		}
		function price_inq_function(){	
			$('#file-spinner').show();			   			
			$('#list_purchased').hide();			
			$('#total_amount_div').hide();
			$('#look_up_div').hide()
			$('#search_div').hide();
			var delay=200; //0.5 seconds
			setTimeout(function(){
				$('#file-spinner').hide();		
			}, delay); 		
			$('#price_inq_div').fadeIn(500);		  
			$("#price_inq_list").fadeIn(500); 
			$('#price_inq_barcode').focus();	
		}
		function look_up_function(){	
			$('#file-spinner').show();			   			
			$('#list_purchased').hide();			
			$('#total_amount_div').hide();
			$('#search_div').hide();
			$('#price_inq_div').hide();
			var delay=200; //0.5 seconds
			setTimeout(function(){
				$('#file-spinner').hide();		
			}, delay); 		
			$('#look_up_div').fadeIn(500);		  
			$("#price_inq_list").fadeIn(500); 
			$('#price_inq_description').focus();	
		}
		function choose_tender_type_function(){			
			window.location = baseUrl+'cashier/payment_type/';
			/*var load_url = baseUrl+'cashier/payment_type/';
			$.post(load_url, {}, function (data){				
				$('#search_div').html(data);
			});*/
		}
		function line_void_function(){
			
		}
		
				
	    $(document).keyup(function(e){
		   var charCode = (e.which) 
		   ? e.which : event.keyCode
		   if (e.altKey && charCode == 189){ // add discount 
        		add_discount_function();
		   }
		   else if (e.altKey && charCode == 120){  // void all transaction
        		void_all_transaction_function();
		   }
		   else if (charCode == 115){  // price inquiry	
		   		price_inq_function();
		   }
		   else if (charCode == 118){  // look up (description)
		   		look_up_function();
		   }
		   else if (e.altKey && charCode == 80){  // tender type	
		   		choose_tender_type_function();
		   }
		   else if (e.altKey && charCode == 88){  // line voide
		   		//alert('me');	
		   		line_void_function();
		   }else if(charCode == 109){
				$('td').first().focus();
		   }
		  });	
		  
		$('#add_discount').click(function(){
        	add_discount_function();
			return false;
		});

		$('#void_all_scanned').click(function(){
        	void_all_transaction_function();
			return false;
		});
		
		$('#price_inq').click(function(){
		   	price_inq_function();
		});
		
		$('#look_up_id').click(function(){
		   look_up_function();
		});
		
		$('#choose_tender_type').click(function(){
		   	choose_tender_type_function();		   	
			
		});		
		
		$('#line_void').rPopView({
			wide: true,
			asJson: true,
			onComplete: function(data){
				$('[data-bb-handler=cancel]').click();				
				
			}
		})
		
	<?php elseif($use_js == 'linevoidJS'): ?>
		//alert('gsdfhgds');
		$("[data-toggle='offcanvas']").click(); //hide main menu sa side
		$('.delete_this_line').click(function(){
			var line_id = $(this).attr('ref');
			 BootstrapDialog.show({
	            title: 'User Authentication',
	            message: "Username:<input type='text' class='form-control' name='username' id='username' placeholder='Username' autofocus><br/>Password:<input type='password' class='form-control' name='pass_word' id='pass_word' placeholder='Password'> <br/> Press 1- Contiue &nbsp;Press 2 - Close",
	            onshow: function(dialog) {
	            	
	            },
	            buttons: [{
	                id: 'pwd',
	                label: 'Continue',
           			cssClass: 'btn-success',
	                hotkey: 49, // Keycode of keyup event of key 'A' is 65.
	                action: function() {
	                	username = $("#username").val();
		                pass_word = $("#pass_word").val();
		                var check_pass = baseUrl+'cashier/check_pass/';
						$.post(check_pass, {'uname' : username, 'pass' : pass_word}, function(data){					
							var res = data.split('|');				
							if(res[0] == 'success'){
								//rMsg('User is authorized','success');
								var void_all_url = baseUrl+'cashier/void_line/';
								$.post(void_all_url, {'line_id' : line_id}, function(data){					
									var res = data.split('|');				
									if(res[0] == 'success'){
										rMsg('Line Voided','success');
										var delay=500; //1 seconds
										setTimeout(function(){
											window.location = baseUrl+'cashier/search_barcode/';
										}, delay); 
									}	
								});     
							}else{
								rMsg('Username and Password not recognized','error');
							}
						}); 
	                }
	            }, {
	                id: 'sc',
	                label: 'Close',
           			cssClass: 'btn-danger',
	                hotkey: 50, // Keycode of keyup event of key 'A' is 65.
	                action: function() {
	                	
	                	//discount_type(0,1);
						//rMsg('SC Discount is enabled','primary');
						var delay=300; //1 seconds
						setTimeout(function(){
							window.location = baseUrl+'cashier/search_barcode/';
						}, delay); 
	                    //alert('Finally, you loved Button A.');
	                }
	            // }
	            }]
	       });
			//alert('delete me! ->'+ref);
			return false;	
		});
	<?php elseif($use_js == 'customerBranchJS'): ?>
		$('#add-branch-btn').click(function(){
			debtor_id = $('#debtor_id').val();
			debtor_branch_id = $('#debtor_branch_id').val();
			window.location = baseUrl+'customer/add_branch/'+debtor_id+'/'+debtor_branch_id;
			return false;
		});	
		
	<?php elseif($use_js == 'settleJs'): ?>
		$('#total_amount_div').hide();	
		$('#list_purchased').hide();	
		
	    function get_details_tender_types(payment_type){
			var load_url = baseUrl+'cashier/get_tender_type_details/';
			$.post(load_url, {'payment_type' : payment_type}, function (data){	
						
				//$('#total_amount_div').html(data);
				
			});
		}
		$('td').first().focus;
		var currCell = $('td').first();
		//alert(currCell);
		$('#tender_types_div').keydown(function (e) {
			var c = "";
			if (e.which == 38) { 
				// Up Arrow
				c = currCell.closest('tr').prev().find('td:eq(' + 
				  currCell.index() + ')');
			} else if (e.which == 40) { 
				// Down Arrow
				c = currCell.closest('tr').next().find('td:eq(' + 
				  currCell.index() + ')');
			}else if (e.which == 13) { 
				var payment_type = currCell.html();
				if(payment_type){
					get_details_tender_types(payment_type);
				}
				return false;		
			}
			if (c.length > 0) {
				currCell = c;
				currCell.focus();
			}
		});
		

		
		 $(document).keyup(function(e){
		   var charCode = (e.which) 
		   ? e.which : event.keyCode
		  	
	    //  if (e.keyCode == 27) {box.modal("hide");}   // esc
			
		  if (e.altKey && charCode == 68){ //line void
		 
		 bootbox.dialog({
                title: "Line Void.",
                message: 'line_void',
            }
        );
				
		   
		  }
					
	    });	

	<?php endif; ?>
});
</script>