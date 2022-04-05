<?php
ini_set('mssql.connect_timeout',0);
ini_set('mssql.timeout',0);
ini_set('memory_limit', '-1');
set_time_limit(0);

class operation_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}
	
	function sample(){
		echo "Model";
		$user    = $this->session->userdata('user');
        $user_branch = $user['branch'];
		$this->bdb = $this->load->database($user_branch,TRUE);
		$connected = $this->bdb->initialize();
			if($connected){

				$sql = "Insert Into TempCycleCount2(Barcode)
						Values ('2222')";
			
				$this->bdb->trans_begin();
				$result = $this->bdb->query($sql);
				
				if($result){
					$this->bdb->trans_commit();
					return 'success';
				}
				else{
					$this->bdb->trans_rollback();
					return 'error';
				}	
			}
	}


}

?>