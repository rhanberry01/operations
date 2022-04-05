<?php
function makeLoginBox(){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->sBox('primary');
					$CI->make->sBoxHead();
						$CI->make->boxTitle('Example');
					$CI->make->eBoxHead();
					
					$CI->make->sBoxBody();
						$CI->make->input('something','example',null,'example',array(),'<i class="fa fa-user"></i>');
					$CI->make->eBoxBody();

					$CI->make->sBoxFoot();
						$CI->make->button('something',array(),'primary');
					$CI->make->eBoxFoot();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();				
	return $CI->make->code();
}

function error_db(){
    $CI =& get_instance();
        $CI->make->sDivRow();
            $CI->make->sDivCol(12);
                $CI->make->sBox('danger');
                    $CI->make->sBoxHead();
                       $CI->make->H(1,"ERROR!",array('style'=>'color:red;margin-top:0px;margin-bottom:0px'));
                    $CI->make->eBoxHead();
                    
                    $CI->make->sBoxBody();
                       // $CI->make->H(4,"Can't Connect to server. Please try again later.<br>Try to logout and login your account then process the transaction again.",array('style'=>'margin-top:0px;margin-bottom:0px'));

                       $CI->make->sTable(array('class'=>'table table-hover','id'=>'details-tbl'));
                       $CI->make->eTable();
                    $CI->make->eBoxBody();
                $CI->make->eBox();
            $CI->make->eDivCol();
        $CI->make->eDivRow();               
    return $CI->make->code();
}


function dashboard(){
	 $CI =& get_instance();
        //$total_no_display = $CI->site->no_display();
        //$total_neg_inventory = $CI->site->neg_inventory();
        //$total_cycle_count = $CI->site->cycle_count();
        $CI->make->sDivCol(12);
          $CI->make->sDivRow();
            $CI->make->sDivCol(4);
              $CI->make->sDivRow();
                $CI->make->sDiv(array('class'=>'panel panel-primary'));
                    $CI->make->sBox('primary',array('style'=>'height:310px'));
                      $CI->make->sBoxBody();
                        $CI->make->sDivRow();
                        $CI->make->sForm("",array('id'=>'addcc_form'));
                          $CI->make->sDivCol(12);
                            $CI->make->input('Barcode','barcode','','Enter Barcode Here...',array('class'=>'','id'=>'autocomplete'));
                          $CI->make->eDivCol();
                          $CI->make->sDivCol(12);
                            $CI->make->button(fa('fa-plus').' Add Item',array('id'=>'savecc-btn','class'=>'btn-block btn-flat','style'=>''),'primary');
                          $CI->make->eDivCol();
                        $CI->make->eForm();
                        $CI->make->eDivRow();
                      $CI->make->eBoxBody();
                    $CI->make->eBox();
                $CI->make->eDiv();
              $CI->make->eDivRow();
            $CI->make->eDivCol();
          $CI->make->eDivRow();
        $CI->make->eDivCol();
        // <div class="col-lg-3 col-md-6">
        //             <div class="panel panel-primary">
        //                 <div class="panel-heading">
        //                     <div class="row">
        //                         <div class="col-xs-3">
        //                             <i class="fa fa-comments fa-5x"></i>
        //                         </div>
        //                         <div class="col-xs-9 text-right">
        //                             <div class="huge">26</div>
        //                             <div>New Comments!</div>
        //                         </div>
        //                     </div>
        //                 </div>
        //                 <a href="#">
        //                     <div class="panel-footer">
        //                         <span class="pull-left">View Details</span>
        //                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        //                         <div class="clearfix"></div>
        //                     </div>
        //                 </a>
        //             </div>
        //         </div>
        return $CI->make->code();

}

?>