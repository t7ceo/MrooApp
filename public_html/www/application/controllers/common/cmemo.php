<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cmemo extends CI_Controller{

	var $param = array();
	
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');  //redirect 사용을 위해 설정
		
		$this->load->library('email');
		
		
		$nowControl = $this->router->fetch_class();
		$this->session->set_userdata('mainMenu', $nowControl);

    }

	//http://mroo.co.kr/home  호출시 실행
	public function index(){
		
		//echo "kkkk";
		
			//디폴트 서버메뉴를 설정 한다.
			//set_defaultSub();		
		
			//$param = array("mode" => "personJ");
		
			$this->load->view("common/head");
			//$this->load->view("memjoinV");
			$this->load->view("common/memo");
			
			$this->load->view("common/foot");
			
	}

}


?>