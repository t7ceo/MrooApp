<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kakaologin extends CI_Controller{

	var $param = array();
	
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');  //redirect 사용을 위해 설정
		
		$nowControl = $this->router->fetch_class();
		$this->session->set_userdata('mainMenu', $nowControl);

    }

	public function index(){
		
			//$this->load->view("common/head");
			//$this->load->view("memjoinV");
			$this->load->view("common/facebooklogin");
			
			//$this->load->view("common/foot");
			
	}

}


?>