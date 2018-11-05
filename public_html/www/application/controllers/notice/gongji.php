<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//MROO
class Gongji extends CI_Controller{

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
		}
    }

	//http://mroo.co.kr/home  호출시 실행
	public function index(){
	
		
		$this->session->set_userdata("findMd", "0");
		$this->session->set_userdata("find", "");
		
		
		if($this->session->userdata('memid')){
			
			if(!$this->session->userdata('gongji')){
				//디폴트 서버메뉴를 설정 한다.
				$gg = set_defaultSub();		
			}else $gg = 1; //$this->session->userdata('gongji');
			
			$this->getView($gg, 1);
			
		
		}else{
			//echo "login no";
			redirect("/home") ;
		}
	
	}
	
			//서버메뉴에 따라 뷰어를 불러 온다.
	public function getView($md, $md2 = 1, $md3 = 0, $md4 = 0, $fnd="0", $page=0){

			$this->session->set_userdata("findMd", "0");
			$this->session->set_userdata("find", "");

	
		$this->session->set_userdata('gongji', $md);
	
		
		//관리자 이하는 무조건 마이페이지로 간다.
		if($this->session->userdata('potion') < 1){
			$md3 = 0;
			$md = 1; 
		}else{
			//자신의 구분과 직책에 따라 전체업체의 리스트를 가져온다.
			$this->load->model('member/member');
			$coarr = array("md"=>$md, "cogubun"=>$this->session->userdata('cogubun'), "po"=>$this->session->userdata('potion'),"coid"=>$this->session->userdata('coid'));
			//$allCo = $this->member->getCo($coarr);  //전체 업체의 리스트를 가져온다.
		}
		

	
		//===================================================
		$pagePerNum = PAGELINE;
		$config['base_url'] = '/notice/gongji/getView/'.$md.'/'.$md2."/".$md3."/".$md4."/".$fnd;
		$config["per_page"] = $pagePerNum;
		$config["num_links"] = 10;
		$config["cur_page"] = $page;
		$plink = array("md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page, "ppn"=>$pagePerNum, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3, "seMenu"=>getSeMenu($this->session->userdata('mainMenu')));
		//===================================================
	
		$param = array("mode" => "gongji", "md"=>$md, "md2"=>$md2);
		$this->load->view("common/head", $param);
		
		

		if(!$fnd){
			$fnd = "";
		}

		$pt = "";
		switch($md){
		case 1:
			$pt = "메시지전송";
			//$this->load->model('notice/notice');

			if($md3 == 2){
				$this->load->model('member/member');
				
				$sstion = array("fnd"=>$fnd, "secoid"=>0);
				$meminf = $this->member->susinMemList($sstion);  //가입회원의 리스트를 가져온다.
				
			
				$miobj = array_merge($plink, array("gaip" => $meminf));
				$this->load->view("notice/messageSend", $miobj);
				
			}else if($md3 == 1){
				
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				
				$this->load->model('notice/notice');
				//나에게 전송된 전체 메시지의 리스트를 가져온다.
				$miobj = array("memid" => $this->session->userdata('memid'));
				$allmess = $this->notice->getAllMess($miobj);
				$this->load->view("notice/messageList", array_merge($plink, array("allmess"=>$allmess)));
				
				
			}else{
				$this->load->model('notice/notice');
				$seMess = $this->notice->getSeMess($md3);
				
				//메시지 수신자 리스트를 가져온다.
				$messSusin = $this->notice->getMessSusin($md3);
				
				$this->load->view("notice/messageSangse", array_merge($plink, array("mess"=>$seMess, "susin"=>$messSusin)));
			}
		break;
		case 2: 
			$pt = "메일발송";
		
			if($md2 == 1){
				
				proFind($fnd);  //검색 모드와 검색어를 세션에 저장 한다.
				
				//$totalCount = $this->member->migabipTotalCount($sstion);
				//$meminf = $this->member->migabip($sstion);  //미가입회원의 자료를 가져온다.
				
				
				$this->load->model('notice/notice');
				//나에게 전송된 전체 메시지의 리스트를 가져온다.
				$miobj = array("memid" => $this->session->userdata('memid'));
				
				$allmess = $this->notice->getAllMail($miobj);
				
				//echo $this->session->userdata('memid').count($allmess);
				
				$this->load->view("notice/mailsendList", array_merge($plink, array("allmess"=>$allmess)));
				
				
			}else if($md2 == 2){
				
				$this->load->model('member/member');
				//$sstion = array("memid" => $this->session->userdata('memid'), "po" => $this->session->userdata('potion'), "cogubun" => $this->session->userdata('cogubun'),  "coid" => $this->session->userdata('coid'), "secoid"=>$md3, "myid" => $this->session->userdata('id'), "rid" => (int)$fnd, "fnd" => $fnd);
				//$meminf = $this->member->gaip($sstion);  //가입회원의 리스트를 가져온다.
				
				//$sstion = array_merge($plink);
				$meminf = $this->member->susinMemList($plink);  //가입회원의 리스트를 가져온다.

			
				$miobj = array_merge($plink, array("gaip" => $meminf, "allco" => $allCo));
			
				$this->load->view("notice/mailsend", $miobj);
			}else{
				
				$this->load->model('notice/notice');
				$seMess = $this->notice->getSeMail($md3);
				
				//메일 수신자 리스트를 가져온다.
				$messSusin = $this->notice->getMailSusin($md3);
				
				$this->load->view("notice/mailSangse", array_merge($plink, array("mess"=>$seMess, "susin"=>$messSusin)));
			}
		
		break;
		case 3:
		/*
			$pt = "푸쉬발송";
			$this->load->model('notice/notice');
			//$meminf = $this->member->chadan();  //차단회원의 자료를 가져온다.
			
			if($md2 == 1){
				
				$this->load->model('notice/notice');
				//나에게 전송된 전체 메시지의 리스트를 가져온다.
				$miobj = array("memid" => $this->session->userdata('memid'));
				$allmess = $this->notice->getAllPush($miobj);
				$this->load->view("notice/pushList", array("onmd"=>$md2, "allmess"=>$allmess));
				
				
			}else if($md2 == 2){
				$this->load->model('member/member');
				$sstion = array("memid" => $this->session->userdata('memid'), "po" => $this->session->userdata('potion'), "cogubun" => $this->session->userdata('cogubun'),  "coid" => $this->session->userdata('coid'), "secoid"=>$md3, "myid" => $this->session->userdata('id'), "rid" => (int)$fnd, "fnd" => $fnd);
				$meminf = $this->member->gaip($sstion);  //가입회원의 리스트를 가져온다.
			
				$miobj = array("gaip" => $meminf, "allco" => $allCo, "md3"=>$md3, "onmd"=>$md2);
				
				
				$this->load->view("notice/pushsend", $miobj);
			}else{
				
				$this->load->model('notice/notice');
				$seMess = $this->notice->getSePush($md3);
				$this->load->view("notice/pushSangse", array("onmd"=>$md2, "mess"=>$seMess));
				
			}
		*/
		break;
		case 4:
			//마이페이지로 간다.
			redirect("member/mypage/getView/1/".$this->session->userdata('id')) ;
			
		break;
		}
		

		if(!$md2) $md2 = 0;
		if(!$md3) $md3 = 0;
		if(!$md4) $md4 = 0;
		$this->load->view("common/foot", $plink);
	
	}
	
	
	//알림을 삭제한다.
	public function notiDel($md, $did){
		
		$this->load->model('notice/notice');
	
		$rt = $this->notice->notiRecDel($md, $did);
		if($rt > 0){
			redirect("notice/gongji/getView/".$md);
		}
		
	}
	
	
	
	
	//메일을 발송한다.
	public function senMail(){
		//메시지를 저장하고 푸시를 보낸다.
		//$this->input->post('seMemid', TRUE);
		$this->load->model('member/member');
		//수신자의 아이디를 배열로 리턴 한다.
		$susin = $this->member->susinMemid(array("susin"=>$this->input->post('susin', TRUE), "coid"=>$this->input->post('coid', TRUE), "seGab"=>$this->input->post('sendCo', TRUE)));
		
		//메일 내용을 저장한다.
		$this->load->model('notice/notice');
		$setmess = array("wrmem" => $this->input->post('wr', TRUE), "txt"=>$this->input->post('mailMess', TRUE), "tit"=>$this->input->post('mailTit', TRUE));
		$rt = $this->notice->setMessMail($susin, $setmess);
		
		if($rt > 0){
			//푸시를 발송한다.
			$this->load->library('email');
			$this->email->from('super@hawoojing.com', $this->session->userdata('memid'));
			
			$toe = "";
			for($m = 0; $m < count($susin); $m++){
				if($toe != "") $toe .= ", ";
				$toe .= $susin[$m]['email'];
			}
			$this->email->to($toe);
			
			//$this->email->cc('another@another-example.com'); 
			//$this->email->bcc('them@their-example.com'); 
			
			$this->email->subject("두꺼비하우징 : ".$this->input->post('mailTit', TRUE));
			$this->email->message($this->input->post('mailMess', TRUE));	
			$this->email->send();
						
			
			hddMessageGcm("새 메일 도착", $this->input->post('mailTit', TRUE), "mail", $susin, $rt);
		}

		redirect("notice/gongji/getView/2");

	}

	
	
	
	//푸쉬를 발송한다.
	public function senPush(){
		//메시지를 저장하고 푸시를 보낸다.
		//$this->input->post('seMemid', TRUE);
		$this->load->model('member/member');
		//수신자의 아이디를 배열로 리턴 한다.
		$susin = $this->member->susinMemid(array("susin"=>$this->input->post('susin', TRUE), "coid"=>$this->input->post('coid', TRUE), "seGab"=>$this->input->post('sendCo', TRUE)));
		
		//메시지 내용을 저장한다.
		$this->load->model('notice/notice');
		$setmess = array("wrmem" => $this->input->post('wr', TRUE), "link"=>$this->input->post('pushLink', TRUE), "txt"=>$this->input->post('pushMess', TRUE), "tit"=>$this->input->post('pushTit', TRUE));
		$rt = $this->notice->setMessPush($susin, $setmess);
		
		if($rt > 0){
			//푸시를 발송한다.
			hddMessageGcm("새로운 안내가 있습니다.", $this->input->post('pushTit', TRUE), "push", $susin, $rt);
		}

		redirect("notice/gongji/getView/3");

	}

	

	public function senMess(){
		//메시지를 저장하고 푸시를 보낸다.
		//$this->input->post('seMemid', TRUE);
		$this->load->model('member/member');
		//수신자의 아이디를 배열로 리턴 한다.
		$susin = $this->member->susinMemid(array("susin"=>$this->input->post('susin', TRUE), "coid"=>$this->input->post('coid', TRUE), "seGab"=>$this->input->post('sendCo', TRUE)));
		
		//메시지 내용을 저장한다.
		$this->load->model('notice/notice');
		$setmess = array("wrmem" => $this->input->post('wr', TRUE), "txt"=>$this->input->post('messMess', TRUE), "tit"=>$this->input->post('messTit', TRUE));
		$rt = $this->notice->setMess($susin, $setmess);
		
		if($rt > 0){
			//푸시를 발송한다.
			hddMessageGcm("새로운 메시지가 있습니다.", $this->input->post('messTit', TRUE), "mess", $susin, $rt);
		}

		redirect("notice/gongji/getView/1");

	}



	public function logout(){
			logout();
	}



}





?>