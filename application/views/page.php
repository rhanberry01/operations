<?php
	$this->load->view('parts/head');
	$this->load->view('parts/topNav');
	$this->load->view('parts/sideNav');
	$this->load->view('parts/body');
	if(isset($load_js))
		{
			$this->load->view('js/'.$load_js);
		}
	$this->load->view('parts/foot');
?>