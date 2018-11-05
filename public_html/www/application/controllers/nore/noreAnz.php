<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NoreAnz extends CI_Controller{

	
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
				//redirect("/scene/hjang") ;
			}
		}else{
			//echo "login no111";
			redirect("/home") ;
		}

	}

	public function getView($md, $md2 = 1, $md3=0, $md4=0, $fnd="0", $page=0){

		$this->load->model('nore/noreanzdb');


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
			
			//$allCo = $this->member->getCo($coarr, $md);  //전체 업체의 리스트를 가져온다.
			
		}


		
		//===================================================
		///*
		$this->load->library('pagination');		
		$pagePerNum = PAGELINE;
		$config['base_url'] = '/nore/noreAnz/getView/'.$md.'/'.$md2."/".$md3."/".$md4."/".$fnd;
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
				
				//공지 리스트 
				$su = count($this->noreanzdb->noreanzTotalCount(1));
				$config["total_rows"] = $su;
				$this->pagination->initialize($config);
							
			
				//주문내역을 가져온다.
				$query = $this->noreanzdb->jarangAll();
				
				$this->load->view('nore/noreanzall', array_merge($plink, $param, array("allbd"=>$query, "totalCount"=>$su, "seMenu"=>getSeMenu($this->session->userdata('mainMenu')))));
			break;
			}
		
		break;
		case 2:   //가입회원

		break;
		case 3:   //가입회원

		break;
		}


		$this->load->view("common/foot", $param);
		//$this->load->view('member/allmem', array("allmem"=>$query->result(), "seMenu"=>getSeMenu($this->session->userdata('mainMenu')), $param));

	
	}




	
	
	//회원삭제를 진행한다.
	public function memDeleteOk($mid, $po){
	
		$this->load->model('member/member');
		$meminf = $this->member->memDelOk($mid, $po);  //회원을 삭제 한다.
		
		redirect(go_path("member/main/getView/", $this->session->userdata('main')));
	
	}
	
	
	//업체 슈퍼 관리자의 존재 여부 확인 
	public function getCoSuperInf(){
		$mid = $this->input->post("memid",true);
		$this->load->model('member/member');
		$stat = $this->member->getCoSuperInf($mid);  //회원가입을 승인 한다.
		
		$aa["rs"] = $stat;
		//echo "kk=".$stat;
		echo json_encode($aa);
	}
	
	
	//회원가입 승인
	public function memOnBack($mid){
	
		$this->load->model('member/member');
		$meminf = $this->member->memOkBack($mid);  //회원가입을 승인 한다.
		
		redirect(go_path("member/main/getView/", $this->session->userdata('main')));

	}
	
	
	//회원자격을 변경한다.
	public function memPoChn($rid, $val){
	
		$this->load->model('member/member');
		$meminf = $this->member->memPoChn($rid, $val);  //회원의 자격을 변경한다.
		
		if($meminf['mid'] == 0){
			$tt = "직책변경 실패하였습니다. 다시 요청 하세요.";
		}else{
			$tt = "직책변경 완료 하였습니다.";
		}

		$meminf['rt'] = $tt;

		echo json_encode($meminf);
	
	}
	
	
	
	//회원가입 승인
	public function memOnOk($mid, $md = 1){
	
		$this->load->model('member/member');
		$meminf = $this->member->memOk($mid, $md);  //회원가입을 승인 한다.
		
		if($meminf == 0){
			$this->session->set_flashdata('transErr', '회원가입 승인 실패하였습니다. 다시 시도해 주세요.');
		}
		//echo $this->session->userdata('main')."/".$meminf;
		redirect(go_path("member/main/getView/", $this->session->userdata('main')));  //메인의 선택한 서버메뉴로 간다.

	}
	
	//회원가입 승인 거부
	public function memOnNo($mid){
	
		$this->load->model('member/member');
		$meminf = $this->member->memNo($mid);  //회원가입을 승인 한다.
		
		if($meminf == 0){
			$this->session->set_flashdata('transErr', '회원가입 승인 취소 실패하였습니다. 다시 시도해 주세요.');
		}
		
		redirect(go_path("member/main/getView/", $this->session->userdata('main')));

	}
	

	//업체 승인 거부
	public function comOnNo($mid){
	
		$this->load->model('company');
		$meminf = $this->company->comNo($mid);  //업체가입을 거부 한다.
		
		redirect(go_path("member/main/getView/", $this->session->userdata('main')));
	
	}
	
	//업체 승인
	public function comOnOk($mid){
	
		$this->load->model('company');
		$meminf = $this->company->comOk($mid);  //업체가입을 승인 한다.
		
		redirect(go_path("member/main/getView/", $this->session->userdata('main')));
	
	}


	public function logout(){
		logout();
	}






}





?>