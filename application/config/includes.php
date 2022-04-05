<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////////////////////////
/// Include your css or style sheets          ///
////////////////////////////////////////////////
$styleSheets = array();
$styleSheets[] = "css/bootstrap.min.css";
$styleSheets[] = "css/font-awesome.min.css";
$styleSheets[] = "css/ionicons.min.css";
$styleSheets[] = "css/datatables/dataTables.bootstrap.css";
$styleSheets[] = "css/fileUpload/jquery.fileupload.css";
$styleSheets[] = "css/timepicker/bootstrap-timepicker.css";
$styleSheets[] = "js/plugins/perfect-scrollbar/perfect-scrollbar.css";
$styleSheets[] = "js/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css";
$styleSheets[] = "css/bootstrap-combobox/bootstrap-combobox.css";
$styleSheets[] = "css/bootstrap-dialog/bootstrap-dialog.css";
$styleSheets[] = "css/wizard-steps/jquery.steps.css";
$styleSheets[] = "css/AdminLTE.css";
//$styleSheets[] = "css/page.css";
//$styleSheets[] = "css/vendor/bootstrap/css/bootstrap.min.css";
//$styleSheets[] = "css/sb-admin.csscss/sb-admin.css">
$config['incCss'] = $styleSheets;

////////////////////////////////////////////////
/// Include your js files                   ///
//////////////////////////////////////////////
$jsFiles = array();
$jsFiles[] = "js/jquery.min.js";
$jsFiles[] = "js/bootstrap.min.js";
$jsFiles[] = "js/alert.js";

$jsFiles[] = "js/plugins/datatables/jquery.dataTables.js";
$jsFiles[] = "js/plugins/datatables/dataTables.bootstrap.js";

$jsFiles[] = "js/plugins/input-mask/jquery.inputmask.js";
$jsFiles[] = "js/plugins/input-mask/jquery.inputmask.date.extensions.js";
$jsFiles[] = "js/plugins/input-mask/jquery.inputmask.extensions.js";
$jsFiles[] = "js/plugins/noty/packaged/jquery.noty.packaged.min.js";
$jsFiles[] = "js/raphael.js";

$jsFiles[] = "js/AdminLTE/app.js";
$jsFiles[] = "js/plugins/sparkline/jquery.sparkline.min.js";
$jsFiles[] = "js/plugins/morris/morris.min.js";
$jsFiles[] = "js/bootbox.js";
$jsFiles[] = "js/jquery.number.js";
$jsFiles[] = "js/plugins/perfect-scrollbar/jquery.mousewheel.js";
$jsFiles[] = "js/plugins/perfect-scrollbar/perfect-scrollbar.js";
$jsFiles[] = "js/plugins/timepicker/bootstrap-timepicker.js";
$jsFiles[] = "js/plugins/datetimepicker/js/moment.js";
$jsFiles[] = "js/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js";
$jsFiles[] = "js/plugins/bootstrap-combobox/bootstrap-combobox.js";
$jsFiles[] = "js/plugins/bootstrap-dialog/bootstrap-dialog.js";
//$jsFiles[] = "vendor/jquery/jquery.min.js";///
//$jsFiles[] = "vendor/bootstrap/js/bootstrap.bundle.min.js";
//$jsFiles[] = "vendor/jquery-easing/jquery.easing.min.js";
//$jsFiles[] = "vendor/chart.js/Chart.min.js";
//$jsFiles[] = "js/sb-admin.min.js";
//$jsFiles[] = "js/sb-admin-datatables.min.js";
//$jsFiles[] = "js/sb-admin-charts.min.js";

$jsFiles[] = "js/initial.js";
$jsFiles[] = "js/helper.js";
$config['incJs'] = $jsFiles;
