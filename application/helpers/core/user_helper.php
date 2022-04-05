<?php
function makeUserForm($user=array()){
	$CI =& get_instance();

	$CI->make->sForm("core/user/users_db",array('id'=>'users_form'));
		/* GENERAL DETAILS */
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(3);
				$CI->make->hidden('id',iSetObj($user,'id'));
				$CI->make->input('First Name','fname',iSetObj($user,'fname'),'First Name',array('class'=>'rOkay'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->input('Middle Name','mname',iSetObj($user,'mname'),'Middle Name',array());
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->input('Last Name','lname',iSetObj($user,'lname'),'Last Name',array('class'=>'rOkay'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(3);
				$CI->make->input('Suffix','suffix',iSetObj($user,'suffix'),'Suffix',array());
			$CI->make->eDivCol();
    	$CI->make->eDivRow();

		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(6);
					$CI->make->input('Username','uname',iSetObj($user,'username'),'Username',array('class'=>'rOkay',iSetObj($user,'id')?'disabled':''=>''));
					if(!iSetObj($user,'id'))
					$CI->make->input('Password','password',iSetObj($user,'password'),'Password',array('type'=>'password','class'=>'rOkay',iSetObj($user,'id')?'disabled':''=>''));
					$CI->make->input('Email','email',iSetObj($user,'email'),'Email',array('class'=>''));
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
					$CI->make->input('Employee ID','emp_id',iSetObj($user,'emp_id'),'',array('class'=>'rOkay formInputMini',iSetObj($user,'emp_id')?'disabled':''=>''));
					$CI->make->roleDrop('Role','role',iSetObj($user,'role'),'Role',array());
					$CI->make->genderDrop('Gender','gender',iSetObj($user,'gender'),array('class'=>'rOkay'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
   	 	/* GENERAL DETAILS END */
	$CI->make->eForm();

	return $CI->make->code();
}
function makeUserAccessForm($role=array()){
	$CI =& get_instance();

	$CI->make->sForm("user/user_access_db",array('id'=>'user_permissions_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(3);
				$CI->make->hidden('id',iSetObj($role,'id'));
				$CI->make->input('Role Name','role',iSetObj($role,'role'),'Role',array('class'=>'rOkay'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(9);
				$CI->make->input('Description','description',iSetObj($role,'description'),'Description',array());
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			// $CI->make->sDivCol(12);
				$CI->make->sBox('success');
                    $CI->make->sBoxHead();
                        $CI->make->boxTitle('Attendance');
                    $CI->make->eBoxHead();
                    $CI->make->sBoxBody();
                        // $list = array();
                        // // $icon = $CI->make->icon('fa-plus');
                        // $list[fa('fa-plus').' Add New'] = array('id'=>'add-new','class'=>'grp-list');
                        // foreach($lists as $val){
                        //     $name = "";
                        //     if(!is_array($desc))
                        //       $name = $val->$desc;
                        //     else{
                        //         foreach ($desc as $dsc) {
                        //            $name .= $val->$dsc." ";
                        //         }
                        //     }
                        //     $list[$name] = array('class'=>'grp-btn grp-list','id'=>'grp-list-'.$val->$ref,'ref'=>$val->$ref);
                        // }
                        // $CI->make->listGroup($list,array('id'=>'add-grp-list-div'));
                    $CI->make->eBoxBody();
                $CI->make->eBox();
			// $CI->make->eDivCol();
    	$CI->make->eDivRow();
	return $CI->make->code();
}
?>