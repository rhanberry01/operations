$(document).ready(function(){

	$('#save-list-form').click(function(){
		var form = $(this).attr('save-form');
		var loadUrl = $(this).attr('load-url');
		$('#'+form).rOkay({
			asJson	   : true,
			btn_load   : $('#save-list-form'),
			btn_load_remove : true,
			onComplete : function(data){
				if (typeof data.error != 'undefined') {
					rMsg(data.msg,'warning');
					return false;
				}
				if(data.act == 'add'){
					$('.grp-list').removeClass('active');
					$('#add-grp-list-div').append('<a href="#" id="grp-list-'+data.id+'" class="grp-btn grp-list list-group-item active" ref="'+data.id+'">'+data.desc+'</a>');
					loadDetail(data.id);
					selectList($('#grp-list-'+data.id));
					selectGroup(data.id);
				}
				else{
					$('#grp-list-'+data.id).text(data.desc);
					loadDetail(data.id);
				}
				if(typeof data.msg != 'undefined' ){
					rMsg(data.msg,'success');
				}
			}
		});
	});
	loadDetail('');
	$('#add-new').addClass('active');
	$('#add-new').click(function(event){
		selectList($('#add-new'));
		loadDetail('');
		event.preventDefault();
	});
	$('.grp-btn').click(function(event){
		selectList($(this));
		var ref = $(this).attr('ref');
		loadDetail(ref);
		event.preventDefault();
	});
	function selectGroup(id){
		$('#grp-list-'+id).click(function(event){
			selectList($(this));
			var ref = $(this).attr('ref');
			loadDetail(ref);
			event.preventDefault();
		});
	}
	function selectList(obj){
		$('.grp-list').removeClass('active');
		obj.addClass('active');
	}
	function loadDetail(groupID){
		var loadUrl = $('#group-detail-con').attr('load-url');
		$('#group-detail-con').rLoad({url:baseUrl+loadUrl+'/'+groupID});
	}
});

