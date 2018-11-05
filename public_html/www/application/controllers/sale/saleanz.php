<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saleanz extends CI_Controller{

	
	var $newdata = array();
	var $param = array();
	
	
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');   //redirect 사용을 위해 설정
		
		$nowControl = $this->router->fetch_class();
		$this->session->set_userdata('mainMenu', $nowControl);
	
		
		
		if(!$this->session->userdata('memid')){
			redirect("/home") ;
		}else{
			$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.
			
			//회원의 자격으로 열수 없는 페이지는 강제로 페이지 전환한다.
			$rra = pageGoInf("main");
			if($rra['rs']) redirect($rra['page']);
		

		}
    }

	//http://mroo.co.kr/home  호출시 실행
	public function index(){
		
		
		//디폴트 서버메뉴를 설정 한다.
		//set_defaultSub();
		
		$this->session->set_userdata("findMd", "0");
		$this->session->set_userdata("find", "");
		
		
		
		if($this->session->userdata('memid')){
			
			//echo "999999".$this->session->userdata('potion');
			if($this->session->userdata('potion') > SAWON){
				//관리자 이상인 경우-회원관리 메뉴로 간다.
				if(!$this->session->userdata('main')) $gg = 1;
				else{
					$gg = 1; //$this->session->userdata('main');
					if($gg > 3) $gg = 2;
				}
				
				$this->getView($gg);
			}else{
				//echo "login no00";
				redirect("/scene/hjang") ;
			}
		}else{
			//echo "login no111";
			redirect("/home") ;
		}

	}

	public function getView($md, $md2 = 1, $md3=0, $md4=0, $fnd="0", $page=0){

		$this->load->model('sale/saleanzdb');

		if($this->session->userdata('main') != $md){
			$this->session->set_userdata("findMd", "0");
			$this->session->set_userdata("find", "");
		}
		
		
	
		//관리자 이하는 무조건 마이페이지로 간다.
		if($this->session->userdata('potion') < ADMIN){
			$md3 = 0;
			$md = 4; 
		}else{
			//자신의 구분과 직책에 따라 전체업체의 리스트를 가져온다.
			$coarr = array("md"=>$md, "cogubun"=>$this->session->userdata('cogubun'), "po"=>$this->session->userdata('potion'), "coid"=>$this->session->userdata('coid'));
			
		}


		
		//===================================================
		///*
		$this->load->library('pagination');		
		$pagePerNum = PAGELINE;
		$config['base_url'] = '/sale/saleAnz/getView/'.$md.'/'.$md2."/".$md3."/".$md4."/".$fnd;
		$config["per_page"] = $pagePerNum;
		$config["num_links"] = 2;
		$config["cur_page"] = $page;
		$plink = array("md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page, "ppn"=>$pagePerNum, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3);
		//*/
		//====================================================
		
	

		$param = array("mode" => "main", "md" => $md, "md2"=>$md2, "md3"=>$md3);
		$this->load->view("common/head", $param);
		
		switch($md){
		case 1:
	
			switch($md3){
				case 1:
		
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				$this->load->model('statis/statisdb');
				//이용권 가격표 및 구매수
				$gumeAnz = $this->statisdb->gumeAnz(1);
				//주문제낙 가격표
				$jumunAnz = $this->statisdb->gumeAnz(2);				
				
				
				
				$this->load->model('sale/saleanzdb');
				//공지 리스트 
				$su = count($this->saleanzdb->saleanzTotalCount(1));
				$config["total_rows"] = $su;
				$this->pagination->initialize($config);
							
			
				//주문내역을 가져온다.
				$query = $this->saleanzdb->saleAll();
				
				$this->load->view('sale/saleanzall', array_merge($plink, $param, array("allbd"=>$query, "totalCount"=>$su, "seMenu"=>getSeMenu($this->session->userdata('mainMenu')), "gumeAnz"=>$gumeAnz, "jumunAnz"=>$jumunAnz)));
				}
			
		break;
		case 2:   //

		break;
		case 3:   //

		break;
		}


		if(!$md2) $md2 = 0;
		if(!$md3) $md3 = 0;
		if(!$md4) $md4 = 0;
		$this->load->view("common/foot", $plink); 



	}





	public function logout(){
		logout();
	}






}





?>