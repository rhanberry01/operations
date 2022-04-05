function baseUrl() {
	var href = window.location.href.split('/');
	return href[0]+'//'+href[2]+'/'+href[3]+'/';
}
var baseUrl = baseUrl();
function isArray(object){
    return object.constructor === Array;
}
function formatNumber(number,dec){

	if(typeof(dec) == 'undefined')
		dec = 2;
    number = number.toFixed(dec) + '';
    x = number.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function rMsg(text,type){
	var n = noty({
	       text        : text,
	       type        : type,
	       dismissQueue: true,
	       layout      : 'topRight',
	       theme       : 'defaultTheme',
	       animation	: {
						open: {height: 'toggle'},
						close: {height: 'toggle'},
						easing: 'swing',
						speed: 500 // opening & closing animation speed
					}
	   }).setTimeout(3500);
}
function site_alerts(){
    $.post(baseUrl+'site/site_alerts',function(data){
        var alerts = data.alerts;
        $.each(alerts, function(index,row){
            rMsg(row['text'],row['type']);
        });
    },"json").promise().done(function() {
        $.post(baseUrl+'site/clear_site_alerts');
    });
}
$(document).ready(function(){
    site_alerts();
	$('.data-table').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aaSorting":[],
        "bDestroy":true
    });
    $('.no-decimal').number(true,0);
    $('.numbers-only').number(true,2);
    $('.amount-only').number(true,4);
    $("[data-mask]").inputmask();
    $('.pick-date').datetimepicker({
        pickTime: false
    });
    $('.pick-time').datetimepicker({
		pickDate: false
	});
	$(".num_without_decimal").on("keypress keyup blur",function (event) {    
	   $(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});
	$(".num_with_decimal").on("keypress keyup blur",function (event) {
		$(this).val($(this).val().replace(/[^0-9\.]/g,''));
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});
    $('select.combobox').combobox({bsVersion: '3'});
});

    //Sparkline charts
    var myvalues = [511, 323, 555, 731, 100, 220, 101, 276, 195, 399, 219];
    $('#sparkline-1').sparkline(myvalues, {
        type: 'bar',
        barColor: '#00a65a',
        negBarColor: "#f56954",
        height: '20px'
    });
    myvalues = [15, 19, 20, 22, 55, 30, 58, 27, 19, 30, 21];
    $('#sparkline-2').sparkline(myvalues, {
        type: 'bar',
        barColor: '#00a65a',
        negBarColor: "#f56954",
        height: '20px'
    });
    myvalues = [35, 29, 30, 22, 33, 27, 31, 27, 29, 30, 36];
    $('#sparkline-3').sparkline(myvalues, {
        type: 'bar',
        barColor: '#00a65a',
        negBarColor: "#f56954",
        height: '20px'
    });
    myvalues = [15, 19, 20, 22, 33, -27, -31, 27, 19, 30, 21];
    $('#sparkline-4').sparkline(myvalues, {
        type: 'bar',
        barColor: '#00a65a',
        negBarColor: "#f56954",
        height: '20px'
    });
    myvalues = [15, 19, 20, 22, 33, 27, 31, -27, -19, 30, 21];
    $('#sparkline-5').sparkline(myvalues, {
        type: 'bar',
        barColor: '#00a65a',
        negBarColor: "#f56954",
        height: '20px'
    });
    myvalues = [15, 19, -20, 22, -13, 27, 31, 27, 19, 30, 21];
    $('#sparkline-6').sparkline(myvalues, {
        type: 'bar',
        barColor: '#00a65a',
        negBarColor: "#f56954",
        height: '20px'
    });

