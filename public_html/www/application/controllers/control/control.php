<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//MROO
class Control extends CI_Controller{

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
		
		if($this->session->userdata('memid')){
			
			if(!$this->session->userdata('control')){
				//디폴트 서버메뉴를 설정 한다.
				$gg = set_defaultSub();		
			}else $gg = 1; //$this->session->userdata('control');
			
			
			$this->getView($gg);
		
		}else{
			//echo "login no";
			redirect("/home") ;
		}
	
	}
	
		//서버메뉴에 따라 뷰어를 불러 온다.
	public function getView($md, $md2 = 2, $md3 = 0, $md4 = 0, $fnd="0", $page=0){
		
	
		
		$this->load->library('pagination');		

		$this->session->set_userdata('control', $md);	

		//=======================================
			$pagePerNum = PAGELINE;
			$config['base_url'] = '/control/control/getView/'.$md.'/'.$md2."/".$md3."/".$md4."/".$fnd;
			$config["per_page"] = $pagePerNum;
			$config["num_links"] = 10;
			$config["cur_page"] = $page;

		
		$plink = array("md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4, "fnd"=>$fnd, "page"=>$page, "ppn"=>$pagePerNum, "onmd"=>$md2, "coid"=>$md3, "secoid"=>$md3, "seMenu"=>getSeMenu($this->session->userdata('mainMenu')));
		$this->session->set_userdata("findMd", "0");
		$this->session->set_userdata("find", "");
		//========================================


		$param = array("mode" => "control", "md"=>$md, "md2"=>$md2, "md3"=>$md3, "md4"=>$md4);
		$this->load->view("common/head", $param);
		
		$pt = "";
		switch($md){
		case 1:  //배너관리
			
			switch($md3){
			case 1:   //배너리스트

				$pt = "배너 리스트";
				$this->load->model('control/controldb');
				
				$rr = $this->controldb->getBannerAll();
				$totalCount = count($rr);
				$config["total_rows"] = count($totalCount);
				$this->pagination->initialize($config);
	
				$arr = array_merge($plink, array("banner"=>$rr, "totalCount"=>$totalCount));
				
				$this->load->view("control/bannerList", $arr);
			
			break;
			case 2:   //배너추가 
			
				$this->load->model('control/controldb');
				//배너의 내용을 가져온다.
				$bd = $this->controldb->getBanner($md4);
			
				$this->load->view("control/bannerOn", array_merge($plink, array("type"=>"insert", "id"=>0, "bd"=>$bd)));
			break;
			case 3:  //상세보기
			
			break;
			case 4:  //수정

				$this->load->model('control/controldb');
				//배너의 내용을 가져온다.
				$bd = $this->controldb->getBanner($md4);

				$this->load->view("control/bannerOn", array_merge($plink, array("type"=>"modify", "id"=>$md4, "bd"=>$bd)));
				//$this->load->view("control/bannerModify", array_merge($plink, array("id"=>$md4, "bd"=>$bd)));

			break;
			}
		

		break;
		case 2:  //관리자 계정관리

			switch($md3){
			case 1:   //관리자 리스트
				$pt = "계정관리";
				$this->load->model('control/controldb');
				
				$query = $this->controldb->adminListAll();
				
				$this->load->view('control/adminlist', array_merge($plink, array("allmem"=>$query, $param)));
			break;
			case 2:   //관리자 추가
				
				$pt = "계정관리자 추가";
				$this->load->model('control/controldb');
				
				$query = $this->controldb->comemListAll(3);
				
				$this->load->view('control/bonsalist', array_merge($plink, array("allmem"=>$query, $param)));			
			
			break;
			}

		break;
		}		
		
		/*
		switch($md){
		case 1:
			$pt = "게시판 생성";
			$this->load->model('control/controldb');
			//$meminf = $this->member->migabip();  //미가입회원의 자료를 가져온다.			
			
			//$miobj = array("migaip" => $meminf);
			$this->load->view("control/borderOn", $plink);

		break;
		case 2:  //게시판 리스트
			$pt = "게시판 리스트";
			$this->load->model('control/controldb');
			$totalCount = $this->controldb->getBdListCount();
			
			$config["total_rows"] = count($totalCount);
			$this->pagination->initialize($config);
			
			
			$rr = $this->controldb->getBdList($page, $pagePerNum);


			$arr = array_merge($plink, array("bd"=>$rr , "totalCount"=>$totalCount));
			
			$this->load->view("control/bdList", $arr);
		break;
		case 3:  //게시판 상세보기 
			$pt = "게시판 수정";
			$this->load->model('control/controldb');
			$rr = $this->controldb->getBdEdit($md2);
			$arr = array("bd"=>$rr);
			$this->load->view("control/bdEdit", $arr);
		break;
		}
		*/

		$this->load->view("common/foot", $plink);
	
	}
	




	//============================================
	//배너를 등록한다.
	//============================================
	public function bannerOn(){

		$config['upload_path'] = './images/banner';
		// git,jpg,png 파일만 업로드를 허용한다.
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = true;
		
		$fnam = "";
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload("file1"))
		{
			$fnam = "0";  //업로드 실패한 경우 
		}	
		else
		{
			//업로드 성공한 경우
			$frs = $this->upload->data();
			$fnam = $frs['file_name'];
		}


		$ad_date = date("Y-m-d H:i:s");
		$this->load->model('control/controldb');


		if($this->input->post("type",true) == "insert"){
			
			$id = 0;
			$arr = array("gubun"=>$this->input->post("gubun",true), "indx"=>$this->input->post('indx', TRUE), "img"=>$fnam, "stday"=>$this->input->post('stday', TRUE), "endday"=>$this->input->post('endday', true), "oninf"=>$this->input->post('oninf', true));
			
			$rr = $this->controldb->bannerOnput($this->input->post("type",true), $arr, $id);  //banner 등록
			
			if($rr > 0){
				//등록성공
				redirect("/control/control/getView/".$this->input->post("md",true)."/".$this->input->post('md2', TRUE)."/1");
			}else{
				redirect("/control/control/getView/".$this->input->post("md",true)."/".$this->input->post('md2', TRUE)."/1");
			}
			
			
		}else{
			//수정모드 
			
			$id = $this->input->post("id",true);
			if($fnam == "0"){
				$arr = array("gubun"=>$this->input->post("gubun",true), "indx"=>$this->input->post('indx', TRUE), "stday"=>$this->input->post('stday', TRUE), "endday"=>$this->input->post('endday', true), "oninf"=>$this->input->post('oninf', true));
			}else{
				//이미지 변경하는 경우 기존 배너 이미지를 지운다.
				$this->load->model('control/controldb');
				$bn = $this->controldb->getBanner($id);
				$this->load->model('common/commondb');
				$dbn = $this->commondb->fileDelOnly("banner", $bn->img);  //이미지를 지운다.

				
				$arr = array("gubun"=>$this->input->post("gubun",true), "indx"=>$this->input->post('indx', TRUE), "img"=>$fnam, "stday"=>$this->input->post('stday', TRUE), "endday"=>$this->input->post('endday', true), "oninf"=>$this->input->post('oninf', true));
			}
			
			$rr = $this->controldb->bannerOnput($this->input->post("type",true), $arr, $id);  //banner 등록
			
			if($rr > 0){
				//등록성공
				redirect("/control/control/getView/".$this->input->post("md",true)."/".$this->input->post('md2', TRUE)."/1");
			}else{
				redirect("/control/control/getView/".$this->input->post("md",true)."/".$this->input->post('md2', TRUE)."/1");
			}
		}
		
		

	}
	//=====================================
	//관리자를 추가한다.
	//=====================================
	public function adminOn(){
	
		$id = $this->input->post("id",true);
		
		$arr = array("memid"=>$this->input->post("memid",true), "name"=>$this->input->post("name",true), "tel"=>$this->input->post('tel', TRUE), "buseo"=>$this->input->post('buseo', true), "jigcheg"=>$this->input->post('jigcheg', true));
		
		$this->load->model('member/member');
		$bn = $this->member->setAdminAct($arr, $this->input->post("memid",true), $this->input->post('actgubun', true), $id);

		redirect("/control/control/getView/2/1/2");
	
	}
	//======================================







	
	public function mkbdDel($md, $did){
	
		$this->load->model('control/controldb');
		$rr = $this->controldb->delBorderRec($did);
		if($rr == "not"){
			 $this->session->set_flashdata('transErr', '데이터가 있는 게시판은 삭제 불가능 합니다.');
		}else{
			$this->session->set_flashdata('transErr', '게시판 삭제하였습니다.');
		}
		
		redirect("/control/control/getView/2") ;
	}
	
	
	
	//게시판 내용수정
	public function edtBorder(){
		

	
		if($this->session->userdata("cogubun") < BONSA){
			 $this->session->set_flashdata('transErr', '게시판 생성권한이 없습니다.');
			 redirect("/control/control/getView/3") ;
		}else if(!$this->input->post('bdtit', true)){
			$this->session->set_flashdata('transErr', '제목을 입력하세요.');
			redirect("/control/control/getView/3") ;
		}else{
			$this->load->model('control/controldb');
			
$arr = array("bdtit"=>$this->input->post('bdtit', true), "gubun"=>(int)$this->input->post('gubun', true), "cogubunWR"=>(int)$this->input->post('cogubunWR', true));
			
			//$arr = array("bdtit"=>$this->input->post('bdtit', true), "gubun"=>(int)$this->input->post('gubun', true), "wrpo"=>(int)$this->input->post('wrpo', true), "rdpo"=>(int)$this->input->post('rdpo', true), "cogubunW"=>(int)$this->input->post('cogubunW', true), "cogubunR"=>(int)$this->input->post('cogubunR', true), "pushinf"=>(int)$this->input->post('pushinf', true));
			$rr = $this->controldb->bdEdit($arr, $this->input->post('rid', true));
			
			if($rr > 0){
				$this->session->set_flashdata('transErr', '게시판 수정 하였습니다.');
				redirect("/control/control/getView/2") ;
			}else{
				$this->session->set_flashdata('transErr', '게시판 수정 실패하였습니다.');
				redirect("/control/control/getView/3") ;
			}
			
		
		}

	
	}
	
	
	
	
	
	public function onBorder(){
		

		//게시판 생성한다.
		if($this->session->userdata("cogubun") < BONSA){
			 $this->session->set_flashdata('transErr', '게시판 생성권한이 없습니다.');
			 redirect("/control/control/getView/1") ;
		}else if(!$this->input->post('bdtit', true)){
			$this->session->set_flashdata('transErr', '제목을 입력하세요.');
			redirect("/control/control/getView/1") ;
		}else{
			$this->load->model('control/controldb');
			
			$arr = array("bdtit"=>$this->input->post('bdtit', true), "gubun"=>(int)$this->input->post('gubun', true), "cogubunWR"=>(int)$this->input->post('cogubunWR', true));
			//$arr = array("bdtit"=>$this->input->post('bdtit', true), "gubun"=>(int)$this->input->post('gubun', true), "wrpo"=>(int)$this->input->post('wrpo', true), "rdpo"=>(int)$this->input->post('rdpo', true), "cogubunW"=>(int)$this->input->post('cogubunW', true), "cogubunR"=>(int)$this->input->post('cogubunR', true), "pushinf"=>(int)$this->input->post('pushinf', true));
			
			$rr = $this->controldb->bdOnput($arr);
			
			if($rr > 0){
				$this->session->set_flashdata('transErr', '게시판 생성 하였습니다.');
				redirect("/control/control/getView/2") ;
			}else{
				$this->session->set_flashdata('transErr', '게시판 생성 실패하였습니다.');
				redirect("/control/control/getView/1") ;
			}
			
		
		}

	
	}
	
	
	
	
	
	
	

	public function logout(){
			logout();
	}



}





?>