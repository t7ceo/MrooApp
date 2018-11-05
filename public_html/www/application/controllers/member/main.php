<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{

	
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

		$this->load->model('member/member');
		$this->session->set_userdata("coid",1);

		if($md3 == 0){
			if($this->session->userdata("cogubun") == BONSA or $this->session->userdata("cogubun") == JOHAPG){
			}else{
				$md3 = $this->session->userdata("coid");
			}
		}	


		if($this->session->userdata('main') != $md){
			$this->session->set_userdata("findMd", "0");
			$this->session->set_userdata("find", "");
		}
		
		
		
		if($md2 == 1 or $md2 == 2){
			$this->session->set_userdata('main', $md);
			$this->session->set_userdata('old', $this->session->userdata("md2"));
			$this->session->set_userdata("md2",$md2);
			$this->session->set_userdata("co",$md3);
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

		//본사 관리자가 아니면 자신의 업체만 볼수 있다.
		if($this->session->userdata('cogubun') < BONSA) $md3 = $this->session->userdata('coid');
		
		
		//===================================================
		///*
		$this->load->library('pagination');		
		$pagePerNum = PAGELINE;
		$config['base_url'] = '/member/main/getView/'.$md.'/'.$md2."/".$md3."/".$md4."/".$fnd;
		$config["per_page"] = $pagePerNum;
		$config["num_links"] = 2;
		$config["cur_page"] = $page;
		$plink = array("md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page, "ppn"=>$pagePerNum, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3);
		//*/
		//====================================================
		
	

		$param = array("mode" => "main", "md" => $md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page);
		$this->load->view("common/head", $param);
		
		
		
		
		switch($md){
		case 1:
			//회원리스트를 가져온다.
			$queryGaip = $this->member->memListAll("stat = 2");
			
			$queryMiGaip = $this->member->memListAll("stat = 1");	
			
			$queryChandan = $this->member->memListAll("stat = 3");	
			
			$this->load->view('member/allmem', array("allMem"=>$queryGaip, "migaipMem"=>$queryMiGaip, "chadanMem"=>$queryChandan, "seMenu"=>getSeMenu($this->session->userdata('mainMenu')), $param));
			
		break;
		case 2:   //신고내역
			//신고내역을 출력
			$query = $this->member->singoListAll();
			$this->load->view('member/singo', array("singo"=>$query, "seMenu"=>getSeMenu($this->session->userdata('mainMenu')), $param));
		break;
		}

		$this->load->view("common/foot", $param);
	
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