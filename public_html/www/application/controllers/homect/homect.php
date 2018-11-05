<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homect extends CI_Controller{

	
	var $newdata = array();
	var $param = array();
	
	public function __construct()
    {
        parent::__construct();
		
		
		$this->load->helper('url');   //redirect 사용을 위해 설정
		
		$nowControl = $this->router->fetch_class();
		$this->session->set_userdata('mainMenu', $nowControl);
		
		$cihs = $this->security->get_csrf_hash();  //ajax 사용하려면 헤시값을 전달 해야 한다.
		
		
    }

	//http://mroo.co.kr/didcms/home  호출시 실행
	public function index(){
		
		
		$this->session->set_userdata("findMd", "0");
		$this->session->set_userdata("find", "");
		
		//subDefaultSet();
		$this->getView(1,1,1);

	}

	public function getView($md, $md2 = 1, $md3=0, $md4=0, $fnd="0", $page=0){
		

		setMdGab($md, $md2, $md3, $md4);



		//$this->load->model('moniter/moniterdb');
		


		if($this->session->userdata('main') != $md){
			$this->session->set_userdata("findMd", "0");
			$this->session->set_userdata("find", "");
		}
		
		
		
		if($md2 == 1 or $md2 == 2){
			$this->session->set_userdata('main', $md);
			$this->session->set_userdata('old', $this->session->userdata("md2"));
			$this->session->set_userdata("md2",$md2);
			//$this->session->set_userdata("co",$md3);
		}

	
		//관리자 이하는 무조건 마이페이지로 간다.
		if($this->session->userdata('potion') < ADMIN){
			//$md3 = 0;
			//$md = 4; 
		}else{
			//자신의 구분과 직책에 따라 전체업체의 리스트를 가져온다.
			$coarr = array("md"=>$md, "cogubun"=>$this->session->userdata('cogubun'), "po"=>$this->session->userdata('potion'), "coid"=>$this->session->userdata('coid'));
			
			//$allCo = $this->member->getCo($coarr, $md);  //전체 업체의 리스트를 가져온다.
			
		}

		//본사 관리자가 아니면 자신의 업체만 볼수 있다.
		//if($this->session->userdata('cogubun') < BONSA) $md3 = $this->session->userdata('coid');

		
		//===================================================
		///*
		$this->load->library('pagination');		
		$pagePerNum = PAGELINE;
		$config['base_url'] = '/homect/homect/getView/'.$md.'/'.$md2."/".$md3."/".$md4."/".$fnd;
		$config["per_page"] = $pagePerNum;
		$config["num_links"] = 2;
		$config["cur_page"] = $page;
		$plink = array("md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page, "ppn"=>$pagePerNum, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3);
		//*/
		//====================================================
		

		$param = array("mode" => "homect", "md" => $md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "type"=>$fnd, "seMenu"=>getSeMenu($this->session->userdata('mainMenu')));
		$this->load->view("common/head", $param);
		

		switch($md){
		case 1:   //비정상 감지현황 - 감지현황 리스트에서 비정상만 추출
			//업체아이디, 매장아이디 설정되면 해당 업체와 매장만 추출
			//$arr = array_merge($param, array("mode"=>"notok", "coid"=>$this->session->userdata("coid"), "mejang"=>$this->session->userdata("mejang")));
			switch($md3){
			case 1:
			
				$plink['page'] = 0;
				$plink['ppn'] = 3;
							
			
				//신규, 신고, 차단회원 리스트
				$this->load->model('member/member');
				$querySingo = $this->member->singoListAll("stat > 0", 3);
				$queryMiGaip = $this->member->memListAll("stat = 1");	
				$queryChandan = $this->member->memListAll("stat = 3");	


				//공지사항, 질문 리스트
				$this->load->model('community/communitybd');
				$su = count($this->communitybd->gongjiTotalCount(1));
				$config["total_rows"] = $su;
				$this->pagination->initialize($config);
				$allbd = $this->communitybd->gongjiList(1, $page,$pagePerNum);
				//질문 리스트
				$faqsu = count($this->communitybd->faqbdTotalCount(3));
				$qna = $this->communitybd->faqbdList(3, 0, 3);
				
	
	
				
				//신규음원 리스트 
				$this->load->model('music/musiconm');
				$newMusic = $this->musiconm->allMusic_list($plink);
				//인기음원 리스트
				$plink['gubun'] = 1; //1:인기, 2:추천
				$ingiMusic = $this->musiconm->allMusic_SangseList($plink);
				//추천음원 리스트
				$plink['gubun'] = 2; //1:인기, 2:추천
				$chucheonMusic = $this->musiconm->allMusic_SangseList($plink);
				

				
				$this->load->view('homect/homeall', array_merge($param, array("migaip"=>$queryMiGaip, "singo"=>$querySingo, "chadan"=>$queryChandan, "allbd"=>$allbd, "totalCount1"=>$su, "qna"=>$qna, "totalCount3"=>$faqsu, "newMusic"=>$newMusic, "ingiMusic"=>$ingiMusic, "chucheon"=>$chucheonMusic)));
				
			break;
			}
			
		break;
		case 2:
			//업체별 감지현황 추출
			switch($md3){
			case 1:
			
				$ww = array("mode"=>"co", "lim"=>7, "nara"=>get_cookie("nara"), "coid"=>get_cookie("co"), "mejang"=>get_cookie("mejang"));
				$query = $this->moniterdb->sencitiveAll($ww);	
				$this->load->view('moniter/sencitiveCo', array("allmem"=>$query, $param));
			break;
			}
		break;
		case 3:
			//매장별 감지현황 추출
			switch($md3){
			case 1:
			
				$ww = array("mode"=>"mejang", "lim"=>7, "nara"=>get_cookie("nara"), "coid"=>get_cookie("co"), "mejang"=>get_cookie("mejang"));
				$query = $this->moniterdb->sencitiveAll($ww);	
				$this->load->view('moniter/sencitiveMejang', array("allmem"=>$query, $param));
			break;
			}
		break;
		case 4:
			//설치요청
			switch($md3){
			case 1:
			
				$this->load->model('monite/moniterdb');
				
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				$arr = array_merge($param, array("mode"=>"new", "nara"=>0, "coid"=>"0", "mejang"=>0, "query"=>"gubun = 1"));
				$totalCount = $this->moniterdb->allAS_totalCount($arr);
				$list = $this->moniterdb->allAS_list($arr);

				//$config["total_rows"] = $totalCount->su;
				//$this->pagination->initialize($config);


				//사업리스트를 출력한다.
				$obj = array("list" => $list, "totalCount"=>$totalCount->su);
				$this->load->view("moniter/comDevice", array_merge($plink, $obj));
			break;
			case 2:
			
				$param['gubun'] = 1;
				//사업리스트를 출력한다.
				$this->load->view("moniter/comOnEdit", $param);

			
			break;
			}
		break;
		case 5:
			//A/S요청 
			switch($md3){
			case 1:
			
				$this->load->model('monite/moniterdb');
				
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				$arr = array_merge($param, array("mode"=>"new", "nara"=>0, "coid"=>"0", "mejang"=>0, "query"=>"gubun = 2"));
				$totalCount = $this->moniterdb->allAS_totalCount($arr);
				$list = $this->moniterdb->allAS_list($arr);

				//$config["total_rows"] = $totalCount->su;
				//$this->pagination->initialize($config);


				//사업리스트를 출력한다.
				$obj = array("list" => $list, "totalCount"=>$totalCount->su);
				$this->load->view("moniter/comAs", array_merge($plink, $obj));
			break;
			case 2:
			
				$param['gubun'] = 2;
				//사업리스트를 출력한다.
				$this->load->view("moniter/comOnEdit", $param);
			
			break;
			}
		break;
		case 6:
		
			$this->load->model('device/devicedb');
		
			switch($md3){
			case 1:
			
				$query = $this->devicedb->allSetTopListNew();
				//장비 설정현황을 가져온다.
				$this->load->view("moniter/allSetTop", array("allmem"=>$query, $param));
			
			break;
			case 2:
			
				$query = $this->devicedb->allSetTopList();
				//장비 설정현황을 가져온다.
				$this->load->view("moniter/allSetTop", array("allmem"=>$query, $param));
			
			break;
			case 3:
			
				//$this->load->view('device/deviceSet', $plink);
			
				if($fnd == "set"){
					//장비설정을 한다.
					$this->load->view('moniter/deviceSet', $param);
				}else{

					$this->load->model('device/devicedb');
					$meminf = $this->devicedb->chnTypeSet($param);
					
					redirect(go_path("moniter/moniter/getView/6/1/2"));
				}
			
			
			break;
			case 4:
			
			
			break;
			case 5:
			
			
			break;
			}
		
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