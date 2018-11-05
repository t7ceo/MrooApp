<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myutil {
	var $MCI = "";

	
	function getMyutil(){
		$this->MCI =& get_instance();
	}
	
	function setMytxt($ii){
		
		//$data = array("mygab" => $ii);
		//$this->MCI->load->vars($data);
	
	}
	
	function getMytxt(){

		$this->getMyutil();
		//$this->MCI->load->get_var('mygab');
		
		return $this->MCI->config->item('ssMenu'); //"uuu".$this->MCI->session->userdata('memid');
	
	}
	
	
	
}


?>